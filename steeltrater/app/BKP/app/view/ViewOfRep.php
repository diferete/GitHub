<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewOfRep extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oOp = new CampoConsulta('Ordem Fab','op');
        $oCod = new CampoConsulta('Código','cod');
        $oProdes = new CampoConsulta('Descrição','prodes');
        $oQuant = new CampoConsulta('Quant','quant', CampoConsulta::TIPO_DECIMAL);
        $oData = new CampoConsulta('Data','data');
        $oSituaca = new CampoConsulta('Situação','situaca');
        $this->setBScrollInf(true);
        
        $this->addCampos($oOp,$oCod,$oProdes,$oQuant,$oData,$oSituaca);
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
    }
    
    
    
    
    
}
