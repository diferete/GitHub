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

    public function afterUpdate() {
        parent::afterUpdate();

        $oModel = $this->Model;


        $aRetorno = $this->Persistencia->updateSit($oModel);
        if ($aRetorno) {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }
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

    public function beforeInsert() {
        parent::beforeInsert();

        $oModel = $this->Model;

        if ($oModel->getMotivo() == '3') {
            $oModel->setSituaca('Entrada');
            $oModel->setHoraentrou($oModel->getHorachegou());
            $oModel->setDataentrou($oModel->getDatachegou());
        }
        if ($oModel->getMotivo() == '4') {

            $oModel->setSituaca('Saída');
            $oModel->setHorasaiu($oModel->getHorachegou());
            $oModel->setDatasaiu($oModel->getDatachegou());
        }
        if ($oModel->getMotivo() != '3' && $oModel->getMotivo() != '4') {
            $oModel->setSituaca('Chegada');
        }
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function criaTelaModalApontamentoColaboradores($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();



        $this->View->setAParametrosExtras($oDados);

        if ($oDados->getSituaca() == 'Saída' && $oDados->getMotivo() == '4') {
            $this->View->criaModalApontaEntradaColaboradores();


            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        }
        if ($oDados->getSituaca() == 'Chegada' && ($oDados->getMotivo() != '4' && $oDados->getMotivo() != '3')) {
            $this->View->criaModalApontaEntradaColaboradores();


            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        }
        if ($oDados->getSituaca() == 'Entrada' && ($oDados->getMotivo() != '4' && $oDados->getMotivo() != '3')) {
            $this->View->criaModalApontaSaidaColaboradores();


            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        }

        if (($oDados->getSituaca() == 'Entrada' && $oDados->getMotivo() == '3') || ($oDados->getSituaca() == 'Entrada' && $oDados->getMotivo() == '4') || ($oDados->getSituaca() == 'Saída' && ($oDados->getMotivo() != '3' && $oDados->getMotivo() != '4'))) {
            $oMsg = new Modal('Atenção', 'Essa pessoa já teve seu apontamento efetuado!', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontamentoColaboradores-btn').click();";
            echo $oMsg->getRender();
        }
    }

    public function apontaEntradaColaboradores() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaEntrada($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Entrada de pessoa apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamentoColaboradores-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

    public function apontaSaidaColaboradores() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaSaida($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Saída de pessoa apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamentoColaboradores-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

    public function gravaHora($sDados) {
        $aDados = explode(',', $sDados);
        $this->carregaModelString($aDados[3]);
        $aRetorno = $this->Persistencia->alteraHora($aDados[2], $this->Model->getNr());
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso!', 'Hora alterada com sucesso.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção!', 'Hora não pode ser alterada.' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
    }

    public function relColaboradores($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relColaboradores');
    }

    public function excluirRegistro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oMensagem = new Modal('Excluir', 'Deseja EXCLUIR o registro nrº' . $aCamposChave['nr'] . '?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_PORT_Colaboradores","excluiRegistro","' . $sDados . '");');

        echo $oMensagem->getRender();
        exit;
    }

    public function excluiRegistro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->excluirRegistro($aCamposChave);
        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Registro excluido com sucesso', Mensagem::TIPO_SUCESSO);
        } else {
            $oMsg = new Mensagem('Atenção', 'Registro não pode ser excluido', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
        exit;
    }

}
