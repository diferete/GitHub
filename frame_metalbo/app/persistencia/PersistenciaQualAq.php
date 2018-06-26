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

        $this->adicionaFiltro('filcgc', '75483040000211');
        
        $this->adicionaJoin('EmpRex');

        $this->adicionaOrderBy('nr', 1);
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
        $aEmail = array();
        $sSql = "select usuemail from tbacaoqualplan left outer join tbusuario 
                on tbacaoqualplan.usucodigo = tbusuario.usucodigo 
                where nr ='" . $aDados[1] . "' and tbacaoqualplan.filcgc ='" . $aDados[0] . "' group by usuemail";
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aEmail[] = $oRowBD->usuemail;
        }
        return $aEmail;
    }

    public function somaSit() {
        $sSql = "select COUNT(*) as cont from tbacaoqual where sit = 'Aberta'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sTotalAnd = $oRow->cont;

        $sSql = "select COUNT(*) as cont from tbacaoqual where sit = 'Finalizada'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sTotalFim = $oRow->cont;

        $sSql = "select COUNT(*) as cont from tbacaoqual where sit = 'Iniciada'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sTotalIni = $oRow->cont;

        $aTotal['Aberta'] = $sTotalAnd;
        $aTotal['Finalizada'] = $sTotalFim;
        $aTotal['Iniciada'] = $sTotalIni;
        return $aTotal;
    }

    public function verifEfi($sFilcgc, $sNr) {
        $sSql = " select COUNT(*)as ef from tbacaoeficaz where filcgc = '" . $sFilcgc . "' and nr = '" . $sNr . "' and sit='Finalizado'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iCont = $oRow->ef;
        if ($iCont == 0) {
            return false;
        } else {
            return true;
        }
    }

}
