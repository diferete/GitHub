<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 20/06/2018
 */

class ViewDELX_NFS_NotaFiscal extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilial = new CampoConsulta('Filial', 'nfs_notafiscalfilial');
        $oSeq = new CampoConsulta('Seq.', 'nfs_notafiscalseq');
        $oNum = new CampoConsulta('Num.', 'nfs_notafiscalnumero');
        $oData= new CampoConsulta('Serie', 'nfs_notafiscalserie');
        $oChegada= new CampoConsulta('Data Chegada', 'nfs_notafiscaldatachegada');
        $oChave= new CampoConsulta('NFE Chave', 'nfs_notafiscalnfechave');
        $oPessoa= new CampoConsulta('Pessoa', 'nfs_notafiscalpessoanome');
        $oDescricaofiltro = new Filtro($oPessoa, Filtro::CAMPO_TEXTO, 5);
        $oCodigofiltro = new Filtro($oNum,Filtro::CAMPO_TEXTO_IGUAL,3);
       

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro,$oCodigofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oSeq, $oFilial, $oPessoa, $oNum, $oData, $oChegada, $oChave);
    }

    public function criaTela() {
        parent::criaTela();


        $oFilial = new Campo('Filial', 'nfs_notafiscalfilial', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq = new Campo('Seq.', 'nfs_notafiscalseq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNum  = new Campo('Num.', 'nfs_notafiscalnumero', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oData = new Campo('Serie', 'nfs_notafiscalserie', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oChegada = new Campo('Data Chegada', 'nfs_notafiscaldatachegada', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oChave = new Campo('NFE Chave', 'nfs_notafiscalnfechave', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oPessoa = new Campo('Pessoa', 'nfs_notafiscalpessoanome', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $this->addCampos(array($oSeq, $oFilial, $oPessoa, $oNum, $oData, $oChegada, $oChave));
    }

}