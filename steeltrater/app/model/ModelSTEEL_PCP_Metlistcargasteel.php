<?php

/*
 * * Implementa classe model
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class ModelSTEEL_PCP_Metlistcargasteel {

    private $dataCarga;
    private $nrCarga;
    private $sit;
    private $usuario;
    private $data;
    private $hora;

    function getDataCarga() {
        return $this->dataCarga;
    }

    function setDataCarga($dataCarga) {
        $this->dataCarga = $dataCarga;
    }

    public function getNrCarga() {
        return $this->nrCarga;
    }

    public function getSit() {
        return $this->sit;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getData() {
        return $this->data;
    }

    public function getHora() {
        return $this->hora;
    }

    public function setNrCarga($nrCarga) {
        $this->nrCarga = $nrCarga;
    }

    public function setSit($sit) {
        $this->sit = $sit;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

}
