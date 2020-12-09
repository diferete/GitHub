<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_HorasParadas extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_HorasParadas');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $sFornoDes = $this->Persistencia->buscaForno($aChave);
        $aChave[1] = $sFornoDes;
        $this->View->setAParametrosExtras($aChave);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aParam1 = explode(',', $this->getParametros());
        $aParam = $this->View->getAParametrosExtras();
        if (count($aParam) > 0) {
            $this->Persistencia->adicionaFiltro('fornocod', $aParam[0]);
        } else {
            $this->Persistencia->adicionaFiltro('fornocod', $aParam1[0]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->adicionaFiltro('fornocod', $this->Model->getFornocod());
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);

        $sScript = '$("#' . $sForm . '").each(function(){this.reset();});';
        echo $sScript;
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[1]);
        foreach ($aCampos as $key => $value) {
            $aCampoAtual = explode('=', $value);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }
    }

    /*
      public function beforeInsert() {
      parent::beforeInsert();

      $this->Model->setTempoparada();
      }

      public function beforeUpdate() {
      parent::beforeUpdate();

      $this->Model->setTempoparada();
      }
     * 
     */
}
