<?php

/* 
 * Classe que implementa o controller da class STEEL_PCP_fornoProd
 * 
 * @author Avanei Martendal
 * @since 28/08/2018
 */

class ControllerSTEEL_PCP_fornoProd extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_fornoProd');
    }
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
       
       
         $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
         $oFornoSel = $oForno->Persistencia->getArrayModel();
         $this->View->setAParametrosExtras($oFornoSel);
         
   
    }
    
    public function inserirFornos($sDados){
         $sDados = $_REQUEST['campos'];
         $sCampos = htmlspecialchars_decode($sDados);
         $aCamposChave = array();
         parse_str($sCampos, $aCamposChave);
         $aDadosProd = array();
         $aDadosProd['procod']=$aCamposChave['prod'];
         $aDadosProd['prodes']=$aCamposChave['prodes'];
         unset($aCamposChave['prod']);
         unset($aCamposChave['prodes']);
         $this->Model->setProd($aDadosProd['procod']);
         $this->Persistencia->adicionaFiltro('prod',$aDadosProd['procod']);
         $this->Persistencia->excluir();
         
         if(count($aCamposChave)>0){
         foreach ($aCamposChave as $key => $value) {
            $this->Model->setFornocod($key); 
            $aRetorno = $this->Persistencia->inserir();
            if($aRetorno[0]){
                $oMensagem= new Mensagem('Sucesso', 'Forno adicionados ao produto!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
            }
         }
         }else{
             $oMensagem = new Modal('Atenção!', 'Você limpou os fornos referente a esse código!', Modal::TIPO_INFO);
             echo $oMensagem->getRender();
         }
             
    }
}
