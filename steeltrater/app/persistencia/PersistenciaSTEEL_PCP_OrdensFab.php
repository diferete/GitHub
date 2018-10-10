<?php

/* 
 * Implementa producao steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class PersistenciaSTEEL_PCP_OrdensFab extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFab');
      
        $this->adicionaRelacionamento('op','op',true,true,true);
        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo');
        $this->adicionaRelacionamento('emp_razaosocial', 'emp_razaosocial');
        $this->adicionaRelacionamento('origem','origem');
        $this->adicionaRelacionamento('documento','documento');
        $this->adicionaRelacionamento('prod','prod');
        $this->adicionaRelacionamento('prodes','prodes');
        
        $this->adicionaRelacionamento('matcod','matcod');
        $this->adicionaRelacionamento('matdes','matdes');
        
        $this->adicionaRelacionamento('receita','receita');
        $this->adicionaRelacionamento('receita_des','receita_des');
        $this->adicionaRelacionamento('quant','quant');
        $this->adicionaRelacionamento('peso','peso');
        $this->adicionaRelacionamento('opcliente','opcliente');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('usuario','usuario');
        $this->adicionaRelacionamento('seqprodnf','seqprodnf');
        $this->adicionaRelacionamento('dataprev','dataprev');
        
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('temprev', 'temprev');
       
        $this->adicionaRelacionamento('seqmat', 'seqmat');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('1000');
        
    }
   
    
    /**
     * Cancela a ordem de produção
     * 
     * @param type $aOp número da op
     */
    public function CancelarOp($aOp){
        
        date_default_timezone_set('America/Sao_Paulo');
        $data      = date("d/m/y");                     //função para pegar a data e hora local
        $hora      = date("H:i");   
        $useRel=$_SESSION['nome'];
        $sSql="update STEEL_PCP_OrdensFab set situacao='Cancelada', usercanc='".$useRel."',datacanc='".$data."', horacanc='".$hora."' where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
     /**
     * Altera ordem de produção para aberta
     * 
     * @param type $aOp número da op
     */
    public function AbertaOp($aOp){
        
        $sSql="update STEEL_PCP_OrdensFab set situacao='Aberta',usercanc=NULL,datacanc=NULL, horacanc=NULL where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
    
    public function alteraSit($iOp,$sSit){
        
        $sSql="update STEEL_PCP_OrdensFab set situacao='".$sSit."' where op='".$iOp."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
   
        
}