<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_FavMenu extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_favmenu');

        $this->adicionaRelacionamento('usucodigo', 'usucodigo', true, true);
        $this->adicionaRelacionamento('favseq', 'favseq', true, true, true);
        $this->adicionaRelacionamento('favdescricao', 'favdescricao');
        $this->adicionaRelacionamento('favclasse', 'favclasse');
        $this->adicionaRelacionamento('favmetodo', 'favmetodo');
        $this->adicionaRelacionamento('favordem', 'favordem');
    }

    /**
     * Retorna o menu favorito
     */
    public function getFavMenu() {
        $sSql = "select favseq,favdescricao,favclasse,favmetodo,favordem from MET_TEC_favmenu where usucodigo =" . $_SESSION['codUser'] . " order by favseq";
        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aFav = array();
            $aFav[] = $row->favseq;
            $aFav[] = $row->favdescricao;
            $aFav[] = $row->favclasse;
            $aFav[] = $row->favmetodo;
            $aFav[] = $row->favordem;
            $aFavComp[] = $aFav;
        }
        return $aFavComp;
    }

    public function insertFav($aDados) {
        $this->adicionaFiltro('usucodigo', $_SESSION['codUser']);
        $this->setChaveIncremento(false);
        $iSeq = $this->getIncremento('favseq', true);
        $iOrdem = $this->getIncremento('favordem', true);

        $this->Model->setUsucodigo($_SESSION['codUser']);
        $this->Model->setFavseq($iSeq);
        $this->Model->setFavdescricao($aDados[0]);
        $this->Model->setFavclasse($aDados[1]);
        $this->Model->setFavmetodo($aDados[2]);
        $this->Model->setFavordem($iOrdem);



        $aRetorno = $this->inserir();
        return $aRetorno;
    }

}
