<?php

/* 
 * Classe que implementa a persistencia de DELX_PRO_ProdutoFilialAlm
 * 
 * @author Cleverton Hoffmann
 * @since 21/09/2018
 */

class PersistenciaDELX_PRO_ProdutoFilialAlm extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_PRODUTOFILIALALM');
       
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true);  
        $this->adicionaRelacionamento('pro_codigo', 'DELX_PRO_Produtos.pro_codigo');
        
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo',true);  
        $this->adicionaRelacionamento('fil_codigo', 'DELX_FIL_Empresa.fil_codigo');  
        
        $this->adicionaRelacionamento('pro_filialAlmTipo', 'pro_filialAlmTipo',true);
        $this->adicionaRelacionamento('pro_filialAlmCodigo','pro_filialAlmCodigo');
        $this->adicionaRelacionamento('pro_filialAlmEstoqueMin','pro_filialAlmEstoqueMin');
        $this->adicionaRelacionamento('pro_filialAlmEstoqueMax','pro_filialAlmEstoqueMax');
        
        $this->setSTop('100');                      
        $this->adicionaOrderBy('pro_codigo', 0);
        $this->adicionaJoin('DELX_PRO_Produtos');
        $this->adicionaJoin('DELX_FIL_Empresa');
    }
}