<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 21/06/2018
 */

class ViewDELX_CPG_CondicaoPagamento extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Cod.', 'cpg_codigo');
        $oDescri = new CampoConsulta('Descrição', 'cpg_descricao');
        $oParcel = new CampoConsulta('N.Parcelas', 'cpg_numeroparcelas');
        $oAcresc = new CampoConsulta('Tx.Acres', 'cpg_taxaacrescimo');
        $oTaxtabped = new CampoConsulta('Tx.Tab.Ped.', 'cpg_taxatabelapedidos');
        $oTpcond = new CampoConsulta('Tip.Cond.', 'cpg_tipocondicao');
        $oAcaofe = new CampoConsulta('Açãop/feriado', 'cpg_acaoparaferiado');
        $oDiapav = new CampoConsulta('DiaPag.ap.feriado', 'cpg_diapagtoaposvencto');
        $oTexpav = new CampoConsulta('Parc.Avista', 'cpg_textoparcelaavista');
        $oPerdes = new CampoConsulta('Perc.Desc.', 'cpg_percentualdesconto');
        $oBasven = new CampoConsulta('DataBas.Venc.', 'cpg_databasevencto');
        $oPramcp = new CampoConsulta('Praz.Med.Cond.Pag.', 'cpg_prazomediocondpagto');
        $oVencpr = new CampoConsulta('Venc.Principal', 'cpg_tipovenctoprincipal');
        $oMarcon = new CampoConsulta('Marg.Contrib.', 'cpg_margemdecontribuicao');
        $oDiafiv = new CampoConsulta('DiaFix.Venc.', 'cpg_diafixovencimento');
        $oCupom = new CampoConsulta('Cupom', 'cpg_cupom');
        $oDatfv = new CampoConsulta('DataFixaVenc.', 'cpg_datafixavencimento', CampoConsulta::TIPO_DATA);
        $oVeppc = new CampoConsulta('TipoVenc.Princ.Ped.Comp.', 'cpg_tipovenctoprincpedcompra');
        $oValmp = new CampoConsulta('ValorMin.Parc.', 'cpg_valorminimoparcela');

        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setILarguraGrid(2500);

        $oDescricaofiltro = new Filtro($oDescri, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);



        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);

        $this->addCampos($oCodigo, $oDescri, $oParcel, $oAcresc, $oTaxtabped, $oTpcond, $oAcaofe, $oDiapav, $oTexpav, $oPerdes, $oBasven, $oPramcp, $oVencpr, $oMarcon, $oDiafiv, $oCupom, $oDatfv, $oVeppc, $oValmp);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new Campo('Cod.', 'cpg_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDescri = new Campo('Descrição', 'cpg_descricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oParcel = new Campo('N.Parcelas', 'cpg_numeroparcelas', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAcresc = new Campo('Tx.Acres', 'cpg_taxaacrescimo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTaxtabped = new Campo('Tx.Tab.Ped.', 'cpg_taxatabelapedidos', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTpcond = new Campo('Tip.Cond.', 'cpg_tipocondicao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAcaofe = new Campo('Açãop/feriado', 'cpg_acaoparaferiado', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiapav = new Campo('DiaPag.ap.feriado', 'cpg_diapagtoaposvencto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTexpav = new Campo('Parc.Avista', 'cpg_textoparcelaavista', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPerdes = new Campo('Perc.Desc.', 'cpg_percentualdesconto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oBasven = new Campo('DataBas.Venc.', 'cpg_databasevencto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPramcp = new Campo('Praz.Med.Cond.Pag.', 'cpg_prazomediocondpagto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oVencpr = new Campo('Venc.Principal', 'cpg_tipovenctoprincipal', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMarcon = new Campo('Marg.Contrib.', 'cpg_margemdecontribuicao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiafiv = new Campo('DiaFix.Venc.', 'cpg_diafixovencimento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCupom = new Campo('Cupom', 'cpg_cupom', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatfv = new Campo('DataFixaVenc.', 'cpg_datafixavencimento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oVeppc = new Campo('TipoVenc.Princ.Ped.Comp.', 'cpg_tipovenctoprincpedcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oValmp = new Campo('ValorMin.Parc.', 'cpg_valorminimoparcela', Campo::TIPO_TEXTO, 2, 2, 12, 12);


        $this->addCampos(array($oCodigo, $oDescri, $oParcel, $oAcresc, $oTaxtabped), array($oTpcond, $oAcaofe, $oDiapav, $oTexpav, $oPerdes), array($oBasven, $oPramcp, $oVencpr, $oMarcon, $oDiafiv), array($oCupom, $oDatfv, $oVeppc, $oValmp));
    }

}
