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
        
        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Analisar apontamentos!');
        $oBotaoModal->addAcao('STEEL_PCP_OrdensFab', 'criaTelaModalAponta', 'modalAponta');
        $this->addModais($oBotaoModal);
        
        $oEmpCod = new CampoConsulta('Cnpj','emp_codigo');
        $oSeq = new CampoConsulta('Seq.Material','seqmat');
        $oOp = new CampoConsulta('Op','op');
        $oData = new CampoConsulta('Data','data', CampoConsulta::TIPO_DATA);
        $oCodigo = new CampoConsulta('Codigo','prod');
        $oReferencia = new CampoConsulta('Referência','referencia');
        $oProdes = new CampoConsulta('Descrição','prodes');
        
        $oReceitaDes = new CampoConsulta('Receita','receita_des');
        $oQuant = new CampoConsulta('Quantidade','quant', CampoConsulta::TIPO_DECIMAL);
        $oPeso = new CampoConsulta('Peso','peso', CampoConsulta::TIPO_DECIMAL);
        $oRetrabalho = new CampoConsulta('Retr.','retrabalho', CampoConsulta::TIPO_TEXTO);
        $oSituacao = new CampoConsulta('Situação', 'situacao');
        $oSituacao->addComparacao('Aberta', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Cancelada', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO,CampoConsulta::MODO_COLUNA);
        $oSituacao->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        
        $oDocumento = new CampoConsulta('NotaEnt', 'documento');
        $oTipOrdem = new CampoConsulta('Tipo','tipoOrdem');
        $oTipOrdem->addComparacao('P', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA,true,'Padrão');
        $oTipOrdem->addComparacao('F', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA,true,'Fio Máq.');
        $oTipOrdem->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA,true,'Arame');
        
        $oNrCarga = new campoconsulta('NºCarga','nrCarga');
        
        $oOpFiltro = new Filtro($oOp, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL,2);
        $oDescricaoFiltro = new Filtro($oProdes, Filtro::CAMPO_TEXTO,3);
        
        $oDocFiltro = new Filtro($oDocumento, Filtro::CAMPO_TEXTO_IGUAL,1);
        
        $oTipoAcaoFiltro = new Filtro($oRetrabalho, Filtro::CAMPO_SELECT, 3,2,12,12,true);
        $oTipoAcaoFiltro->addItemSelect('Todos', 'Todos');
        $oTipoAcaoFiltro->addItemSelect('Não', 'Não incluí retrab.');
        $oTipoAcaoFiltro->addItemSelect('Sim', 'Incluí');
        $oTipoAcaoFiltro->setSLabel('Retrab.');
        $oTipoAcaoFiltro->setBInline(true);
        
        $oFiltroReferencia = new Filtro($oReferencia, Filtro::CAMPO_TEXTO_IGUAL,2,2,2,2);
        
        $oFilEmpresa = new Filtro($oEmpCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilEmpresa->setSClasseBusca('DELX_CAD_Pessoa');
        $oFilEmpresa->setSCampoRetorno('emp_codigo', $this->getTela()->getSId());
        $oFilEmpresa->setSIdTela($this->getTela()->getSId());
        
        $this->addFiltro($oOpFiltro,$oCodigoFiltro,$oDescricaoFiltro,$oFilEmpresa,$oDocFiltro,$oTipoAcaoFiltro,$oFiltroReferencia);
        
        $this->setUsaAcaoExcluir(FALSE);
        
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        
        $this->addCampos($oOp,$oBotaoModal,$oTipOrdem,$oSituacao,$oNrCarga,$oData,$oCodigo,$oReferencia,$oProdes,$oPeso,$oRetrabalho,$oDocumento);
        
       
        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir',Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_OrdensFab', 'acaoMostraRelEspecifico', '', false, 'OpSteel1',false,'',false,'',true);
       // $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar FIO MÁQ', 'STEEL_PCP_OrdensFab', 'acaoMostraRelTESTE', '', false, 'RelOpSteel3',false,'',false,'',true);
       // $oDrop1->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Enviar para meu email', 'STEEL_PCP_OrdensFab', 'geraPdfOp', '', false, 'OpSteel1',false,'',false,'',true);
        $oDrop2 = new Dropdown('Açao', Dropdown::TIPO_DARK);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Cancelar OP', 'STEEL_PCP_OrdensFab', 'msgCancelaOp', '', false, '');
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Retornar para Aberta', 'STEEL_PCP_OrdensFab', 'msgAbertaOp', '', false, '');
        
        
        $oDrop3 = new Dropdown('Retrabalho', Dropdown::TIPO_AVISO);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Colocar em Retrabalho', 'STEEL_PCP_OrdensFab', 'msgRetrabalhoOp', '', false, '');
        
        $this->addDropdown($oDrop1,$oDrop2,$oDrop3);
        $this->getTela()->setiAltura(750);
        
    }
    
    
    public function criaTela() {
        parent::criaTela();
        
        $sAcao =  $this->getSRotina();
        
        $oDados = $this->getAParametrosExtras();
        
        $sClasse = get_class($oDados);
        
        $oOp = new Campo('Op nr.','op', Campo::TIPO_TEXTO,1);
        $oOp->setBCampoBloqueado(true);
        
        
        $oOrigem = new Campo('Origem','origem', Campo::TIPO_TEXTO,1);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        if(method_exists($oDados, 'getNfsnfnro')) 
        {$oOrigem->setSValor('Romaneio');}else{$oOrigem->setSValor('Manual');}}else{
         if(method_exists($oDados, 'getNfnro')) 
          {$oOrigem->setSValor('XML');}else{$oOrigem->setSValor('Manual');}  
        }
         $oOrigem->setBCampoBloqueado(true);
        
        $oL1 = new Campo('','l1', Campo::TIPO_LINHA);
        $oL1->setApenasTela(true);
        
        $oDocumento = new Campo('Doc.Fiscal / OC','documento', Campo::TIPO_TEXTO,2);
        $oDocumento->setBFocus(true);
        $oDocumento->addValidacao(false, Validacao::TIPO_STRING);
         if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        if(method_exists($oDados, 'getNfsnfnro')) 
         {$oDocumento->setSValor($oDados->getNfsnfnro());}}else{
          if(method_exists($oDados, 'getNfnro')) 
           {$oDocumento->setSValor($oDados->getNfnro());}   
         }
        
        $oTipo = new Campo('Tipo OP','tipoOrdem', Campo::TIPO_SELECT,3);
        $oTipo->addItemSelect('P','Padrão - Tempera');
        $oTipo->addItemSelect('F','Fio Máquina - Industrialização'); 
        $oTipo->addItemSelect('A','Arame - Venda');
       
         
        
        //cliente
        $oEmp_codigo = new Campo('Cliente','emp_codigo',Campo::TIPO_BUSCADOBANCOPK,2);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        $oEmp_codigo->setSValor('75483040000211');}else{
            if(method_exists($oDados, 'getNfnro')) 
             {$oEmp_codigo->setSValor($oDados->getEmpcod());} 
        }
        $oEmp_codigo->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do produto adicionando o campo de busca
        $oEmp_des = new Campo('Razão Social','emp_razaosocial',Campo::TIPO_BUSCADOBANCO, 4);
        $oEmp_des->setSIdPk($oEmp_codigo->getId());
        $oEmp_des->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_des->addCampoBusca('emp_codigo', '','');
        $oEmp_des->addCampoBusca('emp_razaosocial', '','');
        $oEmp_des->setSIdTela($this->getTela()->getId());
        $oEmp_des->addValidacao(false, Validacao::TIPO_STRING);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        $oEmp_des->setSValor('METALBO INDUSTRIA DE FIXADORES METALICOS LTDA');}else{
            if(method_exists($oDados, 'getEmpdes')) 
             {$oEmp_des->setSValor($oDados->getEmpdes());} 
        }
        
        //declarar o campo descrição
        $oEmp_codigo->setClasseBusca('DELX_CAD_Pessoa');
        $oEmp_codigo->setSCampoRetorno('emp_codigo',$this->getTela()->getId());
        $oEmp_codigo->addCampoBusca('emp_razaosocial',$oEmp_des->getId(),  $this->getTela()->getId());
        
        
        
       
         //campo código do produto
        $oCodigo = new Campo('Codigo.Interno','prod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
         if(method_exists($oDados, 'getNfsitcod')) 
         {$oCodigo->setSValor($oDados->getNfsitcod());}
        }else{
            if(method_exists($oDados, 'getCodInterno')) 
            {$oCodigo->setSValor($oDados->getCodInterno());}
        }
         
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto','prodes',Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '','');
        $oProdes->addCampoBusca('pro_descricao', '','');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->addValidacao(false, Validacao::TIPO_STRING);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        if(method_exists($oDados, 'getNfsitdes')) 
         {$oProdes->setSValor($oDados->getNfsitdes());}
        }else{
            if(method_exists($oDados, 'getProdes')) 
            {$oProdes->setSValor($oDados->getProdes());}
        }
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oProdes->getId(),  $this->getTela()->getId());
        
        //produto final
        $oProdFinal = new Campo('Produto.Final','prodFinal', Campo::TIPO_BUSCADOBANCOPK,2);
       // $oProdFinal->setBCampoBloqueado(true);
        
        $oProdFinalDes = new Campo('DescFinal','prodesFinal', Campo::TIPO_BUSCADOBANCO,4);
        $oProdFinalDes->setBOculto(true);
        $oProdFinalDes->setSIdPk($oProdFinal->getId());
        $oProdFinalDes->setClasseBusca('DELX_PRO_Produtos');
        $oProdFinalDes->addCampoBusca('pro_codigo', '','');
        $oProdFinalDes->addCampoBusca('pro_descricao', '','');
        $oProdFinalDes->setSIdTela($this->getTela()->getId());
        $oProdFinalDes->addValidacao(false, Validacao::TIPO_STRING);
        
        $oProdFinal->setClasseBusca('DELX_PRO_Produtos');
        $oProdFinal->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oProdFinal->addCampoBusca('pro_descricao',$oProdFinalDes->getId(),  $this->getTela()->getId());
        //pesquisa produto material receita 
        $oBtnPesqOp = new Campo('Pesquisar Prod/Mat/Receita','btn1', Campo::TIPO_BOTAOSMALL,2,2,2,2);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $oBtnPesqOp->setApenasTela(true);
       
        //referencia do produto do cliente
        $oReferencia = new campo('Referência do Cliente','referencia', Campo::TIPO_TEXTO,3);
        $oReferencia->setSCorFundo(Campo::FUNDO_AMARELO);
        $oReferencia->addValidacao(false, Validacao::TIPO_STRING);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
         if(method_exists($oDados, 'getNfsitcod')) 
         {$oReferencia->setSValor($oDados->getNfsitcod());}
        }else{
            if(method_exists($oDados, 'getProcod')) 
            {$oReferencia->setSValor($oDados->getProcod());}
        }
        
        
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
        $oCodMat = new Campo('Material','matcod', Campo::TIPO_TEXTO,1);
        $oCodMat->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCodMat->setBCampoBloqueado(true);
        
        
        //busca material descrição
        $oMatDes = new Campo('Material Descrição','matdes', Campo::TIPO_TEXTO,2);
        $oMatDes->setBCampoBloqueado(true);
     
        
        ///////////////////////////////////////////////////////////////////////////////
        
        //busca campo receita
        $oReceita = new Campo('Receita','receita', Campo::TIPO_TEXTO,1);
        $oReceita->setSCorFundo(Campo::FUNDO_AMARELO);
        $oReceita->setBCampoBloqueado(true);
        $oReceitaDes = new Campo('Descrição','receita_des', Campo::TIPO_TEXTO,3);
        $oReceitaDes->setBCampoBloqueado(true);
        
        $oSeqMat = new Campo ('SeqMat','seqmat', Campo::TIPO_TEXTO,1);
        $oSeqMat->addValidacao(false, Validacao::TIPO_STRING);
        $oSeqMat->setBCampoBloqueado(true);
       
        
        $oTempRev = new Campo('Temp.Rev','temprev', Campo::TIPO_DECIMAL,1);
        //monta o evento para buscar receita padrão
        
        $sEvento1 = 'var codigo = $("#'.$oCodigo->getId().'").val(); var tipoOrdem = $("#'.$oTipo->getId().'").val();'
          . 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");'
          .'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_Produtos","buscaReferencia","' . $oReferencia->getId() . '");'    //buscaReferencia   
    . 'if(tipoOrdem!=="A"){$("#'.$oProdFinal->getId().'").val(codigo);}';
       
        $oCodigo->addEvento(Campo::EVENTO_SAIR,$sEvento1);
        $oBtnPesqOp->getOBotao()->addAcao($sEvento1);
        $sEvento2 = ' var prodes = $("#'.$oProdes->getId().'").val(); var tipoOrdem = $("#'.$oTipo->getId().'").val();' 
                    . 'if(tipoOrdem!=="A"){$("#'.$oProdFinalDes->getId().'").val(prodes);}';
                
        
        $oProdes->addEvento(Campo::EVENTO_SAIR,$sEvento2);
        
        $oLinha = new Campo('','linha', Campo::TIPO_LINHA,12);
        $oLinha->setApenasTela(true);
        
        $oQuant = new Campo('Quant{Peso ou CT}','quant', Campo::TIPO_DECIMAL,2);
        $oQuant->setSValor('0,00');
        $oQuant->setSCorFundo(Campo::FUNDO_AMARELO);
        $oQuant->addValidacao(false, Validacao::TIPO_STRING);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
         if(method_exists($oDados, 'getNfsitqtd')) 
        {$oQuant->setSValor(number_format($oDados->getNfsitqtd(), 2, ',', '.'));}}else{
          if(method_exists($oDados, 'getQtd')) 
            {$oQuant->setSValor(number_format($oDados->getQtd(), 2, ',', '.'));}   
        }
        
        
        $oPeso = new Campo('Peso{Em KG * cáculo insumos e serviços}','peso', Campo::TIPO_DECIMAL,4);
        $oPeso->setSValor('0,00');
        $oPeso->setSCorFundo(Campo::FUNDO_MONEY);
        $oPeso->addValidacao(false, Validacao::TIPO_STRING);
        if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        if(method_exists($oDados, 'getPeso')) 
        {$oPeso->setSValor(number_format($oDados->getPeso(), 2, ',', '.'));}}else{
            if(method_exists($oDados, 'getQtd')) 
            {$oPeso->setSValor(number_format($oDados->getQtd(), 2, ',', '.'));}
        }
         
         
         $oValorUnit = new campo('Valor Unitário','vlrNfEntUnit', Campo::TIPO_DECIMAL,1);
         $oValorUnit->setSValor('0,00');
         if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
          if(method_exists($oDados, 'getVlrNfEntUnit')) 
         {$oValorUnit->setSValor(number_format($oDados->getVlrNfEntUnit(), 2, ',', '.'));}}else{
             if(method_exists($oDados, 'getVlrUnit')) 
            {$oValorUnit->setSValor(number_format($oDados->getVlrUnit(), 2, ',', '.'));}
         }
         
         $oValorEnt = new campo('Valor Total','vlrNfEnt', Campo::TIPO_DECIMAL,1);
         $oValorEnt->setSValor('0,00');
          if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
          if(method_exists($oDados, 'getVlrNfEnt')) 
          {$oValorEnt->setSValor(number_format($oDados->getVlrNfEnt(), 2, ',', '.'));}} else {
             if(method_exists($oDados, 'getVlrTotal')) 
            {$oValorEnt->setSValor(number_format($oDados->getVlrTotal(), 2, ',', '.'));}
          }
        
         $sEventoCalculo = 'precoNfEntradaSteel("'.$oQuant->getId().'","'.$oValorUnit->getId().'","'.$oValorEnt->getId().'");';
         

         //eventos
         $oQuant->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         
         $oPeso->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         
         $oValorUnit->addEvento(Campo::EVENTO_SAIR,$sEventoCalculo);
         
         
         
        
        $oOpCli = new Campo('OP do cliente','opcliente', Campo::TIPO_TEXTO,2);
         if(method_exists($oDados, 'getMetof')) 
         {$oOpCli->setSValor($oDados->getMetof());}else{
              if(method_exists($oDados, 'getOpCliente')) 
           { $oOpCli->setSValor($oDados->getOpCliente());} 
         }
         
         /*if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
        if(method_exists($oDados, 'getNfsnfnro')) 
         {$oDocumento->setSValor($oDados->getNfsnfnro());}}else{
          if(method_exists($oDados, 'getNfnro')) 
           {$oDocumento->setSValor($oDados->getNfnro());}   
         }*/
        
        
        
         $oObs = new campo('Observação','obs', Campo::TIPO_TEXTAREA,8);
         $oDataPrev = new Campo('Data prevista','dataprev', Campo::TIPO_DATA,2);  
         $oDataPrev->setSValor(date('d/m/Y',strtotime('+7 days')));
         
         $oNrCarga = new campo('NºCargaDev','nrCarga', Campo::TIPO_TEXTO,1,1,1,1);
         $oNrCarga->setBCampoBloqueado(true);
         $oNrCarga->setSValor('Sem Carga');
         
         $oXPed = new campo('xPed*{Número OD/OC para sair no xml}','xPed', Campo::TIPO_TEXTO,4,4,4,4);
         $nItemPed = new campo('Seq. OD/OC para sair no xml','nItemPed', Campo::TIPO_TEXTO,3,3,3,3);
         $nItemPed->addValidacao(true, Validacao::TIPO_INTEIRO,'');
        
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
        
         if($sClasse !=='ModelSTEEL_PCP_ImportaXml'){
            if(method_exists($oDados, 'getNfsitseq')) 
             {$oSeqProdNr->setSValor($oDados->getNfsitseq());}
         }else{
             if(method_exists($oDados, 'getSeq')) 
            {$oSeqProdNr->setSValor($oDados->getSeq());}
         }
        
        //ativa o fechamento da tela ao inserir
        $this->getTela()->setBFecharTelaIncluir(true);
        
        //evento click, parametros=>idgrid,pk,codMaterial,DescMaterial,codReceita,DescReceita,SeqMat
        $oGridMat->getOGrid()->setSEventoClick('var chave=""; $("#'.$oGridMat->getId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
               . 'if(chave!==""){requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","sendDadosCampos","'.$oGridMat->getId().'"+","+chave+","+"'.$oCodMat->getId().'"+",'
                . '"+"'.$oMatDes->getId().'"+","+"'.$oReceita->getId().'"+","+"'.$oReceitaDes->getId().'"+","+"'.$oSeqMat->getId().'"+","+"'.$oTempRev->getId().'");} ');
        
        
        if($sAcao=='acaoAlterar'){
         $sAcaoBuscaIni = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_prodMatReceita","getDadosGrid","' . $oGridMat->getId() . '","consultaMatOrdem");';
         $this->getTela()->setSAcaoShow($sAcaoBuscaIni);
        }
        
        $oField1 = new FieldSet('Retrabalho');
        
        $oRetrabalho = new Campo('Retrabalho','retrabalho', Campo::TIPO_SELECT,1);
        $oRetrabalho->setSValor('Não');
        $oRetrabalho->addItemSelect('Não','Não');
        $oRetrabalho->addItemSelect('Sim','Sim');
        
        
        $oOpRet = new Campo('Op Origem Retra.','op_retrabalho', Campo::TIPO_TEXTO,2);
        $oOpRet->setBCampoBloqueado(false);
        
        
        $oField1->addCampos(array($oRetrabalho,$oOpRet));
        $oField1->setOculto(true);
        
        $this->addCampos(array($oOp,$oOrigem,$oData,$oHora,$oUser,$oSeqProdNr, $oSituacao),
                $oLinha,
                array($oDocumento,$oEmp_codigo,$oEmp_des,$oTipo),$oLinha,
                array($oCodigo,$oProdes,$oReferencia),$oLinha,
                array($oProdFinal,$oProdFinalDes,$oBtnPesqOp),$oLinha,
                $oGridMat,
                array($oCodMat, $oMatDes,$oReceita,$oReceitaDes,$oSeqMat),
               $oLinha,
                array($oOpCli,$oQuant,$oPeso,$oValorUnit,$oValorEnt,$oTempRev),$oObs,array($oDataPrev,$oNrCarga,$oXPed,$nItemPed ),$oField1);
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
    
    public function criaModalAponta(){
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();
        
        $oOp = new Campo('OP','op', Campo::TIPO_TEXTO,2);
        $oOp->setSValor($oDados->getOp());
        $oOp->setBCampoBloqueado(true);
        
        $oForno = new Campo('Forno','fornodes', Campo::TIPO_TEXTO,2);
        $oForno->setSValor($oDados->getFornodes());
        $oForno->setBCampoBloqueado(true);
        
        $oCod = new Campo('Código','procod', Campo::TIPO_TEXTO,2);
        $oCod->setSValor($oDados->getProcod());
        $oCod->setBCampoBloqueado(true);
        
        $oDes = new Campo('Descrição do Produto','prodes', Campo::TIPO_TEXTO,6,6,6,6);
        $oDes->setSValor($oDados->getProdes());
        $oDes->setBCampoBloqueado(true);
        
        $oDtEnt = new Campo('Data Entrada','dataent_forno', Campo::TIPO_TEXTO,2);
        $oDtEnt->setSValor(date('d/m/Y', strtotime($oDados->getDataent_forno())));
        $oDtEnt->setBCampoBloqueado(true);
        
        $oHoEnt = new Campo('Hora Entrada','horaent_forno', Campo::TIPO_TEXTO,2);
        $oHoEnt->setSValor(date('H:i:s', strtotime($oDados->getHoraent_forno())));
        $oHoEnt->setBCampoBloqueado(true);
        
        $oDtSai = new Campo('Data Saída','datasaida_forno', Campo::TIPO_TEXTO,2);
        $oDtSai->setSValor(date('d/m/Y', strtotime($oDados->getDatasaida_forno())));
        $oDtSai->setBCampoBloqueado(true);
        
        $oHoSai = new Campo('Hora Saída','horasaida_forno', Campo::TIPO_TEXTO,2);
        $oHoSai->setSValor(date('H:i:s', strtotime($oDados->getHorasaida_forno())));
        $oHoSai->setBCampoBloqueado(true);
        
        $oSit = new Campo('Situação','situacao', Campo::TIPO_TEXTO,2);
        $oSit->setSValor($oDados->getSituacao());
        $oSit->setBCampoBloqueado(true);
        
        $oCodE = new Campo('Cod.','coduser', Campo::TIPO_TEXTO,2);
        $oCodE->setSValor($oDados->getCoduser());
        $oCodE->setBCampoBloqueado(true);
        
        $oUserE = new Campo('Usuário Entrada','usernome', Campo::TIPO_TEXTO,2);
        $oUserE->setSValor($oDados->getUsernome());
        $oUserE->setBCampoBloqueado(true);
        
        $oCodSai = new Campo('Cod.','codusersaida', Campo::TIPO_TEXTO,2);
        $oCodSai->setSValor($oDados->getCodusersaida());
        $oCodSai->setBCampoBloqueado(true);
        
        $oUserS = new Campo('Usuário Saída','usernomesaida', Campo::TIPO_TEXTO,2);
        $oUserS->setSValor($oDados->getUsernomesaida());
        $oUserS->setBCampoBloqueado(true);
        
        $oDiv = new campo('Entradas','div', Campo::DIVISOR_SUCCESS,12,12,12,12);
        $oDiv->setApenasTela(true);
        
        $oDiv1 = new campo('Saídas','div1', Campo::DIVISOR_DARK,12,12,12,12);
        $oDiv1->setApenasTela(true);
        
        $sLinha = new Campo('','label', Campo::TIPO_LINHABRANCO,12,12,12,12);
        
        $this->addCampos(array($oOp,$oForno,$oCod,$oDes),$oDiv,$sLinha,
                array($oDtEnt,$oHoEnt,$oUserE),$sLinha,
                $oDiv1,$sLinha,
                array($oDtSai,$oHoSai,$oUserS));
    }
}
