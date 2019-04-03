<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerAdmPed extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('AdmPed');
    }
    
    public function filtroInicial() {
        parent::filtroInicial();
        $this->Persistencia->adicionaFiltro('data',Util::getPrimeiroDiaMes(), Persistencia::LIGACAO_AND, Persistencia::ENTRE,Util::getDataAtual());
        
    }
    
    public function getPedidos($Dados){
//        echo json_encode($Dados);
        if(empty($Dados->mes)){
            $mes = date('m');
        }else{
            $mes = $Dados->mes;
        }
        if(empty($Dados->ano)){
            $ano = date('y');
        }else{
              $ano = $Dados->ano;
        }
      
        $DataInicial = '01/'.$mes.'/'.$ano;
        $DataFinal = date("t", mktime(0,0,0,$mes,'01',$ano)).'/'.$mes.'/'.$ano;
        
        $aModels = $this->Persistencia->fatPed($DataInicial,$DataFinal);
        
        foreach($aModels as $oAtual){
            
             $aDados = array();
             $aDados['DATA'] = $oAtual->getData().'T00:00:00'; 
             $aDados['DIA'] = date('d', $oAtual->getData()); 
             $aDados['NR'] = $oAtual->getNr();
             $aDados['PESO'] = $oAtual->getPeso();
             $aDados['ACUMPESO'] = $oAtual->getContpeso();
             $aDados['VALOR'] = $oAtual->getVlr();
             $aDados['VLRCIPI'] = $oAtual->getVlrcomipi();
             $aDados['ACUMVALOR'] = $oAtual->getContvlr();
             $aDados['MEDIACIPI'] = $oAtual->getMediaCipi();
             $aDados['MEDIASIPI'] = $oAtual->getMediaSipi();
             $aRetorno[] = $aDados;
         }
       
       return $aRetorno;  
    }
}