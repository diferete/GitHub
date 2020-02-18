<?php

/*
 * Implementa controller da classe QualRnc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerQualRncAnalise extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualRncAnalise');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $aDados = $this->Persistencia->buscaRespEscritório($sDados);
        $this->View->setAParametrosExtras($aDados);
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

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));
        /* $date = new DateTime( '2014-08-19' );
          echo $date-> format( 'd-m-Y' ); */

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));

        //Quantnconf
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);

        $this->Model->setValor(number_format($this->Model->getValor(), 2, ',', '.'));
        $this->Model->setPeso(number_format($this->Model->getPeso(), 2, ',', '.'));
        $this->Model->setQuant(number_format($this->Model->getQuant(), 2, ',', '.'));
        $this->Model->setQuantnconf(number_format($this->Model->getQuantnconf(), 2, ',', '.'));
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);

        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";

        echo $sRetorno;
    }

    public function criaTelaModalAponta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];


        $aRet = $this->Persistencia->verifSit($aCamposChave);

        if ($aRet[0] == true && $aRet[2] == 'Em análise' && $aRet[1] != 'Apontada') {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalAponta($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMens = new Modal('Atenção!', 'A reclamação não está em situação de ser apontada!', Modal::TIPO_AVISO, false, true, false);
            echo $oMens->getRender();
            echo'$("#' . $aDados[1] . '-btn").click();';
        }
    }

    /**
     * Aponta RNC
     * @param type $sDados
     */
    public function apontaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRet = $this->Persistencia->apontaRnc($aCampos);

        if ($aRet[0] == true) {
            $oMsg = new Mensagem('Sucesso', 'Reclamação nº' . $aCampos['nr'] . ' foi apontada com sucesso!', Mensagem::TIPO_SUCESSO);
            $oMsg2 = new Mensagem('Atenção', 'Aguarde enquanto o e-mail é enviado para o setor de vendas!', Mensagem::TIPO_INFO);
            echo $oMsg->getRender();
            echo $oMsg2->getRender();
            echo'requestAjax("","' . $this->getNomeClasse() . '","enviaEmailAponta","' . $sDados . '");';
        } else {
            $oMsg = new Mensagem('Atenção', 'Reclamação nº' . $aCampos['nr'] . ' não pode ser apontada!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
        echo'$("#' . $aDados[2] . '-btn").click();';
    }

    public function reenviaEmailRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sSituaca = $this->Persistencia->verifSit($aCamposChave);

        if ($sSituaca[1] != 'Apontada' || $sSituaca[2] != 'Em análise') {
            $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' não pode ser encaminhada!', Modal::TIPO_AVISO, false, true, false);
        } else {
            $oMensagem = new Modal('Encaminhar e-mail', 'A RC nº' . $aCamposChave['nr'] . ' ja teve seu e-mail encaminhado para o seu setor responsável, deseja reenviar o e-mail?', Modal::TIPO_INFO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $this->getNomeClasse() . '","enviaEmailAponta","' . $sDados . ',reenvia");');
        }
        echo $oMensagem->getRender();
    }

    public function enviaEmailAponta($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[3] == 'reenvia') {
            $sChave = htmlspecialchars_decode($aDados[2]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
        } else {
            $sChave = htmlspecialchars_decode($aDados[3]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
        }

        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');
        $hora = date('H:m');

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

        $oRow = $this->Persistencia->buscaDadosRnc($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RETORNO RECLAMAÇÃO DE CLIENTE Nº ' . $oRow->nr . ' ' . $oRow->devolucao . ''));

        if ($_SESSION['codsetor'] == 3) {
            $sSetor = 'Expedição';
        }
        if ($_SESSION['codsetor'] == 5) {
            $sSetor = 'Embalagem';
        }
        if ($_SESSION['codsetor'] == 25) {
            $sSetor = 'Qualidade';
        }

        $oEmail->setMensagem(utf8_decode('A devolução de Nº ' . $oRow->nr . ' foi apontada pelo setor da<strong><span style="color:red"> "' . $sSetor . '" </span></strong>.<hr><br/>'
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
                        . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($oRow->$oRow->valor, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Peso: </b></td><td> ' . number_format($oRow->peso, 2, ',', '.') . ' </td></tr>'
                        . '<tr><td><b>Aplicação: </b></td><td> ' . $oRow->aplicacao . '</td></tr>'
                        . '<tr><td><b>Não conformidade: </b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $aEmail = $this->Persistencia->buscaEmails($aCamposChave);
        $oEmail->addDestinatario($aEmail[0]);
        $oEmail->addDestinatarioCopia($aEmail[1]);

        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'Um e-mail foi enviado para notificar vendas sobre o apontamento!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente reenviar ou relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}
