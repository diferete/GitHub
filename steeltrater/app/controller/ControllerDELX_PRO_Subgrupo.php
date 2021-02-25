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
        $aFiltro = $_REQUEST['parametrosCampos'];
        sort($aFiltro);
        if (count($aCampos) > 0 || count($aFiltro) > 0) {
            if (isset($aCampos['pro_grupocodigofin'])) {
                $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo'], 0, Persistencia::ENTRE, $aCampos['pro_grupocodigofin']);
            } else {
                if (count($aCampos) > 0) {
                    $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
                } else {
                    if ($aFiltro[0] != '') {
                        $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aFiltro[0]);
                    }
                }
            }
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
