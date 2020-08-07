<?php

/*
 * Classe que implementa a controller da SatisClientePesq
 * 
 * @author Avanei Martendal
 * @since 15/01/2018
 */

class ControllerSatisClientePesq extends Controller {

    public function __construct() {

        $this->carregaClassesMvc('SatisClientePesq');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);



        $aCampos[] = $aChave[0];
        $aCampos[] = $aChave[1];



        $this->View->setAParametrosExtras($aCampos);
    }

    /**
     * Filtros extras
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam = $this->getParametros();
        //$aparam = $this->View->getAParametrosExtras();
        $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
        $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
        $this->Persistencia->setChaveIncremento(false);
    }

//Filtros extras
    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->limpaFiltro();
        $aparam = explode(',', $this->getParametros());
        $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
        $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
    }

    //filtro extras
    public function adicionaFiltroDet2() {
        parent::adicionaFiltroDet2();
        $this->Persistencia->limpaFiltro();
        $aparam = explode(',', $this->getParametros());
        $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
        $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sCampos);
        $aParam = explode(',', $sDados);

        //verifica se está como 
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';



        echo $sScript;
    }

    /**
     * Mensagem para enviar os e-mail
     */
    public function msgEmail($sDados) { // >>>ATENÇÃO<<< É NECESSÁRIO REESCREVER ESTE MÉTODO
        if (isset($_REQUEST['parametrosCampos'])) {
            $aParam = $_REQUEST['parametrosCampos'];
            $aChaves = array();
            foreach ($aParam as $key => $value) {
                $aChaves[] = $value;
            }
        }
        $sDados .= ',' . implode(',', $aChaves);


        $oMensagem = new Modal('E-mail', 'Você tem certeza que deseja enviar e-mail de confirmação para os selecionados?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $this->getNomeClasse() . '","enviaEmail","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    /**
     * envia o email
     */
    public function enviaEmail($sDados) {

        $aDados = explode(',', $sDados);
        $idGrid = $aDados[0];
        array_shift($aDados);
        $aRetorno[0] = true;


        foreach ($aDados as $sChaveAtual) {

            $sChave = htmlspecialchars_decode($sChaveAtual);
            $this->parametros = $sChave;
            $this->carregaModelString($sChave);
            $this->Model = $this->Persistencia->consultar();


            //envia o email
            $aRetorno[0] = $this->envMailAll($this->Model->getFilcgc(), $this->Model->getNr(), $this->Model->getSeq(), $this->Model->getEmail());

            //se necessário adiciona filtro de reload
            $this->filtroReload($sChave);

            if ($aRetorno[0]) {

                //muda a situação do cliente
                $aRetorno[0] = $this->Persistencia->mudaSit($this->Model->getFilcgc(), $this->Model->getNr(), $this->Model->getSeq());


                // Retorna Mensagem Informando o Sucesso da Exlusão do registro
                $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu e-mail foi enviado com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagemSucesso->getRender();
                $this->getDadosConsulta($idGrid, false, null);
            } else {
                $oMensagemErro = new Mensagem('Falha', 'Falha no envio do e-mail!!', Mensagem::TIPO_ERROR);
                echo $oMensagemErro->getRender();
            }
        }
    }

    /**
     * Envia e-mail da pesquisa
     */
    public function envMailAll($filcgc, $nr, $seq, $emailcli) {
        $aDados = explode(',', $sDados);

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

        $oEmail->setAssunto(utf8_decode('Pesquisa de satisfação de cliente Metalbo'));



        $oCorpoDoEmail = new MensagemMail('Prezado cliente!', 'Agradecemos sua participação na pesquisa de satisfação de clientes da Metalbo', date('d/m/Y'));
        $sCorpoDoEmail = $oCorpoDoEmail->getRender();

        $oEmail->setMensagem(utf8_decode($sCorpoDoEmail));
        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        $oEmail->addDestinatario($emailcli);



        $aRetorno = $oEmail->sendEmail();
        return $aRetorno;
    }

}
