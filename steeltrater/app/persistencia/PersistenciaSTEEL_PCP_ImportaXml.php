<?php

/* 
 * Classe que implenta a importação do xml para gerar ordens de produção
 * 
 * @author Avanei Martendal
 * @since 13/02/2019
 */
class PersistenciaSTEEL_PCP_ImportaXml extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ImportaXml');
        
        $this->adicionaRelacionamento('seq', 'seq',true,true,true);
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('nfnro', 'nfnro');
        $this->adicionaRelacionamento('nfser', 'nfser');
        $this->adicionaRelacionamento('nfseq','nfseq');
        
        $this->adicionaRelacionamento('procod','procod');
        $this->adicionaRelacionamento('prodes','prodes');
        $this->adicionaRelacionamento('un','un');
        $this->adicionaRelacionamento('qtd','qtd');
        $this->adicionaRelacionamento('vlrUnit','vlrUnit');
        $this->adicionaRelacionamento('vlrTotal','vlrTotal');
        $this->adicionaRelacionamento('opSteel','opSteel');
        $this->adicionaRelacionamento('dataimp','dataimp');
        $this->adicionaRelacionamento('horaimp','horaimp');
        $this->adicionaRelacionamento('ncm','ncm');
        $this->adicionaRelacionamento('opCliente','opCliente');
        $this->adicionaRelacionamento('xPed', 'xPed');
        $this->adicionaRelacionamento('nItemPed','nItemPed');
       
        $this->setSTop('400');
        $this->adicionaOrderBy('seq',1);
    }
    
     public function atualizaImpXml($aCampos){
        
        $sSql = "update STEEL_PCP_ImportaXml  "
                . "set opSteel = '".$aCampos['op']."' "
                . "where seq =".$aCampos['seq']."";
        
        $aRetorno = $this->executaSql($sSql);
        
    }
}
