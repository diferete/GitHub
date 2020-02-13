<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 18/07/2018
 */

class ViewSTEEL_PCP_ordensFabApontEnt extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oOp = new CampoConsulta('OP', 'op');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCod = new CampoConsulta('Cod.', 'fornocod');
        $oDtent = new CampoConsulta('Data entrada', 'dataent_forno');
        $oHentr = new CampoConsulta('Hora entrada', 'horaent_forno');
        $oDtsaid = new CampoConsulta('Data saída', 'datasaida_forno');
        $oHsaida = new CampoConsulta('Hora saída', 'horasaida_forno');
        $oDescricaoopfiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO, 5);
        

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaoopfiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oOp,$oSeq,$oCod,$oDtent,$oHentr,$oDtsaid,$oHsaida);
    }

    public function criaTela() {
        parent::criaTela();
        //captura os dados 
        $oDados = $this->getAParametrosExtras();
        
        $this->setBTela(true);
      
        
        $oOp = new Campo('OP', 'op', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 6, 6);
        $oOp->setSCorFundo(Campo::FUNDO_AMARELO);
        $oOp->addValidacao(false, Validacao::TIPO_STRING,'','1','100');
        $oOp->setClasseBusca('STEEL_PCP_ordensFabListaPesq');
        $oOp->setSCampoRetorno('op', $this->getTela()->getId());
        
       
        
        $oBtnPesqOp = new Campo('Pesquisar','btn1', Campo::TIPO_BOTAOSMALL);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        
        $oSeq = new Campo('','seq', Campo::TIPO_TEXTO,1);
        $oSeq->setBOculto(true);
       
        $oCliente = new Campo('Cliente','cliente', Campo::TIPO_TEXTO,5);
        $oCliente->setBCampoBloqueado(true);
        $oCliente->setSFont(Campo::FONT_BOLD);
        
        $oOpCliente = new Campo('Op do cliente','opcli', Campo::TIPO_TEXTO,2);
        $oOpCliente->setBCampoBloqueado(true);
        $oOpCliente->setSFont(Campo::FONT_BOLD);
        
        $oProcod = new Campo('Código','procod', Campo::TIPO_TEXTO,2);
        $oProcod->setBCampoBloqueado(true);
        $oProcod->setSFont(Campo::FONT_BOLD);
        $oProcod->addValidacao(false, Validacao::TIPO_STRING,'','1','100');
        $oProdes = new Campo('Descrição','prodes', Campo::TIPO_TEXTO,4);
        $oProdes->setBCampoBloqueado(true);
        $oProdes->setSFont(Campo::FONT_BOLD);
        
        
        
        $oFornoCod = new campo('','fornocod', Campo::TIPO_TEXTO,1);
        $oFornoCod->setBOculto(true);
        $oFornoCod->setSCorFundo(Campo::FUNDO_VERDE);
        $oFornoCod->setSFont(Campo::FONT_BOLD);
        if (method_exists($oDados,'getFornocod')){
            $oFornoCod->setSValor($oDados->getFornocod());
        }
        $oFornoDes=new Campo('Forno','fornodes', Campo::TIPO_TEXTO,1);
        $oFornoDes->setBCampoBloqueado(true);
        $oFornoDes->setSCorFundo(Campo::FUNDO_AMARELO);
        if (method_exists($oDados,'getFornodes')){
            $oFornoDes->setSValor($oDados->getFornodes());
        }
        $oFornoDes->addValidacao(false, Validacao::TIPO_STRING,'','3','100');
        
        //adiciona os eventos ao sair do campo op e do botao pesquisar
         $sEventoOp = 'var OpSteel =  $("#'.$oOp->getId().'").val();if(OpSteel !==""){requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEnt","consultaOpApont",'
                 . '"'.$oCliente->getId().','.$oOpCliente->getId().','.$oProcod->getId().','.$oProdes->getId().'");}'
                 . 'else{$("#'.$oCliente->getId().'").val(""); $("#'.$oOpCliente->getId().'").val(""); $("#'.$oProcod->getId().'").val("");$("#'.$oProdes->getId().'").val("");                                           };';
         $oBtnPesqOp->getOBotao()->addAcao($sEventoOp);
         $oOp->addEvento(Campo::EVENTO_SAIR,$sEventoOp);
             
         
        //botao inserir apontamento
        $oBtnInserir = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId()); 
        //##########################INSERÇÃO DO GRID DE CONTROLE###########################
         $oGridEnt = new campo('Entrada no forno', 'gridEntForno', Campo::TIPO_GRID, 12, 12, 12, 12, 150);
         $oGridEnt->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
         
        $oBotaoExcluir = new CampoConsulta('Excluir','excluir', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setSTitleAcao('Excluir apontamento!');
        $oBotaoExcluir->addAcao('STEEL_PCP_ordensFabApontEnt','msgExcluirApontamento');
        $oBotaoExcluir->setBHideTelaAcao(false);
        $oBotaoExcluir->setILargura(30);
         
         
         $oOpGrid = new CampoConsulta('Op','op');
        // $oProcodGrid = new CampoConsulta('Código','procod');
         $oProcodDesGrid = new CampoConsulta('Produto','prodes');
         $oProcodDesGrid->setILargura(300);
         $oFornoDesGrid = new CampoConsulta('Forno','fornodes');
         $oDataEntGrid = new CampoConsulta('Data Ent','dataent_forno', CampoConsulta::TIPO_DATA);
         $oHoraEntGrid = new CampoConsulta('Hora Ent','horaent_forno', CampoConsulta::TIPO_TIME);
         $oSituaca = new CampoConsulta('Situação','situacao');
         $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
         
         
         $oGridEnt->addCampos($oBotaoExcluir,$oOpGrid,$oProcodDesGrid,$oFornoDesGrid,$oDataEntGrid,$oHoraEntGrid,$oSituaca);
         $oGridEnt->setSController('STEEL_PCP_ordensFabApontEnt');
         $oGridEnt->addParam('op', '0');
         $oGridEnt->getOGrid()->setIAltura(500);
        
       
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_ordensFabApontEnt","inserirApont",'
                 . '"'.$this->getTela()->getId().','. $oGridEnt->getId().'");';
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
         
        //busca ao abrir o campo
         $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEnt","getDadosGrid","' . $oGridEnt->getId() . '","consultaApontGrid");';
        $this->getTela()->setSAcaoShow($sAcaoBusca);
        
        //botao atualizar
        $sAcaoAtualizar = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_ordensFabApontEnt","getDadosGrid","' . $oGridEnt->getId() . '","consultaApontGrid");';
        $oBtnAtualizar = new Campo('Atualizar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $oBtnAtualizar->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
        $oBtnAtualizar->getOBotao()->addAcao($sAcaoAtualizar);
        
        $this->addCampos(array($oOp,$oBtnPesqOp,$oSeq),
                array($oCliente,$oOpCliente),array($oProcod,$oProdes,$oFornoDes,$oFornoCod),array($oBtnInserir,$oBtnAtualizar),$oGridEnt);
        
        
        
       
        
     
        
       
    }
    
     public function consultaApontGrid() {
        $oGridApont = new Grid("");
        
        $oBotaoExcluir = new CampoConsulta('Excluir','excluir', CampoConsulta::TIPO_EXCLUIR);
        $oBotaoExcluir->setSTitleAcao('Excluir apontamento!');
        $oBotaoExcluir->addAcao('STEEL_PCP_ordensFabApontEnt','msgExcluirApontamento');
        $oBotaoExcluir->setBHideTelaAcao(false);
        $oBotaoExcluir->setILargura(30);
        
        $oOp = new CampoConsulta('Op','op');
         //$oProcodGrid = new CampoConsulta('Código','procod');
         $oProcodDesGrid = new CampoConsulta('Produto','prodes');
         $oProcodDesGrid->setILargura(300);
         $oFornoDesGrid = new CampoConsulta('Forno','fornodes');
         $oDataEntGrid = new CampoConsulta('Data Ent','dataent_forno', CampoConsulta::TIPO_DATA);
         $oHoraEntGrid = new CampoConsulta('Hora Ent','horaent_forno', CampoConsulta::TIPO_TIME);
         $oSituaca = new CampoConsulta('Situação','situacao');
         $oSituaca->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
         $oSituaca->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
         $oGridApont->addCampos($oBotaoExcluir,$oOp,$oProcodDesGrid,$oFornoDesGrid,$oDataEntGrid,$oHoraEntGrid,$oSituaca);

        $aCampos = $oGridApont->getArrayCampos();
        return $aCampos;
    }

}
