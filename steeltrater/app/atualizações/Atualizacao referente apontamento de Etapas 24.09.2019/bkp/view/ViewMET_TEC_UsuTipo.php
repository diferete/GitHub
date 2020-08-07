<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_UsuTipo extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oUsutipo = new CampoConsulta('Código','usutipo');
        $oUsutipo->setILargura(600);
        $oUsudes = new CampoConsulta('Tipo Representante','usutipdescricao');
        $oUsudes->setILargura(600);
        
        $oUsutipoF = new Filtro($oUsutipo, Filtro::CAMPO_TEXTO,3);
        
        $this->addFiltro($oUsutipoF);
        
        $this->addCampos($oUsutipo,$oUsudes);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoVisualizar(true);
    }
    
    public function criaTela() {
        parent::criaTela();
        
         $oUsutipo = new Campo('Código','usutipo', Campo::TIPO_TEXTO,1);
        
         $oUsudes = new Campo('Tipo Representante','usutipdescricao', Campo::TIPO_TEXTO,3);
        
         $this->addCampos($oUsutipo,$oUsudes);
    }
}