<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewRepItenVenda extends View {

    public function criaTela() {
        parent::criaTela();
        $this->setBTela(true);

        $oCnpj = new Campo('Cliente', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        // $oCnpj->addValidacao(false, Validacao::TIPO_STRING, '', '2');
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

        /* $oCodigo = new Campo('Código','codigo', Campo::TIPO_TEXTO,1);
          $oCodigo->setBFocus(true); */

        $oCodigo = new Campo('Codigo', 'codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodigo->setClasseBusca('Produto');
        $oCodigo->setSCampoRetorno('procod', $this->getTela()->getId());
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING, '', '2');


        $oBtnBuscar = new Campo('Buscar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);




        /* grid de consulta */
        $oGridItens = new Campo('Consulta venda por itens', 'gridItensVenda', Campo::TIPO_GRID, 12, 12, 12, 12, 350);

        $oNr = new CampoConsulta('Nr.Sol', 'nr');
        $oNr->setILargura(30);
        $oCnpjPesq = new CampoConsulta('Cnpj', 'cnpj');
        $oCliente = new CampoConsulta('Cliente', 'cliente');
        $oCliente->setILargura(380);
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oData->setILargura(80);
        $oQuant = new CampoConsulta('Quant', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oQuant->setILargura(100);
        $oVlrUnit = new CampoConsulta('Valor Unit.', 'vlrunit', CampoConsulta::TIPO_DECIMAL);
        $oVlrUnit->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oVlrUnit->setBComparacaoColuna(true);

        $oValorTot = new CampoConsulta('Valor Tot.', 'vlrtot', CampoConsulta::TIPO_MONEY);
        $oDcompra = new CampoConsulta('Od', 'odcompra');

        $oGridItens->addCampos($oNr, $oCnpjPesq, $oCliente, $oData, $oQuant, $oVlrUnit, $oValorTot, $oDcompra);
        $oGridItens->setSController('RepItenVenda');
        $oGridItens->addParam('empcod', '0');

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","RepItenVenda","getDadosGrid","' . $oGridItens->getId() . '","GridItensVenda");';
        $oBtnBuscar->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnBuscar->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oCodigo, $oCnpj, $oEmpresa, $oBtnBuscar), $oGridItens);
    }

    function GridItensVenda() {

        $oGridVenda = new Grid("");

        $oNr = new CampoConsulta('Nr.Sol', 'nr');
        $oCnpj = new CampoConsulta('Cnpj', 'cnpj');
        $oCliente = new CampoConsulta('Cliente', 'cliente');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oQuant = new CampoConsulta('Quant', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oVlrUnit = new CampoConsulta('Valor Unit.', 'vlrunit', CampoConsulta::TIPO_MONEY);
        $oVlrUnit->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oVlrUnit->setBComparacaoColuna(true);
        $oValorTot = new CampoConsulta('Valor Tot.', 'vlrtot', CampoConsulta::TIPO_MONEY);
        $oDcompra = new CampoConsulta('Od', 'odcompra');

        $oGridVenda->addCampos($oNr, $oCnpj, $oCliente, $oData, $oQuant, $oVlrUnit, $oValorTot, $oDcompra);

        $aCampos = $oGridVenda->getArrayCampos();
        return $aCampos;
    }

}
