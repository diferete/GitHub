<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewRepcod extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->setaTiluloConsulta('Representantes Cadastrados');
        
        
        $oRepcod=new CampoConsulta('Código Representante', 'repcod');
        $oRepdes=new CampoConsulta('Representante', 'repdes');
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        
        $oFiltroCpgCod = new Filtro($oRepcod, Filtro::CAMPO_INTEIRO,2);
        $oFiltroCpgDes = new Filtro($oRepdes, Filtro::CAMPO_TEXTO,3);
        
        $this->addFiltro($oFiltroCpgCod,$oFiltroCpgDes);
        $this->addCampos($oRepcod,$oRepdes);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de representantes');
        
         $oRepcod=new Campo('Código', 'repcod',  Campo::TIPO_TEXTO,2);
         $oRepdes=new Campo('Representante', 'repdes',Campo::TIPO_TEXTO,6);
         $this->addCampos($oRepcod,$oRepdes);
    }
    
}