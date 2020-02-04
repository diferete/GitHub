<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_VENDA_ExpCot extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();



        $oNr = new CampoConsulta('Cotação', 'nr', CampoConsulta::TIPO_TEXTO);
        $oNr->setILargura(50);
        $oCnpj = new CampoConsulta('Cnpj', 'cnpj', CampoConsulta::TIPO_TEXTO);
        $oCliente = new CampoConsulta('Cliente', 'cliente', CampoConsulta::TIPO_LARGURA, 400);
        // $oCliente->setILargura(600);
        $oOdCompra = new CampoConsulta('Od', 'odcompra', CampoConsulta::TIPO_TEXTO);
        $oOdCompra->setILargura(100);


        $oEmail = new CampoConsulta('Email', 'email', CampoConsulta::TIPO_TEXTO);
        $oEmail->addComparacao('NV', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, null);
        $oEmail->addComparacao('EV', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oEmail->setBComparacaoColuna(true);

        $oNrVenda = new CampoConsulta('Nº Sol', 'nrvenda', CampoConsulta::TIPO_TEXTO);
        $oNrVenda->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oNrVenda->setBComparacaoColuna(true);

        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oData->setILargura(100);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Gerar Solicitação de venda', 'MET_VENDA_ExpCot', 'geraSolMsg', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_COPIAR) . 'Gerar copia', 'MET_VENDA_ExpCot', 'msgCopiaCot', '', false, '', false, '', false, '', false, false);

        if (isset($_SESSION['cotvenda']) && $_SESSION['cotvenda'] !== '') {
            $sCotVenda = $_SESSION['cotvenda'];
        } else {
            $sCotVenda = 'cotacao';
        }

        $oDrop2 = new Dropdown('Visualizar', Dropdown::TIPO_PRIMARY);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'MET_VENDA_ExpCot', 'acaoMostraRelConsulta', '', false, '' . $sCotVenda . '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar sem logo', 'MET_VENDA_ExpCot', 'acaoMostraRelConsulta', '', false, '' . $sCotVenda . ',slogo', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EXCEL) . 'Converte para excel', 'MET_VENDA_ExpCot', 'acaoMostraRelXls', '', false, 'cotacaoxls', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email', 'MET_VENDA_ExpCot', 'acaoMostraRelConsulta', '', false, '' . $sCotVenda . ',email,MET_VENDA_ExpCot,envMailCot', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email s/ logo', 'MET_VENDA_ExpCot', 'acaoMostraRelConsulta', '', false, '' . $sCotVenda . ',email,MET_VENDA_ExpCot,envMailCot,slogo', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_INFO) . 'Estoque', 'ConsultaEstoque', 'acaoMostraTelaEstoque', '', false, $_SESSION['officecabcotiten'], true, 'Consulta Estoques de Cotação', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Descontos', 'MET_VENDA_ExpCot', 'acaoMostraRelConsultaHTML', '', false, 'descontosrep', false, '', false, '', false, false);
        $this->addDropdown($oDrop1, $oDrop2); //geraExcelSol*/


        $oFilSolNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);
        $oFilCliente = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oFilCnpj = new Filtro($oCnpj, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12, false);
        $oFilCnpj->setSClasseBusca('Pessoa');
        $oFilCnpj->setSCampoRetorno('empcod', $this->getTela()->getSId());
        $oFilCnpj->setSIdTela($this->getTela()->getSId());

        $this->addCampos($oNr, $oCnpj, $oCliente, $oOdCompra, $oEmail, $oNrVenda, $oData);
        $this->addFiltro($oFilSolNr, $oFilCliente, $oFilCnpj, $oFilData);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
    }

    public function criaTela() {
        parent::criaTela();


        $sAcaoRotina = $this->getSRotina();

        $this->setTituloTela('Inclusão de cotações de venda!');

        // $this->getTela()->setBTela(true);//define para nao ter botao fechar

        $oNr = new Campo('Cotação', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBFocus(true);
        //--------------------campo de pesquisa
        $oCnpj = new Campo('Cliente', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2);

        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setBFocus(true);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO); //'return { valid: true };';
        /* $sCallBackCnpj ='if(requestJSON(false, "SolPed","verifBloqCred", $("#'.$this->getTela()->getId().'-form").serialize(), "'.$oCnpj->getNome().'").retorno == "false"){;'
          .'return { valid: false, message: "Atenção, cliente está bloqueado no financeiro!" };'
          .'}else{return { valid: true };};';
          $oCnpj->addValidacao(true, Validacao::TIPO_CALLBACK, '', '2', '15', '', '', $sCallBackCnpj, Validacao::TRIGGER_SAIR); */


        $oEmpresa = new Campo('Razão Social', 'cliente', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        /* definir sempre código pk e descrição */
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        /* declara as informações */
        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());
        //-------------------fim campo de pesquisa
        $oCodPag = new Campo('Cod', 'codpgt', Campo::TIPO_BUSCADOBANCOPK, 1);
        $oCodPag->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1');
        $oCodPag->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCodPagDes = new Campo('Pagamento', 'cpgt', Campo::TIPO_BUSCADOBANCO, 4);
        $oCodPagDes->setSIdPk($oCodPag->getId());
        $oCodPagDes->setClasseBusca('CondPag');
        $oCodPagDes->addCampoBusca('cpgcod', '', '');
        $oCodPagDes->addCampoBusca('cpgdes', '', '');
        $oCodPagDes->setSIdTela($this->getTela()->getid());
        $oCodPagDes->setITamanho(Campo::TAMANHO_PEQUENO);

        $oCodPag->setClasseBusca('CondPag');
        $oCodPag->setSCampoRetorno('cpgcod', $this->getTela()->getId());
        $oCodPag->addCampoBusca('cpgdes', $oCodPagDes->getId(), $this->getTela()->getId());


        $oOd = new Campo('Ordem de Compra', 'odcompra', Campo::TIPO_TEXTO, 2);
        $oOd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOd->setSValor(' ');

        $oCodRed = new Campo('Cod. Rep', 'codrep', Campo::TIPO_TEXTO, 1);
        $oCodRed->setBCampoBloqueado(true);
        $oCodRed->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodRed->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1');

        $oRep = new Campo('Representante', 'rep', Campo::TIPO_TEXTO, 2);
        $oRep->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRep->setBCampoBloqueado(true);
        //evento para carrega o rep
        $oCodPagDes->addEvento(Campo::EVENTO_SAIR, 'var oCnpj=$("#' . $oCnpj->getId() . '").val(); requestAjax("","MET_VENDA_ExpCot","carregaRep","' . $oCodRed->getId() . ',' . $oRep->getId() . ',"+oCnpj+"","");');

        $oTransp = new Campo('Cod. Transp', 'transcnpj', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oTransp->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTransp->setSValor(' ');

        $oTranspDes = new Campo('Transportadora', 'transp', Campo::TIPO_BUSCADOBANCO, 4);
        $oTranspDes->setSIdPk($oTransp->getId());
        $oTranspDes->setClasseBusca('Transp');
        $oTranspDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTranspDes->setSValor(' ');
        /* definir sempre código pk e descrição */
        $oTranspDes->addCampoBusca('empcod', '', '');
        $oTranspDes->addCampoBusca('empdes', '', '');
        $oTransp->setClasseBusca('Transp');
        $oTransp->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oTransp->addCampoBusca('empdes', $oTranspDes->getId(), $this->getTela()->getId());

        $oFrete = new Campo('Frete', 'frete', Campo::TIPO_SELECT, 2);
        $oFrete->addItemSelect('CIF', 'CIF');
        $oFrete->addItemSelect('FOB', 'FOB');

        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 15);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObs->setILinhasTextArea(4);
        $oObs->setSValor(' ');
        $oObs->setICaracter(300);

        $oQtExata = new Campo('Quantidade exata', 'qtexata', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oQtExata->addItemSelect('N', 'CLIENTE NÃO SOLICITA QUANTIDADES EXATAS');
        $oQtExata->addItemSelect('S', 'CLIENTE SOLICITA QUANTIDADE EXATAS');

        $oAtencao = new Campo('Atenção à seleção', '', Campo::TIPO_BADGE, 1);
        $oAtencao->setSEstiloBadge(Campo::BADGE_DANGER);
        $oAtencao->setApenasTela(true);

        $oDataEnt = new Campo('Data entrega', 'dtent', Campo::TIPO_DATA, 2);
        $oDataEnt->setITamanho(Campo::TAMANHO_PEQUENO);
        $sEventoData = 'if (dataAtual("' . $oDataEnt->getId() . '","' . date('d/m/Y') . '")==false){ '
                . ' return { valid: false, message: "Data menor que a data atual!" };  }else{return { valid: true };}; '
                . 'if($("#' . $oDataEnt->getId() . '").val()=="") { '
                . ' return { valid: false, message: "Data não pode ser em branco!" };'
                . '}else{return { valid: true };};';
        $oDataEnt->addValidacao(true, Validacao::TIPO_CALLBACK, '', '1', '1000', '', '', $sEventoData, Validacao::TRIGGER_TODOS);

        /* Campos ocultos ou com valores fixos */
        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1);
        $oData->setITamanho(Campo::TAMANHO_PEQUENO);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d-m-Y'));


        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1);
        $oHora->setITamanho(Campo::TAMANHO_PEQUENO);
        date_default_timezone_set('America/Sao_Paulo');
        $oHora->setSValor(date('H:i'));
        $oHora->setBCampoBloqueado(true);

        $oUserIns = new campo('Usuário', 'userins', Campo::TIPO_TEXTO, 2);
        $oUserIns->setSValor($_SESSION["nome"]);

        $oConsemail = new Campo('Email', 'consemail', Campo::TIPO_TEXTO, 3);
        $oConsemail->setITamanho(Campo::TAMANHO_PEQUENO);
        $oConsemail->setSValor($_SESSION['email']);
        $oConsemail->setBCampoBloqueado(true);

        $oSituaca = new Campo('', 'situaca', Campo::TIPO_TEXTO, 1);
        $oSituaca->setITamanho(Campo::TAMANHO_PEQUENO);
        $oSituaca->setSValor('A');
        $oSituaca->setBOculto(true);

        $oContato = new Campo('Contato', 'contato', Campo::TIPO_TEXTO, 3);
        $oContato->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContato->setSValor(' ');

        $oEmail = new Campo('', 'email', Campo::TIPO_TEXTO, 1);
        $oEmail->setSValor('NV');
        $oEmail->setBOculto(true);

        $oEtapas = new FormEtapa(2, 2, 2, 2);
        $oEtapas->addItemEtapas('Inserir Cotação!', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens da Cotação', false, $this->addIcone(Base::ICON_CONFIRMAR));
        $this->addEtapa($oEtapas);

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

            $this->addCampos(array($oNr, $oData, $oHora, $oUserIns), array($oCnpj, $oEmpresa), array($oCodPag, $oCodPagDes), array($oOd, $oCodRed, $oRep, $oConsemail), $oFrete, array($oTransp, $oTranspDes), $oObs, array($oQtExata, $oAtencao), $oDataEnt, array($oContato, $oEmail), $oAcao, $oSituaca);
        } else {
            $this->addCampos(array($oNr, $oData, $oHora, $oUserIns), array($oCnpj, $oEmpresa), array($oCodPag, $oCodPagDes), array($oOd, $oCodRed, $oRep, $oConsemail), $oFrete, array($oTransp, $oTranspDes), $oObs, array($oQtExata, $oAtencao), $oDataEnt, array($oContato, $oEmail), $oSituaca);
        }
    }

}
