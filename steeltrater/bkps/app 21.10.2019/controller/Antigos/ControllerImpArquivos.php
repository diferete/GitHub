<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerImpArquivos extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('ImpArquivos');
    }
    
    public function impXlsPreco($sDados){
        $this->Persistencia->buscaPreco($sDados);
        $oMensagem = new Modal('Finalizado importação','Sistema finalizou importação e atualização de preços', Modal::TIPO_SUCESSO,false,true,true);
         echo $oMensagem->getRender();
    }
    
    public function insertPreco($sDados){
        $this->Persistencia->insertPreco($sDados);
        $oMensagem = new Modal('Finalizado importação','Sistema finalizou importação e atualização de preços', Modal::TIPO_SUCESSO,false,true,true);
         echo $oMensagem->getRender();
    }
   
}