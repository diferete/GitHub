<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualDiagramaCausa extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_QUAL_DiagramaCausa');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('matprimades', 'matprimades');
        $this->adicionaRelacionamento('metododes', 'metododes');
        $this->adicionaRelacionamento('maodeobrades', 'maodeobrades');
        $this->adicionaRelacionamento('equipamentodes', 'equipamentodes');
        $this->adicionaRelacionamento('meioambientedes', 'meioambientedes');
        $this->adicionaRelacionamento('medidades', 'medidades');

        $this->adicionaOrderBy('seq', 1);
    }

}
