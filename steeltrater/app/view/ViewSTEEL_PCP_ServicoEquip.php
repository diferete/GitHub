<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_ServicoEquip extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oTratCod = new CampoConsulta('Trat','tratcod');
        $oTratDes = new CampoConsulta('TratDes','STEEL_PCP_Tratamentos.tratdes');
        $oFornoCod = new CampoConsulta('Forno','fornocod');
        $oFornoDes = new CampoConsulta('FornoDes','STEEL_PCP_Forno.fornodes');
        
        $oFiltroTrat = new Filtro($oTratDes, Filtro::CAMPO_TEXTO ,4,4,4,4);
        
        
        $this->addFiltro($oFiltroTrat);
        
        $this->addCampos($oTratCod,$oTratDes,$oFornoCod,$oFornoDes);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oTratCod = new Campo('Serviço','tratcod', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oTratCod->addValidacao(false, Validacao::TIPO_STRING);
        $oTratCod->setClasseBusca('STEEL_PCP_Tratamentos');
        $oTratCod->setSCampoRetorno('tratcod',$this->getTela()->getId());
        
        
        $oFornoCod = new Campo('Código do forno','fornocod', Campo::TIPO_BUSCADOBANCOPK,2);
        $oFornoCod->addValidacao(false, Validacao::TIPO_STRING);
        $oFornoCod->setClasseBusca('STEEL_PCP_Forno');
        $oFornoCod->setSCampoRetorno('fornocod',$this->getTela()->getId());
        
        $this->addCampos($oTratCod,$oFornoCod);
    }
}
