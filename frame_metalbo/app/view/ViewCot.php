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
        $this->addDropdown($oDrop2, $oDrop1);


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
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpresa->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());

        $oCnpj->addEvento(Campo::EVENTO_SAIR, 'var oCnpj = $("#' . $oCnpj->getId() . '").val(); requestAjax("","Cot","retBloq",""+oCnpj+"","");;');

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

        $CodRep = new Campo('Cod. Rep', 'codrep', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oRep = new Campo('Representante', 'rep', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oRep->setSIdPk($CodRep->getId());
        $oRep->setClasseBusca('Repcod');
        $oRep->addCampoBusca('repcod', '', '');
        $oRep->addCampoBusca('repdes', '', '');
        $oRep->setSIdTela($this->getTela()->getid());
        $oRep->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRep->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oRep->setBCampoBloqueado(true);

        $CodRep->setClasseBusca('Repcod');
        $CodRep->setSCampoRetorno('repcod', $this->getTela()->getId());
        $CodRep->addCampoBusca('repdes', $oRep->getId(), $this->getTela()->getId());

        $oConsemail = new Campo('Email', 'consemail', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oConsemail->setITamanho(Campo::TAMANHO_PEQUENO);
        $oConsemail->setSValor($_SESSION['email']);
        $oConsemail->setBCampoBloqueado(true);

        //evento para carrega o rep
        $oCodPag->addEvento(Campo::EVENTO_SAIR, 'var oCnpj=$("#' . $oCnpj->getId() . '").val(); requestAjax("","Cot","carregaRep","' . $CodRep->getId() . ',' . $oRep->getId() . ',"+oCnpj+"","");');

        $oTransp = new Campo('CNPJ Transp.', 'transcnpj', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oTransp->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTransp->setSValor('');

        $oTranspDes = new Campo('Transportadora', 'transp', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oTranspDes->setSIdPk($oTransp->getId());
        $oTranspDes->setClasseBusca('Transp');
        $oTranspDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oTranspDes->setSValor('');

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
        $oObs->setILinhasTextArea(8);
        $oObs->setSValor('');
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
        $oContato->setSValor('');

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

    public function relConsultaEstoque() {
        parent::criaTelaRelatorio();

        //Relatório Faturamento
        $this->setTituloTela('Consulta Estoque');
        $this->setBTela(true);

        $oUsuario = new Campo('', 'userRel', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuario->setSValor($_SESSION['nome']);
        $oUsuario->setBOculto(true);

        //Grupo
        $oGrupoCod = new Campo('Grupo inicial', 'grucod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oGrupoCod->setSValor(0);
        $oGrupoCod->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oGrupoCod->getId() . '").val()==""){$("#' . $oGrupoCod->getId() . '").val("0")}');
        //-----------------------------------------------------------

        $oGrupoDes = new Campo('Descrição', 'grudes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oGrupoDes->setSIdPk($oGrupoCod->getId());
        $oGrupoDes->setClasseBusca('GrupoProd');
        $oGrupoDes->addCampoBusca('grucod', '', '');
        $oGrupoDes->addCampoBusca('grudes', '', '');
        $oGrupoDes->setSIdTela($this->getTela()->getid());
        $oGrupoDes->setBCampoBloqueado(true);

        $oGrupoCod->setClasseBusca('GrupoProd');
        $oGrupoCod->setSCampoRetorno('grucod', $this->getTela()->getId());
        $oGrupoCod->addCampoBusca('grudes', $oGrupoDes->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------

        $oSubGrupoCod = new Campo('Subgrupo inicial', 'subcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubGrupoCod->setSValor(0);
        $oSubGrupoCod->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oSubGrupoCod->getId() . '").val()==""){$("#' . $oSubGrupoCod->getId() . '").val("0")}');

        $oSubGrupoDes = new Campo('Descrição', 'subdes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubGrupoDes->setSIdPk($oSubGrupoCod->getId());
        $oSubGrupoDes->setClasseBusca('SubGrupoProd');
        $oSubGrupoDes->addCampoBusca('subcod', '', '');
        $oSubGrupoDes->addCampoBusca('subdes', '', '');
        $oSubGrupoDes->setSIdTela($this->getTela()->getid());
        $oSubGrupoDes->setBCampoBloqueado(true);


        $oSubGrupoCod->setClasseBusca('SubGrupoProd');
        $oSubGrupoCod->setSCampoRetorno('subcod', $this->getTela()->getId());
        $oSubGrupoCod->addCampoBusca('subdes', $oSubGrupoDes->getId(), $this->getTela()->getId());

        //----------------------------------------------------------------

        $oFamiliaCod = new Campo('Família inicial', 'famcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFamiliaCod->setSValor(0);
        $oFamiliaCod->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oFamiliaCod->getId() . '").val()==""){$("#' . $oFamiliaCod->getId() . '").val("0")}');

        $oFamiliaDes = new Campo('Descrição', 'famdes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFamiliaDes->setSIdPk($oFamiliaCod->getId());
        $oFamiliaDes->setClasseBusca('FamProd');
        $oFamiliaDes->addCampoBusca('famcod', '', '');
        $oFamiliaDes->addCampoBusca('famdes', '', '');
        $oFamiliaDes->setSIdTela($this->getTela()->getid());
        $oFamiliaDes->setBCampoBloqueado(true);


        $oFamiliaCod->setClasseBusca('FamProd');
        $oFamiliaCod->setSCampoRetorno('famcod', $this->getTela()->getId());
        $oFamiliaCod->addCampoBusca('famdes', $oFamiliaDes->getId(), $this->getTela()->getId());

        //-----------------------------------------------------------------------

        $oSubFamiliaCod = new Campo('Subfamília inicial', 'famsub', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubFamiliaCod->setSValor(0);
        $oSubFamiliaCod->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oSubFamiliaCod->getId() . '").val()==""){$("#' . $oSubFamiliaCod->getId() . '").val("0")}');

        $oSubFamiliaDes = new Campo('Descrição', 'famsdes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubFamiliaDes->setSIdPk($oSubFamiliaCod->getId());
        $oSubFamiliaDes->setClasseBusca('FamSub');
        $oSubFamiliaDes->addCampoBusca('famsub', '', '');
        $oSubFamiliaDes->addCampoBusca('famsdes', '', '');
        $oSubFamiliaDes->setSIdTela($this->getTela()->getid());
        $oSubFamiliaDes->setBCampoBloqueado(true);

        $oSubFamiliaCod->setClasseBusca('FamSub');
        $oSubFamiliaCod->setSCampoRetorno('famsub', $this->getTela()->getId());
        $oSubFamiliaCod->addCampoBusca('famsdes', $oSubFamiliaDes->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------------------
        //FINAL
        //Grupo
        $oGrupoCodFin = new Campo('Grupo final', 'grucodfin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oGrupoCodFin->setSValor(999);
        $oGrupoCodFin->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oGrupoCodFin->getId() . '").val()==""){$("#' . $oGrupoCodFin->getId() . '").val("999")}');
        //-----------------------------------------------------------

        $oGrupoDesFin = new Campo('Descrição', 'grudesfin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oGrupoDesFin->setSIdPk($oGrupoCodFin->getId());
        $oGrupoDesFin->setClasseBusca('GrupoProd');
        $oGrupoDesFin->addCampoBusca('grucod', '', '');
        $oGrupoDesFin->addCampoBusca('grudes', '', '');
        $oGrupoDesFin->setSIdTela($this->getTela()->getid());
        $oGrupoDesFin->setBCampoBloqueado(true);

        $oGrupoCodFin->setClasseBusca('GrupoProd');
        $oGrupoCodFin->setSCampoRetorno('grucod', $this->getTela()->getId());
        $oGrupoCodFin->addCampoBusca('grudes', $oGrupoDesFin->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------

        $oSubGrupoCodFin = new Campo('Subgrupo final', 'subcodfin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubGrupoCodFin->setSValor(999);
        $oSubGrupoCodFin->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oSubGrupoCodFin->getId() . '").val()==""){$("#' . $oSubGrupoCodFin->getId() . '").val("999")}');

        $oSubGrupoDesFin = new Campo('Descrição', 'subdesfin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubGrupoDesFin->setSIdPk($oSubGrupoCodFin->getId());
        $oSubGrupoDesFin->setClasseBusca('SubGrupoProd');
        $oSubGrupoDesFin->addCampoBusca('subcod', '', '');
        $oSubGrupoDesFin->addCampoBusca('subdes', '', '');
        $oSubGrupoDesFin->setSIdTela($this->getTela()->getid());
        $oSubGrupoDesFin->setBCampoBloqueado(true);

        $oSubGrupoCodFin->setClasseBusca('SubGrupoProd');
        $oSubGrupoCodFin->setSCampoRetorno('subcod', $this->getTela()->getId());
        $oSubGrupoCodFin->addCampoBusca('subdes', $oSubGrupoDesFin->getId(), $this->getTela()->getId());

        //----------------------------------------------------------------

        $oFamiliaCodFin = new Campo('Família final', 'famcodfin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFamiliaCodFin->setSValor(999);
        $oFamiliaCodFin->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oFamiliaCodFin->getId() . '").val()==""){$("#' . $oFamiliaCodFin->getId() . '").val("999")}');

        $oFamiliaDesFin = new Campo('Descrição', 'famdesfin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFamiliaDesFin->setSIdPk($oFamiliaCodFin->getId());
        $oFamiliaDesFin->setClasseBusca('FamProd');
        $oFamiliaDesFin->addCampoBusca('famcod', '', '');
        $oFamiliaDesFin->addCampoBusca('famdes', '', '');
        $oFamiliaDesFin->setSIdTela($this->getTela()->getid());
        $oFamiliaDesFin->setBCampoBloqueado(true);

        $oFamiliaCodFin->setClasseBusca('FamProd');
        $oFamiliaCodFin->setSCampoRetorno('famcod', $this->getTela()->getId());
        $oFamiliaCodFin->addCampoBusca('famdes', $oFamiliaDesFin->getId(), $this->getTela()->getId());

        //-----------------------------------------------------------------------

        $oSubFamiliaCodFin = new Campo('Subfamília final', 'famsubfin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubFamiliaCodFin->setSValor(999);
        $oSubFamiliaCodFin->addEvento(Campo::EVENTO_SAIR, 'if($("#' . $oSubFamiliaCodFin->getId() . '").val()==""){$("#' . $oSubFamiliaCodFin->getId() . '").val("999")}');

        $oSubFamiliaDesFin = new Campo('Descrição', 'famsdesfin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubFamiliaDesFin->setSIdPk($oSubFamiliaCodFin->getId());
        $oSubFamiliaDesFin->setClasseBusca('FamSub');
        $oSubFamiliaDesFin->addCampoBusca('famsub', '', '');
        $oSubFamiliaDesFin->addCampoBusca('famsdes', '', '');
        $oSubFamiliaDesFin->setSIdTela($this->getTela()->getid());
        $oSubFamiliaDesFin->setBCampoBloqueado(true);

        $oSubFamiliaCodFin->setClasseBusca('FamSub');
        $oSubFamiliaCodFin->setSCampoRetorno('famsub', $this->getTela()->getId());
        $oSubFamiliaCodFin->addCampoBusca('famsdes', $oSubFamiliaDesFin->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------------------
        //FIM FINAL

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);
        
        //para mostrar a parte de imprimir a planilha no excel
        $oXls = new Campo('Exportar para Excel', 'sollib', Campo::TIPO_BOTAOSMALL, 2);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoLib = 'requestAjax("' . $this->getTela()->getId() . '-form","Cot","relatorioConsultaEstoqueExcel");';
        $oXls->getOBotao()->addAcao($sAcaoLib);

        $this->addCampos($oUsuario, array($oGrupoCod, $oGrupoDes, $oGrupoCodFin, $oGrupoDesFin), $oLinha1, array($oSubGrupoCod, $oSubGrupoDes, $oSubGrupoCodFin, $oSubGrupoDesFin), $oLinha1, array($oFamiliaCod, $oFamiliaDes, $oFamiliaCodFin, $oFamiliaDesFin), $oLinha1, array($oSubFamiliaCod, $oSubFamiliaDes, $oSubFamiliaCodFin, $oSubFamiliaDesFin), $oLinha1, $oXls);
    }

}
