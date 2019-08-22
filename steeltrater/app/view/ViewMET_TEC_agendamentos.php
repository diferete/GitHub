<?php

/* 
 * Implementa a classe view dos agendamentos
 */


class ViewMET_TEC_agendamentos extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNr = new CampoConsulta('Nr','nr');
        $oTitulo = new CampoConsulta('Título','titulo');
        $oClasse = new CampoConsulta('Classe','classe');
        $oMetodo = new CampoConsulta('Método','metodo');
        $oData = new CampoConsulta('Data','data', CampoConsulta::TIPO_DATA);
        $oHora = new CampoConsulta('Hora','hora', CampoConsulta::TIPO_TIME);
        
        $oNrFiltro = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL,2,2,2,2);
        $oTitFiltro = new Filtro($oTitulo, Filtro::CAMPO_TEXTO,4,4,4,4);
        
        $this->addFiltro($oNrFiltro,$oTitFiltro);
        
        $this->addCampos($oNr,$oTitulo,$oClasse,$oMetodo,$oData,$oHora);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oNr = new Campo('Nr','nr', Campo::TIPO_TEXTO,1,1,1,1);
        $oTitulo = new Campo('Título','titulo', Campo::TIPO_TEXTO,8,8,8,8);
        $oClasse = new campo('Classe','classe', Campo::TIPO_TEXTO,3,3,3,3);
        $oClasse->setSCorFundo(Campo::FUNDO_AMARELO);
        $oMetodo = new campo('Método','metodo', Campo::TIPO_TEXTO,3,3,3,3);
        $oMetodo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oData = new campo('Data','data', Campo::TIPO_DATA,2,2,2,2);
        $oData->setSValor(Util::getDataAtual());
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,1,1,1,1);
        $oHora->setBTime(TRUE);
        $oParametros = new Campo('Parametros','parametros', Campo::TIPO_TEXTAREA,8,8,8,8);
        $oObs = new Campo('Obs','obs', Campo::TIPO_TEXTAREA,8,8,8,8);
        
        $oAgendamento = new campo('Agendamento','agendamento', Campo::CAMPO_SELECTSIMPLE,4,4,4,4);
        $oAgendamento->addItemSelect('nadata','Na data e hora somente uma vez');
        $oAgendamento->addItemSelect('hora','Todo dia na hora e minuto selecionado');
        $oAgendamento->addItemSelect('minuto','No intervalo de minutos');
        
        $oIntervalo = new campo('Intervalo em minutos','intervalominuto', Campo::TIPO_TEXTO,2,2,2,2);
        $oIntervalo->setBTime(true);
        
        
        $oLinha = new Campo('','linha', Campo::TIPO_LINHA,12,12,12,12);
        $oLinha->setApenasTela(true);
        
        $oLinha2 = new Campo('OBSERVAÇÕES E PARAMETROS','linha2', Campo::DIVISOR_DARK,12,12,12,12);
        $oLinha2->setApenasTela(true);
        
        
        $this->addCampos($oNr,$oLinha,$oTitulo,$oLinha,array($oClasse,$oMetodo),
                $oLinha,$oAgendamento,$oLinha,array($oData,$oHora,$oIntervalo),$oLinha,$oLinha2,$oLinha,$oParametros,$oLinha,$oObs);
        
    }
}
