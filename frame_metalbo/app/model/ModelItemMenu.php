<?php
/**
 * Classe que implementa o Model do objeto ItemMenu 
 */
class ModelItemMenu{
    private $Modulo;
    private $Menu;
    private $itecodigo; 
    private $itedescricao;
    private $iteordem;
    private $iteclasse;
    private $itemetodo;
    
    function getModulo() {
        if(!isset($this->Modulo)){
            $this->Modulo = Fabrica::FabricarModel('Modulo');
        }
        return $this->Modulo;
    }

    function setModulo($Modulo) {
        $this->Modulo = $Modulo;
    }

    function getMenu() {
        if(!isset($this->Menu)){
            $this->Menu = Fabrica::FabricarModel('Menu');
        }
        return $this->Menu;
    }

    function setMenu($Menu) {
        $this->Menu = $Menu;
    }

     

    function getItecodigo() {
        return $this->itecodigo;
    }

    function getItedescricao() {
        return $this->itedescricao;
    }

    function getIteordem() {
        return $this->iteordem;
    }

    function getIteclasse() {
        return $this->iteclasse;
    }

    function getItemetodo() {
        return $this->itemetodo;
    }

   

   

    function setItecodigo($itecodigo) {
        $this->itecodigo = $itecodigo;
    }

    function setItedescricao($itedescricao) {
        $this->itedescricao = $itedescricao;
    }

    function setIteordem($iteordem) {
        $this->iteordem = $iteordem;
    }

    function setIteclasse($iteclasse) {
        $this->iteclasse = $iteclasse;
    }

    function setItemetodo($itemetodo) {
        $this->itemetodo = $itemetodo;
    }


}
?>