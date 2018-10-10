<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_ordensFabLista
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class PersistenciaSTEEL_PCP_ordensFabListaPesq extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFabLista');

        $this->adicionaRelacionamento('nr', 'nr',true,true,true);
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('op','STEEL_PCP_ordensFab.op');
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('fornocod', 'fornocod');
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('dataEntForno', 'dataEntForno');
        $this->adicionaRelacionamento('horaEntForno','horaEntForno');
        $this->adicionaRelacionamento('seqApont','seqApont');
        $this->adicionaRelacionamento('tempforno','tempforno');
        $this->adicionaRelacionamento('prioridade', 'prioridade');
        

        $this->setSTop('1000');
        $this->adicionaOrderBy('prioridade', 1);
        $this->adicionaFiltro('situacao','Liberado');
        $this->adicionaJoin('STEEL_PCP_ordensFab');
        
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $this->adicionaFiltro('fornocod',$aCamposChave['fornocod']);
    }
    
   
}

