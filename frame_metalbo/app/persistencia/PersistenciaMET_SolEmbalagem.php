<?php 
 /*
 * Implementa a classe persistencia MET_SolEmbalagem
 * @author Cleverton Hoffmann
 * @since 24/07/2020
 */ 
class PersistenciaMET_SolEmbalagem extends Persistencia { 
    public function __construct() {
        parent::__construct(); 
        $this->setTabela('pdfsolemb');
        $this->adicionaRelacionamento('id','id', true, true);
        $this->adicionaRelacionamento('nr','nr');
        $this->adicionaRelacionamento('tipo','tipo');
        $this->adicionaRelacionamento('empcod','empcod');
    } 
}