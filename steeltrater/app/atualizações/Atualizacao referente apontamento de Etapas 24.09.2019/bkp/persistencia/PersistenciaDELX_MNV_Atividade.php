<?php

/*
 * Classe que implementa a persistencia de atividade
 * 
 * @author Cleverton Hoffmann
 * @since 29/06/2018
 */

class PersistenciaDELX_MNV_Atividade extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MNV_ATIVIDADE');

        $this->adicionaRelacionamento('mnv_atividadecodigo', 'mnv_atividadecodigo', true, true);
        $this->adicionaRelacionamento('mnv_atividadedescricao', 'mnv_atividadedescricao');
        $this->adicionaRelacionamento('mnv_atividadeprodutocodigo', 'mnv_atividadeprodutocodigo');
        $this->adicionaRelacionamento('eng_atividadeobservacao', 'eng_atividadeobservacao');
        $this->adicionaRelacionamento('eng_atividadeterceiro', 'eng_atividadeterceiro');
        $this->adicionaRelacionamento('eng_atividadeparada', 'eng_atividadeparada');
        $this->adicionaRelacionamento('eng_atividaderecursocodigo', 'eng_atividaderecursocodigo');
        $this->adicionaRelacionamento('mnt_atividadetempo', 'mnt_atividadetempo');
        $this->adicionaRelacionamento('mnt_atividadeprioridade', 'mnt_atividadeprioridade');
        $this->adicionaRelacionamento('mnt_atividadeobservacao', 'mnt_atividadeobservacao');
        $this->adicionaRelacionamento('mnt_atividadetipomanutencao', 'mnt_atividadetipomanutencao');
        $this->adicionaRelacionamento('mnt_atividadearea', 'mnt_atividadearea');
        $this->adicionaRelacionamento('eng_atividadeinativa', 'eng_atividadeinativa');


        $this->setSTop('1000');
        $this->adicionaOrderBy('mnv_atividadecodigo', 0);
    }

}
