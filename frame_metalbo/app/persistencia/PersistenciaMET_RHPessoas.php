<?php

/*
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 16/03/2020
 */

class PersistenciaMET_RHPessoas extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbrhpessoas');
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('numcad', 'numcad');
        $this->adicionaRelacionamento('datadm', 'datadm');
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('sit', 'sit');
        $this->adicionaRelacionamento('funcao', 'funcao');
        $this->adicionaRelacionamento('escala', 'escala');
        $this->adicionaRelacionamento('setor', 'setor');
        $this->adicionaRelacionamento('contexp', 'contexp');
        $this->adicionaRelacionamento('salini', 'salini');
        $this->adicionaRelacionamento('cursos', 'cursos');
        $this->adicionaRelacionamento('banco', 'banco');
        $this->adicionaRelacionamento('agb', 'agb');
        $this->adicionaRelacionamento('contac', 'contac');
        $this->adicionaRelacionamento('anexo', 'anexo');
                
        $this->setSTop(50);
        $this->adicionaOrderBy('seq',1);
    }
    
    public function buscaSetor(){
        
        $sSql = "select Str (codccu)+ '- '+nomccu as setor from vetorh..r018ccu order by setor";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
    public function buscaEscala(){
        
        $sSql = "select Str (codesc)+ '- '+nomesc as escala from vetorh..r006esc order by codesc";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
    public function buscaFuncao(){
        
        $sSql = "select Str (codcar)+ '- '+titcar as funcao from vetorh..r024car order by funcao";       
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI]= $key;
            $iI++;
        }
        return $aRow;
    }
    
     public function finalizarFicha($aDados){
        
        $sSql = "update tbrhpessoas set sit = 'FINALIZADO' where seq =" .$aDados['seq']."";
        
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
    }   
    
    
}