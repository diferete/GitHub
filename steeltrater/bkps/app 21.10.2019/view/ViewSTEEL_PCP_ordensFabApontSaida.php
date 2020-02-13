<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 25/07/2018
 */

class ViewSTEEL_PCP_ordensFabApontSaida extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oBotaoFinalizar = new CampoConsulta('Apont.','finalizar', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setSTitleAcao('Finalizar apontamento!');
        $oBotaoFinalizar->addAcao('STEEL_PCP_ordensFabApontSaida','msgFinalizaOP'); //finalizaOP Controller
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(30);
        
        $oBotaoModal = new CampoConsulta('','apontar', CampoConsulta::TIPO_MODAL);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        
        $oOp = new CampoConsulta('OP', 'op');
        $oProdes = new CampoConsulta('Produto', 'prodes');
        $oProdes->setILargura(300);
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oDtent = new CampoConsulta('Data entrada', 'dataent_forno', CampoConsulta::TIPO_DATA);
        $oHentr = new CampoConsulta('Hora entrada', 'horaent_forno', CampoConsulta::TIPO_TIME);
        $oDtsaid = new CampoConsulta('Data saída', 'datasaida_forno', CampoConsulta::TIPO_DATA);
        $oHsaida = new CampoConsulta('Hora saída', 'horasaida_forno', CampoConsulta::TIPO_TIME);
        $oForno = new CampoConsulta('Forno','fornodes');
        $oSituaca = new CampoConsulta('Situação','situacao');
        $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
        $oSituaca->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        $oSituaca2 = new CampoConsulta('','situacao');
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oSitFiltro = new Filtro($oSituaca2, Filtro::CAMPO_SELECT, 2,2,12,12);
        $oSitFiltro->addItemSelect('Processo', 'Processo');
        $oSitFiltro->addItemSelect('Todos', 'Todos');
        $oSitFiltro->addItemSelect('Finalizado', 'Finalizado');
        
        //mostra os filtros
        $this->getTela()->setBMostraFiltro(true);
        $this->getTela()->setIAltura(600);
       

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oOpFiltro,$oSitFiltro);
        
        /**
         * define o filtro inicial
         */
        $aInicial[0]='situacao,Processo';
        $this->getTela()->setAParametros($aInicial);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Ações',Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Retornar Apontamento', 'STEEL_PCP_OrdensFabApontSaida', 'msgRetornaApontSaida', '', false, '');
               
        $this->addDropdown($oDrop1);

        $this->setBScrollInf(false);
        $this->addCampos($oBotaoFinalizar,$oOp,$oProdes,$oDtent,$oHentr,$oDtsaid,$oHsaida,$oForno,$oSituaca,$oSeq);
    }

}
