<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPedRepIten extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oPdvnr = new CampoConsulta('Nr.Pedido','pdvnro');
        $oSeq = new CampoConsulta('Seq.','pdvproseq');
        $oCodigo = new CampoConsulta('Código','procod');
        $oDes = new CampoConsulta('Descrição','pdvprodes');
        $oQt = new CampoConsulta('Quantidade','pdvproqtdp', CampoConsulta::TIPO_DECIMAL);
        $oVlrUnit = new CampoConsulta('Vlr. Unit','pdvprovlta', CampoConsulta::TIPO_DECIMAL);
        $oTotal = new CampoConsulta('Total','total', CampoConsulta::TIPO_DECIMAL);
        $oTotalFat = new CampoConsulta('Total Faturado','totalfat', CampoConsulta::TIPO_DECIMAL);
        
        $this->addCampos($oPdvnr,$oSeq,$oCodigo,$oDes,$oQt,$oVlrUnit,$oTotal,$oTotalFat);
    }
}