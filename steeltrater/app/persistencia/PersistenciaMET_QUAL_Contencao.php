<?php

/**
 * Class responsável pela acao de persistencia 
 * 
 * @author Avanei Martendal
 * 
 * @since 01/06/2017
 * 
 * @obs A classe é executada após a inserção do cabeçalho da acao da qualidade
 */
class PersistenciaMET_QUAL_Contencao extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_QUAL_Contencao');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('plano', 'plano');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('anexoplan1', 'anexoplan1', false, true, false, 3); //tipo arquivo
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('tipo', 'tipo');
        $this->adicionaRelacionamento('situaca', 'situaca');

        $this->adicionaOrderBy('seq', 1);
    }

    public function deletaContencao($sFilcgc, $sNr, $sAcao) {
        //deletar planos existentes
        $sDelete = "delete MET_QUAL_Contencao where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "' and nrAcao = '" . $sAcao . "' ";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

    public function buscaTipoAcao($aDados) {
        $sSql = "select tipoacao from MET_QUAL_qualaq where filcgc = '" . $aDados[0] . "' and nr = '" . $aDados[1] . "'";
        $oResult = $this->consultaSql($sSql);
        return $oResult->tipoacao;
    }

}
