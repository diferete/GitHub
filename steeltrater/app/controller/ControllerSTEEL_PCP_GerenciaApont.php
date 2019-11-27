<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 06/08/2018
 */


class ControllerSTEEL_PCP_GerenciaApont extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GerenciaApont');
    }

    public function afterUpdate() {
        parent::afterUpdate();
             
        $oSituacao= $this->Model->getSituacao();
        $oDatasaida= $this->Model->getDatasaida_forno();
        $oHoraSaida= $this->Model->getHorasaida_forno();
        $oUsuarioSaida = $this->Model->getUsernomesaida();
        $oCodUsuarioSaida = $this->Model->getCodusersaida();
        
        if (($oSituacao=='Finalizado')&(($oDatasaida=='')||($oHoraSaida=='')||($oUsuarioSaida=='')||($oCodUsuarioSaida==''))){
         $oMensagem = new Modal('Atenção!','Os campos Usuário de saída, Data de saída e Hora de saída obrigatórios para inserir Apontamentos finalizados!',2, false, true, false);
         echo $oMensagem->getRender();
         
        $aRetorno[0]=false;
        $aRetorno[1]='false';
        return $aRetorno;
        }
        
        $oOrdensProd = Fabrica::FabricarController('STEEL_PCP_ordensFab');
        $oOrdensProd->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $oOrdensResult = $oOrdensProd->Persistencia->consultarWhere();
        if($oOrdensResult->getSituacao()!=='Retornado'){
            $oOrdensProd->changeSit($this->Model->getOp(), $this->Model->getSituacao()); 
        }
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function afterInsert() {
        parent::afterInsert();
        
        $oOrdensProd = Fabrica::FabricarController('STEEL_PCP_ordensFab');        
        $oOrdensProd->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $oOrdensResult = $oOrdensProd->Persistencia->consultarWhere();
        if($oOrdensResult->getSituacao()!=='Retornado'){
            $oOrdensProd->changeSit($this->Model->getOp(), $this->Model->getSituacao());
        }
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        
    }
    
    public function afterDelete() {
        parent::afterDelete();
        
        $oOrdensProd = Fabrica::FabricarController('STEEL_PCP_ordensFab');        
        $oOrdensProd->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $oOrdensResult = $oOrdensProd->Persistencia->consultarWhere();
        if($oOrdensResult->getSituacao()!=='Retornado'){
            $oOrdensProd->changeSit($this->Model->getOp(), 'Aberta');
        }
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
               
        $oSituacao=$this->Model->getSituacao();
        $oDatasaida=$this->Model->getDatasaida_forno();
        $oHoraSaida=$this->Model->getHorasaida_forno();
        
        $oOrdensProd = Fabrica::FabricarController('STEEL_PCP_ordensFab');
        $oOrdensProd->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $oOrdensResult = $oOrdensProd->Persistencia->consultarWhere();
        
        if($oOrdensResult->getSituacao()!=='Retornado'){
            $oOrdensProd->changeSit($this->Model->getOp(),$this->Model->getSituacao());
        }
        if (($oSituacao=='Finalizado')&(($oDatasaida=='')||($oHoraSaida=''))){
         $oMensagem = new Modal('Atenção!','Os campos Data de saída e Hora de saída obrigatórios para inserir Apontamentos finalizados!',2, false, true, false);
         echo $oMensagem->getRender();
         
        $aRetorno[0]=false;
        $aRetorno[1]='false';
        return $aRetorno;
        } else{        
            
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        }       
       
    }
    
}