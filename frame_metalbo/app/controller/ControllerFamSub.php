<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerFamSub extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('FamSub');
    }
    
    
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('grucod', $aCampos['grucod']);
            $this->Persistencia->adicionaFiltro('subcod', $aCampos['subcod']);
            $this->Persistencia->adicionaFiltro('famcod', $aCampos['famcod']);
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('grucod', $aCampos['grucod']);
            $this->Persistencia->adicionaFiltro('subcod', $aCampos['subcod']);
            $this->Persistencia->adicionaFiltro('famcod', $aCampos['famcod']);
        }
    }

}