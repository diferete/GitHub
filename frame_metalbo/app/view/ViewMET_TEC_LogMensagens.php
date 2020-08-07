<?php 
 /*
 * Implementa a classe view MET_TEC_LogMensagens
 * @author Alexandre de Souza
 * @since 18/05/2020
 */ 
class ViewMET_TEC_LogMensagens extends View { 
    public function __construct() {
        parent::__construct();
       } 
    public function criaConsulta() { 
        parent::criaConsulta(); 
        $this->setUsaAcaoVisualizar(true); 

        $ofilcgc = new CampoConsulta('filcgc', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oseq = new CampoConsulta('seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $ousucodigo = new CampoConsulta('usucodigo', 'usucodigo', CampoConsulta::TIPO_TEXTO);
        $odataLog = new CampoConsulta('dataLog', 'dataLog', CampoConsulta::TIPO_DATA);
        $ohoraLog = new CampoConsulta('horaLog', 'horaLog', CampoConsulta::TIPO_TEXTO);
        $omensagem = new CampoConsulta('mensagem', 'mensagem', CampoConsulta::TIPO_TEXTO);
        $olida = new CampoConsulta('lida', 'lida', CampoConsulta::TIPO_TEXTO); 
        $this->addCampos($ofilcgc, $oseq, $ousucodigo, $odataLog, $ohoraLog, $omensagem, $olida);
    } 
    public function criaTela() { 
        parent::criaTela(); 

        $ofilcgc = new Campo('filcgc', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oseq = new Campo('seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ousucodigo = new Campo('usucodigo', 'usucodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odataLog = new Campo('dataLog', 'dataLog', Campo::TIPO_DATA, 1, 1, 12, 12);
        $ohoraLog = new Campo('horaLog', 'horaLog', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $omensagem = new Campo('mensagem', 'mensagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $olida = new Campo('lida', 'lida', Campo::TIPO_TEXTO, 1, 1, 12, 12); 
        $this->addCampos($ofilcgc, $oseq, $ousucodigo, $odataLog, $ohoraLog, $omensagem, $olida);
    } 
}