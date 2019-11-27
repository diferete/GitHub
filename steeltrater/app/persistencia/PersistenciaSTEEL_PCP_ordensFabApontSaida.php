<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_ordensFabApontSaida
 * 
 * @author Cleverton Hoffmann
 * @since 25/07/2018
 */

class PersistenciaSTEEL_PCP_ordensFabApontSaida extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFabApont');

        $this->adicionaRelacionamento('op', 'op', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true,true);
        $this->adicionaRelacionamento('fornocod', 'fornocod');
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('dataent_forno', 'dataent_forno');
        $this->adicionaRelacionamento('horaent_forno', 'horaent_forno');
        $this->adicionaRelacionamento('datasaida_forno', 'datasaida_forno');
        $this->adicionaRelacionamento('horasaida_forno', 'horasaida_forno');
        $this->adicionaRelacionamento('situacao','situacao');
        

        $this->setSTop('500');
        $this->adicionaOrderBy('seq', 1);
    }
    
    public function finalizarOP($aOp){
        //Adiciona a data e hora do momento
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');
        $user = $_SESSION['codUser'];
        $nomeuser = $_SESSION['nome'];
        //busca ultimo turno
        $sTurnoFinal = $this->retornaUltimoTurno($aOp['op']);
        
        
        $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();

        //Realiza a inserçao da data e da hora na tabela
        $sSql="update STEEL_PCP_OrdensFabApont set situacao='Finalizado', datasaida_forno='".$sData."',horasaida_forno='".$sHora."',codusersaida='".$user."',usernomesaida='".$nomeuser."', turnoSteelSaida ='".$sTurnoFinal."' where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        $sSql="update STEEL_PCP_ordensFab set situacao = 'Finalizado' where op ='".$aOp['op']."' and situacao <>'Retornado' ";
        $this->executaSql($sSql);
        
        //baixa da lista 
        $sSql="update STEEL_PCP_ordensFabLista set situacao='Finalizado' where op='".$aOp['op']."'";
        $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    
    public function finalizarOPTurno($aOp){
        //Adiciona a data e hora do momento
        date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');
        $user = $_SESSION['codUser'];
        $nomeuser = $_SESSION['nome'];
        
        //Realiza a inserçao da data e da hora na tabela
        $sSql="update STEEL_PCP_OrdensFabApont set situacao='Finalizado', datasaida_forno='".$sData."',horasaida_forno='".$sHora."',codusersaida='".$user."',usernomesaida='".$nomeuser."', turnoSteelSaida ='".$aOp['turnoSteel']."' where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        $sSql="update STEEL_PCP_ordensFab set situacao = 'Finalizado' where op ='".$aOp['op']."' and situacao <>'Retornado' ";
        $this->executaSql($sSql);
        
        //baixa da lista 
        $sSql="update STEEL_PCP_ordensFabLista set situacao='Finalizado' where op='".$aOp['op']."'";
        $this->executaSql($sSql);
        
        return $aRetorno;
        
        
    }
    /*
     * Retorna a OP finalizada para processo
     */
    public function retornarOp($aOp){
      
        $sSql="update STEEL_PCP_OrdensFabApont set situacao='Processo', "
                . "datasaida_forno=NULL, horasaida_forno=NULL,"
                . "turnoSteelSaida=NULL, codusersaida=NULL, usernomesaida=NULL where op='".$aOp['op']."'   ";
        $aRetorno = $this->executaSql($sSql);
        
        $sSql="update STEEL_PCP_ordensFab set situacao = 'Processo' where op ='".$aOp['op']."' ";
        $this->executaSql($sSql);
        
        //retorna lista 
         $sSql="update STEEL_PCP_ordensFabLista set situacao='Processo' where op='".$aOp['op']."'";
        $this->executaSql($sSql);
        
        return $aRetorno;
        
    }
    
     /**
     * Retorna turno do último lançamento
     */
    public function retornaUltimoTurno($sOp){
        $sSql ="select turnoSteelSaida from STEEL_PCP_ordensFabItens 
                where op in ('".$sOp."') 
                and opseq = (select MAX(opseq) 
                from STEEL_PCP_ordensFabItens where op in ('".$sOp."'))";
        $result = $this->getObjetoSql($sSql);
        $oRowDB =$result->fetch(PDO::FETCH_OBJ);
        return $oRowDB->turnosteelsaida;
        
    }
    
}
