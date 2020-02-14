<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class ViewDELX_EMP_PessoaContato extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.', 'emp_codigo');
        $oSeq = new CampoConsulta('Seq.', 'emp_contatoseq');
        $oTipo = new CampoConsulta('Tipo', 'emp_contatotipo');
        $oNome = new CampoConsulta('Nome', 'emp_contatonome');
        $oCargo = new CampoConsulta('Cargo', 'emp_contatocargo');
        $oTele = new CampoConsulta('Telefone', 'emp_contatotelefone');
        $oFax = new CampoConsulta('Fax', 'emp_contatofax');
        $oCel = new CampoConsulta('Celular', 'emp_contatocelular');
        $oEmail = new CampoConsulta('Email', 'emp_contatoemail');
        $oNasc = new CampoConsulta('Nascimento', 'emp_contatodatanascimento');
        $oDescricaofiltro = new Filtro($oNome, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oSeq, $oTipo, $oNome, $oCargo, $oTele, $oFax, $oCel, $oEmail, $oNasc);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Cod.', 'emp_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSeq = new Campo('Seq.', 'emp_contatoseq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTipo = new Campo('Tipo', 'emp_contatotipo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNome = new Campo('Nome', 'emp_contatonome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCargo = new Campo('Cargo', 'emp_contatocargo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTele = new Campo('Telefone', 'emp_contatotelefone', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFax = new Campo('Fax', 'emp_contatofax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCel = new Campo('Celular', 'emp_contatocelular', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmail = new Campo('Email', 'emp_contatoemail', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNasc = new Campo('Nascimento', 'emp_contatodatanascimento', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCod, $oSeq, $oTipo, $oNome, $oCargo), array($oTele, $oFax, $oCel, $oEmail, $oNasc));
    }

}
