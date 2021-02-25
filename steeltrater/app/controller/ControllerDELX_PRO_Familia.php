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
        $aFiltro = $_REQUEST['parametrosCampos'];
        sort($aFiltro);
        $aFiltro = explode(',', $aFiltro[0]);
        if (count($aCampos) > 0 || count($aFiltro) > 0) {
            if (isset($aCampos['pro_grupocodigofin'])) {
                $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo'], 0, Persistencia::ENTRE, $aCampos['pro_grupocodigofin']);
                $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo'], 0, Persistencia::ENTRE, $aCampos['pro_subgrupocodigofin']);
            } else {
                if (count($aCampos) > 0) {
                    $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aCampos['pro_grupocodigo']);
                    $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo']);
                } else {
                    if ($aFiltro[0] != '') {
                        $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aFiltro[0]);
                    }
                    if ($aFiltro[1] != '') {
                        $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aFiltro[1]);
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
            $this->Persistencia->adicionaFiltro('pro_subgrupocodigo', $aCampos['pro_subgrupocodigo']);
        }
    }

}
