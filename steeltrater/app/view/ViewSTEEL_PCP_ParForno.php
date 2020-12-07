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

        $ocod = new CampoConsulta('cod', 'cod', CampoConsulta::TIPO_TEXTO);
        $ocodmotivo = new CampoConsulta('codmotivo', 'codmotivo', CampoConsulta::TIPO_TEXTO);
        $ofornocod = new CampoConsulta('fornocod', 'fornocod', CampoConsulta::TIPO_TEXTO);
        $odatainicio = new CampoConsulta('datainicio', 'datainicio', CampoConsulta::TIPO_DATA);
        $ohorainicio = new CampoConsulta('horainicio', 'horainicio', CampoConsulta::TIPO_TEXTO);
        $ocoduseraberto = new CampoConsulta('coduseraberto', 'coduseraberto', CampoConsulta::TIPO_TEXTO);
        $odesuseraberto = new CampoConsulta('desuseraberto', 'desuseraberto', CampoConsulta::TIPO_TEXTO);
        $ocoduserfechou = new CampoConsulta('coduserfechou', 'coduserfechou', CampoConsulta::TIPO_TEXTO);
        $odesuserfechou = new CampoConsulta('desuserfechou', 'desuserfechou', CampoConsulta::TIPO_TEXTO);
        $odatafim = new CampoConsulta('datafim', 'datafim', CampoConsulta::TIPO_DATA);
        $ohorafim = new CampoConsulta('horafim', 'horafim', CampoConsulta::TIPO_TEXTO);
        $oobs = new CampoConsulta('obs', 'obs', CampoConsulta::TIPO_TEXTO); 
        $this->addCampos($ocod, $ocodmotivo, $ofornocod, $odatainicio, $ohorainicio, $ocoduseraberto, $odesuseraberto, $ocoduserfechou, $odesuserfechou, $odatafim, $ohorafim, $oobs);
    } 
    public function criaTela() { 
        parent::criaTela(); 

        $ocod = new Campo('cod', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocodmotivo = new Campo('codmotivo', 'codmotivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ofornocod = new Campo('fornocod', 'fornocod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odatainicio = new Campo('datainicio', 'datainicio', Campo::TIPO_DATA, 1, 1, 12, 12);
        $ohorainicio = new Campo('horainicio', 'horainicio', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocoduseraberto = new Campo('coduseraberto', 'coduseraberto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odesuseraberto = new Campo('desuseraberto', 'desuseraberto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocoduserfechou = new Campo('coduserfechou', 'coduserfechou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odesuserfechou = new Campo('desuserfechou', 'desuserfechou', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odatafim = new Campo('datafim', 'datafim', Campo::TIPO_DATA, 1, 1, 12, 12);
        $ohorafim = new Campo('horafim', 'horafim', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oobs = new Campo('obs', 'obs', Campo::TIPO_TEXTO, 1, 1, 12, 12); 
        $this->addCampos($ocod, $ocodmotivo, $ofornocod, $odatainicio, $ohorainicio, $ocoduseraberto, $odesuseraberto, $ocoduserfechou, $odesuserfechou, $odatafim, $ohorafim, $oobs);
    } 
}