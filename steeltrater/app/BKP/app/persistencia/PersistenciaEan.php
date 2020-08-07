<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaEan extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbean');
        
        $this->adicionaRelacionamento('ean', 'ean',true);
        $this->adicionaRelacionamento('codigo', 'Produto.procod');
        $this->adicionaRelacionamento('nrcaixa', 'nrcaixa');
        $this->adicionaRelacionamento('pcs','pcs');
        
        $this->adicionaJoin('Produto',NULL,1,'codigo','procod');
        $this->setSTop('35');
        $this->adicionaOrderBy('ean',1);
        
        
    }
    /*
     * Consulta caixa master
     */
    public function consutaCaixaMaster($sCodigo){
        $sSql="select (pcs/100)as masterct from tbean left outer join 
                  metean_cadtipoemb on tbean.idemb = metean_cadtipoemb.idemb 
                  where codigo ='".$sCodigo."'
                  and lib = 'L' 
                  and tbean.idemb =1 and inativo <> 's'";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $aRetorno[0] = number_format($row->masterct,1,',','.');
        
        /*Pesquisa caixas normal*/
        $sSql ="  select (pcs/100)as normalct from tbean left outer join 
                  metean_cadtipoemb on tbean.idemb = metean_cadtipoemb.idemb 
                  where codigo ='".$sCodigo."'
                  and lib = 'L'
                  and tbean.idemb in (2,3,5)  and inativo <> 's'"; 
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $aRetorno[1] = number_format($row->normalct,1,',','.');
        
        return $aRetorno;
        
        /*$result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);*/
    }
    /**
     * resulta uma consulta
     */
    public function consultaEan($sProcod){
        $sSql = "SELECT ean,codigo,pcs,caixa FROM tbean where codigo=".$sProcod." and inativo <> 'S'";
        $result = $this->getObjetoSql($sSql);
        $aLinha = array();
        $iCont = 0;
        while($row =$result->fetch(PDO::FETCH_OBJ)){
           $aColuna[0]=$row->ean;
           $aColuna[1]=$row->codigo;
           $aColuna[2]=number_format($row->pcs,0,'','');
           $aColuna[3]=$row->caixa;
           $aLinha[$iCont]=$aColuna;
           $iCont++;
        }
        return $aLinha;
    }
}
