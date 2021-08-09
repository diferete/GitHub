<?php

/**
 * Classe responsável pelas operações de persistência do objeto
 * ItemMenu
 * 
 * @author Fernando Salla
 * @since 29/06/2012 
 */
class PersistenciaMET_TEC_ItemMenu extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela("MET_TEC_itenmenu");

        $this->adicionaRelacionamento('modcod', 'MET_TEC_Modulo.modcod', true);
        $this->adicionaRelacionamento('mencodigo', 'MET_TEC_Menu.mencodigo', true);
        $this->adicionaRelacionamento('itecodigo', 'itecodigo', true, true, true);
        $this->adicionaRelacionamento('itedescricao', 'itedescricao');
        $this->adicionaRelacionamento('iteordem', 'iteordem');
        $this->adicionaRelacionamento('iteclasse', 'iteclasse');
        $this->adicionaRelacionamento('itemetodo', 'itemetodo');
        $this->adicionaRelacionamento('url', 'url');
        $this->adicionaRelacionamento('iconApp', 'iconApp');
        $this->adicionaRelacionamento('rotina', 'rotina');

        $this->adicionaJoin('MET_TEC_Modulo');
        $this->adicionaJoin('MET_TEC_Menu');
    }

    /*
     * Método que retorna um array de submenus tendo como parametros o 
     * o modulo e o menu
     */

    public function getSubMenu($sModcod, $sMenCodigo) {
        $sSql = "SELECT itedescricao,iteclasse,itemetodo
                FROM MET_TEC_itenmenu
                WHERE modcod =" . $sModcod . " AND mencodigo =" . $sMenCodigo . " ORDER BY iteordem";

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aSubMenu = array();
            $aSubMenu[] = $row->itedescricao;
            $aSubMenu[] = $row->iteclasse;
            $aSubMenu[] = $row->itemetodo;

            $aRetorno[] = $aSubMenu;
        }
        return $aRetorno;
    }

    /*
     * Método que retorna um array de submenus tendo como parametros o 
     * o modulo e o menu
     */

    public function getSubMenuApp($sModcod, $sMenCodigo) {
        $sSql = "SELECT itedescricao,iteclasse,itemetodo,iteinfo,url,iconapp
                FROM MET_TEC_itenmenu
                WHERE modcod =" . $sModcod . " AND mencodigo =" . $sMenCodigo . " ORDER BY iteordem";

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aSubMenu = array();
            $aSubMenu['itedescricao'] = $row->itedescricao;
            $aSubMenu['iteclasse'] = $row->iteclasse;
            $aSubMenu['itemetodo'] = $row->itemetodo;
            $aSubMenu['iteinfo'] = $row->iteinfo;
            $aSubMenu['url'] = $row->url;
            $aSubMenu['iconApp'] = $row->iconapp;
            $aRetorno[] = $aSubMenu;
        }
        return $aRetorno;
    }

    public function getRotinasAdicionais() {
        $sSql = "select "
                . "mencodigo,"
                . "itedescricao,"
                . "iteclasse,"
                . "itemetodo,"
                . "iteordem "
                . "from MET_TEC_itenmenu "
                . "left outer join MET_TEC_modusuario on "
                . "MET_TEC_itenmenu.modcod = MET_TEC_modusuario.modcod "
                . "where rotina = 'S' "
                . "and usucodigo = " . $_SESSION['codUser'];
        $result = $this->getObjetoSql($sSql);
        $aRotinas = array();
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aItenMenu = array();
            $aItenMenu[] = $row->mencodigo;
            $aItenMenu[] = $row->itedescricao;
            $aItenMenu[] = $row->iteclasse;
            $aItenMenu[] = $row->itemetodo;
            $aItenMenu[] = $row->iteordem;
            $aRotinas[] = $aItenMenu;
        }
        return $aRotinas;
    }

}

?>