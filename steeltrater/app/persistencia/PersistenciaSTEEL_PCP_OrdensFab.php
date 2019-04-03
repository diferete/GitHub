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
        
        $this->adicionaRelacionamento('retrabalho', 'retrabalho');
        $this->adicionaRelacionamento('op_retrabalho', 'op_retrabalho');
        
        $this->adicionaRelacionamento('durezaNucMin', 'durezaNucMin');
        $this->adicionaRelacionamento('durezaNucMax', 'durezaNucMax');
        $this->adicionaRelacionamento('NucEscala', 'NucEscala');
        $this->adicionaRelacionamento('durezaSuperfMin', 'durezaSuperfMin');
        $this->adicionaRelacionamento('durezaSuperfMax', 'durezaSuperfMax');
        $this->adicionaRelacionamento('superEscala', 'superEscala');
        $this->adicionaRelacionamento('expCamadaMin', 'expCamadaMin');
        $this->adicionaRelacionamento('expCamadaMax', 'expCamadaMax');
        $this->adicionaRelacionamento('tratrevencomp', 'tratrevencomp');
        $this->adicionaRelacionamento('tipoOrdem','tipoOrdem');
        
        $this->adicionaRelacionamento('fioDurezaSol','fioDurezaSol');
        $this->adicionaRelacionamento('fioEsferio','fioEsferio');
        $this->adicionaRelacionamento('fioDescarbonetaTotal','fioDescarbonetaTotal');
        $this->adicionaRelacionamento('fioDescarbonetaParcial','fioDescarbonetaParcial');
        $this->adicionaRelacionamento('DiamFinalMin','DiamFinalMin');
        $this->adicionaRelacionamento('DiamFinalMax','DiamFinalMax');
        
        $this->adicionaRelacionamento('prodFinal', 'prodFinal');
        $this->adicionaRelacionamento('prodesFinal', 'prodesFinal');
        
        $this->adicionaRelacionamento('vlrNfEnt', 'vlrNfEnt');
        $this->adicionaRelacionamento('vlrNfEntUnit','vlrNfEntUnit');
        $this->adicionaRelacionamento('nrCarga','nrCarga');
        
        $this->adicionaRelacionamento('referencia','referencia');
        
        $this->adicionaRelacionamento('xPed','xPed');
        $this->adicionaRelacionamento('nItemPed','nItemPed');
        
        $this->adicionaRelacionamento('nrcert','nrcert');
        
        $this->adicionaRelacionamento('pendencias','pendencias');
        $this->adicionaRelacionamento('pendenciasobs','pendenciasobs');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('300');
        
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
    
    /**
     * Grava número da carga na op
     */
    
    public function nrCarga($sOp,$sNrCarga){
         $sSql="update STEEL_PCP_OrdensFab set nrCarga='".$sNrCarga."' where op='".$sOp."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
     /**
     * Limpa carga na op
     */
    
    public function limpaCarga($sOp){
         $sSql="update STEEL_PCP_OrdensFab set nrCarga='Sem carga' where op='".$sOp."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    

    /**
     * Coloca a ordem de produção em retrabalho ///////////////TERMINAR O SELECT
     * 
     * @param type $aOp número da op
     */
    public function RetrabalhoOp($aOp){
        
        $sSql="update STEEL_PCP_OrdensFab set situacao='Aberta',usercanc=NULL,datacanc=NULL, horacanc=NULL where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
    /**
     * busca preço da nota fiscal
     */
    
    public function buscaPreço($aCamposChave){
       $sql = "select nfsitvlrun,nfsitvlrto "
              ."  from rex_maquinas.widl.NFC003 "
              ."  where nfsfilcgc ='75483040000211' "
              ."  and nfsnfser = '2' "
              ."  and nfsnfnro = '".$aCamposChave['nfsnfnro']."' "
              ."  and nfsitcod = '".$aCamposChave['nfsitcod']."'";
        
        $result = $this->getObjetoSql($sql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        
        $aRetorno = array();
        $aRetorno[0] = $row->nfsitvlrun;
        $aRetorno[1] = $row->nfsitvlrto; 
        return $aRetorno;
        
    }
   
    public function gravaPendencia($sOp,$sAtencao,$sPendencia){
         $sSql="update STEEL_PCP_OrdensFab set pendencias='".$sAtencao."',pendenciasobs='".$sPendencia."' where op='$sOp'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
}