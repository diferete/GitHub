<?php

/*
 * Classe que implementa as views STEEL_PCP_TabItemPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/02/2019
 */

class ViewSTEEL_PCP_TabItemPreco extends View {
    
   

    public function criaConsulta() {
        parent::criaConsulta();
       

        $oNr = new CampoConsulta('Tabela', 'nr');
        $oRec = new CampoConsulta('Receita', 'receita');
        $oRecDes = new CampoConsulta('Receita Desc.','STEEL_PCP_receitas.peca');
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oPro = new CampoConsulta('Prod', 'prod');
        $oProdDes = new CampoConsulta('Prod. Desc', 'STEEL_PCP_Produtos.pro_descricao');
        $oNcm = new CampoConsulta('NCM','STEEL_PCP_Produtos.pro_ncm');
        $oPre = new CampoConsulta('Preço', 'preco', CampoConsulta::TIPO_EDITDECIMAL);
        $oPre->addAcao('STEEL_PCP_TabItemPreco', 'gravaPreco');
        
        
        $oTipo = new CampoConsulta('Tipo','tipo');
        $oTipo->addComparacao('INSUMO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oTipo->addComparacao('SERVIÇO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
        $this->getTela()->setiAltura(750);

        $this->addCampos($oNr,$oSeq,$oRec,$oRecDes,$oPro,$oProdDes,$oPre,$oNcm,$oTipo);
    }
    
    
     function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(750);
    
        $oNr = new CampoConsulta('Tabela', 'nr');
        $oRec = new CampoConsulta('Receita', 'receita');
        $oRecDes = new CampoConsulta('Receita Desc.','STEEL_PCP_receitas.peca');
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oPro = new CampoConsulta('Prod', 'prod');
        $oProdDes = new CampoConsulta('Prod. Desc', 'STEEL_PCP_Produtos.pro_descricao');
        $oNcm = new CampoConsulta('NCM','STEEL_PCP_Produtos.pro_ncm');
        $oPre = new CampoConsulta('Preço', 'preco', CampoConsulta::TIPO_EDITDECIMAL);
        $oPre->addAcao('STEEL_PCP_TabItemPreco', 'gravaPreco');
        $oTipo = new CampoConsulta('Tipo','tipo');
        $oTipo->addComparacao('INSUMO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oTipo->addComparacao('SERVIÇO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        $this->addCamposDetalhe($oNr,$oSeq,$oRec,$oRecDes,$oPro,$oProdDes,$oPre,$oNcm,$oTipo);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    

    public function criaTela() {
        parent::criaTela();
        $this->criaGridDetalhe();
        
        $sAcao =  $this->getSRotina();
       
        $aValor = $this->getAParametrosExtras();

        $oNr = new Campo('Tabela', 'nr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNr->setSValor($aValor[0]);
        $oNr->setBCampoBloqueado(true);
       
        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1,1,1);
        $oSeq->setBCampoBloqueado(true);
        
        //---------------------------------------------------------------------------
        $oRecCod = new Campo('Receita', 'receita', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oRecCod->addValidacao(false, Validacao::TIPO_STRING);
        $oRecCod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oRecCod->setBFocus(true);
        if($sAcao=='acaoAlterar'){$oRecCod->setBCampoBloqueado(true);}
        
         //campo descrição da receita adicionando o campo de busca
        $oRecdes = new Campo('Receita Descrição','STEEL_PCP_receitas.peca',Campo::TIPO_BUSCADOBANCO, 4);
        $oRecdes->setSIdPk($oRecCod->getId());
        $oRecdes->setClasseBusca('STEEL_PCP_receitas');
        $oRecdes->addCampoBusca('cod', '','');
        $oRecdes->addCampoBusca('peca', '','');
        $oRecdes->setSIdTela($this->getTela()->getId());
        $oRecdes->addValidacao(false, Validacao::TIPO_STRING);
        if($sAcao=='acaoAlterar'){$oRecdes->setBCampoBloqueado(true);}
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oRecCod->setClasseBusca('STEEL_PCP_receitas');
        $oRecCod->setSCampoRetorno('cod',$this->getTela()->getId());
        $oRecCod->addCampoBusca('peca',$oRecdes->getId(),  $this->getTela()->getId());
        
        //-------------------------------------------------------------------------------
        $oCodigo = new Campo('Produto','prod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        if($sAcao=='acaoAlterar'){$oCodigo->setBCampoBloqueado(true);}
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto Descrição','STEEL_PCP_Produtos.pro_descricao',Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('STEEL_PCP_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '','');
        $oProdes->addCampoBusca('pro_descricao', '','');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->addValidacao(false, Validacao::TIPO_STRING);
        if($sAcao=='acaoAlterar'){$oProdes->setBCampoBloqueado(true);}
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('STEEL_PCP_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oProdes->getId(),  $this->getTela()->getId());
        
        //-----------------------------------------------------------------------------------------
        
        $oTratcod = new Campo('Tratamento *Necessário para Ops de Fio Máquina', 'cod', Campo::TIPO_BUSCADOBANCOPK, 4, 4, 4, 4);
        $oTratcod->setSIdHideEtapa($this->getSIdHideEtapa());
        if($sAcao=='acaoAlterar'){$oTratcod->setBCampoBloqueado(true);}
        $oTratcod->setClasseBusca('STEEL_PCP_Tratamentos');
        $oTratcod->setSCampoRetorno('tratcod',$this->getTela()->getId());
       
        
        //------------------------------------------------------------------------------------------
        
        $oPre = new Campo('Preço', 'preco', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oPre->addValidacao(false, Validacao::TIPO_STRING);
        
        //----------------------------------------------------------------------------------
        $oTipo = new campo('Tipo','tipo', Campo::TIPO_TEXTO,1,1,1,1);
        $oTipo->setBCampoBloqueado(true);
        //---------------------------------------------------------------------------------
        $oNcm = new campo('NCM','pro_ncm', Campo::TIPO_TEXTO,2,2,2,2);
        $oNcm->setApenasTela(true);
        $oNcm->setBCampoBloqueado(true);
        //-----busca o tipo se é serviço ou insumo-----------------------------------------
        
        $sEventoTipo = 'var procod =  $("#'.$oCodigo->getId().'").val(); '
                . 'if(procod !==""){requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_TabItemPreco","pesquisaGrupoServInsumo","'.$oTipo->getId().','.$oNcm->getId().'"); }';
        $oCodigo->addEvento(Campo::EVENTO_SAIR,$sEventoTipo);
        
        
        $sCallBackCodigo = 'if(requestJSON(false, "STEEL_PCP_TabItemPreco","callBackInsumos", $("#' . $this->getTela()->getId() . '-form").serialize(), "' . $oCodigo->getNome() . '").retorno == "false"){;'
                . 'return { valid: false, message: "Atenção, cliente está bloqueado no financeiro!" };'
                . '}else{return { valid: true };};';
      //  $oCodigo->addValidacao(true, Validacao::TIPO_CALLBACK, '', '2', '15', '', '', $sCallBackCodigo, Validacao::TRIGGER_SAIR);
        
        //-----------botao inserir--------------------------
         /*Botão para inserir no banco de dados*/
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $sGrid=$this->getOGridDetalhe()->getSId();
       //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten",'
                . '"'.$this->getTela()->getId().'-form,'.$oSeq->getId().','.$sGrid.','.$oRecCod->getId().'","'.$oNr->getSValor().'");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oNr,$oSeq),array($oRecCod,$oRecdes),
                array($oCodigo,$oProdes,$oTratcod),array($oTipo,$oNcm),array($oPre,$oBotConf));
        //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oNr);
    }
    
    
}
