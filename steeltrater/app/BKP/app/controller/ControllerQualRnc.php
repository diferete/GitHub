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

        if ($oTag == null) {
            if (($oLote == '' || $oOp == '') || ($oLote == null || $oOp == null)) {
                $oMsg = new Modal('Atenção', 'Favor preencer os campos de LOTE e ORDEM DE PRODUÇÃO, solicitar com o Cliente!', Modal::TIPO_AVISO, FALSE, TRUE, FALSE);
                echo $oMsg->getRender();

                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            } else {

                $aRetorno = array();
                $aRetorno[0] = true;
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

    /**
     * Aprova final rnc 
     * @param type $sDados
     */
    public function finalizaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRet = $this->Persistencia->finalizaAcao($aCampos);


        if ($aRet[0]) {
            $oMsg = new Mensagem('Sucesso', 'Reclamação nº' . $aCampos['nr'] . ' foi finalizada!', Mensagem::TIPO_SUCESSO);
        } else {
            $oMsg = new Modal('Atenção', 'Erro ao tentar finalizar reclamação!', Modal::TIPO_AVISO, false, true, true);
        }
        echo $oMsg->getRender();
        echo '$("#' . $aDados[2] . '-pesq").click();';
        echo "$('#" . $aDados[2] . "-btn').click();";
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
            $this->geraPdfQualRnc($aCamposChave, $aDados);
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
                $this->geraPdfQualRnc($aCamposChave, $aDados);
            }
        }
    }

    public function geraPdfQualRnc($aCamposChave, $aDados) {

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
                $aUpdateSit = $this->Persistencia->liberaRnc($aCamposChave);
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


        $sProduto = '$("#' . $aDados[4] . '_tag").val("' . $sProd . '");'
                . '$("#' . $aDados[4] . '_tag").focus();'
                . '$("#' . $aDados[5] . '").focus();'
                . '$("#' . $aDados[5] . '").focus();';
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

}
