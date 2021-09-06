<?php

class ControllerMET_TEC_Modulo extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Modulo');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();


        $sDados = urldecode(func_get_arg(0));

        $aSerialFiltros = explode('&', $sDados); // transforma a string em array.

        $aFiltros = array();
        $aNovo = array();
        $teste = array();
        foreach ($aSerialFiltros as $item) {
            $valor = explode('=', $item); // quebra o elemento atual em um array com duas posições,onde o indice zero é a chave e o um o valor em $arrN
            if (array_key_exists($valor[0], $aFiltros)) {
                $aFiltros[$valor[0] . "-final"] = $valor[1];
                $aFiltros[$valor[0] . "-tipo"] = "entre";
            } else {
                $aFiltros[$valor[0]] = $valor[1];
            }


            $teste['nome'] = $valor[0];
            $teste['valor'] = $valor[1];
            $aNovo[] = $teste;
        }
        foreach ($aNovo as $itemteste) {
            if (key_exists($key, $search)) {
                
            }
        }
    }

    public function testarEmail() {

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

}
