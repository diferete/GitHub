<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_PedidoItem
 * 
 * @author Cleverton Hoffmann
 * @since 27/11/2018
 */

class PersistenciaSTEEL_PCP_PedidoItem extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PDV_PEDIDOITEMI');

        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial', true, true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo',true, true);
        $this->adicionaRelacionamento('pdv_pedidoitemseq', 'pdv_pedidoitemseq', true, true);
        $this->adicionaRelacionamento('pdv_pedidoitemiimposto', 'pdv_pedidoitemiimposto', true,true);
        $this->adicionaRelacionamento('PDV_PedidoItemIRegra', 'PDV_PedidoItemIRegra');
        $this->adicionaRelacionamento('PDV_PedidoItemIFormula', 'PDV_PedidoItemIFormula');
        $this->adicionaRelacionamento('PDV_PedidoItemICFOP', 'PDV_PedidoItemICFOP');
        $this->adicionaRelacionamento('PDV_PedidoItemICST', 'PDV_PedidoItemICST');
        $this->adicionaRelacionamento('PDV_PedidoItemIBCalculo', 'PDV_PedidoItemIBCalculo');
        $this->adicionaRelacionamento('PDV_PedidoItemIAliquota', 'PDV_PedidoItemIAliquota');
        $this->adicionaRelacionamento('PDV_PedidoItemIValor', 'PDV_PedidoItemIValor');
        $this->adicionaRelacionamento('PDV_PedidoItemIIsentas', 'PDV_PedidoItemIIsentas');
        $this->adicionaRelacionamento('PDV_PedidoItemIOutras', 'PDV_PedidoItemIOutras');
        $this->adicionaRelacionamento('PDV_PedidoItemIRegraBase', 'PDV_PedidoItemIRegraBase');
        $this->adicionaRelacionamento('PDV_PedidoItemIImpostoFiscal', 'PDV_PedidoItemIImpostoFiscal');
        $this->adicionaRelacionamento('PDV_PedidoItemIRegraReducao', 'PDV_PedidoItemIRegraReducao');
        $this->adicionaRelacionamento('PDV_PedidoItemIClasseNF', 'PDV_PedidoItemIClasseNF');
        $this->adicionaRelacionamento('PDV_PedidoItemIClasseFN', 'PDV_PedidoItemIClasseFN');
        $this->adicionaRelacionamento('PDV_PedidoItemIFatura', 'PDV_PedidoItemIFatura');
        $this->adicionaRelacionamento('PDV_PedidoItemIParcela', 'PDV_PedidoItemIParcela');
        $this->adicionaRelacionamento('PDV_PedidoItemIMVA', 'PDV_PedidoItemIMVA');
        $this->adicionaRelacionamento('PDV_PedidoItemIValorUnidade', 'PDV_PedidoItemIValorUnidade');
        $this->adicionaRelacionamento('PDV_PedidoItemIRegraRedAliq', 'PDV_PedidoItemIRegraRedAliq');

        $this->setSTop('1000');
        $this->adicionaOrderBy('pdv_pedidoitemseq', 0);
    }

}
