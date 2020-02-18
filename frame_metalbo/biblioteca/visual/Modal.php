<?php

/**
 * Classe que implementa mensagens modal
 *
 * @author Carlos Eduardo Scheffer
 * @since 01/12/2016
 */
class Modal {

    private $sId; //Define ID da mensagem
    private $iTipo; //Defite tipo da mensagem
    private $sTitulo; // Define titulo da mensagem
    private $sMsg; //Define a mensagem
    private $sBtnConfirmar; //Texto botão confirmar
    private $bBtnConfirmarFechar; //Fechar modal ao pressionar Confirmar
    private $sBtnConfirmarFunction; //Método ao ser executado quando confirmar for pressionado
    private $bBtnCancelar; //Botão cancelar
    private $sBtnCancelar; //Texto botão cancelar
    private $bBtnCancelarFechar; //Fechar ao pressionar botão cancel
    private $sBtnCancelarFunction; //Método ao ser executada quando cancelar for pressionado

    const TIPO_SUCESSO = 0;
    const TIPO_INFO = 1;
    const TIPO_AVISO = 2;
    const TIPO_ERRO = 3;

    /**
     * 
     * Método responsável por criar a mensagem modal, quando invocada
     * @param type $sTitulo Titulo da mensagem
     * @param type $sMsg Mensagem
     * @param type $iTipo Tipo da mensagem: Sucesso, Aviso, Erro, Info
     * @param type $bBtnCancelar Mostrar botão cancelar
     * @param type $bBtnConfirmarFechar Fechar ao pressionar Confirmar
     * @param type $bBtnCancelarFechar Fechar ao pressionar Cancelar
     */
    public function __construct($sTitulo, $sMsg, $iTipo = self::TIPO_INFO, $bBtnCancelar = false, $bBtnConfirmarFechar = true, $bBtnCancelarFechar = true) {
        $this->sId = Base::getId();
        $this->setITipo($iTipo);
        $this->setSTitulo($sTitulo);
        $this->setSMsg($sMsg);

        $this->setSBtnConfirmar('Confirmar');
        $this->setBBtnConfirmarFechar($bBtnConfirmarFechar);
        $this->setSBtnConfirmarFunction('');

        $this->setBBtnCancelar($bBtnCancelar);
        $this->setSBtnCancelar('Cancelar');
        $this->setBBtnCancelarFechar($bBtnCancelarFechar);
        $this->setSBtnCancelarFunction('');
    }

    /**
     * 
     * Retorna o id do modal
     * @return string
     */
    function getSId() {
        return $this->sId;
    }

    /**
     * retorna o tipo da mensagem
     * @return int
     */
    function getITipo() {
        return $this->iTipo;
    }

    /**
     * Retorna titulo da mensagem
     * @return string
     */
    function getSTitulo() {
        return $this->sTitulo;
    }

    /**
     * 
     * retorna a mensagem
     * @return string
     */
    function getSMsg() {
        return $this->sMsg;
    }

    function setSId($sId) {
        $this->sId = $sId;
    }

    /**
     * Define tipo da mensagem
     * @param int Tipo da mensagem
     */
    function setITipo($iTipo) {
        $this->iTipo = $iTipo;
    }

    /**
     * Define titulo da mensagem
     * @param string String do Titulo
     */
    function setSTitulo($sTitulo) {
        $this->sTitulo = $sTitulo;
    }

    /**
     * Define a mensagem
     * @param string String da mensagem
     */
    function setSMsg($sMsg) {
        $this->sMsg = $sMsg;
    }

    function getSBtnConfirmar() {
        return $this->sBtnConfirmar;
    }

    function getBBtnConfirmarFechar() {
        return $this->bBtnConfirmarFechar;
    }

    function getSBtnConfirmarFunction() {
        return $this->sBtnConfirmarFunction;
    }

    function getBBtnCancelar() {
        return $this->bBtnCancelar;
    }

    function getSBtnCancelar() {
        return $this->sBtnCancelar;
    }

    function getBBtnCancelarFechar() {
        return $this->bBtnCancelarFechar;
    }

    function getSBtnCancelarFunction() {
        return $this->sBtnCancelarFunction;
    }

    function setSBtnConfirmar($sBtnConfirmar) {
        $this->sBtnConfirmar = $sBtnConfirmar;
    }

    function setBBtnConfirmarFechar($bBtnConfirmarFechar) {
        $this->bBtnConfirmarFechar = $bBtnConfirmarFechar;
    }

    function setSBtnConfirmarFunction($sBtnConfirmarFunction) {
        $this->sBtnConfirmarFunction = $sBtnConfirmarFunction;
    }

    function setBBtnCancelar($bBtnCancelar) {
        $this->bBtnCancelar = $bBtnCancelar;
    }

    function setSBtnCancelar($sBtnCancelar) {
        $this->sBtnCancelar = $sBtnCancelar;
    }

    function setBBtnCancelarFechar($bBtnCancelarFechar) {
        $this->bBtnCancelarFechar = $bBtnCancelarFechar;
    }

    function setSBtnCancelarFunction($sBtnCancelarFunction) {
        $this->sBtnCancelarFunction = $sBtnCancelarFunction;
    }

    /**
     * Função (idiota) responsável por converter valor booleano para string
     * @param boolean Valor a ser identificado para renderizar
     * @return string Sting a ser renderizada no JS   
     */
    function getValBoolean($bVal) {
        if ($bVal) {
            return 'true';
        } else if (!$bVal) {
            return 'false';
        }
    }

    /**
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    function getRender() {

        switch ($this->getITipo()) {
            case self::TIPO_SUCESSO:
                $sTipo = 'success';
                break;
            case self::TIPO_AVISO:
                $sTipo = 'warning';
                break;
            case self::TIPO_ERRO:
                $sTipo = 'error';
                break;
            case self::TIPO_INFO:
                $sTipo = 'info';
                break;
        }
        $sModal = 'swal({'
                . 'title: "' . $this->getSTitulo() . '",'
                . 'text: "' . $this->getSMsg() . '",'
                . 'type: "' . $sTipo . '",'
                . 'showCancelButton: ' . $this->getValBoolean($this->getBBtnCancelar()) . ',' //Mostrar botão cancelar
                . 'confirmButtonClass: "btn-success",' //Classe botão Cancelar
                . 'cancelButtonClass: "btn-danger",'
                . 'confirmButtonText: "' . $this->getSBtnConfirmar() . '",' //Texto Botão Confirmar
                . 'cancelButtonText: "' . $this->getSBtnCancelar() . '",' //Texto Botão Cancelar
                . 'closeOnConfirm: ' . $this->getValBoolean($this->getBBtnConfirmarFechar()) . ',' //Fechar ao confirmar
                . 'closeOnCancel: ' . $this->getValBoolean($this->getBBtnCancelarFechar()) . '' // Fechar ao Cancelar
                . '},'
                . 'function(isConfirm){'
                . 'if (isConfirm) {'
                . $this->getSBtnConfirmarFunction() //Executa função se confirmar
                . '} else {'
                . $this->getSBtnCancelarFunction() //Executa função se cancelar
                . '}'
                . '});';
        return $sModal;
    }

}
