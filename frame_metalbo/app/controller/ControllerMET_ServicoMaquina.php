<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class ControllerMET_ServicoMaquina extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ServicoMaquina');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->buscaCelulas();
    }

    public function buscaCelulas() {
        $oControllerCadastroMaquina = Fabrica::FabricarController('MET_CadastroMaquinas');
        $aParame = $oControllerCadastroMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }

    public function afterUpdate() {
        parent::afterUpdate();
        
        $sSit = $this->Model->getSit();
        $CodSit = $this->Model->getCodsit();
        if($sSit=='BLOQUEADO'){
        $this->Persistencia->FinanizaServico($CodSit);
        }
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
        
    }

    public function mostraTelaRelServicos($renderTo, $sMetodo = '') {   
        $this->buscaCelulas2();
        parent::mostraTelaRelatorio($renderTo, 'relServicosMant');              
    }  
    
    public function buscaCelulas2(){
        $oControllerMaquina = Fabrica::FabricarController('MET_Maquinas');
        $aParame = $oControllerMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }
    
}
