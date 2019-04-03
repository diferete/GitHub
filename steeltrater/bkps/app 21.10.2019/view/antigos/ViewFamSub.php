<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewFamSub extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oFamsub = new CampoConsulta('SubFamília','famsub', CampoConsulta::TIPO_LARGURA, 20);
        $oFamSubDes = new CampoConsulta('Descrição','famsdes', CampoConsulta::TIPO_LARGURA, 20);
        
        
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        
        $oFamcodF = new Filtro($oFamsub, Filtro::CAMPO_TEXTO,1);
        $oFamDesF = new Filtro($oFamSubDes,Filtro::CAMPO_TEXTO,3);
        $this->addFiltro($oFamcodF,$oFamDesF);
        
        $this->addCampos($oFamsub,$oFamSubDes);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        
    }
}