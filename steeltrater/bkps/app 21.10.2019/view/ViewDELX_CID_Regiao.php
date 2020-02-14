<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ViewDELX_CID_Regiao extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigoregiao = new CampoConsulta('Cod.Região', 'cid_regiaocodigo');
        $oDescricaoregiao = new CampoConsulta('Região', 'cid_regiaodescricao');
        $oTiporegiao = new CampoConsulta('Tipo', 'cid_regiaotipo');
        $oDataultimofaturamento = new CampoConsulta('Data Ult.Faturamento', 'cid_regiaodataultimofaturament');
        $oDiasfaturamento = new CampoConsulta('Dias-Faturamento', 'cid_regiaonumerodiasfaturament');
        $oDiasfinanceiro = new CampoConsulta('Dias-Financeiro', 'cid_regiaodiasfinanceiro');
        $oDiasentrega = new CampoConsulta('Dias-Entrega', 'cid_regiaodiasentrega');


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);


        $this->setBScrollInf(false);
        $this->addCampos($oCodigoregiao, $oDescricaoregiao, $oTiporegiao, $oDataultimofaturamento, $oDiasfaturamento, $oDiasfinanceiro, $oDiasentrega);
    }

    public function criaTela() {
        parent::criaTela();


        $oCodigoregiao = new Campo('Cod.Região', 'cid_regiaocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDescricaoregiao = new Campo('Região', 'cid_regiaodescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTiporegiao = new Campo('Tipo', 'cid_regiaotipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataultimofaturamento = new Campo('Data Ult.Faturamento', 'cid_regiaodataultimofaturament', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiasfaturamento = new Campo('Dias-Faturamento', 'cid_regiaonumerodiasfaturament', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiasfinanceiro = new Campo('Dias-Financeiro', 'cid_regiaodiasfinanceiro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiasentrega = new Campo('Dias-Entrega', 'cid_regiaodiasentrega', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCodigoregiao, $oDescricaoregiao, $oTiporegiao, $oDataultimofaturamento, $oDiasfaturamento, $oDiasfinanceiro, $oDiasentrega));
    }

}
