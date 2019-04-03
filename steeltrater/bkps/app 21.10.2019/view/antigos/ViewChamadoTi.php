<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewChamadoTi extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1800);
        
        $oId = new CampoConsulta('Id','id');
        $oId->setILargura(30);
        
        $oSit = new CampoConsulta('Situação','ChamadoSit.sit');
        $oSit->setILargura(80);
        $oSit->addComparacao('AGUARDANDO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('EM ANDAMENTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oSit->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        
        $oTipo = new CampoConsulta('Tipo','tipo');
        $oTipo->setILargura(50);
        
        $oUserMet = new CampoConsulta('User Sistema Metalbo','MetSisMetalbo.nome');
        $oUserMet->setILargura(70);
        
        $oUserWeb = new CampoConsulta('User Web','User.usunome');
        $oUserWeb->setILargura(110);
        
        $oDataCad = new CampoConsulta('Data','datacad', CampoConsulta::TIPO_DATA);
        $oDataCad->setILargura(100);
        
        $oHoraCad = new CampoConsulta('Hora','horacad', CampoConsulta::TIPO_TIME);
        $oHoraCad->setILargura(100);
        
        $oSolicitante = new CampoConsulta('Solicitante','atendeti');
        
        
        
        $this->setBScrollInf(true);
        $this->setUsaAcaoExcluir(false);
        
        $this->addCampos($oId,$oSit,$oTipo,$oUserMet,$oUserWeb,$oDataCad,$oHoraCad,$oSolicitante);
        
        $oLinhaWhite = new Campo('','', Campo::TIPO_LINHABRANCO);
        $oProblema = new Campo('Problema apresentando','', Campo::TIPO_TEXTAREA,12);
        $oProblema->setILinhasTextArea(6);
        $oProblema->setSCorFundo(Campo::FUNDO_AMARELO);
        $this->addCamposGrid($oProblema,$oLinhaWhite);
        $this->getTela()->setIAltura(240);
        
         $this->getTela()->setSEventoClick('var chave=""; $("#'.$this->getTela()->getSId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                .'requestAjax("","ChamadoTi","carregaProb","'.$this->getTela()->getSId().'"+","+chave+","+"'.$oProblema->getId().'"+","+"");');
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oId = new Campo('Id','id', Campo::TIPO_TEXTO,1);
        
        $oSit = new Campo('Cod.','ChamadoSit.codsit', Campo::TIPO_TEXTO,1);
        $oSit->setSValor(1);
        $oSit->setBCampoBloqueado(true);
        
        $oUser = new Campo('Cod. User','User.usucodigo', Campo::TIPO_TEXTO,1);
        $oUser->setSValor($_SESSION['codUser']);
        $oUser->setBCampoBloqueado(true);
        $oNome = new Campo('Usuário','User.usunome', Campo::TIPO_TEXTO,3);
        $oNome->setSValor($_SESSION['nome']);
        $oNome->setApenasTela(true);
        $oNome->setBCampoBloqueado(true);
        
        $oLinha = new Campo('','linha1', Campo::TIPO_LINHA,12);
        $oLinha->setApenasTela(true);
        
        
        $oTipo = new Campo('Tipo','tipo', Campo::TIPO_SELECT,2);
        $oTipo->addItemSelect('SOFTWARE', 'SOFTWARE');
        $oTipo->addItemSelect('HARDWARE', 'HARDWARE');
        $oTipo->addItemSelect('SERVIÇOS', 'SERVIÇOS');
        
        $oProbl = new Campo('Descrição','probl', Campo::TIPO_TEXTAREA,10);
        $oProbl->setILinhasTextArea(8);
        $oProbl->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oLinha2 = new Campo('','linha12', Campo::TIPO_LINHA,12);
        $oLinha2->setApenasTela(true);
        
        $this->addCampos(array($oId,$oSit,$oUser,$oNome),$oLinha,$oTipo,$oProbl,$oLinha2);
        
        
    }
    
}