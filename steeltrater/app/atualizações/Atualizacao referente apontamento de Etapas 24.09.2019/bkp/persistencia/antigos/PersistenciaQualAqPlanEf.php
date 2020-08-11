<?php

/**
 * Class responsável pela acao de persistencia  
 * 
 * @autho Avanei Martendal
 * 
 * @since 10/07/2017
 * 
 * @obs Classe responsável por implementar novos 
 * planos de acao baseados em uma avaliacao da eficiência que nao foi eficaz
 */


class PersistenciaQualAqPlanEf extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbacaoqualplan');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true,true);
        $this->adicionaRelacionamento('nr','nr',true,true);
        $this->adicionaRelacionamento('seq', 'seq',true,true,true);
        $this->adicionaRelacionamento('plano','plano');
        $this->adicionaRelacionamento('dataprev', 'dataprev');
        $this->adicionaRelacionamento('anexoplan1', 'anexoplan1');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('tipo','tipo');
        
        $this->adicionaOrderBy('seq',1);
    }
    
    
    
    
}


