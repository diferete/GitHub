<?php
/**
 * Classe que implementa o Model do objeto Menu 
 */
class ModelMenu{
   private $Modulo;
   private $mencodigo;
   private $mendes;
   private $menordem;
   private $acao;
   
   function getAcao() {
       return $this->acao;
   }

   function setAcao($acao) {
       $this->acao = $acao;
   }

      
   function getModulo() {
       if(!isset($this->Modulo)){
           $this->Modulo = Fabrica::FabricarModel('Modulo');
       }
       return $this->Modulo;
   }

   function setModulo($Modulo) {
       $this->Modulo = $Modulo;
   }

   
   function getMencodigo() {
       return $this->mencodigo;
   }

   function getMendes() {
       return $this->mendes;
   }

   function getMenordem() {
       return $this->menordem;
   }

  

   function setMencodigo($mencodigo) {
       $this->mencodigo = $mencodigo;
   }

   function setMendes($mendes) {
       $this->mendes = $mendes;
   }

   function setMenordem($menordem) {
       $this->menordem = $menordem;
   }


}
?>