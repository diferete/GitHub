<?php

/*
 * Classe que implementa a persistencia de Motivo
 * @author Cleverton Hoffmann
 * @since 04/07/2018
 */

class PersistenciaDELX_MOT_Motivo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MOT_MOTIVO');

        $this->adicionaRelacionamento('mot_motivocodigo', 'mot_motivocodigo', true, true);
        $this->adicionaRelacionamento('mot_motivotipo', 'mot_motivotipo');
        $this->adicionaRelacionamento('mot_motivodescricao', 'mot_motivodescricao');

        $this->setSTop('1000');
        $this->adicionaOrderBy('mot_motivocodigo', 0);
    }

}
