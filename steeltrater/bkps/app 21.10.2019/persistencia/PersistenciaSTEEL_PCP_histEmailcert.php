<?php

/* 
 * Gerencia o histório de envio de e-mail 
 * 
 * @since 13/10/2018
 * @author Avanei Martendal
 */

class PersistenciaSTEEL_PCP_histEmailcert extends Persistencia{
    public function __construct() {
        parent::__construct();
        $this->setTabela('STEEL_PCP_histEmailcert');
        
        $this->adicionaRelacionamento('id', 'id',true,true,true);
        $this->adicionaRelacionamento('nrcert', 'nrcert');
        $this->adicionaRelacionamento('userEmail', 'userEmail');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');  
        $this->adicionaRelacionamento('destinatario', 'destinatario');
        $this->adicionaRelacionamento('sitenv', 'sitenv');
                
        $this->adicionaOrderBy('id',1);
        /*  create table STEEL_PCP_histEmailcert(
       id integer,
       nrcert integer,
	   userEmail varchar(80),
	   data date,
	   hora time,
	   destinatario varchar(1000),
	   sitenv varchar(80)
  )	
  )	*/
    }
    
    
}

