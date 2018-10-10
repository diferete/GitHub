<?php

/* 
 * Classe que gera o certificado a partir de uma ordem de produção
 * 
 * @author Avanei Martendal
 / @since 07/10/2018 
 */

class PersistenciaSTEEL_PCP_GeraCertificado extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFab');
        
        $this->adicionaRelacionamento('op','op',true,true,true);
        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo');
        $this->adicionaRelacionamento('emp_razaosocial', 'emp_razaosocial');
        $this->adicionaRelacionamento('origem','origem');
        $this->adicionaRelacionamento('documento','documento');
        $this->adicionaRelacionamento('prod','prod');
        $this->adicionaRelacionamento('prodes','prodes');
        
        $this->adicionaRelacionamento('matcod','matcod');
        $this->adicionaRelacionamento('matdes','matdes');
        
        $this->adicionaRelacionamento('receita','receita');
        $this->adicionaRelacionamento('receita_des','receita_des');
        $this->adicionaRelacionamento('quant','quant');
        $this->adicionaRelacionamento('peso','peso');
        $this->adicionaRelacionamento('opcliente','opcliente');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('usuario','usuario');
        $this->adicionaRelacionamento('seqprodnf','seqprodnf');
        $this->adicionaRelacionamento('dataprev','dataprev');
        
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('temprev', 'temprev');
       
        $this->adicionaRelacionamento('seqmat', 'seqmat');
        
        $this->adicionaRelacionamento('retrabalho', 'retrabalho');
        $this->adicionaRelacionamento('op_retrabalho', 'op_retrabalho');
        
        $this->adicionaRelacionamento('nrcert','nrcert');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('300');
    }
    /**
     * Coloca certificado na op passando o objeto certificado onde terá op e certificado
     * @param type $oCert
     */
    public function putCertOp($oCert){
        $sSql = "update STEEL_PCP_ordensFab set nrcert ='".$oCert->getNrcert()."' where op ='".$oCert->getOp()."' ";
        $this->executaSql($sSql);
    }
}

