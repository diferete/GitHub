<?php

class ControllerMobUsuModulos extends Controller{
    
    public function __construct() {
        $this->carregaClassesMvc('MobUsuModulos');
    }
    
    
    public function getModulos($usuCodigo){
        $aModulos = $this->Persistencia->getModulos($usuCodigo);
        
        if(is_array($aModulos)){
            return $aModulos;
        }
    }
    
}