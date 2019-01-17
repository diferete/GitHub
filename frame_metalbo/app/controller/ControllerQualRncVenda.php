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

    public function carregaAnalise($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aAnalise = array();
        parse_str($sChave, $aAnalise);

        $sAnalise = Util::limpaString($this->Persistencia->buscaAnalise($aAnalise));

        echo '$("#' . $aDados[2] . '").val("' . $sAnalise . '");';
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);

        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";

        echo $sRetorno;
    }

    /**
     * Método que faz a chamada do envio e verificação para reenvio.
     */
    public function verificaEmailSetor($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->verifSitEnc($aCamposChave);

        if ($aRetorno[0] == 'Liberado') {
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
        } else {
            if ($aRetorno[0] == 'Apontada') {
                $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' ja foi apontada!', Modal::TIPO_AVISO, false, true, true);
            }
            if ($aRetorno[0] == 'Aguardando') {
                $oMensagem = new Modal('Atenção', 'A reclamação nº' . $aCamposChave['nr'] . ' não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO, false, true, true);
            }
            if ($aRetorno[1] == 'Em análise' && $aRetorno[0] != 'Apontada') {
                $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' ja teve seu e-mail encaminhado para o seu setor responsável, deseja reenviar o e-mail?', Modal::TIPO_INFO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualRncVenda","enviaEmailSetor","' . $sDados . '","' . $sParam . '");');
            }
        }

        echo $oMensagem->getRender();
    }

    public function updateSitRC($sDados, $sParam) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->verifSitEnc($aCamposChave);

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

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->devolucao . ''));


        $oEmail->setMensagem(utf8_decode('A devolução de Nº ' . $oRow->nr . ' foi enviada pelo setor de Vendas!<hr><br/>'
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
                        . '<tr><td><b>Valor: R$</b></td><td> ' . $oRow->valor . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . $oRow->peso . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        $aRet = $this->Persistencia->verifSitEnc($aCamposChave, $sParam);

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

    /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalAccDevolucao($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $aRet = $this->Persistencia->verifSitDev($aCamposChave);
        if ($aRet[1] == 'Apontada' && $aRet[2] == 'Em análise') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalAccDevolucao($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            if ($aRet[1] != 'Apontada') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC não foi apontada pelo setor responsável pela análise, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Finalizada') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC já foi finalizada pelo representante.', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Aguardando') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Apontada' && $aRet[2] == 'Recusada') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC já foi Recusada e não pode ser apontada novamente...', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Apontada' && $aRet[2] == 'Aceita') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC já foi Aceita e não pode ser apontada novamente...', Modal::TIPO_AVISO);
            }
            echo $oMensagem->getRender();
            echo "$('#" . $aDados[1] . "-btn').click();";
        }
    }

    /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalRecDevolucao($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $aRet = $this->Persistencia->verifSitDev($aCamposChave);
        if ($aRet[1] == 'Apontada' && $aRet[2] == 'Em análise') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalRecDevolucao($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            if ($aRet[1] != 'Apontada') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC não foi apontada pelo setor responsável pela análise, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Finalizada') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC já foi finalizada pelo representante.', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Aguardando') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC não foi liberada pelo Representante, aguarde ou notifique o mesmo para liberação.', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Apontada' && $aRet[2] == 'Recusada') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC já foi Recusada e não pode ser apontada novamente...', Modal::TIPO_AVISO);
            }if ($aRet[1] == 'Apontada' && $aRet[2] == 'Aceita') {
                $oMensagem = new Modal('Devolução', 'Reclamação - RNC já foi Aceita e não pode ser apontada novamente...', Modal::TIPO_AVISO);
            }
            echo $oMensagem->getRender();
            echo "$('#" . $aDados[1] . "-btn').click();";
        }
    }

    public function aceitaDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->aceitaDevolucao($aCamposChave);

        $sParam = 'Aceitar';

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Devolução', 'Devolução aceita pela Metalbo', Modal::TIPO_SUCESSO);
            $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o representante!', Mensagem::TIPO_INFO);
            echo $oMsg2->getRender();
            echo 'requestAjax("","QualRncVenda","enviaEmailDev","' . $sDados . ',' . $sParam . '");';
            echo"$('#" . $aDados[2] . "-btn').click();";
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Devolução', 'Erro ao tentar inserir a observação da devolução.', Modal::TIPO_ERRO);
        }
        echo $oMensagem->getRender();
    }

    public function recusaDevolucao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->recusaDevolucao($aCamposChave);

        $sParam = 'Recusada';

        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Devolução', 'Devolução recusada pela Metalbo', Modal::TIPO_SUCESSO);
            $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o representante!', Mensagem::TIPO_INFO);
            echo $oMsg2->getRender();
            echo 'requestAjax("","QualRncVenda","enviaEmailDev","' . $sDados . ',' . $sParam . '");';
            echo"$('#" . $aDados[2] . "-btn').click();";
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Devolução', 'Erro ao tentar inserir a observação da devolução.', Modal::TIPO_ERRO);
        }
        echo $oMensagem->getRender();
    }

    public function enviaEmailDev($sDados) {
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
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ''));

        if ($aDados[4] == 'Aceitar') {
            $sCor = 'red';
        } else {
            $sCor = 'green';
        }


        $oEmail->setMensagem(utf8_decode('A devolução de Nº ' . $oRow->nr . ' foi <strong><span style="color:' . $sCor . '">' . $oRow->devolucao . '</span></strong> pela Metalbo.<hr><br/>'
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
                        . '<tr><td><b>Valor: R$</b></td><td> ' . $oRow->valor . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . $oRow->peso . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
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
    }

}
