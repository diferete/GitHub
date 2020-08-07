<?php
/**
 * Persistencia da classe que implementa o Tipo de Equipamento
 *
 * @author Carlos
 */
class PersistenciaTiEquipamentoTipo extends Persistencia {
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbtiequiptipo');
        
        $this->adicionaRelacionamento('eqtipcod', 'eqtipcod', true, true, true);
        $this->adicionaRelacionamento('eqtipdescricao', 'eqtipdescricao');
         
    }
}
