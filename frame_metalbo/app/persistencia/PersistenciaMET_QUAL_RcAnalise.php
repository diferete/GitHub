<?php

/*
 * Classe que gerencia a persistencia da classe MET_QUAL_RcAnalise
 * 
 * @author Avanei Martendal
 * @since 12/09/2017
 */

class PersistenciaMET_QUAL_RcAnalise extends Persistencia {

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
        $this->adicionaRelacionamento('apontamento', 'apontamento');
        $this->adicionaRelacionamento('usuaponta', 'usuaponta');

        $this->adicionaRelacionamento('obs_aponta', 'obs_aponta');
        $this->adicionaRelacionamento('produtos', 'produtos');
        $this->adicionaRelacionamento('tagsetor', 'tagsetor');

        $this->adicionaRelacionamento('tagexcecao', 'tagexcecao');

        $this->adicionaRelacionamento('inspecao', 'inspecao');
        $this->adicionaRelacionamento('correcao', 'correcao');
        $this->adicionaRelacionamento('obs_inspecao', 'obs_inspecao');
        $this->adicionaRelacionamento('resp_disposicao', 'resp_disposicao');
        $this->adicionaRelacionamento('data_disposicao', 'data_disposicao');
        $this->adicionaRelacionamento('hora_disposicao', 'hora_disposicao');
        $this->adicionaRelacionamento('anexo_inspecao', 'anexo_inspecao');
        $this->adicionaRelacionamento('anexo_inspecao1', 'anexo_inspecao1');

        $this->adicionaRelacionamento('anexo_analise', 'anexo_analise');
        $this->adicionaRelacionamento('anexo_analise1', 'anexo_analise1');

        $this->adicionaJoin('Pessoa');

        $this->adicionaOrderBy('nr', 1);

        $this->setSTop(50);

        if ($_SESSION['codUser'] != 70) {
            if ($_SESSION['codsetor'] == 3) {
                $this->adicionaFiltro('tagsetor', '3');
            }
            if ($_SESSION['codsetor'] == 5) {
                $this->adicionaFiltro('tagsetor', '5');
            }
        } else {
            $aValor = array();
            $aValor[0] = 3;
            $aValor[1] = 5;
            $this->adicionaFiltro('tagsetor', $aValor, 0, 9);
        }
    }

    public function verificaFim($aDados) {
        $sSql = "select count(*)as total from tbrncqual 
                where  filcgc ='" . $aDados['filcgc'] . "' 
                and nr = " . $aDados['nr'] . "
                and situaca = 'Apontada'";
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

    public function buscaDadosRC($sDados) {
        $sSql = "select * from tbrncqual"
                . " where filcgc = '" . $sDados['filcgc'] . "' and nr = '" . $sDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
    }

    public function buscaEmails($aDados) {
        $sSql = "select resp_venda_cod,usucodigo "
                . "from tbrncqual "
                . "where filcgc ='" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codVenda = $oRow->resp_venda_cod;
        $codRep = $oRow->usucodigo;

        //busca email venda
        $sSql = "select usuemail "
                . "from tbusuario where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail[0] = $oRow->usuemail;

        //busca email rep
        $sSql = "select usuemail "
                . "from tbusuario where usucodigo ='" . $codRep . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail[1] = $oRow->usuemail;

        return $aEmail;
    }

    public function verifSit($aDados) {
        $sSql = "select situaca,reclamacao,devolucao"
                . " from tbrncqual"
                . " where filcgc='" . $aDados['filcgc'] . "' and nr='" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sSituaca = $oRow->situaca;

        if ($sSituaca == 'Aguardando') {
            $aRetorno[0] = false;
            $aRetorno[1] = $sSituaca;
            $aRetorno[2] = $oRow->reclamacao;
        } else {
            $aRetorno[0] = true;
            $aRetorno[1] = $sSituaca;
            $aRetorno[2] = $oRow->reclamacao;
        }
        return $aRetorno;
    }

    /**
     * Apontamento da reclamação 
     */
    public function apontaRC($aDados) {

        $aDados['apontamento'] = $this->preparaString($aDados['apontamento']);
        if ($aDados['anexo_analise'] == '') {
            $aDados['anexo_analise'] = null;
        }if ($aDados['anexo_analise1'] == '') {
            $aDados['anexo_analise1'] = null;
        }
        $sSql = "update tbrncqual"
                . " set situaca = 'Apontada',"
                . " apontamento = '" . $aDados['apontamento'] . "',"
                . " anexo_analise = '" . $aDados['anexo_analise'] . "',"
                . " anexo_analise1 = '" . $aDados['anexo_analise1'] . "',"
                . " usuaponta = '" . $aDados['usuaponta'] . "'"
                . " where filcgc ='" . $aDados['filcgc'] . "' and nr ='" . $aDados['nr'] . "'";

        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function apontaInspecaoRC($aDados) {

        $aDados['inspecao'] = $this->preparaString($aDados['inspecao']);
        $aDados['obs_inspecao'] = $this->preparaString($aDados['obs_inspecao']);

        if ($aDados['anexo_inspecao'] == '') {
            $aDados['anexo_inspecao'] = null;
        }
        if ($aDados['anexo_inspecao1'] == '') {
            $aDados['anexo_inspecao1'] = null;
        }

        $sSql = "update tbrncqual"
                . " set inspecao = '" . $aDados['inspecao'] . "',"
                . " correcao = '" . $aDados['correcao'] . "',"
                . " obs_inspecao = '" . $aDados['obs_inspecao'] . "',"
                . " resp_disposicao = '" . $aDados['resp_disposicao'] . "',"
                . " data_disposicao = '" . $aDados['data_disposicao'] . "',"
                . " hora_disposicao = '" . $aDados['hora_disposicao'] . "',"
                . " anexo_inspecao = '" . $aDados['anexo_inspecao'] . "',"
                . " anexo_inspecao1 = '" . $aDados['anexo_inspecao1'] . "'"
                . " where filcgc ='" . $aDados['filcgc'] . "' and nr ='" . $aDados['nr'] . "'";

        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
