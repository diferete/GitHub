<?php

class ViewMobUsuModulos extends View{
    
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oId = new CampoConsulta('ID', 'id');
        $oOrdem  = new CampoConsulta('Ordem', 'mobmodordem');
        $oUsuario = new CampoConsulta('Nome','User.usunome');
        $oModulo = new CampoConsulta('Modulo','MobModulos.mobmodcod');
        $oModDes = new CampoConsulta('Descrição','MobModulos.mobmoddesc');
        
        $this->addCampos($oId, $oOrdem, $oUsuario, $oModulo, $oModDes);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oId = new Campo('ID', 'id');
        $oId->setBCampoBloqueado(true);
        
        $oOrdem = new Campo('Ordem', 'mobmodordem');
        
        $oUsuario = new Campo('Usuário','User.usucodigo',  Campo::TIPO_TEXTO,1);
        $oUsuario->setClasseBusca('User');
        $oUsuario->addCampoBusca('usunome',null,  $this->getTela()->getId());
        
        
        $oModulo = new Campo('Módulo','MobModulos.mobmodcod', Campo::TIPO_TEXTO,1);
        $oModulo->setClasseBusca('MobModulos');
        $oModulo->addCampoBusca('mobmoddesc',null,  $this->getTela()->getId());//sempre setar o nome do modulo referente a pesquisa
      
        
      $this->addCampos($oId, $oOrdem, $oUsuario, $oModulo);
    }
}

