<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaPedRepIten extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.pedv01');
        
        $this->adicionaRelacionamento('filcgc','filcgc');
        $this->adicionaRelacionamento('pdvnro', 'pdvnro',true,true,true);         
        $this->adicionaRelacionamento('pdvproseq', 'pdvproseq');        
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('pdvprodes', 'pdvprodes');
        $this->adicionaRelacionamento('pdvproqtdp', 'pdvproqtdp');
        $this->adicionaRelacionamento('pdvprovlta', 'pdvprovlta');
        $this->adicionaRelacionamento('pdvproqtdf', 'pdvproqtdf');
        $this->adicionaRelacionamento('total', 'total');
        $this->adicionaRelacionamento('totalfat', 'totalfat');
        $this->adicionaRelacionamento('pdvproobs', 'pdvproobs');
        
        $this->setBConsultaManual(true);
    }
    
    public function consultaManual() {
        parent::consultaManual();
        
        $sSql =  "select widl.PEDV01.filcgc as 'widl.PEDV01.filcgc',
                 widl.PEDV01.pdvnro as 'widl.PEDV01.pdvnro',
                 widl.PEDV01.pdvproseq as 'widl.PEDV01.pdvproseq',
                 widl.PEDV01.procod as 'widl.PEDV01.procod',
		 widl.PEDV01.pdvprodes as 'widl.PEDV01.pdvprodes',
		 widl.PEDV01.pdvproqtdp as 'widl.PEDV01.pdvproqtdp',
		 widl.PEDV01.pdvprovlta as 'widl.PEDV01.pdvprovlta',
         widl.PEDV01.pdvproqtdf, (pdvproqtdp * pdvprovlta) AS 'widl.PEDV01.total',
         (pdvproqtdf * pdvprovlta)as 'widl.PEDV01.totalfat',
         widl.PEDV01.pdvproobs as 'widl.PEDV01.pdvproobs'
         from widl.PEDV01(nolock) ";
        
        return $sSql;
    }
}