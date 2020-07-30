<?php

class PersistenciaModulo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmodulo');

        $this->adicionaRelacionamento('modcod', 'modcod', true, true, true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');
        $this->adicionaRelacionamento('uploads', 'uploads');
        $this->adicionaRelacionamento('uploadmulti', 'uploadmulti');

        $this->adicionaOrderBy('modcod', 1);
    }

    public function teste() {
        $sSql = 'select distinct codsetor,setor,cargo from tbfunc where cnpj = 75483040000211';
        $iNr = 1;
        $iCodFunc = 1;
        $iFilcgc = 75483040000211;

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $sSqlInsert = "insert into MET_RH_FuncaoSetor (nr,filcgc,codsetor,codfuncao,descfuncao,descsetor)"
                    . "values"
                    . "(" . $iNr . "," . $iFilcgc . "," . $row->codsetor . "," . $iCodFunc . ",'" . $row->cargo . "','" . $row->setor . "')";
            $aRetorno = $this->executaSql($sSqlInsert);
            $iNr++;
            $iCodFunc++;
        }
        return;
    }

}
