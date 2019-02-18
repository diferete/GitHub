<?php

/*
 * Class que gerencia as view da classe QualRncVenda
 */

class ViewQualRncVenda extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setiLarguraGrid(2000);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_LARGURA);

        $oCliente = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);

        $oUser = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA);

        $oOfficeDes = new CampoConsulta('Representante', 'officedes', CampoConsulta::TIPO_LARGURA);

        $oData = new CampoConsulta('Data', 'datains', CampoConsulta::TIPO_DATA);

        $oAnexo1 = new CampoConsulta('Anexo 1', 'anexo1', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo2 = new CampoConsulta('Anexo 2', 'anexo2', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo3 = new CampoConsulta('Anexo 3', 'anexo3', CampoConsulta::TIPO_DOWNLOAD);



////////////////////////////////////////////// COLUNAS DE SITUAÇÃO /////////////////////////////////////////////////////////////////////////////

        $oSit = new CampoConsulta('Sit', 'situaca', CampoConsulta::TIPO_LARGURA);
        $oSit->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Env.Exp', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Env.Emb', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Env.Qual', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Apontada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSit->setBComparacaoColuna(true);

        $oReclamacao = new CampoConsulta('Reclamação', 'reclamacao', CampoConsulta::TIPO_LARGURA);
        $oReclamacao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oReclamacao->addComparacao('Em análise', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oReclamacao->addComparacao('Transportadora', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oReclamacao->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oReclamacao->addComparacao('Interna', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_MARROM, CampoConsulta::MODO_COLUNA);
        $oReclamacao->addComparacao('Cliente', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oReclamacao->setBComparacaoColuna(true);

        $oDevolucao = new CampoConsulta('Devolução', 'devolucao', CampoConsulta::TIPO_LARGURA);
        $oDevolucao->addComparacao('Aceita', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Recusada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oDevolucao->setBComparacaoColuna(true);



////////////////////////////////////////////// DROPDOWNS //////////////////////////////////////////////////////////////////////////////////////////////

        $oDropDown = new Dropdown('Opções da reclamação', Dropdown::TIPO_PRIMARY);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'QualRncVenda', 'acaoMostraRelConsulta', '', false, 'rc');
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Retornar', 'QualRncVenda', 'retornaRep', '', false, '');

        $oDropDown1 = new Dropdown('Encaminhar E-mails', Dropdown::TIPO_INFO, Dropdown::ICON_EMAIL);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_QUAL) . 'Qualidade', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Qual');
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_BOX) . 'Embalagem', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Emb');
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_CART) . 'Expedição', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Exp');
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_MARTELO) . 'Representante', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Rep');

        $oDropDown2 = new Dropdown('Apontamentos', Dropdown::TIPO_AVISO);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Apontar reclamação', 'QualRncVenda', 'criaTelaModalApontamento', '', false, '', false, 'criaTelaModalApontamento', true, 'Apontar reclamação');
        //$oDropDown2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Aceitar devolução', 'QualRncVenda', 'criaTelaModalAccReclamacao', '', false, '1', false, 'criaTelaModalAccReclamacao', true, 'Aceitar Devolução');
        //$oDropDown2->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Recusar devolução', 'QualRncVenda', 'criaTelaModalRecReclamacao', '', false, '2', false, 'criaTelaModalRecReclamacao', true, 'Recusar Devolução');        
        //$oDropDown2->addItemDropdown($this->addIcone(Base::ICON_CART) . 'Transportadora', 'QualRncVenda', 'criaTelaModalApontaTransportadora', '', false, '2', false, 'criaTelaModalApontaTransportadora', true, 'Transportadora');
        //$oDropDown2->addItemDropdown($this->addIcone(Base::ICON_CART) . 'Representante', 'QualRncVenda', 'criaTelaModalApontaRepresentante', '', false, '2', false, 'criaTelaModalApontaRepresentante', true, 'Representante');
        //$oDropDown2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Aceitar devolução', 'QualRncVenda', 'verifSitReclamacao', '', false, 'Aceitar');
        //$oDropDown2->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Recusar devolução', 'QualRncVenda', 'verifSitReclamacao', '', false, 'Recusar');

        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDown, $oDropDown1, $oDropDown2);

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3);
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1);

        $this->addFiltro($oFilNr, $oFilCli);
        $this->addCampos($oNr, $oSit, $oReclamacao, $oDevolucao, $oCliente, $oUser, $oOfficeDes, $oData, $oAnexo1, $oAnexo2, $oAnexo3);

        $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $oAnaliseSetor = new Campo('Análise aprensentada pelo setor responsável', '', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oAnaliseSetor->setILinhasTextArea(6);
        $oAnaliseSetor->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAnaliseSetor->setBCampoBloqueado(true);


        $this->addCamposGrid($oAnaliseSetor, $oLinhaWhite);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","QualRncVenda","carregaAnalise","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oAnaliseSetor->getId() . '"+","+"");');

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
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


        $oAplicacao = new Campo('Aplicação', 'aplicacao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oAplicacao->setSCorFundo(Campo::FUNDO_VERMELHO);

        $oDivisor1 = new Campo('Dados da não conformidade', 'nconf', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oDisposicao = new Campo('Disposição', 'disposicao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oDisposicao->addItenRadio('1', 'Acc. Condicionalmente');
        $oDisposicao->addItenRadio('2', 'Recusar');

        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        //seta ids uploads para enviar no request para limpar
        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId());

        $oTabGeral->addCampos(
                array($oRep, $oRespVendaNome, $oRespVenda), $oDivisor2, array($oEmpcod, $oEmpdes), array($oContato, $oCelular, $oEmail, $oInd, $oComer));

        $oTabNF->addCampos(
                array($oDataNf, $oOdCompra, $oPedido, $oValor, $oPeso), array($oLote, $oOp));

        $oTabProd->addCampos($oAplicacao, $oProd, $oDivisor1, array($oDisposicao), $oDescNaoConf);
        $oTabAnexos->addCampos(
                array($oAnexo1, $oAnexo2, $oAnexo3));

        $oTab->addItems($oTabGeral, $oTabNF, $oTabProd, $oTabAnexos);

        $this->addCampos(
                array($oNr, $oFilcgc, $oUsunome, $oOfficeDes, $oDataIns, $oHora), $oDivisor3, array($oNf), $ln, $oTab);
    }

    /**
     * Cria modal para notificar em caso de erro do representante 
     */
    public function criaModalApontamento($sDados) {
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
        
        $oTipoRnc = new Campo('Selecione o tipo da RNC segundo análise e se sua devolução foi aceita ou recusada!', 'divisor1', Campo::DIVISOR_INFO,12,12,12,12);
        $oTipoRnc->setApenasTela(true);

        $oReclamacao = new Campo('Tipo', 'reclamacao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oReclamacao->addItenRadio('Interna', 'Interna');
        $oReclamacao->addItenRadio('Representante', 'Representante');
        $oReclamacao->addItenRadio('Transportadora', 'Transportadora');
        $oReclamacao->addItenRadio('Representante', 'Representante');
        $oReclamacao->addItenRadio('Cliente', 'Cliente');


        $oDevolucao = new Campo('Devolução', 'devolucao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oDevolucao->addItenRadio('Aceita', 'Aceita');
        $oDevolucao->addItenRadio('Recusada', 'Recusada');

        $oLinha1 = new Campo('', 'linha1', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oObs_aponta = new campo('Obs', 'obs_aponta', Campo::TIPO_TEXTAREA, 12);
        $oObs_aponta->setILinhasTextArea(8);
        $oObs_aponta->addValidacao(false, Validacao::TIPO_STRING, '', '10');

        $oBtnInserir = new Campo('Apontar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaReclamacao","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);


        $this->addCampos(array($oFilcgc, $oNr), $oLinha,$oTipoRnc, array($oReclamacao, $oDevolucao), $oLinha1, $oObs_aponta, $oBtnInserir);
    }

}
