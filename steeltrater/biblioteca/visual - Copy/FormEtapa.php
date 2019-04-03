<?php


class FormEtapa{
    private $sId;//id da etapa
    private $sTelaGrande; //Define o valor para tela grandes como note e pc
    private $sTelaMedia; //Define o valor para telas de tablets e notes pequenos
    private $sTelaPequena; //Define o valor para telas pequenas como tablets pequenos e celulares
    private $sTelaMuitoPequena; //Define o valor para telas muito pequenas como celulares pequenos
    private $aEtapa;


    public function __construct($sTelaGrande = '3',$sTelaMedia = '3',$sTelaPequena = '3',$sTelaMuitoPequena='3') {
        $this->sId = Base::getId();
        $this->setSTelaGrande($sTelaGrande);
        $this->setSTelaMedia($sTelaMedia);
        $this->setSTelaPequena($sTelaPequena);
        $this->setSTelaMuitoPequena($sTelaMuitoPequena);
        $this->aEtapa = array();
        }
    
        function getAEtapa() {
            return $this->aEtapa;
        }

        function setAEtapa($aEtapa) {
            $this->aEtapa = $aEtapa;
        }

        
    function getSId() {
        return $this->sId;
    }

    function getSTelaGrande() {
        return $this->sTelaGrande;
    }

    function getSTelaMedia() {
        return $this->sTelaMedia;
    }

    function getSTelaPequena() {
        return $this->sTelaPequena;
    }

    function getSTelaMuitoPequena() {
        return $this->sTelaMuitoPequena;
    }

    function getAEtapas() {
        return $this->aEtapas;
    }

    function setSId($sId) {
        $this->sId = $sId;
    }

    function setSTelaGrande($sTelaGrande) {
        $this->sTelaGrande = $sTelaGrande;
    }

    function setSTelaMedia($sTelaMedia) {
        $this->sTelaMedia = $sTelaMedia;
    }

    function setSTelaPequena($sTelaPequena) {
        $this->sTelaPequena = $sTelaPequena;
    }

    function setSTelaMuitoPequena($sTelaMuitoPequena) {
        $this->sTelaMuitoPequena = $sTelaMuitoPequena;
    }

    function setAEtapas($aEtapas) {
        $this->aEtapas = $aEtapas;
    }
    /**
     * Adiciona Etapas
     */
     public function addItemEtapas($sNomeEtapa,$bSetada=NULL,$sIcone){
      
       $aItemEtapa = array();
       $aItemEtapa['Nome']=$sNomeEtapa;
       $aItemEtapa['id']=  Base::getId();
       $aItemEtapa['setada']=$bSetada;
       $aItemEtapa['icon']=$sIcone;
       
       $this->aEtapa[]=$aItemEtapa;
    }
    /**
     * Método que renderiza as etapas
     */
    public function getRender(){
        $sRender = '<div class="pearls row" id="'.$this->getSId().'">';
        foreach ($this->aEtapa as $keyEtapa => $aPassos) {
            $sCurrent = $aPassos['setada']?'current':'';
            $sRender.= '<div id="'.$keyEtapa.'" class="pearl '.$sCurrent.' col-lg-'.$this->getSTelaGrande().' col-md-'.$this->getSTelaMedia().' col-sm-'.$this->getSTelaPequena().'  col-xs-'.$this->getSTelaMuitoPequena().' ">'
                .'<div class="pearl-icon">'.$aPassos['icon'].'</div>'
                .'<span class="pearl-title">'.$aPassos['Nome'].'</span>'
                .'</div>';
        }
        
         
                
         $sRender .='</div>';
        return $sRender;
     
    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

