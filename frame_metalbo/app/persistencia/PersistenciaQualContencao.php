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
class PersistenciaQualContencao extends Persistencia {

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
        $this->adicionaRelacionamento('apontamento', 'apontamento');
        $this->adicionaRelacionamento('dtaponta', 'dtaponta');

        $this->adicionaOrderBy('seq', 1);
    }

    public function deletaContencao($sFilcgc, $sNr, $sAcao) {
        //deletar planos existentes
        $sDelete = "delete MET_QUAL_Contencao where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "' and nrAcao = '" . $sAcao . "' ";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

    public function buscaTipoAcao($aDados) {
        $sSql = "select tipoacao from tbacaoqual where filcgc = '" . $aDados[0] . "' and nr = '" . $aDados[1] . "'";
        $oResult = $this->consultaSql($sSql);
        return $oResult->tipoacao;
    }

    public function apontaContencao() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aCampos['obsfim'] = $this->preparaString($aCampos['obsfim']);

        $sSql = "update MET_QUAL_Contencao set dtaponta = '" . $aCampos['dtaponta'] . "',"
                . "apontamento = '" . $aCampos['apontamento'] . "', situaca = 'Finalizado'"
                . "where filcgc ='" . $aCampos['filcgc'] . "' and nr = '" . $aCampos['nr'] . "' and seq = '" . $aCampos['seq'] . "' ";

        $aRet = $this->executaSql($sSql);
        return $aRet;
    }

    public function retContencao() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sSql = "update MET_QUAL_Contencao set dtaponta = null,apontamento = '', situaca = null 
        where filcgc ='" . $aCampos['filcgc'] . "' and nr = '" . $aCampos['nr'] . "' and seq = '" . $aCampos['seq'] . "' ";

        $aRet = $this->executaSql($sSql);
        return $aRet;
    }

    public function buscaParam($aDados) {
        $sSql = "select * from MET_QUAL_Contencao where filcgc = '" . $aDados[0] . "' and nr = '" . $aDados[1] . "' and seq = '" . $aDados[2] . "' ";

        $oRow = $this->consultaSql($sSql);

        return $oRow;
    }

}
