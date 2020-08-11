<?php

/* 
 * Class controla parametros do sistema
 * 
 * @author Avanei Martendal
 * 
 * @since 25/08/2017
 */

class ControllerParam extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Param');
    }
    
    /**
     * Verifica parameto se o representante pode ver empenho ou não
     */
    
    public function getBempenho(){
        $bRet = $this->Persistencia->liberaEmpenho();
        return $bRet;
    }
}

