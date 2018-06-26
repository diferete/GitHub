<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSt extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('St');
    }
 
 /**
  * Faz cáculo do st para os representantes
  */
 public function calculaSt($sSimples,$sNr,$sNomeClasse,$estcod){
     //retorna um array com os itens da solicitaçao
     $oClasse = Fabrica::FabricarPersistencia($sNomeClasse);
     $aItens = $oClasse ->itensCalcSt($sNr);
     
     $sSt = $this->Persistencia->ponticms($aItens,$sSimples,$sNr,$estcod);
     
     return $sSt;
     
 }
}