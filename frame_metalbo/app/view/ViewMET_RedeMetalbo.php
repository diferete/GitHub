<?php 
 /*
 * Implementa a classe view MET_RedeMetalbo
 * @author Cleverton Hoffmann
 * @since 29/10/2020
 */
 
class ViewMET_RedeMetalbo extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
 

        $oCOD = new CampoConsulta('COD', 'cod', CampoConsulta::TIPO_TEXTO);
        $oHOSTNAME = new CampoConsulta('HOSTNAME', 'hostname', CampoConsulta::TIPO_TEXTO);
        $oIP = new CampoConsulta('IP', 'ip', CampoConsulta::TIPO_TEXTO);
        $oOBS = new CampoConsulta('OBS', 'obs', CampoConsulta::TIPO_TEXTO);
        $oMAC = new CampoConsulta('MAC', 'mac', CampoConsulta::TIPO_TEXTO);
        $oTIPO = new CampoConsulta('TIPO', 'tipo', CampoConsulta::TIPO_TEXTO);
        $oTIPO->addComparacao('VAGO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oTIPO->addComparacao('OCUPADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, null);
        $oTIPO->addComparacao('DHPCP', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_LINHA, false, null);
 
        $oFiltroCOD = new Filtro($oCOD, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oFiltroHOSTNAME = new Filtro($oHOSTNAME, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFiltroIp = new Filtro($oIP, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFiltroMAC = new Filtro($oMAC, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFiltroTIPO = new Filtro($oTIPO, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroTIPO->setSLabel('');
        $oFiltroTIPO->addItemSelect('', 'TODOS TIPOS');
        $oFiltroTIPO->addItemSelect('VAGO', 'VAGO');
        $oFiltroTIPO->addItemSelect('OCUPADO', 'OCUPADO');
        $oFiltroTIPO->addItemSelect('DHPCP', 'DHPCP');
        
        $this->addFiltro($oFiltroCOD, $oFiltroHOSTNAME, $oFiltroIp, $oFiltroMAC, $oFiltroTIPO);
        
        $this->addCampos($oCOD, $oHOSTNAME, $oIP, $oOBS, $oMAC, $oTIPO);
    }
 
    public function criaTela() { 
        parent::criaTela();
 

        $oCOD = new Campo('COD', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCOD->setBCampoBloqueado(true);
        $oHOSTNAME = new Campo('HOSTNAME', 'hostname', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oIP = new Campo('IP', 'ip', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOBS = new Campo('OBS', 'obs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oMAC = new Campo('MAC', 'mac', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTIPO = new Campo('TIPO', 'tipo', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oTIPO->addItemSelect('VAGO', 'VAGO');
        $oTIPO->addItemSelect('OCUPADO', 'OCUPADO');
        $oTIPO->addItemSelect('DHPCP', 'DHPCP');
        $this->addCampos(array($oCOD, $oHOSTNAME), array($oIP, $oMAC, $oTIPO), $oOBS);
    } 
}