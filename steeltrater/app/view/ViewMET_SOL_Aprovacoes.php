<?php

/*
 * Implementa a classe view MET_SOL_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ViewMET_SOL_Aprovacoes extends View {

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
        $this->getTela()->setiAltura(800);

        $oFilcgc = new CampoConsulta('CNPJ', 'filcgc');

        $oSeqSol = new CampoConsulta('Nr', 'solcod');

        $oBotaoGerencia = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_MARTELO);
        $oBotaoGerencia->setBHideTelaAcao(true);
        $oBotaoGerencia->setILargura(15);
        $oBotaoGerencia->setSTitleAcao('Gerenciar');
        $oBotaoGerencia->addAcao('MET_SOL_Aprovacoes', 'criaTelaModalMetGerenciaSolicitacao', 'criaModalMetGerenciaSolicitacao', '');
        $this->addModais($oBotaoGerencia);

        $oBtnItens = new CampoConsulta('', '', CampoConsulta::TIPO_MVC, CampoConsulta::ICONE_APONTAR);
        $oBtnItens->addDadosConsultaMVC('MET_SOL_AprovacoesItens', 'TelaVisualizaItens', 'Visualizar itens!');
        $oBtnItens->setILargura(15);

        $oSitSol = new CampoConsulta('Situacao', 'solsituaca');
        $oSitSol->addComparacao('I', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, true, 'IMPLANTADA');
        $oSitSol->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_COLUNA, true, 'APROVADA');
        $oSitSol->addComparacao('R', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'REPROVADA');
        $oSitSol->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_BLACK, CampoConsulta::MODO_COLUNA, true, 'AGUARDAR');
        $oSitSol->addComparacao('B', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, true, 'ENTREGUE');
        $oSitSol->setBComparacaoColuna(true);

        $oUsuSol = new CampoConsulta('Solicitante', 'solususoli');

        $oDataHoraSol = new CampoConsulta('Data', 'soldata', CampoConsulta::TIPO_DATA);

        $oObsSol = new CampoConsulta('Observacao', 'solobs');

        $oFilFilcgc = new Filtro($oFilcgc, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilFilcgc->addItemSelect('', 'Todas as Empresas');
        $oFilFilcgc->addItemSelect('75483040000211', 'Filial');
        $oFilFilcgc->addItemSelect('75483040000130', 'Matriz');
        $oFilFilcgc->setSLabel('');

        $oFilSitSol = new Filtro($oSitSol, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilSitSol->addItemSelect('', 'Todas as Situações');
        $oFilSitSol->addItemSelect('I', 'IMPLANTADA');
        $oFilSitSol->addItemSelect('A', 'APROVADA');
        $oFilSitSol->addItemSelect('R', 'REPROVADA');
        $oFilSitSol->addItemSelect('E', 'AGUARDAR');
        $oFilSitSol->addItemSelect('B', 'ENTREGUE');
        $oFilSitSol->setSLabel('');

        $oFilSeqSol = new Filtro($oSeqSol, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);

        $oFilUsuSol = new Filtro($oUsuSol, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oFilData = new Filtro($oDataHoraSol, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);



        $this->addFiltro($oFilFilcgc, $oFilSitSol, $oFilSeqSol, $oFilData, $oFilUsuSol);

        /*
          $this->setUsaDropdown(true);
          $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
          $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_SUP_Solicitacao', 'acaoMostraRelEspecifico', '', false, 'OpSteel1', false, '', false, '', true, false);
          $this->addDropdown($oDrop1); */

        $this->addCampos($oFilcgc, $oSeqSol, $oBotaoGerencia, $oBtnItens, $oSitSol, $oUsuSol, $oDataHoraSol, $oObsSol);
    }

    public function criaTela() {
        parent::criaTela();
    }

    public function criaModalMetGerenciaSolicitacao() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('CNPJ', 'cnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($oDados->getFilcgc());
        $oEmpresa->setBCampoBloqueado(true);

        $oSolSeq = new Campo('Sol.', 'nrsol', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSolSeq->setSValor($oDados->getSolcod());
        $oSolSeq->setBCampoBloqueado(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);

        //botão inserir os dados
        $oBtnAprova = new Campo('Aprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenMetSolicitacaoCompra","A,S");';
        $oBtnAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBtnAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);

        //botão inserir os dados
        $oBtnReprova = new Campo('Reprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenMetSolicitacaoCompra","R,S");';
        $oBtnReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBtnReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);

        $this->addCampos(array($oEmpresa, $oSolSeq), array($oBtnAprova, $oBtnReprova), $oUsunome);
    }

}
