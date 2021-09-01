<?php

/**
 * Classe responsável pelas operações de persistência do objeto
 * ItemMenu
 * 
 * @author Fernando Salla
 * @since 29/06/2012 
 */
class PersistenciaItemMenu extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela("tbitenmenu");

        $this->adicionaRelacionamento('modcod', 'Modulo.modcod', true);
        $this->adicionaRelacionamento('mencodigo', 'Menu.mencodigo', true);
        $this->adicionaRelacionamento('itecodigo', 'itecodigo', true, true, true);
        $this->adicionaRelacionamento('itedescricao', 'itedescricao');
        $this->adicionaRelacionamento('iteordem', 'iteordem');
        $this->adicionaRelacionamento('iteclasse', 'iteclasse');
        $this->adicionaRelacionamento('itemetodo', 'itemetodo');
        $this->adicionaRelacionamento('rotina', 'rotina');

        $this->adicionaJoin('Modulo');
        $this->adicionaJoin('Menu');
    }

    /*
     * Método que retorna um array de submenus tendo como parametros o 
     * o modulo e o menu
     */

    public function getSubMenu($sModcod, $sMenCodigo) {
        $sSql = "SELECT itedescricao,iteclasse,itemetodo
                FROM tbitenmenu
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

    public function getRotinasAdicionais() {
        $sSql = "select "
                . "mencodigo,"
                . "itedescricao,"
                . "iteclasse,"
                . "itemetodo,"
                . "iteordem, "
                . "tbitenmenu.modcod as modcod "
                . "from tbitenmenu "
                . "left outer join tbmodusuario on "
                . "tbitenmenu.modcod = tbmodusuario.modcod "
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
            $aItenMenu[] = $row->modcod;
            $aRotinas[] = $aItenMenu;
        }
        return $aRotinas;
    }

    public function getRotinasAdicionaisContadores($aValue) {

        switch ($aValue[4]) {
            case 1:

                /* steeltrater */
                $sSql = "select COUNT(*) as total from sup_solicitacao(nolock) where sup_solicitacaosituacao = 'A' and fil_codigo = '8993358000174' ";
                $s = $this->consultaSql($sSql);

                /* matriz */
                /*
                  $sSql = "select count(*) as total from rex_maquinas.widl.SOL01(nolock) where solsituaca = 'I' and filcgc = '75483040000130'";
                  $m = $this->consultaSql($sSql);

                  $iCont = $m->total + $s->total; */

                $iCont = $s->total;

                break;

            case 2:

                /* steeltrater */
                $sSql = "select COUNT(*) as total from sup_pedido(nolock) where sup_pedidosituacao = 'A' and fil_codigo = '8993358000174' ";
                $s = $this->consultaSql($sSql);

                /* matriz */
                /*
                  $sSql = "select count(*) as total from rex_maquinas.widl.PED01(nolock) where pdcsituaca = 'N' and pdcfutaut ='" . $_SESSION['nomedelsoft'] . "' and filcgc = '75483040000130'";
                  $m = $this->consultaSql($sSql);

                  $iCont = $m->total + $s->total; */
                $iCont = $s->total;

                break;
        }
        return $iCont;
    }

}

?>