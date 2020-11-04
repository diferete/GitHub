<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewCot extends View {

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

        $oNr = new CampoConsulta('Cotação', 'nr', CampoConsulta::TIPO_TEXTO);
        $oNr->setILargura(50);
        $oCnpj = new CampoConsulta('CNPJ', 'cnpj', CampoConsulta::TIPO_TEXTO);
        $oCliente = new CampoConsulta('Cliente', 'cliente', CampoConsulta::TIPO_LARGURA, 200);
        $oOdCompra = new CampoConsulta('Ordem de compra', 'odcompra', CampoConsulta::TIPO_TEXTO);
        $oOdCompra->setILargura(100);

        $oEmail = new CampoConsulta('Email', 'email', CampoConsulta::TIPO_TEXTO);
        $oEmail->addComparacao('NV', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');
        $oEmail->addComparacao('EV', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oEmail->setBComparacaoColuna(true);

        $oNrVenda = new CampoConsulta('Nº Sol', 'nrvenda', CampoConsulta::TIPO_TEXTO);
        $oNrVenda->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oNrVenda->setBComparacaoColuna(true);

        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oData->setILargura(100);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_LOOP) . 'Gerar Solicitação de venda', 'Cot', 'geraSolMsg', '', false, '', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_COPIAR) . 'Gerar copia', 'Cot', 'msgCopiaCot', '', false, '', false, '', false, '', false, false);

        if (isset($_SESSION['cotvenda']) && $_SESSION['cotvenda'] !== '') {
            $sCotVenda = $_SESSION['cotvenda'];
        } else {
            $sCotVenda = 'cotacao';
        }

        $oDrop2 = new Dropdown('Visualizar', Dropdown::TIPO_PRIMARY);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'Cot', 'acaoMostraRelConsulta', '', false, '' . $sCotVenda . '', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar sem logo', 'Cot', 'acaoMostraRelConsulta', '', false, '' . $sCotVenda . ',slogo', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EXCEL) . 'Converte para excel', 'Cot', 'acaoMostraRelXls', '', false, 'cotacaoxls', false, '', false, '', false, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email', 'Cot', 'geraAnexoCotEmail', '', false, $sCotVenda, false, '', false, '', true, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email s/ logo', 'Cot', 'geraAnexoCotEmailSLogo', '', false, $sCotVenda, false, '', false, '', true, false);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Descontos', 'Cot', 'acaoMostraRelConsultaHTML', '', false, 'descontosrep', '', false, '', false, '', false, false);
        $this->addDropdown($oDrop2);


        $oFilSolNr = new Filtro($oNr, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFilCliente = new Filtro($oCliente, Filtro::CAMPO_TEXTO, 3);
        $oFilOd = new Filtro($oOdCompra, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2);

        $oFilCnpj = new Filtro($oCnpj, Filtro::CAMPO_BUSCADOBANCOPK, 2);
        $oFilCnpj->setSClasseBusca('Pessoa');
        $oFilCnpj->setSCampoRetorno('empcod', $this->getTela()->getSId());
        $oFilCnpj->setSIdTela($this->getTela()->getSId());

        $this->addCampos($oNr, $oCnpj, $oCliente, $oOdCompra, $oEmail, $oNrVenda, $oData);
        $this->addFiltro($oFilSolNr, $oFilCliente, $oFilCnpj, $oFilOd, $oFilData);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $this->setTituloTela('Inclusão de cotações de venda!');

        $oNr = new Campo('Cotação', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
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
        //---- FIM CAMPOS INICIAIS BLOQUEADOS----//

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

        $oOd = new Campo('Ordem de Compra', 'odcompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oOd->setITamanho(Campo::TAMANHO_PEQUENO);
        $oOd->setSValor(' ');

        $CodRep = new Campo('Cod. Rep', 'codrep', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $CodRep->setBCampoBloqueado(true);
        $CodRep->setITamanho(Campo::TAMANHO_PEQUENO);
        $CodRep->addValidacao(false, Validacao::TIPO_INTEIRO, '', '1');

        $oRep = new Campo('Representante', 'rep', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRep->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRep->setBCampoBloqueado(true);

        $oConsemail = new Campo('Email', 'consemail', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oConsemail->setITamanho(Campo::TAMANHO_PEQUENO);
        $oConsemail->setSValor($_SESSION['email']);
        $oConsemail->setBCampoBloqueado(true);

        //evento para carrega o rep
        $oCodPag->addEvento(Campo::EVENTO_SAIR, 'var oCnpj=$("#' . $oCnpj->getId() . '").val(); requestAjax("","Cot","carregaRep","' . $CodRep->getId() . ',' . $oRep->getId() . ',"+oCnpj+"","");');

        $oTransp = new Campo('Cod. Transp', 'transcnpj', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oTransp->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTransp->setSValor(' ');

        $oTranspDes = new Campo('Transportadora', 'transp', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oTranspDes->setSIdPk($oTransp->getId());
        $oTranspDes->setClasseBusca('Transp');
        $oTranspDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTranspDes->setSValor(' ');

        $oTranspDes->addCampoBusca('empcod', '', '');
        $oTranspDes->addCampoBusca('empdes', '', '');
        $oTransp->setClasseBusca('Transp');
        $oTransp->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oTransp->addCampoBusca('empdes', $oTranspDes->getId(), $this->getTela()->getId());

        $oFrete = new Campo('Frete', 'frete', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oFrete->addItemSelect('CIF', 'CIF');
        $oFrete->addItemSelect('FOB', 'FOB');

        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObs->setILinhasTextArea(4);
        $oObs->setSValor(' ');
        $oObs->setICaracter(300);

        $oQtExata = new Campo('Quantidade exata', 'qtexata', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oQtExata->addItemSelect('N', 'CLIENTE NÃO SOLICITA QUANTIDADES EXATAS');
        $oQtExata->addItemSelect('S', 'CLIENTE SOLICITA QUANTIDADE EXATAS');

        $oAtencao = new Campo('Atenção à seleção de quantidades!', '', Campo::TIPO_BADGE, 1, 1, 12, 12);
        $oAtencao->setSEstiloBadge(Campo::BADGE_DANGER);
        $oAtencao->setITamFonteBadge(18);
        $oAtencao->setApenasTela(true);

        //---Campo data de entrega com eventos de validação (Não pode ser menor que a data atual e nem null)---//
        $oDataEnt = new Campo('Data entrega', 'dtent', Campo::TIPO_DATA, 2);
        $oDataEnt->setITamanho(Campo::TAMANHO_PEQUENO);
        $sEventoData = 'if (dataAtual("' . $oDataEnt->getId() . '","' . date('d/m/Y') . '") == false){ '
                . ' return { valid: false, message: "Data menor que a data atual!" };'
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

        $oContato = new Campo('Contato', 'contato', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oContato->setITamanho(Campo::TAMANHO_PEQUENO);
        $oContato->setSValor(' ');

        $oSituaca = new Campo('', 'situaca', Campo::TIPO_TEXTO, 1);
        $oSituaca->setITamanho(Campo::TAMANHO_PEQUENO);
        $oSituaca->setSValor('A');
        $oSituaca->setBOculto(true);

        $oEmail = new Campo('', 'email', Campo::TIPO_TEXTO, 1);
        $oEmail->setSValor('NV');
        $oEmail->setBOculto(true);

        $oEtapas = new FormEtapa(2, 2, 2, 2);
        $oEtapas->addItemEtapas('Inserir Cotação!', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Financeiro', false, $this->addIcone(Base::ICON_INFO));
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

            $this->addCampos(array($oNr, $oData, $oHora, $oUserIns), array($oCnpj, $oEmpresa), array($oCodPag, $oCodPagDes), array($oOd, $CodRep, $oRep, $oConsemail), $oFrete, array($oTransp, $oTranspDes), $oObs, array($oQtExata, $oAtencao), $oDataEnt, array($oContato, $oEmail), $oAcao, $oSituaca);
        } else {
            $this->addCampos(array($oNr, $oData, $oHora, $oUserIns), array($oCnpj, $oEmpresa), array($oCodPag, $oCodPagDes), array($oOd, $CodRep, $oRep, $oConsemail), $oFrete, array($oTransp, $oTranspDes), $oObs, array($oQtExata, $oAtencao), $oDataEnt, array($oContato, $oEmail), $oSituaca);
        }
    }

}
