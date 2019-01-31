<?php

/* 
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ViewMET_Setores extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod', 'codsetor');
        $oDes = new CampoConsulta('Setor', 'descsetor');
                
        $oSetorFiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO,3);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oSetorFiltro);
        
        $this->setBScrollInf(false);
        $this->addCampos($oCod,$oDes);
    }
/*
    public function criaTela() {
        parent::criaTela();
        
        $oFilcgc = new Campo('filcgc', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNr = new Campo('nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodmaq = new Campo('codmaq', 'codmaq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        /*
        $oTip = new Campo('TipCod','tipcod',Campo::TIPO_BUSCADOBANCOPK,2,2,12,12);
        $oTip->setSValor('1');
        $oTip->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do maquina o campo de busca
        $oMaq_des = new Campo('Tipo Maquina','tipdes',Campo::TIPO_BUSCADOBANCO, 4,4,12,12);
        $oMaq_des->setSIdPk($oTip->getId());
        $oMaq_des->setClasseBusca('MET_CadastroMaquinas');
        $oMaq_des->addCampoBusca('tipcod', '','');
        $oMaq_des->addCampoBusca('tipdes', '','');
        $oMaq_des->setSIdTela($this->getTela()->getId());
        $oMaq_des->setSValor('CONFORMACAO A FRIO PORCAS');
        $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
        $oMaq_des->setApenasTela(true);
        
        //declarar o campo descrição maquina
        $oTip->setClasseBusca('MET_CadastroMaquinas');
        $oTip->setSCampoRetorno('tipcod',$this->getTela()->getId());
        $oTip->addCampoBusca('tipdes',$oMaq_des->getId(),  $this->getTela()->getId());
        
        
        
        
        
        
        $oCodsetor = new Campo('codsetor', 'codsetor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSitmp = new Campo('sitmp', 'sitmp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDatabert = new Campo('databert', 'databert', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUserabert = new Campo('userabert', 'userabert', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserfecho = new Campo('userfecho', 'userfecho', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatafech = new Campo('datafech', 'datafech', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $this->addCampos(array($oFilcgc,$oNr,$oCodmaq,$oCodsetor,$oSitmp,$oDatabert,$oUserabert,$oUserfecho,$oDatafech));
    
    }*/
}
