<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_RegistroTreinamento extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_RegistroTreinamento');

        $this->adicionaRelacionamento('nr', 'nr', true);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('data_treinamento', 'data_treinamento');
        $this->adicionaRelacionamento('titulo_treinamento', 'titulo_treinamento');
        $this->adicionaRelacionamento('anexo_treinamento', 'anexo_treinamento', false, true, false, 3);
        $this->adicionaRelacionamento('observacao', 'observacao');

        $this->adicionaOrderBy('seq', 1);
    }

    public function deletaRgistroTreinamento($sFilcgc, $sNr, $sSeq) {
        //deletar planos existentes
        $sDelete = "delete MET_ISO_RegistroTreinamento where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "' and seq = '" . $sSeq . "' ";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

}
