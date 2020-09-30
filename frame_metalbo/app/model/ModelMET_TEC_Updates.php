<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_TEC_Updates {

    private $seq;
    private $sequpdates;
    private $versao;
    private $updates;
    private $codsetor;
    private $descsetor;
    private $todos;
    private $anexo;
    private $data_updates;
    private $hora_updates;

    function getSeq() {
        return $this->seq;
    }

    function getSequpdates() {
        return $this->sequpdates;
    }

    function getVersao() {
        return $this->versao;
    }

    function getUpdates() {
        return $this->updates;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getDescsetor() {
        return $this->descsetor;
    }

    function getTodos() {
        return $this->todos;
    }

    function getAnexo() {
        return $this->anexo;
    }

    function getData_updates() {
        return $this->data_updates;
    }

    function getHora_updates() {
        return $this->hora_updates;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setSequpdates($sequpdates) {
        $this->sequpdates = $sequpdates;
    }

    function setVersao($versao) {
        $this->versao = $versao;
    }

    function setUpdates($updates) {
        $this->updates = $updates;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }

    function setTodos($todos) {
        $this->todos = $todos;
    }

    function setAnexo($anexo) {
        $this->anexo = $anexo;
    }

    function setData_updates($data_updates) {
        $this->data_updates = $data_updates;
    }

    function setHora_updates($hora_updates) {
        $this->hora_updates = $hora_updates;
    }

}
