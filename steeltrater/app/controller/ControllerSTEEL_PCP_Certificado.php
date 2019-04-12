<?php

/* 
 * Implementa a classe controler STEEL_PCP_Certificado
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */


class ControllerSTEEL_PCP_Certificado extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Certificado');
    }
    
    /**
    * Envia o e-mail
    */
   public function geraPdfCert($sDados) {
       $aDados = explode(',', $sDados);
       
       $aNr = $_REQUEST['parametrosCampos'];
       sort($aNr);
       $sVethor='';
       foreach ($aNr as $key => $value) {
           $aNrEnv = explode('=', $value);
           $sVethor.= 'nrcert[]='.$aNrEnv[1].'&';
           $aCert[$key]=$aNrEnv[1];
       }
       
        $_REQUEST['nrcert'] = $aCert;
        $_REQUEST['email'] ='S';
        $_REQUEST['userRel'] = $_SESSION['nome'];
        
         
        //busca se há notas diferentes
        $aNotaCert=array();
        foreach ($aCert as $iCert) {
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert',$iCert);
            $oCertificadoNota = $this->Persistencia->consultarWhere();
            $aNotaSteel[]=$oCertificadoNota->getNotasteel();
        }
        $aNotaSteelUni = array_unique($aNotaSteel);
        $_REQUEST['notaRetorno']=$aNotaSteelUni[0];
        if(count($aNotaSteelUni)>1){
            $oModal= new Modal('Atenção!', 'Existem notas diferentes selecionadas, selecione itens da mesma nota de retorno!', Modal::TIPO_AVISO, false);
           echo $oModal->getRender();
           exit();
        }
        
       
        $aEmp= array();
        foreach ($aCert as $iCert) {
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert',$iCert);
            $oCertificado = $this->Persistencia->consultarWhere();
            $aEmp[]=$oCertificado->getEmpcod();
        }
        $aEmpRep = array_unique($aEmp);
       
        
       if(count($aEmpRep)==1){
       $_REQUEST['empresaCert'] = $aEmpRep[0];
       $aEmail = require 'app/relatorio/CertificadoOpSteel.php';
       if($aEmail[0]){
           $this->Persistencia->mudaSit($aCert);
           echo"$('#".$aDados[1]."-pesq').click();"; 
       }
       //grava histórico
       foreach ($aCert as $i => $cert) {
           $sDest='';
          $oHist = Fabrica::FabricarController('STEEL_PCP_histEmailcert');
          $oHist->Model->setNrcert($cert); 
          $oHist->Model->setUserEmail($_SESSION['nome']);
          $oHist->Model->setData(date('d/m/Y'));
          $oHist->Model->setHora(date('H:i'));
          if($aEmail[0]){
             $oHist->Model->setSitenv('Sucesso'); 
          }else{
             $oHist->Model->setSitenv($aEmail[1]);  
          }
          foreach ($aEmail[2] as $iDest => $sDestinatario) {
              $sDest .= $sDestinatario.';';
             }
          $oHist->Model->setDestinatario($sDest); 
          $oHist->Persistencia->setModel($oHist->Model);
          $oHist->Persistencia->inserir();
       }
       }else{
           $oModal= new Modal('Atenção!', 'Existem empresas diferentes nos certificados escolhidos, seleciona apenas certificados da mesma empresa!', Modal::TIPO_AVISO, false);
           echo $oModal->getRender();
       }
       
     }
    
    public function acaoMostraRelCertificado($sDados) {
       
       parent::acaoMostraRelEspecifico($sDados);
       
       $aNr = $_REQUEST['parametrosCampos'];
       sort($aNr);
       $sVethor='';
       foreach ($aNr as $key => $value) {
           $aNrEnv = explode('=', $value);
           $sVethor.= 'nrcert[]='.$aNrEnv[1].'&';
       }
       
       //busca se há notas diferentes
        $aNotaCert=array();
        foreach ($aNr as $iCert) {
            $aCertEnv = explode('=', $iCert);
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert',$aCertEnv[1]);
            $oCertificadoNota = $this->Persistencia->consultarWhere();
            $aNotaSteel[]=$oCertificadoNota->getNotasteel();
        }
        $aNotaSteelUni = array_unique($aNotaSteel);
        $_REQUEST['notaRetorno']=$aNotaSteelUni[0];
        if(count($aNotaSteelUni)>1){
            $oModal= new Modal('Atenção!', 'Existem notas diferentes selecionadas, selecione itens da mesma nota de retorno!', Modal::TIPO_AVISO, false);
           echo $oModal->getRender();
           exit();
        }
       
      // exemplo.php?vetor[]=valor1&vetor[]=valor2&vetor[]=valor3
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'CertificadoOpSteel.php?'.$sVethor;
        
        $sCampos.= $this->getSget();
        $sCampos.='&notaRetorno='.$aNotaSteelUni[0];
        
       $sCampos.='&output=tela';
       $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
       echo $oWindow; 

    }
    
    public function consultaOpDados($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //verifica se tem uma op válida

        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oDados = $oOpSteel->consultaOp($aCampos['op']);

        
            if ($oDados->getOp() == null) {
                $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não foi localizada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                echo '$("#' . $aId[0] . '").val("");'
                  . '$("#' . $aId[1] . '").val("");'
                 . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");'
                . '$("#' . $aId[4] . '").val("");'
                . '$("#' . $aId[5] . '").val("");'
                . '$("#' . $aId[6] . '").val("");'
                . '$("#' . $aId[7] . '").val("");';
            } else {
                
                $oDados->setProdes(str_replace("\n", " ",$oDados->getProdes()));
                $oDados->setProdes(str_replace("'","\'",$oDados->getProdes()));   
                $oDados->setProdes(str_replace("\r", "",$oDados->getProdes()));
                $oDados->setProdes(str_replace('"', '\"',$oDados->getProdes()));
                
                
                //coloca os dados na view  getProd()
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");'
                . '$("#' . $aId[4] . '").val("");'
                . '$("#' . $aId[5] . '").val("");'
                . '$("#' . $aId[6] . '").val("");'
                . '$("#' . $aId[7] . '").val("");'
                . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_codigo() . '");'
                . '$("#' . $aId[1] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                . '$("#' . $aId[2] . '").val("' . $oDados->getProd() . '");'
                . '$("#' . $aId[3] . '").val("' . $oDados->getProdes() . '");'
                . '$("#' . $aId[4] . '").val("' . $oDados->getOpcliente() . '");'
                . '$("#' . $aId[5] . '").val("' . number_format($oDados->getPeso(), 2, ',', '.') . '");'
                . '$("#' . $aId[6] . '").val("' . $oDados->getDocumento() . '");'
                . '$("#' . $aId[7] . '").val("' . number_format($oDados->getQuant(), 2, ',', '.') . '");';
            }                       
    } 
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        $aRender = explode(',',$sParametros);
        
        $sChave =htmlspecialchars_decode($aRender[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        if(count($aCamposChave)>0){
            
            $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
            $oOp->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
            $oDadosOp = $oOp->Persistencia->consultarWhere();
            
            $this->View->setAParametrosExtras($oDadosOp);
            
            if($oDadosOp->getNrcert()){
            $oModal = new Modal('Atenção!','Esta ordem de produção já tem um certificado atrelado!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            echo ' $("#'.$aRender[1].'consulta").show(); '; 
            exit();
            }
           
        
        }
        
       echo ' $("#'.$aRender[1].'consulta").hide(); '; 
    }
    
   
    
    public function afterInsert() {
        parent::afterInsert();
        
        //instancia classe 
        $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
        $oOp->Persistencia->putCertOp($this->Model);
        
        
        
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        
    }
    
    public function afterDelete() {
        parent::afterDelete();
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
        $oOp->Persistencia->limpaCert($this->Model);
        
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iCon = $oOp->Persistencia->getCount();
        if($iCon ==0){
            $oModal = new Modal('Atenção','Essa op não existe, forneça uma ordem de produção existente!', Modal::TIPO_ERRO,false);
            echo $oModal->getRender();
        }
        
        $aInfo = $this->validaValoresCert($oOp);
        
        
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iCon = $oOp->Persistencia->getCount();
        if($iCon ==0){
            $oModal = new Modal('Atenção','Essa op não existe, forneça uma ordem de produção existente!', Modal::TIPO_ERRO,false);
            echo $oModal->getRender();
        }
       
        $aInfo = $this->validaValoresCert($oOp);
        
       // $this->Model->setObs($aInfo);
                
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        
    }
    
    public function validaValoresCert($oOp){
        
        $aInfo = array();
        if (($oOp->Model->getDurezaNucMin())>($this->Model->getDurezaNucMin())){
            $aInfo[0] = "Dureza mínima do núcleo encontrada está abaixo da Dureza mínima solicitada!";
        }
        if (($oOp->Model->getDurezaNucMax())<($this->Model->getDurezaNucMin())){
            $aInfo[1] = "Dureza mínima do núcleo encontrada está acima da Dureza máxima solicitada!";
        }
        if (($oOp->Model->getDurezaNucMax())<($this->Model->getDurezaNucMax())){
            $aInfo[2] = "Dureza máxima do núcleo encontrada está acima da Dureza máxima solicitada!";
        }
        if (($oOp->Model->getDurezaNucMin())>($this->Model->getDurezaNucMax())){
            $aInfo[3] = "Dureza máxima do núcleo encontrada está abaixo da Dureza mínima solicitada!";
        }
        if (($oOp->Model->getDurezaSuperfMin())>($this->Model->getDurezaSuperfMin())){
            $aInfo[4] = "Dureza minima da superfície encontrada está abaixo da Dureza mínima solicitada!";
        }
        if (($oOp->Model->getDurezaSuperfMax())<($this->Model->getDurezaSuperfMin())){
            $aInfo[5] = "Dureza minima da superfície encontrada está acima da Dureza máxima solicitada!";
        }
        if (($oOp->Model->getDurezaSuperfMax())<($this->Model->getDurezaSuperfMax())){
            $aInfo[3] = "Dureza máxima da superfície encontrada está acima da Dureza máxima solicitada!";
        }
        if (($oOp->Model->getDurezaSuperfMin())>($this->Model->getDurezaSuperfMax())){
            $aInfo[3] = "Dureza máxima da superfície encontrada está abaixo da Dureza mínima solicitada!";
        }
        if (($oOp->Model->getExpCamadaMin())>($this->Model->getExpCamadaMin())){
            $aInfo[4] = "Camada minima encontrada está abaixo da Camada mínima solicitada!";
        }
        if (($oOp->Model->getExpCamadaMax())<($this->Model->getExpCamadaMin())){
            $aInfo[4] = "Camada minima encontrada está acima da Camada máxima solicitada!";
        }
        if (($oOp->Model->getExpCamadaMax())<($this->Model->getExpCamadaMax())){
            $aInfo[5] = "Camada máxima encontrada está acima da Camada máxima solicitada!";
        }
         if (($oOp->Model->getExpCamadaMin())>($this->Model->getExpCamadaMax())){
            $aInfo[5] = "Camada máxima encontrada está abixo da Camada mínima solicitada!";
        }
        return $aInfo;
    }
    
    /**
    * Modal apontamentos certificado
    */
     public function criaTelaModalAponta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aFilcgc= explode('=', $aChave[0]);
        $aPedido = explode('=', $aChave[1]);
        $aSeq = explode('=', $aChave[2]);
        
        //busca a op
        $oCargaInsumoServ = Fabrica::FabricarController('STEEL_PCP_CargaInsumoServ');
        $oCargaInsumoServ->Persistencia->adicionaFiltro('pdv_pedidofilial',$aFilcgc[1]);
        $oCargaInsumoServ->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aPedido[1]);
        $oCargaInsumoServ->Persistencia->adicionaFiltro('pdv_pedidoitemseq',$aSeq[1]);
        $oDadosCarga = $oCargaInsumoServ->Persistencia->consultarWhere();
        
        
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op',$oDadosCarga->getOp());
        
        $oDados = $oOp->Persistencia->consultarWhere();


        $this->View->setAParametrosExtras($oDados);

        $this->View->criaTelaModal($aDados[3]);
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }
    
    public function geraCertCarga($sDados){
       $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos); 
        //verifica se já existe o certificado para alterá-lo
         $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op',$aCampos['op']);
        $oOpDados = $oOp->Persistencia->consultarWhere();
        //verifica se há o certificado
        $oCert = Fabrica::FabricarController('STEEL_PCP_Certificado');
        $oCert->Persistencia->adicionaFiltro('nrcert',$oOpDados->getNrcert());
        $iCert = $oCert->Persistencia->getCount();
        //se não há certificad na tabela gera o insert de um novo certificado
        if($iCert>0){
            $this->alteraCertModal($sDados);
        }else{
            $this->insereCertificadoModal($sDados);
        }
        
        
        
    }

    

    public function insereCertificadoModal($sDados){
         $aDados = explode(',',$sDados);
       $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos); 
        
        //inicia gravação
        $this->Persistencia->iniciaTransacao();
        $aRetorno[0] = true;
        //carrega o model
        $this->View->criaTela();
        $aCamposTela = $this->View->getTela()->getCampos();
        $this->carregaModel($aCamposTela);
        //carrega os dados que nao temos
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op',$aCampos['op']);
        $oOpDados = $oOp->Persistencia->consultarWhere();
        
        $this->Model->setPeso($oOpDados->getPeso());
        $this->Model->setQuant($oOpDados->getQuant());
        $this->Model->setNotacliente($oOpDados->getDocumento());
        $this->Model->setOpcliente($oOpDados->getOpcliente());
        $this->Model->setEmpcod($oOpDados->getEmp_codigo());
        $this->Model->setEmpdes($oOpDados->getEmp_razaosocial());
        
        if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->inserir();
        }

        if ($aRetorno[0]) {
            $aRetorno = $this->afterInsert();
            $this->Persistencia->commit();
        }
        
        if ($aRetorno[0]) {
            //atualiza nr do certificado na ordem e produção
            $oGeraCert = Fabrica::FabricarPersistencia('STEEL_PCP_GeraCertificado');
            
            $oGeraCert->putCertOp($this->Model);
            $oMsg = new Mensagem('Sucesso!', 'Registro inserido com sucesso...', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo'$("#modalApontaItem-btn").click();';
            echo '$("#'.$aDados[2].'").focus();';
        }else {
            $this->Persistencia->rollback();
            $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
        
        
        
        
    }
    
    public function alteraCertModal($sDados){
        $aDados = explode(',',$sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos); 
        $this->View->criaTela();
        
        $aRetorno[0] = true;
        //traz lista campos
        $aCamposTela = $this->View->getTela()->getCampos();

        if ($this->View->getBGravaHistorico() == true) {
            $this->gravaHistorico('Alterar');
        }

        $this->Persistencia->iniciaTransacao();

        $aChaveMestre = $this->Persistencia->getChaveArray();
        foreach ($aChaveMestre as $oCampoBanco) {
            if ($oCampoBanco->getPersiste()) {
                $this->setValorModel($this->Model, $oCampoBanco->getNomeModel());
            }
        }
        $this->Model = $this->Persistencia->consultar();
       
        $this->carregaModel($aCamposTela);
       
        //carrega os dados que nao temos
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op',$aCampos['op']);
        $oOpDados = $oOp->Persistencia->consultarWhere();
        
        $this->Model->setPeso($oOpDados->getPeso());
        $this->Model->setQuant($oOpDados->getQuant());
        $this->Model->setNotacliente($oOpDados->getDocumento());
        $this->Model->setOpcliente($oOpDados->getOpcliente());
        $this->Model->setEmpcod($oOpDados->getEmp_codigo());
        $this->Model->setEmpdes($oOpDados->getEmp_razaosocial());
        
         if ($aRetorno[0]) {
            $aRetorno = $this->beforeUpdate();
        }

        if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->alterar();
        }
        
        if($aRetorno[0]){
            $this->Persistencia->commit();
             //MENSAGEM SUCESSO
            $oMsg = new Mensagem('Sucesso!', 'Seu registro foi alterado com sucesso...', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo'$("#modalApontaItem-btn").click();';
            echo '$("#'.$aDados[2].'").focus();';
        }else{
            $this->Persistencia->rollback();
            $oMsg = new Mensagem('Erro!', 'Seu registro não foi alterado.', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
        
        
    }
    /**
     * Função para atualiza número de notas fiscais com seus certificados
     * @param type $sParametros
     */
    
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        $oCertificado = Fabrica::FabricarController('STEEL_PCP_Certificado');
        $oCertificado->Persistencia->atualizaNotaCertificado();
        
        
    }
}