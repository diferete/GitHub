<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPoliCadMaq extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oCodMaq = new CampoConsulta('Código Máquina', 'codmaq');
        
        $oMaquina = new CampoConsulta('Descrição da Máquina', 'maquina');
        
        $oFab = new CampoConsulta('Fabricante', 'PoliFab.fabdes');
        
        $oModelo = new CampoConsulta('Modelo', 'modelo');
        $oModelo->setILargura(100);
        
        $oResp = new CampoConsulta('Responsável', 'responsavel');

        $oSit = new CampoConsulta('Situação', 'ativa');
        $oSit->addComparacao('Ativa', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oSit->setBComparacaoColuna(true);

        $oSit->addComparacao('Desativada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oSit->setBComparacaoColuna(true);

        $oFiltro1 = new Filtro($oMaquina, Campo::TIPO_TEXTO, 2);
        $oFiltro2 = new Filtro($oFab, Campo::TIPO_TEXTO, 2);
        $oFiltro3 = new Filtro($oResp, Campo::TIPO_TEXTO, 2);
        $this->addFiltro($oFiltro1, $oFiltro2, $oFiltro3);

        $this->setBScrollInf(true);

        $this->addCampos($oCodMaq, $oMaquina, $oFab, $oModelo, $oSit, $oResp);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de Máquinas');
        $oCodMaq = new campo('Código', 'codmaq', Campo::TIPO_TEXTO, 1);
        $oCodMaq->setBCampoBloqueado(true);

        $oMaquina = new Campo('Máquina', 'maquina', Campo::TIPO_TEXTO, 6);

        $oFabCod = new Campo('FabCod', 'PoliFab.fabcod', Campo::TIPO_BUSCADOBANCOPK, 1);
        $oFabCod->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1', '1000');

        $oFabDes = new Campo('Fabricante', 'PoliFab.fabdes', Campo::TIPO_BUSCADOBANCO, 4);
        $oFabDes->setSIdPk($oFabCod->getId());
        $oFabDes->setClasseBusca('PoliFab');
        $oFabDes->addCampoBusca('fabcod', '', '');
        $oFabDes->addCampoBusca('fabdes', '', '');
        $oFabDes->setSIdTela($this->getTela()->getid());
        $oFabDes->setApenasTela(true);
        $oFabDes->addValidacao(false, Validacao::TIPO_STRING, '', '1', '1000');

        $oFabCod->setClasseBusca('PoliFab');
        $oFabCod->setSCampoRetorno('fabcod', $this->getTela()->getId());
        $oFabCod->addCampoBusca('fabdes', $oFabDes->getId(), $this->getTela()->getId());

        $oNomecla = new Campo('Nomeclatura', 'nomeclatura', Campo::TIPO_TEXTO, 3);

        $oModelo = new Campo('Modelo', 'modelo', Campo::TIPO_TEXTO, 3);

        $oAnoFab = new Campo('Ano Fabricante', 'fabricacao', Campo::TIPO_TEXTO, 1);

        $oHorasop = new Campo('Tempo Operação', 'horasop', Campo::TIPO_TEXTO, 2);

        $oNroperador = new Campo('Nº Operadores', 'nroperador', Campo::TIPO_TEXTO, 1);

        $oSerie = new Campo('Série', 'serie', Campo::TIPO_TEXTO, 3);

        $oCodSetor = new Campo('Cod', 'PoliSetor.codsetor', Campo::TIPO_BUSCADOBANCOPK, 1);
        $oCodSetor->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1', '1000');

        $oSetor = new Campo('Setor', 'PoliFab.setor', Campo::TIPO_BUSCADOBANCO, 3);
        $oSetor->setSIdPk($oCodSetor->getId());
        $oSetor->setClasseBusca('PoliSetor');
        $oSetor->addCampoBusca('codsetor', '', '');
        $oSetor->addCampoBusca('setor', '', '');
        $oSetor->setSIdTela($this->getTela()->getid());
        $oSetor->setApenasTela(true);
        $oSetor->addValidacao(false, Validacao::TIPO_STRING, '', '1', '1000');

        $oCodSetor->setClasseBusca('PoliSetor');
        $oCodSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetor->addCampoBusca('setor', $oSetor->getId(), $this->getTela()->getId());

        $oPatrimonio = new Campo('Patrimônio', 'patrimonio', Campo::TIPO_TEXTO, 2);

        $oObs = new Campo('Observações', 'obs', Campo::TIPO_TEXTAREA, 6);

        $oAtiva = new Campo('Situação', 'ativa', Campo::TIPO_SELECT, 2);
        $oAtiva->addItemSelect('Ativa', 'Ativa');
        $oAtiva->addItemSelect('Desativada', 'Desativada');

        $oSeguranca = new Campo('Segurança aplicada', 'seguranca', Campo::TIPO_TEXTAREA, 6);

        $oResponsavel = new Campo('Responsável', 'responsavel', Campo::TIPO_TEXTO, 3);

        $oUsercad = new Campo('Usuário', 'usercad', Campo::TIPO_TEXTO, 2);
        $oUsercad->setSValor($_SESSION['nome']);
        $oUsercad->setBCampoBloqueado(true);

        $oDataCad = new Campo('Data', 'datacad', Campo::TIPO_TEXTO, 1);
        $oDataCad->setSValor(date('d/m/Y'));
        $oDataCad->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'horacad', Campo::TIPO_TEXTO, 1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);


        $this->addCampos(array($oCodMaq, $oUsercad, $oDataCad, $oHora), $oMaquina, array($oFabCod, $oFabDes), array($oNomecla, $oModelo), array($oAnoFab, $oHorasop, $oNroperador, $oSerie), array($oCodSetor, $oSetor), $oAtiva, $oPatrimonio, $oObs, $oSeguranca, $oResponsavel);
    }

    public function RelCadMaqPoli() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de cadastro de máquinas');
        $this->setBTela(true);



        $oOrdData1 = new Campo('Ordenação', 'orddata1', Campo::TIPO_RADIO, 6);
        $oOrdData1->addItenRadio('desc', 'Ordena por código decrescente');
        $oOrdData1->addItenRadio('asc', 'Ordena por código crescente');




        $this->addCampos($oOrdData1);
    }

}
