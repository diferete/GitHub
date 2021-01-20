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
        $this->Persistencia->updateTreinamentos();
    }

    public function buscaDadosFunc($sDados) {
        $aDados = $this->getArrayCampostela();
        if ($aDados['cracha'] == '') {
            exit;
        } else {
            $aIdCampos = explode(',', $sDados);

            $oRetorno = $this->Persistencia->buscaDadosColaborador($aDados);
            $oFuncao = $this->Persistencia->buscaDadosFuncao($oRetorno);

            if ($oRetorno->dessit == 'Demitido') {
                $oRetorno->dessit = 'Inativo';
            } else {
                $oRetorno->dessit = 'Ativo';
            }
            $script = '$("#' . $aIdCampos[0] . '").val("' . $oRetorno->nomfun . '");'
                    . '$("#' . $aIdCampos[1] . '").val("' . $oRetorno->dessit . '");'
                    . '$("#' . $aIdCampos[2] . '").val("' . $oRetorno->nomccu . '");'
                    . '$("#' . $aIdCampos[3] . '").val("' . $oRetorno->titcar . '");'
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


        $aDados = $this->Persistencia->somaFunc();

        $sResulta = '<div style="color:black !important">Total de Registros: ' . $aDados['total'] . '';
        if ($aDados['crachas'] > 0) {
            $sResulta .= '<span style="color:#ff6600 !important">&nbsp;&nbsp;&nbsp; Grau de Escolaridade Incompatível com função: ' . $aDados['crachas'] . '</span>';
        }
        $sResulta .= '<div id="titulolinhatempo">'
                . '<h3 class="panel-title"></h3></br>'
                . '</div>'
                . '<div class="pearls pearls-xs row" id="treinamentoTempo">'
                . '</div>';

        return $sResulta;
    }

    /**
     * Gerencia estilo de cores do wizard conforme status do projeto
     * */
    public function renderTreinamento($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aDados[0] == '') {
            echo '$("#treinamentoTempo").empty();';
            echo '$("#titulolinhatempo").empty();';
        } else {
            $aRetorno = $this->Persistencia->buscaTreinamentos($aCamposChave);

            $sLinha = '';

            if ($aRetorno != '') {
                foreach ($aRetorno as $key => $value) {
                    /*
                     * $aTreinamento[0] -> Revisao Geral do Documento
                     * $aTreinamento[1] -> Nome do Documento a ser passado treinamento
                     * $aTreinamento[2] -> Revisao do Documento que foi passado o treinamento
                     * */
                    $aTreinamento = explode(',', $value);


                    if ($aTreinamento[0] == $aTreinamento[2]) {
                        $sClasseTreinamento = 'current';
                        $sEstiloTreinamento = 'border-color:green;color:green';
                        $sTreinamento = substr($aTreinamento[1], 0, 10);

                        $sLinha = $sLinha . '<div id="0" class="pearl ' . $sClasseTreinamento . ' col-lg-1 col-md-1 col-sm-1 col-xs-1 ">'
                                . '<div class="pearl-icon" style="' . $sEstiloTreinamento . '">'
                                . '<i class="icon wb-check" aria-hidden="true"></i>'
                                . '</div>'
                                . '<span class="pearl-title" style="font-size:12px">' . $sTreinamento . '</span>'
                                . '</div>';
                    }
                    if ($aTreinamento[0] != $aTreinamento[2]) {
                        $sClasseTreinamento = 'current';
                        $sEstiloTreinamento = 'border-color:orange;color:orange';
                        $sTreinamento = substr($aTreinamento[1], 0, 10);

                        $sLinha = $sLinha . '<div id="0" class="pearl ' . $sClasseTreinamento . ' col-lg-1 col-md-1 col-sm-1  col-xs-1 ">'
                                . '<div class="pearl-icon" style="' . $sEstiloTreinamento . '">'
                                . '<i class="icon wb-close" aria-hidden="true"></i>'
                                . '</div>'
                                . '<span class="pearl-title" style="font-size:12px">' . $sTreinamento . '</span>'
                                . '</div>';
                    }
                }
            }



            $sRender = '$("#treinamentoTempo").empty();';
            $sRender .= '$("#treinamentoTempo").append(\'' . $sLinha . '\');';
            echo $sRender;
            //coloca o titulo
            echo '$("#titulolinhatempo").empty();';
            $sTitulo = '<h3 class="panel-title">Treinamentos por funcionario</h3></br>';
            echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';
        }
    }

    public function updateTreinamentos() {
        $this->Persistencia->updateTreinamentos();
    }

}
