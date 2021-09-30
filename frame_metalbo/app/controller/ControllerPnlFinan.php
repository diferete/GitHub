<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerPnlFinan extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('PnlFinan');
        $this->setControllerDetalhe('SolPedIten');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
        
    }
    
   public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        
        $oModelPessoa = Fabrica::FabricarModel('Pessoa');
        $oPersPessoa = Fabrica::FabricarPersistencia('Pessoa');
        $oPersPessoa->setModel($oModelPessoa);
        $oPersPessoa->adicionaFiltro('empcod',$aChave[0]);            
        $oModelPessoa = $oPersPessoa->consultarWhere();
        
        $aCampos[] = $aChave[0];
        $aCampos[] = $oModelPessoa->getEmpdes();
        $aCampos[] = $aChave[2];
        
       
        
        $this->View->setAParametrosExtras($aCampos);
        
       
    }
    
    public function calculoPersonalizado($sParametros = null,$aParam=null) {
        parent::calculoPersonalizado($sParametros);
        
        foreach ($aParam as $key => $value) {
            $sEmpcod=$value[0];
            $sCnpj = $value[1];
        }
        
        $iTotal = $this->Persistencia->somaTitulos();
        $iAtraso = $this->Persistencia->somaTitAtraso();
        $iMedia = $this->Persistencia->mediaFat($sCnpj);
        $iLimite = $this->Persistencia->limiteCred($sCnpj);
        
        if ($iLimite > 0){
            if($iLimite < $iTotal){
                $oMensagem = new Modal('Atenção','Este cliente está sem limite de crédito!',Modal::TIPO_INFO,false);
                echo $oMensagem->getRender();
            }
        }
        
         $xResult = '<b>Em aberto:</b> R$'.number_format($iTotal, 2,',','.').'    |  '
                .'<span class="cor_vermelho"><b>Atraso:</b> R$'.number_format($iAtraso, 2,',','.').'</span>  | '
                .'<span class="cor_verde"><b>Média de Faturamento:</b>R$ '.number_format($iMedia, 2,',','.').'</span> | ';
                if($iLimite > 0){
                  $xResult.='<span><b>Limite de crédito:</b>R$ '.number_format($iLimite, 2,',','.').'</span>'; 
                }else{
                    $xResult.='<span><b>SEM LIMITE DE CRÉDITO CADASTRADO!</b></span>';
                }
        return $xResult;
    }
    
   
}