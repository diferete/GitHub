<?php

/*
 * Classe que controla a persistencia da classe PersistenciaCadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class PersistenciaCadCliRep extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('pdfempcad');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('empfj', 'empfj');
        $this->adicionaRelacionamento('empconfina', 'empconfina');
        $this->adicionaRelacionamento('pagast', 'pagast');
        $this->adicionaRelacionamento('simplesNacional', 'simplesNacional');
        $this->adicionaRelacionamento('empdtcad', 'empdtcad');
        $this->adicionaRelacionamento('empusucad', 'empusucad');
        $this->adicionaRelacionamento('empfant', 'empfant');
        $this->adicionaRelacionamento('empativo', 'empativo');
        $this->adicionaRelacionamento('empfone', 'empfone');
        $this->adicionaRelacionamento('empinterne', 'empinterne');
        $this->adicionaRelacionamento('empend', 'empend');
        $this->adicionaRelacionamento('cidcep', 'cidcep');
        $this->adicionaRelacionamento('empendbair', 'empendbair');
        $this->adicionaRelacionamento('empins', 'empins');
        $this->adicionaRelacionamento('empobs', 'empobs');
        $this->adicionaRelacionamento('repcod', 'repcod');

        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('empmunicipio', 'empmunicipio');
        $this->adicionaRelacionamento('uf', 'uf');
        $this->adicionaRelacionamento('officecod', 'officecod');
        $this->adicionaRelacionamento('officedes', 'officedes');

        $this->adicionaRelacionamento('emailNfe', 'emailNfe');

        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('dtlib', 'dtlib');
        $this->adicionaRelacionamento('horalib', 'horalib');
        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');

        $this->adicionaRelacionamento('empcobbco', 'empcobbco');
        $this->adicionaRelacionamento('empcobcar', 'empcobcar');
        $this->adicionaRelacionamento('certcli', 'certcli');
        $this->adicionaRelacionamento('comer', 'comer');
        $this->adicionaRelacionamento('transp', 'transp');

        $this->adicionaRelacionamento('empnr', 'empnr');

        if (isset($_SESSION['repoffice'])) {

            $this->adicionaFiltro('officecod', $_SESSION['repoffice']);
        }
        $this->adicionaOrderBy('nr', 1);
    }

    //executa a liberação para projetos
    public function liberaMetalbo($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = " select * from pdfempcad where nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sSituaca = $oRow->situaca;
        //verificar se o campo situaca == liberado se for, nao dar update e rotorna array como false na posicao zero
        if ($sSituaca == 'Liberado') {
            $aRetorno[0] = false;
            $aRetorno[1] = 'Atenção este cadastro já está liberado!';
            return $aRetorno;
        } else {

            $sSql = "update pdfempcad set situaca ='Liberado',
                    dtlib ='" . $sData . "',
                    horalib ='" . $sHora . "'
                    where nr ='" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);

            return $aRetorno;
        }
    }

    /* busca resp vendas */

    //busca e-mail de vendas
    public function buscaEmailVenda($sNr) {
        $sSql = "select resp_venda_cod 
                from pdfempcad 
                where nr ='" . $sNr . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codVenda = $oRow->resp_venda_cod;

        //busca email venda
        $sSql = "select usuemail
                from tbusuario 
                where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;

        return $aEmail;
    }

    public function buscaRespEscritório($sDados) {
        $sSql = "select officeresp from tbrepoffice where officecod =" . $_SESSION['repoffice'];
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sCodResp = $oRow->officeresp;


        $sSql = "select usucodigo,usunome from tbusuario where usucodigo =" . $sCodResp;
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->usucodigo;
        $aRetorno[1] = $oRow->usunome;

        return $aRetorno;
    }

    public function buscaCNPJ($sDados) {
        $sSql = "select  COUNT(*) as total"
                . " from widl.emp01"
                . " where empcnpj='".$sDados."'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $sRetorno = $oRow->total;
        if ($sRetorno > 0) {
            $sRetorno = false;
        } else {
            $sRetorno = true;
        }
        return $sRetorno;
    }

}
