<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewEmpresa extends View{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpresa = new CampoConsulta('Cnpj','empcnpj');
        $oEmpDes = new CampoConsulta('Empresa', 'emprazao');
        
        $this->addCampos($oEmpresa,$oEmpDes);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de empresas e filiais');
        
        $oEmpresa = new Campo('Cnpj','empcnpj',  Campo::TIPO_TEXTO,2);
        $oEmpDes = new Campo('Empresa', 'emprazao',  Campo::TIPO_TEXTO,5);
        
        $this->addCampos($oEmpresa,$oEmpDes);
    }
}
