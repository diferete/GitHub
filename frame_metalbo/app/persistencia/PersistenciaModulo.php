<?php

class PersistenciaModulo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmodulo');

        $this->adicionaRelacionamento('modcod', 'modcod', true, true, true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');

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

    public function testeHora() {
        $sSql = "select nr, filcgc, tempo, hora2 from MET_TEC_Chamados";
        $result = $this->getObjetoSql($sSql);

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $sSqlUpdate = "update MET_TEC_Chamados set tempo  = '" . $row->hora2 . "' where nr = " . $row->nr . " and filcgc  = " . $row->filcgc . "";
            $aRetorno = $this->executaSql($sSqlUpdate);
        }
        return;
    }

    public function populaFunc() {
        $sSql = "select numcad,nomfun,cargo,codsetor,setor,grains,desgra from tbfunc where cnpj = 75483040000211 order by setor asc";
        $iNr = 1;
        $iFilcgc = 75483040000211;
        $data = date('d/m/Y');

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {

            $sSqlInsert = "insert into MET_ISO_Treinamentos (nr,filcgc,cracha,situacao,nome,codsetor,descsetor,funcao,data_cad,usuario,codGrau_escolaridade,grau_escolaridade,tagEscolaridade,tagTreinamento)"
                    . "values"
                    . "(" . $iNr . "," . $iFilcgc . "," . $row->numcad . ",'Ativo','" . $row->nomfun . "'," . $row->codsetor . ",'" . $row->setor . "','" . $row->cargo . "','" . $data . "','Alexandre de Souza'," . $row->grains . ",'" . $row->desgra . "','C','N')";
            $aRetorno = $this->executaSql($sSqlInsert);
            $iNr++;
        }
    }

}
