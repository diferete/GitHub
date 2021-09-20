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
            $sSql = $sSql . "and rex_maquinas.widl.PROD01S1.cod like '%" . $oDados->tipo . "%' ";
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

    public function updateEndereco($oDados) {
        $est = preg_replace('/\D/', '', $oDados->estante);
        $nvl = preg_replace('/\D/', '', $oDados->nivel);
        $col = preg_replace('/\D/', '', $oDados->coluna);
        $armcod = $est . '.' . $nvl . '.' . $col;
        $data = date('d/m/Y');

        $sSql = "update rex_maquinas.widl.PROD01S1 set "
                . "armcod = '" . $armcod . "',"
                . "tipend = '" . $oDados->tipo . "',"
                . "data = '" . $data . "' "
                . "where procod = '" . $oDados->codigo . "' "
                . "and armcod = '" . $oDados->armcod . "'";
        $aRetorno = $this->executaSql($sSql);
        $aRetorno[2] = $armcod;
        return $aRetorno;
    }

}
