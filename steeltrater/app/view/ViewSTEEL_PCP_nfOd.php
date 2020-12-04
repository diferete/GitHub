<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_nfOd extends View {

    public function criaTela() {
        parent::criaTela();

        // $this->setBTela(false);

        $oOd = new Campo('Ordem de compra', 'od', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oOd->addValidacao(false, Validacao::TIPO_STRING, 'Valor incorreto!');

        $oOdEmp = new Campo('Empresa', 'empOd', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oOdEmp->setBCampoBloqueado(true);

        $oOd->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","consultaOd","' . $oOdEmp->getId() . '","");');

        $oNf = new Campo('Nota fiscal', 'nf', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oNf->addValidacao(false, Validacao::TIPO_STRING, 'Valor incorreto!');
        $oNfEmp = new campo('Empresa', 'emNf', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oNf->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","consultaNf","' . $oNfEmp->getId() . '","");');
        $oNfEmp->setBCampoBloqueado(true);


        $oLinha = new Campo('', 'linha1', Campo::TIPO_LINHA, 12);

        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gravaOd","' . $oOd->getId() . ',' . $oOdEmp->getId() . ',' . $oNf->getId() . ',' . $oNfEmp->getId() . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);


        $this->setBOcultaFechar(false);
        $this->setBOcultaBotTela(true);
        $this->addCampos(array($oOd, $oOdEmp), $oLinha, array($oNf, $oNfEmp), $oLinha, $oBtnInserir);
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);

        $oXPed = new CampoConsulta('Ordem de compra', 'xPed');
        $oXPed->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oXPed->setBComparacaoColuna(true);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Analisar apontamentos!');
        $oBotaoModal->addAcao('STEEL_PCP_OrdensFab', 'criaTelaModalAponta', 'modalAponta', '');
        $this->addModais($oBotaoModal);

        $oBotaoFat = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_FLAG);
        $oBotaoFat->setBHideTelaAcao(true);
        $oBotaoFat->setILargura(15);
        $oBotaoFat->setSTitleAcao('Itens que vão para nota fiscal!');
        $oBotaoFat->addAcao('STEEL_PCP_OrdensFab', 'criaTelaModalFat', 'modalFat', '');
        $this->addModais($oBotaoFat);

        $oEmpCod = new CampoConsulta('Cnpj', 'emp_codigo');
        $oSeq = new CampoConsulta('Seq.Material', 'seqmat');
        $oOp = new CampoConsulta('Op', 'op');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oCodigo = new CampoConsulta('Codigo', 'prod');
        $oReferencia = new CampoConsulta('Referência', 'referencia');
        $oProdes = new CampoConsulta('Descrição', 'prodes');

        $Pendencia = new campoconsulta('--', 'pendencias');

        $oReceitaDes = new CampoConsulta('Receita', 'receita_des');
        $oQuant = new CampoConsulta('Quantidade', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oPeso = new CampoConsulta('Peso', 'peso', CampoConsulta::TIPO_DECIMAL);
        $oRetrabalho = new CampoConsulta('Retr.', 'retrabalho', CampoConsulta::TIPO_TEXTO);
        $oSituacao = new CampoConsulta('Situação', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');

        $oDocumento = new CampoConsulta('NotaEnt', 'documento');
        $oTipOrdem = new CampoConsulta('Tipo', 'tipoOrdem');

        $oNrCarga = new campoconsulta('NºCarga', 'nrCarga');

        //  $oOpAntes = new CampoConsulta('Op anterior', 'opantes');

        $oReceita = new campoconsulta('Receita', 'receita');

        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oDescricaoFiltro = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 3);

        $oDocFiltro = new Filtro($oDocumento, Filtro::CAMPO_TEXTO_IGUAL, 2);

        $oTipoAcaoFiltro = new Filtro($oRetrabalho, Filtro::CAMPO_SELECT, 3, 2, 12, 12, true);
        $oTipoAcaoFiltro->addItemSelect('Todos', 'Todos');
        $oTipoAcaoFiltro->addItemSelect('Não', 'Não incluí retrab.');
        $oTipoAcaoFiltro->addItemSelect('Sim', 'Incluí');
        $oTipoAcaoFiltro->setSLabel('');
        $oTipoAcaoFiltro->setBInline(true);

        $oFiltroReferencia = new Filtro($oReferencia, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 2, 2);

        $oFilEmpresa = new Filtro($oEmpCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilEmpresa->setSClasseBusca('DELX_CAD_Pessoa');
        $oFilEmpresa->setSCampoRetorno('emp_codigo', $this->getTela()->getSId());
        $oFilEmpresa->setSIdTela($this->getTela()->getSId());

        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);


        //   $oOpAntesFiltro = new Filtro($oOpAntes, Filtro::CAMPO_TEXTO_IGUAL, 2);

        $oFiltroSit = new Filtro($oSituacao, Filtro::CAMPO_SELECT, 3, 2, 12, 12, true);
        $oFiltroSit->addItemSelect('Todos', 'Todos');
        $oFiltroSit->addItemSelect('Aberta', 'Aberta');
        $oFiltroSit->addItemSelect('Processo', 'Processo');
        $oFiltroSit->addItemSelect('Finalizado', 'Finalizado');
        $oFiltroSit->addItemSelect('Retornado', 'Retornado');
        $oFiltroSit->setSLabel('');
        $oFiltroSit->setBInline(true);

        $oFilRec = new Filtro($oReceita, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilRec->setSClasseBusca('STEEL_PCP_Receitas');
        $oFilRec->setSCampoRetorno('cod', $this->getTela()->getSId());
        $oFilRec->setSIdTela($this->getTela()->getSId());

        $this->addFiltro($oDocFiltro, $oOpFiltro, $oCodigoFiltro, $oDescricaoFiltro, $oFilEmpresa);

        $this->setUsaAcaoExcluir(FALSE);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoAlterar(false);


        $this->setBScrollInf(true);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oDocumento, $oXPed, $oOp, $oBotaoModal, $oBotaoFat, $oSituacao, $oNrCarga, $Pendencia, $oData, $oCodigo, $oReferencia, $oProdes, $oPeso, $oRetrabalho, $oReceita, $oTipOrdem);


        /* $this->setUsaDropdown(true);
          $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
          $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_OrdensFab', 'acaoMostraRelEspecifico', '', false, 'OpSteel1', false, '', false, '', true);
          $oDrop2 = new Dropdown('Açao', Dropdown::TIPO_DARK);
          $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Cancelar OP', 'STEEL_PCP_OrdensFab', 'msgCancelaOp', '', false, '');
          $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Retornar para Aberta', 'STEEL_PCP_OrdensFab', 'msgAbertaOp', '', false, '');


          $oDrop3 = new Dropdown('Retrabalho', Dropdown::TIPO_AVISO);
          $oDrop3->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Colocar em Retrabalho', 'STEEL_PCP_OrdensFab', 'msgRetrabalhoOp', '', false, '');

          $this->addDropdown($oDrop1, $oDrop2, $oDrop3); */
        $this->getTela()->setiAltura(750);
    }

}
