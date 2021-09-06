<?php

/*
 * Implementa a classe persistencia STEEL_SOL_AprovacoesItens
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class PersistenciaSTEEL_SOL_AprovacoesItens extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('sup_solicitacaoitem');

        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('sup_solicitacaoseq', 'sup_solicitacaoseq', true, true);
        $this->adicionaRelacionamento('sup_solicitacaoitemseq', 'sup_solicitacaoitemseq', true, true, true);
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo');
        $this->adicionaRelacionamento('sup_prioridadecodigo', 'sup_prioridadecodigo');
        $this->adicionaRelacionamento('sup_solicitacaoitemdescricao', 'sup_solicitacaoitemdescricao');
        $this->adicionaRelacionamento('sup_solicitacaoitemunidade', 'sup_solicitacaoitemunidade');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimpecas', 'sup_solicitacaoitemdimpecas');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimcomprime', 'sup_solicitacaoitemdimcomprime');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimlargura', 'sup_solicitacaoitemdimlargura');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimespessur', 'sup_solicitacaoitemdimespessur');
        $this->adicionaRelacionamento('sup_solicitacaoitemcomqtd', 'sup_solicitacaoitemcomqtd');
        $this->adicionaRelacionamento('sup_solicitacaoitemcomconv', 'sup_solicitacaoitemcomconv');
        $this->adicionaRelacionamento('sup_solicitacaoitemcomund', 'sup_solicitacaoitemcomund');
        $this->adicionaRelacionamento('sup_solicitacaoitemqtd', 'sup_solicitacaoitemqtd');
        $this->adicionaRelacionamento('sup_solicitacaoitemdatanecessi', 'sup_solicitacaoitemdatanecessi');
        $this->adicionaRelacionamento('sup_solicitacaoitemususol', 'sup_solicitacaoitemususol');
        $this->adicionaRelacionamento('sup_solicitacaoitemusucom', 'sup_solicitacaoitemusucom');
        $this->adicionaRelacionamento('sup_solicitacaoitemobservacao', 'sup_solicitacaoitemobservacao');
        $this->adicionaRelacionamento('sup_solicitacaoitemreferencia', 'sup_solicitacaoitemreferencia');
        $this->adicionaRelacionamento('sup_solicitacaoitemvalor', 'sup_solicitacaoitemvalor');
        $this->adicionaRelacionamento('sup_solicitacaoitempesoliq', 'sup_solicitacaoitempesoliq');
        $this->adicionaRelacionamento('sup_solicitacaoitempesobru', 'sup_solicitacaoitempesobru');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimunidade', 'sup_solicitacaoitemdimunidade');
        $this->adicionaRelacionamento('sup_solicitacaoitemdataaprverb', 'sup_solicitacaoitemdataaprverb');
        $this->adicionaRelacionamento('sup_solicitacaoitemvalortotal', 'sup_solicitacaoitemvalortotal');
        $this->adicionaRelacionamento('sup_solicitacaoitemsituacao', 'sup_solicitacaoitemsituacao');
        $this->adicionaRelacionamento('sup_solicitacaoitemgrade', 'sup_solicitacaoitemgrade');
        $this->adicionaRelacionamento('sup_solicitacaoitemtipodespcod', 'sup_solicitacaoitemtipodespcod');
        $this->adicionaRelacionamento('sup_solicitacaoitemcctcodigo', 'sup_solicitacaoitemcctcodigo');
        $this->adicionaRelacionamento('sup_solicitacaoitemplano', 'sup_solicitacaoitemplano');
        $this->adicionaRelacionamento('sup_solicitacaoitemconta', 'sup_solicitacaoitemconta');
        $this->adicionaRelacionamento('sup_solicitacaoitemprojeto', 'sup_solicitacaoitemprojeto');
        $this->adicionaRelacionamento('sup_solicitacaoitemoritipo', 'sup_solicitacaoitemoritipo');
        $this->adicionaRelacionamento('sup_solicitacaoitemorinumero', 'sup_solicitacaoitemorinumero');
        $this->adicionaRelacionamento('sup_solicitacaoitemoriitem', 'sup_solicitacaoitemoriitem');
        $this->adicionaRelacionamento('sup_solicitacaoitemconversor', 'sup_solicitacaoitemconversor');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimconv', 'sup_solicitacaoitemdimconv');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimundconv', 'sup_solicitacaoitemdimundconv');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimgqtd', 'sup_solicitacaoitemdimgqtd');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimgformula', 'sup_solicitacaoitemdimgformula');
        $this->adicionaRelacionamento('sup_solicitacaoitemdimgexpres', 'sup_solicitacaoitemdimgexpres');
        $this->adicionaRelacionamento('sup_solicitacaoitemdataentrega', 'sup_solicitacaoitemdataentrega');
        $this->adicionaRelacionamento('sup_solicitacaoitemposicao', 'sup_solicitacaoitemposicao');

        $this->adicionaOrderBy('sup_solicitacaoitemseq', 1);
    }

    public function alteraQt($sValor, $sCNPJ, $sSeq, $sItemSeq) {
        $sSql = "update sup_solicitacaoitem "
                . "set sup_solicitacaoitemqtd = '" . $sValor . "',"
                . "sup_solicitacaoitemcomqtd = '" . $sValor . "' "
                . "where fil_codigo= " . $sCNPJ . " "
                . "and sup_solicitacaoseq = " . $sSeq . " "
                . "and sup_solicitacaoitemseq = " . $sItemSeq . " ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
