<?php

/*
 * @author Avanei Martendal
 * @Since 06/09/2019
 */

class ViewSTEEL_PCP_ordensFabApontEtapas extends View {

    public function criaTela() {
        parent::criaTela();


        //desativa botoes
        $this->setBTela(true);
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);

        //seta id 
        $this->getTela()->setSId('formEtapasSteel');

        //alimenta fornos para o início do processo

        $aDados = $this->getAParametrosExtras();
        $aFornosRadio = $aDados[1];
        $aOps = $aDados[2];

        //Monta a tela inicial conforme as ops selecionadas conforme o forno selecionado
        $oOpsForno = new FieldSet('Ops em aberto por forno');
        $oOpsForno->setOculto(true);
        $oFornoChoiceGrid = new campo('', 'fornoComboGridPes', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoiceGrid->addItemSelect($oValueForno->getFornocod(), $oValueForno->getFornodes());
        }
        //grid das ops
        $oGridOpsPes = new campo('Ops em processo', 'gridEnt', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridOpsPes->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
        $oGridOpsPes->getOGrid()->setIAltura(50);

        $oBotaoCarregarOps = new CampoConsulta('Carregar', 'carregarOps', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoCarregarOps->setSTitleAcao('Carregar dados para lançar!');
        $oBotaoCarregarOps->addAcao('STEEL_PCP_ordensFabApontEtapasGeren', 'carregaDadosOps', '', '');
        $oBotaoCarregarOps->setBHideTelaAcao(true);
        $oBotaoCarregarOps->setILargura(30);


        $oOpGridPes = new CampoConsulta('Op', 'op');
        $oProdutoGridPes = new CampoConsulta('Produto', 'prodes');
        $oProdutoGridPes->setILargura(500);
        $oFornoGridPes = new CampoConsulta('Forno', 'fornodes');

        $oTurnoGridPes = new CampoConsulta('Turno', 'turnoSteel');
        $oDataEntGridPes = new CampoConsulta('Data Ent', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEntGridPes = new CampoConsulta('Hora Ent', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oSituacaoGridPes = new CampoConsulta('Situação', 'situacao');
        $oSituacaoGridPes->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoGridPes->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoGridPes->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');

        $oGridOpsPes->addCampos($oBotaoCarregarOps, $oOpGridPes, $oProdutoGridPes, $oFornoGridPes, $oTurnoGridPes, $oDataEntGridPes, $oHoraEntGridPes, $oSituacaoGridPes);
        $oGridOpsPes->setSController('STEEL_PCP_OrdensFabItens');
        //$oOpGridPes->addParam('op', '0');
        $oGridOpsPes->getOGrid()->setIAltura(170);
        $oGridOpsPes->getOGrid()->setBGridResponsivo(false);


        $oDivApontaOp = new Campo('', 'apontaInicia', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oDivApontaOp->setApenasTela(true);

        //botao atualizar
        $oBtnAtualizarGridPes = new Campo('Atualizar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBtnAtualizarGridPes->getOBotao()->setId('btn_atualizarGridPes');
        $sAcaoAtualizarGridPes = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapasGeren",'
                . '"getDadosGrid","' . $oGridOpsPes->getId() . '","gridApontaEtapaGeren");';
        $oBtnAtualizarGridPes->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $oBtnAtualizarGridPes->getOBotao()->addAcao($sAcaoAtualizarGridPes);



        $oOpsForno->addCampos(array($oFornoChoiceGrid), $oBtnAtualizarGridPes, $oDivApontaOp, $oGridOpsPes);


        //VERIFICA SE EXISTE ESSA 
        if ($aOps['op'] !== '') {
            $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOp->Persistencia->adicionaFiltro('op', $aOps['op']);
            $oDadosOp = $oOp->Persistencia->consultarWhere();
        }

        //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo', $_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();



        $oTurno = new campo('Turno inicial', 'turnoSteel', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oTurno->addItemSelect('Turno A', 'Turno A');
        $oTurno->addItemSelect('Turno B', 'Turno B');
        $oTurno->addItemSelect('Turno C', 'Turno C');
        $oTurno->addItemSelect('Turno D', 'Turno D');
        $oTurno->addItemSelect('Geral', 'Geral');
        $oTurno->setSValor($oOuserDados->getTurnoSteel());

        //campo dos fornos para somente carregar
        $oFornoCod = new campo('', 'fornocod', Campo::TIPO_TEXTO, 1);
        $oFornoCod->setBOculto(true);
        $oFornoDes = new Campo('', 'fornodes', Campo::TIPO_TEXTO, 2);
        $oFornoDes->setBOculto(true);

        //-----------------------combo dos fornos---------------------------
        $oFornoChoice = new campo('Forno / Trefila *INICIAL', 'fornoCombo', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(), $oValueForno->getFornodes());
        }
        $sCombo = 'var textCombo = $("#' . $oFornoChoice->getId() . ' option:selected").text(); '
                . 'var valueCombo = $("#' . $oFornoChoice->getId() . '").val(); '
                . '$("#' . $oFornoCod->getId() . '").val(valueCombo); $("#' . $oFornoDes->getId() . '").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE, $sCombo);
        //-----------------------------------------------------------------
        //EVENTO QUE AO SELECIONAR O FORNO AO PESQUISAR MUDA NO FORNO COMBO E NOS CAMPOS TEXTO
        $sComboGrid = 'var textComboGrid = $("#' . $oFornoChoiceGrid->getId() . ' option:selected").text(); '
                . 'var valueComboGrid = $("#' . $oFornoChoiceGrid->getId() . '").val(); '
                . '$("#' . $oFornoCod->getId() . '").val(valueComboGrid); '
                . '$("#' . $oFornoDes->getId() . '").val(textComboGrid); '
                . '$("#btn_atualizarGridPes").click(); '
                . '$("[name=fornoCombo]").val(valueComboGrid).trigger("change");';
        $oFornoChoiceGrid->addEvento(Campo::EVENTO_CHANGE, $sComboGrid);
        //verifica primeiro se há cookie setado
        if (isset($_COOKIE['cookfornocod'])) {
            $oFornoCod->setSValor($_COOKIE['cookfornocod']);
            //seta valor padrão
            $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
            $oFornoChoiceGrid->setSValor($_COOKIE['cookfornocod']);
        } else {
            $oFornoArr = $aDados[0];

            if (method_exists($oFornoArr, 'getFornocod')) {
                $oFornoCod->setSValor($oFornoArr->getFornocod());
                $oFornoChoice->setSValor($oFornoArr->getFornocod());
                $oFornoChoiceGrid->setSValor($_COOKIE['cookfornocod']);
            }
        }

        $oFornoDes->setBCampoBloqueado(true);
        $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
        if (isset($_COOKIE['cookfornodes'])) {
            $oFornoDes->setSValor($_COOKIE['cookfornodes']);
        }/* else{
          $oFornoArr = $aDados[0];
          if (method_exists($oFornoArr,'getFornodes')){
          $oFornoDes->setSValor($oFornoArr->getFornodes());
          }} */
        //--------------------------------------------------------------------    

        $oCodUser = new campo('coduser', 'coduser', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oCodUser->setSValor($_SESSION['codUser']);
        $oCodUser->setBCampoBloqueado(true);
        $oCodUser->setBOculto(true);

        $oUserNome = new campo('user', 'usernome', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oUserNome->setSValor($_SESSION['nome']);
        $oUserNome->setBCampoBloqueado(true);
        $oUserNome->setBOculto(true);

        $oCorrida = new campo('Corrida', 'corrida', Campo::TIPO_TEXTO, 3, 3, 3, 3);
        $oCorrida->setSCorFundo(Campo::FUNDO_VERDE);
        // $oCorrida->addEvento(Campo::EVENTO_ENTER, 'if(event.which == 13){event.preventDefault();}');
        //if(event.which == 13){event.preventDefault();}

        /* $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2, 2, 6, 6);
          $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
          $oOp->addValidacao(false, Validacao::TIPO_STRING,'','1','100'); */
        $oOp = new Campo('OP', 'op', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 6, 6);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->addValidacao(false, Validacao::TIPO_STRING, '', '1', '100');
        $oOp->setClasseBusca('STEEL_PCP_ordensFabListaPesq');
        $oOp->setSCampoRetorno('op', $this->getTela()->getId());
        $oOp->setBFocus(true);

        $oCorrida->addEvento(Campo::EVENTO_ENTER, 'if(event.which == 13){event.preventDefault();};$("#' . $oOp->getId() . '" ).focus();$("#' . $oOp->getId() . '" ).val("");');


        if (isset($aOps['op'])) {
            $oOp->setSValor($aOps['op']);
        }


        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        //botao inserir apontamento
        $oBtnInserir = new Campo('Iniciar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
//----------------------------------------------------------------------------------------------------------
        //grid para carregar inicio do processo
        $oGridInicioProcesso = new Campo('Início do processo', 'apontInicio', Campo::TIPO_GRIDVIEW, 12, 12, 12, 12);
        $oGridInicioProcesso->setSTituloGridPainel('Início do processo');
        $oGridInicioProcesso->setSCorTituloGridPainel(Campo::TITULO_DANGER);
        $oGridInicioProcesso->addCabGridView('Excluir');
        $oGridInicioProcesso->addCabGridView('Op');
        $oGridInicioProcesso->addCabGridView('Produto');
        $oGridInicioProcesso->addCabGridView('Forno/Trefila');
        $oGridInicioProcesso->addCabGridView('Turno de Abertura');
        $oGridInicioProcesso->addCabGridView('Data Ent');
        $oGridInicioProcesso->addCabGridView('Hora Ent');
        $oGridInicioProcesso->addCabGridView('Situação');
        $oGridInicioProcesso->addCabGridView('Usuário');
        $oGridInicioProcesso->addCabGridView('Corrida');

//----------------------------------------------------------------------------------------------------------
        $oGridEnt = new campo('Etapas do processo', 'gridEnt', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridEnt->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());

        $oOpGrid = new CampoConsulta('Op', 'op');
        //botao que inicia um processo
        $oBotaoStart = new CampoConsulta('Inciar etapa', 'iniciarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOSUCCES);
        $oBotaoStart->setBHideTelaAcao(true);
        $oBotaoStart->setILargura(20);
        //$oBotaoStart->setILargura(15);
        $oBotaoStart->setSTitleAcao('Inicia etapa!');
        $oBotaoStart->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaIniciar', 'modalApontaIniciar', 'formEtapasSteel-form');
        $oBotaoStart->setSTituloBotaoModal('INICIAR');
        $oGridEnt->getOGrid()->addModal($oBotaoStart);

        //botao que finalizar um processo
        $oBotaoFinalizar = new CampoConsulta('Finalizar etapa', 'finalizarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOPRIMARY);
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(20);
        // $oBotaoFinalizar->setILargura(15);
        $oBotaoFinalizar->setSTitleAcao('Finaliza etapa!');
        $oBotaoFinalizar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaFinalizar', 'modalApontaFinalizar', 'formEtapasSteel-form');
        $oBotaoFinalizar->setSTituloBotaoModal('FINALIZAR');
        $oGridEnt->getOGrid()->addModal($oBotaoFinalizar);

        //botao que retorna um processo
        $oBotaoRetornar = new CampoConsulta('Retornar etapa', 'retornarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAODANGER);
        $oBotaoRetornar->setBHideTelaAcao(true);
        // $oBotaoRetornar->setILargura(15);
        $oBotaoRetornar->setSTitleAcao('Retorna apontamento!');
        $oBotaoRetornar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'retornaApontamento', '', '');
        $oBotaoRetornar->setSTituloBotaoModal('RETORNAR');
        $oBotaoRetornar->setILargura(20);
        $oGridEnt->getOGrid()->addModal($oBotaoRetornar);



        $oReceitaSeq = new CampoConsulta('Etapa', 'receita_seq');
        $oTratamento = new CampoConsulta('Tratamento', 'STEEL_PCP_Tratamentos.tratdes');
        $oTratamento->setILargura(220);
        $oFornodesConsulta = new CampoConsulta('Forno/Trefila', 'fornodes');
        $oTurnoEntrada = new CampoConsulta('Turno.Entrada', 'turnoSteel');
        $oDataEntConsulta = new CampoConsulta('Data Ent.', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEntConsulta = new CampoConsulta('Hora Ent.', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oTurnoSaida = new CampoConsulta('Turno.Saída', 'turnoSteelSaida');
        $oDataSaidaConsulta = new CampoConsulta('Data Saída', 'datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHoraSaidaConsulta = new CampoConsulta('Hora Saída', 'horasaida_forno', CampoConsulta::TIPO_TIME);

        $oSituacaoConsulta = new CampoConsulta('Situação', 'situacao');
        $oSituacaoConsulta->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoConsulta->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoConsulta->setBComparacaoColuna(true);
        $oSituacaoConsulta->setILargura(11);

        $oUserEntConsulta = new campoconsulta('Usuário Ent.', 'usernome');
        $oUserSaidaConsulta = new campoconsulta('Usuário Saída', 'usernomesaida');

        $oDiamMin = new CampoConsulta('DiamMin', 'diamMin', CampoConsulta::TIPO_DECIMAL);
        $oDiamMax = new CampoConsulta('DiamMax', 'diamMax', CampoConsulta::TIPO_DECIMAL);

        $oGridEnt->addCampos($oBotaoStart, $oBotaoFinalizar, $oBotaoRetornar, $oOpGrid, $oReceitaSeq, $oTratamento, $oSituacaoConsulta, $oFornodesConsulta, $oTurnoEntrada, $oDataEntConsulta, $oHoraEntConsulta, $oUserEntConsulta, $oTurnoSaida, $oDataSaidaConsulta, $oHoraSaidaConsulta, $oUserSaidaConsulta, $oDiamMin, $oDiamMax);
        $oGridEnt->setSController('STEEL_PCP_OrdensFabItens');
        $oGridEnt->addParam('op', '0');
        $oGridEnt->getOGrid()->setIAltura(170);
        $oGridEnt->getOGrid()->setBGridResponsivo(false);

        //atualizar
        //botao atualizar
        $oBtnAtualizar = new Campo('Atualizar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBtnAtualizar->getOBotao()->setId('btn_atualizarApontEtapaSteel');
        $sAcaoAtualizar = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapas",'
                . '"atualizaApontEnt","' . $oGridInicioProcesso->getId() . ',' . $oBtnAtualizar->getId() . '","consultaApontGrid");'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFabItens",'
                . '"getDadosGrid","' . $oGridEnt->getId() . '","gridApontaEtapa");';
        $oBtnAtualizar->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $oBtnAtualizar->getOBotao()->addAcao($sAcaoAtualizar);

        //redefine apontamento 
        $oLabelCorrida = new Campo('*Atenção verifique a corrida do seu lançamento se OP for Fio Máquina', 'labelCorrida'
                , Campo::TIPO_LABEL, 5, 5, 5, 5);
        $oLabelCorrida->setApenasTela(true);




        /**
         * Método para inserir apontamento
         */
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEnt","inserirApontEtapa",'
                . '"' . $this->getTela()->getId() . ',' . $oGridInicioProcesso->getId() . ',' . $oOp->getId() . ','
                . '' . $oFornoChoice->getId() . ',' . $oFornoCod->getId() . ','
                . '' . $oFornoDes->getId() . ',' . $oTurno->getId() . ',' . $oBtnAtualizar->getId() . ',' . $oCorrida->getId() . '");';
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $sAcaoFinalizar = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapas","msgFinalizaOPgeral",'
                . '"' . $this->getTela()->getId() . ',' . $oGridInicioProcesso->getId() . ',' . $oOp->getId() . ','
                . '' . $oFornoChoice->getId() . ',' . $oFornoCod->getId() . ','
                . '' . $oFornoDes->getId() . ',' . $oTurno->getId() . ',' . $oBtnAtualizar->getId() . '");';
        $oBotaoFinalizarGeral = new Campo('Finalizar', 'btn_finalizargeralApontaEtapa', Campo::TIPO_BOTAOSIMPLES, 2, 2, 2, 2);
        $oBotaoFinalizarGeral->getOBotao()->setId('btn_finalizargeralApontaEtapa');
        $oBotaoFinalizarGeral->getOBotao()->addAcao($sAcaoFinalizar);


        //msgRetornaApontSaida
        $sAcaoReabrirGeral = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapas","msgRetornaApontSaida",'
                . '"' . $this->getTela()->getId() . ',' . $oGridInicioProcesso->getId() . ',' . $oOp->getId() . ','
                . '' . $oFornoChoice->getId() . ',' . $oFornoCod->getId() . ','
                . '' . $oFornoDes->getId() . ',' . $oTurno->getId() . ',' . $oBtnAtualizar->getId() . '");';
        $oBotaoReabrirGeral = new Campo('Reabrir OP', '', Campo::TIPO_BOTAOSIMPLES, 2, 2, 2, 2);
        $oBotaoReabrirGeral->getOBotao()->setSStyleBotao(Botao::TIPO_WARNING);
        $oBotaoReabrirGeral->getOBotao()->addAcao($sAcaoReabrirGeral);

        //turno para fechamento geral
        $oTurnoFinal = new campo('Turno final', 'turnoSteelFinal', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oTurnoFinal->addItemSelect('Turno A', 'Turno A');
        $oTurnoFinal->addItemSelect('Turno B', 'Turno B');
        $oTurnoFinal->addItemSelect('Turno C', 'Turno C');
        $oTurnoFinal->addItemSelect('Turno D', 'Turno D');
        $oTurnoFinal->addItemSelect('Geral', 'Geral');
        $oTurnoFinal->setSValor($oOuserDados->getTurnoSteel());

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);

        /* ----------------------------------------------------------------------------- */

        $this->getTela()->setSAcaoShow('requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapasGeren",'
                . '"acaoInicial","");');


        if (isset($aOps['op'])) {
            $this->getTela()->setSAcaoShow($sAcaoAtualizar);
        }
        //se tipo da op igual fio máquina adiciona campos referente ao fio máquina
        if ($oDadosOp->getTipoOrdem() == 'F') {
            $oCorrida->setBFocus(true);
            $this->addCampos($oOpsForno, $oDivApontaOp, array($oTurno, $oFornoChoice, $oCorrida, $oOp, $oBtnInserir), $oBtnAtualizar, $oLabelCorrida, $oGridInicioProcesso, $oGridEnt, /* $oLinha1,$oTurnoFinal, */ $oLinha1, $oBotaoFinalizarGeral, /* $oBotaoReabrirGeral, */ array($oCodUser, $oUserNome), array($oFornoCod, $oFornoDes));
        } else {
            if ($oDadosOp->getTipoOrdem() == 'P') {
                $oOp->setBFocus(true);
                $this->addCampos($oOpsForno, $oDivApontaOp, array($oTurno, $oFornoChoice, $oOp, $oBtnInserir), $oBtnAtualizar, $oLabelCorrida, $oGridInicioProcesso, $oGridEnt, /* $oLinha1,$oTurnoFinal, */ $oLinha1, $oBotaoFinalizarGeral, /* $oBotaoReabrirGeral, */ array($oCodUser, $oUserNome), array($oFornoCod, $oFornoDes));
            } else {
                $oCorrida->setBFocus(true);
                $this->addCampos($oOpsForno, $oDivApontaOp, array($oTurno, $oFornoChoice, $oCorrida, $oOp, $oBtnInserir), $oBtnAtualizar, $oLabelCorrida, $oGridInicioProcesso, $oGridEnt, /* $oLinha1,$oTurnoFinal, */ $oLinha1, $oBotaoFinalizarGeral, /* $oBotaoReabrirGeral, */ array($oCodUser, $oUserNome), array($oFornoCod, $oFornoDes));
            }
        }
    }

    public function criaModalApontaIniciar($aForno, $IdGrid, $sModel, $aCamposTela) {
        parent::criaModal();

        $aFornosRadio = $aForno[1];

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        //busca forno do processo
        $oFornoServico = Fabrica::FabricarController('STEEL_PCP_ServicoEquip');
        $oFornoServico->Persistencia->adicionaFiltro('tratcod', $oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
        $aFornosServico = $oFornoServico->Persistencia->getArrayModel();

        //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo', $_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();

        //busca dados do lancamento
        $oApontOpMaster = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        $oApontOpMaster->Persistencia->adicionaFiltro('op', $oDados->getOp());
        $oApontOpMasterDados = $oApontOpMaster->Persistencia->consultarWhere();

        //carrega dados op 
        $oApontOp = Fabrica::FabricarController('STEEL_PCP_ordensFab');
        $oApontOp->Persistencia->adicionaFiltro('op', $oDados->getOp());
        $oApontOpDados = $oApontOp->Persistencia->consultarWhere();

        $oTurno = new campo('Turno inicial', 'turnoSteel', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oTurno->addItemSelect('Turno A', 'Turno A');
        $oTurno->addItemSelect('Turno B', 'Turno B');
        $oTurno->addItemSelect('Turno C', 'Turno C');
        $oTurno->addItemSelect('Turno D', 'Turno D');
        $oTurno->addItemSelect('Geral', 'Geral');
        //if($oApontOpDados->getTipoOrdem()!=='F'){
        //$oTurno->setSValor($oApontOpMasterDados->getTurnoSteel());
        $oTurno->setSValor($aCamposTela['turnoSteel']);
        // }else{
        //$aCamposTela['turnoSteel']
        //     $oTurno->setSValor($oOuserDados->getTurnoSteel());
        // $oTurno->setSValor($aCamposTela['turnoSteel']);
        // }

        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);

        $oEtapa = new Campo('Etapa', 'opseq', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oEtapa->setSValor($oDados->getOpseq());
        $oEtapa->setBCampoBloqueado(true);

        $oCodEtapa = new Campo('CódTrat', 'tratcod', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oCodEtapa->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
        $oCodEtapa->setBCampoBloqueado(true);

        $oTratDes = new campo('Tratamento', 'tratdes', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oTratDes->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratdes());
        $oTratDes->setBCampoBloqueado(true);

        //campo dos fornos para somente carregar
        $oFornoCod = new campo('', 'fornocod', Campo::TIPO_TEXTO, 1);
        $oFornoCod->setBOculto(true);

        $oFornoDes = new Campo('', 'fornodes', Campo::TIPO_TEXTO, 2);
        $oFornoDes->setBOculto(true);


        //-----------------------combo dos fornos---------------------------
        $oFornoChoice = new campo('Forno / Trefila inicial', 'fornoCombo', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        foreach ($aFornosServico as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(), $oValueForno->getSTEEL_PCP_Forno()->getFornodes());
            if ($keyForno == 0) {
                //busca forno/trefina padrão se está presente
                //verifica se o forno do cadastro está presente entre os fornos do serviço
                if (isset($_COOKIE['cookfornocod'])) {
                    $oFornoServicoBusca = Fabrica::FabricarController('STEEL_PCP_ServicoEquip');
                    $oFornoServicoBusca->Persistencia->adicionaFiltro('tratcod', $oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
                    $oFornoServicoBusca->Persistencia->adicionaFiltro('fornocod', $_COOKIE['cookfornocod']);
                    $iCountBusca = $oFornoServicoBusca->Persistencia->getCount();
                    if ($iCountBusca > 0) {
                        $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
                        $oFornoCod->setSValor($_COOKIE['cookfornocod']);
                        $oFornoDes->setSvalor($_COOKIE['cookfornodes']);
                    } else {
                        $oFornoChoice->setSValor($oValueForno->getFornocod());
                        $oFornoCod->setSValor($oValueForno->getFornocod());
                        $oFornoDes->setSvalor($oValueForno->getSTEEL_PCP_Forno()->getFornodes());
                    }
                } else {
                    $oFornoChoice->setSValor($oValueForno->getFornocod());
                    $oFornoCod->setSValor($oValueForno->getFornocod());
                    $oFornoDes->setSvalor($oValueForno->getSTEEL_PCP_Forno()->getFornodes());
                }
            }
        }
        $sCombo = 'var textCombo = $("#' . $oFornoChoice->getId() . ' option:selected").text(); '
                . 'var valueCombo = $("#' . $oFornoChoice->getId() . '").val(); '
                . '$("#' . $oFornoCod->getId() . '").val(valueCombo); $("#' . $oFornoDes->getId() . '").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE, $sCombo);
        //-----------------------------------------------------------------


        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');


        //--------------------------------------------------------------------   
        if ($sModel == 'modalApontaIniciarGeren') {
            $oDataEnt = new Campo('Data Ent.', 'dataent_forno', Campo::TIPO_DATA, 3);
            $oDataEnt->setSValor($sData);
            $oDataEnt->addValidacao(false, Validacao::TIPO_STRING);
            $oHoraEnt = new Campo('Hora Ent.', 'horaent_forno', Campo::TIPO_TEXTO, 2);
            $oHoraEnt->setSValor($sHora);
            $oHoraEnt->addValidacao(false, Validacao::TIPO_STRING);
            //user entrada
            $oUserEntcodigo = new Campo('Cod.Usuário Entrada', 'coduser', Campo::TIPO_BUSCADOBANCOPK, 3);
            $oUserEntcodigo->setSValor($_SESSION['codUser']);
            $oUserEntcodigo->addValidacao(false, Validacao::TIPO_STRING);

            //campo descrição do usuário
            $oUserEntdes = new Campo('Descrição', 'usernome', Campo::TIPO_BUSCADOBANCO, 4);
            $oUserEntdes->setSIdPk($oUserEntcodigo->getId());
            $oUserEntdes->setClasseBusca('MET_TEC_Usuario');
            $oUserEntdes->addCampoBusca('usucodigo', '', '');
            $oUserEntdes->addCampoBusca('usunome', '', '');
            $oUserEntdes->setSIdTela($this->getTela()->getId());
            $oUserEntdes->setSValor($_SESSION['nome']);
            $oUserEntdes->addValidacao(false, Validacao::TIPO_STRING);

            //declarar o campo descrição
            $oUserEntcodigo->setClasseBusca('MET_TEC_Usuario');
            $oUserEntcodigo->setSCampoRetorno('usucodigo', $this->getTela()->getId());
            $oUserEntcodigo->addCampoBusca('usunome', $oUserEntdes->getId(), $this->getTela()->getId());
        } else {
            $oDataEnt = new Campo('Data Ent.', 'dataent_forno', Campo::TIPO_TEXTO, 2);
            $oDataEnt->setSValor($sData);
            $oDataEnt->addValidacao(false, Validacao::TIPO_STRING);
            $oHoraEnt = new Campo('Hora Ent.', 'horaent_forno', Campo::TIPO_TEXTO, 2);
            $oHoraEnt->setSValor($sHora);
            $oHoraEnt->addValidacao(false, Validacao::TIPO_STRING);
            $oDataEnt->setBCampoBloqueado(true);
            $oHoraEnt->setBCampoBloqueado(true);

            $oCodUser = new campo('CodUser', 'coduser', Campo::TIPO_TEXTO, 1, 1, 1, 1);
            $oCodUser->setSValor($_SESSION['codUser']);
            $oCodUser->setBCampoBloqueado(true);
            $oCodUser->setBOculto(true);

            $oUserNome = new campo('Usuário', 'usernome', Campo::TIPO_TEXTO, 2, 2, 2, 2);
            $oUserNome->setSValor($_SESSION['nome']);
            $oUserNome->setBCampoBloqueado(true);
        }
        $oLinha = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);

        //botao inserir apontamento
        $oBtnInserir = new Campo('Apontar Etapa', '', Campo::TIPO_BOTAOSMALL_SUB, 5, 5, 5, 5);

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapas","ApontEtapa",'
                . '"' . $this->getTela()->getId() . ',' . $IdGrid . ',");';
        $oBtnInserir->getOBotao()->addAcao($sAcao);

        if ($sModel == 'modalApontaIniciarGeren') {
            $this->addCampos(array($oOp, $oEtapa, $oCodEtapa, $oTratDes), $oLinha, array($oFornoChoice, $oTurno, $oDataEnt, $oHoraEnt), $oLinha, array($oUserEntcodigo, $oUserEntdes), $oBtnInserir, array($oFornoCod, $oFornoDes));
        } else {
            $this->addCampos(array($oOp, $oEtapa, $oCodEtapa, $oTratDes, $oUserNome), $oLinha, array($oFornoChoice, $oTurno, $oDataEnt, $oHoraEnt), $oBtnInserir, array($oFornoCod, $oFornoDes, $oCodUser));
        }
    }

    //criaTelaModalApontaFinalizar
    public function criaTelaModalApontaFinalizar($aForno, $IdGrid, $sModel, $aCamposTela) {
        parent::criaModal();

        $aFornosRadio = $aForno[1];

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        //busca os dados do usuário
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo', $_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();


        $oTurno = new campo('Turno final', 'turnoSteelSaida', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oTurno->addItemSelect('Turno A', 'Turno A');
        $oTurno->addItemSelect('Turno B', 'Turno B');
        $oTurno->addItemSelect('Turno C', 'Turno C');
        $oTurno->addItemSelect('Turno D', 'Turno D');
        $oTurno->addItemSelect('Geral', 'Geral');
        // $oTurno->setSValor($oOuserDados->getTurnoSteel());
        $oTurno->setSValor($aCamposTela['turnoSteel']);

        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);

        $oEtapa = new Campo('Etapa', 'opseq', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oEtapa->setSValor($oDados->getOpseq());
        $oEtapa->setBCampoBloqueado(true);

        $oCodEtapa = new Campo('CódTrat', 'tratcod', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oCodEtapa->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
        $oCodEtapa->setBCampoBloqueado(true);

        $oTratDes = new campo('Tratamento', 'tratdes', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oTratDes->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratdes());
        $oTratDes->setBCampoBloqueado(true);

        //campo dos fornos para somente carregar
        $oFornoCod = new campo('', 'fornocod', Campo::TIPO_TEXTO, 1);
        $oFornoCod->setBOculto(true);
        // $oFornoCod->setBOculto(true);
        $oFornoDes = new Campo('', 'fornodes', Campo::TIPO_TEXTO, 2);
        $oFornoDes->setBOculto(true);
        // $oFornoDes->setBOculto(true);

        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');


        //-----------------------combo dos fornos---------------------------
        $oFornoChoice = new campo('Forno / Trefila inicial', 'fornoCombo', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        foreach ($aFornosRadio as $keyForno => $oValueForno) {
            $oFornoChoice->addItemSelect($oValueForno->getFornocod(), $oValueForno->getFornodes());
        }
        $sCombo = 'var textCombo = $("#' . $oFornoChoice->getId() . ' option:selected").text(); '
                . 'var valueCombo = $("#' . $oFornoChoice->getId() . '").val(); '
                . '$("#' . $oFornoCod->getId() . '").val(valueCombo); $("#' . $oFornoDes->getId() . '").val(textCombo); ';
        $oFornoChoice->addEvento(Campo::EVENTO_CHANGE, $sCombo);
        //-----------------------------------------------------------------
        //verifica primeiro se há cookie setado
        if (isset($_COOKIE['cookfornocod'])) {
            $oFornoCod->setSValor($_COOKIE['cookfornocod']);
            //seta valor padrão
            $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
        } else {
            $oFornoArr = $aDados[0];

            if (method_exists($oFornoArr, 'getFornocod')) {
                $oFornoCod->setSValor($oFornoArr->getFornocod());
                $oFornoChoice->setSValor($oFornoArr->getFornocod());
            }
        }

        $oFornoDes->setBCampoBloqueado(true);
        $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
        if (isset($_COOKIE['cookfornodes'])) {
            $oFornoDes->setSValor($_COOKIE['cookfornodes']);
        } else {
            $oFornoArr = aForno[0];
            if (method_exists($oFornoArr, 'getFornodes')) {
                $oFornoDes->setSValor($oFornoArr->getFornodes());
            }
        }
        //--------------------------------------------------------------------  
        $oDiamMin = new campo('Diâmetro Mínimo', 'diamMin', Campo::TIPO_DECIMAL_COMPOSTO, 2, 2, 2, 2);
        $oDiamMin->setICasaDecimal(4);

        $oDiamMax = new campo('Diâmetro Máximo', 'diamMax', Campo::TIPO_DECIMAL_COMPOSTO, 2, 2, 2, 2);
        $oDiamMax->setICasaDecimal(4);



        if ($sModel == 'modalApontaFinalizarGeren') {

            $oDataSaida = new Campo('Data Saída', 'datasaida_forno', Campo::TIPO_DATA, 3);
            $oDataSaida->setSValor($sData);
            $oHoraSaida = new Campo('Hora Saída', 'horasaida_forno', Campo::TIPO_TEXTO, 2);
            $oHoraSaida->setSValor($sHora);

            //user saida
            $oUserSaicodigo = new Campo('Cod.Usuário Saída', 'coduser', Campo::TIPO_BUSCADOBANCOPK, 3);
            $oUserSaicodigo->setSValor($_SESSION['codUser']);

            //campo descrição do usuário
            $oUserSaides = new Campo('Descrição', 'usernome', Campo::TIPO_BUSCADOBANCO, 4);
            $oUserSaides->setSIdPk($oUserSaicodigo->getId());
            $oUserSaides->setClasseBusca('MET_TEC_Usuario');
            $oUserSaides->addCampoBusca('usucodigo', '', '');
            $oUserSaides->addCampoBusca('usunome', '', '');
            $oUserSaides->setSIdTela($this->getTela()->getId());
            $oUserSaides->setSValor($_SESSION['nome']);

            //declarar o campo descrição
            $oUserSaicodigo->setClasseBusca('MET_TEC_Usuario');
            $oUserSaicodigo->setSCampoRetorno('usucodigo', $this->getTela()->getId());
            $oUserSaicodigo->addCampoBusca('usunome', $oUserSaides->getId(), $this->getTela()->getId());
        } else {

            $oDataSaida = new Campo('Data Saída', 'datasaida_forno', Campo::TIPO_TEXTO, 2);
            $oDataSaida->setSValor($sData);
            $oHoraSaida = new Campo('Hora Saída', 'horasaida_forno', Campo::TIPO_TEXTO, 2);
            $oHoraSaida->setSValor($sHora);
            $oDataSaida->setBCampoBloqueado(true);
            $oHoraSaida->setBCampoBloqueado(true);

            $oCodUser = new campo('CodUser', 'coduser', Campo::TIPO_TEXTO, 1, 1, 1, 1);
            $oCodUser->setSValor($_SESSION['codUser']);
            $oCodUser->setBCampoBloqueado(true);
            $oCodUser->setBOculto(true);

            $oUserNome = new campo('Usuário', 'usernome', Campo::TIPO_TEXTO, 2, 2, 2, 2);
            $oUserNome->setSValor($_SESSION['nome']);
            $oUserNome->setBCampoBloqueado(true);
        }
        $oLinha = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);

        //botao inserir apontamento
        $oBtnInserir = new Campo('Finaliza etapa', '', Campo::TIPO_BOTAOSMALL_SUB, 5, 5, 5, 5);

        $oDiv = new campo('* Verifique o turno e usuário de saída', 'div1', Campo::DIVISOR_VERMELHO, 12, 12, 12, 12);

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEtapas","FinalizaEtapa",'
                . '"' . $this->getTela()->getId() . ',' . $IdGrid . ',");';
        $oBtnInserir->getOBotao()->addAcao($sAcao);

        if ($sModel == 'modalApontaFinalizarGeren') {
            $this->addCampos(array($oOp, $oEtapa, $oCodEtapa, $oTratDes), $oLinha, $oDiv, $oLinha, array($oTurno, $oUserSaicodigo, $oUserSaides), array($oDiamMin, $oDiamMax), $oLinha, array($oDataSaida, $oHoraSaida), $oLinha, $oBtnInserir, array($oFornoCod, $oFornoDes));
        } else {
            //se o tratamento for trefila adiciona os campos diam
            if ($oDados->getSTEEL_PCP_Tratamentos()->getTratcod() == 20) {
                $this->addCampos(array($oOp, $oEtapa, $oCodEtapa, $oTratDes, $oUserNome), array($oDataSaida, $oHoraSaida), $oLinha, $oDiv, $oLinha, array($oTurno, $oDiamMin, $oDiamMax), $oLinha, $oBtnInserir, array($oFornoCod, $oFornoDes, $oCodUser));
            } else {
                $this->addCampos(array($oOp, $oEtapa, $oCodEtapa, $oTratDes, $oUserNome), array($oDataSaida, $oHoraSaida), $oLinha, $oDiv, $oLinha, $oTurno, $oLinha, $oBtnInserir, array($oFornoCod, $oFornoDes, $oCodUser));
            }
        }
    }

}
