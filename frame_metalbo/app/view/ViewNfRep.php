<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewNfRep extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        //adiciona grid dos produtos
        $oGridItens = new Campo('Itens da Nota Fiscal', 'Itens Nf', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oNfsnfnro = new CampoConsulta('Nota Fiscal', 'nfsnfnro');
        $oNfsnfnro->setILargura(80);
        $oNfSitcod = new CampoConsulta('Código', 'nfsitcod');
        $oNfSitcod->setILargura(80);
        $oNfSitDes = new CampoConsulta('Descrição', 'nfsitdes');
        $oNfSitDes->setILargura(500);
        $oNfSitQtd = new CampoConsulta('Quant.', 'nfsitqtd', CampoConsulta::TIPO_DECIMAL);
        $oNfSitQtd->setILargura(70);
        $oVlrUnit = new CampoConsulta('Vlr. Unit', 'nfsitvlrun', CampoConsulta::TIPO_MONEY);
        $oVlrUnit->setILargura(100);
        $oTotal = new CampoConsulta('Total', 'nfsitvlrto', CampoConsulta::TIPO_MONEY);
        $oPedido = new CampoConsulta('Pedido', 'nfsitpdvnr');
        $oNfSeq = new CampoConsulta('Seq.', 'nfsitseq');
        $oNfSeq->setILargura(30);
        $oGridItens->addCampos($oNfsnfnro, $oNfSeq, $oNfSitcod, $oNfSitDes, $oNfSitQtd, $oVlrUnit, $oTotal, $oPedido);

        $oGridItens->setSController('NfRepIten');
        $oGridItens->addParam('nfsnfnro', '0');
        $oGridItens->getOGrid()->setIAltura(250);
        $oGridItens->getOGrid()->setBScrollInf(false);

        //campos abaixo do grid principal  
        $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);
        $oOrdens = new Campo('PEDIDOS', 'pedidoocobs', Campo::TIPO_TEXTO, 5);
        $oOrdens->setSCorFundo(Campo::FUNDO_AMARELO);
        $oAllOrdem = new Campo('ORDENS DE COMPRA', 'allod', Campo::TIPO_TEXTO, 5);
        $oAllOrdem->setSCorFundo(Campo::FUNDO_AMARELO);

        $this->getTela()->setIAltura(250);

        $oNf = new CampoConsulta('Nota', 'nfsnfnro', CampoConsulta::TIPO_LARGURA, 20);
        $oCliCod = new CampoConsulta('Cnpj', 'nfsclicod', CampoConsulta::TIPO_LARGURA, 20);
        $oCliente = new CampoConsulta('Cliente', 'nfsclinome', CampoConsulta::TIPO_LARGURA, 20);
        $oNfDataEmi = new CampoConsulta('Emissão', 'nfsdtemiss', CampoConsulta::TIPO_DATA);
        $oNfDataEmi->setILargura(30);
        $oHoraEmi = new CampoConsulta('Hora', 'nfshrsaida');
        $oHoraEmi->setILargura(40);
        $oTotal = new CampoConsulta('Total', 'nfsvlrtot', CampoConsulta::TIPO_MONEY);
        $oTotal->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oTotal->setBComparacaoColuna(true);
        $oTranome = new CampoConsulta('Transportador', 'nfstranome');
        $oPeso = new CampoConsulta('Peso', 'nfspesobr', CampoConsulta::TIPO_DECIMAL);

        //filtros
        $oFiltroNota = new Filtro($oNf, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);
        $oFiltroCliente = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oFiltroData = new Filtro($oNfDataEmi, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);
        $oFilCnpj = new Filtro($oCliCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12, false);
        $oFilCnpj->setSClasseBusca('Pessoa');
        $oFilCnpj->setSCampoRetorno('empcod', $this->getTela()->getSId());
        $oFilCnpj->setSIdTela($this->getTela()->getSId());
        $oFilCnpj->setBBuscaTela(true);
        $this->addFiltro($oFiltroNota, $oFiltroCliente, $oFilCnpj, $oFiltroData);

        $this->setBScrollInf(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","NfRep","camposGrid","' . $this->getTela()->getSId() . '"+","+chave+","+"' . $oOrdens->getId() . '"+","+"' . $oAllOrdem->getId() . '");'
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","NfRepIten","getDadosGridDetalhe","' . $oGridItens->getId() . '",chave);');


        $this->addCamposGrid($oOrdens, $oAllOrdem, $oLinhaWhite, $oGridItens);

        $this->addCampos($oNf, $oCliCod, $oCliente, $oNfDataEmi, $oHoraEmi, $oTotal, $oPeso);
        $this->getTela()->setIAltura(180);
    }

    public function RelRepFat() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Faturamento');
        $this->setBTela(true);

        $oCnpj = new Campo('Cliente', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2);
        // $oCnpj->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setBFocus(true);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpresa = new Campo('Razão Social', 'cliente', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());

        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        // $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2);
        // $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim->setSValor(date('d/m/Y'));

        $oOrdData1 = new Campo('Ordenação', 'orddata1', Campo::TIPO_RADIO, 6);
        $oOrdData1->addItenRadio('desc', 'Por data decrescente');
        $oOrdData1->addItenRadio('asc', 'Por data crescente');

        $oApresen = new Campo('Apresentação', 'apresen', Campo::TIPO_RADIO, 6);
        $oApresen->addItenRadio('valor', 'Valores');
        $oApresen->addItenRadio('peso', 'Peso');

        $oItens = new Campo('Listar Itens', 'itens', Campo::TIPO_CHECK, 6);

        $this->addCampos(array($oCnpj, $oEmpresa), $oDataIni, $oDataFim, $oOrdData1, $oApresen, $oItens);
    }

}
