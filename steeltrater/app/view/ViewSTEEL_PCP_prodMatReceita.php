<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class ViewSTEEL_PCP_prodMatReceita extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oSeqMat = new CampoConsulta('Seq.Mat.', 'seqmat');
        $oProCod = new CampoConsulta('Prod.Inicial', 'prod');
        $oProDes = new CampoConsulta('', 'DELX_PRO_Produtos.pro_descricao');
        //$oMatCod = new CampoConsulta('Cod. Material','matcod');
        $oMatDes = new CampoConsulta('Material', 'STEEL_PCP_material.matdes');
        //$oRecCod = new CampoConsulta('Cod. Receita', 'cod');
        $oRecDes = new CampoConsulta('Receita', 'STEEL_PCP_receitas.peca');

        $oProdFinal = new CampoConsulta('Produto.Final', 'STEEL_PCP_pesqArame.pro_descricao');

        $oDesativa = new CampoConsulta('Desativa', 'desativa');
        $oDesativa->addComparacao('Sim', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oDesativa->setBComparacaoColuna(true);

        $oFilProdCod = new Filtro($oProCod, Filtro::CAMPO_TEXTO, 3);
        $oFilSeqMat = new Filtro($oSeqMat, Filtro::CAMPO_TEXTO, 3);
        $oFilProdFinal = new Filtro($oProdFinal, Filtro::CAMPO_TEXTO, 3);

        $oFilDesativa = new Filtro($oDesativa, Filtro::CAMPO_SELECT, 3, 3, 3, 3);
        $oFilDesativa->addItemSelect('Todos', 'Todos');
        $oFilDesativa->addItemSelect('Não', 'Não');
        $oFilDesativa->addItemSelect('Sim', 'Sim');
        $oFilDesativa->setBInline(true);

        $this->addFiltro($oFilSeqMat, $oFilProdCod, $oFilProdFinal, $oFilDesativa);




        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oSeqMat, $oDesativa, $oProCod, $oProDes, $oMatDes, $oRecDes, $oProdFinal);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Relatório em Excel', 'STEEL_PCP_prodMatReceita', 'contaRegistros', '', false, '', false, '', false, '', true, true);
        $this->addDropdown($oDrop1);
    }

    public function consultaMatOrdem() {
        $oGridMat = new Grid("");

        $oSeqMatGrid = new CampoConsulta('Seq.Mat.', 'seqmat');
        $oSeqMatGrid->setILargura(30);
        $oProDesGrid = new CampoConsulta('Produto', 'DELX_PRO_Produtos.pro_descricao');
        $oProDesGrid->setILargura(300);
        $oMatDesGrid = new CampoConsulta('Material', 'STEEL_PCP_material.matdes');
        $oMatDesGrid->setILargura(100);
        $oRecDesGrid = new CampoConsulta('Receita', 'STEEL_PCP_receitas.peca');
        $oRecDesGrid->setILargura(200);
        $oDurNucMin = new CampoConsulta('DurezaMin', 'durezaNucMin', CampoConsulta::TIPO_DECIMAL);
        $oDurNucMin->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oDurNucMin->setILargura(80);
        $oDurNucMin->setBComparacaoColuna(true);
        $oDurNuMax = new CampoConsulta('DurezaMax', 'durezaNucMax', CampoConsulta::TIPO_DECIMAL);
        $oDurNuMax->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oDurNuMax->setILargura(80);
        $oDurNuMax->setBComparacaoColuna(true);
        $oRevenidoDesc = new CampoConsulta('Revenido', 'tratrevencomp');
        $oRevenidoDesc->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oRevenidoDesc->setILargura(150);
        $oRevenidoDesc->setBComparacaoColuna(true);
        $oProdFinalGrid = new CampoConsulta('Produto Final', 'STEEL_PCP_pesqArame.pro_descricao');


        $oGridMat->addCampos($oSeqMatGrid, $oProDesGrid, $oMatDesGrid, $oRecDesGrid, $oDurNucMin, $oDurNuMax, $oRevenidoDesc, $oProdFinalGrid);

        $aCampos = $oGridMat->getArrayCampos();
        return $aCampos;
    }

    public function criaTela() {
        parent::criaTela();



        $oDados = $this->getAParametrosExtras();

        $oTab = new TabPanel();
        $oAbaPadrao = new AbaTabPanel('PADRÃO');
        $oAbaPadrao->setBActive(true);

        $this->addLayoutPadrao('Aba');

        $sAcao = $this->getSRotina();

        $oCodigo = new Campo('Produto', 'prod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oCodigo->setBCampoBloqueado(true);
        }
        if (method_exists($oDados, 'getPro_codigo')) {
            $oCodigo->setSValor($oDados->getPro_codigo());
            $this->setBTela(true);
        }

        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto Descrição', 'DELX_PRO_Produtos.pro_descricao', Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '', '');
        $oProdes->addCampoBusca('pro_descricao', '', '');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oProdes->setBCampoBloqueado(true);
        }
        if (method_exists($oDados, 'getPro_descricao')) {
            $oProdes->setSValor($oDados->getPro_descricao());
        }

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao', $oProdes->getId(), $this->getTela()->getId());

        $oMatCod = new Campo('Material', 'matcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oMatCod->addValidacao(true, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oMatCod->setBCampoBloqueado(true);
        }

        //campo descrição do material adicionando o campo de busca
        $oMatdes = new Campo('Material Descrição', 'STEEL_PCP_material.matdes', Campo::TIPO_BUSCADOBANCO, 4);
        $oMatdes->setSIdPk($oMatCod->getId());
        $oMatdes->setClasseBusca('STEEL_PCP_Material');
        $oMatdes->addCampoBusca('matcod', '', '');
        $oMatdes->addCampoBusca('matdes', '', '');
        $oMatdes->setSIdTela($this->getTela()->getId());
        $oMatdes->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oMatdes->setBCampoBloqueado(true);
        }

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oMatCod->setClasseBusca('STEEL_PCP_Material');
        $oMatCod->setSCampoRetorno('matcod', $this->getTela()->getId());
        $oMatCod->addCampoBusca('matdes', $oMatdes->getId(), $this->getTela()->getId());

        $oRecCod = new Campo('Receita', 'cod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oRecCod->addValidacao(true, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oRecCod->setBCampoBloqueado(true);
        }

        //campo descrição da receita adicionando o campo de busca
        $oRecdes = new Campo('Receita Descrição', 'STEEL_PCP_receitas.peca', Campo::TIPO_BUSCADOBANCO, 4);
        $oRecdes->setSIdPk($oRecCod->getId());
        $oRecdes->setClasseBusca('STEEL_PCP_receitas');
        $oRecdes->addCampoBusca('cod', '', '');
        $oRecdes->addCampoBusca('peca', '', '');
        $oRecdes->setSIdTela($this->getTela()->getId());
        $oRecdes->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oRecdes->setBCampoBloqueado(true);
        }

        $oLabel1 = new Campo('', 'label1', Campo::TIPO_LINHA);
        $oLabel1->setApenasTela(true);

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oRecCod->setClasseBusca('STEEL_PCP_receitas');
        $oRecCod->setSCampoRetorno('cod', $this->getTela()->getId());
        $oRecCod->addCampoBusca('peca', $oRecdes->getId(), $this->getTela()->getId());
        //produto final


        $oCodigoFinal = new Campo('Produto.Final', 'prodfinal', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigoFinal->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oCodigoFinal->setBCampoBloqueado(true);
        }
        if (method_exists($oDados, 'getProdFinal')) {
            $oCodigoFinal->setSValor($oDados->getProdFinal());
            $this->setBTela(true);
        }

        //campo descrição do produto adicionando o campo de busca
        $oProdesFinal = new Campo('Produto Descrição Final', 'STEEL_PCP_pesqArame.pro_descricao', Campo::TIPO_BUSCADOBANCO, 4);
        $oProdesFinal->setSIdPk($oCodigo->getId());
        $oProdesFinal->setClasseBusca('STEEL_PCP_pesqArame');
        $oProdesFinal->addCampoBusca('pro_codigo', '', '');
        $oProdesFinal->addCampoBusca('pro_descricao', '', '');
        $oProdesFinal->setSIdTela($this->getTela()->getId());
        $oProdesFinal->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oProdesFinal->setBCampoBloqueado(true);
        }
        if (method_exists($oDados, 'getProdFinalDes')) {
            $oProdesFinal->setSValor($oDados->getProdFinalDes());
            $this->setBTela(true);
        }

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigoFinal->setClasseBusca('STEEL_PCP_pesqArame');
        $oCodigoFinal->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oCodigoFinal->addCampoBusca('pro_descricao', $oProdesFinal->getId(), $this->getTela()->getId());




        $oNucDurMin = new Campo('Dur.NucMin.', 'durezaNucMin', Campo::TIPO_DECIMAL, 2);
        //$oNucDurMin->addValidacao(false, Validacao::TIPO_DECIMAL);

        $oNucDurMax = new Campo('Dur.NucMax.', 'durezaNucMax', Campo::TIPO_DECIMAL, 2);
        //$oNucDurMax->addValidacao(false, Validacao::TIPO_DECIMAL);

        $oNucEscala = new Campo('Escala', 'NucEscala', Campo::CAMPO_SELECTSIMPLE, 1);
        $oNucEscala->addItemSelect('HRC', 'HRC');
        $oNucEscala->addItemSelect('HV', 'HV');
        $oNucEscala->addItemSelect('HRB', 'HRB');
        $oNucEscala->addItemSelect('HRA', 'HRA');
        $oNucEscala->addItemSelect('HB', 'HB');


        $oSupDurMin = new Campo('Dur.SuperfMin', 'durezaSuperfMin', Campo::TIPO_DECIMAL, 2);

        $oSupDurMax = new Campo('Dur.SuperfMax', 'durezaSuperfMax', Campo::TIPO_DECIMAL, 2);

        $oSupEscala = new Campo('Escala', 'SuperEscala', Campo::CAMPO_SELECTSIMPLE, 1);
        $oSupEscala->addItemSelect('HRC', 'HRC');
        $oSupEscala->addItemSelect('HV', 'HV');
        $oSupEscala->addItemSelect('HRB', 'HRB');
        $oSupEscala->addItemSelect('HRA', 'HRA');
        $oSupEscala->addItemSelect('HB', 'HB');

        $oCamDurMin = new Campo('Espes.CamadaMin', 'expCamadaMin', Campo::TIPO_TESTE, 2);

        $oCamDurMax = new Campo('Espes.CamadaMax', 'expCamadaMax', Campo::TIPO_TESTE, 2);


        $oSeqMat = new Campo('Seq.Mat.', 'seqmat', Campo::TIPO_TEXTO, 1);
        $oSeqMat->setBCampoBloqueado(true);


        $oTratReven = new Campo('Descrição composta revenimento (Deve estar marcado no cadastro de tratamento "Revenir Composto")', 'tratrevencomp', Campo::TIPO_SELECT, 7);
        $oTratReven->addItemSelect('E ENEGRECIDO', 'REVENIDO E ENEGRECER');
        $oTratReven->addItemSelect('À SECO', 'REVENIDO À SECO');
        $oTratReven->addItemSelect('ENEGRECIDO OLEADO', 'REVENIDO ENEGRECIDO OLEADO');


        $oPpap = new Campo('PPAP', 'ppap', Campo::CAMPO_SELECTSIMPLE, 1);
        $oPpap->addItemSelect('S', 'Sim');
        $oPpap->addItemSelect('N', 'Não');
        $oPpap->setSValor('N');

        $oNrPpap = new Campo('Nr.', 'nrppap', Campo::TIPO_TEXTO, 1);

        $oDiv = new campo('Desativar receita', 'div1', Campo::DIVISOR_VERMELHO, 12, 12, 12, 12);
        $oDiv->setApenasTela(true);

        $oDesativa = new Campo('Desativa receita', 'desativa', Campo::CAMPO_SELECTSIMPLE, 3);
        $oDesativa->addItemSelect('Não', 'Não');
        $oDesativa->addItemSelect('Sim', 'Sim');

        $oObsDesativa = new campo('Observação para desativação', 'obsdesativa', Campo::TIPO_TEXTAREA, 8);



        $oAbaFioMaquina = new AbaTabPanel('FIO MÁQUINA');

        $oFioDurezaSol = new Campo('Dureza.Solicitada(HRB)', 'fioDurezaSol', Campo::TIPO_DECIMAL, 2);
        $oFioEsferio = new campo('Esferiodização(%)', 'fioEsferio', Campo::TIPO_DECIMAL, 2);
        $oFioDescarbonetaTotal = new campo('Descarb.Total(µm)', 'fioDescarbonetaTotal', Campo::TIPO_DECIMAL, 2);
        $oFioDescarbonetaParcial = new campo('Descarb.Parcial(µm)', 'fioDescarbonetaParcial', Campo::TIPO_DECIMAL, 2);
        $oDiamFinalMin = new campo('Diâmetro Final Mínimo(mm)', 'DiamFinalMin', Campo::TIPO_DECIMAL, 3);
        $oDiamFinalMax = new campo('Diâmetro Final Máximo(mm)', 'DiamFinalMax', Campo::TIPO_DECIMAL, 3);

        $oObs = new campo('Observações', 'obs', Campo::TIPO_TEXTAREA, 8);
        $oObs->setILinhasTextArea(3);

        $oAbaPadrao->addCampos(array($oNucDurMin, $oNucDurMax, $oNucEscala), array($oSupDurMin, $oSupDurMax, $oSupEscala), array($oCamDurMin, $oCamDurMax));

        $oAbaFioMaquina->addCampos(array($oFioDurezaSol, $oFioEsferio), array($oFioDescarbonetaTotal, $oFioDescarbonetaParcial), array($oDiamFinalMin, $oDiamFinalMax));

        $oTab->addItems($oAbaPadrao, $oAbaFioMaquina);
        $this->addCampos($oSeqMat, array($oCodigo, $oProdes), $oLabel1, array($oMatCod, $oMatdes), $oLabel1, array($oRecCod, $oRecdes), $oLabel1, array($oCodigoFinal, $oProdesFinal), $oLabel1, $oLabel1, array($oTratReven, $oPpap, $oNrPpap), $oLabel1, $oTab, $oLabel1, $oObs, $oDiv, $oLabel1, $oDesativa, $oObsDesativa);
    }

    public function RelItensPPAP() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Itens Com ou Sem PPAP');
        $this->setBTela(true);

        $oPpap = new Campo('PPAP', 'ppap', Campo::TIPO_SELECT, 2);
        $oPpap->addItemSelect('S', 'Sim');
        $oPpap->addItemSelect('N', 'Não');

        $this->addCampos($oPpap);
    }

}
