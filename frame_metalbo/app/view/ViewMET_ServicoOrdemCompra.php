<?php 
 /*
 * Implementa a classe view MET_ServicoOrdemCompra
 * @author Cleverton Hoffmann
 * @since 22/07/2020
 */
 
class ViewMET_ServicoOrdemCompra extends View {
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setILarguraGrid(2300);
        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setIAltura(750);
 
        $oseq = new CampoConsulta('Seq.', 'seq', CampoConsulta::TIPO_TEXTO);
        $oEmpcod = new CampoConsulta('Cod.Empresa', 'empcod', CampoConsulta::TIPO_TEXTO);
        $oEmpdes = new CampoConsulta('Empresa', 'Pessoa.empdes', CampoConsulta::TIPO_TEXTO);
        $ogrupo = new CampoConsulta('Grupo', 'grupo', CampoConsulta::TIPO_TEXTO);
        $oCodprod = new CampoConsulta('Cod.Produto', 'codserv', CampoConsulta::TIPO_TEXTO);
        $oDesprod = new CampoConsulta('Produto', 'Produto.prodes', CampoConsulta::TIPO_TEXTO);
        $otips = new CampoConsulta('Tipo', 'tips', CampoConsulta::TIPO_TEXTO);
        $odescserv = new CampoConsulta('Desc.Tipo', 'descserv', CampoConsulta::TIPO_TEXTO);
        $ovaloruni = new CampoConsulta('Valor unidade', 'valoruni', CampoConsulta::TIPO_DECIMAL);
        
        $oFilSeq = new Filtro($oseq, Filtro::CAMPO_TEXTO_IGUAL, 1);
        $oFilEmpdes = new Filtro($oEmpdes, Filtro::CAMPO_TEXTO, 2);
        $oFilCnpj = new Filtro($oEmpcod, Filtro::CAMPO_BUSCADOBANCOPK, 2);
        $oFilCnpj->setSClasseBusca('Pessoa');
        $oFilCnpj->setSCampoRetorno('empcod', $this->getTela()->getSId());
        $oFilCnpj->setSIdTela($this->getTela()->getSId());
        
        $oFilProddes = new Filtro($oDesprod, Filtro::CAMPO_TEXTO, 2);
        $oFilProd = new Filtro($oCodprod, Filtro::CAMPO_BUSCADOBANCOPK, 2);
        $oFilProd->setSClasseBusca('Produto');
        $oFilProd->setSCampoRetorno('procod', $this->getTela()->getSId());
        $oFilProd->setSIdTela($this->getTela()->getSId());
                
        $oFilTipodes = new Filtro($odescserv, Filtro::CAMPO_TEXTO, 2);
        
        $this->addFiltro($oFilSeq, $oFilCnpj, $oFilEmpdes, $oFilTipodes, $oFilProd, $oFilProddes);
 
        $this->addCampos($oseq, $oEmpcod, $oEmpdes, $ogrupo, $otips, $odescserv, $oCodprod, $oDesprod, $ovaloruni);
    }
 
    public function criaTela() { 
        parent::criaTela();
         
        $sAcaoRotina = $this->getSRotina();
        
        $oseq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oseq->setBCampoBloqueado(true);

        $oEmpcod = new Campo('Cod.Empresa', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oEmpcod->setBCampoBloqueado(true);
        }
        
        $oEmpdes = new Campo('Empresa', 'Pessoa.empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getId());
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oEmpdes->setBCampoBloqueado(true);
        }
        
        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());
                
        $ogrupo = new Campo('Grupo', 'grupo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $ogrupo->setBCampoBloqueado(true);
        }
        
        $oCodprod = new Campo('Cod.Produto', 'codserv', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oCodprod->setBCampoBloqueado(true);
        }
        
        $oDesprod = new Campo('Produto', 'Produto.prodes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oDesprod->setSIdPk($oCodprod->getId());
        $oDesprod->setClasseBusca('Produto');
        $oDesprod->addCampoBusca('procod', '', '');
        $oDesprod->addCampoBusca('prodes', '', '');
        $oDesprod->setSIdTela($this->getTela()->getId());
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oDesprod->setBCampoBloqueado(true);
        }

        $oCodprod->setClasseBusca('Produto');
        $oCodprod->setSCampoRetorno('procod', $this->getTela()->getId());
        $oCodprod->addCampoBusca('prodes', $oDesprod->getId(), $this->getTela()->getId());      
        ////////////////////////////////////////
        $otips = new Campo('Tipos', 'tips', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $otips->setBCampoBloqueado(true);
        }
        
        $odescserv = new Campo('Desc.Tipo', 'descserv', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $odescserv->setSIdPk($otips->getId());
        $odescserv->setClasseBusca('MET_ServicoOrdemCompra');
        $odescserv->addCampoBusca('tips', '', '');
        $odescserv->addCampoBusca('descserv', '', '');
        $odescserv->setSIdTela($this->getTela()->getId());
        if ($sAcaoRotina == 'acaoVisualizar') {
            $odescserv->setBCampoBloqueado(true);
        }
        
        $otips->setClasseBusca('MET_ServicoOrdemCompra');
        $otips->setSCampoRetorno('tips', $this->getTela()->getId());
        $otips->addCampoBusca('descserv', $odescserv->getId(), $this->getTela()->getId());
        
       ////////////////////////////////////////////
        $ovaloruni = new Campo('Valor (Kg)', 'valoruni', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $ovaloruni->setBCampoBloqueado(true);
        }
        
        //---Adiciona uma linha em branco---///
        $oLinha = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);
 
        $this->addCampos(array($oseq, $oEmpcod, $oEmpdes), $oLinha, array($ogrupo, $otips, $odescserv), $oLinha, array ($oCodprod, $oDesprod), $oLinha, $ovaloruni);
    } 
}