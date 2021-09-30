<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenciaMET_EST_Enderecamento
 *
 * @author Alexandre
 */
class PersistenciaMET_EST_Enderecamento extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    public function getDadosEnderecamento($oDados) {


        $iAlm = $this->getAlmUsuario($oDados);

        $sSql = "select rex_maquinas.widl.armazena.armcod as armcod,"
                . "cod,"
                . "tipo,"
                . "armdes, "
                . "rex_maquinas.widl.PROD01S1.procod as procod,"
                . "prodes, "
                . "convert(varchar,data,103)as data,"
                . "traseq "
                . "from rex_maquinas.widl.PROD01S1(nolock) "
                . "left outer join rex_maquinas.widl.ARMAZENA(nolock) "
                . "on rex_maquinas.widl.PROD01S1.armcod = rex_maquinas.widl.ARMAZENA.armcod "
                . "left outer join rex_maquinas.widl.prod01(nolock) "
                . "on rex_maquinas.widl.PROD01S1.procod = rex_maquinas.widl.prod01.procod "
                . "left outer join rex_maquinas.dbo.tipend(nolock) "
                . "on rex_maquinas.widl.PROD01S1.tipend = rex_maquinas.dbo.tipend.cod "
                . "where "
                . "rex_maquinas.widl.armazena.armcod = rex_maquinas.widl.PROD01S1.armcod "
                . "and rex_maquinas.widl.PROD01.procod = rex_maquinas.widl.PROD01S1.procod  "
                . "and rex_maquinas.widl.ARMAZENA.almcod = " . $iAlm . " ";
        if ($oDados->estante != '') {
            $sSql = $sSql . "and rex_maquinas.widl.armazena.armdes like '%" . $oDados->estante . "%' ";
        }
        if ($oDados->nivel != '') {
            $sSql = $sSql . "and rex_maquinas.widl.armazena.armdes like '%" . $oDados->nivel . "%' ";
        }
        if ($oDados->coluna != '') {
            $sSql = $sSql . "and rex_maquinas.widl.armazena.armdes like '%" . $oDados->coluna . "%' ";
        }
        if ($oDados->tipo != '') {
            $sSql = $sSql . "and rex_maquinas.widl.PROD01S1.tipend like '%" . $oDados->tipo . "%' ";
        }
        if ($oDados->codigo != '') {
            $sSql = $sSql . "and rex_maquinas.widl.PROD01S1.procod =  " . $oDados->codigo . " ";
        }
        $sSql = $sSql . "order by rex_maquinas.widl.armazena.armcod";

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['armcod'] = trim($row->armcod);
            $aDados['tipo'] = trim($row->tipo);
            $aDados['cod'] = trim($row->cod);
            $aDados['armdes'] = trim($row->armdes);
            $aDados['procod'] = trim($row->procod);
            $aDados['prodes'] = trim($row->prodes);
            $aDados['data'] = trim($row->data);
            $aDados['traseq'] = trim($row->traseq);
            $aDadosEnd = explode(' ', $aDados['armdes']);
            $aDados['estante'] = trim($aDadosEnd[0]);
            $aDados['nivel'] = trim($aDadosEnd[1]);
            $aDados['coluna'] = trim($aDadosEnd[2]);
            $aRet[] = $aDados;
        }
        return $aRetorno['enderecos'] = $aRet;
    }

    public function updateEndereco($oDados) {
        $est = preg_replace('/\D/', '', $oDados->estante);
        $nvl = preg_replace('/\D/', '', $oDados->nivel);
        $col = preg_replace('/\D/', '', $oDados->coluna);
        $armcod = $est . '.' . $nvl . '.' . $col;
        $data = date('d/m/Y');        
        $hora = date('H:i:s');

        $sSql = "update "
                . "rex_maquinas.widl.PROD01S1 "
                . "set "
                . "armcod = '" . $armcod . "',"
                . "tipend = '" . $oDados->tipo . "' "
                /* "data = '" . $data . "' " */
                . "where procod = '" . $oDados->codigo . "' "
                . "and armcod = '" . $oDados->armcod . "'";
        $aRetorno = $this->executaSql($sSql);
        if ($aRetorno[0]) {
            $sAlm = $this->getAlmUsuario($oDados);
            $sNomeDelsoft = "select usunomedelsoft from MET_TEC_usuario where usucodigo = " . $_SESSION['codUser'];
            $oObjNomeDel = $this->consultaSql($sNomeDelsoft);
            $sSqlHist = "insert "
                    . "into rex_maquinas.dbo.MetEnd_HistEnd "
                    . "("
                    . "nome,"
                    . "acao,"
                    . "data,"
                    . "hora,"
                    . "procod,"
                    . "endantes,"
                    . "enddepois,"
                    . "alm"
                    . ")"
                    . "values"
                    . "("
                    . "'" . $oObjNomeDel->usunomedelsoft . "',"
                    . "'Alteração',"
                    . "'" . $data . "',"
                    . "'" . $hora . "',"
                    . "" . $oDados->codigo . ","
                    . "'" . $oDados->armcod . "',"
                    . "'" . $armcod . "',"
                    . "" . $sAlm . ""
                    . ")";
            $aRetorno = $this->executaSql($sSqlHist);
            if ($aRetorno[0]) {
                $aRetorno[2] = $armcod;
                return $aRetorno;
            } else {
                return $aRetorno;
            }
        } else {
            return $aRetorno;
        }
    }

    public function getDescricao($oDados) {
        $sSql = "select "
                . "prodes "
                . "from rex_maquinas.widl.prod01 "
                . "where procod = " . $oDados->codigo;
        $oObj = $this->consultaSql($sSql);
        return $oObj->prodes;
    }

    public function insereNovoEndereco($oDados) {

        $est = preg_replace('/\D/', '', $oDados->estante);
        $nvl = preg_replace('/\D/', '', $oDados->nivel);
        $col = preg_replace('/\D/', '', $oDados->coluna);
        $armcod = $est . '.' . $nvl . '.' . $col;
        $data = date('d/m/Y');
        $hora = date('H:i:s');

        $sAlm = $this->getAlmUsuario($oDados);

        $sSqlInsEnd = "insert "
                . "into rex_maquinas.widl.PROD01S1 "
                . "("
                . "procod,"
                . "armcod,"
                . "armpro,"
                . "tipend,"
                . "data,"
                . "traseq"
                . ")"
                . "values"
                . "("
                . "" . $oDados->codigo . ","
                . "'" . $armcod . "',"
                . "0,"
                . "" . $oDados->tipo . ","
                . "'" . $data . "',"
                . "0"
                . ")";

        $aRetorno = $this->executaSql($sSqlInsEnd);
        if ($aRetorno[0]) {
            $sNomeDelsoft = "select usunomedelsoft from MET_TEC_usuario where usucodigo = " . $_SESSION['codUser'];
            $oObjNomeDel = $this->consultaSql($sNomeDelsoft);
            $sSqlHist = "insert "
                    . "into rex_maquinas.dbo.MetEnd_HistEnd "
                    . "("
                    . "nome,"
                    . "acao,"
                    . "data,"
                    . "hora,"
                    . "procod,"
                    . "endantes,"
                    . "enddepois,"
                    . "alm"
                    . ")"
                    . "values"
                    . "("
                    . "'" . $oObjNomeDel->usunomedelsoft . "',"
                    . "'Inserção',"
                    . "'" . $data . "',"
                    . "'" . $hora . "',"
                    . "" . $oDados->codigo . ","
                    . "'Inserção',"
                    . "'" . $armcod . "',"
                    . "" . $sAlm . ""
                    . ")";
            $this->executaSql($sSqlHist);
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            return $aRetorno;
        }
    }

    public function getAlmUsuario($oDados) {
        $sSql = "select "
                . "alm "
                . "from rex_maquinas.dbo.tbusuario(nolock) "
                . "left outer join rex_maquinas.dbo.metcad_user(nolock) "
                . "on rex_maquinas.dbo.MetCad_User.nome = rex_maquinas.dbo.tbusuario.usunomeDelsoft "
                . "where "
                . "rex_maquinas.dbo.MetCad_User.coduser = rex_maquinas.dbo.tbusuario.coduserDelsoft "
                . "and rex_maquinas.dbo.tbusuario.usucodigo =" . $oDados->usucodigo;
        $oObj = $this->consultaSql($sSql);
        return $oObj->alm;
    }

    public function addListaEspera($oDados) {
        $est = preg_replace('/\D/', '', $oDados->estante);
        $nvl = preg_replace('/\D/', '', $oDados->nivel);
        $col = preg_replace('/\D/', '', $oDados->coluna);
        $armcod = $est . '.' . $nvl . '.' . $col;
        $data = date('d/m/Y');
        $hora = date('H:i:s');

        $sAlm = $this->getAlmUsuario($oDados);

        $sSqlVerifica = "select COUNT(*) as total "
                . "from rex_maquinas.dbo.tbEndExp "
                . "where cod =" . $oDados->codigo . " "
                . "and endant = '" . $armcod . "' "
                . "and sitend = 'Baixa Exp' "
                . "and dataend = '" . $data . "'";
        $oObjVerifica = $this->consultaSql($sSqlVerifica);

        if ($oObjVerifica->total >= 1) {
            $aRetorno[0] = false;
            $aRetorno[1] = 'existe';
            return $aRetorno;
        } else {
            $sNomeDelsoft = "select "
                    . "usunomedelsoft "
                    . "from MET_TEC_usuario "
                    . "where usucodigo = " . $_SESSION['codUser'];
            $oObjNomeDel = $this->consultaSql($sNomeDelsoft);

            /* 60415809 27.06.03 HILSON DORNER 2021-09-20 Baixa Exp 16:57:26.0000000 NULL 2 NULL NULL */
            $sSqlInsert = "insert "
                    . "into rex_maquinas.dbo.tbEndExp"
                    . "("
                    . "cod,"
                    . "endant,"
                    . "endprox,"
                    . "nome,"
                    . "dataend,"
                    . "sitend,"
                    . "hora,"
                    . "tipoend"
                    . ")"
                    . "values"
                    . "("
                    . "" . $oDados->codigo . ","
                    . "'" . $armcod . "',"
                    . "'',"
                    . "'" . $oObjNomeDel->usunomedelsoft . "',"
                    . "'" . $data . "',"
                    . "'Baixa Exp',"
                    . "'" . $hora . "',"
                    . "2"
                    . ")";

            $aRetornoInsert = $this->executaSql($sSqlInsert);

            if ($aRetornoInsert[0]) {
                $sSqlDelete = "delete "
                        . "from rex_maquinas.widl.PROD01S1 "
                        . "where procod = " . $oDados->codigo . " "
                        . "and armcod = '" . $armcod . "'";
                $aRetornoDelete = $this->executaSql($sSqlDelete);

                if ($aRetornoDelete[0]) {
                    $sSqlHistorico = "insert "
                            . "into rex_maquinas.dbo.MetEnd_HistEnd "
                            . "("
                            . "nome,"
                            . "acao,"
                            . "data,"
                            . "hora,"
                            . "procod,"
                            . "endantes,"
                            . "enddepois,"
                            . "alm"
                            . ")"
                            . "values"
                            . "("
                            . "'" . $oObjNomeDel->usunomedelsoft . "',"
                            . "'Baixa Exp',"
                            . "'" . $data . "',"
                            . "'" . $hora . "',"
                            . "" . $oDados->codigo . ","
                            . "'" . $armcod . "',"
                            . "'Baixa Exp',"
                            . "" . $sAlm . ""
                            . ")";

                    $aRetornoHistorico = $this->executaSql($sSqlHistorico);
                    if ($aRetornoHistorico[0]) {
                        $aRetorno[0] = true;
                        $aRetorno[1] = '';
                        return $aRetorno;
                    } else {
                        return $aRetorno;
                    }
                } else {
                    return $aRetorno;
                }
            } else {
                return $aRetorno;
            }
            return $aRetorno;
        }
    }

}
