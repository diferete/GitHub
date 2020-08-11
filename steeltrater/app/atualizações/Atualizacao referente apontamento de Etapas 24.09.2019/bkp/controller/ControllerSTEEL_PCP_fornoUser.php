<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_fornoUser extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_fornoUser');
    }
    
    public function pesqFornoUser(){
        $this->Persistencia->adicionaFiltro('usercod',$_SESSION['codUser']);
        $oDados = $this->Persistencia->consultarWhere();
        return $oDados;
    }
}
