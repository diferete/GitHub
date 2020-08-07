<?php

/* 
 * Implementa a classe controler de Máquinas
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ControllerMET_MP_Maquinas extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('MET_MP_Maquinas');
    }
    
    /**
     * Função que adiciona e passa parametros extras para view
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        
        $aParame = $this->buscaDados();
        $this->View->setAParametrosExtras($aParame);

    }
    /**
     * Função que retorna um array contendo (Celula, dadosSetor, Responsável, DadosTipoDeMaquina)
     * @return type
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
     * Função que retorna dados da máquina conforme código
     * @param type $iMaq
     * @return type
     */
    public function consultaDadosMaquina($iMaq){
        $this->Persistencia->adicionaFiltro('cod',$iMaq);
        $oMaq = $this->Persistencia->consultarWhere();
        return $oMaq;
    }
    
    /**
     * Função que filtra por setor do usuário logado exceto TI, Elétrica e Mecânica
     * @param type $sParametros
     */
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        $iSet = $_SESSION['codsetor'];
        if($iSet!= 2 && $iSet!= 12 && $iSet!= 29){
            $this->Persistencia->adicionaFiltro('codsetor',$iSet);
        }
    }
}
