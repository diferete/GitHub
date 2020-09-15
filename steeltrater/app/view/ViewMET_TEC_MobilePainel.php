<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_MobilePainel extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oPainelCod = new CampoConsulta('Cod', 'painelcod');
        $oPainelDesc = new CampoConsulta('Desc','paineldesc');
        
        $oFiltro = new Filtro($oPainelDesc, Filtro::CAMPO_TEXTO_IGUAL,3,3,3,3);
        $this->addFiltro($oFiltro);
        $this->addCampos($oPainelCod,$oPainelDesc);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oPainelCod = new Campo('Código','painelcod', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oPainelCod->setBCampoBloqueado(true);
        $oPainelDesc = new Campo('Descrição', 'paineldesc', Campo::TIPO_TEXTO, 6, 6, 6, 6);
        $oPainelDesc->setBFocus(true);
        
        $this->addCampos($oPainelCod,$oPainelDesc);
    }
}