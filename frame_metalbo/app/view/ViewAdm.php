<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */TESTE
 */

class ViewAdm extends View {
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oVlrLiquido = new CampoConsulta('Vlr. Líquido','vlrliquido', CampoConsulta::TIPO_MONEY);
        $oVlrIpi =  new CampoConsulta('Vlr. Ipi','vlripi', CampoConsulta::TIPO_MONEY);
        $oVlrExp = new CampoConsulta('Exportação', 'exportacao', CampoConsulta::TIPO_MONEY);
        $oSucata = new CampoConsulta('Sucata', 'sucata', CampoConsulta::TIPO_MONEY);
        $oDev = new CampoConsulta('Devolução', 'devolucao', CampoConsulta::TIPO_MONEY);
        $oPeso = new CampoConsulta('Peso', 'pesoliquido', CampoConsulta::TIPO_MONEY);
        $oMediaSipi = new CampoConsulta('Média S/Ipi', 'mediaSipi', CampoConsulta::TIPO_MONEY);
        $oMediaCipi = new CampoConsulta('Média C/Ipi', 'mediaCipi', CampoConsulta::TIPO_MONEY);
        
        
        
         $oDataFiltro = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE,2);
         $oDataFiltro->addFiltroValor(Util::getPrimeiroDiaMes());
         $oDataFiltro->addFiltroValor(Util::getDataAtual());
      
        
      
         $this->addFiltro($oDataFiltro);
         
         $this->setUsaDropdown(true);
         
         $oDrop1 = new Dropdown('Fat Mobile', Dropdown::TIPO_PADRAO);
         $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG).'Aponta pagamento','Adm', 'getFaturamento', '',true);
        
         $this->addDropdown($oDrop1);
         
         $this->addCampos($oData,$oVlrLiquido,$oVlrIpi,$oVlrExp,$oSucata,$oDev,$oPeso,$oMediaSipi,$oMediaCipi);
         
         $this->setUsaAcaoAlterar(false);
         $this->setUsaAcaoExcluir(false);
         $this->setUsaAcaoIncluir(false);
    }
    
    
    
}
