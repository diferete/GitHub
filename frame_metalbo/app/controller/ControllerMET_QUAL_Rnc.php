<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_QUAL_Rnc extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_Rnc');
    }

    public function buscaDadosOp($sDados) {
        $aIdCampos = explode(',', $sDados);
        $aDados = $this->getArrayCampostela();
        $oRetorno = $this->Persistencia->buscaDadosOp($aDados['op'], $aDados['filcgc']);
        $script = "$('#" . $aIdCampos[0] . "').val('" . $oRetorno->cod . "');"
                . "$('#" . $aIdCampos[1] . "').val('" . $oRetorno->prodes . "');";

        echo $script;
    }

      public function buscaDadoscodmat($sDados) {
        $aIdCampos = explode(',', $sDados);
        $aDados = $this->getArrayCampostela();
        $oRetorno = $this->Persistencia->buscaDadoscodmat($aDados['codmat']);
        $script =  "$('#" . $aIdCampos[0] . "').val('" . $oRetorno->prodes . "');";

        echo $script;
    }
    
    
        public function buscaDadoscodprod($sDados) {
        $aIdCampos = explode(',', $sDados);
        $aDados = $this->getArrayCampostela();
        $oRetorno = $this->Persistencia->buscaDadoscodprod($aDados['codprod']);
        $script = "$('#" . $aIdCampos[0] . "').val('" . $oRetorno->prodes . "');";

        echo $script;
    }
    
    
    
    
    
    public function acaoMostraRelEspecifico($renderTo, $sMetodo = '') {
        parent::acaoMostraRelEspecifico($renderTo, $sMetodo);

        $sDados = htmlspecialchars_decode($sMetodo);
        $aCamposChave = array();
        parse_str($sDados, $aCamposChave);

        $sSistema = "app/relatorio";
        $sRelatorio = 'documentoRNC.php?' . $sDados;

        $sCampos.= $this->getSget();

        $sCampos.='&output=tela';
        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function acaoCancelaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRetorno = $this->Persistencia->buscaDados($aCamposChave);
        if ($oRetorno->sit != 'Aguardando') {
            $oModal = new Modal('Atenção', 'RNC já foi ' . $oRetorno->sit . '', Modal::TIPO_AVISO);
            echo $oModal->getRender();
        } else {
            $aRetorno = $this->Persistencia->CancelaRnc($aCamposChave);
            if ($aRetorno) {
                $oMsg = new Mensagem('Sucesso', 'Sua RNC foi Cancelada com sucesso', Mensagem::TIPO_SUCESSO);
                echo $oMsg->getRender();
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMsg = new Mensagem('Atenção', 'Sua RNC não foi Cancelada', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }
        }
    }

    public function acaoFinalizaRnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();       
        parse_str($sChave, $aCamposChave);

        $oRetorno = $this->Persistencia->buscaDados($aCamposChave);
        if ($oRetorno->sit != 'Aguardando') {
            $oModal = new Modal('Atenção', 'RNC já foi ' . $oRetorno->sit . '', Modal::TIPO_AVISO);
            echo $oModal->getRender();
        } else {
            $aRetorno = $this->Persistencia->FinalizaRnc($aCamposChave);
            if ($aRetorno) {
                $oMsg = new Mensagem('Sucesso', 'Sua RNC foi Finalizada com sucesso', Mensagem::TIPO_SUCESSO);
                echo $oMsg->getRender();
                echo"$('#" . $aDados[1] . "-pesq').click();";
            } else {
                $oMsg = new Mensagem('Atenção', 'Sua RNC não foi Finalizada', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
            }
        }
    }

    public function adicionaColaborador($sDados) {
        $aDados = explode(',', $sDados);

        $script = '$("#' . $aDados[0] . '_tag").val("' . $aDados[1] . '");'
                . '$("#' . $aDados[0] . '_tag").focus();'
                . '$("#' . $aDados[2] . '").focus();'
                . '$("#' . $aDados[0] . '_tag").focus();'
                . '$("#' . $aDados[2] . '").focus();';

        echo $script;
        echo '$("#' . $aDados[2] . '").val("");';
    }
    
    
}
