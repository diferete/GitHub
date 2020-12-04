<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class ViewDELX_PRO_UnidadeMedida extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oMedida = new CampoConsulta('Un.Medida', 'pro_unidademedida');
        $oDes = new CampoConsulta('Descrição', 'pro_unidademedidadescricao');
        $oDarf = new CampoConsulta('Un.Md.Darf.', 'pro_unidademedidarf');
        $oMerc = new CampoConsulta('Un.Md.Mercosul', 'pro_unidademedidamercosul');
        $oCalc = new CampoConsulta('Un.Md.Calc.', 'pro_unidademedidatipocalc');
        $oCasasd = new CampoConsulta('Un.Md.CasasDec.', 'pro_unidademedidacasasdec');
        
        $oDesFiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5);
        
        $this->addFiltro($oDesFiltro);
        

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(false);
        $this->addCampos($oMedida,$oDes,$oDarf,$oMerc,$oCalc,$oCasasd);
    }

    public function criaTela() {
        parent::criaTela();


        $oMedida = new Campo('Un.Medida', 'pro_unidademedida', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Descrição', 'pro_unidademedidadescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDarf = new Campo('Un.Md.Darf.', 'pro_unidademedidarf', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMerc = new Campo('Un.Md.Mercosul', 'pro_unidademedidamercosul', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCalc = new Campo('Un.Md.Calc.', 'pro_unidademedidatipocalc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCasasd = new Campo('Un.Md.CasasDec.', 'pro_unidademedidacasasdec', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        
        $this->addCampos(array($oMedida,$oDes,$oDarf,$oMerc,$oCalc,$oCasasd));
    }

}
