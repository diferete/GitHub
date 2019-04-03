<?php

class ModelMobModulos{
    
   private $mobmodcod;
   private $mobmoddesc;
   private $mobmodicon;
   private $mobmodrota;
   
   function getMobmodcod() {
       return $this->mobmodcod;
   }

   function getMobmoddesc() {
       return $this->mobmoddesc;
   }

   function getMobmodicon() {
       return $this->mobmodicon;
   }

   function getMobmodrota() {
       return $this->mobmodrota;
   }

   function setMobmodcod($mobmodcod) {
       $this->mobmodcod = $mobmodcod;
   }

   function setMobmoddesc($mobmoddesc) {
       $this->mobmoddesc = $mobmoddesc;
   }

   function setMobmodicon($mobmodicon) {
       $this->mobmodicon = $mobmodicon;
   }

   function setMobmodrota($mobmodrota) {
       $this->mobmodrota = $mobmodrota;
   }




}