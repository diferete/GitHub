<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_ordensFabApontEtapasGeren extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $aForno = $oFornos->Persistencia->getArrayModel();

        $this->getTela()->setBGridResponsivo(false);
        $oOp = new CampoConsulta('Op', 'op');
        $oProduto = new CampoConsulta('Produto', 'prodes');
        $oForno = new CampoConsulta('Forno', 'fornodes');
        $oFornoCod = new CampoConsulta('', 'fornocod');
        $oTurno = new CampoConsulta('Turno', 'turnoSteel');
        $oDataEnt = new CampoConsulta('Data Ent', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEnt = new CampoConsulta('Hora Ent', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oSituacao = new CampoConsulta('Situação', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');

        $oSituaca2 = new CampoConsulta('', 'situacao');

        $oUser = new CampoConsulta('Usuário', 'usernome');

        $oProcessoAtivo = new CampoConsulta('Somente processo', 'processoativo');

        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oSitFiltro = new Filtro($oSituaca2, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oSitFiltro->addItemSelect('Processo', 'Processo');
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Finalizado', 'Finalizado');

        $oFornoChoice = new Filtro($oFornoCod, Filtro::CAMPO_SELECT, 2, 2, 12, 12);

        foreach ($aForno as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(), $oValueForno->getFornodes());
        }

        $oFiltroProcesso = new Filtro($oProcessoAtivo, Filtro::CAMPO_SELECT, 5, 5, 5, 5);
        $oFiltroProcesso->addItemSelect('SIM', 'Sim');
        $oFiltroProcesso->addItemSelect('NAO', 'Não');
        $oFiltroProcesso->addItemSelect('Todos', 'Todos');
        $oFiltroProcesso->setBInline(true);

        $this->addFiltro($oOpFiltro, $oSitFiltro, $oFornoChoice, $oFiltroProcesso);
        /**
         * analisa se temos o cookie para o forno
         */
        if (isset($_COOKIE['cookfornocod'])) {
            $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
            $sForno = $_COOKIE['cookfornocod'];
        }

        /**
         * define o filtro inicial
         */
        $aInicial[] = 'situacao,Processo';
        $aInicial[] = 'fornocod,' . $sForno;
        $aInicial[] = 'processoativo,SIM';
        $this->getTela()->setAParametros($aInicial);
        $this->getTela()->setBMostraFiltro(true);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoAlterar(false);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Etapas', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Apontar/Editar Etapas', 'STEEL_PCP_ordensFabApontEtapas', 'telaApontaEtapasNoGrid', '', true, '', false, '', false, '', false, true);

        $this->addDropdown($oDrop1);


        $this->addCampos($oOp, $oProduto, $oForno, $oTurno, $oDataEnt, $oHoraEnt, $oSituacao, $oUser, $oProcessoAtivo);
    }

    public function gridApontaEtapaGeren() {
        $oGridEnt = new Grid("");

        $oBotaoCarregarOps = new CampoConsulta('Carregar', 'carregarOps', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoCarregarOps->setSTitleAcao('Carregar dados para lançar!');
        $oBotaoCarregarOps->addAcao('STEEL_PCP_ordensFabApontEtapasGeren', 'carregaDadosOps', '', '');
        $oBotaoCarregarOps->setBHideTelaAcao(true);
        $oBotaoCarregarOps->setILargura(30);

        $oOpGridPes = new CampoConsulta('Op', 'op');
        $oProdutoGridPes = new CampoConsulta('Produto', 'prodes');
        $oFornoGridPes = new CampoConsulta('Forno', 'fornodes');

        $oTurnoGridPes = new CampoConsulta('Turno', 'turnoSteel');
        $oDataEntGridPes = new CampoConsulta('Data Ent', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEntGridPes = new CampoConsulta('Hora Ent', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oSituacaoGridPes = new CampoConsulta('Situação', 'situacao');
        $oSituacaoGridPes->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoGridPes->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoGridPes->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');

        $oGridEnt->addCampos($oBotaoCarregarOps, $oOpGridPes, $oProdutoGridPes, $oFornoGridPes, $oTurnoGridPes, $oDataEntGridPes, $oHoraEntGridPes, $oSituacaoGridPes);

        $aCampos = $oGridEnt->getArrayCampos();
        return $aCampos;
    }

}
