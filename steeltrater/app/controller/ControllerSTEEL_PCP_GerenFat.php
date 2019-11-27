<?php

/* 
 *Gerencia o controller do gerenciamento de faturamento 
 * 
 * @author Avanei Martendal
 * 
 * @since 05/08/2019
 */

class ControllerSTEEL_PCP_GerenFat extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GerenFat');
    }
    
    public function carregaDadosGerenFat($sDados){
        $aDados = explode(',', $sDados);
        $aCamposChave = array();
        parse_str($_REQUEST['campos'], $aCamposChave);
 //################################################################################################
        //faturamento diário peso
        $aDadosParam['busca'] ='FatPeso';
        $aDadosParam['dataini'] = Util::getDataAtual();
        $aDadosParam['datafin'] = Util::getDataAtual();
        $aDadosParam['grupoini']=0;
        $aDadosParam['grupofin']=9999;
        $aDadosParam['finan']='N';
        $aDadosFatDiarioPeso = $this->Persistencia->geraGerenFat($aDadosParam);
        //busca dados referente ao valor somente de serviços e insumos
        $aDadosParam['finan']='S';
        $aDadosFatDiarioValorSerIns =$this->Persistencia->geraGerenFat($aDadosParam); 
        //busca dados referente serviço 
        $aDadosParam['grupoini']=100;
        $aDadosParam['grupofin']=100;
        $aDadosFatDiarioServ = $this->Persistencia->geraGerenFat($aDadosParam);
        //busca dados referente insumo
        $aDadosParam['grupoini']=101;
        $aDadosParam['grupofin']=101;
        $aDadosFatDiarioInsumo = $this->Persistencia->geraGerenFat($aDadosParam);
        
        //gerar visualizacao faturamento diário
        echo '$("#'.$aDados[0].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='<tr><td>Peso total de retorno de industrialização</td><td>'.number_format($aDadosFatDiarioPeso['PesoOp'], 2, ',', '.').' Kg</td></tr> '  
                      .'             <tr><td>Valor total de faturamento</td><td>R$ '.number_format($aDadosFatDiarioValorSerIns['ValorTotalVenda'], 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor serviço</td><td>R$ '.number_format($aDadosFatDiarioServ['ValorTotalVenda'], 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor insumo</td><td>R$ '.number_format($aDadosFatDiarioInsumo['ValorTotalVenda'], 2, ',', '.').'</td></tr> '; 
        echo '$("#'.$aDados[0].' > tbody").append(\''.$sHtmlDiario.'\');';
        
  //################################################################################################
  //Faturamento mensal
        $aDadosParam['busca'] ='FatPeso';
        $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosParam['grupoini']=0;
        $aDadosParam['grupofin']=9999;
        $aDadosParam['finan']='N';
        $aDadosFatMensalTupoPeso = $this->Persistencia->geraGerenFat($aDadosParam);
        //busca dados referente ao valor somente de serviços e insumos
        $aDadosParam['finan']='S';
        $aDadosFatMensalTudoValorSerIns =$this->Persistencia->geraGerenFat($aDadosParam); 
        //busca dados referente serviço 
        $aDadosParam['grupoini']=100;
        $aDadosParam['grupofin']=100;
        $aDadosFatMensalTudoServ = $this->Persistencia->geraGerenFat($aDadosParam);
        //busca dados referente insumo
        $aDadosParam['grupoini']=101;
        $aDadosParam['grupofin']=101;
        $aDadosFatMensalTudoInsumo = $this->Persistencia->geraGerenFat($aDadosParam);    
        
        //gerar visualizacao faturamento diário
        echo '$("#'.$aDados[1].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='<tr><td>Peso total de retorno de industrialização</td><td>'.number_format($aDadosFatMensalTupoPeso['PesoOp'], 2, ',', '.').' Kg</td></tr> '  
                      .'             <tr><td>Valor total de faturamento</td><td>R$ '.number_format($aDadosFatMensalTudoValorSerIns['ValorTotalVenda'], 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor serviço</td><td>R$ '.number_format($aDadosFatMensalTudoServ['ValorTotalVenda'], 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor insumo</td><td>R$ '.number_format($aDadosFatMensalTudoInsumo['ValorTotalVenda'], 2, ',', '.').'</td></tr> '; 
        echo '$("#'.$aDados[1].' > tbody").append(\''.$sHtmlDiario.'\');';
      //##################################################################################
        
         //Fio Máquina Mensal
        $aDadosParam['busca'] ='FatPeso';
        $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosParam['grupoini']=0;
        $aDadosParam['grupofin']=9999;
        $aDadosParam['finan']='N';
        $aDadosParam['tipoOrdem']='F';
        
        $aDadosFatFioPeso = $this->Persistencia->geraGerenFat($aDadosParam);
        //busca dados referente ao valor somente de serviços e insumos
        $aDadosParam['finan']='S';
        $aDadosParam['tipoRet']='SERVIÇO';
        $aDadosFatFioSer =$this->Persistencia->geraGerenFat($aDadosParam); 
        
        $aDadosParam['tipoRet']='INSUMO';
        $aDadosFatFioInsumo =$this->Persistencia->geraGerenFat($aDadosParam);
        
        $FatTudo =$aDadosFatFioSer['ValorTotalVenda'] + $aDadosFatFioInsumo['ValorTotalVenda'];
        
        //gerar visualizacao faturamento diário
        echo '$("#'.$aDados[2].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='<tr><td>Peso total de retorno de industrialização</td><td>'.number_format($aDadosFatFioPeso['PesoOp'], 2, ',', '.').' Kg</td></tr> '  
                      .'             <tr><td>Valor total de faturamento</td><td>R$ '.number_format($FatTudo, 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor serviço</td><td>R$ '.number_format($aDadosFatFioSer['ValorTotalVenda'], 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor insumo</td><td>R$ '.number_format($aDadosFatFioInsumo['ValorTotalVenda'], 2, ',', '.').'</td></tr> '; 
        echo '$("#'.$aDados[2].' > tbody").append(\''.$sHtmlDiario.'\');';
   //#################################################################################################     
       //produtos acabado mensal
        $aDadosParam['busca'] ='FatPeso';
        $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosParam['grupoini']=0;
        $aDadosParam['grupofin']=9999;
        $aDadosParam['finan']='N';
        $aDadosParam['tipoOrdem']='P';
        $aDadosParam['tipoRet']='RETORNO';
        
        $aDadosFatAcabadoPeso = $this->Persistencia->geraGerenFat($aDadosParam);
         //busca dados referente ao valor somente de serviços e insumos
        $aDadosParam['finan']='S';
        $aDadosParam['tipoRet']='SERVIÇO';
        $aDadosFatAcabadoSer =$this->Persistencia->geraGerenFat($aDadosParam); 
        
        $aDadosParam['tipoRet']='INSUMO';
        $aDadosFatAcabadoInsumo =$this->Persistencia->geraGerenFat($aDadosParam);
        
        $FatAcabTudo =$aDadosFatAcabadoSer['ValorTotalVenda'] + $aDadosFatAcabadoInsumo['ValorTotalVenda']; 
        
        //gerar visualizacao faturamento diário
        echo '$("#'.$aDados[3].' > tbody >").remove();'; 
        //html visualizacao
        $sHtmlDiario ='<tr><td>Peso total de retorno de industrialização</td><td>'.number_format($aDadosFatAcabadoPeso['PesoOp'], 2, ',', '.').' Kg</td></tr> '  
                      .'             <tr><td>Valor total de faturamento</td><td>R$ '.number_format($FatAcabTudo, 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor serviço</td><td>R$ '.number_format($aDadosFatAcabadoSer['ValorTotalVenda'], 2, ',', '.').'</td></tr> '   
                      .'             <tr><td>Valor insumo</td><td>R$ '.number_format($aDadosFatAcabadoInsumo['ValorTotalVenda'], 2, ',', '.').'</td></tr> '; 
        echo '$("#'.$aDados[3].' > tbody").append(\''.$sHtmlDiario.'\');'; 
    }
}

