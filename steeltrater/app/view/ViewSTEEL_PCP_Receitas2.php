<?php

/* 
 * Classe que implementa view das receiras das ofs
 * 
 * @author Avanei Martendal
 * @since 15/16/2018
 * 
 */

class ViewSTEEL_PCP_Receitas extends View {
    public function criaConsulta() {
        parent::criaConsulta();
        $oGridItens = new Campo('Itens da receita','ReceitaItens', Campo::TIPO_GRID,12,12,12,12,150);
        $oCod = new CampoConsulta('Código','cod');
        $oSeq = new CampoConsulta('Seq.','seq');
        $oTrat = new CampoConsulta('Tratamento','STEEL_PCP_Tratamentos.tratcod');
        $oTratDes = new CampoConsulta('Desc','STEEL_PCP_Tratamentos.tratdes');
        $oCamadaMin = new CampoConsulta('CamadaMín','camada_min', CampoConsulta::TIPO_DECIMAL);
        $oCamadaMax = new CampoConsulta('CamadaMáx','camada_max', CampoConsulta::TIPO_DECIMAL);
        $oTemperatura = new CampoConsulta('Temperatura','temperatura', CampoConsulta::TIPO_DECIMAL);
        
        $oGridItens->addCampos($oCod,$oSeq,$oTrat,$oTratDes,$oCamadaMin,$oCamadaMax,$oTemperatura);
        $oGridItens->setSController('STEEL_PCP_ReceitasItens');
        $oGridItens->addParam('cod','0');
        $oGridItens->getOGrid()->setIAltura(250);
        $oGridItens->getOGrid()->setBScrollInf(false);
        
        $oCodRec = new CampoConsulta('Código','cod');
        $oData = new CampoConsulta('Data','data', CampoConsulta::TIPO_DATA);
        $oPeca = new CampoConsulta('Peça','peca');
        $oTemp = new CampoConsulta('TempRev','temprev', CampoConsulta::TIPO_DECIMAL);
        $oMaterial = new CampoConsulta('Material','material');
        $oClasse = new CampoConsulta('Classe','classe');
        $oDureza = new CampoConsulta('Dureza','dureza');
        
        $oFiltro1 = new Filtro($oPeca, Filtro::CAMPO_TEXTO,3);
        $oFiltro2 = new Filtro($oCodRec, Filtro::CAMPO_TEXTO,2);
        $this->addFiltro($oFiltro2, $oFiltro1);
        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);
        
         $this->getTela()->setSEventoClick('var chave=""; $("#'.$this->getTela()->getSId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
               . 'requestAjax("'.$this->getTela()->getSId().'-form","STEEL_PCP_ReceitasItens","getDadosGridDetalhe","'.$oGridItens->getId().'",chave);');
        
        $this->getTela()->setIAltura(250);
        
        $this->addCamposGrid($oGridItens); 
        $this->addCampos($oCodRec,$oData,$oPeca,$oTemp,$oMaterial,$oClasse,$oDureza);
        
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oCod = new Campo('Código','cod', Campo::TIPO_TEXTO,1);
        $oCod->setBCampoBloqueado(true);
       
        
        $oData = new Campo('Data','data', Campo::TIPO_TEXTO,2);
        $oData->setBCampoBloqueado(true);
        date_default_timezone_set('America/Sao_Paulo');
        $oData->setSValor(date('d/m/Y'));
        $oPeca = new Campo('Peça','peca', Campo::TIPO_TEXTO,4);
        $oPeca->addValidacao(false, Validacao::TIPO_STRING,'Campo é necessário!','2','500');
        $oPeca->setBFocus(true);
        
        
        $oMaterial = new Campo('Material','material', Campo::TIPO_TEXTO,4);
        $oMaterial->addValidacao(false, Validacao::TIPO_STRING,'Campo necessário!','1','100');
        
        $oClasse = new Campo('Classe','classe', Campo::TIPO_TEXTO,1);
        $oLabel1 = new Campo('','label1', Campo::TIPO_LINHA);
        $oLabel1->setApenasTela(true);
      //  $oDureza = new Campo('Dureza','dureza', Campo::TIPO_TEXTO,3);
        $oBitola = new Campo('Bitola','bitola', Campo::TIPO_TEXTO,2);
        $oTempRev = new campo('Temp.Rev','temprev', Campo::TIPO_TEXTO,1);
        
        $oLabel2 = new Campo('','label2', Campo::TIPO_LINHA);
        $oLabel2->setApenasTela(true);
        $oMetanol = new campo('Metanol','metanol', Campo::TIPO_TEXTO,1);
        $oMetanol->setSCorFundo(Campo::FUNDO_AMARELO);
        $oXigenio = new campo('Oxigênio','oxigenio', Campo::TIPO_TEXTO,1);
        $oXigenio->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oNitrogenio = new Campo('Nitrogênio','nitrogenio', Campo::TIPO_TEXTO,1);
        $oNitrogenio->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oAmonia = new Campo('Amônia','amonia', Campo::TIPO_TEXTO,1);
        $oAmonia->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oGpl = new Campo('Glp','glp', Campo::TIPO_TEXTO,1);
        $oGpl->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oCo = new Campo('Co','co', Campo::TIPO_TEXTO,1);
        $oCo->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oCarbono = new Campo('Carbono','carbono', Campo::TIPO_TEXTO,1);
        $oCarbono->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oLabel3 = new Campo('','Label3', Campo::TIPO_LINHA,1);
        $oLabel3->setApenasTela(true);
        
        $oImagem = new Campo('Imagem','imagem', Campo::TIPO_UPLOAD,3);
        
        $oInstTrab = new campo('Inst.Trab','instTrab', Campo::TIPO_TEXTO,1);
        
        $oProgForno = new Campo('Progr.Forno','progForno', Campo::TIPO_TEXTO,1);
        
        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cad. Receitas', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens da Receita', false, $this->addIcone(Base::ICON_CONFIRMAR));
        $this->addEtapa($oEtapas);
        
        //adiciona campo de controle
        //monta campo de controle para inserir ou alterar
        $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
        $oAcao->setApenasTela(true);
        if ($this->getSRotina() == View::ACAO_INCLUIR) {
            $oAcao->setSValor('incluir');
        } else {
            $oAcao->setSValor('alterar');
        }
        $this->setSIdControleUpAlt($oAcao->getId());
        
        /*********************************************************/
        $oCamp = new campo('SERVIÇOS E INSUMOS','', Campo::DIVISOR_SUCCESS,12);
        $oCamp->setApenasTela(true);
                
        $oCodServ = new Campo('Cod.Serviço','codServ', Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodServ->setClasseBusca('DELX_PRO_Produtos');
        $oCodServ->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        
        $oCodServMet = new campo('Cod.Serviço.Metalbo', 'codServMet', Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodServMet->setClasseBusca('DELX_PRO_Produtos');
        $oCodServMet->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
        
        $oCodInsumo = new campo('Cod.Insumo', 'codInsumo',  Campo::TIPO_BUSCADOBANCOPK,2);
        $oCodInsumo->setClasseBusca('DELX_PRO_Produtos');
        $oCodInsumo->setSCampoRetorno('pro_codigo',$this->getTela()->getId());
                
        $this->addCampos(array($oCod,$oData),array($oPeca,$oMaterial,$oClasse),
                $oLabel1,array($oBitola,$oTempRev),$oLabel2,$oCamp,array($oCodServ,$oCodServMet),
                $oCodInsumo,
                array($oMetanol,$oXigenio,$oNitrogenio,$oAmonia),
                array($oGpl,$oCo,$oCarbono),$oLabel3,array($oImagem,$oInstTrab,$oProgForno),$oAcao);
       
    }
    
    public function RelOpSteelReceitasItens(){        
        parent::criaTelaRelatorio(); 
        
       $this->setTituloTela('Relatório de Itens da Receita');        
       $this->setBTela(true);     
        
       //$oDataatual = new Campo('Data da Receita', 'dataatual', Campo::TIPO_DATA, 2, 2, 12, 12);
                           
       //codigo da receita
        $iCodigo = new Campo('Codigo','cod',Campo::TIPO_BUSCADOBANCOPK,2);
        
        //campo peÃ§a da receita
        $oPeca = new Campo('Peça','peca',Campo::TIPO_BUSCADOBANCO, 4);
        $oPeca->setSIdPk($iCodigo->getId());
        $oPeca->setClasseBusca('STEEL_PCP_receitas');
        $oPeca->addCampoBusca('cod', '','');
        $oPeca->addCampoBusca('peca', '','');
        $oPeca->setSIdTela($this->getTela()->getId());
        $oPeca->setSValor('');
        
        //declarar o campo peça
        $iCodigo->setClasseBusca('STEEL_PCP_receitas');
        $iCodigo->setSCampoRetorno('cod',$this->getTela()->getId());
        $iCodigo->addCampoBusca('peca',$oPeca->getId(),  $this->getTela()->getId());
        
       $this->addCampos(array($iCodigo,$oPeca));
    } 
    
}