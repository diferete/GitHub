<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewTabVenda extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        $this->setaTiluloConsulta('Consulta de preços do sistema');
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oProcod = new CampoConsulta('Código','Produto.procod',  CampoConsulta::TIPO_LARGURA, 15);
        $oPreco = new CampoConsulta('Preço','preco', CampoConsulta::TIPO_MONEY);
        $oProdes = new CampoConsulta('Descrição','Produto.prodes', CampoConsulta::TIPO_LARGURA,20);
        $oRevisao = new CampoConsulta('Revisão','revisao', CampoConsulta::TIPO_TEXTO);
        
        $oFiltroDes = new Filtro($oProdes, Filtro::CAMPO_TEXTO,4);
        $oFiltroCod = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL,2);
        
        $this->addCampos($oProcod,$oProdes,$oPreco,$oRevisao);
        $this->addFiltro($oFiltroCod,$oFiltroDes);
        $this->setBScrollInf(true);
    }
}