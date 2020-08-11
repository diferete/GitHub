<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_FamProd extends Persistencia {

    public function __construct() {
        parent::__construct();
        $this->setTabela('PRO_GRUPOSUBGRUPOFAMILIA');

        $this->adicionaRelacionamento('PRO_GrupoCodigo', 'PRO_GrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_SubGrupoCodigo', 'PRO_SubGrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_FamiliaCodigo', 'PRO_FamiliaCodigo', true, true);
        $this->adicionaRelacionamento('PRO_FamiliaDescricao', 'PRO_FamiliaDescricao');
        $this->adicionaRelacionamento('PRO_FamiliaTipoControle', 'PRO_FamiliaTipoControle');
        $this->adicionaRelacionamento('PRO_FamiliaTipoDespesa', 'PRO_FamiliaTipoDespesa');
        $this->adicionaRelacionamento('PRO_FamiliaTipoReceita', 'PRO_FamiliaTipoReceita');
        $this->adicionaRelacionamento('PRO_FamiliaComprador', 'PRO_FamiliaComprador');
        $this->adicionaRelacionamento('PRO_FamiliaControleLote', 'PRO_FamiliaControleLote');
        $this->adicionaRelacionamento('PRO_FamiliaMovEstoque', 'PRO_FamiliaMovEstoque');
        $this->adicionaRelacionamento('PRO_FamiliaTipoCusto', 'PRO_FamiliaTipoCusto');

        $this->setSTop('50');
    }

}
