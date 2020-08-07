<?php

/**
 * Implementa controller da classe FIS_Lc11603secundario
 * @author Alexandre W de Souza
 * @since 26/09/2018
 * ** */
class ControllerDELX_FIS_Lc11603secundario extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_FIS_Lc11603secundario');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('fis_lc11603principalcodigo', $aCampos['fis_lc11603principalcodigo']);
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('fis_lc11603principalcodigo', $aCampos['fis_lc11603principalcodigo']);
        }
    }

}
