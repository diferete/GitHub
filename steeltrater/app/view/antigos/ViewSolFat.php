<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewSolFat extends View{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpcnpj = new CampoConsulta('Empresa', 'empcnpj');
        $oFatnro  = new CampoConsulta('Sol. Nf', 'fatsol');
        $oFatnro->setILargura(50);
        
        $oCnpj = new CampoConsulta('Código Pessoa', 'Pessoa.pescnpj');
        $oCliente = new CampoConsulta('Cliente', 'pesnome_razao');
        $oContato = new CampoConsulta('Contato', 'contato');
        $oFatsit = new CampoConsulta('Sit. Fat', 'fatsit');
        
       
        $oFatod = new CampoConsulta('Ordem','fatod');
        $oFatod->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_AMARELO,CampoConsulta::MODO_COLUNA);
        $oFatod->setBComparacaoColuna(true);
        
        $oFatsit->addComparacao('Não gerada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);//Ordem de serviço
        $oFatsit->addComparacao('Faturada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
       
        $oFatsit->setBComparacaoColuna(true);
        
        $oVlr = new CampoConsulta('Valor','fatvlrtot',  Campo::TIPO_MONEY);
        
        $oFatfinan = new CampoConsulta('Financeiro','fatfinan');
        $oFatfinan->addComparacao('Com financeiro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oFatfinan->addComparacao('Sem financeiro', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oFatfinan->setBComparacaoColuna(true);
        
        $this->addCampos($oFatnro,$oFatod,$oCnpj,$oCliente,$oContato,$oVlr,$oFatsit,$oFatfinan);
        
        
        $oFatSolFil = new Filtro($oFatnro, Filtro::CAMPO_TEXTO,2);
        
        $oClienteFil = new Filtro($oCliente, Filtro::CAMPO_TEXTO,3 );
       
        $this->addFiltro($oFatSolFil,$oClienteFil);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Contas Receber ', Dropdown::TIPO_PADRAO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG).'Adiciona Contas á Receber','ContRec', 'acaoMostraTelaIncluir', '',true);
        
        $oDrop2 = new Dropdown('Movimentações ', Dropdown::TIPO_ERRO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIG).'Retorna solicitação','SolFat', 'retornaSolicitação', '',false);
        
        $this->addDropdown($oDrop1,$oDrop2);
        
        $this->setUsaAcaoExcluir(false);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Solicitação de Nota Fiscal');
        
        $oEmpcnpj = new Campo('', 'empcnpj',  Campo::TIPO_TEXTO,2);
        $oEmpcnpj->setSValor('21804925000165');
        $oEmpcnpj->setILinhasTextArea(Campo::TAMANHO_PEQUENO);
        $oEmpcnpj->setBOculto(true);
        
        $oFatSol = new Campo('Solicitação','fatsol',  Campo::TIPO_TEXTO,1);
        $oFatSol->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oPessoa = new Campo('Código Pessoa','Pessoa.pescnpj', Campo::TIPO_BUSCADOBANCOPK,2);
        $oPessoa->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oRazao = new Campo('Nome','pesnome_razao', Campo::TIPO_BUSCADOBANCO,4);
        $oRazao->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRazao->setSIdPk($oPessoa->getId());
        $oRazao->setClasseBusca('Pessoa');
        $oRazao->addCampoBusca('pescnpj', '','');
        $oRazao->addCampoBusca('pesnome_razao', '','');
        
        $oPessoa->setClasseBusca('Pessoa');
        $oPessoa->setSCampoRetorno('pescnpj',$this->getTela()->getId());
        $oPessoa->addCampoBusca('pesnome_razao',$oRazao->getId(),  $this->getTela()->getId());
        
        $oContato = new Campo('Contato','contato', Campo::TIPO_TEXTO,4);
        $oContato->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oEtapas = new FormEtapa(2,2,2,2);
        $oEtapas->addItemEtapas('Solicitação Nota Fiscal',true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens da Solicitação',false,  $this->addIcone(Base::ICON_CONFIRMAR));
        
        $this->addEtapa($oEtapas);
        
        $oVlrTot = new Campo('Valor','fatvlrtot',  Campo::TIPO_TEXTO,2);
       // $oVlrTot->setBCampoBloqueado(true);
        $oVlrTot->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oFatSit = new Campo('Sit. Fat','fatsit',  Campo::TIPO_TEXTO,2);
        $oFatSit->setBCampoBloqueado(true);
        $oFatSit->setITamanho(Campo::TAMANHO_PEQUENO);
        $oFatSit->setSValor('Não gerada');
        
        $oFatFinan =new Campo('Sit. Finan','fatfinan',  Campo::TIPO_TEXTO,2);
        $oFatFinan->setBCampoBloqueado(true);
        $oFatFinan->setITamanho(Campo::TAMANHO_PEQUENO); 
        $oFatFinan->setSValor('Sem financeiro');
        
        $this->addCampos(array($oFatSol,$oFatSit,$oFatFinan,$oEmpcnpj),array($oPessoa,$oRazao,$oVlrTot),$oContato);
    }
    
    
}