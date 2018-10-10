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
        
        //validar se cliente tem na base e atualizar seu nome conforme cadastro
         $this->verificaCampos();
       
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setTemprev($this->ValorSql($this->Model->getTemprev()));
        
        
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
        
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setTemprev($this->ValorSql($this->Model->getTemprev()));
        
        

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
        
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
        
    }

        public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);
        
        $this->Model->setQuant(number_format($this->Model->getQuant(), 3, ',', '.'),0,0,'L' );
        $this->Model->setPeso(number_format($this->Model->getPeso(), 3, ',', '.'),0,0,'L' );
        $this->Model->setTemprev(number_format($this->Model->getTemprev(), 3, ',', '.'),0,0,'L' );
       
    }
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        $aRender = explode(',',$sParametros);
        
        $sChave =htmlspecialchars_decode($aRender[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        if(count($aCamposChave)>0){
        $oNotasImp = Fabrica::FabricarController('STEEL_PCP_NotaImportaNf');
        $oModelImp = $oNotasImp->buscaNota($aCamposChave);
        //busca o peso do produto
        $oPeso = Fabrica::FabricarController('DELX_PRO_Produtos');
        $Peso = $oPeso->retornaPeso($oModelImp->getNfsitcod());
        $PesoTotal = ($Peso*$oModelImp->getNfsitqtd());
        $oModelImp->setPeso($PesoTotal);
        
        $this->View->setAParametrosExtras($oModelImp);
        
        //valida se há op
        if($oModelImp->getOpSteel()){
            $oModal = new Modal('Atenção!','Esse ítem já tem ordem de produção.', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            exit();
        }
        echo ' $("#'.$aRender[1].'consulta").hide(); ';
        
        }
        
        
    }

   //busca uma receita padrão 
 /*  public function buscaProdReceita($sDados){
       $aRender = explode(',',$sDados);
        
        
       
       $oProdReceita = Fabrica::FabricarController('STEEL_PCP_ProdReceita');
       $oDados = $oProdReceita->receitaPadrao($aRender[0]);
       
       
       //coloca o valor no campo
       if($oDados->getCod_receita()){
        $oMensagem = new Mensagem('Localizado!','Foi localizado uma receita.', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
        echo '$("#'.$aRender[1].'").val("'.$oDados->getCod_receita().'");';
        echo '$("#'.$aRender[2].'").val("");';
       }else{
          $oMensagem = new Mensagem('Atenção!','Não foi encontrado uma receita padrão.', Mensagem::TIPO_INFO);
          echo $oMensagem->getRender();
         // echo '$("#'.$aRender[1].'").val("");';
         // echo '$("#'.$aRender[2].'").val("");';
       }
   }*/
   
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
       }
       
      // exemplo.php?vetor[]=valor1&vetor[]=valor2&vetor[]=valor3
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'OpSteel1.php?'.$sVethor;
        
        $sCampos.= $this->getSget();
        
        
        
       $sCampos.='&output=tela';
       $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
       echo $oWindow; 
         
         
       
        }
       
       
    public function mostraTelaRelOpEmitida($renderTo, $sMetodo = '') {        
        parent::mostraTelaRelatorio($renderTo, 'RelOpSteel2');              
        
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
    }
 
   
        
}
   
   
    

