<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewEan extends View{
    public function __construct() {
        parent::__construct();
    }
   
    public function criaConsulta() {
        parent::criaConsulta();
        $this->setaTiluloConsulta('Consulta de códigos de barra');
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oEan = new CampoConsulta('Ean', 'ean', CampoConsulta::TIPO_LARGURA, 20);
        $oProcod = new CampoConsulta('Código','Produto.procod', CampoConsulta::TIPO_LARGURA, 20);
        $oProdes = new CampoConsulta('Descrição','Produto.prodes', CampoConsulta::TIPO_LARGURA, 20 );
        $oQt = new CampoConsulta('Peças', 'pcs', CampoConsulta::TIPO_LARGURA, 20);
        $this->setBScrollInf(true);
        
        
        
        $oFiltroDes = new Filtro($oProdes, Filtro::CAMPO_TEXTO,4);
        $oFiltroProcod = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL,2);
        
        $this->addCampos($oEan,$oQt,$oProcod,$oProdes);
        $this->addFiltro($oFiltroProcod,$oFiltroDes);
    } 
    
}