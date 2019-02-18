<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class ControllerDELX_PRO_Produtos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_PRO_Produtos');
    }

    public function retornaPeso($sProduto) {
        $this->Persistencia->adicionaFiltro('pro_codigo', $sProduto);
        $oProduto = $this->Persistencia->consultarWhere();
        return $oProduto->getPro_pesoliquido();
    }

    public function afterInsert() {
        parent::afterInsert();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aValorCampo = array();

        if (isset($aCampos['matriz'])) {
            array_push($aValorCampo, '75483040000130');
        }
        if (isset($aCampos['fecial'])) {
            array_push($aValorCampo, '5572480000189');
        }
        if (isset($aCampos['fecula'])) {
            array_push($aValorCampo, '10540966000175');
        }
        if (isset($aCampos['hedler'])) {
            array_push($aValorCampo, '83781641000158');
        }
        if (isset($aCampos['steeltrater'])) {
            array_push($aValorCampo, '8993358000174');
        }
        
       $this->Persistencia->insereProdFilial($aValorCampo); 
    }

}
