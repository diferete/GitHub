<?php

class ViewMetSisMetalbo extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        
        $oCodUser = new CampoConsulta('Código','coduser');
        $oNome = new CampoConsulta('Nome','nome');
        $oSobre = new CampoConsulta('Sobrenome','sobrenome');
        
        $this->addCampos($oCodUser,$oNome,$oSobre);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
