<?php

/*
 * Classe que implementa a persistencia de DELX_EST_Almoxarifado
 * 
 * @author Cleverton Hoffmann
 * @since 23/10/2018
 */

class PersistenciaDELX_EST_Almoxarifado extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('EST_ALMOXARIFADO');

        $this->adicionaRelacionamento('est_almoxarifadocodigo', 'est_almoxarifadocodigo',true, true);
        $this->adicionaRelacionamento('est_almoxarifadodescricao', 'est_almoxarifadodescricao');
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('est_almoxarifadocodigo', 0);
    }

}
