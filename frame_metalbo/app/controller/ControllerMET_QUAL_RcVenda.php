<?php

/*
 * Implementa controller da classe MET_QUAL_Rc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerMET_QUAL_RcVenda extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_RcVenda');
    }

    /*
     * Busca dados da NF e coloca o valor nos campos via jquery
     * */

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

    /*
     * Método que mostra na MostraConsulta a análise feita pelo setor responsável caso problema seja interno
     * */

    public function carregaAnalise($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aAnalise = array();
        parse_str($sChave, $aAnalise);

        $oAnalise = $this->Persistencia->buscaDadosRC($aAnalise);

        $sAnalise = Util::limpaString($oAnalise->apontamento);

        if ($sAnalise == '') {
            $sAnalise = Util::limpaString($oAnalise->obs_aponta);
        }

        switch ($oAnalise->tagsetor) {
            case 3:
                $sSetor = 'Expedição';
                break;
            case 5:
                $sSetor = 'Embalagem';
                break;
            case 25:
                $sSetor = 'Qualidade';
                break;
            default:
                $sSetor = 'Vendas';
                break;
        }

        $sProblema = $oAnalise->aplicacao . ' -  ' . Util::limpaString($oAnalise->naoconf);

        $sScriptLabel = '$("label[for=' . $aDados[2] . ']").text("Análise aprensentada pelo setor responsável - ' . $sSetor . ':");';
        $sScriptDados = '$("#' . $aDados[2] . '").val("' . $sAnalise . '");';
        $sProblemas = '$("#' . $aDados[3] . '").val("' . $sProblema . '");';

        echo $sScriptLabel;
        echo $sScriptDados;
        echo $sProblemas;
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);

        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";

        echo $sRetorno;
    }

    /*
     * Método que analisa e direciona para os métodos de envio de e-mails e notificações.
     * */

    public function verificaEmailSetor($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->verifSitRC($aCamposChave);

        if ($aRetorno[0] == 'Liberado' && $aRetorno[1] == 'Aguardando') {
            $this->emailsSetores($sDados, $sParam);
        }
        if (($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Transportadora') || ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Representante') || ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Cliente')) {
            $this->emailRep($sDados, $aRetorno, $sParam);
        } else {
            $this->sitEmails($sDados, $sParam, $aRetorno);
        }
    }

    /*
     * Método que especifíca para qual setor de análise encaminhar os e-mails de notificação.
     * */

    public function emailsSetores($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);


        if ($sParam == 'Env.Qual') {
            $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da QUALIDADE?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
        }
        if ($sParam == 'Env.Emb') {
            $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da EMBALAGEM?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
        }
        if ($sParam == 'Env.Exp') {
            $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da EXPEDIÇÃO?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
        }
        if ($sParam == 'Env.Rep') {
            $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' não está em situação de ser reenviada para o representante!!', Modal::TIPO_AVISO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    /*
     * Método que especifíca qual tipo de notificação o representante recebe caso problema não seja interno interno.
     * */

    public function emailRep($sDados, $aRetorno, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        if ($sParam != 'Env.Rep') {
            $oMensagem = new Modal('Ops!', 'Essa reclamação apenas pode ter seu e-mail reenviado para o representante, tente novamente :)', Modal::TIPO_AVISO, false, true, true);
        } else {

            if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Transportadora') {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' teve sua análise como avaria da Transportadora, deseja reenviar o e-mail para o representante?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","enviaEmailRep","' . $sDados . '");');
            }
            if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Representante') {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' teve sua análise como desacerto do Representante, deseja reenviar o e-mail para o representante?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","enviaEmailRep","' . $sDados . '");');
            }
            if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Cliente') {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' teve sua análise como desacerto do Cliente, deseja reenviar o e-mail para o representante?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","enviaEmailRep","' . $sDados . '");');
            }
        }

        echo $oMensagem->getRender();
    }

    /*
     * Método que especifíca o tipo de notificação que vendas recebe para excessões ou ações indevidas.
     * * */

    public function sitEmails($sDados, $sParam, $aRetorno) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Em análise') {
            $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' já foi apontada por um setor interno da Metalbo!', Modal::TIPO_AVISO, false, true, true);
        }
        if ($aRetorno[0] == 'Aguardando') {
            $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO, false, true, true);
        }
        if ($aRetorno[1] == 'Em análise' && $aRetorno[0] != 'Apontada') {
            $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' ja teve seu e-mail encaminhado para o seu setor responsável, deseja reenviar o e-mail?', Modal::TIPO_INFO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","enviaEmailSetor","' . $sDados . '","' . $sParam . '");');
        }
        if ($aRetorno[0] == 'Finalizada') {
            $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' já foi finalizada pelo representante!', Modal::TIPO_AVISO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    /*
     * Método que monta a Modal de Apontamento do setor de Vendas
     * */

    public function criaTelaModalApontamento($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $oRet = $this->Persistencia->buscaDadosRC($aCamposChave);

        if (($oRet->situaca == 'Liberado' && $oRet->reclamacao == 'Aguardando') || ($oRet->situaca == 'Apontada' && $oRet->reclamacao == 'Em análise')) {

            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalApontamento($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            if ($oRet->devolucao == 'Aceita' && $oRet->situaca != 'Finalizada' && (($oRet->nfdevolucao == null && $oRet->nfsipi == null && $oRet->valorfrete == null) || ($oRet->nfdevolucao == '0' && $oRet->nfsipi == '.0000' && $oRet->valorfrete == '.0000'))) {

                $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
                $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

                $oDados = $this->Persistencia->consultarWhere();
                $this->View->setAParametrosExtras($oDados);

                $this->View->criaModalApontamentoNF($sDados);

                //adiciona onde será renderizado
                $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
                echo $sLimpa;
                $this->View->getTela()->setSRender($aDados[1] . '-modal');

                //renderiza a tela
                $this->View->getTela()->getRender();
            } else {
                $this->msgSit($aDados, $oRet);
            }
        }
    }

    public function msgSit($aDados, $oRet) {

        if ($oRet->situaca == 'Finalizada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC já foi finalizada pelo representante.', Modal::TIPO_AVISO);
        }
        if ($oRet->situaca != 'Apontada' && $oRet->reclamacao == 'Em análise') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC não está em situação de ser apontada.', Modal::TIPO_AVISO);
        }
        if ($oRet->situaca == 'Aguardando' && $oRet->reclamacao == 'Aguardando') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
        }
        if ($oRet->situaca == 'Apontada' && $oRet->reclamacao == 'Interna' && $oRet->devolucao == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como Interna, foi Recusada e não pode ser apontada novamente.', Modal::TIPO_AVISO);
        }
        if ($oRet->situaca == 'Apontada' && $oRet->reclamacao == 'Interna' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como Interna, foi Aceita e já teve sua NF apontada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($oRet->reclamacao == 'Transportadora' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como avaria causada pela Transportadora e a devolução foi Aceita e já teve sua NF apontada pelo setor de Vendas', Modal::TIPO_AVISO);
        }
        if ($oRet->reclamacao == 'Transportadora' && $oRet->devolucao == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como avaria causada pela Transportadora e a devolução foi Recusada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($oRet->reclamacao == 'Representante' && $oRet->devolucao == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como Desacerto do Representante e a devolução foi Recusada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($oRet->reclamacao == 'Representante' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como Desacerto do Representante e a devolução foi Aceita e já teve sua NF apontada pelo setor de Vendas', Modal::TIPO_AVISO);
        }
        if ($oRet->reclamacao == 'Cliente' && $oRet->devolucao == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como Desacerto do Cliente e a devolução foi Recusada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($oRet->reclamacao == 'Cliente' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RC foi apontada como Desacerto do Cliente e a devolução foi Aceita e já teve sua NF apontada pelo setor de Vendas', Modal::TIPO_AVISO);
        }
        echo $oMensagem->getRender();
        echo "$('#" . $aDados[1] . "-btn').click();";
    }

    public function updateSitRC($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->verifSitRC($aCamposChave);

        if ($aRetorno[1] != 'Em análise') {
            $aRetorno = $this->Persistencia->updateSitRC($aCamposChave, $sParam);
            if ($aRetorno == true) {
                $oMensagem = new Mensagem('Sucesso', 'Registro alterado com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                $this->enviaEmailSetor($sDados, $sParam);
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Mensagem('Atenção', 'O registro não pode ser alterado, o e-mail não foi enviado!', Mensagem::TIPO_ERROR);
                echo $oMensagem->getRender();
            }
        }
    }

    /**
     * Metodo que monta o e-mail e envia para o setor responsável pela análise da devolução.
     */
    public function enviaEmailSetor($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

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

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->reclamacao . ''));


        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oRow->nr . ' foi enviada pelo setor de Vendas!<hr><br/>'
                        . '<b> Responsável de Vendas: ' . $oRow->resp_venda_nome . '<b><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal: </b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . $oRow->datanf . ' </td></tr>'
                        . '<tr><td><b>Od. de compra: </b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº: </b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($oRow->valor, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . number_format($oRow->peso, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        $aRet = $this->Persistencia->verifSitRC($aCamposChave, $sParam);

        // Para
        if ($aRet[0] != $sParam) {
            $oMensagem2 = new Modal('Ops!', 'Parece que você selecionou um setor diferente de para onde esse e-mail foi enviado, tente novamente :)', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem2->getRender();
        } else {
            if ($aRet[0] == 'Aguardando') {
                $oMensagem3 = new Modal('Ops!', 'A RC não foi liberada pelo representante, aguarde a liberação ou solicite para o mesmo.', Modal::TIPO_AVISO, false, true, true);
                echo $oMensagem3->getRender();
            } else {
                if ($aRet[0] == 'Env.Qual') {
                    //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                    $oEmail->addDestinatario('duda@metalbo.com.br');
                }
                if ($aRet[0] == 'Env.Emb') {
                    //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                    $oEmail->addDestinatario('embalagem@metalbo.com.br');
                }
                if ($aRet[0] == 'Env.Exp') {
                    //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                    $oEmail->addDestinatario('josiani@metalbo.com.br');
                }

                $oEmail->addAnexo('app/relatorio/RC/RC' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf', utf8_decode('RC nº' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf'));
                $aRetorno = $oEmail->sendEmail();
                if ($aRetorno[0]) {
                    $oMensagem4 = new Mensagem('E-mail', 'Um e-mail foi enviado com sucesso para o setor responsável!', Mensagem::TIPO_SUCESSO);
                    echo $oMensagem4->getRender();
                } else {
                    $oMensagem5 = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
                    echo $oMensagem5->getRender();
                }
            }
        }
    }

    public function apontaReclamacao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['reclamacao'] == '' || $aCampos['reclamacao'] == null) {
            $oMsg = new Mensagem('Atenção', 'Selecione o TIPO da RC segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
            exit();
        }
        if ($aCampos['devolucao'] == '' || $aCampos['devolucao'] == null) {
            $oMsg = new Mensagem('Atenção', 'Selecione o status da DEVOLUÇÃO segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
            exit();
        } else {
            $aRetorno = $this->Persistencia->apontaReclamacao($aCamposChave);

            if ($aRetorno[0] == true) {
                $oMensagem = new Modal('Sucesso', 'Apontamento efetuado com sucesso!', Modal::TIPO_SUCESSO);
                $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o representante!', Mensagem::TIPO_INFO, 10000);
                echo $oMsg2->getRender();
                echo 'requestAjax("","MET_QUAL_RcVenda","enviaEmailRep","' . $sDados . '");';
                echo"$('#" . $aDados[2] . "-btn').click();";
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Modal('Atenção', 'Erro ao tentar inserir o registro', Modal::TIPO_ERRO);
            }
            echo $oMensagem->getRender();
        }
    }

    public function apontaNFReclamacao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRetorno = $this->Persistencia->apontaNFReclamacao($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Sucesso', 'Apontamento efetuado com sucesso!', Modal::TIPO_SUCESSO);
            echo"$('#" . $aDados[2] . "-btn').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'Erro ao tentar inserir o registro', Modal::TIPO_ERRO);
        }
        echo $oMensagem->getRender();
    }

    public function enviaEmailRep($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[3] == '' || $aDados[3] == null) {
            $sChave = htmlspecialchars_decode($aDados[2]);
        } else {
            $sChave = htmlspecialchars_decode($aDados[3]);
        }
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

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

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ''));
        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oRow->nr . ' foi apontada pelo setor de VENDAS.<hr><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal: </b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . $oRow->datanf . ' </td></tr>'
                        . '<tr><td><b>Od. de compra: </b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº: </b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($oRow->valor, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . number_format($oRow->peso, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '<tr><td><b>Observação de Vendas: </b></td><td> ' . $oRow->obs_aponta . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $sEmail = $this->Persistencia->buscaEmailRep($aCamposChave);
        $oEmail->addDestinatario($sEmail);
        //$oEmail->addDestinatario('alexandre@metalbo.com.br');

        $oEmail->addDestinatarioCopia($_SESSION['email']);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o representante com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo 'requestAjax("","MET_QUAL_RcVenda","notificaAlmoxarifado","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email para o representante, tente reenviar ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /*
     * Método que monta a Modal de Apontamento do setor de Vendas
     * */

    public function criaTelaModalRetorna($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $aRet = $this->Persistencia->verifSitRC($aCamposChave);

        if ($aRet[0] == 'Liberado' && $aRet[1] == 'Aguardando' && $aRet[2] == 'Aguardando') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);
            $this->View->criaModalRetorna($sDados);


            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMensagem = new Modal('Atenção!', 'A RC nº' . $aCamposChave['nr'] . ' não está em condições para ser retornada para o Representante.', Modal::TIPO_AVISO, false, true, true);
            echo"$('#" . $aDados[1] . "-btn').click();";
        }

        echo $oMensagem->getRender();
    }

    public function retornaEmailRep($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aDadosModal = array();
        parse_str($_REQUEST['campos'], $aDadosModal);

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

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ''));
        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oRow->nr . ' foi RETORNADA pelo setor de VENDAS.<hr><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal: </b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . $oRow->datanf . ' </td></tr>'
                        . '<tr><td><b>Od. de compra: </b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº: </b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($oRow->valor, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . number_format($oRow->peso, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '<tr><td><b>MOTIVO DO RETORNO: </b></td><td> ' . $aDadosModal['motivo'] . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $sEmail = $this->Persistencia->buscaEmailRep($aCamposChave);
        $oEmail->addDestinatario($sEmail);
        //$oEmail->addDestinatario('alexandre@metalbo.com.br');

        $oEmail->addDestinatarioCopia($_SESSION['email']);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $aRetorna = $this->Persistencia->retornaRep($aCamposChave);
            if ($aRetorna[0] == true) {
                $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o representante com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                echo"$('#" . $aDados[1] . "-pesq').click();";
                echo"$('#" . $aDados[2] . "-btn').click();";
            }
        } else {
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email para o representante, tente novamente ou comunique o TI - ', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function notificaAlmoxarifado($sDados) {
        $sClasse = $this->getNomeClasse();
        //Envia e-mail notificando o setor do almoxarifado
        $oMsg3 = new Modal('Notificar Almoxarifado', 'Deseja notificar o setor do Almoxarifado?', Modal::TIPO_AVISO, true, true, true);
        $oMsg3->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","enviaEmailAlmoxarifado","' . $sDados . '");');
        echo $oMsg3->getRender();
    }

    public function enviaEmailAlmoxarifado($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

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

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE'));
        $oEmail->setMensagem(utf8_decode('<span style="color:green;"><b>A devolução foi ACEITA pelo setor de VENDAS</b></span><br/>'
                        . '<b>Responsável de Vendas: ' . $oRow->resp_venda_nome . ' </b><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Observação VENDAS: </b></td><td> ' . $oRow->obs_aponta . ' </td></tr>'
                        . '<tr><td><b>Observação ANÁLISE: </b></td><td> ' . $oRow->apontamento . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $oEmail->addDestinatario('almoxarifado@metalbo.com.br');
        //$oEmail->addDestinatario('alexandre@metalbo.com.br');

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o setor do Almoxarifado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email para o setor do Almoxarifado, tente novamente ou comunique o TI - ', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

}
