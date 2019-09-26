<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewAutPrecoItem extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
   
        
        $oId= new CampoConsulta('id', 'id',  CampoConsulta::TIPO_TEXTO);
        $oTipo = new CampoConsulta('Tipo', 'tipo', CampoConsulta::TIPO_TEXTO);
        $oNr = new CampoConsulta('Nr','nr', CampoConsulta::TIPO_TEXTO);
        $oCodigo = new CampoConsulta('Codigo','Codigo', CampoConsulta::TIPO_TEXTO);
        $oDescricao = new CampoConsulta('Descrição','descricao',  CampoConsulta::TIPO_TEXTO);
        $oPrecoTab = new CampoConsulta('Preço Tabela','precotab', CampoConsulta::TIPO_MONEY);
        $oUnitario = new CampoConsulta('Unitário', 'unitario', CampoConsulta::TIPO_MONEY);
        $oTotalDesconto = new CampoConsulta('Total de Desconto', 'totaldesconto', CampoConsulta::TIPO_DECIMAL);
        $oPrecoKg = new CampoConsulta('Preço por Kg','precoKg', CampoConsulta::TIPO_MONEY);
        $oNome = new CampoConsulta('Nome', 'nome', CampoConsulta::TIPO_TEXTO);
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_TEXTO);
       
        $this->addCampos($oId,$oTipo,$oNr,$oCodigo,
                $oDescricao,$oPrecoTab,$oUnitario,$oTotalDesconto,$oPrecoKg,$oNome,$oData);
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
    }
}