<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class ControllerMET_ItensManPrev extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('MET_ItensManPrev');
    }
    
    public function buscaMaqDes($sCodMaq) {
        
        $oMaqDes = $this->Persistencia->consultaMaqDes($sCodMaq);
        $sMaqDes = $oMaqDes->maquina;
        return $sMaqDes;
        
    }
        
    //Novo ------------------------------------------------------------------------------------------------------
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);  
        $aChave[3] = $this->buscaMaqDes($aChave[2]);
        $this->View->setAParametrosExtras($aChave);
    }
    /////////////////////////////////////////////////VERIFICAR NECESSIDADE DE USO
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
       $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if (count($aparam) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
            $this->Persistencia->setChaveIncremento(false);
        } else {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam1[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam1[1]); 
            $this->Persistencia->setChaveIncremento(true);
        }
    }
    /*
    public function acaoDetalheIten($sDados, $sCampos) {
        parent::acaoDetalheIten($sDados, $sCampos);
        //adiciona filtro da chave primária
        $this->parametros = $sCampos;
        //carrega o model
        $this->carregaModel();

        $this->adicionaFiltrosExtras();
        //adiciona o filtro da sequencia do detalhe
        $this->adicionaFiltroDet();

        $iCont = $this->Persistencia->getCount();
        //limpa os filtros
        $this->Persistencia->limpaFiltro();
        //verifica se há validacao no lado do servidor
        $this->getVal($sDados . ',' . $iCont);
        //limpa os filtros
        $this->Persistencia->limpaFiltro();
        //se cont = 0 segue ação incluir
        //if ($iCont == 0) {
            $this->acaoIncluirDet($sDados, $sCampos);
        //} else {
       //     $this->acaoAlterarDet($sDados, $sCampos);
        //}
    }
     * 
     */
    
    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
            $aCampoAtual = explode('=', $sCampoAtual);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }

        $this->Persistencia->setChaveIncremento(false);
    }
    
    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sDados);
        $aParam = explode(',', $sDados);

        //verifica se está como 
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
        echo $sScript;
    }
    
    
    /**
     * Cria tela
     * @param type $sDados
     * @param type $sCampos
     */
    
    public function criaPainelItensManPrev($sDados, $sCampos) {
        $aDados = explode(',', $sDados);
        $aCampos = explode(',', $sCampos);
        $this->pkDetalhe($aCampos);
        $this->parametros = $sCampos;

        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->adicionaBotoesEtapas($aDados[0], $aDados[1], $this->getControllerDetalhe(), $this->getSMetodoDetalhe());
        $this->View->getTela()->getRender();
    }
    
    
    //-----------------------------------------------------------------------------------------------------------
}