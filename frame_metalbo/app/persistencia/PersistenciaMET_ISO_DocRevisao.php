<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_DocRevisao extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_DocRevisao');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true);
        $this->adicionaRelacionamento('nr', 'nr', true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('descricao', 'descricao');
        $this->adicionaRelacionamento('data_revisao', 'data_revisao');
        $this->adicionaRelacionamento('revisao', 'revisao');
        $this->adicionaRelacionamento('observacao', 'observacao');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('arquivo', 'arquivo', false, true, false, 3);

        $this->adicionaOrderBy('seq', 1);
    }

    public function getDadosDocumento($aDados) {
        $sSql = 'select documento from MET_ISO_Documentos where nr =' . $aDados[1] . ' and filcgc = ' . $aDados[0];
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno->documento;
    }
    
    public function deletaDocumento($sFilcgc, $sNr, $sSeq) {
        //deletar planos existentes
        $sDelete = "delete from MET_ISO_DocRevisao where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "' and seq = '" . $sSeq . "' ";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

}
