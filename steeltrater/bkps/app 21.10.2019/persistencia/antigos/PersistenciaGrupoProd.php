<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaGrupoProd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.prod04');
        
        $this->adicionaRelacionamento('grucod','grucod',true);
        $this->adicionaRelacionamento('grudes', 'grudes');
        $this->adicionaRelacionamento('grutipo', 'grutipo');
        
        $this->adicionaOrderBy('grucod',1);
        $this->setSTop('25');
        
        if(isset($_SESSION['grupoprod'])){
            $aGrupo = explode(',', $_SESSION['grupoprod']);
           
            $this->adicionaFiltro('grucod', $aGrupo[0], Persistencia::LIGACAO_AND, Persistencia::ENTRE,$aGrupo[1]);
        }
        
    }
}