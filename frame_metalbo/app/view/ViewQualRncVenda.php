<?php

/*
 * Class que gerencia as view da classe QualRncVenda
 */

class ViewQualRncVenda extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(true);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_LARGURA);

        $oCliente = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);

        $oUser = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA);

        $oOfficeDes = new CampoConsulta('Representante', 'officedes', CampoConsulta::TIPO_LARGURA);

        $oData = new CampoConsulta('Data', 'datains', CampoConsulta::TIPO_DATA);

        $oSit = new CampoConsulta('Sit', 'situaca', CampoConsulta::TIPO_LARGURA);
        $oSit->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Env.Exp', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Env.Emb', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Env.Qual', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Apontada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oSit->setBComparacaoColuna(true);

        $oDevolucao = new CampoConsulta('Devolução', 'devolucao', CampoConsulta::TIPO_LARGURA);
        $oDevolucao->addComparacao('Aceita', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Recusada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Em análise', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oDevolucao->setBComparacaoColuna(true);

        $oDropDown = new Dropdown('Opções da reclamação', Dropdown::TIPO_PRIMARY);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'QualRncVenda', 'acaoMostraRelConsulta', '', false, 'rc');

        $oDropDown1 = new Dropdown('Encaminhar E-mails', Dropdown::TIPO_INFO, Dropdown::ICON_EMAIL);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_QUAL) . 'Qualidade', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Qual');
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_BOX) . 'Embalagem', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Emb');
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_CART) . 'Expedição', 'QualRncVenda', 'verificaEmailSetor', '', false, 'Env.Exp');

        $oDropDown2 = new Dropdown('Devolução', Dropdown::TIPO_AVISO);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Aceitar devolução', 'QualRncVenda', 'verifSitDevolucao', '', false, 'Aceitar');
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Recusar devolução', 'QualRncVenda', 'verifSitDevolucao', '', false, 'Recusar');

        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDown, $oDropDown1, $oDropDown2);

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3);
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1);

        $this->addFiltro($oFilNr, $oFilCli);
        $this->addCampos($oNr, $oSit, $oDevolucao, $oCliente, $oUser, $oOfficeDes, $oData);

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(true);
    }

    public function criaTela() {
        parent::criaTela();

        $aDadosTela = $this->getAParametrosExtras();

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oOfficecod = new Campo('', 'officecod', Campo::TIPO_TEXTO, 1);
        $oOfficecod->setSValor($_SESSION['repoffice']);
        $oOfficecod->setBCampoBloqueado(true);
        $oOfficecod->setBOculto(true);

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oOfficeDes->setSValor($_SESSION['repofficedes']);
        $oOfficeDes->setBCampoBloqueado(true);

        $oUsucodigo = new Campo('', 'usucodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsucodigo->setSValor($_SESSION['codUser']);
        $oUsucodigo->setBOculto(true);

        $oUsunome = new campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsunome->setSValor($_SESSION['nome']);
        $oUsunome->setBCampoBloqueado(true);

        $oDataIns = new Campo('Data do report', 'datains', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataIns->setSValor(date('d/m/Y'));
        $oDataIns->setBCampoBloqueado(true);

        $oHora = new campo('Hora do report', 'horains', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        //situacao
        $oSituaca = new Campo('Situação', 'situaca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setSValor('Aguardando');
        $oSituaca->setBCampoBloqueado(true);

        //cliente
        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '3');
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setBFocus(true);

        $oEmpdes = new Campo('Cliente', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getid());
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);

        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getid());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());


        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRespVendaNome->setBCampoBloqueado(true);


        $oField = new FieldSet('Informações');
        $oField->setOculto(true);
        $oField->addCampos(array($oNr, $oFilcgc, $oUsunome, $oOfficeDes), array($oRespVendaNome, $oDataIns, $oHora, $oSituaca, $oUsucodigo, $oOfficecod));

        $oFieldContato = new FieldSet('Informações contato');

        $oContato = new campo('Contato', 'contato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oContato->addValidacao(FALSE, Validacao::TIPO_STRING, 5);

        $oCelular = new Campo('Celular *somente Nº', 'celular', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmail = new campo('E-mail', 'email', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmail->addValidacao(false, Validacao::TIPO_EMAIL);

        $oInd = new campo('Indústria', 'ind', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $oComer = new campo('Comércio', 'comer', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $oFieldContato->addCampos(array($oContato, $oCelular, $oEmail, $oInd, $oComer));

        /* dados da nota fiscal */
        $oFieldNf = new FieldSet('Nota fiscal');

        $oNf = new Campo('Nota fiscal', 'nf', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNf->setSCorFundo(Campo::FUNDO_MONEY);

        $oNf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', 2, 2, 12, 12);

        $oDataNf = new Campo('Data.Nf', 'datanf', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOdCompra = new Campo('Od.Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPedido = new campo('Pedido', 'pedido', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValor = new campo('Valor', 'valor', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oPeso = new campo('Peso', 'peso', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","QualRnc","buscaNf","' . $oDataNf->getId() . ',' . $oValor->getId() . ',' . $oPeso->getId() . '");';

        $oNf->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oFieldNf->addCampos(array($oNf, $oDataNf, $oOdCompra, $oPedido, $oValor, $oPeso));

        $oFieldEmb = new FieldSet('Embalagem');

        $oLote = new Campo('Nº Lote', 'lote', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oFieldEmb->addCampos(array($oLote, $oOp));

        $oDescNaoConf = new Campo('Descrição da não conformidade', 'naoconf', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescNaoConf->setILinhasTextArea(5);
        $oDescNaoConf->setSCorFundo(Campo::FUNDO_MONEY);

        $oDadosProduto = new FieldSet('Dados do produto');

        //campo código do produto
        $oCodigo = new Campo('Codigo', 'procod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodigo->setITamanho(Campo::TAMANHO_PEQUENO);

        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto', 'prodes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oProdes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '', '');
        $oProdes->addCampoBusca('prodes', '', '');
        $oProdes->setSIdTela($this->getTela()->getid());

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('Produto');
        $oCodigo->setSCampoRetorno('procod', $this->getTela()->getId());
        $oCodigo->addCampoBusca('prodes', $oProdes->getId(), $this->getTela()->getId());

        $oAplicacao = new Campo('Aplicação', 'aplicacao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oAplicacao->setSCorFundo(Campo::FUNDO_VERMELHO);

        $oQuant = new Campo('Quantidade', 'quant', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oQuanNconf = new Campo('Quant. não conforme', 'quantnconf', Campo::TIPO_TEXTO, 2, 2, 12, 12);


        $oDadosProduto->addCampos(array($oCodigo, $oProdes, $oQuant, $oAplicacao), array($oQuanNconf));

        $oAnexos = new FieldSet('Anexos');

        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexos->addCampos(array($oAnexo1, $oAnexo2, $oAnexo3));
        $oAnexos->setOculto(true);

        //seta ids uploads para enviar no request para limpar
        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId());

        $this->addCampos($oField, array($oEmpcod, $oEmpdes), $oFieldContato, $oFieldNf, $oFieldEmb, $oDescNaoConf, $oDadosProduto, $oAnexos);
        //array($oRespVenda, $oRespVendaNome)
    }

}
