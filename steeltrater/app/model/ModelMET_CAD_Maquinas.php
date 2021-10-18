<?php

/*
 * Implementa a classe model MET_CAD_Maquinas
 * @author Cleverton Hoffmann
 * @since 13/07/2021
 */

class ModelMET_CAD_Maquinas {

    private $DELX_FIL_Empresa;
    private $DELX_CAD_Pessoa;
    private $DELX_CAD_Pessoa2;
    private $MET_CAD_setores;
    private $fil_codigo;
    private $cod;
    private $maquina;
    private $bitola;
    private $seq;
    private $maqtip;
    private $cat;
    private $nomeclatura;
    private $fabricante;
    private $modelo;
    private $anofab;
    private $capacidade;
    private $produtividade;
    private $tempoopera;
    private $operadores;
    private $adequadonr12;
    private $codsetor;
    private $fornecedor;
    private $serie;
    private $patrimonio;
    private $peso02;
    private $alimentacao;
    private $protfixa;
    private $metalica;
    private $madeira;
    private $tela;
    private $acrilico;
    private $poli;
    private $protmovel;
    private $metalicamov;
    private $madeiramov;
    private $telamov;
    private $acrilicomov;
    private $polimov;
    private $sisseg;
    private $cortluz;
    private $laser;
    private $optica;
    private $batente;
    private $scanner;
    private $tapete;
    private $chaveseg;
    private $magnetica;
    private $eletromec;
    private $intseg;
    private $relesseg;
    private $clp;
    private $sitmaq;
    private $zonaprotfixa;
    private $zonaprotmovel;
    private $zonaprotseg;
    private $partida;
    private $partidabaixatensao;
    private $partidaisolacao;
    private $parada;
    private $paradabaixatensao;
    private $paradaisolacao;
    private $emergencia;
    private $emergenciabaixatensao;
    private $emeriso;
    private $emercabo;
    private $emercabobaixatensao;
    private $emercaboiso;
    private $rearme;
    private $resetbaixatensao;
    private $resetiso;
    private $sportugues;
    private $choque;
    private $relpatrimonio;
    private $empcnpj;
    private $tipmanut;
    private $obs;
    private $codigoMaq;
    private $cct_codigo;

    function getCct_codigo() {
        return $this->cct_codigo;
    }

    function setCct_codigo($cct_codigo) {
        $this->cct_codigo = $cct_codigo;
    }

    function getCodigoMaq() {
        return $this->codigoMaq;
    }

    function setCodigoMaq($codigoMaq) {
        $this->codigoMaq = $codigoMaq;
    }

    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function getDELX_FIL_Empresa() {
        if (!isset($this->DELX_FIL_Empresa)) {
            $this->DELX_FIL_Empresa = Fabrica::FabricarModel('DELX_FIL_Empresa');
        }
        return $this->DELX_FIL_Empresa;
    }

    function setDELX_FIL_Empresa($DELX_FIL_Empresa) {
        $this->DELX_FIL_Empresa = $DELX_FIL_Empresa;
    }

    function getDELX_CAD_Pessoa() {
        if (!isset($this->DELX_CAD_Pessoa)) {
            $this->DELX_CAD_Pessoa = Fabrica::FabricarModel('DELX_CAD_Pessoa');
        }
        return $this->DELX_CAD_Pessoa;
    }

    function setDELX_CAD_Pessoa($DELX_CAD_Pessoa) {
        $this->DELX_CAD_Pessoa = $DELX_CAD_Pessoa;
    }

    function getDELX_CAD_Pessoa2() {
        if (!isset($this->DELX_CAD_Pessoa2)) {
            $this->DELX_CAD_Pessoa2 = Fabrica::FabricarModel('DELX_CAD_Pessoa');
        }
        return $this->DELX_CAD_Pessoa2;
    }

    function setDELX_CAD_Pessoa2($DELX_CAD_Pessoa2) {
        $this->DELX_CAD_Pessoa2 = $DELX_CAD_Pessoa2;
    }

    function getMET_CAD_setores() {
        if (!isset($this->MET_CAD_setores)) {
            $this->MET_CAD_setores = Fabrica::FabricarModel('MET_CAD_setores');
        }
        return $this->MET_CAD_setores;
    }

    function setMET_CAD_setores($MET_CAD_setores) {
        $this->MET_CAD_setores = $MET_CAD_setores;
    }

    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }

    function getCod() {
        return $this->cod;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function getMaquina() {
        return $this->maquina;
    }

    function setMaquina($maquina) {
        $this->maquina = $maquina;
    }

    function getBitola() {
        return $this->bitola;
    }

    function setBitola($bitola) {
        $this->bitola = $bitola;
    }

    function getSeq() {
        return $this->seq;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function getMaqtip() {
        return $this->maqtip;
    }

    function setMaqtip($maqtip) {
        $this->maqtip = $maqtip;
    }

    function getCat() {
        return $this->cat;
    }

    function setCat($cat) {
        $this->cat = $cat;
    }

    function getNomeclatura() {
        return $this->nomeclatura;
    }

    function setNomeclatura($nomeclatura) {
        $this->nomeclatura = $nomeclatura;
    }

    function getFabricante() {
        return $this->fabricante;
    }

    function setFabricante($fabricante) {
        $this->fabricante = $fabricante;
    }

    function getModelo() {
        return $this->modelo;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function getAnofab() {
        return $this->anofab;
    }

    function setAnofab($anofab) {
        $this->anofab = $anofab;
    }

    function getCapacidade() {
        return $this->capacidade;
    }

    function setCapacidade($capacidade) {
        $this->capacidade = $capacidade;
    }

    function getProdutividade() {
        return $this->produtividade;
    }

    function setProdutividade($produtividade) {
        $this->produtividade = $produtividade;
    }

    function getTempoopera() {
        return $this->tempoopera;
    }

    function setTempoopera($tempoopera) {
        $this->tempoopera = $tempoopera;
    }

    function getOperadores() {
        return $this->operadores;
    }

    function setOperadores($operadores) {
        $this->operadores = $operadores;
    }

    function getAdequadonr12() {
        return $this->adequadonr12;
    }

    function setAdequadonr12($adequadonr12) {
        $this->adequadonr12 = $adequadonr12;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function getFornecedor() {
        return $this->fornecedor;
    }

    function setFornecedor($fornecedor) {
        $this->fornecedor = $fornecedor;
    }

    function getSerie() {
        return $this->serie;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

    function getPatrimonio() {
        return $this->patrimonio;
    }

    function setPatrimonio($patrimonio) {
        $this->patrimonio = $patrimonio;
    }

    function getPeso02() {
        return $this->peso02;
    }

    function setPeso02($peso02) {
        $this->peso02 = $peso02;
    }

    function getAlimentacao() {
        return $this->alimentacao;
    }

    function setAlimentacao($alimentacao) {
        $this->alimentacao = $alimentacao;
    }

    function getProtfixa() {
        return $this->protfixa;
    }

    function setProtfixa($protfixa) {
        $this->protfixa = $protfixa;
    }

    function getMetalica() {
        return $this->metalica;
    }

    function setMetalica($metalica) {
        $this->metalica = $metalica;
    }

    function getMadeira() {
        return $this->madeira;
    }

    function setMadeira($madeira) {
        $this->madeira = $madeira;
    }

    function getTela() {
        return $this->tela;
    }

    function setTela($tela) {
        $this->tela = $tela;
    }

    function getAcrilico() {
        return $this->acrilico;
    }

    function setAcrilico($acrilico) {
        $this->acrilico = $acrilico;
    }

    function getPoli() {
        return $this->poli;
    }

    function setPoli($poli) {
        $this->poli = $poli;
    }

    function getProtmovel() {
        return $this->protmovel;
    }

    function setProtmovel($protmovel) {
        $this->protmovel = $protmovel;
    }

    function getMetalicamov() {
        return $this->metalicamov;
    }

    function setMetalicamov($metalicamov) {
        $this->metalicamov = $metalicamov;
    }

    function getMadeiramov() {
        return $this->madeiramov;
    }

    function setMadeiramov($madeiramov) {
        $this->madeiramov = $madeiramov;
    }

    function getTelamov() {
        return $this->telamov;
    }

    function setTelamov($telamov) {
        $this->telamov = $telamov;
    }

    function getAcrilicomov() {
        return $this->acrilicomov;
    }

    function setAcrilicomov($acrilicomov) {
        $this->acrilicomov = $acrilicomov;
    }

    function getPolimov() {
        return $this->polimov;
    }

    function setPolimov($polimov) {
        $this->polimov = $polimov;
    }

    function getSisseg() {
        return $this->sisseg;
    }

    function setSisseg($sisseg) {
        $this->sisseg = $sisseg;
    }

    function getCortluz() {
        return $this->cortluz;
    }

    function setCortluz($cortluz) {
        $this->cortluz = $cortluz;
    }

    function getLaser() {
        return $this->laser;
    }

    function setLaser($laser) {
        $this->laser = $laser;
    }

    function getOptica() {
        return $this->optica;
    }

    function setOptica($optica) {
        $this->optica = $optica;
    }

    function getBatente() {
        return $this->batente;
    }

    function setBatente($batente) {
        $this->batente = $batente;
    }

    function getScanner() {
        return $this->scanner;
    }

    function setScanner($scanner) {
        $this->scanner = $scanner;
    }

    function getTapete() {
        return $this->tapete;
    }

    function setTapete($tapete) {
        $this->tapete = $tapete;
    }

    function getChaveseg() {
        return $this->chaveseg;
    }

    function setChaveseg($chaveseg) {
        $this->chaveseg = $chaveseg;
    }

    function getMagnetica() {
        return $this->magnetica;
    }

    function setMagnetica($magnetica) {
        $this->magnetica = $magnetica;
    }

    function getEletromec() {
        return $this->eletromec;
    }

    function setEletromec($eletromec) {
        $this->eletromec = $eletromec;
    }

    function getIntseg() {
        return $this->intseg;
    }

    function setIntseg($intseg) {
        $this->intseg = $intseg;
    }

    function getRelesseg() {
        return $this->relesseg;
    }

    function setRelesseg($relesseg) {
        $this->relesseg = $relesseg;
    }

    function getClp() {
        return $this->clp;
    }

    function setClp($clp) {
        $this->clp = $clp;
    }

    function getSitmaq() {
        return $this->sitmaq;
    }

    function setSitmaq($sitmaq) {
        $this->sitmaq = $sitmaq;
    }

    function getZonaprotfixa() {
        return $this->zonaprotfixa;
    }

    function setZonaprotfixa($zonaprotfixa) {
        $this->zonaprotfixa = $zonaprotfixa;
    }

    function getZonaprotmovel() {
        return $this->zonaprotmovel;
    }

    function setZonaprotmovel($zonaprotmovel) {
        $this->zonaprotmovel = $zonaprotmovel;
    }

    function getZonaprotseg() {
        return $this->zonaprotseg;
    }

    function setZonaprotseg($zonaprotseg) {
        $this->zonaprotseg = $zonaprotseg;
    }

    function getPartida() {
        return $this->partida;
    }

    function setPartida($partida) {
        $this->partida = $partida;
    }

    function getPartidabaixatensao() {
        return $this->partidabaixatensao;
    }

    function setPartidabaixatensao($partidabaixatensao) {
        $this->partidabaixatensao = $partidabaixatensao;
    }

    function getPartidaisolacao() {
        return $this->partidaisolacao;
    }

    function setPartidaisolacao($partidaisolacao) {
        $this->partidaisolacao = $partidaisolacao;
    }

    function getParada() {
        return $this->parada;
    }

    function setParada($parada) {
        $this->parada = $parada;
    }

    function getParadabaixatensao() {
        return $this->paradabaixatensao;
    }

    function setParadabaixatensao($paradabaixatensao) {
        $this->paradabaixatensao = $paradabaixatensao;
    }

    function getParadaisolacao() {
        return $this->paradaisolacao;
    }

    function setParadaisolacao($paradaisolacao) {
        $this->paradaisolacao = $paradaisolacao;
    }

    function getEmergencia() {
        return $this->emergencia;
    }

    function setEmergencia($emergencia) {
        $this->emergencia = $emergencia;
    }

    function getEmergenciabaixatensao() {
        return $this->emergenciabaixatensao;
    }

    function setEmergenciabaixatensao($emergenciabaixatensao) {
        $this->emergenciabaixatensao = $emergenciabaixatensao;
    }

    function getEmeriso() {
        return $this->emeriso;
    }

    function setEmeriso($emeriso) {
        $this->emeriso = $emeriso;
    }

    function getEmercabo() {
        return $this->emercabo;
    }

    function setEmercabo($emercabo) {
        $this->emercabo = $emercabo;
    }

    function getEmercabobaixatensao() {
        return $this->emercabobaixatensao;
    }

    function setEmercabobaixatensao($emercabobaixatensao) {
        $this->emercabobaixatensao = $emercabobaixatensao;
    }

    function getEmercaboiso() {
        return $this->emercaboiso;
    }

    function setEmercaboiso($emercaboiso) {
        $this->emercaboiso = $emercaboiso;
    }

    function getRearme() {
        return $this->rearme;
    }

    function setRearme($reset) {
        $this->rearme = $reset;
    }

    function getResetbaixatensao() {
        return $this->resetbaixatensao;
    }

    function setResetbaixatensao($resetbaixatensao) {
        $this->resetbaixatensao = $resetbaixatensao;
    }

    function getResetiso() {
        return $this->resetiso;
    }

    function setResetiso($resetiso) {
        $this->resetiso = $resetiso;
    }

    function getSportugues() {
        return $this->sportugues;
    }

    function setSportugues($sportugues) {
        $this->sportugues = $sportugues;
    }

    function getChoque() {
        return $this->choque;
    }

    function setChoque($choque) {
        $this->choque = $choque;
    }

    function getRelpatrimonio() {
        return $this->relpatrimonio;
    }

    function setRelpatrimonio($relpatrimonio) {
        $this->relpatrimonio = $relpatrimonio;
    }

    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function getTipmanut() {
        return $this->tipmanut;
    }

    function setTipmanut($tipmanut) {
        $this->tipmanut = $tipmanut;
    }

}
