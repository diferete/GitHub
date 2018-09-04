<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class PersistenciaMET_ServicoMaquina extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbservmp');
        
        $this->adicionaRelacionamento('codsit','codsit',true,true, true);
        $this->adicionaRelacionamento('tipcod', 'tipcod');
        $this->adicionaRelacionamento('servico', 'servico');
        $this->adicionaRelacionamento('ciclo','ciclo');
        $this->adicionaRelacionamento('resp','resp');
        $this->adicionaRelacionamento('usercad','usercad');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        
        $this->adicionaOrderBy('codsit',0);
        
    }
}
