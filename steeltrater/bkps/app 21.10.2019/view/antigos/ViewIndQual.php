<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewIndQual extends View{
    public function __construct() {
        parent::__construct();
    }
    
    
    public function indicadorRelExp(){
         parent::criaTelaRelatorio();
        
        $this->setTituloTela('Indicador Expedição');
        $this->setBTela(true); 
        
        $oDataIni = new Campo('Data Inicial','dataini', Campo::TIPO_DATA,2);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');
       // $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim = new Campo('Data Final','datafim', Campo::TIPO_DATA,2);
       // $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim->setSValor(date('d/m/Y'));
        $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        
        $oXls = new Campo('Exportar para Excel','sollib',  Campo::TIPO_BOTAOSMALL,1);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoLib ='requestAjax("'.$this->getTela()->getId().'-form","IndQual","indicadorExpedicaoXls");';
        $oXls->getOBotao()->addAcao($sAcaoLib);
        
        $this->addCampos(array($oDataIni,$oDataFim),$oXls);
    }
    
    
    
}