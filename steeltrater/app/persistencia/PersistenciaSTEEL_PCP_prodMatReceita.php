<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class PersistenciaSTEEL_PCP_prodMatReceita extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_prodMatReceita');

        $this->adicionaRelacionamento('seqmat', 'seqmat', true, true, true);
        $this->adicionaRelacionamento('prod', 'DELX_PRO_Produtos.pro_codigo', false,false);
        $this->adicionaRelacionamento('prod', 'prod');
        $this->adicionaRelacionamento('matcod', 'matcod');
        $this->adicionaRelacionamento('matcod', 'STEEL_PCP_material.matcod', false,false);
        $this->adicionaRelacionamento('cod', 'cod');
        $this->adicionaRelacionamento('matcod', 'STEEL_PCP_receitas.cod', false,false);
        $this->adicionaRelacionamento('durezaNucMin', 'durezaNucMin');
        $this->adicionaRelacionamento('durezaNucMax', 'durezaNucMax');
        $this->adicionaRelacionamento('NucEscala', 'NucEscala');//NucEscala
        
        $this->adicionaRelacionamento('durezaSuperfMin', 'durezaSuperfMin');
        $this->adicionaRelacionamento('durezaSuperfMax', 'durezaSuperfMax');
        $this->adicionaRelacionamento('SuperEscala', 'SuperEscala');//SuperEscala
        $this->adicionaRelacionamento('expCamadaMin', 'expCamadaMin');
        $this->adicionaRelacionamento('expCamadaMax', 'expCamadaMax');
        
        $this->adicionaRelacionamento('tratrevencomp', 'tratrevencomp');
        
        $this->adicionaRelacionamento('fioDurezaSol', 'fioDurezaSol');
        $this->adicionaRelacionamento('fioEsferio', 'fioEsferio');
        $this->adicionaRelacionamento('fioDescarbonetaTotal', 'fioDescarbonetaTotal');
        $this->adicionaRelacionamento('fioDescarbonetaParcial', 'fioDescarbonetaParcial');
        $this->adicionaRelacionamento('DiamFinalMin', 'DiamFinalMin');
        $this->adicionaRelacionamento('DiamFinalMax', 'DiamFinalMax');
        
        $this->adicionaRelacionamento('ppap', 'ppap');
        
        $this->adicionaRelacionamento('nrppap','nrppap');
        
        $this->setSTop('10');
        $this->adicionaOrderBy('seqmat', 1);
        $this->adicionaJoin('DELX_PRO_Produtos', null,1, 'prod','pro_codigo');
        $this->adicionaJoin('STEEL_PCP_material');
        $this->adicionaJoin('STEEL_PCP_receitas');
        
    }

}