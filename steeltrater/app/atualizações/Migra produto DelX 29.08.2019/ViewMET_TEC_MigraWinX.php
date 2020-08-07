<?php

/**
 * Implementa view da classe MET_TEC_MigraWinX
 * 
 * @author Alexandre W de Souza
 * @since 01/10/2018
 * ** */
class ViewMET_TEC_MigraWinX extends View {

    public function criaTela() {
        parent::criaTela();

        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);
        
        $this->setBTela(true);

        $oTab = new TabPanel();
      //  $oAbaProFam = new AbaTabPanel('Grupos/Família');
        //$oAbaProFam->setBActive(true);
        $this->addLayoutPadrao('Aba');

        $oBotaoGrupo = new Campo('Migra Grupo', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoGrupo = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProd","Grupo");';
        $oBotaoGrupo->getOBotao()->addAcao($sAcaoGrupo);

        $oBotaoSubGrupo = new Campo('Migra Sub Grupo', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoSubGrupo = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProd","SubGrupo");';
        $oBotaoSubGrupo->getOBotao()->addAcao($sAcaoSubGrupo);


        $oBotaoFamilia = new Campo('Migra Familia', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoFamilia = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProd","Familia");';
        $oBotaoFamilia->getOBotao()->addAcao($sAcaoFamilia);


        $oBotaoSubFam = new Campo('Migra Sub Família', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoSubFam = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProd","SubFamilia");';
        $oBotaoSubFam->getOBotao()->addAcao($sAcaoSubFam);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $oAbaProProd = new AbaTabPanel('Produtos');
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $oBotaoMigraProd = new Campo('Migra Produtos', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoProd = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProdGeral","pro_geral");';
        $oBotaoMigraProd->getOBotao()->addAcao($sAcaoProd);

        $oBotaoMigraFilial = new Campo('Migra Prod.Filial', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoFilial = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProdGeral","pro_filial");';
        $oBotaoMigraFilial->getOBotao()->addAcao($sAcaoFilial);
        //pro_filialCompleto
        $oBotaoMigraFilialCompleto = new Campo('Migra Prod.Filial Completo', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoFilialCompleto = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","migraProdGeral","pro_filialCompleto");';
        $oBotaoMigraFilialCompleto->getOBotao()->addAcao($sAcaoFilialCompleto);

        //$oAbaProFam->addCampos(/*$oBotaoGrupo, $oBotaoSubGrupo, $oBotaoFamilia, $oBotaoSubFam*/);
        
        $oAbaProProd->setBActive(true);
        
        $oAbaProProd->addCampos($oBotaoMigraProd, $oBotaoMigraFilial/*,$oBotaoMigraFilialCompleto*/);
        
        $oTab->addItems($oAbaProProd);

        $this->addCampos($oTab);
    }

}
