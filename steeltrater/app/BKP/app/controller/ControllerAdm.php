<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerAdm extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Adm');
    }
  
    /*
     * Define o filtro inicial da consulta
     */
    
    public function filtroInicial() {
        parent::filtroInicial();
        $this->Persistencia->adicionaFiltro('data',Util::getPrimeiroDiaMes(), Persistencia::LIGACAO_AND, Persistencia::ENTRE,Util::getDataAtual());
        
    }
    
    /*
     * Método que retorna faturamento para plataforma Mobile
     */
    public function getFaturamento($Dados){
		
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
        
		date_default_timezone_set('America/Sao_Paulo');
        $aModels = $this->Persistencia->fatMobile($DataInicial, $DataFinal);
        
         foreach($aModels as $oAtual){
            
             $aDados = array();
			 //ATENÇÃO: PELO FATO DO FUSO HORÁRIO BRASILEIRO SER GTM-0300, NO LUGAR DE 00:00:00 FOI COLLOCADO 03:00:00 
             $aDados['DATA'] = $oAtual->getData().'T00:00:00'; //date('d/m/Y', strtotime($oAtual->getData())); 
             $aDados['DIA'] = date('d', strtotime($oAtual->getData())); 
             $aDados['VLRLIQ'] = $oAtual->getVlrliquido();
             $aDados['VLRIPI'] = $oAtual->getVlripi();
             $aDados['EXPORTACAO'] = $oAtual->getExportacao();
             $aDados['SUCATA'] = $oAtual->getSucata();
             $aDados['DEVOLUCAO'] = $oAtual->getDevolucao();
             $aDados['PESO'] = $oAtual->getPesoliquido();
             $aDados['MEDIASIPI'] = $oAtual->getMediaSipi();
             $aDados['MEDIACIPI'] = $oAtual->getMediaCipi();
             $aRetorno[] = $aDados;
         }
       
       return $aRetorno;  
    }
    
    public function getTotalizadores(){
         $aModels = $this->Persistencia->getTotalizadores();
        
          foreach($aModels as $oAtual){
            
             $aDados = array();
              $aDados['VLRLIQ'] = $oAtual->getVlrliquido() + $oAtual->getExportacao() + $oAtual->getSucata() + $oAtual->getVlripi();
 //            $aDados['VLRLIQ'] = $oAtual->getVlrliquido();
             $aDados['VLRIPI'] = $oAtual->getVlripi();
//             $aDados['EXPORTACAO'] = $oAtual->getExportacao();
             $aDados['SUCATA'] = $oAtual->getSucata();
             $aDados['PESO'] = $oAtual->getPesoliquido();
             $aDados['MEDIASIPI'] = $oAtual->getMediaSipi();
             $aDados['MEDIACIPI'] = $oAtual->getMediaCipi();
             $aRetorno[] = $aDados;
         }
       
       return $aRetorno;  

    }
}
