<?php

/*
 * Implementa a classe persistencia MET_TEC_LogMensagens
 * @author Alexandre de Souza
 * @since 18/05/2020
 */

class PersistenciaMET_TEC_LogMensagens extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_LogMensagens');
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('seq', 'seq');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('datalog', 'datalog');
        $this->adicionaRelacionamento('horalog', 'horalog');
        $this->adicionaRelacionamento('mensagem', 'mensagem');
        $this->adicionaRelacionamento('lida', 'lida');
        $this->adicionaRelacionamento('usunome', 'usunome');
    }

    public function gravaLog($aDados) {
        $sSql = 'select coalesce(max(seq),0) as ultimo from MET_TEC_LogMensagens where usucodigo = ' . $aDados[5];
        $obj = $this->consultaSql($sSql);
        $iUltimo = $obj->ultimo;

        if ($iUltimo == null || !$iUltimo || $iUltimo == 0) {
            $sSql = "insert into MET_TEC_LogMensagens "
                    . "(filcgc,seq,usucodigo,datalog,horalog,mensagem,lida,usunome) "
                    . "values "
                    . "(" . $_SESSION['filcgc'] . ",1," . $aDados[5] . ",'" . $aDados[3] . "','" . $aDados[4] . "','" . $aDados[2] . " - " . $aDados[0] . " - " . $aDados[1] . "','N','" . $aDados[6] . "')";
        } else {
            $seq = $iUltimo + 1;
            $sSql = "insert into MET_TEC_LogMensagens "
                    . "(filcgc,seq,usucodigo,datalog,horalog,mensagem,lida,usunome) "
                    . "values "
                    . "(" . $_SESSION['filcgc'] . "," . $seq . ",'" . $aDados[5] . "','" . $aDados[3] . "','" . $aDados[4] . "','" . $aDados[2] . " - " . $aDados[0] . " - " . $aDados[1] . "','N','" . $aDados[6] . "')";
        }

        $bDebug = $this->executaSql($sSql);
    }

}
