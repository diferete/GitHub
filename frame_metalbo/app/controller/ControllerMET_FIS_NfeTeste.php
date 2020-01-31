<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_FIS_NfeTeste extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_FIS_NfeTeste');
    }

    public function NFETeste() {
        require 'app/relatorio/NFETeste.php';
    }

}
