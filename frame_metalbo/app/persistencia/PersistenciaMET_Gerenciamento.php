<?php

/*
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class PersistenciaMET_Gerenciamento extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmanutmp');
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('codmaq', 'codmaq');
        $this->adicionaRelacionamento('codmaq', 'MET_Maquinas.cod', false, false, false);
        $this->adicionaRelacionamento('maquina', 'MET_Maquinas.maquina', false, false, false);
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor', false, false, false);
        $this->adicionaRelacionamento('sitmp', 'sitmp');
        $this->adicionaRelacionamento('databert', 'databert');
        $this->adicionaRelacionamento('userabert', 'userabert');
        $this->adicionaRelacionamento('userfecho', 'userfecho');
        $this->adicionaRelacionamento('datafech', 'datafech');
        $this->adicionaOrderBy('nr', 1);
        $this->adicionaJoin('MET_Maquinas', null, 1, 'codmaq', 'cod');
        $this->adicionaJoin('Setor');
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

        if ($iNr != null && $iNr != 0) {
            $sSql = "select  count (sitmp) as numero,resp
                from   tbitensmp left outer join    
                tbservmp on tbitensmp.codsit =   tbservmp.codsit 
                where sitmp <> 'FINALIZADO' and
                dias<0 and nr = '" . $iNr . "'
                group by resp";
        } else {
            $sSql = "select  count (sitmp) as numero,resp
                from   tbitensmp left outer join    
                tbservmp on tbitensmp.codsit =   tbservmp.codsit 
                where sitmp <> 'FINALIZADO' and
                dias<0
                group by resp";
        }

        $oRow = array();
        $result = $this->getObjetoSql($sSql);
        while ($aRow = $result->fetch(PDO::FETCH_ASSOC)) {
            $oRow[$aRow['resp']] = $aRow['numero'];
        }

        return ($oRow);
    }

    public function buscaNrServNeg() {

        $sSql = "select nr from tbitensmp 
                left outer join    
                tbservmp on tbitensmp.codsit = tbservmp.codsit 
                where sitmp <> 'FINALIZADO' 
                and dias<0";

        $sCodSet = $_SESSION['codsetor'];

        if ($sCodSet == '2') {
            
        } else if ($sCodSet == '12') {
            $sSql .= " and tbservmp.resp = 'MANUTENCAO'";
        } else if ($sCodSet == '29') {
            $sSql .= " and tbservmp.resp = 'MECANICA'";
        } else {
            $sSql .= " and tbservmp.resp = 'OPERADOR'";
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
     * Função que retorna as nr das máquinas que tem serviço cadastrado por responsável - MANUTENÇÃO ELÉTRICA, MECÂNICA e OPERADOR
     */

    public function retornaTexMaqPorSetor($sResp) {

        $sSql = "select tbmanutmp.nr from tbmanutmp 
		left outer join  
		tbitensmp on tbmanutmp.nr = tbitensmp.nr
		left outer join    
                tbservmp on tbitensmp.codsit = tbservmp.codsit 
                where (tbitensmp.sitmp <> 'FINALIZADO'  ";

        $sCodSet = $_SESSION['codsetor'];

        if ($sResp == null || $sResp == '') {
            if ($sCodSet == '2') {
                
            } else if ($sCodSet == '12') {
                $sSql .= " and tbservmp.resp = 'MANUTENCAO'";
            } else if ($sCodSet == '29') {
                $sSql .= " and tbservmp.resp = 'MECANICA'";
            } else {
                $sSql .= " and tbservmp.resp = 'OPERADOR'";
            }
        } else if ($sResp == 'MANUTENCAO') {
            $sSql .= " and tbservmp.resp = 'MANUTENCAO'";
        } else if ($sResp == 'MECANICA') {
            $sSql .= " and tbservmp.resp = 'MECANICA'";
        } else if ($sResp == 'OPERADOR') {
            $sSql .= " and tbservmp.resp = 'OPERADOR'";
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

}
