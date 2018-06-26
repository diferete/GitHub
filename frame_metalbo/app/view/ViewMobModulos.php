<?php
class ViewMobModulos extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oCodigo = new CampoConsulta('Código:', 'mobmodcod');
        $oDescricao = new CampoConsulta('Descrição:', 'mobmoddesc');
        $oRota = new CampoConsulta('Rota:', 'mobmodrota');
        $oIcone = new CampoConsulta('Ícone:', 'mobmodicon');
        
        $this->addCampos($oCodigo, $oDescricao, $oRota, $oIcone);
       
    }
    
    public function criaTela() {
        parent::criaTela();
        //$this->setTituloTela('Cadastro de Módulos Mobile');
        
        $oCodigo = new Campo('Código:', 'mobmodcod', Campo::TIPO_TEXTO,1,1,1,1);
        $oCodigo->setBCampoBloqueado(true);
        
        $oDescricao = new Campo('Descrição:', 'mobmoddesc');
        $oRota = new Campo('Rota:', 'mobmodrota');
        $oIcone = new Campo('Ícone:', 'mobmodicon');
        
        $this->addCampos($oCodigo, $oDescricao, $oRota, $oIcone);
    }
}

