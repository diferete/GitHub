<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_QUAL_QualAq extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_QUAL_qualaq');

        $this->adicionaRelacionamento('filcgc', 'DELX_FIL_Empresa.fil_codigo', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('titulo', 'titulo');
        $this->adicionaRelacionamento('dtimp', 'dtimp');
        $this->adicionaRelacionamento('horimp', 'horimp');
        $this->adicionaRelacionamento('userimp', 'userimp');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('dataini', 'dataini');
        $this->adicionaRelacionamento('datafim', 'datafim');
        $this->adicionaRelacionamento('equipe', 'equipe');
        $this->adicionaRelacionamento('tipoacao', 'tipoacao');
        $this->adicionaRelacionamento('origem', 'origem');
        $this->adicionaRelacionamento('tipmelhoria', 'tipmelhoria');
        $this->adicionaRelacionamento('problema', 'problema');
        $this->adicionaRelacionamento('objetivo', 'objetivo');
        $this->adicionaRelacionamento('sit', 'sit');
        $this->adicionaRelacionamento('userfech', 'userfech');
        $this->adicionaRelacionamento('datafech', 'datafech');
        $this->adicionaRelacionamento('horafech', 'horafech');
        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('classificacao', 'classificacao');
        $this->adicionaRelacionamento('emailEquip', 'emailEquip');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('dtcancela', 'dtcancela');
        $this->adicionaRelacionamento('obscancela', 'obscancela');
        $this->adicionaRelacionamento('usucancela', 'usucancela');

        $this->adicionaFiltro('filcgc', '8993358000174');

        $this->adicionaJoin('DELX_FIL_Empresa', null, 1, 'filcgc', 'fil_codigo');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop(50);
    }

    public function fechaAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');


        $sSql = "update MET_QUAL_qualaq set sit = 'Finalizada', userfech = '" . $user . "', horafech = '" . $sHora . "', datafech = '" . $sData . "' 
         where filcgc = '" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function startAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');


        $sSql = "update MET_QUAL_qualaq set sit = 'Iniciada' where filcgc = '" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function reabreAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = "update MET_QUAL_qualaq set sit = 'Aberta', userfech =null, horafech =null, datafech =null 
         where filcgc = '" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    //    public function emailPlan($aDados) {
//        $aEmail = array();
//        $sSql = "select usuemail from MET_QUAL_qualplan left outer join MET_TEC_usuario 
//                on MET_QUAL_qualplan.usucodigo = MET_TEC_usuario.usucodigo 
//                where nr ='" . $aDados[1] . "' and MET_QUAL_qualplan.filcgc ='" . $aDados[0] . "' group by usuemail";
//        $result = $this->getObjetoSql($sSql);
//        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
//            $aEmail[] = $oRowBD->usuemail;
//        }
//        return $aEmail;
//    }

    public function emailPlan($aDados) {
        $sSql = "select emailEquip from MET_QUAL_qualaq where nr = " . $aDados[1] . " and filcgc =" . $aDados[0];
        $sResult = $this->getObjetoSql($sSql);
        $oRowBD = $sResult->fetch(PDO::FETCH_OBJ);
        $aEmail = explode(',', $oRowBD->emailequip);

        return $aEmail;
    }

    public function somaSit($sDados) {
        $sSql = "select COUNT(*) as cont from MET_QUAL_qualaq where sit = 'Aberta' and filcgc = '" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sTotalAnd = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_QUAL_qualaq where sit = 'Finalizada' and filcgc = '" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sTotalFim = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_QUAL_qualaq where sit = 'Iniciada' and filcgc = '" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sTotalIni = $oRow->cont;

        $aTotal['Aberta'] = $sTotalAnd;
        $aTotal['Finalizada'] = $sTotalFim;
        $aTotal['Iniciada'] = $sTotalIni;
        return $aTotal;
    }

    public function verifEfi($sFilcgc, $sNr) {
        $sSql = " select COUNT(*)as ef from MET_QUAL_acaoeficaz where filcgc = '" . $sFilcgc . "' and nr = '" . $sNr . "' and sit='Finalizado'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iCont = $oRow->ef;
        if ($iCont == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserEmail($sDados) {
        $sSql = "select usunome,usuemail from MET_TEC_usuario where usucodigo = " . $sDados;
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->usunome;
        $aRetorno[1] = $oRow->usuemail;

        return $aRetorno;
    }

    public function buscaDadosAq($aDados) {
        $sSql = "select * from MET_QUAL_qualaq where filcgc = '" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "' and nr = '" . $aDados['nr'] . "'";
        $oRow = $this->consultaSql($sSql);

        return $oRow;
    }

    public function cancelaAq() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sUser = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sData = date('d/m/Y');

        $sSql = "update MET_QUAL_qualaq set"
                . " dtcancela ='" . $sData . "',usucancela='" . $sUser . "',obscancela='" . $aCampos['obscancela'] . "',sit='Cancelada'"
                . " where filcgc='" . $aCampos['filcgc'] . "' and nr='" . $aCampos['nr'] . "'";

        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
