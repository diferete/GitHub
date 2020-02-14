<?php

/*
 * Classe que implementa os models da DELX_MOT_Motivo
 * 
 * @author Cleverton Hoffmann
 * @since 04/07/2018
 */

class ModelDELX_MOT_Motivo {

    private $mot_motivocodigo;
    private $mot_motivotipo;
    private $mot_motivodescricao;

    function getMot_motivocodigo() {
        return $this->mot_motivocodigo;
    }

    function getMot_motivotipo() {
        return $this->mot_motivotipo;
    }

    function getMot_motivodescricao() {
        return $this->mot_motivodescricao;
    }

    function setMot_motivocodigo($mot_motivocodigo) {
        $this->mot_motivocodigo = $mot_motivocodigo;
    }

    function setMot_motivotipo($mot_motivotipo) {
        $this->mot_motivotipo = $mot_motivotipo;
    }

    function setMot_motivodescricao($mot_motivodescricao) {
        $this->mot_motivodescricao = $mot_motivodescricao;
    }

}
