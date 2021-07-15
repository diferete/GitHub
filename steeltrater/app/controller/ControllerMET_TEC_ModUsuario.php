<?php

/*
 * Classe que implementa os métodos de controle 
 * dos módulos do usuário
 */

class ControllerMET_TEC_ModUsuario extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_ModUsuario');
    }

    /*
     * Método que retorna o modulo do usuário, se esta setado $bInicial como true
     * retorna somente o primeiro modulo se false returna todos
     */

    public function modSistema($bInicial = false, $sModulo) {
        return $this->Persistencia->modUserSistema($bInicial, $sModulo);
    }

    /**
     * 
     * @return string
     */
    public function modSistemaApp() {
        return $this->Persistencia->modUserSistemaApp();
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $iNr = $this->Persistencia->getModUserApp('');

        if ($iNr > 0) {
            $oMensagem = new Mensagem('Atenção!', 'Já existe um módulo de aplicativo para esse usuário', Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            exit();
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
