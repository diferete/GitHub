<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerRepDay extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('RepDay');
    }
    
    public function DadosRepDay($sDados){
        $aIds = explode(',', $sDados);
        //busca os dados para carregar
        $aDados =$this->Persistencia->buscaDados('1');
        foreach ($aDados as $key => $value) {
          $sTable .= '<tr><td>'.$key.'</td><td>'.number_format($value, 2, ',', '.').'</td></tr>';  
        }
        
         
         $aDadosVlr = $this->Persistencia->buscaDadosValor('1');
         
         foreach ($aDadosVlr as $key => $value) {
          $sTableVlr .= '<tr><td>'.$key.'</td><td>'.number_format($value, 2, ',', '.').'</td></tr>';  
        }
        
        $aDadosVlrMes = $this->Persistencia->buscaMesValor('');
        foreach ($aDadosVlrMes as $key => $value) {
          $sTableVlrMonth .= '<tr><td>'.$key.'</td><td>'.number_format($value, 2, ',', '.').'</td></tr>';  
        }
        
        $aDadosCountMes  = $this->Persistencia->buscaMesCount('1');
        foreach ($aDadosCountMes as $key => $value) {
          $sTableCountMonth .= '<tr><td>'.$key.'</td><td>'.number_format($value, 2, ',', '.').'</td></tr>';  
        }
        
         
         $sRender ='$("#'.$aIds[0].' > tbody > tr").empty();'; 
         echo $sRender;
         echo '$("#'.$aIds[0].' > tbody").append(\''.$sTable.'\');';
         
         $sRender ='$("#'.$aIds[1].' > tbody > tr").empty();'; 
         echo $sRender;
         echo '$("#'.$aIds[1].' > tbody").append(\''.$sTableVlr.'\');';
         
         $sRender ='$("#'.$aIds[2].' > tbody > tr").empty();'; 
         echo $sRender;
         echo '$("#'.$aIds[2].' > tbody").append(\''.$sTableVlrMonth.'\');';
         
         $sRender ='$("#'.$aIds[3].' > tbody > tr").empty();'; 
         echo $sRender;
         echo '$("#'.$aIds[3].' > tbody").append(\''.$sTableCountMonth.'\');';
         
    }
    
}