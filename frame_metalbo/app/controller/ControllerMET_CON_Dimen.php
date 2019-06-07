<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_CON_Dimen extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_CON_Dimen');
    }

    public function buscaDadosProd($sDados) {
        $aDados = explode(',', $sDados);

        $oObj = $this->Persistencia->getCadDim($aDados[0]);


        if ($oObj == false) {
            $oMsg = new Mensagem('Atenção!', 'Código não existe, não pode ser vendido ou não possui cadastro.', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();

            $sLimpaCampos = '$("#' . $aDados[1] . '").val("");'
                    . '$("#' . $aDados[2] . '").val("");'
                    . '$("#' . $aDados[3] . '").val("");'
                    . '$("#' . $aDados[4] . '").val("");'
                    . '$("#' . $aDados[5] . '").val("");'
                    . '$("#' . $aDados[6] . '").val("");'
                    . '$("#' . $aDados[7] . '").val("");'
                    . '$("#' . $aDados[8] . '").val("");'
                    . '$("#' . $aDados[9] . '").val("");'
                    . '$("#' . $aDados[10] . '").val("");'
                    . '$("#' . $aDados[11] . '").val("");'
                    . '$("#' . $aDados[12] . '").val("");'
                    . '$("#' . $aDados[13] . '").val("");'
                    . '$("#' . $aDados[14] . '").val("");'
                    . '$("#' . $aDados[15] . '").val("");'
                    . '$("#' . $aDados[16] . '").val("");'
                    . '$("#' . $aDados[17] . '").val("");'
                    . '$("#' . $aDados[18] . '").val("");'
                    . '$("#' . $aDados[19] . '").val("");'
                    . '$("#' . $aDados[20] . '").val("");'
                    . '$("#' . $aDados[21] . '").val("");'
                    . '$("#' . $aDados[22] . '").val("");'
                    . '$("#' . $aDados[23] . '").val("");'
                    . '$("#' . $aDados[24] . '").val("");';

            echo $sLimpaCampos;
        } else {
            $sSetValorCampos = '$("#' . $aDados[1] . '").val("' . Util::formataSqlDecimal($oObj->prodchamin) . '");'
                    . '$("#' . $aDados[2] . '").val("' . Util::formataSqlDecimal($oObj->prodchamax) . '");'
                    . '$("#' . $aDados[3] . '").val("' . Util::formataSqlDecimal($oObj->prodaltmin) . '");'
                    . '$("#' . $aDados[4] . '").val("' . Util::formataSqlDecimal($oObj->prodaltmax) . '");'
                    . '$("#' . $aDados[5] . '").val("' . Util::formataSqlDecimal($oObj->proddiamin) . '");'
                    . '$("#' . $aDados[6] . '").val("' . Util::formataSqlDecimal($oObj->proddiamax) . '");'
                    . '$("#' . $aDados[7] . '").val("' . Util::formataSqlDecimal($oObj->procommin) . '");'
                    . '$("#' . $aDados[8] . '").val("' . Util::formataSqlDecimal($oObj->procommax) . '");'
                    . '$("#' . $aDados[9] . '").val("' . Util::formataSqlDecimal($oObj->prodiapmin) . '");'
                    . '$("#' . $aDados[10] . '").val("' . Util::formataSqlDecimal($oObj->prodiapmax) . '");'
                    . '$("#' . $aDados[11] . '").val("' . Util::formataSqlDecimal($oObj->prodiaemin) . '");'
                    . '$("#' . $aDados[12] . '").val("' . Util::formataSqlDecimal($oObj->prodiaemax) . '");'
                    . '$("#' . $aDados[13] . '").val("' . Util::formataSqlDecimal($oObj->procomrmin) . '");'
                    . '$("#' . $aDados[14] . '").val("' . Util::formataSqlDecimal($oObj->procomrmax) . '");'
                    . '$("#' . $aDados[15] . '").val("' . Util::formataSqlDecimal($oObj->comphastma) . '");'
                    . '$("#' . $aDados[16] . '").val("' . Util::formataSqlDecimal($oObj->comphastmi) . '");'
                    . '$("#' . $aDados[17] . '").val("' . Util::formataSqlDecimal($oObj->diamhastmi) . '");'
                    . '$("#' . $aDados[18] . '").val("' . Util::formataSqlDecimal($oObj->diamhastma) . '");'
                    . '$("#' . $aDados[19] . '").val("' . Util::formataSqlDecimal($oObj->pfcmin) . '");'
                    . '$("#' . $aDados[20] . '").val("' . Util::formataSqlDecimal($oObj->pfcmax) . '");'
                    . '$("#' . $aDados[22] . '").val("' . (int) $oObj->prodacab . '");'
                    . '$("#' . $aDados[23] . '").val("' . $oObj->promatcod . '");'
                    . '$("#' . $aDados[24] . '").val("' . $oObj->proclasseg . '");';
            $teste = strlen($oObj->proanghel);
            if ($teste > 0) {
                $sSetValorCampos .= '$("#' . $aDados[21] . '").val("' . $oObj->proanghel . '");';
            }
            echo $sSetValorCampos;
        }
    }

}
