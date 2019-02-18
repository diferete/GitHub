<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewSolFatItem extends View{
    
    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(400);
        
        
        $oFatSol = new CampoConsulta('Sol.','fatsol');
        $oFatseq = new CampoConsulta('Seq', 'fatseq');
        $oProcod = new CampoConsulta('Procod', 'procod');
        $oProdes = new CampoConsulta('Prodes', 'prodes');
        $oFatqt = new CampoConsulta('Qt', 'fatqt');
        $oFatVlrUnit = new CampoConsulta('Unit.', 'fatvlrunit');
        $oFatVlrTot = new CampoConsulta('Total', 'fatvlrtot');
        
        $this->addCamposDetalhe($oFatSol,$oFatseq,$oProcod,$oProdes,$oFatqt,$oFatVlrUnit,$oFatVlrTot);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->criaGridDetalhe();
        
        $aValor = $this->getAParametrosExtras();
        
        $oEmpCnpj = new Campo('Empresa', 'empcnpj', Campo::TIPO_TEXTO,2);
        $oEmpCnpj->setSValor( $aValor[0]);
        $oEmpCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oFatSol = new Campo('Sol.','fatsol', Campo::TIPO_TEXTO,2);
        $oFatSol->setSValor( $aValor[1]);
        $oFatSol->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oFatPescnpj = new Campo('Código Pessoa','pescnpj', Campo::TIPO_TEXTO,2);
        $oFatPescnpj->setSValor( $aValor[2]);
        $oFatPescnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oFatseq = new Campo('Seq', 'fatseq', Campo::TIPO_TEXTO,1);
        $oFatseq->setITamanho(Campo::TAMANHO_PEQUENO);
      
        
        $oProcod = new Campo('Código','procod', Campo::TIPO_BUSCADOBANCOPK,2);
        $oProcod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oProcod->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oProdes = new Campo('Descrição','prodes', Campo::TIPO_BUSCADOBANCO,3);
        $oProdes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdes->setSIdPk($oProcod->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '','');
        $oProdes->addCampoBusca('prodes', '','');
        
        $oProcod->setClasseBusca('Produto');
        $oProcod->setSCampoRetorno('procod',$this->getTela()->getId());
        $oProcod->addCampoBusca('prodes',$oProdes->getId(),  $this->getTela()->getId());
        
        
        
        $oFatqt = new Campo('Qt', 'fatqt', Campo::TIPO_TEXTO,1);
        $oFatqt->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oFatVlrUnit = new Campo('Unit.', 'fatvlrunit', Campo::TIPO_TEXTO,1);
        $oFatVlrUnit->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oFatVlrTot = new Campo('Total', 'fatvlrtot', Campo::TIPO_TEXTO,1);
        $oFatVlrTot->setITamanho(Campo::TAMANHO_PEQUENO);
        
         
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL);
        $sGrid=$this->getOGridDetalhe()->getSId();
       //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oFatseq->getId().','.$sGrid.','.$oProcod->getId().'","'.$oEmpCnpj->getSValor().','.$oFatSol->getSValor().','.$oFatPescnpj->getSValor().'");';
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
        
        $this->addCampos(array($oFatSol,$oFatPescnpj,$oEmpCnpj),array($oFatseq,$oProcod,$oProdes,$oFatqt,$oFatVlrUnit,$oFatVlrTot,$oBotConf));
        
         $oFatqt->addEvento(Campo::EVENTO_SAIR, 'var qt = $("#'.$oFatqt->getId().'").val();'
                . '$("#'.$oFatqt->getId().'").val(moedaParaNumero(qt));'
                . 'calcItemNf("'.$oFatqt->getId().'","'. $oFatVlrUnit->getId().'","'. $oFatVlrTot->getId().'");');

         $oFatVlrUnit->addEvento(Campo::EVENTO_SAIR, 'var qt = $("#'.$oFatqt->getId().'").val();'
                . '$("#'.$oFatqt->getId().'").val(moedaParaNumero(qt));'
                . 'calcItemNf("'.$oFatqt->getId().'","'. $oFatVlrUnit->getId().'","'. $oFatVlrTot->getId().'");');
         
        //adiciona objetos campos para servirem como filtros iniciais do grid
         
        $this->addCamposFiltroIni($oEmpCnpj,$oFatPescnpj,$oFatSol);
    }

    

    public function criaConsulta() {
        parent::criaConsulta();
        
        $oFatSol = new CampoConsulta('Sol.','fatsol');
        $oFatseq = new CampoConsulta('Seq', 'fatseq');
        $oProcod = new CampoConsulta('Procod', 'procod');
        $oProdes = new CampoConsulta('Prodes', 'prodes');
        $oFatqt = new CampoConsulta('Qt', 'fatqt');
        $oFatVlrUnit = new CampoConsulta('Unit.', 'fatvlrunit');
        $oFatVlrTot = new CampoConsulta('Total', 'fatvlrtot');
        
        $this->addCampos($oFatSol,$oFatseq,$oProcod,$oProdes,$oFatqt,$oFatVlrUnit,$oFatVlrTot);
        
        
        
    }
    
    
}
