<?php

/**
 * Classe que controla as operações do objeto SolCadUser
 * 
 * @author Avanei Martendal
 * @since 14/07/2017
 */

class ViewMET_TEC_Soluser extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oUsucodigo = new CampoConsulta('Código','usucodigo', CampoConsulta::TIPO_LARGURA,20);
        $oUsunome = new CampoConsulta('Nome','usunome', CampoConsulta::TIPO_LARGURA,20);
        $oUsusobre = new CampoConsulta('Sobrenome','ususobrenome', CampoConsulta::TIPO_LARGURA,20);
        $oUsuLogin = new CampoConsulta('Login','usulogin', CampoConsulta::TIPO_LARGURA,20);
        $oUsuEmail = new CampoConsulta('E-mail','usuemail', CampoConsulta::TIPO_LARGURA,20);
        $oUsusit = new CampoConsulta('Sit.','ususit', CampoConsulta::TIPO_LARGURA,20);
        $oUsusit->addComparacao('Aguardando cadastro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oObs = new CampoConsulta('Obs','obs', CampoConsulta::TIPO_LARGURA,20);
        $oData = new CampoConsulta('Data','dataSolUser', CampoConsulta::TIPO_DATA,20);
        
        $this->addCampos($oUsucodigo,$oUsunome,$oUsusobre,$oUsuLogin,$oUsuEmail,$oUsusit,$oData,$oObs);
    }
     
}