<?php

/*
 * Implementa controller da classe MET_QUAL_Rc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerMET_QUAL_RcRep extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_RcRep');
    }

    public function relReclamacaoCliente($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relReclamacaoCliente');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $oLote = $this->Model->getLote();
        $oOp = $this->Model->getOp();
        $oTag = $this->Model->getTagexcecao();
        $oProd = $this->Model->getProdutos();

        if (($oTag == '' || $oTag == null ) || ($oProd == '' || $oProd == null)) {
            if (($oTag != true && ($oLote == '' || $oOp == '')) || ($oTag != true && ($oLote == null || $oOp == null))) {
                $oMsg = new Modal('Atenção', 'Favor preencher os campos de LOTE e ORDEM DE PRODUÇÃO, solicitar com o Cliente!', Modal::TIPO_AVISO, FALSE, TRUE, FALSE);
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            } if ($oProd == '' || $oProd == null) {
                $oMsg = new Mensagem('Atenção', 'Favor preencher o campo de Produtos', Mensagem::TIPO_WARNING);
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            }
        } else {
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


        $oRep = Fabrica::FabricarController('RepCodOffice');
        $oRep->Persistencia->adicionaFiltro('officecod', $_SESSION['repoffice']);
        $oReps = $oRep->Persistencia->getArrayModel();

        $this->View->setOObjTela($oReps);

        $oSit = $this->Model->getSituaca();

        if ($oSit != 'Aguardando') {
            $aOrdem = explode('=', $sChave);
            $oMensagem = new Modal('Atenção!', 'O cadastro Nº' . $this->Model->getNr() . ' não pode ser modificadao somente visualizado!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
    }

    public function carregaAnalise($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aAnalise = array();
        parse_str($sChave, $aAnalise);

        $oAnalise = $this->Persistencia->buscaDadosRC($aAnalise);


        $sAnalise = Util::limpaString($oAnalise->obs_aponta);


        switch ($oAnalise->tagsetor) {
            case 3:
                $sSetor = 'Expedição';
                break;
            case 5:
                $sSetor = 'Embalagem';
                break;
            case 25:
                $sSetor = 'Qualidade';
                break;
            default:
                $sSetor = 'Vendas';
                break;
        }

        $sProblema = $oAnalise->aplicacao . ' -  ' . Util::limpaString($oAnalise->naoconf);

        $sScriptDados = '$("#' . $aDados[2] . '").val("' . $sAnalise . '");';
        $sProblemas = '$("#' . $aDados[3] . '").val("' . $sProblema . '");';

        echo $sScriptDados;
        echo $sProblemas;
    }

    public function buscaNf($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaNf($aCamposChave['nf']);

        echo"$('#" . $aParam[0] . "').val('" . $oRow->data . "');"
        . "$('#" . $aParam[1] . "').val('" . number_format($oRow->nfsvlrtot, 2, ',', '.') . "');"
        . "$('#" . $aParam[2] . "').val('" . number_format($oRow->nfspesolq, 2, ',', '.') . "');"
        . "$('#" . $aParam[3] . "').val('" . $oRow->nfsclicgc . "');"
        . "$('#" . $aParam[4] . "').val('" . $oRow->nfsclinome . "');";
    }

    public function limpaUploads($aIds) {
        parent::limpaUploads($aIds);


        $sRetorno = "$('#" . $aIds[3] . "').fileinput('clear');"
                . "$('#" . $aIds[4] . "').fileinput('clear');"
                . "$('#" . $aIds[5] . "').fileinput('clear');";

        echo $sRetorno;
    }

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

        $aRet = $this->Persistencia->verifSitRC($aCamposChave);
        if ($aRet[0] == 'Apontada' && ($aRet[2] == 'Recusada' || $aRet[2] == 'Aceita')) {

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
            if ($aRet[0] == 'Finalizada') {
                $oMens = new Modal('Atenção...  A reclamação já foi finalizada!', '', Modal::TIPO_AVISO, false, true, false);
            }
            if ($aRet[0] == 'Aguardando') {
                $oMens = new Modal('Atenção... A reclamação ainda não foi liberada para Metalbo, favor efetuar a liberação da mesma para proseguir com a análise!', '', Modal::TIPO_AVISO, false, true, false);
            }
            if ($aRet[1] == 'Em análise' || $aRet[0] == 'Liberado') {
                $oMens = new Modal('Atenção... A reclamação não está em condições de ser finalizada, aguarde!', '', Modal::TIPO_AVISO, false, true, false);
            }
            echo $oMens->getRender();
            echo'$("#' . $aDados[1] . '-pesq").click();';
            echo "$('#" . $aDados[1] . "-btn').click();";
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

    public function reenviaEmail($sDados) {
        $aDados = explode(',', $sDados);
        $sIdGrid = $aDados[1];
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRet = $this->Persistencia->verifSitRC($aCamposChave);

        if ($aRet[0] == 'Liberado') {
            $oMensagem = new Modal('Atenção', 'A reclamação já foi liberada para a Metalbo! Deseja reenviar o e-mail?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberarMetalbo","' . $sDados . ',reenvia");');
        } else {
            if ($aRet[0] == 'Aguardando') {
                $oMensagem = new Modal('Atenção', 'A reclamação ainda não foi liberada para a Metalbo!', Modal::TIPO_AVISO, false, true, false);
            }
            if ($aRet[0] == 'Apontada' && $aRet[1] == 'Transportadora') {
                $oMensagem = new Modal('Atenção', 'A reclamação foi apontada e avaliada como avaria pela transportadora!', Modal::TIPO_AVISO, false, true, false);
            }
            if ($aRet[0] == 'Apontada' && $aRet[1] != 'Transportadora') {
                $oMensagem = new Modal('Atenção', 'A reclamação já foi apontada!', Modal::TIPO_AVISO, false, true, false);
            }
            if ($aRet[1] == 'Em análise') {
                $oMensagem = new Modal('Atenção', 'A reclamação já está em análise pela Metalbo!', Modal::TIPO_AVISO, false, true, false);
            }
            echo '$("#' . $sIdGrid . '-pesq").click();';
        }
        echo $oMensagem->getRender();
    }

    public function liberarMetalbo($sDados) {
        $aDados = explode(',', $sDados);
        if ($aDados[3] == 'reenvia') {
            $sIdGrid = $aDados[1];
            $sRc[0] = $aDados[2];
            $sChave = htmlspecialchars_decode($sRc[0]);
            $aCamposChave = array();
            parse_str($sChave, $aCamposChave);
            $this->geraPdfQualRC($aCamposChave, $aDados);
        } else {
            $sIdGrid = $aDados[1];
            $sRc[0] = $aDados[3];
            $sChave = htmlspecialchars_decode($sRc[0]);
            $aCamposChave = array();

            parse_str($sChave, $aCamposChave);
            $aRet = $this->Persistencia->verifSitRC($aCamposChave);

            if ($aRet[0] != 'Aguardando') {
                $oMensagem = new Modal('Atenção...  A reclamação já foi liberada para a Metalbo!', '', Modal::TIPO_AVISO, false, true, false);
                echo $oMensagem->getRender();
                return;
            } else {
                $sIdGrid = $aDados[1];
                $sRc[0] = $aDados[3];
                $sChave = htmlspecialchars_decode($sRc[0]);
                $aCamposChave = array();
                parse_str($sChave, $aCamposChave);
                $this->geraPdfQualRC($aCamposChave, $aDados);
            }
        }
    }

    public function geraPdfQualRC($aCamposChave, $aDados) {

        $_REQUEST['filcgcRc'] = $aCamposChave['filcgc'];
        $_REQUEST['nrRc'] = $aCamposChave['nr'];
        $_REQUEST['email'] = 'S';
        $_REQUEST['userRel'] = $_SESSION['nome'];

        $sIdGrid = $aDados[1];
        $sReenvia = $aDados[3];

        $aRetornoEmail = require 'app/relatorio/rc.php';

        if ($sReenvia == 'reenvia') {
            if ($aRetornoEmail[0] == true) {
                $oMsg = new Mensagem('Sucesso', 'Reclamação liberada para a Metalbo!', Mensagem::TIPO_SUCESSO);
                echo '$("#' . $sIdGrid . '-pesq").click();';
            } else {
                $oMsg = new Mensagem('Erro', 'Reclamação não pode ser liberada para a Metalbo! ', Mensagem::TIPO_WARNING);
            }
        }
        if ($sReenvia != 'reenvia') {
            if ($aRetornoEmail[0] == true) {
                $aUpdateSit = $this->Persistencia->liberaRC($aCamposChave);
                if ($aUpdateSit[0] == true) {
                    $oMsg = new Mensagem('Sucesso', 'Reclamação liberada para a Metalbo!', Mensagem::TIPO_SUCESSO);
                    echo '$("#' . $sIdGrid . '-pesq").click();';
                } else {
                    $oMsg = new Mensagem('Erro', 'Reclamação não pode ser liberada para a Metalbo! ', Mensagem::TIPO_WARNING);
                }
            }
        }
        echo $oMsg->getRender();
    }

    public function insereProd($sDados) {
        $aDados = explode(';', $sDados);

        $sProd = $aDados[0] . ' - ' . $aDados[1] . ' - ' . $aDados[2] . ' - ' . $aDados[3];


        $sProduto = "$('#" . $aDados[4] . "_tag').val('" . $sProd . "');"
                . "$('#" . $aDados[4] . "_tag').focus();"
                . "$('#" . $aDados[5] . "').focus();"
                . "$('#" . $aDados[4] . "_tag').focus();"
                . "$('#" . $aDados[5] . "').focus();";
        echo $sProduto;
        $this->limpaCampos($aDados);
    }

    public function limpaCampos($aDados) {
        $sLimpaCampos = '$("#' . $aDados[5] . '").val("");'
                . '$("#' . $aDados[6] . '").val("");'
                . '$("#' . $aDados[7] . '").val("");'
                . '$("#' . $aDados[8] . '").val("");';
        echo $sLimpaCampos;
    }

    public function notificaQualidade($aDados) {

        $sChave = htmlspecialchars_decode($aDados[3]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

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
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('E-mail automático METALBO'));

        $oRow = $this->Persistencia->buscaDadosRC($aCamposChave);

        $oEmail->setAssunto(utf8_decode('RECLAMAÇÃO DE CLIENTE'));
        $oEmail->setMensagem(utf8_decode('<span style="color:green;"><b>A RC número:' . $oRow->nr . ' foi FINALIZADA pelo representante</b></span><br/><br/>'
                        . '<b>FAZER APONTAMENTO DA INSPEÇÃO: Resultados de Inspeção de Recebimento da Reclamação!</b><br/><br/>'
                        . '<b>Responsável de Vendas: ' . $oRow->resp_venda_nome . ' </b><br/>'
                        . '<b>Representante: ' . $oRow->usunome . ' </b><br/>'
                        . '<b>Escritório: ' . $oRow->officedes . ' </b><br/>'
                        . '<b>Hora: ' . $hora . '  </b><br/>'
                        . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                        . '<table border = 1 cellspacing = 0 cellpadding = 2 width = "100%">'
                        . '<tr><td><b>Cnpj: </b></td><td> ' . $oRow->empcod . ' </td></tr>'
                        . '<tr><td><b>Razão Social: </b></td><td> ' . $oRow->empdes . ' </td></tr>'
                        . '<tr><td><b>Observação VENDAS: </b></td><td> ' . $oRow->obs_aponta . ' </td></tr>'
                        . '<tr><td><b>Observação ANÁLISE: </b></td><td> ' . $oRow->apontamento . ' </td></tr>'
                        . '</table><br/><br/>'
                        . '<b>Para mais informações, consulte o anexo!</b><br/>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        //$oEmail->addDestinatario('almoxarifado@metalbo.com.br');
        $oEmail->addDestinatario('alexandre@metalbo.com.br');

        $oEmail->addAnexo('app/relatorio/RC/RC' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf', utf8_decode('RC nº' . $aCamposChave['nr'] . '_empresa_' . $aCamposChave['filcgc'] . '.pdf'));

        $aRetorno = $oEmail->sendEmail();
    }

}
