<?php 
 /*
 * Implementa a classe model STEEL_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */ 
class ModelSTEEL_PED_AprovacoesItens {
    private $fil_codigo;
    private $sup_pedidoseq;
    private $sup_pedidoitemseq;
    private $pro_codigo;
    private $pro_familiacodigo;
    private $sup_pedidoitemdescricao;
    private $sup_pedidoitemunidade;
    private $sup_pedidoitemreferencia;
    private $sup_pedidoitemdimpecas;
    private $sup_pedidoitemdimcomp;
    private $sup_pedidoitemdimlarg;
    private $sup_pedidoitemdimespe;
    private $sup_pedidoitemcomqtd;
    private $sup_pedidoitemcomconv;
    private $sup_pedidoitemcomund;
    private $sup_pedidoitemcomvalor;
    private $sup_pedidoitemqtd;
    private $sup_pedidoitemdataneces;
    private $sup_pedidoitemdataentrega;
    private $sup_pedidoitemsituacao;
    private $sup_pedidoitemvalor;
    private $sup_pedidoitemqtdreceb;
    private $sup_pedidoitemobservacao;
    private $sup_pedidoitemmargemtolqtd;
    private $sup_pedidoitemperdesconto;
    private $sup_pedidoitemvlrdesconto;
    private $sup_pedidoitempesobru;
    private $sup_pedidoitempesoliq;
    private $sup_pedidoitemdimund;
    private $sup_pedidoitemdimconv;
    private $sup_pedidoitemdimundconv;
    private $sup_pedidoitemvalorfrete;
    private $sup_pedidoitemvalordespesa;
    private $sup_pedidoitemvalorseguro;
    private $sup_pedidoitemvalordesconto;
    private $sup_pedidoitemvalortotal;
    private $sup_pedidoitemmargemtolvlr;
    private $sup_pedidoitemtipodesconto;
    private $sup_pedidoitemgrade;
    private $sup_pedidoitemtipodespesacodig;
    private $sup_pedidoitemcentrocustocodig;
    private $sup_pedidoitemplano;
    private $sup_pedidoitemconta;
    private $sup_pedidoitemprojeto;
    private $sup_pedidoitemconversor;
    private $sup_pedidoitemmarca;
    private $sup_pedidoitemloteminimo;
    private $sup_pedidoitemlotemultiplo;
    private $sup_pedidoitemdimgqtd;
    private $sup_pedidoitemdimgformula;
    private $sup_pedidoitemdimgexpres;
    private $sup_pedidoitemseqaprovacao;
    private $sup_pedidoitemcomvalortabela;
    private $sup_pedidoitemlote;
    private $sup_pedidoitemdataenvio;
    private $sup_pedidoitemencmandatahr;
    private $sup_pedidoitemencmanusu;
    private $sup_pedidoitemencmanjus;
    private $sup_pedidoitemdimcalc;
    private $sup_pedidoitemdataultupd;
    private $sup_pedidoitemimportado;
    private $sup_pedidoitemvaloracrescimo;
    private $sup_pedidoitemcontrato;
    private $sup_pedidoitemdataaprverba;
    private $sup_pedidoitemcontratoseq;

    function getFil_codigo(){
       return $this->fil_codigo;
    }
    function setFil_codigo($fil_codigo){
       $this->fil_codigo = $fil_codigo;
    }
    function getSup_pedidoseq(){
       return $this->sup_pedidoseq;
    }
    function setSup_pedidoseq($sup_pedidoseq){
       $this->sup_pedidoseq = $sup_pedidoseq;
    }
    function getSup_pedidoitemseq(){
       return $this->sup_pedidoitemseq;
    }
    function setSup_pedidoitemseq($sup_pedidoitemseq){
       $this->sup_pedidoitemseq = $sup_pedidoitemseq;
    }
    function getPro_codigo(){
       return $this->pro_codigo;
    }
    function setPro_codigo($pro_codigo){
       $this->pro_codigo = $pro_codigo;
    }
    function getPro_familiacodigo(){
       return $this->pro_familiacodigo;
    }
    function setPro_familiacodigo($pro_familiacodigo){
       $this->pro_familiacodigo = $pro_familiacodigo;
    }
    function getSup_pedidoitemdescricao(){
       return $this->sup_pedidoitemdescricao;
    }
    function setSup_pedidoitemdescricao($sup_pedidoitemdescricao){
       $this->sup_pedidoitemdescricao = $sup_pedidoitemdescricao;
    }
    function getSup_pedidoitemunidade(){
       return $this->sup_pedidoitemunidade;
    }
    function setSup_pedidoitemunidade($sup_pedidoitemunidade){
       $this->sup_pedidoitemunidade = $sup_pedidoitemunidade;
    }
    function getSup_pedidoitemreferencia(){
       return $this->sup_pedidoitemreferencia;
    }
    function setSup_pedidoitemreferencia($sup_pedidoitemreferencia){
       $this->sup_pedidoitemreferencia = $sup_pedidoitemreferencia;
    }
    function getSup_pedidoitemdimpecas(){
       return $this->sup_pedidoitemdimpecas;
    }
    function setSup_pedidoitemdimpecas($sup_pedidoitemdimpecas){
       $this->sup_pedidoitemdimpecas = $sup_pedidoitemdimpecas;
    }
    function getSup_pedidoitemdimcomp(){
       return $this->sup_pedidoitemdimcomp;
    }
    function setSup_pedidoitemdimcomp($sup_pedidoitemdimcomp){
       $this->sup_pedidoitemdimcomp = $sup_pedidoitemdimcomp;
    }
    function getSup_pedidoitemdimlarg(){
       return $this->sup_pedidoitemdimlarg;
    }
    function setSup_pedidoitemdimlarg($sup_pedidoitemdimlarg){
       $this->sup_pedidoitemdimlarg = $sup_pedidoitemdimlarg;
    }
    function getSup_pedidoitemdimespe(){
       return $this->sup_pedidoitemdimespe;
    }
    function setSup_pedidoitemdimespe($sup_pedidoitemdimespe){
       $this->sup_pedidoitemdimespe = $sup_pedidoitemdimespe;
    }
    function getSup_pedidoitemcomqtd(){
       return $this->sup_pedidoitemcomqtd;
    }
    function setSup_pedidoitemcomqtd($sup_pedidoitemcomqtd){
       $this->sup_pedidoitemcomqtd = $sup_pedidoitemcomqtd;
    }
    function getSup_pedidoitemcomconv(){
       return $this->sup_pedidoitemcomconv;
    }
    function setSup_pedidoitemcomconv($sup_pedidoitemcomconv){
       $this->sup_pedidoitemcomconv = $sup_pedidoitemcomconv;
    }
    function getSup_pedidoitemcomund(){
       return $this->sup_pedidoitemcomund;
    }
    function setSup_pedidoitemcomund($sup_pedidoitemcomund){
       $this->sup_pedidoitemcomund = $sup_pedidoitemcomund;
    }
    function getSup_pedidoitemcomvalor(){
       return $this->sup_pedidoitemcomvalor;
    }
    function setSup_pedidoitemcomvalor($sup_pedidoitemcomvalor){
       $this->sup_pedidoitemcomvalor = $sup_pedidoitemcomvalor;
    }
    function getSup_pedidoitemqtd(){
       return $this->sup_pedidoitemqtd;
    }
    function setSup_pedidoitemqtd($sup_pedidoitemqtd){
       $this->sup_pedidoitemqtd = $sup_pedidoitemqtd;
    }
    function getSup_pedidoitemdataneces(){
       return $this->sup_pedidoitemdataneces;
    }
    function setSup_pedidoitemdataneces($sup_pedidoitemdataneces){
       $this->sup_pedidoitemdataneces = $sup_pedidoitemdataneces;
    }
    function getSup_pedidoitemdataentrega(){
       return $this->sup_pedidoitemdataentrega;
    }
    function setSup_pedidoitemdataentrega($sup_pedidoitemdataentrega){
       $this->sup_pedidoitemdataentrega = $sup_pedidoitemdataentrega;
    }
    function getSup_pedidoitemsituacao(){
       return $this->sup_pedidoitemsituacao;
    }
    function setSup_pedidoitemsituacao($sup_pedidoitemsituacao){
       $this->sup_pedidoitemsituacao = $sup_pedidoitemsituacao;
    }
    function getSup_pedidoitemvalor(){
       return $this->sup_pedidoitemvalor;
    }
    function setSup_pedidoitemvalor($sup_pedidoitemvalor){
       $this->sup_pedidoitemvalor = $sup_pedidoitemvalor;
    }
    function getSup_pedidoitemqtdreceb(){
       return $this->sup_pedidoitemqtdreceb;
    }
    function setSup_pedidoitemqtdreceb($sup_pedidoitemqtdreceb){
       $this->sup_pedidoitemqtdreceb = $sup_pedidoitemqtdreceb;
    }
    function getSup_pedidoitemobservacao(){
       return $this->sup_pedidoitemobservacao;
    }
    function setSup_pedidoitemobservacao($sup_pedidoitemobservacao){
       $this->sup_pedidoitemobservacao = $sup_pedidoitemobservacao;
    }
    function getSup_pedidoitemmargemtolqtd(){
       return $this->sup_pedidoitemmargemtolqtd;
    }
    function setSup_pedidoitemmargemtolqtd($sup_pedidoitemmargemtolqtd){
       $this->sup_pedidoitemmargemtolqtd = $sup_pedidoitemmargemtolqtd;
    }
    function getSup_pedidoitemperdesconto(){
       return $this->sup_pedidoitemperdesconto;
    }
    function setSup_pedidoitemperdesconto($sup_pedidoitemperdesconto){
       $this->sup_pedidoitemperdesconto = $sup_pedidoitemperdesconto;
    }
    function getSup_pedidoitemvlrdesconto(){
       return $this->sup_pedidoitemvlrdesconto;
    }
    function setSup_pedidoitemvlrdesconto($sup_pedidoitemvlrdesconto){
       $this->sup_pedidoitemvlrdesconto = $sup_pedidoitemvlrdesconto;
    }
    function getSup_pedidoitempesobru(){
       return $this->sup_pedidoitempesobru;
    }
    function setSup_pedidoitempesobru($sup_pedidoitempesobru){
       $this->sup_pedidoitempesobru = $sup_pedidoitempesobru;
    }
    function getSup_pedidoitempesoliq(){
       return $this->sup_pedidoitempesoliq;
    }
    function setSup_pedidoitempesoliq($sup_pedidoitempesoliq){
       $this->sup_pedidoitempesoliq = $sup_pedidoitempesoliq;
    }
    function getSup_pedidoitemdimund(){
       return $this->sup_pedidoitemdimund;
    }
    function setSup_pedidoitemdimund($sup_pedidoitemdimund){
       $this->sup_pedidoitemdimund = $sup_pedidoitemdimund;
    }
    function getSup_pedidoitemdimconv(){
       return $this->sup_pedidoitemdimconv;
    }
    function setSup_pedidoitemdimconv($sup_pedidoitemdimconv){
       $this->sup_pedidoitemdimconv = $sup_pedidoitemdimconv;
    }
    function getSup_pedidoitemdimundconv(){
       return $this->sup_pedidoitemdimundconv;
    }
    function setSup_pedidoitemdimundconv($sup_pedidoitemdimundconv){
       $this->sup_pedidoitemdimundconv = $sup_pedidoitemdimundconv;
    }
    function getSup_pedidoitemvalorfrete(){
       return $this->sup_pedidoitemvalorfrete;
    }
    function setSup_pedidoitemvalorfrete($sup_pedidoitemvalorfrete){
       $this->sup_pedidoitemvalorfrete = $sup_pedidoitemvalorfrete;
    }
    function getSup_pedidoitemvalordespesa(){
       return $this->sup_pedidoitemvalordespesa;
    }
    function setSup_pedidoitemvalordespesa($sup_pedidoitemvalordespesa){
       $this->sup_pedidoitemvalordespesa = $sup_pedidoitemvalordespesa;
    }
    function getSup_pedidoitemvalorseguro(){
       return $this->sup_pedidoitemvalorseguro;
    }
    function setSup_pedidoitemvalorseguro($sup_pedidoitemvalorseguro){
       $this->sup_pedidoitemvalorseguro = $sup_pedidoitemvalorseguro;
    }
    function getSup_pedidoitemvalordesconto(){
       return $this->sup_pedidoitemvalordesconto;
    }
    function setSup_pedidoitemvalordesconto($sup_pedidoitemvalordesconto){
       $this->sup_pedidoitemvalordesconto = $sup_pedidoitemvalordesconto;
    }
    function getSup_pedidoitemvalortotal(){
       return $this->sup_pedidoitemvalortotal;
    }
    function setSup_pedidoitemvalortotal($sup_pedidoitemvalortotal){
       $this->sup_pedidoitemvalortotal = $sup_pedidoitemvalortotal;
    }
    function getSup_pedidoitemmargemtolvlr(){
       return $this->sup_pedidoitemmargemtolvlr;
    }
    function setSup_pedidoitemmargemtolvlr($sup_pedidoitemmargemtolvlr){
       $this->sup_pedidoitemmargemtolvlr = $sup_pedidoitemmargemtolvlr;
    }
    function getSup_pedidoitemtipodesconto(){
       return $this->sup_pedidoitemtipodesconto;
    }
    function setSup_pedidoitemtipodesconto($sup_pedidoitemtipodesconto){
       $this->sup_pedidoitemtipodesconto = $sup_pedidoitemtipodesconto;
    }
    function getSup_pedidoitemgrade(){
       return $this->sup_pedidoitemgrade;
    }
    function setSup_pedidoitemgrade($sup_pedidoitemgrade){
       $this->sup_pedidoitemgrade = $sup_pedidoitemgrade;
    }
    function getSup_pedidoitemtipodespesacodig(){
       return $this->sup_pedidoitemtipodespesacodig;
    }
    function setSup_pedidoitemtipodespesacodig($sup_pedidoitemtipodespesacodig){
       $this->sup_pedidoitemtipodespesacodig = $sup_pedidoitemtipodespesacodig;
    }
    function getSup_pedidoitemcentrocustocodig(){
       return $this->sup_pedidoitemcentrocustocodig;
    }
    function setSup_pedidoitemcentrocustocodig($sup_pedidoitemcentrocustocodig){
       $this->sup_pedidoitemcentrocustocodig = $sup_pedidoitemcentrocustocodig;
    }
    function getSup_pedidoitemplano(){
       return $this->sup_pedidoitemplano;
    }
    function setSup_pedidoitemplano($sup_pedidoitemplano){
       $this->sup_pedidoitemplano = $sup_pedidoitemplano;
    }
    function getSup_pedidoitemconta(){
       return $this->sup_pedidoitemconta;
    }
    function setSup_pedidoitemconta($sup_pedidoitemconta){
       $this->sup_pedidoitemconta = $sup_pedidoitemconta;
    }
    function getSup_pedidoitemprojeto(){
       return $this->sup_pedidoitemprojeto;
    }
    function setSup_pedidoitemprojeto($sup_pedidoitemprojeto){
       $this->sup_pedidoitemprojeto = $sup_pedidoitemprojeto;
    }
    function getSup_pedidoitemconversor(){
       return $this->sup_pedidoitemconversor;
    }
    function setSup_pedidoitemconversor($sup_pedidoitemconversor){
       $this->sup_pedidoitemconversor = $sup_pedidoitemconversor;
    }
    function getSup_pedidoitemmarca(){
       return $this->sup_pedidoitemmarca;
    }
    function setSup_pedidoitemmarca($sup_pedidoitemmarca){
       $this->sup_pedidoitemmarca = $sup_pedidoitemmarca;
    }
    function getSup_pedidoitemloteminimo(){
       return $this->sup_pedidoitemloteminimo;
    }
    function setSup_pedidoitemloteminimo($sup_pedidoitemloteminimo){
       $this->sup_pedidoitemloteminimo = $sup_pedidoitemloteminimo;
    }
    function getSup_pedidoitemlotemultiplo(){
       return $this->sup_pedidoitemlotemultiplo;
    }
    function setSup_pedidoitemlotemultiplo($sup_pedidoitemlotemultiplo){
       $this->sup_pedidoitemlotemultiplo = $sup_pedidoitemlotemultiplo;
    }
    function getSup_pedidoitemdimgqtd(){
       return $this->sup_pedidoitemdimgqtd;
    }
    function setSup_pedidoitemdimgqtd($sup_pedidoitemdimgqtd){
       $this->sup_pedidoitemdimgqtd = $sup_pedidoitemdimgqtd;
    }
    function getSup_pedidoitemdimgformula(){
       return $this->sup_pedidoitemdimgformula;
    }
    function setSup_pedidoitemdimgformula($sup_pedidoitemdimgformula){
       $this->sup_pedidoitemdimgformula = $sup_pedidoitemdimgformula;
    }
    function getSup_pedidoitemdimgexpres(){
       return $this->sup_pedidoitemdimgexpres;
    }
    function setSup_pedidoitemdimgexpres($sup_pedidoitemdimgexpres){
       $this->sup_pedidoitemdimgexpres = $sup_pedidoitemdimgexpres;
    }
    function getSup_pedidoitemseqaprovacao(){
       return $this->sup_pedidoitemseqaprovacao;
    }
    function setSup_pedidoitemseqaprovacao($sup_pedidoitemseqaprovacao){
       $this->sup_pedidoitemseqaprovacao = $sup_pedidoitemseqaprovacao;
    }
    function getSup_pedidoitemcomvalortabela(){
       return $this->sup_pedidoitemcomvalortabela;
    }
    function setSup_pedidoitemcomvalortabela($sup_pedidoitemcomvalortabela){
       $this->sup_pedidoitemcomvalortabela = $sup_pedidoitemcomvalortabela;
    }
    function getSup_pedidoitemlote(){
       return $this->sup_pedidoitemlote;
    }
    function setSup_pedidoitemlote($sup_pedidoitemlote){
       $this->sup_pedidoitemlote = $sup_pedidoitemlote;
    }
    function getSup_pedidoitemdataenvio(){
       return $this->sup_pedidoitemdataenvio;
    }
    function setSup_pedidoitemdataenvio($sup_pedidoitemdataenvio){
       $this->sup_pedidoitemdataenvio = $sup_pedidoitemdataenvio;
    }
    function getSup_pedidoitemencmandatahr(){
       return $this->sup_pedidoitemencmandatahr;
    }
    function setSup_pedidoitemencmandatahr($sup_pedidoitemencmandatahr){
       $this->sup_pedidoitemencmandatahr = $sup_pedidoitemencmandatahr;
    }
    function getSup_pedidoitemencmanusu(){
       return $this->sup_pedidoitemencmanusu;
    }
    function setSup_pedidoitemencmanusu($sup_pedidoitemencmanusu){
       $this->sup_pedidoitemencmanusu = $sup_pedidoitemencmanusu;
    }
    function getSup_pedidoitemencmanjus(){
       return $this->sup_pedidoitemencmanjus;
    }
    function setSup_pedidoitemencmanjus($sup_pedidoitemencmanjus){
       $this->sup_pedidoitemencmanjus = $sup_pedidoitemencmanjus;
    }
    function getSup_pedidoitemdimcalc(){
       return $this->sup_pedidoitemdimcalc;
    }
    function setSup_pedidoitemdimcalc($sup_pedidoitemdimcalc){
       $this->sup_pedidoitemdimcalc = $sup_pedidoitemdimcalc;
    }
    function getSup_pedidoitemdataultupd(){
       return $this->sup_pedidoitemdataultupd;
    }
    function setSup_pedidoitemdataultupd($sup_pedidoitemdataultupd){
       $this->sup_pedidoitemdataultupd = $sup_pedidoitemdataultupd;
    }
    function getSup_pedidoitemimportado(){
       return $this->sup_pedidoitemimportado;
    }
    function setSup_pedidoitemimportado($sup_pedidoitemimportado){
       $this->sup_pedidoitemimportado = $sup_pedidoitemimportado;
    }
    function getSup_pedidoitemvaloracrescimo(){
       return $this->sup_pedidoitemvaloracrescimo;
    }
    function setSup_pedidoitemvaloracrescimo($sup_pedidoitemvaloracrescimo){
       $this->sup_pedidoitemvaloracrescimo = $sup_pedidoitemvaloracrescimo;
    }
    function getSup_pedidoitemcontrato(){
       return $this->sup_pedidoitemcontrato;
    }
    function setSup_pedidoitemcontrato($sup_pedidoitemcontrato){
       $this->sup_pedidoitemcontrato = $sup_pedidoitemcontrato;
    }
    function getSup_pedidoitemdataaprverba(){
       return $this->sup_pedidoitemdataaprverba;
    }
    function setSup_pedidoitemdataaprverba($sup_pedidoitemdataaprverba){
       $this->sup_pedidoitemdataaprverba = $sup_pedidoitemdataaprverba;
    }
    function getSup_pedidoitemcontratoseq(){
       return $this->sup_pedidoitemcontratoseq;
    }
    function setSup_pedidoitemcontratoseq($sup_pedidoitemcontratoseq){
       $this->sup_pedidoitemcontratoseq = $sup_pedidoitemcontratoseq;
    }
}