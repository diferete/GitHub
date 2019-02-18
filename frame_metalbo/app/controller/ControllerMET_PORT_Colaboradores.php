<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_PORT_Colaboradores extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PORT_Colaboradores');
    }

    public function afterInsert() {
        parent::afterInsert();

        $oModel = $this->Model;


        $this->Persistencia->cadPlaca($oModel);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function buscaCracha($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aCamposChave['cracha'] == '') {
            return;
        } else {
            $this->consultaCracha($sDados);
        }
    }

    public function consultaCracha($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aConsulta = $this->Persistencia->consultaCracha($aCamposChave);

        echo"$('#" . $aDados[0] . "').val('" . $aConsulta[0] . "');"
        . "$('#" . $aDados[1] . "').val('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');";
    }

    public function criaTelaModalApontamento($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();

        if ($oDados->getSituaca() == 'Chegada' || ($oDados->getSituaca() == 'Entrada' && $oDados->getMotivo() != '3')) {

            $this->View->setAParametrosExtras($oDados);

            if ($oDados->getMotivo() != '3' && ($oDados->getSituaca() == 'Entrada' || $oDados->getSituaca() == 'Chegada')) {
                $this->View->criaModalApontaSaida();
            }if ($oDados->getMotivo() != '4' && $oDados->getSituaca() == 'Chegada') {
                $this->View->criaModalApontaEntrada();
            }

            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Essa pessoa já teve seu apontamento efetuado!', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontamento-btn').click();";
            echo $oMsg->getRender();
        }
    }

    public function apontaEntrada() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaEntrada($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Entrada de pessoa apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamento-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

    public function apontaSaida() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaSaida($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Saída de pessoa apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamento-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

}
