<?php

/* 
 * Implementa a classe view para importar xmls 
 * @author Avanei Martendal
 * @since 13/02/2019
 */

class viewSTEEL_PCP_ImportaXml extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oBotaoEmitOf = new CampoConsulta('Emite','emitOf', CampoConsulta::TIPO_ACAO);
        $oBotaoEmitOf->setSTitleAcao('Emitir Ordem Fabricação!');
        $oBotaoEmitOf->addAcao('STEEL_PCP_OrdensFab','acaoMostraTelaIncluir','xml');
        $oBotaoEmitOf->setBHideTelaAcao(true);
        $oBotaoEmitOf->setILargura(30);
        
        $oOpCliente = new CampoConsulta('OpCliente','opCliente');
        
        
        
        $oSeq = new CampoConsulta('seq', 'seq');
        $oSeq->setILargura(30);
        
        $oEmpcod = new CampoConsulta('Cnpj','empcod');
        $oEmpcod->setILargura(100);
        
        $oEmpdes = new CampoConsulta('Empresa','empdes');
        $oEmpdes->setILargura(80);
        
        $oNfnro = new CampoConsulta('Nr.Nota','nfnro');
        $oNfnro->setILargura(30);
        
        $oSerie = new CampoConsulta('Série','nfser');
        $oSerie->setILargura(20);
        
        $oNfeSeq = new CampoConsulta('SeqItem','nfseq');
        $oNfeSeq->setILargura(20);
        
        $oProcod = new CampoConsulta('Cód/Referência','procod');
        $oProcod->setILargura(50);
        
        $oProdes = new CampoConsulta('Descrição','prodes');
        $oProdes->setILargura(300);
        
        $oUn = new CampoConsulta('Un','un');
        $oUn->setILargura(20);
        
        $oQt = new CampoConsulta('Qt','qtd', CampoConsulta::TIPO_DECIMAL);
        $oQt->setILargura(30);
        
        $oVlrUnit = new CampoConsulta('Vlr.Unit','vlrUnit', CampoConsulta::TIPO_DECIMAL);
        $oVlrUnit->setILargura(50);
        
        $oVlrTotal = new CampoConsulta('Vlr.Total','vlrTotal',CampoConsulta::TIPO_DECIMAL);
        $oVlrTotal->setILargura(100);
        
        $oOpSteel = new CampoConsulta('OpSteel','opSteel');
        $oOpSteel->setILargura(30);
       // $oOpSteel->addComparacao('0', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
       // $oOpSteel->addComparacao('0', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        
        
        $oOpSteel->addComparacao('0', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oOpSteel->setBComparacaoColuna(true);
         
        
        
        $oNcm = new campoconsulta('Ncm','ncm');
        $oNcm->setILargura(100);
        
        $oXped = new CampoConsulta('xPed','xPed');
        $oXped->setILargura(100);
        
        $oNitemPed = new CampoConsulta('nItemPed','nItemPed');
      
        $oFilEmpresa = new Filtro($oEmpcod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilEmpresa->setSClasseBusca('DELX_CAD_Pessoa');
        $oFilEmpresa->setSCampoRetorno('emp_codigo', $this->getTela()->getSId());
        $oFilEmpresa->setSIdTela($this->getTela()->getSId());
        
        $oFiltro1 = new Filtro($oNfnro, Filtro::CAMPO_TEXTO_IGUAL,1,1,1,1);
        $oFiltroReferencia = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL,2);
        $this->addFiltro($oFiltro1,$oFilEmpresa,$oFiltroReferencia);
        
        
        $this->addCampos($oBotaoEmitOf,$oSeq,$oOpSteel,$oEmpcod,$oNfnro,
                $oSerie,$oNfeSeq,$oProcod,$oProdes,$oUn,$oQt,$oVlrUnit,
                $oVlrTotal,$oNcm,$oOpCliente,$oXped,$oNitemPed);
        $this->setUsaAcaoAlterar(false);
        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setBMostraFiltro(true);
        $this->getTela()->setiAltura(750);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oXml = new Campo('Importa XML', 'impXml', Campo::TIPO_UPLOAD, 3, 3, 3, 3);
        $oXml->setSClasseUp('STEEL_PCP_ImportaXml');
        $oXml->setSMetodoUp('Upload');
        
        $this->setBOcultaBotTela(true);
        
        $this->addCampos($oXml);
    }
}