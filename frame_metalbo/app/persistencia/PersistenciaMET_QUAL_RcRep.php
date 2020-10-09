<?php

/*
 * Classe que implementa a Persistencia da classe MET_QUAL_RcRep
 * 
 * @author Avanei Martendal
 * @since 10/09/2017
 */

class PersistenciaMET_QUAL_RcRep extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbrncqual');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('empcod', 'Pessoa.empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('celular', 'celular');
        $this->adicionaRelacionamento('email', 'email');
        $this->adicionaRelacionamento('contato', 'contato');
        $this->adicionaRelacionamento('ind', 'ind');
        $this->adicionaRelacionamento('comer', 'comer');

        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('datains', 'datains');
        $this->adicionaRelacionamento('horains', 'horains');

        $this->adicionaRelacionamento('nf', 'nf');
        $this->adicionaRelacionamento('datanf', 'datanf');
        $this->adicionaRelacionamento('odcompra', 'odcompra');
        $this->adicionaRelacionamento('pedido', 'pedido');
        $this->adicionaRelacionamento('valor', 'valor');
        $this->adicionaRelacionamento('peso', 'peso');

        $this->adicionaRelacionamento('lote', 'lote');
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('naoconf', 'naoconf');

        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('aplicacao', 'aplicacao');
        $this->adicionaRelacionamento('quant', 'quant');

        $this->adicionaRelacionamento('quantnconf', 'quantnconf');
        $this->adicionaRelacionamento('disposicao', 'disposicao');

        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('anexo3', 'anexo3');

        $this->adicionaRelacionamento('officecod', 'officecod');
        $this->adicionaRelacionamento('officedes', 'officedes');

        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('reclamacao', 'reclamacao');
        $this->adicionaRelacionamento('devolucao', 'devolucao');

        $this->adicionaRelacionamento('obsSit', 'obsSit');

        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');
        $this->adicionaRelacionamento('repcod', 'repcod');
        $this->adicionaRelacionamento('usuaponta', 'usuaponta');

        $this->adicionaRelacionamento('obs_aponta', 'obs_aponta');
        $this->adicionaRelacionamento('produtos', 'produtos');

        $this->adicionaRelacionamento('tagexcecao', 'tagexcecao');
        
        $this->adicionaRelacionamento('procedencia', 'procedencia');

        $this->adicionaJoin('Pessoa');

        if (isset($_SESSION['repoffice'])) {

            $this->adicionaFiltro('officecod', $_SESSION['repoffice']);
        }

        $this->adicionaOrderBy('nr', 1);

        $this->setSTop(50);
    }

    public function consultaNf($sNfnro) {
        $sSql = "select nfsnfnro,nfsclicgc,nfsclinome,convert(varchar,nfsdtemiss,103)as data,nfspesolq,nfsvlrtot 
                from widl.nfc001 where nfsnfnro ='" . $sNfnro . "' and nfsnfser = 2";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    public function verifSitRC($aDados) {
        $sSql = "select situaca,reclamacao,devolucao"
                . " from tbrncqual"
                . " where filcgc= " . $aDados['filcgc'] . " and nr= " . $aDados['nr'] . " ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aSit = array();
        $aSit[0] = $oRow->situaca;
        $aSit[1] = $oRow->reclamacao;
        $aSit[2] = $oRow->devolucao;

        return $aSit;
    }

    //Libera RC para vendas-Metalbo
    public function liberaRC($aDados) {
        $sSql = "update tbrncqual set situaca ='Liberado'"
                . "where filcgc ='" . $aDados['filcgc'] . "' and nr ='" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaRespEscritório() {
        $sSql = "select officeresp "
                . "from tbrepoffice where officecod =" . $_SESSION['repoffice'];
        $result1 = $this->getObjetoSql($sSql);
        $oRow1 = $result1->fetch(PDO::FETCH_OBJ);
        $sCodResp = $oRow1->officeresp;


        $sSql = "select usucodigo,usunome "
                . "from tbusuario where usucodigo =" . $sCodResp;
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->usucodigo;
        $aRetorno[1] = $oRow->usunome;

        return $aRetorno;
    }

    public function buscaRespVenda($sDados) {
        $sSql = "select resp_venda_cod,resp_venda_nome"
                . " from tbrepcodoffice"
                . " where repcod = '" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->resp_venda_cod;
        $aRetorno[1] = $oRow->resp_venda_nome;

        return $aRetorno;
    }

    public function buscaDadosRC($aDados) {
        $sSql = "select * from tbrncqual"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $oResult = $this->consultaSql($sSql);
        return $oResult;
    }

}
