<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaGerenContRec extends Persistencia{
     public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbcontrec_parc');
        
        $this->adicionaRelacionamento('empcnpj','empcnpj',true,true);
        $this->adicionaRelacionamento('pescnpj','Pessoa.pescnpj',true,true);
        $this->adicionaRelacionamento('recdocto','recdocto',true,true);
        $this->adicionaRelacionamento('recparc','recparc',true,true,true);
        $this->adicionaRelacionamento('recparcvlr','recparcvlr');
        $this->adicionaRelacionamento('recparcvenc','recparcvenc');
        $this->adicionaRelacionamento('recobs','recobs');
        $this->adicionaRelacionamento('recsit','recsit');
        $this->adicionaRelacionamento('recdatapag', 'recdatapag');
        $this->adicionaRelacionamento('recobspag', 'recobspag');
        $this->adicionaRelacionamento('recuserapont', 'recuserapont');
        
        $this->adicionaJoin('Pessoa');
        
        
    }
    /**
     * Muda a situação do contas a receber
     */
    public function mudaSitRec($sEmpcnpj,$sPescnpj,$sRecDocto, $sRecParc){
         $sSql ="update tbcontrec_parc set recsit = 'Pago' 
                where empcnpj = '".$sEmpcnpj."'
                and pescnpj = '".$sPescnpj."'
                and recdocto = '".$sRecDocto."'
                and recparc = '".$sRecParc."'";
         $aRetorno =$this->executaSql($sSql);   
         return $aRetorno;
    }
}