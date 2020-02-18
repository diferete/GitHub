<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ControllerMET_Maquinas extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('MET_Maquinas');
    }
    
    /**
     * Adiciona parâmetros extras na View
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aParame = $this->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }
    
    /**
     * Busca os dados para passar como filtro
     * Códigos de todas Células
     * Códigos de todos Setores
     * Códigos de todos Responsáveis pelos Serviços Manutenção Preventiva
     * Códigos do tipo de maquina MQ, PO, PF...
     * @return type Array[CodCelula, CodSetor, CodRespServ, CodMaqTip] 
     */
    public function buscaDados(){
        $aParame = array();
        $aParame1 = $this->Persistencia->buscaDadosCelula();
        $aParame2 =  $this->Persistencia->buscaDadosSetor();
        $aParame3 =  $this->Persistencia->buscaDadosResp();
        $aParame4 =  $this->Persistencia->buscaDadosMaqTip();
        $aParame[0]= $aParame1;
        $aParame[1]= $aParame2;
        $aParame[2]= $aParame3;
        $aParame[3]= $aParame4;
        return $aParame;
    }
    
    /**
     * Consulta os dados da máquina passando o código como parâmetro
     * @param type $iMaq
     * @return type Dados Maquina
     */
    public function consultaDadosMaquina($iMaq){
        $this->Persistencia->adicionaFiltro('cod',$iMaq);
        $oMaq = $this->Persistencia->consultarWhere();
        return $oMaq;
    }
}
