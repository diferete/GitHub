<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_FuncDesc extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_FuncDesc');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true);
        $this->adicionaRelacionamento('nr', 'nr', true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('descricao', 'descricao');
        $this->adicionaRelacionamento('data_revisao', 'data_revisao');
        $this->adicionaRelacionamento('revisao', 'revisao');
        $this->adicionaRelacionamento('observacao', 'observacao');
        $this->adicionaRelacionamento('esc_exigida', 'esc_exigida');
        $this->adicionaRelacionamento('esc_recomendada', 'esc_recomendada');
        $this->adicionaRelacionamento('arquivo', 'arquivo', false, true, false, 3);

        $this->adicionaOrderBy('seq', 1);
    }

    public function deletaDescricao($sFilcgc, $sNr, $sSeq) {
        //deletar planos existentes
        $sDelete = "delete MET_ISO_FuncDesc where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "' and seq = '" . $sSeq . "' ";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

}
