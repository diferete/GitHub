<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPedRep extends View{
    
    
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        //adiciona o grid de itens de pedido
        $oGridItensPed = new Campo('Itens do Pedido','Itens Ped', Campo::TIPO_GRID,12,12,12,12);
        $oPdvnr = new CampoConsulta('Nr.Pedido','pdvnro');
        $oPdvnr->setILargura(30);
        $oSeq = new CampoConsulta('Seq.','pdvproseq');
        $oSeq->setILargura(25);
        $oCodigo = new CampoConsulta('Código','procod');
        $oCodigo->setILargura(60);
        $oDesProPed = new CampoConsulta('Descrição','pdvprodes');
        $oDesProPed->setILargura(350);
        $oQtProPed = new CampoConsulta('Quantidade','pdvproqtdp', CampoConsulta::TIPO_DECIMAL);
        $oQtProPed->setILargura(80);
        $oVlrUnit = new CampoConsulta('Vlr. Unit','pdvprovlta', CampoConsulta::TIPO_DECIMAL);
        $oVlrUnit->setILargura(80);
        $oTotal = new CampoConsulta('Total','total', CampoConsulta::TIPO_DECIMAL);
        $oTotal->setILargura(80);
        $oTotalFat = new CampoConsulta('Tot.Faturado','totalfat', CampoConsulta::TIPO_DECIMAL);
        
        $oGridItensPed->addCampos($oPdvnr,$oSeq,$oCodigo,$oDesProPed,$oQtProPed,$oVlrUnit,$oTotal,$oTotalFat);
        $oGridItensPed->setSController('PedRepIten');
        $oGridItensPed->addParam('pdvnro','0');
        $oGridItensPed->getOGrid()->setIAltura(150);
        $oGridItensPed->getOGrid()->setBScrollInf(false);
        
        //notas do pedido
        $oGridNotas = new Campo('Notas do Pedido','Notas Ped', Campo::TIPO_GRID,12,12,12,12);
        $oNf = new CampoConsulta('Nota','nfsnfnro');
        $oNf->setILargura(60);
        $oNfCod = new CampoConsulta('Código','nfsitcod');
        $oNfCod->setILargura(60);
        $oDesProNota = new CampoConsulta('Descrição','nfsitdes');
        $oDesProNota->setILargura(400);
        $oQtProNota = new CampoConsulta('Quantidade','nfsitqtd', CampoConsulta::TIPO_DECIMAL);
        $oDataEmi = new CampoConsulta('Emissão','nfsitdtemi', CampoConsulta::TIPO_DATA);
        $oPedido = new CampoConsulta('Pedido','nfsitpdvnr');
        $oNfSeq = new CampoConsulta('Seq.','nfsitseq');
        
        $oGridNotas->addCampos($oNf,$oNfSeq,$oNfCod,$oDesProNota,$oQtProNota,$oDataEmi,$oPedido);
        $oGridNotas->setSController('NfItenPed');
        $oGridNotas->addParam('nfsitpdvnr','0');
        $oGridNotas->getOGrid()->setIAltura(150);
        $oGridNotas->getOGrid()->setBScrollInf(false);
        
        
        $oPdvnro = new CampoConsulta('Nr.Pedido','pdvnro');
        $oOd = new CampoConsulta('Ord. Compra','pdvordcomp');
        $oCnpj = new CampoConsulta('Cnpj','Pessoa.empcod');
        $oEmpDes = new CampoConsulta('Cliente','Pessoa.empdes');
        $oSituaca = new CampoConsulta('Situação','situaca');
        $oSituaca->addComparacao('LIBERADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oSituaca->addComparacao('CANCELADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        $oSituaca->addComparacao('FATURADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
        $oSituaca->addComparacao('BLOQUEADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        $oEmissao = new CampoConsulta('Emissão','pdvemissao', CampoConsulta::TIPO_DATA);
        $oDtEntre = new CampoConsulta('Entrega','pdvdtentre',CampoConsulta::TIPO_DATA);
        
        $oFiltroPdvnro = new Filtro($oPdvnro, Filtro::CAMPO_TEXTO_IGUAL,2);
        $oFiltroCli = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO,3);
        $oFiltroOd = new Filtro($oOd, Filtro::CAMPO_TEXTO_IGUAL,2);
         $oFilCnpj = new Filtro($oCnpj, Filtro::CAMPO_BUSCADOBANCOPK,2);
         $oFilCnpj->setSClasseBusca('Pessoa');
         $oFilCnpj->setSCampoRetorno('empcod',$this->getTela()->getSId());
         $oFilCnpj->setSIdTela($this->getTela()->getSId());
         $oFilCnpj->setBBuscaTela(true);
        
        $this->addFiltro($oFiltroPdvnro,$oFiltroOd,$oFiltroCli,$oFilCnpj);
        
        $this->setUsaDropdown(true);
        $oDrop2 = new Dropdown('Pedido de venda', Dropdown::TIPO_PRIMARY);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA).'Visualizar', 'PedRep', 'acaoMostraRelConsulta','', false, 'RepPedido');
         $this->addDropdown($oDrop2);
        
        $this->addCampos($oPdvnro,$oOd,$oCnpj,$oEmpDes,$oSituaca,$oEmissao,$oDtEntre);
        $this->setBScrollInf(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoIncluir(false);
        $this->getTela()->setIAltura(250);
        
        
        
        $this->addCamposGrid($oGridItensPed,$oGridNotas);
        
        $this->getTela()->setSEventoClick('var chave=""; $("#'.$this->getTela()->getSId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
               . 'requestAjax("'.$this->getTela()->getSId().'-form","PedRepIten","getDadosGridDetalhe","'.$oGridItensPed->getId().'",chave);'
               .'requestAjax("'.$this->getTela()->getSId().'-form","NfItenPed","getDadosGridDetalhe","'.$oGridNotas->getId().'",chave);');
    }
    
    public function RelSaldoRep(){
        parent::criaTelaRelatorio();
        
        $this->setTituloTela('Saldo de pedidos');
        $this->setBTela(true); 
        
        $oCnpj = new Campo('Cliente','cnpj', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCnpj->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setBFocus(true);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oEmpresa = new Campo('Razão Social','cliente', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '','');
        $oEmpresa->addCampoBusca('empdes', '','');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod',$this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes',$oEmpresa->getId(),  $this->getTela()->getId());
        
        $oDataIni = new Campo('Data Inicial','dataini', Campo::TIPO_DATA,2);
        $oDataIni->setSValor('01/01/2016');
        $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim = new Campo('Data Final','datafim', Campo::TIPO_DATA,2);
        $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim->setSValor(date('d/m/Y'));
        
        $oOrdData1 = new Campo('Ordenação','orddata1', Campo::TIPO_RADIO,6);
        $oOrdData1->addItenRadio('desc','Por data de entrega decrescente');
        $oOrdData1->addItenRadio('asc','Por data de entrega crescente');
        
       
       
        $this->addCampos(array($oCnpj,$oEmpresa),$oDataIni,$oDataFim,$oOrdData1);
    }
}