<?php

/**
 * Model da Classe que mantem os equipamentos do codsetor de Tecnologia da Informação da Metalbo
 *
 * @author Carlos
 */
class ModelTiEquipamento {

    private $equipcod;
    private $TiEquipamentoTipo;
    private $equipusuario;
    private $equipfabricante;
    private $equipmodelo;
    private $equipsistema;
    private $equiplicenca;
    private $equipmemoria;
    private $equipcpu;
    private $equiphd;
    private $equiphostname;
    private $equipmac;
    private $equipdatacad;
    private $equiphoracad;
    private $ipfixo;
    private $nfe;
    private $equipsuprimento;
    private $Setor;
    private $filcgc;
    private $obs;
    
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    
    function getFilcgc() {
        return $this->filcgc;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function getSetor() {
        if (!isset($this->Setor)) {
            $this->Setor = Fabrica::FabricarModel('Setor');
        }

        return $this->Setor;
    }

    function setSetor($Setor) {
        $this->Setor = $Setor;
    }

    function getNfe() {
        return $this->nfe;
    }

    function getEquipsuprimento() {
        return $this->equipsuprimento;
    }

    function setNfe($nfe) {
        $this->nfe = $nfe;
    }

    function setEquipsuprimento($equipsuprimento) {
        $this->equipsuprimento = $equipsuprimento;
    }

    function getIpfixo() {
        return $this->ipfixo;
    }

    function setIpfixo($ipfixo) {
        $this->ipfixo = $ipfixo;
    }

    function getEquipcod() {
        return $this->equipcod;
    }

    function getEquipusuario() {
        return $this->equipusuario;
    }

    function getEquipfabricante() {
        return $this->equipfabricante;
    }

    function getEquipmodelo() {
        return $this->equipmodelo;
    }

    function getEquipsistema() {
        return $this->equipsistema;
    }

    function getEquiplicenca() {
        return $this->equiplicenca;
    }

    function getEquipmemoria() {
        return $this->equipmemoria;
    }

    function getEquipcpu() {
        return $this->equipcpu;
    }

    function getEquiphd() {
        return $this->equiphd;
    }

    function getEquiphostname() {
        return $this->equiphostname;
    }

    function getEquipmac() {
        return $this->equipmac;
    }

    function getEquipdatacad() {
        return $this->equipdatacad;
    }

    function getEquiphoracad() {
        return $this->equiphoracad;
    }

    function getEquipdataalter() {
        return $this->equipdataalter;
    }

    function getEquiphoraalter() {
        return $this->equiphoraalter;
    }

    function setEquipcod($equipcod) {
        $this->equipcod = $equipcod;
    }

    function getTiEquipamentoTipo() {
        if (!isset($this->TiEquipamentoTipo)) {
            $this->TiEquipamentoTipo = Fabrica::FabricarModel('TiEquipamentoTipo');
        }
        return $this->TiEquipamentoTipo;
    }

    function setTiEquipamentoTipo($TiEquipamentoTipo) {
        $this->TiEquipamentoTipo = $TiEquipamentoTipo;
    }

    function setEquipusuario($equipusuario) {
        $this->equipusuario = $equipusuario;
    }

    function setEquipfabricante($equipfabricante) {
        $this->equipfabricante = $equipfabricante;
    }

    function setEquipmodelo($equipmodelo) {
        $this->equipmodelo = $equipmodelo;
    }

    function setEquipsistema($equipsistema) {
        $this->equipsistema = $equipsistema;
    }

    function setEquiplicenca($equiplicenca) {
        $this->equiplicenca = $equiplicenca;
    }

    function setEquipmemoria($equipmemoria) {
        $this->equipmemoria = $equipmemoria;
    }

    function setEquipcpu($equipcpu) {
        $this->equipcpu = $equipcpu;
    }

    function setEquiphd($equiphd) {
        $this->equiphd = $equiphd;
    }

    function setEquiphostname($equiphostname) {
        $this->equiphostname = $equiphostname;
    }

    function setEquipmac($equipmac) {
        $this->equipmac = $equipmac;
    }

    function setEquipdatacad($equipdatacad) {
        $this->equipdatacad = $equipdatacad;
    }

    function setEquiphoracad($equiphoracad) {
        $this->equiphoracad = $equiphoracad;
    }

    function setEquipdataalter($equipdataalter) {
        $this->equipdataalter = $equipdataalter;
    }

    function setEquiphoraalter($equiphoraalter) {
        $this->equiphoraalter = $equiphoraalter;
    }

}
