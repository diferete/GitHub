<?php

/*
 * Classe que gerencia a Controller da VersaoSistema
 * @author: Alexandre W. de Souza
 * @since: 15/09/2017
 * 
 */

class ViewMET_TEC_Versao extends View {

    function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oTec = new CampoConsulta('Tecnologia', 'tec');
        $oVersao = new CampoConsulta('Versão', 'versao');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oHora = new CampoConsulta('Hora', 'hora');
        $oUsuNome = new CampoConsulta('Usuário', 'usunome', CampoConsulta::TIPO_LARGURA, 20);
        $oFVersao = new Filtro($oVersao, Filtro::CAMPO_TEXTO);
        $oFData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2);

        $this->addFiltro($oFVersao, $oFData);


        $this->addCampos($oSeq, $oTec, $oVersao, $oData, $oHora, $oUsuNome);
    }

    public function criaTela() {
        parent::criaTela();

        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Versões');
        $oTabGeral->setBActive(true);
        $oTabUpdatesNovidades = new AbaTabPanel('Updates e novidades');

        $this->addLayoutPadrao('Aba');

        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oTec = new Campo('Tecnologia', 'tec', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oTec->addItemSelect('PHP', 'PHP');
        $oTec->addItemSelect('Delphi', 'Delphi');
        $oTec->addItemSelect('Ionic', 'Ionic');

        $oUsuCodigo = new campo('...', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oUsuCodigo->addValidacao(false, Validacao::TIPO_STRING, '', '1');


        $oUsuNome = new Campo('Usuário', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oUsuNome->setSIdPk($oUsuCodigo->getId());
        $oUsuNome->setClasseBusca('User');
        $oUsuNome->addCampoBusca('usucodigo', '', '');
        $oUsuNome->addCampoBusca('usunome', '', '');
        $oUsuNome->setSIdTela($this->getTela()->getid());

        $oUsuCodigo->setClasseBusca('User');
        $oUsuCodigo->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oUsuCodigo->addCampoBusca('usunome', $oUsuNome->getId(), $this->getTela()->getId());

        //$oUsuNome = new Campo('Nome Usuário', 'usunome', Campo::TIPO_TEXTO, 2);

        $oVersao = new Campo('Numéro da Versão', 'versao', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oData = new Campo('Data', 'data', Campo::TIPO_DATA, 1, 1, 12, 12);
        $oData->setSValor(date('d/m/Y'));
        $oData->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oDescricao = new Campo('Descrição das Alterações', 'descricao', Campo::TIPO_TEXTAREA, 10, 10, 12, 12);

        $oEquipe = new Campo('Equipe Responsável', 'equipe', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oTabGeral->addCampos($oTec, array($oSeq, $oUsuCodigo, $oUsuNome, $oVersao), array($oData, $oHora, $oEquipe), $oDescricao);

        $oConteudo = new Campo('Conteúdo', 'conteudo', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oConteudo->setILinhasTextArea(5);

        $oCodSetor = new Campo('Cód. Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oDescSetor = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oDescSetor->setSIdPk($oCodSetor->getId());
        $oDescSetor->setClasseBusca('Setor');
        $oDescSetor->addCampoBusca('codsetor', '', '');
        $oDescSetor->addCampoBusca('descsetor', '', '');
        $oDescSetor->setSIdTela($this->getTela()->getid());
        
        $oCodSetor->setClasseBusca('Setor');
        $oCodSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetor->addCampoBusca('descsetor', $oDescSetor->getId(), $this->getTela()->getId());


        $oTabUpdatesNovidades->addCampos();

        $oTab->addItems($oTabGeral, $oTabUpdatesNovidades);

        $this->addCampos($oTab);
    }

}
