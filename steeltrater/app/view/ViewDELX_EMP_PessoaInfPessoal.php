<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 03/07/2018
 */

class ViewDELX_EMP_PessoaInfPessoal extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.', 'emp_codigo');
        $oSeq = new CampoConsulta('Seq.', 'emp_infpessoalseq');
        $oPai = new CampoConsulta('Nome Pai', 'emp_infpessoalnomepai');
        $oMae = new CampoConsulta('Nome mãe', 'emp_infpessoalnomemae');
        $oNas = new CampoConsulta('Local Nasc.', 'emp_infpessoallocalnasc');
        $oEsc = new CampoConsulta('Escolaridade', 'emp_infpessoalescolaridade');
        $oCiv = new CampoConsulta('Est.Civil', 'emp_infpessoalestadocivil');
        $oTra = new CampoConsulta('Emp.Trabalha', 'emp_infpessoalempresatrabalha');
        $oDatanasc = new CampoConsulta('Data Nascimento', 'emp_infpessoadatanascimento');

        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setILarguraGrid(3000);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);


        $this->setBScrollInf(false);

        $this->addCampos($oCod, $oSeq, $oPai, $oMae, $oNas, $oEsc, $oCiv, $oTra, $oDatanasc);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Cod.', 'emp_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSeq = new Campo('Seq.', 'emp_infpessoalseq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPai = new Campo('Nome Pai', 'emp_infpessoalnomepai', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMae = new Campo('Nome mãe', 'emp_infpessoalnomemae', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNas = new Campo('Local Nasc.', 'emp_infpessoallocalnasc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEsc = new Campo('Escolaridade', 'emp_infpessoalescolaridade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCiv = new Campo('Est.Civil', 'emp_infpessoalestadocivil', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTra = new Campo('Emp.Trabalha', 'emp_infpessoalempresatrabalha', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatanasc = new Campo('Data Nascimento', 'emp_infpessoadatanascimento', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCod, $oSeq, $oPai, $oMae, $oNas), array($oEsc, $oCiv, $oTra, $oDatanasc));
    }

}
