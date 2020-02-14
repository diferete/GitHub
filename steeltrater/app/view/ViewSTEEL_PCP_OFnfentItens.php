<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_OFnfentItens extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilial = new CampoConsulta('Filial', 'nfs_notafiscalfilial');
        $oSeq = new CampoConsulta('Seq.', 'nfs_notafiscalseq');
        $oItemseq = new CampoConsulta('Seq.Item', 'nfs_notafiscalitemseq');
        $oProditem = new CampoConsulta('Cod.Item', 'nfs_notafiscalitemproduto');
        $oNomeprod = new CampoConsulta('Prod.Nome', 'nfs_notafiscalitemprodutonomem');
        $oProunm = new CampoConsulta('Prod.Un.', 'nfs_notafiscalitemprodutounman');
        $oQuant = new CampoConsulta('Quantidade', 'nfs_notafiscalitemquantidade', CampoConsulta::TIPO_DECIMAL);
        $oVunit = new CampoConsulta('Valor Unit.', 'nfs_notafiscalitemvalorunitari', CampoConsulta::TIPO_DECIMAL);
        $oVtotal = new CampoConsulta('Valor Total', 'nfs_notafiscalitemvalortotal', CampoConsulta::TIPO_DECIMAL);
        $oPesoliq = new CampoConsulta('Peso Liquido', 'nfs_notafiscalitempesoliquido', CampoConsulta::TIPO_DECIMAL);
        $oPesobru = new CampoConsulta('Peso Bruto', 'nfs_notafiscalitempesobruto', CampoConsulta::TIPO_DECIMAL);
        $oDescricaofiltro = new Filtro($oNomeprod, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $oCodigofiltro = new Filtro($oProditem, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oDescricaofiltro, $oCodigofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oFilial, $oSeq, $oItemseq, $oProditem, $oNomeprod, $oProunm, $oQuant, $oVunit, $oVtotal, $oPesoliq, $oPesobru);
    }

    public function criaTela() {
        parent::criaTela();

        //grid dos itens
        $oGridNfIten = new campo('Itens da nota fiscal', 'gridItensNf', Campo::TIPO_GRID, 12, 12, 12, 12, 200);


        $oSeqItenCons = new CampoConsulta('Sequência', 'nfs_notafiscalitemseq');
        $oSeqItenCons->setILargura(100);
        $oIten = new CampoConsulta('Produto', 'nfs_notafiscalitemproduto');
        $oIten->setILargura(100);
        $oItenNome = new CampoConsulta('Descrição', 'nfs_notafiscalitemprodutonomem');
        $oUn = new CampoConsulta('Un.', 'nfs_notafiscalitemprodutounman');
        $oQt = new CampoConsulta('Quant.', 'nfs_notafiscalitemquantidade', CampoConsulta::TIPO_DECIMAL);

        $oGridNfIten->addCampos($oSeqItenCons, $oIten, $oItenNome, $oUn, $oQt);
        $oGridNfIten->setSController('DELX_NFS_NotaFiscalItem');
        $oGridNfIten->addParam('nfs_notafiscalseq', '0');

        //campos abaixo do grid
        //pega os parametros
        $aDados = $this->getAParametrosExtras();

        $oFilial = new campo('Filial', 'nfs_notafiscalfilial', Campo::TIPO_TEXTO, 2);
        $oFilial->setSValor($aDados['nfs_notafiscalfilial']);
        $oFilial->setBCampoBloqueado(true);
        $oFilialSeq = new campo('Seq', 'nfs_notafiscalseq', Campo::TIPO_TEXTO, 1);
        $oFilialSeq->setSValor($aDados['nfs_notafiscalseq']);
        $oFilialSeq->setBCampoBloqueado(true);

        $oSeqIten = new Campo('Seq. Iten', 'nfs_notafiscalitemseq', Campo::TIPO_TEXTO, 1);



        //faz a busca inicial dos dados
        $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OFnfentItens","getDadosGrid","' . $oGridNfIten->getId() . '","consultaItenNf"); ';
        $this->getTela()->setSAcaoShow($sAcaoBusca);
        $this->addCampos($oGridNfIten, array($oFilial, $oFilialSeq, $oSeqIten));
    }

    public function consultaItenNf() {
        $oGridNfIten = new Grid("");

        $oSeqItenCons = new CampoConsulta('Sequência', 'nfs_notafiscalitemseq');
        $oSeqItenCons->setILargura(100);
        $oIten = new CampoConsulta('Produto', 'nfs_notafiscalitemproduto');
        $oIten->setILargura(100);
        $oItenNome = new CampoConsulta('Descrição', 'nfs_notafiscalitemprodutonomem');
        $oUn = new CampoConsulta('Un.', 'nfs_notafiscalitemprodutounman');
        $oQt = new CampoConsulta('Quant.', 'nfs_notafiscalitemquantidade', CampoConsulta::TIPO_DECIMAL);


        $oGridNfIten->addCampos($oSeqItenCons);
        $oGridNfIten->addCampos($oIten);
        $oGridNfIten->addCampos($oItenNome);
        $oGridNfIten->addCampos($oUn);
        $oGridNfIten->addCampos($oQt);

        $aCampos = $oGridNfIten->getArrayCampos();
        return $aCampos;
    }

}
