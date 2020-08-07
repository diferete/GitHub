<?php 
 /*
 * Implementa a classe persistencia MET_ItenEsp
 * @author Cleverton Hoffmann
 * @since 10/07/2020
 */
 
class PersistenciaMET_ItenEsp extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('TbitenEsp');
        $this->adicionaRelacionamento('procod','procod', true, true);
        $this->adicionaRelacionamento('tipoesp','tipoesp');
        $this->adicionaRelacionamento('imagem','imagem');
        $this->adicionaJoin('Produto');
       
        $this->setSTop('50');
    } 
}