<?php 
 /*
 * Implementa a classe persistencia MET_MANUT_OS
 * @author Cleverton Hoffmann
 * @since 21/07/2021
 */
 
class PersistenciaMET_MANUT_OS extends Persistencia {
 
    public function __construct() {
        parent::__construct();
 
        $this->setTabela('MET_MANUT_OS');
        $this->adicionaRelacionamento('fil_codigo','fil_codigo', true, true);
        $this->adicionaRelacionamento('fil_codigo','DELX_FIL_Empresa.fil_codigo', false, false, false);
        $this->adicionaRelacionamento('nr','nr', true, true, true);
        $this->adicionaRelacionamento('cod','cod');
        $this->adicionaRelacionamento('cod','MET_CAD_Maquinas.codigoMaq', false, false, false);        
        $this->adicionaRelacionamento('usuariocad','usuariocad');
        $this->adicionaRelacionamento('usuariocad','MET_TEC_USUARIO.usucodigo', false, false, false);
        $this->adicionaRelacionamento('datacad','datacad');
        $this->adicionaRelacionamento('codserv','codserv');
        $this->adicionaRelacionamento('horacad','horacad');
        $this->adicionaRelacionamento('userenc','userenc');
        $this->adicionaRelacionamento('consumo','consumo');
        $this->adicionaRelacionamento('problema','problema');
        $this->adicionaRelacionamento('solucao','solucao');
        $this->adicionaRelacionamento('previsao','previsao');
        $this->adicionaRelacionamento('responsavel','responsavel');
        $this->adicionaRelacionamento('dataenc','dataenc');
        $this->adicionaRelacionamento('horaenc','horaenc');
        $this->adicionaRelacionamento('tipomanut','tipomanut');
        $this->adicionaRelacionamento('dias','dias');
        $this->adicionaRelacionamento('codsetor','codsetor');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('situacao','situacao');
        $this->adicionaRelacionamento('oqfazer','oqfazer');
        $this->adicionaRelacionamento('fezmanut','fezmanut');
        $this->adicionaRelacionamento('matnecessario','matnecessario');
        
        $sAnd = ' and MET_MANUT_OS.fil_codigo = MET_CAD_Maquinas.fil_codigo ';
        $this->adicionaJoin('MET_CAD_Maquinas', null, 1, 'cod', 'codigoMaq', $sAnd);
        $this->adicionaJoin('DELX_FIL_Empresa');
        $this->adicionaJoin('MET_TEC_USUARIO', null, 1, 'usuariocad', 'usucodigo');
        
        $this->adicionaOrderBy('nr',1);
        $this->setSTop('50');
    } 
    
    public function apontaInicio($aDados){
        
        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Iniciada', "
                ."userinic ='".$iCodUser."', "
                ."datainic ='".Util::getDataAtual()."', "
                ."horainic ='".date('H:i')."'  where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
     public function apontaAberta($aDados){
         
        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Aberta', "
                ."userretor ='".$iCodUser."', "
                ."dataretor ='".Util::getDataAtual()."', "
                ."horaretor ='".date('H:i')."'  where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
    public function apontaIniciada($aDados){
        
        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Iniciada', "
                ."userretor ='".$iCodUser."', "
                ."dataretor ='".Util::getDataAtual()."', "
                ."horaretor ='".date('H:i')."'  where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
     public function cancela($aDados){
        
        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Cancelada', "
                ."usercanc ='".$iCodUser."', "
                ."datacanc ='".Util::getDataAtual()."', "
                ."horacanc ='".date('H:i')."'  where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
    public function enc($aDados){
        
        $iCodUser = $_SESSION['codUser'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update MET_MANUT_OS set situacao = 'Encerrada', "
                ."userenc ='".$iCodUser."', "
                ."dataenc ='".Util::getDataAtual()."', "
                ."horaenc ='".date('H:i')."'  where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
    /**
     * Método que atualiza campos da tabela na hora da consulta
     */
    public function atualizaDataAntesdaConsulta(){
        
        $sSql = "update MET_MANUT_OS set dias = DATEDIFF(DAY, GETDATE(), previsao)
            where situacao <> 'Encerrada' and situacao <> 'Cancelada'";
        
        $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
        
    }
    
    public function buscaDadosCrachaMan($sCracha) {
        $sSql = "select usucodigo,usunome from MET_TEC_Usuario where usucracha = " . $sCracha . "";
        $oObjCracha = $this->consultaSql($sSql);
        return $oObjCracha;
    }
    
}