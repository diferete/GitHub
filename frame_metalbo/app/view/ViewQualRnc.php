<?php

/*
 * Implemanta a view da classe QualRnc
 * @author Avanei Martendal
 * @since 10/09/2017
 */

class ViewQualRnc extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oNr->setILargura(10);

        $oCliente = new CampoConsulta('Cliente', 'empdes');

        $oUser = new CampoConsulta('Usuário', 'usunome');
        $oUser->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA);
        $oUser->setBComparacaoColuna(true);

        $oOfficeDes = new CampoConsulta('Representante', 'officedes');

        $oData = new CampoConsulta('Data', 'datains', CampoConsulta::TIPO_DATA);

        $oSit = new CampoConsulta('Sit', 'situaca');
        $oSit->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);

        $oDevolucao = new CampoConsulta('Devolução', 'devolucao');
        $oDevolucao->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Aprovada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oDevolucao->addComparacao('Recusada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oDevolucao->setBComparacaoColuna(true);

        $oDropDow = new Dropdown('Opções da reclamação', Dropdown::TIPO_PRIMARY);
        $oDropDow->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'QualRnc', 'acaoMostraRelConsulta', '', false, 'rc');
        $oDropDow->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Liberar Metalbo', 'QualRnc', 'envMailGrid', '', false, 'rc,email,QualRnc,enviaEmailRnc');


        $oDropDow1 = new Dropdown('Finalizar reclamação', Dropdown::TIPO_AVISO);
        $oDropDow1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Finalizar', 'QualRnc', 'criaTelaModalFinaliza', '', false, '', false, 'criaTelaModalFinaliza', true, 'Finalizar Reclamação');

        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDow, $oDropDow1);

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3);
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1);

        $this->addFiltro($oFilNr, $oFilCli);
        $this->addCampos($oNr, $oCliente, $oUser, $oOfficeDes, $oData, $oSit, $oDevolucao);

        $this->setBScrollInf(true);
        $this->setUsaAcaoExcluir(false);
    }

    public function criaTela() {
        parent::criaTela();

        $aDadosTela = $this->getAParametrosExtras();

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);

        $oDevolucao = new Campo('', 'devolucao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDevolucao->setSValor('Aguardando');
        $oDevolucao->setBCampoBloqueado(true);
        $oDevolucao->setBOculto(true);


        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oOfficecod = new Campo('', 'officecod', Campo::TIPO_TEXTO, 1);
        $oOfficecod->setSValor($_SESSION['repoffice']);
        $oOfficecod->setBCampoBloqueado(true);
        $oOfficecod->setBOculto(true);

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oOfficeDes->setSValor($_SESSION['repofficedes']);
        $oOfficeDes->setBCampoBloqueado(true);

        $oUsucodigo = new Campo('', 'usucodigo', Campo::TIPO_TEXTO, 1);
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

        //responsável por vendas
        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespVenda->setBFocus(true);
        $oRespVenda->setSValor($aDadosTela[0]);
        $oRespVenda->setBCampoBloqueado(true);


        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespVendaNome->setSIdPk($oRespVenda->getId());
        $oRespVendaNome->setClasseBusca('User');
        $oRespVendaNome->addCampoBusca('usucodigo', '', '');
        $oRespVendaNome->addCampoBusca('usunome', '', '');
        $oRespVendaNome->setSIdTela($this->getTela()->getid());
        $oRespVendaNome->setSValor($aDadosTela[1]);
        $oRespVendaNome->setBCampoBloqueado(true);


        $oRespVenda->setClasseBusca('User');
        $oRespVenda->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oRespVenda->addCampoBusca('usunome', $oRespVendaNome->getId(), $this->getTela()->getId());


        $oField = new FieldSet('Informações');
        $oField->setOculto(true);
        $oField->addCampos(array($oNr, $oFilcgc, $oUsunome, $oOfficeDes), array($oRespVenda, $oRespVendaNome, $oDataIns, $oHora, $oSituaca, $oUsucodigo, $oOfficecod, $oDevolucao));

        $oFieldContato = new FieldSet('Informações contato');

        $oContato = new campo('Contato', 'contato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oContato->addValidacao(FALSE, Validacao::TIPO_STRING, 5);

        $oCelular = new Campo('Celular *somente Nº', 'celular', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmail = new campo('E-mail', 'email', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmail->addValidacao(false, Validacao::TIPO_EMAIL);

        $oInd = new campo('Indústria', 'ind', Campo::TIPO_CHECK, 1);
        $oInd->setIMarginTop(15);
        $oComer = new campo('Comércio', 'comer', Campo::TIPO_CHECK, 1);
        $oComer->setIMarginTop(15);

        $oFieldContato->addCampos(array($oContato, $oCelular, $oEmail, $oInd, $oComer));

        /* dados da nota fiscal */
        $oFieldNf = new FieldSet('Nota fiscal');

        $oNf = new Campo('Nota fiscal', 'nf', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNf->setSCorFundo(Campo::FUNDO_MONEY);
        $oNf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', 2);

        $oDataNf = new Campo('Data.Nf', 'datanf', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOdCompra = new Campo('Od.Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPedido = new campo('Pedido', 'pedido', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValor = new campo('Valor', 'valor', Campo::TIPO_MONEY, 1, 1, 12, 12);

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
        $oProdes = new Campo('Produto', 'prodes', Campo::TIPO_BUSCADOBANCO, 3);
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

        $oAplicacao = new Campo('Aplicação', 'aplicacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oQuant = new Campo('Quantidade', 'quant', Campo::TIPO_MONEY, 1, 1, 12, 12);

        $oQuanNconf = new Campo('Quant. não conforme', 'quantnconf', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oAceito = new Campo('Aceito condicionalmente', 'aceitocond', Campo::TIPO_CHECK, 2);
        $oAceito->setIMarginTop(15);

        $oReprovar = new Campo('Reprovar', 'reprovar', Campo::TIPO_CHECK, 2);
        $oReprovar->setIMarginTop(15);

        $oDadosProduto->addCampos(array($oCodigo, $oProdes, $oQuant, $oAplicacao), array($oQuanNconf, $oAceito, $oReprovar));


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

    /**
     * Cria modal para finalizar reclamação de cliente
     */

    /**
     * Função para cria a tela modal para vizualizar a proposta
     */
    public function criaModalFinaliza($sDados) {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 3);
        $oFilcgc->setSValor($oDados->getFilcgc());
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oObs_fim = new campo('Obs', 'obs_fim', Campo::TIPO_TEXTAREA, 12);
        $oObs_fim->setILinhasTextArea(8);



        $oBtnInserir = new Campo('Apontar aprovação', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","finalizaRnc","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->setBTela(true);


        $this->addCampos(array($oFilcgc, $oNr), $oObs_fim, $oBtnInserir);
    }

}
