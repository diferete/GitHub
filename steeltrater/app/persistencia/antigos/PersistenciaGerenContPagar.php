<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaGerenContPagar extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbcontpagar_item');
        
        $this->adicionaRelacionamento('empcnpj', 'empcnpj',true,true);
        $this->adicionaRelacionamento('nfdoc', 'nfdoc',true,true);
        $this->adicionaRelacionamento('nfserie', 'nfserie',true,true);
        $this->adicionaRelacionamento('pescnpj', 'Pessoa.pescnpj',true,true);
        $this->adicionaRelacionamento('contseq', 'contseq',true,true);//contvlr
        $this->adicionaRelacionamento('contvlr', 'contvlr');
        $this->adicionaRelacionamento('contvenc', 'contvenc');
        $this->adicionaRelacionamento('contsit', 'contsit');
        $this->adicionaRelacionamento('contdatapag', 'contdatapag');
        $this->adicionaRelacionamento('origcod','origcod');
        $this->adicionaRelacionamento('origdes','origdes');
        $this->adicionaRelacionamento('contpagobs', 'contpagobs');
        $this->adicionaJoin('Pessoa');
        
    }
    
    public function mudasitTitulo(){
        $sChave = $this->getStringChave(); 
        $sSql = "update tbcontpagar_item set contsit = 'Pago' 
        where ".$sChave ;
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }
    
    public function retornaSitTitulo($aChave){
      $sSql = "update tbcontpagar_item set contsit = 'Sem pagamento',
        contdatapag = '', origcod = '', contpagobs = '',origdes = '' 
        where tbcontpagar_item.empcnpj = '".$aChave['empcnpj']."' 
        AND tbcontpagar_item.nfdoc = '".$aChave['nfdoc']."'
        AND tbcontpagar_item.nfserie = '".$aChave['nfserie']."'
        AND tbcontpagar_item.pescnpj = '".$aChave['Pessoa_pescnpj']."' 
        AND tbcontpagar_item.contseq = '".$aChave['contseq']."'";  
      $aRetorno = $this->executaSql($sSql);
      return $aRetorno;
        
    }
}