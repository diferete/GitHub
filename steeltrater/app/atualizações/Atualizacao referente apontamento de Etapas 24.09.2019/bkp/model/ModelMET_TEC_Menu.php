<?php
/**
 * Classe que implementa o Model do objeto Menu 
 */
class ModelMET_TEC_Menu{
   private $MET_TEC_Modulo;
   private $mencodigo;
   private $mendes;
   private $menordem;
   private $acao;
   
   function getMET_TEC_Modulo() {
       if(!isset($this->MET_TEC_Modulo)){
           $this->MET_TEC_Modulo = Fabrica::FabricarModel('MET_TEC_Modulo');
       }
       return $this->MET_TEC_Modulo;
   }

   function setMET_TEC_Modulo($MET_TEC_Modulo) {
       $this->MET_TEC_Modulo = $MET_TEC_Modulo;
   }

      
   function getAcao() {
       return $this->acao;
   }

   function setAcao($acao) {
       $this->acao = $acao;
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