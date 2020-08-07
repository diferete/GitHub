<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewChamadoSit extends View{
    
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oCodsit = new CampoConsulta('Codigo','codsit');
        $oCodsit->setILargura(40);
        
        $oSit = new CampoConsulta('Situações','sit');
        
        $oFiltro1 = new Filtro($oSit, Filtro::CAMPO_TEXTO,3);
        
        $this->addFiltro($oFiltro1);
        
        $this->addCampos($oCodsit,$oSit);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oCodSit = new Campo('Código','codsit', Campo::TIPO_TEXTO,1);
        $oSit = new Campo('Situação','sit', Campo::TIPO_TEXTO,5);
        
        $this->addCampos($oCodSit,$oSit);
    }
    
    
}