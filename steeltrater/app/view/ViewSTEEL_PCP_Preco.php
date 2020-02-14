<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */

class ViewSTEEL_PCP_Preco extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Codigo', 'tpv_codigo');
        // $Reg = new CampoConsulta('Regiao', 'CID_RegiaoCodigo');
        // $oCpgCod = new CampoConsulta('CPC_Cod.', 'CPG_Codigo');
        //  $oMoeCod = new CampoConsulta('Moe.Cod.', 'MOE_Codigo');
        $oDes = new CampoConsulta('Descrição', 'TPV_Descricao');
        // $oAti = new CampoConsulta('Ativa', 'TPV_Ativa');
        // $oCliCod = new CampoConsulta('Cliente Cod.', 'TPV_ClienteCodigo', CampoConsulta::TIPO_DECIMAL);
        //$oDtInic = new CampoConsulta('Data Inicio', 'TPV_DataInicio', CampoConsulta::TIPO_DATA);
        //$oCom = new CampoConsulta('Comissão', 'TPV_Comissao', CampoConsulta::TIPO_DECIMAL);
        //$oComInc = new CampoConsulta('Com. Inclusa', 'TPV_ComissaoInclusa');
        // $oMarkup = new CampoConsulta('Markup', 'TPV_Markup', CampoConsulta::TIPO_DECIMAL);
        // $oMarNeg = new CampoConsulta('Marg.Negociação', 'TPV_MargemNegociacao', CampoConsulta::TIPO_DECIMAL);
        // $oDescon = new CampoConsulta('Desconto', 'TPV_Desconto', CampoConsulta::TIPO_DECIMAL);
        //$oArred = new CampoConsulta('Arred.Preço', 'TPV_ArredondaPreco');
        //$oIcmsInc = new CampoConsulta('ICMS Incl.', 'TPV_ICMSIncluso');
        //$oDtBase = new CampoConsulta('Data Base', 'TPV_DataBase');
        //$oFretCod = new CampoConsulta('Frete Cod.', 'FRE_TipoFreteCodigo');
        //$oCup = new CampoConsulta('Cupom', 'TPV_Cupom');
        // $oLimDesc = new CampoConsulta('Limite Desc.', 'TPV_LimiteDesconto', CampoConsulta::TIPO_DECIMAL);
        // $oDtVal = new CampoConsulta('Data Validade', 'TPV_DataValidade', CampoConsulta::TIPO_DATA);
        //$oConvMoeDigPed = new CampoConsulta('Conv.Moe.Dig.', 'TPV_ConverteMoedaDigitacaoPedi');
        //$oAvpInd = new CampoConsulta('AVP Indice', 'TPV_TabelaPrecoAVPIndice', CampoConsulta::TIPO_DECIMAL);
        //$oAssocia = new CampoConsulta('Associado', 'TPV_TabelaPrecoAssociado');
        //$oForPreco = new CampoConsulta('Formula', 'TPV_TabelaPrecoFormula');
        //$oVctoFix = new CampoConsulta('Usa Vcto Fixo', 'TPV_TabelaPrecoUsaVctoFixo');
        // $oValFretTon = new CampoConsulta('Frete Ton.', 'TPV_ValorFreteTon', CampoConsulta::TIPO_DECIMAL);

        $oCodfiltro = new Filtro($oCod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oDescricaoFiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oCodfiltro, $oDescricaoFiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oDes);
    }

    public function criaTela() {
        parent::criaTela();

        /*
          $oCod = new Campo('Codigo', 'tpv_codigo', Campo::TIPO_TEXTO,2,2,2);
          $oCod->setBCampoBloqueado(true);
          $Reg = new Campo('Regiao', 'CID_RegiaoCodigo', Campo::TIPO_TEXTO,2,2,2);
          $oCpgCod = new Campo('CPC_Cod.', 'CPG_Codigo', Campo::TIPO_TEXTO,2,2,2);
          $oMoeCod = new Campo('Moe.Cod.', 'MOE_Codigo', Campo::TIPO_TEXTO,2,2,2);
          $oDes = new Campo('Descrição', 'TPV_Descricao', Campo::TIPO_TEXTO,2,2,2);
          $oAti = new Campo('Ativa', 'TPV_Ativa', Campo::TIPO_TEXTO,2,2,2);
          $oCliCod = new Campo('Cliente Cod.', 'TPV_ClienteCodigo', Campo::TIPO_DECIMAL,2,2,2);
          $oDtInic = new Campo('Data Inicio', 'TPV_DataInicio', Campo::TIPO_DATA,2,2,2);
          $oCom = new Campo('Comissão', 'TPV_Comissao', Campo::TIPO_DECIMAL,2,2,2);
          $oComInc = new Campo('Com. Inclusa', 'TPV_ComissaoInclusa', Campo::TIPO_TEXTO,2,2,2);
          $oMarkup = new Campo('Markup', 'TPV_Markup', Campo::TIPO_DECIMAL,2,2,2);
          $oMarNeg = new Campo('Marg.Negociação', 'TPV_MargemNegociacao', Campo::TIPO_DECIMAL,2,2,2);
          $oDescon = new Campo('Desconto', 'TPV_Desconto', Campo::TIPO_DECIMAL,2,2,2);
          $oArred = new Campo('Arred.Preço', 'TPV_ArredondaPreco', Campo::TIPO_TEXTO,2,2,2);
          $oIcmsInc = new Campo('ICMS Incl.', 'TPV_ICMSIncluso', Campo::TIPO_TEXTO,2,2,2);
          $oDtBase = new Campo('Data Base', 'TPV_DataBase', Campo::TIPO_TEXTO,2,2,2);
          $oFretCod = new Campo('Frete Cod.', 'FRE_TipoFreteCodigo', Campo::TIPO_TEXTO,2,2,2);
          $oCup = new Campo('Cupom', 'TPV_Cupom', Campo::TIPO_TEXTO,2,2,2);
          $oLimDesc = new Campo('Limite Desc.', 'TPV_LimiteDesconto', Campo::TIPO_DECIMAL,2,2,2);
          $oDtVal = new Campo('Data Validade', 'TPV_DataValidade', Campo::TIPO_DATA,2,2,2);
          $oConvMoeDigPed = new Campo('Conv.Moe.Dig.', 'TPV_ConverteMoedaDigitacaoPedi', Campo::TIPO_TEXTO,2,2,2);
          $oAvpInd = new Campo('AVP Indice', 'TPV_TabelaPrecoAVPIndice', Campo::TIPO_DECIMAL,2,2,2);
          $oAssocia = new Campo('Associado', 'TPV_TabelaPrecoAssociado', Campo::TIPO_TEXTO,2,2,2);
          $oForPreco = new Campo('Formula', 'TPV_TabelaPrecoFormula', Campo::TIPO_TEXTO,2,2,2);
          $oVctoFix = new Campo('Usa Vcto Fixo', 'TPV_TabelaPrecoUsaVctoFixo', Campo::TIPO_TEXTO,2,2,2);
          $oValFretTon = new Campo('Frete Ton.', 'TPV_ValorFreteTon', Campo::TIPO_DECIMAL,2,2,2);

          $this->addCampos(
          array($oCod,$Reg,$oCpgCod,$oMoeCod,$oDes,$oAti,$oCliCod,$oDtInic,
          $oCom,$oComInc,$oMarkup,$oMarNeg,$oDescon,$oArred,
          $oIcmsInc,$oIcmsInc,$oDtBase,$oFretCod,$oFretCod,
          $oCup,$oLimDesc,$oLimDesc,$oDtVal,$oConvMoeDigPed,
          $oConvMoeDigPed,$oAvpInd,$oAssocia,$oForPreco,$oVctoFix,$oValFretTon)); */
    }

}
