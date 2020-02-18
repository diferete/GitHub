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

    public function adicionaCorrida($sDados) {
        $aDados = explode(',', $sDados);

        $bRetorno = $this->Persistencia->buscaCorrida($aDados[1]);


        $script = '$("#' . $aDados[0] . '_tag").val("' . $aDados[1] . '");'
                . '$("#' . $aDados[0] . '_tag").focus();'
                . '$("#' . $aDados[2] . '").focus();'
                . '$("#' . $aDados[2] . '").focus();';

        echo $script;
        echo '$("#' . $aDados[2] . '").val("");';
        if ($bRetorno == false) {
            $oMsg = new Mensagem('Atenção', 'Corrida não encontrada no sistema', Modal::TIPO_AVISO);
            echo $oMsg->getRender();
        }
    }

}
