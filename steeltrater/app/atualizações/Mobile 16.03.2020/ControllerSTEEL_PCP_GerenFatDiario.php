<?php

/* 
 * Implementa a controller do faturamento diário
 * 
 * @author Avanei Martendal
 * @since 20/02/2020
 */

class ControllerSTEEL_PCP_GerenFatDiario extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GerenFatDiario');
    }
    
    /*Carrega os faturamento diário*/
    public function carregaDadosGerenFatDiario($sDados){
        $aIds = explode(',', $sDados);
        
        $aCamposChave = $this->getArrayCampostela();
        $aDadosParam['dataini'] = $aCamposChave['dataini'];
        $aDadosParam['datafin'] = $aCamposChave['datafin'];
        $aDadosFat = array();
        $aDadosFat = $this->Persistencia->getFatDiario($aDadosParam['dataini'],$aDadosParam['datafin']);
        
        
         echo '$("#'.$aIds[0].' > tbody >").remove();';
         $sHtmRetorno ='';
         foreach ($aDadosFat['grid'] as $key => $value) {
             $sHtmRetorno .= '<tr>';
             $sHtmRetorno .=  '<td style="font-size:13px;background-color:#D3D3D3">'.$value['dataChar'].' </td>'
                             .'<td style="font-size:13px;color:#006400">R$ '.number_format($value['ValorFat'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;color:#FF0000">R$ '.number_format($value['ValorServico'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;color:#8B008B">R$ '.number_format($value['ValorInsumo'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;color:#FF0000">R$ '.number_format($value['ValorServicoAcab'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;color:#8B008B">R$ '.number_format($value['ValorInsumoAcab'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;color:#FF0000">R$ '.number_format($value['ValorServicoFio'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;color:#8B008B">R$ '.number_format($value['ValorInsumoFio'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;background-color:#D3D3D3"> '.number_format($value['PesoInd'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;background-color:#D3D3D3"> '.number_format($value['PesoIndAcab'], 2, ',', '.').' </td>'
                             .'<td style="font-size:13px;background-color:#D3D3D3"> '.number_format($value['PesoIndFio'], 2, ',', '.').' </td>';
             $sHtmRetorno .='</tr>';
         }
         echo '$("#'.$aIds[0].' > tbody").append(\''.$sHtmRetorno.'\');';
         
         //carrega os somatórios
         echo "$('#".$aIds[1]."').val('R$ ".number_format($aDadosFat['Total']['ValorFat'],2,',','.')."');";
         echo "$('#".$aIds[2]."').val('R$ ".number_format($aDadosFat['Total']['ValorServico'],2,',','.')."');";
         echo "$('#".$aIds[3]."').val('R$ ".number_format($aDadosFat['Total']['ValorInsumo'],2,',','.')."');";
         
     //number_format($aDadosFatDiarioValorSerIns['ValorTotalVenda'], 2, ',', '.')
    }
}

