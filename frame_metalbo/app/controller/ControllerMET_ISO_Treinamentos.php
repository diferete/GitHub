<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_ISO_Treinamentos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ISO_Treinamentos');
    }

    public function buscaDadosFunc($sDados) {
        $aDados = $this->getArrayCampostela();
        $aIdCampos = explode(',', $sDados);
        $oRetorno = $this->Persistencia->buscaDadosFunc($aDados);
//        
//        if($oRetorno->sit != 'Demitido'){
//            $oRetorno->sit = 'Ativo';
//        }else{
//            $oRetorno->sit = 'Inativo';
//        }

        $script = '$("#' . $aIdCampos[0] . '").val("' . $oRetorno->nomfun . '");'
                . '$("#' . $aIdCampos[1] . '").val("' . $oRetorno->sit . '");'
                . '$("#' . $aIdCampos[2] . '").val("' . $oRetorno->setor . '");'
                . '$("#' . $aIdCampos[3] . '").val("' . $oRetorno->cargo . '");';

        echo $script;
    }

}
