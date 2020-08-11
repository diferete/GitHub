<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_ordensFabApontEtapasGeren extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $aForno = $oFornos->Persistencia->getArrayModel();
        
        $this->getTela()->setBGridResponsivo(false);
        $oOp = new CampoConsulta('Op','op');
        $oProduto = new CampoConsulta('Produto','prodes');
        $oForno = new CampoConsulta('Forno','fornodes');
        $oFornoCod = new CampoConsulta('','fornocod');
        $oTurno = new CampoConsulta('Turno','turnoSteel');
        $oDataEnt = new CampoConsulta('Data Ent','dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEnt = new CampoConsulta('Hora Ent','horaent_forno', CampoConsulta::TIPO_TIME);
        $oSituacao = new CampoConsulta('Situação','situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
        $oSituaca2 = new CampoConsulta('','situacao');
        
        $oUser = new CampoConsulta('Usuário','usernome');
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oSitFiltro = new Filtro($oSituaca2, Filtro::CAMPO_SELECT, 2,2,12,12);
        $oSitFiltro->addItemSelect('Processo', 'Processo');
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Finalizado', 'Finalizado');
        
        $oFornoChoice = new Filtro($oFornoCod, Filtro::CAMPO_SELECT,2,2,12,12);
        
        foreach ($aForno as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
        }
        
        $this->addFiltro($oOpFiltro,$oSitFiltro,$oFornoChoice);
        /**
         * analisa se temos o cookie para o forno
         */
        if(isset($_COOKIE['cookfornocod'])){
           $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
           $sForno = $_COOKIE['cookfornocod'];
        }
        
        /**
         * define o filtro inicial
         */
        $aInicial[]='situacao,Processo';
        $aInicial[]='fornocod,'.$sForno;
        $this->getTela()->setAParametros($aInicial);
        $this->getTela()->setBMostraFiltro(true);
       
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoAlterar(false);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Etapas',Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Apontar/Editar Etapas', 'STEEL_PCP_ordensFabApontEtapas', 'telaApontaEtapasNoGrid', '', true, '',false,'',false,'',false,true);
            
        $this->addDropdown($oDrop1);
        
        
        $this->addCampos($oOp,$oProduto,$oForno,$oTurno,$oDataEnt,$oHoraEnt,$oSituacao,$oUser);
       
    }
}