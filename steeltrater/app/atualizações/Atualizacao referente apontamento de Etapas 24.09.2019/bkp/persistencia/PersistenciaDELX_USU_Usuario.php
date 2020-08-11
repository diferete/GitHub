<?php

/*
 * Implementa persistencia da classe DELX_USU_Usuario
 * @author Alexandre W. de Souza
 * @since 18-10-2018
 * *** */

class PersistenciaDELX_USU_Usuario extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('USU_USUARIO');

        
        $this->adicionaRelacionamento('usu_empcodigo', 'usu_empcodigo');
        $this->adicionaRelacionamento('usu_codigo', 'usu_codigo',true,true);
        $this->adicionaRelacionamento('usu_nome', 'usu_nome',true,true);
        $this->adicionaRelacionamento('usu_senha', 'usu_senha');
        $this->adicionaRelacionamento('usu_status', 'usu_status');
        $this->adicionaRelacionamento('usu_logasistema', 'usu_logasistema');

    }

}
