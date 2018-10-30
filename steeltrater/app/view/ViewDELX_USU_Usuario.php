<?php

/*
 * Implementa view da classe DELX_USU_Usuario
 * @author Alexandre W. de Souza
 * @since 18-10-2018
 * *** */

class ViewDELX_USU_Usuario extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);


        $oEmpCod = new CampoConsulta('EmpCod.', 'usu_empcodigo');
        $oUsuCod = new CampoConsulta('CodNome', 'usu_codigo');
        $oUsuNome = new CampoConsulta('Nome', 'usu_nome');
        $oUsuStatus = new CampoConsulta('Status', 'usu_status');
        $oUsuLogaSistema = new CampoConsulta('Loga Sis.', 'usu_logasistema');

        $oEmpCodFil = new Filtro($oEmpCod, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        $oUsuCodFil = new Filtro($oUsuNome, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);



        $this->addFiltro($oEmpCodFil, $oUsuCodFil);
        $this->addCampos($oEmpCod, $oUsuCod, $oUsuNome, $oUsuStatus, $oUsuLogaSistema);
    }

    public function criaTela() {
        parent::criaTela();

        $oEmpCod = new Campo('EmpCod.', 'usu_empcodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuCod = new Campo('CodNome', 'usu_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuNome = new Campo('Nome', 'usu_nome', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oUsuStatus = new Campo('Status', 'usu_status', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuLogaSistema = new Campo('Loga Sis.', 'usu_logasistema', Campo::TIPO_TEXTO, 2, 2, 12, 12);


        $this->addCampos(array($oEmpCod), array($oUsuCod, $oUsuNome), array($oUsuStatus, $oUsuLogaSistema));
    }

}
