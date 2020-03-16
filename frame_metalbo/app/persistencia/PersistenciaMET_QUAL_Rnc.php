<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_QUAL_Rnc extends Persistencia {

    public function __construct() {
        parent::__construct();
        $this->setTabela('MET_QUAL_Rnc');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('codprobl', 'codprobl');
        $this->adicionaRelacionamento('codprobl', 'MET_QUAL_Prob_Rnc.codprobl', false, false, false);
        $this->adicionaRelacionamento('databert', 'databert');
        $this->adicionaRelacionamento('horaini', 'horaini');
        $this->adicionaRelacionamento('codprod', 'codprod');
        $this->adicionaRelacionamento('codmat', 'codmat');
        $this->adicionaRelacionamento('sit', 'sit');
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('lote', 'lote');
        $this->adicionaRelacionamento('corrida', 'corrida');
        $this->adicionaRelacionamento('qtlote', 'qtlote');
        $this->adicionaRelacionamento('qtloternc', 'qtloternc');
        $this->adicionaRelacionamento('descset01', 'descset01');
        $this->adicionaRelacionamento('userini', 'userini');
        $this->adicionaRelacionamento('turno01', 'turno01');
        $this->adicionaRelacionamento('tipornc', 'tipornc');
        $this->adicionaRelacionamento('fornec', 'fornec');
        $this->adicionaRelacionamento('descrnc', 'descrnc');
        $this->adicionaRelacionamento('descset02', 'descset02');
        $this->adicionaRelacionamento('turno02', 'turno02');
        $this->adicionaRelacionamento('usercausa', 'usercausa');
        $this->adicionaRelacionamento('causarnc', 'causarnc');
        $this->adicionaRelacionamento('desccausa', 'desccausa');
        $this->adicionaRelacionamento('decisaornc', 'decisaornc');
        $this->adicionaRelacionamento('descdescirnc', 'descdescirnc');
        $this->adicionaRelacionamento('respcausa', 'respcausa');
        $this->adicionaRelacionamento('lidercausa', 'lidercausa');
        $this->adicionaRelacionamento('userf', 'userf');
        $this->adicionaRelacionamento('dataf', 'dataf');
        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('anexo3', 'anexo3');
        $this->adicionaRelacionamento('anexo4', 'anexo4');
        $this->adicionaRelacionamento('descprod', 'descprod');



        $this->adicionaRelacionamento('filcgc', 'Pessoa.empcod', false, false);
        $this->adicionaRelacionamento('empdes', 'empdes', false, false);
        $this->adicionaJoin('MET_QUAL_Prob_Rnc');
        $this->adicionaJoin('Pessoa', null, 1, 'filcgc', 'empcod');

        //$this->setSTop(50);

        $this->adicionaOrderBy('nr', 1);
    }

    public function buscaDadosOp($sOp) {

        $sSql = 'select metop.op,cod,prodes from metop  '
                . 'left outer join  metitenop '
                . 'on metop.op = metitenop.op '
                . 'where metop.op  =' . $sOp . ' ';
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno;
    }

    public function buscaDadoscodmat($sCodmat) {

        $sSql = 'select procod,prodes '
                . ' FROM WIDL.PROD01'
                . ' WHERE GRUCOD =2 '
                . 'AND PROCOD =' . $sCodmat . ' ';
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno;
    }

    public function buscaDadoscodprod($sCodprod) {

        $sSql = 'select procod,prodes '
                . ' FROM WIDL.PROD01'
                . ' WHERE GRUCOD in(12,13) '
                . 'AND PROCOD =' . $sCodprod . ' ';
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno;
    }

    public function CancelaRnc($aDados) {
        $dData = date('d/m/Y');
        $hHora = date('H:i:s');


        $sSql = "update MET_QUAL_Rnc set sit = 'Cancelada',userf='" . $_SESSION['nome'] . "',dataf='" . $dData . "',horaf='" . $hHora . "' where nr = " . $aDados['nr'] . " and filcgc =" . $aDados['filcgc'] . "";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function FinalizaRnc($aDados) {
        $dData = date('d/m/Y');
        $hHora = date('H:i:s');


        $sSql = "update MET_QUAL_Rnc set sit = 'Finalizada',userf='" . $_SESSION['nome'] . "',dataf='" . $dData . "',horaf='" . $hHora . "' where nr = " . $aDados['nr'] . " and filcgc =" . $aDados['filcgc'] . "";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaDados($aDados) {
        $sSql = 'select * from MET_QUAL_Rnc where nr = ' . $aDados['nr'] . ' and filcgc = ' . $aDados['filcgc'];
        $oRetorno = $this->consultaSql($sSql);

        return $oRetorno;
    }

    public function buscaCorrida($sDados) {
        $sSql = "select COUNT(*) as corrida from MetQual_MovOi where corrida = '" . $sDados . "'";
        $iCorrida = $this->consultaSql($sSql);

        if ($iCorrida->corrida > 0) {
            return true;
        } else {
            return false;
        }
    }

}
