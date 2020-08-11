<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_PORT_Transito extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PORT_Transito');
    }

    public function relTransito($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relTransito');
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $sMotivo = $this->Model->getMotivo();
        $this->Model->setMotorista(strtoupper($this->Model->getMotorista()));
        $this->Model->setHorachegou(date('H:i:s'));
        $this->Model->setDescmotivo(Util::limpaString($this->Model->getDescmotivo()));

        if ($sMotivo != 'Selecionar') {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $oMsg = new Mensagem('Atenção', 'Favor selecionar um motivo!', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();

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

        $this->Persistencia->cadCpf($oModel);

        $hoje = date('d/m/Y');

        if ($oModel->getMotivo() == '1' && $oModel->getDatachegou() == $hoje) {
            $aRetorno = $this->Persistencia->geraCadastro($oModel);
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
        } else {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        $oSit = $this->Model->getSituaca();

        if ($oSit != 'Chegada') {
            $oMensagem = new Modal('Atenção!', 'A movimentação Nº' . $this->Model->getNr() . ' não pode ser modificada, somente visualizada!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $aDados = array();
        parse_str($_REQUEST['campos'], $aDados);
        $sHora = $this->Persistencia->buscaHora($aDados);
        $aHora = explode('.', $sHora);

        $this->Model->setMotorista(strtoupper($this->Model->getMotorista()));
        $this->Model->setHorachegou($aHora[0]);
        $this->Model->setDescmotivo(Util::limpaString($this->Model->getDescmotivo()));

        $oModel = $this->Model;
        if ($oModel->getMotivo() == '1') {
            $aRetorno = $this->Persistencia->updateCadastro($oModel);
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
        } else {

            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $oModel = $this->Model;

        $this->Persistencia->cadPlaca($oModel);

        $this->Persistencia->cadCpf($oModel);


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function gravaHora($sDados) {
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($aDados[3], $aCamposChave);
        $aRetorno = $this->Persistencia->alteraHora($aDados[2], $aCamposChave);
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso!', 'Hora alterada com sucesso.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção!', 'Hora não pode ser alterada.' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
    }

    public function buscaCpf($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aCamposChave['cpf'] == '') {
            return;
        } else {
            $this->consultaCpf($sDados);
        }
    }

    public function consultaCpf($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oConsulta = $this->Persistencia->consultaCpf($aCamposChave);

        echo"$('#" . $aDados[0] . "').val('" . $oConsulta->fone . "');";
    }

    public function buscaPlaca($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaPlaca($aCamposChave['placa']);

        echo"$('#" . $aParam[0] . "').val('" . strtoupper($aCamposChave['placa']) . "');"
        . "$('#" . $aParam[1] . "').val('" . $oRow->empcod . "');"
        . "$('#" . $aParam[2] . "').val('" . $oRow->empdes . "');";
        exit;
    }

    public function criaTelaModalApontamentoTransito($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();

        if ($oDados->getSituaca() == 'Chegada' || $oDados->getSituaca() == 'Entrada') {

            $this->View->setAParametrosExtras($oDados);

            if ($oDados->getSituaca() == 'Chegada') {
                $this->View->criaModalApontaEntradaTransito();
            }
            if ($oDados->getSituaca() == 'Entrada') {
                $this->View->criaModalApontaSaidaTransito();
            }

            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Esse caminhão já teve seu apontamento efetuado!', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontamentoTransito-btn').click();";
            echo $oMsg->getRender();
            exit;
        }
    }

    public function apontaEntradaTransito() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaEntrada($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Entrada de veículo apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamentoTransito-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
        exit;
    }

    public function apontaSaidaTransito() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaSaida($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Saída de veículo apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamentoTransito-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
        exit;
    }

    public function excluirRegistro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sRetorno = $this->Persistencia->buscaSituaca($aCamposChave);
        if ($sRetorno != 'Saida') {
            $oMensagem = new Modal('Excluir', 'Deseja EXCLUIR o registro nrº' . $aCamposChave['nr'] . '?', Modal::TIPO_INFO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_PORT_Transito","excluiRegistro","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Excluir', 'O registro nrº' . $aCamposChave['nr'] . ' não pode ser excluido', Modal::TIPO_AVISO, false, true, false);
        }
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
