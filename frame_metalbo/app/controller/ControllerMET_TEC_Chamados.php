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

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $this->Persistencia->updateTempoRestante();
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();
        if ($_SESSION['codsetor'] == 2) {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }

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

    public function beforeInsert() {
        parent::beforeInsert();

        $str = str_replace(array("\r", "\n"), " ", $this->Model->getProblema());
        $this->Model->setProblema($str);

        if ($this->Model->getFilcgc() == '83781641000158') {
            $this->Model->setRepoffice('POLIAMIDOS');
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $str = str_replace(array("\r", "\n"), " ", $this->Model->getProblema());
        $this->Model->setProblema($str);

        if ($this->Model->getFilcgc() == '83781641000158') {
            $this->Model->setRepoffice('POLIAMIDOS');
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterCommitInsert() {
        parent::afterCommitInsert();
        $aCampos = $this->getArrayCampostela();

        $oDados = $this->Persistencia->buscaDadosChamado($aCampos);

        if ($oDados->repoffice != null) {
            $sAssunto = $oDados->repoffice;
        } else {
            $sAssunto = $oDados->filcgc;
        }
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
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('CHAMADO NR ' . $oDados->nr . ''));

        $oEmail->setAssunto(utf8_decode('CHAMADO Nº' . $oDados->nr . ' - ' . $sAssunto));
        $oEmail->setMensagem(utf8_decode('Novo chamado:<br/>'
                        . '<b>Usuário:</b> ' . $aCampos['usunome'] . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Tipo:</b></td><td>' . $sTipo . '</td></tr>'
                        . '<tr><td><b>Subtipo:</b></td><td>' . $aCampos['subtipo_nome'] . '</td></tr>'
                        . '<tr><td><b>Problema:</b></td><td>' . $aCampos['problema'] . '</td></tr>'
                        . '</table><br/><br/>'
                        . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $oEmail->addDestinatario('alexandre@metalbo.com.br');
        $oEmail->addDestinatarioCopia('cleverton@metalbo.com.br');
        $oEmail->addDestinatarioCopia('jose@metalbo.com.br');
        if ($aCampos['anexo1'] != '') {
            $oEmail->addAnexo('Uploads/' . $aCampos['anexo1'] . '', utf8_decode($aCampos['anexo1']));
        }
        if ($aCampos['anexo2'] != '') {
            $oEmail->addAnexo('Uploads/' . $aCampos['anexo2'] . '', utf8_decode($aCampos['anexo2']));
        }
        if ($aCampos['anexo3'] != '') {
            $oEmail->addAnexo('Uploads/' . $aCampos['anexo3'] . '', utf8_decode($aCampos['anexo3']));
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

            $oMensagem2 = new Mensagem('Sucesso', 'SEU REGISTRO FOI INSERIDO!', Mensagem::TIPO_SUCESSO, 20000);
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email, saia e tente utilize o botão: E-MAIL -> REENVIAR E-MAIL', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            echo $oMensagem2->getRender();

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

        $oProblema = $this->Persistencia->buscaProblema($aProblema);

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

        if ($aCampos['previsao'] == '' || $aCampos['previsao'] == null) {
            $oMensagem = new Mensagem('Atenção', 'Informe uma previsão de atendimento!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } else {
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
    }

    public function apontaChamadoFinaliza() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['obsfim'] == '') {
            $oMensagem = new Mensagem('Atenção', 'Preencha o campo OBSERVAÇÃO!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } if ($aCampos['tempo'] == '') {
            $oMensagem = new Mensagem('Atenção', 'Preencha o campo TEMPO!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } else {
            $aRetorno = $this->Persistencia->finalizaChamado($aCampos);
            if ($aRetorno[0]) {
                $bRetorno = $this->EnviaEmailFinalizaChamado($aCampos);
                if ($bRetorno) {
                    $oMsg = new Modal('Tudo certo', 'Chamado foi finalizado com sucesso', Modal::TIPO_SUCESSO, false, true, false);
                    echo "$('#criaModalApontaChamado-btn').click();";
                    echo $oMsg->getRender();
                } else {
                    $oMsg = new Modal('Atenção', 'Erro ao tentar enviar e-mail de finalização do chamado', Modal::TIPO_AVISO, false, true, false);
                    echo "$('#criaModalApontaChamado-btn').click();";
                    echo $oMsg->getRender();
                }
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

        if (($oDados->getSituaca() == 'AGUARDANDO') || ($_SESSION['codsetor'] == 2 && $oDados->getSituaca() != 'FINALIZADO')) {

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
        if ($aCampos['obsfim'] != '' || $aCampos['obsfim'] != null) {
            $aRetorno = $this->Persistencia->cancelaChamado($aCampos);
            if ($aRetorno[0]) {
                $oMsg = new Modal('Tudo certo', 'Chamado foi cancelado com sucesso', Modal::TIPO_SUCESSO, false, true, false);
                $this->EnviaEmailFinalizaChamado($aDados);
                echo "$('#" . $aDados[1] . "-btn').click();";
                echo $oMsg->getRender();
            } else {
                $oMsg = new Modal('Atenção', 'Erro ao tentar cancelar o chamado', Modal::TIPO_AVISO, false, true, false);
                echo "$('#" . $aDados[1] . "-btn').click();";
                echo $oMsg->getRender();
            }
        } else {
            exit;
        }
    }

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

    public function EnviaEmailFinalizaChamado($aDados) {
        $oDados = $this->Persistencia->buscaDadosEmailChamado($aDados);

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('CHAMADO NR ' . $oDados->nr . ''));

        if ($oDados->repoffice != null) {
            $sAssunto = $oDados->repoffice;
        } else {
            $sAssunto = $oDados->filcgc;
        }

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

        $oEmail->setAssunto(utf8_decode('CHAMADO Nº' . $oDados->nr . ' - ' . $sAssunto));
        $oEmail->setMensagem(utf8_decode('<b style="color:#0f5539; font-weight:900;font-size:18px;">SEU CHAMADO FOI ' . $oDados->situaca . '<br/>'
                        . '<b>Usuário:</b> ' . $oDados->usunome . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Tipo:</b></td><td>' . $sTipo . '</td></tr>'
                        . '<tr><td><b>Subtipo:</b></td><td>' . $oDados->subtipo_nome . '</td></tr>'
                        . '<tr><td><b>Problema:</b></td><td>' . $oDados->problema . '</td></tr>'
                        . '<tr><td><b>O que foi feito:</b></td><td>' . $oDados->obsfim . '</td></tr>'
                        . '</table><br/><br/>'
                        . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $oEmail->addDestinatario($oDados->email);
        $oEmail->addDestinatarioCopia('alexandre@metalbo.com.br');
        $oEmail->addDestinatarioCopia('cleverton@metalbo.com.br');

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'O usuário foi notificado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $bRetorno = true;
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            $bRetorno = false;
        }
        sleep(3);
        return $bRetorno;
    }

    public function reenviaEmailFinaliza($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oDados = $this->Persistencia->buscaDadosEmailChamado($aCamposChave);

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('CHAMADO NR ' . $oDados->nr . ''));

        if ($oDados->situaca != 'FINALIZADO') {
            $oMensagem = new Modal('E-mail', 'O chamado ainda não foi FINALIZADO!', Modal::TIPO_AVISO);
            echo $oMensagem->getRender();
        } else {
            if ($oDados->repoffice != null) {
                $sAssunto = $oDados->repoffice;
            } else {
                $sAssunto = $oDados->filcgc;
            }

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

            $oEmail->setAssunto(utf8_decode('CHAMADO Nº' . $oDados->nr . ' - ' . $sAssunto));
            $oEmail->setMensagem(utf8_decode('<b style="color:#0f5539; font-weight:900;font-size:18px;">SEU CHAMADO FOI FINALIZADO<br/>'
                            . '<b>Usuário:</b> ' . $oDados->usunome . '<br/><br/><br/>'
                            . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                            . '<tr><td><b>Tipo:</b></td><td>' . $sTipo . '</td></tr>'
                            . '<tr><td><b>Subtipo:</b></td><td>' . $oDados->subtipo_nome . '</td></tr>'
                            . '<tr><td><b>Problema:</b></td><td>' . $oDados->problema . '</td></tr>'
                            . '<tr><td><b>O que foi feito:</b></td><td>' . $oDados->obsfim . '</td></tr>'
                            . '</table><br/><br/>'
                            . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));
            $oEmail->limpaDestinatariosAll();



            // Para
            $oEmail->addDestinatario($oDados->email);
            $oEmail->addDestinatarioCopia('alexandre@metalbo.com.br');
            $oEmail->addDestinatarioCopia('cleverton@metalbo.com.br');

            $aRetorno = $oEmail->sendEmail();
            if ($aRetorno[0]) {
                $oMensagem = new Modal('Tudo certo', 'O setor de TI foi notificado com sucesso!', Modal::TIPO_SUCESSO, false, true, false);
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

    public function reenviaEmailTi($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oDados = $this->Persistencia->buscaDadosEmailChamado($aCamposChave);

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('CHAMADO NR ' . $oDados->nr . ''));

        if ($oDados->situaca != 'AGUARDANDO') {
            $oMensagem = new Modal('E-mail', 'O chamado já foi ' . $oDados->situaca . '!', Modal::TIPO_AVISO);
            echo $oMensagem->getRender();
        } else {
            if ($oDados->repoffice != null) {
                $sAssunto = $oDados->repoffice;
            } else {
                $sAssunto = $oDados->filcgc;
            }

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

            $oEmail->setAssunto(utf8_decode('CHAMADO Nº' . $oDados->nr . ' - ' . $sAssunto));
            $oEmail->setMensagem(utf8_decode('Novo chamado:<br/>'
                            . '<b>Usuário:</b> ' . $oDados->usunome . '<br/><br/><br/>'
                            . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                            . '<tr><td><b>Tipo:</b></td><td>' . $sTipo . '</td></tr>'
                            . '<tr><td><b>Subtipo:</b></td><td>' . $oDados->subtipo_nome . '</td></tr>'
                            . '<tr><td><b>Problema:</b></td><td>' . $oDados->problema . '</td></tr>'
                            . '<tr><td><b>O que foi feito:</b></td><td>' . $oDados->obsfim . '</td></tr>'
                            . '</table><br/><br/>'
                            . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));
            $oEmail->limpaDestinatariosAll();

            $oEmail->addDestinatario('alexandre@metalbo.com.br');
            $oEmail->addDestinatarioCopia('cleverton@metalbo.com.br');
            $oEmail->addDestinatarioCopia('jose@metalbo.com.br');
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
                $oMensagem = new Modal('Tudo certo', 'O setor de TI foi notificado com sucesso!', Modal::TIPO_SUCESSO, false, true, false);
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

    public function mostraTelaRelChamados($renderTo, $sMetodo = '') {
        $this->buscaDados();
        parent::mostraTelaRelatorio($renderTo, 'relChamados');
    }

    public function buscaDados() {
        $aParame[0] = $this->Persistencia->buscaDadosRep();
        $aParame[1] = $this->Persistencia->buscaDadosSubTipo();
        $aParame[2] = $this->Persistencia->buscaDadosEmp();
        $aParame[3] = $this->Persistencia->buscaDadosUsuario();
        $aParame[4] = $this->Persistencia->buscaDadosSetores();

        $this->View->setAParametrosExtras($aParame);
    }

}
