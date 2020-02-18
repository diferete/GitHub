<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class ViewSTEEL_PCP_ProdReceita extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Codigo', 'pro_codigo');
        $oCod->setILargura(100);
        $oRes = new CampoConsulta('Receita', 'cod_receita');
        $oCodfiltro = new Filtro($oCod, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);


        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodfiltro);

        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oCod, $oRes);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Código', 'pro_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCod->addValidacao(false, Validacao::TIPO_STRING);
        $oCod->setClasseBusca('DELX_PRO_Produtos');
        $oCod->setSCampoRetorno('pro_codigo', $this->getTela()->getId());

        $oRes = new Campo('Material', 'cod_receita', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oRes->addValidacao(false, Validacao::TIPO_STRING);
        $oRes->setClasseBusca('STEEL_PCP_material');
        $oRes->setSCampoRetorno('matcod', $this->getTela()->getId());




        $this->addCampos(array($oCod, $oRes));
    }

}
