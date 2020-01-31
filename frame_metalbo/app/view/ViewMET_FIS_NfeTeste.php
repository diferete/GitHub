<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_FIS_NfeTeste extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaDropdown(true);

        $oTeste = new Dropdown('Teste', Dropdown::TIPO_DARK);
        $oTeste->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Teste', $this->getController(), 'NFETeste', '', false, '', false, '', false, true);

        $this->addDropdown($oTeste);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
