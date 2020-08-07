<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaRepDay extends Persistencia {
    public function __construct() {
        parent::__construct();
    }
    
    public function buscaDados($sDados){
        $aDados = array();
        //libera o total de solicitações liberadas para a metalbo
        $sTabelaSolCab = $_SESSION['officecabsol'];
        $sTabelaSolIten = $_SESSION['officecabsoliten'];
        $sTabelaCotCab = $_SESSION['officecabcot'];
        $reps = $_SESSION['repsoffice'];
        $sData = date('d/m/Y');
        $sSql = "select COUNT(*) as totalsol from ".$sTabelaSolCab." where datalib ='".$sData."' and EMAIL = 'EV'";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de solicitações liberadas'] = $row->totalsol; 
        //libera o total de cotações
        $sSql = "select COUNT(*) as totalcot from ".$sTabelaCotCab." where DATA ='".$sData."' ";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de cotações'] = $row->totalcot; 
        //traz o número de pedidos emitidos por representante
        $sSql = "select COUNT(*) as totalped from widl.PEV01 where pdvemissao = '".$sData."' and pdvrepcod in(".$reps.") "
                . "and pdvsituaca in ('O','T','B','C')";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de solicitação que viraram pedidos'] = $row->totalped; 
        //carrega o total de notas emitidas
        $sSql = "select COUNT(*) as totalnf
          from widl.NFC001(nolock),
          widl.mov01(nolock)
          where widl.nfc001.nfsmovcod = widl.MOV01.movcod  
          and nfsdtemiss = '".$sData."'
          and nfscancela <> '*'
          and widl.NFC001.nfsfilcgc = '75483040000211'
          and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC001.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = '' 
          and nfsrepcod in(".$reps.")";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de notas fiscais'] = $row->totalnf; 
        
      
        
        return $aDados;
        
    }
    
    public function buscaDadosValor($sDados){
        $aDados = array();
        //libera o total de solicitações liberadas para a metalbo
        $sTabelaSolCab = $_SESSION['officecabsol'];
        $sTabelaSolIten = $_SESSION['officecabsoliten'];
        $sTabelaCotCab = $_SESSION['officecabcot'];
        $sTabelaCotIten = $_SESSION['officecabcotiten'];
        $reps = $_SESSION['repsoffice'];
        $sData = date('d/m/Y');
          //soma o total de solicitacoes 
             $sSql = "select SUM(VLRTOT) as totalsol from ".$sTabelaSolCab." left outer join ".$sTabelaSolIten."
                on ".$sTabelaSolCab.".NR = ".$sTabelaSolIten.".NR
                where datalib ='".$sData."' and EMAIL = 'EV'";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Valor de solicitações liberadas para Metalbo'] = $row->totalsol; 
        
        //valor das cotações emitida
        $sSql = "select SUM(VLRTOT) as totalcot from ".$sTabelaCotCab." left outer join ".$sTabelaCotIten."
                on ".$sTabelaCotCab.".NR = ".$sTabelaCotIten.".NR
                where ".$sTabelaCotCab.".DATA ='".$sData."' ";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Valor de cotações emitidas'] = $row->totalcot;
        
        $sSql = " select   sum((pdvproqtdp)*pdvprovlta) as total 
               from widl.PEDV01 left outer join widl.PEV01 
               on widl.PEDV01.filcgc = widl.PEV01.filcgc
               and widl.PEDV01.pdvnro = widl.PEV01.pdvnro
               where pdvemissao ='".$sData."'
               and widl.PEDV01.filcgc = 75483040000211
               and widl.PEV01.pdvrepcod in(".$reps.") and pdvsituaca in ('O','T','B','C')";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Valor de solicitações que viraram pedidos'] = $row->total;
        
        $sSql = "select  SUM(nfsitvlrto + nfsitvlrip + nfsitvlrsu -nfsitvlrde) vlrtotal
		  from widl.NFC001(nolock),widl.NFC003(nolock), 
          widl.mov01(nolock),widl.prod01(nolock) 
          where widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro 
          and widl.NFC003.nfsitcod = widl.prod01.procod 
          and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc 
          and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser 
          and widl.nfc001.nfsmovcod = widl.MOV01.movcod  
          and nfsdtemiss ='".$sData."' 
          and nfscancela <> '*' and widl.NFC001.nfsfilcgc = '75483040000211' 
          and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC003.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = ''
          and nfsrepcod in(".$reps.")";
        
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Total de notas emitidas'] = $row->vlrtotal;
        
        return $aDados;
    }
    
      public function buscaMesValor($sDados){
        $aDados = array();
        
        //libera o total de solicitações liberadas para a metalbo
        $sTabelaSolCab = $_SESSION['officecabsol'];
        $sTabelaSolIten = $_SESSION['officecabsoliten'];
        $sTabelaCotCab = $_SESSION['officecabcot'];
        $sTabelaCotIten = $_SESSION['officecabcotiten'];
        $reps = $_SESSION['repsoffice'];
        $sDataini = Util::getPrimeiroDiaMes();
        $sData = date('d/m/Y');
          //soma o total de solicitacoes 
             $sSql = "select SUM(VLRTOT) as totalsol from ".$sTabelaSolCab." left outer join ".$sTabelaSolIten."
                on ".$sTabelaSolCab.".NR = ".$sTabelaSolIten.".NR
                where datalib between '".$sDataini."'  and '".$sData."' and EMAIL = 'EV'";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Valor de solicitações liberadas para Metalbo no mês'] = $row->totalsol; 
        
        
         //valor das cotações emitida
        $sSql = "select SUM(VLRTOT) as totalcot from ".$sTabelaCotCab." left outer join ".$sTabelaCotIten."
                on ".$sTabelaCotCab.".NR = ".$sTabelaCotIten.".NR
                where ".$sTabelaCotCab.".DATA between '".$sDataini."'  and '".$sData."' ";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Valor de cotações emitidas durante o mês'] = $row->totalcot;
        
         $sSql = " select   sum((pdvproqtdp)*pdvprovlta) as total 
               from widl.PEDV01 left outer join widl.PEV01 
               on widl.PEDV01.filcgc = widl.PEV01.filcgc
               and widl.PEDV01.pdvnro = widl.PEV01.pdvnro
               where pdvemissao between '".$sDataini."'  and '".$sData."'
               and widl.PEDV01.filcgc = 75483040000211
               and widl.PEV01.pdvrepcod in(".$reps.") and pdvsituaca in ('O','T','B','C')";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Valor de solicitações que viraram pedidos durante o mês'] = $row->total;
        
        $sSql = "select  SUM(nfsitvlrto + nfsitvlrip + nfsitvlrsu -nfsitvlrde) vlrtotal
		  from widl.NFC001(nolock),widl.NFC003(nolock), 
          widl.mov01(nolock),widl.prod01(nolock) 
          where widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro 
          and widl.NFC003.nfsitcod = widl.prod01.procod 
          and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc 
          and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser 
          and widl.nfc001.nfsmovcod = widl.MOV01.movcod  
          and nfsdtemiss between '".$sDataini."'  and '".$sData."' 
          and nfscancela <> '*' and widl.NFC001.nfsfilcgc = '75483040000211' 
          and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC003.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = ''
          and nfsrepcod in(".$reps.")";
        
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Total de notas emitidas durante o mês'] = $row->vlrtotal;
        return $aDados;
      
    }
    
    public function buscaMesCount($sDados){
         $aDados = array();
        //libera o total de solicitações liberadas para a metalbo
        $sTabelaSolCab = $_SESSION['officecabsol'];
        $sTabelaSolIten = $_SESSION['officecabsoliten'];
        $sTabelaCotCab = $_SESSION['officecabcot'];
        $sDataini = Util::getPrimeiroDiaMes();
        $reps = $_SESSION['repsoffice'];
        $sData = date('d/m/Y');
        $sSql = "select COUNT(*) as totalsol from ".$sTabelaSolCab." where datalib between '".$sDataini."'  and '".$sData."' and EMAIL = 'EV'";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de solicitações liberadas'] = $row->totalsol; 
        //libera o total de cotações
        $sSql = "select COUNT(*) as totalcot from ".$sTabelaCotCab." where DATA between '".$sDataini."'  and '".$sData."' ";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de cotações'] = $row->totalcot; 
        //traz o número de pedidos emitidos por representante
        $sSql = "select COUNT(*) as totalped from widl.PEV01 where pdvemissao between '".$sDataini."'  and '".$sData."' "
                . "and pdvrepcod in(".$reps.") and pdvsituaca in ('O','T','B','C')";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de solicitação que viraram pedidos'] = $row->totalped; 
        //carrega o total de notas emitidas
        $sSql = "select COUNT(*) as totalnf
          from widl.NFC001(nolock),
          widl.mov01(nolock)
          where widl.nfc001.nfsmovcod = widl.MOV01.movcod  
          and nfsdtemiss between '".$sDataini."'  and '".$sData."'
          and nfscancela <> '*'
          and widl.NFC001.nfsfilcgc = '75483040000211'
          and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC001.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = '' 
          and nfsrepcod in(".$reps.")";
        $sResult = $this->getObjetoSql($sSql);
        $row = $sResult->fetch(PDO::FETCH_OBJ);
        $aDados['Número de notas fiscais'] = $row->totalnf; 
        
      
        
        return $aDados;
    }
}