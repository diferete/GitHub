<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_PORT_Visitantes extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PORT_Visitantes');
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
        $this->Model->setHorachegou($aHora[0]);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $oModel = $this->Model;
        if ($oModel->getMotivo() == 'Selecionar') {
            $oMsg = new Mensagem('Atenção', 'Selecione um MOTIVO!', Mensagem::TIPO_INFO);
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
			
			$this->Model->setDescmotivo(trim($this->Model->getDescmotivo()));
			
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function afterInsert() {
        parent::afterInsert();

        $oModel = $this->Model;


        $this->Persistencia->cadPlaca($oModel);
        $this->Persistencia->cadCPF($oModel);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function criaTelaModalApontamentoVisitante($sDados) {
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
                $this->View->criaModalApontaEntradaVisitante();
            }
            if ($oDados->getSituaca() == 'Entrada') {
                $this->View->criaModalApontaSaidaVisitante();
            }

            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Essa pessoa já teve seu apontamento efetuado!', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontamentoVisitante-btn').click();";
            echo $oMsg->getRender();
        }
    }

    public function apontaEntradaVisitante() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaEntrada($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Entrada de pessoa apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamentoVisitante-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

    public function apontaSaidaVisitante() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaSaida($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Saída de pessoa apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamentoVisitante-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
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

        echo"$('#" . $aDados[0] . "').val('" . $oConsulta->empfant . "');"
        . "$('#" . $aDados[1] . "').val('" . $oConsulta->fone . "');";
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

    public function relVisitantes($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relVisitantes');
    }

    public function excluirRegistro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oMensagem = new Modal('Excluir', 'Deseja EXCLUIR o registro nrº' . $aCamposChave['nr'] . '?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_PORT_Visitantes","excluiRegistro","' . $sDados . '");');
        
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
