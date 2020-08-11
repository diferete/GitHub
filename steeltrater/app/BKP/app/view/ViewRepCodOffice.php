<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewRepCodOffice extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        
        $oFilcgc = new CampoConsulta('Empresa do Escritório', 'filcgc');
        $officecod = new CampoConsulta('Escritório', 'officecod');
        $officeseq = new CampoConsulta('Seq.', 'officeseq');
        $oRepcod = new CampoConsulta('Representante', 'repcod');
        $oRespVendaCod = new CampoConsulta('VendasCod', 'resp_venda_cod');
        $oRespVendaNome = new CampoConsulta('VendasNome', 'resp_venda_nome');

        $oRepcodF = new Filtro($oRepcod, Filtro::CAMPO_TEXTO_IGUAL, 2);

        $oEscritorio = new Filtro($officecod, Filtro::CAMPO_TEXTO_IGUAL, 1);

        $oFilVendaNome = new Filtro($oRespVendaNome, Filtro::CAMPO_TEXTO, 2);

        $this->addFiltro($oRepcodF, $oEscritorio, $oFilVendaNome);

        $this->addCampos($officecod, $oRepcod, $oFilcgc, $officeseq, $oRespVendaCod, $oRespVendaNome);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de códigos de representantes por escritório');
        $officecod = new Campo('Código do Escritório', 'officecod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $officecod->setSIdHideEtapa($this->getSIdHideEtapa());
        $officecod->setITamanho(Campo::TAMANHO_PEQUENO);
        $officecod->setBFocus(true);
        $officecod->addValidacao(false, Validacao::TIPO_STRING);


        $officecod->setClasseBusca('RepOffice');
        $officecod->setSCampoRetorno('officecod', $this->getTela()->getId());

        $oFilcgc = new Campo('Empresa do Escritório', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFilcgc->setSIdHideEtapa($this->getSIdHideEtapa());
        $oFilcgc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oFilcgc->addValidacao(false, Validacao::TIPO_STRING);

        $oFilcgc->setClasseBusca('RepOffice');
        $oFilcgc->setSCampoRetorno('EmpRex.filcgc', $this->getTela()->getId());

        $officeseq = new Campo('Seq.', 'officeseq', Campo::TIPO_TEXTO, 1);
        $officeseq->setBCampoBloqueado(true);

        $oRepcod = new Campo('Código Representante', 'repcod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oRepcod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oRepcod->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRepcod->addValidacao(false, Validacao::TIPO_STRING);

        $oRepcod->setClasseBusca('Repcod');
        $oRepcod->setSCampoRetorno('repcod', $this->getTela()->getId());

        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRespVenda->setBFocus(true);
        $oRespVenda->setSValor($aDadosTela[0]);


        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespVendaNome->setSIdPk($oRespVenda->getId());
        $oRespVendaNome->setClasseBusca('User');
        $oRespVendaNome->addCampoBusca('usucodigo', '', '');
        $oRespVendaNome->addCampoBusca('usunome', '', '');
        $oRespVendaNome->setSIdTela($this->getTela()->getid());
        $oRespVendaNome->setSValor($aDadosTela[1]);


        $oRespVenda->setClasseBusca('User');
        $oRespVenda->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oRespVenda->addCampoBusca('usunome', $oRespVendaNome->getId(), $this->getTela()->getId());


        $this->addCampos($officeseq, array($officecod, $oFilcgc), $oRepcod, array($oRespVenda, $oRespVendaNome));
    }

}
