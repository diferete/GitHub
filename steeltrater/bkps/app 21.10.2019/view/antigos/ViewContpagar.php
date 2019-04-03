<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewContpagar extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaTela() {
        parent::criaTela();
        $this->setTituloTela('Inclusão de títulos');
        $oField = new FieldSet('Filtro');
        $aDados = $this->getAParametrosExtras();
        
        $oEmpcnpj = new Campo('Empresa','empcnpj', Campo::TIPO_TEXTO,2);
        $oEmpcnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpcnpj->setBCampoBloqueado(true);
        $oEmpcnpj->setSValor($aDados['empcnpj']);
        $oNfdoc = new Campo('Documento', 'nfdoc', Campo::TIPO_TEXTO,1);
        $oNfdoc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfdoc->setBCampoBloqueado(true);
        $oNfdoc->setSValor($aDados['nfdoc']);
        $oNfserie = new Campo('Serie','nfserie', Campo::TIPO_TEXTO,1);
        $oNfserie->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfserie->setSValor($aDados['nfserie']);
        $oNfserie->setBCampoBloqueado(true);
        $oPesCnpj = new Campo('Pessoa','pescnpj', Campo::TIPO_TEXTO,2);
        $oPesCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPesCnpj->setBCampoBloqueado(true);
        $oPesCnpj->setSValor($aDados['pescnpj']);
        
        $oDataEmi = new Campo('Data Emissão','contdataemi',  Campo::TIPO_DATA,2);
        $oDataEmi->setSValor(date('d/m/Y'));
        
        $oUserEmi = new Campo('Usuário','contuseremi',  Campo::TIPO_TEXTO,2);
        $oUserEmi->setSValor($_SESSION['nome']);
        
        $oHoraEmi = new Campo('Hora emissão','contdatahora',  Campo::TIPO_TEXTO,2);
        $oHoraEmi->setSValor(date('H:i:s'));
        
        $oEtapas = new FormEtapa(2,2,2,2);
        $oEtapas->addItemEtapas('Inclusão Contas á pagar',true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Inclusão Parcelas',false,  $this->addIcone(Base::ICON_CONFIRMAR));
        
        $this->addEtapa($oEtapas);
        
        $oField->addCampos(array($oEmpcnpj,$oPesCnpj,$oNfdoc,$oNfserie));
        $this->addCampos($oField,array($oDataEmi,$oUserEmi,$oHoraEmi));
    }
    public function criaConsulta() {
        parent::criaConsulta();
        
       
        
        $oEmpcnpj = new CampoConsulta('Empresa','empcnpj');
        $oNfdoc = new CampoConsulta('Documento', 'nfdoc');
        $oNfserie = new CampoConsulta('Serie','nfserie');
        $oPesCnpj = new CampoConsulta('Código Pessoa','pescnpj');
        
        
        
         $this->addCampos($oEmpcnpj,$oNfdoc,$oNfserie,$oPesCnpj);
        
    }
}
