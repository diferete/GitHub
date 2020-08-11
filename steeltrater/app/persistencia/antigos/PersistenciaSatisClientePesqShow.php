<?php


/* 
 * Classe que implementa a persistencia da classe SatisClientePesq
 * @author Avanei Martendal 
 * @since 15/01/2018
 */

class PersistenciaSatisClientePesqShow extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbsatisclientepesq');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true,true);
        $this->adicionaRelacionamento('nr','nr',true,true);
        $this->adicionaRelacionamento('seq', 'seq',true,true,true);
        
        $this->adicionaRelacionamento('empcod','empcod');
        $this->adicionaRelacionamento('empdes','empdes');
        
        
        $this->adicionaRelacionamento('comercial','comercial');
        
        $this->adicionaRelacionamento('prodrequisito','prodrequisito');
        $this->adicionaRelacionamento('prodembalagem ','prodembalagem');
        
        $this->adicionaRelacionamento('prodprazo','prodprazo');
        $this->adicionaRelacionamento('geralexpectativa','geralexpectativa');
        $this->adicionaRelacionamento('geralindica','geralindica');
        
        $this->adicionaRelacionamento('contato','contato');
        
        $this->adicionaRelacionamento('email', 'email');
        
        $this->adicionaRelacionamento('obs','obs');
        
        $this->adicionaRelacionamento('emailenv','emailenv');
        
        $this->adicionaOrderBy('seq',1);
        
      
        
    }
}
