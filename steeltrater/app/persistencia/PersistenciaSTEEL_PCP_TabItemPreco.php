<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_TabItemPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2019
 */

class PersistenciaSTEEL_PCP_TabItemPreco extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_TabItemPreco');

        $this->adicionaRelacionamento('nr', 'nr', true,true);
        $this->adicionaRelacionamento('seq', 'seq', true,true,true);
        $this->adicionaRelacionamento('receita', 'STEEL_PCP_receitas.cod', false,false);
        $this->adicionaRelacionamento('receita','receita');
        $this->adicionaRelacionamento('prod', 'STEEL_PCP_Produtos.pro_codigo', false,false);
        $this->adicionaRelacionamento('prod', 'prod');
        $this->adicionaRelacionamento('preco', 'preco');
        $this->adicionaRelacionamento('tipo','tipo');
        $this->adicionaRelacionamento('cod','cod');
        

        $this->setSTop('500');
        $this->adicionaJoin('STEEL_PCP_receitas', null,1, 'receita','cod');
        $this->adicionaJoin('STEEL_PCP_Produtos', null,1, 'prod','pro_codigo');
       
        $this->adicionaOrderBy('nr',1);
        $this->adicionaOrderBy('seq',1);
    }

     public function alteraPreco($sValor,$sNr,$sSeq){
        $sSql="update STEEL_PCP_TabItemPreco set preco ='".$sValor."' where nr='".$sNr."' and seq ='".$sSeq."'    ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
}