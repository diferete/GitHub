<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_nfOd extends Persistencia{
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
        
        $this->adicionaRelacionamento('rnc','rnc');
        $this->adicionaRelacionamento('opantes','opantes');
        
      
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('100');
        
        
    }
    
    public function buscaOd($sDados){
        $sSql ="  select * from rex_maquinas.widl.PED01 left outer join rex_maquinas.widl.EMP01
       on rex_maquinas.widl.PED01.empcod = rex_maquinas.widl.EMP01.empcod
       where filcgc ='75483040000211'
       and rex_maquinas.widl.PED01.empcod ='8993358000174'
       and pdcnro = ".$sDados;
        
       $result = $this->getObjetoSql($sSql);
       
       $oRow = $result->fetch(PDO::FETCH_OBJ);
       
       if($oRow->pdcnro !==null){
           return $oRow->empdes;
       }else
       {
           return false;
       }
       
    }
    
    public function consultaNf($sDados){
        $sSql ="    select nfsclinome,convert(varchar,nfsdtemiss,103)dataemiss 
       from rex_maquinas.widl.NFC001 
       where nfsfilcgc ='75483040000211'
       and nfsnfser ='2'
       and nfsclicod ='8993358000174'
       and nfsnfnro ='".$sDados."' ";
        
       $result = $this->getObjetoSql($sSql);
       
       $oRow = $result->fetch(PDO::FETCH_OBJ);
       
       if($oRow->nfsclinome !==null){
           return $oRow->nfsclinome;
       }else
       {
           return false;
       }
    }
    
    public function gravaXped($aDados){
        
        $sSql ="update STEEL_PCP_ordensFab set xPed ='".$aDados['od']."',nItemPed ='1'
                where documento ='".$aDados['nf']."'
                and emp_codigo ='75483040000211' ";
        
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }
}