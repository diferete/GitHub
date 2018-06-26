<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewImg extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        $oImg = new CampoConsulta('Imagem','imagem');
        $this->addCampos($oImg);
    }
    
    public function criaTela() {
        parent::criaTela();
        $oImg = new Campo('Imagem','imagem', Campo::TIPO_UPLOAD2,4);
        
        $this->addCampos($oImg);
    }
}