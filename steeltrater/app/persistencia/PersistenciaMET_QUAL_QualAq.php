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

    public function emailPlan($aDados) {
        $sSql = "select emailEquip from MET_QUAL_qualaq where nr = " . $aDados[1] . " and filcgc =" . $aDados[0];
        $oRow = $this->consultaSql($sSql);
        $aEmail = explode(',', $oRow->emailequip);

        return $aEmail;
    }

    public function somaSit() {
        $sSql = "select COUNT(*) as cont from MET_QUAL_qualaq where sit = 'Aberta'";
        $oRow = $this->consultaSql($sSql);
        $sTotalAnd = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_QUAL_qualaq where sit = 'Finalizada'";
        $oRow = $this->consultaSql($sSql);
        $sTotalFim = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_QUAL_qualaq where sit = 'Iniciada'";
        $oRow = $this->consultaSql($sSql);
        $sTotalIni = $oRow->cont;

        $aTotal['Aberta'] = $sTotalAnd;
        $aTotal['Finalizada'] = $sTotalFim;
        $aTotal['Iniciada'] = $sTotalIni;
        return $aTotal;
    }

    public function verifEfi($sFilcgc, $sNr) {
        $sSql = " select COUNT(*)as ef from MET_QUAL_acaoeficaz where filcgc = '" . $sFilcgc . "' and nr = '" . $sNr . "' and sit='Finalizado'";
        $oRow = $this->consultaSql($sSql);
        $iCont = $oRow->ef;
        if ($iCont == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getUserEmail($sDados) {
        $sSql = "select usunome,usuemail from MET_TEC_usuario where usucodigo = " . $sDados;
        $oRow = $this->consultaSql($sSql);

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

    public function verifSituacoes($aDados) {
        $sSqlAq = "select tipoacao,sit,problema,objetivo from MET_QUAL_qualaq where nr ='" . $aDados['nr'] . "'  and filcgc ='" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "'";
        $oRowAq = $this->consultaSql($sSqlAq);
        $aRowAq = (array) $oRowAq;
        if (($aRowAq['problema'] != '' || $aRowAq['problema'] != null) && ($aRowAq['objetivo'] != '' || $aRowAq['objetivo'] != null)) {
            $aRowAq['problema'] = true;
            $aRowAq['objetivo'] = true;
        } else {
            $aRowAq['problema'] = false;
            $aRowAq['objetivo'] = false;
        }

        $sSqlContencao = "select COUNT(*) as total from MET_QUAL_Contencao  where nr ='" . $aDados['nr'] . "'  and filcgc ='" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "'";
        $oContencao = $this->consultaSql($sSqlContencao);
        if ($oContencao->total == 0) {
            $aRowAq['contencao'] = 'vazio';
        } else {
            $sSqlPlan = $sSqlContencao . " and situaca is null";
            $oContencao = $this->consultaSql($sSqlContencao);
            if ($oContencao->total == 0) {
                $aRowAq['contencao'] = true;
            } else {
                $aRowAq['contencao'] = false;
            }
        }


        $sSqlCorrecao = "select COUNT(*) as total from MET_QUAL_Correcao  where nr ='" . $aDados['nr'] . "'  and filcgc ='" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "'";
        $oCorrecao = $this->consultaSql($sSqlCorrecao);
        if ($oCorrecao->total == 0) {
            $aRowAq['correcao'] = 'vazio';
        } else {
            $sSqlPlan = $sSqlCorrecao . " and situaca is null";
            $oCorrecao = $this->consultaSql($sSqlCorrecao);
            if ($oCorrecao->total == 0) {
                $aRowAq['correcao'] = true;
            } else {
                $aRowAq['correcao'] = false;
            }
        }


        $sSqlCausa = "select COUNT(*) as total from MET_QUAL_DiagramaCausa  where nr ='" . $aDados['nr'] . "'  and filcgc ='" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "'";
        $oCausa = $this->consultaSql($sSqlCausa);
        if ($oCausa->total == 0) {
            $aRowAq['causa'] = false;
        } else {
            $aRowAq['causa'] = true;
        }


        $sSqlPlan = "select COUNT(*) as total from MET_QUAL_qualplan where nr ='" . $aDados['nr'] . "'  and filcgc ='" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "'";
        $oPlan = $this->consultaSql($sSqlPlan);
        if ($oPlan->total == 0) {
            $aRowAq['plano'] = 'vazio';
        } else {
            $sSqlPlan = $sSqlPlan . " and sitfim is null";
            $oPlan = $this->consultaSql($sSqlPlan);
            if ($oPlan->total == 0) {
                $aRowAq['plano'] = true;
            } else {
                $aRowAq['plano'] = false;
            }
        }


        $sSqlEficaz = "select COUNT(*) as total from MET_QUAL_acaoeficaz  where nr ='" . $aDados['nr'] . "'  and filcgc ='" . $aDados['DELX_FIL_Empresa_fil_codigo'] . "'";
        $oEficaz = $this->consultaSql($sSqlEficaz);
        if ($oEficaz->total == 0) {
            $aRowAq['eficaz'] = 'vazio';
        } else {
            $sSqlPlan = $sSqlPlan . " and sitfim is null";
            $oEficaz = $this->consultaSql($sSqlPlan);
            if ($oEficaz->total == 0) {
                $aRowAq['eficaz'] = true;
            } else {
                $aRowAq['eficaz'] = false;
            }
        }




        return $aRowAq;
    }

}
