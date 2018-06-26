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
        $this->adicionaRelacionamento('aceitocond', 'aceitocond');
        $this->adicionaRelacionamento('reprovar', 'reprovar');

        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('anexo3', 'anexo3');




        $this->adicionaRelacionamento('officecod', 'officecod');
        $this->adicionaRelacionamento('officedes', 'officedes');

        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('devolucao', 'devolucao');

        $this->adicionaRelacionamento('obsSit', 'obsSit');

        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');



        $this->adicionaJoin('Pessoa');

        $this->adicionaOrderBy('nr', 1);
    }

    public function verificaFim($aDados) {
        $sSql = "select count(*)as total from tbrncqual 
                where  filcgc ='" . $aDados['filcgc'] . "' 
                and nr = " . $aDados['nr'] . "
                and situaca = 'Finalizado'";
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

    //Libera RNC para vendas-Metalbo
    public function liberaRnc($aDados) {
        date_default_timezone_set('America/Sao_Paulo');

        $sSql = " select * from tbrncqual where nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sSituaca = $oRow->situaca;
        //verificar se o campo situaca == liberado se for, nao dar update e rotorna array como false na posicao zero
        if ($sSituaca == 'Liberado') {
            $aRetorno[0] = false;
            $aRetorno[1] = 'Atenção este cadastro já está liberado!';
            return $aRetorno;
        } else {
            $sSql = "update tbrncqual set situaca ='Liberado' "
                    . "where nr ='" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);

            return $aRetorno;
        }
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

    public function buscaDadosRnc($sDados) {
        $sSql = "select * from tbrncqual"
                . " where filcgc = '" . $sDados['filcgc'] . "' and nr = '" . $sDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
    }

    public function buscaEmailVenda($aDados) {
        $sSql = "select resp_venda_cod "
                . "from tbrncqual "
                . "where filcgc ='" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codVenda = $oRow->resp_venda_cod;

        //busca email venda
        $sSql = "select usuemail "
                . "from tbusuario where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;

        return $aEmail;
    }

    public function verifSit($aDados) {
        $sSql = "select situaca"
                . " from tbrncqual"
                . " where filcgc='" . $aDados['filcgc'] . "' and nr='" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sSituaca = $oRow->situaca;

        if ($sSituaca == 'Aguardando') {
            $aRetorno[0] = false;
        } else {
            $aRetorno[0] = true;
        }

        return $aRetorno;
    }

    public function aceitaDevolucao($aDados) {
        $sSql = "select devolucao"
                . " from tbrncqual"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sDevolucao = $oRow->devolucao;

        if ($sDevolucao == 'Recusada' || $sDevolucao == 'Aceita') {
            $aRetorno[0] = false;
        } else {
            $sSql = "update tbrncqual set devolucao ='Aceita' "
                    . "where nr ='" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
        }
        return $aRetorno;
    }

    public function recusaDevolucao($aDados) {
        $sSql = "select devolucao"
                . " from tbrncqual"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sDevolucao = $oRow->devolucao;

        if ($sDevolucao == 'Recusada' || $sDevolucao == 'Aceita') {
            $aRetorno[0] = false;
        } else {
            $sSql = "update tbrncqual set devolucao ='Recusada' "
                    . "where nr ='" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
        }
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

}
