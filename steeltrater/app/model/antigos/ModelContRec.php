<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelContRec {
   private $empcnpj;
   private $Pessoa;
   private $recdocto;
   private $recvlrtot;
   private $recdtemiss;
   private $recusuario;
   private $rechoraemi;
   private $condcod;
   
   function getCondcod() {
       return $this->condcod;
   }

   function setCondcod($condcod) {
       $this->condcod = $condcod;
   }

      
   function getRecdtemiss() {
       return $this->recdtemiss;
   }

   function getRecusuario() {
       return $this->recusuario;
   }

   function getRechoraemi() {
       return $this->rechoraemi;
   }

   function setRecdtemiss($recdtemiss) {
       $this->recdtemiss = $recdtemiss;
   }

   function setRecusuario($recusuario) {
       $this->recusuario = $recusuario;
   }

   function setRechoraemi($rechoraemi) {
       $this->rechoraemi = $rechoraemi;
   }

      
  function getPessoa() {
        if(!isset($this->Pessoa)){
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        
        return $this->Pessoa;
    }

   function setPessoa($Pessoa) {
       $this->Pessoa = $Pessoa;
   }

      
   function getEmpcnpj() {
       return $this->empcnpj;
   }

 

   function getRecdocto() {
       return $this->recdocto;
   }

   function getRecvlrtot() {
       return $this->recvlrtot;
   }

   function setEmpcnpj($empcnpj) {
       $this->empcnpj = $empcnpj;
   }


   function setRecdocto($recdocto) {
       $this->recdocto = $recdocto;
   }

   function setRecvlrtot($recvlrtot) {
       $this->recvlrtot = $recvlrtot;
   }


    
    
}