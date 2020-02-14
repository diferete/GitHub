<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerRepItenVenda extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('RepItenVenda');
    }
    
    
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        $this->Persistencia->limpaFiltro();
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        if($aCampos['cnpj']!= ''){
        $sProcod = '';
        $sProcod = " and cnpj ='".$aCampos['cnpj']."'";
        }
        $sTabelaIten = $_SESSION['officecabsoliten'];
        $this->Persistencia->setSWhereManual(" where ".$this->Persistencia->getTabela().".NR = ".$sTabelaIten.".NR 
                 ".$sProcod." and EMAIL = 'EV' and codigo=".$aCampos['codigo']."
                  order by ".$this->Persistencia->getTabela().".DATA desc");
       
        
        
    }
}
