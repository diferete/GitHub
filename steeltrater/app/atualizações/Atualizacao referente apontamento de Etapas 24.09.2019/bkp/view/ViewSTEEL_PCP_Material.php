<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 03/09/2018
 */

class ViewSTEEL_PCP_Material extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código','matcod');
        $oCod->setILargura(30);
        $oDes = new CampoConsulta('Material','matdes');

        
        $oFilDes = new Filtro($oDes, Filtro::CAMPO_TEXTO, 2);
        $this->addFiltro($oFilDes);
        
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oCod,$oDes);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Código', 'matcod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Material', 'matdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        
        

        $this->addCampos(array($oCod,$oDes));
    }

}