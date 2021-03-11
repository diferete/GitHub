<?php

/*
 * Classe controller QualNovoProjRep
 * 
 * @autor Avanei Martendal
 * @since 26/07/2017
 */

class ControllerQualNovoProjRep extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualNovoProjRep');
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $sDescProd = $this->Model->getDesc_novo_prod();
        if (preg_match('/[\'^£$%&*()}{@#~?><>|=_¬¨]/', $sDescProd)) {

            $oMsg = new Mensagem('Atenção', 'Caractere inválido detectado na descrição. Favor verificar.', Mensagem::TIPO_WARNING, '70000');
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $quant = $this->Model->getQuant_pc();
            if ($quant == '0' || $quant == '0,00') {

                $oMsg = new Mensagem('Atenção', 'Quantidade não pode ser 0!', Mensagem::TIPO_WARNING, '70000');
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            } else {
                $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));

                $aRetorno = array();
                $aRetorno[0] = true;
                $aRetorno[1] = '';
                return $aRetorno;
            }
            $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));

            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $sDescProd = $this->Model->getDesc_novo_prod();
        if (preg_match('/[\'^£$%&*()}{@#~?><>|=_¬¨]/', $sDescProd)) {

            $oMsg = new Mensagem('Atenção', 'Caractere inválido detectado na descrição. Favor verificar.', Mensagem::TIPO_WARNING, '70000');
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $quant = $this->Model->getQuant_pc();
            if ($quant == '0' || $quant = '0,00') {

                $oMsg = new Mensagem('Atenção', 'Quantidade não pode ser 0!', Mensagem::TIPO_WARNING, '70000');
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            } else {
                $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));

                $aRetorno = array();
                $aRetorno[0] = true;
                $aRetorno[1] = '';
                return $aRetorno;
            }
            $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));

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

        if ($this->Model->getSitgeralproj() != 'Representante') {
            $aOrdem = explode('=', $sChave);
            $oMensagem = new Modal('Atenção!', 'A entrada de projeto nº ' . $this->Model->getNr() . ' não pode ser modificada somente visualizada!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
            //exit();
        }

        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);
    }

    //mensagem para liberar para a metalbo
    public function msLiberaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bSit = $this->Persistencia->verifLibProj($aCamposChave);


        if ($bSit == true) {
            $oMensagem = new Modal('Liberação para projetos', 'Deseja liberar a entrada de projeto nº' . $aCamposChave['nr'] . ' para o setor de projetos?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaProj","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Atenção', 'A entrada de projeto nº ' . $aCamposChave['nr'] . ' já está liberado para o setor de projetos da Metalbo!', Modal::TIPO_AVISO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    //efetua a liberação para a metalbo
    public function liberaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bExecuta = $this->Persistencia->liberaProj($aCamposChave);

        if ($bExecuta) {
            $oMensagem = new Mensagem('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' foi liberado com sucesso para o setor de projetos da Metalbo!', Modal::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $this->EnvProjMetalbo($sChave);
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' não foi liberado!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        }
    }

    //reenvia email liberaçao do representante
    public function ReenvProjMetalbo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bSit = $this->Persistencia->verifLibRepProj($aCamposChave);

        if ($bSit == true) {
            $this->EnvProjMetalbo($sChave);
        } else {
            $oMensagem = new Modal('Atenção', 'A entrada de projeto nº ' . $aCamposChave['nr'] . ' ainda não foi liberado!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    //envia email para vendas pe para o próprio representante
    public function EnvProjMetalbo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();




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

        $oDadosProj = $this->Persistencia->buscaDadosEmail($aCamposChave);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº' . $oDadosProj->nr . ''));
        $oEmail->setMensagem(utf8_decode('PROJETO Nº ' . $oDadosProj->nr . ' FOI LIBERADO PELO REPRESENTANTE ' . $oDadosProj->officedes . '<hr><br/>'
                        . '<b>Descrição:</b> ' . $oDadosProj->desc_novo_prod . '<br/>'
                        . '<b>Acabamento:</b> ' . $oDadosProj->acabamento . '<br/>'
                        . '<b>Quant.Cnt/Mês:</b> ' . number_format($oDadosProj->quant_pc, 2, ',', '.') . '<br />' //.number_format($oAprov->quant_pc, 2, ',', '.').
                        . '<b>Data Implantação:  ' . $oDadosProj->dtimp . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Cnpj:</b></td><td>' . $oDadosProj->empcod . '</td></tr>'
                        . '<tr><td><b>Cliente:</b></td><td>' . $oDadosProj->empdes . '</td></tr>'
                        . '<tr><td><b>Escritório:</b></td><td>' . $oDadosProj->officedes . '</td></tr>'
                        . '<tr><td><b>Representante:</b></td><td>' . $oDadosProj->repnome . '</td></tr> '
                        . '<tr><td><b>Resp. Vendas:</b></td><td>' . $oDadosProj->resp_venda_nome . '</td></tr> '
                        . '<tr><td><b>Observação:</b></td><td>' . $oDadosProj->replibobs . '</td></tr> '
                        . '</table><br/><br/> '
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //enviar e-mail projetos
        $aUserPlano = $this->Persistencia->buscaEmailProjeto2($aCamposChave);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }


        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalProposta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $oProposta = $this->Persistencia->buscaProposta($aCamposChave);
        $this->View->setAParametrosExtras($oProposta);

        $this->View->criaModalProposta();

        //adiciona onde será renderizado
        $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
        echo $sLimpa;
        $this->View->getTela()->setSRender($aDados[1] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    /**
     * Tela de mensagem para o envio da proposta
     * @param type $sDados
     */
    public function msgEnvProp($sDados) {
        $aDados = explode(',', $sDados);

        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        //pega os campos do parametro
        //vai montar id de mais de uma linha selecionada
        if (isset($_REQUEST['parametrosCampos'])) {
            $aParam = $_REQUEST['parametrosCampos'];
            foreach ($aParam as $key => $value) {
                $aChaves[] = htmlspecialchars_decode($value);
            }
            foreach ($aChaves as $key => $value) {
                $sChaveP = $value;
                $aCamposChaveP = array();
                parse_str($sChaveP, $aCamposChaveP);
                $sChaveParam .= $aCamposChaveP['nr'] . ',';
            }
            $sChaveParam = substr($sChaveParam, 0, -1);
        }

        $sDadosParam .= implode(',', $aChaves);
        $aDadosParam = explode(',', $sChaveParam);

        $bEnvia = true;
        foreach ($aDadosParam as $key => $value) {
            $aCamposChave['nr'] = $value;
            $oEnvia = $this->Persistencia->verifSit($aCamposChave);
            if ($oEnvia->sitgeralproj == 'Expirado' || $oEnvia->sitgeralproj == 'Expirado') {
                break;
            }
        }


        if ($oEnvia->sitproj == 'Aprovado' && $oEnvia->sitvendas == 'Aprovado' && $oEnvia->sitcliente == 'Aguardando') {
            $oMensagem = new Modal('Proposta', 'Deseja enviar a proposta do projeto(s) n(s)º ' . $sChaveParam . ' para o seu e-mail?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EnvProp","' . $sDados . '","' . $sChaveParam . '");');
        } if ($oEnvia->sitgeralproj == 'Reprovado') {
            $oMensagem = new Modal('Prosposta', 'Entrada de projetos foi reprovada e não pode ser encaminhada.', Modal::TIPO_ERRO, false, true, true);
        }if ($oEnvia->sitgeralproj == 'Expirado') {
            $oMensagem = new Modal('Prosposta', 'Entrada de projetos foi expirada pelo sistema e não pode ser encaminhada.', Modal::TIPO_ERRO, false, true, true);
        }


        echo $oMensagem->getRender();
    }

    /**
     * Envia e-mail com a proposta
     * @param type $sDados
     */
    public function EnvProp($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        if (isset($_REQUEST['parametrosCampos'])) {
            $aParam = $_REQUEST['parametrosCampos'];
            foreach ($aParam as $key => $value) {
                $sParam = $value;
                $aChaves = explode('|', $value);
            }
        }
        //aplica foreach para mudar situaçao 
        foreach ($aChaves as $key => $value) {
            $aCamposChave['nr'] = $value;
            $this->Persistencia->sitenvProposta($aCamposChave);
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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));

        //monta o foreach para envio dos e-mails 
        foreach ($aChaves as $key => $value) {
            $aCamposChave['nr'] = $value;
            $oAprov = $this->Persistencia->buscaProposta($aCamposChave);
            $aObjeto[] = $oAprov;
        }
        //monta o forech
        $oEmail->setAssunto(utf8_decode('Entrada(s) de projeto(s) n(s)º' . $sParam . ''));
        $sEmail = "";
        foreach ($aObjeto as $key => $oObj) {
            $sEmail .= '<span style="background-color:#CFCFCF">SEGUE PROPOSTA DA(S) ENTRADA(S) DE PROJETO Nº ' . $oObj->nr . '</span><br/><br/>'
                    . '<b>Cliente:</b> ' . $oObj->empcod . ' ' . $oObj->empdes . '<br/><br/>'
                    . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                    . '<tr><td><b>Produto:</b></td><td>' . $oObj->desc_novo_prod . '</td></tr>'
                    . '<tr><td><b>Acabamento:</b></td><td> ' . $oAprov->acabamento . '</td></tr>'
                    . '<tr><td><b>Quant.Cnt/Mês:</b></td><td>' . number_format($oObj->quant_pc, 2, ',', '.') . '</td></tr>'
                    . '<tr><td><b>Lote Mínimo:</b></td><td>' . number_format($oObj->lotemin, 2, ',', '.') . '</td></tr>'
                    . '<tr><td><b>Peso:</b></td><td>' . number_format($oObj->pesoct, 2, ',', '.') . '</td></tr>'
                    . '<tr><td><b>Preço:</b></td><td><span style="color:#006400"><b>R$ ' . number_format($oObj->precofinal, 2, ',', '.') . '</b></span></td></tr>'
                    . '<tr><td><b>Prazo:</b></td><td><span style="color:#006400">' . $oObj->prazoentregautil . ' dias úteis a partir da aprovação do cliente</span></td></tr>'
                    . '</table><br/><br/><hr>';
        }


        $sEmail .= '<b style="color:red; font-weight:900;font-size:18px;">SE NÃO APROVADO PELO EM ATÉ 60 DIAS O PROJETO IRÁ EXPIRAR E SERÁ CANCELADO</b>';
        $sEmail .= '<br/><b>E-mail enviado automaticamente, favor não responder!</b>';


        $oEmail->setMensagem(utf8_decode($sEmail));

        $oEmail->limpaDestinatariosAll();

        // Para
        $oEmail->addDestinatario($_SESSION['email']);


        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * Cria a tela Modal para aprovaçào da proposta
     * @param type $sDados
     */
    public function criaTelaModalAprovProp($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $bExecuta = $this->Persistencia->verifAprovRep($aCamposChave);
        $oProposta = $this->Persistencia->buscaProposta($aCamposChave);
        $bExpira = $this->Persistencia->verifExpirado($aCamposChave);
        if ($bExpira) {
            //se false não abre a tela
            if ($bExecuta) {
                //verifica se o projeto já está aprovado
                $bAprov = $this->Persistencia->verifAprovCli($aCamposChave);

                if ($bAprov) {
                    $bReprov = $this->Persistencia->verifReprov($aCamposChave);
                    if ($bReprov) {
                        $this->View->setAParametrosExtras($oProposta);


                        $this->View->criaTelaModalAprovProp($aDados[1]);

                        //adiciona onde será renderizado
                        $this->View->getTela()->setSRender($aDados[1] . '-modal');


                        //renderiza a tela
                        $this->View->getTela()->getRender();
                    } else {
                        $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' está reprovado!', Modal::TIPO_ERRO, false, true, true);
                        echo $oMensagem->getRender();
                        echo "$('#" . $aDados[1] . "-btn').click();";
                    }
                } else {
                    $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' já está aprovado pelo cliente!', Modal::TIPO_ERRO, false, true, true);
                    echo $oMensagem->getRender();
                    echo "$('#" . $aDados[1] . "-btn').click();";
                }
            } else {
                $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' não está em situação para ser aprovado!', Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
                echo "$('#" . $aDados[1] . "-btn').click();";
            }
        } else {
            $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' foi expirado pelo sistema!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            echo "$('#" . $aDados[1] . "-btn').click();";
        }
    }

    /**
     * Cria a tela Modal reprovar projeto pelo cliente
     * @param type $sDados
     */
    public function criaTelaModalReprovProp($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $bLibCad = $this->Persistencia->verifLibCadastro($aCamposChave);
        $bReprov = $this->Persistencia->verifReprov($aCamposChave);
        $bExpira = $this->Persistencia->verifExpirado($aCamposChave);
        if ($bExpira) {
            if ($bLibCad) {
                if ($bReprov) {
                    $oProposta = $this->Persistencia->buscaProposta($aCamposChave);
                    $this->View->setAParametrosExtras($oProposta);

                    $this->View->criaTelaModalReprovProp($aCamposChave['id']);

                    //adiciona onde será renderizado
                    $this->View->getTela()->setSRender($aDados[1] . '-modal');

                    //renderiza a tela
                    $this->View->getTela()->getRender();
                } else {
                    $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' não pode ser reprovado!', Modal::TIPO_ERRO, false, true, true);
                    echo $oMensagem->getRender();
                    echo "$('#" . $aDados[1] . "-btn').click();";
                }
            } else {
                $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' já foi liberado para cadastro!', Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
                echo "$('#" . $aDados[1] . "-btn').click();";
            }
        } else {
            $oMensagem = new Modal('Projeto', 'O projeto ' . $aCamposChave['nr'] . ' foi expirado pelo sistema!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            echo "$('#" . $aDados[1] . "-btn').click();";
        }
    }

    /**
     * Aprova a proposta 
     * @param type $sDados
     */
    public function aprovaPropCli($sDados) {
        $aDados = explode(',', $sDados);
        $sClasse = $this->getNomeClasse();
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $sCampos = $aCampos['EmpRex_filcgc'] . ',' . $aCampos['nr'];

        $aRetorno = $this->Persistencia->aprovCli($aCampos['EmpRex_filcgc'], $aCampos['nr'], $aCampos['obsaprovcli']);
        if ($aRetorno[0]) {
            echo'$("#' . $aDados[1] . '-btn").click();';
            $oMsg = new Mensagem('Aprovado com sucesso', 'Projeto nº' . $aCampos['nr'] . ' foi aprovado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo 'requestAjax("","' . $sClasse . '","mensEmailAprov","' . $sCampos . '");';
        } else {
            $oMsg = new Mensagem('Erro no apontamento', 'Projeto não aprovado com sucesso!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
    }

    /**
     * mostra mensagem
     */
    public function mensEmailAprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('E-mail', 'Deseja notificar projetos sobre a aprovação da proposta?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EnvSolCadastro","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    /**
     * Envia e-mail solicitando o cadastro
     * @param type $sDados
     */
    public function EnvSolCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sClasse = $this->getNomeClasse();
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $sCampos = $aCampos['filcgc'] . ',' . $aCampos['nr'];

        $aDadosP['EmpRex_filcgc'] = $aDados[0];
        $aDadosP['nr'] = $aDados[1];


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

        $oAprov = $this->Persistencia->buscaProposta($aDadosP);

        $oEmail->setAssunto(utf8_decode('ATENÇÃO - Solicitação de cadastro da entrada de projeto nº' . $oAprov->nr . ''));
        $oEmail->setMensagem(utf8_decode('ATENÇÃO SOLICITAÇÃO DE CADASTRO DO PROJETO Nº ' . $oAprov->nr . '.<hr><br/>'
                        . '<b>Cliente:</b> ' . $oAprov->empcod . ' ' . $oAprov->empdes . '<br/>'
                        . '<b>Data da Aprovação:</b>' . $oAprov->dtaprovcli . '<br/><br/><br/>'
                        . '<b>Hora da Aprovação:</b>' . $oAprov->horaprovcli . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Produto:</b></td><td>' . $oAprov->desc_novo_prod . '</td></tr>'
                        . '<tr><td><b>Acabamento:</b></td><td> ' . $oAprov->acabamento . '</td></tr>'
                        . '<tr><td><b>Quant.Cnt/Mês:</b></td><td>' . number_format($oAprov->quant_pc, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Lote Mínimo:</b></td><td>' . number_format($oAprov->lotemin, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Peso:</b></td><td>' . number_format($oAprov->pesoct, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Preço:</b></td><td><span style="color:#006400"><b>R$ ' . number_format($oAprov->precofinal, 2, ',', '.') . '</b></span></td></tr>'
                        . '<tr><td><b>Prazo:</b></td><td><span style="color:#006400">' . $oAprov->prazoentregautil . ' dias úteis a partir da aprovação do cliente</span></td></tr>'
                        . '</table><br/><br/><br/>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'
        ));

        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //nao enviar e-mail para vendas no momento
        $aUserPlano = $this->Persistencia->buscaEmailProjeto($aDados);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function reprovarProposta($sDados) {
        $aDados = explode(',', $sDados);
        $sClasse = $this->getNomeClasse();
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $sCampos = $aCampos['filcgc'] . ',' . $aCampos['nr'];

        $aRetorno = $this->Persistencia->reprovCli($aCampos['EmpRex_filcgc'], $aCampos['nr'], $aCampos['obsreprov']);
        if ($aRetorno[0]) {
            echo'$("#' . $aDados[1] . '-btn").click();';
            $oMsg = new Mensagem('Reprovado com sucesso', 'Projeto nº' . $aCampos['nr'] . ' foi reprovado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            // $this->EnvSolCadastro($aCampos);
        } else {
            $oMsg = new Mensagem('Erro no apontamento', 'Projeto não aprovado com sucesso!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
    }

    /**
     * Retorna cliente
     */
    public function msgRetCli($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aExecuta = $this->Persistencia->verifAprovVendaProj($aCamposChave);

        if ($aExecuta[0]) {
            $bExecuta2 = $this->Persistencia->veriAprovCli($aCamposChave);
            if ($bExecuta2) {
                $oMensagem = new Modal('Retornar', 'Deseja retornar a situação do cliente?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","retCli","' . $sDados . '");');
            } else {
                $oMensagem = new Modal('Atenção', 'Este projeto está aprovado pelo cliente, não é possível retornar a situação!', Modal::TIPO_ERRO, false, true, true);
            }
        } else {
            $oMensagem = new Modal('Atenção', 'Este projeto precisa estar aprovado por vendas e por projetos para fazer o retorno da situação!', Modal::TIPO_ERRO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    /**
     * Retorna cliente se não estiver aprojado
     */
    public function retCli($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetona = $this->Persistencia->retornaAprovCli($aCamposChave);

        if ($aRetona) {
            $oMsg = new Mensagem('Retornado com sucesso', 'Projeto foi retornado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'Este projeto precisa estar aprovado por vendas e por projetos para fazer o retorno da situação!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);


        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";
        echo $sRetorno;
    }

    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);


        $sValorBanco = $this->Model->getQuant_pc();
        $sValorDec = number_format($sValorBanco, 2, ',', '.');
        $this->Model->setQuant_pc($sValorDec);
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $aDados = $this->Persistencia->buscaRespEscritório($sDados);
        $this->View->setAParametrosExtras($aDados);

        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);
    }

    public function getRespVenda($sDados) {
        $aDados = explode(',', $sDados);
        $iString = strlen($aDados[0]);
        if ($iString <= 4) {
            $aRet = $this->Persistencia->buscaRespVenda($aDados[0]);
            echo '$("#' . $aDados[1] . '").val("' . $aRet[0] . '");';
            echo '$("#' . $aDados[2] . '").val("' . $aRet[1] . '");';
            exit;
        } else {
            $oMsg = new Mensagem('Erro', 'Código de representante inválido! Se seu código não aparecer para seleção, notifique o TI da Metalbo ', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();
            exit;
        }
    }

}
