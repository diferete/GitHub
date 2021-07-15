<?php

/*
 * Classe que implementa as ordens de fabricação steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class ViewSTEEL_PCP_GeraCertificado extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        //botao para a geração do certificado

        $oBotaoConsulta = new CampoConsulta('Gerar', 'emiteCert', CampoConsulta::TIPO_ACAO);
        $oBotaoConsulta->setSTitleAcao('Gerar Certificado da OP!');
        $oBotaoConsulta->addAcao('STEEL_PCP_Certificado', 'acaoMostraTelaIncluir', '', '');
        $oBotaoConsulta->setBHideTelaAcao(true);

        $oOp = new CampoConsulta('Op', 'op');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oCodigo = new CampoConsulta('Codigo', 'prod');
        $oProdes = new CampoConsulta('Descrição', 'prodes');
        $oQuant = new CampoConsulta('Qt.', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oSituacao = new CampoConsulta('Sit', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $oCliente = new CampoConsulta('Cliente', 'emp_razaosocial');
        $oCnpj = new CampoConsulta('Cnpj', 'emp_codigo');
        $oNotaEnt = new CampoConsulta('NotaEnt', 'documento');

        $oGeraCert = new CampoConsulta('Nr.Cert', 'nrcert');
        $oGeraCert->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, false, '');
        $oGeraCert->setBComparacaoColuna(true);




        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oDescricaoFiltro = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 3);

        $oDocFiltro = new Filtro($oNotaEnt, Filtro::CAMPO_TEXTO_IGUAL, 1);

        $oFilCnpj = new Filtro($oCnpj, Filtro::CAMPO_BUSCADOBANCOPK, 2);
        $oFilCnpj->setSClasseBusca('DELX_CAD_Pessoa');
        $oFilCnpj->setSCampoRetorno('emp_codigo', $this->getTela()->getSId());
        $oFilCnpj->setSIdTela($this->getTela()->getSId());

        $this->addFiltro($oOpFiltro, $oFilCnpj, $oCodigoFiltro, $oDescricaoFiltro, $oDocFiltro);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oBotaoConsulta, $oOp, $oGeraCert, $oSituacao, $oData, $oCodigo, $oProdes, $oQuant, $oCliente, $oNotaEnt);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Relatório Etiquetas', 'STEEL_PCP_GeraCertificado', 'acaoMostraRelCargaEtiquetas', '', false, 'RelRomaneioCarga', false, '', false, '', true, false);
        $this->addDropdown($oDrop1);

        $this->getTela()->setiAltura(750);
    }

}
