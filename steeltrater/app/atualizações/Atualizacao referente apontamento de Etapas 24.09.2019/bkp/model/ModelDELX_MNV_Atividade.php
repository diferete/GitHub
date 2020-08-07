<?php

/*
 * Classe que implementa os models da DELX_CID_Cidade
 * 
 * @author Cleverton Hoffmann
 * @since 29/06/2018
 */

class ModelDELX_MNV_Atividade {

    private $mnv_atividadecodigo;
    private $mnv_atividadedescricao;
    private $mnv_atividadeprodutocodigo;
    private $eng_atividadeobservacao;
    private $eng_atividadeterceiro;
    private $eng_atividadeparada;
    private $eng_atividaderecursocodigo;
    private $mnt_atividadetempo;
    private $mnt_atividadeprioridade;
    private $mnt_atividadeobservacao;
    private $mnt_atividadetipomanutencao;
    private $mnt_atividadearea;
    private $eng_atividadeinativa;

    function getMnv_atividadecodigo() {
        return $this->mnv_atividadecodigo;
    }

    function getMnv_atividadedescricao() {
        return $this->mnv_atividadedescricao;
    }

    function getMnv_atividadeprodutocodigo() {
        return $this->mnv_atividadeprodutocodigo;
    }

    function getEng_atividadeobservacao() {
        return $this->eng_atividadeobservacao;
    }

    function getEng_atividadeterceiro() {
        return $this->eng_atividadeterceiro;
    }

    function getEng_atividadeparada() {
        return $this->eng_atividadeparada;
    }

    function getEng_atividaderecursocodigo() {
        return $this->eng_atividaderecursocodigo;
    }

    function getMnt_atividadetempo() {
        return $this->mnt_atividadetempo;
    }

    function getMnt_atividadeprioridade() {
        return $this->mnt_atividadeprioridade;
    }

    function getMnt_atividadeobservacao() {
        return $this->mnt_atividadeobservacao;
    }

    function getMnt_atividadetipomanutencao() {
        return $this->mnt_atividadetipomanutencao;
    }

    function getMnt_atividadearea() {
        return $this->mnt_atividadearea;
    }

    function getEng_atividadeinativa() {
        return $this->eng_atividadeinativa;
    }

    function setMnv_atividadecodigo($mnv_atividadecodigo) {
        $this->mnv_atividadecodigo = $mnv_atividadecodigo;
    }

    function setMnv_atividadedescricao($mnv_atividadedescricao) {
        $this->mnv_atividadedescricao = $mnv_atividadedescricao;
    }

    function setMnv_atividadeprodutocodigo($mnv_atividadeprodutocodigo) {
        $this->mnv_atividadeprodutocodigo = $mnv_atividadeprodutocodigo;
    }

    function setEng_atividadeobservacao($eng_atividadeobservacao) {
        $this->eng_atividadeobservacao = $eng_atividadeobservacao;
    }

    function setEng_atividadeterceiro($eng_atividadeterceiro) {
        $this->eng_atividadeterceiro = $eng_atividadeterceiro;
    }

    function setEng_atividadeparada($eng_atividadeparada) {
        $this->eng_atividadeparada = $eng_atividadeparada;
    }

    function setEng_atividaderecursocodigo($eng_atividaderecursocodigo) {
        $this->eng_atividaderecursocodigo = $eng_atividaderecursocodigo;
    }

    function setMnt_atividadetempo($mnt_atividadetempo) {
        $this->mnt_atividadetempo = $mnt_atividadetempo;
    }

    function setMnt_atividadeprioridade($mnt_atividadeprioridade) {
        $this->mnt_atividadeprioridade = $mnt_atividadeprioridade;
    }

    function setMnt_atividadeobservacao($mnt_atividadeobservacao) {
        $this->mnt_atividadeobservacao = $mnt_atividadeobservacao;
    }

    function setMnt_atividadetipomanutencao($mnt_atividadetipomanutencao) {
        $this->mnt_atividadetipomanutencao = $mnt_atividadetipomanutencao;
    }

    function setMnt_atividadearea($mnt_atividadearea) {
        $this->mnt_atividadearea = $mnt_atividadearea;
    }

    function setEng_atividadeinativa($eng_atividadeinativa) {
        $this->eng_atividadeinativa = $eng_atividadeinativa;
    }

}
