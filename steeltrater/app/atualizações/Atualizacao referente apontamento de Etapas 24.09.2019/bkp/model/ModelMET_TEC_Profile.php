<?php

/* 
 *Classe que implementa o modelo de dados dos usuários
 * @author Avanei Martendal
 * @since 24/05/2016
 */
class ModelMET_TEC_Profile{
    private $usucodigo;
    private $usunome;
    private $usulogin;
    private $ususenha;
    private $usucracha;
    private $usuimagem;
    
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getUsulogin() {
        return $this->usulogin;
    }

    function getUsusenha() {
        return $this->ususenha;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setUsulogin($usulogin) {
        $this->usulogin = $usulogin;
    }

    function setUsusenha($ususenha) {
        $this->ususenha = $ususenha;
    }
    function getUsucracha() {
        return $this->usucracha;
    }

    function setUsucracha($usucracha) {
        $this->usucracha = $usucracha;
    }
    function getUsuimagem() {
        return $this->usuimagem;
    }

    function setUsuimagem($usuimagem) {
        $this->usuimagem = $usuimagem;
}




}
