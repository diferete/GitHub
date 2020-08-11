<?php

/* 
 * Classe que implementa a persistencia de DELX_PRO_ProdutoFilialAlm
 * 
 * @author Cleverton Hoffmann
 * @since 21/09/2018
 */

class PersistenciaDELX_PRO_ProdutoFilialAlmTipo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('EST_ALMOXARIFADO');
       
        $this->adicionaRelacionamento('est_almoxarifadocodigo', 'est_almoxarifadocodigo',true, true, true);
        $this->adicionaRelacionamento('est_almoxarifadodescricao', 'est_almoxarifadodescricao');  
        $this->adicionaRelacionamento('est_almoxarifadosigla', 'est_almoxarifadosigla');  
        $this->adicionaRelacionamento('est_almoxarifadotipo', 'est_almoxarifadotipo');  
        
        $this->setSTop('100');                      
        $this->adicionaOrderBy('est_almoxarifadocodigo', 0);
     
    }
}