<?php

/*
 * Class que gerencia as view da classe MET_QUAL_RcVenda
 */

class ViewMET_QUAL_RcAnalise extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setiLarguraGrid(3150);

        $this->getTela()->setIAltura(550);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_LARGURA);
        $oNr->setILargura(10);

        $oCliente = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);
        $oCliente->setILargura(100);

        $oUser = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA);
        $oUser->setILargura(20);

        $oOfficeDes = new CampoConsulta('Representante', 'officedes', CampoConsulta::TIPO_LARGURA);
        $oOfficeDes->setILargura(40);

        $oData = new CampoConsulta('Data', 'datains', CampoConsulta::TIPO_DATA);
        $oData->setILargura(20);

        $oProd = new CampoConsulta('Produtos', 'produtos');
        $oProd->setILargura(150);

        $oAnexo1 = new CampoConsulta('Anexo 1', 'anexo1', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo2 = new CampoConsulta('Anexo 2', 'anexo2', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo3 = new CampoConsulta('Anexo 3', 'anexo3', CampoConsulta::TIPO_DOWNLOAD);


        $oSit = new CampoConsulta('Sit. Geral', 'situaca', CampoConsulta::TIPO_LARGURA);
        $oSit->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Exp', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Emb', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Qual', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Apontada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA, false, null);
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
        $oDevolucao->addComparacao('Recusada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->addComparacao('N/ se aplica', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oDevolucao->setBComparacaoColuna(true);

        $oProcedencia = new CampoConsulta('Procede', 'procedencia', CampoConsulta::TIPO_TEXTO);
        $oProcedencia->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oProcedencia->addComparacao('PROCEDE', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oProcedencia->addComparacao('NÃO PROCEDE', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_LINHA, false, null);
        $oProcedencia->setBComparacaoColuna(true);


        $oDropDown = new Dropdown('Apontar análise', Dropdown::TIPO_AVISO);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Apontar análise', 'MET_QUAL_RcAnalise', 'criaTelaModalAponta', '', false, '', false, 'criaTelaModalAponta', true, 'Apontar análise', false, false);

        $oDropDown2 = new Dropdown('Opções da reclamação', Dropdown::TIPO_PRIMARY);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'MET_QUAL_RcVenda', 'acaoMostraRelConsulta', '', false, 'rc', false, '', false, '', false, false);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Reenviar e-mail', 'MET_QUAL_RcAnalise', 'reenviaEmailRC', '', false, '', false, '', false, '', false, false);

        $oDropDown3 = new Dropdown('Inspeção', Dropdown::TIPO_ERRO, Dropdown::ICON_CHECK);
        $oDropDown3->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Apontar inspeção', 'MET_QUAL_RcAnalise', 'criaTelaModalApontaInspecao', '', false, '', false, 'criaTelaModalApontaInspecao', true, 'Resultados de Inspeção de Recebimento da Reclamação', false, false);

        $this->setUsaDropdown(true);
        if ($_SESSION['codsetor'] == 25) {
            $this->addDropdown($oDropDown, $oDropDown2, $oDropDown3);
        } else {
            $this->addDropdown($oDropDown, $oDropDown2);
        }

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilProdutos = new Filtro($oProd, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $this->addFiltro($oFilNr, $oFilCli, $oFilProdutos);

        $this->addCampos($oNr, $oSit, $oReclamacao, $oProcedencia, $oDevolucao, $oCliente, $oProd, $oUser, $oOfficeDes, $oData, $oAnexo1, $oAnexo2, $oAnexo3);



        if ($_SESSION['codsetor'] == 25) {
            $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);


            $oInspecao = new Campo('Inspeção', '', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
            $oInspecao->setILinhasTextArea(6);
            $oInspecao->setSCorFundo(Campo::FUNDO_MONEY);
            $oInspecao->setBCampoBloqueado(true);

            $oCorrecao = new Campo('Correção', '', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
            $oCorrecao->setILinhasTextArea(6);
            $oCorrecao->setSCorFundo(Campo::FUNDO_MONEY);
            $oCorrecao->setBCampoBloqueado(true);


            $this->addCamposGrid($oInspecao, $oCorrecao, $oLinhaWhite);

            $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                    . 'requestAjax("","MET_QUAL_RcAnalise","carregaInspecao","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oInspecao->getId() . ',' . $oCorrecao->getId() . '"+","+"");');
        }
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

        $oOfficecod = new Campo('', 'officecod', Campo::TIPO_TEXTO, 1);
        $oOfficecod->setBCampoBloqueado(true);
        $oOfficecod->setBOculto(true);

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oOfficeDes->setBCampoBloqueado(true);

        $oUsucodigo = new Campo('', 'usucodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsucodigo->setBOculto(true);

        $oUsunome = new campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsunome->setBCampoBloqueado(true);

        $oDataIns = new Campo('Data do report', 'datains', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataIns->setBCampoBloqueado(true);

        $oHora = new campo('Hora do report', 'horains', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        $oHora->setBCampoBloqueado(true);

        $oDivisor3 = new Campo('Dados da Reclamação', 'dadosrec', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor3->setApenasTela(true);

        //situacao
        $oSituaca = new Campo('Situação', 'situaca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setBCampoBloqueado(true);

        //cliente
        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmpdes = new Campo('Cliente', 'empdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        //responsável por vendas
        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRespVenda->setBCampoBloqueado(true);

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRespVendaNome->setBCampoBloqueado(true);

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

        $oValor = new campo('Valor', 'valor', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oPeso = new campo('Peso', 'peso', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oLote = new Campo('Nº Lote', 'lote', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oDescNaoConf = new Campo('Descrição da não conformidade', 'naoconf', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescNaoConf->setILinhasTextArea(5);
        $oDescNaoConf->setSCorFundo(Campo::FUNDO_MONEY);

        $oProd = new campo('Produtos', 'produtos', Campo::TIPO_TAGS, 12, 12, 12, 12);
        $oProd->setILinhasTextArea(5);
        $oProd->setSCorFundo(Campo::FUNDO_AMARELO);

        $oAplicacao = new Campo('Aplicação/Avaria', 'aplicacao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oAplicacao->setSCorFundo(Campo::FUNDO_VERMELHO);

        $oDivisor1 = new Campo('Dados da não conformidade', 'nconf', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDisposicao = new Campo('Disposição', 'disposicao', Campo::TIPO_RADIO, 6, 6, 12, 12);
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

    /**
     * Cria modal para finalizar reclamação de cliente
     */
    public function criaModalAponta($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oUsuAponta = new campo('Usuário', 'usuaponta', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oUsuAponta->setSValor($_SESSION['nome']);
        $oUsuAponta->setBCampoBloqueado(true);

        $oUsercausa = new Campo('...', 'numcad', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oUsercausa->setBDisabled(true);

        $oPessoacausa = new Campo('Quem causou', 'nomfun', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oPessoacausa->setSIdPk($oUsercausa->getId());
        $oPessoacausa->setClasseBusca('MET_CAD_Funcionarios');
        $oPessoacausa->addCampoBusca('numcad', '', '');
        $oPessoacausa->addCampoBusca('nomfun', '', '');
        $oPessoacausa->setSIdTela($this->getTela()->getid());
        $oPessoacausa->setApenasTela(true);
        $oPessoacausa->addValidacao(true, string, '', 10, 200);

        $oUsercausa->setClasseBusca('MET_CAD_Funcionarios');
        $oUsercausa->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oUsercausa->addCampoBusca('nomfun', $oPessoacausa->getId(), $this->getTela()->getId());

        $oRcProcede = new Campo('RC Procede?', 'divisor3', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oRcProcede->setApenasTela(true);

        $oProcede = new Campo('Procedencia', 'procedencia', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oProcede->addItenRadio('PROCEDE', 'Procede');
        $oProcede->addItenRadio('NÃO PROCEDE', 'Não Procede');

        $oApontamento = new campo('Apontar análise', 'apontamento', Campo::TIPO_TEXTAREA, 12);
        $oApontamento->setILinhasTextArea(8);
        $oApontamento->addValidacao(false, Validacao::TIPO_STRING, '', '2', '999');

        $oAnexo = new Campo('Anexo', 'anexo_analise', Campo::TIPO_UPLOAD, 6, 6, 12, 12);
        $oAnexo1 = new campo('Anexo', 'anexo_analise1', campo::TIPO_UPLOAD, 6, 6, 12, 12);

        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaRC","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);

        $this->addCampos(array($oFilcgc, $oNr, $oUsuAponta), array($oUsercausa, $oPessoacausa), $oRcProcede, array($oProcede), $oApontamento, array($oAnexo, $oAnexo1), $oBtnInserir);
    }

    public function criaModalApontaInspecao($sDados) {
        parent::criaModal();


        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oUsuAponta = new Campo('Usuário', 'resp_disposicao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oUsuAponta->setSValor($_SESSION['nome']);
        $oUsuAponta->setBCampoBloqueado(true);

        $oData = new Campo('Data dispoção', 'data_disposicao', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oData->setSValor(date('d/m/Y'));

        $oHora = new Campo('Hora disposição', 'hora_disposicao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHora->setSValor(date('H:i:s'));
        $oHora->setBCampoBloqueado(true);

        $oCorrecao = new Campo('Correção', 'correcao', Campo::CAMPO_SELECTSIMPLE, 3, 3, 12, 12);
        $oCorrecao->addItemSelect('Devolver', 'Devolver');
        $oCorrecao->addItemSelect('Aprovar com desvio', 'Aprovar com desvio');
        $oCorrecao->addItemSelect('Reclassificar', 'Reclassificar');
        $oCorrecao->addItemSelect('Retrabalhar', 'Retrabalhar');
        $oCorrecao->addItemSelect('Sucatear', 'Sucatear');
        $oCorrecao->addItemSelect('Outra', 'Outra');

        $oAnexo1 = new Campo('Anexo 1', 'anexo_inspecao', Campo::TIPO_UPLOAD, 6, 6, 12, 12);
        $oAnexo2 = new Campo('Anexo 2', 'anexo_inspecao1', Campo::TIPO_UPLOAD, 6, 6, 12, 12);

        $oApontamento = new Campo('Apontar inspeção', 'inspecao', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oApontamento->setILinhasTextArea(3);
        $oApontamento->addValidacao(false, Validacao::TIPO_STRING, '', '2', '999');

        $oObs = new Campo('Observação', 'obs_inspecao', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObs->setILinhasTextArea(3);

        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaInspecaoRC","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);


        $this->addCampos(array($oFilcgc, $oNr, $oUsuAponta, $oData, $oHora), $oCorrecao, array($oAnexo1, $oAnexo2), array($oApontamento, $oObs), $oBtnInserir);
    }

}
