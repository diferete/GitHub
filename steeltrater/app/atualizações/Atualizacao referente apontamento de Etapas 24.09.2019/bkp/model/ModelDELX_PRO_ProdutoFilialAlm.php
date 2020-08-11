<?php

/*
 * Classe que implementa os models da DELX_PRO_ProdutoFilialAlm
 * 
 * @author Cleverton Hoffmann
 * @since 21/09/2018
 */

class ModelDELX_PRO_ProdutoFilialAlm {

    private $pro_codigo;
    private $fil_codigo;
    private $pro_filialAlmTipo;
    private $pro_filialAlmCodigo;
    private $pro_filialAlmEstoqueMin;
    private $pro_filialAlmEstoqueMax;
    private $DELX_PRO_Produtos;
    private $DELX_FIL_Empresa;
    
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
    
    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function getPro_filialAlmTipo() {
        return $this->pro_filialAlmTipo;
    }

    function getPro_filialAlmCodigo() {
        return $this->pro_filialAlmCodigo;
    }

    function getPro_filialAlmEstoqueMin() {
        return $this->pro_filialAlmEstoqueMin;
    }

    function getPro_filialAlmEstoqueMax() {
        return $this->pro_filialAlmEstoqueMax;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }

    function setPro_filialAlmTipo($pro_filialAlmTipo) {
        $this->pro_filialAlmTipo = $pro_filialAlmTipo;
    }

    function setPro_filialAlmCodigo($pro_filialAlmCodigo) {
        $this->pro_filialAlmCodigo = $pro_filialAlmCodigo;
    }

    function setPro_filialAlmEstoqueMin($pro_filialAlmEstoqueMin) {
        $this->pro_filialAlmEstoqueMin = $pro_filialAlmEstoqueMin;
    }

    function setPro_filialAlmEstoqueMax($pro_filialAlmEstoqueMax) {
        $this->pro_filialAlmEstoqueMax = $pro_filialAlmEstoqueMax;
    }
    
}