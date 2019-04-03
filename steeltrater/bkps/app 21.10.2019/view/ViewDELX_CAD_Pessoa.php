<?php

/*
 * Classe que implementa as views 
 * 
 * @author Avanei Martendal
 * @since 11/06/2018
 */

class ViewDELX_CAD_Pessoa extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCnpj = new CampoConsulta('CNPJ/CPF', 'emp_codigo');
        $oCnpjfiltro = new Filtro($oCnpj, Filtro::CAMPO_TEXTO_IGUAL, 3);
        $oRazao = new CampoConsulta('Razão Social', 'emp_razaosocial');
        $oRazaofiltro = new Filtro($oRazao, Filtro::CAMPO_TEXTO, 4);
        $oFantasia = new CampoConsulta('Fantasia', 'emp_fantasia');
        $oCadastrodata = new CampoConsulta('Cad.Data', 'emp_cadastrodata', CampoConsulta::TIPO_DATA);
        $oCadastrousuario = new CampoConsulta('Cad.Usuário', 'emp_cadastrousuario');

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCnpjfiltro,$oRazaofiltro);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oCnpj, $oRazao, $oFantasia, $oCadastrodata, $oCadastrousuario);
    }

    public function criaTela() {
        parent::criaTela();

        $oCnpj = new Campo('CNPJ/CPF', 'emp_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        $oRazao = new Campo('Razão', 'emp_razaosocial', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oRazao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oFantasia = new Campo('Fantasia', 'emp_fantasia', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oFantasia->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCadastrodata = new Campo('Cad.Data', 'emp_cadastrodata', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCadastrodata->setSCorFundo(Campo::FUNDO_VERDE);
        $oCadastrousuario = new Campo('Cad.Usuário', 'emp_cadastrousuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCadastrousuario->setSCorFundo(Campo::FUNDO_VERDE);

        $this->addCampos(array($oCnpj, $oRazao, $oFantasia), array($oCadastrodata, $oCadastrousuario));
    }

}
