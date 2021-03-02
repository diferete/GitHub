<?php

/*
 * Class que gerencia as view da classe MET_QUAL_RcVenda
 */

class ViewMET_QUAL_RcVenda extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBMostraFiltro(true);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setiLarguraGrid(2800);

        $this->getTela()->setIAltura(550);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setSTitleAcao('Liberar e apontar devolução!');
        $oBotaoModal->addAcao('MET_QUAL_RcVenda', 'criaTelaModalApontaDevolucao', 'criaModalApontaDevolucao', '');
        $this->addModais($oBotaoModal);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_LARGURA);

        $oCliente = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);

        $oUser = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA);

        $oOfficeDes = new CampoConsulta('Representante', 'officedes', CampoConsulta::TIPO_LARGURA);

        $oData = new CampoConsulta('Data', 'datains', CampoConsulta::TIPO_DATA);

        $oProd = new CampoConsulta('Produtos', 'produtos');

        $oAnexo1 = new CampoConsulta('Anexo 1', 'anexo1', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo2 = new CampoConsulta('Anexo 2', 'anexo2', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo3 = new CampoConsulta('Anexo 3', 'anexo3', CampoConsulta::TIPO_DOWNLOAD);

        $oDataLibVendas = new CampoConsulta('Dt. lib. vendas', 'datalibvendas', CampoConsulta::TIPO_DATA);

        $oHoraLibVendas = new CampoConsulta('Hr. lib. vendas', 'horalibvendas', CampoConsulta::TIPO_TIME);

        $oDataLibAnalise = new CampoConsulta('Dt. lib. análise', 'datalibanalise', CampoConsulta::TIPO_DATA);

        $oHoraLibAnalise = new CampoConsulta('Hr. lib. análise', 'horalibanalise', CampoConsulta::TIPO_TIME);

        ////////////////////////////////////////////// COLUNAS DE SITUAÇÃO /////////////////////////////////////////////////////////////////////////////

        $oSit = new CampoConsulta('Sit. Geral', 'situaca', CampoConsulta::TIPO_LARGURA);
        $oSit->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Exp', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Emb', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Qual', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Apontada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->setBComparacaoColuna(true);

        $oReclamacao = new CampoConsulta('Reclamação', 'reclamacao', CampoConsulta::TIPO_LARGURA);
        $oReclamacao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oReclamacao->addComparacao('Em análise', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, false, null);
        $oReclamacao->addComparacao('Transportadora', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oReclamacao->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oReclamacao->addComparacao('Interna', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_MARROM, CampoConsulta::MODO_COLUNA, false, null);
        $oReclamacao->addComparacao('Cliente', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oReclamacao->setBComparacaoColuna(true);

        $oDevolucao = new CampoConsulta('Devolução', 'devolucao', CampoConsulta::TIPO_TEXTO);
        $oDevolucao->addComparacao('Aceita', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->addComparacao('Indeferida', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->addComparacao('Não se aplica', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->setBComparacaoColuna(true);

        $oProcedencia = new CampoConsulta('Procede', 'procedencia', CampoConsulta::TIPO_TEXTO);
        $oProcedencia->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oProcedencia->addComparacao('PROCEDE', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oProcedencia->addComparacao('NÃO PROCEDE', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, false, null);
        $oProcedencia->setBComparacaoColuna(true);

        $oLibDevolucao = new CampoConsulta('Liberação', 'sollibdevolucao', CampoConsulta::TIPO_TEXTO);
////////////////////////////////////////////// DROPDOWNS //////////////////////////////////////////////////////////////////////////////////////////////

        $oDropDown = new Dropdown('Opções da reclamação', Dropdown::TIPO_PRIMARY);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'MET_QUAL_RcVenda', 'acaoMostraRelConsulta', '', false, 'rc', false, '', false, '', false, false);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Retornar', 'MET_QUAL_RcVenda', 'criaTelaModalRetorna', '', false, '', false, 'criaTelaModalRetorna', true, 'Retornar para o Representante', false, false);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_CHAVE) . 'Reabrir', 'MET_QUAL_RcVenda', 'reabrirRC', '', false, '', false, '', true, '', false, false);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Cancelar', 'MET_QUAL_RcVenda', 'criaTelaModalCancela', '', false, '', false, 'criaTelaModalCancela', true, 'Cancelar reclamação', false, false);

        $oDropDown1 = new Dropdown('Encaminhar E-mails', Dropdown::TIPO_INFO, Dropdown::ICON_EMAIL);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_QUAL) . 'Qualidade', 'MET_QUAL_RcVenda', 'verificaEmailSetor', '', false, 'Env.Qual', false, '', false, '', false, false);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_BOX) . 'Embalagem', 'MET_QUAL_RcVenda', 'verificaEmailSetor', '', false, 'Env.Emb', false, '', false, '', false, false);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_CART) . 'Expedição', 'MET_QUAL_RcVenda', 'verificaEmailSetor', '', false, 'Env.Exp', false, '', false, '', false, false);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Representante', 'MET_QUAL_RcVenda', 'verificaEmailSetor', '', false, 'Env.Rep', false, '', false, '', false, false);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Vendas - Jaques', 'MET_QUAL_RcVenda', 'solicitaLibDevolucao', '', false, '', false, '', true, '', false, false);

        $oDropDown2 = new Dropdown('Apontamentos', Dropdown::TIPO_AVISO);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Apontar reclamação', 'MET_QUAL_RcVenda', 'criaTelaModalApontamento', '', false, '', false, 'criaTelaModalApontamento', true, 'Apontar reclamação', false, false);


        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDown, $oDropDown1, $oDropDown2);

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilProdutos = new Filtro($oProd, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, true);

        $oFilOfficeDes = new Filtro($oOfficeDes, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilOfficeDes->addItemSelect('', 'TODOS');
        foreach ($this->getAParametrosExtras() as $key => $value) {
            $oFilOfficeDes->addItemSelect($value, $value);
        }

        $this->addFiltro($oFilNr, $oFilCli, $oFilProdutos, $oFilOfficeDes);
        if ($_SESSION['codUser'] == 19) {
            $this->addCampos($oBotaoModal, $oNr, $oSit, $oReclamacao, $oProcedencia, $oDevolucao, $oLibDevolucao, $oCliente, $oUser, $oOfficeDes, $oData, $oAnexo1, $oAnexo2, $oAnexo3, $oDataLibVendas, $oHoraLibVendas, $oDataLibAnalise, $oHoraLibAnalise);
        } else {
            $this->addCampos($oNr, $oSit, $oReclamacao, $oProcedencia, $oDevolucao, $oLibDevolucao, $oCliente, $oUser, $oOfficeDes, $oData, $oAnexo1, $oAnexo2, $oAnexo3, $oDataLibVendas, $oHoraLibVendas, $oDataLibAnalise, $oHoraLibAnalise);
        }


        $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $oAnaliseSetor = new Campo('Análise aprensentada pelo setor responsável', '', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oAnaliseSetor->setILinhasTextArea(6);
        $oAnaliseSetor->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAnaliseSetor->setBCampoBloqueado(true);

        $oProblema = new Campo('Problema descrito pelo Representante', '', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oProblema->setILinhasTextArea(6);
        $oProblema->setSCorFundo(Campo::FUNDO_MONEY);
        $oProblema->setBCampoBloqueado(true);


        $this->addCamposGrid($oProblema, $oAnaliseSetor, $oLinhaWhite);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_QUAL_RcVenda","carregaAnalise","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oAnaliseSetor->getId() . ',' . $oProblema->getId() . '"+","+"");');
    }

    public function criaTela() {
        parent::criaTela();

        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Empresa/Contato');
        $oTabGeral->setBActive(true);

        $oTabNF = new AbaTabPanel('Dados NF');
        $oTabProd = new AbaTabPanel('Produto');
        $oTabAnexos = new AbaTabPanel('Anexos');

        $this->addLayoutPadrao('Aba');

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oOfficeDes->setBCampoBloqueado(true);

        $oUsunome = new campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsunome->setBCampoBloqueado(true);

        $oDataIns = new Campo('Data do report', 'datains', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataIns->setBCampoBloqueado(true);

        $oHora = new campo('Hora do report', 'horains', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setBCampoBloqueado(true);

        $oDivisor3 = new Campo('Dados da Reclamação', 'dadosrec', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor3->setApenasTela(true);

        //situacao
        $oSituaca = new Campo('Situação', 'situaca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setBCampoBloqueado(true);

        //cliente
        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '3');
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setBFocus(true);

        $oEmpdes = new Campo('Cliente', 'empdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);

        //responsável por vendas
        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespVenda->setBCampoBloqueado(true);

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRespVendaNome->setBCampoBloqueado(true);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRep = new Campo('Código do Representante', 'repcod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRep->setBCampoBloqueado(true);

        $oDivisor2 = new Campo('Dados do cliente', 'clidados', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oContato = new campo('Contato', 'contato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oContato->addValidacao(FALSE, Validacao::TIPO_STRING, 5);

        $oCelular = new Campo('Celular *somente Nº', 'celular', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmail = new campo('E-mail', 'email', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmail->addValidacao(false, Validacao::TIPO_EMAIL);

        $oInd = new campo('Indústria', 'ind', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $oComer = new campo('Comércio', 'comer', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $ln = new Campo('', '', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $ln->setApenasTela(true);

        $oNf = new Campo('Nota fiscal', 'nf', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNf->setSCorFundo(Campo::FUNDO_MONEY);
        $oNf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', 2, 2, 12, 12);

        $oTagExcecao = new Campo(' <- Exceção, inserir sem LOTE', 'tagexcecao', Campo::TIPO_CHECK, 2, 2, 12, 12);

        $oDataNf = new Campo('Data.Nf', 'datanf', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOdCompra = new Campo('Od.Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPedido = new campo('Pedido', 'pedido', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValor = new campo('Valor', 'valor', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oValor->setBCampoBloqueado(true);

        $oPeso = new campo('Peso', 'peso', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oPeso->setBCampoBloqueado(true);

        $oLote = new Campo('Nº Lote', 'lote', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 2, 2, 12, 12);


        $oDescNaoConf = new Campo('Descrição da não conformidade', 'naoconf', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescNaoConf->setILinhasTextArea(5);
        $oDescNaoConf->setSCorFundo(Campo::FUNDO_MONEY);

/////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oProd = new campo('Produtos', 'produtos', Campo::TIPO_TAGS, 12, 12, 12, 12);
        $oProd->setILinhasTextArea(5);
        $oProd->setSCorFundo(Campo::FUNDO_AMARELO);

//////////////////////////////////////////////////////////////////////////////////////////////////////////////        


        $oAplicacao = new Campo('Problema', 'aplicacao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oAplicacao->setSCorFundo(Campo::FUNDO_VERMELHO);

        $oDivisor1 = new Campo('Dados da não conformidade', 'nconf', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDisposicao = new Campo('Disposição', 'disposicao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oDisposicao->addItenRadio('1', 'Aceita Condicionalmente');
        $oDisposicao->addItenRadio('2', 'Devolver');

        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        //seta ids uploads para enviar no request para limpar
        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId());

        $oTabGeral->addCampos(
                array($oRep, $oRespVendaNome, $oRespVenda), $oDivisor2, array($oEmpcod, $oEmpdes), array($oContato, $oCelular, $oEmail, $oInd, $oComer));

        $oTabNF->addCampos(
                array($oDataNf, $oOdCompra, $oPedido, $oValor, $oPeso), array($oLote, $oOp));

        $oTabProd->addCampos($oAplicacao, $oProd, $oDivisor1, $oDescNaoConf, array($oDisposicao));
        $oTabAnexos->addCampos(
                array($oAnexo1, $oAnexo2, $oAnexo3));

        $oTab->addItems($oTabGeral, $oTabNF, $oTabProd, $oTabAnexos);

        $this->addCampos(
                array($oNr, $oFilcgc, $oUsunome, $oOfficeDes, $oDataIns, $oHora), $oDivisor3, array($oNf, $oTagExcecao), $ln, $oTab);
    }

    public function criaModalApontamento($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->nr);
        $oNr->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oTipoRC = new Campo('Selecione o tipo da RC segundo análise e se sua devolução foi aceita ou recusada!', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oTipoRC->setApenasTela(true);

        $oReclamacao = new Campo('Tipo', 'reclamacao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oReclamacao->addItenRadio('Interna', 'Interna');
        $oReclamacao->addItenRadio('Representante', 'Representante');
        $oReclamacao->addItenRadio('Transportadora', 'Transportadora');
        $oReclamacao->addItenRadio('Representante', 'Representante');
        $oReclamacao->addItenRadio('Cliente', 'Cliente');

        $oGDevolucao = new Campo('Gerou devolução?', 'divisor2', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        $oGDevolucao->setApenasTela(true);

        $oDevolucao = new Campo('Devolução', 'devolucao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oDevolucao->addItenRadio('Aceita', 'Aceita');
        $oDevolucao->addItenRadio('Indeferida', 'Indeferida');
        $oDevolucao->addItenRadio('Não se aplica', 'Não se aplica');
        if ($oDados->devolucao != null) {
            $oDevolucao->setSValor($oDados->devolucao);
        }
        if ($oDados->disposicao == 1 && $oDados->devolucao == null) {
            $oDevolucao->setSValor('Não se aplica');
        }

        $oRcProcede = new Campo('RC Procede?', 'divisor3', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oRcProcede->setApenasTela(true);

        $oProcede = new Campo('Procedencia', 'procedencia', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oProcede->addItenRadio('PROCEDE', 'Procede');
        $oProcede->addItenRadio('NÃO PROCEDE', 'Não Procede');
        if ($oDados->procedencia != null) {
            $oProcede->setSValor($oDados->procedencia);
        }

        $oNfDevolucao = new Campo('NF Devolução', 'nfdevolucao', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValorDevolucaoSIPI = new Campo('NF s/ IPI', 'nfsIpi', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oValorFrete = new Campo('Frete', 'valorfrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oLinha1 = new Campo('', 'linha1', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oObs_aponta = new campo('Obs', 'obs_aponta', Campo::TIPO_TEXTAREA, 12);
        $oObs_aponta->setILinhasTextArea(8);
        $oObs_aponta->addValidacao(false, Validacao::TIPO_STRING, '', '10');
        $oObs_aponta->setSValor($oDados->obs_aponta);

        $oBtnApontar = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnApontar->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaReclamacao","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnApontar->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnApontar->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);
        $this->addCampos(array($oFilcgc, $oNr), $oLinha, $oTipoRC, array($oReclamacao), $oRcProcede, array($oProcede), $oGDevolucao, array($oDevolucao), array($oNfDevolucao, $oValorDevolucaoSIPI, $oValorFrete), $oLinha1, $oObs_aponta, $oBtnApontar);
    }

    public function criaModalApontamentoReaberta($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->nr);
        $oNr->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oTipoRC = new Campo('Selecione o tipo da RC segundo análise e se sua devolução foi aceita ou recusada!', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oTipoRC->setApenasTela(true);

        $oReclamacao = new Campo('Tipo', 'reclamacao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oReclamacao->addItenRadio('Interna', 'Interna');
        $oReclamacao->addItenRadio('Representante', 'Representante');
        $oReclamacao->addItenRadio('Transportadora', 'Transportadora');
        $oReclamacao->addItenRadio('Representante', 'Representante');
        $oReclamacao->addItenRadio('Cliente', 'Cliente');
        if ($oDados->reclamacao != null) {
            $oReclamacao->setSValor($oDados->reclamacao);
        }

        $oGDevolucao = new Campo('Gerou devolução?', 'divisor2', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        $oGDevolucao->setApenasTela(true);

        $oDevolucao = new Campo('Devolução', 'devolucao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oDevolucao->addItenRadio('Aceita', 'Aceita');
        $oDevolucao->addItenRadio('Indeferida', 'Indeferida');
        $oDevolucao->addItenRadio('Não se aplica', 'Não se aplica');
        if ($oDados->devolucao != null) {
            $oDevolucao->setSValor($oDados->devolucao);
        }
        if ($oDados->disposicao == 1 && $oDados->devolucao == null) {
            $oDevolucao->setSValor('Não se aplica');
        }

        $oRcProcede = new Campo('RC Procede?', 'divisor3', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oRcProcede->setApenasTela(true);

        $oProcede = new Campo('Procedencia', 'procedencia', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oProcede->addItenRadio('PROCEDE', 'Procede');
        $oProcede->addItenRadio('NÃO PROCEDE', 'Não Procede');
        if ($oDados->procedencia != null) {
            $oProcede->setSValor($oDados->procedencia);
        }

        $oNfDevolucao = new Campo('NF Devolução', 'nfdevolucao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        if ($oDados->nfdevolucao != null && $oDados->nfdevolucao != 0) {
            $oNfDevolucao->setSValor($oDados->nfdevolucao);
        }

        $oValorDevolucaoSIPI = new Campo('NF s/ IPI', 'nfsIpi', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        if ($oDados->nfsipi != null && $oDados->nfsipi != 0) {
            $oValorDevolucaoSIPI->setSValor($oDados->nfsipi);
        }

        $oValorFrete = new Campo('Frete', 'valorfrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        if ($oDados->valorfrete != null && $oDados->valorfrete != 0) {
            $oValorFrete->setSValor($oDados->valorfrete);
        }

        $oLinha1 = new Campo('', 'linha1', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oObs_aponta = new campo('Motivo da reabertura', 'motivo_reabriu', Campo::TIPO_TEXTAREA, 12);
        $oObs_aponta->setILinhasTextArea(8);
        $oObs_aponta->addValidacao(false, Validacao::TIPO_STRING, '', '10');

        $oBtnApontar = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnApontar->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaReclamacao","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnApontar->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnApontar->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);

        $this->addCampos(array($oFilcgc, $oNr), $oLinha, $oTipoRC, array($oReclamacao), $oRcProcede, array($oProcede), $oGDevolucao, array($oDevolucao), array($oNfDevolucao, $oValorDevolucaoSIPI, $oValorFrete), $oLinha1, $oObs_aponta, $oBtnApontar);
    }

    public function criaModalApontamentoNF($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->nr);
        $oNr->setBCampoBloqueado(true);

        $oNfDevolucao = new Campo('NF Devolução', 'nfdevolucao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oValorDevolucaoSIPI = new Campo('NF s/ IPI', 'nfsIpi', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oValorFrete = new Campo('Frete', 'valorfrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oApontaNF = new Campo('', 'apontaNF', Campo::TIPO_TEXTO);
        $oApontaNF->setSValor('Apontada');
        $oApontaNF->setBOculto(true);

        $oBtnReabrir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnReabrir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaNFReclamacao","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnReabrir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnReabrir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);

        $this->addCampos(array($oFilcgc, $oNr), array($oNfDevolucao, $oValorDevolucaoSIPI, $oValorFrete), array($oBtnReabrir, $oApontaNF));
    }

    /**
     * Cria modal para notificar em caso de erro do representante 
     */
    public function criaModalRetorna($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oObs_aponta = new campo('Descreva o porque de retornar ao representante', 'motivo', Campo::TIPO_TEXTAREA, 12);
        $oObs_aponta->setILinhasTextArea(8);
        $oObs_aponta->addValidacao(false, Validacao::TIPO_STRING, '', '10');

        $oBtnReabrir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnReabrir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","retornaEmailRep","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnReabrir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnReabrir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);

        $this->addCampos(array($oFilcgc, $oNr), $oLinha, $oObs_aponta, $oBtnReabrir);
    }

    public function criaModalApontaDevolucao($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oDevolucao = new Campo('Devolução', 'devolucao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oDevolucao->addItenRadio('Aceita', 'Aceita');
        $oDevolucao->addItenRadio('Indeferida', 'Indeferida');

        $oObsDevolucao = new Campo('Observação', 'obslibdevolucao', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObsDevolucao->setILinhasTextArea(3);
        $oObsDevolucao->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', '10', '200');

        $oBtnLiberar = new Campo('Liberar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnLiberar->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","liberaDevolucao","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnLiberar->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnLiberar->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);

        $this->addCampos(array($oFilcgc, $oNr), $oLinha, array($oDevolucao), array($oObsDevolucao), $oBtnLiberar);
    }

    /**
     * Cria modal para notificar em caso de erro do representante 
     */
    public function criaModalCancela($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oUsuCancela = new Campo('Usuário', 'usucancela', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuCancela->setSValor($_SESSION['nome']);
        $oUsuCancela->setBCampoBloqueado(true);

        $oObs_aponta = new campo('Descreva o motivo do CANCELAMENTO da RC', 'motivocancela', Campo::TIPO_TEXTAREA, 12);
        $oObs_aponta->setILinhasTextArea(8);
        $oObs_aponta->addValidacao(false, Validacao::TIPO_STRING, '', '10');

        $oBtnReabrir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnReabrir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","cancelaRC","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnReabrir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnReabrir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);

        $this->addCampos(array($oFilcgc, $oNr, $oUsuCancela), $oLinha, $oObs_aponta, $oBtnReabrir);
    }

}
