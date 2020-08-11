<?php

/*
 * Classe que implementa os models da STEEL_PCP_ProdutoFilial
 * 
 * @author Cleverton Hoffmann
 * @since 15/02/2019
 */

class ModelSTEEL_PCP_ProdutoFilial{

    
   
    //Inf. Gerais
    private $pro_produtofilialgrupotipo;
    private $fil_codigo;
    private $pro_codigo;
    private $DELX_FIL_Empresa;
    private $DELX_PRO_Produtos;
    private $pro_filialdtbloqueado;
    private $pro_filialmotivobloqueio;
    private $pro_filialestoque;
    private $pro_filialnegativo;
    private $pro_filialestminimo; 
    private $pro_filialestminimodias;
    private $pro_filialestpontorep;
    private $pro_filialestmaximo;
    private $pro_filialestmaximodias; 
    private $pro_filialdtinventariorota;
    private $pro_filialitemcomposto; 
    private $pro_filialcontrolasaldo;
    private $pro_filialreservaestoqueestrut;
    private $pro_filialquantidademultpadrao;
    private $pro_filialqtdprodutividade;
    private $pro_filialveiculo;
    
    //Compras
    private $pro_filialprioridade;
    private $pro_filialcomprador;
    private $pro_filialcomprapercdifvalor;
    private $pro_filialcomprapercdifqtd;
    
    //MRP
    private $pro_filialmrpplanejamento;
    private $pro_filialmrptipoordem;
    private $pro_filialmrpdiascompra;
    private $pro_filialmrpdiasproducao;
    private $pro_filialmrpdiasqualidade;
    private $pro_filialmrpdiasfornecedor;
    private $pro_filialestminimotipo; 
    private $pro_filialestminimoperiodo;
    private $pro_filialmrploteminimoqtd;
    private $pro_filialmrplotemultiploqtd;
    private $pro_filialmrpdiasagrupamento;
    private $pro_filialloteproducaoqtd;
    private $pro_filialmrpacao;
    private $pro_filialmrpfilial;
    
    //FINAME
    private $pro_filialcodigofiname;
    private $pro_filialdescricaofiname;
    
    //ContNserie
    private $pro_filialreferenciaserie;
        
    //EspeciePadNotaFiscal
    private $pro_filialespeciepadrao;
    private $pro_filialespeciecapacidade; 
    
    //Fechamento de Estoque
    private $pro_filialpercustocoproduto;
    private $pro_filialconsqtdeprodcoprodut;
    
    private $pro_filialinvrotativodata;
    
    private $pro_filialreferenciaseriefilia;
    
    function getPro_filialreferenciaseriefilia() {
        return $this->pro_filialreferenciaseriefilia;
    }

    function setPro_filialreferenciaseriefilia($pro_filialreferenciaseriefilia) {
        $this->pro_filialreferenciaseriefilia = $pro_filialreferenciaseriefilia;
    }

        
    function getPro_filialinvrotativodata() {
        return $this->pro_filialinvrotativodata;
    }

    function setPro_filialinvrotativodata($pro_filialinvrotativodata) {
        $this->pro_filialinvrotativodata = $pro_filialinvrotativodata;
    }

        
    function getPro_filialconsqtdeprodcoprodut() {
        return $this->pro_filialconsqtdeprodcoprodut;
    }

    function setPro_filialconsqtdeprodcoprodut($pro_filialconsqtdeprodcoprodut) {
        $this->pro_filialconsqtdeprodcoprodut = $pro_filialconsqtdeprodcoprodut;
    }
    
    function getPro_filialpercustocoproduto(){
        return $this->pro_filialpercustocoproduto;
    }
    
    function setPro_filialpercustocoproduto($pro_filialpercustocoproduto) {
        $this->pro_filialpercustocoproduto = $pro_filialpercustocoproduto;
    }
    
    function getPro_filialprioridade() {
        return $this->pro_filialprioridade;
    }

    function getPro_filialcomprador() {
        return $this->pro_filialcomprador;
    }

    function getPro_filialcomprapercdifvalor() {
        return $this->pro_filialcomprapercdifvalor;
    }

    function getPro_filialcomprapercdifqtd() {
        return $this->pro_filialcomprapercdifqtd;
    }

    function getPro_filialmrpplanejamento() {
        return $this->pro_filialmrpplanejamento;
    }

    function getPro_filialmrptipoordem() {
        return $this->pro_filialmrptipoordem;
    }

    function getPro_filialmrpdiascompra() {
        return $this->pro_filialmrpdiascompra;
    }

    function getPro_filialmrpdiasproducao() {
        return $this->pro_filialmrpdiasproducao;
    }

    function getPro_filialmrpdiasqualidade() {
        return $this->pro_filialmrpdiasqualidade;
    }

    function getPro_filialmrpdiasfornecedor() {
        return $this->pro_filialmrpdiasfornecedor;
    }

    function getPro_filialestminimotipo() {
        return $this->pro_filialestminimotipo;
    }

    function getPro_filialestminimoperiodo() {
        return $this->pro_filialestminimoperiodo;
    }

    function getPro_filialmrploteminimoqtd() {
        return $this->pro_filialmrploteminimoqtd;
    }

    function getPro_filialmrplotemultiploqtd() {
        return $this->pro_filialmrplotemultiploqtd;
    }

    function getPro_filialmrpdiasagrupamento() {
        return $this->pro_filialmrpdiasagrupamento;
    }

    function getPro_filialloteproducaoqtd() {
        return $this->pro_filialloteproducaoqtd;
    }

    function getPro_filialmrpacao() {
        return $this->pro_filialmrpacao;
    }

    function getPro_filialmrpfilial() {
        return $this->pro_filialmrpfilial;
    }

    function getPro_filialcodigofiname() {
        return $this->pro_filialcodigofiname;
    }

    function getPro_filialdescricaofiname() {
        return $this->pro_filialdescricaofiname;
    }

    function getPro_filialreferenciaserie() {
        return $this->pro_filialreferenciaserie;
    }

    function getPro_filialespeciepadrao() {
        return $this->pro_filialespeciepadrao;
    }

    function getPro_filialespeciecapacidade() {
        return $this->pro_filialespeciecapacidade;
    }

    function setPro_filialprioridade($pro_filialprioridade) {
        $this->pro_filialprioridade = $pro_filialprioridade;
    }

    function setPro_filialcomprador($pro_filialcomprador) {
        $this->pro_filialcomprador = $pro_filialcomprador;
    }

    function setPro_filialcomprapercdifvalor($pro_filialcomprapercdifvalor) {
        $this->pro_filialcomprapercdifvalor = $pro_filialcomprapercdifvalor;
    }

    function setPro_filialcomprapercdifqtd($pro_filialcomprapercdifqtd) {
        $this->pro_filialcomprapercdifqtd = $pro_filialcomprapercdifqtd;
    }

    function setPro_filialmrpplanejamento($pro_filialmrpplanejamento) {
        $this->pro_filialmrpplanejamento = $pro_filialmrpplanejamento;
    }

    function setPro_filialmrptipoordem($pro_filialmrptipoordem) {
        $this->pro_filialmrptipoordem = $pro_filialmrptipoordem;
    }

    function setPro_filialmrpdiascompra($pro_filialmrpdiascompra) {
        $this->pro_filialmrpdiascompra = $pro_filialmrpdiascompra;
    }

    function setPro_filialmrpdiasproducao($pro_filialmrpdiasproducao) {
        $this->pro_filialmrpdiasproducao = $pro_filialmrpdiasproducao;
    }

    function setPro_filialmrpdiasqualidade($pro_filialmrpdiasqualidade) {
        $this->pro_filialmrpdiasqualidade = $pro_filialmrpdiasqualidade;
    }

    function setPro_filialmrpdiasfornecedor($pro_filialmrpdiasfornecedor) {
        $this->pro_filialmrpdiasfornecedor = $pro_filialmrpdiasfornecedor;
    }

    function setPro_filialestminimotipo($pro_filialestminimotipo) {
        $this->pro_filialestminimotipo = $pro_filialestminimotipo;
    }

    function setPro_filialestminimoperiodo($pro_filialestminimoperiodo) {
        $this->pro_filialestminimoperiodo = $pro_filialestminimoperiodo;
    }

    function setPro_filialmrploteminimoqtd($pro_filialmrploteminimoqtd) {
        $this->pro_filialmrploteminimoqtd = $pro_filialmrploteminimoqtd;
    }

    function setPro_filialmrplotemultiploqtd($pro_filialmrplotemultiploqtd) {
        $this->pro_filialmrplotemultiploqtd = $pro_filialmrplotemultiploqtd;
    }

    function setPro_filialmrpdiasagrupamento($pro_filialmrpdiasagrupamento) {
        $this->pro_filialmrpdiasagrupamento = $pro_filialmrpdiasagrupamento;
    }

    function setPro_filialloteproducaoqtd($pro_filialloteproducaoqtd) {
        $this->pro_filialloteproducaoqtd = $pro_filialloteproducaoqtd;
    }

    function setPro_filialmrpacao($pro_filialmrpacao) {
        $this->pro_filialmrpacao = $pro_filialmrpacao;
    }

    function setPro_filialmrpfilial($pro_filialmrpfilial) {
        $this->pro_filialmrpfilial = $pro_filialmrpfilial;
    }

    function setPro_filialcodigofiname($pro_filialcodigofiname) {
        $this->pro_filialcodigofiname = $pro_filialcodigofiname;
    }

    function setPro_filialdescricaofiname($pro_filialdescricaofiname) {
        $this->pro_filialdescricaofiname = $pro_filialdescricaofiname;
    }

    function setPro_filialreferenciaserie($pro_filialreferenciaserie) {
        $this->pro_filialreferenciaserie = $pro_filialreferenciaserie;
    }

    function setPro_filialespeciepadrao($pro_filialespeciepadrao) {
        $this->pro_filialespeciepadrao = $pro_filialespeciepadrao;
    }

    function setPro_filialespeciecapacidade($pro_filialespeciecapacidade) {
        $this->pro_filialespeciecapacidade = $pro_filialespeciecapacidade;
    }    
    
    function getPro_filialestminimo() {
        return $this->pro_filialestminimo;
    }

    function getPro_filialestminimodias() {
        return $this->pro_filialestminimodias;
    }

    function getPro_filialestpontorep() {
        return $this->pro_filialestpontorep;
    }

    function getPro_filialestmaximo() {
        return $this->pro_filialestmaximo;
    }

    function getPro_filialestmaximodias() {
        return $this->pro_filialestmaximodias;
    }

    function getPro_filialdtinventariorota() {
        return $this->pro_filialdtinventariorota;
    }

    function getPro_filialquantidademultpadrao() {
        return $this->pro_filialquantidademultpadrao;
    }

    function getPro_filialqtdprodutividade() {
        return $this->pro_filialqtdprodutividade;
    }

    function getPro_filialveiculo() {
        return $this->pro_filialveiculo;
    }

    function setPro_filialestminimo($pro_filialestminimo) {
        $this->pro_filialestminimo = $pro_filialestminimo;
    }

    function setPro_filialestminimodias($pro_filialestminimodias) {
        $this->pro_filialestminimodias = $pro_filialestminimodias;
    }

    function setPro_filialestpontorep($pro_filialestpontorep) {
        $this->pro_filialestpontorep = $pro_filialestpontorep;
    }

    function setPro_filialestmaximo($pro_filialestmaximo) {
        $this->pro_filialestmaximo = $pro_filialestmaximo;
    }

    function setPro_filialestmaximodias($pro_filialestmaximodias) {
        $this->pro_filialestmaximodias = $pro_filialestmaximodias;
    }

    function setPro_filialdtinventariorota($pro_filialdtinventariorota) {
        $this->pro_filialdtinventariorota = $pro_filialdtinventariorota;
    }

    function setPro_filialquantidademultpadrao($pro_filialquantidademultpadrao) {
        $this->pro_filialquantidademultpadrao = $pro_filialquantidademultpadrao;
    }

    function setPro_filialqtdprodutividade($pro_filialqtdprodutividade) {
        $this->pro_filialqtdprodutividade = $pro_filialqtdprodutividade;
    }

    function setPro_filialveiculo($pro_filialveiculo) {
        $this->pro_filialveiculo = $pro_filialveiculo;
    }
   
    function getPro_filialnegativo() {
        return $this->pro_filialnegativo;
    }

    function setPro_filialnegativo($pro_filialnegativo) {
        $this->pro_filialnegativo = $pro_filialnegativo;
    }
 
    function getPro_filialmotivobloqueio() {
        return $this->pro_filialmotivobloqueio;
    }

    function setPro_filialmotivobloqueio($pro_filialmotivobloqueio) {
        $this->pro_filialmotivobloqueio = $pro_filialmotivobloqueio;
    }   
    
    function getPro_produtofilialgrupotipo() {
        return $this->pro_produtofilialgrupotipo;
    }

    function setPro_produtofilialgrupotipo($pro_produtofilialgrupotipo) {
        $this->pro_produtofilialgrupotipo = $pro_produtofilialgrupotipo;
    }
    
    function getPro_filialdtbloqueado() {
        return $this->pro_filialdtbloqueado;
    }

    function getPro_filialestoque() {
        return $this->pro_filialestoque;
    }

    function getPro_filialitemcomposto() {
        return $this->pro_filialitemcomposto;
    }

    function getPro_filialcontrolasaldo() {
        return $this->pro_filialcontrolasaldo;
    }

    function getPro_filialreservaestoqueestrut() {
        return $this->pro_filialreservaestoqueestrut;
    }

    function setPro_filialdtbloqueado($pro_filialdtbloqueado) {
        $this->pro_filialdtbloqueado = $pro_filialdtbloqueado;
    }

    function setPro_filialestoque($pro_filialestoque) {
        $this->pro_filialestoque = $pro_filialestoque;
    }

    function setPro_filialitemcomposto($pro_filialitemcomposto) {
        $this->pro_filialitemcomposto = $pro_filialitemcomposto;
    }

    function setPro_filialcontrolasaldo($pro_filialcontrolasaldo) {
        $this->pro_filialcontrolasaldo = $pro_filialcontrolasaldo;
    }

    function setPro_filialreservaestoqueestrut($pro_filialreservaestoqueestrut) {
        $this->pro_filialreservaestoqueestrut = $pro_filialreservaestoqueestrut;
    }

           
    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function getDELX_FIL_Empresa() {
        if(!isset($this->DELX_FIL_Empresa)){
            $this->DELX_FIL_Empresa = Fabrica::FabricarModel('DELX_FIL_Empresa');
        }
        return $this->DELX_FIL_Empresa;
    }

    function setDELX_FIL_Empresa($DELX_FIL_Empresa) {
        $this->DELX_FIL_Empresa = $DELX_FIL_Empresa;
    }
    
    function getDELX_PRO_Produtos() {
        if(!isset($this->DELX_PRO_Produtos)){
            $this->DELX_PRO_Produtos = Fabrica::FabricarModel('DELX_PRO_Produtos');
        }
        return $this->DELX_PRO_Produtos;
    }

    function setDELX_PRO_Produtos($DELX_PRO_Produtos) {
        $this->DELX_PRO_Produtos = $DELX_PRO_Produtos;
    }
    
}