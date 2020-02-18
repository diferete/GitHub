<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_TEC_UsuTipo{
        private $usutipo;
        private $usutipdescricao;
        
        
        function getUsutipo() {
            return $this->usutipo;
        }

        function getUsutipdescricao() {
            return $this->usutipdescricao;
        }

        function setUsutipo($usutipo) {
            $this->usutipo = $usutipo;
        }

        function setUsutipdescricao($usutipdescricao) {
            $this->usutipdescricao = $usutipdescricao;
        }


}