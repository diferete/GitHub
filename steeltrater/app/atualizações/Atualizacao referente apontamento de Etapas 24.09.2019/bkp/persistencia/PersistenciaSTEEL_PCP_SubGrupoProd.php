<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_SubGrupoProd extends Persistencia {

    public function __construct() {
        parent::__construct();
        $this->setTabela('PRO_GRUPOSUBGRUPO');

        $this->adicionaRelacionamento('PRO_GrupoCodigo', 'PRO_GrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_SubGrupoCodigo', 'PRO_SubGrupoCodigo', true, true);
        $this->adicionaRelacionamento('PRO_SubGrupoDescricao', 'PRO_SubGrupoDescricao');
        $this->adicionaRelacionamento('PRO_SubGrupoTipoControle', 'PRO_SubGrupoTipoControle');
        $this->adicionaRelacionamento('PRO_SubGrupoTipoDespesa', 'PRO_SubGrupoTipoDespesa');
        $this->adicionaRelacionamento('PRO_SubGrupoTipoReceita', 'PRO_SubGrupoTipoReceita');
        $this->adicionaRelacionamento('PRO_SubGrupoFatCorSeq', 'PRO_SubGrupoFatCorSeq');
        $this->adicionaRelacionamento('GRS_GrupoSubGrupoPH', 'GRS_GrupoSubGrupoPH');
        $this->adicionaRelacionamento('PRO_SubGrupoCCT', 'PRO_SubGrupoCCT');
        $this->adicionaRelacionamento('PRO_GrupoSubGrupoComprador', 'PRO_GrupoSubGrupoComprador');
        $this->adicionaRelacionamento('PRO_GrupoSubGrupoControleLote', 'PRO_GrupoSubGrupoControleLote');
        $this->adicionaRelacionamento('PRO_GrupoSubGrupoMovEstoque', 'PRO_GrupoSubGrupoMovEstoque');
        $this->adicionaRelacionamento('PRO_GrupoSubGrupoTipoCusto', 'PRO_GrupoSubGrupoTipoCusto');

        $this->setSTop('50');
    }

}
