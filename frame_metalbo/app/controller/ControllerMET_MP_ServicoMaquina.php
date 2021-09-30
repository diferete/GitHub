<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class ControllerMET_MP_ServicoMaquina extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_MP_ServicoMaquina');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->buscaCelulas();
    }

    /**
     * Busca dados do cadastro de tipo de máquina
     */
    public function buscaCelulas() {
        $oControllerCadastroMaquina = Fabrica::FabricarController('MET_MP_CadastroMaquinas');
        $aParame = $oControllerCadastroMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }

    /**
     * Busca informações da máquina para a geração do relatório
     */
    public function buscaCelulas2(){
        $oControllerMaquina = Fabrica::FabricarController('MET_MP_Maquinas');
        $aParame = $oControllerMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }
    
    /**
     * Método que antes de alterar verifica a situação do serviço e finaliza ele nos itens da manutenção preventiva
     * @return string
     */
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

    /**
     * Mostra Tela Relatório de Serviços
     * @param type $renderTo
     * @param type $sMetodo
     */
    public function mostraTelaRelServicos($renderTo, $sMetodo = '') {   
        $this->buscaCelulas2();
        parent::mostraTelaRelatorio($renderTo, 'relServicosMant');              
    }  
    
    /**
     * Adiciona Filtros antes da consulta filtrando pelo setor e responsável pela manutenção preventiva
     * @param type $sParametros
     */
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        if($_REQUEST['metodo']!='getDadosConsulta'){
        $iSet = $_SESSION['codsetor'];
        if($iSet!= 2 && $iSet!= 12 && $iSet!= 29 && $iSet!= 31 && $iSet!= 9 && $iSet!= 32 && $iSet!= 24){
            $this->Persistencia->adicionaFiltro('codsetor',$iSet);
            $this->Persistencia->adicionaFiltro('resp', 'OPERADOR');
        }else if($iSet== 12){
            $this->Persistencia->adicionaFiltro('resp','ELETRICA');
        }else if($iSet== 29){
            $this->Persistencia->adicionaFiltro('resp','MECANICA');
        }
        }
    }
    
}
