<?php

/* 
 * Classe que implementa a persistencia de atividade economica
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class PersistenciaDELX_ATI_AtividadeEconomica extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('ATI_ATIVIDADEECONOMICA');
        
        $this->adicionaRelacionamento('ati_codigo','ati_codigo',true,true);
        $this->adicionaRelacionamento('ati_descricao','ati_descricao');
        $this->adicionaRelacionamento('ati_atividadeeconomicacodclass', 'ati_atividadeeconomicacodclass');
        
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('ati_codigo', 0);
        
    }
}


