<?php

/**
 * Classe principal do sistema, responsável pelo gerenciamento de 
 * todas as requisições
 * 
 * @author Avanei Martendal
 * @since 20/07/2016
 */
class ControllerPrincipal extends Controller {

    /**
     * Método responsável por realizar as requisições do sistema
     * Instancia objetos e realiza a chamada dos métodos desejados
     * conforme os parâmetros passados 
     */
    public function getRequisicao() {

        $bExecuta = true;
        $sClasse = "";
        $sMetodo = "";
        $aParametros = array();
        $iCodigoClasse = $_REQUEST['classe'];

        if (isset($_REQUEST['classe']) && isset($_REQUEST['metodo'])) {
            if ($_REQUEST['metodo'] == 'acaoLogout') {
                $bExecuta = true;
            } else
            if ($_REQUEST['classe'] == 'MET_TEC_Soluser' || $_REQUEST['classe'] == 'Agendamentos' || $_REQUEST['classe'] == 'BuscaRepSite' ||
                    $_REQUEST['classe'] == 'NoticiaSite' || $_REQUEST['classe'] == 'MovFornoSteel' || $_REQUEST['classe'] == 'Curriculo') {
                $bExecuta = true;
            } else {
                $bExecuta = $this->validaSessao();
            }

            if ($bExecuta || $_REQUEST['metodo'] == 'logaSistema' || $_REQUEST['redefinesenha'] || ($_REQUEST['classe'] == 'Mobile' && $_REQUEST['metodo'] == 'getRequisicao') || ($_REQUEST['classe'] == 'MET_TEC_Mobile' && $_REQUEST['metodo'] == 'getRequisicao')) {
                $bExecuta = true;

                $sClasse = $_REQUEST['classe'];
                $sMetodo = $_REQUEST['metodo'];

                if ($_REQUEST['parametros']) {
                    foreach ($_REQUEST['parametros'] as $atual) {
                        array_push($aParametros, utf8_decode($atual));
                    }
                }

                if ($_REQUEST['parametrosCampos']) {
                    foreach ($_REQUEST['parametrosCampos'] as $atual) {
                        array_push($aParametros, utf8_decode($atual));
                    }
                }
            }
        } else {

            $sClasse = 'MET_TEC_Login';
            $sMetodo = 'mostraTelaLogin';
        }

        if ($bExecuta) {
            //cria a instância do objeto
            $oRequest = Fabrica::FabricarController($sClasse);


            if (is_numeric($iCodigoClasse) && $oRequest) {
                $oRequest->setCodigoRotina($iCodigoClasse);
            }

            if (!$oRequest) {
                
            } else {

                if (method_exists($oRequest, $sMetodo)) {
                    call_user_func_array(array($oRequest, $sMetodo), $aParametros);
                } else {
                    
                }
            }
        } else {
            /*
             * finaliza a sessão, emite mensagem de erro de sessão 
             * inválida ao usuário e o redireciona para a página de login
             */
            $oControllerUsuario = Fabrica::FabricarController('Usuario');
            $oControllerUsuario->msgSessaoInvalida('Principal....');
        }
    }

    /**
     * Método que realiza a validação da sessão do usuário 
     * 
     * @return boolean
     */
    public function validaSessao() {
        $oControllerUsuario = Fabrica::FabricarController('Usuario');
        return $oControllerUsuario->validaSessao();
    }

}

?>