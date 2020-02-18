<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ViewMET_Gerenciamento extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);
        
        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0];
        $aDado2 = $aDados[1];  
        $aCodSetor = $aDado2[0];
        $aDesSetor = $aDado2[1];
        $aDado4 = $aDados[3];
        $aDado5 = $aDados[4];
        
        $oNr = new CampoConsulta('Nr', 'nr');
        foreach ($aDado5 as $key){
            $oNr->addComparacao ($key, CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        }
        $oNr->setSOperacao('personalizado');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oDesMaq = new CampoConsulta('Maquina', 'MET_Maquinas.maquina');
        $oCodsetor = new CampoConsulta('Cod.Setor', 'codsetor');
        $oSetDes = new CampoConsulta('Setor', 'Setor.descsetor');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserabert = new CampoConsulta('UsuarioAbert.', 'userabert');
        $oSeq = new CampoConsulta('Célula', 'MET_Maquinas.seq');
        $oSetor = new CampoConsulta('Setor', 'MET_Maquinas.codsetor');
        $oCategoria = new CampoConsulta('Categoria', 'MET_Maquinas.maqtip');
        
        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1);
        $oFiltroCodMaquina = new Filtro($oCodmaq, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFiltroDesMaquina = new Filtro($oDesMaq, Filtro::CAMPO_TEXTO, 2);
        $oFiltroSituacao = new Filtro($oSitmp, Filtro::CAMPO_SELECT, 1,1,1,1);
        $oFiltroSituacao->setSValor('ABERTO');
        $oFiltroSituacao->addItemSelect('ABERTO', 'Situação Aberto');
        $oFiltroSituacao->addItemSelect('FINALIZADO', 'Situação Finalizado');
        $oFiltroSituacao->setSLabel('');
        
        //Filtro de células
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_SELECT, 2,2,2,2);
        $oFiltroSeq->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key){
            $val =(int)$key['seq'];
            $oFiltroSeq->addItemSelect($val, $key['seq'].' - Célula');
        }
        $oFiltroSeq->setSLabel('');
        
        //Filtro tipo Categoria
        $oCategoriaFiltro= new Filtro($oCategoria, Filtro::CAMPO_SELECT, 2,2,2,2);
        $oCategoriaFiltro->addItemSelect('', 'Todas Categorias');
        foreach ($aDado4 as $key3){
            $oCategoriaFiltro->addItemSelect($key3['maqtip'], $key3['maqtip']);
        }
        $oCategoriaFiltro->setSLabel('');
        
        //Filtro de Setor
        $oFiltroSetor = new Filtro($oSetor, Filtro::CAMPO_SELECT, 3,3,3,3);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1){
            $oFiltroSetor->addItemSelect($key1, $key1.' - '.$aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroNr, $oFiltroCodMaquina, $oFiltroDesMaquina, $oFiltroSeq,$oCategoriaFiltro, $oFiltroSetor,$oFiltroSituacao);
        
        $this->getTela()->setBMostraFiltro(true);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oNr, $oCodmaq, $oDesMaq, $oSeq, $oCategoria, $oCodsetor, $oSetDes, $oSitmp);
        
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'TODOS', 'MET_Gerenciamento', 'acaoMostraRelEspecifico', 'TODOS', false, 'relServicoMaquinaMantPrev', false, '', false, '', true);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'ABERTOS', 'MET_Gerenciamento', 'acaoMostraRelEspecifico', 'ABERTOS', false, 'relServicoMaquinaMantPrev', false, '', false, '', true);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'FINALIZADOS', 'MET_Gerenciamento', 'acaoMostraRelEspecifico', 'FINALIZADOS', false, 'relServicoMaquinaMantPrev', false, '', false, '', true);
        $this->addDropdown($oDrop1);
        
        $this->getTela()->setSEventoClick('var chave=""; $("#' . $this->getTela()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getSId() . '-form","MET_Gerenciamento","calculoPersonalizado",chave+",qualaqtempo");');

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
        if($sAcaoRotina=='acaoAlterar'||$sAcaoRotina == 'acaoVisualizar'){
            $oCodmaq->setBCampoBloqueado(true);
        }

        //campo descrição da maquina adicionando o campo de busca
        $oMaq_des = new Campo('Maquina', 'MET_Maquinas.maquina', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_des->setSIdPk($oCodmaq->getId());
        $oMaq_des->setClasseBusca('MET_Maquinas');
        $oMaq_des->addCampoBusca('cod', '', '');
        $oMaq_des->addCampoBusca('maquina', '', '');
        $oMaq_des->setSIdTela($this->getTela()->getId());
        $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
        if($sAcaoRotina=='acaoAlterar'||$sAcaoRotina == 'acaoVisualizar'){
            $oMaq_des->setBCampoBloqueado(true);
        }
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodmaq->setClasseBusca('MET_Maquinas');
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

  //      $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $oCodmaq = new Campo('Codigo', 'codmaq', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
      //  $oCodmaq->addValidacao(false, Validacao::TIPO_INTEIRO);

        //campo descrição da maquina adicionando o campo de busca
        $oMaq_des = new Campo('Maquina', 'MET_Maquinas.maquina', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_des->setSIdPk($oCodmaq->getId());
        $oMaq_des->setClasseBusca('MET_Maquinas');
        $oMaq_des->addCampoBusca('cod', '', '');
        $oMaq_des->addCampoBusca('maquina', '', '');
        $oMaq_des->setSIdTela($this->getTela()->getId());
      //  $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodmaq->setClasseBusca('MET_Maquinas');
        $oCodmaq->setSCampoRetorno('cod', $this->getTela()->getId());
        $oCodmaq->addCampoBusca('maquina', $oMaq_des->getId(), $this->getTela()->getId());
        
        $oSitmp = new Campo('Situação dos Serviços', 'sitmp', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oSitmp->addItemSelect('', 'TODOS');
        $oSitmp->addItemSelect('ABERTOS', 'ABERTOS');
        $oSitmp->addItemSelect('FINALIZADOS', 'FINALIZADOS');
        $oSitmp->addValidacao(true, Validacao::TIPO_STRING);

        //Filtro de células
        $oFiltroSeq = new Campo('Célula', 'MET_Maquinas.seq', Campo::CAMPO_SELECTSIMPLE, 1,1,1,1);
        $oFiltroSeq->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key){
            $val =(int)$key['seq'];
            $oFiltroSeq->addItemSelect($val, $key['seq'].' - Célula');
        }
        $oFiltroSeq->addValidacao(true, Validacao::TIPO_STRING);
        
        //Filtro de Setor
        $oFiltroSetor = new Campo('Setor', 'MET_Maquinas.codsetor', Campo::CAMPO_SELECTSIMPLE, 3,3,3,3);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1){
            $oFiltroSetor->addItemSelect($key1, $key1.' - '.$aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->addValidacao(true, Validacao::TIPO_STRING);
       
        //Filtro tipo Manutenção
        $oRespFiltro= new Campo('Responsável','resp', Campo::CAMPO_SELECTSIMPLE, 2,2,2,2);
        $oRespFiltro->addItemSelect('', 'Todos');
        foreach ($aDado3 as $key2){
            $oRespFiltro->addItemSelect($key2['resp'], $key2['resp']);
        }
        $oRespFiltro->addValidacao(true, Validacao::TIPO_STRING);
        
        //Filtro tipo Categoria
        $oCategoriaFiltro= new Campo('Categoria', 'MET_Maquinas.maqtip', Campo::CAMPO_SELECTSIMPLE, 2,2,2,2);
        $oCategoriaFiltro->addItemSelect(' ', 'Todas Categorias');
        foreach ($aDado4 as $key3){
            $oCategoriaFiltro->addItemSelect(rtrim($key3['maqtip']), rtrim($key3['maqtip']));
        }    
        $oCategoriaFiltro->addValidacao(true, Validacao::TIPO_STRING);
        
        $oDatainicial = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');
        $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');
        
        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);
        
        //adiciona os evento ao sair do campo codmaq
        $sEventoOp = 'var CodMaq =  $("#'.$oCodmaq->getId().'").val();if(CodMaq !==""){requestAjax("'.$this->getTela()->getId().'-form","MET_Gerenciamento","consultaDadosMaquina",'
                 . '"'.$oFiltroSeq->getId().','.$oCategoriaFiltro->getId().','.$oFiltroSetor->getId().'");}';
        $oCodmaq->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
        
        $this->addCampos(array($oCodmaq, $oMaq_des),$oLinha1, array($oFiltroSeq, $oRespFiltro,$oSitmp), $oLinha1,array($oCategoriaFiltro, $oFiltroSetor), $oLinha1, array($oDatainicial, $oDatafinal));
    }

}
