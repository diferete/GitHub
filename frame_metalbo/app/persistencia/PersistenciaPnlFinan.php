<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaPnlFinan extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.REC001');

        $this->adicionaRelacionamento('recdtemiss', 'recdtemiss');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('recdocto', 'recdocto');
        $this->adicionaRelacionamento('recprdtpro', 'recprdtpro');
        $this->adicionaRelacionamento('recprdtpgt', 'recprdtpgt');
        $this->adicionaRelacionamento('recparnro', 'recparnro');
        $this->adicionaRelacionamento('recprvlr', 'recprvlr');
        $this->adicionaRelacionamento('recprvlpgt', 'recprvlpgt');
        $this->adicionaRelacionamento('recprindtr', 'recprindtr');
        $this->adicionaRelacionamento('recprtirec', 'recprtirec');
        $this->adicionaRelacionamento('diasvenc', 'diasvenc');
        $this->adicionaRelacionamento('bcodes', 'bcodes');
        $this->adicionaRelacionamento('recprnro', 'recprnro');

        $this->setBConsultaManual(true);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select "
                . "widl.REC001.recdtemiss as 'widl.REC001.recdtemiss', "
                . "widl.REC001.empcod as 'widl.REC001.empcod', "
                . "widl.emp01.empdes as 'widl.emp01.empdes', "
                . "widl.REC001.recdocto as 'widl.REC001.recdocto', "
                . "widl.REC0012.recprdtpro as 'widl.REC001.recprdtpro', "
                . "widl.REC0012.recprdtpgt as 'widl.REC001.recprdtpgt', "
                . "widl.REC0012.recparnro as 'widl.REC001.recparnro', "
                . "widl.REC0012.recprvlr as 'widl.REC001.recprvlr', "
                . "widl.REC0012.recprvlpgt as 'widl.REC001.recprvlpgt', "
                . "widl.REC0012.recprindtr as 'widl.REC001.recprindtr', "
                . "widl.REC0012.recprtirec as 'widl.REC001.recprtirec', "
                . "DATEDIFF(day,CONVERT (date, SYSDATETIME()),recprdtpro) as 'widl.REC001.diasvenc', "
                . "widl.BANCOS.bcodes as 'widl.REC001.bcodes', "
                . "widl.REC0012.recprnro as 'widl.REC001.recprnro' "
                . "from widl.REC001(nolock) "
                . "left outer join widl.REC0012(nolock) "
                . "on widl.REC001.recdocto = widl.REC0012.recdocto "
                . "left outer join widl.EMP01(nolock) "
                . "on widl.REC001.empcod = widl.EMP01.empcod "
                . "left outer join widl.BANCOS(nolock) "
                . "on widl.REC0012.recprbconr = widl.BANCOS.bconro ";

        $sWhereManual = " and recprdtpgt = '1753-01-01' "
                . "and widl.REC001.recdocto NOT LIKE 'T%' "
                . "and widl.REC001.recdocto NOT LIKE 'D%' "
                . "and widl.REC001.filcgc = '75483040000211' "
                . "and tpdcod in (1,3) "
                . "order by recprdtpro ";
        $this->setSWhereManual($sWhereManual);
        return $sSql;
    }

    public function somaTitulos($sCnpj) {

        $sSql = "select "
                . "SUM(recprvlr)as total "
                . "from widl.REC001(nolock) "
                . "left outer join widl.REC0012(nolock) "
                . "on widl.REC001.recdocto = widl.REC0012.recdocto "
                . "left outer join widl.EMP01(nolock) "
                . "on widl.REC001.empcod = widl.EMP01.empcod "
                . "where widl.EMP01.empcod  ='" . $sCnpj . "' "
                . "and widl.REC001.recdocto NOT LIKE 'T%' "
                . "and widl.REC001.recdocto NOT LIKE 'D%' "
                . "and widl.REC001.filcgc = '75483040000211' "
                . "and recprdtpgt = '1753-01-01' "
                . "and tpdcod in (1,3)  ";


        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->total;
    }

    /**
     * Soma títulos em atraso
     */
    public function somaTitAtraso($sCnpj) {
        $sSql = "select "
                . "SUM(recprvlr)as total "
                . "from widl.REC001(nolock) "
                . "left outer join widl.REC0012(nolock) "
                . "on widl.REC001.recdocto = widl.REC0012.recdocto "
                . "left outer join widl.EMP01(nolock) "
                . "on widl.REC001.empcod = widl.EMP01.empcod "
                . "where widl.EMP01.empcod  ='" . $sCnpj . "' "
                . "and widl.REC001.recdocto NOT LIKE 'T%' "
                . "and widl.REC001.recdocto NOT LIKE 'D%' "
                . "and widl.REC001.filcgc = '75483040000211' "
                . "and recprdtpgt = '1753-01-01' "
                . "and tpdcod in (1,3) "
                . "and DATEDIFF(day,CONVERT (date, SYSDATETIME()),recprdtpro) < 0 ";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->total;
    }

    public function mediaFat($sEmpcod) {
        $sDataIni = date('Y-m-d', strtotime("-365 days"));
        $sSql = "select "
                . "SUM(nfsitvlrto + nfsitvlrip + nfsitvlrsu)/12 total "
                . "from widl.NFC001(nolock), "
                . "widl.NFC003(nolock), "
                . "widl.mov01(nolock), "
                . "widl.prod01(nolock) "
                . "where widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro "
                . "and widl.NFC003.nfsitcod = widl.prod01.procod "
                . "and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc "
                . "and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser "
                . "and widl.nfc001.nfsmovcod = widl.MOV01.movcod "
                . "and nfsdtemiss between convert(date,'" . $sDataIni . "') "
                . "and CONVERT (date, SYSDATETIME()) "
                . "and nfscancela <> '*' "
                . "and widl.NFC001.nfsfilcgc = '75483040000211' "
                . "and movfin = 'S' "
                . "and widl.NFC003.nfsnfser = 2 "
                . "and nfssaida = 'XXX' "
                . "and nfscomplem = '' "
                . "and nfsclicod = " . $sEmpcod;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->total;
    }

    public function limiteCred($sEmpcod) {
        $sSql = "select "
                . "empcod, "
                . "empdes, "
                . "cclilimite, "
                . "repcod "
                . "from widl.emp01(nolock) "
                . "where empcod = " . $sEmpcod;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->cclilimite;
    }

}
