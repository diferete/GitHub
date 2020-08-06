<?php 
 /*
 * Implementa a classe persistencia MET_ServicoOrdemCompra
 * @author Cleverton Hoffmann
 * @since 22/07/2020
 */
 
class PersistenciaMET_ServicoOrdemCompra extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('tbservoc');
        
        $this->adicionaRelacionamento('seq','seq', true, true, true);
        $this->adicionaRelacionamento('empcod','empcod');
        $this->adicionaRelacionamento('empcod','Pessoa.empcod', false, false,false);
        $this->adicionaRelacionamento('empdes','Pessoa.empdes', false, false,false);
        $this->adicionaRelacionamento('grupo','grupo');
        $this->adicionaRelacionamento('codserv','codserv');
        $this->adicionaRelacionamento('codserv','Produto.procod', false, false,false);
        $this->adicionaRelacionamento('prodes','Produto.prodes', false, false,false);
        $this->adicionaRelacionamento('tips','tips');
        $this->adicionaRelacionamento('descserv','descserv');
        $this->adicionaRelacionamento('valoruni','valoruni');
        
        $this->adicionaOrderBy('seq', 0);
        $this->adicionaJoin('Produto', null, 1, 'codserv', 'procod');
        $this->adicionaJoin('Pessoa');
        $this->setSTop('100');
    } 
}