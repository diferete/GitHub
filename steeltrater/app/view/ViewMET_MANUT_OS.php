<?php

/*
 * Implementa a classe view MET_MANUT_OS
 * @author Cleverton Hoffmann
 * @since 21/07/2021
 */

class ViewMET_MANUT_OS extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setIAltura(700);
        $this->getTela()->setITipoGrid(2);

        $ofil_des = new CampoConsulta('Empresa', 'DELX_FIL_Empresa.fil_fantasia', CampoConsulta::TIPO_TEXTO);
        $onr = new CampoConsulta('Ordem', 'nr', CampoConsulta::TIPO_TEXTO);
        $onr->setILargura(30);

        $ocodMaq = new CampoConsulta('Cód', 'MET_CAD_Maquinas.codigoMaq', CampoConsulta::TIPO_TEXTO);
        $ocodMaq->setILargura(20);
        $odesMaq = new CampoConsulta('Máquina', 'MET_CAD_Maquinas.maquina', CampoConsulta::TIPO_TEXTO);
        $odesMaq->setILargura(500);

        //$ocodserv = new CampoConsulta('SERVIÇO', 'codserv', CampoConsulta::TIPO_TEXTO);

        $oresponsavel = new CampoConsulta('Responsável', 'responsavel', CampoConsulta::TIPO_TEXTO);
        $oresponsavel->setILargura(65);

        $ousuariocaddes = new CampoConsulta('Usuário inicial', 'MET_TEC_USUARIO.usunome', CampoConsulta::TIPO_TEXTO);
        $odatacad = new CampoConsulta('Data inicial', 'datacad', CampoConsulta::TIPO_DATA);
        $odatacad->setILargura(55);
        $ohoracad = new CampoConsulta('Hora inicial', 'horacad', CampoConsulta::TIPO_TIME);
        $ohoracad->setILargura(55);

        $oprevisao = new CampoConsulta('Previsão', 'previsao', CampoConsulta::TIPO_DATA);
        $oprevisao->setILargura(55);

        $otipomanut = new CampoConsulta('Tipo', 'tipomanut', CampoConsulta::TIPO_TEXTO);
        $otipomanut->addComparacao('MP', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'PREVENTIVA');
        $otipomanut->addComparacao('MC', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, true, 'CORRETIVA');
        $otipomanut->setBComparacaoColuna(true);
        $otipomanut->setILargura(65);

        $odias = new CampoConsulta('Dias Restantes', 'dias', CampoConsulta::TIPO_TEXTO);
        $odias->addComparacao('0', CampoConsulta::COMPARACAO_MENOR, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $odias->addComparacao('0', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_COLUNA, false, '');
        $odias->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_COLUNA, false, '');
        $odias->addComparacao('', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_PADRAO, CampoConsulta::MODO_COLUNA, false, '');
        $odias->setBComparacaoColuna(true);
        $odias->setILargura(50);

        //$ocodsetor = new CampoConsulta('SETOR', 'codsetor', CampoConsulta::TIPO_TEXTO);
        $oSituaca = new CampoConsulta('Situação', 'situacao');
        $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, true, 'ABERTA');
        $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, true, 'CANCELADA');
        $oSituaca->addComparacao('Iniciada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, true, 'INICIADA');
        $oSituaca->addComparacao('Encerrada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'ENCERRADA');
        $oSituaca->setILargura(65);

        $oNrfiltro = new Filtro($onr, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12);
//        $oDesEmpfiltro = new Filtro($ofil_des, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);
//        $oMaqCodfiltro = new Filtro($ocodMaq, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12);
        $oMaqDesfiltro = new Filtro($odesMaq, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);
        $oUsuariofiltro = new Filtro($ousuariocaddes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, true);
        // $oCodigoSetorfiltro = new Filtro($ocodsetor, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12);
        $oDescricaoSituacaofiltro = new Filtro($oSituaca, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oDescricaoSituacaofiltro->setSLabel('');
        $oDescricaoSituacaofiltro->addItemSelect('', 'Todas Situações');
        $oDescricaoSituacaofiltro->addItemSelect('Aberta', 'Aberta');
        $oDescricaoSituacaofiltro->addItemSelect('Cancelada', 'Cancelada');
        $oDescricaoSituacaofiltro->addItemSelect('Iniciada', 'Iniciada');
        $oDescricaoSituacaofiltro->addItemSelect('Encerrada', 'Encerrada');

        $oTipofiltro = new Filtro($otipomanut, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oTipofiltro->setSLabel('');
        $oTipofiltro->addItemSelect('', 'Todos Tipos');
        $oTipofiltro->addItemSelect('MP', 'Preventiva');
        $oTipofiltro->addItemSelect('MC', 'Corretiva');

        $oRespfiltro = new Filtro($oresponsavel, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oRespfiltro->setSLabel('');
        $oRespfiltro->addItemSelect('', 'Todos Responsáveis');
        $oRespfiltro->addItemSelect('MECANICA', 'Mecanica');
        $oRespfiltro->addItemSelect('ELETRICA', 'Elétrica');
        $oRespfiltro->addItemSelect('OPERADOR', 'Operador');

        $oFilData = new Filtro($oprevisao, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);
        //$oDiasfiltro = new Filtro($odias, Filtro::CAMPO_INTEIRO, 2, 2, 12, 12);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Movimentações', Dropdown::TIPO_INFO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Aponta início da manutenção', 'MET_MANUT_OS', 'msgLibManut', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_FECHAR) . 'Encerramento', 'MET_MANUT_OS', 'msgEnc', '', false, '', false, '', false, '', false, false);
        // $oDrop1->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Retorna para aberta', 'MET_MANUT_OS', 'msgRetAberta', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_RECARREGAR) . 'Retorna para iniciada', 'MET_MANUT_OS', 'msgRetIniciada', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_BORRACHA) . 'Cancela', 'MET_MANUT_OS', 'msgCancela', '', false, '', false, '', false, '', false, false);

        $oDrop2 = new Dropdown('Imprimir', Dropdown::TIPO_PRIMARY);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Ficha simples', 'MET_MANUT_OS', 'acaoMostraRelConsulta', '', false, 'FichaManut', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_PASTA) . 'Ordem completa', 'MET_MANUT_OS', 'acaoMostraRelConsulta', '', false, 'OrdemManut', false, '', false, '', false, false);

        $this->addDropdown($oDrop1, $oDrop2);

        $this->setUsaAcaoExcluir(false);

        //INTERESSANTE CRIAR UMA SITUAÇÃO POSTERGADA DEVIDO PROBLEMA DE MÁQUINA?

        $this->addFiltro($oDescricaoSituacaofiltro, $oNrfiltro, $oMaqDesfiltro, $oUsuariofiltro, $oFilData, $oTipofiltro, $oRespfiltro);

        $this->addCampos($ofil_des, $onr, $oSituaca, $ocodMaq, $odesMaq/* , $ocodserv */, $odatacad, $ohoracad, $ousuariocaddes, $oprevisao, $odias, $otipomanut, $oresponsavel/* , $ocodsetor */);

        $this->setBScrollInf(true);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcao = $this->getSRotina();

        if ($sAcao !== 'acaoAlterar') {
            //desativa botoes
            $this->setBTela(true);
            $this->setBOcultaFechar(true);
        }

        $oField0 = new FieldSet('Apontamento');

        $this->setTituloTela('Insere ordem de serviço');

        $ofil_codigo = new campo('Código Empresa', 'fil_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $ofil_codigo->setSValor('8993358000174');
        $ofil_codigo->setBCampoBloqueado(true);

        $ofil_Des = new Campo('Descrição', 'DELX_FIL_Empresa.fil_fantasia', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $ofil_Des->setSIdPk($ofil_codigo->getId());
        $ofil_Des->setSValor('STEELTRATER');
        $ofil_Des->setClasseBusca('DELX_FIL_empresa');
        $ofil_Des->addCampoBusca('fil_codigo', '', '');
        $ofil_Des->addCampoBusca('fil_fantasia', '', '');
        $ofil_Des->setSIdTela($this->getTela()->getid());
        $ofil_Des->addValidacao(false, Validacao::TIPO_STRING);
        $ofil_Des->setBCampoBloqueado(true);

        $ofil_codigo->setClasseBusca('DELX_FIL_empresa');
        $ofil_codigo->setSCampoRetorno('fil_codigo', $this->getTela()->getId());
        $ofil_codigo->addCampoBusca('fil_fantasia', $ofil_Des->getId(), $this->getTela()->getId());

        $onr = new Campo('Ordem', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $onr->setBCampoBloqueado(true);

        $ocod = new campo('Código Máquina', 'cod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $ocod->addValidacao(false, Validacao::TIPO_INTEIRO);

        $ocod_Des = new Campo('Descrição', 'MET_CAD_Maquinas.maquina', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $ocod_Des->setSIdPk($ocod->getId());
        $ocod_Des->setClasseBusca('MET_CAD_Maquinas');
        $ocod_Des->addCampoBusca('codigoMaq', '', '');
        $ocod_Des->addCampoBusca('maquina', '', '');
        $ocod_Des->setSIdTela($this->getTela()->getid());
        $ocod_Des->addValidacao(false, Validacao::TIPO_STRING);

        $ocod->setClasseBusca('MET_CAD_Maquinas');
        $ocod->setSCampoRetorno('codigoMaq', $this->getTela()->getId());
        $ocod->addCampoBusca('maquina', $ocod_Des->getId(), $this->getTela()->getId());

        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCracha->setId('manutCracha');
        if ($sAcao !== 'acaoAlterar') {
            $oCracha->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', '1', '6');
        }
        $oCracha->setApenasTela(true);
        $oCracha->setBFocus(true);
        $oCracha->setSCorFundo(Campo::FUNDO_VERMELHO);

        $ousuariocad = new campo('Usuário', 'usuariocad', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        //$ousuariocad->setSValor($_SESSION['codUser']);
        $ousuariocad->setBCampoBloqueado(true);

        $ousuariocaddes = new Campo('Descrição', 'MET_TEC_USUARIO.usunome', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $ousuariocaddes->setSIdPk($ousuariocad->getId());
        $ousuariocaddes->setClasseBusca('MET_TEC_USUARIO');
        $ousuariocaddes->addCampoBusca('usucodigo', '', '');
        $ousuariocaddes->addCampoBusca('usunome', '', '');
        $ousuariocaddes->setSIdTela($this->getTela()->getid());
        //$ousuariocaddes->setSValor($_SESSION['nome']);
        $ousuariocaddes->addValidacao(false, Validacao::TIPO_STRING);
        $ousuariocaddes->setBCampoBloqueado(true);

        $ousuariocad->setClasseBusca('MET_TEC_USUARIO');
        $ousuariocad->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $ousuariocad->addCampoBusca('usunome', $ousuariocaddes->getId(), $this->getTela()->getId());

        $sDadosCracha = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_MANUT_OS","buscaDadosCrachaManut","' . $ousuariocad->getId() . ',' . $ousuariocaddes->getId() . ',' . $oCracha->getId() . '");';
        $oCracha->addEvento(Campo::EVENTO_CHANGE, $sDadosCracha);

        $odatacad = new Campo('Data', 'datacad', Campo::TIPO_DATA, 2, 2, 12, 12);
        $odatacad->setSValor(date('d/m/Y', strtotime("now")));
        $odatacad->setBCampoBloqueado(true);

        $ohoracad = new Campo('Hora', 'horacad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ohoracad->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $ohoracad->setSValor(date('H:i'));
        $ohoracad->setBCampoBloqueado(true);

        $oproblema = new Campo('Problema apresentado', 'problema', Campo::TIPO_TEXTAREA, 6);
        $oproblema->setSCorFundo(Campo::FUNDO_MONEY);
        $oproblema->setILinhasTextArea(8);

        $osituacao = new Campo('Situação', 'situacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $osituacao->setSValor('Aberta');
        $osituacao->setBCampoBloqueado(true);

        $oField1 = new FieldSet('Fechamento');
        $osolucao = new Campo('Solução', 'solucao', Campo::TIPO_TEXTAREA, 6);
        $osolucao->setILinhasTextArea(6);
        $osolucao->setSCorFundo(Campo::FUNDO_VERDE);

        $oconsumo = new Campo('Consumo', 'consumo', Campo::TIPO_TEXTAREA, 6);
        $oconsumo->setILinhasTextArea(5);
        $oconsumo->setSCorFundo(Campo::FUNDO_AMARELO);

        //        $ouserenc = new Campo('userenc', 'userenc', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oField1->addCampos($osolucao, $oconsumo);

        $oField2 = new FieldSet('Material Necessário Para Compra');

        $oProCod = new Campo('Código', 'DELX_PRO_Produtos.pro_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oProCod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oProCod->setApenasTela(true);

        $omatnecessario = new Campo('Material Necessário', 'matnecessario', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $omatnecessario->setSCorFundo(Campo::FUNDO_AZUL);
        $omatnecessario->setSIdPk($oProCod->getId());
        $omatnecessario->setClasseBusca('DELX_PRO_Produtos');
        $omatnecessario->addCampoBusca('pro_codigo', '', '');
        $omatnecessario->addCampoBusca('pro_descricao', '', '');
        $omatnecessario->setSIdTela($this->getTela()->getid());
        $omatnecessario->setApenasTela(true);

        $oProCod->setClasseBusca('DELX_PRO_Produtos');
        $oProCod->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oProCod->addCampoBusca('pro_descricao', $omatnecessario->getId(), $this->getTela()->getId());

        $oQuant = new Campo('Quantidade', 'quantidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oQuant->setApenasTela(true);

        $oObservacao = new Campo('Observação Material', 'obsmat', Campo::TIPO_TEXTAREA, 5);
        $oObservacao->setILinhasTextArea(1);
        $oObservacao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObservacao->setApenasTela(true);

        /**
         * Monta a parte do grid de inserção de material -------------------------------------------------------------------
         */
        $oGridMatNeces = new campo('Material Necessário', 'gridMatOS', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridMatNeces->setId('gridMaterialManutOS');
        $oGridMatNeces->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
        $oGridMatNeces->setApenasTela(true);

        $ofil_cod3 = new CampoConsulta('Empresa', 'fil_codigo');
        $ofil_cod3->setILargura(60);
        $ocodMaq3 = new CampoConsulta('Máquina', 'cod');
        $ocodMaq3->setILargura(15);
        $ocodOS = new CampoConsulta('OS', 'nr');
        $ocodOS->setILargura(15);
        $ocodMat = new CampoConsulta('Código', 'codmat');
        $ocodMat->setILargura(15);
        $odesMat = new CampoConsulta('Descrição', 'descricaomat');
        $odesMat->setILargura(15);
        $ocodUser = new CampoConsulta('Cod.', 'usermatcod');
        $ocodUser->setILargura(30);
        $odesUser = new CampoConsulta('Usuário', 'usermatdes');
        $odesUser->setILargura(30);
        $odata = new CampoConsulta('Data', 'datamat', CampoConsulta::TIPO_DATA);
        $odata->setILargura(30);
        $oquantidade = new CampoConsulta('Quantidade', 'quantidade');
        $oquantidade->setILargura(30);
        $oobs1 = new CampoConsulta('Observação', 'obsmat');
        $oobs1->setILargura(30);

        $oBotaoExcluir = new CampoConsulta('Excluir', 'teste', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setILargura(15);
        $oBotaoExcluir->setSTitleAcao('Excluir item!');
        $oBotaoExcluir->addAcao('MET_MANUT_OSMaterial', 'msgExcluirMaterial', '', '');
        $oBotaoExcluir->setBHideTelaAcao(true);
        $oBotaoExcluir->setILargura(30);
        $oBotaoExcluir->setSNomeGrid('gridMatOS');

        $oGridMatNeces->addCampos($oBotaoExcluir, $ofil_cod3, $ocodMaq3, $ocodOS, $ocodMat, $odesMat, $ocodUser, $odesUser, $odata, $oquantidade, $oobs1);

        $oGridMatNeces->setSController('MET_MANUT_OSMaterial');
        $oGridMatNeces->getOGrid()->setIAltura(200);
        $oGridMatNeces->getOGrid()->setBGridResponsivo(true);

        $oBotInser = new Campo('INSERIR', 'test', Campo::TIPO_BOTAOSMALL, 1, 1, 2, 2);
        $oBotInser->setApenasTela(true);
        $oBotInser->setIMarginTop(6);
        $sAcao1 = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_MANUT_OSMaterial","acaoInserirMaterial","' . $this->getTela()->getId() . '-form,' .
                $oProCod->getId() . ',' . $omatnecessario->getId() . ',' . $oGridMatNeces->getId() . '","");';

        $oBotInser->getOBotao()->addAcao($sAcao1);

        $oField2->addCampos(array($oProCod, $omatnecessario, $oQuant, $oObservacao), array($oBotInser), $oGridMatNeces);

        $oresponsavel = new Campo('Responsável', 'responsavel', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oresponsavel->addItemSelect('MECANICA', 'MECANICA');
        $oresponsavel->addItemSelect('ELETRICA', 'ELÉTRICA');
        $oresponsavel->addItemSelect('OPERADOR', 'OPERADOR');

        $oprevisao = new Campo('Previsão de Entrega', 'previsao', Campo::TIPO_DATA, 2, 2, 12, 12);

        $otipomanut = new Campo('Tipo Manutenção', 'tipomanut', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $otipomanut->addItemSelect('MC', 'CORRETIVA');
        $otipomanut->addItemSelect('MP', 'PREVENTIVA');

        $ocodsetor = new Campo('codsetor', 'codsetor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocodsetor->setSValor($_SESSION['codsetor']);
        $ocodsetor->setBOculto(true);

        $oobs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 6);
        $oobs->setILinhasTextArea(5);
        $oobs->setSCorFundo(Campo::FUNDO_VERMELHO);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oField0->addCampos(array($oCracha, $ousuariocad, $ousuariocaddes, $odatacad, $ohoracad), $oLinha1, array($ocod, $ocod_Des), $oLinha1, array($oresponsavel, $oprevisao, $otipomanut), $oLinha1, $oproblema);

        $sAcaoMet = $_REQUEST['metodo'];

        if ($sAcaoMet == 'acaoMostraTelaAlterar') {

            $oCracha->setBCampoBloqueado(true);
            $ocod->setBCampoBloqueado(true);
            $ocod_Des->setBCampoBloqueado(true);
            $oresponsavel->setBCampoBloqueado(true);
            $oprevisao->setBCampoBloqueado(true);
            $otipomanut->setBCampoBloqueado(true);
            $oproblema->setBCampoBloqueado(true);
            //$oField0->setOculto(true);
        } else {

            $oField1->setOculto(true);
            $oField2->setOculto(true);
        }

        if ($sAcaoMet !== 'acaoMostraTela') {
            $this->addCampos(array($onr, $ofil_codigo, $ofil_Des, $osituacao), $oLinha1, $oField0, $oLinha1, $oField2, $oLinha1, $oField1, $oLinha1, $ocodsetor, $oobs);
        } else {
            $this->addCampos(array($onr, $ofil_codigo, $ofil_Des, $osituacao), $oLinha1, $oField0);
        }
    }

    public function relOsSteel() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de manutenção por máquina');
        $this->setBTela(true);

        $ocod = new campo('Código Máquina', 'cod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $ocod->setSCorFundo(Campo::FUNDO_AMARELO);

        $oMaq_Des = new Campo('Descrição', 'MET_CAD_Maquinas.maquina', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_Des->setSIdPk($ocod->getId());
        $oMaq_Des->setClasseBusca('MET_CAD_Maquinas');
        $oMaq_Des->addCampoBusca('cod', '', '');
        $oMaq_Des->addCampoBusca('maquina', '', '');
        $oMaq_Des->setSIdTela($this->getTela()->getid());
        $oMaq_Des->setSCorFundo(Campo::FUNDO_AMARELO);

        $ocod->setClasseBusca('MET_CAD_Maquinas');
        $ocod->setSCampoRetorno('cod', $this->getTela()->getId());
        $ocod->addCampoBusca('maquina', $oMaq_Des->getId(), $this->getTela()->getId());

        $oDataIniPrev = new Campo('Data inicial previsão', 'dataprevini', Campo::TIPO_DATA, 2);
        $oDataFimPrev = new Campo('Data final previsao', 'dataprevfim', Campo::TIPO_DATA, 2);
        $oDataIniPrev->setSValor('01/01/2021');
        $oDataFimPrev->setSValor(date('d/m/Y'));

        $oDataIni = new Campo('Data inicial cadastro', 'dataini', Campo::TIPO_DATA, 2);
        $oDataFim = new Campo('Data final cadastro', 'datafim', Campo::TIPO_DATA, 2);
        $oDataIni->setSValor('01/01/2021');
        $oDataFim->setSValor(date('d/m/Y'));

        $osituacao = new Campo('Situação', 'situacao', Campo::CAMPO_SELECTSIMPLE, 1, 1, 12, 12);
        $osituacao->addItemSelect('Todas', 'Todas');
        $osituacao->addItemSelect('Aberta', 'Aberta');
        $osituacao->addItemSelect('Cancelada', 'Cancelada');
        $osituacao->addItemSelect('Iniciada', 'Iniciada');
        $osituacao->addItemSelect('Encerrada', 'Encerrada');

        $oresponsavel = new Campo('Responsável', 'responsavel', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oresponsavel->addItemSelect('Todos', 'Todos');
        $oresponsavel->addItemSelect('MECANICA', 'Mecanica');
        $oresponsavel->addItemSelect('ELETRICA', 'Elétrica');
        $oresponsavel->addItemSelect('OPERADOR', 'Operador');

        $otipomanut = new Campo('Tipo Manutenção', 'tipomanut', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $otipomanut->addItemSelect('Todas', 'Todas');
        $otipomanut->addItemSelect('MC', 'Corretiva');
        $otipomanut->addItemSelect('MP', 'Preventiva');

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        //para mostrar a parte de imprimir a planilha no excel
        $oXls = new Campo('Exportar para Excel', 'expexcel', Campo::TIPO_BOTAOSMALL, 2, 2, 2, 2);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoExc = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_MANUT_OS","relatorioExcelManut");';
        $oXls->getOBotao()->addAcao($sAcaoExc);

        $this->addCampos(array($ocod, $oMaq_Des), $oLinha1, array($oresponsavel, $otipomanut), $oLinha1, array($oDataIniPrev, $oDataFimPrev), $oLinha1, array($oDataIni, $oDataFim), $oLinha1, $osituacao, $oXls);
    }

}
