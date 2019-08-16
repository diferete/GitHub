<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualNovoProjRep extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        //$this->getTela()->setBGridResponsivo(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaDropdown(true);


        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setILargura(1);

        $oData = new CampoConsulta('Data', 'dtimp', CampoConsulta::TIPO_DATA);
        $oData->setILargura(50);

        $oEmpDes = new CampoConsulta('Cliente', 'Pessoa.empdes');
        $oEmpDes->setILargura(400);
        $oEmpDes->setBComparacaoColuna(true);

        $oDesc_Novo = new CampoConsulta('Produto', 'desc_novo_prod');
        $oDesc_Novo->setILargura(800);

        $oQt = new CampoConsulta('Quant.Cnt/Mês.', 'quant_pc', CampoConsulta::TIPO_DECIMAL);


        /* Define as situações */
        $oSitProj = new CampoConsulta('SitProjetos', 'sitproj', CampoConsulta::TIPO_TEXTO);
        $oSitProj->addComparacao('Cód. enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitProj->addComparacao('Lib.Projetos', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitProj->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitProj->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitProj->setBComparacaoColuna(true);
        $oSitProj->setILargura(11);

        $oSitVendas = new CampoConsulta('SitVendas', 'sitvendas', CampoConsulta::TIPO_TEXTO);
        $oSitVendas->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitVendas->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitVendas->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitVendas->setBComparacaoColuna(true);
        $oSitVendas->setILargura(11);

        $oSitCLiente = new CampoConsulta('SitCliente', 'sitcliente', CampoConsulta::TIPO_TEXTO);
        $oSitCLiente->addComparacao('Aguardando', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitCLiente->addComparacao('Enviado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitCLiente->addComparacao('Aprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitCLiente->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitCLiente->addComparacao('Expirado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_COLUNA);
        $oSitCLiente->setBComparacaoColuna(true);

        $oSitGeral = new CampoConsulta('SitGeral', 'sitgeralproj', CampoConsulta::TIPO_TEXTO);
        $oSitGeral->addComparacao('Cadastrado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_MARROM, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Representante', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Lib.Projetos', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Reprovado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Lib.Cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Em execução', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Produzido', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitGeral->addComparacao('Faturado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA);
        $oSitGeral->setBComparacaoColuna(true);
        $oSitGeral->setILargura(60);






        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);
        $oEmpDesFil = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12);



        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Liberar Projetos', 'QualNovoProjRep', 'msLiberaProj', '', false, '');
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Reenviar e-mail para projetos', 'QualNovoProjRep', 'ReenvProjMetalbo', '', false, '');

        $oDrop2 = new Dropdown('Proposta', Dropdown::TIPO_DARK);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_FILE) . 'Vizualizar proposta', 'QualNovoProjRep', 'criaTelaModalProposta', '', false, '', false, 'criaModalProposta', true, 'Visualizar Proposta');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Envia proposta para meu e-mail', 'QualNovoProjRep', 'msgEnvProp', '', false, '', false, '', false, '', true);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Aprovar proposta', 'QualNovoProjRep', 'criaTelaModalAprovProp', '', false, '', false, 'criaTelaModalAprovProposta', true, 'Aprova proposta');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_DELETAR) . 'Reprovar proposta', 'QualNovoProjRep', 'criaTelaModalReprovProp', '', false, '', false, 'criaTelaModalReprovProp', true, 'Reprova proposta');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Retorna situação cliente', 'QualNovoProjRep', 'msgRetCli', '', false, '');
        //$oDrop2->addItemDropdown($this->addIcone(Base::ICON_LAPIS).'Apontar reprovação do cliente ','QualNovoProj','acaoMostraTelaModal','', false, '',false,'modal1',true,'Reprovação do cliente');

        $this->addDropdown($oDrop1, $oDrop2);


        $this->addFiltro($oFilNr, $oEmpDesFil, $oFilData);

        $this->addCampos($oNr, $oSitProj, $oSitVendas, $oSitCLiente, $oSitGeral, $oData, $oEmpDes, $oDesc_Novo, $oQt);
    }

    public function criaTela() {
        parent::criaTela();

        $oDadosRep = $this->getOObjTela();
        $aDadosTela = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Empresa', 'EmpRex.filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);


        $oNr = new Campo('Número', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBFocus(true);

        $oDataImp = new campo('Implantação', 'dtimp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataImp->setSValor(date('d-m-Y'));
        $oDataImp->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'horaimp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oSit = new campo('Sit.Projetos', 'sitproj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSit->setSValor('');
        $oSit->setBCampoBloqueado(true);

        $oSitGeral = new campo('Sit.Geral', 'sitgeralproj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitGeral->setBCampoBloqueado(true);
        $oSitGeral->setSValor('Representante');

        $oSitVenda = new campo('Sit.Vendas', 'sitvendas', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitVenda->setSValor('');
        $oSitVenda->setBCampoBloqueado(true);

        $oSitCliente = new campo('Sit.Cliente', 'sitcliente', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitCliente->setSValor('');
        $oSitCliente->setBCampoBloqueado(true);

        $oRespProjCod = new Campo('...', 'resp_proj_cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRespProjCod->setSValor('31'); //ATENÇAO MUDAR ESSE VALOR
        $oRespProjCod->setBCampoBloqueado(true);

        $oRespProjNome = new Campo('Resp.Projetos', 'resp_proj_nome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRespProjNome->setSValor('Eloir Jordelino');
        $oRespProjNome->setBCampoBloqueado(true);

        $oGrupo = new campo('Grupo', 'grucod', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oGrupo->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oGrupoDes = new campo('Grupo Des.', '', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oGrupoDes->setSIdPk($oGrupo->getId());
        $oGrupoDes->setClasseBusca('GrupoProd');
        $oGrupoDes->addCampoBusca('grucod', '', '');
        $oGrupoDes->addCampoBusca('grudes', '', '');
        $oGrupoDes->setSIdTela($this->getTela()->getid());
        $oGrupoDes->setApenasTela(true);

        $oGrupo->setClasseBusca('GrupoProd');
        $oGrupo->setSCampoRetorno('grucod', $this->getTela()->getid());
        $oGrupo->addCampoBusca('grudes', $oGrupoDes->getId(), $this->getTela()->getid());

        //==================================================================================================================================//
        $oRepCodOffice = new Campo('Código do Representante', 'repcodoffice', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oRepCodOffice->addItemSelect('Cod. Representante', 'Cod. Representante');
        $oRepCodOffice->setApenasTela(true);
        foreach ($oDadosRep as $key => $oRepCodObj) {
            $oRepCodOffice->addItemSelect($oRepCodObj->getRepcod(), $oRepCodObj->getRepcod());
        }
        $oRepCodOffice->addValidacao(false, Validacao::TIPO_STRING, 'Selecione código de representante', '2', '3');

        $oRepNome = new campo('Representante', 'repnome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRepNome->setSValor($_SESSION['nome']);
        $oRepNome->setBCampoBloqueado(true);

        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRespVenda->setBCampoBloqueado(true);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, 'Caso não apareça, notificar o setor de TI da Metalbo', '2', '3');

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRespVendaNome->setBCampoBloqueado(true);

        $sAcaoRespVenda = 'buscaRespVenda($("#' . $oRepCodOffice->getId() . '").val(),'
                . '"' . $oRespVenda->getId() . '",'
                . '"' . $oRespVendaNome->getId() . '",'
                . '"' . $this->getController() . '")';

        $oRepCodOffice->addEvento(Campo::EVENTO_CHANGE, $sAcaoRespVenda);
        //===============================================================================================================================//

        $oRepCod = new campo('Cod.', 'repcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRepCod->setSValor($_SESSION['codUser']);
        $oRepCod->setBCampoBloqueado(true);

        $oOfficecod = new Campo('...', 'officecod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOfficecod->setSValor($_SESSION['repoffice']);
        $oOfficecod->setBCampoBloqueado(true);

        $oOfficedes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oOfficedes->setSValor($_SESSION['repofficedes']);
        $oOfficedes->setBCampoBloqueado(true);

        $oEmpcod = new Campo('...', 'Pessoa.empcod', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        //$oEmpcod->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);

        $oEmpdes = new Campo('Cliente', 'Pessoa.empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getid());
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpdes->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getid());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());



        $oEmail = new campo('E-mail do cliente', 'emailCli', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmail->addValidacao(FALSE, Validacao::TIPO_STRING);

        $oContato = new campo('Contato', 'contato', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oDescProd = new campo('Descrição do produto com valores referentes a peça', 'desc_novo_prod', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oDescProd->setSCorFundo(Campo::FUNDO_VERDE);
        $oDescProd->addValidacao(false, Validacao::TIPO_STRING,'Descrição muito longa, utilize OBS','0','100');

        $oAcaba = new Campo('Acabamento do Produto', 'acabamento', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oAcaba->addItemSelect('POL', 'Polido');
        $oAcaba->addItemSelect('ZINC', 'Branco');
        $oAcaba->addItemSelect('BICR', 'Bicromatizado');
        $oAcaba->addItemSelect('G.FOG', 'PO Galvanizado Fogo');
        $oAcaba->addItemSelect('GALV.FOG', 'PF Galvanizado Fogo');
        $oAcaba->addItemSelect('Z.FE.PRT', 'Zinc. Ferro Preto');
        $oAcaba->addItemSelect('Z.FE.AMARL', 'Zinc. Ferro Amarelo');
        $oAcaba->addItemSelect('ORG.MET', 'Org. Metalico');
        $oAcaba->addItemSelect('ZINC.PRT', 'Zin. Preto');
        $oAcaba->addItemSelect('BICR.TRIV', 'Bic. Trivalente');
        $oAcaba->setSCorFundo(Campo::FUNDO_VERDE);
        $oAcaba->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!');


        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oQuant->setSValor('0');
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);


        /* Adiciona evento para por decimal no campo quantidade */
        $sAcaoExit = 'NewProjRep("' . $oQuant->getId() . '");';
        $oRespVenda->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);

        /* Anexos */
        $oAnexoDesenho = new Campo('Anexo 1', 'anexo1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexoDoc = new campo('Anexo 2', 'anexo2', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oAnexoFree = new campo('Anexo 3', 'anexo3', Campo::TIPO_UPLOAD, 2, 2, 12, 12);

        $oFieldAnexo = new FieldSet('Anexos do sistema');
        $oFieldAnexo->addCampos(array($oAnexoDesenho, $oAnexoDoc, $oAnexoFree));

        $oFieldDetalhe = new FieldSet('Informações');
        $oFieldDetalhe->setOculto(true);
        $oFieldDetalhe->addCampos(array($oDataImp, $oHora, $oSit, $oSitGeral, $oSitVenda, $oSitCliente), array($oFilcgc, $oRespProjCod, $oRespProjNome), array($oOfficecod, $oOfficedes));


        $oObsRep = new Campo('Observação gerais do cliente/representante', 'replibobs', Campo::TIPO_TEXTAREA, 12);
        $oObsRep->setILinhasTextArea(5);

        //seta ids uploads para enviar no request para limpar
        $this->setSIdUpload(',' . $oAnexoDesenho->getId() . ',' . $oAnexoDoc->getId() . ',' . $oAnexoFree->getId());

        $this->addCampos($oFieldDetalhe, $oNr, array($oGrupo, $oGrupoDes), array($oRepNome, $oRepCod, $oRepCodOffice, $oRespVenda, $oRespVendaNome), array($oEmpcod, $oEmpdes), array($oEmail, $oContato), array($oDescProd, $oAcaba, $oQuant), $oFieldAnexo, $oObsRep);
        // array($oEmpcod,$oEmpdes),
        //array($oRespVenda,$oRespVendaNome)
    }

    /**
     * Função para cria a tela modal para vizualizar a proposta
     */
    public function criaModalProposta() {
        parent::criaModal();

        $oDados = $this->getAParametrosExtras();

        $oEmpcod = new Campo('Cliente', 'empcod', Campo::TIPO_TEXTO, 3);
        $oEmpcod->setSValor($oDados->empcod);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new campo('...', 'empdes', Campo::TIPO_TEXTO, 9);
        $oEmpdes->setSValor($oDados->empdes);
        $oEmpdes->setBCampoBloqueado(true);

        $oProduto = new campo('Produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 12);
        $oProduto->setSValor($oDados->desc_novo_prod);
        $oProduto->setBCampoBloqueado(true);

        $oAcaba = new campo('Acabamento', 'acabamento', Campo::TIPO_TEXTO, 3);
        $oAcaba->setSValor($oDados->acabamento);
        $oAcaba->setBCampoBloqueado(true);

        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 3);
        $oQuant->setSValor(number_format($oDados->quant_pc, 2, ',', '.'));
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setBCampoBloqueado(true);

        $oLoteMin = new campo('Lote Mínimo', 'lotemin', Campo::TIPO_TEXTO, 2);
        $oLoteMin->setSValor(number_format($oDados->lotemin, 2, ',', '.'));
        $oLoteMin->setBCampoBloqueado(true);

        $oPesoCt = new campo('Peso Ct', 'pesoct', Campo::TIPO_TEXTO, 2);
        $oPesoCt->setSValor(number_format($oDados->pesoct, 2, ',', '.'));
        $oPesoCt->setBCampoBloqueado(true);

        $oPreco = new Campo('Preço R$:', 'precofinal', Campo::TIPO_TEXTO, 3);
        $oPreco->setSValor(number_format($oDados->precofinal, 2, ',', '.'));
        $oPreco->setSCorFundo(Campo::FUNDO_VERDE);
        $oPreco->setBCampoBloqueado(true);

        $oPrazo = new Campo('Prazo entrega/Dias úteis', 'prazoentregautil', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oPrazo->setSValor($oDados->prazoentregautil);
        $oPrazo->setBCampoBloqueado(true);

        $oObsVenda = new campo('Obs. Vendas/Motivo Reprovação', 'fin_obs', Campo::TIPO_TEXTAREA, 12);
        $sValor = $oDados->fin_obs;
        $sValor = str_replace("\n", " ", $sValor);
        $sValor = str_replace("'", "\'", $sValor);
        $sValor = str_replace("\r", "", $sValor);

        $oObsVenda->setSValor($sValor);
        $oObsVenda->setBCampoBloqueado(true);
        $oObsVenda->setILinhasTextArea(3);

        $oObsProj = new Campo('Obs. Projetos/Motivo Reprovação', 'obs_proj', Campo::TIPO_TEXTAREA, 12);
        $sValorProj = $oDados->obs_proj;
        $sValorProj = str_replace("\n", " ", $sValorProj);
        $sValorProj = str_replace("'", "\'", $sValorProj);
        $sValorProj = str_replace("\r", "", $sValorProj);

        $oObsProj->setSValor($sValorProj);
        $oObsProj->setBCampoBloqueado(true);
        $oObsProj->setILinhasTextArea(3);

        $oObsReprova = new Campo('Obs. Cliente/Motivo Reprovação', 'obsreprovcli', Campo::TIPO_TEXTAREA, 12);
        $sValorReprova = $oDados->obsreprovcli;
        $sValorReprova = str_replace("\n", " ", $sValorReprova);
        $sValorReprova = str_replace("'", "\'", $sValorReprova);
        $sValorReprova = str_replace("\r", "", $sValorReprova);

        $oObsReprova->setSValor($sValorReprova);
        $oObsReprova->setBCampoBloqueado(TRUE);
        $oObsReprova->setILinhasTextArea(3);

        $this->setBTela(true);


        $this->addCampos(array($oEmpcod, $oEmpdes), $oProduto, array($oAcaba, $oQuant, $oLoteMin, $oPesoCt), array($oPreco, $oPrazo), $oObsProj, $oObsVenda, $oObsReprova);
    }

    public function criaTelaModalAprovProp($sDados) {
        parent::criaModal();

        $this->setBTela(true);

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new campo('', 'EmpRex_filcgc', Campo::TIPO_TEXTO, 1);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBOculto(true);

        $oNr = new campo('', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setSValor($oDados->nr);
        $oNr->setBOculto(true);

        $oEmpcod = new Campo('Cliente', 'empcod', Campo::TIPO_TEXTO, 3);
        $oEmpcod->setSValor($oDados->empcod);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new campo('...', 'empdes', Campo::TIPO_TEXTO, 9);
        $oEmpdes->setSValor($oDados->empdes);
        $oEmpdes->setBCampoBloqueado(true);

        $oProduto = new campo('Produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 12);
        $oProduto->setSValor($oDados->desc_novo_prod);
        $oProduto->setBCampoBloqueado(true);

        $oAcaba = new campo('Acabamento', 'acabamento', Campo::TIPO_TEXTO, 3);
        $oAcaba->setSValor($oDados->acabamento);
        $oAcaba->setBCampoBloqueado(true);

        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 3);
        $oQuant->setSValor(number_format($oDados->quant_pc, 2, ',', '.'));
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setBCampoBloqueado(true);

        $oLoteMin = new campo('Lote Mínimo', 'lotemin', Campo::TIPO_TEXTO, 3);
        $oLoteMin->setSValor(number_format($oDados->lotemin, 2, ',', '.'));
        $oLoteMin->setBCampoBloqueado(true);

        $oPesoCt = new campo('Peso Ct', 'pesoct', Campo::TIPO_TEXTO, 3);
        $oPesoCt->setSValor(number_format($oDados->pesoct, 2, ',', '.'));
        $oPesoCt->setBCampoBloqueado(true);

        $oPreco = new Campo('Preço R$:', 'precofinal', Campo::TIPO_TEXTO, 3);
        $oPreco->setSValor(number_format($oDados->precofinal, 2, ',', '.'));
        $oPreco->setSCorFundo(Campo::FUNDO_VERDE);
        $oPreco->setBCampoBloqueado(true);

        $oPrazo = new Campo('P.Entrega/Dias úteis', 'prazoentregautil', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oPrazo->setSValor($oDados->prazoentregautil);
        $oPrazo->setBCampoBloqueado(true);

        $oObsAprov = new campo('Obs. aprovação', 'obsaprovcli', Campo::TIPO_TEXTAREA, 12);
        $oObsAprov->addValidacao(false, Validacao::TIPO_STRING, 'É necessário informar este campo!', '10');

        $oBtnInserir = new Campo('Apontar aprovação', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","aprovaPropCli","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oEmpcod, $oEmpdes), $oProduto, array($oAcaba, $oQuant, $oLoteMin), array($oPesoCt, $oPreco, $oPrazo), $oObsAprov, array($oBtnInserir, $oFilcgc, $oNr));
    }

    /**
     * Cria tela modal para reprovar proposta
     */
    public function criaTelaModalReprovProp($sDados) {
        parent:: criaModal();

        $this->setBTela(true);

        $oDados = $this->getAParametrosExtras();

        $oFilcgc = new campo('', 'EmpRex_filcgc', Campo::TIPO_TEXTO, 1);
        $oFilcgc->setSValor($oDados->filcgc);
        $oFilcgc->setBOculto(true);

        $oNr = new campo('Nr.', 'nr', Campo::TIPO_TEXTO, 3);
        $oNr->setSValor($oDados->nr);
        $oNr->setBCampoBloqueado(true);


        $oEmpcod = new Campo('Cliente', 'empcod', Campo::TIPO_TEXTO, 3);
        $oEmpcod->setSValor($oDados->empcod);
        $oEmpcod->setBCampoBloqueado(true);

        $oEmpdes = new campo('...', 'empdes', Campo::TIPO_TEXTO, 9);
        $oEmpdes->setSValor($oDados->empdes);
        $oEmpdes->setBCampoBloqueado(true);

        $oProduto = new campo('Produto', 'desc_novo_prod', Campo::TIPO_TEXTO, 12);
        $oProduto->setSValor($oDados->desc_novo_prod);
        $oProduto->setBCampoBloqueado(true);

        $oAcaba = new campo('Acabamento', 'acabamento', Campo::TIPO_TEXTO, 3);
        $oAcaba->setSValor($oDados->acabamento);
        $oAcaba->setBCampoBloqueado(true);

        $oQuant = new campo('Quant.Cnt/Mês', 'quant_pc', Campo::TIPO_TEXTO, 2);
        $oQuant->setSValor(number_format($oDados->quant_pc, 2, ',', '.'));
        $oQuant->setSCorFundo(Campo::FUNDO_VERDE);
        $oQuant->setBCampoBloqueado(true);

        $oObsRep = new campo('Motivo da reprovação', 'obsreprov', Campo::TIPO_TEXTAREA, 12);
        $oObsRep->addValidacao(false, Validacao::TIPO_STRING, 'É necessário informar este campo!', '10');

        $oBtnInserir = new Campo('Reprovar proposta', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","reprovarProposta","' . $this->getTela()->getId() . '-form,' . $sDados . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);


        $this->addCampos($oNr, array($oEmpcod, $oEmpdes), array($oProduto, $oAcaba, $oQuant), $oFilcgc, $oObsRep, $oBtnInserir);
    }

}
