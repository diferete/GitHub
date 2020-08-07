<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_ordensFabApontEtapasGeren extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabApontEtapasGeren');
    }
    
    public function acaoInicial($sDados){
        echo"$('#btn_atualizarGridPes').click();"; 
    }

        public function carregaDadosOps($sDados){
        $aDados = explode(',', $sDados);
        
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
                
        
        $oDadosOp = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEtapasGeren');
        $oDadosOp->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oDadosRec = $oDadosOp->Persistencia->consultarWhere();
        //getCorrida()
        echo "$('[name=op]').val('" . $oDadosRec->getOp() . "').trigger('change');";
        echo "$('[name=corrida]').val('" . $oDadosRec->getCorrida() . "').trigger('change');";
        echo "$('[name=fornoCombo]').val('" . $oDadosRec->getFornocod() . "').trigger('change');";
        echo "$('[name=turnoSteel]').val('" . $oDadosRec->getTurnoSteel() . "').trigger('change');";
        
        
        echo"$('#btn_atualizarApontEtapaSteel').click();"; 
    }

        public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        $aCamposTela = $this->getArrayCampostela();
        
      if(isset($aCamposTela['fornoComboGridPes'])){
        $this->Persistencia->adicionaFiltro('situacao','Processo');
        $this->Persistencia->adicionaFiltro('fornocod',$aCamposTela['fornoComboGridPes']);
        $this->Persistencia->adicionaFiltro('processoativo','SIM');
      }
    
    }
    
   

}