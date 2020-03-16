<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualAq extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualAq');
        $this->setControllerDetalhe('QualContencao');
        $this->setSMetodoDetalhe('criaPainelContencao');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getEmpRex()->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getEmpRex()->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        return $aRetorno;
    }

    public function msgFechaAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bEf = $this->Persistencia->verifEfi($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        if ($bEf) {
            $oMensagem = new Modal('Fechamento de ação', 'Fechar a ação da qualidade nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","fechaAq","' . $sDados . '");');
            echo $oMensagem->getRender();
        } else {
            $oMsgEf = new Modal('Atenção', 'Esta ação da qualidade não tem nenhuma avaliação da eficácia apontada, '
                    . 'insira uma avaliação da eficácia antes de finalizar', Modal::TIPO_ERRO, false, true, true);
            echo $oMsgEf->getRender();
        }
    }

    public function fechaAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->fechaAq($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem = new Modal('Sucesso', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' finalizada com sucesso', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' não foi finalizada', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function msgAbreAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();



        $oMensagem = new Modal('Reabertura da ação', 'Deseja reabrir a ação nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","reabreAq","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    public function reabreAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oRetSit = $this->Persistencia->buscaDadosAq($aCamposChave);

        if ($oRetSit->sit == 'Cancelada') {
            $oMensagem = new Modal('Atenção!', 'Ação Nº' . $oRetSit->nr . ' não pode ser reaberta por estar CANCELADA.', Modal::TIPO_ERRO, false, true, true);
        }
        if ($oRetSit->sit == 'Aberta') {
            $oMensagem = new Modal('Atenção!', 'Ação Nº' . $oRetSit->nr . ' já está ABERTA.', Modal::TIPO_ERRO, false, true, true);
        } else {
            $aRetorno = $this->Persistencia->reabreAq($aCamposChave);
            if ($aRetorno[0]) {
                $oMensagem = new Modal('Sucesso', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' foi reaberta com sucesso', Modal::TIPO_SUCESSO, false, true, true);
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Modal('Atenção', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' não foi reaberta', Modal::TIPO_ERRO, false, true, true);
            }
        }
        echo $oMensagem->getRender();
    }

    public function startAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oRetSit = $this->Persistencia->buscaDadosAq($aCamposChave);

        if ($oRetSit->sit == 'Cancelada' || $oRetSit->sit == 'Finalizada') {
            $oMensagem = new Modal('Atenção!', 'Ação Nº' . $oRetSit->nr . ' não pode ser Iniciada por estar FINALIZADA ou CANCELADA. Reabra a ação para iniciar!', Modal::TIPO_ERRO, false, true, true);
        }
        if ($oRetSit->sit == 'Aberta') {
            $aRetorno = $this->Persistencia->startAq($aCamposChave);
            if ($aRetorno[0]) {
                $oMensagem = new Modal('Sucesso', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' foi iniciada', Modal::TIPO_SUCESSO, false, true, true);
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMensagem = new Modal('Atenção', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' não foi iniciada', Modal::TIPO_ERRO, false, true, true);
            }
        } else {
            if ($oRetSit->sit == 'Iniciada') {
                $oMensagem = new Modal('Atenção!', 'Ação Nº' . $oRetSit->nr . ' já está iniciada!', Modal::TIPO_AVISO, false, true, true);
            }
        }


        echo $oMensagem->getRender();
    }

    public function envMailQual($sDados, $sRel) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aNr = explode('=', $aDados[2]);


        // sleep(5);

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

        $oEmail->setAssunto(utf8_decode('Ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0]));
        $oEmail->setMensagem(utf8_decode('Anexo ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0] . ' da qual você está envolvido. '
                        . ' Verifique a ação em anexo para ficar por dentro dos detalhes!'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        // Cópia
        //  $aCopia = array();
        //  $aCopia[] = 'avaneim@gmail.com';
        //  $aCopia[] = 'avanei@rexmaquinas.com.br';

        foreach ($aCopia as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        $oEmail->addAnexo('app/relatorio/qualidade/Aq' . $aDados[1] . '_empresa_' . $aDados[0] . '.pdf', utf8_decode('Aq nº' . $aDados[1] . '_empresa_' . $aDados[0] . '.pdf'));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function envMailGrid($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        echo 'requestAjax("","QualAqPlan","geraRelPdfAq","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . ',AqImp");';
        echo'requestAjax("","QualAq","envMailAll","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . '");';
    }

    public function envMailGrid2($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        echo 'requestAjax("","QualAqPlan","geraRelPdfAq","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . ',AqImp");';
        echo'requestAjax("","QualAq","envMailQual","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . '");';
    }

    public function envMailMsg($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aNr = explode('=', $aDados[2]);

        $oMensagem = new Modal('Email', 'Deseja enviar e-mail para todos os envolvidos nessa ação da qualidade?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualAq","envMailAll","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function envMailAll($sDados, $sRel) {
        $aDados = explode(',', $sDados);

        //emails planos da acao 
        $aUserPlano = $this->Persistencia->emailPlan($aDados);


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

        $oEmail->setAssunto(utf8_decode('Ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0]));
        $oEmail->setMensagem(utf8_decode('Anexo ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0] . ' da qual você está envolvido. '
                        . ' Verifique a ação em anexo para ficar por dentro dos detalhes!'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        $oEmail->addAnexo('app/relatorio/qualidade/Aq' . $aDados[1] . '_empresa_' . $aDados[0] . '.pdf', utf8_decode('Aq nº' . $aDados[1] . '_empresa_' . $aDados[0] . '.pdf'));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);

        $sEmpresa = $_SESSION['filcgc'];

        $aTotal = $this->Persistencia->somaSit($sEmpresa);

        $sResulta = '<div class="cor_verde">Total de ações abertas:' . $aTotal['Aberta'] . '</div>'
                . '<div class="cor_azul">Total de ações iniciadas:' . $aTotal['Iniciada'] . '</div>'
                . 'Total de ações finalizadas:' . $aTotal['Finalizada'] . ''
                . '<div id="titulolinhatempo">'
                . '<h3 class="panel-title">Linha do Tempo da AQ</h3></br>'
                . '</div>'
                . '<div class="pearls pearls-xs row" id="qualaqtempo">'
                . '</div>';

        return $sResulta;
    }

    /**
     * Gerencia estilo de cores do wizard conforme status do projeto
     * */
    public function renderTempo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aDados[0] == '') {
            echo '$("#qualaqtempo").empty();';
            echo '$("#titulolinhatempo").empty();';
        } else {
            $aRetorno = $this->Persistencia->verifSituacoes($aCamposChave);

            if ($aRetorno['sit'] == 'Iniciada') {
                $sCurrentAq = 'current';
                $sEstiloAq = 'border-color:blue;color:blue';
            }
            if ($aRetorno['sit'] == 'Aberta' && $aRetorno['problema'] == false && $aRetorno['objetivo'] == false) {
                $sCurrentAq = 'current';
                $sEstiloAq = 'border-color:orange;color:orange;';
            }
            if ($aRetorno['sit'] == 'Aberta' && $aRetorno['problema'] == true && $aRetorno['objetivo'] == true) {
                $sCurrentAq = 'current';
                $sEstiloAq = 'border-color:green;color:green';
            }
            if ($aRetorno['sit'] == 'Finalizada' || $aRetorno['sit'] == 'Cancelada') {
                $sCurrentAq = 'current';
                $sEstiloAq = 'border-color:black;color:black';
            }
            //Contenção
            if ($aRetorno['contencao'] == false && $aRetorno['tipoacao'] == 'Ação Corretiva') {
                $sCurrentCont = 'current';
                $sEstiloCont = 'border-color:orange;color:orange';
                $sContencao = 'Apontamento Pendente';
            }
            if ($aRetorno['contencao'] == true || $aRetorno['tipoacao'] == 'Ação Preventiva') {
                $sCurrentCont = 'current';
                $sEstiloCont = 'border-color:green;color:green';
                $sContencao = 'Ação Preventiva ou Finalizadas';
            }
            //Correção
            if ($aRetorno['correcao'] == false && $aRetorno['tipoacao'] == 'Ação Corretiva') {
                $sCurrentCorr = 'current';
                $sEstiloCorr = 'border-color:orange;color:orange';
                $sCorrecao = 'Apontamento Pendente';
            }
            if ($aRetorno['correcao'] == true || $aRetorno['tipoacao'] == 'Ação Preventiva') {
                $sCurrentCorr = 'current';
                $sEstiloCorr = 'border-color:green;color:green';
                $sCorrecao = 'Ação Preventiva ou Finalizadas';
            }
            //Causa
            if ($aRetorno['causa'] == false) {
                $sCurrentCausa = 'current';
                $sEstiloCausa = 'border-color:orange;color:orange';
                $sCausa = 'Causas vazias';
            }
            if ($aRetorno['causa'] == true) {
                $sCurrentCausa = 'current';
                $sEstiloCausa = 'border-color:green;color:green';
                $sCausa = 'Ao menos uma causa apontada';
            }
            //Plano
            if ($aRetorno['plano'] == true) {
                $sCurrentPlano = 'current';
                $sEstiloPlano = 'border-color:green;color:green';
                $sPlano = 'Finalizados';
            }
            if ($aRetorno['plano'] == false) {
                $sCurrentPlano = 'current';
                $sEstiloPlano = 'border-color:orange;color:orange';
                $sPlano = 'Apontamento Pendente';
            }
            //Eficácia
            if ($aRetorno['eficaz'] == false) {
                $sCurrentEficaz = 'current';
                $sEstiloEficaz = 'border-color:orange;color:orange';
                $sEficaz = 'Apontamento Pendente';
            }
            if ($aRetorno['eficaz'] == true) {
                $sCurrentEficaz = 'current';
                $sEstiloEficaz = 'border-color:green;color:green';
                $sEficaz = 'Finalizado';
            }



            $sLinha = //posição 1 AQ
                    '<div id="0" class="pearl ' . $sCurrentAq . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloAq . '">'
                    . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Situação da AQ: ' . $aRetorno['sit'] . '</span>'
                    . '</div>'
                    //posição 2 Contenção
                    . '<div id="1" class="pearl ' . $sCurrentCont . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloCont . '">'
                    . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Ação de Contenção: ' . $sContencao . '</span>'
                    . '</div>'
                    //posição 3 Correção
                    . '<div id="2" class="pearl ' . $sCurrentCorr . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloCorr . '">'
                    . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Ação de Correção: ' . $sCorrecao . '</span>'
                    . '</div>'
                    //posição 4 Causa
                    . '<div id="3" class="pearl ' . $sCurrentCausa . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloCausa . '">'
                    . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Causa(s): ' . $sCausa . '</span>'
                    . '</div>'
                    //posição 5 Plano de ação
                    . '<div id="4" class="pearl ' . $sCurrentPlano . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloPlano . '">'
                    . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Plano(s) de Ação: ' . $sPlano . ' </span>'
                    . '</div>'
                    //posição 6 Eficáz
                    . '<div id="5" class="pearl ' . $sCurrentEficaz . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloEficaz . '">'
                    . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Eficácia: ' . $sEficaz . '</span>'
                    . '</div>';

            $sRender = '$("#qualaqtempo").empty();';
            $sRender .= '$("#qualaqtempo").append(\'' . $sLinha . '\');';
            echo $sRender;
            //coloca o titulo
            echo '$("#titulolinhatempo").empty();';
            $sTitulo = '<h3 class="panel-title">Linha do Tempo AQ Nº ' . $aCamposChave['nr'] . '</h3></br>';
            echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';
        }
    }

    public function getUserEmail($sDados) {
        $aDados = explode(',', $sDados);

        $aRetorno = $this->Persistencia->getUserEmail($aDados[0]);

        //Nomes
        $sNome = 'var valor =$("#' . $aDados[1] . '").val();'
                . 'if (valor !== ""){'
                . '$("#' . $aDados[1] . '").val(valor+",' . $aRetorno[0] . '");'
                . '}else{'
                . '$("#' . $aDados[1] . '").val(valor+"' . $aRetorno[0] . '");'
                . '}  ';
        echo $sNome;
        //E-mail
        $sEmail = '$("#' . $aDados[2] . '_tag").val("' . $aRetorno[1] . '").focus();'
                . '$("#' . $aDados[3] . '").focus();'
                . '$("#' . $aDados[3] . '").focus();';
        echo $sEmail;
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        $oSit = $this->Model->getSit();

        if ($oSit == 'Finalizada' || $oSit == 'Cancelada') {
            $oMensagem = new Modal('Atenção!', 'Ação Nº' . $this->Model->getNr() . ' não pode ser alterada por estar FINALIZADA ou CANCELADA!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
    }

    public function criaModalCancelaAq($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $oDados = $this->Persistencia->buscaDadosAq($aCamposChave);

        if ($oDados->sit == 'Iniciada' || $oDados->sit == 'Aberta') {
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaTelaModalCancelaAq($aCamposChave['id']);

            //adiciona onde será renderizado
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            if ($oDados->sit == 'Cancelada') {
                $oMensagem = new Modal('Atenção!', 'Ação Nº' . $oDados->nr . ' já está CANCELADA!', Modal::TIPO_ERRO, false, true, true);
                echo "$('#" . $aDados[1] . "-btn').click();";
            }
            if ($oDados->sit == 'Finalizada') {
                $oMensagem = new Modal('Atenção!', 'Ação Nº' . $oDados->nr . ' não pode ser CANCELADA por estar FINALIZADA!', Modal::TIPO_ERRO, false, true, true);
            }
            echo $oMensagem->getRender();
        }
    }

    public function cancelaAq($sDados) {
        $aDados = explode(',', $sDados);

        $aRetorno = $this->Persistencia->cancelaAq();

        if ($aRetorno == true) {
            $oMensagem = new Mensagem('Cancelada', 'Ação Nº' . $this->Model->getNr() . ' foi cancelada com sucesso!', Mensagem::TIPO_SUCESSO);
            echo "$('#" . $aDados[1] . "-btn').click();";
        } else {
            $oMensagem = new Mensagem('Atenção!', 'Erro ao cancelar Ação Nº' . $this->Model->getNr() . ', a ação não foi cancelada!', Mensagem::TIPO_WARNING);
        }
        echo $oMensagem->getRender();
    }

    public function geraPdfQualAq($sDados) {
        $aDados = explode(',', $sDados);
        $sAq[] = $aDados[3];
        $sChave = htmlspecialchars_decode($sAq[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $_REQUEST['filcgcAq'] = $aCamposChave['EmpRex_filcgc'];
        $_REQUEST['nrAq'] = $aCamposChave['nr'];
        $_REQUEST['email'] = 'S';
        $_REQUEST['userRel'] = $_SESSION['nome'];

        require 'app/relatorio/AqImp.php';
    }

    public function envMailTodosMsg($sDados) {
        $oMensagem = new Modal('Email', 'Deseja enviar e-mail para todos os envolvidos nessa ação da qualidade?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualAq","geraPdfQualAqTodos","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function geraPdfQualAqTodos($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[2] == 'concluir') {
            $_REQUEST['filcgcAq'] = $aDados[0];
            $_REQUEST['nrAq'] = $aDados[1];
            $_REQUEST['email'] = 'S';
            $_REQUEST['userRel'] = $_SESSION['nome'];
            $_REQUEST['todos'] = 'S';
        } else {
            $sAq[] = $aDados[3];
            $sChave = htmlspecialchars_decode($sAq[0]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);

            $_REQUEST['filcgcAq'] = $aCamposChave['EmpRex_filcgc'];
            $_REQUEST['nrAq'] = $aCamposChave['nr'];
            $_REQUEST['email'] = 'S';
            $_REQUEST['userRel'] = $_SESSION['nome'];
            $_REQUEST['todos'] = 'S';
        }


        require 'app/relatorio/AqImp.php';
    }

    public function relAcaoQualidade($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relAcaoQualidade');
    }

    public function notificaAQ() {
        $aRetorno = $this->Persistencia->buscaDataAq();

        if (count($aRetorno) > 0) {
            $iDias = 0;
            foreach ($aRetorno as $iKey => $oValue) {
                $iDias = $oValue->dias;
                if ($iDias >= -7) {
                    $this->envEmailAq($oValue);
                }
            }
        }
        return $aRetorno;
    }

    public function envEmailAq($oValue) {

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


        $aEmail = $this->Persistencia->buscaEmailPlanoAcao($oValue);

        $oEmail->addDestinatario($aEmail[0]);

        //$oEmail->addDestinatario('alexandre@metalbo.com.br');


        $oEmail->setAssunto(utf8_decode('Plano de Ação Seq. ' . $oValue->seq . ' da Ação nº' . $oValue->nr . ''));
        $oEmail->setMensagem(utf8_decode('PLANO DE AÇÃO Nº ' . $oValue->seq . ' ESTÁ PRESTES A EXPIRAR <hr><br/>'
                        . '<p style="margin:20px;color:red;font-weight:900;font-size:25px;">Tempo para expirar o plano de ação está menor que 7 DIAS!</p>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Responsável pelo plano de ação:</b></td><td>' . $oValue->usunome . '</td></tr>'
                        . '<tr><td><b>Data prevista:</b></td><td> ' . $oValue->data . '</td></tr>'
                        . '<tr><td><b>Empesa:</b></td><td>' . $oValue->filcgc . '</td></tr>'
                        . '</table><br/><br/><hr>'
                        . '<br/><b style="margin:40px;color:blue">E-mail enviado automaticamente, favor não responder!</b>'
                        . '<br/><b style="margin:40px;color:red">Você continuará recebendo e-mails até o plano de ação ser finalizado!</b>'));

        $aRetorno = $oEmail->sendEmail();
        return;
    }

}
