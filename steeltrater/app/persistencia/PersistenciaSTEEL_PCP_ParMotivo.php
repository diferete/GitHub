<?php 
 /*
 * Implementa a classe persistencia STEEL_PCP_ParMotivo
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */
 
class PersistenciaSTEEL_PCP_ParMotivo extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('STEEL_PCP_ParMotivo');
        $this->adicionaRelacionamento('codmotivo','codmotivo', true, true, true);
        $this->adicionaRelacionamento('descricao','descricao');
    } 
}