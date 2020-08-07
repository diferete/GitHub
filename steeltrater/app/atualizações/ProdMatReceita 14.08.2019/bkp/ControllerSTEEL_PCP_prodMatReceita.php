<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class ControllerSTEEL_PCP_prodMatReceita extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_prodMatReceita');
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $this->Persistencia->adicionaFiltro('prod', $this->Model->getProd());
        $this->Persistencia->adicionaFiltro('matcod', $this->Model->getMatcod());
        $this->Persistencia->adicionaFiltro('cod', $this->Model->getCod());
        $this->Persistencia->adicionaFiltro('prodfinal', $this->Model->getProdFinal());
        
        $iCont =$this->Persistencia->getCount();
        if($iCont>0){
            $oModal = new Modal('Atenção!','Já existe uma registro desse produto, material, receita!', Modal::TIPO_INFO);
            echo $oModal->getRender();
            exit();
        }
        $this->Persistencia->limpaFiltro();
        $aRetorno[0] = true;
         return $aRetorno;
    }
    
    public function afterGetdadoGrid($sParametros = null) {
        parent::afterGetdadoGrid();
        
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        if($aCamposChave['prod']==''){
          $oMensagem = new Mensagem('Atenção!', 'Informe um código para pesquisar seu material e receita!', Mensagem::TIPO_WARNING);
          echo $oMensagem->getRender();
          exit();
        }else{
          $this->Persistencia->adicionaFiltro('prod',$aCamposChave['prod']);
          $this->Persistencia->adicionaFiltro('prodfinal',$aCamposChave['prodFinal']);
          $iCout = $this->Persistencia->getCount();
          if ($iCout==0){
              $oModal = new Modal('Atenção!', 'Não há vínculo do produto com o Material e sua Receita, prossiga até a tela de cadastro.', Modal::TIPO_AVISO,TRUE,TRUE,TRUE);
              $oModal->setSBtnConfirmarFunction('verificaTab("menu-1-prodMatRec","1-prodMatRec","STEEL_PCP_prodMatReceita",'
                      . '"acaoMostraTela","tabmenu-1-prodMatRec,'.$aCamposChave['prod'].'|'.$aCamposChave['prodFinal'].'|'.$aCamposChave['prodesFinal'].'","Prod/Mat/Receita","parametro");');
              echo $oModal->getRender();
              
          } 
        }
    }
    
    public function sendDadosCampos($sDados){
      $aDados = explode(',',$sDados);
        
      $sChave = htmlspecialchars_decode($aDados[1]);
      $aChaveAq = array();
      parse_str($sChave,$aChaveAq);
      $this->Persistencia->adicionaFiltro('seqmat',$aChaveAq['seqmat']);
      $this->Model = $this->Persistencia->consultarWhere();
      
      if(count($aChaveAq)>0){
          

           
            echo "$('#".$aDados[2]."').val('".$this->Model->getMatcod()."');";
            echo "$('#".$aDados[3]."').val('".$this->Model->getSTEEL_PCP_material()->getMatdes()."');";
            echo "$('#".$aDados[4]."').val('".$this->Model->getCod()."');";
            echo "$('#".$aDados[5]."').val('".$this->Model->getSTEEL_PCP_receitas()->getPeca()."');";
            echo "$('#".$aDados[6]."').val('".$this->Model->getSeqmat()."');";
            echo "$('#".$aDados[7]."').val('".number_format($this->Model->getSTEEL_PCP_receitas()->getTemprev(),3,',','.')."');";
           
            
            
        }else{
            echo "$('#".$aDados[2]."').val('');";
            echo "$('#".$aDados[3]."').val('');";
            echo "$('#".$aDados[4]."').val('');";
            echo "$('#".$aDados[5]."').val('');";
            echo "$('#".$aDados[6]."').val('');";
            echo "$('#".$aDados[7]."').val('0');";
        }
        
      
    }
    
    public function antesExcluir($sParametros = null) {
        parent::antesExcluir($sParametros);
        
        $oProduto = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oProduto->Persistencia->adicionaFiltro('seqmat',$sParametros['seqmat']);
        $iContVinculo = $oProduto->Persistencia->getCount();
        
        if($iContVinculo==0){
            
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
            
        }else{
            
            $oModal = new Modal('Atenção', 'Esse produto não pode ser excluído, pois está vinculado a uma Ordem de Produção!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
       }
    
       
    public function mostraRelItensPPAP($renderTo, $sMetodo = '') {                
        parent::mostraTelaRelatorio($renderTo, 'RelItensPPAP');                          
           
    }  
    
    
    public function relatorioExcelProdMatRec(){ 
                
        $sCampos.= $this->getSget();
               
        $sSistema ="app/relatorio";
        $sRelatorio = 'RelProdMatRecExcel.php?';
        
        $sCampos.='&output=email';
        $oMensagem = new Mensagem("Aguarde","Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
        
        $oWindow ='var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'","MsgWindow","width=500,height=100,left=375,top=330");';
                    //.'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;

       // $oMenSuccess = new Mensagem("Sucesso","Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
       // echo $oMenSuccess->getRender();
       
    } 
    
    public function contaRegistros($sDados){
        
        $sClasse = $this->getNomeClasse();
        $oProdMatRec = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $iCountCli = $oProdMatRec->Persistencia->getCount();
        $oMensagem = new Modal('Gerando Excel', 'A tabela tem ' . $iCountCli . ' linhas deseja continuar? \n Enquanto gera seu arquivo continue a usar o sistema!', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","relatorioExcelProdMatRec");');  
        echo $oMensagem->getRender();      
    }
    
    public function afterCriaTela() {
        parent::afterCriaTela();
        
        $this->View->setBOcultaFechar(true);
    }
    
    public function antesDeMostrarTela($sParametros = null) {
        parent::antesDeMostrarTela($sParametros);
        
        $aDados = explode('|', $sParametros);
        $aDados1 = explode(',', $aDados[0]);
        
        $oProdDados = Fabrica::FabricarController('DELX_PRO_Produtos');
        $oProdDados->Persistencia->adicionaFiltro('pro_codigo',$aDados1[1]);
        $oDados = $oProdDados->Persistencia->consultarWhere();
        if($oDados->getPro_codigo()!==null){
            $oDados->setProdFinal($aDados[1]);
            $oDados->setProdFinalDes($aDados[2]);
        }
        
        $this->View->setAParametrosExtras($oDados); 
    }
    
         
}
