<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_ordensFabLista
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class PersistenciaSTEEL_PCP_ordensFabLista extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFabLista');

        $this->adicionaRelacionamento('nr', 'nr',true,true,true);
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('op','STEEL_PCP_ordensFab.op');
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('fornocod', 'fornocod');
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('dataEntForno', 'dataEntForno');
        $this->adicionaRelacionamento('horaEntForno','horaEntForno');
        $this->adicionaRelacionamento('seqApont','seqApont');
        $this->adicionaRelacionamento('tempforno','tempforno');
        $this->adicionaRelacionamento('prioridade', 'prioridade');
        

        $this->setSTop('1000');
        $this->adicionaOrderBy('tempforno', 1);
        $this->adicionaJoin('STEEL_PCP_ordensFab');
    }
    
    public function apontaLista($oModel){
      $sSql = "update STEEL_PCP_ordensFabLista 
                set situacao='".$oModel->getSituacao()."',
                data='".$oModel->getData()."', 
                hora='".$oModel->getHora()."',
                fornocod='".$oModel->getFornocod()."',
                fornodes='".$oModel->getFornodes()."',
                tempForno='".$oModel->getTempForno()."',
                prioridade='".$oModel->getPrioridade()."'
                where nr='".$oModel->getNr()."'";  
      $aRetorno= $this->executaSql($sSql);
      return $aRetorno;
    }
    
     public function alteraPrio($sValor,$sChave){
        $sSql="update STEEL_PCP_OrdensFabLista set prioridade ='".$sValor."' where nr='".$sChave."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
    public function baixaLista($aDados,$sSit){
        $sSql = "update STEEL_PCP_ordensFabLista set situacao='".$sSit."' where op='".$aDados['op']."'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }
    
   
}