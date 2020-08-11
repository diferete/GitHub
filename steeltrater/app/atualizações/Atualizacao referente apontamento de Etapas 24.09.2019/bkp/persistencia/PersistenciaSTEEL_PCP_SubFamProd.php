<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_SubFamProd extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_GRUPOSUBGRUPOFAMILIASUBFAM');


        $this->adicionaRelacionamento('PRO_GrupoCodigo', 'PRO_GrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_SubGrupoCodigo', 'PRO_SubGrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_FamiliaCodigo', 'PRO_FamiliaCodigo', true, true);
        $this->adicionaRelacionamento('PRO_SubFamiliaCodigo', 'PRO_SubFamiliaCodigo', true, true);
        $this->adicionaRelacionamento('PRO_SubFamiliaDescricao', 'PRO_SubFamiliaDescricao');
        $this->adicionaRelacionamento('PRO_SubFamiliaProDescricao', 'PRO_SubFamiliaProDescricao');
        $this->adicionaRelacionamento('PRO_SubFamiliaProDescTec', 'PRO_SubFamiliaProDescTec');
        $this->adicionaRelacionamento('PRO_SubFamiliaProFormataDesc', 'PRO_SubFamiliaProFormataDesc');
        $this->adicionaRelacionamento('PRO_SubFamiliaTipoControle', 'PRO_SubFamiliaTipoControle');
        $this->adicionaRelacionamento('PRO_SubFamiliaTipoDespesa', 'PRO_SubFamiliaTipoDespesa');
        $this->adicionaRelacionamento('PRO_SubFamiliaTipoReceita', 'PRO_SubFamiliaTipoReceita');
        $this->adicionaRelacionamento('PRO_SubFamiliaProdutoBase', 'PRO_SubFamiliaProdutoBase');
        $this->adicionaRelacionamento('PRO_SubFamiliaSequencialProdut', 'PRO_SubFamiliaSequencialProdut');
        $this->adicionaRelacionamento('PRO_SubFamiliaComprador', 'PRO_SubFamiliaComprador');
        $this->adicionaRelacionamento('PRO_SubFamiliaControleLote', 'PRO_SubFamiliaControleLote');
        $this->adicionaRelacionamento('PRO_SubFamiliaMovEstoque', 'PRO_SubFamiliaMovEstoque');
        $this->adicionaRelacionamento('PRO_SubFamiliaTipoCusto', 'PRO_SubFamiliaTipoCusto');
    }

}
