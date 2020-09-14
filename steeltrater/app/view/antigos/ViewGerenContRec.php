<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewGerenContRec extends View{
    
    
    
      public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmpCnpj = new CampoConsulta('', 'empcnpj');
        $oPescnpj = new CampoConsulta('Código Pessoa','Pessoa.pescnpj');
        $oPerazao_nome = new CampoConsulta('Nome','Pessoa.pesnome_razao');
        $oRecDoct = new CampoConsulta('Documento','recdocto');
        $oRecparc = new CampoConsulta('Parcela','recparc');
        $oRecVlr =  new CampoConsulta('Valor','recparcvlr');
        $oRecVenc =  new CampoConsulta('Vencimento','recparcvenc');
        $oRecSit = new CampoConsulta('Situação','recsit');
        $oRecSit->addComparacao('Em aberto', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $oRecSit->addComparacao('Pago', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oRecSit->setBComparacaoColuna(true);
        
         $this->setUsaDropdown(true);
         $oDrop1 = new Dropdown('Movimentações', Dropdown::TIPO_SUCESSO);
         $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG).'Aponta pagamento','GerenContRec', 'acaoMostraTelaApontamentos', '',true);
        
        $this->addCampos($oPescnpj,$oPerazao_nome,$oRecSit,$oRecDoct,$oRecparc,$oRecVlr,$oRecVenc);
        $this->addDropdown($oDrop1);
        
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        
        $oFiltroCli = new Filtro($oPerazao_nome,  Campo::TIPO_TEXTO,3);
        $this->addFiltro($oFiltroCli);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Aponta pagamento do título');
        
        $oEmpCnpj = new Campo('Empresa','empcnpj',  Campo::TIPO_TEXTO,2);
        $oEmpCnpj->setSValor('21804925000165');
        $oEmpCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpCnpj->setBCampoBloqueado(true);
        
        $oPescnpj = new Campo('Pessoa','Pessoa.pescnpj', Campo::TIPO_TEXTO,2);
        $oPescnpj->setSValor('21804925000165');
        $oPescnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPescnpj->setBCampoBloqueado(true);
        
        $oPesRazao = new Campo('Nome','Pessoa.pesnome_razao', Campo::TIPO_TEXTO,3);
        $oPesRazao->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPesRazao->setBCampoBloqueado(true);
        
        $oRecDocto = new Campo('Documento','recdocto',  Campo::TIPO_TEXTO,1);
        $oRecDocto->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecDocto->setBCampoBloqueado(true);
        
        $oRecParc = new campo('Parcela','recparc',  Campo::TIPO_TEXTO,1);
        $oRecParc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecParc->setBCampoBloqueado(true);
        
        $oValor = new Campo('Valor','recparcvlr',  Campo::TIPO_MONEY,2);
        $oValor->setITamanho(Campo::TAMANHO_PEQUENO);
        $oValor->setBCampoBloqueado(true);
        $oValor->setSTipoMoeda('R$');
        
        $oRecvenc = new Campo('Vencimento','recparcvenc',  Campo::TIPO_DATA,2);
        $oRecvenc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecvenc->setBCampoBloqueado(true);
        
        $oRecObs = new Campo('Observação do título','recobs', Campo::TIPO_TEXTAREA,5);
        $oRecObs->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecObs->setBCampoBloqueado(true);
        
        $oDataPag = new Campo('Data Pagamento','recdatapag',  Campo::TIPO_DATA,2);
        $oDataPag->setSValor(date('Y/m/d'));
        
        $oSit = new Campo('Situação','recsit',  Campo::TIPO_TEXTO,2);
        $oSit->setITamanho(Campo::TAMANHO_PEQUENO);
        $oSit->setBCampoBloqueado(true);
        
        $oObsPag = new Campo('Observação de pagamento','recobspag', Campo::TIPO_TEXTAREA,5);
        
        $oUser = new Campo('Usuário','recuserapont',  Campo::TIPO_TEXTO,3);
        $oUser->setITamanho(Campo::TAMANHO_PEQUENO);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
        
        $this->addCampos(array($oEmpCnpj,$oPescnpj,$oPesRazao),array($oRecDocto,$oRecParc,$oValor),$oRecvenc,$oRecObs,
                $oDataPag,$oSit,$oObsPag,$oUser);
    }
}