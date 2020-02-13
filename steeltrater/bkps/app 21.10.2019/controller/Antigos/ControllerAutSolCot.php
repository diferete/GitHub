<?php

/* 
 * Controller da classe para liberar media de preço
 * @author Avanei Martendal
 * @since 25/07/2016
 */

class ControllerAutSolCot extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('AutSolCot');
    }
    
    /**
     * Libera cotação ou solicitação
     */
     /**
     * Verifica se item se encontra com preço liberado
     */
    public function libeSolCot($aDados){
        return $this->Persistencia->libeSolCot($aDados[8],$aDados[7],$aDados[9]);
        
    }
}