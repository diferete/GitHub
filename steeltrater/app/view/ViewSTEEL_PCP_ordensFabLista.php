<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class ViewSTEEL_PCP_ordensFabLista extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oDadosForno = $this->getAParametrosExtras();

        $oBotaoModal = new CampoConsulta('', 'liberar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_FLAG);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Liberar lista para o forno!');
        $oBotaoModal->addAcao('STEEL_PCP_ordensFabLista', 'criaTelaModalLibForno', 'modalLib', '');
        $this->addModais($oBotaoModal);
        $this->getTela()->setBFocoCampo(true);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oPrioridade = new CampoConsulta('Prior.', 'prioridade', CampoConsulta::TIPO_EDIT);
        $oPrioridade->setILargura(20);
        $oPrioridade->addAcao('STEEL_PCP_ordensFabLista', 'gravaPrio', '', '');
        $oPrioridade->setBOrderBy(true);


        $oOp = new CampoConsulta('Op', 'op');
        $oSit = new CampoConsulta('Sit.', 'situacao');
        $oSit->addComparacao('Espera', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSit->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA, false, '');

        $oTempFor = new CampoConsulta('TempForno', 'tempforno', CampoConsulta::TIPO_DECIMAL);
        $oTempFor->setBOrderBy(true);
        $oProduto = new CampoConsulta('Produto', 'STEEL_PCP_ordensFab.prod');
        $oProdes = new CampoConsulta('Descrição', 'STEEL_PCP_ordensFab.prodes');

        $oForDes = new CampoConsulta('Forno', 'fornodes');
        $oCliente = new CampoConsulta('Cliente', 'STEEL_PCP_ordensFab.emp_razaosocial');
        $oCliente->setBTruncate(true);
        $oNrCarta = new campoConsulta('Carg', 'nrCarga');

        $oPeso = new CampoConsulta('Peso', 'STEEL_PCP_ordensFab.peso', CampoConsulta::TIPO_DECIMAL);

        //filtro situação da lista 
        $oSitListaFiltro = new Filtro($oSit, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        //$oSitListaFiltro->addItemSelect('slista', 'Sem lista');
        $oSitListaFiltro->addItemSelect('Todos', 'Todos');
        $oSitListaFiltro->addItemSelect('Espera', 'Espera');
        $oSitListaFiltro->addItemSelect('Liberado', 'Liberado');
        $oSitListaFiltro->addItemSelect('Processo', 'Processo');
        $oSitListaFiltro->addItemSelect('Finalizado', 'Finalizado');
        $oSitListaFiltro->setSValor('Espera');
        $oSitListaFiltro->setBInline(true);

        $oProdFiltro = new Filtro($oProduto, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);

        $oCliFiltro = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $oFornoFiltro = new Filtro($oForDes, Filtro::CAMPO_SELECT, 3, 3, 12, 12, false);
        $oFornoFiltro->addItemSelect('Todos', 'Todos');
        foreach ($oDadosForno as $key => $oFornoObj) {
            $oFornoFiltro->addItemSelect($oFornoObj->getFornodes(), $oFornoObj->getFornodes());
        }
        $oFornoFiltro->setSValor('Todos');

        $oFornoFiltro->setBInline(true);
        $oCliFiltro->setBQuebraLinha(true);



        $this->addFiltro($oSitListaFiltro, $oFornoFiltro, $oProdFiltro, $oCliFiltro);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);

        /*
         * Insere Dropdown para prioridade de forno
         */
        $this->setUsaDropdown(true);
        $oBotaoModalRel = new Dropdown('Imprimir Prioridades', Dropdown::TIPO_SUCESSO);
        foreach ($oDadosForno as $key => $oFornoObj) {
            $oBotaoModalRel->addItemDropdown($this->addIcone(Base::ICON_BOX) . $oFornoObj->getFornodes(), 'STEEL_PCP_OrdensFabLista', 'acaoMostraRelEspecifico', $oFornoObj->getFornocod(), false, 'RelOpSteelPrioridadeForno', false, '', false, '', true, true);
        }

        $this->addDropdown($oBotaoModalRel);



        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $aInicial[0] = 'situacao,Espera';
        $this->getTela()->setAParametros($aInicial);
        $this->getTela()->setiAltura(400);

        $this->addCampos($oPrioridade, $oBotaoModal, $oTempFor, $oOp, $oSit, $oProduto, $oProdes, $oPeso, $oForDes, $oNrCarta, $oCliente, $oNr);

        //campo abaixo do grid
        $oObsRel = new Campo('Observação para o relatório', 'obs', Campo::TIPO_TEXTAREA, 8);
        $oObsRel->setILinhasTextArea(3);
        $this->addCamposGrid($oObsRel);
    }

    public function criaTela() {
        parent::criaTela();


        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oOp = new Campo('Op', 'op', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSit = new Campo('Situacao', 'situacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDat = new Campo('Data', 'data', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oNr, $oOp, $oSit, $oDat));
    }

    public function criaModalLibForno($oModel) {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();
        $aFornoLista = $this->getAModelDados();

        $oNr = new Campo('Nr.Agenda', 'nr', Campo::TIPO_TEXTO, 2);
        $oNr->setSCorFundo(Campo::FUNDO_AMARELO);
        $oNr->setSValor($oModel->getNr());

        $oOp = new Campo('Op', 'op', Campo::TIPO_TEXTO, 1);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);

        $oProcod = new campo('Produto', 'prodes', Campo::TIPO_TEXTO, 2);
        $oProcod->setSValor($oDados->getProd());
        $oProcod->setBCampoBloqueado(true);

        $oProdes = new Campo('Descrição', 'prodes', Campo::TIPO_TEXTO, 5);
        $oProdes->setSValor($oDados->getProdes());
        $oProdes->setBCampoBloqueado(true);

        $oForno = new Campo('Forno', 'fornocod', Campo::TIPO_SELECTMULTI, 3);
        $oForno->addItemSelect('Todos', 'Todos');
        //coloca os fornos nos valores
        foreach ($aFornoLista as $key => $oFornoObj) {
            $oForno->addItemSelect($oFornoObj->getFornocod(), $oFornoObj->getFornodes());
        }
        $oForno->setSValor($oModel->getFornocod());

        $oSitLista = new campo('Situação', 'situacao', Campo::TIPO_SELECTMULTI, 2);
        $oSitLista->addItemSelect('Espera', 'Espera');
        $oSitLista->addItemSelect('Liberado', 'Liberado');
        $oSitLista->setSValor($oModel->getSituacao());

        $oPrioridade = new Campo('Prioridadades', 'prioridade', Campo::CAMPO_SELECTSIMPLE, 2);
        $i = 1;
        while ($i <= 100) {
            $oPrioridade->addItemSelect($i, $i);
            $i++;
        }
        $oPrioridade->setSValor($oModel->getPrioridade());



        $oTemp = new Campo('Temperatura', 'tempForno', Campo::TIPO_TEXTO, 1);
        $oTemp->setBCampoBloqueado(true);
        $oTemp->setSValor(number_format($oDados->getTemprev(), 2, ',', '.'));

        //oNr carga
        $oNrCarta = new campo('Nr.Carga', 'nrCarga', Campo::CAMPO_SELECTSIMPLE, 1, 1, 1, 1);
        $oNrCarta->addItemSelect('1', '1');
        $oNrCarta->addItemSelect('2', '2');
        $oNrCarta->addItemSelect('3', '3');
        $oNrCarta->addItemSelect('3', '3');
        $oNrCarta->addItemSelect('4', '4');
        $oNrCarta->addItemSelect('5', '5');
        $oNrCarta->addItemSelect('6', '6');
        $oNrCarta->addItemSelect('7', '7');
        $oNrCarta->addItemSelect('8', '8');
        $oNrCarta->addItemSelect('9', '9');
        $oNrCarta->addItemSelect('10', '10');

        $oNrCarta->setSValor($oModel->getNrCarga());

        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $oBtnInserir->setIMarginTop(7);
        //id do grid

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabLista","atualizarLista","' . $this->getTela()->getId() . '-form","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);



        $this->addCampos(array($oNr, $oOp, $oProcod, $oProdes), array($oForno, $oSitLista, $oPrioridade, $oTemp, $oNrCarta), $oBtnInserir);
    }

}
