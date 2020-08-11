<?php
/**
 * Classe que filtra automaticamente apenas os dados da empresa da session
 * 
 * @author Everton Porath
 * @since 15/06/2013
 */
 class ControllerEmpresaPadrao extends Controller{

    public function adicionaFiltrosExtras(){
        $this->Persistencia->adicionaFiltro('empcodigo',$_SESSION['empresa']);       
    }
}
?>