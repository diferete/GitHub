<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerTEC_Testes extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('TEC_Testes');
    }

    /* pega os dados da tabela com os dados do Excel e insere em outra tabela com todos os códigos de acabamentos */

    public function populaTabelaPrecoNovo() {
        $this->Persistencia->populaTabelaPrecoNovo();
    }

    public function verificaMovProduto() {
        $this->Persistencia->verificaMovProduto();
    }

}
