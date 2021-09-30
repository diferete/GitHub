<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewEstudantes extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oCod = new CampoConsulta('Código','cod');
        $oNome = new CampoConsulta('Nome','nome');
        $oUlt  = new CampoConsulta('Última Parte','ultparte', CampoConsulta::TIPO_DATA);
        $oProx = new CampoConsulta('Próxima','proxparte',CampoConsulta::TIPO_DATA);
        $obs = new CampoConsulta('Obs','obs');
        
        $oFiltroNome = new Filtro($oNome, Filtro::CAMPO_TEXTO,3);
        
        $this->addFiltro($oFiltroNome);
        
        $this->addCampos($oCod,$oNome,$oUlt,$oProx,$obs);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oCod = new Campo('Código','cod', Campo::TIPO_TEXTO,2);
        $oNome = new Campo('Nome','nome',Campo::TIPO_TEXTO,5);
        $oUlt  = new Campo('Última Parte','ultparte', Campo::TIPO_DATA,2);
        $oProx = new Campo('Próxima','proxparte',Campo::TIPO_DATA,2);
        $obs = new Campo('Obs','obs', Campo::TIPO_TEXTAREA,8);
        $obs->setILinhasTextArea(7);
        
        $this->addCampos($oCod,$oNome,$oUlt,$oProx,$obs);
    }
}