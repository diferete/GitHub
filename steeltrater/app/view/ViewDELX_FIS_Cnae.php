<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 16/11/2018
 */

class ViewDELX_FIS_Cnae extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.CNAE', 'FIS_CNAECodigo');
        $oDes = new CampoConsulta('Descrição CNAE', 'FIS_CNAEDescricao');
        $oRet = new CampoConsulta('Retenção', 'FIS_CNAERetencao');
        $oDescricaofiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5);
       
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod,$oDes,$oRet);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new CampoConsulta('Cod.CNAE', 'FIS_CNAECodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new CampoConsulta('Descrição CNAE', 'FIS_CNAEDescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRet = new CampoConsulta('Retenção', 'FIS_CNAERetencao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        
        $this->addCampos(array($oCod,$oDes,$oRet));
    }

}
