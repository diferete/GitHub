<?php

/*
 * Implemanta a view da classe MET_QUAL_Rc
 * @author Avanei Martendal
 * @since 10/09/2017
 */

class ViewMET_QUAL_RcRep extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setiLarguraGrid(3400);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_LARGURA);

        $oCliente = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_TEXTO);

        $oUser = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_TEXTO);

        $oOfficeDes = new CampoConsulta('Representante', 'officedes', CampoConsulta::TIPO_TEXTO);

        $oData = new CampoConsulta('Data', 'datains', CampoConsulta::TIPO_DATA);

        $oAnexo1 = new CampoConsulta('Anexo 1', 'anexo1', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo2 = new CampoConsulta('Anexo 2', 'anexo2', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexo3 = new CampoConsulta('Anexo 3', 'anexo3', CampoConsulta::TIPO_DOWNLOAD);


        $oSit = new CampoConsulta('Sit', 'situaca', CampoConsulta::TIPO_TEXTO);
        $oSit->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Exp', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Emb', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Env.Qual', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Apontada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->addComparacao('Finalizada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA, false, null);
        $oSit->setBComparacaoColuna(true);

        $oReclamacao = new CampoConsulta('Reclamação', 'reclamacao', CampoConsulta::TIPO_TEXTO);
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

        $oDropDown = new Dropdown('Liberações', Dropdown::TIPO_PRIMARY);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Liberar Metalbo', 'MET_QUAL_RcRep', 'liberarMetalbo', '', false, 'rc', false, '', false, '', true, false);

        $oDropDown2 = new Dropdown('Opções da Reclamação', Dropdown::TIPO_INFO, Dropdown::ICON_INFO);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'MET_QUAL_RcRep', 'acaoMostraRelConsulta', '', false, 'rc', false, '', false, '', false, false);
        $oDropDown2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Reenviar e-mail', 'MET_QUAL_RcRep', 'reenviaEmail', '', false, '', false, '', false, '', false, false);

        $this->setUsaDropdown(true);
        $this->addDropdown($oDropDown, $oDropDown2);


        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilCli = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $this->addFiltro($oFilNr, $oFilCli);
        $this->addCampos($oNr, $oSit, $oReclamacao, $oProcedencia, $oDevolucao, $oCliente, $oUser, $oOfficeDes, $oData, $oAnexo1, $oAnexo2, $oAnexo3);

        $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $oAnaliseVendas = new Campo('Resposta apresentada pelo setor de Vendas', '', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oAnaliseVendas->setILinhasTextArea(6);
        $oAnaliseVendas->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAnaliseVendas->setBCampoBloqueado(true);

        $oProblema = new Campo('Problema descrito pelo Representante', '', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oProblema->setILinhasTextArea(6);
        $oProblema->setSCorFundo(Campo::FUNDO_MONEY);
        $oProblema->setBCampoBloqueado(true);


        $this->addCamposGrid($oProblema, $oAnaliseVendas, $oLinhaWhite);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_QUAL_RcRep","carregaAnalise","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oAnaliseVendas->getId() . ',' . $oProblema->getId() . '"+","+"");');


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
        $oTabProd = new AbaTabPanel('Produto');
        $oTabAnexos = new AbaTabPanel('Anexos');

        $this->addLayoutPadrao('Aba');

        $oFilcgc = new Campo('CNPJ', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);

        $oProcedencia = new Campo('', 'procedencia', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oProcedencia->setSValor('Aguardando');
        $oProcedencia->setBCampoBloqueado(true);
        $oProcedencia->setBOculto(true);

        $oDevolucao = new Campo('', 'devolucao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDevolucao->setSValor('Aguardando');
        $oDevolucao->setBCampoBloqueado(true);
        $oDevolucao->setBOculto(true);

        $oReclamacao = new Campo('', 'reclamacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oReclamacao->setSValor('Aguardando');
        $oReclamacao->setBCampoBloqueado(true);
        $oReclamacao->setBOculto(true);

        //situacao
        $oSituaca = new Campo('', 'situaca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituaca->setSValor('Aguardando');
        $oSituaca->setBCampoBloqueado(true);
        $oSituaca->setBOculto(true);

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

        $oTagExcecao = new Campo(' <- Exceção, inserir sem LOTE', 'tagexcecao', Campo::TIPO_CHECK, 2, 2, 12, 12);

        $oDataNf = new Campo('Data.Nf', 'datanf', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDataNf->setBCampoBloqueado(true);

        $oOdCompra = new Campo('Od.Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPedido = new campo('Pedido', 'pedido', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValor = new campo('Valor', 'valor', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oValor->setBCampoBloqueado(true);

        $oPeso = new campo('Peso', 'peso', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oPeso->setBCampoBloqueado(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_QUAL_RcRep","buscaNf","' . $oDataNf->getId() . ',' . $oValor->getId() . ',' . $oPeso->getId() . ',' . $oEmpcod->getId() . ',' . $oEmpdes->getId() . '");';

        $oNf->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oLote = new Campo('Nº Lote', 'lote', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oOp = new Campo('Ordem Produção', 'op', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        /*
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
         * 
         */

        $oAplicacao = new Campo('Problema', 'aplicacao', Campo::TIPO_SELECT, 3, 3, 12, 12);
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
        $oAplicacao->addItemSelect('Produto faltando no físico', 'Produto faltando no físico');


        $oDivisor1 = new Campo('Dados da não conformidade', 'nconf', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

/////////////////////////////////////////////////////////////////////////////////////////////////////////


        $oQuant = new Campo('Quantidade', 'quant', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oQuanNconf = new Campo('Qnt. não conforme', 'quantnconf', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oProCod = new campo('Cód.', 'procod', Campo::TIPO_BUSCADOBANCOPK, 2, 4, 4, 4);

        $oProDes = new Campo('Produto', 'prodes', Campo::TIPO_BUSCADOBANCO, 3, 8, 8, 8);
        $oProDes->setSIdPk($oProCod->getId());
        $oProDes->setClasseBusca('Produto');
        $oProDes->addCampoBusca('procod', '', '');
        $oProDes->addCampoBusca('prodes', '', '');
        $oProDes->setSIdTela($this->getTela()->getid());
        $oProDes->setApenasTela(true);

        $oProCod->setClasseBusca('Produto');
        $oProCod->setSCampoRetorno('procod', $this->getTela()->getId());
        $oProCod->addCampoBusca('prodes', $oProDes->getId(), $this->getTela()->getId());
        $oProCod->setApenasTela(true);

        $oProd = new campo('Produtos', 'produtos', Campo::TIPO_TAGS, 12, 12, 12, 12);
        $oProd->setILinhasTextArea(5);
        $oProd->setSCorFundo(Campo::FUNDO_AMARELO);
        $oProd->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 5);


        $oBotConf = new Campo('Adicionar', 'botao', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotConf->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $sAcao = 'insereProd($("#' . $oProCod->getId() . '").val(),'
                . '$("#' . $oProDes->getId() . '").val(),'
                . '$("#' . $oQuant->getId() . '").val(),'
                . '$("#' . $oQuanNconf->getId() . '").val(),'
                . '"' . $oProd->getId() . '",'
                . '"' . $oProCod->getId() . '",'
                . '"' . $oProDes->getId() . '",'
                . '"' . $oQuant->getId() . '",'
                . '"' . $oQuanNconf->getId() . '",'
                . '"' . $this->getController() . '")';
        $oBotConf->getOBotao()->addAcao($sAcao);
        $oBotConf->setApenasTela(true);


//////////////////////////////////////////////////////////////////////////////////////////////////////////////       
        $oDisposicao = new Campo('Disposição', 'disposicao', Campo::TIPO_RADIO, 2, 2, 12, 12);
        $oDisposicao->addItenRadio('1', 'Aceita Condicionalmente');
        $oDisposicao->addItenRadio('2', 'Devolver');

        $oAtencao = new Campo('Acc. Condicionalmente - Apenas reclamação.', '', Campo::TIPO_BADGE, 2, 3, 12, 12);
        $oAtencao->setSEstiloBadge(Campo::BADGE_SUCCESS);
        $oAtencao->setITamFonteBadge(18);
        $oAtencao->setApenasTela(true);

        $oAtencao1 = new Campo('Devolver - Intenção de devolução pelo Cliente.', '', Campo::TIPO_BADGE, 2, 3, 12, 12);
        $oAtencao1->setSEstiloBadge(Campo::BADGE_DANGER);
        $oAtencao1->setITamFonteBadge(18);
        $oAtencao1->setApenasTela(true);

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
                array($oDataNf, $oOdCompra, $oPedido, $oValor, $oPeso), array($oLote, $oOp));

        $oTabProd->addCampos($oAplicacao, array($oProCod, $oProDes, $oQuant, $oQuanNconf, $oBotConf), $oProd, $oDivisor1, $oDescNaoConf, array($oDisposicao, $oAtencao, $oAtencao1));

        $oTabAnexos->addCampos(
                array($oAnexo1, $oAnexo2, $oAnexo3), $oSituaca, array($oUsucodigo, $oOfficecod, $oDevolucao, $oProcedencia, $oReclamacao));

        $oTab->addItems($oTabGeral, $oTabNF, $oTabProd, $oTabAnexos);

        $this->addCampos(
                array($oNr, $oFilcgc, $oUsunome, $oOfficeDes, $oDataIns, $oHora), $oDivisor3, array($oNf, $oTagExcecao), $ln, $oTab);



        //array($oRespVenda, $oRespVendaNome)
    }

    public function relReclamacaoCliente() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Reclamações de Clientes');
        $this->setBTela(true);


        $oDivisor1 = new Campo('Situações por Setor', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(TRUE);


        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oDataFin = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataFin->setSValor(Util::getDataAtual());
        $oDataFin->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oSetorAnalise = new campo('Setor da análise', 'tagsetor', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oSetorAnalise->addItemSelect('', 'Todos');
        $oSetorAnalise->addItemSelect('34', 'Vendas');
        $oSetorAnalise->addItemSelect('25', 'Qualidade');
        $oSetorAnalise->addItemSelect('3', 'Expedição');
        $oSetorAnalise->addItemSelect('5', 'Embalagem');

        $oSituaca = new campo('Situação Geral', 'situaca', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oSituaca->addItemSelect('', 'Todas');
        $oSituaca->addItemSelect('Aguardando', 'Aguardando');
        $oSituaca->addItemSelect('Liberada', 'Liberada');
        $oSituaca->addItemSelect('Apontada', 'Apontada');
        $oSituaca->addItemSelect('Finalizada', 'Finalizada');

        $oReclamacao = new campo('Status da Reclamação', 'reclamacao', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oReclamacao->addItemSelect('', 'Todas');
        $oReclamacao->addItemSelect('Aguardando', 'Aguardando');
        $oReclamacao->addItemSelect('Em análise', 'Em análise');
        $oReclamacao->addItemSelect('Interna', 'Interna');
        $oReclamacao->addItemSelect('Cliente', 'Cliente');
        $oReclamacao->addItemSelect('Representante', 'Representante');
        $oReclamacao->addItemSelect('Transportadora', 'Transportadora');

        $oDevolucao = new campo('Devolução', 'devolucao', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oDevolucao->addItemSelect('', 'Todas');
        $oDevolucao->addItemSelect('Aguardando', 'Aguardando');
        $oDevolucao->addItemSelect('Aceita', 'Aceita');
        $oDevolucao->addItemSelect('Indeferida', 'Indeferida');

        $oDivisor2 = new Campo('Situações Gerais', 'divisor2', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(TRUE);

        $olinha = new Campo('', 'linha1', Campo::TIPO_LINHABRANCO);
        $olinha->setApenasTela(true);

//        /EXCEL
//        $oXls = new Campo('Exportar para Excel', 'sollib', Campo::TIPO_BOTAOSMALL, 1);
//        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
//
//        $sAcaoLib = 'requestAjax("' . $this->getTela()->getId() . '-form","QualGerenProj","relProjXls");';
//        $oXls->getOBotao()->addAcao($sAcaoLib);

        $this->addCampos(array($oDataIni, $oDataFin), $oDivisor1, $oSetorAnalise, $oDivisor2, array($oSituaca, $oReclamacao, $oDevolucao), $olinha/* , $oXls */);
    }

}
