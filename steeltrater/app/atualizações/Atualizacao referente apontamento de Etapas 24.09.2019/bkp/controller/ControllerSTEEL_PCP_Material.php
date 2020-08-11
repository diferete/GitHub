<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 03/09/2018
 */

class ControllerSTEEL_PCP_Material extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Material');
    }
    
    public function antesExcluir($sParametros = null) {
           parent::antesExcluir($sParametros);
        $oMaterial = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $oMaterial->Persistencia->adicionaFiltro('matcod',$sParametros['matcod']);
        $iContMaterial = $oMaterial->Persistencia->getCount();
        
        $oProduto = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oProduto->Persistencia->adicionaFiltro('matcod',$sParametros['matcod']);
        $iContProduto = $oProduto->Persistencia->getCount(); 

        if(($iContMaterial==0)&&($iContProduto==0)){
            
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
            
        }else{
            
            $oModal = new Modal('Atenção', 'Esse material não pode ser excluído, pois está vinculado a um produto!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }  
           
    }
    
}