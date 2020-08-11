<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class PersistenciaMET_MP_Maquinas extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('metmaq');
        
        $this->adicionaRelacionamento('cod','cod',true,true, true);
        $this->adicionaRelacionamento('maquina', 'maquina');
        $this->adicionaRelacionamento('maqtip', 'maqtip');
        $this->adicionaRelacionamento('nomeclatura', 'nomeclatura');
        $this->adicionaRelacionamento('seq', 'seq');
        $this->adicionaRelacionamento('tipmanut', 'tipmanut');
        $this->adicionaRelacionamento('sitmaq', 'sitmaq');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaFiltro('sitmaq', 'ATIVA');
        
        $this->setSTop(50);
        
        $this->adicionaOrderBy('cod',0);
        
    }
    /**
     * Retorna array com dados da célula
     * @return type
     */
    public function buscaDadosCelula(){
        
        $sSql = "select seq from metmaq where seq>=0 group by seq order by seq";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
    /**
     * Retorna array com dados do Setor
     * @return type
     */
    public function buscaDadosSetor(){
        
        $sSql = "select codsetor,descsetor from MetCad_Setores order by codsetor";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow1 = Array();
        $aRow2 = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow1[$iI]= $key['codsetor'];
            $aRow2[$iI] = $key['descsetor'];
            $iI++;
        }
        $aRow[0] = $aRow1;
        $aRow[1] = $aRow2;
        return $aRow;
    }
    
<<<<<<< HEAD:steeltrater/app/BKP/app/persistencia/PersistenciaMET_Maquinas.php
    public function buscaDadosTipManut(){
=======
    /**
     * Retorna array com dados do Responsável
     * @return type
     */
    public function buscaDadosResp(){
>>>>>>> a54785e83fce56537b06fb4e15ca79b1f590fce7:frame_metalbo/app/persistencia/PersistenciaMET_MP_Maquinas.php
        
        $sSql = "select tipmanut from metmaq where tipmanut is not null group by tipmanut";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
    /**
     * Retorna array com dados do tipo de máquina
     * @return type
     */
    public function buscaDadosMaqTip(){
        $sSql = "select maqtip from metmaq group by maqtip";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
}
