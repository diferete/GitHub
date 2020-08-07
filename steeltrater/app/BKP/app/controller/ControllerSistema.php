<?php
/**
 * Classe que controla as operações do objeto Sistema
 * 
 * @author Avanei Martendal
 * @since 22/09/2015
 */
 class ControllerSistema extends Controller{

     function __construct(){
        $this->View = Fabrica::FabricarView('Sistema');
        $this->Model = Fabrica::FabricarModel('Sistema');
        
        $this->Persistencia = Fabrica::FabricarPersistencia('Sistema');
        $this->Persistencia->setModel($this->Model);
       }  
       
       
     /**
      * Método que realiza a montagem da estrutura do sistema,
      * cabeçalho, rodapé e menu
      */
       
     public function getTelaSistema(){
       
       echo $this->View->retornaTelaInicial(); 
       }
    /*
     * Método que monta a tela inical do sistema
     */
    public function getTelaInicial(){
        echo $this->View->constroiTelaInicial();
       }
     
     


    
}
?>