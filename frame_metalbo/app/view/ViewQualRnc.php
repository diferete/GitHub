<?php

/*
 * Implemanta a view da classe QualRnc
 * @author Avanei Martendal
 * @since 10/09/2017
 */

class ViewQualRnc extends View {

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
        $oDevolucao->addComparacao('Transportadora', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oDevolucao->setBComparacaoColuna(true);

        $oDropDown = new Dropdown('Liberações', Dropdown::TIPO_PRIMARY);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Liberar Metalbo', 'QualRnc', 'liberarMetalbo', '', false, 'rc', false, '', false, '', true);

        $oDropDown1 = new Dropdown('Finalizar reclamação', Dropdown::TIPO_AVISO);
        $oDropDown1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Finalizar', 'QualRnc', 'criaTelaModalFinaliza', '', false, '', false, 'criaTelaModalFinaliza', true, 'Finalizar Reclamação');

        $oDropDown2 = new Dropdown('Opções da Reclamação', Dropdown::TIPO_INFO, Dropdown::ICON_INFO);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'QualRnc', 'acaoMostraRelConsulta', '', false, 'rc');
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Reenviar e-mail', 'QualRnc', 'reenviaEmail', '', false, '');

        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDown, $oDropDown2, $oDropDown1);


        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1);

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3);

        $this->addFiltro($oFilNr, $oFilCli);
        $this->addCampos($oNr, $oSit, $oDevolucao, $oCliente, $oUser, $oOfficeDes, $oData,$oAnexo1,$oAnexo2,$oAnexo3);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
    }

    public function criaTela() {
        parent::criaTela();

        $oDadosRep = $this->getOObjTela();

        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Empresa/Contato');
        $oTabGeral->setBActive(true);

        $oTabNF = new AbaTabPanel('Dados NF');
        $oTabAnexos = new AbaTabPanel('Anexos');

        $this->addLayoutPadrao('Aba');

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);

        $oDevolucao = new Campo('', 'devolucao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDevolucao->setSValor('Aguardando');
        $oDevolucao->setBCampoBloqueado(true);
        $oDevolucao->setBOculto(true);


        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oOfficecod = new Campo('', 'officecod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOfficecod->setSValor($_SESSION['repoffice']);
        $oOfficecod->setBCampoBloqueado(true);
        $oOfficecod->setBOculto(true);

        $oOfficeDes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
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

        $oDivisor3 = new Campo('Dados da Reclamação', 'dadosrec', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor3->setApenasTela(true);

        //situacao
        $oSituaca = new Campo('', 'situaca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setSValor('Aguardando');
        $oSituaca->setBCampoBloqueado(true);
        $oSituaca->setBOculto(true);


        //responsável por vendas
        $oRespVenda = new campo('', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespVenda->setBCampoBloqueado(true);
        $oRespVenda->setBOculto(true);

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRespVendaNome->setBCampoBloqueado(true);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');


        $oRep = new Campo('Código do Representante', 'repcod', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oRep->addItemSelect('Cod. Representante', 'Cod. Representante');
        foreach ($oDadosRep as $key => $oRepCodObj) {
            $oRep->addItemSelect($oRepCodObj->getRepcod(), $oRepCodObj->getRepcod());
        }
        $oRep->addValidacao(false, Validacao::TIPO_STRING, 'Selecione código de representante', '2', '3');

        $sAcaoRespVenda = 'buscaRespVenda($("#' . $oRep->getId() . '").val(),'
                . '"' . $oRespVenda->getId() . '",'
                . '"' . $oRespVendaNome->getId() . '",'
                . '"' . $this->getController() . '")';

        $oRep->addEvento(Campo::EVENTO_CHANGE, $sAcaoRespVenda);


        $oDivisor2 = new Campo('Dados do cliente', 'clidados', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        //cliente
        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new Campo('Cliente', 'empdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmpdes->setBCampoBloqueado(true);

        $oContato = new campo('Contato', 'contato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oContato->addValidacao(FALSE, Validacao::TIPO_STRING, 'Campo obrigatório!', '5');

        $oCelular = new Campo('Fone *somente Nº', 'celular', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmail = new campo('E-mail', 'email', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmail->addValidacao(false, Validacao::TIPO_EMAIL);

        $oInd = new campo('Indústria', 'ind', Campo::TIPO_CHECK, 1);

        $oComer = new campo('Comércio', 'comer', Campo::TIPO_CHECK, 1);

        $ln = new Campo('', '', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $ln->setApenasTela(true);

        $oNf = new Campo('Nrº Nota fiscal', 'nf', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNf->setSCorFundo(Campo::FUNDO_MONEY);
        $oNf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '2');

        $oDataNf = new Campo('Data.Nf', 'datanf', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDataNf->setBCampoBloqueado(true);

        $oOdCompra = new Campo('Od.Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPedido = new campo('Pedido', 'pedido', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValor = new campo('Valor', 'valor', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oValor->setBCampoBloqueado(true);

        $oPeso = new campo('Peso', 'peso', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oPeso->setBCampoBloqueado(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","QualRnc","buscaNf","' . $oDataNf->getId() . ',' . $oValor->getId() . ',' . $oPeso->getId() . ',' . $oEmpcod->getId() . ',' . $oEmpdes->getId() . '");';

        $oNf->addEvento(Campo::EVENTO_SAIR, $sCallBack);


        $oLote = new Campo('Nº Lote', 'lote', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        //campo código do produto
        $oCodigo = new Campo('Codigo', 'procod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodigo->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '4');


        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto', 'prodes', Campo::TIPO_BUSCADOBANCO, 5, 5, 12, 12);
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

        $oAplicacao = new Campo('Aplicação', 'aplicacao', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oAplicacao->addItemSelect('Oxidação branca', 'Oxidação branca');
        $oAplicacao->addItemSelect('Oxidação vermelha', 'Oxidação vermelha');
        $oAplicacao->addItemSelect('Embalagem diferente da etiqueta', 'Embalagem diferente da etiqueta');
        $oAplicacao->addItemSelect('Produto misturado', 'Produto misturado');
        $oAplicacao->addItemSelect('Quantidade errada', 'Quantidade errada');
        $oAplicacao->addItemSelect('Envio de produto errado', 'Envio de produto errado');
        $oAplicacao->addItemSelect('Entrega de produto errado', 'Entrega de produto errado');
        $oAplicacao->addItemSelect('Produto com trinca', 'Prod. com trinca');
        $oAplicacao->addItemSelect('Quantidade enviada diferente do pedido', 'Quant enviada diferente do pedido');
        $oAplicacao->addItemSelect('Embalagem avariada', 'Embalagem avariada');
        $oAplicacao->addItemSelect('Produto entregues em duplicidade', 'Produto entregues em duplicidade');
        $oAplicacao->addItemSelect('Rosca danificada', 'Rosca danificada');
        $oAplicacao->addItemSelect('Erro no pedido', 'Erro no pedido');
        $oAplicacao->addItemSelect('Dimencional errado', 'Dimencional errado');
        $oAplicacao->addItemSelect('Rosca fora da especificação', 'Rosca fora da especificação');


        $oDivisor1 = new Campo('Dados da não conformidade', 'nconf', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oQuant = new Campo('Quantidade', 'quant', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oQuanNconf = new Campo('Quant. não conforme', 'quantnconf', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oQuanNconf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '4');

        $oDisposicao = new Campo('Disposição', 'disposicao', Campo::TIPO_RADIO, 6, 6, 12, 12);
        $oDisposicao->addItenRadio('1', 'Acc. Condicionalmente');
        $oDisposicao->addItenRadio('2', 'Recusar');

        $oDescNaoConf = new Campo('Descrição da não conformidade', 'naoconf', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescNaoConf->setILinhasTextArea(5);
        $oDescNaoConf->setSCorFundo(Campo::FUNDO_MONEY);
        $oDescNaoConf->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5');

        $oAnexo1 = new Campo('Anexo1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo2 = new Campo('Anexo2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo3 = new Campo('Anexo3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        //seta ids uploads para enviar no request para limpar
        $this->setSIdUpload(',' . $oAnexo1->getId() . ',' . $oAnexo2->getId() . ',' . $oAnexo3->getId());



        $oTabGeral->addCampos(
                array($oRep, $oRespVendaNome, $oRespVenda), $oDivisor2, array($oEmpcod, $oEmpdes), array($oContato, $oCelular, $oEmail, $oInd, $oComer));
        $oTabNF->addCampos(
                array($oDataNf, $oOdCompra, $oPedido, $oValor, $oPeso), array($oLote, $oOp), array($oCodigo, $oProdes, $oQuant), $oDivisor1, array($oAplicacao, $oQuanNconf, $oDisposicao), $oDescNaoConf);
        $oTabAnexos->addCampos(
                array($oAnexo1, $oAnexo2, $oAnexo3), $oSituaca, array($oUsucodigo, $oOfficecod, $oDevolucao));

        $oTab->addItems($oTabGeral, $oTabNF, $oTabAnexos);

        $this->addCampos(
                array($oNr, $oFilcgc, $oUsunome, $oOfficeDes, $oDataIns, $oHora), $oDivisor3, array($oNf), $ln, $oTab);



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
        $oObs_fim->addValidacao(false, Validacao::TIPO_STRING, '', '2');



        $oBtnInserir = new Campo('Finalizar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
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
