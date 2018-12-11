<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualAq extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbacaoqual');
        
        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc', true, true);
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
        $this->adicionaRelacionamento('certificacao', 'certificacao');
        $this->adicionaRelacionamento('emailEquip', 'emailEquip');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('dtcancela', 'dtcancela');
        $this->adicionaRelacionamento('obscancela', 'obscancela');
        $this->adicionaRelacionamento('usucancela', 'usucancela');

        $this->adicionaFiltro('filcgc', '75483040000211');

        $this->adicionaJoin('EmpRex');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop(50);
    }

    public function fechaAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');


        $sSql = "update tbacaoqual set sit = 'Finalizada', userfech = '" . $user . "', horafech = '" . $sHora . "', datafech = '" . $sData . "' 
         where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function startAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');


        $sSql = "update tbacaoqual set sit = 'Iniciada' where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function reabreAq($aDados) {
        $user = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');


        $sSql = "update tbacaoqual set sit = 'Aberta', userfech =null, horafech =null, datafech =null 
         where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr ='" . $aDados['nr'] . "'  ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function emailPlan($aDados) {
        $sSql = "select emailEquip from tbacaoqual where nr = " . $aDados[1] . " and filcgc =" . $aDados[0];
        $oRow = $this->consultaSql($sSql);
        $aEmail = explode(',', $oRowBD->emailequip);

        return $aEmail;
    }

    public function somaSit() {
        $sSql = "select COUNT(*) as cont from tbacaoqual where sit = 'Aberta'";
        $oRow = $this->consultaSql($sSql);
        $sTotalAnd = $oRow->cont;

        $sSql = "select COUNT(*) as cont from tbacaoqual where sit = 'Finalizada'";
        $oRow = $this->consultaSql($sSql);
        $sTotalFim = $oRow->cont;

        $sSql = "select COUNT(*) as cont from tbacaoqual where sit = 'Iniciada'";
        $oRow = $this->consultaSql($sSql);
        $sTotalIni = $oRow->cont;

        $aTotal['Aberta'] = $sTotalAnd;
        $aTotal['Finalizada'] = $sTotalFim;
        $aTotal['Iniciada'] = $sTotalIni;
        return $aTotal;
    }

    public function verifEfi($sFilcgc, $sNr) {
        $sSql = " select COUNT(*)as ef from tbacaoeficaz where filcgc = '" . $sFilcgc . "' and nr = '" . $sNr . "' and sit='Finalizado'";
        $oRow = $this->consultaSql($sSql);
        $iCont = $oRow->ef;
        if ($iCont == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserEmail($sDados) {
        $sSql = "select usunome,usuemail from tbusuario where usucodigo = " . $sDados;
        $oRow = $this->consultaSql($sSql);

        $aRetorno[0] = $oRow->usunome;
        $aRetorno[1] = $oRow->usuemail;

        return $aRetorno;
    }

    public function buscaDadosAq($aDados) {
        $sSql = "select * from tbacaoqual where filcgc =" . $aDados['EmpRex_filcgc'] . " and nr = " . $aDados['nr'];
        $oRow = $this->consultaSql($sSql);

        return $oRow;
    }

    public function cancelaAq() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $sUser = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sData = date('d/m/Y');

        $sSql = "update tbacaoqual set"
                . " dtcancela ='" . $sData . "',usucancela='" . $sUser . "',obscancela='" . $aCampos['obscancela'] . "',sit='Cancelada'"
                . " where filcgc='" . $aCampos['filcgc'] . "' and nr='" . $aCampos['nr'] . "'";

        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
