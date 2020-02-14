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
        parse_str($_REQUEST['campos'],$aCampos);
         if(count($aCampos)>0){
        $this->Persistencia->adicionaFiltro('grucod',$aCampos['grupo'], Persistencia::LIGACAO_AND, Persistencia::ENTRE,$aCampos['grupo1']);
        $this->Persistencia->adicionaFiltro('subcod',$aCampos['subgrupo'], Persistencia::LIGACAO_AND, Persistencia::ENTRE,$aCampos['subgrupo1']);
        $this->Persistencia->adicionaFiltro('famcod',$aCampos['familia'], Persistencia::LIGACAO_AND, Persistencia::ENTRE,$aCampos['familia1']);
        }
    }

}