<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewOd extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oEmp = new CampoConsulta('Empresa','empcnpj');
        $oOdnrj = new CampoConsulta('Número','odnr');
        $oOdnrj->setSOperacao('soma');
        $oOdnrj->setILargura(30);
        $oOdData = new CampoConsulta('Data','oddata');
        $oHora = new CampoConsulta('Hora', 'odhora');
        $oOdusuario = new CampoConsulta('Usuário', 'odusuario');
        $oCliente = new CampoConsulta('Cliente', 'Pessoa.pesnome_razao');
        $oOdTipo = new CampoConsulta('Tipo','odtipo');
        $oContato = new CampoConsulta('Contato', 'odcontato');
        $oOdSit = new CampoConsulta('Situação','odsit');
        
        $this->addCampos($oOdnrj,$oOdTipo,$oCliente,$oContato,$oOdSit,$oOdData);
        
        $this->setUsaAcaoVisualizar(true);
        
        $oContatoFiltro = new Filtro($oContato,  Campo::TIPO_TEXTO,3);
        $oOdNr = new Filtro($oOdnrj,  Campo::TIPO_TEXTO,2);
        
        $oOdSit->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA, false, '');
        $oOdSit->addComparacao('Encerrada sem Faturamento', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AMARELO,CampoConsulta::MODO_COLUNA, false, '');
        $oOdSit->addComparacao('Lib. Faturamento', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA, false, '');
        $oOdSit->setBComparacaoColuna(true);
        
        $oOdTipo->addComparacao('Pedido de venda', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA, false, '');//Ordem de serviço
        $oOdTipo->addComparacao('Ordem de serviço', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA, false, '');
        $oOdTipo->addComparacao('Cotação', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AMARELO,CampoConsulta::MODO_COLUNA, false, '');
        
        $oOdTipo->setBComparacaoColuna(true);
        
        $oClienteF = new Filtro($oCliente,  Campo::TIPO_TEXTO,3);
        
        $this->addFiltro($oClienteF,$oContatoFiltro,$oOdNr);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Movimentação', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG).'Libera Faturamento','Od', 'liberaFat', '',false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_DELETAR).'Encerra sem Faturamento','Od', 'fechaOdmsg', '',false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_DESBLOQUEADO).'Retorna situação','Od', 'retAbertaMsg', '',false);
        
        $oDrop2 = new Dropdown('Vizualizar', Dropdown::TIPO_PRIMARY);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_CONFIG).'Vizualizar Ordem','Od', 'acaoMostraRelConsulta', '',false,'mostraordem');
        
        
        $this->addDropdown($oDrop1,$oDrop2);
        $this->setUsaAcaoExcluir(false);
    }
    
    public function criaTela() {
        parent::criaTela();
        
       
        $this->setTituloTela('Pedidos de venda - Ordem de serviços - Cotação');
        $oEmp = new Campo('','empcnpj', Campo::TIPO_TEXTO,2);
        $oEmp->setSValor('21804925000165');
        $oEmp->setBCampoBloqueado('true');
        $oEmp->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmp->setBOculto(true);
        
        $oOdnrj = new Campo('Ordem','odnr',  Campo::TIPO_TEXTO,1);
        $oOdnrj->setBCampoBloqueado(true);
        $oOdnrj->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oOdData = new Campo('Data','oddata', Campo::TIPO_DATA,2);
        $oOdData->setSValor(date('d/m/Y'));
        
        $oHora = new Campo('Hora', 'odhora',  Campo::TIPO_TEXTO,1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        $oHora->setBTime(true);
        $oHora->setSValor(date('H:i:s'));
        
        $oOdusuario = new Campo('Usuário', 'odusuario');
        $oOdusuario->setSValor($_SESSION['nome']);
        $oOdusuario->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdusuario->setBCampoBloqueado(true);
        
        $oOdCnpj = new Campo('Código Pessoa','Pessoa.pescnpj', Campo::TIPO_BUSCADOBANCOPK,2);
        $oOdCnpj->setBFocus(true);
        $oOdCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oRazao = new Campo('Razão Social','Pessoa.pesnome_razao', Campo::TIPO_BUSCADOBANCO, 4);
        $oRazao->setSIdPk($oOdCnpj->getId());
        $oRazao->setClasseBusca('Pessoa');
        $oRazao->addCampoBusca('pescnpj', '','');
        $oRazao->addCampoBusca('pesnome_razao', '','');
       // $oRazao->setApenasTela(true);
        $oRazao->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oOdCnpj->setClasseBusca('Pessoa');
        $oOdCnpj->setSCampoRetorno('pescnpj',$this->getTela()->getId());
        $oOdCnpj->addCampoBusca('pesnome_razao',$oRazao->getId(),  $this->getTela()->getId());
        
        $oOdTipo = new Campo('Tipo','odtipo', Campo::TIPO_SELECT,3);
        $oOdTipo->addItemSelect('Pedido de venda', 'Pedido de Venda');
        $oOdTipo->addItemSelect('Ordem de serviço', 'Ordem de Serviço');
        $oOdTipo->addItemSelect('Cotação','Cotação');
        
        $oOdSit = new Campo('Situação','odsit', Campo::TIPO_TEXTO,2);
        $oOdSit->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOdSit->setSValor('Aberta');
        $oOdSit->setBCampoBloqueado(true);
        
        $oContato= new Campo('Contato','odcontato',  Campo::TIPO_TEXTO,3);
        
        $oObsSol = new Campo('Solução / Observação / Fechamento','odser_sol',  Campo::TIPO_TEXTAREA,10);
        
        $oFieldServico = new FieldSet('Ordem de Serviço');
         
        $oOdSer_equi = new Campo('Descrição do equipamento','odser_equip',  Campo::TIPO_TEXTAREA,6);
        
        $oOdser_problema = new Campo('Problema apresentado','odser_problema',  Campo::TIPO_TEXTAREA,6);
        
        $oOdPag = new Campo('Condição','CondPag.condcod',  Campo::TIPO_BUSCADOBANCOPK,2);
        $oOdPag->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oConPagDes = new Campo('Pagamento','CondPag.conddes',  Campo::TIPO_BUSCADOBANCO,4);
        $oConPagDes->setSIdPk($oOdPag->getId());
        $oConPagDes->setClasseBusca('CondPag');
        $oConPagDes->addCampoBusca('condcod', '','');
        $oConPagDes->addCampoBusca('conddes', '','');
        $oConPagDes->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $oOdPag->setClasseBusca('CondPag');
        $oOdPag->setSCampoRetorno('condcod',$this->getTela()->getId());
        $oOdPag->addCampoBusca('conddes',$oConPagDes->getId(),  $this->getTela()->getId());
       
        $oEtapas = new FormEtapa(2,2,2,2);
        $oEtapas->addItemEtapas('Ordem - Serviço - Venda - Orçamento',true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens ',false,  $this->addIcone(Base::ICON_CONFIRMAR));
        
        $this->addEtapa($oEtapas);
        
        $oFieldServico->addCampos(array($oOdSer_equi,$oOdser_problema),$oObsSol);
        
        $this->addCampos(array($oOdnrj,$oOdData,$oHora,$oOdSit,$oEmp),array($oOdCnpj,$oRazao,$oOdTipo),$oContato,$oFieldServico,array($oOdPag,$oConPagDes),$oOdusuario);
        
        
    }
    /**
     * Mostra ordem de serviço
     */
    public function mostraOrdem(){
        parent::criaTelaRelatorio();
        
    }
}