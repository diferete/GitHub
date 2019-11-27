<?php

/*
 * Classe que gerencia a Persistência da MET_GerenciaFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class PersistenciaMET_GerenciaFrete extends Persistencia{
   public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbgerecfrete');
        
        $this->adicionaRelacionamento('nr','nr',true, true, true);
        $this->adicionaRelacionamento('cnpj','cnpj',false,true);
        $this->adicionaRelacionamento('cnpj','Pessoa.empcod',false,false);
        $this->adicionaRelacionamento('empdes','empdes',false,false);
        $this->adicionaRelacionamento('nrconhe','nrconhe');
        $this->adicionaRelacionamento('nrfat','nrfat');
        $this->adicionaRelacionamento('nrnotaoc','nrnotaoc');
        $this->adicionaRelacionamento('totakg','totakg');
        $this->adicionaRelacionamento('totalnf','totalnf');
        $this->adicionaRelacionamento('valorserv','valorserv');
        $this->adicionaRelacionamento('fracaofrete','fracaofrete');
        $this->adicionaRelacionamento('seqregra','seqregra');
        $this->adicionaRelacionamento('codtipo','codtipo');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('sit','sit');
        $this->adicionaRelacionamento('usuario','usuario');
        $this->adicionaRelacionamento('obsfinal','obsfinal');
        $this->adicionaRelacionamento('dataem', 'dataem');
        
        $this->adicionaOrderBy('nr',1);
        $this->adicionaJoin('Pessoa', null,1, 'cnpj','empcod');
   }
   
   /**
    * Método que consulta as empresas cadastradas na tabela de frete
    * @return type
    */
   public function buscaEmpresas(){
        $sSql = "select distinct cnpj,empdes from tbfrete left outer join widl.emp01
	         on tbfrete.cnpj =  widl.emp01.empcod ";       
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
     * Método que verifica se já existe um conhecimento igual inserido retornando valor 1 se sim
     * @param type $aValores
     * @return type
     */
    public function verificaConhec($aValores){
        $sSql="select count(nrconhe) as total from tbgerecfrete where nrconhe = ".$aValores['nrconhe']." "
              . "and cnpj = ".$aValores['cnpj']." ";

            $result = $this->getObjetoSql($sSql);
            $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow->total;
    }
    
    /**
     * Consulta os dados consistentes nas tabelas NFC001 e NFE01
     * @param type $aValores
     * @return type
     */
    public function consultaDados($aValores){
        
        if($aValores['codtipo']==1){
            
            $sSql=" select nfsnfnro as nota,nfsvlrtot,
                    Ceiling(nfspesobr) as pesoNota, Ceiling(nfspesobr/100) as FracaoFrete,
                   '".$aValores['cnpj']."' as cnpj ,'' as totalfrete, '' as freteminimo
                    from widl.NFC001 left outer join  widl.EMP01 
                    on widl.NFC001.nfsclicod =widl.EMP01.empcod
                    where nfsnfnro in(".$aValores['nrnotaoc'].")";

            $result = $this->getObjetoSql($sSql);
            $oRow = $result->fetch(PDO::FETCH_OBJ);
            
        }else if($aValores['codtipo'] == 2){
            
            $sSql2 = "select nfenro,nfevlrnota as nfsvlrtot,
                      nfetransp as cnpj 
                      from widl.NFE01 where nfetransp ='".$aValores['cnpj']."' and  nfenro = ".$aValores['nrnotaoc']." ";
            $result = $this->getObjetoSql($sSql2);
            $oRow = $result->fetch(PDO::FETCH_OBJ);
            
        }
        
        return $oRow;
        
    }
    
    /**
     * Retorna o tipo da tabela tbfrete
     * @param type $aValores
     * @return type
     */
    public function retornaCodTipo($aValores){
        
        $sSql=" select codtipo from tbfrete where cnpj = '".$aValores['cnpj']."' group by codtipo";

        $result = $this->getObjetoSql($sSql);
        
        $iI=0;
        while($key = $result->fetch(PDO::FETCH_ASSOC)){
            $aRow1[$iI]= $key;
            $iI++;
        }    
        
        return $aRow1;
        
    }
    
    /**
     * Realiza a consulta e execução de cálculos de frete
     * @param type $aValores
     * @return type Lista de valores de frete da transportadora
     */
    public function consultaDadosFormulas($aValores){
        
        $PDOnew = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
        
        $aRet1 = $PDOnew->exec("BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH "
                . "BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH ");
        
        if(($aValores['cnpj']=='3565095000260')
                ||($aValores['cnpj']=='428307001593')
                ||($aValores['cnpj']=='2633583000385')
                ||($aValores['cnpj']=='4353469003504')
                ||($aValores['cnpj']=='89317697001880')){
        
            $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH "
                 . "select ".$aValores['cnpj']." as cnpj, ".$aValores['nrnotaoc']." as nota, "
                 .$aValores['totalnf']." as nfsvlrtot, ".$aValores['totakg']." as pesoNota, "
                 .$aValores['fracaofrete']." as FracaoFrete,'' as totalfrete, '' as freteminimo into tbnt#";
            $aRetorno = $PDOnew->exec($sSqlAux);         
        }
        //MIRIN - Compra e Venda ?
        if($aValores['cnpj']=='3565095000260'){            
            
            if($aRetorno==1){
            $sSql1 = "select seq, ref, ROUND(
               ROUND(coalesce( fretevalor * nfsvlrtot ,0) +coalesce( pesoNota * fretepeso,0) +coalesce( pedagio * FracaoFrete,0)+taxa2 +tas+taxa+gris  ,2) * imposto/100 
               +ROUND(coalesce( fretevalor  * nfsvlrtot ,0) +coalesce( pesoNota * fretepeso,0) +coalesce( pedagio *FracaoFrete,0)+taxa2 +tas+taxa +gris ,2),2 ) as totalfrete,
                ROUND(
               ROUND(coalesce( fretevalor * nfsvlrtot ,0) +[taxamin] +coalesce( pedagio * FracaoFrete,0)+taxa2 +tas+taxa+gris  ,2) *imposto/100 
               +ROUND(coalesce( fretevalor * nfsvlrtot ,0)+ [taxamin]+coalesce( pedagio * FracaoFrete,0)+taxa2 +tas+taxa +gris ,2),2 ) as freteminimo
               from tbfrete left outer join tbnt#
               on tbfrete.cnpj = tbnt#.cnpj
               where tbfrete.cnpj =".$aValores['cnpj']." and tbfrete.codtipo = ".$aValores['codtipo']." ";
            
            $result = $PDOnew->query($sSql1);
            
            }
            
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
            
        }else
            
        //* EXPRESSO SÃO MIGUEL LTDA */ - COMPRA falta
        if($aValores['cnpj']=='428307001593'){

            if($aRetorno==1){
            $sSql1 = "select seq, ref, ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+
                coalesce(  nfsvlrtot * gris, 0),2)/imposto,2)  as totalfrete,
                ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+
                coalesce( taxa,0),2)/imposto,2)  as freteminimo
                from tbfrete left outer join tbnt#
                on tbfrete.cnpj = tbnt#.cnpj
                where  tbfrete.cnpj = ".$aValores['cnpj'] ." and codtipo = ".$aValores['codtipo']."" ;
            
            $result = $PDOnew->query($sSql1);
            }
            
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
            
        }else
        
        //*leomar*/ - Venda OK
        if($aValores['cnpj']=='2633583000385'){

            if($aRetorno==1){            
            
            $sSql1 = "select seq, ref, ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( (pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+ TAXA2 +
                    coalesce(  nfsvlrtot  *gris,0) ,2) *imposto/100 + ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+ TAXA2 +
                    coalesce(  nfsvlrtot  *gris,0) ,2)  AS totalfrete
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = ".$aValores['cnpj'] ." and codtipo = ".$aValores['codtipo']."" ;            
            $result = $PDOnew->query($sSql1);
            }
            
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
        }
        
        //*bauer*/ - Venda OK
        if($aValores['cnpj']=='4353469003504'){

            if($aRetorno==1){ 
            $sSql1 = "select seq, ref, ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  nfsvlrtot  *gris,0) ,2)*imposto + coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  nfsvlrtot  *gris,0) as totalfrete, 
                    ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  taxa2,0) ,2)*imposto + coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  taxa2,0) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = ".$aValores['cnpj'] ." and codtipo = ".$aValores['codtipo']."" ;            
            $result = $PDOnew->query($sSql1);
            }
            
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
        }
        
        //*TW TRANSPORTES E LOGISTICA */ - Venda
        if($aValores['cnpj']=='89317697001880'){

            if($aRetorno==1){ 
            $sSql1 = "select 'tw'as cliente, ref, seq ,ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota * fretepeso)+taxamin),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as totalfrete, '' as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = ".$aValores['cnpj'] ." and codtipo = ".$aValores['codtipo']."" ;        
            $result = $PDOnew->query($sSql1);
            }
            
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
        }

        //*SNM TRANSPORTES LTDA*/ - Venda falta
        if($aValores['cnpj']=='10618249000119'){
                        
        
            $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH"
                . " BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH "
                    . "select ".$aValores['cnpj']." as cnpj, ".$aValores['nrnotaoc']." as nota, "
                 .$aValores['totalnf']." as nfsvlrtot, ".$aValores['totakg']." as pesoNota, "
                 .$aValores['fracaofrete']." as FracaoFrete,'' as totalfrete, '' as freteminimo, '' as seq into tbnt2#"
                    . " create table tbnt# (
                        seq integer,
                        ref varchar(100),
                        totalfrete money,
                        freteminimo money)";
            
            $aRetorno = $PDOnew->exec($sSqlAux);
            
            if($aRetorno==1){
         
            $sSql3 = "/*26,27,28,29*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref, ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce((pesoNota * fretepeso),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Totalfrete,ROUND(ROUND (coalesce( taxamin ,0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq  in(26,27,28,29)
                    /*30,31*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref, ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Totalfrete,ROUND(ROUND (coalesce( taxamin ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq in(30,31)
                    /*32*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref, ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2),2) as Totalfrete,ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2),2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq in(32)
                    /*33*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref, ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Totalfrete,ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq in(33)" ;
            $aRetorno1 = $PDOnew->exec($sSql3);
            } 
            $sSql1 = "select * from  tbnt#" ;        
            $result = $PDOnew->query($sSql1);
                        
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
        }
        
        //*VENTOLOG*/ - Compra falta
        if($aValores['cnpj']=='10882366000195'){

            $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH "
                    . "BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH "
                    ."select ".$aValores['cnpj']." as cnpj, ".$aValores['nrnotaoc']." as nota, "
                 .$aValores['totalnf']." as nfsvlrtot, ".$aValores['totakg']." as pesoNota, "
                 .$aValores['fracaofrete']." as FracaoFrete,'' as totalfrete, '' as freteminimo into tbnt2#"
                    . " create table tbnt# (
                        seq integer,
                        ref varchar(100),
                        totalfrete money,
                        freteminimo money) ";
            
            $aRetorno = $PDOnew->exec($sSqlAux);
            
            if($aRetorno==1){
                
            $sSql3 = "insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce((pesoNota * fretepeso),0),2)) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 34.50),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 41.40),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2
                    on tbfrete.cnpj = tbnt2.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 48.30),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 55.20),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 69.00),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 109.25),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 125.35),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 138),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 " ;            
            
            $aRetorno1 = $PDOnew->exec($sSql3);
            } 
            $sSql1 = "select * from  tbnt#" ;        
            $result = $PDOnew->query($sSql1);
                        
            $iI=0;
            while($key = $result->fetch($PDOnew::FETCH_ASSOC)){
                $aRow1[$iI]= $key;
                $iI++;
            }
        }
        
        
        return $aRow1;
    }
   
}