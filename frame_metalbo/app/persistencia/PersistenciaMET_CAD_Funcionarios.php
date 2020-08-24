<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_CAD_Funcionarios extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbfunc');

        $this->adicionaRelacionamento('numcad', 'numcad');
        $this->adicionaRelacionamento('nomfun', 'nomfun');
        $this->adicionaRelacionamento('cpf', 'cpf');
        $this->adicionaRelacionamento('cargo', 'cargo');
        $this->adicionaRelacionamento('cnpj', 'cnpj');
        $this->adicionaRelacionamento('sit', 'sit');

        $this->adicionaFiltro('cnpj', $_SESSION['filcgc']);
        $this->adicionaFiltro('sit', 'Inativo', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);

        $this->setSTop(50);
    }

}
