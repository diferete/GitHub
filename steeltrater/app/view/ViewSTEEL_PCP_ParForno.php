<?php

/*
 * Implementa a classe view STEEL_PCP_ParForno
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */

class ViewSTEEL_PCP_ParForno extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);


        $ocod = new CampoConsulta('Cod', 'cod', CampoConsulta::TIPO_TEXTO);
        $ocodmotivo = new CampoConsulta('Cod Motivo', 'codmotivo', CampoConsulta::TIPO_TEXTO);
        $ofornocod = new CampoConsulta('Forno', 'fornocod', CampoConsulta::TIPO_TEXTO);
        $odatainicio = new CampoConsulta('Data Inicial', 'datainicio', CampoConsulta::TIPO_DATA);
        $ohorainicio = new CampoConsulta('Hora Inicial', 'horainicio', CampoConsulta::TIPO_TEXTO);
        // $ocoduseraberto = new CampoConsulta('coduseraberto', 'coduseraberto', CampoConsulta::TIPO_TEXTO);
        $odesuseraberto = new CampoConsulta('Usuário', 'desuseraberto', CampoConsulta::TIPO_TEXTO);
        // $ocoduserfechou = new CampoConsulta('coduserfechou', 'coduserfechou', CampoConsulta::TIPO_TEXTO);
        // $odesuserfechou = new CampoConsulta('desuserfechou', 'desuserfechou', CampoConsulta::TIPO_TEXTO);
        $odatafim = new CampoConsulta('Data Final', 'datafim', CampoConsulta::TIPO_DATA);
        $ohorafim = new CampoConsulta('Hora Final', 'horafim', CampoConsulta::TIPO_TEXTO);
        //$oobs = new CampoConsulta('Observação', 'obs', CampoConsulta::TIPO_TEXTO);

        $this->addCampos($ocod, $ocodmotivo, $ofornocod, $odatainicio, $ohorainicio, $odatafim, $ohorafim, $odesuseraberto);
    }

    public function criaTela() {
        parent::criaTela();

        $ocod = new Campo('Cod', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocod->setBCampoBloqueado(true);

        $aDados = $this->getAParametrosExtras();
        $aFornos = $aDados[1];
        $aMotivos = $aDados[2];

        $ofornocod = new Campo('Forno', 'fornocod', Campo::CAMPO_SELECTSIMPLE, 3, 3, 12, 12);
        foreach ($aFornos as $keyForno => $oValueForno) {
            $ofornocod->addItemSelect($oValueForno->getFornocod(), $oValueForno->getFornodes());
        }

        $ocodmotivo = new Campo('Motivo', 'codmotivo', Campo::CAMPO_SELECTSIMPLE, 3, 3, 12, 12);
        foreach ($aMotivos as $keyMotivo => $oValueMotivo) {
            $ocodmotivo->addItemSelect($oValueMotivo->getCodmotivo(), $oValueMotivo->getCodmotivo() . " - " . $oValueMotivo->getDescricao());
        }

        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');

        $odatainicio = new Campo('Data Inicial', 'datainicio', Campo::TIPO_DATA, 2, 2, 12, 12);
        $odatainicio->setSValor($sData);

        $ohorainicio = new Campo('Hora Inicial', 'horainicio', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $ohorainicio->setSValor($sHora);

        $odatafim = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);
        $odatafim->setSValor($sData);

        $ohorafim = new Campo('Hora Final', 'horafim', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $ohorafim->setSValor($sHora);

//        $ocoduseraberto = new Campo('Cod. Usuario', 'coduseraberto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
//        $odesuseraberto = new Campo('Descrição Usuário', 'desuseraberto', Campo::TIPO_TEXTO, 3, 3, 12, 12);
//        
        //user saida
        $ocoduseraberto = new Campo('Cod.Usuário', 'coduseraberto', Campo::TIPO_BUSCADOBANCOPK, 3);
        $ocoduseraberto->setSValor($_SESSION['codUser']);

        //campo descrição do usuário
        $odesuseraberto = new Campo('Descrição', 'desuseraberto', Campo::TIPO_BUSCADOBANCO, 4);
        $odesuseraberto->setSIdPk($ocoduseraberto->getId());
        $odesuseraberto->setClasseBusca('MET_TEC_Usuario');
        $odesuseraberto->addCampoBusca('usucodigo', '', '');
        $odesuseraberto->addCampoBusca('usunome', '', '');
        $odesuseraberto->setSIdTela($this->getTela()->getId());
        $odesuseraberto->setSValor($_SESSION['nome']);

        //declarar o campo descrição
        $ocoduseraberto->setClasseBusca('MET_TEC_Usuario');
        $ocoduseraberto->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $ocoduseraberto->addCampoBusca('usunome', $odesuseraberto->getId(), $this->getTela()->getId());


        // $ocoduserfechou = new Campo('coduserfechou', 'coduserfechou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        // $odesuserfechou = new Campo('desuserfechou', 'desuserfechou', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oobs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);

        $oL1 = new Campo('', 'l1', Campo::TIPO_LINHABRANCO);
        $oL1->setApenasTela(true);

        $this->addCampos(array($ocod, $ofornocod, $ocodmotivo), $oL1, array($odatainicio, $ohorainicio, $odatafim, $ohorafim), $oL1, array($ocoduseraberto, $odesuseraberto)/* , $ocoduserfechou, $odesuserfechou, */, $oL1, $oobs);
    }

    public function criaModalApontaParada() {
        parent::criaModal();

        $this->getTela()->setSId('ModalApontaParada');
        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        //botao inserir apontamento
        $oBtnInserir = new Campo('Apontar Parada', '', Campo::TIPO_BOTAOSMALL_SUB, 5, 5, 5, 5);

        $ofornocod = new Campo('fornocod', 'fornocod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocodmotivo = new Campo('codmotivo', 'codmotivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odatainicio = new Campo('datainicio', 'datainicio', Campo::TIPO_DATA, 1, 1, 12, 12);
        $ohorainicio = new Campo('horainicio', 'horainicio', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocoduseraberto = new Campo('coduseraberto', 'coduseraberto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odesuseraberto = new Campo('desuseraberto', 'desuseraberto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocoduserfechou = new Campo('coduserfechou', 'coduserfechou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odesuserfechou = new Campo('desuserfechou', 'desuserfechou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odatafim = new Campo('datafim', 'datafim', Campo::TIPO_DATA, 1, 1, 12, 12);
        $ohorafim = new Campo('horafim', 'horafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oobs = new Campo('obs', 'obs', Campo::TIPO_TEXTO, 1, 1, 12, 12);


        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ParForno","ApontParada");';
        $oBtnInserir->getOBotao()->addAcao($sAcao);

        $this->addCampos(array($ofornocod, $ocodmotivo), $odatainicio, $ohorainicio, $ocoduseraberto, $odesuseraberto, $ocoduserfechou, $odesuserfechou, $odatafim, $ohorafim, $oobs, $oBtnInserir);
    }

}
