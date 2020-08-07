<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewGerenContPagar extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Aponta pagamento de títulos');

        $oEmpcnpj = new Campo('', 'empcnpj', Campo::TIPO_TEXTO, 2);
        $oEmpcnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpcnpj->setBOculto(true);

        $oNfdoc = new Campo('Documento', 'nfdoc', Campo::TIPO_TEXTO, 1);
        $oNfdoc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfdoc->setBCampoBloqueado(true);

        $oNfserie = new Campo('Série', 'nfserie', Campo::TIPO_TEXTO, 1);
        $oNfserie->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNfserie->setBCampoBloqueado(true);

        $oContSeq = new Campo('Parcela', 'contseq', Campo::TIPO_TEXTO, 1);
        $oContSeq->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContSeq->setBCampoBloqueado(true);

        $oPescnpj = new Campo('Código Pessoa', 'Pessoa.pescnpj', Campo::TIPO_TEXTO, 2);
        $oPescnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPescnpj->setBCampoBloqueado(true);

        $oContValor = new Campo('Valor Parcela', 'contvlr', Campo::TIPO_MONEY, 2);
        $oContValor->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContValor->setBCampoBloqueado(true);
        $oContValor->setSTipoMoeda('R$');

        $oContVenc = new Campo('Vencimento', 'contvenc', Campo::TIPO_DATA, 2);
        $oContVenc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContVenc->setBCampoBloqueado(true);

        $oContSit = new Campo('Situação', 'contsit', Campo::TIPO_TEXTO, 2);
        $oContSit->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContSit->setBCampoBloqueado(true);

        $oContPagObs = new Campo('Observações de Pagamento', 'contpagobs', Campo::TIPO_EDITOR, 12);

        $oDataPaga = new Campo('Data do Pagamento', 'contdatapag', Campo::TIPO_DATA, 2);

        $oOrigFinan = new Campo('Financeiro', 'origcod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oOrigFinan->setBFocus(true);

        $oOrigDes = new Campo('Origem descrição', 'origdes', Campo::TIPO_BUSCADOBANCO, 4);
        $oOrigDes->setSIdPk($oOrigFinan->getId());
        $oOrigDes->setClasseBusca('OrigPag');
        $oOrigDes->addCampoBusca('origcod', '', '');
        $oOrigDes->addCampoBusca('origdes', '', '');
        //$oOrigDes->setApenasTela(true);

        $oOrigFinan->setClasseBusca('OrigPag');
        $oOrigFinan->setSCampoRetorno('origcod', $this->getTela()->getId());
        $oOrigFinan->addCampoBusca('origdes', $oOrigDes->getId(), $this->getTela()->getId());



        $oNfCnpj = new Campo('Código Pessoa', 'pescnpj', Campo::TIPO_BUSCADOBANCOPK, 2);

        $oEmpresa = new Campo('Razão Social', 'pesnome_razao', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oNfCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('pescnpj', '', '');
        $oEmpresa->addCampoBusca('pesnome_razao', '', '');

        $oNfCnpj->setClasseBusca('Pessoa');
        $oNfCnpj->setSCampoRetorno('pescnpj', $this->getTela()->getId());
        $oNfCnpj->addCampoBusca('pesnome_razao', $oEmpresa->getId(), $this->getTela()->getId());



        $this->addCampos(array($oPescnpj, $oNfdoc, $oNfserie, $oContSeq, $oEmpcnpj), array($oContValor, $oContVenc, $oContSit), array($oOrigFinan, $oOrigDes), $oDataPaga, $oContPagObs);
    }

    public function criaConsulta() {
        parent::criaConsulta();

        // $oEmpcnpj = new CampoConsulta('Empresa','empcnpj');
        $oNfdoc = new CampoConsulta('Documento', 'nfdoc');
        $oNfdoc->setILargura(50);
        $oNfserie = new CampoConsulta('Série', 'nfserie');
        $oNfserie->setILargura(25);
        $oPescnpj = new CampoConsulta('Código Pessoa', 'Pessoa.pescnpj');
        $oPescnpj->setILargura(50);

        $oPesrazao = new CampoConsulta('Fornecedor', 'Pessoa.pesnome_razao');
        $oPesrazao->setILargura(200);
        $oParcSeq = new CampoConsulta('Parc', 'contseq');
        $oParcSeq->setILargura(10);
        $oNfqValor = new CampoConsulta('Valor', 'contvlr', CampoConsulta::TIPO_MONEY);
        $oNfqValor->setILargura(100);

        $oVenc = new CampoConsulta('Vencimento', 'contvenc');
        $oVenc->setILargura(50);
        $oSitPag = new CampoConsulta('Situação', 'contsit');
        $oFiltroDoc = new Filtro($oNfdoc, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oSitPag->addComparacao('Sem pagamento', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oSitPag->addComparacao('Pago', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);

        $this->addCampos($oNfdoc, $oNfserie, $oPescnpj, $oPesrazao, $oParcSeq, $oNfqValor, $oVenc, $oSitPag);
        $this->addFiltro($oFiltroDoc);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Financeiro ', Dropdown::TIPO_PADRAO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG) . 'Aponta pagamento', 'GerenContPagar', 'acaoMostraTelaApontamentos', '', true, '', false, '', false, '', false, false);

        $oDropP2 = new Dropdown('Movimentação', Dropdown::TIPO_INFO);
        $oDropP2->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Retorna Pagamento', 'GerenContPagar', 'retornoPag', '', false, false, '', false, '', false, false);




        $this->addDropdown($oDrop1, $oDropP2);
    }

}
