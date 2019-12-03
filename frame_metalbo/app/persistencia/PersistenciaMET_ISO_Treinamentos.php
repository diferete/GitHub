<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_ISO_Treinamentos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_ISO_Treinamentos');
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('cracha', 'cracha');
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('funcao', 'funcao');
        $this->adicionaRelacionamento('data_cad', 'data_cad');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('updates', 'updates');
    }

    public function buscaDadosFunc($aDados) {
        $sSql = 'select nomfun,cargo,sit,setor from tbfunc where numcad = ' . $aDados['cracha'];
        $oDados = $this->consultaSql($sSql);
        return $oDados;
    }

    public function deletaDependencias($aDados) {

        $sSql = "delete from MET_ISO_RegistroTreinamento where nr =" . $aDados[1] . "  and filcgc = " . $aDados[0];
        $this->executaSql($sSql);
    }

}
