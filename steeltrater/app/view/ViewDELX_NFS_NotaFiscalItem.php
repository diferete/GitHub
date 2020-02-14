<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 20/06/2018
 */

class ViewDELX_NFS_NotaFiscalItem extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilial = new CampoConsulta('Filial', 'nfs_notafiscalfilial');
        $oSeq = new CampoConsulta('Seq.', 'nfs_notafiscalseq');
        $oItemseq = new CampoConsulta('Seq.Item', 'nfs_notafiscalitemseq');
        $oProditem = new CampoConsulta('Cod.Item', 'nfs_notafiscalitemproduto');
        $oNomeprod = new CampoConsulta('Prod.Nome', 'nfs_notafiscalitemprodutonomem');
        $oProunm = new CampoConsulta('Prod.Un.', 'nfs_notafiscalitemprodutounman');
        $oQuant = new CampoConsulta('Quantidade', 'nfs_notafiscalitemquantidade');
        $oVunit = new CampoConsulta('Valor Unit.', 'nfs_notafiscalitemvalorunitari');
        $oVtotal = new CampoConsulta('Valor Total', 'nfs_notafiscalitemvalortotal');
        $oPesoliq = new CampoConsulta('Peso Liquido', 'nfs_notafiscalitempesoliquido');
        $oPesobru = new CampoConsulta('Peso Bruto', 'nfs_notafiscalitempesobruto');
        $oDescricaofiltro = new Filtro($oNomeprod, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $oCodigofiltro = new Filtro($oProditem, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro, $oCodigofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oFilial, $oSeq, $oItemseq, $oProditem, $oNomeprod, $oProunm, $oQuant, $oVunit, $oVtotal, $oPesoliq, $oPesobru);
    }

    public function criaTela() {
        parent::criaTela();


        $oFilial = new Campo('Filial', 'nfs_notafiscalfilial', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq = new Campo('Seq.', 'nfs_notafiscalseq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oItemseq = new Campo('Seq.Item', 'nfs_notafiscalitemseq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oProditem = new Campo('Cod.Item', 'nfs_notafiscalitemproduto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNomeprod = new Campo('Prod.Nome', 'nfs_notafiscalitemprodutonomem', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oProunm = new Campo('Prod.Un.', 'nfs_notafiscalitemprodutounman', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oQuant = new Campo('Quantidade', 'nfs_notafiscalitemquantidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oVunit = new Campo('Valor Unit.', 'nfs_notafiscalitemvalorunitari', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oVtotal = new Campo('Valor Total', 'nfs_notafiscalitemvalortotal', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPesoliq = new Campo('Peso Liquido', 'nfs_notafiscalitempesoliquido', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPesobru = new Campo('Peso Bruto', 'nfs_notafiscalitempesobruto', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $this->addCampos(array($oFilial, $oSeq, $oItemseq, $oProditem, $oNomeprod), array($oProunm, $oQuant, $oVunit, $oVtotal, $oPesoliq, $oPesobru));
    }

}
