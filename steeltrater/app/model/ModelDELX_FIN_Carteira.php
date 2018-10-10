<?php

/*
 * Classe que implementa os models da FIN_Carteira
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

Class ModelDELX_FIN_Carteira {

    private $fin_carteiracodigo;
    private $fin_carteiradescricao;

    function getFin_carteiracodigo() {
        return $this->fin_carteiracodigo;
    }

    function getFin_carteiradescricao() {
        return $this->fin_carteiradescricao;
    }

    function setFin_carteiracodigo($fin_carteiracodigo) {
        $this->fin_carteiracodigo = $fin_carteiracodigo;
    }

    function setFin_carteiradescricao($fin_carteiradescricao) {
        $this->fin_carteiradescricao = $fin_carteiradescricao;
    }
}
