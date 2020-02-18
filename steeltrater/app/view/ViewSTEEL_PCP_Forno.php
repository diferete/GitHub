<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 05/07/2018
 */

class ViewSTEEL_PCP_Forno extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código', 'fornocod');
        $oCod->setILargura(50);
        $oDes = new CampoConsulta('Descrição', 'fornodes');
        $oDes->setILargura(400);
        $oSig = new CampoConsulta('Sigla', 'fornosigla');
        $oTipOrdem = new CampoConsulta('Tipo OP', 'tipoOrdem');

        $oFilForno = new Filtro($oDes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $this->addFiltro($oFilForno);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oCod, $oDes, $oSig, $oTipOrdem);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Codigo', 'fornocod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Descrição', 'fornodes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSig = new Campo('Sigla', 'fornosigla', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oTipo = new Campo('Tipo OP', 'tipoOrdem', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oTipo->addItemSelect('P', 'Padrão - Tempera');
        $oTipo->addItemSelect('F', 'Fio Máquina - Industrialização');
        $oTipo->addItemSelect('A', 'Arame - Venda');
        $oLabel1 = new campo('', 'label', Campo::TIPO_LINHA, 12);
        $oLabel1->setApenasTela(true);
        $oCookieCod = new campo('Codigo forno {Para gravação local}', 'cookfornocod', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oCookieCod->setApenasTela(true);
        if (isset($_COOKIE['cookfornocod'])) {
            $oCookieCod->setSValor($_COOKIE['cookfornocod']);
        }

        $oCookieDes = new campo('Descrição forno{Para gravação local}', 'cookfornodes', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oCookieDes->setApenasTela(true);
        if (isset($_COOKIE['cookfornodes'])) {
            $oCookieDes->setSValor($_COOKIE['cookfornodes']);
        }

        $this->addCampos(array($oCod, $oDes, $oSig), $oTipo, $oLabel1, $oCookieCod, $oCookieDes);
    }

}
