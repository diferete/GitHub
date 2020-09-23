<?php

/*
 * Classe que implementa a controller CadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class ControllerCadCliRep extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('CadCliRep');
    }

    public function beforeInsert() {
        parent::beforeInsert();
        $sCNPJ = $this->Model->getCnpj();
        $sEmpcod = $this->Model->getEmpcod();


        if ($sCNPJ != $sEmpcod) {
            if ($sCNPJ == '') {

                $this->Model->setEmpmunicipio(Util::removeAcentos($this->Model->getEmpmunicipio()));
                $this->Model->setEmpendbair(Util::removeAcentos($this->Model->getEmpendbair()));
                $this->Model->setEmpend(Util::removeAcentos($this->Model->getEmpend()));

                $aRetorno = array();
                $aRetorno[0] = true;
                $aRetorno[1] = '';


                $oMsg = new Mensagem('Atenção preenchimento manual', 'Verifique o número do CNPJ antes de liberar cadastro!', Mensagem::TIPO_WARNING, 10000);
                echo $oMsg->getRender();

                return $aRetorno;
            } else {

                $oMsg = new Mensagem('Erro ao tentar inserir', 'Verifique o número do CNPJ.', Mensagem::TIPO_WARNING);
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            }
        } else {
            $this->Model->setEmpmunicipio(Util::removeAcentos($this->Model->getEmpmunicipio()));
            $this->Model->setEmpendbair(Util::removeAcentos($this->Model->getEmpendbair()));
            $this->Model->setEmpend(Util::removeAcentos($this->Model->getEmpend()));

            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $sCNPJ = $this->Model->getCnpj();
        $sEmpcod = $this->Model->getEmpcod();


        if ($sCNPJ != $sEmpcod) {
            if ($sCNPJ == '') {

                $this->Model->setEmpmunicipio(Util::removeAcentos($this->Model->getEmpmunicipio()));
                $this->Model->setEmpendbair(Util::removeAcentos($this->Model->getEmpendbair()));
                $this->Model->setEmpend(Util::removeAcentos($this->Model->getEmpend()));

                $aRetorno = array();
                $aRetorno[0] = true;
                $aRetorno[1] = '';


                $oMsg = new Mensagem('Atenção preenchimento manual', 'Verifique o número do CNPJ antes de liberar cadastro!', Mensagem::TIPO_WARNING, 10000);
                echo $oMsg->getRender();

                return $aRetorno;
            } else {

                $oMsg = new Mensagem('Erro ao tentar inserir', 'Verifique o número do CNPJ.', Mensagem::TIPO_WARNING);
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            }
        } else {
            $this->Model->setEmpmunicipio(Util::removeAcentos($this->Model->getEmpmunicipio()));
            $this->Model->setEmpendbair(Util::removeAcentos($this->Model->getEmpendbair()));
            $this->Model->setEmpend(Util::removeAcentos($this->Model->getEmpend()));

            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituaca() == 'Liberado' or $this->Model->getSituaca() == 'Cadastrado') {
            $aOrdem = explode('=', $sChave);
            $oMensagem = new Modal('Atenção!', 'O cadastro Nº' . $this->Model->getNr() . ' não pode ser modificadao somente visualizado!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
            //exit();
        }
    }

    /**
     * Método para liberar cadastro para a Metalbo
     */
    public function msgLiberaCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Liberação de cadastro', 'Deseja liberar o cadastro nº' . $aCamposChave['nr'] . ' para a Metalbo?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaCadastro","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    public function liberaCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->liberaMetalbo($aCamposChave);
        $sCondicao = $aRetorno[0];

        switch ($sCondicao) {
            case 'Liberado':
                $oMensagem = new Modal('Liberação de cadastro', 'Solicitação de cadastro nº' . $aCamposChave['nr'] . ' já foi liberada para a Metalbo, deseja REENVIAR o e-mail de notificação?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","enviaEmailMetalbo","' . $aCamposChave['nr'] . '");');
                break;
            case 'Cadastrado':
                $oMensagem = new Modal('Liberação de cadastro', 'Solicitação de cadastro nº' . $aCamposChave['nr'] . ' já foi cadastrada', Modal::TIPO_AVISO, false, true, true);
                break;
            default:
                $oMensagem = new Mensagem('Sucesso!', 'Seu cadastro foi liberado com sucesso...', Mensagem::TIPO_SUCESSO);
                echo"$('#" . $aDados[1] . "-pesq').click();";
                $this->enviaEmailMetalbo($aCamposChave['nr']);
                break;
        }
        echo $oMensagem->getRender();
    }

    public function enviaEmailMetalbo($sNr) {
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

        $this->Persistencia->adicionafiltro('nr', $sNr);
        $oRow = $this->Persistencia->consultarWhere();

        $oEmail->setAssunto(utf8_decode('Cadastro de Cliente Nº' . $oRow->getNr() . ''));
        $oEmail->setMensagem(utf8_decode('CLIENTE Nº ' . $oRow->getNr() . ' FOI LIBERADO PELO REPRESENTANTE ' . $oRow->getUsucodigo() . '<hr><br/>'
                        . '<b>Representante:  ' . $_SESSION['nome'] . '<br/>'
                        . '<b>Escritório:  ' . $oRow->getOfficedes() . '<br/>'
                        . '<b>Hora:  ' . $oRow->getHoralib() . '<br/>'
                        . '<b>Data do Cadastro:  ' . $oRow->getEmpdtcad() . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Cnpj:</b></td><td>' . $oRow->getEmpcod() . '</td></tr>'
                        . '<tr><td><b>Razão Social:</b></td><td>' . $oRow->getEmpdes() . '</td></tr>'
                        . '<tr><td><b>Nome Fantasia:</b></td><td>' . $oRow->getEmpfant() . '</td></tr>'
                        . '<tr><td><b>Observação:</b></td><td>' . $oRow->getEmpobs() . '</td></tr> '
                        . '</table><br/><br/> '
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar o cadastro!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //enviar e-mail vendas
        $aUserPlano = $this->Persistencia->buscaEmailVenda($sNr);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        //$aUserPlano = $this->Persistencia->buscaEmailVenda($sNr);
        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();

        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente liberar novamente ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function getCNPJ($sDados) {
        $aDados = explode('*', $sDados);
        $aDadosEMP = explode('|', $aDados[0]);
        $aIdCampos = explode('|', $aDados[1]);
        if ($aDadosEMP[0] != '') {
            $bRet = $this->Persistencia->buscaCNPJ($aDadosEMP[0]);
            if ($bRet == false) {
                $oMensagem = new Modal('Atenção', 'Esse CNPJ já está cadastrado no sistema!', Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            } else {
                $sSetValorCampos = '$("#' . $aIdCampos[0] . '").val("' . $aDadosEMP[0] . '");'
                        . '$("#' . $aIdCampos[1] . '").val("' . str_replace(".", "", $aDadosEMP[1]) . '");'
                        . '$("#' . $aIdCampos[2] . '").val("' . $aDadosEMP[2] . '");'
                        . '$("#' . $aIdCampos[3] . '").val("' . $aDadosEMP[3] . '");'
                        . '$("#' . $aIdCampos[4] . '").val("' . $aDadosEMP[4] . '");'
                        . '$("#' . $aIdCampos[5] . '").val("' . $aDadosEMP[5] . '");'
                        . '$("#' . $aIdCampos[6] . '").val("' . $aDadosEMP[6] . '");'
                        . '$("#' . $aIdCampos[7] . '").val("' . $aDadosEMP[7] . '");'
                        . '$("#' . $aIdCampos[8] . '").val("' . $aDadosEMP[8] . '");'
                        . '$("#' . $aIdCampos[9] . '").val("' . $aDadosEMP[9] . '");'
                        . '$("#' . $aIdCampos[10] . '").val("' . $aDadosEMP[10] . '");'
                        . '$("#' . $aIdCampos[11] . '").val("' . $aDadosEMP[11] . '");';
                echo $sSetValorCampos;
                $oMensagem = new Mensagem('Sucesso', 'Busca efetuada com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                if (strlen($aDados[1]) > 45 || strlen($aDados[2]) > 35) {
                    $oMsg = new Mensagem('Atenção', 'Abreviar Razão Social e Fantasia. Ex: COM, IND, MAQ, EQUIP sem adicionar pontos', Mensagem::TIPO_ERROR, '10000');
                    echo $oMsg->getRender();
                }

                echo 'buscaIBGE("CadCliRep","' . Util::removeAcentos($aDadosEMP[6]) . '","' . $aDadosEMP[8] . '","' . $aIdCampos[12] . '","' . $aDadosEMP[12] . '");';
            }
        } else {
            exit;
        }
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

    public function codigoIBGE($sDados) {
        $aDados = explode('|', $sDados);
        if ($aDados[0] == 'VAZIO') {
            $this->Persistencia->gravaHistorico($aDados[2]);
        }
        $script = "$('#" . $aDados[1] . "' ).val('" . $aDados[0] . "' );";
        echo 'console.log(' . $aDados[0] . ');';
        echo $script;
    }
 //////////////////////////////////////////////////////////
    public function mostraTelaRelCadCliRep($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relCadCliRep');
    }
}
