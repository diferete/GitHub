<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class PersistenciaMET_ItensManPrev extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbitensmp');
        
        $this->adicionaRelacionamento('filcgc','filcgc',true);
        $this->adicionaRelacionamento('nr','nr', true);
        $this->adicionaRelacionamento('seq','seq', true, true, true);
        $this->adicionaRelacionamento('codmaq','codmaq');
        $this->adicionaRelacionamento('maquina','maquina', false, false, false);
        $this->adicionaRelacionamento('codsit','MET_ServicoMaquina.codsit',false, false, false);
        $this->adicionaRelacionamento('codsit','codsit');
        $this->adicionaRelacionamento('servico','servico',false, false, false);
        $this->adicionaRelacionamento('sitmp','sitmp');
        $this->adicionaRelacionamento('dias','dias');
        $this->adicionaRelacionamento('databert','databert');
        $this->adicionaRelacionamento('userinicial','userinicial');
        $this->adicionaRelacionamento('datafech','datafech');
        $this->adicionaRelacionamento('userfinal','userfinal');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('oqfazer','oqfazer');
        $this->adicionaRelacionamento('fezmanut','fezmanut');
        
        $this->setSTop('500');
        $this->adicionaOrderBy('seq',1);
    
        $this->adicionaJoin('MET_ServicoMaquina');
        
    }   
    
    public function consultaMaqDes($oCodMaq){
        
        $sSql="select maquina"
                . " from metmaq"
                . " where cod = '".$oCodMaq."'";
        $result = $this->getObjetoSql($sSql);
        $oMatDes = $result->fetch(PDO::FETCH_OBJ);

        return $oMatDes;
    }
    
    public function consultaDados($CodSit){
        
        $sSql="select ciclo,resp"
                . " from tbservmp"
                . " where codsit = '".$CodSit."'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
        
    }
    
    public function verificaServico($iCodMaq,$iCodSit) {
        
       $sSql = "select count (codmaq) as total from tbitensmp where codmaq = '".$iCodMaq."' and codsit = '".$iCodSit."' and sitmp = 'ABERTO'";
       $result = $this->getObjetoSql($sSql);
       $oRow = $result->fetch(PDO::FETCH_OBJ);
       return ((int) $oRow->total);
       
    }
    
    /*
     * Pega a data atual e o usuário
     * Cria um novo serviço a partir do existente
     * Finaliza serviço
     * Atualiza os dias em todos os campos
     */
    public function finalizarServico($aDados){
        
        //Adiciona a data e hora do momento
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sUsuário = $_SESSION['nome'];
        
        $sSql = "insert into tbitensmp 
            (filcgc, nr,seq, codmaq, tbitensmp.codsit, sitmp, dias, databert,
            userinicial, datafech, userfinal, oqfazer, fezmanut)
            select  filcgc, nr,
            (select max(seq) as maximo from tbitensmp where nr = '".$aDados['nr']."' and filcgc = '".$aDados['filcgc']."' and sitmp = 'ABERTO')+1,
            codmaq, tbitensmp.codsit, sitmp, ciclo, GETDATE(), userinicial, datafech, userfinal, oqfazer, 'SIM'
            from tbitensmp left outer join  tbservmp on tbservmp.codsit = tbitensmp.codsit 
            where seq = '".$aDados['seq']."' and nr = '".$aDados['nr']."' and filcgc = '".$aDados['filcgc']."'  
            update tbitensmp set sitmp = 'FINALIZADO', datafech = '".$sData."', userfinal = '".$sUsuário."'  "
            . "where seq = '".$aDados['seq']."' and nr = '".$aDados['nr']."' and filcgc = '".$aDados['filcgc']."'  
            update tbitensmp set dias = ciclo - DATEDIFF(DAY, databert, GETDATE()) from tbitensmp
            left outer join  tbservmp on tbservmp.codsit = tbitensmp.codsit 
            where databert<>GETDATE() AND sitmp<>'FINALIZADO'";
        
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
    }
    
    /**
     * Método que atualiza campos da tabela na hora da consulta
     */
    public function atualizaDataAntesdaConsulta(){
        
        $sSql = "update tbitensmp set dias = ciclo - DATEDIFF(DAY, databert, GETDATE()) from tbitensmp
            left outer join  tbservmp on tbservmp.codsit = tbitensmp.codsit 
            where databert<>GETDATE() AND sitmp<>'FINALIZADO'";
        
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
    }
    
    public function verificaCampoValido($iCodSit, $sDesc){
        
        $sSql = "select servico from tbservmp where codsit = '".$iCodSit."' ";       
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_ASSOC);
        $sServico = $oRow['servico'];
        if(strcasecmp($sServico,$sDesc)==0){
            return true;
        } else{
            return false;
        }
        
    }
    
    public function buscaDescricao($sSeq, $sNr){
        $sSql = "select servico from tbservmp where codsit = (select codsit from tbitensmp where nr = '".$sNr."' and seq = '".$sSeq."')";       
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_ASSOC);
        $sServico = $oRow['servico'];
        return $sServico;
    }
    
    public function buscaOqueFazer($sSeq, $sNr){
        $sSql = "select oqfazer from tbitensmp where nr = '".$sNr."' and seq = '".$sSeq."'";       
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_ASSOC);
        $sOqueFazer = $oRow['oqfazer'];
        return $sOqueFazer;
    }
    
}
