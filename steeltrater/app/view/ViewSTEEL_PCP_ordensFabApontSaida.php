<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 25/07/2018
 */

class ViewSTEEL_PCP_ordensFabApontSaida extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $aForno = $oFornos->Persistencia->getArrayModel();


        $oBotaoFinalizar = new CampoConsulta('Apont.', 'finalizar', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setSTitleAcao('Finalizar apontamento!');
        $oBotaoFinalizar->addAcao('STEEL_PCP_ordensFabApontSaida', 'msgFinalizaOP', '', ''); //finalizaOP Controller
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(30);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        //-----------------------------------------------------------------------

        $oBotaoFinalizarOp = new CampoConsulta('---', 'finalizarOp', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOSUCCES);
        $oBotaoFinalizarOp->setBHideTelaAcao(true);
        $oBotaoFinalizarOp->setILargura(20);
        // $oBotaoFinalizar->setILargura(15);
        $oBotaoFinalizarOp->setSTitleAcao('Finalizar!');
        $oBotaoFinalizarOp->addAcao('STEEL_PCP_OrdensFabApontSaida', 'criaTelaModalApontaFinalizar', 'modalApontaFinalizarSemEtapa', '');
        $oBotaoFinalizarOp->setSTituloBotaoModal('--FINALIZAR--');
        $this->addModais($oBotaoFinalizarOp);

        //------------------------------------------------------------------------

        $oOp = new CampoConsulta('OP', 'op');
        $oProdes = new CampoConsulta('Produto', 'prodes');
        $oProdes->setILargura(300);
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oDtent = new CampoConsulta('Data entrada', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHentr = new CampoConsulta('Hora entrada', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oDtsaid = new CampoConsulta('Data saída', 'datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHsaida = new CampoConsulta('Hora saída', 'horasaida_forno', CampoConsulta::TIPO_TIME);
        $oForno = new CampoConsulta('', 'fornodes');
        $oFornoCod = new CampoConsulta('', 'fornocod');
        $oSituaca = new CampoConsulta('Situação', 'situacao');
        $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituaca->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $oSituaca2 = new CampoConsulta('', 'situacao');

        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oSitFiltro = new Filtro($oSituaca2, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oSitFiltro->addItemSelect('Processo', 'Processo');
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Finalizado', 'Finalizado');

        $oFornoChoice = new Filtro($oFornoCod, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFornoChoice->addItemSelect('--', '--');
        foreach ($aForno as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(), $oValueForno->getFornodes());
        }



        //mostra os filtros
        $this->getTela()->setBMostraFiltro(true);
        $this->getTela()->setIAltura(600);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oOpFiltro, $oSitFiltro, $oFornoChoice);

        /**
         * define o filtro inicial
         */
        $aInicial[0] = 'situacao,Processo';
        $this->getTela()->setAParametros($aInicial);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Ações', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Retornar Apontamento', 'STEEL_PCP_OrdensFabApontSaida', 'msgRetornaApontSaida', '', false, '', false, '', false, '', false, false);

        $this->addDropdown($oDrop1);

        $this->setBScrollInf(false);
        $this->addCampos($oBotaoFinalizarOp, $oOp, $oProdes, $oDtent, $oHentr, $oDtsaid, $oHsaida, $oFornoCod, $oForno, $oSituaca, $oSeq);

        //busca o forno padrao 
        $oUserForno = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        $oFornoUser = $oUserForno->pesqFornoUser();

        if (isset($_COOKIE['cookfornocod'])) {
            $sForno = $_COOKIE['cookfornocod'];
        } else {
            if (method_exists($oFornoUser, 'getFornocod')) {
                $sForno = $oFornoUser->getFornocod();
            }
        }


        $aParam1[] = 'situacao,Processo';
        $aParam1[] = 'fornocod,' . $sForno;
        $this->getTela()->setAParametros($aParam1);
    }

    //criaTelaModalApontaFinalizar
    public function criaTelaModalApontaFinalizar($oApontDados) {
        parent::criaModal();

        $this->setBTela(true);



        //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo', $_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();

        $oTurno = new campo('Turno final', 'turnoSteel', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oTurno->addItemSelect('Turno A', 'Turno A');
        $oTurno->addItemSelect('Turno B', 'Turno B');
        $oTurno->addItemSelect('Turno C', 'Turno C');
        $oTurno->addItemSelect('Turno D', 'Turno D');
        $oTurno->addItemSelect('Geral', 'Geral');
        $oTurno->setSValor($oOuserDados->getTurnoSteel());

        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oOp->setSValor($oApontDados->getOp());
        $oOp->setBCampoBloqueado(true);

        $oCodUser = new campo('CodUser', 'coduser', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oCodUser->setSValor($_SESSION['codUser']);
        $oCodUser->setBCampoBloqueado(true);
        //$oCodUser->setBOculto(true);

        $oUserNome = new campo('Usuário', 'usernome', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oUserNome->setSValor($_SESSION['nome']);
        $oUserNome->setBCampoBloqueado(true);

        $oLinha = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oDiv = new campo('* Verifique o turno de saída', 'div1', Campo::DIVISOR_VERMELHO, 12, 12, 12, 12);

        //botao inserir apontamento
        $oBtnInserir = new Campo('Finaliza etapa', '', Campo::TIPO_BOTAOSMALL_SUB, 5, 5, 5, 5);

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontSaida","finalizaOPTurnoSaida",'
                . '"' . $this->getTela()->getId() . ',,");';
        $oBtnInserir->getOBotao()->addAcao($sAcao);

        $this->addCampos(array($oOp, $oCodUser, $oUserNome), $oLinha, $oDiv, $oLinha, $oTurno, $oLinha, $oBtnInserir);
    }

}
