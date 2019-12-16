<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_ISO_Treinamentos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ISO_Treinamentos');
        $this->setControllerDetalhe('MET_ISO_RegistroTreinamento');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        $aDados = $this->getArrayCampostela();
        $aRetorno[2] = $aDados['nome'];

        return $aRetorno;
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $this->Persistencia->updateEscolaridade();
    }

    public function buscaDadosFunc($sDados) {
        $aDados = $this->getArrayCampostela();
        if ($aDados['cracha'] == '') {
            exit;
        } else {
            $aIdCampos = explode(',', $sDados);

            $oRetorno = $this->Persistencia->buscaDadosColaborador($aDados);
            $oFuncao = $this->Persistencia->buscaDadosFuncao($oRetorno);

            if ($oRetorno->sit == 'Demitido') {
                $oRetorno->sit = 'Inativo';
            } else {
                $oRetorno->sit = 'Ativo';
            }
            $script = '$("#' . $aIdCampos[0] . '").val("' . $oRetorno->nomfun . '");'
                    . '$("#' . $aIdCampos[1] . '").val("' . $oRetorno->sit . '");'
                    . '$("#' . $aIdCampos[2] . '").val("' . $oRetorno->setor . '");'
                    . '$("#' . $aIdCampos[3] . '").val("' . $oRetorno->cargo . '");'
                    . '$("#' . $aIdCampos[4] . '").val("' . $oRetorno->desgra . '");';

            if ($oFuncao->esc_exigida > $oRetorno->grains) {
                $oMensagem = new Mensagem('Atenção', 'Escolaridade inconpatível com função exercida!', Mensagem::TIPO_ERROR, 10000);
                echo $oMensagem->getRender();
                $scriptEscolaridade = '$("#' . $aIdCampos[5] . '").val("I");';
            } else {
                $scriptEscolaridade = '$("#' . $aIdCampos[5] . '").val("C");';
            }
            echo $script . $scriptEscolaridade;
        }
    }

    public function afterDelete() {
        parent::afterDelete();

        $aDados[0] = $this->Model->getFilcgc();
        $aDados[1] = $this->Model->getNr();
        $this->Persistencia->deletaDependencias($aDados);


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     * */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);


        $oFuncao = $this->Persistencia->somaFunc();

        $sResulta = '<div style="color:black !important">Total de Registros: ' . $oFuncao . ''
                . '<span style="color:blue !important">&nbsp;&nbsp;&nbsp;  Iniciados: ' . $oFuncao . '</span>'
                . '<span style="color:green !important">&nbsp;&nbsp;&nbsp;  Finalizados: ' . $oFuncao . '</span>'
                . '<span style="color:red !important">&nbsp;&nbsp;&nbsp;  Cancelados: ' . $oFuncao . '</span>'
                . '</div>';

        return $sResulta;
    }

}
