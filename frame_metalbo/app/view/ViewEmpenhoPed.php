<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewEmpenhoPed extends View{
   
    public function criaTela() {
        parent::criaTela();
       
        $this->setBTela(true);
        
        $oCnpj = new Campo('Cliente','cnpj', Campo::TIPO_BUSCADOBANCOPK, 2);
      //  $oCnpj->addValidacao(false, Validacao::TIPO_STRING,'',2);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
       
        $oEmpresa = new Campo('Razão Social','cliente', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addCampoBusca('empcod', '','');
        $oEmpresa->addCampoBusca('empdes', '','');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod',$this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes',$oEmpresa->getId(),  $this->getTela()->getId());
        
        $oSituaca = new Campo('Situação','situaca', Campo::TIPO_SELECT,2);
        $oSituaca->addItemSelect('O', 'LIBERADO');
        $oSituaca->addItemSelect('T', 'FATURADO');
        $oSituaca->addItemSelect('C', 'CANCELADO');
        $oSituaca->addItemSelect('B', 'BLOQUEADO');
        
         /*grid de consulta*/
        $oGridEmpenho = new Campo('Consulta Empenho','gridEmpenho', Campo::TIPO_GRID,12,12,12,12,350);
         $oPdvnro = new CampoConsulta('Pedido','pdvnro');
        $oPdvnro->setILargura(50);
        $oEmpdes = new CampoConsulta('Cliente','empdes');
        $oEmpdes->setILargura(500);
        $oTotal = new CampoConsulta('Total','total', CampoConsulta::TIPO_DECIMAL);
        $oTotal->setILargura(100);
        $oDataEnt = new CampoConsulta('Data Entrega','pdvdtentre');
        $oDataEnt->setILargura(120);
        $oEmissao = new CampoConsulta('Emissão','pdvemissao');
        $oEmissao->setILargura(120);
        $oSit = new CampoConsulta('Situação','situaca');
        $oSit->addComparacao('LIBERADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oGridEmpenho->addCampos($oPdvnro,$oEmpdes,$oTotal,$oDataEnt,$oEmissao,$oSit);
        $oGridEmpenho->setSController('EmpenhoPed');
        
        $oCodigo = new Campo('Codigo','codigo',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodigo->setClasseBusca('Produto');
        $oCodigo->setSCampoRetorno('procod',$this->getTela()->getId());
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        if($_REQUEST['parametrosCampos']){
                    foreach ($_REQUEST['parametrosCampos'] as $sAtual){
                        $sProcod = $sAtual ;
                    }
        }
        $oCodigo->setSValor($sProcod);
        
        
        $oMercAberto = new Campo('Mercado Interno','interno', Campo::TIPO_TEXTO,2,2,2,2);
        $oMercAberto->setSCorFundo(Campo::FUNDO_MONEY);
        $oMercAberto->setITamanho(Campo::TAMANHO_GRANDE);
        
        
        $oExp = new campo('Exportações','exp', Campo::TIPO_TEXTO,2,2,2,2);
        $oExp->setSCorFundo(Campo::FUNDO_VERDE);
        $oExp->setITamanho(Campo::TAMANHO_GRANDE);
        
        $oExpLib = new Campo('Somente Exp. Liberadas','libexp', Campo::TIPO_TEXTO,2,2,2,2);
        $oExpLib->setITamanho(Campo::TAMANHO_GRANDE);
        
       
        $sAcao ='requestAjax("'.$this->getTela()->getId().'-form","EmpenhoPed","getDadosGrid","'.$oGridEmpenho->getId().'","GridEmpenho");'
                .'var procod = $("#'.$oCodigo->getId().'").val(); requestAjax("'.$this->getTela()->getId().'-form",'
                . '"EmpenhoPed","SomaEmpenho",procod+",'.$oMercAberto->getId().','.$oExp->getId().','.$oExpLib->getId().'");'; 
        $oBtnBuscar = new Campo('Buscar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $oBtnBuscar->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnBuscar->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        $this->getTela()->setSAcaoShow($sAcao);
        
        
        $this->addCampos(array($oCodigo,$oCnpj,$oEmpresa,$oBtnBuscar),$oGridEmpenho,array($oMercAberto,$oExp,$oExpLib));
        
    }
    
     function GridEmpenho(){
       
        $oGridEmp = new Grid(""); 
        
        $oPdvnro = new CampoConsulta('Pedido','pdvnro');
        $oPdvnro->setILargura(50);
        $oEmpdes = new CampoConsulta('Cliente','empdes');
        $oEmpdes->setILargura(500);
        $oTotal = new CampoConsulta('Total','total', CampoConsulta::TIPO_DECIMAL);
        $oTotal->setILargura(100);
        $oDataEnt = new CampoConsulta('Data Entrega','pdvdtentre');
        $oDataEnt->setILargura(120);
        $oEmissao = new CampoConsulta('Emissão','pdvemissao');
        $oEmissao->setILargura(120);
        $oSit = new CampoConsulta('Situação','situaca');
        $oSit->addComparacao('LIBERADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        
        $oGridEmp->addCampos($oPdvnro,$oEmpdes,$oTotal,$oDataEnt,$oEmissao,$oSit);
       
        $aCampos = $oGridEmp->getArrayCampos();
        return $aCampos;
        }
}