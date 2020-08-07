<?php

/**
 * Classe que mantem os equipamentos do setor de Tecnologia da Informação da Metalbo
 *
 * @author Carlos
 */
class PersistenciaTiEquipamento extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbtiequipamento');

        $this->adicionaRelacionamento('equipcod', 'equipcod', TRUE, TRUE, TRUE);
        $this->adicionaRelacionamento('eqtipcod', 'TiEquipamentoTipo.eqtipcod');
        $this->adicionaRelacionamento('equipusuario', 'equipusuario');
        $this->adicionaRelacionamento('equipfabricante', 'equipfabricante');
        $this->adicionaRelacionamento('equipmodelo', 'equipmodelo');
        $this->adicionaRelacionamento('equipsistema', 'equipsistema');
        $this->adicionaRelacionamento('equiplicenca', 'equiplicenca');
        $this->adicionaRelacionamento('equipmemoria', 'equipmemoria');
        $this->adicionaRelacionamento('equipcpu', 'equipcpu');
        $this->adicionaRelacionamento('equiphd', 'equiphd');
        $this->adicionaRelacionamento('equiphostname', 'equiphostname');
        $this->adicionaRelacionamento('equipmac', 'equipmac');
        $this->adicionaRelacionamento('ipfixo', 'ipfixo');
        $this->adicionaRelacionamento('nfe', 'nfe');
        $this->adicionaRelacionamento('equipsuprimento', 'equipsuprimento');
        $this->adicionaRelacionamento('codsetor', 'Setor.codsetor');
        $this->adicionaRelacionamento('filcgc', 'filcgc');
        $this->adicionaRelacionamento('equipdatacad', 'equipdatacad');
        $this->adicionaRelacionamento('equiphoracad', 'equiphoracad');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('numlic', 'numlic');
        $this->adicionaRelacionamento('office', 'office');
        $this->adicionaRelacionamento('licoffice', 'licoffice');
        $this->adicionaRelacionamento('equipimagem', 'equipimagem');
        
        $this->adicionaJoin('Setor');
        $this->adicionaJoin('TiEquipamentoTipo');
        $this->adicionaOrderBy('equipcod', 1);
        $this->setSTop('50');
    }

}
