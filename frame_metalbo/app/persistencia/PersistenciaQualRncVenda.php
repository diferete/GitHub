<?php

/*
 * Classe que gerencia a persistencia da classe QualRncVenda
 * 
 * @author Avanei Martendal
 * @since 12/09/2017
 */

class PersistenciaQualRncVenda extends Persistencia {

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
        $this->adicionaRelacionamento('produtos', 'produtos');


        $this->adicionaRelacionamento('obsSit', 'obsSit');

        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');
        $this->adicionaRelacionamento('repcod', 'repcod');
        $this->adicionaRelacionamento('apontamento', 'apontamento');
        $this->adicionaRelacionamento('usuaponta', 'usuaponta');
        $this->adicionaRelacionamento('usuapontavenda', 'usuapontavenda');

        $this->adicionaRelacionamento('obs_aponta', 'obs_aponta');

        $this->adicionaJoin('Pessoa');

        $this->adicionaOrderBy('nr', 1);
    }

    /**
     * Método que busca os dados para montar o e-mail de encaminhamento para análise.
     */
    public function buscaDadosRnc($sDados) {
        $sSql = "select * from tbrncqual"
                . " where filcgc = '" . $sDados['filcgc'] . "' and nr = '" . $sDados['nr'] . "'";
        $oResult = $this->consultaSql($sSql);
        return $oResult;
    }

    public function verificaFim($aDados) {
        $sSql = "select count(*)as total from tbrncqual 
                where  filcgc ='" . $aDados['filcgc'] . "' 
                and nr = " . $aDados['nr'] . "
                and situaca = 'Finalizada'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aret = array();
        if ($oRow->total > 0) {
            $aret[] = false;
        } else {
            $aret[] = true;
        }
        return $aret;
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

    /**
     * Método para buscar o responsável pelo escritório de representação que emitiu a RC.
     */
    public function buscaRespEscritório($sDados) {
        $sSql = "select officeresp "
                . "from tbrepoffice where officecod =" . $_SESSION['repoffice'];
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sCodResp = $oRow->officeresp;


        $sSql = "select usucodigo,usunome "
                . "from tbusuario where usucodigo =" . $sCodResp;
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->usucodigo;
        $aRetorno[1] = $oRow->usunome;

        return $aRetorno;
    }

    public function updateSitRC($aCamposChave, $sParam) {
        if ($sParam == 'Env.Qual') {
            $sSql = "update tbrncqual"
                    . " set situaca = 'Env.Qual',"
                    . " reclamacao = 'Em análise',"
                    . " tagsetor = '25'"
                    . " where filcgc = '" . $aCamposChave['filcgc'] . "' and nr = '" . $aCamposChave['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
            return $aRetorno;
        }
        if ($sParam == 'Env.Emb') {
            $sSql = "update tbrncqual"
                    . " set situaca = 'Env.Emb',"
                    . " reclamacao = 'Em análise',"
                    . " tagsetor = '5'"
                    . " where filcgc = '" . $aCamposChave['filcgc'] . "' and nr = '" . $aCamposChave['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
            return $aRetorno;
        }
        if ($sParam == 'Env.Exp') {
            $sSql = "update tbrncqual"
                    . " set situaca = 'Env.Exp',"
                    . " reclamacao = 'Em análise',"
                    . " tagsetor = '3'"
                    . " where filcgc = '" . $aCamposChave['filcgc'] . "' and nr = '" . $aCamposChave['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
            return $aRetorno;
        }
    }

    public function aceitaDevolucao($aDados) {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sObs = Util::limpaString($aCampos['obs_aponta']);

        $sSql = "select reclamacao"
                . " from tbrncqual"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sDevolucao = $oRow->reclamacao;

        if ($sDevolucao == 'Recusada' || $sDevolucao == 'Aceita') {
            $aRetorno[0] = false;
        } else {
            $sSql = "update tbrncqual"
                    . " set reclamacao ='Aceita',"
                    . " obs_aponta ='" . $sObs . "', "
                    . " reclamacaoacc = 'true'"
                    . " where nr ='" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
        }
        return $aRetorno;
    }

    public function apontaTransportadora($aDados) {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sObs = Util::limpaString($aCampos['obs_aponta']);

        $sSql = "update tbrncqual"
                . " set situaca = 'Apontada',"
                . " reclamacao ='Transportadora',"
                . " obs_aponta ='" . $sObs . "',"
                . " usuaponta = '" . $aDados['usuaponta'] . "'"
                . " reclamacaorec = 'true'"
                . " where nr ='" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function apontaRepresentante($aDados) {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sObs = Util::limpaString($aCampos['obs_aponta']);

        $sSql = "update tbrncqual"
                . " set situaca = 'Apontada',"
                . " reclamacao ='Representante',"
                . " obs_aponta ='" . $sObs . "',"
                . " usuaponta = '" . $aDados['usuaponta'] . "'"
                . " where nr ='" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function buscaEmailRep($aDados) {
        $sSql = "select usucodigo"
                . " from tbrncqual"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sCod = $oRow->usucodigo;

        $sSql = "select usuemail"
                . " from tbusuario"
                . " where usucodigo ='" . $sCod . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sEmail = $oRow->usuemail;

        return $sEmail;
    }

    public function apontaReclamacao($aDados) {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sObs = Util::limpaString($aCampos['obs_aponta']);

        $sSql = "update tbrncqual "
                . "set situaca = 'Apontada', "
                . "reclamacao = '" . $aCampos['reclamacao'] . "', "
                . "devolucao = '" . $aCampos['devolucao'] . "', "
                . "obs_aponta = '" . $sObs . "', "
                . "usuapontavenda = '" . $_SESSION['nome'] . "' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
