<?php

/*
 * Implementa a classe persistencia MET_MANUT_OS
 * @author Cleverton Hoffmann
 * @since 21/07/2021
 */

class PersistenciaMET_MANUT_OS extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_MANUT_OS');
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('fil_codigo', 'DELX_FIL_Empresa.fil_codigo', false, false, false);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('cod', 'cod');
        $this->adicionaRelacionamento('cod', 'MET_CAD_Maquinas.codigoMaq', false, false, false);
        $this->adicionaRelacionamento('usuariocad', 'usuariocad');
        $this->adicionaRelacionamento('usuariocad', 'MET_TEC_USUARIO.usucodigo', false, false, false);
        $this->adicionaRelacionamento('datacad', 'datacad');
        $this->adicionaRelacionamento('codserv', 'codserv');
        $this->adicionaRelacionamento('codserv', 'MET_MANUT_OSServico.codserv', false, false, false);
        $this->adicionaRelacionamento('horacad', 'horacad');
        $this->adicionaRelacionamento('userenc', 'userenc');
        $this->adicionaRelacionamento('consumo', 'consumo');
        $this->adicionaRelacionamento('problema', 'problema');
        $this->adicionaRelacionamento('solucao', 'solucao');
        $this->adicionaRelacionamento('previsao', 'previsao');
        $this->adicionaRelacionamento('responsavel', 'responsavel');
        $this->adicionaRelacionamento('dataenc', 'dataenc');
        $this->adicionaRelacionamento('horaenc', 'horaenc');
        $this->adicionaRelacionamento('tipomanut', 'tipomanut');
        $this->adicionaRelacionamento('dias', 'dias');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('oqfazer', 'oqfazer');
        $this->adicionaRelacionamento('fezmanut', 'fezmanut');
        $this->adicionaRelacionamento('matnecessario', 'matnecessario');

        $sAnd = ' and MET_MANUT_OS.fil_codigo = MET_CAD_Maquinas.fil_codigo ';
        $this->adicionaJoin('MET_CAD_Maquinas', null, 1, 'cod', 'codigoMaq', $sAnd);
        $this->adicionaJoin('DELX_FIL_Empresa');
        $this->adicionaJoin('MET_MANUT_OSServico');
        $this->adicionaJoin('MET_TEC_USUARIO', null, 1, 'usuariocad', 'usucodigo');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop('50');
    }

    public function apontaInicio($aDados) {

        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Iniciada', "
                . "userinic ='" . $iCodUser . "', "
                . "datainic ='" . Util::getDataAtual() . "', "
                . "horainic ='" . date('H:i') . "'  where nr =" . $aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function apontaAberta($aDados) {

        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Aberta', "
                . "userretor ='" . $iCodUser . "', "
                . "dataretor ='" . Util::getDataAtual() . "', "
                . "horaretor ='" . date('H:i') . "'  where nr =" . $aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function apontaIniciada($aDados) {

        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Iniciada', "
                . "userretor ='" . $iCodUser . "', "
                . "dataretor ='" . Util::getDataAtual() . "', "
                . "horaretor ='" . date('H:i') . "'  where nr =" . $aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function cancela($aDados) {

        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Cancelada', "
                . "usercanc ='" . $iCodUser . "', "
                . "datacanc ='" . Util::getDataAtual() . "', "
                . "horacanc ='" . date('H:i') . "'  where nr =" . $aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function enc($aDados) {

        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Encerrada', "
                . "userenc ='" . $iCodUser . "', "
                . "dataenc ='" . Util::getDataAtual() . "', "
                . "horaenc ='" . date('H:i') . "'  where nr =" . $aDados['nr'] . " and fil_codigo=" . $aDados['fil_codigo'];
        $aRetorno = $this->executaSql($sSql);

        if ($aRetorno[0]) {

            $oMan = Fabrica::FabricarController('MET_MANUT_OS');
            $oMan->Persistencia->adicionaFiltro('fil_codigo', $aDados['fil_codigo']);
            $oMan->Persistencia->adicionaFiltro('nr', $aDados['nr']);
            $oManDados = $oMan->Persistencia->consultarWhere();
            
            if ($oManDados->getTipomanut()=='MP') {
                $oSer = Fabrica::FabricarController('MET_MANUT_OSServico');
                $oSer->Persistencia->adicionaFiltro('fil_codigo', $aDados['fil_codigo']);
                $oSer->Persistencia->adicionaFiltro('codserv', $oManDados->getCodserv());
                $oServDados = $oSer->Persistencia->consultarWhere();

                $sSql2 = "INSERT INTO MET_MANUT_OS (fil_codigo, nr, cod, usuariocad, datacad, horacad, codserv, consumo, problema,	
                    solucao, previsao, responsavel, userinic, datainic, horainic, usercanc,
                    datacanc, horacanc, userretor, dataretor, horaretor, userenc, dataenc, 
                    horaenc, tipomanut, dias, codsetor, obs, situacao, oqfazer, fezmanut, matnecessario)
                    SELECT fil_codigo, (SELECT COALESCE(MAX(nr),0)+1 AS nr FROM MET_MANUT_OS where fil_codigo=" . $aDados['fil_codigo'] . "), cod, " . $iCodUser . ", '" . Util::getDataAtual() . "', '" . date('H:i') . "', codserv, '', '',
                    '', '" . date('d/m/Y', strtotime('+'.$oServDados->getCiclo().' days')) . "', responsavel, '', '', '', '',
                    '', '', '', '', '', '', '',
                    '', tipomanut, ".$oServDados->getCiclo().", codsetor, '', 'Aberta', oqfazer, '', '' 
                    FROM MET_MANUT_OS WHERE nr=" . $aDados['nr'] . " and fil_codigo=" . $aDados['fil_codigo']."";
                $aRetorno = $this->executaSql($sSql2);
            }
        }
        return $aRetorno;
    }

    /**
     * Método que atualiza campos da tabela na hora da consulta
     */
    public function atualizaDataAntesdaConsulta() {

        $sSql = "update MET_MANUT_OS set dias = DATEDIFF(DAY, GETDATE(), previsao)
            where situacao <> 'Encerrada' and situacao <> 'Cancelada'";

        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function buscaDadosCrachaMan($sCracha) {
        $sSql = "select usucodigo,usunome from MET_TEC_Usuario where usucracha = " . $sCracha . "";
        $oObjCracha = $this->consultaSql($sSql);
        return $oObjCracha;
    }

}
