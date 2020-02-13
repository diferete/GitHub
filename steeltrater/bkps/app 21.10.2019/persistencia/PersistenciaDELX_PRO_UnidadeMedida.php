<?php

/*
 * Classe que implementa a persistencia de Unidade Medida
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class PersistenciaDELX_PRO_UnidadeMedida extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_UNIDADEMEDIDA');

        $this->adicionaRelacionamento('pro_unidademedida', 'pro_unidademedida', true, true);
        $this->adicionaRelacionamento('pro_unidademedidadescricao', 'pro_unidademedidadescricao');
        $this->adicionaRelacionamento('pro_unidademedidarf', 'pro_unidademedidarf');
        $this->adicionaRelacionamento('pro_unidademedidamercosul', 'pro_unidademedidamercosul');
        $this->adicionaRelacionamento('pro_unidademedidatipocalc', 'pro_unidademedidatipocalc');
        $this->adicionaRelacionamento('pro_unidademedidacasasdec', 'pro_unidademedidacasasdec');
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('pro_unidademedida', 0);
    }

}
