<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class PersistenciaSTEEL_PCP_Certificado extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_CERTIFICADO');

        $this->adicionaRelacionamento('nrcert', 'nrcert', true, true, true);
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('notasteel', 'notasteel');
        $this->adicionaRelacionamento('notacliente', 'notacliente');
        $this->adicionaRelacionamento('opcliente', 'opcliente');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('dataensaio', 'dataensaio');
        $this->adicionaRelacionamento('dataemissao', 'dataemissao');
        $this->adicionaRelacionamento('peso', 'peso');
        $this->adicionaRelacionamento('quant', 'quant');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('hora', 'hora');
        
        $this->adicionaRelacionamento('durezaSuperfMin', 'durezaSuperfMin');
        $this->adicionaRelacionamento('durezaSuperfMax', 'durezaSuperfMax');
        $this->adicionaRelacionamento('SuperEscala', 'SuperEscala');
        
        $this->adicionaRelacionamento('durezaNucMin', 'durezaNucMin');
        $this->adicionaRelacionamento('durezaNucMax', 'durezaNucMax');
        $this->adicionaRelacionamento('NucEscala', 'NucEscala');
        
        $this->adicionaRelacionamento('expCamadaMin', 'expCamadaMin');
        $this->adicionaRelacionamento('expCamadaMax', 'expCamadaMax');
        
        $this->adicionaRelacionamento('inspeneg','inspeneg');
        
        $this->adicionaRelacionamento('sitEmail', 'sitEmail');
        
        $this->adicionaRelacionamento('conclusao', 'conclusao');
        
        $this->adicionaRelacionamento('fioDurezaSol', 'fioDurezaSol');
        $this->adicionaRelacionamento('fioEsferio', 'fioEsferio');
        $this->adicionaRelacionamento('fioDescarbonetaTotal', 'fioDescarbonetaTotal');
        $this->adicionaRelacionamento('fioDescarbonetaParcial', 'fioDescarbonetaParcial');
        $this->adicionaRelacionamento('DiamFinalMin', 'DiamFinalMin');
        $this->adicionaRelacionamento('DiamFinalMax', 'DiamFinalMax');
        $this->adicionaRelacionamento('dataNotaRetorno', 'dataNotaRetorno');
        
        
        $this->setSTop('200');
        $this->adicionaOrderBy('nrcert', 1);
    }
    
    /**
     * Muda a situação do envio do e-mail
     */
    
    public function mudaSit($aCert){
        foreach ($aCert as $key => $iCert) {
            $sSql="update steel_pcp_certificado set sitEmail='Env' where nrcert='".$iCert."'   ";
            $this->executaSql($sSql);
        }
    }

    /**
     * Atualiza o certificado referente a sua nota fiscal
     */
    public function atualizaNotaCertificado(){
        //limpa notas canceladas
        $this->limpaCancelada();
        
        $sSql = "select * from steel_pcp_certificado where notasteel is null or notasteel = 0";
        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            //busca a carga
            $sCarga = $this->buscaCarga($oRowBD->op);
            //busca ordem de produção
            $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOp->Persistencia->adicionaFiltro('op',$oRowBD->op);
            $oOpDados = $oOp->Persistencia->consultarWhere();
            //busca sequencia do item na carta
            $sSeqCarga = $this->buscaSeqCarga($sCarga,$oRowBD->op);
            //busca a nota fiscal
            $aNota =$this->buscaNota($sCarga,$oOpDados->getProdFinal(),$sSeqCarga);
            //gera update 
            $this->updateNotaCert($oRowBD->nrcert,$aNota);
           }
       }
    /**
     * Busca nota fiscal
     * @param type $sNrCarga
     */
    public function buscaNota($sNrCarga,$sProcod,$sSeqCarga){
       $sSql = "select NFS_NotaFiscalNumero,NFS_NotaFiscalDataEmissao 
                from nfs_notafiscalitem left outer join NFS_NOTAFISCAL
                on nfs_notafiscalitem.NFS_NotaFiscalFilial = NFS_NOTAFISCAL.NFS_NotaFiscalFilial
                and nfs_notafiscalitem.NFS_NotaFiscalSeq = NFS_NOTAFISCAL.NFS_NotaFiscalSeq
                where nfs_notafiscalitempedidocodigo = '".$sNrCarga."' and nfs_notafiscalcancelada = 'N'
                and nfs_notafiscalitem.NFS_NotaFiscalFilial ='8993358000174'
                and nfs_notafiscalitemproduto = '".$sProcod."'
                and NFS_NotaFiscalItemPedidoItemSe ='".$sSeqCarga."'
                and NFS_NotaFiscalSituacao <>'X'
                group by NFS_NotaFiscalNumero,NFS_NotaFiscalDataEmissao  "; 
       
       $result = $this->getObjetoSql($sSql);
       
       $oRowNota = $result->fetch(PDO::FETCH_OBJ);
       
       $aNota['nr'] = $oRowNota->nfs_notafiscalnumero;
       $aNota['data'] = $oRowNota->nfs_notafiscaldataemissao;
       //$iNota = $oRowNota->nfs_notafiscalnumero;
           
       return $aNota; 
       
    }
    
    /**
     * Atualiza nota fiscal
     */
    public function updateNotaCert($iNrCert,$aNota){
        $sSql = "update steel_pcp_certificado set notasteel ='".$aNota['nr']."',dataNotaRetorno ='".$aNota['data']."' where nrcert ='".$iNrCert."'";
        $this->executaSql($sSql);
        
    }
    /**
     * Busca carga
     */
    public function buscaCarga($sOp){
        $sSql = "select nrcarga from steel_pcp_ordensfab where op ='".$sOp."'";
        $result = $this->getObjetoSql($sSql);
        
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        
        return $oRow->nrcarga;
    }
    
    /**
     * busca seq na carca
     */
    public function buscaSeqCarga($sCarga,$sOp){
        $sSql = "select pdv_pedidoitemseq from STEEL_PCP_CargaInsumoServ 
                where op ='".$sOp."'
                and pdv_pedidocodigo ='".$sCarga."'
                and pdv_insserv ='RETORNO' ";
        $result = $this->getObjetoSql($sSql);
        
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        
        return $oRow->pdv_pedidoitemseq;
    }
    
    public function limpaCancelada(){
        $sSql = "select * from NFS_NOTAFISCAL where nfs_notafiscalcancelada = 'S' and NFS_NotaFiscalFilial ='8993358000174' ";
        $result = $this->getObjetoSql($sSql);
        while ($oRow = $result->fetch(PDO::FETCH_OBJ)){
            $sSqlExec ="update STEEL_PCP_certificado set notasteel = 0 where notasteel = '".$oRow->nfs_notafiscalnumero."' ";
            $this->executaSql($sSqlExec);
        }
    }
}
