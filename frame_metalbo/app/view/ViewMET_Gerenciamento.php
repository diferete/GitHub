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

        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oNr = new CampoConsulta('Nr', 'nr');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oDesMaq = new CampoConsulta('Maquina','MET_Maquinas.maquina');
        $oCodsetor = new CampoConsulta('Cod.Setor', 'codsetor');
        $oSetDes = new CampoConsulta('Setor', 'MET_Setores.descsetor');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserabert = new CampoConsulta('UsuarioAbert.', 'userabert');
        $oUserfecho = new CampoConsulta('UsuarioFech', 'userfecho');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        
        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_TEXTO,2);
        $oFiltroMaquina = new Filtro ($oDesMaq, Filtro::CAMPO_TEXTO, 3);
        $oFiltroSetor = new Filtro ($oSetDes, Filtro::CAMPO_TEXTO, 3);
        
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroNr,$oFiltroMaquina,$oFiltroSetor);       
        
        
        $this->setBScrollInf(TRUE);
        $this->addCampos($oFilcgc,$oNr,$oCodmaq,$oDesMaq,$oCodsetor,$oSetDes,$oSitmp,$oDatabert,$oUserabert,$oUserfecho,$oDatafech);
    }

    public function criaTela() {
        parent::criaTela();
        
        $sAcao =  $this->getSRotina();
        
        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor('75483040000211');
        $oFilcgc->setBCampoBloqueado(true);
        
        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);
        
        $oCodmaq = new Campo('Codigo','codmaq',Campo::TIPO_BUSCADOBANCOPK,2, 2, 12, 12);
        $oCodmaq->addValidacao(false, Validacao::TIPO_INTEIRO);
        
        //campo descrição da maquina adicionando o campo de busca
        $oMaq_des = new Campo('Maquina','MET_Maquinas.maquina',Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_des->setSIdPk($oCodmaq->getId());
        $oMaq_des->setClasseBusca('MET_Maquinas');
        $oMaq_des->addCampoBusca('cod', '','');
        $oMaq_des->addCampoBusca('maquina', '','');
        $oMaq_des->setSIdTela($this->getTela()->getId());
        $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
                
        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodmaq->setClasseBusca('MET_Maquinas');
        $oCodmaq->setSCampoRetorno('cod',$this->getTela()->getId());
        $oCodmaq->addCampoBusca('maquina',$oMaq_des->getId(),$this->getTela()->getId());
               
        $oSitmp = new Campo('Situação', 'sitmp', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitmp->setSValor('ABERTO');
        $oSitmp->addValidacao(false, Validacao::TIPO_STRING);
        $oSitmp->setBCampoBloqueado(true);
        
        $oDatabert = new Campo('DataAbert', 'databert', Campo::TIPO_TEXTO,1);
        $oDatabert->setSValor(date('d/m/Y'));
        $oDatabert->setBCampoBloqueado(true);
        
        $oUserabert = new Campo('UsuarioAbert.', 'userabert', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserabert->setSValor($_SESSION['nome']);
        $oUserabert->setBCampoBloqueado(true);
        
        $oUserfecho = new Campo('UsuarioFech', 'userfecho', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserfecho->setBCampoBloqueado(true);
        
        $oDatafech = new Campo('DataFech', 'datafech', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDatafech->setBCampoBloqueado(true);
        
        //NOVO ------------------------------------------------------------------------------------------------
        $oEtapas = new FormEtapa(4, 4, 4, 4);
        $oEtapas->addItemEtapas('Manutenção Preventiva Máquina', true, $this->addIcone(Base::ICON_CONFIG));
        $oEtapas->addItemEtapas('Serviço Manutenção Preventiva', false, $this->addIcone(Base::ICON_CONFIRMAR));
           
        $this->addEtapa($oEtapas);
  
        //monta campo de controle para inserir ou alterar
        $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2);
        $oAcao->setApenasTela(true);
        if ($this->getSRotina() == View::ACAO_INCLUIR) {
            $oAcao->setSValor('incluir');
        } else {
            $oAcao->setSValor('alterar');
        }
        $this->setSIdControleUpAlt($oAcao->getId());  
        // ----------------------------------------------------------------------------------------------------
        
        $this->addCampos(array($oFilcgc,$oNr,
                               $oDatabert,$oUserabert,$oUserfecho,$oDatafech),$oSitmp, 
                array($oCodmaq, $oMaq_des),$oAcao);
    }

}
