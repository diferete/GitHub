<?php 
 /*
 * Implementa a classe model STEEL_SOL_AprovacoesItens
 * @author Alexandre de Souza
 * @since 18/08/2021
 */ 
class ModelSTEEL_SOL_AprovacoesItens {
    private $fil_codigo;
    private $sup_solicitacaoseq;
    private $sup_solicitacaoitemseq;
    private $pro_codigo;
    private $sup_prioridadecodigo;
    private $sup_solicitacaoitemdescricao;
    private $sup_solicitacaoitemunidade;
    private $sup_solicitacaoitemdimpecas;
    private $sup_solicitacaoitemdimcomprime;
    private $sup_solicitacaoitemdimlargura;
    private $sup_solicitacaoitemdimespessur;
    private $sup_solicitacaoitemcomqtd;
    private $sup_solicitacaoitemcomconv;
    private $sup_solicitacaoitemcomund;
    private $sup_solicitacaoitemqtd;
    private $sup_solicitacaoitemdatanecessi;
    private $sup_solicitacaoitemususol;
    private $sup_solicitacaoitemusucom;
    private $sup_solicitacaoitemobservacao;
    private $sup_solicitacaoitemreferencia;
    private $sup_solicitacaoitemvalor;
    private $sup_solicitacaoitempesoliq;
    private $sup_solicitacaoitempesobru;
    private $sup_solicitacaoitemdimunidade;
    private $sup_solicitacaoitemdataaprverb;
    private $sup_solicitacaoitemvalortotal;
    private $sup_solicitacaoitemsituacao;
    private $sup_solicitacaoitemgrade;
    private $sup_solicitacaoitemtipodespcod;
    private $sup_solicitacaoitemcctcodigo;
    private $sup_solicitacaoitemplano;
    private $sup_solicitacaoitemconta;
    private $sup_solicitacaoitemprojeto;
    private $sup_solicitacaoitemoritipo;
    private $sup_solicitacaoitemorinumero;
    private $sup_solicitacaoitemoriitem;
    private $sup_solicitacaoitemconversor;
    private $sup_solicitacaoitemdimconv;
    private $sup_solicitacaoitemdimundconv;
    private $sup_solicitacaoitemdimgqtd;
    private $sup_solicitacaoitemdimgformula;
    private $sup_solicitacaoitemdimgexpres;
    private $sup_solicitacaoitemdataentrega;
    private $sup_solicitacaoitemposicao;

    function getFil_codigo(){
       return $this->fil_codigo;
    }
    function setFil_codigo($fil_codigo){
       $this->fil_codigo = $fil_codigo;
    }
    function getSup_solicitacaoseq(){
       return $this->sup_solicitacaoseq;
    }
    function setSup_solicitacaoseq($sup_solicitacaoseq){
       $this->sup_solicitacaoseq = $sup_solicitacaoseq;
    }
    function getSup_solicitacaoitemseq(){
       return $this->sup_solicitacaoitemseq;
    }
    function setSup_solicitacaoitemseq($sup_solicitacaoitemseq){
       $this->sup_solicitacaoitemseq = $sup_solicitacaoitemseq;
    }
    function getPro_codigo(){
       return $this->pro_codigo;
    }
    function setPro_codigo($pro_codigo){
       $this->pro_codigo = $pro_codigo;
    }
    function getSup_prioridadecodigo(){
       return $this->sup_prioridadecodigo;
    }
    function setSup_prioridadecodigo($sup_prioridadecodigo){
       $this->sup_prioridadecodigo = $sup_prioridadecodigo;
    }
    function getSup_solicitacaoitemdescricao(){
       return $this->sup_solicitacaoitemdescricao;
    }
    function setSup_solicitacaoitemdescricao($sup_solicitacaoitemdescricao){
       $this->sup_solicitacaoitemdescricao = $sup_solicitacaoitemdescricao;
    }
    function getSup_solicitacaoitemunidade(){
       return $this->sup_solicitacaoitemunidade;
    }
    function setSup_solicitacaoitemunidade($sup_solicitacaoitemunidade){
       $this->sup_solicitacaoitemunidade = $sup_solicitacaoitemunidade;
    }
    function getSup_solicitacaoitemdimpecas(){
       return $this->sup_solicitacaoitemdimpecas;
    }
    function setSup_solicitacaoitemdimpecas($sup_solicitacaoitemdimpecas){
       $this->sup_solicitacaoitemdimpecas = $sup_solicitacaoitemdimpecas;
    }
    function getSup_solicitacaoitemdimcomprime(){
       return $this->sup_solicitacaoitemdimcomprime;
    }
    function setSup_solicitacaoitemdimcomprime($sup_solicitacaoitemdimcomprime){
       $this->sup_solicitacaoitemdimcomprime = $sup_solicitacaoitemdimcomprime;
    }
    function getSup_solicitacaoitemdimlargura(){
       return $this->sup_solicitacaoitemdimlargura;
    }
    function setSup_solicitacaoitemdimlargura($sup_solicitacaoitemdimlargura){
       $this->sup_solicitacaoitemdimlargura = $sup_solicitacaoitemdimlargura;
    }
    function getSup_solicitacaoitemdimespessur(){
       return $this->sup_solicitacaoitemdimespessur;
    }
    function setSup_solicitacaoitemdimespessur($sup_solicitacaoitemdimespessur){
       $this->sup_solicitacaoitemdimespessur = $sup_solicitacaoitemdimespessur;
    }
    function getSup_solicitacaoitemcomqtd(){
       return $this->sup_solicitacaoitemcomqtd;
    }
    function setSup_solicitacaoitemcomqtd($sup_solicitacaoitemcomqtd){
       $this->sup_solicitacaoitemcomqtd = $sup_solicitacaoitemcomqtd;
    }
    function getSup_solicitacaoitemcomconv(){
       return $this->sup_solicitacaoitemcomconv;
    }
    function setSup_solicitacaoitemcomconv($sup_solicitacaoitemcomconv){
       $this->sup_solicitacaoitemcomconv = $sup_solicitacaoitemcomconv;
    }
    function getSup_solicitacaoitemcomund(){
       return $this->sup_solicitacaoitemcomund;
    }
    function setSup_solicitacaoitemcomund($sup_solicitacaoitemcomund){
       $this->sup_solicitacaoitemcomund = $sup_solicitacaoitemcomund;
    }
    function getSup_solicitacaoitemqtd(){
       return $this->sup_solicitacaoitemqtd;
    }
    function setSup_solicitacaoitemqtd($sup_solicitacaoitemqtd){
       $this->sup_solicitacaoitemqtd = $sup_solicitacaoitemqtd;
    }
    function getSup_solicitacaoitemdatanecessi(){
       return $this->sup_solicitacaoitemdatanecessi;
    }
    function setSup_solicitacaoitemdatanecessi($sup_solicitacaoitemdatanecessi){
       $this->sup_solicitacaoitemdatanecessi = $sup_solicitacaoitemdatanecessi;
    }
    function getSup_solicitacaoitemususol(){
       return $this->sup_solicitacaoitemususol;
    }
    function setSup_solicitacaoitemususol($sup_solicitacaoitemususol){
       $this->sup_solicitacaoitemususol = $sup_solicitacaoitemususol;
    }
    function getSup_solicitacaoitemusucom(){
       return $this->sup_solicitacaoitemusucom;
    }
    function setSup_solicitacaoitemusucom($sup_solicitacaoitemusucom){
       $this->sup_solicitacaoitemusucom = $sup_solicitacaoitemusucom;
    }
    function getSup_solicitacaoitemobservacao(){
       return $this->sup_solicitacaoitemobservacao;
    }
    function setSup_solicitacaoitemobservacao($sup_solicitacaoitemobservacao){
       $this->sup_solicitacaoitemobservacao = $sup_solicitacaoitemobservacao;
    }
    function getSup_solicitacaoitemreferencia(){
       return $this->sup_solicitacaoitemreferencia;
    }
    function setSup_solicitacaoitemreferencia($sup_solicitacaoitemreferencia){
       $this->sup_solicitacaoitemreferencia = $sup_solicitacaoitemreferencia;
    }
    function getSup_solicitacaoitemvalor(){
       return $this->sup_solicitacaoitemvalor;
    }
    function setSup_solicitacaoitemvalor($sup_solicitacaoitemvalor){
       $this->sup_solicitacaoitemvalor = $sup_solicitacaoitemvalor;
    }
    function getSup_solicitacaoitempesoliq(){
       return $this->sup_solicitacaoitempesoliq;
    }
    function setSup_solicitacaoitempesoliq($sup_solicitacaoitempesoliq){
       $this->sup_solicitacaoitempesoliq = $sup_solicitacaoitempesoliq;
    }
    function getSup_solicitacaoitempesobru(){
       return $this->sup_solicitacaoitempesobru;
    }
    function setSup_solicitacaoitempesobru($sup_solicitacaoitempesobru){
       $this->sup_solicitacaoitempesobru = $sup_solicitacaoitempesobru;
    }
    function getSup_solicitacaoitemdimunidade(){
       return $this->sup_solicitacaoitemdimunidade;
    }
    function setSup_solicitacaoitemdimunidade($sup_solicitacaoitemdimunidade){
       $this->sup_solicitacaoitemdimunidade = $sup_solicitacaoitemdimunidade;
    }
    function getSup_solicitacaoitemdataaprverb(){
       return $this->sup_solicitacaoitemdataaprverb;
    }
    function setSup_solicitacaoitemdataaprverb($sup_solicitacaoitemdataaprverb){
       $this->sup_solicitacaoitemdataaprverb = $sup_solicitacaoitemdataaprverb;
    }
    function getSup_solicitacaoitemvalortotal(){
       return $this->sup_solicitacaoitemvalortotal;
    }
    function setSup_solicitacaoitemvalortotal($sup_solicitacaoitemvalortotal){
       $this->sup_solicitacaoitemvalortotal = $sup_solicitacaoitemvalortotal;
    }
    function getSup_solicitacaoitemsituacao(){
       return $this->sup_solicitacaoitemsituacao;
    }
    function setSup_solicitacaoitemsituacao($sup_solicitacaoitemsituacao){
       $this->sup_solicitacaoitemsituacao = $sup_solicitacaoitemsituacao;
    }
    function getSup_solicitacaoitemgrade(){
       return $this->sup_solicitacaoitemgrade;
    }
    function setSup_solicitacaoitemgrade($sup_solicitacaoitemgrade){
       $this->sup_solicitacaoitemgrade = $sup_solicitacaoitemgrade;
    }
    function getSup_solicitacaoitemtipodespcod(){
       return $this->sup_solicitacaoitemtipodespcod;
    }
    function setSup_solicitacaoitemtipodespcod($sup_solicitacaoitemtipodespcod){
       $this->sup_solicitacaoitemtipodespcod = $sup_solicitacaoitemtipodespcod;
    }
    function getSup_solicitacaoitemcctcodigo(){
       return $this->sup_solicitacaoitemcctcodigo;
    }
    function setSup_solicitacaoitemcctcodigo($sup_solicitacaoitemcctcodigo){
       $this->sup_solicitacaoitemcctcodigo = $sup_solicitacaoitemcctcodigo;
    }
    function getSup_solicitacaoitemplano(){
       return $this->sup_solicitacaoitemplano;
    }
    function setSup_solicitacaoitemplano($sup_solicitacaoitemplano){
       $this->sup_solicitacaoitemplano = $sup_solicitacaoitemplano;
    }
    function getSup_solicitacaoitemconta(){
       return $this->sup_solicitacaoitemconta;
    }
    function setSup_solicitacaoitemconta($sup_solicitacaoitemconta){
       $this->sup_solicitacaoitemconta = $sup_solicitacaoitemconta;
    }
    function getSup_solicitacaoitemprojeto(){
       return $this->sup_solicitacaoitemprojeto;
    }
    function setSup_solicitacaoitemprojeto($sup_solicitacaoitemprojeto){
       $this->sup_solicitacaoitemprojeto = $sup_solicitacaoitemprojeto;
    }
    function getSup_solicitacaoitemoritipo(){
       return $this->sup_solicitacaoitemoritipo;
    }
    function setSup_solicitacaoitemoritipo($sup_solicitacaoitemoritipo){
       $this->sup_solicitacaoitemoritipo = $sup_solicitacaoitemoritipo;
    }
    function getSup_solicitacaoitemorinumero(){
       return $this->sup_solicitacaoitemorinumero;
    }
    function setSup_solicitacaoitemorinumero($sup_solicitacaoitemorinumero){
       $this->sup_solicitacaoitemorinumero = $sup_solicitacaoitemorinumero;
    }
    function getSup_solicitacaoitemoriitem(){
       return $this->sup_solicitacaoitemoriitem;
    }
    function setSup_solicitacaoitemoriitem($sup_solicitacaoitemoriitem){
       $this->sup_solicitacaoitemoriitem = $sup_solicitacaoitemoriitem;
    }
    function getSup_solicitacaoitemconversor(){
       return $this->sup_solicitacaoitemconversor;
    }
    function setSup_solicitacaoitemconversor($sup_solicitacaoitemconversor){
       $this->sup_solicitacaoitemconversor = $sup_solicitacaoitemconversor;
    }
    function getSup_solicitacaoitemdimconv(){
       return $this->sup_solicitacaoitemdimconv;
    }
    function setSup_solicitacaoitemdimconv($sup_solicitacaoitemdimconv){
       $this->sup_solicitacaoitemdimconv = $sup_solicitacaoitemdimconv;
    }
    function getSup_solicitacaoitemdimundconv(){
       return $this->sup_solicitacaoitemdimundconv;
    }
    function setSup_solicitacaoitemdimundconv($sup_solicitacaoitemdimundconv){
       $this->sup_solicitacaoitemdimundconv = $sup_solicitacaoitemdimundconv;
    }
    function getSup_solicitacaoitemdimgqtd(){
       return $this->sup_solicitacaoitemdimgqtd;
    }
    function setSup_solicitacaoitemdimgqtd($sup_solicitacaoitemdimgqtd){
       $this->sup_solicitacaoitemdimgqtd = $sup_solicitacaoitemdimgqtd;
    }
    function getSup_solicitacaoitemdimgformula(){
       return $this->sup_solicitacaoitemdimgformula;
    }
    function setSup_solicitacaoitemdimgformula($sup_solicitacaoitemdimgformula){
       $this->sup_solicitacaoitemdimgformula = $sup_solicitacaoitemdimgformula;
    }
    function getSup_solicitacaoitemdimgexpres(){
       return $this->sup_solicitacaoitemdimgexpres;
    }
    function setSup_solicitacaoitemdimgexpres($sup_solicitacaoitemdimgexpres){
       $this->sup_solicitacaoitemdimgexpres = $sup_solicitacaoitemdimgexpres;
    }
    function getSup_solicitacaoitemdataentrega(){
       return $this->sup_solicitacaoitemdataentrega;
    }
    function setSup_solicitacaoitemdataentrega($sup_solicitacaoitemdataentrega){
       $this->sup_solicitacaoitemdataentrega = $sup_solicitacaoitemdataentrega;
    }
    function getSup_solicitacaoitemposicao(){
       return $this->sup_solicitacaoitemposicao;
    }
    function setSup_solicitacaoitemposicao($sup_solicitacaoitemposicao){
       $this->sup_solicitacaoitemposicao = $sup_solicitacaoitemposicao;
    }
}