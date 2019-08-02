<?php

/* 
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 18/02/2019
 */

class ViewMET_ItensManPrevConsulta extends View {
    
    public function criaConsulta() {
        parent::criaConsulta();
                        
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodSit = new CampoConsulta('Cod.Sit.','MET_ServicoMaquina.codsit');
        $oServ = new CampoConsulta('Serviço.','MET_ServicoMaquina.servico');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO,CampoConsulta::MODO_COLUNA);
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');

        
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);
        $oFiltroCodMaq = new Filtro($oCodmaq, Filtro::CAMPO_TEXTO, 2);
        $oFiltroServico = new Filtro($oServ, Filtro::CAMPO_TEXTO, 2);
        $oFiltroSituacao = new Filtro($oSitmp, Filtro::CAMPO_TEXTO, 2);

        $this->addFiltro($oFiltroSeq, $oFiltroCodMaq, $oFiltroServico, $oFiltroSituacao);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addCampos($oSeq, $oCodmaq, $oCodSit,$oServ, $oSitmp, $oDias, $oDatabert, $oUserinic,$oDatafech,$oUserfinal);
    }
    
}
