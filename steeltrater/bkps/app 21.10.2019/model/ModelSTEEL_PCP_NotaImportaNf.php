<?php

/* 
 * Classe que implementa o model da importação
 * 
 * @author Avanei Martendal 
 * 
 * @since 02/07/2018
 */

class ModelSTEEL_PCP_NotaImportaNf {
      private $nfsnfnro;
      private $nfsnfser;       
      private $nfsitseq;        
      private $nfsitcod;        
      private $nfsitdes;
      private $nfsitun;        
      private $nfsitqtd;        
      private $nfsclicgc;
      private $empdes;        
      private $nfsdtemiss;
      private $peso;
      
      private $RoeNro;
      private $metof;
      private $metpesocarg;
      private $metmat;
      private $RoeObs;
      private $opSteel;
      
      function getOpSteel() {
          return $this->opSteel;
      }

      function setOpSteel($opSteel) {
          $this->opSteel = $opSteel;
      }

            
      
      function getRoeObs() {
          return $this->RoeObs;
      }

      function setRoeObs($RoeObs) {
          $this->RoeObs = $RoeObs;
      }

            
      function getRoeNro() {
          return $this->RoeNro;
      }

      function getMetof() {
          return $this->metof;
      }

      function getMetpesocarg() {
          return $this->metpesocarg;
      }

      function getMetmat() {
          return $this->metmat;
      }

      function setRoeNro($RoeNro) {
          $this->RoeNro = $RoeNro;
      }

      function setMetof($metof) {
          $this->metof = $metof;
      }

      function setMetpesocarg($metpesocarg) {
          $this->metpesocarg = $metpesocarg;
      }

      function setMetmat($metmat) {
          $this->metmat = $metmat;
      }

            
      function getPeso() {
          return $this->peso;
      }

      function setPeso($peso) {
          $this->peso = $peso;
      }

            
      function getNfsnfnro() {
          return $this->nfsnfnro;
      }

      function getNfsnfser() {
          return $this->nfsnfser;
      }

      function getNfsitseq() {
          return $this->nfsitseq;
      }

      function getNfsitcod() {
          return $this->nfsitcod;
      }

      function getNfsitdes() {
          return $this->nfsitdes;
      }

      function getNfsitun() {
          return $this->nfsitun;
      }

      function getNfsitqtd() {
          return $this->nfsitqtd;
      }

      function getNfsclicgc() {
          return $this->nfsclicgc;
      }

      function getEmpdes() {
          return $this->empdes;
      }

      function getNfsdtemiss() {
          return $this->nfsdtemiss;
      }

      function setNfsnfnro($nfsnfnro) {
          $this->nfsnfnro = $nfsnfnro;
      }

      function setNfsnfser($nfsnfser) {
          $this->nfsnfser = $nfsnfser;
      }

      function setNfsitseq($nfsitseq) {
          $this->nfsitseq = $nfsitseq;
      }

      function setNfsitcod($nfsitcod) {
          $this->nfsitcod = $nfsitcod;
      }

      function setNfsitdes($nfsitdes) {
          $this->nfsitdes = $nfsitdes;
      }

      function setNfsitun($nfsitun) {
          $this->nfsitun = $nfsitun;
      }

      function setNfsitqtd($nfsitqtd) {
          $this->nfsitqtd = $nfsitqtd;
      }

      function setNfsclicgc($nfsclicgc) {
          $this->nfsclicgc = $nfsclicgc;
      }

      function setEmpdes($empdes) {
          $this->empdes = $empdes;
      }

      function setNfsdtemiss($nfsdtemiss) {
          $this->nfsdtemiss = $nfsdtemiss;
      }

                    
              
   
}
