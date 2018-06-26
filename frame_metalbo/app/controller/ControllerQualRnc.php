<?php

/*
 * Implementa controller da classe QualRnc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerQualRnc extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualRnc');
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

    /**
     * finaliza uma rnc
     */

    /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalFinaliza($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $aRet = $this->Persistencia->verificaFim($aCamposChave);
        if ($aRet[0]) {
            $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);

            $oDados = $this->Persistencia->consultarWhere();
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalFinaliza($sDados);

            //adiciona onde será renderizado
            $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMens = new Modal('Atenção, reclamação já finalizada!', '', Modal::TIPO_AVISO, false, true, false);
            echo $oMens->getRender();
            echo'$("#' . $aDados[1] . '-btn").click();';
        }
    }

    /**
     * Aprova final rnc 
     * @param type $sDados
     */
    public function finalizaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sClasse = $this->getNomeClasse();
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRet = $this->Persistencia->finalizaAcao($aCampos);


        if ($aRet[0]) {
            $oMsg = new Mensagem('Reclamação nº' . $aCampos['nr'] . ' foi finalizada com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo'$("#' . $aDados[2] . '-btn").click();';
        } else {
            
        }
    }

    public function envMailGrid($sDados) {
        $sDadosFull = $sDados;
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        echo 'requestAjax("","QualRnc","geraRelPdfRnc","' . $aCamposChave['filcgc'] . ',' . $aCamposChave['nr'] . ',rc");';
        echo 'requestAjax("","QualRnc","msgLiberaRnc","' . $sDadosFull . '");';
    }

    public function geraRelPdfRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $sSistema = "app/relatorio";
        $sRelatorio = $aDados[2] . '.php?';
        $sCampos = 'nr=' . $aDados[1] . '&';
        $sCampos .= 'filcgc=' . $aDados[0];


        $sCampos .= '&output=email';

        $oWindow = 'var win = window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "1366002941508","width=100,height=100,left=375,top=330");'
                . 'setTimeout(function () { win.close();}, 1000);';
        echo $oWindow;
        //echo 'requestAjax("","QualRnc","msgLibRnc","' . $aCamposChave['filcgc'] . ',' . $aCamposChave['nr'] . '");';
    }

    public function msgLiberaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Liberação de RNC', 'Deseja liberar a RNC nº' . $aCamposChave['nr'] . ' para a Metalbo?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaRnc","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    public function liberaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->liberaRnc($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem2 = new Mensagem('Sucesso!', 'Seu cadastro foi liberado com sucesso...', Mensagem::TIPO_SUCESSO);
            echo"$('#" . $aDados[1] . "-pesq').click();";
            $this->enviaEmailRnc($sChave);
        } else {
            $oMensagem2 = new Mensagem('Atenção!', $aRetorno[1], Mensagem::TIPO_ERROR);
        }
        echo $oMensagem2->getRender();
    }

    public function enviaEmailRnc($sDados) {
        $aDados = array();
        parse_str($sDados,$aDados);
        $sClasse = $this->getNomeClasse();
        date_default_timezone_set('America/Sao_Paulo');
        $data = date('d/m/Y');
        $hora = date('H:m');

        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oRow = $this->Persistencia->buscaDadosRnc($aDados);

        $oEmail->setAssunto(utf8_decode('Inserida nova RNC - Reclamação de cliente'));

        $oEmail->setMensagem(utf8_decode('RECLAMAÇÃO Nº ' . $oRow->nr . ' FOI LIBERADA PELO REPRESENTANTE<hr><br/>'
                        . '<b>Representante: ' . $_SESSION['nome'] . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora:' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj:</b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social:</b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Nota fiscal:</b></td><td> ' . $oRow->nf . ' </td></tr>'
                        . '<tr><td><b>Data da NF.:</b></td><td> ' . $oRow->datanf . ' </td></tr>'
                        . '<tr><td><b>Od. de compra:</b></td><td> ' . $oRow->odcompra . ' </td></tr>'
                        . '<tr><td><b>Pedido Nº:</b></td><td> ' . $oRow->pedido . ' </td></tr>'
                        . '<tr><td><b>Valor: R$</b></td><td> ' . $oRow->valor . ' </td></tr>'
                        . '<tr><td><b>Peso:</b></td><td> ' . $oRow->peso . ' </td></tr>'
                        . '<tr><td><b>Não conformidade:</b></td><td> ' . $oRow->naoconf . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>))'));

        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //enviar e-mail vendas
        $aUserPlano = $this->Persistencia->buscaEmailVenda($aDados);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }
        //provisório para ir cópia para avanei
        $oEmail->addAnexo('app/relatorio/rnc/Rnc' . $aDados['nr'] . '_empresa_' . $aDados['filcgc'] . '.pdf', utf8_decode('RNC nº' . $aDados['nr'] . '_empresa_' . $aDados['filcgc']));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}
