<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// ModelMET_QUAL_Prob_Rnc


class ModelMET_QUAL_Prob_Rnc {
    
   private $codprobl;
   private $descprobl;
   
   function getCodprobl() {
       return $this->codprobl;
   }

   function getDescprobl() {
       return $this->descprobl;
   }

   function setCodprobl($codprobl) {
       $this->codprobl = $codprobl;
   }

   function setDescprobl($descprobl) {
       $this->descprobl = $descprobl;
   }


}

