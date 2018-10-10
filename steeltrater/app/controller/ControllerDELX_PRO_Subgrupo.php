<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class ControllerDELX_PRO_Subgrupo extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_PRO_Subgrupo');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
        }
    }
    
    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();
        
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
        }
        
    }

}
