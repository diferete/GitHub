<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 21/09/2018
 */

class ViewDELX_PRO_ProdutoFilialAlm extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oProCod = new CampoConsulta('Produto', 'DELX_PRO_Produtos.pro_codigo');
        $oFilCod = new CampoConsulta('Filial', 'DELX_FIL_Empresa.fil_fantasia');
        $oAlmTip = new CampoConsulta('Tipo do Almoxarifado', 'pro_filialAlmTipo');
        $oAlmCod = new CampoConsulta('Almoxarifado', 'pro_filialAlmCodigo');
        $oEstMin = new CampoConsulta('Estoque Mínimo', 'pro_filialAlmEstoqueMin');
        $oEstMax = new CampoConsulta('Estoque Máximo', 'pro_filialAlmEstoqueMax');
        $oProdfiltro = new Filtro($oProCod, Filtro::CAMPO_TEXTO, 5);
        
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oProdfiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oProCod,$oFilCod,$oAlmTip,$oAlmCod,$oEstMin, $oEstMax);
    }

    public function criaTela() {
        parent::criaTela();


        $oProCod = new Campo('Produto', 'DELX_PRO_Produtos.pro_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oProDes = new Campo('Descrição', 'DELX_PRO_Produtos.pro_descricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oFilCod = new Campo('Filial', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAlmTip = new Campo('Tipo do Almoxarifado', 'pro_filialAlmTipo', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oAlmTip->addItemSelect('E','Compras');
        $oAlmTip->addItemSelect('F','Faturamento');
        $oAlmTip->addItemSelect('P','Entrada de Produção');
        $oAlmTip->addItemSelect('B','Baixa na Produção');
        $oAlmTip->addItemSelect('M','Baixa na Manutenção');
       // $oAlmTip->addItemSelect(' ','Inspeção da Qualidade');
       // $oAlmTip->addItemSelect(' ','Regeitados da Qualidade'); //TERMINAR VERIFICAR AS SIGLAS A GRAVAR
        $oAlmTip->addItemSelect('G','Geral');
   
        //Almoxarifado
        $oAlmCod = new Campo('Almoxarifado','pro_filialAlmCodigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oAlmCod->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do almoxarifado adicionando o campo de busca
        $oAlmdes = new Campo('Descrição','est_almoxarifadodescricao',Campo::TIPO_BUSCADOBANCO, 4);
        $oAlmdes->setSIdPk($oAlmCod->getId());
        $oAlmdes->setClasseBusca('DELX_PRO_ProdutoFilialAlmTipo');
        $oAlmdes->addCampoBusca('est_almoxarifadocodigo', '','');
        $oAlmdes->addCampoBusca('est_almoxarifadodescricao', '','');
        $oAlmdes->setSIdTela($this->getTela()->getId());
        $oAlmdes->addValidacao(false, Validacao::TIPO_STRING);
        
        //declarar o campo descrição
        $oAlmCod->setClasseBusca('DELX_PRO_ProdutoFilialAlmTipo');
        $oAlmCod->setSCampoRetorno('est_almoxarifadocodigo',$this->getTela()->getId());
        $oAlmCod->addCampoBusca('est_almoxarifadodescricao',$oAlmdes->getId(),  $this->getTela()->getId());
        $oAlmdes->setApenasTela(true);

        $oEstMin = new Campo('Estoque Mínimo', 'pro_filialAlmEstoqueMin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEstMax = new Campo('Estoque Máximo', 'pro_filialAlmEstoqueMax', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        
        $this->addCampos(array($oProCod,$oProDes),$oFilCod,$oAlmTip,array($oAlmCod,$oAlmdes),$oEstMin, $oEstMax);
    }

}
