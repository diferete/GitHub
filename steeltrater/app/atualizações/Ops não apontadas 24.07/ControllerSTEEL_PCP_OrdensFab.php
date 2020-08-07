<?php

/* 
 *Controller da classe fabricação steel
 * 
 * @author Avanei Martendal
 * 
 * @since 25/06/2018
 */

class ControllerSTEEL_PCP_OrdensFab extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_OrdensFab');
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $this->verificaCampos();
        $this->verificaOp();
     
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;

    }

    public function afterUpdate() {
        parent::afterUpdate();
         
        //atualiza itens da orden de fabricação
        $oFabintens = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
        $oFabintens->itensOrdem($this->Model);
        
       
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    

    public function beforeInsert() {
        parent::beforeInsert();

        $this->verificaCampos();
        $this->verificaOp();
        
       

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    public function afterInsert() {
        parent::afterInsert();
        //verifica o outro incremento inserido
        $iAutoInc = $this->Persistencia->getMaxRegistro('op');
        $this->Model->setOp($iAutoInc);
        
        
        
        $oFabintens = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
        $oFabintens->itensOrdem($this->Model);
        
        //marca na importa op o nr da op para controle
        if($this->Model->getOrigem()=='Romaneio'){
        $oImporta = Fabrica::FabricarController('STEEL_PCP_NotaImportaNf');
        $aCampos['nfsnfnro'] = $this->Model->getDocumento();
        $aCampos['nfsitseq'] = $this->Model->getSeqprodnf();
        $aCampos['op'] = $this->Model->getOp();
        $oImporta->atualizaOPnf($aCampos);
        }
        
        //marca na importa op no xml
        
        if($this->Model->getOrigem()=='XML'){
            $oImporta = Fabrica::FabricarController('STEEL_PCP_ImportaXml');
            $aCampos['seq'] = $this->Model->getSeqprodnf();
            $aCampos['op'] = $this->Model->getOp();
            $oImporta->Persistencia->atualizaImpXml($aCampos);
        }
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
        
    }

        public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);
        
       
       
    }
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        $aRender = explode(',',$sParametros);
        
        $sChave =htmlspecialchars_decode($aRender[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        //verifica se vem de xml ou importa metalbo
        
        if($aRender[3]!=='xml'){
            if(count($aCamposChave)>0){
            $oNotasImp = Fabrica::FabricarController('STEEL_PCP_NotaImportaNf');
            $oModelImp = $oNotasImp->buscaNota($aCamposChave);
            //busca o peso do produto
           // $oPeso = Fabrica::FabricarController('DELX_PRO_Produtos');
           // $Peso = $oPeso->retornaPeso($oModelImp->getNfsitcod());
           // $PesoTotal = ($Peso*$oModelImp->getNfsitqtd());
            $oModelImp->setPeso($oModelImp->getMetpesocarg());
            //busca o preço da nota
            $aCamposChave['nfsitcod'] = $oModelImp->getNfsitcod();
            $aPreco = $this->Persistencia->buscaPreço($aCamposChave);
            $oModelImp->setVlrNfEntUnit($aPreco[0]);
            $oModelImp->setVlrNfEnt($aPreco[1]);

            $this->View->setAParametrosExtras($oModelImp);

            //valida se há op
            if($oModelImp->getOpSteel()){
                $oModal = new Modal('Atenção!','Esse ítem já tem ordem de produção.', Modal::TIPO_AVISO);
                echo $oModal->getRender();
                exit();
            }
            echo ' $("#'.$aRender[1].'consulta").hide(); ';

            }
        }else{
            //notas importada por xml
            $oNotaXml = Fabrica::FabricarController('STEEL_PCP_ImportaXml');
            $oNotaXml->Persistencia->adicionaFiltro('seq',$aCamposChave['seq']);
            
            $oDadosXml = $oNotaXml->Persistencia->consultarWhere();
            
            if($oDadosXml->getEmpcod()!=='75483040000211'){
                //busca a referencia do produto
                $oProdutos = Fabrica::FabricarController('DELX_PRO_Produtos');
                $oProdutos->Persistencia->adicionaFiltro('pro_referencia',$oDadosXml->getProcod());
                $oProdutos->Persistencia->adicionaFiltro('pro_codigoantigo',$oDadosXml->getEmpcod());
                
                $iCont = $oProdutos->Persistencia->getCount();
                
                if($iCont==0){
                    $sSeq = $oDadosXml->getSeq();
                    $oModal = new Modal('Atenção','Este código não possui cadastro ou referência no sistema! '
                            . 'Prossiga a tela de cadastro de produto para gerar seu cadastro!', Modal::TIPO_AVISO, true, true, true);
                    $oModal->setSBtnConfirmarFunction('verificaTab("menu-1-prod","1-prod","STEEL_PCP_Produtos","acaoMostraTela","tabmenu-1-prod,'.$sSeq.'","Produtos","parametro");');
                    echo $oModal->getRender();
                    exit();
                }else{
                    $oProdDados = $oProdutos->Persistencia->consultarWhere();
                    $oDadosXml->setCodInterno($oProdDados->getPro_codigo());
                }
            }
            $this->View->setAParametrosExtras($oDadosXml);
            
            if($oDadosXml->getOpSteel()){
                $oModal = new Modal('Atenção!','Esse ítem já tem ordem de produção.', Modal::TIPO_AVISO);
                echo $oModal->getRender();
                exit();
            }
            echo ' $("#'.$aRender[1].'consulta").hide(); ';
            
        }

    }

  
   /**
    * Imprime as ordens de produção
    */
   public function acaoMostraRelEspecifico($sDados) {
       
       parent::acaoMostraRelEspecifico($sDados);
       
       $aOps = $_REQUEST['parametrosCampos'];
       sort($aOps);
       $sVethor='';
       foreach ($aOps as $key => $value) {
           $aOpsEnv = explode('=', $value);
           $sVethor.= 'ops[]='.$aOpsEnv[1].'&';
           $aOp[$key]=$aOpsEnv[1];
       }
       //verifica se tem mais de um tipo de op selecionado
        $aTipo= array();
        foreach ($aOp as $iOp) {
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('op',$iOp);
            $oOps = $this->Persistencia->consultarWhere();
            $aTipo[]=$oOps->getTipoOrdem();
        }
        $aTipOps = array_unique($aTipo);
        if(count($aTipOps)==1){
       
       if($aTipOps[0]=='P'){
            // exemplo.php?vetor[]=valor1&vetor[]=valor2&vetor[]=valor3

              $sSistema ="app/relatorio";
              $sRelatorio = 'OpSteel1.php?'.$sVethor;

              $sCampos.= $this->getSget();

              $sCampos.= '&email=N'; 


              $sCampos.='&output=tela';
              $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
              echo $oWindow; 
       }else{
            $sSistema ="app/relatorio";
            $sRelatorio = 'RelOpSteel3.php?'.$sVethor;
        
            $sCampos.= $this->getSget();
        
            $sCampos.= '&email=N'; 
       
        
            $sCampos.='&output=tela';
            $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
            echo $oWindow; 
       }
        }else{
            $oModal= new Modal('Atenção!', 'Escolha apenas um tipo de OP para impressões múltiplas!', Modal::TIPO_AVISO, false);
           echo $oModal->getRender();
        }
         
       
        }
        
        /**
    * Imprime as ordens de produção
    */
   public function acaoMostraRelTESTE($sDados) {
       
       parent::acaoMostraRelEspecifico($sDados);
       
       $aOps = $_REQUEST['parametrosCampos'];
       sort($aOps);
       $sVethor='';
       foreach ($aOps as $key => $value) {
           $aOpsEnv = explode('=', $value);
           $sVethor.= 'ops[]='.$aOpsEnv[1].'&';
       }
       
      // exemplo.php?vetor[]=valor1&vetor[]=valor2&vetor[]=valor3
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'RelOpSteel3.php?'.$sVethor;
        
        $sCampos.= $this->getSget();
        
        $sCampos.= '&email=N'; 
       
        
        $sCampos.='&output=tela';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow; 
         
         
       
        }
        
    /**
    * Envia o e-mail
    */
   public function geraPdfOp($sDados) {
       
       $aOps = $_REQUEST['parametrosCampos'];
       sort($aOps);
       $sVethor='';
       foreach ($aOps as $key => $value) {
           $aOpsEnv = explode('=', $value);
           $sVethor.= 'ops[]='.$aOpsEnv[1].'&';
           $aOp[$key]=$aOpsEnv[1];
       }
        $_REQUEST['ops'] = $aOp;
        $_REQUEST['email'] ='S';
       //require 'biblioteca/fpdf/fpdf.php';
        
       require 'app/relatorio/OpSteel1.php';
       
       
       
     }
     
     

     public function mostraTelaRelOpEmitida($renderTo, $sMetodo = '') {        
        parent::mostraTelaRelatorio($renderTo, 'RelOpSteel2');              
        
    } 
    
    public function mostraTelaRelOpFat($renderTo, $sMetodo = '') {        
        parent::mostraTelaRelatorio($renderTo, 'RelOpFat');              
        
    } 
    
    /**
     *  Gera xls do relatorio de ordem de produção
   */
  
    public function relatorioExcelOp(){ //indicadorExpedicaoXls
        //Explode string parametros
        $sDados = $_REQUEST['campos'];
        
        $sCampos = htmlspecialchars_decode($sDados);
                
        $sCampos.= $this->getSget();
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'RelOpSteel2Excel.php?';
        
        $sCampos.='&output=email';
        $oMensagem = new Mensagem("Aguarde","Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
        
        $oWindow =// 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");'; 
                'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'","MsgWindow","width=500,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;
         
        
        
        $oMenSuccess = new Mensagem("Sucesso","Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
       
    } 
   
    /*
     * Mensagem se deseja cancelar Ordem de Produção
     */   
    public function msgCancelaOp($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();
        
        if($oOpAtual->getSituacao()!=='Aberta'){
            $oMensagem = new Modal('Situação OP inválida!', 'A OP nº' . $aCamposChave['op'] . ' não pode ser cancelada!', Modal::TIPO_AVISO, true, true, true);
            echo $oMensagem->getRender();
        }else{
        
            $oMensagem = new Modal('Cancelar OP', 'Deseja cancelar Ordem de Produção nº' . $aCamposChave['op'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","cancelaOP","' . $sDados . '");');
       
            echo $oMensagem->getRender();
        }
    }
    
    /*
     * Cancelar ordem de producao
     */
    public function cancelaOP($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //chama o método na pers
        $aRetorno = $this->Persistencia->CancelarOp($aCamposChave);
        if($aRetorno[0]){
        $oMensagem = new Mensagem('Atenção','A OP '.$aCamposChave['op'].' foi cancelada com sucesso!', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
        echo"$('#".$aDados[1]."-pesq').click();"; 
        }else{
           $oMensagem = new Mensagem('Erro!','A OP '.$aCamposChave['op'].' não foi cancelada com sucesso! >>>>'.$aRetorno[1], Mensagem::TIPO_ERROR);
           echo $oMensagem->getRender();  
        }     
    }
    
    /*
     * Mensagem se deseja retornar para Aberta situação da Ordem de Produção
     */ 
     public function msgAbertaOp($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();
        if($oOpAtual->getSituacao()!=='Cancelada'){
            $oMensagem = new Modal('Situação OP inválida!', 'A OP nº' . $aCamposChave['op'] . ' não pode ser retornada para Aberta!', Modal::TIPO_AVISO, true, true, true);
            echo $oMensagem->getRender();
        }else{   
        $oMensagem = new Modal('Retornar para Aberta a OP', 'Deseja alterar a situação Ordem de Produção nº' . $aCamposChave['op'] . ' para Aberta?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","abertaOp","' . $sDados . '");');
       
        echo $oMensagem->getRender();
        }
    }
    
    /*
     * Altera para Aberta a situação da ordem de producao
     */
    public function abertaOp($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //chama o método na persistencia
        $aRetorno = $this->Persistencia->AbertaOp($aCamposChave);
        
        if($aRetorno[0]){
        $oMensagem = new Mensagem('Atenção','A situação da OP '.$aCamposChave['op'].' foi alterada para Aberta com sucesso!', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
        echo"$('#".$aDados[1]."-pesq').click();"; 
        }else{
           $oMensagem = new Mensagem('Erro!','A OP '.$aCamposChave['op'].' não foi alterada com sucesso! >>>>'.$aRetorno[1], Mensagem::TIPO_ERROR);
           echo $oMensagem->getRender();  
        }     
    }
    public function consultaOp($iOp){
        $s=1; 
        $this->Persistencia->adicionaFiltro('op',$iOp);
        $oOp = $this->Persistencia->consultarWhere();
        return $oOp;
    }
    
    public function retornaOpAberto($aCampos){
        $aRetorno = $this->Persistencia->AbertaOp($aCampos);
    }
    
     public function mostraTelaRelOpForno($renderTo, $sMetodo = '') {        
        parent::mostraTelaRelatorio($renderTo, 'RelOpSteelForno');              
        
    }  
    
    public function buscaOp($iOp){
        $this->Persistencia->adicionaFiltro('op',$iOp);
        $oOp = $this->Persistencia->consultarWhere();
        return $oOp;
    }
    
    /**
     * Muda a situação da op conforme passado por parametro
     * @param type $iOp
     * @param type $sSit
     */
    public function changeSit($iOp,$sSit){
        
        $aRetorno = $this->Persistencia->alteraSit($iOp,$sSit);
        return($aRetorno);
        
    }
    
    public function buscaProduto ($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $this->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $this->Model = $this->Persistencia->consultarWhere();
        
        $this->Model->setProdes(str_replace("\n", " ",$this->Model->getProdes()));
        $this->Model->setProdes(str_replace("'","\'",$this->Model->getProdes()));   
        $this->Model->setProdes(str_replace("\r", "",$this->Model->getProdes()));
       
        $sRender = "$('#".$aDados[0]."').val('".$this->Model->getProd()."');"
             ."$('#".$aDados[1]."').val('".$this->Model->getProdes()."');";  
        
        echo $sRender;
            
             //. "$("#'.$aDados[1].'").val("'.$oDados->getProdes().'");';
        
    }
    public function verificaCampos(){
        //validar se cliente tem na base e atualizar seu nome conforme cadastro
        $oCliente = Fabrica::FabricarController('DELX_CAD_Pessoa');
        $oCliente->Persistencia->adicionaFiltro('emp_codigo', $this->Model->getEmp_codigo());
        $iCountCli = $oCliente->Persistencia->getCount();
        if($iCountCli>0){
            $oClienteResult = $oCliente->Persistencia->consultarWhere();
            $this->Model->setEmp_razaosocial($oClienteResult->getEmp_razaosocial());
        }else{
            $oModal = new Modal('Atenção', 'Esse cliente não está no seu cadastro de pessoas!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        //validar se produto tem na base e atualizar seu nome conforme cadastro
        $oCodigo = Fabrica::FabricarController('DELX_PRO_Produtos');
        $oCodigo->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getProd());
        $iContPro = $oCodigo->Persistencia->getCount();
        if($iContPro>0){
            $oProdResult = $oCodigo->Persistencia->consultarWhere();
            $this->Model->setProdes($oProdResult->getPro_descricao());
        }else{
            $oModal = new Modal('Atenção', 'Esse produto não está no seu cadastro de produtos!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        //validar se receita tem na base e atualizar seu nome conforme cadastro
        $oReceita = Fabrica::FabricarController('STEEL_PCP_Receitas');
        $oReceita->Persistencia->adicionaFiltro('cod',$this->Model->getReceita());
        $iContRec = $oReceita->Persistencia->getCount();
        if($iContRec>0){
            $oRecResult = $oReceita->Persistencia->consultarWhere();
            $this->Model->setReceita_des($oRecResult->getPeca());
        }else{
            $oModal = new Modal('Atenção', 'Essa receita não está no seu cadastro de receitas!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        //verifica quantidade 
        if($this->Model->getQuant()=='0' ||$this->Model->getQuant()=='' ){
            $oModal = new Modal('Atenção', 'Verifique a quantidade, não pode ser zero!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
         //verifica o peso
        if($this->Model->getPeso()=='0' ||$this->Model->getPeso()=='' ){
            $oModal = new Modal('Atenção', 'Verifique o peso, não pode ser zero!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        //verifica o unitário
        if($this->Model->getVlrNfEntUnit()=='0' ||$this->Model->getVlrNfEntUnit()=='' ){
            $oModal = new Modal('Atenção', 'Verifique o valor unitário, não pode ser zero!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        //verifica o valor
        if($this->Model->getVlrNfEnt()=='0' ||$this->Model->getVlrNfEnt()=='' ){
            $oModal = new Modal('Atenção', 'Verifique o valor, não pode ser zero!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        
        //atualiza campos Dur. Nucleo Dureza Max escala super,supermax, exp, expmax, composto
        $oProdMatRec = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $oProdMatRec->Persistencia->adicionaFiltro('seqmat',$this->Model->getSeqmat());
        $oDadosMetRec =$oProdMatRec->Persistencia->consultarWhere(); 
        
        $this->Model->setDurezaNucMin($oDadosMetRec->getDurezaNucMin());
        $this->Model->setDurezaNucMax($oDadosMetRec->getDurezaNucMax());
        $this->Model->setNucEscala($oDadosMetRec->getNucEscala());
        
        $this->Model->setDurezaSuperfMin($oDadosMetRec->getDurezaSuperfMin());
        $this->Model->setDurezaSuperfMax($oDadosMetRec->getDurezaSuperfMax());
        $this->Model->setSuperEscala($oDadosMetRec->getSuperEscala());
        
        $this->Model->setExpCamadaMin($oDadosMetRec->getExpCamadaMin());
        $this->Model->setExpCamadaMax($oDadosMetRec->getExpCamadaMax());
        $this->Model->setTratrevencomp($oDadosMetRec->getTratrevencomp());
        
        $this->Model->setFioDurezaSol($oDadosMetRec->getFioDurezaSol());
        $this->Model->setFioEsferio($oDadosMetRec->getFioEsferio());
        $this->Model->setFioDescarbonetaTotal($oDadosMetRec->getFioDescarbonetaTotal());
        $this->Model->setFioDescarbonetaParcial($oDadosMetRec->getFioDescarbonetaParcial());
        $this->Model->setDiamFinalMin($oDadosMetRec->getDiamFinalMin());
        $this->Model->setDiamFinalMax($oDadosMetRec->getDiamFinalMax());
        
    }
 
    
    
    
    /*
     * Mensagem se deseja colocar a ordem de produção para Retrabalho
     */ 
     public function msgRetrabalhoOp($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();
        if($oOpAtual->getSituacao()!=='Finalizado'){
            $oMensagem = new Modal('Situação OP inválida!', 'A OP nº' . $aCamposChave['op'] . ' não pode ser colocada em retrabalho!', Modal::TIPO_AVISO, false, true);
            
            echo $oMensagem->getRender();
        }else{   
        $oMensagem = new Modal('Colocar em Retrabalho a OP', 'Deseja colocar em Retrabalho a Ordem de Produção nº' . $aCamposChave['op'] . ' ?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","retrabalhoOp","' . $sDados . '");');
       
        echo $oMensagem->getRender();
        }
    }
    
    /*
     * Altera para Retrabalho a Ordem de produção e cria uma nova ordem de produção
     */
    public function retrabalhoOp($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //alimenta a model cab da op
        $this->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $this->Model=$this->Persistencia->consultarWhere();
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("d/m/y");                     
        $hora = date("H:i");   
        $user =$_SESSION['nome'];
        $this->Model->setData($data);
        $this->Model->setHora($hora);
        $this->Model->setUsuario($user);
        $this->Model->setOp_retrabalho($aCamposChave['op']);
        $this->Model->setRetrabalho('Sim');
        $this->Model->setSituacao('Aberta');
        $aRetorno[0]=$this->Persistencia->inserir();
        
        //itens da op
        $oItensOp = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
        $oItensOp->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oModelIten=$oItensOp->Persistencia->getArrayModel();
        
        foreach ($oModelIten as $oIten) {
            $oItensOp->Model = $oIten;
            $oItensOp->Model->setOp($this->Model->getOp());
            $oItensOp->Persistencia->setModel($oItensOp->Model);
            $oItensOp->Persistencia->inserir();
        }
        
        if($aRetorno[0]){
        $oMensagem = new Mensagem('Atenção!','A OP '.$aCamposChave['op'].' foi colocada em Retrabalho com sucesso!', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
        echo"$('#".$aDados[1]."-pesq').click();"; 
        }else{
           $oMensagem = new Mensagem('Erro!','A OP '.$aCamposChave['op'].' não foi colocada em Retrabalho! >>>>'.$aRetorno[1], Mensagem::TIPO_ERROR);
           echo $oMensagem->getRender();  
        }    
    }
    
    public function verificaOp(){
        //if($this->Model->getTipoOrdem()=='A'){
            if($this->Model->getProdFinal()==null || $this->Model->getProdFinal()==''){
                $oModal = new Modal('Atenção!','É necessário informar um produto final.', Modal::TIPO_AVISO, false, true);
                echo $oModal->getRender();
                exit();
            }
            
           
       // }
        //verifica se produto final é igual
       if($this->Model->getTipoOrdem()=='A'){
         if($this->Model->getProdFinal()==$this->Model->getProd()){
               $oModal = new Modal('Atenção!','O tipo da OP é de Arame no entando o produto final é igual ao produto da OP, altere o produto final!', Modal::TIPO_AVISO, false, true);
                echo $oModal->getRender();
                exit(); 
            }
       }
    }
    
   /**
    * Modal apontamentos
    */
     public function criaTelaModalAponta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aOp= explode('=', $aChave[0]);
        
        $oApontOp = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        $oApontOp->Persistencia->adicionaFiltro('op',$aOp[1]);
        
        $oDados = $oApontOp->Persistencia->consultarWhere();


        $this->View->setAParametrosExtras($oDados);

        $this->View->criaModalAponta();
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    /**
     * 
     * @param type $sParametros
     * @return boolean
     */
    public function criaTelaModalFat($sDados){
         $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aOp= explode('=', $aChave[0]);
        
       
       // $this->View->setAParametrosExtras($oDados);

        $this->View->criaModalFat($aOp);
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }


    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
        $aOp= explode('=', $sParametros[0]);
        $this->Persistencia->adicionaFiltro('op',$aOp[1]);
        $oDados = $this->Persistencia->consultarWhere();
        $sSituacao = $oDados->getSituacao();
        if($sSituacao == 'Processo'){
            $oModal = new Modal('Atenção!','Não é possível alterar a OP '.$aOp[1].', por que ela está em processo!', Modal::TIPO_AVISO, false, true);
            echo $oModal->getRender();
            $this->setBDesativaBotaoPadrao(true);
        }else{
            return true;
        }
    }
    
    /**
     * açoes após dar um comit
     */
    
    public function afterCommitUpdate() {
        parent::afterCommitUpdate();
        
        $this->pendenciasOP($sOp);
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno; 
    }
    /**
     * açoes após inserir
     */
    public function afterCommitInsert() {
        parent::afterCommitInsert();
        
        $this->pendenciasOP($sOp);
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno; 
    }

    /**
     * Monta as pendencias que podem ocorrer 
     */
    
    public function pendenciasOP($sOp){
        $aErro['pendencia'] = '';
        $aErro['pendenciaobs'] = '';
        $aDadosFat['tabela']='';
        $aDadosFat['ncm']='';
        
        
        //verificar se há tabela de preço para o cliente
        $aCamposChave = array();
        parse_str($_REQUEST['campos'], $aCamposChave);
        
        //busca tabela de preço
        $oTabCli = Fabrica::FabricarController('STEEL_PCP_TabCabPreco');
        $oTabCli->Persistencia->adicionaFiltro('emp_codigo',$aCamposChave['emp_codigo']);
        $oTabCli->Persistencia->adicionaFiltro('sit','INATIVA',0,10);
        $oTabCliDados = $oTabCli->Persistencia->consultarWhere();
        $iTabela = $oTabCli->Persistencia->getCount();
        $aDadosFat['tabela']=$oTabCliDados->getNometabela();
        //busca produtos
        $oProdUn = Fabrica::FabricarController('DELX_PRO_Produtos');
        $oProdUn->Persistencia->limpaFiltro();
        $oProdUn->Persistencia->adicionaFiltro('pro_codigo',$this->Model->getProdFinal());
        $oProdDados = $oProdUn->Persistencia->consultarWhere();
        $aDadosFat['ncm'] = $oProdDados->getPro_ncm(); 
        
        //item da tabela de preço   
         $oItemsTabela = Fabrica::FabricarController('STEEL_PCP_TabItemPreco');    
        //------------------------verificar tabela ----------------------------------------------
        if($iTabela==0){
            //mensagem e gravamos tabela = 0
            $oMensagem = new Mensagem('Atenção!','Não há tabela de preços para esse cliente! ', Mensagem::TIPO_WARNING,5000);
            echo $oMensagem->getRender();
            $aErro['pendencia'] = 'Atenção';
            $aErro['pendenciaobs'] .= 'Tabela de preços não cadastrada! ';
            }
         
        //------------------------verifica item na tabela de preço -----------------------------
                //verifica tipo da op para analisar 
            if($this->Model->getTipoOrdem()=='P'){
                //INSUMO----------------------------------------------------
                $oItemsTabela->Persistencia->adicionaFiltro('nr',$oTabCliDados->getNr());
                $oItemsTabela->Persistencia->adicionaFiltro('receita',$this->Model->getReceita());
                $oItemsTabela->Persistencia->adicionaFiltro('tipo','INSUMO');
                $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm',$oProdDados->getPro_ncm());
                $oDadosInsumo = $oItemsTabela->Persistencia->consultarWhere();
                //alimenta array insumo
                $aDadosFat['insumo'][] = $oDadosInsumo;
                 if($oDadosInsumo->getProd()== null){
                    //mensagem e gravamos tabela = 0
                    $oMensagem = new Mensagem('Atenção!','Não há INSUMO cadastrado na tabela de preço! ', Mensagem::TIPO_WARNING,5000);
                    echo $oMensagem->getRender();
                    $aErro['pendencia'] = 'Atenção';
                    $aErro['pendenciaobs'] .= 'Não há INSUMO cadastrado na tabela de preço! ';
                    }
                  //SERVIÇO--------------------------------------------------
                $oItemsTabela->Persistencia->limpaFiltro();
                $oItemsTabela->Persistencia->adicionaFiltro('nr',$oTabCliDados->getNr());
                $oItemsTabela->Persistencia->adicionaFiltro('receita',$this->Model->getReceita());
                $oItemsTabela->Persistencia->adicionaFiltro('tipo','SERVIÇO');
                $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm',$oProdDados->getPro_ncm());
                $oDadosServico = $oItemsTabela->Persistencia->consultarWhere();
                //alimenta array serviço
                $aDadosFat['servico'][] = $oDadosServico;
                 if($oDadosServico->getProd()== null){
                    //mensagem e gravamos tabela = 0
                    $oMensagem = new Mensagem('Atenção!','Não há SERVIÇO cadastrado na tabela de preço! ', Mensagem::TIPO_WARNING,5000);
                    echo $oMensagem->getRender();
                    $aErro['pendencia'] = 'Atenção';
                    $aErro['pendenciaobs'] .= 'Não há SERVIÇO cadastrado na tabela de preço! ';
                    }  
                  //-----------------------------------------------------------  
                    
                }
        
               //-----------------------SE A OP FOR FIO MÁQUINA----------------------
                
            if($this->Model->getTipoOrdem()=='F'){
                        //novo método para inserir dando um foreach
                        $oItensReceita = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
                        $oItensReceita->Persistencia->adicionaFiltro('cod',$this->Model->getReceita());
                        //gera os items da receita de modo distinc
                        $aDadosItensReceita = $oItensReceita->Persistencia->distinctItemReceita($this->Model->getReceita());
                        
                        foreach ($aDadosItensReceita as $key => $oTrat) {
                            $oItemsTabela->Persistencia->limpaFiltro();
                            $oItemsTabela->Persistencia->adicionaFiltro('nr',$oTabCliDados->getNr());  //tabela de preco
                            $oItemsTabela->Persistencia->adicionaFiltro('receita', $this->Model->getReceita()); //receita
                            $oItemsTabela->Persistencia->adicionaFiltro('tipo','SERVIÇO'); //insumo ou serviço
                            $oItemsTabela->Persistencia->adicionaFiltro('cod',$oTrat->tratcod); //codigo do tratamento somente qdo for op fio
                            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm',$oProdDados->getPro_ncm());//ncm
                            $oDadosFioServ = $oItemsTabela->Persistencia->consultarWhere();
                            //servico
                            $aDadosFat['servico'][] = $oDadosFioServ;
                            if($oDadosFioServ->getProd()== null){
                                //mensagem e gravamos tabela = 0
                                $oMensagem = new Mensagem('Atenção!','Não há SERVIÇO cadastrado na tabela de preço e lembrar de informar o tratamento! ', Mensagem::TIPO_WARNING,5000);
                                echo $oMensagem->getRender();
                                $aErro['pendencia'] = 'Atenção';
                                $aErro['pendenciaobs'] .= 'Não há SERVIÇO cadastrado na tabela de preço e lembrar de informar o tratamento nº'.$oTrat->tratcod.'! '; 
                            }
                            
                            $oItemsTabela->Persistencia->limpafiltro();
                            $oItemsTabela->Persistencia->adicionaFiltro('nr',$oTabCliDados->getNr());  //tabela de preco
                            $oItemsTabela->Persistencia->adicionaFiltro('receita', $this->Model->getReceita()); //receita
                            $oItemsTabela->Persistencia->adicionaFiltro('tipo','INSUMO'); //insumo ou serviço
                            $oItemsTabela->Persistencia->adicionaFiltro('cod',$oTrat->tratcod); //codigo do tratamento somente qdo for op fio
                            $oItemsTabela->Persistencia->adicionaFiltro('STEEL_PCP_Produtos.pro_ncm',$oProdDados->getPro_ncm());//ncm
                            $oDadosFioInsumo = $oItemsTabela->Persistencia->consultarWhere();
                            //alimenta array insumo
                            $aDadosFat['insumo'][] = $oDadosFioInsumo;
                            
                            if($oDadosFioInsumo->getProd()== null){
                                //mensagem e gravamos tabela = 0
                                $oMensagem = new Mensagem('Atenção!','Não há INSUMO cadastrado na tabela de preço e lembrar de informar o tratamento! ', Mensagem::TIPO_WARNING,5000);
                                echo $oMensagem->getRender();
                                $aErro['pendencia'] = 'Atenção';
                                $aErro['pendenciaobs'] .= 'Não há INSUMO cadastrado na tabela de preço e lembrar de informar o tratamento nº'.$oTrat->tratcod.'! '; 
                            }
                            
                            
                        }
            }
                
                
                
            
        //grava
        $this->Persistencia->gravaPendencia($this->Model->getOp(),$aErro['pendencia'],$aErro['pendenciaobs']);
        //($sOp,$sAtencao,$sPendencia)
       
        return $aDadosFat;
    }
    
    public function mostraTelaRelOpSteelNaoApont($renderTo, $sMetodo = '') {        
        parent::mostraTelaRelatorio($renderTo, 'RelOpSteelNaoApont');              
    }  
}
   
   
    

