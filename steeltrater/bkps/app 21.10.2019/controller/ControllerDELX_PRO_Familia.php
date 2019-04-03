<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ControllerDELX_PRO_Familia extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_PRO_Familia');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
            $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo']);
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
            $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo']);
        }
    }

}
