<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ControllerMET_Gerenciamento extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('MET_Gerenciamento');
        $this->setControllerDetalhe('MET_ItensManPrev');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    //NOVO ----------------------------------------------------------------------------------
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        $this->Persistencia->adicionaFiltro('codmaq', $this->Model->getCodmaq());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        $aRetorno[2] = $this->Model->getCodmaq();
        return $aRetorno;
    }
    //-----------------------------------------------------------------------------------------
    
    function beforeInsert() {
        parent::beforeInsert();
        
        $iCodMaq = $this->Model->getCodmaq();
        
        $oCodSetor = $this->Persistencia->consultaCodSetor($iCodMaq);
        
        $this->Model->setCodsetor($oCodSetor->codsetor);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
     
    }
    
    function beforeUpdate() {
        parent::beforeUpdate();
                
        $iCodMaq = $this->Model->getCodmaq();
        
        $oCodSetor = $this->Persistencia->consultaCodSetor($iCodMaq);
        
        $this->Model->setCodsetor($oCodSetor->codsetor);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
     
    }
    
}
