<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewGrupoProd extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oGrucod = new CampoConsulta('Código','grucod');
        $oDes = new CampoConsulta('Descrição','grudes');
        $oGruTipo = new CampoConsulta('Tipo','grutipo');
        
        $oFilDes = new Filtro($oDes, Filtro::CAMPO_TEXTO,3);
        $this->addFiltro($oFilDes);
        
        $this->addCampos($oGrucod,$oDes,$oGruTipo);
        $this->setBScrollInf(true);
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Visualiza grupo de produtos');
        
        $oGrucod = new Campo('Código','grucod', Campo::TIPO_TEXTO,1);
        $oDes = new Campo('Descrição','grudes', Campo::TIPO_TEXTO,3);
        $oGruTipo = new Campo('Tipo','grutipo', Campo::TIPO_TEXTO,2);
        
        $this->addCampos($oGrucod,$oDes,$oGruTipo);
        
        
    }
}