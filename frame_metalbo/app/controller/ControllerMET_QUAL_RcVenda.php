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

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aRepOffice = $this->Persistencia->getRepOffice();
        $this->View->setAParametrosExtras($aRepOffice);
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

        if ($sChave == '') {
            $sScriptLabel = '$("label[for=' . $aDados[2] . ']").text("");';
            $sScriptLabel2 = '$("label[for=' . $aDados[3] . ']").text("");';
            $sScriptDados = '$("#' . $aDados[2] . '").val("");';
            $sProblemas = '$("#' . $aDados[3] . '").val("");';

            echo $sScriptLabel;
            echo $sScriptLabel2;
            echo $sScriptDados;
            echo $sProblemas;
        } else {
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

            if ($oAnalise->situaca == 'Cancelada') {
                $sAnalise = Util::limpaString($oAnalise->motivocancela);
                $sScriptLabel = '$("label[for=' . $aDados[2] . ']").text("Motivo do Cancelamento da análise:");';
            } else {
                $sScriptLabel = '$("label[for=' . $aDados[2] . ']").text("Análise aprensentada pelo setor responsável - ' . $sSetor . ':");';
            }
            $sScriptLabel2 = '$("label[for=' . $aDados[3] . ']").text("Problema descrito pelo Representante:");';
            $sScriptDados = '$("#' . $aDados[2] . '").val("' . $sAnalise . '");';
            $sProblemas = '$("#' . $aDados[3] . '").val("' . $sProblema . '");';



            echo $sScriptLabel;
            echo $sScriptLabel2;
            echo $sScriptDados;
            echo $sProblemas;
        }
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

        if ($aRetorno[0] == 'Liberado' && $aRetorno[1] == 'Aguardando' && $aRetorno[3] != 'Aguardando') {
            $this->emailsSetores($sDados, $sParam);
        }
        if ($aRetorno[3] != 'Aguardando' && ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Transportadora') || ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Representante') || ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Cliente')) {
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

        if ($aRetorno[0] == 'Cancelada') {
            $oMensagem = new Mensagem('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' foi cancelada.', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Em análise') {
            $oMensagem = new Mensagem('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' já foi apontada por um setor interno da Metalbo!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRetorno[0] == 'Aguardando') {
            $oMensagem = new Mensagem('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRetorno[0] == 'Finalizada') {
            $oMensagem = new Mensagem('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' já foi finalizada!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRetorno[3] == 'Aguardando') {
            $oMensagem = new Mensagem('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' está aguardando liberação de devolução pela gerência!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRetorno[0] == 'Reaberta') {
            $oMensagem = new Mensagem('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' foi Reaberta e está aguardando apontamento!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRetorno[1] == 'Em análise' && $aRetorno[0] != 'Apontada') {
            $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' ja teve seu e-mail encaminhado para o seu setor responsável, deseja reenviar o e-mail?', Modal::TIPO_INFO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","enviaEmailSetor","' . $sDados . '","' . $sParam . '");');
            echo $oMensagem->getRender();
        }
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
        $iRet = $this->gerenciaSituacoes($oRet);

        $this->View->setAParametrosExtras($oRet);

        switch ($iRet) {
            case 0:
                $this->msgSit($aDados, $oRet);
                break;
            case 1:
                $this->View->criaModalApontamento($sDados);
                break;
            case 2:
                $this->View->criaModalApontamentoNF($sDados);
                break;
            case 3:
                $this->View->criaModalApontamentoReaberta($sDados);
                break;
        }

        //adiciona onde será renderizado
        $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
        echo $sLimpa;
        $this->View->getTela()->setSRender($aDados[1] . '-modal');
        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    function gerenciaSituacoes($oDados) {
        if ($oDados->situaca == 'Cancelada') {
            return 0;
        }
        if ($oDados->situaca == 'Aguardando') {
            return 0;
        }
        if ($oDados->situaca == 'Liberado') {
            return 1;
        }
        if ($oDados->situaca == 'Apontada') {
            if ($oDados->sollibdevolucao == null || $oDados->sollibdevolucao == 'Liberada') {
                return 1;
            } else {
                return 0;
            }
        }
        if ($oDados->situaca == 'Finalizada') {
            if ($oDados->apontanf == null) {
                return 2;
            } else {
                return 0;
            }
        }
        if ($oDados->situaca == 'Reaberta') {
            return 3;
        }
    }

    public function apontaReclamacao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $oDados = $this->Persistencia->buscaDadosRC($aCamposChave);

        if ($aCampos['reclamacao'] == '' || $aCampos['reclamacao'] == null) {
            $oMsg = new Mensagem('Atenção', 'Selecione o TIPO da RC segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
            exit();
        }
        if ($aCampos['devolucao'] == '' || $aCampos['devolucao'] == null) {
            $oMsg = new Mensagem('Atenção', 'Selecione o status da DEVOLUÇÃO segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
            exit();
        }
        if (($aCampos['procedencia'] == '' || $aCampos['procedencia'] == null) && $oDados->procedencia == 'Aguardando') {
            $oMsg = new Mensagem('Atenção', 'Selecione o status da PROCEDENCIA segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
            exit();
        } else {
            $aRetorno = $this->Persistencia->apontaReclamacao($aCamposChave, $oDados->procedencia);
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

    public function msgSit($aDados, $oRet) {
        if ($oRet->situaca == 'Cancelada') {
            $oMensagem = new Mensagem('Atenção!', 'Reclamação - RC foi Cancelada!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            echo "$('#" . $aDados[1] . "-btn').click();";
            exit();
        }
        if ($oRet->situaca == 'Finalizada' && $oRet->apontanf == 'Apontada') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC já foi finalizada e NF de devolução apontada, reabra a RC caso deseje alterar!', Mensagem::TIPO_WARNING);
        }
        if ($oRet->situaca == 'Finalizada' && $oRet->apontanf == null) {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC já foi finalizada!', Mensagem::TIPO_WARNING);
        }
        if ($oRet->situaca != 'Apontada' && $oRet->reclamacao == 'Em análise') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC não está em situação de ser apontada.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->situaca == 'Aguardando' && $oRet->reclamacao == 'Aguardando') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->situaca == 'Apontada' && $oRet->reclamacao == 'Interna' && $oRet->devolucao == 'Indeferida') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Interna, foi Indeferida e não pode ser apontada novamente.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->situaca == 'Apontada' && $oRet->reclamacao == 'Interna' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Interna, foi Aceita pelo setor de Vendas.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->situaca == 'Apontada' && $oRet->reclamacao == 'Interna' && $oRet->devolucao == 'Não se aplica') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Interna, e a devolução Não se aplica!.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Transportadora' && $oRet->devolucao == 'Indeferida') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como avaria causada pela Transportadora e a devolução foi Indeferida pelo setor de Vendas.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Transportadora' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como avaria causada pela Transportadora e a devolução foi Aceita pelo setor de Vendas', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Transportadora' && $oRet->devolucao == 'Não se aplica') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como avaria causada pela Transportadora e a devolução Não se aplica!', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Representante' && $oRet->devolucao == 'Indeferida') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Desacerto do Representante e a devolução foi Indeferida pelo setor de Vendas.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Representante' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Desacerto do Representante e a devolução foi Aceita pelo setor de Vendas', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Representante' && $oRet->devolucao == 'Não se aplica') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Desacerto do Representante e a devolução Não se aplica!', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Cliente' && $oRet->devolucao == 'Indeferida') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Desacerto do Cliente e a devolução foi Indeferida pelo setor de Vendas.', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Cliente' && $oRet->devolucao == 'Aceita') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Desacerto do Cliente e a devolução foi Aceita pelo setor de Vendas', Mensagem::TIPO_WARNING);
        }
        if ($oRet->reclamacao == 'Cliente' && $oRet->devolucao == 'Não se aplica') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC foi apontada como Desacerto do Cliente e a devolução Não se aplica!', Mensagem::TIPO_WARNING);
        }
        if ($oRet->sollibdevolucao == 'Aguardando') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação - RC está aguardando liberação de devolução pela gerência!', Mensagem::TIPO_WARNING);
        }
        echo $oMensagem->getRender();
        echo "$('#" . $aDados[1] . "-btn').click();";
        exit();
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
                echo "$('#" . $aDados[1] . "-pesq').click();";
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->reclamacao . ''));


        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oRow->nr . ' está em Análise!<hr><br/>'
                        . '<b> Responsável de Vendas: ' . $oRow->resp_venda_nome . '<b><br/>'
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
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        $aRet = $this->Persistencia->verifSitRC($aCamposChave, $sParam);

        // Para
        if ($aRet[0] != $sParam) {
            $oMensagem2 = new Modal('Ops!', 'Parece que você selecionou um setor diferente de para onde esse e-mail foi enviado, tente novamente :)', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem2->getRender();
            sleep(2);
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
                    $oEmail->addDestinatario('ean@metalbo.com.br');
                    $oEmail->addDestinatarioCopia('duda@metalbo.com.br');
                }
                if ($aRet[0] == 'Env.Exp') {
                    //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                    $oEmail->addDestinatario('embalagem@metalbo.com.br');
                    $oEmail->addDestinatarioCopia('josiani@metalbo.com.br');
                    $oEmail->addDestinatarioCopia('duda@metalbo.com.br');
                }

                //$oEmail->addAnexo('app/relatorio/RC/RC' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf', utf8_decode('RC nº' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf'));
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ''));
        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oRow->nr . ' foi apontada e finalizada pelo setor de VENDAS.<hr><br/>'
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
                        . '<tr><td><b>Observação de Vendas: </b></td><td> ' . $oRow->obs_aponta . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $sEmail = $this->Persistencia->buscaEmailRep($aCamposChave);
        $oEmail->addDestinatario($sEmail);
        $oEmail->addDestinatarioCopia($_SESSION['email']);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o representante com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email para o representante, tente reenviar ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
        echo 'requestAjax("","MET_QUAL_RcVenda","notificaAlmoxarifado","' . $sDados . '");';
    }

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
            $oMensagem = new Mensagem('Atenção!', 'A RC nº' . $aCamposChave['nr'] . ' não está em condições para ser retornada para o Representante.', Mensagem::TIPO_WARNING);
            echo"$('#" . $aDados[1] . "-btn').click();";
            echo $oMensagem->getRender();
        }
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

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
                        . '<tr><td><b>Data da NF.: </b></td><td> ' . Util::converteData($oRow->datanf) . ' </td></tr>'
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

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
                        . '<b>Para mais informações, consulte o anexo!</b><br/>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $oEmail->addDestinatario('duda@metalbo.com.br');
        $oEmail->addDestinatarioCopia('almoxarifado@metalbo.com.br');

        //$oEmail->addAnexo('app/relatorio/RC/RC' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf', utf8_decode('RC nº' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf'));

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o setor do Almoxarifado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email para o setor do Almoxarifado, tente novamente ou comunique o TI!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    /*
     * Método que monta a Modal de Reabertura RC do setor de Vendas
     * */

    public function reabrirRC($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oDados = $this->Persistencia->buscaDadosRC($aCamposChave);
        if ($oDados->situaca == 'Finalizada') {
            $aRetorno = $this->Persistencia->reabrirRC($aCamposChave);
            if ($aRetorno[0]) {
                $oMensagem = new Mensagem('Sucesso', 'RC reaberta para apontamento!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                echo "$('#" . $aDados[0] . "-pesq').click();";
            } else {
                $oMensagem = new Mensagem('Atenção', 'Problemas ao tentar reabrir a RC para apontamento, tente novamente ou comunique o TI!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
            }
        } else {
            $oMensagem = new Mensagem('Atenção', 'Não está em condições de ser Reaberta!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function notificaRetornoAnalise($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oDados = $this->Persistencia->buscaDadosRC($aCamposChave);
        if ($oDados->situaca == 'Apontada' && $oDados->devolucao == 'Aguardando') {
            $oMsg3 = new Modal('Retornar para análise', 'Deseja retornar essa RC para o setor de Análise?', Modal::TIPO_AVISO, true, true, true);
            $oMsg3->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","retornarRCAnalise","' . $sDados . '");');
            echo $oMsg3->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção', 'A RC não está em condições de ser retornada!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function retornarRCAnalise($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aRetorno = $this->Persistencia->retornarRCAnalise($aCamposChave);
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso', 'RC retornada para análise!', Mensagem::TIPO_SUCESSO);
            $oMensagem2 = new Mensagem('Aguarde', 'Um e-mail será enviado para notificar o setor de análise', Mensagem::TIPO_WARNING, 5000);
            echo $oMensagem->getRender();
            echo $oMensagem2->getRender();
            echo 'requestAjax("","MET_QUAL_RcVenda","enviaEmailRetornoAnalise","' . $sDados . '");';
        } else {
            $oMensagem = new Mensagem('Atenção', 'Problemas ao tentar retornar a RC para análise, tente novamente ou comunique o TI!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function enviaEmailRetornoAnalise($sDados) {

        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oDados = $this->Persistencia->buscaDadosRC($aCamposChave);

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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oDados->nr . ''));


        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oDados->nr . ' foi retornada pelo setor de Vendas!<hr><br/>'
                        . '<b> Responsável de Vendas: ' . $oDados->resp_venda_nome . '<b><br/>'
                        . '<b>Data do retorno: ' . $data . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        // Para       
        switch ($oDados->tagsetor) {
            case 3:
                //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                $oEmail->addDestinatario('embalagem@metalbo.com.br');
                $oEmail->addDestinatarioCopia('josiani@metalbo.com.br');
                $oEmail->addDestinatarioCopia('duda@metalbo.com.br');
                break;
            case 5:
                //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                $oEmail->addDestinatario('ean@metalbo.com.br');
                $oEmail->addDestinatarioCopia('duda@metalbo.com.br');
                break;
            case 25:
                //$oEmail->addDestinatario('alexandre@metalbo.com.br');
                $oEmail->addDestinatario('duda@metalbo.com.br');
                break;
        }

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem4 = new Mensagem('E-mail', 'Um e-mail foi enviado com sucesso para o setor responsável pela Análise!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem4->getRender();
            echo "$('#" . $aDados[0] . "-pesq').click();";
        } else {
            $oMensagem5 = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem5->getRender();
        }
    }

    public function solicitaLibDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oDados = $this->Persistencia->buscaDadosRC($aCamposChave);

        if ($oDados->situaca == 'Cancelada') {
            $oMensagem = new Mensagem('Atenção!', 'A RC nº' . $aCamposChave['nr'] . ' já foi cancelada', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if (($oDados->sollibdevolucao == '' || $oDados->sollibdevolucao == null) && ($oDados->situaca == 'Liberado' || $oDados->situaca == 'Apontada' || $oDados->situaca == 'Reaberta')) {
            $aRetorno = $this->Persistencia->solicitaLibDevolucao($aCamposChave);
            if ($aRetorno[0]) {
                $oMensagem = new Mensagem('Sucesso', 'Solicitação de liberação da devolução enviada!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                echo "$('#" . $aDados[0] . "-pesq').click();";
            } else {
                $oMensagem = new Mensagem('Atenção', 'Problemas ao tentar solicitar liberação da devolução, tente novamente ou comunique o TI!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
            }
        } elseif ($oDados->sollibdevolucao == 'Liberada') {
            $oMensagem = new Mensagem('Atenção', 'Devolução já apontada e liberada pela gerência!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } elseif ($oDados->reclamacao == 'Em análise' && $oDados->situaca != 'Apontada') {
            $oMensagem = new Mensagem('Atenção', 'Reclamação está em análise, aguarde para solicitar liberação de devolução.', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } elseif ($oDados->situaca == 'Finalizada') {
            $oMensagem = new Mensagem('Atenção', 'Processo de reclamação Finalizado.', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção', 'Já foi solicitada a liberação, aguarde.', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    /*
     * Método que monta a Modal de Apontamento do setor de Vendas
     * */

    public function criaTelaModalApontaDevolucao($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRet = $this->Persistencia->verifSitRC($aCamposChave);
        if ($aRet[0] == 'Cancelada') {
            echo"$('#" . $aDados[0] . "-btn').click();";
            $oMensagem = new Mensagem('Atenção!', 'A RC nº' . $aCamposChave['nr'] . ' já foi cancelada', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit;
        }
        if ($aRet[3] == 'Aguardando' || ($aRet[0] != 'Cancelada' || $aRet[0] != 'Finalizada' || $aRet[0] != 'Aguardando')) {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);
            $this->View->criaModalApontaDevolucao($sDados);


            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[0] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção!', 'A RC nº' . $aCamposChave['nr'] . ' não está em condições de ser liberada.', Modal::TIPO_AVISO);
            echo"$('#" . $aDados[0] . "-btn').click();";
            echo $oMensagem->getRender();
        }
    }

    public function liberaDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aRet = $this->Persistencia->liberaDevolucao($aCamposChave);
        if ($aRet[0]) {
            $this->enviaEmailLiberaDevolucao($sDados);
        }
    }

    public function enviaEmailLiberaDevolucao($sDados) {
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        $sCor = '';
        if ($oRow->devolucao == 'Aceita') {
            $sCor = 'green';
        } else {
            $sCor = 'orange';
        }

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE NRº ' . $oRow->nr));
        $oEmail->setMensagem(utf8_decode('<span style="color:' . $sCor . ';"><b>A devolução foi Liberada e ' . $oRow->devolucao . ' pela gerência de VENDAS</b></span><br/>'
                        . '<b>Número: ' . $oRow->nr . ' </b><br/>'
                        . '<b>Responsável de Vendas: ' . $oRow->resp_venda_nome . ' </b><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Devolução pela gerência: </b></td><td> ' . $oRow->devolucao . ' </td></tr>'
                        . '<tr><td><b>Observação: </b></td><td> ' . $oRow->obslibdevolucao . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        $sEmail = $this->Persistencia->buscaEmailVendas($aCamposChave);
        $oEmail->addDestinatario($sEmail);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Responsável de vendas pela reclamação foi notificado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo"$('#" . $aDados[1] . "-btn').click();";
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email de notificação, comunique o departamento de TI!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function criaTelaModalCancela($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        if ($oRow->situaca == 'Cancelada') {
            echo"$('#" . $aDados[1] . "-btn').click();";
            $oMensagem = new Mensagem('Atenção!', 'A RC nº' . $aCamposChave['nr'] . ' já foi cancelada', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } else {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);
            $this->View->criaModalCancela($sDados);


            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        }
    }

    /*
     * Método que monta a Modal de Reabertura RC do setor de Vendas
     * */

    public function cancelaRC($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['motivocancela'] == '' || $aCampos['motivocancela'] == null) {
            $oMensagem = new Mensagem('Atenção', 'Favor preencher o motivo do cancelamento', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        } else {
            $aRetorno = $this->Persistencia->cancelarRC($aCamposChave);
            if ($aRetorno[0]) {
                echo "$('#" . $aDados[0] . "-pesq').click();";
                $oMensagem = new Mensagem('Sucesso', 'RC foi cancelada!', Mensagem::TIPO_SUCESSO);
                $this->emailCancelaRC($sDados);
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Mensagem('Atenção', 'Problemas ao tentar cancelar a RC, tente novamente ou comunique o TI!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
            }
        }
    }

    public function emailCancelaRC($sDados) {
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail Sistema Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ''));
        $oEmail->setMensagem(utf8_decode('A reclamação de Nº ' . $oRow->nr . ' foi CANCELADA pelo setor de VENDAS.<hr><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>MOTIVO DO CANCELAMENTO: </b></td><td> ' . $oRow->motivocancela . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        $sEmail = $this->Persistencia->buscaEmailRep($aCamposChave);
        $oEmail->addDestinatario($sEmail);
        $oEmail->addDestinatarioCopia($_SESSION['email']);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para o representante com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
            echo"$('#" . $aDados[2] . "-btn').click();";
        } else {
            $oMensagem = new Mensagem('E-mail', 'Problemas ao enviar o email para o representante, tente novamente ou comunique o TI - ', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function notificaRetornoDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oDados = $this->Persistencia->buscaDadosRC($aCamposChave);
        if ($oDados->sollibdevolucao == 'Aguardando') {
            $oMsg3 = new Modal('Retornar', 'Deseja retornar essa RC para Análise?', Modal::TIPO_AVISO, true, true, true);
            $oMsg3->setSBtnConfirmarFunction('requestAjax("","MET_QUAL_RcVenda","retornarDevolucao","' . $sDados . '");');
            echo $oMsg3->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção', 'A RC não está em condições de ser retornada!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

    public function retornarDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aRetorno = $this->Persistencia->retornarDevolucao($aCamposChave);
        if ($aRetorno[0]) {
            echo "$('#" . $aDados[0] . "-pesq').click();";
            $oMensagem = new Mensagem('Sucesso', 'RC retornada para análise!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção', 'Problemas ao tentar retornar a RC para análise, tente novamente ou comunique o TI!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

}
