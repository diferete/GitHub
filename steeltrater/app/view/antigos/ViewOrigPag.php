<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewOrigPag extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro Origem Financeira');
        
        $oOrigCod = new Campo('Código','origcod',  Campo::TIPO_TEXTO,1);
        $oOrigDes = new Campo('Descrição','origdes',  Campo::TIPO_TEXTO,4);
        
        $this->addCampos($oOrigCod,$oOrigDes);
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oOrigCod = new CampoConsulta('Código','origcod');
        $oOrigDes = new CampoConsulta('Descrição','origdes');
        
        $this->addCampos($oOrigCod,$oOrigDes);
        
        $oFiltroDes = new Filtro($oOrigDes, Filtro::CAMPO_TEXTO,4);
        
        $this->addFiltro($oFiltroDes);
    }
    
    
}
