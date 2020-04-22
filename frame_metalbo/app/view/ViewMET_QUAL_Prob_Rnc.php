<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_QUAL_Prob_Rnc extends View {
      public function __construct() {
        parent::__construct();
        $this->setTitulo(' PROBLEMA RNC');
    }
    
     public function criaTela() {
        parent::criaTela();
        
         $oCodProbl = new Campo('Cód.Prod.', 'codprobl', Campo::TIPO_TEXTO, true);
         $oCodProbl->setBCampoBloqueado(true);
        $oProdDes = new campo('Desc.Prod', 'descprobl', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        
         $this->addCampos( $oCodProbl,  $oProdDes);
        
     }
    
         public function criaConsulta() {
           parent::criaConsulta();
           
             $oCodprobl = new CampoConsulta('Código', 'codprobl');
             $oDescprobl = new CampoConsulta('Problema','descprobl');
             
             $this->addCampos($oCodprobl,$oDescprobl);
             
             $oFdescprobl = new Filtro($oDescprobl, Filtro::CAMPO_TEXTO,6,6,6,6);
             $this->addFiltro($oFdescprobl);
         }
     
    
}



