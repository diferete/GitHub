<?php 
 /*
 * Implementa a classe model MET_ServicoOrdemCompra
 * @author Cleverton Hoffmann
 * @since 22/07/2020
 */
 
class ModelMET_ServicoOrdemCompra {

    private $Produto;
    private $Pessoa;
    private $empcod;
    private $seq;
    private $grupo;
    private $codserv;
    private $tips;
    private $descserv;
    private $valoruni;

    function getProduto() {
        if (!isset($this->Produto)) {
            $this->Produto = Fabrica::FabricarModel('Produto');
        }
        return $this->Produto;
    }

    function setProduto($Produto) {
        $this->Produto = $Produto;
    }
    
    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }
    
    function getEmpcod(){
       return $this->empcod;
    }
    function setEmpcod($empcod){
       $this->empcod = $empcod;
    }
    function getSeq(){
       return $this->seq;
    }
    function setSeq($seq){
       $this->seq = $seq;
    }
    function getGrupo(){
       return $this->grupo;
    }
    function setGrupo($grupo){
       $this->grupo = $grupo;
    }
    function getCodserv(){
       return $this->codserv;
    }
    function setCodserv($codserv){
       $this->codserv = $codserv;
    }
    function getTips(){
       return $this->tips;
    }
    function setTips($tips){
       $this->tips = $tips;
    }
    function getDescserv(){
       return $this->descserv;
    }
    function setDescserv($descserv){
       $this->descserv = $descserv;
    }
    function getValoruni(){
       return $this->valoruni;
    }
    function setValoruni($valoruni){
       $this->valoruni = $valoruni;
    }
}