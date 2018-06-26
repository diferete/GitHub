<?php
/*
 * Classe que implementa os métodos de controle 
 * dos módulos do usuário
 */
class ControllerModUsuario extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('ModUsuario');
        }
    /*
     * Método que retorna o modulo do usuário, se esta setado $bInicial como true
     * retorna somente o primeiro modulo se false returna todos
     */
     public function modSistema($bInicial=false,$sModulo){
         return $this->Persistencia->modUserSistema($bInicial,$sModulo); 
    }
    
    
}


