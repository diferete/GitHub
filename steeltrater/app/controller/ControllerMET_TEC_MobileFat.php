<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerMET_TEC_MobileFat extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_MobileFat');
    }
    
    public function getPainelFat($Dados){
        $aRetorno = array();
        $aDadosDiario = array();
        $aDadosMensal = array();
        $totalAppDiario =0;
        $totalAppMensal =0;
        //busca os painéis 
        $aPainel = $this->Persistencia->getPainelApp();
        foreach ($aPainel as $key => $sPainel) {
        //Busca Painel da Metalbo
            if($sPainel=='Faturamento Metalbo'){
                //busca dados do faturamento da Metalbo
                $sDataDia = Util::getDataAtual();
                $aDadosDiario = $this->Persistencia->getTotalFat($sDataDia, $sDataDia);
                //Obtem valor total para app diário
                $totalAppDiario =$aDadosDiario['vlrliquido']+$aDadosDiario['vlripi']+$aDadosDiario['sucata']+$aDadosDiario['exportacao']; 
                //obtem dados mensais
                $sDataIni = Util::getPrimeiroDiaMes();
                $aDadosMensal = $this->Persistencia->getTotalFat($sDataIni, $sDataDia);
                $totalAppMensal =$aDadosMensal['vlrliquido']+$aDadosMensal['vlripi']+$aDadosMensal['sucata']+$aDadosMensal['exportacao']; 
                
                $aRetorno['FatMetalbo'][0]['title']='Fat. Hoje';
                $aRetorno['FatMetalbo'][0]['value']='R$ '. number_format($totalAppDiario,2,',','.');
                
                $aRetorno['FatMetalbo'][1]['title']='Fat. Mês';
                $aRetorno['FatMetalbo'][1]['value']='R$ '. number_format($totalAppMensal,2,',','.');

                $aRetorno['FatMetalbo'][2]['title']='Preço Kg S/IPI Hoje';
                $aRetorno['FatMetalbo'][2]['value']= number_format($aDadosDiario['mediaSipi'],2,',','.');

                $aRetorno['FatMetalbo'][3]['title']='Preço Kg C/IPI Hoje';
                $aRetorno['FatMetalbo'][3]['value']=number_format($aDadosDiario['mediaCipi'],2,',','.');

                $aRetorno['FatMetalbo'][4]['title']='Peso Hoje';
                $aRetorno['FatMetalbo'][4]['value']=number_format($aDadosDiario['PesoLiquido'],2,',','.').' Kg';

                $aRetorno['FatMetalbo'][5]['title']='Peso Mês';
                $aRetorno['FatMetalbo'][5]['value']=number_format($aDadosMensal['PesoLiquido'],2,',','.').' Kg';
                
                $aRetorno['FatMetalbo'][6]['title']='Sucata Hoje';
                $aRetorno['FatMetalbo'][6]['value']='R$ '.number_format($aDadosDiario['sucata'],2,',','.');

                $aRetorno['PainelFatMetalbo']='Faturamento Metalbo';
                
            }
        //Busca Painel da SteelTrater
            if($sPainel =='Faturamento SteelTrater'){
                //busca valores mensais
                $sDataDia = Util::getDataAtual();
                $sDataIni = Util::getPrimeiroDiaMes();
                
                $aDadosFat = array();
                //instancia a classe para busca dos dados
                $oGerenFatDiario = Fabrica::FabricarController('STEEL_PCP_GerenFatDiario');
                $aDadosFat = $oGerenFatDiario->Persistencia->getFatDiario($sDataIni,$sDataDia);
                
                $aRetorno['FatSteel'][0]['title']='Serviço/Insumo Mês';
                $aRetorno['FatSteel'][0]['value']='R$ '. number_format($aDadosFat['Total']['ValorFat'],2,',','.');

                $aRetorno['FatSteel'][1]['title']='Serviço Mês';
                $aRetorno['FatSteel'][1]['value']='R$ '. number_format($aDadosFat['Total']['ValorServico'],2,',','.');

                $aRetorno['FatSteel'][2]['title']='Insumo Mês';
                $aRetorno['FatSteel'][2]['value']='R$ '. number_format($aDadosFat['Total']['ValorInsumo'],2,',','.');

                $aRetorno['FatSteel'][3]['title']='Peso Total Mês';
                $aRetorno['FatSteel'][3]['value']=number_format($aDadosFat['Total']['PesoInd'],2,',','.').' Kg';
                
                $aRetorno['FatSteel'][4]['title']='Peso PO/PF etc Mês';
                $aRetorno['FatSteel'][4]['value']=number_format($aDadosFat['Total']['PesoIndAcab'],2,',','.').' Kg';
                
                $aRetorno['FatSteel'][5]['title']='Peso Fio Máq Mês';
                $aRetorno['FatSteel'][5]['value']=number_format($aDadosFat['Total']['PesoIndFio'],2,',','.').' Kg';

                $aRetorno['PainelFatSteel']='Faturamento SteelTrater';
            }
        //Busca Painel Pedidos Metalbo
            if($sPainel=='Pedidos Metalbo'){
                $sDataDia = Util::getDataAtual();
                $sDataIni = Util::getPrimeiroDiaMes();
                
                $aDadosPed=array();
                $aDadosMensalPed=array();
                //número pedidos hj,peso hj,valor hj,
                $aDadosPed = $this->Persistencia->getPedidos($sDataDia, $sDataDia);
                //peso e valor mensal
                $aDadosMensalPed = $this->Persistencia->getPedidosSoma($sDataIni, $sDataDia);
                
                $aRetorno['pedMetalbo'][0]['title']='Valor Hoje';
                $aRetorno['pedMetalbo'][0]['value']='R$ '.$aDadosPed[0]['vlrcomipi'];
                
                $aRetorno['pedMetalbo'][1]['title']='Valor Mês';
                $aRetorno['pedMetalbo'][1]['value']='R$ '.$aDadosMensalPed['vlrcomipi'];
                
                $aRetorno['pedMetalbo'][2]['title']='Pedidos Hoje';
                $aRetorno['pedMetalbo'][2]['value']=$aDadosPed[0]['peso'].' Kg';
                
                $aRetorno['pedMetalbo'][3]['title']='Pedidos Mês';
                $aRetorno['pedMetalbo'][3]['value']=$aDadosMensalPed['pesoMes'].' Kg';
                
                $aRetorno['PainelPedMetalbo']='Pedidos Metalbo';
            }
        //Busca Painel Produção Metalbo
            if($sPainel=='Produção Metalbo'){
               $sDataDia = Util::getDataAtual();
               $sDataIni = Util::getPrimeiroDiaMes(); 
               
               $sDataOntem = Util::dataSextaSegunda();
               
               /* if($Dados->empresa=='filial'){
                       $sCnpj = '75483040000211';
                    }
                    if($Dados->empresa=='matriz'){
                        $sCnpj = '75483040000130';
                    }*/
               $sCnpj = '75483040000211'; 
               $aDadosProd = $this->Persistencia->getProdMetalbo($sDataIni,$sDataDia,$sCnpj);
               $aDadosProdDia = $this->Persistencia->getProdMetalbo($sDataOntem,$sDataOntem,$sCnpj);
                
                $aRetorno['ProdMetalbo'][0]['title']='Total '.$sDataOntem;
                $aRetorno['ProdMetalbo'][0]['value']=$aDadosProdDia['total']['totalsemrosq'].' Kg';
               
                $aRetorno['ProdMetalbo'][1]['title']='Parafuso '.$sDataOntem;
                $aRetorno['ProdMetalbo'][1]['value']=$aDadosProdDia['total']['parafuso'].' Kg';

                $aRetorno['ProdMetalbo'][2]['title']='Porcas '.$sDataOntem;
                $aRetorno['ProdMetalbo'][2]['value']=$aDadosProdDia['total']['porca'].' Kg';
                
                $aRetorno['ProdMetalbo'][3]['title']='Maq Quente '.$sDataOntem;
                $aRetorno['ProdMetalbo'][3]['value']=$aDadosProdDia['total']['maqquente'].' Kg';

                $aRetorno['ProdMetalbo'][4]['title']='Total Mês';
                $aRetorno['ProdMetalbo'][4]['value']=$aDadosProd['total']['totalsemrosq'].' Kg';

                $aRetorno['ProdMetalbo'][5]['title']='Parafuso Mês';
                $aRetorno['ProdMetalbo'][5]['value']=$aDadosProd['total']['parafuso'].' Kg';
                
                $aRetorno['ProdMetalbo'][6]['title']='Porcas Mês';
                $aRetorno['ProdMetalbo'][6]['value']=$aDadosProd['total']['porca'].' Kg';
                
                $aRetorno['ProdMetalbo'][7]['title']='Maq Quente Mês';
                $aRetorno['ProdMetalbo'][7]['value']=$aDadosProd['total']['maqquente'].' Kg';

                $aRetorno['PainelProdMetalbo']='Produção Metalbo';
               
            }
            
           //Busca Painel Produção SteelTrater
            if($sPainel =='Produção SteelTrater'){
               $sDataDia = Util::getDataAtual();
               $sDataIni = Util::getDataOtemDiaUm(); 
               
               $aDadosProdSteel = array();
               $aRetornoProdSteel = array();
               //instancia a classe para busca dos dados
               $oDadosProdSteel = Fabrica::FabricarController('STEEL_PCP_GerenProd');
               $aDadosProdSteel = $oDadosProdSteel->getProdAppSteel($sDataIni,$sDataFim);
               //number_format($totalAppMensal,2,',','.')
               
               $aRetorno['ProdSteel'][0]['title']='Produção total '.$sDataDia;
               $aRetorno['ProdSteel'][0]['value']=number_format($aDadosProdSteel['ProdDiaria']['PesoTotal']['pesoTotal'],2,',','.').' Kg';
               
               $aRetorno['ProdSteel'][1]['title']='Fornos contínuos '.$sDataDia;
               $aRetorno['ProdSteel'][1]['value']=number_format($aDadosProdSteel['ProdDiaria']['PesoTempera']['pesoTotal'],2,',','.').' Kg';
               
               $aRetorno['ProdSteel'][2]['title']='Fio Máquina '.$sDataDia;
               $aRetorno['ProdSteel'][2]['value']=number_format($aDadosProdSteel['ProdDiaria']['PesoFio']['pesoTotal'],2,',','.').' Kg';
               
               $aRetorno['ProdSteel'][3]['title']='Produção total Mês';
               $aRetorno['ProdSteel'][3]['value']=number_format($aDadosProdSteel['ProdMensal']['PesoTotal']['pesoTotal'],2,',','.').' Kg';
               
               $aRetorno['ProdSteel'][4]['title']='Fornos contínuos Mês';
               $aRetorno['ProdSteel'][4]['value']=number_format($aDadosProdSteel['ProdMensal']['PesoTempera']['pesoTotal'],2,',','.').' Kg';
               
               $aRetorno['ProdSteel'][5]['title']='Fio Máquina Mês';
               $aRetorno['ProdSteel'][5]['value']=number_format($aDadosProdSteel['ProdMensal']['PesoFio']['pesoTotal'],2,',','.').' Kg';
               
               $aRetorno['PainelProdSteel']='Produção SteelTrater';
               
             
               
            }
        }
        return $aRetorno;
       }
       
    public function getFatMetalbo($Dados){
        
        $dia = date( 'd', strtotime($Dados->mes) );
        $mes = date( 'm', strtotime($Dados->mes) );
        $ano = date( 'Y', strtotime($Dados->mes) );   
		
        
        //primeiro dia
        $dataInicial ="01/$mes/$ano";
        
        $dataFinal = date("t", mktime(0, 0, 0, $mes, '01', $ano)).'/'.$mes.'/'.$ano; // Mágica, plim!    
        
        //busca o total do mês selecionado
        $aDadosMensal = $this->Persistencia->getTotalFat($dataInicial, $dataFinal);
        $totalAppMensal =$aDadosMensal['vlrliquido']+$aDadosMensal['vlripi']+$aDadosMensal['sucata']+$aDadosMensal['exportacao']; 
        
        //array de retorno
        $aRetorno['total']='R$ '. number_format($totalAppMensal,2,',','.');
        $aRetorno['totalPeso']=number_format($aDadosMensal['PesoLiquido'],2,',','.').' Kg';
        
        
        //busca total faturamento mês
        $aRetorno['diario'] = $this->Persistencia->getFatMensal($dataInicial,$dataFinal);
		
		$aRetorno['data'] =$dataInicial;
        
        return $aRetorno;
    }
    
    public function getFatSteel($Dados){
        $dia = date( 'd', strtotime($Dados->mes) );
        $mes = date( 'm', strtotime($Dados->mes) );
        $ano = date( 'Y', strtotime($Dados->mes) );
        
        //primeiro dia
        $dataInicial ="01/$mes/$ano";
        
        $dataFinal =date("t", mktime(0, 0, 0, $mes, '01', $ano)).'/'.$mes.'/'.$ano; // Mágica, plim!   
       
        $oGerenFatDiario = Fabrica::FabricarController('STEEL_PCP_GerenFatDiario');
        $aDadosFat = array();
        $aDadosFat =  $oGerenFatDiario->Persistencia->getFatDiario($dataInicial,$dataFinal,'celular');
        
        
        $aRetorno['totalFat']= 'R$ '.number_format($aDadosFat['Total']['ValorFat'],2, ',','.');
        $aRetorno['totalServico']= 'R$ '.number_format($aDadosFat['Total']['ValorServico'],2, ',','.');
        $aRetorno['totalInsumo']='R$ '.number_format($aDadosFat['Total']['ValorInsumo'],2, ',','.');
        $aRetorno['totalPoPf']=number_format($aDadosFat['Total']['PesoIndAcab'],2, ',','.').' Kg';
        $aRetorno['totalFio']=number_format($aDadosFat['Total']['PesoIndFio'],2, ',','.').' Kg';  
        
        //busca total faturamento mês
        $aRetorno['diario'] = $aDadosFat['grid'];
        $aRetorno['dataIni']=$dataInicial;
        
        return $aRetorno;
        
    }
    
    public function getPedMetalbo($Dados){
        $dia = date( 'd', strtotime($Dados->mes) );
        $mes = date( 'm', strtotime($Dados->mes) );
        $ano = date( 'Y', strtotime($Dados->mes) );
        
        //primeiro dia
        $dataInicial ="01/$mes/$ano";
        $dataFinal =date("t", mktime(0, 0, 0, $mes, '01', $ano)).'/'.$mes.'/'.$ano;
        
         $aDadosPed = $this->Persistencia->getPedidos($dataInicial, $dataFinal);
         //peso e valor mensal
         $aDadosMensalPed = $this->Persistencia->getPedidosSoma($dataInicial, $dataFinal);
         
         $aRetorno['pesoMes']=$aDadosMensalPed['pesoMes'].' Kg';
         $aRetorno['vlrcomipi']='R$ '.$aDadosMensalPed['vlrcomipi'];
         $aRetorno['diario']=$aDadosPed;
         
         return $aRetorno;
    }
    
    public function getProdMetalbo($Dados){
        $dia = date( 'd', strtotime($Dados->mes) );
        $mes = date( 'm', strtotime($Dados->mes) );
        $ano = date( 'Y', strtotime($Dados->mes) );
        
        $sCnpj = '';
        
        //primeiro dia
        $dataInicial ="01/$mes/$ano";
        
        $dataFinal = date("t", mktime(0, 0, 0, $mes, '01', $ano)).'/'.$mes.'/'.$ano; // Mágica, plim!    
        if($Dados->empresa=='filial'){
            $sCnpj = '75483040000211';
        }
        if($Dados->empresa=='matriz'){
            $sCnpj = '75483040000130';
        }
        if(!isset($Dados->empresa)){
            $sCnpj = '75483040000211'; 
        }
        
        $aDadosProdDia = $this->Persistencia->getProdMetalbo($dataInicial,$dataFinal,$sCnpj);
        
        $aRetorno['totalMensal']=$aDadosProdDia['total']['totalsemrosq'];
        $aRetorno['totalParaf']=$aDadosProdDia['total']['parafuso'];
        $aRetorno['totalPorca']=$aDadosProdDia['total']['porca'];
        $aRetorno['maqquente']=$aDadosProdDia['total']['maqquente'];
        
        $aRetorno['diario'] = $aDadosProdDia['diario'];
        $aRetorno['filial']=$sCnpj;
        
        return $aRetorno;
        
    }
    
    public function getProdSteel($Dados){
        $dia = date( 'd', strtotime($Dados->mes) );
        $mes = date( 'm', strtotime($Dados->mes) );
        $ano = date( 'Y', strtotime($Dados->mes) );
		

        
        //primeiro dia
        $dataInicial ="01/$mes/$ano";
        
        $dataFinal =date("t", mktime(0, 0, 0, $mes, '01', $ano)).'/'.$mes.'/'.$ano; // Mágica, plim!   
        
        $dataOntem =date("t", mktime(0, 0, 0, $mes, '01', $ano)).'/'.$mes.'/'.$ano; //date("d/m/Y", mktime(0, 0, 0, $mes, $dia - 1, $ano));
        
        $oDadosProdSteel = Fabrica::FabricarController('STEEL_PCP_GerenProd');
        //traz produção mensal até dia ontem
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = $dataInicial;
        $aDadosParam['datafin'] = $dataOntem;
        $aDadosPesoGeralMensal = $oDadosProdSteel->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op tempera
        $aDadosParam['busca'] ='ProdTotal';
         $aDadosParam['dataini'] = $dataInicial;
        $aDadosParam['datafin'] = $dataOntem;
        $aDadosParam['tipoOp'] = 'P';
        $aDadosPesoTemperaMensal = $oDadosProdSteel->Persistencia->geraGerenProd($aDadosParam);
        //separa por tipo de op fio maquina
        $aDadosParam['busca'] ='ProdTotal';
         $aDadosParam['dataini'] = $dataInicial;
        $aDadosParam['datafin'] = $dataOntem;
        $aDadosParam['tipoOp'] = 'F';
        $aDadosPesoFioMensal = $oDadosProdSteel->Persistencia->geraGerenProd($aDadosParam);
        
        $aRetorno['totalMensal']= number_format($aDadosPesoGeralMensal['pesoTotal'], 2, ',','.').' Kg';
        $aRetorno['totalMensalForno']=number_format($aDadosPesoTemperaMensal['pesoTotal'], 2, ',','.').' Kg';
        $aRetorno['totalMensalFio'] = number_format($aDadosPesoFioMensal['pesoTotal'], 2, ',','.').' Kg';
        
		$fp = fopen("bloco11.txt", "w");
        fwrite($fp, $dataOntem);
        fclose($fp);
       
        
        $aDadosProdSteel = $oDadosProdSteel->Persistencia->getProdApp($dataInicial,$dataFinal);
        
       
        $aRetorno['diario'] = $aDadosProdSteel;
        
        return $aRetorno;
        
        
    }
    
    /*Traz as etapas por dia para o app*/
    public function getProdSteelEtapa($Dados){
        $dia = date( 'd', strtotime($Dados->mes) );
        $mes = date( 'm', strtotime($Dados->mes) );
        $ano = date( 'Y', strtotime($Dados->mes) );
        
        //primeiro dia
        $dataParam =$Dados->mes;//"$dia/$mes/$ano";
       
        //classe gerenProd
        $oDadosProdSteel = Fabrica::FabricarController('STEEL_PCP_GerenProd');
          //apontamento por etapa diário
        $aDadosParam = array();
        $aDadosParam['busca'] ='ProdTotal';
        $aDadosParam['dataini'] = $dataParam;
        $aDadosParam['datafin'] = $dataParam;
       // $aDadosParam['tipoOp'] = 'F';
        $aDadosEtapa = $oDadosProdSteel->Persistencia->geraProdEtapas($aDadosParam);
        
        $aRetornoDados =array();
        $aDados = array();
        
        foreach ($aDadosEtapa as $key => $value) {
            $aDados['etapa']=$key;
            $aDados['peso']= number_format($value,'2',',','.');   
            $aRetornoDados[]=$aDados;
         }
        
         
        
        /*while ($row = $result->fetch(PDO::FETCH_OBJ)){
             $aDados['data'] = $row->dataconv;
             $aDados['peso'] = number_format($row->pesototal,'2',',','.');
             $aRetorno[]=$aDados;
         }*/
        
        return $aRetorno['etapas'] = $aRetornoDados;
        
    }
	
	  /**
     * Método para retornar as listas em espera
     */
    public function listaLiberadoFosfatizacao($Dados){
        
        $aDadosProdDia = array();
        $aRetorno = array();
        
        $aRetorno['total']=$this->Persistencia->getCountLista();
        $aRetorno['lista']=$this->Persistencia->getListaEspera();
        //retorno de teste para o aplicativo
        return $aRetorno;
    }
    
    /**
     * Gera o update na lista metalbo
     */
    public function setLiberadoFosfatizacao($Dados){
        
        //traz os dados da class de usu
        
        $oDadosUser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oDadosUser->Persistencia->adicionaFiltro('usucodigo',$Dados->usucod);
        $oDados = $oDadosUser->Persistencia->consultarWhere();
        
        $aDados = array();
        $aDados['nome'] = $oDados->getUsunome();
        $aDados['seq'] = $Dados->seq;
        $aRetorno =$this->Persistencia->setListaLiberado($aDados);
        $aIonic = array();
        $aIonic['retorno'] = $aRetorno[0];
        $aIonic['mensagem'] = $aRetorno[1];
        return $aIonic;
    }
	
}
