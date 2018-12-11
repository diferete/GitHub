<?php

/*
 * Classe que implementa os models 
 * 
 * @author Cleverton Hoffmann
 * @since 04/12/2018
 */

class ModelMET_TEC_Sequencia {

   private $tec_sequenciatabela;
   private $tec_sequenciafilial;
   private $tec_sequencianumero;
    
   function getTec_sequenciatabela() {
       return $this->tec_sequenciatabela;
   }

   function getTec_sequenciafilial() {
       return $this->tec_sequenciafilial;
   }

   function getTec_sequencianumero() {
       return $this->tec_sequencianumero;
   }

   function setTec_sequenciatabela($tec_sequenciatabela) {
       $this->tec_sequenciatabela = $tec_sequenciatabela;
   }

   function setTec_sequenciafilial($tec_sequenciafilial) {
       $this->tec_sequenciafilial = $tec_sequenciafilial;
   }

   function setTec_sequencianumero($tec_sequencianumero) {
       $this->tec_sequencianumero = $tec_sequencianumero;
   }
}