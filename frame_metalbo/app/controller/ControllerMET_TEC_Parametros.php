<?php

/* 
 * Class controla parametros do sistema
 * 
 * @author Avanei Martendal
 * 
 * @since 25/08/2017
 */

class ControllerMET_TEC_Parametros extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Parametros');
    }
    
    /**
     * Verifica parameto se o representante pode ver empenho ou não
     */
    
    public function getBempenho(){
        $bRet = $this->Persistencia->liberaEmpenho();
        return $bRet;
    }
}

