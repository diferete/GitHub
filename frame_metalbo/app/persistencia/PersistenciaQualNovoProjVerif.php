<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualNovoProjVerif extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbqualNovoProjeto');

        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);

        $this->adicionaRelacionamento('verifDesenhoPrev', 'verifDesenhoPrev');
        $this->adicionaRelacionamento('verifDesenhoTer', 'verifDesenhoTer');
        $this->adicionaRelacionamento('verifDesenhoResp', 'verifDesenhoResp');
        $this->adicionaRelacionamento('verifDesenhoAnex', 'verifDesenhoAnex');

        $this->adicionaRelacionamento('verifRelFerrPrev', 'verifRelFerrPrev');
        $this->adicionaRelacionamento('verifRelFerrter', 'verifRelFerrter');
        $this->adicionaRelacionamento('verifRelFerrResp', 'verifRelFerrResp');
        $this->adicionaRelacionamento('verifRelFerrAnex', 'verifRelFerrAnex');

        $this->adicionaRelacionamento('verifDesenhoFerrPrev', 'verifDesenhoFerrPrev');
        $this->adicionaRelacionamento('verifDesenhoFerrTer', 'verifDesenhoFerrTer');
        $this->adicionaRelacionamento('verifDesenhoFerrResp', 'verifDesenhoFerrResp');
        $this->adicionaRelacionamento('verifDesenhoFerrAnex', 'verifDesenhoFerrAnex');

        $this->adicionaRelacionamento('dimenFerrPrev', 'dimenFerrPrev');
        $this->adicionaRelacionamento('dimenFerrTer', 'dimenFerrTer');
        $this->adicionaRelacionamento('dimenFerrResp', 'dimenFerrResp');
        $this->adicionaRelacionamento('dimenFerrAnex', 'dimenFerrAnex');

        $this->adicionaRelacionamento('dimenProdPrev', 'dimenProdPrev');
        $this->adicionaRelacionamento('dimenProdTer', 'dimenProdTer');
        $this->adicionaRelacionamento('dimenProdResp', 'dimenProdResp');
        $this->adicionaRelacionamento('dimenProdAnex', 'dimenProdAnex');


        $this->adicionaRelacionamento('camadaZincoPrev', 'camadaZincoPrev');
        $this->adicionaRelacionamento('camadaZincoTer', 'camadaZincoTer');
        $this->adicionaRelacionamento('camadaZincoResp', 'camadaZincoResp');
        $this->adicionaRelacionamento('camadaZincoAnex', 'camadaZincoAnex');

        $this->adicionaRelacionamento('ensaioDurezaPrev', 'ensaioDurezaPrev');
        $this->adicionaRelacionamento('ensaioDurezaTer', 'ensaioDurezaTer');
        $this->adicionaRelacionamento('ensaioDurezaResp', 'ensaioDurezaResp');
        $this->adicionaRelacionamento('ensaioDurezaAnex', 'ensaioDurezaAnex');

        $this->adicionaRelacionamento('cargaprovaPrev', 'cargaprovaPrev');
        $this->adicionaRelacionamento('cargaprovaTer', 'cargaprovaTer');
        $this->adicionaRelacionamento('cargaprovaResp', 'cargaprovaResp');
        $this->adicionaRelacionamento('cargaprovaAnex', 'cargaprovaAnex');

        $this->adicionaRelacionamento('terceiroPrev', 'terceiroPrev');
        $this->adicionaRelacionamento('terceiroTer', 'terceiroTer');
        $this->adicionaRelacionamento('terceiroResp', 'terceiroResp');
        $this->adicionaRelacionamento('terceiroAnex', 'terceiroAnex');

        $this->adicionaRelacionamento('ensReq', 'ensReq');
        $this->adicionaRelacionamento('ensReqDef', 'ensReqDef');
        $this->adicionaRelacionamento('ensReqLegal', 'ensReqLegal');
        $this->adicionaRelacionamento('ensPlan', 'ensPlan');
        $this->adicionaRelacionamento('ensComem', 'ensComem');
        $this->adicionaRelacionamento('respEns', 'respEns');

        $this->adicionaRelacionamento('valNf', 'valNf');
        $this->adicionaRelacionamento('valNfPrev', 'valNfPrev');
        $this->adicionaRelacionamento('valNfTer', 'valNfTer');
        $this->adicionaRelacionamento('valNfResp', 'valNfResp');

        $this->adicionaRelacionamento('valOd', 'valOd');
        $this->adicionaRelacionamento('valOdPrev', 'valOdPrev');
        $this->adicionaRelacionamento('valOdTer', 'valOdTer');
        $this->adicionaRelacionamento('valODResp', 'valODResp');

        $this->adicionaRelacionamento('valPed', 'valPed');
        $this->adicionaRelacionamento('valPedPrev', 'valPedPrev');
        $this->adicionaRelacionamento('valPedTer', 'valPedTer');
        $this->adicionaRelacionamento('valPedResp', 'valPedResp');

        $this->adicionaRelacionamento('valPapp', 'valPapp');
        $this->adicionaRelacionamento('valPappPrev', 'valPappPrev');
        $this->adicionaRelacionamento('valPappTer', 'valPappTer');
        $this->adicionaRelacionamento('valPappResp', 'valPappResp');



        $this->adicionaRelacionamento('etapProj', 'etapProj');
        $this->adicionaRelacionamento('result', 'result');
        $this->adicionaRelacionamento('cliprov', 'cliprov');
        $this->adicionaRelacionamento('valproj', 'valproj');
        $this->adicionaRelacionamento('comenvalproj', 'comenvalproj');
        $this->adicionaRelacionamento('respvalproj', 'respvalproj');

        $this->adicionaJoin('EmpRex');
        $this->adicionaOrderBy('nr', 1);
        $this->setSTop('50');
    }

    public function verifValProj($sDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');
        $sSql = "select respvalproj,etapProj,result,cliprov,valproj from tbqualNovoProjeto where nr='" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aElemen = json_decode(json_encode($oRow), true);
        $aElemenFilter = array_filter($aElemen);

        $oRespValProj = $oRow->respvalproj;
        $iCount = count($aElemenFilter);

        if ($iCount == 5 && $oRespValProj == 'Eloir') {
            $sSql = "update tbqualNovoProjeto set sitgeralproj = 'Cadastrado',
                sitproj = 'Cód. enviado',
                dtafimProj = '" . $sData . "',
                horafimProj = '" . $sHora . "',
                userfimProj = '" . $_SESSION['nome'] . "'
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
            $this->executaSql($sSql);
            return;
        } else {
            return;
        }
    }

}
