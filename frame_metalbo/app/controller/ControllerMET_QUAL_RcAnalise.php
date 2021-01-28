<?php

/*
 * Implementa controller da classe MET_QUAL_Rc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerMET_QUAL_RcAnalise extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_RcAnalise');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $aDados = $this->Persistencia->buscaRespEscritório($sDados);
        $this->View->setAParametrosExtras($aDados);
    }

    public function buscaNf($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaNf($aCamposChave['nf']);

        echo"$('#" . $aParam[0] . "').val('" . $oRow->data . "');"
        . "$('#" . $aParam[1] . "').val('" . number_format($oRow->nfsvlrtot, 2, ',', '.') . "');"
        . "$('#" . $aParam[2] . "').val('" . number_format($oRow->nfspesolq, 2, ',', '.') . "');";
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));
        /* $date = new DateTime( '2014-08-19' );
          echo $date-> format( 'd-m-Y' ); */

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));

        //Quantnconf
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);

        $this->Model->setValor(number_format($this->Model->getValor(), 2, ',', '.'));
        $this->Model->setPeso(number_format($this->Model->getPeso(), 2, ',', '.'));
        $this->Model->setQuant(number_format($this->Model->getQuant(), 2, ',', '.'));
        $this->Model->setQuantnconf(number_format($this->Model->getQuantnconf(), 2, ',', '.'));
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);

        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";

        echo $sRetorno;
    }

    /**
     * Método para chamar tela modal para apontar RC
     * @param string $sDados chaves primarias e IDs relacionados a modal
     */
    public function criaTelaModalAponta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];


        $aRet = $this->Persistencia->verifSit($aCamposChave);
        if ($aRet[3] == 'Cancelada') {
            $oMens = new Mensagem('Atenção!', 'A reclamação foi cancelada!', Mensagem::TIPO_WARNING);
            echo $oMens->getRender();
            echo'$("#' . $aDados[1] . '-btn").click();';
        } elseif ($aRet[0] == true && $aRet[2] == 'Em análise' && $aRet[1] != 'Apontada') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalAponta($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMens = new Modal('Atenção!', 'A reclamação não está em situação de ser apontada!', Modal::TIPO_AVISO, false, true, false);
            echo $oMens->getRender();
            echo'$("#' . $aDados[1] . '-btn").click();';
        }
    }

    /**
     * Aponta RC 
     * @param string $sDados chaves primarias e IDs relacionados a modal
     */
    public function apontaRC($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['procedencia'] == '' || $aCampos['procedencia'] == null) {
            $oMsg = new Mensagem('Atenção', 'Selecione o status da DEVOLUÇÃO segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
            exit();
        } else {
            $aRet = $this->Persistencia->apontaRC($aCampos);
            if ($aRet[0] == true) {
                $oMsg = new Mensagem('Sucesso', 'Reclamação nº' . $aCampos['nr'] . ' foi apontada com sucesso!', Mensagem::TIPO_SUCESSO);
                $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o setor de vendas!', Mensagem::TIPO_INFO);
                echo $oMsg->getRender();
                echo $oMsg2->getRender();
                echo'requestAjax("","' . $this->getNomeClasse() . '","enviaEmailAponta","' . $sDados . '");';
            } else {
                $oMsg = new Mensagem('Atenção', 'Reclamação nº' . $aCampos['nr'] . ' não pode ser apontada!', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }
            echo'$("#' . $aDados[2] . '-btn").click();';
        }
    }

    public function reenviaEmailRC($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aSituaca = $this->Persistencia->verifSit($aCamposChave);

        if ($aSituaca[1] == 'Cancelada') {
            $oMensagem = new Mensagem('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' não pode ser encaminhada!', Mensagem::TIPO_WARNING);
        } elseif ($aSituaca[1] != 'Apontada' || $aSituaca[2] != 'Em análise') {
            $oMensagem = new Mensagem('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' não pode ser encaminhada!', Mensagem::TIPO_WARNING);
        } else {
            $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' ja teve seu e-mail encaminhado para o seu setor responsável, deseja reenviar o e-mail?', Modal::TIPO_INFO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $this->getNomeClasse() . '","enviaEmailAponta","' . $sDados . ',reenvia");');
        }
        echo $oMensagem->getRender();
    }

    public function enviaEmailAponta($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[3] == 'reenvia') {
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
        } else {
            $sChave = htmlspecialchars_decode($aDados[3]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
        }

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');
        $hora = date('H:m');

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        if ($_SESSION['codsetor'] == 3) {
            $sSetor = 'Expedição';
        }
        if ($_SESSION['codsetor'] == 5) {
            $sSetor = 'Embalagem';
        }
        if ($_SESSION['codsetor'] == 25) {
            $sSetor = 'Qualidade';
        }

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->devolucao . ''));
        $oEmail->setMensagem(utf8_decode('A devolução de Nº ' . $oRow->nr . ' foi apontada pelo setor da<strong><span style="color:red"> ' . $sSetor . ' </span></strong>.<hr><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal: </b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . Util::converteData($oRow->datanf) . ' </td></tr>'
                        . '<tr><td><b>Od. de compra: </b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº: </b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($oRow->valor, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . number_format($oRow->peso, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '<tr><td><b>Análise pelo setor da ' . $sSetor . ': </b></td><td> ' . $oRow->apontamento . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmail = $this->Persistencia->buscaEmails($aCamposChave);
        $oEmail->addDestinatario($aEmail[0]);
        $oEmail->addDestinatarioCopia($aEmail[1]);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para notificar vendas sobre o apontamento!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente reenviar ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * Método para chamar tela modal para apontar inspeções da RC após finalizado pelo representante
     * @param string $sDados chaves primarias e IDs relacionados a modal
     */
    public function criaTelaModalApontaInspecao($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];


        $oRet = $this->Persistencia->buscaDadosRC($aCamposChave);

        if ($oRet->devolucao != 'Aguardando') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalApontaInspecao($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMens = new Modal('Atenção!', 'Já possuiu inspeção ou não está em situação de ser apontada!', Modal::TIPO_AVISO, false, true, false);
            echo $oMens->getRender();
            echo'$("#' . $aDados[1] . '-btn").click();';
        }
    }

    /**
     * Aponta inspeção da RC após finalizado pelo representante
     * @param string $sDados chaves primarias e IDs relacionados a modal
     */
    public function apontaInspecaoRC($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['check'] == true) {
            $aRetorno = $this->notificaVendas($aCampos);
            if ($aRetorno[0] == true) {
                $aRet = $this->Persistencia->apontaInspecaoRC($aCampos);
                if ($aRet[0] == true) {
                    $oMsg = new Mensagem('Sucesso', 'Inspeção da reclamação nº' . $aCampos['nr'] . ' foi apontada com sucesso!', Mensagem::TIPO_SUCESSO);
                    echo $oMsg->getRender();
                    echo'$("#' . $aDados[2] . '-btn").click();';
                } else {
                    $oMsg = new Mensagem('Atenção', 'Inspeção da reclamação nº' . $aCampos['nr'] . ' não pode ser apontada!', Mensagem::TIPO_ERROR);
                    echo $oMsg->getRender();
                }
            } else {
                return;
            }
        } else {
            $aRet = $this->Persistencia->apontaInspecaoRC($aCampos);
            if ($aRet[0] == true) {
                $oMsg = new Mensagem('Sucesso', 'Inspeção da reclamação nº' . $aCampos['nr'] . ' foi apontada com sucesso!', Mensagem::TIPO_SUCESSO);
                echo'$("#' . $aDados[2] . '-btn").click();';
            } else {
                $oMsg = new Mensagem('Atenção', 'Inspeção da reclamação nº' . $aCampos['nr'] . ' não pode ser apontada!', Mensagem::TIPO_ERROR);
            }
            echo $oMsg->getRender();
        }
    }

    public function notificaVendas($aCampos) {
        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));


        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE'));
        $oEmail->setMensagem(utf8_decode('<span style="color:green;"><b>A reclamação NR ' . $aCampos['nr'] . '</b></span><br/>'
                        . '<b>Data do Cadastro: ' . $aCampos['data_disposição'] . ' </b><br/>'
                        . '<b>Hora: ' . $aCampos['hora_disposição'] . '  </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Correção: </b></td><td> ' . $aCampos['correcao'] . ' </td></tr>'
                        . '<tr><td><b>Inspeção: </b></td><td> ' . $aCampos['inspecao'] . ' </td></tr>'
                        . '<tr><td><b>Observação: </b></td><td> ' . $aCampos['obs_inspecao'] . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<b>Para mais informações, consulte o anexo!</b><br/>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();
        $aEmail = $this->Persistencia->buscaEmails($aCampos);
        $oEmail->addDestinatario($aEmail[0]);
        //$oEmail->addDestinatario('alexandre@metalbo.com.br');


        if ($aCampos['anexo_inspecao']) {
            $oEmail->addAnexo('Uploads/' . $aCampos['anexo_inspecao'], utf8_decode('' . $aCampos['anexo_inspecao'] . ''));
        }
        if ($aCampos['anexo_inspecao1']) {
            $oEmail->addAnexo('Uploads/' . $aCampos['anexo_inspecao1'], utf8_decode('' . $aCampos['anexo_inspecao1'] . ''));
        }

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o setor de Vendas!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email para Vendas, comunique o TI!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
        return $aRetorno;
    }

    /*
     * Método que mostra na MostraConsulta a análise feita pelo setor responsável caso problema seja interno
     * */

    public function carregaInspecao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aInspecao = array();
        parse_str($sChave, $aInspecao);

        $oInspecao = $this->Persistencia->buscaDadosRC($aInspecao);

        $sInspecao = Util::limpaString($oInspecao->inspecao);
        $sCorrecao = Util::limpaString($oInspecao->correcao);

        $sScriptInspecao = '$("#' . $aDados[2] . '").val("' . $sInspecao . '");';
        $sScriptCorrecao = '$("#' . $aDados[3] . '").val("' . $sCorrecao . '");';

        echo $sScriptInspecao;
        echo $sScriptCorrecao;
    }

    /**
     * Método para chamar tela modal para apontar inspeções da RC após finalizado pelo representante
     * @param string $sDados chaves primarias e IDs relacionados a modal
     */
    public function criaTelaModalRetornaRC($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];


        $oRet = $this->Persistencia->buscaDadosRC($aCamposChave);

        if ($oRet->situaca == 'Cancelada') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação foi Cancelada!', Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            echo '$("#' . $aDados[1] . '-btn").click();';
        } elseif ($oRet->situaca == 'Env.Qual' || $oRet->situaca == 'Env.Emb' || $oRet->situaca == 'Env.Exp') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalRetornaRC($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção', 'Reclamação não está em condições de ser retornada!', Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            echo '$("#' . $aDados[1] . '-btn").click();';
        }
    }

    public function retornarRC($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);


        $aRet = $this->Persistencia->retornaRC($aCampos);

        if ($aRet[0]) {

            date_default_timezone_set('America/Sao_Paulo');
            $data = date('d/m/Y');
            $hora = date('H:m');

            $oEmail = new Email();
            $oEmail->setMailer();
            $oEmail->setEnvioSMTP();
            $oEmail->setServidor(Config::SERVER_SMTP);
            $oEmail->setPorta(Config::PORT_SMTP);
            $oEmail->setAutentica(true);
            $oEmail->setUsuario(Config::EMAIL_SENDER);
            $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
            $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
            $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));

            $oRow = $this->Persistencia->buscaDadosRC($aCampos);


            $oEmail->setAssunto(utf8_decode('RETORNO RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->devolucao . ''));
            $oEmail->setMensagem(utf8_decode('Reclmação de Cliente Nrº ' . $oRow->nr . ' foi RETORNADA pelo setor da<strong><span style="color:red"> "' . $_SESSION['descsetor'] . '" </span></strong>.<hr><br/>'
                            . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                            . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                            . '<b>Hora: ' . $hora . '  </b><br/>'
                            . '<b>Data: ' . $data . ' </b><br/><br/><br/>'
                            . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                            . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                            . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                            . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->obs_analiseret . ' </td></tr>'
                            . '</table><br/><br/>'
                            . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                            . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

            $oEmail->limpaDestinatariosAll();

            // Para
            $aEmail = $this->Persistencia->buscaEmails($aCampos);
            $oEmail->addDestinatario($aEmail[0]);
            $oEmail->addDestinatarioCopia($aEmail[1]);

            $aRetorno = $oEmail->sendEmail();
            if ($aRetorno[0]) {
                $oMensagem = new Mensagem('Sucesso', 'A RC foi retornada para o setor de Vendas!', Mensagem::TIPO_SUCESSO);
                echo'$("#' . $aDados[2] . '-btn").click();';
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Mensagem('Atenção', 'Não foi possível notificar o setor de VENDAS, avise o setor do TI!', Mensagem::TIPO_ERROR);
                echo $oMensagem->getRender();
            }
        } else {
            $oMensagem = new Mensagem('Atenção', 'Não foi possível retortar a RC, avise o setor do TI!', Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
    }

}
