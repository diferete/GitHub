<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_RH_FuncaoSetor extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNr = new CampoConsulta('Nr', 'nr');
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc');
        $oSetor = new CampoConsulta('Setor', 'codsetor');
        $oCodFunc = new CampoConsulta('Cod.Func.', 'codfunc');
        $oDescFunc = new CampoConsulta('Desc.Func.', 'descfunc');
        
        $this->addCampos($oNr,$oFilcgc,$oSetor,$oCodFunc,$oDescFunc);
        
    }
    
    public function criaTela() {
        parent::criaTela();
    }
}