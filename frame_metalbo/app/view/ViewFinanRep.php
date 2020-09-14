<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewFinanRep extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oRecDataEmi = new CampoConsulta('Data Emissão', 'recdtemiss', CampoConsulta::TIPO_DATA);
        $oRecDocto = new CampoConsulta('Nf/Série', 'recdocto');

        $this->addCampos($oRecDataEmi, $oRecDocto);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBTela(true);

        $oCnpj = new Campo('Cliente', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2);
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
        $oBtnBuscar = new Campo('Buscar', '', Campo::TIPO_BOTAOSMALL);

        //grid do financeiro

        $oGridFinan = new Campo('Títulos em aberto', 'gridFinan', Campo::TIPO_GRID, 12, 12, 12, 12, 150);

        $oDataEmi = new CampoConsulta('Emissão', 'recdtemiss', CampoConsulta::TIPO_DATA);
        $oDataEmi->setILargura(80);

        $oNfdoc = new CampoConsulta('Nf/Série', 'recdocto');
        $oNfdoc->setILargura(80);

        $oVenc = new CampoConsulta('Vencimento', 'recprdtpro', CampoConsulta::TIPO_DATA);
        $oVenc->setILargura(80);

        $oValor = new CampoConsulta('Valor', 'recprvlr', CampoConsulta::TIPO_MONEY);
        $oValor->setILargura(100);

        $oDias = new CampoConsulta('Dias para vencer', 'dias');
        $oDias->setILargura(120);
        $oDias->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oDias->addComparacao('0', CampoConsulta::COMPARACAO_MENOR, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, null);

        $oParc = new CampoConsulta('Parcela', 'recparnro');
        $oParc->setILargura(80);

        $oBanco = new CampoConsulta('Banco', 'bcodes');
        $oBanco->setILargura(80);

        $oHist = new CampoConsulta('Histórico', 'rechist');

        $oGridFinan->addCampos($oDataEmi, $oNfdoc, $oVenc, $oValor, $oDias, $oParc, $oBanco, $oHist);
        $oGridFinan->setSController('FinanRep');
        $oGridFinan->addParam('empcod', '0');
        $oGridFinan->getOGrid()->setSScrollInfCampo('criaConsultaGridFinan');
        $oGridFinan->getOGrid()->setSOrdemScrollInf('crescente');
        $oGridFinan->getOGrid()->setIaltura(280);

        $oGridTotal = new Campo('Total', 'total', Campo::TIPO_GRIDVIEW, 2, 2, 2, 2);
        $oGridTotal->addCabGridView('Total');
        $oGridTotal->addCabGridView('');
        $oGridTotal->addLinhasGridView(1, 'Em aberto');
        $oGridTotal->addLinhasGridView(1, '0');
        $oGridTotal->addLinhasGridView(2, 'Em atraso');
        $oGridTotal->addLinhasGridView(2, '0');

        $oAg = new Campo('Ag.Beneficiário.Carteira.Nosso Nr.', 'ag', Campo::TIPO_TEXTO, 3);
        $oAg->setSCorFundo(Campo::FUNDO_AZUL);

        $oCnpjCli = new Campo('Cnpj - Cliente', 'cnpjcli', Campo::TIPO_TEXTO, 2);
        $oCnpjCli->setSCorFundo(Campo::FUNDO_AZUL);

        $oNossoNr = new Campo('Nosso Número', 'nosso', Campo::TIPO_TEXTO, 2);
        $oNossoNr->setSCorFundo(Campo::FUNDO_VERDE);

        $oCnpjMatriz = new Campo('Cnpj METALBO', 'rex', Campo::TIPO_TEXTO, 2);
        $oCnpjMatriz->setSValor("75483040000130");

        $oBtnBuscar->addAcaoBotao('if ($("#' . $oCnpj->getId() . '").val()!== ""){'
                . 'requestAjax("' . $this->getTela()->getId() . '-form", "FinanRep", "getDadosGrid", "' . $oGridFinan->getId() . '", "criaConsultaGridFinan");'
                . '}'
                . 'if ($("#' . $oCnpj->getId() . '").val()!== ""){'
                . 'var empcod = $("#' . $oCnpj->getId() . '").val();'
                . 'requestAjax("' . $this->getTela()->getId() . '-form", "FinanRep", "somaTitulo", empcod + "," + "' . $oGridTotal->getId() . '"); '
                . '}');

        $oGridFinan->getOGrid()->setSEventoClick('var chave=""; $("#' . $oGridFinan->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();});'
                . 'requestAjax("","FinanRep","getDadosBoleto","' . $oGridFinan->getId() . '"+","+chave+","+"' . $oAg->getId() . '"+","+"' . $oCnpjCli->getId() . '"+","+"' . $oNossoNr->getId() . '");');

        $this->addCampos(array($oCnpj, $oEmpresa, $oBtnBuscar), $oGridFinan, array($oGridTotal, $oAg, $oCnpjCli, $oNossoNr, $oCnpjMatriz));
    }

    function criaConsultaGridFinan() {

        $oGridFinan = new Grid("");

        $oDataEmi = new CampoConsulta('Emissão', 'recdtemiss', CampoConsulta::TIPO_DATA);
        $oDataEmi->setILargura(80);

        $oNfdoc = new CampoConsulta('Nf/Série', 'recdocto');
        $oNfdoc->setILargura(80);

        $oVenc = new CampoConsulta('Vencimento', 'recprdtpro', CampoConsulta::TIPO_DATA);
        $oVenc->setILargura(80);

        $oValor = new CampoConsulta('Valor', 'recprvlr', CampoConsulta::TIPO_MONEY);
        $oValor->setILargura(100);

        $oDias = new CampoConsulta('Dias para vencer', 'dias');
        $oDias->setILargura(120);
        $oDias->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');
        $oDias->addComparacao('0', CampoConsulta::COMPARACAO_MENOR, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, '');

        $oParc = new CampoConsulta('Parcela', 'recparnro');
        $oParc->setILargura(80);

        $oBanco = new CampoConsulta('Banco', 'bcodes');

        $oHist = new CampoConsulta('Histórico', 'rechist');

        $oGridFinan->addCampos($oDataEmi, $oNfdoc, $oVenc, $oValor, $oDias, $oParc, $oBanco, $oHist);

        $aCampos = $oGridFinan->getArrayCampos();
        return $aCampos;
    }

    public function RelRepTituloAberto() {
        parent::criaTelaRelatorio();

        $aDados = $this->getAParametrosExtras();
        $aDados1 = $aDados[0];
        $aDados2 = $aDados[1];
        $aDados3 = $aDados[2];
        $aDados4 = $aDados[3];
        $aDados5 = $aDados[4];

        $this->setTituloTela('Títulos a receber em aberto');
        $this->setBTela(true);

        $oDivisor = new Campo('Vencimento', 'vencimento', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oDataIni = new Campo('Data inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oDataFim = new Campo('Data final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);



        $oAtraso = new Campo('Somente em atraso', 'atrasados', Campo::TIPO_CHECK, 1, 1, 12, 12);

        $oDivisor1 = new Campo('Cliente', 'cliente', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oEmpCod = new campo('CNPJ', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oEmpDes = new Campo('Empresa', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpDes->setSIdPk($oEmpCod->getId());
        $oEmpDes->setClasseBusca('Pessoa');
        $oEmpDes->addCampoBusca('empcod', '', '');
        $oEmpDes->addCampoBusca('empdes', '', '');
        $oEmpDes->setSIdTela($this->getTela()->getid());

        $oEmpCod->setClasseBusca('Pessoa');
        $oEmpCod->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oEmpCod->addCampoBusca('empdes', $oEmpDes->getId(), $this->getTela()->getId());

        $this->addCampos($oDivisor, array($oDataIni, $oDataFim, $oAtraso), $oDivisor1, array($oEmpCod, $oEmpDes));
    }

}
