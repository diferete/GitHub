<?php

/**
 * Implementa view da classe MET_TEC_MigraWinX
 * 
 * @author Alexandre W de Souza
 * @since 01/10/2018
 * ***/

class ViewMET_TEC_MigraWinX extends View {

    public function criaTela() {
        parent::criaTela();
        
        $oBotaoGrupo = new Campo('Migra Grupo', '', Campo::TIPO_BOTAOSMALL_SUB,1,1,12,12);
        
        $sAcaoGrupo = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","migraGrupo","'.$this->getTela()->getId().'-form,");';
        
        $oBotaoGrupo->getOBotao()->addAcao($sAcaoGrupo);
        
        $this->addCampos($oBotaoGrupo);
    }

}
