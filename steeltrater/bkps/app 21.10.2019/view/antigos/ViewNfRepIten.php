<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewNfRepIten extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNfsnfnro= new CampoConsulta('Nota Fiscal','nfsnfnro');
        $oNfSitcod = new CampoConsulta('Código','nfsitcod');
        $oNfSitDes = new CampoConsulta('Descrição','nfsitdes');
        $oNfSitQtd = new CampoConsulta('Quant.','nfsitqtd',CampoConsulta::TIPO_DECIMAL); 
        $oNfSitQtd->setILargura(100);
        $oVlrUnit = new CampoConsulta('Vlr. Unit','nfsitvlrun',CampoConsulta::TIPO_MONEY);
        $oTotal = new CampoConsulta('Total','nfsitvlrto', CampoConsulta::TIPO_MONEY);
        $oPedido = new CampoConsulta('Pedido','nfsitpdvnr');
        $oNfSeq = new CampoConsulta('Seq.','nfsitseq');
        $oNfSeq->setILargura(30);
        
        $this->addCampos($oNfsnfnro,$oNfSeq,$oNfSitcod,$oNfSitDes,$oNfSitQtd,$oVlrUnit,$oTotal,$oPedido);
    }
   
}