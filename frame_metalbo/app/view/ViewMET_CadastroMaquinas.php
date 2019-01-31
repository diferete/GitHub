<?php

/* 
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 22/08/2018
 */

class ViewMET_CadastroMaquinas extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod', 'tipcod');
        $oDes = new CampoConsulta('Tipo Maquina', 'tipdes');
        $oDesFiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO,3);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDesFiltro);
        
        $this->setBScrollInf(TRUE);
        $this->addCampos($oCod, $oDes);
    }

    public function criaTela() {
        parent::criaTela();
        
        $oCod = new Campo('Cod', 'tipcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDes = new Campo('Tipo Maquina', 'tipdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        
        $this->addCampos(array($oCod,$oDes));
       }

}
