<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_ParametrosProd extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oCod = new CampoConsulta('Código','cod');
        $oParam = new CampoConsulta('Parametro','parametro');
        $oValor = new CampoConsulta('Valor','valor');
        
        $oFiltro = new Filtro($oParam, Filtro::CAMPO_TEXTO, 6, 6, 6, 6);
        
        $this->addFiltro($oFiltro);
        $this->addCampos($oCod,$oParam,$oValor);
        $this->setUsaAcaoExcluir(false);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oCod = new Campo('Cod','cod', Campo::TIPO_TEXTO,1,1,1,1);
        $oParam = new Campo('Parâmetro', 'parametro', Campo::TIPO_TEXTO,5,5,5,5);
        $oValor = new Campo('Valor','valor', Campo::CAMPO_SELECTSIMPLE,5,5,5,5);
        $oValor->addItemSelect('SIM','SIM');
        $oValor->addItemSelect('NÃO','NÃO');
        $oObs = new Campo('Obs','obs', Campo::TIPO_TEXTAREA,8,8,8,8);
        
        $this->addCampos($oCod,$oParam,$oValor,$oObs);
    }
}