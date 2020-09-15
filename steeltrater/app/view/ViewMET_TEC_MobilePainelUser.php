<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_MobilePainelUser extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oUsucod = new CampoConsulta('Usuário','usucodigo');
        $oPainel = new CampoConsulta('Painel','painelcod');
        
        $oFiltro = new Filtro($oUsucod, Filtro::CAMPO_TEXTO_IGUAL, 3,3, 3, 3);
        $this->addFiltro($oFiltro);
        
        $this->addCampos($oUsucod,$oPainel);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de usuários e painel do app');
        
        $oUsucod = new Campo('Usuário','usucodigo', Campo::TIPO_BUSCADOBANCOPK, 2,2,2,2);
        $oUsucod->setClasseBusca('MET_TEC_Usuario');
        $oUsucod->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        
        $oPainel = new Campo('Painel','painelcod', Campo::TIPO_BUSCADOBANCOPK,2,2,2,2);
        $oPainel->setClasseBusca('MET_TEC_MobilePainel');
        $oPainel->setSCampoRetorno('painelcod',$this->getTela()->getId());
        
       
        
        $this->addCampos($oUsucod,$oPainel);
    }
}