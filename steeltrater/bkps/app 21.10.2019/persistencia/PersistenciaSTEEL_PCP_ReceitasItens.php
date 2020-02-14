<?php

/* 
 * Classe que implementa os itens da receita
 * 
 * @author Avanei Martendal
 * @since 15/06/2018
 * 
 */

class PersistenciaSTEEL_PCP_ReceitasItens extends Persistencia {
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_receitasItens');
        
        $this->adicionaRelacionamento('cod','cod',true,true);
        $this->adicionaRelacionamento('seq','seq',true,true,true);
        $this->adicionaRelacionamento('tratcod', 'STEEL_PCP_Tratamentos.tratcod');
        $this->adicionaRelacionamento('camada_min', 'camada_min');
        $this->adicionaRelacionamento('camada_max', 'camada_max');   
        $this->adicionaRelacionamento('temperatura','temperatura');
        $this->adicionaRelacionamento('Tempo','tempo');
        $this->adicionaRelacionamento('Resfriamento','resfriamento');
        
        $this->adicionaJoin('STEEL_PCP_Tratamentos');
       
    }
    
    public function buscaPeso($aCampos){
        $sSql = "select temperatura from STEEL_PCP_receitasItens where tratcod in (3,17,19) and cod ='".$aCampos['receita']."'";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->temperatura;
        
        
    }
}