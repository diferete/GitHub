<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class ViewDELX_EMP_PessoaEndereco extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodi = new CampoConsulta('Cod.', 'emp_Codigo');
        $oEnds = new CampoConsulta('Seq.', 'emp_enderecoseq');
        $oPais = new CampoConsulta('PaisCod.', 'cid_paiscodigo');
        $oEndt = new CampoConsulta('Tipo', 'emp_enderecotipo');
        $oLogr = new CampoConsulta('Logradouro', 'emp_enderecologradouro');
        $oNume = new CampoConsulta('Número', 'emp_endereconumero');
        $oComp = new CampoConsulta('Complemento', 'emp_enderecocomplemento');
        $oBair = new CampoConsulta('Bairro', 'emp_enderecobairro');
        $oEndo = new CampoConsulta('Obs.', 'emp_enderecoobs');
        $oEmai = new CampoConsulta('Email', 'emp_enderecoemail');
        $oTele = new CampoConsulta('Tel.', 'emp_enderecotelefone');
        $oInsr = new CampoConsulta('Insc.Rural', 'emp_enderecoinscrural');
        $oInse = new CampoConsulta('Insc.Estadual', 'emp_enderecoinscestadual');
        $oCnpj = new CampoConsulta('CNPJ', 'emp_enderecocnpj');
        $oLcep = new CampoConsulta('Logradouro', 'cid_logradourocep');
        $oEndf = new CampoConsulta('Fax', 'emp_enderecofax');
        $oCidc = new CampoConsulta('Cod.Cidade', 'cid_codigo');
        $oEmis = new CampoConsulta('RG Data Emissao', 'emp_enderecorgdataemissao', CampoConsulta::TIPO_DATA);
        $oResi = new CampoConsulta('Reside Data', 'emp_enderecoresidedata', CampoConsulta::TIPO_DATA);

        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setILarguraGrid(3000);

        $oDescricaofiltro = new Filtro($oLogr, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);



        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);

        $this->addCampos($oCodi, $oEnds, $oPais, $oEndt, $oLogr, $oNume, $oComp, $oBair, $oEndo, $oEmai, $oTele, $oInsr, $oInse, $oCnpj, $oLcep, $oEndf, $oCidc, $oEmis, $oResi);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodi = new Campo('Cod.', 'emp_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEnds = new Campo('Seq.', 'emp_enderecoseq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPais = new Campo('PaisCod.', 'cid_paiscodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEndt = new Campo('Tipo', 'emp_enderecotipo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oLogr = new Campo('Logradouro', 'emp_enderecologradouro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNume = new Campo('Número', 'emp_endereconumero', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oComp = new Campo('Complemento', 'emp_enderecocomplemento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oBair = new Campo('Bairro', 'emp_enderecobairro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEndo = new Campo('Obs.', 'emp_enderecoobs', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmai = new Campo('Email', 'emp_enderecoemail', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTele = new Campo('Tel.', 'emp_enderecotelefone', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oInsr = new Campo('Insc.Rural', 'emp_enderecoinscrural', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oInse = new Campo('Insc.Estadual', 'emp_enderecoinscestadual', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCnpj = new Campo('CNPJ', 'emp_enderecocnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oLcep = new Campo('Logradouro', 'cid_logradourocep', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEndf = new Campo('Fax', 'emp_enderecofax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCidc = new Campo('Cod.Cidade', 'cid_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmis = new Campo('RG Data Emissao', 'emp_enderecorgdataemissao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oResi = new Campo('Reside Data', 'emp_enderecoresidedata', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCodi, $oEnds, $oPais, $oEndt, $oLogr), array($oNume, $oComp, $oBair, $oEndo, $oEmai), array($oTele, $oInsr, $oInse, $oCnpj, $oLcep), array($oEndf, $oCidc, $oEmis, $oResi));
    }

}
