<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_Preco
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */

class PersistenciaSTEEL_PCP_Preco extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('TPV_TABELAPRECO');

        $this->adicionaRelacionamento('tpv_codigo', 'tpv_codigo', true, true,true);
        $this->adicionaRelacionamento('CID_RegiaoCodigo', 'CID_RegiaoCodigo');
        $this->adicionaRelacionamento('CPG_Codigo', 'CPG_Codigo');
        $this->adicionaRelacionamento('MOE_Codigo', 'MOE_Codigo');
        $this->adicionaRelacionamento('TPV_Descricao', 'TPV_Descricao');
        $this->adicionaRelacionamento('TPV_Ativa', 'TPV_Ativa');
        $this->adicionaRelacionamento('TPV_ClienteCodigo', 'TPV_ClienteCodigo');
        $this->adicionaRelacionamento('TPV_DataInicio', 'TPV_DataInicio');
        $this->adicionaRelacionamento('TPV_Comissao', 'TPV_Comissao');
        $this->adicionaRelacionamento('TPV_ComissaoInclusa', 'TPV_ComissaoInclusa');
        $this->adicionaRelacionamento('TPV_Markup', 'TPV_Markup');
        $this->adicionaRelacionamento('TPV_MargemNegociacao', 'TPV_MargemNegociacao');
        $this->adicionaRelacionamento('TPV_Desconto', 'TPV_Desconto');
        $this->adicionaRelacionamento('TPV_ArredondaPreco', 'TPV_ArredondaPreco');
        $this->adicionaRelacionamento('TPV_ICMSIncluso', 'TPV_ICMSIncluso');
        $this->adicionaRelacionamento('TPV_DataBase', 'TPV_DataBase');
        $this->adicionaRelacionamento('FRE_TipoFreteCodigo', 'FRE_TipoFreteCodigo');
        $this->adicionaRelacionamento('TPV_Cupom', 'TPV_Cupom');
        $this->adicionaRelacionamento('TPV_LimiteDesconto', 'TPV_LimiteDesconto');
        $this->adicionaRelacionamento('TPV_DataValidade', 'TPV_DataValidade');
        $this->adicionaRelacionamento('TPV_ConverteMoedaDigitacaoPedi', 'TPV_ConverteMoedaDigitacaoPedi');
        $this->adicionaRelacionamento('TPV_TabelaPrecoAVPIndice', 'TPV_TabelaPrecoAVPIndice');
        $this->adicionaRelacionamento('TPV_TabelaPrecoAssociado', 'TPV_TabelaPrecoAssociado');
        $this->adicionaRelacionamento('TPV_TabelaPrecoFormula', 'TPV_TabelaPrecoFormula');
        $this->adicionaRelacionamento('TPV_TabelaPrecoUsaVctoFixo', 'TPV_TabelaPrecoUsaVctoFixo');
        $this->adicionaRelacionamento('TPV_ValorFreteTon', 'TPV_ValorFreteTon');
        
        $this->setSTop('100');
        
        $this->adicionaOrderBy('tpv_codigo',1);
    }

}