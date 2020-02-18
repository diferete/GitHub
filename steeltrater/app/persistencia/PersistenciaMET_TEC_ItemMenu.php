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

}

?>