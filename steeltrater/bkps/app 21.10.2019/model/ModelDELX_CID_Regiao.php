<?php

/*
 * Classe que implementa os models da DELX_CID_Regiao
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ModelDELX_CID_Regiao {

    private $cid_regiaocodigo;
    private $cid_regiaodescricao;
    private $cid_regiaotipo;
    private $cid_regiaodataultimofaturament;
    private $cid_regiaonumerodiasfaturament;
    private $cid_regiaodiasfinanceiro;
    private $cid_regiaodiasentrega;

    function getCid_regiaocodigo() {
        return $this->cid_regiaocodigo;
    }

    function getCid_regiaodescricao() {
        return $this->cid_regiaodescricao;
    }

    function getCid_regiaotipo() {
        return $this->cid_regiaotipo;
    }

    function getCid_regiaodataultimofaturament() {
        return $this->cid_regiaodataultimofaturament;
    }

    function getCid_regiaonumerodiasfaturament() {
        return $this->cid_regiaonumerodiasfaturament;
    }

    function getCid_regiaodiasfinanceiro() {
        return $this->cid_regiaodiasfinanceiro;
    }

    function getCid_regiaodiasentrega() {
        return $this->cid_regiaodiasentrega;
    }

    function setCid_regiaocodigo($cid_regiaocodigo) {
        $this->cid_regiaocodigo = $cid_regiaocodigo;
    }

    function setCid_regiaodescricao($cid_regiaodescricao) {
        $this->cid_regiaodescricao = $cid_regiaodescricao;
    }

    function setCid_regiaotipo($cid_regiaotipo) {
        $this->cid_regiaotipo = $cid_regiaotipo;
    }

    function setCid_regiaodataultimofaturament($cid_regiaodataultimofaturament) {
        $this->cid_regiaodataultimofaturament = $cid_regiaodataultimofaturament;
    }

    function setCid_regiaonumerodiasfaturament($cid_regiaonumerodiasfaturament) {
        $this->cid_regiaonumerodiasfaturament = $cid_regiaonumerodiasfaturament;
    }

    function setCid_regiaodiasfinanceiro($cid_regiaodiasfinanceiro) {
        $this->cid_regiaodiasfinanceiro = $cid_regiaodiasfinanceiro;
    }

    function setCid_regiaodiasentrega($cid_regiaodiasentrega) {
        $this->cid_regiaodiasentrega = $cid_regiaodiasentrega;
    }

}
