<?php 
 /*
 * Implementa a classe persistencia MET_RedeMetalbo
 * @author Cleverton Hoffmann
 * @since 29/10/2020
 */
 
class PersistenciaMET_RedeMetalbo extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('tbredemet');
        $this->adicionaRelacionamento('cod','cod', true, true, true);
        $this->adicionaRelacionamento('hostname','hostname');
        $this->adicionaRelacionamento('ip','ip');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('mac','mac');
        $this->adicionaRelacionamento('tipo','tipo');
    } 
}