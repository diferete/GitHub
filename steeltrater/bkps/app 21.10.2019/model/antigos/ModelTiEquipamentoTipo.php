<?php
/**
 * Description of ModelEquipamentoTiTipo
 *
 * @author Carlos
 */
class ModelTiEquipamentoTipo {
    private $eqtipcod;
    private $eqtipdescricao;
    
 
    function getEqtipcod() {
        return $this->eqtipcod;
    }

    function getEqtipdescricao() {
        return $this->eqtipdescricao;
    }

    function setEqtipcod($eqtipcod) {
        $this->eqtipcod = $eqtipcod;
    }

    function setEqtipdescricao($eqtipdescricao) {
        $this->eqtipdescricao = $eqtipdescricao;
    }


    
}
