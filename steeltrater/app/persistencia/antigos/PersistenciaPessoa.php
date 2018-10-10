<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaPessoa extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.emp01');
        
        $this->adicionaRelacionamento('empcod', 'empcod',TRUE);
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('empativo', 'empativo');
        $this->adicionaRelacionamento('cidcep', 'Cidcep.cidcep');
        $this->adicionaRelacionamento('empcnpj', 'empcnpj');
        $this->adicionaRelacionamento('empfant', 'empfant');
        $this->adicionaRelacionamento('empfone', 'empfone');
        $this->adicionaRelacionamento('empinterne','empinterne');
        $this->adicionaRelacionamento('empend', 'empend');
        $this->adicionaRelacionamento('empendbair','empendbair');
        $this->adicionaRelacionamento('empins', 'empins');
        $this->adicionaRelacionamento('empobs', 'empobs');
        $this->adicionaRelacionamento('empausucad', 'empausucad');
        $this->adicionaRelacionamento('empadtcad','empadtcad');
        $this->adicionaRelacionamento('repcod', 'repcod');
        $this->adicionaRelacionamento('emptr', 'emptr');
        $this->adicionaRelacionamento('empsit', 'empsit');
        $this->adicionaRelacionamento('empblocred', 'empblocred');
        
        $this->setSTop('25');
        $this->adicionaOrderBy('empcod',1);
        $this->adicionaJoin('Cidcep',null, 1,'cidcep','cidcep');
        $this->adicionaFiltro('empsit', 'B', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);
        
        if(isset($_SESSION['repsoffice'])){
            $aValor = explode(',', $_SESSION['repsoffice']);
            
            if($aValor[0]!==''){
              $this->adicionaFiltro('repcod',$aValor,0,9);
            }
        }
        
        
    }
    
    
}