<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerCot extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('Cot');
        $this->setControllerDetalhe('PnlFinanCot');
        $this->setSMetodoDetalhe('criaPainelFinanceiro');
    }

    /**
     * Método para carregar o representante
     */
    public function carregaRep($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[2] <> '') {
            $aRetorno = $this->Persistencia->buscaRep($aDados[2]);
            echo"$('#" . $aDados[0] . "').val('" . $aRetorno[0] . "');"
            . "$('#" . $aDados[1] . "').val('" . $aRetorno[1] . "');";
        }
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        // $this->Persistencia->adicionaFiltro('',  $this->Model->getMencodigo());
    }

    /**
     * monta os campos para a próxima etapa
     */
    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getCnpj();
        $aRetorno[1] = $this->Model->getCliente();
        $aRetorno[2] = $this->Model->getNr();
        return $aRetorno;
    }

    public function antesAlterar($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $this->carregaModelString($sParametros[0]);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getEmail() == 'EV') {
            $aOrdem = explode('=', $sParametros[0]);
            $oMensagem = new Modal('Cotação já encerrada!', 'A cotação nº' . $aOrdem[1] . ' já foi liberada, não é permitido fazer alterações!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
            //exit();
        }
    }

    /**
     * Libera solicitação para a metalbo
     */
    public function msgLiberaMetalbo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->carregaModelString($aDados[2]);
        $this->Model = $this->Persistencia->consultar();
        if ($this->Model->getEmail() == 'EV') {
            $oMensagem = new Modal('Cotação já liberada', 'A solicitação nº' . $aCamposChave['nr'] . ' já está liberada!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        } else {
            //verifica se nao existe bloqueio no financeiro
            $aNr = explode('=', $aDados[2]);
            $sEmpcod = $this->Persistencia->retCli($aNr[1]);
            $sBloq = $this->Persistencia->retBloq($sEmpcod);
            if ($sBloq == 'B') {
                $oMensagem = new Modal('Cópia de Cotação', 'O Cliente da cotação nº' . $aCamposChave['nr'] . ' está com financeiro bloqueado', Modal::TIPO_AVISO, false, true, true);
                echo $oMensagem->getRender();
            } else {
                $oMensagem = new Modal('Liberar cotação', 'Deseja liberar a cotação nº' . $aCamposChave['nr'] . ' para a metalbo?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaMetalbo","' . $sDados . '");');

                echo $oMensagem->getRender();
            }
        }
    }

    public function liberaMetalbo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = array();
        $aRetorno = $this->Persistencia->libMetalbo($aCamposChave);

        $oMensagem = new Modal('Atenção', 'A cotação nº' . $aCamposChave['nr'] . ' foi liberada com sucesso', Modal::TIPO_SUCESSO, false, true, true);
        echo $oMensagem->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function msgCopiaCot($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        //verifica se nao existe bloqueio no financeiro
        $aNr = explode('=', $aDados[2]);
        $sEmpcod = $this->Persistencia->retCli($aNr[1]);
        $sBloq = $this->Persistencia->retBloq($sEmpcod);
        $sMsgBloq = '';
        if ($sBloq == 'B') {
            $sMsgBloq = 'Atenção esse cliente está com bloqueio de crédito';
        }

        $oMensagemConf = new Modal('Cópia cotação', 'Deseja gerar uma cópia da cotação nº' . $aCamposChave['nr'] . '? ' . $sMsgBloq . '', Modal::TIPO_AVISO, true, true, true);
        $oMensagemConf->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","copiaCot","' . $sDados . '");');


        echo $oMensagemConf->getRender();
    }

    public function copiaCot($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->copiaCot($sChave);
        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Atenção', 'A Cotação nº' . $aRetorno[1] . ' foi copiada com sucesso', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'A Cotação nº' . $aCamposChave['nr'] . ' não foi copiado', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * gera solicitacao a partir de uma cotacao
     */
    public function geraSolMsg($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        //verifica se nao existe bloqueio no financeiro
        $aNr = explode('=', $aDados[2]);
        $sEmpcod = $this->Persistencia->retCli($aNr[1]);
        $sBloq = $this->Persistencia->retBloq($sEmpcod);
        if ($sBloq == 'B') {
            $oMensagem = new Modal('Gerar Solicitação de venda', 'O Cliente da solicitação nº' . $aCamposChave['nr'] . ' está com financeiro bloqueado', Modal::TIPO_AVISO, false, true, true);
        } else {

            $oMensagem = new Modal('Gerar Solicitação de venda', 'Deseja gerar uma solicitação de venda da cotação nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","geraSol","' . $sDados . '");');
        }

        echo $oMensagem->getRender();
    }

    public function geraSol($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $aNrCot = explode('=', $aDados[2]);


        $aRetorno = $this->Persistencia->geraSol($aNrCot[1]);
        if ($aRetorno[0] == true) {
            $oMensagem = new Modal('Sucesso', 'A Cotação nº' . $aCamposChave['nr'] . ' gerou uma nova solicitaçao de venda nº' . $aRetorno[1] . '', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'A Cotação nº' . $aCamposChave['nr'] . ' não gerou solicitação de venda', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * Retorna dados para get de relatórios
     */
    public function getSget() {
        parent::getSget();

        $sTabCab = $this->Persistencia->getTabela();
        $oCotIten = Fabrica::FabricarPersistencia('CotIten');
        $sTabIten = $oCotIten->getTabela();

        $sCampos = '&tabcab=' . $sTabCab;
        $sCampos .= '&itencab=' . $sTabIten;
        $sCampos .= '&repcod=' . $_SESSION['repoffice'];


        //busca a imagem padrão dos relatórios
        $oRepOffice = Fabrica::FabricarPersistencia('RepOffice');
        $sImg = $oRepOffice->imgRel(null);
        $sCampos .= '&imgrel=' . $sImg;

        return $sCampos;
    }

    /**
     * 
     * @param type $sDados
     * @param type $sRelenvia email da cotacao
     */
    public function envMailCot($sDados, $sRel) {
        $aDados = explode(',', $sDados);
        $aNr = explode('=', $aDados[2]);

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

        $oEmail->setAssunto(utf8_decode('Cotaçao de venda nº' . $aNr[1]));
        $oEmail->setMensagem(utf8_decode('Anexo cotação de venda nº' . $aNr[1]));
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

        $oEmail->addAnexo('app/relatorio/representantes/' . $_SESSION['diroffice'] . '/cotacao' . $aNr[1] . '.pdf', utf8_decode('Cotação de venda nº' . $aNr[1]));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $this->Persistencia->confirmaEnvioEmail($aDados, $aNr);
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function geraAnexoCotEmail($sDados) {
        $aDados = explode(',', $sDados);
        $sNR[] = $aDados[3];
        $sChave = htmlspecialchars_decode($sNR[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sParametros = $this->getSget();
        $aParametros = explode('&', $sParametros);

        $aParam = array();
        foreach ($aParametros as $key => $value) {
            $aItems = explode('=', $value);
            $aParam[$aItems[0]] = $aItems[1];
        }

        $_REQUEST['nr'] = $aCamposChave['nr'];
        $_REQUEST['tabcab'] = $aParam['tabcab'];
        $_REQUEST['itencab'] = $aParam['itencab'];
        $_REQUEST['imgrel'] = $aParam['imgrel'];
        $_REQUEST['output'] = 'email';
        $_REQUEST['dir'] = $_SESSION['diroffice'];
        $_REQUEST['logo'] = 'comlogo';
        $_REQUEST['repcod'] = $_SESSION['repoffice'];

        require 'app/relatorio/cotacao.php';
    }

    public function geraAnexoCotEmailSLogo($sDados) {
        $aDados = explode(',', $sDados);
        $sNR[] = $aDados[3];
        $sChave = htmlspecialchars_decode($sNR[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sParametros = $this->getSget();
        $aParametros = explode('&', $sParametros);

        $aParam = array();
        foreach ($aParametros as $key => $value) {
            $aItems = explode('=', $value);
            $aParam[$aItems[0]] = $aItems[1];
        }

        $_REQUEST['nr'] = $aCamposChave['nr'];
        $_REQUEST['tabcab'] = $aParam['tabcab'];
        $_REQUEST['itencab'] = $aParam['itencab'];
        $_REQUEST['imgrel'] = $aParam['imgrel'];
        $_REQUEST['output'] = 'email';
        $_REQUEST['dir'] = $_SESSION['diroffice'];
        $_REQUEST['logo'] = 'semlogo';
        $_REQUEST['repcod'] = $_SESSION['repoffice'];

        require 'app/relatorio/cotacao.php';
    }

}
