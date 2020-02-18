<?php

/*
 * Classe que implementa as views STEEL_PCP_TabCabPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/02/2019
 */

class ViewSTEEL_PCP_TabCabPreco extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Tabela', 'nr');
        $oEmp = new CampoConsulta('Empresa', 'emp_codigo');
        $oEmpDes = new CampoConsulta('Razão', 'DELX_CAD_Pessoa.emp_razaosocial');
        $oTab = new CampoConsulta('Tabela', 'nometabela');
        $oNrfiltro = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);
        $oSit = new CampoConsulta('Situação', 'sit');
        $oSit->addComparacao('ATIVA', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSit->addComparacao('INATIVA', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oNrfiltro);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_TabCabPreco', 'acaoMostraRelConsulta', '', false, 'RelTabelaPreco', false, '', false, '', false, false);
        //$oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'SolPed', 'acaoMostraRelConsulta', '', false, '' . $sSolvenda . '');
        $this->addDropdown($oDrop1);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oNr, $oEmp, $oEmpDes, $oTab, $oSit);
    }

    public function criaTela() {
        parent::criaTela();
        $sAcao = $this->getSRotina();

        $oNr = new Campo('Tabela', 'nr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNr->setBCampoBloqueado(true);


        $oEmp_codigo = new Campo('Cliente', 'emp_codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcao == 'acaoAlterar') {
            $oEmp_codigo->setBCampoBloqueado(true);
        }

        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social', 'DELX_CAD_Pessoa.emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 5);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '', '');
        $oEmp_des->addCampoBusca('emp_razaosocial', '', '');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        if ($sAcao == 'acaoAlterar') {
            $oEmp_des->setBCampoBloqueado(true);
        }

        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial', $oEmp_des->getId(), $this->getTela()->getId());



        $oTab = new Campo('Tabela', 'nometabela', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oTab->setSCorFundo(Campo::FUNDO_VERDE);
        $oTab->addValidacao(false, Validacao::TIPO_STRING);

        $oLinha = new campo('', 'label1', Campo::TIPO_LINHA, 12);
        $oLinha->setApenasTela(true);

        $oUsuario = new campo('Usuário', 'usuarioCadastro', Campo::TIPO_TEXTO, 2);
        $oUsuario->setSValor($_SESSION['nome']);
        $oUsuario->setBCampoBloqueado(true);

        $oData = new campo('Data', 'data', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oData->setSValor(Util::getDataAtual());
        $oData->setBCampoBloqueado(true);

        $oSit = new campo('Situacao da tabela', 'sit', Campo::TIPO_SELECT, 3);
        $oSit->addItemSelect('ATIVA', 'ATIVA');
        $oSit->addItemSelect('INATIVA', 'INATIVA');

        $oConcaTena = new campo('Concatena referência ao insumo e serviço na nota fiscal de saída', 'concatena', Campo::TIPO_CHECK, 5, 5, 5, 5);

        //monta campo de controle para inserir ou alterar
        $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
        $oAcao->setApenasTela(true);
        if ($this->getSRotina() == View::ACAO_INCLUIR) {
            $oAcao->setSValor('incluir');
        } else {
            $oAcao->setSValor('alterar');
        }
        $this->setSIdControleUpAlt($oAcao->getId());

        $this->addCampos($oNr, array($oEmp_codigo, $oEmp_des), $oTab, $oLinha, array($oUsuario, $oData, $oAcao), $oSit, $oConcaTena);

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cria tabela', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens da tabela', false, $this->addIcone(Base::ICON_CONFIRMAR));
        $this->addEtapa($oEtapas);
    }

}
