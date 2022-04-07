<?php

/*
 * Classe que implementa STEEL_PCP_GerenciaApont
 * 
 * @author Cleverton Hoffmann
 * @since 06/08/2018
 */

class ViewSTEEL_PCP_GerenciaApont extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oOp = new CampoConsulta('Op', 'op');
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oCodForno = new CampoConsulta('Cod.Forno', 'fornocod');
        $oDesForno = new CampoConsulta('Forno', 'fornodes');
        $oCodProd = new CampoConsulta('Cod.Prod.', 'procod');
        $oDesProd = new CampoConsulta('Descrição', 'prodes');
        $oDataEnt = new CampoConsulta('Data Ent.', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEnt = new CampoConsulta('Hora Ent.', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oDataSai = new CampoConsulta('Data Saida', 'datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHoraSai = new CampoConsulta('Hora Saida', 'horasaida_forno', CampoConsulta::TIPO_TIME);

        $oSituacao = new CampoConsulta('Situação', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');

        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oSeqFiltro = new Filtro($oSeq, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFornoFiltro = new Filtro($oCodForno, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oCodProdFiltro = new Filtro($oCodProd, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oSituafiltro = new Filtro($oSituacao, Filtro::CAMPO_TEXTO, 2);
        $this->addFiltro($oOpFiltro, $oSeqFiltro, $oFornoFiltro, $oCodProdFiltro, $oSituafiltro);

        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oOp, $oSeq, $oCodForno, $oDesForno, $oSituacao, $oCodProd, $oDesProd, $oDataEnt, $oHoraEnt, $oDataSai, $oHoraSai);

        $this->getTela()->setiAltura(650);
    }

    public function criaTela() {
        parent::criaTela();

        $oOp = new Campo('Op nº.', 'op', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOp->addValidacao(false, Validacao::TIPO_STRING);
        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);
        $oCodProd = new Campo('Cod.Prod.', 'procod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodProd->setBCampoBloqueado(true);
        $oDesProd = new Campo('Descrição', 'prodes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oDesProd->setBCampoBloqueado(true);

        //Cod. forno
        $oCodForno = new Campo('Cod.Forno', 'fornocod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodForno->setSValor('');
        $oCodForno->addValidacao(false, Validacao::TIPO_STRING);

        //Forno
        $oDesForno = new Campo('Descrição Forno', 'fornodes', Campo::TIPO_BUSCADOBANCO, 4);
        $oDesForno->setSIdPk($oCodForno->getId());
        $oDesForno->setClasseBusca('STEEL_PCP_Forno');
        $oDesForno->addCampoBusca('fornocod', '', '');
        $oDesForno->addCampoBusca('fornodes', '', '');
        $oDesForno->setSIdTela($this->getTela()->getId());
        $oDesForno->setSValor('');
        $oDesForno->addValidacao(false, Validacao::TIPO_STRING);

        //declarar o campo descrição do forno
        $oCodForno->setClasseBusca('STEEL_PCP_Forno');
        $oCodForno->setSCampoRetorno('fornocod', $this->getTela()->getId());
        $oCodForno->addCampoBusca('fornodes', $oDesForno->getId(), $this->getTela()->getId());

        $oSituacao = new Campo('Situação', 'situacao', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oSituacao->addItemSelect('Processo', 'Processo');
        $oSituacao->addItemSelect('Finalizado', 'Finalizado');


        $oDataEnt = new Campo('Data Entrada', 'dataent_forno', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEnt->setSValor(Util::getPrimeiroDiaMes());
        $oDataEnt->addValidacao(false, Validacao::TIPO_STRING);
        $oDataSai = new Campo('Data Saída', 'datasaida_forno', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oHoraEnt = new Campo('Hora de Entrada', 'horaent_forno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraEnt->setBTime(true);
        $oHoraEnt->addValidacao(false, Validacao::TIPO_STRING);
        $oHoraSai = new Campo('Hora de Saída', 'horasaida_forno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraSai->setBTime(true);

        //user entrada
        $oUserEntcodigo = new Campo('Cod.Usuário Entrada', 'coduser', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oUserEntcodigo->setSValor('');
        $oUserEntcodigo->addValidacao(false, Validacao::TIPO_STRING);

        //campo descrição do usuário
        $oUserEntdes = new Campo('Descrição', 'usernome', Campo::TIPO_BUSCADOBANCO, 4);
        $oUserEntdes->setSIdPk($oUserEntcodigo->getId());
        $oUserEntdes->setClasseBusca('MET_TEC_Usuario');
        $oUserEntdes->addCampoBusca('usucodigo', '', '');
        $oUserEntdes->addCampoBusca('usunome', '', '');
        $oUserEntdes->setSIdTela($this->getTela()->getId());
        $oUserEntdes->setSValor('');
        $oUserEntdes->addValidacao(false, Validacao::TIPO_STRING);

        //declarar o campo descrição
        $oUserEntcodigo->setClasseBusca('MET_TEC_Usuario');
        $oUserEntcodigo->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oUserEntcodigo->addCampoBusca('usunome', $oUserEntdes->getId(), $this->getTela()->getId());

        //user saida
        $oUserSaicodigo = new Campo('Cod.Usuário Saída', 'codusersaida', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oUserSaicodigo->setSValor('');

        //campo descrição do usuário
        $oUserSaides = new Campo('Descrição', 'usernomesaida', Campo::TIPO_BUSCADOBANCO, 4);
        $oUserSaides->setSIdPk($oUserSaicodigo->getId());
        $oUserSaides->setClasseBusca('MET_TEC_Usuario');
        $oUserSaides->addCampoBusca('usucodigo', '', '');
        $oUserSaides->addCampoBusca('usunome', '', '');
        $oUserSaides->setSIdTela($this->getTela()->getId());
        $oUserSaides->setSValor('');

        //declarar o campo descrição
        $oUserSaicodigo->setClasseBusca('MET_TEC_Usuario');
        $oUserSaicodigo->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oUserSaicodigo->addCampoBusca('usunome', $oUserSaides->getId(), $this->getTela()->getId());

        $oTurnoEnt = new campo('Turno Entrada', 'turnoSteel', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oTurnoEnt->addItemSelect('Turno A', 'Turno A');
        $oTurnoEnt->addItemSelect('Turno B', 'Turno B');
        $oTurnoEnt->addItemSelect('Turno C', 'Turno C');
        $oTurnoEnt->addItemSelect('Turno D', 'Turno D');
        $oTurnoEnt->addItemSelect('Geral', 'Geral');

        $oCorrida = new campo('Corrida', 'corrida', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oCorrida->addEvento(Campo::EVENTO_ENTER, 'if(event.which == 13){event.preventDefault();}');

        $oTurnoSaida = new campo('Turno Saída', 'turnoSteelSaida', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oTurnoSaida->addItemSelect('Turno A', 'Turno A');
        $oTurnoSaida->addItemSelect('Turno B', 'Turno B');
        $oTurnoSaida->addItemSelect('Turno C', 'Turno C');
        $oTurnoSaida->addItemSelect('Turno D', 'Turno D');
        $oTurnoSaida->addItemSelect('Geral', 'Geral');

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oFieldE = new FieldSet('Entrada');
        $oFieldE->addCampos(array($oUserEntcodigo, $oUserEntdes), $oLinha1, array($oDataEnt, $oHoraEnt, $oTurnoEnt), $oCorrida);
        $oFieldE->setOculto(FALSE);

        $oFieldS = new FieldSet('Saída');
        $oFieldS->addCampos(array($oUserSaicodigo, $oUserSaides), $oLinha1, array($oDataSai, $oHoraSai, $oTurnoSaida));
        $oFieldS->setOculto(FALSE);

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        //----------------------------------------------------------------------------------------------------------
        $oGridEnt = new campo('Etapas do processo', 'gridEnt', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridEnt->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());

        $oOpGrid = new CampoConsulta('Op', 'op');
        //botao que inicia um processo
        $oBotaoStart = new CampoConsulta('Inciar etapa', 'iniciarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOSUCCES);
        $oBotaoStart->setBHideTelaAcao(true);
        $oBotaoStart->setILargura(20);
        $oBotaoStart->setSTitleAcao('Inicia etapa!');
        $oBotaoStart->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaIniciar', 'modalApontaIniciarGeren', '');
        $oBotaoStart->setSTituloBotaoModal('INICIAR');
        $oGridEnt->getOGrid()->addModal($oBotaoStart);

        //botao que finalizar um processo
        $oBotaoFinalizar = new CampoConsulta('Finalizar etapa', 'finalizarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAOPRIMARY);
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(20);
        $oBotaoFinalizar->setSTitleAcao('Finaliza etapa!');
        $oBotaoFinalizar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'criaTelaModalApontaFinalizar', 'modalApontaFinalizarGeren', '');
        $oBotaoFinalizar->setSTituloBotaoModal('FINALIZAR');
        $oGridEnt->getOGrid()->addModal($oBotaoFinalizar);

        //botao que retorna um processo
        $oBotaoRetornar = new CampoConsulta('Retornar etapa', 'retornarEtapa', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_BOTAODANGER);
        $oBotaoRetornar->setBHideTelaAcao(true);
        $oBotaoRetornar->setSTitleAcao('Retorna apontamento!');
        $oBotaoRetornar->addAcao('STEEL_PCP_OrdensFabApontEtapas', 'retornaApontamentoGeren', '', '');
        $oBotaoRetornar->setSTituloBotaoModal('RETORNAR');
        $oBotaoRetornar->setILargura(20);
        $oGridEnt->getOGrid()->addModal($oBotaoRetornar);

        $oReceitaSeq = new CampoConsulta('Etapa', 'receita_seq');
        $oTratamento = new CampoConsulta('Tratamento', 'STEEL_PCP_Tratamentos.tratdes');
        $oTratamento->setILargura(220);
        $oFornodesConsulta = new CampoConsulta('Forno/Trefila', 'fornodes');
        $oDataEntConsulta = new CampoConsulta('Data Ent.', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHoraEntConsulta = new CampoConsulta('Hora Ent.', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oDataSaidaConsulta = new CampoConsulta('Data Saída', 'datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHoraSaidaConsulta = new CampoConsulta('Hora Saída', 'horasaida_forno', CampoConsulta::TIPO_TIME);

        $oSituacaoConsulta = new CampoConsulta('Situação', 'situacao');
        $oSituacaoConsulta->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoConsulta->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacaoConsulta->setBComparacaoColuna(true);
        $oSituacaoConsulta->setILargura(11);

        $oUserEntConsulta = new campoconsulta('Usuário Ent.', 'usernome');
        $oUserSaidaConsulta = new campoconsulta('Usuário Saída', 'usernomesaida');

        $oGridEnt->addCampos($oBotaoStart, $oBotaoFinalizar, $oBotaoRetornar, $oOpGrid, $oReceitaSeq, $oTratamento, $oSituacaoConsulta, $oFornodesConsulta, $oDataEntConsulta, $oHoraEntConsulta, $oUserEntConsulta, $oDataSaidaConsulta, $oHoraSaidaConsulta, $oUserSaidaConsulta);
        $oGridEnt->setSController('STEEL_PCP_OrdensFabItens');
        $oGridEnt->addParam('op', '0');
        $oGridEnt->getOGrid()->setIAltura(220);
        $oGridEnt->getOGrid()->setBGridResponsivo(false);
        $oGridEnt->setApenasTela(true);

        $oBtnAtualizar = new Campo('Atualizar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBtnAtualizar->getOBotao()->setId('btn_atualizarApontEtapaSteelGeren');
        $sAcaoAtualizar = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFabItens",'
                . '"getDadosGrid","' . $oGridEnt->getId() . '","gridApontaEtapaGeren");';
        $oBtnAtualizar->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $oBtnAtualizar->getOBotao()->addAcao($sAcaoAtualizar);
        $oBtnAtualizar->setApenasTela(true);

        //          . '"getDadosGrid","' . $oGridEnt->getId() . '","gridApontaEtapa");';
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sBuscaProd = 'var recod = $("#' . $oOp->getId() . '").val();if(recod!==""){'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFab",'
                . '"buscaProduto","' . $oCodProd->getId() . ',' . $oDesProd->getId() . '");$("#btn_atualizarApontEtapaSteelGeren").click();}';

        $oOp->addEvento(Campo::EVENTO_SAIR, $sBuscaProd);

        // $oOp->addEvento(Campo::EVENTO_FOCUS, $sAcaoAtualizar); 
        $oOp->setBFocus(true);

        $this->addCampos(array($oOp, $oSeq, $oCodProd, $oDesProd), $oLinha1, array($oCodForno, $oDesForno), $oLinha1, $oFieldE, $oLinha1, $oBtnAtualizar, $oGridEnt, $oFieldS, $oSituacao);
    }

    /*
      public function criaModalApontaIniciar($aForno,$IdGrid) {
      parent::criaModal();

      $aFornosRadio = $aForno[1];

      $this->setBTela(true);
      $oDados = $this->getAParametrosExtras();

      //busca os dados do usuário
      $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
      $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
      $oOuserDados = $oOuser->Persistencia->consultarWhere();

      $oTurno = new campo('Turno inicial','turnoSteel', Campo::CAMPO_SELECTSIMPLE,2,2,2,2);
      $oTurno->addItemSelect('Turno A','Turno A');
      $oTurno->addItemSelect('Turno B','Turno B');
      $oTurno->addItemSelect('Turno C','Turno C');
      $oTurno->addItemSelect('Turno D','Turno D');
      $oTurno->addItemSelect('Geral','Geral');
      $oTurno->setSValor($oOuserDados->getTurnoSteel());

      $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2,2,2,2);
      $oOp->setSValor($oDados->getOp());
      $oOp->setBCampoBloqueado(true);

      $oEtapa = new Campo('Etapa','opseq', Campo::TIPO_TEXTO,1,1,1,1);
      $oEtapa->setSValor($oDados->getOpseq());
      $oEtapa->setBCampoBloqueado(true);

      $oCodEtapa = new Campo('CódTrat','tratcod', Campo::TIPO_TEXTO,1,1,1,1);
      $oCodEtapa->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
      $oCodEtapa->setBCampoBloqueado(true);

      $oTratDes = new campo('Tratamento','tratdes', Campo::TIPO_TEXTO,4,4,4,4);
      $oTratDes->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratdes());
      $oTratDes->setBCampoBloqueado(true);

      //campo dos fornos para somente carregar
      $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
      $oFornoCod->setBOculto(true);
      // $oFornoCod->setBOculto(true);
      $oFornoDes=new Campo('','fornodes', Campo::TIPO_TEXTO,2);
      $oFornoDes->setBOculto(true);
      // $oFornoDes->setBOculto(true);

      //-----------------------combo dos fornos---------------------------
      $oFornoChoice = new campo('Forno / Trefila inicial','fornoCombo', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
      foreach ($aFornosRadio as $keyForno => $oValueForno) {
      $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
      }
      $sCombo ='var textCombo = $("#'.$oFornoChoice->getId().' option:selected").text(); '
      . 'var valueCombo = $("#'.$oFornoChoice->getId().'").val(); '
      .'$("#'.$oFornoCod->getId().'").val(valueCombo); $("#'.$oFornoDes->getId().'").val(textCombo); ';
      $oFornoChoice->addEvento(Campo::EVENTO_CHANGE,$sCombo);
      //-----------------------------------------------------------------
      //verifica primeiro se há cookie setado
      if(isset($_COOKIE['cookfornocod'])){
      $oFornoCod->setSValor($_COOKIE['cookfornocod']);
      //seta valor padrão
      $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
      }else{
      $oFornoArr = $aDados[0];

      if (method_exists($oFornoArr,'getFornocod')){
      $oFornoCod->setSValor($oFornoArr->getFornocod());
      $oFornoChoice->setSValor($oFornoArr->getFornocod());
      }}

      $oFornoDes->setBCampoBloqueado(true);
      $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
      if(isset($_COOKIE['cookfornodes'])){
      $oFornoDes->setSValor($_COOKIE['cookfornodes']);
      }else{
      $oFornoArr = aForno[0];
      if (method_exists($oFornoArr,'getFornodes')){
      $oFornoDes->setSValor($oFornoArr->getFornodes());
      }}
      //--------------------------------------------------------------------

      $oCodUser = new campo('CodUser','coduser', Campo::TIPO_TEXTO,1,1,1,1);
      $oCodUser->setSValor($_SESSION['codUser']);
      $oCodUser->setBCampoBloqueado(true);
      $oCodUser->setBOculto(true);

      $oUserNome = new campo('Usuário','usernome', Campo::TIPO_TEXTO,2,2,2,2);
      $oUserNome->setSValor($_SESSION['nome']);
      $oUserNome->setBCampoBloqueado(true);

      $oLinha = new campo('','linha', Campo::TIPO_LINHA,12,12,12,12);

      //botao inserir apontamento
      $oBtnInserir = new Campo('Apontar Etapa','',  Campo::TIPO_BOTAOSMALL_SUB,5,5,5,5);

      $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEtapas","ApontEtapa",'
      . '"'.$this->getTela()->getId().','.$IdGrid.',");';
      $oBtnInserir->getOBotao()->addAcao($sAcao);

      $this->addCampos(array($oOp,$oEtapa,$oCodEtapa,$oTratDes,$oUserNome),
      $oLinha,
      array($oFornoChoice,$oTurno),
      $oBtnInserir,
      array($oFornoCod,$oFornoDes,$oCodUser));
      }

      //criaTelaModalApontaFinalizar
      public function criaTelaModalApontaFinalizar($aForno,$IdGrid) {
      parent::criaModal();

      $aFornosRadio = $aForno[1];

      $this->setBTela(true);
      $oDados = $this->getAParametrosExtras();

      //busca os dados do usuário
      $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
      $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
      $oOuserDados = $oOuser->Persistencia->consultarWhere();

      $oTurno = new campo('Turno final','turnoSteelSaida', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
      $oTurno->addItemSelect('Turno A','Turno A');
      $oTurno->addItemSelect('Turno B','Turno B');
      $oTurno->addItemSelect('Turno C','Turno C');
      $oTurno->addItemSelect('Turno D','Turno D');
      $oTurno->addItemSelect('Geral','Geral');
      $oTurno->setSValor($oOuserDados->getTurnoSteel());

      $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2,2,2,2);
      $oOp->setSValor($oDados->getOp());
      $oOp->setBCampoBloqueado(true);

      $oEtapa = new Campo('Etapa','opseq', Campo::TIPO_TEXTO,1,1,1,1);
      $oEtapa->setSValor($oDados->getOpseq());
      $oEtapa->setBCampoBloqueado(true);

      $oCodEtapa = new Campo('CódTrat','tratcod', Campo::TIPO_TEXTO,1,1,1,1);
      $oCodEtapa->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratcod());
      $oCodEtapa->setBCampoBloqueado(true);

      $oTratDes = new campo('Tratamento','tratdes', Campo::TIPO_TEXTO,4,4,4,4);
      $oTratDes->setSValor($oDados->getSTEEL_PCP_Tratamentos()->getTratdes());
      $oTratDes->setBCampoBloqueado(true);

      //campo dos fornos para somente carregar
      $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
      $oFornoCod->setBOculto(true);
      // $oFornoCod->setBOculto(true);
      $oFornoDes=new Campo('','fornodes', Campo::TIPO_TEXTO,2);
      $oFornoDes->setBOculto(true);
      // $oFornoDes->setBOculto(true);

      //-----------------------combo dos fornos---------------------------
      $oFornoChoice = new campo('Forno / Trefila inicial','fornoCombo', Campo::CAMPO_SELECTSIMPLE,3,3,3,3);
      foreach ($aFornosRadio as $keyForno => $oValueForno) {
      $oFornoChoice->addItemSelect($oValueForno->getFornocod(),$oValueForno->getFornodes());
      }
      $sCombo ='var textCombo = $("#'.$oFornoChoice->getId().' option:selected").text(); '
      . 'var valueCombo = $("#'.$oFornoChoice->getId().'").val(); '
      .'$("#'.$oFornoCod->getId().'").val(valueCombo); $("#'.$oFornoDes->getId().'").val(textCombo); ';
      $oFornoChoice->addEvento(Campo::EVENTO_CHANGE,$sCombo);
      //-----------------------------------------------------------------
      //verifica primeiro se há cookie setado
      if(isset($_COOKIE['cookfornocod'])){
      $oFornoCod->setSValor($_COOKIE['cookfornocod']);
      //seta valor padrão
      $oFornoChoice->setSValor($_COOKIE['cookfornocod']);
      }else{
      $oFornoArr = $aDados[0];

      if (method_exists($oFornoArr,'getFornocod')){
      $oFornoCod->setSValor($oFornoArr->getFornocod());
      $oFornoChoice->setSValor($oFornoArr->getFornocod());
      }}

      $oFornoDes->setBCampoBloqueado(true);
      $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
      if(isset($_COOKIE['cookfornodes'])){
      $oFornoDes->setSValor($_COOKIE['cookfornodes']);
      }else{
      $oFornoArr = aForno[0];
      if (method_exists($oFornoArr,'getFornodes')){
      $oFornoDes->setSValor($oFornoArr->getFornodes());
      }}
      //--------------------------------------------------------------------

      $oCodUser = new campo('CodUser','coduser', Campo::TIPO_TEXTO,1,1,1,1);
      $oCodUser->setSValor($_SESSION['codUser']);
      $oCodUser->setBCampoBloqueado(true);
      $oCodUser->setBOculto(true);

      $oUserNome = new campo('Usuário','usernome', Campo::TIPO_TEXTO,2,2,2,2);
      $oUserNome->setSValor($_SESSION['nome']);
      $oUserNome->setBCampoBloqueado(true);

      $oLinha = new campo('','linha', Campo::TIPO_LINHA,12,12,12,12);

      //botao inserir apontamento
      $oBtnInserir = new Campo('Finaliza etapa','',  Campo::TIPO_BOTAOSMALL_SUB,5,5,5,5);

      $oDiv = new campo('* Verifique o turno de saída','div1', Campo::DIVISOR_VERMELHO,12,12,12,12);

      $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEtapas","FinalizaEtapa",'
      . '"'.$this->getTela()->getId().','.$IdGrid.',");';
      $oBtnInserir->getOBotao()->addAcao($sAcao);

      $this->addCampos(array($oOp,$oEtapa,$oCodEtapa,$oTratDes,$oUserNome),
      $oLinha,
      $oDiv,
      $oLinha,
      $oTurno,
      $oLinha,
      $oBtnInserir,
      array($oFornoCod,$oFornoDes,$oCodUser));
      }
     */
}
