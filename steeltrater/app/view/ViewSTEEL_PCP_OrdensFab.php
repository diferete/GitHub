<?php

/* 
 * Classe que implementa as ordens de fabricação steel
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class ViewSTEEL_PCP_OrdensFab extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oSeq = new CampoConsulta('Seq.Material','seqmat');
        $oOp = new CampoConsulta('Op','op');
        $oData = new CampoConsulta('Data','data', CampoConsulta::TIPO_DATA);
        $oCodigo = new CampoConsulta('Codigo','prod');
        $oProdes = new CampoConsulta('Descrição','prodes');
        $oReceitaDes = new CampoConsulta('Receita','receita_des');
        $oQuant = new CampoConsulta('Quantidade','quant', CampoConsulta::TIPO_DECIMAL);
        $oPeso = new CampoConsulta('Peso','peso', CampoConsulta::TIPO_DECIMAL);
        $oSituacao = new CampoConsulta('Situação', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL,2);
        $oDescricaoFiltro = new Filtro($oProdes, Filtro::CAMPO_TEXTO,3);
        $this->addFiltro($oOpFiltro,$oCodigoFiltro,$oDescricaoFiltro);
        
        $this->setUsaAcaoExcluir(false);
        
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        
        $this->addCampos($oOp,$oSituacao,$oData,$oCodigo,$oProdes,$oSeq, $oReceitaDes,$oQuant,$oPeso);
        
       
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir',Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_OrdensFab', 'acaoMostraRelEspecifico', '', false, 'OpSteel1',false,'',false,'',true);
        $oDrop2 = new Dropdown('Açao', Dropdown::TIPO_DARK);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Cancelar OP', 'STEEL_PCP_OrdensFab', 'msgCancelaOp', '', false, '');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Retornar para Aberta', 'STEEL_PCP_OrdensFab', 'msgAbertaOp', '', false, '');
        
        
        $this->addDropdown($oDrop1,$oDrop2);
        $this->getTela()->setiAltura(1000);
        
    }
    
    
    public function criaTela() {
        parent::criaTela();
        
        $sAcao =  $this->getSRotina();
        
        $oDados = $this->getAParametrosExtras();
        
        $oOp = new Campo('Op nr.','op', Campo::TIPO_TEXTO,1);
        $oOp->setBCampoBloqueado(true);
        
        
        $oOrigem = new Campo('Origem','origem', Campo::TIPO_TEXTO,1);
        if(method_exists($oDados, 'getNfsnfnro')) 
         {$oOrigem->setSValor('Romaneio');}else{$oOrigem->setSValor('Manual');}
        $oOrigem->setBCampoBloqueado(true);
        
        $oL1 = new Campo('','l1', Campo::TIPO_LINHA);
        $oL1->setApenasTela(true);
        
        $oDocumento = new Campo('Doc.Fiscal','documento', Campo::TIPO_TEXTO,1);
        $oDocumento->setBFocus(true);
        $oDocumento->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDados, 'getNfsnfnro')) 
         {$oDocumento->setSValor($oDados->getNfsnfnro());}
         
        
        
        //cliente
        $oEmp_codigo = new Campo('Cliente','emp_codigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->setSValor('75483040000211');
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','emp_razaosocial',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');
        $oEmp_des->addValidacao(false, Validacao::TIPO_STRING);
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        
        
       
         //campo código do produto
        $oCodigo = new Campo('Codigo','prod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
         if(method_exists($oDados, 'getNfsitcod')) 
         {$oCodigo->setSValor($oDados->getNfsitcod());}
         
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto','prodes',Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '','');
        $oProdes->addCampoBusca('pro_descricao', '','');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->addValidacao(false, Validacao::TIPO_STRING);
        
        if(method_exists($oDados, 'getNfsitdes')) 
         {$oProdes->setSValor($oDados->getNfsitdes());}
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oProdes->getId(),  $this->getTela()->getId());
        
        //grid para escolha da prod/mat/receita 
        
        $oGridMat = new campo('Produto/Material/Receita', 'gridMat', Campo::TIPO_GRID, 11, 11, 11, 11, 150);
        $oGridMat->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());
        $oGridMat->setApenasTela(true);
        
        $oSeqMatGrid = new CampoConsulta('Seq.Mat.','seqmat');
        $oSeqMatGrid->setILargura(30);
        $oProDesGrid = new CampoConsulta('Produto', 'DELX_PRO_Produtos.pro_descricao');
        $oMatDesGrid = new CampoConsulta('Material', 'STEEL_PCP_material.matdes');
        $oRecDesGrid = new CampoConsulta('Receita','STEEL_PCP_receitas.peca');
        
        $oGridMat->addCampos($oSeqMatGrid,$oProDesGrid,$oMatDesGrid,$oRecDesGrid);
        $oGridMat->setSController('STEEL_PCP_prodMatReceita');
        $oGridMat->addParam('seqmat', '0');
        $oGridMat->getOGrid()->setIAltura(75);
        
        
        
        
        
        //busca campo material
        $oCodMat = new Campo('Material','matcod', Campo::TIPO_BUSCADOBANCOPK,1);
        $oCodMat->setSCorFundo(Campo::FUNDO_AMARELO);
        
        //busca material descrição
        $oMatDes = new Campo('Material Descrição','matdes', Campo::TIPO_BUSCADOBANCO,2);
        $oMatDes->setSIdPk($oCodMat->getId());
        $oMatDes->setClasseBusca('STEEL_PCP_Material');
        $oMatDes->addCampoBusca('matcod','','');
        $oMatDes->addCampoBusca('STEEL_PCP_Material','','');
        $oMatDes->setSIdTela($this->getTela()->getId());
        $oMatDes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oMatDes->addValidacao(false, Validacao::TIPO_STRING);
        $oMatDes->setBCampoBloqueado(true);
        
        //dados pk campo
        $oCodMat->setClasseBusca('STEEL_PCP_Material');
        $oCodMat->setSCampoRetorno('matcod',$this->getTela()->getId());
        $oCodMat->addCampoBusca('matdes', $oMatDes->getId(), $this->getTela()->getId());
        $oCodMat->addValidacao(false, Validacao::TIPO_STRING);
        $oCodMat->setBCampoBloqueado(true);
        
        ///////////////////////////////////////////////////////////////////////////////
        
        //busca campo receita
        $oReceita = new Campo('Receita','receita', Campo::TIPO_BUSCADOBANCOPK,2);
        $oReceita->setSCorFundo(Campo::FUNDO_AMARELO);
        
        //busca receita descrição
        $oReceitaDes = new Campo('Descrição','receita_des', Campo::TIPO_BUSCADOBANCO,3);
        $oReceitaDes->setSIdPk($oReceita->getId());
        $oReceitaDes->setClasseBusca('STEEL_PCP_Receitas');
        $oReceitaDes->addCampoBusca('cod','','');
        $oReceitaDes->addCampoBusca('peca','','');
        $oReceitaDes->setSIdTela($this->getTela()->getId());
        $oReceitaDes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oReceitaDes->addValidacao(false, Validacao::TIPO_STRING);
        $oReceitaDes->setBCampoBloqueado(true);
        //dados pk campo
        $oReceita->setClasseBusca('STEEL_PCP_Receitas');
        $oReceita->setSCampoRetorno('cod',$this->getTela()->getId());
        $oReceita->addCampoBusca('peca', $oReceitaDes->getId(), $this->getTela()->getId());
        $oReceita->addValidacao(false, Validacao::TIPO_STRING);
        $oReceita->setBCampoBloqueado(true);
        
        $oTempRev = new Campo('Temp.Rev','temprev', Campo::TIPO_TEXTO,1);
        
       // $sBuscaTemp ='var recod = $("#'.$oReceita->getId().'").val();if(recod!==""){'
       //         . 'requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_Receitas","buscaTempPadrao","'.$oTempRev->getId().'");}';
       // $oReceita->addEvento(Campo::EVENTO_SAIR,$sBuscaTemp);
        
        $oSeqMat = new Campo ('SeqMat','seqmat', Campo::TIPO_TEXTO,1);
        $oSeqMat->addValidacao(false, Validacao::TIPO_STRING);
        $oSeqMat->setBCampoBloqueado(true);
        
        
        //monta o evento para buscar receita padrão
      //  $sAcaoBusca ='requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");';
        $sEvento1 = 'var codigo = $("#'.$oCodigo->getId().'").val();'
          . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");';
       
        $oCodigo->addEvento(Campo::EVENTO_SAIR,$sEvento1);
        
        $oLinha = new Campo('','linha', Campo::TIPO_LINHA,12);
        $oLinha->setApenasTela(true);
        
        $oQuant = new Campo('Quant','quant', Campo::TIPO_TEXTO,1);
        $oQuant->setSValor('0,00');
        $oQuant->setSCorFundo(Campo::FUNDO_AMARELO);
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
         if(method_exists($oDados, 'getNfsitqtd')) 
         {$oQuant->setSValor(number_format($oDados->getNfsitqtd(), 2, ',', '.'));}
        
        
        $oPeso = new Campo('Peso','peso', Campo::TIPO_TEXTO,1);
        $oPeso->setSValor('0,00');
        $oPeso->setSCorFundo(Campo::FUNDO_MONEY);
        $oPeso->addValidacao(false, Validacao::TIPO_STRING);
        if(method_exists($oDados, 'getPeso')) 
         {$oPeso->setSValor(number_format($oDados->getPeso(), 2, ',', '.'));}
         
        
        
        $oOpCli = new Campo('OP do cliente','opcliente', Campo::TIPO_TEXTO,2);
         if(method_exists($oDados, 'getMetof')) 
         {$oOpCli->setSValor($oDados->getMetof());}
        
        
        
         $oObs = new campo('Observação','obs', Campo::TIPO_TEXTAREA,8);
         $oDataPrev = new Campo('Data prevista','dataprev', Campo::TIPO_DATA,2);  
         $oDataPrev->setSValor(date('d/m/Y',strtotime('+7 days')));
        
        //getRoeObs()
        if(method_exists($oDados, 'getRoeObs')) 
         {$oObs->setSValor($oDados->getRoeObs());}
        
        $oData = new Campo('Data','data', Campo::TIPO_TEXTO,1);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));
        
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,2);
        $oHora->setBCampoBloqueado(true);
        $oHora->setSValor(date('H:i'));
        
        $oUser = new Campo('Usuário','usuario', Campo::TIPO_TEXTO,2);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
        $oSeqProdNr = new Campo('Seq.Rom','seqprodnf', Campo::TIPO_TEXTO,1);
        $oSeqProdNr->setBCampoBloqueado(true);
        
        
        $oSituacao = new Campo('Situação','situacao', Campo::TIPO_TEXTO,1);
        $oSituacao->setBCampoBloqueado(true);
        $oSituacao->setSValor('Aberta');
        
        if(method_exists($oDados, 'getNfsitseq')) 
         {$oSeqProdNr->setSValor($oDados->getNfsitseq());}
        
        //ativa o fechamento da tela ao inserir
        $this->getTela()->setBFecharTelaIncluir(true);
        
        //evento click, parametros=>idgrid,pk,codMaterial,DescMaterial,codReceita,DescReceita,SeqMat
        $oGridMat->getOGrid()->setSEventoClick('var chave=""; $("#'.$oGridMat->getId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
               . 'if(chave!==""){requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","sendDadosCampos","'.$oGridMat->getId().'"+","+chave+","+"'.$oCodMat->getId().'"+",'
                . '"+"'.$oMatDes->getId().'"+","+"'.$oReceita->getId().'"+","+"'.$oReceitaDes->getId().'"+","+"'.$oSeqMat->getId().'"+","+"'.$oTempRev->getId().'");} ');
        
        
        /*
         * $sEvento1 = 'var codigo = $("#'.$oCodigo->getId().'").val();'
          . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");';
         */
        if($sAcao=='acaoAlterar'){
         $sAcaoBuscaIni = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");';
         $this->getTela()->setSAcaoShow($sAcaoBuscaIni);
        }
        
        $this->addCampos(array($oOp,$oOrigem,$oData,$oHora,$oUser,$oSeqProdNr, $oSituacao),
                $oLinha,
                $oDocumento,
                array($oEmp_codigo,$oEmp_des),
                array($oCodigo,$oProdes),
                $oGridMat,
                array($oCodMat, $oMatDes,$oReceita,$oReceitaDes,$oSeqMat),
                //array(),
                $oLinha,
                array($oOpCli,$oQuant,$oPeso,$oTempRev),$oObs,$oDataPrev);
    }
    
   
    
   /*
    * 
    */
    public function RelOpSteel2(){        
        parent::criaTelaRelatorio(); 
        
        $this->setTituloTela('Relatório de ordens de produção emitidas');        
        $this->setBTela(true);     
        
       $oDatainicial = new Campo('Data Incial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
       $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
       $oDatainicial->addValidacao(false, Validacao::TIPO_STRING,'', '2', '100');
       $oDatafinal = new Campo('Data Final', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
       $oDatafinal->setSValor(Util::getDataAtual());
       $oDatafinal->addValidacao(false, Validacao::TIPO_STRING,'', '2', '100');
       //novo
       $oSituaRel = new Campo('Situação', 'situa', Campo::TIPO_SELECT, 2, 2, 12, 12);
       $oSituaRel->addItemSelect('Todas','Todas');
       $oSituaRel->addItemSelect('Aberta','Aberta');
       $oSituaRel->addItemSelect('Cancelada', 'Cancelada');
       $oSituaRel->addItemSelect('Finalizado', 'Finalizado');
       $oSituaRel->addItemSelect('Processo', 'Processo');
             
       //cliente
        $oEmp_codigo = new Campo('Cliente','emp_codigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->setSValor('');
        
        
        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','emp_razaosocial',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('');
        
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
       
        //para mostrar a parte de imprimir a planilha no excel
        $oXls = new Campo('Exportar para Excel','sollib',  Campo::TIPO_BOTAOSMALL,1);
        $oXls->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoLib ='requestAjax("'.$this->getTela()->getId().'-form","STEEL_PCP_OrdensFab","relatorioExcelOp");';
        $oXls->getOBotao()->addAcao($sAcaoLib);
       
       $this->addCampos(array($oDatainicial, $oDatafinal),array($oEmp_codigo, $oEmp_des),$oSituaRel,$oXls);
    }
    
    public function RelOpSteelForno(){        
        parent::criaTelaRelatorio(); 
        
       $this->setTituloTela('Relatório de ordens de produção apontadas por forno');        
       $this->setBTela(true);     
        
       $oDatainicial = new Campo('Data Entrada', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
       $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
       $oDatainicial->addValidacao(false, Validacao::TIPO_STRING,'', '2', '100');
       $oDatafinal = new Campo('Data Saída', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
       $oDatafinal->setSValor(Util::getDataAtual());
       $oDatafinal->addValidacao(false, Validacao::TIPO_STRING,'', '2', '100');
       
       //Situação
       $oSituaRel = new Campo('Situação', 'situa', Campo::TIPO_SELECT, 2, 2, 12, 12);
       $oSituaRel->addItemSelect('Todas','Todas');
       $oSituaRel->addItemSelect('Finalizado', 'Finalizado');
       $oSituaRel->addItemSelect('Processo', 'Processo');
             
       //cliente
        $oEmp_codigo = new Campo('Cliente','emp_codigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oEmp_codigo->setSValor('');
        
        
        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','emp_razaosocial',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->setSValor('');
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        //busca do forno
        
        $oFornoCod = new Campo('Forno','fornocod',Campo::TIPO_BUSCADOBANCOPK,2);
        
        
        //campo descrição do produto adicionando o campo de busca
        $oFornodes = new Campo('Forno','fornodes',Campo::TIPO_BUSCADOBANCO, 4);
        $oFornodes->setSIdPk($oFornoCod ->getId());
        $oFornodes->setClasseBusca('STEEL_PCP_Forno');
        $oFornodes->addCampoBusca('FornoCod', '','');
        $oFornodes->addCampoBusca('fornodes', '','');
        $oFornodes->setSIdTela($this->getTela()->getId());
        $oFornodes->setSValor('');
        
        //declarar o campo descrição
        $oFornoCod->setClasseBusca('STEEL_PCP_Forno');
        $oFornoCod->setSCampoRetorno('fornocod',$this->getTela()->getId());
        $oFornoCod->addCampoBusca('fornodes',$oFornodes->getId(),  $this->getTela()->getId());
        
        
       $this->addCampos(array($oDatainicial, $oDatafinal),array($oFornoCod,$oFornodes),array($oEmp_codigo, $oEmp_des),$oSituaRel);
    } 
        
}
