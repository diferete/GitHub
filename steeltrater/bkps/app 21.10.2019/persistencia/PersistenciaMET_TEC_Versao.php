<?php

/*
 * Classe que gerencia a Persistena da VersaoSistema
 * @author: Alexandre W. de Souza
 * @since: 15/09/2017
 *  
 */

class PersistenciaMET_TEC_Versao extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_versao');

        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('tec', 'tec');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('versao', 'versao');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('descricao', 'descricao');
        $this->adicionaRelacionamento('equipe', 'equipe');

        $this->adicionaOrderBy('seq', 1);
    }
    
        /*Funçao para mostrar a versão sistema na ViewSistema*/
    public function mostrVersaoSistema (){
        $sSql = "select versao from MET_TEC_versao where seq = (select MAX(seq) as seq from MET_TEC_versao)";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sVersao = $oRow->versao;
        
        return $sVersao;
        
        
        
    }

}
