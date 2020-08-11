<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class ViewDELX_FIN_Carteira extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Codigo.', 'fin_carteiracodigo');
        $oDes = new CampoConsulta('Des. Carteira', 'fin_carteiradescricao');
        //$oDescricaofiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5);
        

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        //$this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod,$oDes);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Codigo', 'fin_carteiracodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Des. Carteira', 'fin_carteiradescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        
        $this->addCampos(array($oCod,$oDes));
    }

}

