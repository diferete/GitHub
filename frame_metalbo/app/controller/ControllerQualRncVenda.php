<?php

/*
 * Implementa controller da classe QualRnc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerQualRncVenda extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualRncVenda');
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

        $oAnalise = $this->Persistencia->buscaDadosRnc($aAnalise);

        $sAnalise = Util::limpaString($oAnalise->apontamento);

        echo '$("#' . $aDados[2] . '").val("' . $sAnalise . '");';
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
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
        }
        if ($sParam == 'Env.Emb') {
            $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da EMBALAGEM?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
        }
        if ($sParam == 'Env.Exp') {
            $oMensagem = new Modal('Encaminhar e-mail', 'Deseja encaminhar a RC nº' . $aCamposChave['nr'] . ' para o setor da EXPEDIÇÃO?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","updateSitRC","' . $sDados . '","' . $sParam . '");');
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
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","enviaEmailRep","' . $sDados . '");');
            }
            if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Representante') {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' teve sua análise como desacerto do Representante, deseja reenviar o e-mail para o representante?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","enviaEmailRep","' . $sDados . '");');
            }
            if ($aRetorno[0] == 'Apontada' && $aRetorno[1] == 'Cliente') {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' teve sua análise como desacerto do Cliente, deseja reenviar o e-mail para o representante?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","enviaEmailRep","' . $sDados . '");');
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
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","enviaEmailSetor","' . $sDados . '","' . $sParam . '");');
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

        $aRet = $this->Persistencia->verifSitRC($aCamposChave);

        if (($aRet[0] == 'Liberado' && $aRet[1] == 'Aguardando') || ($aRet[0] == 'Apontada' && $aRet[1] == 'Em análise')) {
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
            $this->msgSit($aDados, $aRet);
        }
    }

    public function msgSit($aDados, $aRet) {

        if ($aRet[0] == 'Finalizada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC já foi finalizada pelo representante.', Modal::TIPO_AVISO);
        }
        if ($aRet[0] != 'Apontada' && $aRet[1] == 'Em análise') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC não está em situação de ser apontada.', Modal::TIPO_AVISO);
        }
        if ($aRet[0] == 'Aguardando' && $aRet[1] == 'Aguardando') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
        }
        if ($aRet[0] == 'Apontada' && $aRet[1] == 'Interna' && $aRet[2] == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como Interna, foi Recusada e não pode ser apontada novamente.', Modal::TIPO_AVISO);
        }
        if ($aRet[0] == 'Apontada' && $aRet[1] == 'Interna' && $aRet[2] == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como Interna, foi Aceita e não pode ser apontada novamente.', Modal::TIPO_AVISO);
        }
        if ($aRet[1] == 'Transportadora' && $aRet[2] == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como avaria causada pela Transportadora e a devolução foi Aceita pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($aRet[1] == 'Transportadora' && $aRet[2] == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como avaria causada pela Transportadora e a devolução foi Recusada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($aRet[1] == 'Representante' && $aRet[2] == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como desacerto do Representante e a devolução foi Recusada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($aRet[1] == 'Representante' && $aRet[2] == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como desacerto do Representante e a devolução foi Aceita pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($aRet[1] == 'Cliente' && $aRet[2] == 'Recusada') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como desacerto do Cliente e a devolução foi Recusada pelo setor de Vendas.', Modal::TIPO_AVISO);
        }
        if ($aRet[1] == 'Cliente' && $aRet[2] == 'Aceita') {
            $oMensagem = new Modal('Atenção', 'Reclamação - RNC foi apontada como desacerto do Cliente e a devolução foi Aceita pelo setor de Vendas.', Modal::TIPO_AVISO);
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
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

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
                $oMensagem3 = new Modal('Ops!', 'A RNC não foi liberada pelo representante, aguarde a liberação ou solicite para o mesmo.', Modal::TIPO_AVISO, false, true, true);
                echo $oMensagem3->getRender();
            } else {
                if ($aRet[0] == 'Env.Qual') {
                    $oEmail->addDestinatario('alexandre@metalbo.com.br');
                    //$oEmail->addDestinatario('duda@metalbo.com.br');
                }
                if ($aRet[0] == 'Env.Emb') {
                    $oEmail->addDestinatario('alexandre@metalbo.com.br');
                    //$oEmail->addDestinatario('embalagem@metalbo.com.br');
                }
                if ($aRet[0] == 'Env.Exp') {
                    $oEmail->addDestinatario('alexandre@metalbo.com.br');
                    //$oEmail->addDestinatario('josiani@metalbo.com.br');
                }

                $oEmail->addAnexo('app/relatorio/rnc/Rnc' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf', utf8_decode('RNC nº' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc']));
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
            $oMsg = new Mensagem('Atenção', 'Selecione o TIPO da RNC segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
        if ($aCampos['devolucao'] == '' || $aCampos['devolucao'] == null) {
            $oMsg = new Mensagem('Atenção', 'Selecione o status da DEVOLUÇÃO segundo análise!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        } else {
            $aRetorno = $this->Persistencia->apontaReclamacao($aCamposChave);

            if ($aRetorno[0] == true) {
                $oMensagem = new Modal('Sucesso', 'Apontamento efetuado com sucesso!', Modal::TIPO_SUCESSO);
                $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o representante!', Mensagem::TIPO_INFO);
                echo $oMsg2->getRender();
                echo 'requestAjax("","QualRncVenda","enviaEmailRep","' . $sDados . '");';
                echo"$('#" . $aDados[2] . "-btn').click();";
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Modal('Atenção', 'Erro ao tentar inserir o registro', Modal::TIPO_ERRO);
            }
            echo $oMensagem->getRender();
        }
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
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

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
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

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

}
