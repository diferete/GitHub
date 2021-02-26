<?php

/* 
 * Classe que implementa a alteração da receita zincagem na ordens fabricação
 * @author Cleverton Hoffmann
 * @since 25/02/2021
 */

class ModelSTEEL_PCP_OFReceitaZinc {
    
    private $op;
    private $receita_zinc;
    private $receita_zincdesc;
    private $processozinc;
    private $situacao;
    
    function getSituacao() {
        return $this->situacao;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }
    
    function getProcessozinc() {
        return $this->processozinc;
    }

    function setProcessozinc($processozinc) {
        $this->processozinc = $processozinc;
    }
    
    function getOp() {
        return $this->op;
    }

    function getReceita_zinc() {
        return $this->receita_zinc;
    }

    function getReceita_zincdesc() {
        return $this->receita_zincdesc;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setReceita_zinc($receita_zinc) {
        $this->receita_zinc = $receita_zinc;
    }

    function setReceita_zincdesc($receita_zincdesc) {
        $this->receita_zincdesc = $receita_zincdesc;
    }

}

