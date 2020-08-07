<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualDiagramaCausa extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualDiagramaCausa');
    }

    public function insereDiagrama($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->carregaModel();

        $oFuncExcluir = $this->Persistencia->excluir(true);

        $oFuncInserir = $this->Persistencia->inserir();

        if ($oFuncExcluir[0] == false || $oFuncInserir[0] == false) {
            $oMensagem = new Mensagem('Erro', 'Erro ao tentar inserir um Diagrama da Causa', Mensagem::TIPO_ERROR);
        } else {
            $oMensagem = new Mensagem('Sucesso', 'Diagrama da causa atualizado com sucesso!', Mensagem::TIPO_SUCESSO);
        }

        echo $oMensagem->getRender();
    }

}
