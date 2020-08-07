<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerPedRep extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('PedRep');
    }
    
   public function mostraTelaSaldo($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'RelSaldoRep');
    }  
}