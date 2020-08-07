<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_PORT_Pessoas extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PORT_Pessoas');
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $sMotivo = $this->Model->getMotivo();
        $sTipoPessoa = $this->Model->getTipopessoa();


        if ($sMotivo == 'Selecionar') {
            $oMsg = new Mensagem('Atenção', 'Favor selecionar o Motivo!', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        } if ($sTipoPessoa == 'Selecionar') {
            $oMsg = new Mensagem('Atenção', 'Favor selecionar o Tipo de pessoa!', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }if ($sTipoPessoa != 'Selecionar' && $sMotivo != 'Selecionar') {
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

        if ($oSit == 'Saída') {
            $oMensagem = new Modal('Atenção!', 'O trânsito Nº' . $this->Model->getNr() . ' não pode ser modificadao somente visualizado!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
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

    public function criaTelaModalApontamento($sDados) {
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
                $this->View->criaModalApontaEntrada();
            }
            if ($oDados->getSituaca() == 'Entrada') {
                $this->View->criaModalApontaSaida();
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

    public function consultaCracha($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aConsulta = $this->Persistencia->consultaCracha($aCamposChave);
        $sCodSetor = $aConsulta[1];

        if ($aDados[5] == 'acaoIncluir') {
            switch ($sCodSetor) {
                case '55':

                    echo"$('#" . $aDados[0] . "').val('');"
                    . "$('#" . $aDados[1] . "').val('" . $aConsulta[1] . "');"
                    . "$('#" . $aDados[2] . "').val('" . $aConsulta[2] . "');"
                    . "$('#" . $aDados[3] . "').val('');"
                    . "$('#" . $aDados[4] . "').val('');";
                    break;
                case '56':

                    echo"$('#" . $aDados[0] . "').val('');"
                    . "$('#" . $aDados[1] . "').val('" . $aConsulta[1] . "');"
                    . "$('#" . $aDados[2] . "').val('" . $aConsulta[2] . "');"
                    . "$('#" . $aDados[3] . "').val('');"
                    . "$('#" . $aDados[4] . "').val('');";
                    break;

                default:

                    echo"$('#" . $aDados[0] . "').val('" . $aConsulta[0] . "');"
                    . "$('#" . $aDados[1] . "').val('" . $aConsulta[1] . "');"
                    . "$('#" . $aDados[2] . "').val('" . $aConsulta[2] . "');"
                    . "$('#" . $aDados[3] . "').val('75483040000211');"
                    . "$('#" . $aDados[4] . "').val('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');";
                    break;
            }
        }
        if ($aDados[5] == 'acaoAlterar') {
            switch ($sCodSetor) {
                case '55':

                    echo"$('#" . $aDados[1] . "').val('" . $aConsulta[1] . "');"
                    . "$('#" . $aDados[2] . "').val('" . $aConsulta[2] . "');";
                    break;
                case '56':

                    echo"$('#" . $aDados[1] . "').val('" . $aConsulta[1] . "');"
                    . "$('#" . $aDados[2] . "').val('" . $aConsulta[2] . "');";
                    break;

                default:

                    echo"$('#" . $aDados[0] . "').val('" . $aConsulta[0] . "');"
                    . "$('#" . $aDados[1] . "').val('" . $aConsulta[1] . "');"
                    . "$('#" . $aDados[2] . "').val('" . $aConsulta[2] . "');"
                    . "$('#" . $aDados[3] . "').val('75483040000211');"
                    . "$('#" . $aDados[4] . "').val('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');";
                    break;
            }
        }
    }

}
