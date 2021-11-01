<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewConsultaEstoque extends View {

    public function __construct() {
        parent::__construct();
    }

    function criaTela() {
        parent::criaTela();

        //carrega parametro da tela
        $oParam = Fabrica::FabricarController('Param');
        $bVisualizaEmpenho = $oParam->getBempenho();



        $this->setBTela(true);

        $oGrupo = new Campo('Grupo', 'grupo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oGrupo->setClasseBusca('GrupoProd');
        $oGrupo->setSCampoRetorno('grucod', $this->getTela()->getId());
        $oGrupo->setSValor('0');

        $oGrupo1 = new Campo('Grupo', 'grupo1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oGrupo1->setClasseBusca('GrupoProd');
        $oGrupo1->setSCampoRetorno('grucod', $this->getTela()->getId());
        $oGrupo1->setSValor('999');

        $oSubGrupo = new Campo('Sub.Grupo', 'subgrupo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubGrupo->setClasseBusca('SubGrupoProd');
        $oSubGrupo->setSCampoRetorno('subcod', $this->getTela()->getid());
        $oSubGrupo->setSValor('0');

        $oSubGrupo1 = new Campo('Sub.Grupo', 'subgrupo1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubGrupo1->setClasseBusca('SubGrupoProd');
        $oSubGrupo1->setSCampoRetorno('subcod', $this->getTela()->getid());
        $oSubGrupo1->setSValor('999');

        $oFamilia = new Campo('Família', 'familia', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFamilia->setClasseBusca('FamProd');
        $oFamilia->setSCampoRetorno('famcod', $this->getTela()->getid());
        $oFamilia->setSValor('0');

        $oFamilia1 = new Campo('Família', 'familia1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFamilia1->setClasseBusca('FamProd');
        $oFamilia1->setSCampoRetorno('famcod', $this->getTela()->getid());
        $oFamilia1->setSValor('999');

        $oSubFam = new Campo('Sub.Fam', 'subfamilia', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubFam->setClasseBusca('FamSub');
        $oSubFam->setSCampoRetorno('famsub', $this->getTela()->getid());
        $oSubFam->setSValor('0');

        $oSubFam1 = new Campo('Sub.Fam', 'subfamilia1', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oSubFam1->setClasseBusca('FamSub');
        $oSubFam1->setSCampoRetorno('famsub', $this->getTela()->getid());
        $oSubFam1->setSValor('999');
        $sDadosSolCot = '';
        if ($_REQUEST['parametrosCampos']) {
            foreach ($_REQUEST['parametrosCampos'] as $sAtual) {
                $sDadosSolCot = $sAtual;
            }
        }
        $oFiltroAdd = new Campo('', 'filadd', Campo::TIPO_TEXTO, 1);
        $oFiltroAdd->setSValor($sDadosSolCot);
        $oFiltroAdd->setBOculto(true);

        $oCodigo = new Campo('Código', 'procod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigo->setClasseBusca('Produto');
        $oCodigo->setSCampoRetorno('procod', $this->getTela()->getid());

        $oBtnBuscar = new Campo('Buscar', '', Campo::TIPO_BOTAOSMALL);





        $oBtnCarregar = new Campo('Carregar Itens', '', Campo::TIPO_BOTAOSMALL);
        /* Renderiza o grid */



        $oFieldGrupo = new FieldSet('Pesquisar por grupos');
        $oFieldGrupo->addCampos(array($oGrupo, $oGrupo1, $oSubGrupo, $oSubGrupo1), array($oFamilia, $oFamilia1, $oSubFam, $oSubFam1, $oBtnCarregar, $oFiltroAdd));
        $oFieldGrupo->setOculto(true);
        //grid que lista os produtos

        $oGridProdutos = new Campo('Produtos', 'gridEstoque', Campo::TIPO_GRID, 12, 12, 12, 12, 180);
        $oProcodGrid = new CampoConsulta('Código', 'procod', CampoConsulta::TIPO_LARGURA, 35);
        $oProdesGrid = new CampoConsulta('Descrição', 'prodes', CampoConsulta::TIPO_LARGURA, 20);
        $oPesoGrid = new CampoConsulta('Peso', 'propesprat', CampoConsulta::TIPO_DECIMAL);

        $oPreco = new CampoConsulta('Preço', 'tabvenda.preco', CampoConsulta::TIPO_DECIMAL);
        $oPreco->addComparacao('0', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');



        $oGridProdutos->addCampos($oProcodGrid, $oProdesGrid, $oPesoGrid, $oPreco);
        $oGridProdutos->setSController('ConsultaEstoque');
        $oGridProdutos->addParam('procod', '0');


        $oGridEstoque = new Campo('Estoques', 'estoque', Campo::TIPO_GRIDVIEW, 3, 3, 3, 3);
        $oGridEstoque->addCabGridView('Almoxarifado');
        $oGridEstoque->addCabGridView('Quantidade');
        $oGridEstoque->addLinhasGridView(1, 'Geral');
        $oGridEstoque->addLinhasGridView(1, '0');
        $oGridEstoque->addLinhasGridView(2, 'Acabado');
        $oGridEstoque->addLinhasGridView(2, '0');


        $oPedAberto = new Campo('Pedidos', 'ped', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedAberto->setSCorFundo(Campo::FUNDO_MONEY);


        $oSaldoPed = new Campo('Saldo', 'saldo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSaldoPed->setSCorFundo(Campo::FUNDO_AMARELO);
        $oSaldoPed->setSTipoBotao(Campo::BUTTON_SUCCESS);

        if ($bVisualizaEmpenho) {
            $oBtnEmpenho = new Campo('Ped.', '', Campo::TIPO_BOTAOSMALL, 1, 1, 1, 1);
        }

        $oOf = new Campo('Fabricação', 'of', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oOf->setSTipoBotao(Campo::BUTTON_SUCCESS);
        $oOf->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOf->setClasseBusca('OfRep');
        $oOf->setSCampoRetorno('op', $this->getTela()->getId());
        $oOf->setSParamBuscaPk($oCodigo->getId());



        $oFildEmb = new FieldSet('Embalagem');
        $oFildEmb->setOculto(false);

        $oGridEmb = new Campo('Estoques', 'estoque', Campo::TIPO_GRIDVIEW, 6, 6, 6, 6);
        $oGridEmb->setSCorCabGridView(Campo::GRIDVIEW_CORINFO);
        $oGridEmb->addCabGridView('Ean');
        $oGridEmb->addCabGridView('Código');
        $oGridEmb->addCabGridView('Peças');
        $oGridEmb->addCabGridView('Caixa');
        $oGridEmb->addLinhasGridView(1, '0');
        $oGridEmb->addLinhasGridView(1, '0');
        $oGridEmb->addLinhasGridView(1, '0');
        $oGridEmb->addLinhasGridView(1, '0');

        $oFildEmb->addCampos($oGridEmb);




        $oGridProdutos->getOGrid()->setSEventoClick('var chave=""; $("#' . $oGridProdutos->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); $("#' . $oCodigo->getId() . '").val(chave.substr(7,(chave.length - 1))); '  //str.replace("Microsoft", "W3Schools")
                . 'requestAjax("","ConsultaEstoque","geraEstoque","' . $oGridEstoque->getId() . '"+","+chave+","+"' . $oPedAberto->getId() . '"+","+"' . $oSaldoPed->getId() . '"+","+"' . $oOf->getId() . '"+","+"' . $oGridEmb->getId() . '");');




        $sAcaoCarregaItens = '$("#' . $oCodigo->getId() . '").val("");requestAjax("' . $this->getTela()->getId() . '-form","ConsultaEstoque","getDadosGrid","' . $oGridProdutos->getId() . '","criaConsultaGridEstoque");';
        $oBtnCarregar->addAcaoBotao($sAcaoCarregaItens);
        if ($sDadosSolCot !== '') {
            $this->getTela()->setSAcaoShow($sAcaoCarregaItens);
        }
        if ($sDadosSolCot == '') {
            $oGridProdutos->getOGrid()->setBUsaCarrGrid(true);
            $oGridProdutos->getOGrid()->setBNaoUsaScroll(true);
            $oGridProdutos->getOGrid()->setBScrollInfTelaGrid(true);
            $oGridProdutos->getOGrid()->setSScrollInfCampo('criaConsultaGridEstoque');
            $oGridProdutos->getOGrid()->setSOrdemScrollInf('crescente');
            $oGridProdutos->getOGrid()->setSIdTelaGrid($this->getTela()->getId());
        }

        $sEventoBuscar = 'if ($("#' . $oCodigo->getId() . '").val()!=="")'
                . '{'
                . ' zeraCampoEstoque("' . $oGrupo->getId() . '","' . $oGrupo1->getId() . '","' . $oSubGrupo->getId() . '","' . $oSubGrupo1->getId() . '",'
                . '"' . $oFamilia->getId() . '","' . $oFamilia1->getId() . '","' . $oSubFam->getId() . '","' . $oSubFam1->getId() . '","' . $oFiltroAdd->getId() . '");'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","ConsultaEstoque","getDadosGrid","' . $oGridProdutos->getId() . '",'
                . '"criaConsultaGridEstoque"); requestAjax("","ConsultaEstoque",'
                . '"geraEstoque","' . $oGridEstoque->getId() . '"+",'
                . '"+$("#' . $oCodigo->getId() . '").val()+","+"' . $oPedAberto->getId() . '"+",'
                . '"+"' . $oSaldoPed->getId() . '"+","+"' . $oOf->getId() . '"+","+"' . $oGridEmb->getId() . '")};';
        //adiciona o evento no botao sair
        $oCodigo->addEvento(Campo::EVENTO_ENTER, $sEventoBuscar);


        $oBtnBuscar->addAcaoBotao($sEventoBuscar);

        if ($bVisualizaEmpenho) {
            $oBtnEmpenho->addAcaoBotao('verificaTab("menu-1-est","1-est","EmpenhoPed","acaoMostraTela","tabmenu-1-est","Empenho de Pedidos",$("#' . $oCodigo->getId() . '").val());');
        }
        if ($bVisualizaEmpenho) {
            $this->addCampos($oFieldGrupo, array($oCodigo, $oBtnBuscar), $oGridProdutos, array($oGridEstoque, $oPedAberto, $oSaldoPed, $oBtnEmpenho, $oOf), $oFildEmb);
        } else {
            $this->addCampos($oFieldGrupo, array($oCodigo, $oBtnBuscar), $oGridProdutos, array($oGridEstoque, $oPedAberto, $oSaldoPed, $oOf), $oFildEmb);
        }
    }

    function criaConsultaGridEstoque() {


        $oGridEstoque = new Grid("");


        $oProcodGrid = new CampoConsulta('Código', 'procod');
        $oProdesGrid = new CampoConsulta('Descrição', 'prodes');
        $oPesoGrid = new CampoConsulta('Peso', 'propesprat', CampoConsulta::TIPO_DECIMAL);
        $oPreco = new CampoConsulta('Preço', 'tabvenda.preco', CampoConsulta::TIPO_MONEY);
        $oPreco->addComparacao('0', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');

        $oGridEstoque->addCampos($oProcodGrid);
        $oGridEstoque->addCampos($oProdesGrid);
        $oGridEstoque->addCampos($oPesoGrid);
        $oGridEstoque->addCampos($oPreco);

        $aCampos = $oGridEstoque->getArrayCampos();
        return $aCampos;
    }

}
