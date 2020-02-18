<?php

/*
 * Implementa a controller da classe QualNovoProjVenda
 * 
 * @author Avanei Martendal
 * @since 09/08/2017
 */

class ControllerQualNovoProjVenda extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualNovoProjVenda');
    }

    /**
     * Corrige valores para moeda
     * @return string
     */
    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setVlrFerramen($this->ValorSql($this->Model->getVlrFerramen()));
        $this->Model->setVlrDesenProj($this->ValorSql($this->Model->getVlrDesenProj()));
        $this->Model->setVlrMatPrima($this->ValorSql($this->Model->getVlrMatPrima()));
        $this->Model->setVlrAcabSuper($this->ValorSql($this->Model->getVlrAcabSuper()));
        $this->Model->setVlrTratTer($this->ValorSql($this->Model->getVlrTratTer()));
        $this->Model->setVlrCustProd($this->ValorSql($this->Model->getVlrCustProd()));
        $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));
        $this->Model->setLotemin($this->ValorSql($this->Model->getLotemin()));
        $this->Model->setPesoct($this->ValorSql($this->Model->getPesoct()));
        $this->Model->setPrecofinal($this->ValorSql($this->Model->getPrecofinal()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Corrige valores para moeda
     * @return string
     */
    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setVlrFerramen($this->ValorSql($this->Model->getVlrFerramen()));
        $this->Model->setVlrDesenProj($this->ValorSql($this->Model->getVlrDesenProj()));
        $this->Model->setVlrMatPrima($this->ValorSql($this->Model->getVlrMatPrima()));
        $this->Model->setVlrAcabSuper($this->ValorSql($this->Model->getVlrAcabSuper()));
        $this->Model->setVlrTratTer($this->ValorSql($this->Model->getVlrTratTer()));
        $this->Model->setVlrCustProd($this->ValorSql($this->Model->getVlrCustProd()));
        $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));
        $this->Model->setLotemin($this->ValorSql($this->Model->getLotemin()));
        $this->Model->setPesoct($this->ValorSql($this->Model->getPesoct()));
        $this->Model->setPrecofinal($this->ValorSql($this->Model->getPrecofinal()));


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Gera uma mensagem de aprovação para liberar a solicitação
     * @param type $sDados monta chave primária
     */
    public function msgAprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $bSit = $this->Persistencia->verifSituacao($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        if ($bSit) {
            $bComercial = $this->Persistencia->verifInfCom($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);
            if ($bComercial) {
                $oMensagem = new Modal('Aprovar projeto', 'Deseja liberar o projeto nº ' . $aCamposChave['nr'] . ' para o representante?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","aprovaProj","' . $sDados . '");');
            } else {
                $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' não está com as definições comerciais informadas, preço e prazo de entrega!', Modal::TIPO_ERRO, false, true, true);
            }
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' não pode ser liberado para representante!', Modal::TIPO_ERRO, false, true, true);
        }


        echo $oMensagem->getRender();
    }

    /**
     * Aprova a entrada de projeto
     * @param type $sDados monta a chave primária
     */
    public function aprovaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->aprovaVendaProj($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Mensagem('Atenção', 'O projeto nº ' . $aRetorno[1] . ' foi encaminhado para o representante', Modal::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $this->EnvAprov($sDados);
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' não foi liberado', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function reenviaAprovaVenda($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();



        $aRetorno = $this->Persistencia->verifProjProjVenda($aCamposChave);

        if ($aRetorno == false) {
            $oMensagem = new Modal('Atenção', 'O projeto está Reprovado, o reenvio do e-mail de Aprovação foi cancelado.', Modal::TIPO_AVISO, false, true, true);
        } else {
            $oMensagem = new Mensagem('Aguarde!', 'Seu e-mail está sendo gerado e enviado', Mensagem::TIPO_INFO);
            echo'requestAjax("","' . $sClasse . '","EnvAprov","' . $sDados . '");';
        }
        echo $oMensagem->getRender();
    }

    /**
     * Envia um e-mail para o representante que foi aprovado a entrada de projeto
     * @param type $sDados monta a chave primária
     */
    public function EnvAprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
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

        $oAprov = $this->Persistencia->buscaDadosEmailRep($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);
        $aObs = $this->Persistencia->buscaObs($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº ' . $aCamposChave['nr'] . ''));
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#006400"><b>APROVADO</b></span> PELO SETOR DE VENDAS.<hr><br/>'
                        . '<b>Cliente:</b> ' . $oAprov->empcod . '  ' . $oAprov->empdes . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Produto:</b></td><td>' . $oAprov->desc_novo_prod . '</td></tr>'
                        . '<tr><td><b>Acabamento:</b></td><td>' . $oAprov->acabamento . '</td></tr>'
                        . '<tr><td><b>Quant.Cnt/Mês:</b></td><td>' . number_format($oAprov->quant_pc, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Lote Mínimo:</b></td><td>' . number_format($oAprov->lotemin, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Peso:</b></td><td>' . number_format($oAprov->pesoct, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Preço:</b></td><td><span style="color:#006400">' . number_format($oAprov->precofinal, 2, ',', '.') . '</span></td></tr>'
                        . '<tr><td><b>Prazo:</b></td><td><span style="color:#006400">' . $oAprov->prazoentregautil . ' dias úteis a partir da aprovação do cliente</span></td></tr>'
                        . '<tr><td><b>Observação vendas/Motivo reprovação:</b></td><td>' . $aObs['Financeiro'] . '</td></tr>'
                        . '</table><br/><br/>'
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
                        . '<br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //na o enviar e-mail para vendas no momento
        $aUserPlano = $this->Persistencia->emailRep($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->addDestinatarioCopia($aUserPlano['rep']);


        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente no botão de E-mails, caso o problema persista, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /*
     * mensagem de retorno para o projetos
     */

    public function msgRetProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bSit = $this->Persistencia->verifSituacao2($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        if ($bSit) {

            $oMensagem = new Modal('Retornar para projetos', 'Deseja retornar o projeto nº ' . $aCamposChave['nr'] . ' para o projetos? --ATENÇÃO SERÁ RETORNADO TODAS AS SITUAÇÕES!', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("", "' . $sClasse . '", "retProjetos", "' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' não pode ser retornado!', Modal::TIPO_ERRO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    /*
     * retorna para projetos
     */

    public function retProjetos($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRet = $this->Persistencia->retProjetos($aCamposChave);
        if ($aRet[0]) {
            $oMensagem = new Mensagem('Retorno', 'Projeto retornado com sucesso para o setor de projetos!', Mensagem::TIPO_SUCESSO);
            echo'requestAjax("", "' . $sClasse . '", "EnvRetornaProj", "' . $sDados . '");';
            echo"$('#" . $aDados[1] . "-pesq').click();";
        }
        echo $oMensagem->getRender();
    }

    public function reenviaRetornoProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->verifProjRep($aCamposChave);

        if ($aRetorno == true) {
            $oMensagem = new Modal('Atenção!', 'Projeto Aprovado pelo Cliente, o reenvio do e-mail de Retorno foi cancelado.', Modal::TIPO_AVISO, false, true, true);
        } else {
            $oMensagem = new Mensagem('Aguarde', 'Seu e-mail está sendo gerado e enviado', Mensagem::TIPO_INFO);
            echo'requestAjax("","' . $sClasse . '","EnvRetornaProj","' . $sDados . '");';
        }
        echo $oMensagem->getRender();
    }

    public function EnvRetornaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
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

        $oAprov = $this->Persistencia->buscaDadosEmailRep($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);
        $aObs = $this->Persistencia->buscaObs($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº ' . $aCamposChave['nr'] . ''));
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#006400"><b>RETORNADO</b></span> PELO SETOR DE VENDAS.<hr><br/>'
                        . '<b>Cliente:</b> ' . $oAprov->empcod . '  ' . $oAprov->empdes . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Produto:</b></td><td>' . $oAprov->desc_novo_prod . '</td></tr>'
                        . '<tr><td><b>Acabamento:</b></td><td>' . $oAprov->acabamento . '</td></tr>'
                        . '<tr><td><b>Quant.Cnt/Mês:</b></td><td>' . number_format($oAprov->quant_pc, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Lote Mínimo:</b></td><td>' . number_format($oAprov->lotemin, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Observação vendas/Motivo reprovação:</b></td><td>' . $aObs['Financeiro'] . '</td></tr>'
                        . '</table><br/><br/><br/>'
                        . ' < a href = "sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
                        . ' < br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        // Para        
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //na o enviar e-mail para vendas no momento
        $aUserPlano = $this->Persistencia->emailRep($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->addDestinatarioCopia($aUserPlano['proj']);


        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente no botão de E-mails, caso o problema persista, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    //retorna para para aberto
    public function msgReprovaProjVenda($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array(
        );
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bSit = $this->Persistencia->verifSituacao($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        if ($bSit) {
            $oMensagem = new Modal('Reprovar projeto', 'Deseja reprovar o projeto nº ' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","ReprovaProj","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' não pode ser reprovado!', Modal::TIPO_ERRO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    /**
     * reprova projeto
     */
    public function ReprovaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2])

        ;
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->reprovaProj($aCamposChave);
        if ($aRetorno[0] == true) {
            $oMensagem = new Mensagem('Reprovação', 'Reprovado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();

            echo"$('#" . $aDados[1] . "-pesq').click();";
            echo'requestAjax("","' . $sClasse . '","msgEnvReprov","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº ' . $aCamposChave['nr'] . ' foi reprovado', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function msgEnvReprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Enviar reprovação', 'Deseja enviar e-mail de reprovação do projeto nº ' . $aCamposChave['nr'] . ' para os envolvidos?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EnvReprov","' . $sDados . '");');


        echo $oMensagem->getRender();
    }

    public function reenviaReprovaVenda($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->verifProjProjVenda($aCamposChave);

        if ($aRetorno == false) {
            $oMensagem = new Mensagem('Aguarde', 'Seu e-mail está sendo gerado e enviado', Mensagem::TIPO_INFO);
            echo'requestAjax("","' . $sClasse . '","EnvReprov","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto está Aprovado, o reenvio do e-mail de Reprovação foi cancelado.', Modal::TIPO_AVISO, false, true, true);
        }
        echo $oMensagem->getRender();
    }

    public function EnvReprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
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

        $aObs = $this->Persistencia->buscaObs($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);
        $oCampos = $this->Persistencia->buscaDados($aCamposChave);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº ' . $aCamposChave['nr'] . ''));
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#FF0000"><b>REPROVADO</b></span> PELO SETOR DE VENDAS.<hr><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%">'
                        . '<tr><td><b>Descrição:</b></td><td>' . $oCampos->desc_novo_prod . '</td></tr>'
                        . '<tr><td><b>Acabamento:</b></td><td>' . $oCampos->acabamento . '</td></tr>'
                        . '<tr><td><b>Quant.Cnt/Mês:</b></td><td>' . number_format($oCampos->quant_pc, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Empresa:</b></td><td>' . $oCampos->empdes . '</td></tr>'
                        . '<tr><td><b>Observação vendas/Motivo reprovação:</b></td><td>' . $aObs['Financeiro'] . '</td></tr> </table>'
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));



        $oEmail->limpaDestinatariosAll();

        // Para        
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        $aUserPlano = $this->Persistencia->projEmail($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente no botão de E-mails, caso o problema persista, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);

        $sDataDb = $this->Model->getPrazoentregautil();
        $sValorBanco = $this->Model->getQuant_pc();
        $sValorDec = number_format($sValorBanco, 2, ',', '.');
        $this->Model->setQuant_pc($sValorDec);
    }

}
