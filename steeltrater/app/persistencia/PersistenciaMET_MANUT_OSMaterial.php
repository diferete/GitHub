<?php

/*
 * Implementa a classe persistencia MET_MANUT_OSMaterial
 * @author Cleverton Hoffmann
 * @since 24/08/2021
 */

class PersistenciaMET_MANUT_OSMaterial extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_MANUT_OSMaterial');
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('cod', 'cod', true, true);
        $this->adicionaRelacionamento('codmat', 'codmat');
        $this->adicionaRelacionamento('descricaomat', 'descricaomat');
        $this->adicionaRelacionamento('usermatcod', 'usermatcod');
        $this->adicionaRelacionamento('usermatdes', 'usermatdes');
        $this->adicionaRelacionamento('datamat', 'datamat');
        $this->adicionaRelacionamento('quantidade', 'quantidade');
        $this->adicionaRelacionamento('obsmat', 'obsmat');
        $this->adicionaRelacionamento('processoCompra', 'processoCompra');
        $this->adicionaRelacionamento('numero', 'numero');
        $this->adicionaRelacionamento('quantMatSol', 'quantMatSol');

        $this->adicionaOrderBy('seq', 1);
        $this->setSTop('30');
    }

    public function inserirMat($aCamposChave) {
        date_default_timezone_set('America/Sao_Paulo');
        $data = date("d/m/y");
        $useRMatCod = $_SESSION['codUser'];
        $useRMatDes = $_SESSION['nome'];

        $sSql5 = 'SELECT COALESCE(MAX(numero),0)+1 AS proximo FROM MET_MANUT_OSMaterial';
        $obj = $this->consultaSql($sSql5);
        $inc1 = (int) $obj->proximo;

        $sSql = "INSERT INTO MET_MANUT_OSMaterial (seq, fil_codigo, nr, cod, codmat, descricaomat, usermatcod, usermatdes, datamat, quantidade, obsmat, processoCompra, numero, quantMatSol) "
                . "VALUES ('" . $aCamposChave['seq'] . "','" . $aCamposChave['fil_codigo'] . "','" . $aCamposChave['nr'] . "','" . $aCamposChave['cod'] . "','" . $aCamposChave['MET_MANUT_OSPesqProd_pro_codigo'] . "','" . str_replace("'", "''", $aCamposChave['matnecessario']) . "','" . $useRMatCod . "','" . $useRMatDes . "','" . $data . "','"
                . $aCamposChave['quantidade'] . "','" . $aCamposChave['obsmat'] . "', 'NÃO SOLICITADO', " . $inc1 . "," . $aCamposChave['quantidade'] . ")";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function excluirMat($aCamposChave) {
        $sSql = " DELETE MET_MANUT_OSMaterial "
                . "WHERE fil_codigo = " . $aCamposChave['fil_codigo']
                . " AND nr = " . $aCamposChave['nr']
                . " AND cod = " . $aCamposChave['cod']
                . " AND seq = " . $aCamposChave['seq'];
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function getIncrementoMat($oModelManut) {
        $sSql = " SELECT COALESCE(MAX(seq),0)+1 AS proximo FROM MET_MANUT_OSMaterial "
                . " WHERE fil_codigo = '" . $oModelManut->getFil_codigo() . "' "
                . " AND nr = '" . $oModelManut->getNr() . "' "
                . " AND cod = '" . $oModelManut->getCod() . "' ";

        $obj = $this->consultaSql($sSql);
        return $obj->proximo;
    }

}
