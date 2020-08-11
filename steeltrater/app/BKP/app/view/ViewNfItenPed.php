<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewNfItenPed extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNf = new CampoConsulta('Nota Fiscal','nfsnfnro');
        $oNfCod = new CampoConsulta('Código','nfsitcod');
        $oDes = new CampoConsulta('Descrição','nfsitdes');
        $oQt = new CampoConsulta('Quantidade','nfsitqtd', CampoConsulta::TIPO_DECIMAL);
        $oDataEmi = new CampoConsulta('Emissão','nfsitdtemi', CampoConsulta::TIPO_DATA);
        $oPedido = new CampoConsulta('Pedido','nfsitpdvnr');
        $oNfSeq = new CampoConsulta('Seq.','nfsitseq');
        
        $this->addCampos($oNf,$oNfSeq,$oNfCod,$oDes,$oQt,$oDataEmi,$oPedido);
    }
}