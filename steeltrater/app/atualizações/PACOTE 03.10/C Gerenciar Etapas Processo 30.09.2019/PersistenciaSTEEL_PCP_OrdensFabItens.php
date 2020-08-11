<?php

/* 
 * Classe que implementa a emissão de ordens da steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 * 
 */

class PersistenciaSTEEL_PCP_OrdensFabItens extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFabItens');
        
        $this->adicionaRelacionamento('op', 'op',true,true);
        $this->adicionaRelacionamento('opseq', 'opseq',true,true,true);
        $this->adicionaRelacionamento('receita', 'receita');
        $this->adicionaRelacionamento('receita_seq','receita_seq');
        $this->adicionaRelacionamento('tratamento', 'STEEL_PCP_Tratamentos.tratcod',false,false);
        $this->adicionaRelacionamento('tratamento', 'tratamento');
        $this->adicionaRelacionamento('camada_min', 'camada_min');
        $this->adicionaRelacionamento('camada_max', 'camada_max');
        $this->adicionaRelacionamento('temperatura', 'temperatura');
        $this->adicionaRelacionamento('tempo', 'tempo');
        $this->adicionaRelacionamento('resfriamento', 'resfriamento');
        //nova tela para apontamento em etapas
        
        $this->adicionaRelacionamento('fornocod','fornocod');
        $this->adicionaRelacionamento('fornodes','fornodes');
        $this->adicionaRelacionamento('dataent_forno','dataent_forno');
        $this->adicionaRelacionamento('horaent_forno','horaent_forno');
        $this->adicionaRelacionamento('datasaida_forno','datasaida_forno');
        $this->adicionaRelacionamento('horasaida_forno','horasaida_forno');
        $this->adicionaRelacionamento('situacao','situacao');
        $this->adicionaRelacionamento('coduser','coduser');
        $this->adicionaRelacionamento('usernome','usernome');
        $this->adicionaRelacionamento('codusersaida','codusersaida');
        $this->adicionaRelacionamento('usernomesaida','usernomesaida');
        $this->adicionaRelacionamento('turnoSteel','turnoSteel');
        $this->adicionaRelacionamento('turnoSteelSaida','turnoSteelSaida');
        
        
        $this->adicionaJoin('STEEL_PCP_tratamentos', null,1, 'tratamento','tratcod');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('500');
    }
    
    /**
     * Gera o apontamento inicial das etapas
     */
    
    public function apontaIniciarEtapa($aCampos){
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');
        
        $sSql = "update STEEL_PCP_ordensFabItens 
                    set fornocod = '".$aCampos['fornocod']."', 
                    fornodes = '".$aCampos['fornodes']."', 
                    dataent_forno ='".$aCampos['dataent_forno']."',
                    horaent_forno ='".$aCampos['horaent_forno']."',
                    turnoSteel ='".$aCampos['turnoSteel']."',
                    situacao = 'Processo',
                    coduser = '".$aCampos['coduser']."',
                    usernome = '".$aCampos['usernome']."'    
                    where op = '".$aCampos['op']."'
                    and opseq = '".$aCampos['opseq']."'
                    ";
                
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
    public function apontaFinalizaEtapa($aCampos){
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');
        
        $sSql = "   update STEEL_PCP_ordensFabItens 
                    set datasaida_forno = '".$aCampos['datasaida_forno']."', 
                    horasaida_forno = '".$aCampos['horasaida_forno']."', 
                    situacao ='Finalizado',
                    codusersaida ='".$aCampos['coduser']."',
                    usernomesaida ='".$aCampos['usernome']."',
                    turnoSteelSaida ='".$aCampos['turnoSteelSaida']."'
                    where op = '".$aCampos['op']."'
                    and opseq = '".$aCampos['opseq']."'
                    ";
                
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
}