<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_FavMenu extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_FavMenu');
    }

    /**
     * Retorna a string contendo o menu favorito
     */
    public function getFavMenu($bRecarrega = null) {
        $aFav = $this->Persistencia->getFavMenu();

        if ($bRecarrega) {
            $sString = '';
            foreach ($aFav as $key => $avalue) {
                $sMenuId = $avalue[0] . '-fav';
                $sString .= '<li role="presentation" id="menu-' . $sMenuId . '">'
                        . '                <a href="javascript:void(0)" title="Abre a tela ' . $avalue[1] . '"  onclick="verificaTab(\\\'menu-' . $sMenuId . '\\\',\\\'' . $sMenuId . '\\\',\\\'' . $avalue[2] . '\\\',\\\'' . $avalue[3] . '\\\',\\\'tabmenu-' . $sMenuId . '\\\'); "role="menuitem">'
                        . '                  <span class="icon fa-star-o"></span>' . $avalue[1] . '<span title="Deleta favorito" onclick="requestAjax(\\\'menu-' . $sMenuId . '\\\',\\\'FavMenu\\\',\\\'msgdeletaFav\\\',\\\'' . utf8_encode($avalue[2]) . ',' . utf8_encode($avalue[3]) . ',\\\');" class="icon wb-trash pull-right fav-red"></span></a>'
                        . '              </li>';
            }
        } else {
            foreach ($aFav as $key => $avalue) {
                $sMenuId = $avalue[0] . '-fav';
                $sString .= '<li role="presentation" id="menu-' . $sMenuId . '" >'
                        . '                <a href="javascript:void(0)" title="Abre a tela ' . $avalue[1] . '"  onclick="verificaTab(\'menu-' . $sMenuId . '\',\'' . $sMenuId . '\',\'' . $avalue[2] . '\',\'' . $avalue[3] . '\',\'tabmenu-' . $sMenuId . '\'); "role="menuitem"> '
                        . '                  <span class="icon fa-star-o"></span>' . $avalue[1] . '<span title="Deleta favorito" onclick="requestAjax(\'menu-' . $sMenuId . '\',\'FavMenu\',\'msgdeletaFav\',\'' . utf8_encode($avalue[2]) . ',' . utf8_encode($avalue[3]) . ',\');" class="icon wb-trash pull-right fav-red"></span></a> '
                        . '              </li>';
            }
        }

        return $sString;
    }

    /**
     * Recarrega favoritos
     */
    public function reloadFav() {
        echo "$('#favGeral-1').empty();";

        $sString = $this->getFavMenu(true);

        echo "$('#favGeral-1').append('" . $sString . "');";

        //"$('#tabmenucont').append('".$sMsg."');";
    }

    public function afterInsert() {
        parent::afterInsert();
        $this->reloadFav();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $this->reloadFav();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterDelete() {
        parent::afterDelete();

        $this->reloadFav();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function msgInsFav($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->Persistencia->limpaFiltro();
        $this->Persistencia->adicionaFiltro('favclasse', $aDados[1]);
        $this->Persistencia->adicionaFiltro('favmetodo', $aDados[2]);
        $this->Persistencia->adicionaFiltro('usucodigo', $_SESSION["codUser"]);
        $iCount = $this->Persistencia->getCount();
        $this->Persistencia->limpaFiltro();
        if ($iCount > 0) {
            $oMensagem = new Modal('Favoritos', 'Item já está em favoritos', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        } else {

            $oMensagem = new Modal('Menu Favorito', 'Deseja incluir esse programa nos seus favoritos?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","InsFav","' . utf8_encode($sDados) . '");');

            echo $oMensagem->getRender();
        }
    }

    public function InsFav($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //verifica se não existe uma 

        $aRetorno = $this->Persistencia->insertFav($aDados);

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Favoritos', 'Item adicionado com sucesso', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            $this->reloadFav();
        }
    }

    public function msgdeletaFav($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Excluir Favorito', 'Deseja excluir esse favorito?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","deletaFav","' . utf8_encode($sDados) . '");');
        echo $oMensagem->getRender();
    }

    public function deletaFav($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $this->Persistencia->adicionaFiltro('favclasse', $aDados[0]);
        $this->Persistencia->adicionaFiltro('favmetodo', $aDados[1]);
        $this->Persistencia->adicionaFiltro('usucodigo', $_SESSION['codUser']);
        $aRetorno = $this->Persistencia->excluir();
        if ($aRetorno[0]) {
            $this->reloadFav();
        }
    }

}
