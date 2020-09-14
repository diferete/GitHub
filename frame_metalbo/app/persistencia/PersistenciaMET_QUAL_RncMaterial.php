<?php 
 /*
 * Implementa a classe persistencia MET_QUAL_RncMaterial
 * @author Cleverton Hoffmann
 * @since 25/08/2020
 */

class PersistenciaMET_QUAL_RncMaterial extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('MET_QUAL_RncMaterial');
        $this->adicionaRelacionamento('cod','cod', true, true, true);
        $this->adicionaRelacionamento('corrida','corrida');
        
        $this->adicionaOrderBy('cod', 0);
        $this->setSTop(50);
    } 
}