<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaFinanRep extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.REC001');

        $this->adicionaRelacionamento('recdtemiss', 'recdtemiss');
        $this->adicionaRelacionamento('empcod', 'empcod', true, true);
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('recdocto', 'recdocto', true, true, true);
        $this->adicionaRelacionamento('recprdtpro', 'recprdtpro');
        $this->adicionaRelacionamento('recprdtpgt', 'recprdtpgt');
        $this->adicionaRelacionamento('recparnro', 'recparnro', true, true, true);
        $this->adicionaRelacionamento('recprvlr', 'recprvlr');
        $this->adicionaRelacionamento('recprvlpgt', 'recprvlpgt');
        $this->adicionaRelacionamento('recprindtr', 'recprindtr');
        $this->adicionaRelacionamento('recprtirec', 'recprtirec');
        $this->adicionaRelacionamento('recprbconr', 'recprbconr', true, true);
        $this->adicionaRelacionamento('dias', 'dias');
        $this->adicionaRelacionamento('bcodes', 'bcodes');
        $this->adicionaRelacionamento('rechist', 'rechist');
        $this->adicionaRelacionamento('recprnro', 'recprnro', true, true, true);

        $this->setBConsultaManual(true);

        $this->setSWhereManual(" and recprdtpgt = '1753-01-01'
          and widl.REC001.recdocto NOT LIKE 'T%'
          and widl.REC001.recdocto NOT LIKE 'D%'
          and widl.REC001.filcgc = '75483040000211'
          and tpdcod in (1,3)  ORDER BY recprdtpro ");
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select  top(500)  widl.REC001.recdtemiss as 'widl.REC001.recdtemiss',
          widl.REC001.empcod as 'widl.REC001.empcod',
          widl.EMP01.empdes as 'widl.REC001.empdes',
          widl.REC001.recdocto as 'widl.REC001.recdocto',
          widl.REC001.rechist as 'widl.REC001.rechist',
          widl.REC0012.recprdtpro as 'widl.REC001.recprdtpro',
          widl.REC0012.recprdtpgt as 'widl.REC001.recprdtpgt',
          widl.REC0012.recparnro  as 'widl.REC001.recparnro',
          widl.REC0012.recprvlr   as 'widl.REC001.recprvlr' ,
          widl.REC0012.recprvlpgt as 'widl.REC001.recprvlpgt',
          widl.REC0012.recprindtr  as 'widl.REC001.recprindtr',
          widl.REC0012.recprtirec  as 'widl.REC001.recprtirec',
          widl.REC0012.recprbconr  as 'widl.REC001.recprbconr',
          DATEDIFF(day,CONVERT (date, SYSDATETIME()),recprdtpro) as 'widl.REC001.dias',
          bcodes as  'widl.REC001.bcodes',
          recprnro as 'widl.REC001.recprnro' 
          from widl.REC001(nolock) left outer join 
          widl.REC0012(nolock) on widl.REC001.recdocto = widl.REC0012.recdocto left outer join 
          widl.EMP01(nolock) on widl.REC001.empcod = widl.EMP01.empcod left outer join  
          widl.BANCOS(nolock) on widl.REC0012.recprbconr = widl.BANCOS.bconro ";



        return $sSql;
    }

    public function somaTitulo($empcod) {
        $sSql = "select SUM(recprvlr)as total "
                . "from widl.REC001 "
                . "left outer join widl.REC0012 "
                . "on widl.REC001.recdocto = widl.REC0012.recdocto "
                . "left outer join widl.EMP01 "
                . "on widl.REC001.empcod = widl.EMP01.empcod "
                . "where widl.REC001.empcod =" . $empcod . " "
                . "and widl.REC001.recdocto NOT LIKE 'T%' "
                . "and widl.REC001.recdocto NOT LIKE 'D%' "
                . "and widl.REC001.filcgc = '75483040000211' "
                . "and recprdtpgt = '1753-01-01' "
                . "and tpdcod in (1,3)";

        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $mTotal = $oRow->total;

        $sSqlAtraso = "select sum(recprvlr) as total 
            from widl.REC001(nolock) left outer join 
            widl.REC0012(nolock) on widl.REC001.recdocto = widl.REC0012.recdocto left outer join 
            widl.EMP01(nolock) on widl.REC001.empcod = widl.EMP01.empcod 
            where widl.REC001.empcod =" . $empcod . " 
            and DATEDIFF(day,CONVERT (date, SYSDATETIME()),recprdtpro) < 0 
            and widl.REC001.recdocto NOT LIKE 'T%'
            and widl.REC001.recdocto NOT LIKE 'D%'
            and widl.REC001.filcgc = '75483040000211'
            and recprdtpgt = '1753-01-01'
            and tpdcod in (1,3) ";

        $result = $this->getObjetoSql($sSqlAtraso);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $mTotalAtraso = $oRow->total;

        $aDados['total'] = $mTotal;
        $aDados['atrasado'] = $mTotalAtraso;

        return $aDados;
    }

    public function geraDadosBoleto($docto, $parc, $prog) {
        $bancoNr = "";
        $agConta = "";
        $carteira = "";
        $nosso = "";
        $dv = "";
        $dadosItau = "";
        $empcod = "";

        $sSql = "select  count(*)as nrlinhas,recprcarco,rtrim(recprnrobc) as recprnrobc ,recprbconr,recparnro,empcod 
           from widl.REC0012(NOLOCK) where recdocto ='" . $docto . "' and recparnro =" . $parc . " and recprnro =" . $prog . "   
           group by recprcarco,recprnrobc,recprbconr,recparnro,empcod ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $carteira = $oRow->recprcarco;
        $nosso = $oRow->recprnrobc;
        $bancoNr = $oRow->recprbconr;
        $empcod = $oRow->empcod;

        if ($oRow->nrlinhas > 0) {
            $sSql = " select replace(rTrim(replace(bcoagencia+''+bcoconta,' ','')),'-','')as agconta  
                from widl.BANCOS where bconro ='" . $bancoNr . "'";
            $result = $this->getObjetoSql($sSql);
            $oRow = $result->fetch(PDO::FETCH_OBJ);
            $agConta = $oRow->agconta;
            if (strlen($nosso) == 0) {
                $aRetorno['itau'] = 'Título não possuí nosso número!';
                $aRetorno['nosso'] = 'Título não possuí nosso número!';
                $aRetorno['empcod'] = $empcod;
            } else {
                $aRetorno['itau'] = $agConta . $carteira . $nosso;
                $aRetorno['nosso'] = $nosso;
                $aRetorno['empcod'] = $empcod;
                //verifica se é bradesco
                $bBradesco = $this->verficaBradesco($bancoNr);
                if ($bBradesco) {
                    $aRetorno['nosso'] = substr($nosso, 0, -1);
                }
            }
        }
        return $aRetorno;
    }

    /**
     * verifica se o banco é bradesco
     */
    public function verficaBradesco($bcnro) {
        $sSql = "select COUNT(*)as bra from widl.BANCOS where bcodes like '%brades%' and bconro ='" . $bcnro . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        if ($oRow->bra > 0) {
            return true;
        } else {
            return false;
        }
    }

}
