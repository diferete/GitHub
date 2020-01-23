<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_RH_FuncaoSetor extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_RH_FuncaoSetor');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('codsetor', $aCampos['codsetor']);
            $this->Persistencia->adicionaFiltro('filcgc', $_SESSION['filcgc']);
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('codsetor', $aCampos['setor']);
            $this->Persistencia->adicionaFiltro('filcgc', $_SESSION['filcgc']);
        }
    }

}
