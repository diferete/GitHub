<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ViewMET_MP_Gerenciamento extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0];
        $aDado2 = $aDados[1];
        $aCodSetor = $aDado2[0];
        $aDesSetor = $aDado2[1];
        $aDado4 = $aDados[3];
        $aDado5 = $aDados[4];

        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setBMostraFiltro(true);
        $this->getTela()->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $iSet = $_SESSION['codsetor'];
        
        if($iSet== 2){
            $this->setUsaAcaoIncluir(true);
            $this->setUsaAcaoExcluir(false);
        }else{
            $this->setUsaAcaoIncluir(false);
            $this->setUsaAcaoExcluir(false);
        }

        $oNr = new CampoConsulta('Nr', 'nr');
        foreach ($aDado5 as $key) {
            $oNr->addComparacao($key, CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, null);
        }
        $oNr->setSOperacao('personalizado');

        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');

        $oDesMaq = new CampoConsulta('Maquina', 'maqmp');

        $oSetDes = new CampoConsulta('Setor', 'MET_CAD_Setores.descsetor');

        $oSitmp = new CampoConsulta('Situação', 'sitmp');

        $oSeq = new CampoConsulta('Célula', 'MET_MP_Maquinas.seq');

        $oSetor = new CampoConsulta('Setor', 'MET_MP_Maquinas.codsetor');

        $oCategoria = new CampoConsulta('Categoria', 'MET_MP_Maquinas.maqtip');

        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilCodMaq = new Filtro($oCodmaq, Filtro::CAMPO_BUSCADOBANCOPK, 1, 1, 12, 12, false);
        $oFilCodMaq->setSClasseBusca('MET_MP_Maquinas');
        $oFilCodMaq->setSCampoRetorno('cod', $this->getTela()->getSId());
        $oFilCodMaq->setSIdTela($this->getTela()->getSId());

        $oFiltroSituacao = new Filtro($oSitmp, Filtro::CAMPO_SELECT, 1, 1, 12, 12, true);
        $oFiltroSituacao->setSValor('ABERTO');
        $oFiltroSituacao->addItemSelect('ABERTO', 'Situação Aberto');
        $oFiltroSituacao->addItemSelect('FINALIZADO', 'Situação Finalizado');
        $oFiltroSituacao->setSLabel('');

        //Filtro de células
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroSeq->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key) {
            $val = (int) $key['seq'];
            $oFiltroSeq->addItemSelect($val, $key['seq'] . ' - Célula');
        }
        $oFiltroSeq->setSLabel('');

        //Filtro tipo Categoria
        $oCategoriaFiltro = new Filtro($oCategoria, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oCategoriaFiltro->addItemSelect('', 'Todas Categorias');
        foreach ($aDado4 as $key3) {
            $oCategoriaFiltro->addItemSelect($key3['maqtip'], $key3['maqtip']);
        }
        $oCategoriaFiltro->setSLabel('');

        //Filtro de Setor
        $oFiltroSetor = new Filtro($oSetor, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1) {
            $oFiltroSetor->addItemSelect($key1, $key1 . ' - ' . $aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');

        if($iSet!= 2 && $iSet!= 12 && $iSet!= 29){
            $oFiltroSetor->setSValor($iSet);
        }

        $oFiltroDesMaq = new Filtro($oDesMaq, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, TRUE);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'TODOS', 'MET_MP_Gerenciamento', 'acaoMostraRelEspecifico', 'TODOS', false, 'relServicoMaquinaMantPrev', false, '', false, '', true, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'ABERTOS', 'MET_MP_Gerenciamento', 'acaoMostraRelEspecifico', 'ABERTOS', false, 'relServicoMaquinaMantPrev', false, '', false, '', true, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'FINALIZADOS', 'MET_MP_Gerenciamento', 'acaoMostraRelEspecifico', 'FINALIZADOS', false, 'relServicoMaquinaMantPrev', false, '', false, '', true, false);


        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","MET_MP_Gerenciamento","calculoPersonalizado",chave+",qualaqtempo");');

        $this->addDropdown($oDrop1);
        $this->addFiltro($oFiltroNr, $oFilCodMaq, $oFiltroSeq, $oCategoriaFiltro, $oFiltroSetor, $oFiltroSituacao, $oFiltroDesMaq);
        $this->addCampos($oNr, $oCodmaq, $oDesMaq, $oSeq, $oCategoria, $oSetor, $oSetDes, $oSitmp);
        
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oCodmaq = new Campo('Codigo', 'codmaq', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodmaq->addValidacao(false, Validacao::TIPO_INTEIRO);
        if ($sAcaoRotina == 'acaoAlterar' || $sAcaoRotina == 'acaoVisualizar') {
            $oCodmaq->setBCampoBloqueado(true);
        }

        //campo descrição da maquina adicionando o campo de busca
        $oMaq_des = new Campo('Maquina', 'maqmp', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_des->setSIdPk($oCodmaq->getId());
        $oMaq_des->setClasseBusca('MET_MP_Maquinas');
        $oMaq_des->addCampoBusca('cod', '', '');
        $oMaq_des->addCampoBusca('maquina', '', '');
        $oMaq_des->setSIdTela($this->getTela()->getId());
        $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
        if ($sAcaoRotina == 'acaoAlterar' || $sAcaoRotina == 'acaoVisualizar') {
            $oMaq_des->setBCampoBloqueado(true);
        }

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodmaq->setClasseBusca('MET_MP_Maquinas');
        $oCodmaq->setSCampoRetorno('cod', $this->getTela()->getId());
        $oCodmaq->addCampoBusca('maquina', $oMaq_des->getId(), $this->getTela()->getId());

        $oSitmp = new Campo('Situação', 'sitmp', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitmp->setSValor('ABERTO');
        $oSitmp->addValidacao(false, Validacao::TIPO_STRING);
        $oSitmp->setBCampoBloqueado(true);

        $oDatabert = new Campo('DataAbert', 'databert', Campo::TIPO_DATA, 2);
        $oDatabert->setSValor(date('d/m/Y'));
        $oDatabert->setBCampoBloqueado(true);

        $oUserabert = new Campo('UsuarioAbert.', 'userabert', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserabert->setSValor($_SESSION['nome']);
        $oUserabert->setBCampoBloqueado(true);

        //NOVO ------------------------------------------------------------------------------------------------
        $oEtapas = new FormEtapa(4, 4, 4, 4);
        $oEtapas->addItemEtapas('Manutenção Preventiva Máquina', true, $this->addIcone(Base::ICON_CONFIG));
        $oEtapas->addItemEtapas('Serviço Manutenção Preventiva', false, $this->addIcone(Base::ICON_CONFIRMAR));

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
            $this->addCampos(array($oFilcgc, $oNr,
                $oDatabert, $oUserabert), $oSitmp, array($oCodmaq, $oMaq_des), $oAcao);
        } else {
            $this->addCampos(array($oFilcgc, $oNr,
                $oDatabert, $oUserabert), $oSitmp, array($oCodmaq, $oMaq_des));
        }
    }

    public function relServicoMaquinaMantPrev() {
        parent::criaTelaRelatorio();

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0];
        $aDado2 = $aDados[1];
        $aCodSetor = $aDado2[0];
        $aDesSetor = $aDado2[1];
        $aDado3 = $aDados[2];
        $aDado4 = $aDados[3];

        $this->setTituloTela('Relatório dos Itens da Manutenção Preventiva');
        $this->setBTela(true);

        $oCodmaq = new Campo('Codigo', 'codmaq', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oMaq_des = new Campo('Maquina', 'MET_MP_Maquinas.maquina', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_des->setSIdPk($oCodmaq->getId());
        $oMaq_des->setClasseBusca('MET_MP_Maquinas');
        $oMaq_des->addCampoBusca('cod', '', '');
        $oMaq_des->addCampoBusca('maquina', '', '');
        $oMaq_des->setSIdTela($this->getTela()->getId());

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodmaq->setClasseBusca('MET_MP_Maquinas');
        $oCodmaq->setSCampoRetorno('cod', $this->getTela()->getId());
        $oCodmaq->addCampoBusca('maquina', $oMaq_des->getId(), $this->getTela()->getId());

        $oSitmp = new Campo('Situação dos Serviços', 'sitmp', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oSitmp->addItemSelect('', 'TODOS');
        $oSitmp->addItemSelect('ABERTOS', 'ABERTOS');
        $oSitmp->addItemSelect('FINALIZADOS', 'FINALIZADOS');
        $oSitmp->addValidacao(true, Validacao::TIPO_STRING);

        //Filtro de células
        $oFiltroSeq = new Campo('Célula', 'MET_MP_Maquinas.seq', Campo::CAMPO_SELECTSIMPLE, 1, 1, 1, 1);
        $oFiltroSeq->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key) {
            $val = (int) $key['seq'];
            $oFiltroSeq->addItemSelect($val, $key['seq'] . ' - Célula');
        }
        $oFiltroSeq->addValidacao(true, Validacao::TIPO_STRING);

        //Filtro de Setor
        $oFiltroSetor = new Campo('Setor', 'MET_MP_Maquinas.codsetor', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1) {
            $oFiltroSetor->addItemSelect($key1, $key1 . ' - ' . $aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->addValidacao(true, Validacao::TIPO_STRING);

        //Filtro tipo Manutenção
        $oRespFiltro = new Campo('Responsável', 'resp', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oRespFiltro->addItemSelect('', 'Todos');
        foreach ($aDado3 as $key2) {
            $oRespFiltro->addItemSelect($key2['resp'], $key2['resp']);
        }
        $oRespFiltro->addValidacao(true, Validacao::TIPO_STRING);

        //Filtro tipo Categoria
        $oCategoriaFiltro = new Campo('Categoria', 'MET_MP_Maquinas.maqtip', Campo::CAMPO_SELECTSIMPLE, 2, 2, 2, 2);
        $oCategoriaFiltro->addItemSelect(' ', 'Todas Categorias');
        foreach ($aDado4 as $key3) {
            $oCategoriaFiltro->addItemSelect(rtrim($key3['maqtip']), rtrim($key3['maqtip']));
        }
        $oCategoriaFiltro->addValidacao(true, Validacao::TIPO_STRING);

        $oDatainicial = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');

        $oAplicaFiltro = new Campo('Aplica Data', 'apdata', Campo::TIPO_CHECK,1,1,1,1);
        
        $oSimplifica = new Campo('Resumido', 'simple', Campo::TIPO_CHECK,1,1,1,1);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $oDiasRest = new Campo('Dias Restantes', 'dias', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oDiasRest->addItemSelect('----', 'TODOS');
        $oDiasRest->addItemSelect('0', '0 dias');
        $oDiasRest->addItemSelect('1', '1 dias');
        $oDiasRest->addItemSelect('3', '3 dias');
        $oDiasRest->addItemSelect('5', '5 dias');
        $oDiasRest->addItemSelect('7', '7 dias');
        $oDiasRest->addItemSelect('15', '15 dias');
        $oDiasRest->addItemSelect('30', '30 dias');
        $oDiasRest->addItemSelect('60', '60 dias');
        $oDiasRest->addItemSelect('90', '90 dias');
        $oDiasRest->addItemSelect('120', '120 dias');
        $oDiasRest->addItemSelect('166', '166 dias');
        $oDiasRest->addItemSelect('180', '180 dias');
        $oDiasRest->addItemSelect('365', '365 dias');

        //adiciona os evento ao sair do campo codmaq
        $sEventoOp = 'var CodMaq =  $("#' . $oCodmaq->getId() . '").val();if(CodMaq !==""){requestAjax("' . $this->getTela()->getId() . '-form","MET_MP_Gerenciamento","consultaDadosMaquina",'
                . '"' . $oFiltroSeq->getId() . ',' . $oCategoriaFiltro->getId() . ',' . $oFiltroSetor->getId() . '");}';
        $oCodmaq->addEvento(Campo::EVENTO_SAIR, $sEventoOp);

        $this->addCampos(array($oCodmaq, $oMaq_des), $oLinha1, array($oFiltroSeq, $oRespFiltro, $oSitmp), $oLinha1, array($oCategoriaFiltro, $oFiltroSetor), $oLinha1, array($oAplicaFiltro, $oDatainicial, $oDatafinal),$oLinha1, $oDiasRest,$oSimplifica);
    }

}
