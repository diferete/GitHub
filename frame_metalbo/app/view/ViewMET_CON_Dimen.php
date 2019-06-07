<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_CON_Dimen extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBTela(true);
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);

        $oProcod = new campo('Código', 'procod', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oProcod->setApenasTela(true);

        $oProdes = new campo('Descrição', 'prodes', Campo::TIPO_BUSCADOBANCO, 7, 7, 12, 12);
        $oProdes->setSIdPk($oProcod->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '', '');
        $oProdes->addCampoBusca('prodes', '', '');
        $oProcod->setSIdTela($this->getTela()->getid());
        $oProdes->setApenasTela(true);

        $oProcod->setClasseBusca('Produto');
        $oProcod->setSCampoRetorno('procod', $this->getTela()->getid());
        $oProcod->addCampoBusca('prodes', $oProdes->getId(), $this->getTela()->getid());

        $oAngHelice = new campo('Âng. Helice', 'anghelice', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oAngHelice->setApenasTela(true);

        $oAcab = new Campo('Acab.', 'acab', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oAcab->setApenasTela(true);

        $oMaterial = new campo('Material', 'material', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMaterial->setApenasTela(true);

        $oClasse = new campo('Classe', 'classe', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oClasse->setApenasTela(true);

        $oChaveMin = new campo('Chave Mín.', 'chavemin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oChaveMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oChaveMin->setSValor('0');
        $oChaveMin->setApenasTela(true);


        $oChaveMax = new campo('Chave Max.', 'chavemax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oChaveMax->setSValor('0');
        $oChaveMax->setSCorFundo(Campo::FUNDO_AMARELO);
        $oChaveMax->setApenasTela(true);

        $oAltMin = new Campo('Alt. Mín', 'altmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oAltMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAltMin->setSValor('0');
        $oAltMin->setApenasTela(true);

        $oAltMax = new Campo('Alt. Máx', 'altmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oAltMax->setSValor('0');
        $oAltMax->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAltMax->setApenasTela(true);

        $oDiamFmin = new campo('Diâm. Furo Mín', 'diamfmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamFmin->setSValor('0');
        $oDiamFmin->setApenasTela(true);

        $oDiamFmax = new campo('Diâm. Furo Máx', 'diamfmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamFmax->setSValor('0');
        $oDiamFmax->setApenasTela(true);

        $oCompMin = new campo('Comp. Mín', 'compmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oCompMin->setSValor('0');
        $oCompMin->setApenasTela(true);

        $oCompMax = new campo('Comp .Máx', 'compmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oCompMax->setSValor('0');
        $oCompMax->setApenasTela(true);

        $oDiamPriMin = new Campo('Diâm. Prim. Mín', 'diampmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamPriMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamPriMin->setSValor('0');
        $oDiamPriMin->setApenasTela(true);

        $oDiamPriMax = new Campo('Diâm. Prim. Máx', 'diampmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamPriMax->setSValor('0');
        $oDiamPriMax->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamPriMax->setApenasTela(true);

        $oDiamExtMin = new campo('Diâm. Ext. Mín', 'diamexmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamExtMin->setSValor('0');
        $oDiamExtMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamExtMin->setApenasTela(true);

        $oDiamExtMax = new campo('Diâm. Ext. Máx', 'diamexmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamExtMax->setSValor('0');
        $oDiamExtMax->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamExtMax->setApenasTela(true);

        $oCompRMin = new campo('Com. Rosc. Mín', 'comprmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oCompRMin->setSValor('0');
        $oCompRMin->setApenasTela(true);

        $oCompRMax = new campo('Com. Rosc. Máx', 'comprmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oCompRMax->setSValor('0');
        $oCompRMax->setApenasTela(true);

        $oCompHasteMin = new Campo('Com. Hast. Mín', 'comphmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oCompHasteMin->setSValor('0');
        $oCompHasteMin->setApenasTela(true);

        $oCompHasteMax = new Campo('Com. Hast. Máx', 'comphmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oCompHasteMax->setSValor('0');
        $oCompHasteMax->setApenasTela(true);

        $oDiamHasteMin = new campo('Diâm. Haste. Mín', 'diamhmin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamHasteMin->setSValor('0');
        $oDiamHasteMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamHasteMin->setApenasTela(true);

        $oDiamHasteMax = new campo('Diâm. Haste. Máx', 'diamhmax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oDiamHasteMax->setSValor('0');
        $oDiamHasteMax->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDiamHasteMax->setApenasTela(true);

        $oProfCanecoMin = new Campo('Prof.Caneco Min.', 'profcanecomin', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oProfCanecoMin->setSValor('0');
        $oProfCanecoMin->setSCorFundo(Campo::FUNDO_AMARELO);
        $oProfCanecoMin->setApenasTela(true);

        $oProfCanecoMax = new Campo('Prof.Caneco Max.', 'profcanecomax', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oProfCanecoMax->setSValor('0');
        $oProfCanecoMax->setSCorFundo(Campo::FUNDO_AMARELO);
        $oProfCanecoMax->setApenasTela(true);



        //executa esta funcao ao sair dos campos
        $sAcaoExit = 'dimenProd($("#' . $oProcod->getId() . '").val(),'
                . '"' . $oChaveMin->getId() . '","' . $oChaveMax->getId() . '","' . $oAltMin->getId() . '","' . $oAltMax->getId() . '","' . $oDiamFmin->getId() . '",'
                . '"' . $oDiamFmax->getId() . '","' . $oCompMin->getId() . '","' . $oCompMax->getId() . '","' . $oDiamPriMin->getId() . '",' . '"' . $oDiamPriMax->getId() . '",'
                . '"' . $oDiamExtMin->getId() . '","' . $oDiamExtMax->getId() . '","' . $oCompRMin->getId() . '","' . $oCompRMax->getId() . '","' . $oCompHasteMin->getId() . '",'
                . '"' . $oCompHasteMax->getId() . '","' . $oDiamHasteMin->getId() . '","' . $oDiamHasteMax->getId() . '","' . $oProfCanecoMin->getId() . '","' . $oProfCanecoMax->getId() . '",'
                . '"' . $oAngHelice->getId() . '","' . $oAcab->getId() . '","' . $oMaterial->getId() . '","' . $oClasse->getId() . '","' . $this->getController() . '");';

        $oProcod->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);


        $this->addCampos(array($oProcod, $oProdes), array($oAcab, $oMaterial, $oClasse, $oAngHelice), array($oChaveMin, $oChaveMax, $oAltMin, $oAltMax), array($oDiamFmin, $oDiamFmax, $oCompMin, $oCompMax), array($oDiamPriMin, $oDiamPriMax, $oDiamExtMin, $oDiamExtMax), array($oCompHasteMin, $oCompHasteMax, $oCompRMin, $oCompRMax), array($oDiamHasteMin, $oDiamHasteMax, $oProfCanecoMin, $oProfCanecoMax));
    }

}
