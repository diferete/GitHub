<?php

/*
 * View da classe para liberar media de preço
 * @author Avanei Martendal
 * @since 25/07/2016
 */

class ViewAutSolCot extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setaTiluloConsulta('Autorização de preço por KG');

        $oId = new CampoConsulta('Id', 'id');
        $oNr = new CampoConsulta('Nr', 'nr');
        $oTipo = new CampoConsulta('Tipo', 'tipo');
        $oEmpcod = new CampoConsulta('Empresa', 'Pessoa.empcod');
        $oEmpDes = new CampoConsulta('', 'Pessoa.empdes');
        //$oMedia = new CampoConsulta('Média', 'media',  CampoConsulta::TIPO_MONEY);
        $oCodRep = new CampoConsulta('Representante', 'codrep');

        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 1, 1, 12, 12, false);
        $oFiltroRep = new Filtro($oCodRep, Filtro::CAMPO_INTEIRO, 1, 1, 12, 12, false);

        $this->addCampos($oId, $oNr, $oEmpcod, $oEmpDes, $oTipo, $oCodRep);
        $this->addFiltro($oFiltroNr, $oFiltroRep);
        $this->setUsaAcaoAlterar(false);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Liberar preço por kg');

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setITamanho(Campo::TAMANHO_PEQUENO);

        $oTipo = new Campo('Tipo de documento', 'tipo', Campo::TIPO_SELECT, 4);
        $oTipo->addItemSelect('pedido', 'Solicitação de pedido de venda');
        $oTipo->addItemSelect('cotacao', 'Cotação de venda');
        $oTipo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCnpj = new Campo('Cliente', 'Pessoa.empcod', Campo::TIPO_BUSCADOBANCOPK, 3);
        $oCnpj->addValidacao(false, Validacao::TIPO_INTEIRO, '', '2', '15');
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);

        $oEmpresa = new Campo('Razão Social', 'razão', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->setApenasTela(true);
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);


        /* definir sempre código pk e descrição */
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());







        $oMedia = new Campo('', 'media', Campo::TIPO_TEXTO, 1);
        $oMedia->setITamanho(Campo::TAMANHO_PEQUENO);
        $oMedia->setSValor('1');
        $oMedia->setBOculto(true);

        $oCodRep = new Campo('Codigo', 'codrep', Campo::TIPO_TEXTO, 1);
        $oCodRep->setITamanho(Campo::TAMANHO_PEQUENO);

        $oRepDes = new campo('Representante', 'repdes', Campo::TIPO_TEXTO, 2);

        $oEmpresa->addEvento(Campo::EVENTO_SAIR, 'var oCnpj=$("#' . $oCnpj->getId() . '").val(); requestAjax("","SolPed","carregaRep","' . $oCodRep->getId() . ',' . $oRepDes->getId() . ',"+oCnpj+"","");');

        $this->addCampos($oNr, array($oCnpj, $oEmpresa), array($oCodRep, $oRepDes), $oTipo, $oMedia);
    }

}
