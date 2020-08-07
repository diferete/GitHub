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
class PersistenciaMET_QUAL_QualPlan extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_QUAL_qualplan');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('plano', 'plano');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('datafim', 'datafim');
        $this->adicionaRelacionamento('obsfim', 'obsfim');
        $this->adicionaRelacionamento('sitfim', 'sitfim');
        $this->adicionaRelacionamento('anexoplan1', 'anexoplan1', false, true, false, 3); //tipo arquivo
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('anexofim', 'anexofim', false, true, false, 3); //tipo arquivo
        $this->adicionaRelacionamento('tipo', 'tipo');
        $this->adicionaRelacionamento('nrEfi', 'nrEfi');
        $this->adicionaRelacionamento('procedimento', 'procedimento');
        $this->adicionaRelacionamento('it', 'it');
        $this->adicionaRelacionamento('planocontrole', 'planocontrole');
        $this->adicionaRelacionamento('fluxograma', 'fluxograma');
        $this->adicionaRelacionamento('ppap', 'ppap');
        $this->adicionaRelacionamento('contexto', 'contexto');
        $this->adicionaRelacionamento('preventiva', 'preventiva');
        $this->adicionaRelacionamento('funcao', 'funcao');
        $this->adicionaRelacionamento('treinamento', 'treinamento');

        $this->adicionaOrderBy('seq', 1);
    }

    /**
     * insere um plano de acao manualmente
     */
    public function inserAq($aCampos) {
        $this->adicionaFiltro('filcgc', $aCampos['filcgc']);
        $this->adicionaFiltro('nr', $aCampos['nr']);
        $this->setChaveIncremento(false);
        $iInc = $this->getIncremento('seq', true);

        $sInsert = "insert into MET_QUAL_qualplan (filcgc,nr,seq,plano,dataprev,anexoplan1,usucodigo,usunome,tipo,nrefi)
      values('" . $aCampos['filcgc'] . "','" . $aCampos['nr'] . "','" . $iInc . "',"
                . "'" . $aCampos['plano'] . "','" . $aCampos['dataprevplan'] . "',"
                . "'" . $aCampos['anexoplan1'] . "','" . $aCampos['usucodigo'] . "','" . $aCampos['usunome'] . "','" . $aCampos['tipo'] . "','" . $aCampos['seq'] . "')";

        $aRet = $this->executaSql($sInsert);

        //deletar planos existentes
        $sDelete = "delete tbacaoeficazPlan where filcgc = '" . $aCampos['filcgc'] . "' and nr ='" . $aCampos['nr'] . "' and seq = '" . $aCampos['seq'] . "' and nrAcao ='" . $iInc . "'  ";
        $aDelete = $this->executaSql($sDelete);

        //da um update colocando a acao correta na tabela de eficácia
        $sInsAfPlan = "insert into tbacaoeficazPlan (filcgc,nr,seq,nrAcao) values ('" . $aCampos['filcgc'] . "','" . $aCampos['nr'] . "','" . $aCampos['seq'] . "','" . $iInc . "')";
        $aInsAfPlan = $this->executaSql($sInsAfPlan);

        //da um update na eficácia para setar como com plano de ação
        $sUpdateAcao = "update MET_QUAL_acaoeficaz set comacao = 'S' where filcgc = '" . $aCampos['filcgc'] . "' and nr ='" . $aCampos['nr'] . "' and seq = '" . $aCampos['seq'] . "' ";
        $aUpdateAcao = $this->executaSql($sUpdateAcao);

        return $aRet;
    }

    public function deletaEficazPlan($sFilcgc, $sNr, $sAcao) {
        //deletar planos existentes
        $sDelete = "delete MET_QUAL_qualplan where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "' and nrAcao = '" . $sAcao . "' ";
        $aDelete = $this->executaSql($sDelete);
        return $aDelete;
    }

    public function apontaPlano() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aCampos['obsfim'] = $this->preparaString($aCampos['obsfim']);

        $sSql = "update MET_QUAL_qualplan set funcao='" . $aCampos['funcao'] . "',treinamento='" . $aCampos['treinamento'] . "',preventiva='" . $aCampos['preventiva'] . "',"
                . "contexto='" . $aCampos['contexto'] . "',ppap='" . $aCampos['ppap'] . "',planocontrole='" . $aCampos['planocontrole'] . "',it='" . $aCampos['it'] . "',"
                . "procedimento='" . $aCampos['procedimento'] . "',fluxograma='" . $aCampos['fluxograma'] . "',datafim = '" . $aCampos['datafim'] . "',"
                . "obsfim = '" . $aCampos['obsfim'] . "', sitfim = 'Finalizado', anexofim = '" . $aCampos['anexofim'] . "'
        where filcgc ='" . $aCampos['filcgc'] . "' and nr = '" . $aCampos['nr'] . "' and seq = '" . $aCampos['seq'] . "' ";

        $aRet = $this->executaSql($sSql);
        return $aRet;
    }

    public function retPlano() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sSql = "update MET_QUAL_qualplan set datafim = null,obsfim = '', sitfim = null 
        where filcgc ='" . $aCampos['filcgc'] . "' and nr = '" . $aCampos['nr'] . "' and seq = '" . $aCampos['seq'] . "' ";

        $aRet = $this->executaSql($sSql);
        return $aRet;
    }

    public function buscaParam($aDados) {
        $sSql = "select * from MET_QUAL_qualplan where filcgc = '" . $aDados[0] . "' and nr = '" . $aDados[1] . "' and seq = '" . $aDados[2] . "' ";

        $oRow = $this->consultaSql($sSql);

        return $oRow;
    }

}
