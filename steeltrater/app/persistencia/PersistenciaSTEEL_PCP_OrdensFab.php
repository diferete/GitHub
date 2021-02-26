<?php

/* 
 * Implementa producao steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class PersistenciaSTEEL_PCP_OrdensFab extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFab');
      
        $this->adicionaRelacionamento('op','op',true,true,true);
        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo');
        $this->adicionaRelacionamento('emp_razaosocial', 'emp_razaosocial');
        $this->adicionaRelacionamento('origem','origem');
        $this->adicionaRelacionamento('documento','documento');
        $this->adicionaRelacionamento('prod','prod');
        $this->adicionaRelacionamento('prodes','prodes');
        
        $this->adicionaRelacionamento('matcod','matcod');
        $this->adicionaRelacionamento('matdes','matdes');
        
        $this->adicionaRelacionamento('receita','receita');
        $this->adicionaRelacionamento('receita_des','receita_des');
        $this->adicionaRelacionamento('quant','quant');
        $this->adicionaRelacionamento('peso','peso');
        $this->adicionaRelacionamento('opcliente','opcliente');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('usuario','usuario');
        $this->adicionaRelacionamento('seqprodnf','seqprodnf');
        $this->adicionaRelacionamento('dataprev','dataprev');
        
        $this->adicionaRelacionamento('situacao', 'situacao');
        $this->adicionaRelacionamento('temprev', 'temprev');
       
        $this->adicionaRelacionamento('seqmat', 'seqmat');
        
        $this->adicionaRelacionamento('retrabalho', 'retrabalho');
        $this->adicionaRelacionamento('op_retrabalho', 'op_retrabalho');
        
        $this->adicionaRelacionamento('durezaNucMin', 'durezaNucMin');
        $this->adicionaRelacionamento('durezaNucMax', 'durezaNucMax');
        $this->adicionaRelacionamento('NucEscala', 'NucEscala');
        $this->adicionaRelacionamento('durezaSuperfMin', 'durezaSuperfMin');
        $this->adicionaRelacionamento('durezaSuperfMax', 'durezaSuperfMax');
        $this->adicionaRelacionamento('superEscala', 'superEscala');
        $this->adicionaRelacionamento('expCamadaMin', 'expCamadaMin');
        $this->adicionaRelacionamento('expCamadaMax', 'expCamadaMax');
        $this->adicionaRelacionamento('tratrevencomp', 'tratrevencomp');
        $this->adicionaRelacionamento('tipoOrdem','tipoOrdem');
        
        $this->adicionaRelacionamento('fioDurezaSol','fioDurezaSol');
        $this->adicionaRelacionamento('fioEsferio','fioEsferio');
        $this->adicionaRelacionamento('fioDescarbonetaTotal','fioDescarbonetaTotal');
        $this->adicionaRelacionamento('fioDescarbonetaParcial','fioDescarbonetaParcial');
        $this->adicionaRelacionamento('DiamFinalMin','DiamFinalMin');
        $this->adicionaRelacionamento('DiamFinalMax','DiamFinalMax');
        
        $this->adicionaRelacionamento('prodFinal', 'prodFinal');
        $this->adicionaRelacionamento('prodesFinal', 'prodesFinal');
        
        $this->adicionaRelacionamento('vlrNfEnt', 'vlrNfEnt');
        $this->adicionaRelacionamento('vlrNfEntUnit','vlrNfEntUnit');
        $this->adicionaRelacionamento('nrCarga','nrCarga');
        
        $this->adicionaRelacionamento('referencia','referencia');
        
        $this->adicionaRelacionamento('xPed','xPed');
        $this->adicionaRelacionamento('nItemPed','nItemPed');
        
        $this->adicionaRelacionamento('nrcert','nrcert');
        
        $this->adicionaRelacionamento('pendencias','pendencias');
        $this->adicionaRelacionamento('pendenciasobs','pendenciasobs');
        
        $this->adicionaRelacionamento('rnc','rnc');
        $this->adicionaRelacionamento('opantes','opantes');
        
        $this->adicionaRelacionamento('dataemidoc', 'dataemidoc');
        $this->adicionaRelacionamento('serie_nf', 'serie_nf');
        
        $this->adicionaRelacionamento('nfsnfechv','nfsnfechv');
        
        //pesagem
        $this->adicionaRelacionamento('pesoBal','pesoBal');
        $this->adicionaRelacionamento('pesoCaixa','pesoCaixa');
        $this->adicionaRelacionamento('pesoDif', 'pesoDif');
        $this->adicionaRelacionamento('dataPesagem', 'dataPesagem');
        $this->adicionaRelacionamento('horaPesagem', 'horaPesagem');
        $this->adicionaRelacionamento('userPesagem', 'userPesagem');
        
        $this->adicionaRelacionamento('nItemPedServico','nItemPedServico');
        $this->adicionaRelacionamento('nItemPedInsumo','nItemPedInsumo');
        $this->adicionaRelacionamento('nItemPedEnergia','nItemPedEnergia');
        
        $this->adicionaRelacionamento('receita_zinc','receita_zinc');
        $this->adicionaRelacionamento('receita_zincdesc','receita_zincdesc');
        $this->adicionaRelacionamento('processozinc','processozinc');
        
        $this->adicionaOrderBy('op',1);
        $this->setSTop('100');
        
    
        
    }
    
    /**
     * Cancela a ordem de produção
     * 
     * @param type $aOp número da op
     */
    public function CancelarOp($aOp){
        
        date_default_timezone_set('America/Sao_Paulo');
        $data      = date("d/m/y");                     //função para pegar a data e hora local
        $hora      = date("H:i");   
        $useRel=$_SESSION['nome'];
        $sSql="update STEEL_PCP_OrdensFab set situacao='Cancelada', usercanc='".$useRel."',datacanc='".$data."', horacanc='".$hora."' where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
     /**
     * Altera ordem de produção para aberta
     * 
     * @param type $aOp número da op
     */
    public function AbertaOp($aOp){
        
        $sSql="update STEEL_PCP_OrdensFab set situacao='Aberta',usercanc=NULL,datacanc=NULL, horacanc=NULL where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
    
    public function alteraSit($iOp,$sSit){
        
        $sSql="update STEEL_PCP_OrdensFab set situacao='".$sSit."' where op='".$iOp."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
    /**
     * Grava número da carga na op
     */
    
    public function nrCarga($sOp,$sNrCarga){
         $sSql="update STEEL_PCP_OrdensFab set situacao='Retornado' where op='".$sOp."'   ";
         $this->executaSql($sSql);
         
         $sSql="update STEEL_PCP_OrdensFab set nrCarga='".$sNrCarga."' where op='".$sOp."'   ";
         $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
     /**
     * Limpa carga na op
     */
    
    public function limpaCarga($sOp){
        $sSql="update STEEL_PCP_OrdensFab set situacao='Finalizado' where op='".$sOp."'   ";
         $this->executaSql($sSql);
         
         $sSql="update STEEL_PCP_OrdensFab set nrCarga='Sem Carga' where op='".$sOp."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    

    /**
     * Coloca a ordem de produção em retrabalho ///////////////TERMINAR O SELECT
     * 
     * @param type $aOp número da op
     */
    public function RetrabalhoOp($aOp){
        
        $sSql="update STEEL_PCP_OrdensFab set situacao='Aberta',usercanc=NULL,datacanc=NULL, horacanc=NULL where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
    /**
     * busca preço da nota fiscal
     */
    
    public function buscaPreço($aCamposChave){
       $sql = "select nfsitvlrun,nfsitvlrto "
              ."  from rex_maquinas.widl.NFC003 "
              ."  where nfsfilcgc ='75483040000211' "
              ."  and nfsnfser = '2' "
              ."  and nfsnfnro = '".$aCamposChave['nfsnfnro']."' "
              ."  and nfsitcod = '".$aCamposChave['nfsitcod']."'"
              ."  and nfsitqtd = '".$aCamposChave['qtParam']."'";//< novo parametro
        
        $result = $this->getObjetoSql($sql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        
        $aRetorno = array();
        $aRetorno[0] = $row->nfsitvlrun;
        $aRetorno[1] = $row->nfsitvlrto; 
        return $aRetorno;
        
    }
   
    public function gravaPendencia($sOp,$sAtencao,$sPendencia){
         $sSql="update STEEL_PCP_OrdensFab set pendencias='".$sAtencao."',pendenciasobs='".$sPendencia."' where op='$sOp'   ";
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
    }
    
    public function buscaMovimento(){
          
        $sql = "select * from NFS_TIPOMOVIMENTO where NFS_TipoMovimentoCodigo>=300 order by NFS_TipoMovimentoCodigo desc";
        $result = $this->getObjetoSql($sql);
        $aRetorno = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $aRetorno[$row['nfs_tipomovimentocodigo']] = $row['nfs_tipomovimentodescricao'];
        }
        return $aRetorno;
        
    }
    
    /**
     * Muda a situação para origem retrabalho
     */
    public function origemRetrabalho($sOp){
        $sSql = "update STEEL_PCP_OrdensFab set retrabalho='OP origem retrabalho' where op='$sOp' ";
        $aRetorno = $this->executaSql($sSql);
    }
    
    public function getChaveNfeMetalbo($sNf,$sNfSer){
        $sSql = "select nfsnfechv from rex_maquinas.widl.NFC001(nolock) where nfsnfnro ='".$sNf."' and nfsnfser ='".$sNfSer."'";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->nfsnfechv;
    }
    
    public function getChaveNfeXml($sNf,$sNfSer){
        $sSql = "select distinct(nfsnfechv) from STEEL_PCP_ImportaXml where nfnro ='".$sNf."' and nfser ='".$sNfSer."'";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        return $row->nfsnfechv;
    }
    
    public function pesoBalancaoOp($aDados){
        $sHora = date('H:i');
        $sSql = "update STEEL_PCP_OrdensFab set pesoBal='".$aDados['pesobal']."', "
                . "pesoCaixa='".$aDados['pesocaixa']."', pesoDif='".$aDados['pesodif']."', "
                . "dataPesagem='".$aDados['dataPesagem']."', horaPesagem='".$sHora."',"
                . "userPesagem='".$aDados['userPesagem']."' where op ='".$aDados['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }
    
    public function buscaTratamento(){
        
        $sql = "select * from STEEL_PCP_tratamentos";
        $result = $this->getObjetoSql($sql);
        $aRetorno = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $aRetorno[$row['tratcod']] = $row['tratdes'];
        }
        return $aRetorno;
        
    }
    
}