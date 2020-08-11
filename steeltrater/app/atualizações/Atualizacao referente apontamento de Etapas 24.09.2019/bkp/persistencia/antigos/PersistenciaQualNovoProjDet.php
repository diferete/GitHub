<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualNovoProjDet extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbqualNovoProjeto');
        
        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc',true,true);
        $this->adicionaRelacionamento('nr', 'nr',true,true,true);
        
        $this->adicionaRelacionamento('desenho_prev','desenho_prev');
        $this->adicionaRelacionamento('desenho_ter', 'desenho_ter');
        $this->adicionaRelacionamento('desenho_resp', 'desenho_resp');
        
        $this->adicionaRelacionamento('etapasfab_prev','etapasfab_prev');
        $this->adicionaRelacionamento('etapasfab_ter','etapasfab_ter');
        $this->adicionaRelacionamento('etapas_resp','etapas_resp');
        
        $this->adicionaRelacionamento('relFerr_prev','relFerr_prev');
        $this->adicionaRelacionamento('relFerr_ter','relFerr_ter');
        $this->adicionaRelacionamento('relFerr_resp','relFerr_resp');
        
        $this->adicionaRelacionamento('relFerrDesen_prev','relFerrDesen_prev');
        $this->adicionaRelacionamento('relFerrDesen_ter','relFerrDesen_ter');
        $this->adicionaRelacionamento('relFerrDesen_resp','relFerrDesen_resp');
        
        $this->adicionaRelacionamento('relFerrDist_prev', 'relFerrDist_prev');
        $this->adicionaRelacionamento('relFerrDist_ter', 'relFerrDist_ter');
        $this->adicionaRelacionamento('relFerrDist_resp', 'relFerrDist_resp');
        
        $this->adicionaRelacionamento('relFerrConf_prev', 'relFerrConf_prev');
        $this->adicionaRelacionamento('relFerrConf_ter', 'relFerrConf_ter');
        $this->adicionaRelacionamento('relFerrConf_resp', 'relFerrConf_resp');
        
        $this->adicionaRelacionamento('ferrElaboradas','ferrElaboradas');
        $this->adicionaRelacionamento('desenAcordo','desenAcordo');
        $this->adicionaRelacionamento('respAnaliseCri','respAnaliseCri');
        $this->adicionaRelacionamento('comenCrit','comenCrit');
        
     
        
       
    }
}