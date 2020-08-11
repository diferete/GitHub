<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Testes extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    public function insereGrupo() {

        $sSqlCod = "select procod from tbqualNovoProjeto where procod is not null and grucod is null and subcod is null and famcod is null and famsub is null";
        $result = $this->getObjetoSql($sSqlCod);
        $aProCod = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            array_push($aProCod, $row->procod);
        }

        foreach ($aProCod as $key => $value) {
            $sSql = "update tbqualNovoProjeto set grucod = (select grucod from widl.PROD01 where procod = " . $value . " ),
                    subcod = (select subcod from widl.PROD01 where procod = " . $value . " ),
                    famcod = (select famcod from widl.PROD01 where procod = " . $value . " ),
                    famsub = (select famsub from widl.PROD01 where procod = " . $value . " ) where procod = " . $value . "";
            $aRetorno = $this->executaSql($sSql);

            $i = mt_rand(00, 9999999999);
            $LogNome = date('d-m-Y H-i-s' . $i);
            if ($aRetorno[0] == true) {
                $meuArquivo = $LogNome . '-PdoLogGrupoProd.txt';
                $data = $LogNome . '-> grupo item ' . $value . ' concluida com sucesso';
            } else {
                $meuArquivo = $LogNome . '-PdoLogERRO.txt';
                $data = $aRetorno[1] . $value;
            }
            $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'GitHub/frame_metalbo/LOGS/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
            fwrite($gerenciaArquivo, $data);
            fclose($gerenciaArquivo);
        }
        return;
    }

    public function insereGrupo2() {

        $sSqlCod = "SELECT desc_novo_prod,grucod,nr from tbqualNovoProjeto WHERE (lower(desc_novo_prod) LIKE '%FRANCES%')";
        $result = $this->getObjetoSql($sSqlCod);
        $aProCod = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            array_push($aProCod, $row->nr);
        }

        foreach ($aProCod as $key => $value) {
            $sSql = "update tbqualNovoProjeto set grucod = '13' where nr = " . $value . "";
            $aRetorno = $this->executaSql($sSql);

            $i = mt_rand(00, 9999999999);
            $LogNome = date('d-m-Y H-i-s' . $i);
            if ($aRetorno[0] == true) {
                $meuArquivo = $LogNome . '-PdoLogGrupoProd.txt';
                $data = $LogNome . '-> grupo item ' . $value . ' concluida com sucesso';
            } else {
                $meuArquivo = $LogNome . '-PdoLogERRO.txt';
                $data = $aRetorno[1] . $value;
            }
            $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'GitHub/frame_metalbo/LOGS/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
            fwrite($gerenciaArquivo, $data);
            fclose($gerenciaArquivo);
        }
        return;
    }

    public function pesoXml($sProcod, $sPeso) {
        $sSql = "insert into testeXml values('" . $sProcod . "','" . $sPeso . "')";
        $aRetorno = $this->executaSql($sSql);
        return;
    }

    public function inserePlaca() {
        $sSqlPlaca = "select * from MET_PORT_CadVeiculos";
        $result = $this->getObjetoSql($sSqlPlaca);
        $aPlacas = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            array_push($aPlacas, $row);
        }
        foreach ($aPlacas as $key => $oValue) {
            $sSqlInserePlaca = "insert into MET_CAD_Placas(filcgc,empcod,empdes,placa,cracha,nome)"
                    . "values('" . $oValue->filcgc . "','" . $oValue->empcod . "','" . $oValue->empdes . "','" . $oValue->placa . "','" . $oValue->cracha . "','" . $oValue->pessoa . "')";
            $aResult = $this->executaSql($sSqlInserePlaca);
        }
        return;
    }

    /**
     * Busca dados via select na tabela de entrada de projetos
     * 
     * */
    public function verificaSitEntProj() {
        $sSql = "select sitgeralproj,sitproj,sitcliente,sitvendas,filcgc,nr,desc_novo_prod,dtimp,
                empcod,officedes,repnome,resp_venda_nome,dtaprovendas,
                resp_proj_cod,resp_venda_cod,repcod,emailCli,
                DATEDIFF(day,dtaprovendas,GETDATE())as dias 
                from tbqualNovoProjeto where sitvendas='Aprovado' 
                and  sitgeralproj='Em execução' and sitcliente = 'Aguardando'";
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $oRowBD;
            $aRetorno[] = $oModel;
        }

        return $aRetorno;
    }

    /**
     * Faz update de campos na tabela em caso de tempo projeto expirado sem aprovação do cliente 
     * 
     * */
    public function mudaSitEntProj($aDados) {
        $iDias = 0;
        foreach ($aDados as $iKey => $oValue) {

            $iDias = $oValue->dias;
            $sFilcgc = $oValue->filcgc;
            $iNr = $oValue->nr;

            if ($iDias >= 60) {
                date_default_timezone_set('America/Sao_Paulo');
                $sSql = "update tbqualNovoProjeto 
                set sitgeralproj = 'Expirado',
                sitcliente = 'Expirado',
                userreprovcli = 'Expirado pelo Sistema'  
                where filcgc = '" . $sFilcgc . "' and nr = '" . $iNr . "'";
                $aRetorno = $this->executaSql($sSql);
            }
        }
        return $aRetorno;
    }

}
