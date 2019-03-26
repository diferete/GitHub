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
        $this->Model->setEmpmunicipio(Util::removeAcentos($this->Model->getEmpmunicipio()));
        $this->Model->setEmpendbair(Util::removeAcentos($this->Model->getEmpendbair()));
        $this->Model->setEmpend(Util::removeAcentos($this->Model->getEmpend()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
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

        if ($aRetorno[1] != false) {
            $oMensagem = new Mensagem('Sucesso!', 'Seu cadastro foi liberado com sucesso...', Mensagem::TIPO_SUCESSO);
            echo"$('#" . $aDados[1] . "-pesq').click();";
            $this->enviaEmailMetalbo($aCamposChave['nr']);
        } else {
            if ($aRetorno[0] == 'Liberado') {
                $oMensagem = new Modal('Liberação de cadastro', 'Solicitação de cadastro nº' . $aCamposChave['nr'] . ' já foi liberada para a Metalbo, deseja REENVIAR o e-mail de notificação?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","enviaEmailMetalbo","' . $aCamposChave['nr'] . '");');
            } else {
                $oMensagem = new Modal('Liberação de cadastro', 'Solicitação de cadastro nº' . $aCamposChave['nr'] . ' já foi cadastrada', Modal::TIPO_AVISO, false, true, true);
            }
        }
        echo $oMensagem->getRender();
    }

    public function enviaEmailMetalbo($sNr) {
        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

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

//        $aUserPlano = $this->Persistencia->buscaEmailVenda($sNr);
//        $oEmail->addDestinatario('alexandre@metalbo.com.br');
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
        $aDados = explode(',', $sDados);
        if ($aDados[0] != '') {
            $sRet = $this->Persistencia->buscaCNPJ($aDados[0]);
            if ($sRet == false) {
                $oMensagem = new Modal('Atenção', 'Esse CNPJ já está cadastrado no sistema!', Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            } else {
                $sSetValorCampos = '$("#' . $aDados[12] . '").val("' . $aDados[1] . '");'
                        . '$("#' . $aDados[13] . '").val("' . $aDados[2] . '");'
                        . '$("#' . $aDados[14] . '").val("' . $aDados[3] . '");'
                        . '$("#' . $aDados[15] . '").val("' . $aDados[4] . '");'
                        . '$("#' . $aDados[16] . '").val("' . $aDados[5] . '");'
                        . '$("#' . $aDados[17] . '").val("' . $aDados[6] . '");'
                        . '$("#' . $aDados[18] . '").val("' . $aDados[7] . '");'
                        . '$("#' . $aDados[19] . '").val("' . $aDados[8] . '");'
                        . '$("#' . $aDados[20] . '").val("' . $aDados[9] . '");'
                        . '$("#' . $aDados[21] . '").val("' . $aDados[10] . '");'
                        . '$("#' . $aDados[22] . '").val("' . $aDados[11] . '");';
                echo $sSetValorCampos;
                $oMensagem = new Mensagem('Sucesso', 'Busca efetuada com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                if (strlen($aDados[1]) > 45 || strlen($aDados[2]) > 35) {
                    $oMsg = new Mensagem('Atenção', 'Abreviar Razão Social e Fantasia. Ex: COM, IND, MAQ, EQUIP', Mensagem::TIPO_ERROR, '10000');
                    echo $oMsg->getRender();
                }
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

}
