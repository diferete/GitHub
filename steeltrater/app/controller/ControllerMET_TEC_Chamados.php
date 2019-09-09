<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_Chamados extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Chamados');
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituaca() != 'AGUARDANDO') {
            $oMensagem = new Modal('Atenção!', 'O cadastro Nº' . $this->Model->getNr() . ' não pode ser modificadao somente visualizado!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
            //exit();
        } else {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function afterInsert() {
        parent::afterInsert();
        $aCampos = $this->retornaArrayCamposTela();

        $aChave['nr'] = $aCampos['nr'];
        $aChave['filcgc'] = $aCampos['filcgc'];

        $oDados = $this->Persistencia->buscaDadosChamado($aChave);
        switch ($oDados->tipo) {
            case 1:
                $sTipo = 'HARDWARE';
                break;
            case 2:
                $sTipo = 'SOFTWARE';
                break;
            case 3:
                $sTipo = 'SERVIÇOS';
                break;
        }

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('CHAMADO NR ' . $oDados->nr . ''));

        $oEmail->setAssunto(utf8_decode('NOVO CHAMADO Nº' . $oDados->nr . ' EMPRESA ' . $oDados->filcgc));
        $oEmail->setMensagem(utf8_decode('Novo chamado:<br/>'
                        . '<b>Usuário:</b> ' . $oDados->usunome . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Tipo:</b></td><td>' . $sTipo . '</td></tr>'
                        . '<tr><td><b>Subtipo:</b></td><td>' . $oDados->subtipo_nome . '</td></tr>'
                        . '<tr><td><b>Problema:</b></td><td>' . $oDados->problema . '</td></tr>'
                        . '</table><br/><br/>'
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar o chamado!</a>'
                        . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $oEmail->addDestinatario('alexandre@metalbo.com.br');
        //$oEmail->addDestinatarioCopia('cleverton@metalbo.com.br');
        if ($oDados->anexo1 != '') {
            $oEmail->addAnexo('Uploads/' . $oDados->anexo1 . '', utf8_decode($oDados->anexo1));
        }
        if ($oDados->anexo2 != '') {
            $oEmail->addAnexo('Uploads/' . $oDados->anexo2 . '', utf8_decode($oDados->anexo2));
        }
        if ($oDados->anexo3 != '') {
            $oEmail->addAnexo('Uploads/' . $oDados->anexo3 . '', utf8_decode($oDados->anexo3));
        }

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'O setor de TI foi notificado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();

            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function carregaProb($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aProblema = array();
        parse_str($sChave, $aProblema);

        $oProblema = $this->Persistencia->buscaDadosChamado($aProblema);

        $sProblema = Util::limpaString($oProblema->problema);
        $sObsFim = Util::limpaString($oProblema->obsfim);

        $sScript = '$("#' . $aDados[2] . '").val("' . $sProblema . '");'
                . '$("#' . $aDados[3] . '").val("' . $sObsFim . '");';
        echo $sScript;
    }

    public function criaTelaModalApontaChamado($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();

        if ($oDados->getSituaca() == 'AGUARDANDO' || $oDados->getSituaca() == 'INICIADO') {

            $this->View->setAParametrosExtras($oDados);

            if ($oDados->getSituaca() == 'AGUARDANDO') {
                $this->View->criaModalIniciaChamado();
            }
            if ($oDados->getSituaca() == 'INICIADO') {
                $this->View->criaModalFinalizaChamado();
            }

            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Chamado já foi ' . $oDados->getSituaca(), Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontaChamado-btn').click();";
            echo $oMsg->getRender();
            exit;
        }
    }

    public function apontaChamadoInicia() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRetorno = $this->Persistencia->iniciaChamado($aCampos);
        if ($aRetorno[0]) {
            $oMsg = new Modal('Tudo certo', 'Chamado foi iniciado com sucesso', Modal::TIPO_SUCESSO, false, true, false);
            echo "$('#criaModalApontaChamado-btn').click();";
            echo $oMsg->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Erro ao tentar iniciar o chamado', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontaChamado-btn').click();";
            echo $oMsg->getRender();
        }
    }

    public function apontaChamadoFinaliza() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['obsfim'] == '') {
            $oMensagem = new Mensagem('Atenção', 'Preencha o campo OBSERVAÇÃO!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } else {
            $aRetorno = $this->Persistencia->finalizaChamado($aCampos);
            if ($aRetorno[0]) {
                $oMsg = new Modal('Tudo certo', 'Chamado foi finalizado com sucesso', Modal::TIPO_SUCESSO, false, true, false);
                echo "$('#criaModalApontaChamado-btn').click();";
                echo $oMsg->getRender();
            } else {
                $oMsg = new Modal('Atenção', 'Erro ao tentar finalizar o chamado', Modal::TIPO_AVISO, false, true, false);
                echo "$('#criaModalApontaChamado-btn').click();";
                echo $oMsg->getRender();
            }
        }
    }

    public function criaTelaModalCancelaChamado($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();

        if ($oDados->getSituaca() == 'AGUARDANDO' || $_SESSION['codsetor'] == 2) {

            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalCancelaChamado($aDados[1]);

            //adiciona onde será renderizado
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMensagem = new Modal('Atenção', 'Não pode ser cancelada', Modal::TIPO_ERRO, false, true, true);
            echo '$("#' . $aDados[1] . '-btn").click();';
            echo $oMensagem->getRender();
        }
    }

    public function apontaChamadoCancela($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRetorno = $this->Persistencia->cancelaChamado($aCampos);
        if ($aRetorno[0]) {
            $oMsg = new Modal('Tudo certo', 'Chamado foi cancelado com sucesso', Modal::TIPO_SUCESSO, false, true, false);
            echo "$('#" . $aDados[1] . "-btn').click();";
            echo $oMsg->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Erro ao tentar cancelar o chamado', Modal::TIPO_AVISO, false, true, false);
            echo "$('#" . $aDados[1] . "-btn').click();";
            echo $oMsg->getRender();
        }
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     * */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);


        $aTotal = $this->Persistencia->somaSit();

        $sResulta = '<div style="color:black !important">Aguardando: ' . $aTotal['AGUARDANDO'] . ''
                . '<span style="color:blue !important">&nbsp;&nbsp;&nbsp;  Iniciados: ' . $aTotal['INICIADO'] . '</span>'
                . '<span style="color:green !important">&nbsp;&nbsp;&nbsp;  Finalizados: ' . $aTotal['FINALIZADO'] . '</span>'
                . '<span style="color:red !important">&nbsp;&nbsp;&nbsp;  Cancelados: ' . $aTotal['CANCELADO'] . '</span>'
                . '</div>';

        return $sResulta;
    }

}
