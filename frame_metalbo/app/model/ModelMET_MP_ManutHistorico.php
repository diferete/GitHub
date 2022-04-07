<?php

/*
 * * Implementa classe persistencia
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class ModelMET_MP_ManutHistorico {

    //put your code here

    private $MET_MP_Maquinas;
    private $id;
    private $usersistcod;
    private $usersistdes;
    private $codmaquina;
    private $horasmaq;
    private $horasmaqant;
    private $obs;
    private $datahora;

    function getMET_MP_Maquinas() {
        if (!isset($this->MET_MP_Maquinas)) {
            $this->MET_MP_Maquinas = Fabrica::FabricarModel('MET_MP_Maquinas');
        }
        return $this->MET_MP_Maquinas;
    }

    function setMET_MP_Maquinas($MET_MP_Maquinas) {
        $this->MET_MP_Maquinas = $MET_MP_Maquinas;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsersistcod() {
        return $this->usersistcod;
    }

    public function getUsersistdes() {
        return $this->usersistdes;
    }

    public function getCodmaquina() {
        return $this->codmaquina;
    }

    public function getHorasmaq() {
        return $this->horasmaq;
    }

    public function getHorasmaqant() {
        return $this->horasmaqant;
    }

    public function getObs() {
        return $this->obs;
    }

    public function getDatahora() {
        return $this->datahora;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsersistcod($usersistcod) {
        $this->usersistcod = $usersistcod;
    }

    public function setUsersistdes($usersistdes) {
        $this->usersistdes = $usersistdes;
    }

    public function setCodmaquina($codmaquina) {
        $this->codmaquina = $codmaquina;
    }

    public function setHorasmaq($horasmaq) {
        $this->horasmaq = $horasmaq;
    }

    public function setHorasmaqant($horasmaqant) {
        $this->horasmaqant = $horasmaqant;
    }

    public function setObs($obs) {
        $this->obs = $obs;
    }

    public function setDatahora($datahora) {
        $this->datahora = $datahora;
    }

}
