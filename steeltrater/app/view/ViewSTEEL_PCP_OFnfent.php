<?php

/*
 * classe que implementa a view da geração das of steel
 * 
 * @author Avanei Martendal
 * 
 * @since 22/06/2018
 */

class ViewSTEEL_PCP_OFnfent extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilial = new CampoConsulta('Filial', 'nfs_notafiscalfilial');

        $oBotaoConsulta = new CampoConsulta('OF', 'emitOf', CampoConsulta::TIPO_ACAO);
        $oBotaoConsulta->setSTitleAcao('Emitir Ordem Fabricação!');
        $oBotaoConsulta->addAcao('STEEL_PCP_OFnfentItens', 'acaoMostraTelaApontdiv', '', '');


        $oSeq = new CampoConsulta('Seq.', 'nfs_notafiscalseq');
        $oNum = new CampoConsulta('Num.', 'nfs_notafiscalnumero');
        $oSerie = new CampoConsulta('Serie', 'nfs_notafiscalserie');
        $oChegada = new CampoConsulta('Data Chegada', 'nfs_notafiscaldatachegada', CampoConsulta::TIPO_DATA);
        $oChave = new CampoConsulta('NFE Chave', 'nfs_notafiscalnfechave');
        $oPessoa = new CampoConsulta('Pessoa', 'nfs_notafiscalpessoanome');



        $oDescricaofiltro = new Filtro($oPessoa, Filtro::CAMPO_TEXTO, 5);
        $oCodigofiltro = new Filtro($oNum, Filtro::CAMPO_TEXTO_IGUAL, 3);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oDescricaofiltro, $oCodigofiltro);

        $this->getTela()->setIAltura(400);

        $this->setBScrollInf(false);
        $this->addCampos($oBotaoConsulta, $oFilial, $oNum, $oSerie, $oPessoa, $oChegada, $oChave, $oSeq);
    }

}
