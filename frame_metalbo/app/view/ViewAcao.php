<?php
/**
 * Classe que implementa as operações de tela referentes ao 
 * objeto as operações do objeto Ação
 * 
 * @author Everton Porath
 * @since 02/12/2013
 * 
 */
class ViewAcao extends View{ 
    
    function __construct() {
        parent::__construct();
        
        $this->setTitulo('Ação');
    }
    
    /**
     * Método que realiza a criação dos campos da tela de manutenção (inclusão/alteração) 
     */
    function criaTela(){
        parent::criaTela();
        
        $oId = new Campo('Código','codigo',Campo::TIPO_TEXTO,true);
        $oNome = new Campo('Descrição','descricao',Campo::TIPO_TEXTO,500,false);
        $oMetodo = new Campo('Metodo','metodo',Campo::TIPO_TEXTO,200,false);
        
        $this->addCampos($oId,$oNome,$oMetodo);
    }
    
    /**
     * Método que realiza a criação dos campos da tela de consulta
     */
    function criaConsulta(){
        parent::criaConsulta();
        
        $oCodigo = new CampoConsulta('Código','codigo',CampoConsulta::TIPO_INTEIRO);
        $oNome = new CampoConsulta('Descrição','descricao',CampoConsulta::TIPO_TEXTO);
        $oMetodo = new CampoConsulta('Método','metodo',CampoConsulta::TIPO_TEXTO);
        
        $this->addCampos($oCodigo,$oNome,$oMetodo);
    }
}
?>