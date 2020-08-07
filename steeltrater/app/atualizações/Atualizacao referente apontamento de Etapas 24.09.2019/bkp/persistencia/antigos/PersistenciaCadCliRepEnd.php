<?php
/**
 * Class que implementa a persistencia CadCliRepEnd para inserçao de cobrancás 
 * @author Avanei Martendal
 * @since 27/09/2017
 */

Class PersistenciaCadCliRepEnd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('pdfempcadEnd');
        
        $this->adicionaRelacionamento('nr','nr',true,true);
        $this->adicionaRelacionamento('empcod','empcod',true,true);
        $this->adicionaRelacionamento('tipo','tipo',true,true);
        
        $this->adicionaRelacionamento('ender','ender');
        $this->adicionaRelacionamento('endnr','endnr');
        $this->adicionaRelacionamento('endbairr','endbairr');
        $this->adicionaRelacionamento('endcep','endcep');
        $this->adicionaRelacionamento('endcid','endcid');
        $this->adicionaRelacionamento('enduf','enduf');
        
        $this->adicionaRelacionamento('endcnpj','endcnpj');
        $this->adicionaRelacionamento('endInsc','endInsc');
        $this->adicionaRelacionamento('empendfone','empendfone');
        $this->adicionaRelacionamento('empendemail','empendemail');
        $this->adicionaRelacionamento('empendobs','empendobs');
        
        
   
    }
}
