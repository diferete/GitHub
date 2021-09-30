<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPoliSetor extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oCodsetor = new CampoConsulta('Código', 'codsetor');
        
        $oSetor = new CampoConsulta('Setor', 'setor');
        
        $oFiltro1 = new Filtro($oSetor, Campo::TIPO_TEXTO,3);
        
        $this->addFiltro($oFiltro1);
        
        $this->addCampos($oCodsetor,$oSetor);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oCodsetor = new Campo('Código', 'codsetor', Campo::TIPO_TEXTO,1);
        $oSetor = new Campo('Setor', 'setor', Campo::TIPO_TEXTO,6);
        
        $this->addCampos($oCodsetor,$oSetor);
        
    }
}