<?php

/*
 * Classe que implementa as ordens de fabricação steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class ViewSTEEL_PCP_OrdensFab extends View {

     public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Analisar apontamentos!');
        $oBotaoModal->addAcao('STEEL_PCP_OrdensFab', 'criaTelaModalAponta', 'modalAponta');
        $this->addModais($oBotaoModal);

        $oBotaoFat = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_FLAG);
        $oBotaoFat->setBHideTelaAcao(true);
        $oBotaoFat->setILargura(15);
        $oBotaoFat->setSTitleAcao('Itens que vão para nota fiscal!');
        $oBotaoFat->addAcao('STEEL_PCP_OrdensFab', 'criaTelaModalFat', 'modalFat');
        $this->addModais($oBotaoFat);

        $oEmpCod = new CampoConsulta('Cnpj', 'emp_codigo');
        $oSeq = new CampoConsulta('Seq.Material', 'seqmat');
        $oOp = new CampoConsulta('Op', 'op');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oCodigo = new CampoConsulta('Codigo', 'prod');
        $oReferencia = new CampoConsulta('Referência', 'referencia');
        $oProdes = new CampoConsulta('Descrição', 'prodes');

        $Pendencia = new campoconsulta('--', 'pendencias');

        $oReceitaDes = new CampoConsulta('Receita', 'receita_des');
        $oQuant = new CampoConsulta('Quantidade', 'quant', CampoConsulta::TIPO_DECIMAL);
        $oPeso = new CampoConsulta('Peso', 'peso', CampoConsulta::TIPO_DECIMAL);
        $oRetrabalho = new CampoConsulta('Retr.', 'retrabalho', CampoConsulta::TIPO_TEXTO);
        
        $oOp_retrabalho = new CampoConsulta('Op.Retrabalho','op_retrabalho');
        $oSituacao = new CampoConsulta('Situação', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);

        $oDocumento = new CampoConsulta('NotaEnt', 'documento');
        $oTipOrdem = new CampoConsulta('Tipo', 'tipoOrdem');

        $oNrCarga = new campoconsulta('NºCarga', 'nrCarga');

      //  $oOpAntes = new CampoConsulta('Op anterior', 'opantes');
        
        $oReceita = new campoconsulta('Receita','receita');

        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oDescricaoFiltro = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 3);
       
        $oDocFiltro = new Filtro($oDocumento, Filtro::CAMPO_TEXTO_IGUAL, 1);

        $oTipoAcaoFiltro = new Filtro($oRetrabalho, Filtro::CAMPO_SELECT, 3, 2, 12, 12, true);
        $oTipoAcaoFiltro->addItemSelect('Todos', 'Todos');
        $oTipoAcaoFiltro->addItemSelect('Não', 'Não incluí retrab.');
        $oTipoAcaoFiltro->addItemSelect('Sim', 'Incluí');
        $oTipoAcaoFiltro->setSLabel('');
        $oTipoAcaoFiltro->setBInline(true);

        $oFiltroReferencia = new Filtro($oReferencia, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 2, 2);

        $oFilEmpresa = new Filtro($oEmpCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilEmpresa->setSClasseBusca('DELX_CAD_Pessoa');
        $oFilEmpresa->setSCampoRetorno('emp_codigo', $this->getTela()->getSId());
        $oFilEmpresa->setSIdTela($this->getTela()->getSId());
        
        $oFilData = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);


     //   $oOpAntesFiltro = new Filtro($oOpAntes, Filtro::CAMPO_TEXTO_IGUAL, 2);

        $oFiltroSit = new Filtro($oSituacao, Filtro::CAMPO_SELECT, 3, 2, 12, 12,true);
        $oFiltroSit->addItemSelect('Todos', 'Todos');
        $oFiltroSit->addItemSelect('Aberta', 'Aberta');
        $oFiltroSit->addItemSelect('Processo', 'Processo');
        $oFiltroSit->addItemSelect('Finalizado', 'Finalizado');
        $oFiltroSit->addItemSelect('Retornado', 'Retornado');
        $oFiltroSit->setSLabel('');
        $oFiltroSit->setBInline(true);
        
        $oFilRec = new Filtro($oReceita, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilRec->setSClasseBusca('STEEL_PCP_Receitas');
        $oFilRec->setSCampoRetorno('cod', $this->getTela()->getSId());
        $oFilRec->setSIdTela($this->getTela()->getSId());
        
        $oOFilOpret = new Filtro($oOp_retrabalho, Filtro::CAMPO_TEXTO_IGUAL,2,2,2,2);

        $this->addFiltro($oOpFiltro, $oCodigoFiltro, $oDescricaoFiltro, $oFilEmpresa, 
                $oDocFiltro, $oTipoAcaoFiltro, $oFiltroReferencia,
                $oFilRec,$oFilData,$oFiltroSit);

        $this->setUsaAcaoExcluir(FALSE);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(true);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->addCampos($oOp, $oBotaoModal, $oBotaoFat, $oSituacao, $oNrCarga, $Pendencia, $oData, $oCodigo, $oReferencia, $oProdes, $oPeso, $oRetrabalho, $oDocumento,$oReceita, $oTipOrdem);


        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_OrdensFab', 'acaoMostraRelEspecifico', '', false, 'OpSteel1', false, '', false, '', true);
        $oDrop2 = new Dropdown('Açao', Dropdown::TIPO_DARK);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Cancelar OP', 'STEEL_PCP_OrdensFab', 'msgCancelaOp', '', false, '');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Retornar para Aberta', 'STEEL_PCP_OrdensFab', 'msgAbertaOp', '', false, '');


        $oDrop3 = new Dropdown('Retrabalho', Dropdown::TIPO_AVISO);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Colocar em Retrabalho', 'STEEL_PCP_OrdensFab', 'msgRetrabalhoOp', '', false, '');

        $this->addDropdown($oDrop1, $oDrop2, $oDrop3);
        $this->getTela()->setiAltura(750);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcao = $this->getSRotina();

        $oDados = $this->getAParametrosExtras();

        $sClasse = get_class($oDados);

        $oOp = new Campo('Op nr.', 'op', Campo::TIPO_TEXTO, 1);
        $oOp->setBCampoBloqueado(true);


        $oOrigem = new Campo('Origem', 'origem', Campo::TIPO_TEXTO, 1);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsnfnro')) {
                $oOrigem->setSValor('Romaneio');
            } else {
                $oOrigem->setSValor('Manual');
            }
        } else {
            if (method_exists($oDados, 'getNfnro')) {
                $oOrigem->setSValor('XML');
            } else {
                $oOrigem->setSValor('Manual');
            }
        }
        $oOrigem->setBCampoBloqueado(true);

        $oL1 = new Campo('', 'l1', Campo::TIPO_LINHA);
        $oL1->setApenasTela(true);

        $oDocumento = new Campo('Doc.Fiscal', 'documento', Campo::TIPO_TEXTO, 1);
        $oDocumento->setBFocus(true);
        $oDocumento->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsnfnro')) {
                $oDocumento->setSValor($oDados->getNfsnfnro());
            }
        } else {
            if (method_exists($oDados, 'getNfnro')) {
                $oDocumento->setSValor($oDados->getNfnro());
            }
        }

       
        
        $oDataemi = new campo('Emissão','dataemidoc', Campo::TIPO_DATA,2,2,2,2);
        //$oDataemi->setSValor(date('d/m/Y'));
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsdtemiss')) {
                $oDataemi->setSValor(date('d/m/Y', strtotime($oDados->getNfsdtemiss())));//
             }
        } else {
            if (method_exists($oDados, 'getDataemidoc')) {
                $oDataemi->setSValor(date('d/m/Y', strtotime($oDados->getDataemidoc())));
            }
        }  
        
         
        
        $oSerie = new campo('Série','serie_nf', Campo::TIPO_TEXTO,1,1,1,1);
        //$oSerie->setSValor('1');
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsnfser')) {
                $oSerie->setSValor($oDados->getNfsnfser());
            }
        } else {
            if (method_exists($oDados, 'getNfnro')) {
                $oSerie->setSValor($oDados->getNfser());
            }
        } 
       
        
        $oTipo = new Campo('Tipo OP', 'tipoOrdem', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oTipo->addItemSelect('P', 'Padrão - Tempera');
        $oTipo->addItemSelect('F', 'Fio Máquina - Industrialização');
        $oTipo->addItemSelect('A', 'Arame - Venda');



        //cliente
        $oEmp_codigo = new Campo('Cliente', 'emp_codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            $oEmp_codigo->setSValor('75483040000211');
        } else {
            if (method_exists($oDados, 'getNfnro')) {
                $oEmp_codigo->setSValor($oDados->getEmpcod());
            }
        }
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);

        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social', 'emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '', '');
        $oEmp_des->addCampoBusca('emp_razaosocial', '', '');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            $oEmp_des->setSValor('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');
        } else {
            if (method_exists($oDados, 'getEmpdes')) {
                $oEmp_des->setSValor($oDados->getEmpdes());
            }
        }

        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial', $oEmp_des->getId(), $this->getTela()->getId());




        //campo código do produto
        $oCodigo = new Campo('Codigo.Interno', 'prod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsitcod')) {
                $oCodigo->setSValor($oDados->getNfsitcod());
            }
        } else {
            if (method_exists($oDados, 'getCodInterno')) {
                $oCodigo->setSValor($oDados->getCodInterno());
            }
        }


        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto', 'prodes', Campo::TIPO_BUSCADOBANCO, 5);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '', '');
        $oProdes->addCampoBusca('pro_descricao', '', '');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsitdes')) {
                $oProdes->setSValor($oDados->getNfsitdes());
            }
        } else {
            if (method_exists($oDados, 'getProdes')) {
                $oProdes->setSValor($oDados->getProdes());
            }
        }

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao', $oProdes->getId(), $this->getTela()->getId());

        //produto final
        $oProdFinal = new Campo('Produto.Final', 'prodFinal', Campo::TIPO_BUSCADOBANCOPK, 2);
        // $oProdFinal->setBCampoBloqueado(true);

        $oProdFinalDes = new Campo('DescFinal', 'prodesFinal', Campo::TIPO_BUSCADOBANCO, 5);
        $oProdFinalDes->setBOculto(true);
        $oProdFinalDes->setSIdPk($oProdFinal->getId());
        $oProdFinalDes->setClasseBusca('STEEL_PCP_pesqArame');
        $oProdFinalDes->addCampoBusca('pro_codigo', '', '');
        $oProdFinalDes->addCampoBusca('pro_descricao', '', '');
        $oProdFinalDes->setSIdTela($this->getTela()->getId());
        $oProdFinalDes->addValidacao(false, Validacao::TIPO_STRING);

        $oProdFinal->setClasseBusca('STEEL_PCP_pesqArame');
        $oProdFinal->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oProdFinal->addCampoBusca('pro_descricao', $oProdFinalDes->getId(), $this->getTela()->getId());
        //pesquisa produto material receita 
        $oBtnPesqOp = new Campo('Busca receita', 'btn1', Campo::TIPO_BOTAOSMALL, 2, 2, 2, 2);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $oBtnPesqOp->setApenasTela(true);
        //evento para buscar pela referencia            

        $sEventoReferencia = 'var codigo = $("#' . $oCodigo->getId() . '").val(); var tipoOrdem = $("#' . $oTipo->getId() . '").val();'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_Produtos",'
                . '"buscaProdutoReferencia","' . $oCodigo->getId() . ',' . $oProdes->getId() . '");';



        //referencia do produto do cliente
        $oReferencia = new campo('Referência  <span class="badge badge-warning">Para Metalbo não necessário informar</span>', 'referencia', Campo::TIPO_TEXTO, 6, 6, 6, 6);
        $oReferencia->setSCorFundo(Campo::FUNDO_AMARELO);
        //$oReferencia->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsitcod')) {
                $oReferencia->setSValor($oDados->getNfsitcod());
            }
        } else {
            if (method_exists($oDados, 'getProcod')) {
                $oReferencia->setSValor($oDados->getProcod());
            }
        }
        $oReferencia->addEvento(Campo::EVENTO_SAIR, $sEventoReferencia);

      //  $oOpAntes = new Campo('Op sistema anterior', 'opantes', Campo::TIPO_TEXTO, 3, 3, 3, 3);

        $oGridMat = new campo('Produto/Material/Receita', 'gridMat', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
        $oGridMat->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
        $oGridMat->setApenasTela(true);

        $oSeqMatGrid = new CampoConsulta('Seq.Mat.', 'seqmat');
        $oSeqMatGrid->setILargura(30);
        $oProDesGrid = new CampoConsulta('Produto', 'DELX_PRO_Produtos.pro_descricao');
        $oMatDesGrid = new CampoConsulta('Material', 'STEEL_PCP_material.matdes');
        $oRecDesGrid = new CampoConsulta('Receita', 'STEEL_PCP_receitas.peca');
        $oProdFinalGrid = new CampoConsulta('Produto Final', 'STEEL_PCP_pesqArame.pro_descricao');

        $oGridMat->addCampos($oSeqMatGrid, $oProDesGrid, $oMatDesGrid, $oRecDesGrid, $oProdFinalGrid);
        $oGridMat->setSController('STEEL_PCP_prodMatReceita');
        $oGridMat->addParam('seqmat', '0');
        $oGridMat->getOGrid()->setIAltura(90);





        //busca campo material
        $oCodMat = new Campo('Material', 'matcod', Campo::TIPO_TEXTO, 1);
        $oCodMat->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCodMat->setBCampoBloqueado(true);


        //busca material descrição
        $oMatDes = new Campo('Material Descrição', 'matdes', Campo::TIPO_TEXTO, 2);
        $oMatDes->setBCampoBloqueado(true);


        ///////////////////////////////////////////////////////////////////////////////
        //busca campo receita
        $oReceita = new Campo('Receita', 'receita', Campo::TIPO_TEXTO, 1);
        $oReceita->setSCorFundo(Campo::FUNDO_AMARELO);
        $oReceita->setBCampoBloqueado(true);
        $oReceitaDes = new Campo('Descrição', 'receita_des', Campo::TIPO_TEXTO, 3);
        $oReceitaDes->setBCampoBloqueado(true);

        $oSeqMat = new Campo('SeqMat', 'seqmat', Campo::TIPO_TEXTO, 1);
        $oSeqMat->addValidacao(false, Validacao::TIPO_STRING);
        $oSeqMat->setBCampoBloqueado(true);


        $oTempRev = new Campo('Temp.Rev', 'temprev', Campo::TIPO_DECIMAL, 1);
        //monta o evento para buscar receita padrão

        $sEvento1 = 'var codigo = $("#' . $oProdFinal->getId() . '").val(); var tipoOrdem = $("#' . $oTipo->getId() . '").val();'
                . 'if(codigo!==""){'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");'
                . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_Produtos","buscaReferencia","' . $oReferencia->getId() . '");'    //buscaReferencia   
                . 'if(tipoOrdem=="P"){$("#' . $oProdFinal->getId() . '").val(codigo);}}';

        $oProdFinal->addEvento(Campo::EVENTO_SAIR, $sEvento1);
        $oBtnPesqOp->getOBotao()->addAcao($sEvento1);
        $sEvento2 = ' var prodes = $("#' . $oProdes->getId() . '").val(); var codigo1 = $("#' . $oCodigo->getId() . '").val();var tipoOrdem = $("#' . $oTipo->getId() . '").val();'
                . 'if(tipoOrdem=="P"){$("#' . $oProdFinal->getId() . '").val(codigo1);$("#' . $oProdFinalDes->getId() . '").val(prodes);}';


        $oProdes->addEvento(Campo::EVENTO_SAIR, $sEvento2);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHA, 12);
        $oLinha->setApenasTela(true);

        $oQuant = new Campo('Quant{Peso ou CT}', 'quant', Campo::TIPO_DECIMAL, 2);
        $oQuant->setSValor('0,00');
        $oQuant->setSCorFundo(Campo::FUNDO_AMARELO);
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsitqtd')) {
                $oQuant->setSValor(number_format($oDados->getNfsitqtd(), 2, ',', '.'));
            }
        } else {
            if (method_exists($oDados, 'getQtd')) {
                $oQuant->setSValor(number_format($oDados->getQtd(), 2, ',', '.'));
            }
        }


        $oPeso = new Campo('Peso{Em KG * cáculo insumos e serviços}', 'peso', Campo::TIPO_DECIMAL, 4);
        $oPeso->setSValor('0,00');
        $oPeso->setSCorFundo(Campo::FUNDO_MONEY);
        $oPeso->addValidacao(false, Validacao::TIPO_STRING);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getPeso')) {
                $oPeso->setSValor(number_format($oDados->getPeso(), 2, ',', '.'));
            }
        } else {
            if (method_exists($oDados, 'getQtd')) {
                $oPeso->setSValor(number_format($oDados->getQtd(), 2, ',', '.'));
            }
        }


        $oValorUnit = new campo('Valor Unitário', 'vlrNfEntUnit', Campo::TIPO_DECIMAL, 1);
        $oValorUnit->setSValor('0,00');
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getVlrNfEntUnit')) {
                $oValorUnit->setSValor(number_format($oDados->getVlrNfEntUnit(), 2, ',', '.'));
            }
        } else {
            if (method_exists($oDados, 'getVlrUnit')) {
                $oValorUnit->setSValor(number_format($oDados->getVlrUnit(), 2, ',', '.'));
            }
        }

        $oValorEnt = new campo('Valor Total', 'vlrNfEnt', Campo::TIPO_DECIMAL, 1);
        $oValorEnt->setSValor('0,00');
        $oValorEnt->setBCampoBloqueado(true);
        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getVlrNfEnt')) {
                $oValorEnt->setSValor(number_format($oDados->getVlrNfEnt(), 2, ',', '.'));
            }
        } else {
            if (method_exists($oDados, 'getVlrTotal')) {
                $oValorEnt->setSValor(number_format($oDados->getVlrTotal(), 2, ',', '.'));
            }
        }

        $sEventoCalculo = 'precoNfEntradaSteel("' . $oQuant->getId() . '","' . $oValorUnit->getId() . '","' . $oValorEnt->getId() . '");';


        //eventos
        $oQuant->addEvento(Campo::EVENTO_SAIR, $sEventoCalculo);

        $oPeso->addEvento(Campo::EVENTO_SAIR, $sEventoCalculo);

        $oValorUnit->addEvento(Campo::EVENTO_SAIR, $sEventoCalculo);




        $oOpCli = new Campo('OP do cliente', 'opcliente', Campo::TIPO_TEXTO, 2);
        if (method_exists($oDados, 'getMetof')) {
            $oOpCli->setSValor($oDados->getMetof());
        } else {
            if (method_exists($oDados, 'getOpCliente')) {
                $oOpCli->setSValor($oDados->getOpCliente());
            }
        }


        $oObs = new campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 8);
        $oDataPrev = new Campo('Data prevista', 'dataprev', Campo::TIPO_DATA, 2);
        $oDataPrev->setSValor(date('d/m/Y', strtotime('+7 days')));

        $oNrCarga = new campo('NºCargaDev', 'nrCarga', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oNrCarga->setBCampoBloqueado(true);
        $oNrCarga->setSValor('Sem Carga');

        $oXPed = new campo('xPed*{Número OD/OC para sair no xml}', 'xPed', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        if ($sClasse == 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getXPed')) {
                $oXPed->setSValor($oDados->getXPed());
            }
        }

        $nItemPed = new campo('Seq. OD/OC para sair no xml', 'nItemPed', Campo::TIPO_TEXTO, 3, 3, 3, 3);
        if ($sClasse == 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNItemPed')) {
                $nItemPed->setSValor($oDados->getNItemPed());
            }
        }

        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));

        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 2);
        $oHora->setBCampoBloqueado(true);
        $oHora->setSValor(date('H:i'));

        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);

        $oSeqProdNr = new Campo('Seq.Rom', 'seqprodnf', Campo::TIPO_TEXTO, 1);
        $oSeqProdNr->setBCampoBloqueado(true);


        $oSituacao = new Campo('Situação', 'situacao', Campo::TIPO_TEXTO, 1);
        $oSituacao->setBCampoBloqueado(true);
        $oSituacao->setSValor('Aberta');

        if ($sClasse !== 'ModelSTEEL_PCP_ImportaXml') {
            if (method_exists($oDados, 'getNfsitseq')) {
                $oSeqProdNr->setSValor($oDados->getNfsitseq());
            }
        } else {
            if (method_exists($oDados, 'getSeq')) {
                $oSeqProdNr->setSValor($oDados->getSeq());
            }
        }

        //ativa o fechamento da tela ao inserir
        $this->getTela()->setBFecharTelaIncluir(true);

        //evento click, parametros=>idgrid,pk,codMaterial,DescMaterial,codReceita,DescReceita,SeqMat
        $oGridMat->getOGrid()->setSEventoClick('var chave=""; $("#' . $oGridMat->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'if(chave!==""){requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","sendDadosCampos","' . $oGridMat->getId() . '"+","+chave+","+"' . $oCodMat->getId() . '"+",'
                . '"+"' . $oMatDes->getId() . '"+","+"' . $oReceita->getId() . '"+","+"' . $oReceitaDes->getId() . '"+","+"' . $oSeqMat->getId() . '"+","+"' . $oTempRev->getId() . '");} ');


        if ($sAcao == 'acaoAlterar') {
            $sAcaoBuscaIni = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");';
            $this->getTela()->setSAcaoShow($sAcaoBuscaIni);
        }

        $oField1 = new FieldSet('Retrabalho');

        $oRetrabalho = new Campo('Retrabalho', 'retrabalho', Campo::CAMPO_SELECTSIMPLE, 4, 4, 4, 4, 4);
        $oRetrabalho->setSValor('Não');
        $oRetrabalho->addItemSelect('Não', 'Não');
        $oRetrabalho->addItemSelect('Sim', 'Sim');
        $oRetrabalho->addItemSelect('Sim S/Cobrança', 'Sim S/Cobrança');
        $oRetrabalho->addItemSelect('Retorno não Ind.', 'Retorno não Ind.');
        $oRetrabalho->addItemSelect('OP origem retrabalho', 'OP origem retrabalho *Não entra estoque');

        $oOpRet = new Campo('Op Origem Retra.', 'op_retrabalho', Campo::TIPO_TEXTO, 2);
        $oOpRet->setBCampoBloqueado(false);

        $oRnc = new campo('RNC', 'rnc', Campo::TIPO_TEXTO, 2);


        $oField1->addCampos(array($oRetrabalho, $oOpRet, $oRnc));
        $oField1->setOculto(true);

        $oNrcert = new Campo('Certificado', 'nrcert', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oNrcert->setBCampoBloqueado(true);

        $oField2 = new FieldSet('Pendências');
        $oPendencia = new campo('Pendências', 'pendencias', Campo::TIPO_TEXTO, 1);
        $oPendencia->setBCampoBloqueado(true);
        $oPendenciaObs = new campo('Pendência Obs', 'pendenciasobs', Campo::TIPO_TEXTAREA, 6);
        $oPendenciaObs->setILinhasTextArea(6);
        $oPendenciaObs->setBCampoBloqueado(true);
        $oField2->setOculto(true);
        $oField2->addCampos($oPendencia, $oPendenciaObs);


        $this->addCampos(array($oOp, $oOrigem, $oData, $oHora, $oUser, $oSeqProdNr, $oSituacao), $oLinha, 
                array($oDocumento,$oDataemi,$oSerie),$oLinha,
                array($oEmp_codigo, $oEmp_des, $oTipo), $oLinha, array($oReferencia), $oLinha, array($oCodigo, $oProdes), $oLinha, array($oProdFinal, $oProdFinalDes, $oBtnPesqOp), $oLinha, $oGridMat, $oLinha, array($oCodMat, $oMatDes, $oReceita, $oReceitaDes, $oSeqMat), $oLinha, array($oOpCli, $oQuant, $oPeso, $oValorUnit, $oValorEnt, $oTempRev), $oLinha, $oObs, $oLinha, array($oDataPrev, $oNrCarga, $oXPed, $nItemPed, $oNrcert), $oField1, $oField2);
    }

    /*
     * 
     */

    public function RelOpSteel2() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Estoque / OPS');
        $this->setBTela(true);



        $oDatainicial = new Campo('Data Incial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');
        //novo
        $oSituaRel = new Campo('Situação', 'situa', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituaRel->addItemSelect('Todas', 'Todas');
        $oSituaRel->addItemSelect('Aberta', 'Aberta');
        $oSituaRel->addItemSelect('Cancelada', 'Cancelada');
        $oSituaRel->addItemSelect('Finalizado', 'Finalizado');
        $oSituaRel->addItemSelect('Retornado', 'Retornado');
        $oSituaRel->addItemSelect('Processo', 'Processo');

        $sLabel = new campo('* Todas exceto Retornado e Cancelado', 'obs', Campo::TIPO_LABEL, 3, 3, 3);
        $sLabel->setApenasTela(true);
        $sLabel->setIMarginTop(20);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        //cliente
        $oEmp_codigo = new Campo('Cliente', 'emp_codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oEmp_codigo->setSValor('');


        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social', 'emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '', '');
        $oEmp_des->addCampoBusca('emp_razaosocial', '', '');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('');

        $oRetrabalho = new Campo('Retrabalho', 'retrabalho', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3, 3);
        $oRetrabalho->setSValor('Incluir');
        $oRetrabalho->addItemSelect('Incluir', 'Incluir');
        $oRetrabalho->addItemSelect('Não', 'Não');
        $oRetrabalho->addItemSelect('Sim', 'Sim');
        $oRetrabalho->addItemSelect('Sim S/Cobrança', 'Sim S/Cobrança');
        $oRetrabalho->addItemSelect('Retorno não Ind.', 'Retorno não Ind.');
        $oRetrabalho->addItemSelect('OP origem retrabalho', 'OP origem retrabalho *Não entra estoque');

        $sLabe2 = new campo('<h5 style="color:red">* Ops de retorno não industrializado não somam no estoque apenas se escolher a opção retorno não ind. Ops que originam retrabalho interno não entram no estoque.</h5>', 'obs2', Campo::TIPO_LABEL, 3, 3, 3);
        $sLabe2->setApenasTela(true);
        $sLabe2->setIMarginTop(3);

        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial', $oEmp_des->getId(), $this->getTela()->getId());

        //para mostrar a parte de imprimir a planilha no excel
        $oXls = new Campo('Exportar para Excel', 'sollib', Campo::TIPO_BOTAOSMALL, 1);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoLib = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFab","relatorioExcelOp");';
        $oXls->getOBotao()->addAcao($sAcaoLib);

        $this->addCampos(array($oDatainicial, $oDatafinal), $oLinha1, array($oEmp_codigo, $oEmp_des), $oLinha1, array($oSituaRel, $sLabel), $oLinha1, $oRetrabalho, $sLabe2, $oLinha1, $oXls);
    }

    public function RelOpSteelForno() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de ordens de produção apontadas por forno');
        $this->setBTela(true);

        $oDatainicial = new Campo('Data Entrada', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Saída', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');

        //Situação
        $oSituaRel = new Campo('Situação', 'situa', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituaRel->addItemSelect('Finalizado', 'Finalizado');
        $oSituaRel->addItemSelect('Todas', 'Todas');
        $oSituaRel->addItemSelect('Finalizado', 'Finalizado');
        $oSituaRel->addItemSelect('Processo', 'Processo');

        //cliente
        $oEmp_codigo = new Campo('Cliente', 'emp_codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oEmp_codigo->setSValor('');


        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social', 'emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '', '');
        $oEmp_des->addCampoBusca('emp_razaosocial', '', '');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('');

        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial', $oEmp_des->getId(), $this->getTela()->getId());

        //busca do forno

        $oFornoCod = new Campo('Forno', 'fornocod', Campo::TIPO_BUSCADOBANCOPK, 2);


        //campo descrição do forno adicionando o campo de busca
        $oFornodes = new Campo('Descrição Forno', 'fornodes', Campo::TIPO_BUSCADOBANCO, 4);
        $oFornodes->setSIdPk($oFornoCod->getId());
        $oFornodes->setClasseBusca('STEEL_PCP_Forno');
        $oFornodes->addCampoBusca('FornoCod', '', '');
        $oFornodes->addCampoBusca('fornodes', '', '');
        $oFornodes->setSIdTela($this->getTela()->getId());
        $oFornodes->setSValor('');

        //declarar o campo descrição
        $oFornoCod->setClasseBusca('STEEL_PCP_Forno');
        $oFornoCod->setSCampoRetorno('fornocod', $this->getTela()->getId());
        $oFornoCod->addCampoBusca('fornodes', $oFornodes->getId(), $this->getTela()->getId());

        $oRetrabalho = new Campo('Retrabalho', 'retrabalho', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3, 3);
        $oRetrabalho->setSValor('Incluir');
        $oRetrabalho->addItemSelect('Incluir', 'Incluir');
        $oRetrabalho->addItemSelect('Não', 'Não');
        $oRetrabalho->addItemSelect('Sim', 'Sim');
        $oRetrabalho->addItemSelect('Sim S/Cobrança', 'Sim S/Cobrança');
        $oRetrabalho->addItemSelect('Retorno não Ind.', 'Retorno não Ind.');

        $sLabe2 = new campo('<h5 style="color:red">* Ops de retorno não industrializado não entram apenas se escolher a opção retorno não ind.</h5>', 'obs2', Campo::TIPO_LABEL, 3, 3, 3);
        $sLabe2->setApenasTela(true);
        $sLabe2->setIMarginTop(3);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);
        
        $oXls = new Campo('Exportar para Excel', 'sollib', Campo::TIPO_BOTAOSMALL, 2,2,2,2);
$oXls->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);
$sAcaoLib = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFab","relatorioExcelApontamentos");';
$oXls->getOBotao()->addAcao($sAcaoLib);

$this->addCampos(array($oDatainicial, $oDatafinal), $oLinha1, array($oFornoCod, $oFornodes), $oLinha1, array($oEmp_codigo, $oEmp_des), $oLinha1, array($oSituaRel), $oLinha1, $oRetrabalho, $sLabe2, $oXls);

     //   $this->addCampos(array($oDatainicial, $oDatafinal), $oLinha1, array($oFornoCod, $oFornodes), $oLinha1, array($oEmp_codigo, $oEmp_des), $oLinha1, array($oSituaRel), $oLinha1, $oRetrabalho, $sLabe2);
    }

    public function criaModalAponta() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oOp = new Campo('OP', 'op', Campo::TIPO_TEXTO, 2);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);

        $oForno = new Campo('Forno', 'fornodes', Campo::TIPO_TEXTO, 2);
        $oForno->setSValor($oDados->getFornodes());
        $oForno->setBCampoBloqueado(true);

        $oCod = new Campo('Código', 'procod', Campo::TIPO_TEXTO, 2);
        $oCod->setSValor($oDados->getProcod());
        $oCod->setBCampoBloqueado(true);

        $oDes = new Campo('Descrição do Produto', 'prodes', Campo::TIPO_TEXTO, 6, 6, 6, 6);
        $oDes->setSValor($oDados->getProdes());
        $oDes->setBCampoBloqueado(true);

        $oDtEnt = new Campo('Data Entrada', 'dataent_forno', Campo::TIPO_TEXTO, 2);
        if ($oDados->getOp() != null) {
            $oDtEnt->setSValor(date('d/m/Y', strtotime($oDados->getDataent_forno())));
        }
        $oDtEnt->setBCampoBloqueado(true);

        $oHoEnt = new Campo('Hora Entrada', 'horaent_forno', Campo::TIPO_TEXTO, 2);
        if ($oDados->getOp() != null) {
            $oHoEnt->setSValor(date('H:i:s', strtotime($oDados->getHoraent_forno())));
        }
        $oHoEnt->setBCampoBloqueado(true);

        $oDtSai = new Campo('Data Saída', 'datasaida_forno', Campo::TIPO_TEXTO, 2);
        if ($oDados->getOp() != null && $oDados->getUsernomesaida() != null) {
            $oDtSai->setSValor(date('d/m/Y', strtotime($oDados->getDatasaida_forno())));
        }
        $oDtSai->setBCampoBloqueado(true);

        $oHoSai = new Campo('Hora Saída', 'horasaida_forno', Campo::TIPO_TEXTO, 2);
        if ($oDados->getOp() != null && $oDados->getUsernomesaida() != null) {
            $oHoSai->setSValor(date('H:i:s', strtotime($oDados->getHorasaida_forno())));
        }
        $oHoSai->setBCampoBloqueado(true);

        $oSit = new Campo('Situação', 'situacao', Campo::TIPO_TEXTO, 2);
        $oSit->setSValor($oDados->getSituacao());
        $oSit->setBCampoBloqueado(true);

        $oCodE = new Campo('Cod.', 'coduser', Campo::TIPO_TEXTO, 2);
        $oCodE->setSValor($oDados->getCoduser());
        $oCodE->setBCampoBloqueado(true);

        $oUserE = new Campo('Usuário Entrada', 'usernome', Campo::TIPO_TEXTO, 2);
        $oUserE->setSValor($oDados->getUsernome());
        $oUserE->setBCampoBloqueado(true);

        $oCodSai = new Campo('Cod.', 'codusersaida', Campo::TIPO_TEXTO, 2);
        $oCodSai->setSValor($oDados->getCodusersaida());
        $oCodSai->setBCampoBloqueado(true);

        $oUserS = new Campo('Usuário Saída', 'usernomesaida', Campo::TIPO_TEXTO, 2);
        $oUserS->setSValor($oDados->getUsernomesaida());
        $oUserS->setBCampoBloqueado(true);

        $oDiv = new campo('Entradas', 'div', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
        $oDiv->setApenasTela(true);

        $oDiv1 = new campo('Saídas', 'div1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDiv1->setApenasTela(true);

        $sLinha = new Campo('', 'label', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);



        $this->addCampos(array($oOp, $oForno, $oCod, $oDes), $oDiv, $sLinha, array($oDtEnt, $oHoEnt, $oUserE), $sLinha, $oDiv1, $sLinha, array($oDtSai, $oHoSai, $oUserS));
    }

    public function criaModalFat($aOp) {
        parent::criaModal();

        $this->setBTela(true);

        //carrega a op
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $aOp[1]);
        $oDadosOp = $oOp->Persistencia->consultarWhere();
        $_REQUEST['campos'] = 'emp_codigo=' . $oDadosOp->getEmp_codigo();

        $oOp->Model = $oDadosOp;

        $aDados = $oOp->pendenciasOP($aOp);

        $oTabela = new Campo('Tabela de preço', 'tabpreco', Campo::TIPO_TEXTO, 4);
        $oTabela->setSValor($aDados['tabela']);
        $oTabela->setBCampoBloqueado(true);
        $oNcm = new campo('Ncm retorno', 'ncm', Campo::TIPO_TEXTO, 3);
        $oNcm->setSValor($aDados['ncm']);
        $oNcm->setBNCM(true);
        $oNcm->setBCampoBloqueado(true);
        $oTipoOP = new campo('Tipo OP', 'tipoOp', Campo::TIPO_TEXTO, 3);
        $oTipoOP->setBCampoBloqueado(true);
        //define o tipo da op

        switch ($oOp->Model->getTipoOrdem()) {
            case 'P':
                $oTipoOP->setSValor('Padrão - Têmpera');
                break;
            case 'F':
                $oTipoOP->setSValor('Fio Máquina - Industrialização');
                break;
            case 'A':
                $oTipoOP->setSValor('Arame - Venda');
                break;
            default:
                $oTipoOP->setSValor('Padrão');
        }

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHA, 12);
        $oRetorno = new Campo('Retorno', 'retorno', Campo::TIPO_TEXTO, 6);
        $oRetorno->setSValor($oDadosOp->getProdesFinal());
        $oRetorno->setBCampoBloqueado(true);
        $oQuantRet = new Campo('Qt.Retorno', 'qtRetorno', Campo::TIPO_DECIMAL, 2);
        $oQuantRet->setBCampoBloqueado(true);
        $oQuantRet->setSValor(number_format($oDadosOp->getQuant(), 2, ',', '.'));
        $oPesoRet = new campo('Peso.Retorno', 'pesoRetorno', Campo::TIPO_DECIMAL, 2);
        $oPesoRet->setBCampoBloqueado(true);
        $oPesoRet->setSValor(number_format($oDadosOp->getPeso(), 2, ',', '.'));
        $oValorTotRet = new campo('Vlr.Total', 'vlrTotRetorno', Campo::TIPO_DECIMAL, 2);
        $oValorTotRet->setBCampoBloqueado(true);
        $oValorTotRet->setSValor(number_format($oDadosOp->getVlrNfEnt(), 2, ',', '.'));

        $oGrid = new Campo('', 'insumo', Campo::TIPO_GRIDVIEW, 12, 12, 12, 12);
        $oGrid->addCabGridView('Insumo');
        $oGrid->addCabGridView('Descrição do insumo');
        $oGrid->addCabGridView('Quantidade');
        $oGrid->addCabGridView('Valor');
        $oGrid->addCabGridView('Total');

        $oGrid1 = new Campo('', 'servico', Campo::TIPO_GRIDVIEW, 12, 12, 12, 12);
        $oGrid1->addCabGridView('Serviço');
        $oGrid1->addCabGridView('Descrição do serviço');
        $oGrid1->addCabGridView('Quantidade');
        $oGrid1->addCabGridView('Valor');
        $oGrid1->addCabGridView('Total');


        $this->addCampos(array($oTabela, $oNcm, $oTipoOP), $oLinha, array($oRetorno, $oQuantRet, $oPesoRet, $oValorTotRet), $oLinha);

        foreach ($aDados['insumo'] as $keyInsumo => $oInsumo) {
            $oGrid->addLinhasGridView(1, $oInsumo->getProd());
            $oGrid->addLinhasGridView(1, $oInsumo->getSTEEL_PCP_Produtos()->getPro_descricao());
            $oGrid->addLinhasGridView(1, number_format($oDadosOp->getPeso(), 2, ',', '.'));
            $oGrid->addLinhasGridView(1, number_format($oInsumo->getPreco(), 2, ',', '.'));
            $TotalInsumo = $oDadosOp->getPeso() * $oInsumo->getPreco();
            $oGrid->addLinhasGridView(1, number_format($TotalInsumo, 2, ',', '.'));
        }
        $this->addCampos($oGrid);

        foreach ($aDados['servico'] as $keyServico => $oServico) {
            $oGrid1->addLinhasGridView(1, $oServico->getProd());
            $oGrid1->addLinhasGridView(1, $oServico->getSTEEL_PCP_Produtos()->getPro_descricao());
            $oGrid1->addLinhasGridView(1, number_format($oDadosOp->getPeso(), 2, ',', '.'));
            $oGrid1->addLinhasGridView(1, number_format($oServico->getPreco(), 2, ',', '.'));
            $TotalServico = $oDadosOp->getPeso() * $oServico->getPreco();
            $oGrid1->addLinhasGridView(1, number_format($TotalServico, 2, ',', '.'));
        }
        $this->addCampos($oGrid1);
    }

    /**
     * Relatório de ordens de fabricação e faturamento
     */
    public function RelOpFat() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Ordens de produção / Faturamento');
        $this->setBTela(true);

        $oDatainicial = new Campo('Data Incial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        //cliente
        $oEmp_codigo = new Campo('Cliente', 'emp_codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oEmp_codigo->setSValor('');

        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social', 'emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '', '');
        $oEmp_des->addCampoBusca('emp_razaosocial', '', '');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('');

        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial', $oEmp_des->getId(), $this->getTela()->getId());

        //informar nr da nota sem serie
        $oNotaFiscal = new campo('Nota Fiscal *Não informar série ', 'nf_ent', Campo::TIPO_TEXTO, 3, 3, 3, 3);

        //para mostrar a parte de imprimir a planilha no excel
        $oXls = new Campo('Exportar para Excel', 'sollib', Campo::TIPO_BOTAOSMALL, 1);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoLib = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OrdensFab","relatorioExcelOp");';
        $oXls->getOBotao()->addAcao($sAcaoLib);

        $oSituacao = new Campo('Situação', 'situaca', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oSituacao->addItemSelect("Todos", "Todos");
        $oSituacao->addItemSelect("Retornado", "Retornados");
        $oSituacao->addItemSelect("Não Retornados", "Não Retornados");

        $oRetrabalho = new Campo('Retrabalho', 'retrabalho', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3, 3);
        $oRetrabalho->setSValor('Incluir');
        $oRetrabalho->addItemSelect('Incluir', 'Incluir');
        $oRetrabalho->addItemSelect('Não', 'Não');
        $oRetrabalho->addItemSelect('Sim', 'Sim');
        $oRetrabalho->addItemSelect('Sim S/Cobrança', 'Sim S/Cobrança');
        $oRetrabalho->addItemSelect('Retorno não Ind.', 'Retorno não Ind.');

        $sLabe2 = new campo('<h5 style="color:red">* Ops de retorno não industrializado não entram apenas se escolher a opção retorno não ind.</h5>', 'obs2', Campo::TIPO_LABEL, 3, 3, 3);
        $sLabe2->setApenasTela(true);
        $sLabe2->setIMarginTop(3);

        $this->addCampos(array($oDatainicial, $oDatafinal), $oLinha1, array($oEmp_codigo, $oEmp_des), $oLinha1, $oNotaFiscal, $oLinha1, array($oSituacao), $oLinha1, $oRetrabalho, $sLabe2);
    }

    public function RelOpSteelNaoApont() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de ordens de produção não apontadas / Apontamentos incorretos');
        $this->setBTela(true);

        $oDatainicial = new Campo('Data Entrada', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Saída', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');

        $oField2 = new FieldSet('Relatório Apontamentos incorretos');
        $oField2->setOculto(true);
        $oCheck1 = new Campo('Apontamentos finalizados com usuário final em branco', 'check1', Campo::TIPO_CHECK, 6, 6, 12, 12);
        $oField2->addCampos($oCheck1);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $this->addCampos(array($oDatainicial, $oDatafinal), $oLinha1, $oField2/* ,$oLinha1,array($oFornoCod,$oFornodes),$oLinha1,array($oEmp_codigo, $oEmp_des),$oLinha1,array($oSituaRel),$oLinha1,$oRetrabalho,$sLabe2 */);
    }

    public function RelFaturamento() {
        parent::criaTelaRelatorio();
              
        //Relatório Faturamento
        $this->setTituloTela('Relatório de faturamento');
        $this->setBTela(true);
        $aDados = $this->getAParametrosExtras();

        $oDatainicial = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');

        //cliente
        $oEmp_codigo = new Campo('Cliente', 'emp_codigo', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oEmp_codigo->setSValor('');

        //campo descrição do cliente adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social', 'emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '', '');
        $oEmp_des->addCampoBusca('emp_razaosocial', '', '');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('');

        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial', $oEmp_des->getId(), $this->getTela()->getId());

        
        $oCodigo = new Campo('Produto','prod',Campo::TIPO_BUSCADOBANCOPK,2);
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto Descrição','DELX_PRO_Produtos.pro_descricao',Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '','');
        $oProdes->addCampoBusca('pro_descricao', '','');
        $oProdes->setSIdTela($this->getTela()->getId());
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oProdes->getId(),  $this->getTela()->getId());
        
        
        //Grupo
        $oGrupoCod = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oGrupoCod->setSValor(0);
        $oGrupoCod->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oGrupoCod->getId() . '").val()==""){$("#' . $oGrupoCod->getId() . '").val("0")}');
        //-----------------------------------------------------------

        $oGrupoDes = new Campo('Descrição', 'DELX_PRO_Grupo.pro_grupodescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oGrupoDes->setSIdPk($oGrupoCod->getId());
        $oGrupoDes->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoDes->addCampoBusca('pro_grupocodigo', '', '');
        $oGrupoDes->addCampoBusca('pro_grupodescricao', '', '');
        $oGrupoDes->setSIdTela($this->getTela()->getid());
        $oGrupoDes->setBCampoBloqueado(true);

        $oGrupoCod->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoCod->setSCampoRetorno('pro_grupocodigo', $this->getTela()->getId());
        $oGrupoCod->addCampoBusca('pro_grupodescricao', $oGrupoDes->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------

        $oSubGrupoCod = new Campo('Sub.Grupo', 'pro_subgrupocodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubGrupoCod->setSValor(0);
        $oSubGrupoCod->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oSubGrupoCod->getId() . '").val()==""){$("#' . $oSubGrupoCod->getId() . '").val("0")}');

        $oSubGrupoDes = new Campo('Descrição', 'DELX_PRO_Subgrupo.pro_subgrupodescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubGrupoDes->setSIdPk($oSubGrupoCod->getId());
        $oSubGrupoDes->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoDes->addCampoBusca('pro_subgrupocodigo', '', '');
        $oSubGrupoDes->addCampoBusca('pro_subgrupodescricao', '', '');
        $oSubGrupoDes->setSIdTela($this->getTela()->getid());
        $oSubGrupoDes->setBCampoBloqueado(true);


        $oSubGrupoCod->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoCod->setSCampoRetorno('pro_subgrupocodigo', $this->getTela()->getId());
        $oSubGrupoCod->addCampoBusca('pro_subgrupodescricao', $oSubGrupoDes->getId(), $this->getTela()->getId());

        //----------------------------------------------------------------

        $oFamiliaCod = new Campo('Família', 'pro_familiacodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFamiliaCod->setSValor(0);
        $oFamiliaCod->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oFamiliaCod->getId() . '").val()==""){$("#' . $oFamiliaCod->getId() . '").val("0")}');

        $oFamiliaDes = new Campo('Descrição', 'DELX_PRO_Familia.pro_familiadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFamiliaDes->setSIdPk($oFamiliaCod->getId());
        $oFamiliaDes->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaDes->addCampoBusca('pro_familiacodigo', '', '');
        $oFamiliaDes->addCampoBusca('pro_familiadescricao', '', '');
        $oFamiliaDes->setSIdTela($this->getTela()->getid());
        $oFamiliaDes->setBCampoBloqueado(true);


        $oFamiliaCod->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaCod->setSCampoRetorno('pro_familiacodigo', $this->getTela()->getId());
        $oFamiliaCod->addCampoBusca('pro_familiadescricao', $oFamiliaDes->getId(), $this->getTela()->getId());

        //-----------------------------------------------------------------------

        $oSubFamiliaCod = new Campo('Sub.Fam', 'pro_subfamiliacodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubFamiliaCod->setSValor(0);
        $oSubFamiliaCod->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oSubFamiliaCod->getId() . '").val()==""){$("#' . $oSubFamiliaCod->getId() . '").val("0")}');

        $oSubFamiliaDes = new Campo('Descrição', 'DELX_PRO_Subfamilia.pro_subfamiliadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubFamiliaDes->setSIdPk($oSubFamiliaCod->getId());
        $oSubFamiliaDes->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaDes->addCampoBusca('pro_subfamiliacodigo', '', '');
        $oSubFamiliaDes->addCampoBusca('pro_subfamiliadescricao', '', '');
        $oSubFamiliaDes->setSIdTela($this->getTela()->getid());
        $oSubFamiliaDes->setBCampoBloqueado(true);

        $oSubFamiliaCod->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaCod->setSCampoRetorno('pro_subfamiliacodigo', $this->getTela()->getId());
        $oSubFamiliaCod->addCampoBusca('pro_subfamiliadescricao', $oSubFamiliaDes->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------------------
        
        //FINAL
        
        //Grupo
        $oGrupoCodFin = new Campo('GrupoFinal', 'pro_grupocodigofin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oGrupoCodFin->setSValor(99999);
        $oGrupoCodFin->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oGrupoCodFin->getId() . '").val()==""){$("#' . $oGrupoCodFin->getId() . '").val("99999")}');
        //-----------------------------------------------------------

        $oGrupoDesFin = new Campo('DescriçãoFinal', 'pro_grupodescricaofin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oGrupoDesFin->setSIdPk($oGrupoCodFin->getId());
        $oGrupoDesFin->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoDesFin->addCampoBusca('pro_grupocodigo', '', '');
        $oGrupoDesFin->addCampoBusca('pro_grupodescricao', '', '');
        $oGrupoDesFin->setSIdTela($this->getTela()->getid());
        $oGrupoDesFin->setBCampoBloqueado(true);

        $oGrupoCodFin->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoCodFin->setSCampoRetorno('pro_grupocodigo', $this->getTela()->getId());
        $oGrupoCodFin->addCampoBusca('pro_grupodescricao', $oGrupoDesFin->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------

        $oSubGrupoCodFin = new Campo('Sub.GrupoFinal', 'pro_subgrupocodigofin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubGrupoCodFin->setSValor(99999);
        $oSubGrupoCodFin->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oSubGrupoCodFin->getId() . '").val()==""){$("#' . $oSubGrupoCodFin->getId() . '").val("99999")}');

        $oSubGrupoDesFin = new Campo('DescriçãoFinal', 'pro_subgrupodescricaofin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubGrupoDesFin->setSIdPk($oSubGrupoCodFin->getId());
        $oSubGrupoDesFin->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoDesFin->addCampoBusca('pro_subgrupocodigo', '', '');
        $oSubGrupoDesFin->addCampoBusca('pro_subgrupodescricao', '', '');
        $oSubGrupoDesFin->setSIdTela($this->getTela()->getid());
        $oSubGrupoDesFin->setBCampoBloqueado(true);

        $oSubGrupoCodFin->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoCodFin->setSCampoRetorno('pro_subgrupocodigo', $this->getTela()->getId());
        $oSubGrupoCodFin->addCampoBusca('pro_subgrupodescricao', $oSubGrupoDesFin->getId(), $this->getTela()->getId());

        //----------------------------------------------------------------

        $oFamiliaCodFin = new Campo('Família', 'pro_familiacodigofin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFamiliaCodFin->setSValor(99999);
        $oFamiliaCodFin->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oFamiliaCodFin->getId() . '").val()==""){$("#' . $oFamiliaCodFin->getId() . '").val("99999")}');

        $oFamiliaDesFin = new Campo('Descrição', 'pro_familiadescricaofin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFamiliaDesFin->setSIdPk($oFamiliaCodFin->getId());
        $oFamiliaDesFin->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaDesFin->addCampoBusca('pro_familiacodigo', '', '');
        $oFamiliaDesFin->addCampoBusca('pro_familiadescricao', '', '');
        $oFamiliaDesFin->setSIdTela($this->getTela()->getid());
        $oFamiliaDesFin->setBCampoBloqueado(true);

        $oFamiliaCodFin->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaCodFin->setSCampoRetorno('pro_familiacodigo', $this->getTela()->getId());
        $oFamiliaCodFin->addCampoBusca('pro_familiadescricao', $oFamiliaDesFin->getId(), $this->getTela()->getId());

        //-----------------------------------------------------------------------

        $oSubFamiliaCodFin = new Campo('Sub.Fam', 'pro_subfamiliacodigofin', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSubFamiliaCodFin->setSValor(99999);
        $oSubFamiliaCodFin->addEvento(Campo::EVENTO_SAIR,'if($("#' . $oSubFamiliaCodFin->getId() . '").val()==""){$("#' . $oSubFamiliaCodFin->getId() . '").val("99999")}');

        $oSubFamiliaDesFin = new Campo('Descrição', 'pro_subfamiliadescricaofin', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubFamiliaDesFin->setSIdPk($oSubFamiliaCodFin->getId());
        $oSubFamiliaDesFin->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaDesFin->addCampoBusca('pro_subfamiliacodigo', '', '');
        $oSubFamiliaDesFin->addCampoBusca('pro_subfamiliadescricao', '', '');
        $oSubFamiliaDesFin->setSIdTela($this->getTela()->getid());
        $oSubFamiliaDesFin->setBCampoBloqueado(true);

        $oSubFamiliaCodFin->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaCodFin->setSCampoRetorno('pro_subfamiliacodigo', $this->getTela()->getId());
        $oSubFamiliaCodFin->addCampoBusca('pro_subfamiliadescricao', $oSubFamiliaDesFin->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------------------
        //FIM FINAL
        
        $oTipoMovimento = new Campo('Tipo Movimento', 'nfs_tipomovimentocodigo', Campo::TIPO_SELECTTAGS, 8,8,8,8);
        foreach ($aDados as $key => $oValue) {
            $oTipoMovimento->addItemSelect($key,$key.' - '.$oValue);
        }
        //define se marca somente vendas
        $oSomenteVenda = new Campo('Lista somente produtos que gera financeiro (Retorno e Insumo por exemplo)','sVenda', Campo::TIPO_CHECK,12,12,12,12);
        $oSomenteVenda->setBValorCheck(true);
        
        $oListarProdutos = new Campo('Listar itens da nota','sIten', Campo::TIPO_CHECK,12,12,12,12);
        
        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);
        
        $oNotaFiscal = new Campo('Nota Fiscal', 'documento', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oField1 = new FieldSet('Geral');
        $oField1->setOculto(false);
        $oField1->addCampos($oLinha1, array($oDatainicial, $oDatafinal),$oLinha1, array($oEmp_codigo, $oEmp_des),$oLinha1, array($oCodigo, $oProdes),$oLinha1, $oNotaFiscal,$oLinha1);
        
        $oField2 = new FieldSet('Grupos Famílias');
        $oField2->setOculto(true);
        $oField2->addCampos(array($oGrupoCod, $oGrupoDes, $oGrupoCodFin, $oGrupoDesFin),
                            array($oSubGrupoCod, $oSubGrupoDes, $oSubGrupoCodFin, $oSubGrupoDesFin),
                   $oLinha1,array($oFamiliaCod, $oFamiliaDes, $oFamiliaCodFin, $oFamiliaDesFin), 
                            array($oSubFamiliaCod, $oSubFamiliaDes, $oSubFamiliaCodFin, $oSubFamiliaDesFin));

        $this->addCampos($oField1,$oField2, $oLinha1,$oTipoMovimento,$oSomenteVenda,$oListarProdutos);
    }

}
