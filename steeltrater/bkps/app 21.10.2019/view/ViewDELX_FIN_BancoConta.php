<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ViewDELX_FIN_BancoConta extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.', 'fin_bancocodigo');
        $oNum = new CampoConsulta('Num.', 'fin_bancocontanumero');
        $oAge = new CampoConsulta('Agência', 'fin_bancocontaagencia');
        $oRem = new CampoConsulta('GeraRem.', 'fin_bancocontageraremessa');
        $oCob = new CampoConsulta('Cobr.Seq.', 'fin_bancocontacobrancaseq');
        $oPag = new CampoConsulta('Pagam.Seq.', 'fin_bancocontapagamentoseq');
        $oChe = new CampoConsulta('Emite Cheque', 'fin_bancocontaemitecheque');
        $oUltChe = new CampoConsulta('Ult.Cheque', 'fin_bancocontaultimocheque');
        $oLayChe = new CampoConsulta('Lay.Cheque', 'fin_bancocontalaycheque');
        $oFilial = new CampoConsulta('Conta Filial', 'fin_bancocontafilial');
        //$oDescricaofiltro = new Filtro($oCidade, Filtro::CAMPO_TEXTO, 5);
        //$oCodigofiltro = new Filtro($oCodcidade,Filtro::CAMPO_TEXTO_IGUAL,3);
        //$oEstadofiltro = new Filtro($oEstado, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        //$this->addFiltro($oCodigofiltro,$oDescricaofiltro, $oEstadofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod,$oNum,$oAge,$oRem,$oCob,$oPag,$oChe,$oUltChe,$oLayChe,$oFilial);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Cod.', 'fin_bancocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNum = new Campo('Num.', 'fin_bancocontanumero', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAge = new Campo('Agência', 'fin_bancocontaagencia', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRem = new Campo('GeraRem.', 'fin_bancocontageraremessa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCob = new Campo('Cobr.Seq.', 'fin_bancocontacobrancaseq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPag = new Campo('Pagam.Seq.', 'fin_bancocontapagamentoseq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oChe = new Campo('Emite Cheque', 'fin_bancocontaemitecheque', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUltChe = new Campo('Ult.Cheque', 'fin_bancocontaultimocheque', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oLayChe = new Campo('Lay.Cheque', 'fin_bancocontalaycheque', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilial = new Campo('Conta Filial', 'fin_bancocontafilial', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCod,$oNum,$oAge,$oRem,$oCob),array($oPag,$oChe,$oUltChe,$oLayChe,$oFilial));
    }

}
