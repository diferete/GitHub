<?php

/* 
 *Classe que implementa o controller da produção steeltrater
 * 
 * @author Avanei Martendal
 * @since 31/05/2018
 */

class ControllerSTEEL_PCP_Tratamentos extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Tratamentos');
    }
    
    public function beforeDelete(){
        parent::beforeDelete();
    
        $oReceitaItens = Fabrica::FabricarController('STEEL_PCP_receitasItens');
        $oReceitaItens->Persistencia->adicionaFiltro('tratcod',$this->Model->getTratcod());
        $iContRecItens = $oReceitaItens->Persistencia->getCount();

        if($iContRecItens==0){
            
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
            
        }else{
            
            $oModal = new Modal('Atenção', 'Esse item não pode ser excluído, pois está sendo usada por uma receita!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
    }
}

