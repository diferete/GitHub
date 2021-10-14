<?php

/*
 * Implementa a classe view STEEL_SOL_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ViewSTEEL_SOL_Aprovacoes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oFilCod = new CampoConsulta('CNPJ', 'FIL_Codigo');

        $oSeqSol = new CampoConsulta('Seq.', 'SUP_SolicitacaoSeq');

        $oBotaoGerencia = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_APONTAR);
        $oBotaoGerencia->setBHideTelaAcao(true);
        $oBotaoGerencia->setILargura(15);
        $oBotaoGerencia->setSTitleAcao('Gerenciar');
        $oBotaoGerencia->addAcao('STEEL_SOL_Aprovacoes', 'criaTelaModalGerenciaSolicitacao', 'criaModalGerenciaSolicitacao', '');
        $this->addModais($oBotaoGerencia);

        $oBtnItens = new CampoConsulta('', '', CampoConsulta::TIPO_MVC, CampoConsulta::ICONE_MARTELO);
        $oBtnItens->addDadosConsultaMVC('STEEL_SOL_AprovacoesItens', 'TelaVisualizaItens', 'Visualizar itens!');
        $oBtnItens->setILargura(15);

        $oTipoSol = new CampoConsulta('Tipo', 'SUP_SolicitacaoTipo');

        $oSitSol = new CampoConsulta('Situacao', 'SUP_SolicitacaoSituacao');
        $oSitSol->addComparacao('M', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, true, 'EM MONTAGEM');
        $oSitSol->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, true, 'EM ABERTO');
        $oSitSol->addComparacao('L', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, true, 'LIBERADO');
        $oSitSol->addComparacao('O', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_COLUNA, true, 'EM COMPRAS');
        $oSitSol->addComparacao('C', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, true, 'CANCELADO');
        $oSitSol->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_BLACK, CampoConsulta::MODO_COLUNA, true, 'ENCERRADO');
        $oSitSol->addComparacao('R', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'REPROVADO');
        $oSitSol->setBComparacaoColuna(true);

        $oUsuSol = new CampoConsulta('UsuCadastro', 'SUP_SolicitacaoUsuCadastro');

        $oDataHoraSol = new CampoConsulta('Data', 'SUP_SolicitacaoDataHora', CampoConsulta::TIPO_DATA);

        $oObsSol = new CampoConsulta('Observacao', 'SUP_SolicitacaoObservacao');

        $oFilSeqSol = new Filtro($oSeqSol, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oFilData = new Filtro($oDataHoraSol, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oFilUsuSol = new Filtro($oUsuSol, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);

        $oFilSitSol = new Filtro($oSitSol, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilSitSol->addItemSelect('', 'Todos');
        $oFilSitSol->addItemSelect('A', 'Em aberto');
        $oFilSitSol->addItemSelect('L', 'Liberado');
        $oFilSitSol->addItemSelect('O', 'Em compras');
        $oFilSitSol->addItemSelect('C', 'Cancelado');
        $oFilSitSol->addItemSelect('E', 'Encerrado');
        $oFilSitSol->addItemSelect('R', 'Reprovado');
        $oFilSitSol->setSLabel('');

        $this->addFiltro($oFilSeqSol, $oFilData, $oFilUsuSol, $oFilSitSol);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_SUP_Solicitacao', 'acaoMostraRelEspecifico', '', false, 'OpSteel1', false, '', false, '', true, false);
        $this->addDropdown($oDrop1);

        $this->addCampos($oFilCod, $oSeqSol, $oBotaoGerencia, $oBtnItens, $oTipoSol, $oSitSol, $oUsuSol, $oDataHoraSol, $oObsSol);
    }

    public function criaTela() {
        parent::criaTela();
    }

    public function criaModalGerenciaSolicitacao() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('CNPJ', 'cnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($oDados->getFIL_Codigo());
        $oEmpresa->setBCampoBloqueado(true);

        $oSolSeq = new Campo('Sol.', 'nrsol', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSolSeq->setSValor($oDados->getSUP_SolicitacaoSeq());
        $oSolSeq->setBCampoBloqueado(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);

        //botão inserir os dados
        $oBtnAprova = new Campo('Aprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenSolicitacaoCompra","A,S");';
        $oBtnAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBtnAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);

        //botão inserir os dados
        $oBtnReprova = new Campo('Reprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenSolicitacaoCompra","R,S");';
        $oBtnReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBtnReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);



        $this->addCampos(array($oEmpresa, $oSolSeq), array($oBtnAprova, $oBtnReprova), $oUsunome);
    }

}
