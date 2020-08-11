<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaEmpenhoPed extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.pev01');
        
        $this->adicionaRelacionamento('pdvnro', 'pdvnro',true,true,true);
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('total','total');
        $this->adicionaRelacionamento('pdvdtentre', 'pdvdtentre');
        $this->adicionaRelacionamento('pdvemissao', 'pdvemissao');
        $this->adicionaRelacionamento('situaca','situaca');
        
        $this->setBConsultaManual(true);
        
       
    }
    
    public function consultaManual() {
        parent::consultaManual();
        
        $sSql  = "select widl.PEV01.pdvnro as 'widl.pev01.pdvnro',
	   widl.PEV01.empcod  as 'widl.pev01.empcod', 
	   widl.EMP01.empdes as 'widl.pev01.empdes',
      (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf) as 'widl.pev01.total', 
       convert(varchar,widl.PEV01.pdvdtentre,103) as 'widl.PEV01.pdvdtentre', 
      convert(varchar,widl.pev01.pdvemissao,103) as 'widl.pev01.pdvemissao', 
      case 
      when widl.PEV01.pdvsituaca = 'O' then 'LIBERADO'
      when widl.PEV01.pdvsituaca = 'T' then 'FATURADO'
		      when widl.pev01.pdvsituaca = 'C' then 'CANCELADO'
		      when widl.pev01.pdvsituaca = 'B' then 'BLOQUEADO'
		      END AS 'widl.pev01.situaca' 
      from widl.PEV01(nolock),widl.PEDV01(nolock),widl.EMP01(nolock) ";
        
        return $sSql;
    }
    
    public function somaPedidos($sProcod){
        $sSql = "select SUM(widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf) as total 
          from widl.PEV01(nolock),widl.PEDV01(nolock),widl.EMP01(nolock)  where 
          widl.PEV01.pdvnro = widl.PEDV01.pdvnro 
          and widl.pev01.empcod=widl.emp01.empcod  
          and widl.PEDV01.procod =".$sProcod." and 
          widl.pev01.filcgc =  75483040000211 
          and widl.pev01.empcod <> 75483040000211
          and widl.PEV01.pdvsituaca = 'O'
          and (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf)>0 
          and pdvrepcod <>'500'";
        
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $iTotalInterno = $row->total;
        
        //soma exportacoes
        $sSql = "select SUM(widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf) as total 
          from widl.PEV01(nolock),widl.PEDV01(nolock),widl.EMP01(nolock)  where 
          widl.PEV01.pdvnro = widl.PEDV01.pdvnro 
          and widl.pev01.empcod=widl.emp01.empcod  
          and widl.PEDV01.procod =".$sProcod." and 
          widl.pev01.filcgc =  75483040000211 
          and widl.pev01.empcod <> 75483040000211
          and widl.PEV01.pdvsituaca = 'O'
          and (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf)>0 
          and pdvrepcod ='500'";
         $result = $this->getObjetoSql($sSql);
         $row = $result->fetch(PDO::FETCH_OBJ);
        
        $iTotalExp = $row->total;
        
        $sSql = " select SUM(widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf) as total 
          from widl.PEV01(nolock),widl.PEDV01(nolock),widl.EMP01(nolock)  where 
          widl.PEV01.pdvnro = widl.PEDV01.pdvnro 
          and widl.pev01.empcod=widl.emp01.empcod  
          and widl.PEDV01.procod =".$sProcod." and 
          widl.pev01.filcgc =  75483040000211 
          and widl.pev01.empcod <> 75483040000211 
          and widl.PEV01.pdvsituaca = 'O'
          and (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf)>0 
          and pdvrepcod ='500'
          /*CARREGA ITENS COM EXPORTAÇÃO LIBERADAS*/
          and widl.PEV01.pdvnro not in 
          (select widl.pev01.pdvnro 
          from widl.PEV01 left outer join 
          widl.PEdV01 on widl.PEV01.pdvnro = widl.PEDV01.pdvnro left outer join 
          pdfexportacao on widl.PEV01.pdvnro = pdfexportacao.pdvnro 
          where pdvsituaca = 'O' and pdvrepcod = '500'
          and codsit is null 
          or codsit in (1,2))";
        
         $result = $this->getObjetoSql($sSql);
         $row = $result->fetch(PDO::FETCH_OBJ);
        
        $iTotalExpLib = $row->total;
        
        
        $aDados = array();
        $aDados['interno']=$iTotalInterno;
        $aDados['export']=$iTotalExp;
        $aDados['exportlib']=$iTotalExpLib;
        return $aDados;
        
    }
}