<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaPedRep extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.pev01');
        
        $this->adicionaRelacionamento('pdvnro','pdvnro',true,true,true);
        $this->adicionaRelacionamento('pdvordcomp', 'pdvordcomp');
        $this->adicionaRelacionamento('empcod', 'Pessoa.empcod');
        $this->adicionaRelacionamento('pdvemissao', 'pdvemissao');
        $this->adicionaRelacionamento('pdvdtentre', 'pdvdtentre');
        $this->adicionaRelacionamento('situaca', 'situaca',false,true,false, CampoBanco::TIPO_FORALISTA);
        $this->adicionaRelacionamento('pdvobs', 'pdvobs');
        $this->adicionaRelacionamento('filcgc','filcgc');
        $this->adicionaRelacionamento('pdvrepcod','pdvrepcod');
        
        $this->adicionaJoin('Pessoa');
        
        
        $this->setSTop(30);
        $this->adicionaOrderBy('pdvnro',1);  
        
        
        $this->adicionaFiltro('filcgc', '75483040000211');
        
        
        $this->setSWhereManual(" AND PDVSITUACA IN ('O','T','C','B')");
        
        
        if(isset($_SESSION['repsoffice'])){  
            $aValor = explode(',', $_SESSION['repsoffice']);
            $this->adicionaFiltro('pdvrepcod',$aValor,0,9);
        }
        //seta case
        $this->setSCase(",case 
                when widl.PEV01.pdvsituaca = 'O' then 'LIBERADO' 
                when widl.PEV01.pdvsituaca = 'T' then 'FATURADO' 
		      when widl.pev01.pdvsituaca = 'C' then 'CANCELADO'
		      when widl.pev01.pdvsituaca = 'B' then 'BLOQUEADO' 
		      END AS 'widl.pev01.situaca' ");
    }
    
    public function consultaManual() {
        parent::consultaManual();
        
        $sSql = "select top(40) widl.pev01.pdvnro as 'widl.pev01.pdvnro',
                widl.pev01.pdvordcomp as 'widl.pev01.pdvordcomp',
                widl.pev01.empcod as 'widl.pev01.empcod',
                widl.emp01.empdes as 'widl.emp01.empdes',
                widl.pev01.pdvemissao as 'widl.pev01.pdvemissao' , 
                widl.pev01.pdvdtentre as 'widl.pev01.pdvdtentre', 
                case 
                when widl.PEV01.pdvsituaca = 'O' then 'LIBERADO' 
                when widl.PEV01.pdvsituaca = 'T' then 'FATURADO' 
		      when widl.pev01.pdvsituaca = 'C' then 'CANCELADO'
		      when widl.pev01.pdvsituaca = 'B' then 'BLOQUEADO' 
		      END AS 'widl.pev01.situaca',
                      widl.pev01.pdvobs as 'widl.pev01.pdvobs' 
                from widl.PEV01(nolock)  left outer join widl.EMP01(nolock) 
               on widl.PEV01.empcod = widl.EMP01.empcod  ";
            
            
        return $sSql; 
        
       
        
    }
    
    
    
}
