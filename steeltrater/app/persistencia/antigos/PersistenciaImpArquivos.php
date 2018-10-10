<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaImpArquivos extends Persistencia{
    public function __construct() {
        parent::__construct();
    }
    
    public function buscaPreco($sDados){
        //Parafuso#$
        //Parafuso$
        //Porca#$
        //Porca$
        //Barra#$
        //Arruela#$
        $sSql = "select procod,round(preco,2) as preco from Parafuso$ order by procod ";
        
        $result = $this->getObjetoSql($sSql);
        
         
      
        while($oRow = $result->fetch(PDO::FETCH_OBJ)){
            $sCodigo = $oRow->procod;
            $sPreco = $oRow->preco;//round($oRow->preco, 2);  // 1.96 $oRow->preco;
            $iNr = 9;//possível de tratamentos
            $iStart = 1;
            while ($iStart <= $iNr){
                $sCodigoTrat = substr_replace($sCodigo, $iStart , 3, 1);//string, subs, posicao, 1 do inicio -1 do final
                //vai verificar se há cadastro
               // if($this->verifCadastro($sCodigoTrat)=='s'){
                    //vai gerar update na tabela auxiliar
                    $this->mudaPreco($sCodigoTrat, $sPreco); 
              //  }
                $iStart++;
            }
            
        }
       }
       
        //funcao que verifica se há cadastro
        public function verifCadastro($sProcod){
            $sSql = "select COUNT(*) as cont from widl.prod01 where procod =".$sProcod." and probloqpro <> 'S'";
            $result = $this->getObjetoSql($sSql);
            $oRow = $result->fetch(PDO::FETCH_OBJ);
            if($oRow->cont > 0){
                return 's';
            }else{
                return 'n';
            }
        }
        //monta o update na tabela atualizada
        public function mudaPreco($sProcod,$Preco){
            $sSql = "update pdftabvendas_atualizado set preco =".$Preco.", revisao ='Rev.15' where codigo =".$sProcod;
            $aRetorno = $this->executaSql($sSql);
            if ($aRetorno[0]==false){
                exit();   
            }
            return $aRetorno[0];
        }
        
        
        //insere novos preços da tabela
        public function insertPreco($sDados){
        //Parafuso#$
        //Parafuso$
        //Porca#$
        //Porca$
        //Barra#$
        //Arruela#$
        $sSql = "select procod,round(preco,2) as preco from Porca#$ order by procod ";
        
        $result = $this->getObjetoSql($sSql);
        
         
      
        while($oRow = $result->fetch(PDO::FETCH_OBJ)){
            $sCodigo = $oRow->procod;
           // $sCodigo = substr($sCodigo, 0, -2);
            $sPreco = $oRow->preco;//round($oRow->preco, 2);  // 1.96 $oRow->preco;
            $iNr = 9;//possível de tratamentos
            $iStart = 1;
            while ($iStart <= $iNr){
                $sCodigoTrat = substr_replace($sCodigo, $iStart , 3, 1);//string, subs, posicao, 1 do inicio -1 do final
                //vai verificar se há cadastro
                $this->geraPreco($sCodigoTrat, $sPreco);
             /*   if($this->verifCadPreco($sCodigoTrat)=='s'){
                    //vai gerar update na tabela auxiliar
                    $this->geraPreco($sCodigoTrat, $sPreco); 
                }*/
                $iStart++;
            }
            
        }
       }
       
       //verifica se o item já está na tabela
       public function verifCadPreco($sCodigo){
            $sSql = "select COUNT(*) as cont from pdftabvendas where codigo ='".$sCodigo."' ";
            $result = $this->getObjetoSql($sSql);
            $oRow = $result->fetch(PDO::FETCH_OBJ);
            if($oRow->cont > 0){
                return 'n';
            }else{
                return 'n';
            }
       }
       
       public function geraPreco($sCodigoTrat, $sPreco){
           $sSql = "insert into pdfCodXls values('".$sCodigoTrat."','".$sPreco."')";
           $aRetorno = $this->executaSql($sSql);
       }
            
}