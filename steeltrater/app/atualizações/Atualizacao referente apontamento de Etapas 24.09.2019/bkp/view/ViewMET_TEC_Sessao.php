<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Sessao extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        
        $oUsuCodigo = new CampoConsulta('Código Usuário','usucodigo');
        $oUsuNome = new CampoConsulta('Nome','usunome');
        $oSessao = new CampoConsulta('Sessao ID','usuidsessao');
        $oStatus = new CampoConsulta('Status','usustatus');
        $oDataHora = new CampoConsulta('Data','usuhora');
        $oLast = new CampoConsulta('Último acesso','usulastacesso');
        
        $oUsuFnome = new Filtro($oUsuNome, Filtro::CAMPO_TEXTO,3);
        $this->addFiltro($oUsuFnome);
       
        
        $this->addCampos($oUsuCodigo,$oUsuNome,$oSessao,$oStatus,$oDataHora,$oLast);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
    }
}