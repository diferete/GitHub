<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_ordensFabApontSaida
 * 
 * @author Cleverton Hoffmann
 * @since 25/07/2018
 */

class PersistenciaSTEEL_PCP_ordensFabApontSaida extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFabApont');

        $this->adicionaRelacionamento('op', 'op', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true,true);
        $this->adicionaRelacionamento('fornocod', 'fornocod');
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('dataent_forno', 'dataent_forno');
        $this->adicionaRelacionamento('horaent_forno', 'horaent_forno');
        $this->adicionaRelacionamento('datasaida_forno', 'datasaida_forno');
        $this->adicionaRelacionamento('horasaida_forno', 'horasaida_forno');
        $this->adicionaRelacionamento('situacao','situacao');
        

        $this->setSTop('500');
        $this->adicionaOrderBy('op', 1);
    }
    
    public function finalizarOP($aOp){
        //Adiciona a data e hora do momento
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');
        $user = $_SESSION['codUser'];
        $nomeuser = $_SESSION['nome'];

        //Realiza a inserçao da data e da hora na tabela
        $sSql="update STEEL_PCP_OrdensFabApont set situacao='Finalizado', datasaida_forno='".$sData."',horasaida_forno='".$sHora."',codusersaida='".$user."',usernomesaida='".$nomeuser."' where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        $sSql="update STEEL_PCP_ordensFab set situacao = 'Finalizado' where op ='".$aOp['op']."' ";
        $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    /*
     * Retorna a OP finalizada para processo
     */
    public function retornarOp($aOp){
      
        $sSql="update STEEL_PCP_OrdensFabApont set situacao='Processo', datasaida_forno=NULL, horasaida_forno=NULL where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        $sSql="update STEEL_PCP_ordensFab set situacao = 'Processo' where op ='".$aOp['op']."' ";
        $this->executaSql($sSql);
        
        return $aRetorno;
        
    }
    
}
