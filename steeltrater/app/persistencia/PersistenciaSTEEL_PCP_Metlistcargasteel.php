<?php

/*
 * * Implementa classe persistencia
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class PersistenciaSTEEL_PCP_Metlistcargasteel extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.dbo.metlistcargasteel');
        $this->adicionaRelacionamento('dataCarga', 'dataCarga', true);
        $this->adicionaRelacionamento('nrCarga', 'nrCarga', true);
        $this->adicionaRelacionamento('sit', 'sit');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');

        $this->setBConsultaManual(true);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "SELECT rex_maquinas.dbo.metlistcargasteel.datacarga AS 'rex_maquinas.dbo.metlistcargasteel.datacarga',"
                . "rex_maquinas.dbo.metlistcargasteel.nrcarga AS 'rex_maquinas.dbo.metlistcargasteel.nrcarga',"
                . "rex_maquinas.dbo.metlistcargasteel.sit AS 'rex_maquinas.dbo.metlistcargasteel.sit',"
                . "rex_maquinas.dbo.metlistcargasteel.usuario AS 'rex_maquinas.dbo.metlistcargasteel.usuario',"
                . "rex_maquinas.dbo.metlistcargasteel.data AS 'rex_maquinas.dbo.metlistcargasteel.data',"
                . "rex_maquinas.dbo.metlistcargasteel.hora AS 'rex_maquinas.dbo.metlistcargasteel.hora' FROM rex_maquinas.dbo.metlistcargasteel "
                . "ORDER BY rex_maquinas.dbo.metlistcargasteel.dataCarga DESC ";

        return $sSql;
    }

}
