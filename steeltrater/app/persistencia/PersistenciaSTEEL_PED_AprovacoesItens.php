<?php

/*
 * Implementa a classe persistencia STEEL_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class PersistenciaSTEEL_PED_AprovacoesItens extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('SUP_PEDIDOITEM');

        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('sup_pedidoseq', 'sup_pedidoseq', true, true);
        $this->adicionaRelacionamento('sup_pedidoitemseq', 'sup_pedidoitemseq', true, true, true);
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo');
        $this->adicionaRelacionamento('pro_familiacodigo', 'pro_familiacodigo');
        $this->adicionaRelacionamento('sup_pedidoitemdescricao', 'sup_pedidoitemdescricao');
        $this->adicionaRelacionamento('sup_pedidoitemunidade', 'sup_pedidoitemunidade');
        $this->adicionaRelacionamento('sup_pedidoitemreferencia', 'sup_pedidoitemreferencia');
        $this->adicionaRelacionamento('sup_pedidoitemdimpecas', 'sup_pedidoitemdimpecas');
        $this->adicionaRelacionamento('sup_pedidoitemdimcomp', 'sup_pedidoitemdimcomp');
        $this->adicionaRelacionamento('sup_pedidoitemdimlarg', 'sup_pedidoitemdimlarg');
        $this->adicionaRelacionamento('sup_pedidoitemdimespe', 'sup_pedidoitemdimespe');
        $this->adicionaRelacionamento('sup_pedidoitemcomqtd', 'sup_pedidoitemcomqtd');
        $this->adicionaRelacionamento('sup_pedidoitemcomconv', 'sup_pedidoitemcomconv');
        $this->adicionaRelacionamento('sup_pedidoitemcomund', 'sup_pedidoitemcomund');
        $this->adicionaRelacionamento('sup_pedidoitemcomvalor', 'sup_pedidoitemcomvalor');
        $this->adicionaRelacionamento('sup_pedidoitemqtd', 'sup_pedidoitemqtd');
        $this->adicionaRelacionamento('sup_pedidoitemdataneces', 'sup_pedidoitemdataneces');
        $this->adicionaRelacionamento('sup_pedidoitemdataentrega', 'sup_pedidoitemdataentrega');
        $this->adicionaRelacionamento('sup_pedidoitemsituacao', 'sup_pedidoitemsituacao');
        $this->adicionaRelacionamento('sup_pedidoitemvalor', 'sup_pedidoitemvalor');
        $this->adicionaRelacionamento('sup_pedidoitemqtdreceb', 'sup_pedidoitemqtdreceb');
        $this->adicionaRelacionamento('sup_pedidoitemobservacao', 'sup_pedidoitemobservacao');
        $this->adicionaRelacionamento('sup_pedidoitemmargemtolqtd', 'sup_pedidoitemmargemtolqtd');
        $this->adicionaRelacionamento('sup_pedidoitemperdesconto', 'sup_pedidoitemperdesconto');
        $this->adicionaRelacionamento('sup_pedidoitemvlrdesconto', 'sup_pedidoitemvlrdesconto');
        $this->adicionaRelacionamento('sup_pedidoitempesobru', 'sup_pedidoitempesobru');
        $this->adicionaRelacionamento('sup_pedidoitempesoliq', 'sup_pedidoitempesoliq');
        $this->adicionaRelacionamento('sup_pedidoitemdimund', 'sup_pedidoitemdimund');
        $this->adicionaRelacionamento('sup_pedidoitemdimconv', 'sup_pedidoitemdimconv');
        $this->adicionaRelacionamento('sup_pedidoitemdimundconv', 'sup_pedidoitemdimundconv');
        $this->adicionaRelacionamento('sup_pedidoitemvalorfrete', 'sup_pedidoitemvalorfrete');
        $this->adicionaRelacionamento('sup_pedidoitemvalordespesa', 'sup_pedidoitemvalordespesa');
        $this->adicionaRelacionamento('sup_pedidoitemvalorseguro', 'sup_pedidoitemvalorseguro');
        $this->adicionaRelacionamento('sup_pedidoitemvalordesconto', 'sup_pedidoitemvalordesconto');
        $this->adicionaRelacionamento('sup_pedidoitemvalortotal', 'sup_pedidoitemvalortotal');
        $this->adicionaRelacionamento('sup_pedidoitemmargemtolvlr', 'sup_pedidoitemmargemtolvlr');
        $this->adicionaRelacionamento('sup_pedidoitemtipodesconto', 'sup_pedidoitemtipodesconto');
        $this->adicionaRelacionamento('sup_pedidoitemgrade', 'sup_pedidoitemgrade');
        $this->adicionaRelacionamento('sup_pedidoitemtipodespesacodig', 'sup_pedidoitemtipodespesacodig');
        $this->adicionaRelacionamento('sup_pedidoitemcentrocustocodig', 'sup_pedidoitemcentrocustocodig');
        $this->adicionaRelacionamento('sup_pedidoitemplano', 'sup_pedidoitemplano');
        $this->adicionaRelacionamento('sup_pedidoitemconta', 'sup_pedidoitemconta');
        $this->adicionaRelacionamento('sup_pedidoitemprojeto', 'sup_pedidoitemprojeto');
        $this->adicionaRelacionamento('sup_pedidoitemconversor', 'sup_pedidoitemconversor');
        $this->adicionaRelacionamento('sup_pedidoitemmarca', 'sup_pedidoitemmarca');
        $this->adicionaRelacionamento('sup_pedidoitemloteminimo', 'sup_pedidoitemloteminimo');
        $this->adicionaRelacionamento('sup_pedidoitemlotemultiplo', 'sup_pedidoitemlotemultiplo');
        $this->adicionaRelacionamento('sup_pedidoitemdimgqtd', 'sup_pedidoitemdimgqtd');
        $this->adicionaRelacionamento('sup_pedidoitemdimgformula', 'sup_pedidoitemdimgformula');
        $this->adicionaRelacionamento('sup_pedidoitemdimgexpres', 'sup_pedidoitemdimgexpres');
        $this->adicionaRelacionamento('sup_pedidoitemseqaprovacao', 'sup_pedidoitemseqaprovacao');
        $this->adicionaRelacionamento('sup_pedidoitemcomvalortabela', 'sup_pedidoitemcomvalortabela');
        $this->adicionaRelacionamento('sup_pedidoitemlote', 'sup_pedidoitemlote');
        $this->adicionaRelacionamento('sup_pedidoitemdataenvio', 'sup_pedidoitemdataenvio');
        $this->adicionaRelacionamento('sup_pedidoitemencmandatahr', 'sup_pedidoitemencmandatahr');
        $this->adicionaRelacionamento('sup_pedidoitemencmanusu', 'sup_pedidoitemencmanusu');
        $this->adicionaRelacionamento('sup_pedidoitemencmanjus', 'sup_pedidoitemencmanjus');
        $this->adicionaRelacionamento('sup_pedidoitemdimcalc', 'sup_pedidoitemdimcalc');
        $this->adicionaRelacionamento('sup_pedidoitemdataultupd', 'sup_pedidoitemdataultupd');
        $this->adicionaRelacionamento('sup_pedidoitemimportado', 'sup_pedidoitemimportado');
        $this->adicionaRelacionamento('sup_pedidoitemvaloracrescimo', 'sup_pedidoitemvaloracrescimo');
        $this->adicionaRelacionamento('sup_pedidoitemcontrato', 'sup_pedidoitemcontrato');
        $this->adicionaRelacionamento('sup_pedidoitemdataaprverba', 'sup_pedidoitemdataaprverba');
        $this->adicionaRelacionamento('sup_pedidoitemcontratoseq', 'sup_pedidoitemcontratoseq');

        $this->adicionaOrderBy('sup_pedidoitemseq', 1);
    }

}
