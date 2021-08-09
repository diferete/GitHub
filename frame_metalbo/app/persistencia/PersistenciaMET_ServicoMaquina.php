<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class PersistenciaMET_ServicoMaquina extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbservmp');
        
        $this->adicionaRelacionamento('codsit','codsit',true,true, true);
        $this->adicionaRelacionamento('tipcod', 'tipcod');
        $this->adicionaRelacionamento('tipcod', 'MET_CadastroMaquinas.tipcod',false,false,false);
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('codsetor', 'Setor.codsetor',false,false,false);
        $this->adicionaRelacionamento('servico', 'servico');
        $this->adicionaRelacionamento('ciclo','ciclo');
        $this->adicionaRelacionamento('resp','resp');
        $this->adicionaRelacionamento('usercad','usercad');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('sit','sit');
        $this->adicionaFiltro('sit', 'ABERTO');
        
        $this->adicionaOrderBy('codsit',1);
        $this->adicionaOrderBy('servico',0);
        $this->adicionaJoin('MET_CadastroMaquinas');
        $this->adicionaJoin('Setor');
        
    }
    
    
    public function FinanizaServico($iCodSit){
                
        $sSql = "update tbitensmp set sitmp = 'FINALIZADO', "
                . "datafech='" . $this->Model->getData() . "' , "
                . "userfinal = '" . $this->Model->getUsercad() . "' , "
                . "obs = 'SERVIÇO FINALIZADO' "
                . "where codsit='" . $iCodSit . "' and sitmp ='ABERTO' ";

        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
     
    }
}
