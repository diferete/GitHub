<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class ViewDELX_TDS_TipoDespesa extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cód.', 'tds_codigo');
        $oDes = new CampoConsulta('Descrição', 'tds_descricao');
        $oIna = new CampoConsulta('Inativa', 'tds_inativa');
        $oCon = new CampoConsulta('Conta Titulo', 'tds_contatitulo');
        $oTip = new CampoConsulta('Tipo', 'tds_tipo');
        $oGru = new CampoConsulta('Grupo', 'tds_grupo');
        $oFlu = new CampoConsulta('Descons.Fluxo', 'tds_desconsiderafluxo');
        $oOpe = new CampoConsulta('Desp.Oper.', 'tds_despesaoperacional');
        $oCla = new CampoConsulta('Classif.', 'tds_classificacao');
        $oVia = new CampoConsulta('Contr.Viagem', 'tds_controleviagem');
        $oDsc = new CampoConsulta('GrupoDescr.', 'tds_grupodescricao');
        $oDpd = new CampoConsulta('Tp.Desp.ValorDoc.Sup.', 'tds_tipodespesavaldocsup');
        $oDescricaofiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oDes, $oIna, $oCon, $oTip, $oGru, $oFlu, $oOpe, $oCla, $oVia, $oDsc, $oDpd);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Cód.', 'tds_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDes = new Campo('Descrição', 'tds_descricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oIna = new Campo('Inativa', 'tds_inativa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCon = new Campo('Conta Titulo', 'tds_contatitulo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTip = new Campo('Tipo', 'tds_tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oGru = new Campo('Grupo', 'tds_grupo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFlu = new Campo('Descons.Fluxo', 'tds_desconsiderafluxo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOpe = new Campo('Desp.Oper.', 'tds_despesaoperacional', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCla = new Campo('Classif.', 'tds_classificacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oVia = new Campo('Contr.Viagem', 'tds_controleviagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDsc = new Campo('GrupoDescr.', 'tds_grupodescricao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDpd = new Campo('Tp.Desp.ValorDoc.Sup.', 'tds_tipodespesavaldocsup', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $this->addCampos(array($oCod, $oDes, $oIna, $oCon, $oTip, $oGru), array($oFlu, $oOpe, $oCla, $oVia, $oDsc, $oDpd));
    }

}
