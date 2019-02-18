<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewContRec extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpcnpj = new CampoConsulta('Empresa', 'empcnpj');
        $oPescnpj = new CampoConsulta('Código Pessoa','Pessoa.pescnpj');
        $oPesNome = new CampoConsulta('Razão','Pessoa.pesnome_razao');
        $oRecDocto = new CampoConsulta('Documento', 'recdocto');
        $oRecValor = new CampoConsulta('Valor Título', 'recvlrtot');
        
        $this->addCampos($oEmpcnpj,$oPescnpj,$oPesNome,$oRecDocto,$oRecValor);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        $aDados = $this->getAParametrosExtras();
        
        $oEmpcnpj = new Campo('Empresa', 'empcnpj',  Campo::TIPO_TEXTO,2);
        $oEmpcnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpcnpj->setSValor('21804925000165');
        $oEmpcnpj->setBCampoBloqueado(true);
        
        $oOdCnpj = new Campo('Código Pessoa','Pessoa.pescnpj', Campo::TIPO_BUSCADOBANCOPK,2);
        $oOdCnpj->setBFocus(true);
        $oOdCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdCnpj->setSValor($aDados['Pessoa_pescnpj']);
        $oOdCnpj->setBCampoBloqueado(true);
        
        $oRazao = new Campo('Razão Social','Pessoa.pesnome_razao', Campo::TIPO_BUSCADOBANCO, 4);
        $oRazao->setSIdPk($oOdCnpj->getId());
        $oRazao->setClasseBusca('Pessoa');
        $oRazao->addCampoBusca('pescnpj', '','');
        $oRazao->addCampoBusca('pesnome_razao', '','');
        //$oRazao->setApenasTela(true);
        $oRazao->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRazao->setSValor($aDados['razao']);
        $oRazao->setBCampoBloqueado(true);
        
        $oOdCnpj->setClasseBusca('Pessoa');
        $oOdCnpj->setSCampoRetorno('pescnpj',$this->getTela()->getId());
        $oOdCnpj->addCampoBusca('pesnome_razao',$oRazao->getId(),  $this->getTela()->getId());
        
        
        
        
        
        
        
        $oRecDocto = new Campo('Documento', 'recdocto',Campo::TIPO_TEXTO,1);
        if(isset($aDados['fatsol'])){
            $oRecDocto->setSValor($aDados['fatsol'].'-s');
        }
        $oRecDocto->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecDocto->setBFocus(true);
        $oRecDocto->setBCampoBloqueado(true);
        
        $oRecValor = new Campo('Valor Título', 'recvlrtot',Campo::TIPO_TEXTO,1);
        $oRecValor->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecValor->setSValor($aDados ['valor']);
        
        $oRecDtemiss = new Campo('Data emissão', 'recdtemiss',Campo::TIPO_DATA,2);
        $oRecDtemiss->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecDtemiss->setSValor(date('Y/m/d'));
        
        $oRecusuario = new Campo('Usuário', 'recusuario',Campo::TIPO_TEXTO,2);
        $oRecusuario->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecusuario->setSValor($_SESSION['nome']);
        $oRecusuario->setBCampoBloqueado(true);
        
        $oRechora = new Campo('Hora', 'rechoraemi',Campo::TIPO_TEXTO,2);
        $oRechora->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRechora->setSValor(date('H:i:s'));
        
        $oCondCod = new Campo('Condição Pag.','condcod', Campo::TIPO_BUSCADOBANCOPK,2);
        $oCondCod->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oCondDes = new Campo('Condição','conddes', Campo::TIPO_BUSCADOBANCO,3);
        $oCondDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCondDes->setSIdPk($oCondCod->getId());
        $oCondDes->setClasseBusca('CondPag');
        $oCondDes->addCampoBusca('condcod', '','');  
        $oCondDes->addCampoBusca('conddes', '',''); 
        
        $oCondCod->setClasseBusca('CondPag');
        $oCondCod->setSCampoRetorno('condcod',$this->getTela()->getId());
        $oCondCod->addCampoBusca('conddes',$oCondDes->getId(),  $this->getTela()->getId());
      
        $oEtapas = new FormEtapa(2,2,2,2);
        $oEtapas->addItemEtapas('Contas á receber',true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Parcelas',false,  $this->addIcone(Base::ICON_CONFIRMAR));
        
        $this->addEtapa($oEtapas);
        
        $this->addCampos(array($oEmpcnpj,$oRecusuario,$oRecDtemiss,$oRechora),array($oOdCnpj,$oRazao),$oRecDocto,$oRecValor,array($oCondCod,$oCondDes));
    }
}