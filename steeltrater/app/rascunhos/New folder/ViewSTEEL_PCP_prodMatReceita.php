<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class ViewSTEEL_PCP_prodMatReceita extends View {

    public function criaConsulta() {
        parent::criaConsulta();    

        $oSeqMat = new CampoConsulta('Seq.Mat.','seqmat');
        $oProCod = new CampoConsulta('Cód. Prod.','prod');
        $oProDes = new CampoConsulta('Descrição', 'DELX_PRO_Produtos.pro_descricao');
        $oMatCod = new CampoConsulta('Cod. Material','matcod');
        $oMatDes = new CampoConsulta('Descrição', 'STEEL_PCP_material.matdes');
        $oRecCod = new CampoConsulta('Cod. Receita', 'cod');
        $oRecDes = new CampoConsulta('Descrição','STEEL_PCP_receitas.peca');
       // $oNucDur = new CampoConsulta('Dur.Nuc.','durezaNucMin');
        //$oSupDur = new CampoConsulta('Dur.Superf','durezaSuperfMin');
       // $oCamDur = new CampoConsulta('Expessura.Camada','expCamadaMin');
        
        $oFilProdCod = new Filtro($oProCod, Filtro::CAMPO_TEXTO, 3);
        $oFiltroProdes = new Filtro($oProDes, Filtro::CAMPO_TEXTO,3);
        $this->addFiltro($oFilProdCod,$oFiltroProdes);
        
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oSeqMat,$oProCod ,$oProDes,$oMatCod,$oMatDes, $oRecCod, $oRecDes);
    }
    
    public function consultaMatOrdem() {
        $oGridMat = new Grid("");
        
        $oSeqMatGrid = new CampoConsulta('Seq.Mat.','seqmat');
        $oProDesGrid = new CampoConsulta('Produto', 'DELX_PRO_Produtos.pro_descricao');
        $oMatDesGrid = new CampoConsulta('Material', 'STEEL_PCP_material.matdes');
        $oRecDesGrid = new CampoConsulta('Receita','STEEL_PCP_receitas.peca');
        
        $oGridMat->addCampos($oSeqMatGrid,$oProDesGrid,$oMatDesGrid,$oRecDesGrid);

        $aCampos = $oGridMat->getArrayCampos();
        return $aCampos;
    }

    public function criaTela() {
        parent::criaTela();
        
        $oTab = new TabPanel();
        $oAbaPadrao = new AbaTabPanel('PADRÃO');
        $oAbaPadrao->setBActive(true);

        $this->addLayoutPadrao('Aba');
                
        $sAcao =  $this->getSRotina();
        
        $oCodigo = new Campo('Produto','prod',Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodigo->addValidacao(false, Validacao::TIPO_STRING);
        if($sAcao=='acaoAlterar'){$oCodigo->setBCampoBloqueado(true);}
        
        //campo descrição do produto adicionando o campo de busca
        $oProdes = new Campo('Produto Descrição','DELX_PRO_Produtos.pro_descricao',Campo::TIPO_BUSCADOBANCO, 4);
        $oProdes->setSIdPk($oCodigo->getId());
        $oProdes->setClasseBusca('DELX_PRO_Produtos');
        $oProdes->addCampoBusca('pro_codigo', '','');
        $oProdes->addCampoBusca('pro_descricao', '','');
        $oProdes->setSIdTela($this->getTela()->getId());
        $oProdes->addValidacao(false, Validacao::TIPO_STRING);
         if($sAcao=='acaoAlterar'){$oProdes->setBCampoBloqueado(true);}
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodigo->setClasseBusca('DELX_PRO_Produtos');
        $oCodigo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        $oCodigo->addCampoBusca('pro_descricao',$oProdes->getId(),  $this->getTela()->getId());
        
        $oMatCod = new Campo('Material', 'matcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oMatCod->addValidacao(true, Validacao::TIPO_STRING);
         if($sAcao=='acaoAlterar'){$oMatCod->setBCampoBloqueado(true);}
                
        //campo descrição do material adicionando o campo de busca
        $oMatdes = new Campo('Material Descrição','STEEL_PCP_material.matdes',Campo::TIPO_BUSCADOBANCO, 4);
        $oMatdes->setSIdPk($oMatCod->getId());
        $oMatdes->setClasseBusca('STEEL_PCP_Material');
        $oMatdes->addCampoBusca('matcod', '','');
        $oMatdes->addCampoBusca('matdes', '','');
        $oMatdes->setSIdTela($this->getTela()->getId());
        $oMatdes->addValidacao(false, Validacao::TIPO_STRING);
         if($sAcao=='acaoAlterar'){$oMatdes->setBCampoBloqueado(true);}
        
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oMatCod->setClasseBusca('STEEL_PCP_Material');
        $oMatCod->setSCampoRetorno('matcod',$this->getTela()->getId());
        $oMatCod->addCampoBusca('matdes',$oMatdes->getId(),  $this->getTela()->getId());
        
        $oRecCod = new Campo('Receita', 'cod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oRecCod->addValidacao(true, Validacao::TIPO_STRING);
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
        
        $oLabel1 = new Campo('', 'label1', Campo::TIPO_LINHA);
        $oLabel1->setApenasTela(true);
         
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oRecCod->setClasseBusca('STEEL_PCP_receitas');
        $oRecCod->setSCampoRetorno('cod',$this->getTela()->getId());
        $oRecCod->addCampoBusca('peca',$oRecdes->getId(),  $this->getTela()->getId());
        
        $oNucDurMin = new Campo('Dur.NucMin.','durezaNucMin', Campo::TIPO_DECIMAL,2);
        //$oNucDurMin->addValidacao(false, Validacao::TIPO_DECIMAL);
       
        $oNucDurMax = new Campo('Dur.NucMax.','durezaNucMax', Campo::TIPO_DECIMAL,2);
        //$oNucDurMax->addValidacao(false, Validacao::TIPO_DECIMAL);
       
        $oNucEscala = new Campo('Escala','NucEscala', Campo::TIPO_SELECT,1);
        $oNucEscala->addItemSelect('HRC','HRC');
        $oNucEscala->addItemSelect('HV','HV');
        $oNucEscala->addItemSelect('HRB','HRB');
        $oNucEscala->addItemSelect('HRA','HRA');
        $oNucEscala->addItemSelect('HB','HB');
        
        
        $oSupDurMin = new Campo('Dur.SuperfMin','durezaSuperfMin', Campo::TIPO_DECIMAL,2);
    
        $oSupDurMax = new Campo('Dur.SuperfMax','durezaSuperfMax', Campo::TIPO_DECIMAL,2);
     
        $oSupEscala = new Campo('Escala','SuperEscala', Campo::TIPO_SELECT,1);
        $oSupEscala->addItemSelect('HRC','HRC');
        $oSupEscala->addItemSelect('HV','HV');
        $oSupEscala->addItemSelect('HRB','HRB');
        $oSupEscala->addItemSelect('HRA','HRA');
        $oSupEscala->addItemSelect('HB','HB');
        
        $oCamDurMin = new Campo('Exp.CamadaMin','expCamadaMin', Campo::TIPO_TESTE,2);
      
        $oCamDurMax = new Campo('Exp.CamadaMax','expCamadaMax', Campo::TIPO_TESTE,2);
      
        
        $oSeqMat = new Campo('Seq.Mat.','seqmat', Campo::TIPO_TEXTO,1);
        $oSeqMat->setBCampoBloqueado(true);
        
        
        $oTratReven = new Campo('Descrição composta revenimento (Deve estar marcado no cadastro de tratamento "Revenir Composto")','tratrevencomp', Campo::TIPO_SELECT,7);
        $oTratReven->addItemSelect('E ENEGRECIDO','REVENIDO E ENEGRECER');
        $oTratReven->addItemSelect('À SECO','REVENIDO À SECO');
        $oTratReven->addItemSelect('ENEGRECIDO OLEADO','REVENIDO ENEGRECIDO OLEADO');
        
        
        $oPpap = new Campo('PPAP','ppap', Campo::TIPO_SELECT,1);
        $oPpap->addItemSelect('S','Sim');
        $oPpap->addItemSelect('N','Não');
        $oPpap->setSValor('N');
        
        $oNrPpap = new Campo('Nr.','nrppap', Campo::TIPO_TEXTO,1);
        
        $oAbaFioMaquina = new AbaTabPanel('FIO MÁQUINA');
        
        $oFioDurezaSol = new Campo('Dureza.Solicitada(HRB)','fioDurezaSol', Campo::TIPO_DECIMAL,2);
        $oFioEsferio = new campo('Esferiodização(%)','fioEsferio', Campo::TIPO_DECIMAL,2);
        $oFioDescarbonetaTotal = new campo('Descarb.Total(µm)','fioDescarbonetaTotal', Campo::TIPO_DECIMAL,2);
        $oFioDescarbonetaParcial = new campo('Descarb.Parcial(µm)','fioDescarbonetaParcial', Campo::TIPO_DECIMAL,2);
        $oDiamFinalMin = new campo('Diâmetro Final Mínimo(mm)','DiamFinalMin',Campo::TIPO_DECIMAL,3);
        $oDiamFinalMax = new campo('Diâmetro Final Máximo(mm)','DiamFinalMax',Campo::TIPO_DECIMAL,3);
        
        $oAbaPadrao->addCampos(array($oNucDurMin,$oNucDurMax,$oNucEscala),
                           array($oSupDurMin,$oSupDurMax,$oSupEscala), 
                           array($oCamDurMin,$oCamDurMax));
        
        $oAbaFioMaquina->addCampos(array($oFioDurezaSol,$oFioEsferio),
                            array($oFioDescarbonetaTotal,$oFioDescarbonetaParcial),
                            array($oDiamFinalMin,$oDiamFinalMax));
   
        $oTab->addItems($oAbaPadrao,$oAbaFioMaquina);
        $this->addCampos($oSeqMat, array($oCodigo,$oProdes),array($oMatCod, $oMatdes),
                array($oRecCod, $oRecdes), 
                $oLabel1,array($oTratReven,$oPpap,$oNrPpap),$oLabel1,$oTab);
    }
    
    public function RelItensPPAP(){        
        parent::criaTelaRelatorio(); 
        
        $this->setTituloTela('Relatório de Itens Com ou Sem PPAP');        
        $this->setBTela(true);   
                       
        $oPpap = new Campo('PPAP','ppap', Campo::TIPO_SELECT,2);
        $oPpap->addItemSelect('S','Sim');
        $oPpap->addItemSelect('N','Não');
        
        $this->addCampos($oPpap);
    }
}