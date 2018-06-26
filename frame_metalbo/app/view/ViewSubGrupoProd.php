<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSubGrupoProd extends View {
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oGrucod = new CampoConsulta('Grupo','grucod', CampoConsulta::TIPO_LARGURA, 20);
        $oSubGrupo = new CampoConsulta('SubGrupo','subcod', CampoConsulta::TIPO_LARGURA, 20);
        $oSubDes = new CampoConsulta('SubGrupo Descrição','subdes', CampoConsulta::TIPO_LARGURA, 20);
        
        $oFilSubCod = new Filtro($oSubGrupo, Filtro::CAMPO_TEXTO,2);
        $oFilSubdes = new Filtro($oSubDes, Filtro::CAMPO_TEXTO,2);
        $oFilGrupo = new Filtro($oGrucod, Filtro::CAMPO_TEXTO,2);
        
        
        $this->addFiltro($oFilSubCod,$oFilSubdes,$oFilGrupo);
        
        $this->addCampos($oSubGrupo,$oSubDes,$oGrucod);
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Visualiza Sub Grupos de Produtos');
        
        $oGrucod = new Campo('Grupo','grucod', Campo::TIPO_TEXTO,1);
        $oSubGrupo = new Campo('SubGrupo','subcod',Campo::TIPO_TEXTO,1);
        $oSubDes = new Campo('SubGrupo Descrição','subdes',Campo::TIPO_TEXTO,3);
        
         $this->addCampos(array($oSubGrupo,$oSubDes),array($oGrucod));
   
    }
}