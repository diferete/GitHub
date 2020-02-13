<?php

/**
 * Classe responsável pela persistencia do objeto MovFornoSteel
 * 
 * @author Avanei Martendal
 * @since 29/03/2018
 */

class PersistenciaMovFornoSteel extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('steelmov_forno');
        
        $this->adicionaRelacionamento('nr', 'nr',true,true);
        $this->adicionaRelacionamento('ofsteel', 'ofsteel');
        $this->adicionaRelacionamento('procodCod', 'procodCod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('empcod', 'empcod');
        
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('ofcliente', 'ofcliente');
        $this->adicionaRelacionamento('dtent', 'dtent');
        
        $this->adicionaRelacionamento('horaent', 'horaent');
        $this->adicionaRelacionamento('forno', 'forno');
        $this->adicionaRelacionamento('sit', 'sit');
        
        $this->adicionaRelacionamento('dtsaida', 'dtsaida');
        $this->adicionaRelacionamento('horasaida', 'horasaida');
        $this->adicionaRelacionamento('lastRefresch', 'lastRefresch');
        
        $this->setSTop('150');
        $this->adicionaOrderBy('nr', 1);
        
    }
    
    /**
     * deleta as entradas das datas seleciondas
     */
    public function deletaReg($dt1,$dt2){
        $sSql = "delete from steelmov_forno where dtent between '".$dt1."' and '".$dt2."'";
        $aRetorno =$this->executaSql($sSql);
        return $aRetorno;
    }
    
    public function ultimaAtualizacao(){
        $sSql = "select lastRefresch from  steelmov_forno where nr = (select MAX(nr) from steelmov_forno)";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $sData = $row->lastrefresch;
        return $sData;
        
    }
}