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

        $aDados = $this->Persistencia->buscaRespEscritório($sDados);
        $this->View->setAParametrosExtras($aDados);
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

        $aRet = $this->Persistencia->verificaFim($aCamposChave);
        if ($aRet[1] == 'Aceita' & $aRet[0] != 'Finalizada' || $aRet[1] == 'Recusada' & $aRet[0] != 'Finalizada') {

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
                echo $oMens->getRender();
                echo'$("#' . $aDados[1] . '-pesq").click();';
            } if ($aRet[0] == 'Aguardando') {
                $oMens = new Modal('Atenção... A reclamação ainda não foi liberada para Metalbo, favor efetuar a liberação da mesma para proseguir com a análise!', '', Modal::TIPO_AVISO, false, true, false);
                echo $oMens->getRender();
                echo'$("#' . $aDados[1] . '-pesq").click();';
            } if ($aRet[1] == 'Em análise' || $aRet[0] == 'Liberado') {
                $oMens = new Modal('Atenção... A reclamação não está em condições de ser finalizada, aguarde!', '', Modal::TIPO_AVISO, false, true, false);
                echo $oMens->getRender();
                echo'$("#' . $aDados[1] . '-pesq").click();';
            }
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
            $oMsg = new Mensagem('Sucesso', 'Reclamação nº' . $aCampos['nr'] . ' foi finalizada!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo '$("#' . $aDados[2] . '-pesq").click();';
        } else {
            
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

    public function geraPdfQualRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sIdGrid = $aDados[1];
        $sAq[] = $aDados[3];
        $sChave = htmlspecialchars_decode($sAq[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);


        $aRet = $this->Persistencia->verificaFim($aCamposChave);

        if ($aRet[0] != 'Aguardando') {
            $oMensagem = new Modal('Atenção...  A reclamação já foi liberada para a Metalbo!', '', Modal::TIPO_AVISO, false, true, false);
            echo $oMensagem->getRender();
            echo '$("#' . $sIdGrid . '-pesq").click();';
        } else {

            $_REQUEST['filcgcRc'] = $aCamposChave['filcgc'];
            $_REQUEST['nrRc'] = $aCamposChave['nr'];
            $_REQUEST['email'] = 'S';
            $_REQUEST['userRel'] = $_SESSION['nome'];

            $aRetornoEmail = require 'app/relatorio/rc.php';
        }
        if ($aRetornoEmail[0] == true) {
            $aUpdateSit = $this->Persistencia->liberaRnc($aCamposChave);
            if ($aUpdateSit[0] == true) {
                $oMsg = new Mensagem('Sucesso', 'Reclamação liberada para a Metalbo!', Mensagem::TIPO_SUCESSO);
                echo $oMsg->getRender();
                echo '$("#' . $sIdGrid . '-pesq").click();';
            } else {
                $oMsg = new Mensagem('Erro', 'Reclamação não pode ser liberada para a Metalbo! ', Mensagem::TIPO_WARNING);
                echo $oMsg->getRender();
            }
        }
    }

}
