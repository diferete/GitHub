<?php

class ControllerCurriculo extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('Curriculo');
    }

    public function getTelaCurriculo() {
        $sTela = $this->View->blankScreen();
        echo $sTela;
    }

}
