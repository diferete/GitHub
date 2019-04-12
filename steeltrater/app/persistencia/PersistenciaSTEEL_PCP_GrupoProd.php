<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_GrupoProd extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_GRUPO');

        $this->adicionaRelacionamento('PRO_GrupoCodigo', 'PRO_GrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_GrupoDescricao', 'PRO_GrupoDescricao');
        $this->adicionaRelacionamento('PRO_GrupoTipo', 'PRO_GrupoTipo');
        $this->adicionaRelacionamento('PRO_GrupoTipoControle', 'PRO_GrupoTipoControle');
        $this->adicionaRelacionamento('PRO_GrupoTipoDespesa', 'PRO_GrupoTipoDespesa');
        $this->adicionaRelacionamento('PRO_GrupoTipoReceita', 'PRO_GrupoTipoReceita');
        $this->adicionaRelacionamento('GRS_GrupoPH', 'GRS_GrupoPH');
        $this->adicionaRelacionamento('PRO_GrupoComprador', 'PRO_GrupoComprador');
        $this->adicionaRelacionamento('PRO_GrupoControleLote', 'PRO_GrupoControleLote');
        $this->adicionaRelacionamento('PRO_GrupoMovEstoque', 'PRO_GrupoMovEstoque');
        $this->adicionaRelacionamento('PRO_GrupoTipoCusto', 'PRO_GrupoTipoCusto');
    }

}
