<?php

/*
 * Classe que gerencia a View da MET_GerenciaFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class ViewMET_GerenciaFrete extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $aDados = $this->getAParametrosExtras();

        $oBotaoContPag = new CampoConsulta('Contas a Pagar', 'ContPag', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoContPag->setSTitleAcao('Libera o faturamento!');
        $oBotaoContPag->addAcao('MET_GerenciaFrete', 'msgLibPag');
        $oBotaoContPag->setBHideTelaAcao(true);
        $oBotaoContPag->setILargura(30);

        $oNr = new CampoConsulta('Nr', 'nr');
        $oCnpj = new CampoConsulta('CNPJ', 'cnpj');
        $oEmpDes = new CampoConsulta('Empresa', 'Pessoa.empdes');
        $oNrCon = new CampoConsulta('Conhecimento', 'nrconhe');
        $oNrFat = new CampoConsulta('Fat.', 'nrfat');
        $oNrNot = new CampoConsulta('Nota', 'nrnotaoc');
        $oTotalKg = new CampoConsulta('Total Kg.', 'totakg', CampoConsulta::TIPO_DECIMAL);
        $oTotalNf = new CampoConsulta('Total Nf.', 'totalnf', CampoConsulta::TIPO_DECIMAL);
        $oFracaoFrete = new CampoConsulta('Fração Frete.', 'fracaofrete');
        $oValSer = new CampoConsulta('Valor Serv.', 'valorserv', CampoConsulta::TIPO_DECIMAL);
        $oCodTipo = new CampoConsulta('Tipo.', 'codtipo');
        $oCodTipo->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_COLUNA, true, 'VENDA');
        $oCodTipo->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_COLUNA, true, 'COMPRA');
        $oDat = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, true, 'APROVADO');
        $oSit->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, true, 'ESPERA');
        $oUser = new CampoConsulta('Usuário', 'usuario');

        $oFiltroCnpj = new Filtro($oCnpj, Filtro::CAMPO_SELECT, 3, 3, 3, 3);
        $oFiltroCnpj->addItemSelect('', 'Todas Empresas');
        foreach ($aDados as $key) {
            $val = (int) $key['cnpj'];
            $oFiltroCnpj->addItemSelect($val, $val . ' - ' . $key['empdes']);
        }
        $oFiltroCnpj->setSLabel('');

        $oFiltroConh = new Filtro($oNrCon, Filtro::CAMPO_TEXTO, 1);
        $oFiltroNota = new Filtro($oNrNot, Filtro::CAMPO_TEXTO, 1);
        $oFiltroTipo = new Filtro($oCodTipo, Filtro::CAMPO_SELECT, 1);
        $oFiltroTipo->addItemSelect('', 'Todos tipos');
        $oFiltroTipo->addItemSelect('1', 'VENDA');
        $oFiltroTipo->addItemSelect('2', 'COMPRA');
        $oFiltroTipo->setSLabel('');
        $oFiltroSitu = new Filtro($oSit, Filtro::CAMPO_SELECT, 1);
        $oFiltroSitu->addItemSelect('', 'Todas situações');
        $oFiltroSitu->addItemSelect('A', 'APROVADO');
        $oFiltroSitu->addItemSelect('E', 'ESPERA');
        $oFiltroSitu->setSLabel('');

        $this->addFiltro($oFiltroCnpj, $oFiltroConh, $oFiltroNota, $oFiltroTipo, $oFiltroSitu);

        $this->getTela()->setBMostraFiltro(true);

        $this->setBScrollInf(false);

        $this->addCampos($oBotaoContPag, $oNr, $oCnpj, $oEmpDes, $oNrCon, $oNrFat, $oNrNot, $oTotalKg, $oTotalNf, $oFracaoFrete, $oValSer, $oCodTipo, $oSit, $oDat, $oUser);
    }

    public function criaTela() {
        parent::criaTela();

        $aDados = $this->getAParametrosExtras();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);

        //Filtro de células
        $oCnpj = new Campo('CNPJ', 'cnpj', Campo::TIPO_SELECT, 5);
        foreach ($aDados as $key) {
            $val = (int) $key['cnpj'];
            $oCnpj->addItemSelect($val, $val . ' - ' . $key['empdes']);
        }
        $oCnpj->addValidacao(false);
        $oCnpj->setId('gerenciafrete_cnpj');

        $oSeqReg = new Campo('Seq.Regra', 'seqregra', Campo::TIPO_TEXTO, 1);
        $oSeqReg->setBOculto(true);

        $oNrCon = new Campo('Nr. Conhecimento', 'nrconhe', Campo::TIPO_TEXTO, 2);
        $oNrCon->setId('gerenciafrete_nrconhe');
        $oNrCon->addValidacao(false);
        $sCallBack2 = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_GerenciaFrete","verificaConhecimento","");';
        $oNrCon->addEvento(Campo::EVENTO_SAIR, $sCallBack2);
        $oNrFat = new Campo('Nr. Fat.', 'nrfat', Campo::TIPO_TEXTO, 1);
        $oNrFat->addValidacao(false);
        $oNrFat->setId('gerenciafrete_nrfat');
        $oNrNot = new Campo('Nr. Nota', 'nrnotaoc', Campo::TIPO_TEXTO, 2);
        $oNrNot->addValidacao(false);
        $oTotalKg = new Campo('Total Kg.', 'totakg', Campo::TIPO_TEXTO, 1);
        $oTotalKg->addValidacao(false);
        $oTotalNf = new Campo('Total Nf.', 'totalnf', Campo::TIPO_TEXTO, 1);
        $oTotalNf->addValidacao(false);

        $oFracaoFrete = new Campo('Fração Frete.', 'fracaofrete', Campo::TIPO_TEXTO, 1);
        $oFracaoFrete->addValidacao(false);
        $oFracaoFrete->setBCampoBloqueado(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_GerenciaFrete","buscaDados","' . $oTotalNf->getId() . ',' . $oTotalKg->getId() . ',' . $oFracaoFrete->getId() . '");';

        $sCallBack1 = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_GerenciaFrete","calculoFracaoFrete","' . $oFracaoFrete->getId() . '");';

        $oTotalKg->addEvento(Campo::EVENTO_SAIR, $sCallBack1);

        $oNrNot->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oValSer = new Campo('Valor Serv.', 'valorserv', Campo::TIPO_DECIMAL, 1);
        $oValSer->addValidacao(false);
        $oValSer->setId('gerenciafrete_valorserv');

        $oCodtip = new Campo('Tipo', 'codtipo', Campo::TIPO_SELECT, 2);
        $oCodtip->addItemSelect('1', 'Venda');
        $oCodtip->addItemSelect('2', 'Compra');
        $oCodtip->addValidacao(false);
        $oCodtip->setId('gerenciafrete_codtip');

        $oDat = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1);
        $oDat->setSValor(date('d/m/Y'));
        $oDat->setBOculto(true);
        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1);
        $oHora->setSValor(date('H:i'));
        $oHora->setBOculto(true);
        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 1);
        $oUser->setSValor($_SESSION['nome']);
        $oUser->setBOculto(true);

        $oSit = new Campo('Situação', 'sit', Campo::CAMPO_SELECTSIMPLE, 1);
        $oSit->setSValor('A');
        $oSit->addItemSelect('A', 'Aprovado');
        $oSit->addItemSelect('E', 'Espera');

        $oObs = new Campo('Obs.Final', 'obsfinal', Campo::TIPO_TEXTAREA, 8);

        $oGridFrete = new Campo('Resultado Cálculos Frete', 'gridFrete', Campo::TIPO_GRID, 12, 12, 12, 12, 180);
        $oSequencia = new CampoConsulta('Sequencia', 'seq');
        $oReferencia = new CampoConsulta('Referência', 'ref');
        $oTotalFrete = new CampoConsulta('Total Frete', 'totalfrete', CampoConsulta::TIPO_DECIMAL);
        $oFrete = new CampoConsulta('Frete Mínimo', 'freteminimo', CampoConsulta::TIPO_DECIMAL);

        $oGridFrete->addCampos($oSequencia, $oReferencia, $oTotalFrete, $oFrete);
        $oGridFrete->setSController('MET_GerenciaFrete');
        $oGridFrete->addParam('seqfrete', '0');

        $oGridFrete->getOGrid()->setBUsaCarrGrid(false);
        $oGridFrete->getOGrid()->setIAltura(300);
        $oGridFrete->getOGrid()->setBNaoUsaScroll(true);
        $oGridFrete->getOGrid()->setBScrollInfTelaGrid(true);
        $oGridFrete->getOGrid()->setSScrollInfCampo('criaConsultaGridFrete');
        $oGridFrete->getOGrid()->setSOrdemScrollInf('crescente');
        $oGridFrete->getOGrid()->setSIdTelaGrid($this->getTela()->getId());
        $oGridFrete->getOGrid()->setSId('gerenciafrete_grid');
        $oGridFrete->setId('gerenciafrete_grid');
        $oGridFrete->setApenasTela(true);

        $sCallBack2 = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_GerenciaFrete","calculoFreteTotalFormulas","' . $oGridFrete->getId() . ',' . $oSeqReg->getId() . '");';

        $oValSer->addEvento(Campo::EVENTO_SAIR, $sCallBack2);

        $oL = new Campo('', 'tes', Campo::TIPO_LINHABRANCO);
        $oL->setApenasTela(true);

        $sDataEm = new Campo('Data', 'dataem', Campo::TIPO_DATA, 2);
        $sDataEm->addValidacao(false);
        $sDataEm->setId('gerenciafrete_dataem');

        $this->addCampos(array($oNr, $oCnpj, $oNrFat, $sDataEm, $oCodtip), $oL, array($oNrCon, $oNrNot, $oTotalNf, $oTotalKg, $oFracaoFrete, $oValSer, $oSit), $oL, $oSeqReg, $oGridFrete, $oL, array($oDat, $oHora, $oUser), $oL, $oObs);
    }

    /**
     * Método construtor do grid consulta frete
     * @return type
     */
    function criaConsultaGridFrete() {

        $oGridFrete = new Grid("");
        $oSequencia = new CampoConsulta('Sequencia', 'seq');
        $oReferencia = new CampoConsulta('Referência', 'ref');
        $oTotalFrete = new CampoConsulta('Total Frete', 'totalfrete', CampoConsulta::TIPO_MONEY);
        $oFrete = new CampoConsulta('Frete Mínimo', 'freteminimo', CampoConsulta::TIPO_MONEY);

        $oGridFrete->addCampos($oSequencia);
        $oGridFrete->addCampos($oReferencia);
        $oGridFrete->addCampos($oTotalFrete);
        $oGridFrete->addCampos($oFrete);
        $oGridFrete->setSId('gerenciafrete_grid');

        $aCampos = $oGridFrete->getArrayCampos();
        return $aCampos;
    }

    /**
     * Método que monta a tela de relatório de frete
     */
    public function relGerenciaFrete() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Gerenciamento de Fretes');
        $this->setBTela(true);

        $aDados = $this->getAParametrosExtras();

        //Filtro de células
        $oCnpj = new Campo('CNPJ', 'cnpj', Campo::TIPO_SELECT, 4);
        foreach ($aDados as $key) {
            $val = (int) $key['cnpj'];
            $oCnpj->addItemSelect($val, $val . ' - ' . $key['empdes']);
        }

        $oNrCon = new Campo('Nr. Conhecimento', 'nrconhe', Campo::TIPO_TEXTO, 1);
        $oNrFat = new Campo('Nr. Fat.', 'nrfat', Campo::TIPO_TEXTO, 1);
        $oNrNot = new Campo('Nr. Nota', 'nrnotaoc', Campo::TIPO_TEXTO, 1);

        $oCodtip = new Campo('Tipo', 'codtipo', Campo::TIPO_SELECT, 2);
        $oCodtip->addItemSelect('0', 'Todos');
        $oCodtip->addItemSelect('1', 'Venda');
        $oCodtip->addItemSelect('2', 'Compra');

        $oDatainicial = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');

        $bTipo = new Campo('Detalhado', 'det', Campo::TIPO_CHECK, 1);

        $oL = new Campo('', 'tes', Campo::TIPO_LINHABRANCO);
        $oL->setApenasTela(true);

        $this->addCampos(array($oNrFat, $oCnpj), $oL, array($oNrNot, $oNrCon, $oCodtip), $oL, array($oDatainicial, $oDatafinal), $bTipo);
    }

}
