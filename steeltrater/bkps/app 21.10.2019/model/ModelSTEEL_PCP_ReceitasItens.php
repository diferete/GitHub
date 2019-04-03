<?php

/* 
 Classe que implementa a model da receitaitens
 * 
 * @author Avanei Martendal
 * @since 15/06/2018
 */

class ModelSTEEL_PCP_ReceitasItens {
    private $cod;
    private $seq;
    private $STEEL_PCP_Tratamentos;
    private $camada_min;
    private $camada_max;
    private $temperatura;
    private $tempo;
    private $resfriamento;
    
    function getSTEEL_PCP_Tratamentos() {
        if(!isset($this->STEEL_PCP_Tratamentos)){
            $this->STEEL_PCP_Tratamentos = Fabrica::FabricarModel('STEEL_PCP_Tratamentos');
        }
        return $this->STEEL_PCP_Tratamentos;
    }

    function setSTEEL_PCP_Tratamentos($STEEL_PCP_Tratamentos) {
        $this->STEEL_PCP_Tratamentos = $STEEL_PCP_Tratamentos;
    }

    
  
        
    function getResfriamento() {
        return $this->resfriamento;
    }

    function setResfriamento($resfriamento) {
        $this->resfriamento = $resfriamento;
    }

        
    function getTempo() {
        return $this->tempo;
    }

    function setTempo($tempo) {
        $this->tempo = $tempo;
    }

        
    function getTemperatura() {
        return $this->temperatura;
    }

    function setTemperatura($temperatura) {
        $this->temperatura = $temperatura;
    }

        
    function getCamada_min() {
        return $this->camada_min;
    }

    function getCamada_max() {
        return $this->camada_max;
    }

    function setCamada_min($camada_min) {
        $this->camada_min = $camada_min;
    }

    function setCamada_max($camada_max) {
        $this->camada_max = $camada_max;
    }

        
    function getCod() {
        return $this->cod;
    }

    function getSeq() {
        return $this->seq;
    }


    function setCod($cod) {
        $this->cod = $cod;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

   


    
}