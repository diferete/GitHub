<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewFamProd extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oGrucod = new CampoConsulta('Grupo','grucod', CampoConsulta::TIPO_LARGURA, 20);
        
        
        $oSubcod = new CampoConsulta('SubGrupo','subcod', CampoConsulta::TIPO_LARGURA, 20);
        
        
        $oFamCod = new CampoConsulta('FamCod','famcod', CampoConsulta::TIPO_LARGURA, 20);
        $oFamDes = new CampoConsulta('Família Descrição','famdes', CampoConsulta::TIPO_LARGURA, 20);
        
       $oFamCodF = new Filtro($oFamCod, Filtro::CAMPO_TEXTO,1);
       $oFamDesF = new Filtro($oFamDes, Filtro::CAMPO_TEXTO,3);
       
       $this->addFiltro($oFamCodF,$oFamDesF);
        
         
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        
        $this->addCampos($oFamCod,$oFamDes,$oGrucod,$oSubcod);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Visualiza Família');
        
        $oGrucod = new Campo('Grupo','grucod', Campo::TIPO_TEXTO,1);
        
        
        $oSubcod = new Campo('SubGrupo','subcod',Campo::TIPO_TEXTO,1);
      
        
        $oFamCod = new Campo('FamCod','famcod',Campo::TIPO_TEXTO,1);
        $oFamDes = new Campo('Família Descrição','famdes',Campo::TIPO_TEXTO,3);
        
        $this->addCampos($oFamCod,$oFamDes,$oGrucod,$oSubcod);
    }
}