<?php
 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualCausa extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbacaoqualcausa');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('causa', 'causa');
        $this->adicionaRelacionamento('causades', 'causades');
        $this->adicionaRelacionamento('anexocausa1', 'anexocausa1');
        $this->adicionaRelacionamento('causaprov', 'causaprov');
        $this->adicionaRelacionamento('pq1', 'pq1');
        $this->adicionaRelacionamento('pq2', 'pq2');
        $this->adicionaRelacionamento('pq3', 'pq3');
        $this->adicionaRelacionamento('pq4', 'pq4');
        $this->adicionaRelacionamento('pq5', 'pq5');
        $this->adicionaRelacionamento('ocorrencia', 'ocorrencia');
        $this->adicionaRelacionamento('matprimades', 'matprimades');
        $this->adicionaRelacionamento('metododes', 'metododes');
        $this->adicionaRelacionamento('maodeobrades', 'maodeobrades');
        $this->adicionaRelacionamento('equipamentodes', 'equipamentodes');
        $this->adicionaRelacionamento('meioambientedes', 'meioambientedes');
        $this->adicionaRelacionamento('medidades', 'medidades');


        $this->adicionaOrderBy('seq', 1);
    }

    //atualiza ocorrencias
    public function atualizaOcorrencia($sFilcgc, $sNr, $sSeq) {
        $sSql = "select * from tbacaoqualcausa where filcgc = '" . $sFilcgc . "' and nr ='" . $sNr . "'";
        $result = $this->getObjetoSql($sSql);


        while ($oRow = $result->fetch(PDO::FETCH_OBJ)) {
            $sCausa = $oRow->causa;
            //verifica as ocorrencias e da um update
            $sSql2 = "select COUNT(*)as ocorrencia from tbacaoqualcausa 
                    where filcgc ='" . $sFilcgc . "' and nr ='" . $sNr . "'
                    and causa ='" . $sCausa . "'
                    group by causa
                    order by ocorrencia desc ";
            $result2 = $this->getObjetoSql($sSql2);
            $oRow2 = $result2->fetch(PDO::FETCH_OBJ);
            $sOcorrencia = $oRow2->ocorrencia;

            //gera o update
            $sSql3 = "update tbacaoqualcausa set ocorrencia ='" . $sOcorrencia . "' 
                    where filcgc ='" . $sFilcgc . "' and nr ='" . $sNr . "'
                    and causa ='" . $sCausa . "'";
            $aRetUp = $this->executaSql($sSql3);
        }
        return $aRetorno[0] = true;
    }

}
