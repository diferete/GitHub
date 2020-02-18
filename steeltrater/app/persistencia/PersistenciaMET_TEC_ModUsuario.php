<?php

class PersistenciaMET_TEC_ModUsuario extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_modusuario');

        $this->adicionaRelacionamento('usucodigo', 'MET_TEC_Usuario.usucodigo', true, true);
        $this->adicionaRelacionamento('modcod', 'MET_TEC_Modulo.modcod', true, true);
        $this->adicionaRelacionamento('modordem', 'modordem');

        $this->adicionaJoin('MET_TEC_Modulo');
        $this->adicionaJoin('MET_TEC_Usuario');
    }

    /*
     * Método que retorna o modulo inicial ou todos os módulos do usuário
     */

    public function modUserSistema($bInicial, $sModulo) {
        if ($bInicial) {
            $sSql = "select MET_TEC_modusuario.modcod,modescricao from MET_TEC_modusuario left outer join 
                    MET_TEC_modulo on MET_TEC_modusuario.modcod = MET_TEC_modulo.modcod
                    where usucodigo =" . $_SESSION['codUser'] . " and modordem = 1";
            $result = $this->getObjetoSql($sSql);
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $aqt = array();
                $aqt[] = $row->modescricao;
                $aqt[] = $row->modcod;
            }
            return $aqt;
        } else {
            $sSql = "select MET_TEC_modusuario.modcod,modescricao from MET_TEC_modusuario left outer join 
                    MET_TEC_modulo on MET_TEC_modusuario.modcod = MET_TEC_modulo.modcod
                    where usucodigo =" . $_SESSION['codUser'] . "";
            if (isset($sModulo)) {
                $sSql .= " and MET_TEC_modusuario.modcod =" . $sModulo . " ";
            }
            $sSql .= " order by MET_TEC_modusuario.modordem ";
            $result = $this->getObjetoSql($sSql);
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $aqt = array();
                $aqt[] = $row->modescricao;
                $aqt[] = $row->modcod;
                $aRet[] = $aqt;
            }
            return $aRet;
        }
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

