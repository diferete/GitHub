<?php
/**
 * Classe principal do sistema, responsável pelo gerenciamento de 
 * todas as requisições
 * 
 * @author Avanei Martendal
 * @since 20/07/2016
 */
class ControllerPrincipal extends Controller{
    /**
     * Método responsável por realizar as requisições do sistema
     * Instancia objetos e realiza a chamada dos métodos desejados
     * conforme os parâmetros passados 
     */

    public function getRequisicao(){
       
        $bExecuta = true;
        $sClasse = "";
        $sMetodo = "";
        $aParametros = array();
        $iCodigoClasse = $_REQUEST['classe'];
        
        if(isset($_REQUEST['classe']) && isset($_REQUEST['metodo'])){
            //$bExecuta = $this->validaSessao();
            
            $bExecuta = true;
            
            if($bExecuta || $_REQUEST['metodo'] == 'logaSistema'){
                $bExecuta = true;
                
                $sClasse = $_REQUEST['classe'];
                $sMetodo = $_REQUEST['metodo'];
                    
                if($_REQUEST['parametros']){
                    foreach ($_REQUEST['parametros'] as $atual) {
                        array_push($aParametros, utf8_decode($atual));
                    }
                }
                
                if($_REQUEST['parametrosCampos']){
                    foreach ($_REQUEST['parametrosCampos'] as $atual){
                        array_push($aParametros, utf8_decode($atual));
                    }
                }
            } 
           
        } else{
           
            $sClasse='Login';
            $sMetodo='mostraTelaLogin';  
           }

        if($bExecuta){
            //cria a instância do objeto
            $oRequest = Fabrica::FabricarController($sClasse);
            
            if(is_numeric($iCodigoClasse) && $oRequest){
                $oRequest->setCodigoRotina($iCodigoClasse);
            }
            
            if(!$oRequest){
               
            } else{
                
                if(method_exists($oRequest, $sMetodo)){
                    call_user_func_array(array($oRequest,$sMetodo),$aParametros);
                } else{
                    //verificar mensagem de erro que vamos apresentar
                   // $this->mensagemErroClasseMetodo("Erro ao executar método",$iCodigoClasse,$sClasse,$oModelAcaoRotina->getAcao()->getCodigo(),$sMetodo);
                }
            }
        } else{
            /* 
             * finaliza a sessão, emite mensagem de erro de sessão 
             * inválida ao usuário e o redireciona para a página de login
             */
            $oControllerUsuario = Fabrica::FabricarController('Usuario');
            $oControllerUsuario->msgSessaoInvalida();
        }

        }
    
   
    /**
     * Método que realiza a validação da sessão do usuário 
     * 
     * @return boolean
     */
    public function validaSessao(){
        $oControllerUsuario = Fabrica::FabricarController('Usuario');
        return $oControllerUsuario->validaSessao();
    }
} 
?>