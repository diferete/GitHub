<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_GerenProd extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GerenProd');
    }
    
    /**
     * Método para carregar a gestão da produção
     */
    public function carregaDadosGerenProd($sDados){
        //tratamentos dos dados da tela
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($_REQUEST['campos'], $aCamposChave);
        
        //################################################################################################
        //producao diário peso
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
         
        $aDadosPesoGeral = $this->Persistencia->geraGerenProd($aDadosParam);
       //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTempera = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFio = $this->Persistencia->geraGerenProd($aDadosParam);
        
        echo '$("#'.$aDados[0].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='             <tr><td>Produção total</td><td> '.number_format($aDadosPesoGeral['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Padrão tempera</td><td> '.number_format($aDadosPesoTempera['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Fio Máquina Industrialização</td><td>'.number_format($aDadosPesoFio['pesoTotal'], 2, ',', '.').' Kg</td></tr> '; 
        echo '$("#'.$aDados[0].' > tbody").append(\''.$sHtmlDiario.'\');';
        
 //#############################################################################################################
        
         //producao mensal peso
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosPesoGeralMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTemperaMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFioMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        
        echo '$("#'.$aDados[1].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='             <tr><td>Produção total</td><td> '.number_format($aDadosPesoGeralMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Padrão tempera</td><td> '.number_format($aDadosPesoTemperaMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '   
                      .'             <tr><td>Fio Máquina Industrialização</td><td>'.number_format($aDadosPesoFioMensal['pesoTotal'], 2, ',', '.').' Kg</td></tr> '; 
        echo '$("#'.$aDados[1].' > tbody").append(\''.$sHtmlDiario.'\');';
   //################################################################################################
        //producao diário por forno
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdForno';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        
        $aDadosProdFornoDiario = $this->Persistencia->geraGerenProd($aDadosParam);
        $sHtmlDiario ='';
        foreach ($aDadosProdFornoDiario as $key => $value) {
           $sHtmlDiario .='             <tr><td>'.$key.' </td><td> '.number_format($value, 2, ',', '.').' Kg</td></tr> '   ; 
        }
        echo '$("#'.$aDados[2].' > tbody >").remove();'; 
        echo '$("#'.$aDados[2].' > tbody").append(\''.$sHtmlDiario.'\');';
        
    //###############################################################################################
        //producao por forno mensal
        
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdForno';
        $aDadosParam['dataini'] = Util::getPrimeiroDiaMes();
        $aDadosParam['datafin'] = Util::getDataAtual();
        
        $aDadosProdFornoMensal = $this->Persistencia->geraGerenProd($aDadosParam);
        
        $sHtmlDiario ='';
        foreach ($aDadosProdFornoMensal as $key => $value) {
           $sHtmlDiario .='             <tr><td>'.$key.' </td><td> '.number_format($value, 2, ',', '.').' Kg</td></tr> '   ; 
        }
        echo '$("#'.$aDados[3].' > tbody >").remove();'; 
        echo '$("#'.$aDados[3].' > tbody").append(\''.$sHtmlDiario.'\');';
    }
}