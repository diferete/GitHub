<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_ordensFabApont
 * 
 * @author Cleverton Hoffmann
 * @since 18/07/2018
 */

class PersistenciaSTEEL_PCP_ordensFabApontEnt extends Persistencia {

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
    
    public function inserirApont($aCampos){
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');
        
        $iSeq = $this->getIncremento('seq');
        
        $sSql ="insert into STEEL_PCP_ordensFabApont (op,seq,fornocod,fornodes,procod,prodes,dataent_forno,horaent_forno,situacao)"
                . " values(".$aCampos['op'].",".$iSeq.","
                . " ".$aCampos['fornocod'].",'".$aCampos['fornodes']."','".$aCampos['procod']."',"
                . "'".$aCampos['prodes']."','".$sData."','".$sHora."','Processo');";
        $aRetorno = $this->executaSql($sSql);
        
        //muda a situacao da op para em processo
        $sSql="update STEEL_PCP_ordensFab set situacao = 'Processo' where op ='".$aCampos['op']."' ";
        $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
    
    public function deletarOp($aOpseq){
        
        $sSql="delete from STEEL_PCP_ordensFabApont where op='".$aOpseq['op']."'and seq='".$aOpseq['seq']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;        
        
    }
    
}
