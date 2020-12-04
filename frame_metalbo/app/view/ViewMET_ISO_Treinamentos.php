<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_Treinamentos extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setSId('GridTreinamentos');

        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setSOperacao('personalizado');
        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oCracha = new CampoConsulta('Crachá', 'cracha');
        $oNome = new CampoConsulta('Colaborador', 'nome');
        $oSit = new CampoConsulta('Sit', 'situacao');
        $oSetor = new CampoConsulta('Setor', 'descsetor');
        $oFuncao = new CampoConsulta('Função', 'funcao');

        $oTagEsc = new CampoConsulta('...', 'tagEscolaridade');
        $oTagEsc->addComparacao('I', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_LARANJA, CampoConsulta::MODO_LINHA, false, null);
        $oTagEsc->setBColOculta(true);

        $oTagTreinamento = new CampoConsulta('Necessita Trenamento?', 'tagTreinamento');
        $oTagTreinamento->addComparacao('S', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, true, 'Sim');
        $oTagTreinamento->addComparacao('N', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Não');
        $oTagTreinamento->setBComparacaoColuna(true);


        $oFilNr = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 1, 1, 12, 12, false);
        $oFilFilcgc = new Filtro($oFilcgc, Filtro::CAMPO_INTEIRO, 2, 2, 12, 12, false);
        $oFilCracha = new Filtro($oCracha, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);


        $oFilSetor = new Filtro($oSetor, Filtro::CAMPO_BUSCADOBANCOPK, 3, 3, 12, 12, false);
        $oFilSetor->setSClasseBusca('Setor');
        $oFilSetor->setSCampoRetorno('descsetor', $this->getTela()->getSId());
        $oFilSetor->setSIdTela($this->getTela()->getSId());

        $oFilFuncao = new Filtro($oFuncao, Filtro::CAMPO_BUSCADOBANCOPK, 3, 3, 12, 12, true);
        $oFilFuncao->setSClasseBusca('MET_RH_FuncaoSetor');
        $oFilFuncao->setSCampoRetorno('descfuncao', $this->getTela()->getSId());
        $oFilFuncao->setSIdTela($this->getTela()->getSId());

        $oFilTreinamento = new Filtro($oTagTreinamento, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilTreinamento->addItemSelect('Todos', 'Todos');
        $oFilTreinamento->addItemSelect('S', 'Sim');
        $oFilTreinamento->addItemSelect('N', 'Não');



        $this->addFiltro($oFilNr, $oFilFilcgc, $oFilCracha, $oFilSetor, $oFilFuncao, $oFilTreinamento);

        $this->addCampos($oNr, $oFilcgc, $oCracha, $oNome, $oSetor, $oFuncao, $oSit, $oTagTreinamento, $oTagEsc);

        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","MET_ISO_Treinamentos","renderTreinamento",chave+",treinamentoTempo");');
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oDados = $this->getAParametrosExtras();

        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);

        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setSValor($_SESSION['nome']);
        $oUser->setBCampoBloqueado(true);

        $oDataCad = new Campo('...', 'data_cad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCad->setBOculto(true);
        $oDataCad->setSValor(date('d-m-Y'));

        /////////////////////////////////////////////
        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        //$oCracha->setSCorFundo(Campo::FUNDO_MONEY);

        $oNome = new Campo('Colaborador', 'nome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oNome->setSIdPk($oCracha->getId());
        $oNome->setClasseBusca('MET_CAD_Funcionarios');
        $oNome->addCampoBusca('numcad', '', '');
        $oNome->addCampoBusca('nomfun', '', '');
        $oNome->setSIdTela($this->getTela()->getid());

        $oCracha->setClasseBusca('MET_CAD_Funcionarios');
        $oCracha->setSCampoRetorno('numcad', $this->getTela()->getId());
        $oCracha->addCampoBusca('nomfun', $oNome->getId(), $this->getTela()->getId());
        //////////////////////////////////////////////

        $oCodSetor = new Campo('', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodSetor->setApenasTela(true);
        $oCodSetor->setBOculto(true);

        $oDescSetor = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDescSetor->setSIdPk($oCodSetor->getId());
        $oDescSetor->setClasseBusca('Setor');
        $oDescSetor->addCampoBusca('codsetor', '', '');
        $oDescSetor->addCampoBusca('descsetor', '', '');
        $oDescSetor->setSIdTela($this->getTela()->getid());

        $oCodSetor->setClasseBusca('Setor');
        $oCodSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetor->addCampoBusca('descsetor', $oDescSetor->getId(), $this->getTela()->getId());

        $oFuncao = new Campo('Função', 'funcao', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oSit = new Campo('Sit', 'situacao', Campo::CAMPO_SELECTSIMPLE, 1, 1, 12, 12);
        $oSit->addItemSelect('Ativo', 'Ativo');
        $oSit->addItemSelect('Inativo', 'Inativo');

        $oDivisor1 = new Campo('Condições da escolaridade', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oGrauEsc = new Campo('Escolaridade', 'grau_escolaridade', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oTagEsc = new Campo('...', 'tagEscolaridade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTagEsc->setBOculto(true);

        $oCracha->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Treinamentos","buscaDadosFunc","' . $oNome->getId() . ',' . $oSit->getId() . ',' . $oDescSetor->getId() . ',' . $oFuncao->getId() . ',' . $oGrauEsc->getId() . ',' . $oTagEsc->getId() . '");');
        $oNome->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Treinamentos","buscaDadosFunc","' . $oNome->getId() . ',' . $oSit->getId() . ',' . $oDescSetor->getId() . ',' . $oFuncao->getId() . ',' . $oGrauEsc->getId() . ',' . $oTagEsc->getId() . '");');

        $oLinhaBranco = new Campo('', 'linha', Campo::TIPO_LINHA, 1, 1, 12, 12);
        $oLinhaBranco->setApenasTela(true);

        $oExp1A = new Campo('Exp. min. 1 ano', 'experiencia1a', Campo::TIPO_SELECT, 2, 2, 6, 6);
        $oExp1A->addItemSelect('Não se aplica a função', 'Não se aplica a função');
        $oExp1A->addItemSelect('Atende', 'Atende');
        $oExp1A->addItemSelect('Avaliação Pendente', 'Avaliação Pendente');
        $oExp1A->addItemSelect('Não atende', 'Não atende');

        $oExp2A = new Campo('Exp. min. 2 anos', 'experiencia2a', Campo::TIPO_SELECT, 2, 2, 6, 6);
        $oExp2A->addItemSelect('Não se aplica a função', 'Não se aplica a função');
        $oExp2A->addItemSelect('Atende', 'Atende');
        $oExp2A->addItemSelect('Avaliação Pendente', 'Avaliação Pendente');
        $oExp2A->addItemSelect('Não atende', 'Não atende');

        $oHabLider = new Campo('Hab. liderança', 'hablideranca', Campo::TIPO_SELECT, 2, 2, 6, 6);
        $oHabLider->addItemSelect('Não se aplica a função', 'Não se aplica a função');
        $oHabLider->addItemSelect('Atende', 'Atende');
        $oHabLider->addItemSelect('Avaliação Pendente', 'Avaliação Pendente');
        $oHabLider->addItemSelect('Não atende', 'Não atende');

        $oSemExp = new Campo('Sem experiência exigigda', 'semexperiencia', Campo::TIPO_SELECT, 2, 2, 6, 6);
        $oSemExp->addItemSelect('Não se aplica a função', 'Não se aplica a função');
        $oSemExp->addItemSelect('Atende', 'Atende');
        $oSemExp->addItemSelect('Avaliação Pendente', 'Avaliação Pendente');
        $oSemExp->addItemSelect('Não atende', 'Não atende');



        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Colaborador', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Registros de Treinamento', false, $this->addIcone(Base::ICON_CONFIRMAR));


        $this->addEtapa($oEtapas);

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {
            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }$this->setSIdControleUpAlt($oAcao->getId());
            $this->addCampos(array($oNr, $oFilcgc, $oUser, $oDataCad), array($oCracha, $oNome), array($oDescSetor, $oFuncao, $oGrauEsc, $oSit, $oTagEsc), $oAcao);
        } else {
            $this->addCampos(array($oNr, $oFilcgc, $oUser, $oDataCad), array($oCracha, $oNome), array($oDescSetor, $oFuncao, $oGrauEsc, $oTagEsc, $oSit));
        }
    }

}
