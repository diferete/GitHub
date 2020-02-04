<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPoliManut extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Ordem', 'nr');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oHora = new CampoConsulta('Hora', 'hora');
        $oUser = new CampoConsulta('Usuário', 'usuario'); //PoliCadMaq.codmaq
        $oMaquina = new CampoConsulta('Máquina', 'PoliCadMaq.maquina');
        $oPrevisao = new CampoConsulta('Previsão', 'previsao', CampoConsulta::TIPO_DATA);
        $oSituaca = new CampoConsulta('Situacão', 'situaca');
        $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, null);
        $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, null);
        $oSituaca->addComparacao('Iniciada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);


        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Ficha para mecânico', 'PoliManut', 'acaoMostraRelConsulta', '', false, 'fichamanutpoli', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_PASTA) . 'Ordem completa', 'PoliManut', 'acaoMostraRelConsulta', '', false, 'ordemmanutpoli', false, '', false, '', false, false);

        $oDrop2 = new Dropdown('Movimentações', Dropdown::TIPO_INFO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Aponta início da manutenção', 'PoliManut', 'msgLibManut', '', false, '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Encerramento', 'PoliManut', 'msgEnc', '', false, '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Retorna para aberta', 'PoliManut', 'msgRetAberta', '', false, '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_BORRACHA) . 'Cancela', 'PoliManut', 'msgCancela', '', false, '', false, '', false, '', false, false);

        $this->addDropdown($oDrop1, $oDrop2);

        $oFnr = new Filtro($oNr, Campo::TIPO_TEXTO, 1, 1, 12, 12, false);
        $oFMaquina = new Filtro($oMaquina, Campo::TIPO_TEXTO, 3, 3, 12, 12, false);
        $this->addFiltro($oFnr, $oFMaquina);

        $this->setUsaAcaoExcluir(false);

        $this->addCampos($oNr, $oMaquina, $oData, $oHora, $oUser, $oPrevisao, $oSituaca);

        $this->setBScrollInf(true);
        // $this->setUsaAcaoExcluir(false);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Insere ordem de serviço');

        $oNr = new Campo('Ordem', 'nr', Campo::TIPO_TEXTO, 1);

        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1);
        $oData->setSValor(date('d/m/Y'));
        $oData->setBCampoBloqueado(true);


        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2);
        $oUser->setSValor($_SESSION['nome']);
        $oUser->setBCampoBloqueado(true);

        $oCodMaq = new Campo('Cód', 'PoliCadMaq.codmaq', Campo::TIPO_BUSCADOBANCOPK, 1);
        $oCodMaq->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCodMaq->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1', '1000');


        $oMaq = new Campo('Máquina', 'PoliCadMaq.maquina', Campo::TIPO_BUSCADOBANCO, 5);
        $oMaq->setSIdPk($oCodMaq->getId());
        $oMaq->setClasseBusca('PoliCadMaq');
        $oMaq->addCampoBusca('codmaq', '', '');
        $oMaq->addCampoBusca('maquina', '', '');
        $oMaq->setSIdTela($this->getTela()->getid());
        // $oMaq->setApenasTela(true);
        $oMaq->setSCorFundo(Campo::FUNDO_AMARELO);
        $oMaq->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oCodMaq->setClasseBusca('PoliCadMaq');
        $oCodMaq->setSCampoRetorno('codmaq', $this->getTela()->getId());
        $oCodMaq->addCampoBusca('maquina', $oMaq->getId(), $this->getTela()->getId());

        $oProblema = new Campo('Problema apresentado', 'problema', Campo::TIPO_TEXTAREA, 6);
        $oProblema->setSCorFundo(Campo::FUNDO_MONEY);
        $oProblema->setILinhasTextArea(8);

        $oSituaca = new Campo('Situação', 'situaca', Campo::TIPO_TEXTO, 2);
        $oSituaca->setSValor('Aberta');
        $oSituaca->setBCampoBloqueado(true);

        $oPrevisao = new Campo('Previsão de entrega', 'previsao', Campo::TIPO_DATA, 2);


        $oField1 = new FieldSet('Fechamento');
        $oSolucao = new Campo('Solução', 'solucao', Campo::TIPO_TEXTAREA, 6);
        $oSolucao->setILinhasTextArea(6);
        $oSolucao->setSCorFundo(Campo::FUNDO_VERDE);

        $oMecanico = new Campo('Mecânico', 'mecanico', Campo::TIPO_TEXTO, 3);

        $oConsumo = new Campo('Consumo', 'consumo', Campo::TIPO_TEXTAREA, 6);
        $oConsumo->setILinhasTextArea(5);
        $oConsumo->setSCorFundo(Campo::FUNDO_AMARELO);

        $oField1->addCampos($oSolucao, $oMecanico, $oConsumo);
        $oField1->setOculto(true);





        $this->addCampos(array($oNr, $oData, $oHora, $oUser), array($oCodMaq, $oMaq), $oProblema, $oSituaca, $oField1, $oPrevisao);
    }

    public function relOsPoli() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de manutenção por máquina');
        $this->setBTela(true);

        $oCodMaq = new Campo('Cód', 'PoliCadMaq.codmaq', Campo::TIPO_BUSCADOBANCOPK, 1);
        $oCodMaq->setSCorFundo(Campo::FUNDO_AMARELO);
        //$oCodMaq->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1', '1000');


        $oMaq = new Campo('Máquina', 'PoliCadMaq.maquina', Campo::TIPO_BUSCADOBANCO, 5);
        $oMaq->setSIdPk($oCodMaq->getId());
        $oMaq->setClasseBusca('PoliCadMaq');
        $oMaq->addCampoBusca('codmaq', '', '');
        $oMaq->addCampoBusca('maquina', '', '');
        $oMaq->setSIdTela($this->getTela()->getid());
        // $oMaq->setApenasTela(true);
        $oMaq->setSCorFundo(Campo::FUNDO_AMARELO);
        // $oMaq->addValidacao(false, Validacao::TIPO_STRING,'','2');

        $oCodMaq->setClasseBusca('PoliCadMaq');
        $oCodMaq->setSCampoRetorno('codmaq', $this->getTela()->getId());
        $oCodMaq->addCampoBusca('maquina', $oMaq->getId(), $this->getTela()->getId());

        $oDataIni = new Campo('Data inicial', 'dataini', Campo::TIPO_DATA, 2);
        $oDataFim = new Campo('Data final', 'datafim', Campo::TIPO_DATA, 2);
        $oDataIni->setSValor('01/01/2010');
        $oDataFim->setSValor(date('d/m/Y'));
        $oSit = new Campo('Situação', 'sit', Campo::TIPO_SELECT, 2);
        $oSit->addItemSelect('Todas', 'Todas');
        $oSit->addItemSelect('Aberta', 'Aberta');
        $oSit->addItemSelect('Encerrada', 'Encerrada');


        $this->addCampos(array($oCodMaq, $oMaq), array($oDataIni, $oDataFim), $oSit);
    }

}
