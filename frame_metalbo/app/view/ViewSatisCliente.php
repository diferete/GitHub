<?php

/*
 * Classe que implementa a view da pesquisa de satisfacao 
 * 
 * @author Avanei Martendal
 * @since 14/01/2018
 */

class ViewSatisCliente extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        //grid dos itens


        $oGridItens = new Campo('Resultado da pesquisa', 'Pesquisa', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridItens->getOGrid()->setILarguraGrid(1800);
        $this->getTela()->setILarguraGrid(1200);

        $oNrGrid = new CampoConsulta('Nr', 'nr');
        $oSeqGrid = new CampoConsulta('Seq', 'seq');
        $oEmpcodGrid = new CampoConsulta('Cnpj', 'empcod');
        $oEmpcodGrid->setILargura(100);
        $oEmpdesGrid = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);
        $oEmpdesGrid->setILargura(250);
        $oEmailGrid = new CampoConsulta('Mail', 'email');
        $oEmailGrid->setILargura(150);

        $oComercialGrid = new CampoConsulta('Comercial', 'comercial', CampoConsulta::TIPO_DESTAQUE1);
        $oProdReqGrid = new CampoConsulta('Prod.Requisito', 'prodrequisito', CampoConsulta::TIPO_DESTAQUE1);
        $oEmbGrid = new CampoConsulta('Embalagem', 'prodembalagem', CampoConsulta::TIPO_DESTAQUE1);
        $oPrazoGrid = new CampoConsulta('Prazo', 'prodprazo', CampoConsulta::TIPO_DESTAQUE1);

        $oGeralExpGrid = new CampoConsulta('Expectativa', 'geralexpectativa', CampoConsulta::TIPO_DESTAQUE1);

        $oIndicaGrid = new CampoConsulta('Indicação', 'geralindica', CampoConsulta::TIPO_DESTAQUE1);

        $oEmailEnvGrid = new CampoConsulta('Enviado', 'emailenv');
        $oEmailEnvGrid->addComparacao('Sim', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oEmailEnvGrid->addComparacao('Não', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, null);


        $oGridItens->addCampos($oNrGrid, $oSeqGrid, $oEmpdesGrid, $oEmailGrid, $oComercialGrid, $oProdReqGrid, $oEmbGrid, $oPrazoGrid, $oGeralExpGrid, $oIndicaGrid, $oEmailEnvGrid);

        $oGridItens->setSController('SatisClientePesqShow');
        $oGridItens->addParam('filcgc', '0');
        $oGridItens->addParam('nr', '0');
        $oGridItens->getOGrid()->setIAltura(450);
        $oGridItens->getOGrid()->setBScrollInf(false);

        //campos da consulta normal

        $oFilcgc = new CampoConsulta('CNPJ', 'filcgc');
        $oNr = new CampoConsulta('Número', 'nr');
        $oTitulo = new CampoConsulta('Título', 'titulo', CampoConsulta::TIPO_DESTAQUE1);

        $oData = new CampoConsulta('Data da pesquisa', 'data', CampoConsulta::TIPO_DATA);
        $oPeriodo = new CampoConsulta('Período', 'periodo', CampoConsulta::TIPO_LARGURA, 200);
        $oObs = new CampoConsulta('Obs', 'obs');

        $this->setUsaAcaoExcluir(false);

        $oFNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);

        $this->addFiltro($oFNr);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","SatisClientePesqShow","getDadosGridDetalheShow","' . $oGridItens->getId() . '",chave);');

        $this->addCamposGrid($oGridItens);

        $this->addCampos($oFilcgc, $oNr, $oTitulo, $oData, $oPeriodo, $oObs);

        $this->getTela()->setIAltura(200);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Relatórios', Dropdown::TIPO_PRIMARY, 2, 2, 2, 2);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'SatisCliente', 'acaoMostraRelConsulta', '', false, 'relsatispesq', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EXCEL) . 'Converte para excel', 'SatisCliente', 'acaoMostraRelXls', '', false, 'relsatispesqxls', false, '', false, '', false, false);

        $this->addDropdown($oDrop1);
    }

    public function criaTela() {
        parent::criaTela();

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Número da pesquisa', 'nr', Campo::TIPO_TEXTO, 2, 2, 2, 2);

        $oTitulo = new Campo('Título da pesquisa', 'titulo', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oTitulo->setSCorFundo(Campo::FUNDO_MONEY);

        $oDataPesquisa = new Campo('Data', 'data', Campo::TIPO_DATA, 2, 2, 2, 2);
        $oDataPesquisa->setSValor(date('d/m/Y'));

        $oPeriodo = new Campo('Perído', 'periodo', Campo::TIPO_TEXTO, 8, 8, 8, 8);

        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 8, 8, 8, 8);
        $oObs->setILinhasTextArea(8);

        //monta campo de controle para inserir ou alterar
        $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2);
        $oAcao->setApenasTela(true);
        if ($this->getSRotina() == View::ACAO_INCLUIR) {
            $oAcao->setSValor('incluir');
        } else {
            $oAcao->setSValor('alterar');
        }
        $this->setSIdControleUpAlt($oAcao->getId());

        $this->addCampos(array($oFilcgc, $oNr), $oTitulo, $oDataPesquisa, $oPeriodo, $oObs, $oAcao);

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cadastro de Pesquisa', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Inserir Pesquisa', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);
    }

}
