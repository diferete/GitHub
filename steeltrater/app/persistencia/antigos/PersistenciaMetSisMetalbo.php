<?php

class PersistenciaMetSisMetalbo extends Persistencia {

    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MetCad_User');

        $this->adicionaRelacionamento('coduser', 'coduser',true,true,true);
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('sobrenome', 'sobrenome');
    }

}
