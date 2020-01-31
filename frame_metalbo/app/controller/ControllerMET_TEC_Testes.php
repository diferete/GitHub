<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_Testes extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Testes');
    }

    public function insereGrupo() {
        $this->Persistencia->insereGrupo();

        $oMensagem = new Mensagem('Pronto', 'Conculido com sucesso');
        echo $oMensagem->getRender();
    }

    public function insereGrupo2() {
        $this->Persistencia->insereGrupo2();

        $oMensagem = new Mensagem('Pronto', 'Conculido com sucesso');
        echo $oMensagem->getRender();
    }

    public function expiraProj() {
        $oExpira = Fabrica::FabricarController('Agendamentos');
        $aExpira = $oExpira->atualizaEntProj();
    }

    public function converteXML() {

        $xml = simplexml_load_file('app/arquivo.xml');

        foreach ($xml->NFe as $key => $oValor) {
            foreach ($oValor->infNFe->det->prod as $key1 => $oValor1) {
                $s = 1;
                $sCodigo = (string) $oValor1->cProd;
                $sPesoTrib = (string) $oValor1->qTrib;
                $this->Persistencia->pesoXml($sCodigo, $sPesoTrib);
            }
        }

        echo '<br>';
    }

    public function inserePlaca() {
        $this->Persistencia->inserePlaca();
        $oMsg = new Mensagem('Pronto', 'concluido com sucesso');
        echo $oMsg->getRender();
    }

    public function testarEmail() {

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

        $oEmail->setAssunto(utf8_decode('TESTE ENVIO DE E-MAIL'));
        $oEmail->setMensagem(utf8_decode('Teste de envio de e-mail via sistema.metalbo'));

        $oEmail->limpaDestinatariosAll();
        // Para        
        $oEmail->addDestinatario($_SESSION['email']);

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
    
    public function atualizaEntProj() {

        $aRetorno = $this->Persistencia->verificaSitEntProj();
        //verifica se array tem dados, dar um count
        if (count($aRetorno) > 0) {
            //executa a funçao
            $aRet = $this->Persistencia->mudaSitEntProj($aRetorno);
        }
    }

}
