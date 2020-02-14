<?php

/**
 * Controller da classe slides, que é responsável por controlar slides no MetalboApp e no Site
 * Atualmente é utilizada na classe
 * @author Carlos
 */
class ControllerSlides extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Slides');
    }
    
    
    public function getSlides(){
        
        $aModels  = $this->Persistencia->getSlides();
        
        if(!empty($aModels)){
            foreach($aModels as $oAtual){

                $aDados = array();
                $aDados['ID'] = $oAtual->getSlidid();
                $aDados['DESC'] = $oAtual->getSliddesc();
                $aDados['IMG'] = $oAtual->getSlidimg();
                $aDados['DATA'] = $oAtual->getSliddata();
                $aSlides[] = $aDados;
            }
            
            $aRetorno = array('SUCESSO' => true, 'DADOS' => $aSlides );
        }else{
            $aRetorno = array('SUCESSO' => false, 'ERRO' => 'Ocorreu algum erro ao obter os Slides' );
        }
        return $aRetorno;  
    }
    

}
