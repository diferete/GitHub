<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSolPed extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setILarguraGrid(2300);
        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setIAltura(750);

        $oNr = new CampoConsulta('Solicitação', 'nr', CampoConsulta::TIPO_TEXTO);
        $oNr->setILargura(50);

        $oCnpj = new CampoConsulta('CNPJ', 'cnpj', CampoConsulta::TIPO_TEXTO);

        $oCliente = new CampoConsulta('Cliente', 'cliente', CampoConsulta::TIPO_LARGURA, 200);

        $oOdCompra = new CampoConsulta('Ordem de compra', 'odcompra', CampoConsulta::TIPO_LARGURA, 15);
        $oOdCompra->setILargura(100);

        $oUserLib = new CampoConsulta('Usuário Lib.', 'userlib', CampoConsulta::TIPO_TEXTO);
        $oUserLib->setILargura(100);

        $oNrCot = new CampoConsulta('Cotação', 'nrcot', CampoConsulta::TIPO_TEXTO);

        $oDataLib = new CampoConsulta('Data Liberaçao', 'datalib', CampoConsulta::TIPO_DATA);
        $oDataLib->setILargura(80);

        $oEmail = new CampoConsulta('Email', 'email', CampoConsulta::TIPO_TEXTO);
        $oEmail->addComparacao('NV', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, '');
        $oEmail->addComparacao('EV', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');

        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oData->setILargura(100);

        $oGeraPed = new CampoConsulta('Pedido', 'geraped');
        $oGeraPed->setILargura(25);

        $this->setUsaDropdown(true);

        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Liberar para metalbo', 'SolPed', 'msgLiberaMetalbo', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_COPIAR) . 'Gerar copia', 'SolPed', 'msgCopiaSol', '', false, '', false, '', false, '', false, false);

        $oDrop2 = new Dropdown('Visualizar', Dropdown::TIPO_PRIMARY);
        //verifica sessão de solicitação de venda
        if (isset($_SESSION['solvenda']) && $_SESSION['solveda'] !== '') {
            $sSolvenda = $_SESSION['solvenda'];
        } else {
            $sSolvenda = 'solvenda';
        }
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'SolPed', 'acaoMostraRelConsulta', '', false, '' . $sSolvenda . '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar sem logo', 'SolPed', 'acaoMostraRelConsulta', '', false, '' . $sSolvenda . ',slogo', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EXCEL) . 'Converte para excel', 'SolPed', 'acaoMostraRelXls', '', false, 'solvendaxls', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email', 'SolPed', 'geraAnexoSolEmail', '', false, $sSolvenda, false, '', false, '', true, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email s/ logo', 'SolPed', 'geraAnexoSolEmailSLogo', '', false, $sSolvenda, false, '', false, '', true, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Descontos', 'SolPed', 'acaoMostraRelConsultaHTML', '', false, 'descontosrep', false, '', false, '', false, false);
        $this->addDropdown($oDrop2);
        //descontosrep

        $oFilSolNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);

        $oFilCliente = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);

        $oFilCnpj = new Filtro($oCnpj, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilCnpj->setSClasseBusca('Pessoa');
        $oFilCnpj->setSCampoRetorno('empcod', $this->getTela()->getSId());
        $oFilCnpj->setSIdTela($this->getTela()->getSId());

        $oFilOd = new Filtro($oOdCompra, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);

        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);

        $this->addCampos($oNr, $oCnpj, $oCliente, $oOdCompra, $oUserLib, $oNrCot, $oGeraPed, $oData, $oEmail);
        $this->addFiltro($oFilSolNr, $oFilCliente, $oFilCnpj, $oFilOd, $oFilData);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $this->setTituloTela('Inclusão de solicitação de pedidos de venda!');

        //---Define para não ter botão fechar---
        //$this->getTela()->setBTela(true);
        //----INICIO CAMPOS INICIAIS BLOQUEADOS----//
        $oNr = new Campo('Sol', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBFocus(true);
        //--------------------campo de pesquisa
        $oCnpj = new Campo('Cliente', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setBFocus(true);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);

        $oEmpresa = new Campo('Razão Social', 'cliente', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());

        //---Campo usuário que pega da SESSION---//
        $oUserIns = new campo('Usuário', 'userins', Campo::TIPO_TEXTO, 2, 3, 3);
        $oUserIns->setSValor($_SESSION["nome"]);
        $oUserIns->setBCampoBloqueado(true);

        //---Campo Data Atual---///
        $oData = new Campo('Data', 'data', Campo::TIPO_DATA, 1, 3, 3, 4);
        $oData->setITamanho(Campo::TAMANHO_PEQUENO);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));

        //---Campo Hora Atual---///
        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1, 3, 3, 4);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oCodPag = new Campo('Cod', 'codpgt', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodPag->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1');
        $oCodPag->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCodPagDes = new Campo('Pagamento', 'cpgt', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oCodPagDes->setSIdPk($oCodPag->getId());
        $oCodPagDes->setClasseBusca('CondPag');
        $oCodPagDes->addCampoBusca('cpgcod', '', '');
        $oCodPagDes->addCampoBusca('cpgdes', '', '');
        $oCodPagDes->setSIdTela($this->getTela()->getid());
        $oCodPagDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodPagDes->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oCodPag->setClasseBusca('CondPag');
        $oCodPag->setSCampoRetorno('cpgcod', $this->getTela()->getId());
        $oCodPag->addCampoBusca('cpgdes', $oCodPagDes->getId(), $this->getTela()->getId());

        //---Campo Ordem de Compra---///
        $oOd = new Campo('Ordem de Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oOd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOd->setSValor(' ');
        $oOd->addValidacao(false, Validacao::TIPO_STRING);

        //---Campo Código de representante---///
        $oCodRep = new Campo('Cod. Rep', 'codrep', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        //---Campo Descrição de Representante---///
        $oRep = new Campo('Representante', 'rep', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oRep->setSIdPk($oCodRep->getId());
        $oRep->setClasseBusca('Repcod');
        $oRep->addCampoBusca('repcod', '', '');
        $oRep->addCampoBusca('repdes', '', '');
        $oRep->setSIdTela($this->getTela()->getid());
        $oRep->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRep->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRep->setBCampoBloqueado(true);

        $oCodRep->setClasseBusca('Repcod');
        $oCodRep->setSCampoRetorno('repcod', $this->getTela()->getId());
        $oCodRep->addCampoBusca('repdes', $oRep->getId(), $this->getTela()->getId());

        //evento para carrega o rep
        $oCodPagDes->addEvento(Campo::EVENTO_SAIR, 'var oCnpj=$("#' . $oCnpj->getId() . '").val(); requestAjax("","SolPed","carregaRep","' . $oCodRep->getId() . ',' . $oRep->getId() . ',"+oCnpj+"","");');

        //---INICIO PESQUISA TIPO DE TRANSPORTADORA---//
        $oTransp = new Campo('CNPJ Transp.', 'transcnpj', Campo::TIPO_BUSCADOBANCOPK, 2, 6, 6, 12);
        $oTransp->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTransp->setSValor('');

        $oTranspDes = new Campo('Transportadora', 'transp', Campo::TIPO_BUSCADOBANCO, 4, 6, 6, 12);
        $oTranspDes->setSIdPk($oTransp->getId());
        $oTranspDes->setClasseBusca('Transp');
        $oTranspDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTranspDes->setSValor('');

        /* definir sempre código pk e descrição */
        $oTranspDes->addCampoBusca('empcod', '', '');
        $oTranspDes->addCampoBusca('empdes', '', '');
        $oTransp->setClasseBusca('Transp');
        $oTransp->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oTransp->addCampoBusca('empdes', $oTranspDes->getId(), $this->getTela()->getId());
        //---FIM PESQUISA TIPO DE PAGAMENTO---//
        //---Campo Tipo de Frete---///
        $oFrete = new Campo('Frete', 'frete', Campo::TIPO_SELECT, 2);
        $oFrete->addItemSelect('CIF ', 'CIF ');
        $oFrete->addItemSelect('FOB', 'FOB');

        //---Campo Observação---///
        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObs->setILinhasTextArea(4);
        $oObs->setSValor('');
        $oObs->setICaracter(300);

        //---Campo Quantidade Exata---///
        $oQtExata = new Campo('Quantidade exata', 'qtexata', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oQtExata->addItemSelect('N', 'CLIENTE NÃO SOLICITA QUANTIDADES EXATAS');
        $oQtExata->addItemSelect('S', 'CLIENTE SOLICITA QUANTIDADE EXATAS');

        //---Aviso do campo Quantidade Exata---//
        $oAtencao = new Campo('Atenção à seleção de quantidades!', '', Campo::TIPO_BADGE, 1, 1, 12, 12);
        $oAtencao->setSEstiloBadge(Campo::BADGE_DANGER);
        $oAtencao->setITamFonteBadge(18);
        $oAtencao->setApenasTela(true);

        //---Campo data de entrega com eventos de validação (Não pode ser menor que a data atual e nem null)---//
        $oDataEnt = new Campo('Data entrega', 'dtent', Campo::TIPO_DATA, 2);
        $oDataEnt->setITamanho(Campo::TAMANHO_PEQUENO);
        $sEventoData = 'if (dataAtual("' . $oDataEnt->getId() . '","' . date('d/m/Y') . '") == false){ '
                . 'return { valid: false, message: "Data menor que a data atual!" };'
                . '}else{'
                . 'return { valid: true };'
                . '};'
                . 'if($("#' . $oDataEnt->getId() . '").val() == "") {'
                . 'return { valid: false, message: "Data não pode ser em branco!" };'
                . '}else{'
                . 'return { valid: true };'
                . '};';
        if ($sAcaoRotina != 'acaoVisualizar') {
            $oDataEnt->addValidacao(true, Validacao::TIPO_CALLBACK, '', '1', '1000', '', '', $sEventoData, Validacao::TRIGGER_TODOS);
        }
        //---Campos ocultos ou com valores fixos---//
        $oConsemail = new Campo('Email', 'consemail', Campo::TIPO_TEXTO, 3, 3, 3, 12);
        $oConsemail->setITamanho(Campo::TAMANHO_PEQUENO);
        $oConsemail->setSValor($_SESSION['email']);
        $oConsemail->setBCampoBloqueado(true);

        $oSituaca = new Campo('', 'situaca', Campo::TIPO_TEXTO, 1);
        $oSituaca->setITamanho(Campo::TAMANHO_PEQUENO);
        $oSituaca->setSValor('A');
        $oSituaca->setBOculto(true);

        $oContato = new Campo('Contato', 'contato', Campo::TIPO_TEXTO, 3);
        $oContato->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContato->setSValor('');

        $oEmail = new Campo('', 'email', Campo::TIPO_TEXTO, 1);
        $oEmail->setSValor('NV');
        $oEmail->setBOculto(true);
        //---//

        $oEtapas = new FormEtapa(2, 2, 2, 2);
        $oEtapas->addItemEtapas('Inserir Solicitação!', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Financeiro', false, $this->addIcone(Base::ICON_INFO));
        $oEtapas->addItemEtapas('Itens da Solicitação', false, $this->addIcone(Base::ICON_CONFIRMAR));
        $this->addEtapa($oEtapas);

        //---Adiciona uma linha em branco---///

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {
            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }
            $this->setSIdControleUpAlt($oAcao->getId());

            $this->addCampos(array($oNr, $oData, $oHora, $oUserIns), array($oCnpj, $oEmpresa), array($oCodPag, $oCodPagDes), array($oOd, $oCodRep, $oRep, $oConsemail), $oFrete, array($oTransp, $oTranspDes), $oObs, array($oQtExata, $oAtencao), $oDataEnt, array($oContato, $oEmail), $oAcao, $oSituaca);
        } else {

            $this->addCampos(array($oNr, $oData, $oHora, $oUserIns), array($oCnpj, $oEmpresa), array($oCodPag, $oCodPagDes), array($oOd, $oCodRep, $oRep, $oConsemail), $oFrete, array($oTransp, $oTranspDes), $oObs, array($oQtExata, $oAtencao), $oDataEnt, array($oContato, $oEmail), $oSituaca);
        }
    }

}
