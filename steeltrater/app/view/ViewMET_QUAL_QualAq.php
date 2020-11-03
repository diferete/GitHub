<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_QUAL_QualAq extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setIAltura(400);

        $this->getTela()->setBMostraFiltro(true);

        $oTitulo = new CampoConsulta('Título', 'titulo', CampoConsulta::TIPO_LARGURA, 300);

        $oFilcgc = new CampoConsulta('Cnpj', 'filcgc');

        $oNr = new CampoConsulta('AQ', 'nr');
        $oNr->setSOperacao('personalizado');

        $oDataFim = new CampoConsulta('Dt.Implantação', 'dtimp', CampoConsulta::TIPO_DATA);

        $oSit = new CampoConsulta('Situação', 'sit', CampoConsulta::TIPO_DESTAQUE2);
        $oSit->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');
        $oSit->addComparacao('Iniciada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');

        $oOrigem = new CampoConsulta('Origem', 'origem', CampoConsulta::TIPO_LARGURA);

        $oTipoAcao = new CampoConsulta('Tipo da ação', 'tipoacao', CampoConsulta::TIPO_LARGURA);

        $oTipoMel = new CampoConsulta('TipoMelhoria', 'tipmelhoria', CampoConsulta::TIPO_LARGURA);

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);

        $oFilTit = new Filtro($oTitulo, Filtro::CAMPO_TEXTO, 10, 10, 12, 12);
        $oFilTit->setBQuebraLinha(true);

        $oTipoAcaoFiltro = new Filtro($oTipoAcao, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oTipoAcaoFiltro->addItemSelect('Todos', 'Todos');
        $oTipoAcaoFiltro->addItemSelect('Ação Corretiva', 'Ação Corretiva');
        $oTipoAcaoFiltro->addItemSelect('Ação Preventiva', 'Ação Preventiva');
        $oTipoAcaoFiltro->setSLabel('Ação');

        $oOrigemFiltro = new Filtro($oOrigem, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oOrigemFiltro->addItemSelect('Todos', 'Todos');
        $oOrigemFiltro->addItemSelect('Sugestão de funcionário', 'Sugestão de funcionário');
        $oOrigemFiltro->addItemSelect('Análise crítica do SGQ', 'Análise crítica do SGQ');
        $oOrigemFiltro->addItemSelect('Análise dos Indicadores', 'Análise dos Indicadores');
        $oOrigemFiltro->addItemSelect('Reclamação de Cliente', 'Reclamação de Cliente');
        $oOrigemFiltro->addItemSelect('Auditoria Interna', 'Auditoria Interna');
        $oOrigemFiltro->addItemSelect('Auditoria Externa', 'Auditoria Externa');
        $oOrigemFiltro->addItemSelect('Produto não conforme', 'Produto não conforme');
        $oOrigemFiltro->setSLabel('Origem');

        $oTipoMelFiltro = new Filtro($oTipoMel, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oTipoMelFiltro->addItemSelect('Todos', 'Todos');
        $oTipoMelFiltro->addItemSelect('Produto', 'Produto');
        $oTipoMelFiltro->addItemSelect('Processo', 'Processo');
        $oTipoMelFiltro->addItemSelect('Ambiente', 'Ambiente');
        $oTipoMelFiltro->setSLabel('Tipo');

        $oSitFiltro = new Filtro($oSit, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Aberta', 'Aberta');
        $oSitFiltro->addItemSelect('Iniciada', 'Iniciada');
        $oSitFiltro->addItemSelect('Finalizada', 'Finalizada');
        $oSitFiltro->addItemSelect('Cancelada', 'Cancelada');


        $this->addFiltro($oFilNr, $oFilTit, $oTipoAcaoFiltro, $oOrigemFiltro, $oTipoMelFiltro, $oSitFiltro);

        $this->setUsaDropdown(true);
        /*
          $oDrop1 = new Dropdown('Ação e Eficácia', Dropdown::TIPO_SUCESSO, 2);
          $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CALENDARIO) . 'Finalizar plano de ação', 'MET_QUAL_AqPlanApont', 'acaoMostraTelaApontdiv', '', true, '');
          $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Inserir avaliação da eficácia', 'MET_QUAL_AcaoEficaz', 'acaoMostraTelaApontdiv', '', true, '');
          $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CALENDARIO) . 'Apontar avaliação da eficácia', 'MET_QUAL_AcaoEficazApont', 'acaoMostraTelaApontdiv', '', true, '');
         */

        $oDrop3 = new Dropdown('Movimentação', Dropdown::TIPO_DARK);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Iniciar ação da qualidade', 'MET_QUAL_QualAq', 'startAq', '', false, '', false, '', false, '', false, false);
        //$oDrop3->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Finalizar ação da qualidade', 'MET_QUAL_QualAq', 'msgFechaAq', '', false, ''); //msgAbreAq
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_DESBLOQUEADO) . 'Reabrir ação da qualidade', 'MET_QUAL_QualAq', 'msgAbreAq', '', false, '', false, '', false, '', false, false);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Cancelar ação da qualidade', 'MET_QUAL_QualAq', 'criaModalCancelaAq', '', false, '', false, 'criaTelaModalCancelaAq', true, 'Cancelar Aq', false, false);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_FILE) . 'Ata de reunião', 'MET_QUAL_Ata', 'acaoMostraTelaApontdiv', '', true, '', false, '', false, '', false, false);

        $oDrop4 = new Dropdown('Impressão e Emails', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop4->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Vizualizar ação da qualidade', 'MET_QUAL_QualAq', 'acaoMostraRelConsulta', '', false, 'AqImp', false, '', false, '', false, false);
        $oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu e-mail', 'MET_QUAL_QualAq', 'geraPdfQualAq', '', false, 'AqImp', false, '', false, '', true, false);
        //$oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email', 'MET_QUAL_QualAq', 'envMailGrid2', '', false, 'AqImp,email,MET_QUAL_QualAq,envMailQual');
        $oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para todos os envolvidos', 'MET_QUAL_QualAq', 'geraPdfQualAqTodos', '', false, 'AqImp', false, '', false, '', true, false);
        //$oDrop4->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para todos envolvidos', 'MET_QUAL_QualAq', 'envMailGrid', '', false, 'AqImp,email,MET_QUAL_QualAq,envMailAll');


        $this->addDropdown(/* $oDrop1, */ $oDrop3, $oDrop4);

        $this->addCampos($oNr, $oSit, $oTitulo, $oDataFim, $oTipoAcao, $oOrigem, $oTipoMel, $oFilcgc);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoExcluir(false);


        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","MET_QUAL_QualAq","renderTempo",chave+",qualaqtempo");');
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oTitulo = new Campo('Título da ação da qualidade', 'titulo', Campo::TIPO_TEXTO, 3, 6, 12, 12);
        $oLinha1 = new Campo('', '', Campo::TIPO_LINHA, 12);
        $oLinha1->setApenasTela(true);
        $oTitulo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTitulo->setBFocus(true);

        $oSit = new Campo('Situação', 'sit', Campo::TIPO_TEXTO, 2, 6, 6, 6);
        $oSit->setSValor('Aberta');
        $oSit->setBCampoBloqueado(true);

        $oFilChave = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilChave->setSValor($_SESSION['filcgc']);
        $oFilChave->setBOculto(true);


        $oFilcgc = new Campo('Empresa', 'DELX_FIL_Empresa.fil_codigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBFocus(true);

        $oFilDes = new campo('Empresa', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oFilDes->setSIdPk($oFilcgc->getId());
        $oFilDes->setClasseBusca('DELX_FIL_Empresa');
        $oFilDes->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oFilDes->addCampoBusca('fil_codigo', '', '');
        $oFilDes->addCampoBusca('fil_fantasia', '', '');
        $oFilDes->setSIdTela($this->getTela()->getid());

        $oFilcgc->setClasseBusca('DELX_FIL_Empresa');
        $oFilcgc->setSCampoRetorno('fil_codigo', $this->getTela()->getId());
        $oFilcgc->addCampoBusca('fil_fantasia', $oFilDes->getId(), $this->getTela()->getId());


        $oDataImp = new campo('Implantação', 'dtimp', Campo::TIPO_TEXTO, 2, 6, 6, 6);
        $oDataImp->setSValor(date('d/m/Y'));
        $oDataImp->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'horimp', Campo::TIPO_TEXTO, 2, 3, 3, 3);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oUserImplant = new campo('Usuário Implantação', 'userimp', Campo::TIPO_TEXTO, 2, 9, 9, 9);
        $oUserImplant->setSValor($_SESSION['nome']);
        $oUserImplant->setBCampoBloqueado(true);


        $oCertificacao = new Campo('Classificação', 'classificacao', Campo::TIPO_SELECT, 4, 12, 12, 12);
        $oCertificacao->addItemSelect('Cliente, processos e produto', 'Cliente, processos e produto');
        $oCertificacao->addItemSelect('Segurança e saúde ocupacional', 'Segurança e saúde ocupacional');
        $oCertificacao->addItemSelect('Meio ambiente', 'Meio ambiente');

        $oSetor = new campo('...', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oSetor->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oSetorDes = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSetorDes->setSIdPk($oSetor->getId());
        $oSetorDes->setClasseBusca('MET_CAD_Setores');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getid());

        $oSetor->setClasseBusca('MET_CAD_Setores');
        $oSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oSetor->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());
        $oSetor->addValidacao(false, Validacao::TIPO_STRING, '', 1, 3);

        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRespNome = new Campo('Responsável', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('MET_TEC_usuario');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());


        $oResp->setClasseBusca('MET_TEC_usuario');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());

        $oDivisor = new Campo('Adiciona equipe', 'addeqp', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oCodUser = new campo('Cód.', 'codusuario', Campo::TIPO_BUSCADOBANCOPK, 2, 4, 4, 4);

        $oUserNome = new Campo('Participa', 'participante', Campo::TIPO_BUSCADOBANCO, 3, 8, 8, 8);
        $oUserNome->setSIdPk($oCodUser->getId());
        $oUserNome->setClasseBusca('MET_TEC_usuario');
        $oUserNome->addCampoBusca('usucodigo', '', '');
        $oUserNome->addCampoBusca('usunome', '', '');
        $oUserNome->setSIdTela($this->getTela()->getid());
        $oUserNome->setApenasTela(true);

        $oCodUser->setClasseBusca('MET_TEC_usuario');
        $oCodUser->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodUser->addCampoBusca('usunome', $oUserNome->getId(), $this->getTela()->getId());
        $oCodUser->setApenasTela(true);

        $oEquipe = new campo('Equipe envolvida', 'equipe', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oEquipe->setICaracter(500);
        $oEquipe->setILinhasTextArea(5);

        $oEquipeEmail = new Campo('E-mails', 'emailEquip', Campo::TIPO_TAGS, 6, 6, 12, 12);

        $oBotConf = new Campo('Adicionar', 'botao', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $oBotConf->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);
        $sAcao = 'getUserEmail($("#' . $oCodUser->getId() . '").val(),'
                . '"' . $oEquipe->getId() . '",'
                . '"' . $oEquipeEmail->getId() . '",'
                . '"' . $oCodUser->getId() . '",'
                . '"' . $this->getController() . '")';
        $oBotConf->getOBotao()->addAcao($sAcao);
        $oBotConf->setApenasTela(true);

        $oDivisor1 = new Campo('', 'addeqp2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDataIni = new campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataIni->setSValor(date('d/m/Y'));

        /* $oDataFinal = new campo('Data Prevista', 'datafim', Campo::TIPO_DATA, 2, 6, 6, 6);
          $oDataFinal->setSValor(date('d/m/Y'));
         */

        $oTipoAcao = new campo('Tipo da ação', 'tipoacao', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oTipoAcao->addItemSelect('Ação Corretiva', 'Ação Corretiva');
        $oTipoAcao->addItemSelect('Ação Preventiva', 'Ação Preventiva');

        $oOrigem = new campo('Origem da ação', 'origem', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oOrigem->addItemSelect('Sugestão de funcionário', 'Sugestão de funcionário');
        $oOrigem->addItemSelect('Contexto da organização', 'Contexto da organização');
        $oOrigem->addItemSelect('Análise crítica do SGQ', 'Análise crítica do SGQ');
        $oOrigem->addItemSelect('Análise dos Indicadores', 'Análise dos Indicadores');
        $oOrigem->addItemSelect('Reclamação de Cliente', 'Reclamação de Cliente');
        $oOrigem->addItemSelect('Auditoria Interna', 'Auditoria Interna');
        $oOrigem->addItemSelect('Auditoria Externa', 'Auditoria Externa');
        $oOrigem->addItemSelect('Produto não conforme', 'Produto não conforme');

        $oTipmel = new campo('Tipo de melhoria', 'tipmelhoria', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oTipmel->addItemSelect('Produto', 'Produto');
        $oTipmel->addItemSelect('Processo', 'Processo');
        $oTipmel->addItemSelect('Ambiente', 'Ambiente');

        $oAssunto = new Campo('Assunto / Problema', 'problema', Campo::TIPO_TEXTAREA, 5, 5, 12, 12);
        $oAssunto->setILinhasTextArea(5);
        $oAssunto->setICaracter(400);

        $oObjetivo = new Campo('Objetivo', 'objetivo', Campo::TIPO_TEXTAREA, 5, 5, 12, 12);
        $oObjetivo->setILinhasTextArea(5);
        $oObjetivo->setICaracter(400);

        $oNr = new campo('', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBOculto(true);

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Inserir ação da qualidade', true, $this->addIcone(Base::ICON_CALENDARIO));
        $oEtapas->addItemEtapas('Contenção/Abrangência', false, $this->addIcone(Base::ICON_INFO));
        $oEtapas->addItemEtapas('Ação de correção', false, $this->addIcone(Base::ICON_CONFIRMAR));
        $oEtapas->addItemEtapas('Causa raiz do problema', false, $this->addIcone(Base::ICON_LAPIS));
        $oEtapas->addItemEtapas('Plano de ação', false, $this->addIcone(Base::ICON_MARTELO));
        $oEtapas->addItemEtapas('Avaliação da eficácia', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);

        $oAnexo1 = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD, 4, 4, 12, 12);

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {

            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }
            $this->setSIdControleUpAlt($oAcao->getId());
            $this->addCampos(
                    array($oTitulo, $oSit, $oDataImp, $oHora, $oUserImplant), array($oCertificacao, $oSetor, $oSetorDes), $oLinha1, array($oFilcgc, $oFilChave, $oFilDes, $oResp, $oRespNome), $oDivisor, array($oCodUser, $oUserNome, $oBotConf), array($oEquipe, $oEquipeEmail), $oDivisor1, array($oDataIni), array($oTipoAcao, $oOrigem, $oTipmel), $oAnexo1, array($oAssunto, $oObjetivo), $oNr, $oAcao);
        } else {
            $this->addCampos(
                    array($oTitulo, $oSit, $oDataImp, $oHora, $oUserImplant), array($oCertificacao, $oSetor, $oSetorDes), $oLinha1, array($oFilcgc, $oFilChave, $oFilDes, $oResp, $oRespNome), $oDivisor, array($oCodUser, $oUserNome, $oBotConf), array($oEquipe, $oEquipeEmail), $oDivisor1, array($oDataIni), array($oTipoAcao, $oOrigem, $oTipmel), $oAnexo1, array($oAssunto, $oObjetivo), $oNr);
        }
    }

    public function criaTelaModalCancelaAq($sDados) {
        parent:: criaModal();

        $this->setBTela(true);

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($oDados->nr);
        $oNr->setBCampoBloqueado(true);

        $oDtCancela = new Campo('Data cancelamento', 'dtcancela', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDtCancela->setSValor(date('d/m/Y'));
        $oDtCancela->setBCampoBloqueado(true);

        $oResponsavel = new Campo('Responsável', 'usunome', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oResponsavel->setSValor($oDados->usunome);
        $oResponsavel->setBCampoBloqueado(true);

        $oUsuCancela = new campo('Usu.Cancela', 'usucancela', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oUsuCancela->setSValor($_SESSION['nome']);
        $oUsuCancela->setBCampoBloqueado(true);

        $oTitulo = new campo('Título Aq', 'titulo', Campo::TIPO_TEXTO, 12, 12, 12, 12);
        $oTitulo->setSValor($oDados->titulo);
        $oTitulo->setBCampoBloqueado(true);

        $oObsCancela = new campo('Motivo do cancelamento', 'obscancela', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsCancela->addValidacao(false, Validacao::TIPO_STRING, 'É necessário informar este campo!', '10', '1000');
        $oObsCancela->setILinhasTextArea(5);

        $oBtnInserir = new Campo('Cancelar Aq', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","cancelaAq","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oFilcgc, $oNr, $oResponsavel), $oTitulo, array($oDtCancela, $oUsuCancela), $oObsCancela, $oBtnInserir);
    }

    public function relAcaoQualidade() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Ações da Qualidade');
        $this->setBTela(true);

        $oDivisor1 = new Campo('Situações por Setor', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(TRUE);

        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oDataFin = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataFin->setSValor(date('d/m/Y'));

        $oSituacao = new Campo('Situação da Ação', 'situacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituacao->addItemSelect('T', 'Todas');
        $oSituacao->addItemSelect('A', 'Aberta');
        $oSituacao->addItemSelect('F', 'Finalizada');

        $oSituacao2 = new Campo('Situação do Plano de Ação', 'situacao2', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituacao2->addItemSelect('T', 'Todos');
        $oSituacao2->addItemSelect('A', 'Aberto');
        $oSituacao2->addItemSelect('F', 'Finalizado');

        $oVencidos = new Campo('Atraso', 'vencido', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $oSetor = new campo('Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oSetorDes = new Campo('Descrição', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSetorDes->setSIdPk($oSetor->getId());
        $oSetorDes->setClasseBusca('Setor');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getid());

        $oSetor->setClasseBusca('Setor');
        $oSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oSetor->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());

        $oTipoAcao = new campo('Tipo da ação', 'tipoacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoAcao->addItemSelect('T', 'Todas');
        $oTipoAcao->addItemSelect('Ação Corretiva', 'Ação Corretiva');
        $oTipoAcao->addItemSelect('Ação Preventiva', 'Ação Preventiva');

        $olinha = new Campo('', 'linha1', Campo::TIPO_LINHABRANCO);
        $olinha->setApenasTela(true);

        $this->addCampos(array($oSetor, $oSetorDes), $olinha, array($oDataIni, $oDataFin), $olinha, array($oSituacao, $oTipoAcao), $olinha, $oSituacao2, $oVencidos);
    }

}
