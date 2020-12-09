<?php 
 /*
 * Implementa a classe persistencia STEEL_PCP_ParForno
 * @author Cleverton Hoffmann
 * @since 03/12/2020
 */
 
class PersistenciaSTEEL_PCP_ParForno extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('STEEL_PCP_ParForno');
        $this->adicionaRelacionamento('cod','cod', true, true, true);
        $this->adicionaRelacionamento('codmotivo','codmotivo');
        $this->adicionaRelacionamento('fornocod','fornocod');
        $this->adicionaRelacionamento('datainicio','datainicio');
        $this->adicionaRelacionamento('horainicio','horainicio');
        $this->adicionaRelacionamento('coduseraberto','coduseraberto');
        $this->adicionaRelacionamento('desuseraberto','desuseraberto');
        $this->adicionaRelacionamento('coduserfechou','coduserfechou');
        $this->adicionaRelacionamento('desuserfechou','desuserfechou');
        $this->adicionaRelacionamento('datafim','datafim');
        $this->adicionaRelacionamento('horafim','horafim');
        $this->adicionaRelacionamento('obs','obs');
    } 
}