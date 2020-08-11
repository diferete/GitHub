<?php

/**
 * Classe responsável pelas operações de persistência do objeto
 * SolCadUser
 * 
 * @author Avanei Martendal
 * @since 14/07/2017
 */

class PersistenciaSolCadUser extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbsoluser');

        $this->adicionaRelacionamento('usucodigo', 'usucodigo', true, true, true);
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('ususobrenome', 'ususobrenome');
        $this->adicionaRelacionamento('usulogin', 'usulogin');
        $this->adicionaRelacionamento('usuemail', 'usuemail');
        $this->adicionaRelacionamento('ususit', 'ususit');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('dataSolUser', 'dataSolUser');
    }

    public function insereSol() {
        $aCamposChave = array();
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        parse_str($sChave, $aCamposChave);

        date_default_timezone_set('America/Sao_Paulo');
        $oData = date('d/m/Y');

        $this->setChaveIncremento(false);
        $iInc = $this->getIncremento('usucodigo', true);

        $sSql = "insert into tbsoluser (usucodigo,usunome,ususobrenome,usulogin,usuemail,ususit,obs,dataSolUser)
                 values('" . $iInc . "','" . $aCamposChave['nomeSol'] . "','" . $aCamposChave['sobrenomeSol'] . "',"
                . "'" . $aCamposChave['loginSol'] . "','" . $aCamposChave['emailSol'] . "','Aguardando cadastro','" . $aCamposChave['obsSol'] . "','".$oData."')";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

}
