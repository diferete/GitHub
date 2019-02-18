<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewContPagItem extends View{
    public function __construct() {
        parent::__construct();
    }
    
    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);
        
        
        $oEmpcnpj = new CampoConsulta('Empresa', 'empcnpj');
        $oNfdoc = new CampoConsulta('Documento', 'nfdoc');
        $oNfserie = new CampoConsulta('Série', 'nfserie');
        $oPescnpj = new CampoConsulta('Razão', 'pescnpj');
        $oContseq = new CampoConsulta('Seq','contseq');
        $oContvlr = new CampoConsulta('Valor Parc', 'contvlr');
        $oContvenc = new CampoConsulta('Vencimento','contvenc');
        
        $this->addCamposDetalhe($oEmpcnpj,$oNfdoc,$oNfserie,$oPescnpj,$oContseq,$oContvlr,$oContvenc);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    
    
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpcnpj = new CampoConsulta('Empresa', 'empcnpj');
        $oNfdoc = new CampoConsulta('Documento', 'nfdoc');
        $oNfserie = new CampoConsulta('Série', 'nfserie');
        $oPescnpj = new CampoConsulta('Razão', 'pescnpj');
        $oContseq = new CampoConsulta('Seq','contseq');
        $oContvlr = new CampoConsulta('Valor Parc', 'contvlr');
        $oContvenc = new CampoConsulta('Vencimento','contvenc');
        
        $this->addCampos($oEmpcnpj,$oNfdoc,$oNfserie,$oPescnpj,$oContseq,$oContvlr,$oContvenc);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        $this->criaGridDetalhe();
        
        $aValor = $this->getAParametrosExtras();
        $oEmpcnpj = new Campo('Empresa', 'empcnpj',  Campo::TIPO_TEXTO,2);
        $oEmpcnpj->setSValor($aValor[0]);
        $oEmpcnpj->setBCampoBloqueado(true);
        $oNfdoc = new Campo('Documento', 'nfdoc',Campo::TIPO_TEXTO,1);
        $oNfdoc->setSValor($aValor[1]);
        $oNfdoc->setBCampoBloqueado(true);
        $oNfserie = new Campo('Série', 'nfserie',Campo::TIPO_TEXTO,1);
        $oNfserie->setSValor($aValor[2]);
        $oNfserie->setBCampoBloqueado(true);
        $oPescnpj = new Campo('Pessoa', 'pescnpj',Campo::TIPO_TEXTO,1);
        $oPescnpj->setSValor($aValor[3]);
        $oPescnpj->setBCampoBloqueado(true);
        $oContseq = new Campo('Seq','contseq',Campo::TIPO_TEXTO,1);
        $oContseq->setBCampoBloqueado(true);
        $oContvlr = new Campo('Valor Parc', 'contvlr',Campo::TIPO_TEXTO,1);
        $oContvlr->setSValor('0,00');
        $oContvenc = new Campo('Vencimento','contvenc',Campo::TIPO_DATA,2);
        $oContvenc->setSValor(date('d/m/Y'));
        
        $oContValorNf = new Campo('Valor Nota','vlrnf',  Campo::TIPO_TEXTO,1);
        $oContValorNf->setApenasTela(true);
        $oContValorNf->setBCampoBloqueado(true);
        $oContValorNf->setSValor($aValor[4]);
        
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL);
        $sGrid=$this->getOGridDetalhe()->getSId();
       //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oContseq->getId().','.$sGrid.','.$oContvlr->getId().'","'.$oNfdoc->getSValor().','.$oNfserie->getSValor().','.$oPescnpj->getSValor().','.$oEmpcnpj->getSValor().'");';//$oNfseq
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
         $oContvlr->addEvento(Campo::EVENTO_SAIR, 'var unit = $("#'.$oContvlr->getId().'").val();'
                . '$("#'.$oContvlr->getId().'").val(moedaParaNumero(unit));');
               
        
         
        $this->addCampos(array($oEmpcnpj,$oNfdoc,$oNfserie,$oContValorNf),array($oPescnpj,$oContseq,$oContvlr,$oContvenc,$oBotConf));
          //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oEmpcnpj,$oNfdoc,$oNfserie,$oPescnpj);
    }
    
    /*
     * Adiciona evento no botão concluir
     */
    public function addeventoConc() {
        parent::addeventoConc();
        
        $aValor = $this->getAParametrosExtras();
        
        $sRequest = 'requestAjax("","Nfent","mudaSitFinan","'.$aValor[0].','.$aValor[1].','.$aValor[2].','.$aValor[3].'");';
        
        return $sRequest;
    }
}