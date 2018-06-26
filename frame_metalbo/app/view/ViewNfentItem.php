<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewNfentItem extends View{
    public function __construct() {
        parent::__construct();
    }
    
    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(400);
        
        
        $oNfdoc = new CampoConsulta('Documento','nfdoc');
        $oNfserie = new CampoConsulta('Série','nfserie');
        $oPescnpj = new CampoConsulta('Código Pessoa','pescnpj');
        $oNfSeq = new CampoConsulta('Seq.','nfseq');
        $oProcod = new CampoConsulta('Código','procod');
        $oProdes = new CampoConsulta('Descrição','prodes');
        $oNfqt = new CampoConsulta('Quantidade','nfqt');
        $oNfqtUnit = new CampoConsulta('Unitário','nfvlrunit');
        $oNfVlrTot = new CampoConsulta('Total','nfvlrtot');
        
        $this->addCamposDetalhe($oNfdoc,$oNfserie,$oPescnpj,$oNfSeq,$oProcod,$oProdes,$oNfqt,$oNfqtUnit,$oNfVlrTot);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    
    function criaTela(){
        parent::criaTela();
        
        $this->criaGridDetalhe();
       /*Dados pk menu*/
        $aValor = $this->getAParametrosExtras();
        
        $oEmpCnpj = new Campo('Empresa', 'empcnpj', Campo::TIPO_TEXTO,2);
        $oEmpCnpj->setBCampoBloqueado('true');
        $oEmpCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpCnpj->setSValor($aValor[3]);
        
        $oNfdoc = new Campo('Documento','nfdoc',  Campo::TIPO_TEXTO,1);
        $oNfdoc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfdoc->setBCampoBloqueado(true);
        $oNfdoc->setApenasTela(true);
        $oNfdoc->setSValor($aValor[0]);
        
        $oNfserie = new Campo('Série','nfserie', Campo::TIPO_TEXTO,1);
        $oNfserie->setBCampoBloqueado(true);
        $oNfserie->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfserie->setSValor($aValor[1]);
        $oNfserie->setApenasTela(true);
        
        $oPescnpj = new Campo('Pessoa','pescnpj', Campo::TIPO_TEXTO,1);
        $oPescnpj->setBCampoBloqueado(true);
        $oPescnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPescnpj->setApenasTela(true);
        $oPescnpj->setSValor($aValor[2]);
        
        $oNfseq = new Campo('Sequencia','nfseq', Campo::TIPO_TEXTO,1);
        $oNfseq->setBCampoBloqueado(true);
        $oNfseq->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfseq->setBFocus(true);
        
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
        
        $oNfqt = new Campo('Quantidade','nfqt', Campo::TIPO_TEXTO,1);
        $oNfqt->setITamanho(Campo::TAMANHO_PEQUENO);
       //$oNfqt->setSTipoMoeda($sTipoMoeda)
        
        $oNfqtUnit = new Campo('Unitário','nfvlrunit', Campo::TIPO_TEXTO,1);
        $oNfqtUnit->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oNfVlrTot = new Campo('Total','nfvlrtot', Campo::TIPO_TEXTO,1);
        $oNfVlrTot->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfVlrTot->setBCampoBloqueado(true);
        
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL);
        $sGrid=$this->getOGridDetalhe()->getSId();
       //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oNfseq->getId().','.$sGrid.','.$oNfseq->getId().'","'.$oNfdoc->getSValor().','.$oNfserie->getSValor().','.$oPescnpj->getSValor().','.$oEmpCnpj->getSValor().'");';//$oNfseq
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
        $this->addCampos($oEmpCnpj,array($oNfdoc,$oNfserie,$oPescnpj,$oNfseq),array($oProcod,$oProdes,$oNfqt,$oNfqtUnit,$oNfVlrTot,$oBotConf));
        
        $oNfqt->addEvento(Campo::EVENTO_SAIR, 'var qt = $("#'.$oNfqt->getId().'").val();'
                . '$("#'.$oNfqt->getId().'").val(moedaParaNumero(qt));'
                . 'calcItemNf("'.$oNfqt->getId().'","'. $oNfqtUnit->getId().'","'. $oNfVlrTot->getId().'");');

         $oNfqtUnit->addEvento(Campo::EVENTO_SAIR, 'var unit = $("#'.$oNfqtUnit->getId().'").val();'
                . '$("#'.$oNfqtUnit->getId().'").val(moedaParaNumero(unit));'
                . 'calcItemNf("'.$oNfqt->getId().'","'. $oNfqtUnit->getId().'","'. $oNfVlrTot->getId().'");');
         
        //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oNfdoc,$oNfserie,$oPescnpj);
       
        
    }
    
    function criaConsulta(){
        parent::criaConsulta();
        $oNfdoc = new CampoConsulta('Documento','nfdoc');
        $oNfserie = new CampoConsulta('Série','nfserie');
        $oPescnpj = new CampoConsulta('Código Pessoa','pescnpj');
        $oNfSeq = new CampoConsulta('Seq.','nfseq');
        $oProcod = new CampoConsulta('Código','procod');
        $oProdes = new CampoConsulta('Descrição','prodes');
        $oNfqt = new CampoConsulta('Quantidade','nfqt');
        $oNfqtUnit = new CampoConsulta('Unitário','nfvlrunit');
        $oNfVlrTot = new CampoConsulta('Total','nfvlrtot');
        
        $this->addCampos($oNfdoc,$oNfserie,$oPescnpj,$oNfSeq,$oProcod,$oProdes,$oNfqt,$oNfqtUnit,$oNfVlrTot);
    }
}
