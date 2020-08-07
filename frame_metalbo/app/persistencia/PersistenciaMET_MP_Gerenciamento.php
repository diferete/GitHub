<?php

/*
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class PersistenciaMET_MP_Gerenciamento extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmanutmp');
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('codmaq', 'codmaq');
        $this->adicionaRelacionamento('codmaq', 'MET_MP_Maquinas.cod', false, false, false);
        $this->adicionaRelacionamento('maquina', 'MET_MP_Maquinas.maquina', false, false, false);
        $this->adicionaRelacionamento('maqmp', 'maqmp');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('codsetor', 'Setor.codsetor', false, false, false);
        $this->adicionaRelacionamento('descsetor', 'descsetor', false, false, false);
        $this->adicionaRelacionamento('sitmp', 'sitmp');
        $this->adicionaRelacionamento('databert', 'databert');
        $this->adicionaRelacionamento('userabert', 'userabert');
        $this->adicionaRelacionamento('userfecho', 'userfecho');
        $this->adicionaRelacionamento('datafech', 'datafech');
 
        $this->adicionaOrderBy('maqmp', 0);
        //$this->adicionaOrderBy('nr', 1);
        $this->adicionaJoin('MET_MP_Maquinas', null, 1, 'codmaq', 'cod');
        $this->adicionaJoin('Setor');       
        $this->setSTop('50');
       
    }

    public function consultaCodSetor($iCodMaq) {

        $sSql = "select codsetor from metmaq where cod ='" . $iCodMaq . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
    }

    public function verificaQuantMaqAber($iCodMaq) {

        $sSql = "select count (codmaq) as total from tbmanutmp where codmaq = '" . $iCodMaq . "' and sitmp = 'ABERTO'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return ((int) $oRow->total);
    }

    public function verificaCampoValido($iCodMaq, $sDesc) {

        $sSql = "select maquina from metmaq where cod= '" . $iCodMaq . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_ASSOC);
        $sMaquina = $oRow['maquina'];
        if (strcasecmp($sMaquina, $sDesc) == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function totalAbertoVencidos($iNr) {

        $sCodSet = $_SESSION['codsetor'];
        
        if ($iNr != null && $iNr != 0) {
            $sSql = "select  count (sitmp) as numero,resp
                from   tbitensmp left outer join    
                tbservmp on tbitensmp.codsit =   tbservmp.codsit 
                where sitmp <> 'FINALIZADO' and
                dias<0 and nr = '" . $iNr . "' ";
        } else {
            $sSql = "select  count (sitmp) as numero,resp
                from   tbitensmp left outer join    
                tbservmp on tbitensmp.codsit =   tbservmp.codsit 
                where sitmp <> 'FINALIZADO' and
                dias<0 ";
        }
        if ($sCodSet == '2') {
            
        } else if ($sCodSet == '12') {
            $sSql .= " and tbservmp.resp = 'ELETRICA'";
        } else if ($sCodSet == '29') {
            $sSql .= " and tbservmp.resp = 'MECANICA'";
        } else {
            $sSql .= " and tbservmp.resp = 'OPERADOR'";
            $sSql .= " and tbservmp.codsetor = ".$sCodSet."";
        }
            $sSql .= " group by resp";
        $oRow = array();
        $result = $this->getObjetoSql($sSql);
        while ($aRow = $result->fetch(PDO::FETCH_ASSOC)) {
            $oRow[$aRow['resp']] = $aRow['numero'];
        }

        return ($oRow);
    }

    public function buscaNrServNeg() {
        $sCodSet = $_SESSION['codsetor'];
        $sSql = "select nr from tbitensmp 
                left outer join    
                tbservmp on tbitensmp.codsit = tbservmp.codsit 
                where sitmp <> 'FINALIZADO' 
                and dias<0";
        if ($sCodSet == '2') {
            
        } else if ($sCodSet == '12') {
            $sSql .= " and tbservmp.resp = 'ELETRICA'";
        } else if ($sCodSet == '29') {
            $sSql .= " and tbservmp.resp = 'MECANICA'";
        } else {
            $sSql .= " and tbservmp.resp = 'OPERADOR'";
            $sSql .= " and tbservmp.codsetor = ".$sCodSet."";
        }

        $sSql .= " group by nr";

        $oRow = array();
        $result = $this->getObjetoSql($sSql);
        $i = 0;
        while ($aRow = $result->fetch(PDO::FETCH_OBJ)) {
            $oRow[$i] = $aRow->nr;
            $i++;
        }

        return ($oRow);
    }

    /*
     * Função que retorna as nr das máquinas que tem serviço cadastrado por responsável - MANUTENÇÃO ELÉTRICA, MECÂNICA, OPERADOR 
     */
    public function retornaTexMaqPorSetor($Setor) {

        $sSql = "select tbmanutmp.nr from tbmanutmp 
		left outer join  
		tbitensmp on tbmanutmp.nr = tbitensmp.nr
		left outer join    
                tbservmp on tbitensmp.codsit = tbservmp.codsit 
                where (tbitensmp.sitmp <> 'FINALIZADO'  ";

        if($Setor==null || $Setor==''){
            $sCodSet = $_SESSION['codsetor'];
        }else{
            $sCodSet = $Setor;
        }

//        if ($sResp == null || $sResp == '') {
            if ($sCodSet == '2') {
                
            } else if ($sCodSet == '12') {
                $sSql .= " and tbservmp.resp = 'ELETRICA'";
            } else if ($sCodSet == '29') {
                $sSql .= " and tbservmp.resp = 'MECANICA'";
            } else {
                $sSql .= " and tbservmp.resp = 'OPERADOR' "
                        . " and tbservmp.codsetor = ".$sCodSet."";
            }    
            
            
        $sSql .= ") or tbitensmp.nr is null group by tbmanutmp.nr ";

        $result = $this->getObjetoSql($sSql);
        $i = 0;
        $oRow = array();
        while ($aRow = $result->fetch(PDO::FETCH_OBJ)) {
            $oRow[$i] = $aRow->nr;
            $i++;
        }
        return implode($oRow, ',');
    }

    /**
     * Método que retorna descrição da máquina conforme Nr
     * @param type $nr
     * @return type
     */
    public function retornaMaquina($nr){
        $sSql = "select maqmp from tbmanutmp where nr = ".$nr."";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
    }
    
}
