<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_FuncDesc extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaGridDetalhe() {
        parent::criaGridDetalhe();

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oSeq = new CampoConsulta('Seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $oUsuario = new CampoConsulta('Usuário', 'usuario', CampoConsulta::TIPO_TEXTO);
        $oDoc = new CampoConsulta('Documento', 'arquivo', CampoConsulta::TIPO_DOWNLOAD);
        $oDoc->setSDiretorioManual('Descricao de Funcoes');
        $oRev = new CampoConsulta('Revisão', 'revisao', CampoConsulta::TIPO_TEXTO);
        $oDataRev = new CampoConsulta('Data da Revisão', 'data_revisao', CampoConsulta::TIPO_DATA);
        $oDescFunc = new CampoConsulta('Desc. da Função', 'descricao', CampoConsulta::TIPO_TEXTO);

        $oEscExigida = new CampoConsulta('Esc. Exigida', 'esc_exigida');
        $oEscExigida->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ler e escrever');
        $oEscExigida->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino básico - 4ª');
        $oEscExigida->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino funcamental - 8ª');
        $oEscExigida->addComparacao('4', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino médio - 3º');
        $oEscExigida->addComparacao('5', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Superior - Técnico');
        $oEscExigida->addComparacao('6', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Especialização');


        $oEscRecomendada = new CampoConsulta('Esc. Recomendada', 'esc_recomendada');
        $oEscRecomendada->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ler e escrever');
        $oEscRecomendada->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino básico - 4ª');
        $oEscRecomendada->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino funcamental - 8ª');
        $oEscRecomendada->addComparacao('4', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino médio - 3º');
        $oEscRecomendada->addComparacao('5', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Superior - Técnico');
        $oEscRecomendada->addComparacao('6', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Especialização');



        $oObs = new Campo('Observação de alterações', '', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->setILinhasTextArea(6);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObs->setApenasTela(true);
        $oObs->setBCampoBloqueado(true);

        $this->addCamposGridDetalhe($oObs);

        $this->getOGridDetalhe()->setSEventoClick('var chave=""; $("#' . $this->getOGridDetalhe()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'var idCampos ="' . $oObs->getId() . '";'
                . 'requestAjax("","MET_ISO_FuncDesc","carregaObs","' . $this->getOGridDetalhe()->getSId() . '"+","+chave+","+idCampos+"");');

        $this->addCamposDetalhe($oNr, $oFilcgc, $oSeq, $oUsuario, $oRev, $oDataRev, $oDescFunc, $oEscExigida, $oEscRecomendada, $oDoc);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);
        $oFilcgc = new CampoConsulta('Emp.', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oSeq = new CampoConsulta('Seq', 'seq', CampoConsulta::TIPO_TEXTO);
        $oUsuario = new CampoConsulta('Usuário', 'usuario', CampoConsulta::TIPO_TEXTO);
        $oDoc = new CampoConsulta('Documento', 'arquivo', CampoConsulta::TIPO_DOWNLOAD);
        $oDoc->setSDiretorioManual('Descricao de Funcoes');
        $oRev = new CampoConsulta('Revisão', 'revisao', CampoConsulta::TIPO_TEXTO);
        $oDataRev = new CampoConsulta('Data da Revisão', 'data_revisao', CampoConsulta::TIPO_DATA);
        $oDescFunc = new CampoConsulta('Desc. da Função', 'descricao', CampoConsulta::TIPO_TEXTO);

        $oEscExigida = new CampoConsulta('Esc. Exigida', 'esc_exigida');
        $oEscExigida->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ler e escrever');
        $oEscExigida->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino básico - 4ª');
        $oEscExigida->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino funcamental - 8ª');
        $oEscExigida->addComparacao('4', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino médio - 3º');
        $oEscExigida->addComparacao('5', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Superior - Técnico');
        $oEscExigida->addComparacao('6', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Especialização');

        $oEscRecomendada = new CampoConsulta('Esc. Recomendada', 'esc_recomendada');
        $oEscRecomendada->addComparacao('1', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ler e escrever');
        $oEscRecomendada->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino básico - 4ª');
        $oEscRecomendada->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino funcamental - 8ª');
        $oEscRecomendada->addComparacao('4', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Ensino médio - 3º');
        $oEscRecomendada->addComparacao('5', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Superior - Técnico');
        $oEscRecomendada->addComparacao('6', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'Especialização');

        $this->addCampos($oNr, $oFilcgc, $oSeq, $oUsuario, $oRev, $oDataRev, $oDescFunc, $oEscExigida, $oEscRecomendada, $oDoc);
    }

    public function criaTela() {
        parent::criaTela();

        $aParam = $this->getAParametrosExtras();
        $this->criaGridDetalhe();


        $oSetor = new Campo('Setor', 'setor', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oSetor->setSValor($aParam[2]);
        $oSetor->setBOculto(true);
        $oSetor->setApenasTela(true);

        $oFilcgc = new Campo('Emp', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setSValor($aParam[0]);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aParam[1]);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);

        $oUsuario = new Campo('User', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuario->setSValor($_SESSION['nome']);
        $oUsuario->setBCampoBloqueado(true);
        $oUsuario->setBOculto(true);

        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);
        $oSeq->setBOculto(true);

        $oCodFuncao = new Campo('Cód. Função', 'codfuncao', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodFuncao->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodFuncao->setApenasTela(true);

        $oDescFuncao = new Campo('Descrição da função', 'descricao', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oDescFuncao->setSIdPk($oCodFuncao->getId());
        $oDescFuncao->setClasseBusca('MET_RH_FuncaoSetor');
        $oDescFuncao->addCampoBusca('codfunc', '', '');
        $oDescFuncao->addCampoBusca('descfunc', '', '');
        $oDescFuncao->setSIdTela($this->getTela()->getid());
        $oDescFuncao->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCodFuncao->setClasseBusca('MET_RH_FuncaoSetor');
        $oCodFuncao->setSCampoRetorno('codfunc', $this->getTela()->getId());
        $oCodFuncao->addCampoBusca('descfunc', $oDescFuncao->getId(), $this->getTela()->getId());

        $oRevisao = new Campo('Revisao', 'revisao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRevisao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oRevisao->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        

        $oDataRevisao = new Campo('data', 'data_revisao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataRevisao->setSValor(date('d-m-Y'));
        $oDataRevisao->setBOculto(true);

        $oObs = new Campo('Obs.', 'observacao', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObs->setILinhasTextArea(3);

        $oEscExigida = new Campo('Esc. Exigida', 'esc_exigida', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEscExigida->addItemSelect('1', 'Ler e escrever');
        $oEscExigida->addItemSelect('2', 'Ensino básico - 4ª');
        $oEscExigida->addItemSelect('3', 'Ensino funcamental - 8ª');
        $oEscExigida->addItemSelect('4', 'Ensino médio - 3º');
        $oEscExigida->addItemSelect('5', 'Superior - Técnico');
        $oEscExigida->addItemSelect('6', 'Especialização');

        $oEscRecomendada = new Campo('Esc. Recomendada', 'esc_recomendada', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEscRecomendada->addItemSelect('1', 'Ler e escrever');
        $oEscRecomendada->addItemSelect('2', 'Ensino básico - 4ª');
        $oEscRecomendada->addItemSelect('3', 'Ensino funcamental - 8ª');
        $oEscRecomendada->addItemSelect('4', 'Ensino médio - 3º');
        $oEscRecomendada->addItemSelect('5', 'Superior - Técnico');
        $oEscRecomendada->addItemSelect('6', 'Especialização');

        $oArquivo = new Campo('Anexo', 'arquivo', Campo::TIPO_UPLOAD, 3, 3, 12, 12);
        $oArquivo->setSDiretorio('Descricao de Funcoes');
        $oArquivo->setBNomeArquivo(true);

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);

        $sGrid = $this->getOGridDetalhe()->getSId();
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oObs->getId() . ',' . $oArquivo->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oNr, $oFilcgc, $oUsuario, $oSeq, $oDataRevisao), array(/* $oDescricao, */$oSetor, $oCodFuncao, $oDescFuncao, $oEscExigida, $oEscRecomendada), array($oArquivo, $oRevisao), $oObs, $oBotConf);
        $this->addCamposFiltroIni($oNr, $oFilcgc);
    }

}
