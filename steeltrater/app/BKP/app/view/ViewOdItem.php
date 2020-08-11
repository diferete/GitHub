<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewOdItem extends View{
    
     function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(400);
        
        
        $oOdnr = new CampoConsulta('Número','odnr');
        $oOdseq = new CampoConsulta('Seq', 'odseq');
        $oProcod = new CampoConsulta('Código', 'procod');
        $oProdes = new CampoConsulta('Descrição', 'prodes');
        $oOdqt = new CampoConsulta('Quant.', 'odqt');
        $oOdvlr = new CampoConsulta('Valor Unit', 'odvlr');
        $oOdVlrTot = new CampoConsulta('Valor Total','odvlrtot');
        $oOdObs = new CampoConsulta('Obs', 'odobs');
        
        $this->addCamposDetalhe($oOdnr,$oOdseq,$oProcod,$oProdes,$oOdqt,$oOdvlr,$oOdVlrTot);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    
    function criaConsulta() {
        parent::criaConsulta();
        
        $oOdnr = new CampoConsulta('Número','odnr');
        $oOdseq = new CampoConsulta('Seq', 'odseq');
        $oProcod = new CampoConsulta('Código', 'procod');
        $oProdes = new CampoConsulta('Descrição', 'prodes');
        $oOdqt = new CampoConsulta('Quant.', 'odqt');
        $oOdvlr = new CampoConsulta('Valor Unit', 'odvlr');
        $oOdVlrTot = new CampoConsulta('Valor Total','odvlrtot');
        $oOdObs = new CampoConsulta('Obs', 'odobs');
        
        $this->addCampos($oOdnr,$oOdseq,$oProcod,$oProdes,$oOdqt,$oOdvlr,$oOdVlrTot);
        $this->setUsaAcaoVisualizar(true);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->criaGridDetalhe();
         
        $aValor = $this->getAParametrosExtras();
        $this->setTituloTela('Inclusão de itens venda');
        $oOdnr = new Campo('Número','odnr', Campo::TIPO_TEXTO,1);
        $oOdnr->setSValor($aValor[1]);
        $oOdnr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdnr->setBCampoBloqueado(true);
        $oEmpCnpj = new Campo('','empcnpj',  Campo::TIPO_TEXTO,2);
        $oEmpCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpCnpj->setBCampoBloqueado(true);
        $oEmpCnpj->setSValor($aValor[0]);
        $oEmpCnpj->setBOculto(true);
        
        $oOdseq = new Campo('Seq', 'odseq', Campo::TIPO_TEXTO,1);
        $oOdseq->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdseq->setBCampoBloqueado(true);
        
        $oProcod = new Campo('Código','procod', Campo::TIPO_BUSCADOBANCOPK,2);
        $oProcod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oProcod->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProcod->setBFocus(true);
        
        $oProdes = new Campo('Descrição','prodes', Campo::TIPO_BUSCADOBANCO,3);
        $oProdes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oProdes->setSIdPk($oProcod->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addCampoBusca('procod', '','');
        $oProdes->addCampoBusca('prodes', '','');
        
        $oProcod->setClasseBusca('Produto');
        $oProcod->setSCampoRetorno('procod',$this->getTela()->getId());
        $oProcod->addCampoBusca('prodes',$oProdes->getId(),  $this->getTela()->getId());
        
        
        
        
        
        
        
        $oOdqt = new Campo('Quant.', 'odqt',  Campo::TIPO_TEXTO,1);
        $oOdqt->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdvlr = new Campo('Valor Unit', 'odvlr', Campo::TIPO_TEXTO,1);
        $oOdvlr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdVlrTot = new Campo('Valor Total','odvlrtot', Campo::TIPO_TEXTO,1);
        $oOdVlrTot->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdObs = new Campo('Obs', 'odobs',  Campo::TIPO_TEXTAREA,4);
        
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL);
        
        $sGrid=$this->getOGridDetalhe()->getSId();
       //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oOdseq->getId().','.$sGrid.','.$oProcod->getId().'","'.$oEmpCnpj->getSValor().','.$oOdnr->getSValor().'");';
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
        $oOdqt->addEvento(Campo::EVENTO_SAIR, 'var qt = $("#'.$oOdqt->getId().'").val();'
                . '$("#'.$oOdqt->getId().'").val(moedaParaNumero(qt));'
                . 'calcItemNf("'.$oOdqt->getId().'","'. $oOdvlr->getId().'","'. $oOdVlrTot->getId().'");');

        $oOdvlr->addEvento(Campo::EVENTO_SAIR, 'var qt = $("#'.$oOdqt->getId().'").val();'
                . '$("#'.$oOdqt->getId().'").val(moedaParaNumero(qt));'
                . 'calcItemNf("'.$oOdqt->getId().'","'. $oOdvlr->getId().'","'. $oOdVlrTot->getId().'");');
        
        
        
        $this->addCampos(array($oOdnr,$oOdseq,$oProcod,$oProdes),array($oOdqt,$oOdvlr,$oOdVlrTot),array($oOdObs,$oBotConf),$oEmpCnpj);
       
         //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oEmpCnpj,$oOdnr);
    
        
        
        
        
        
        
        
        
        
    }
    
    
    
}
