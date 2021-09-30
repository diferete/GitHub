<?php

/*
 * Implementa a classe view MET_MANUT_OSGeraSolCom
 * @author Cleverton Hoffmann
 * @since 20/09/2021
 */

class ViewMET_MANUT_OSGeraSolCom extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setBGridResponsivo(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setITipoGrid(2);

        $ofil_codigo = new CampoConsulta('Empresa', 'fil_codigo', CampoConsulta::TIPO_TEXTO);
        $ofil_codigo->setBColOculta(true);
        
        $onr = new CampoConsulta('OS', 'nr', CampoConsulta::TIPO_TEXTO);
        
        $oInc = new CampoConsulta('Nr', 'numero', CampoConsulta::TIPO_TEXTO);
        $oInc->setBColOculta(true);

        $ocod = new CampoConsulta('Cod Maquina', 'cod', CampoConsulta::TIPO_TEXTO);
        $oseq = new CampoConsulta('Sequência', 'seq', CampoConsulta::TIPO_TEXTO);
        $ocodmat = new CampoConsulta('Cod Material', 'codmat', CampoConsulta::TIPO_TEXTO);
        $odescricaomat = new CampoConsulta('Descrição Material', 'descricaomat', CampoConsulta::TIPO_TEXTO);
        $ousermatdes = new CampoConsulta('Des. Usuário', 'usermatdes', CampoConsulta::TIPO_TEXTO);
        $oquantidade = new CampoConsulta('Quantidade Solicitação', 'quantMatSol', CampoConsulta::TIPO_TEXTO);
        $oobsmat = new CampoConsulta('Obs. Material', 'obsmat', CampoConsulta::TIPO_TEXTO);
        $odatamat = new CampoConsulta('Data', 'datamat', CampoConsulta::TIPO_DATA);
        $osituacaoCompra = new CampoConsulta('Sit. Compra', 'processoCompra', CampoConsulta::TIPO_TEXTO);
        $osituacaoCompra->addComparacao("NÃO SOLICITADO", CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, '');
        $osituacaoCompra->addComparacao("SOLICITADO", CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, '');

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Apontamento', Dropdown::TIPO_INFO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_COPIAR) . 'Gerar solicitação compra', 'MET_MANUT_OSGeraSolCom', 'msgGeraSolOS', '', false, '', false, '', false, '', true, false);

        $oDrop2 = new Dropdown('Imprimir', Dropdown::TIPO_PRIMARY);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Ordem completa', 'MET_MANUT_OS', 'acaoMostraRelConsulta', '', false, 'OrdemManut', false, '', false, '', false, false);

        $this->addDropdown($oDrop1, $oDrop2);

        $oNrfiltro = new Filtro($onr, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);
        $oMaqCodfiltro = new Filtro($ocod, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12);
        $oCodMatfiltro = new Filtro($ocodmat, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12);
        $oFilData = new Filtro($odatamat, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12);
        $oDesSitfiltro = new Filtro($osituacaoCompra, Filtro::CAMPO_SELECT, 2, 2, 12, 12);
        $oDesSitfiltro->setSLabel('');
        $oDesSitfiltro->addItemSelect('NÃO SOLICITADO', 'NÃO SOLICITADO');
        $oDesSitfiltro->addItemSelect('SOLICITADO', 'SOLICITADO');

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        //$this->setUsaAcaoAlterar(false);
        $this->getTela()->setBMostraFiltro(true);

        $this->addFiltro($oNrfiltro, $oMaqCodfiltro, $oCodMatfiltro, $oFilData, $oDesSitfiltro);

        $this->addCampos($onr, $ocod, $oseq, $ocodmat, $odescricaomat, $oquantidade, $oobsmat, $ousermatdes, $odatamat, $osituacaoCompra, $ofil_codigo, $oInc);
    }

    public function criaTela() {
        parent::criaTela();

        $onumero = new Campo('Seq.', 'numero', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $onumero->setBCampoBloqueado(true);
        $ofil_codigo = new Campo('Cod.Empresa', 'fil_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ofil_codigo->setBCampoBloqueado(true);
        $onr = new Campo('OS', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $onr->setBCampoBloqueado(true);
        $ocod = new Campo('Cod.Maquina', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ocod->setBCampoBloqueado(true);
        $oseq = new Campo('Seq.Item OS', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oseq->setBCampoBloqueado(true);

        $oProCod = new Campo('Código', 'codmat', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oProCod->setId('CodmaterialManOsSol');

        $omatnecessario = new Campo('Material Necessário', 'descricaomat', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $omatnecessario->setId('materialManOsSol');
        $omatnecessario->setSCorFundo(Campo::FUNDO_AZUL);
        $omatnecessario->setSIdPk($oProCod->getId());
        $omatnecessario->setClasseBusca('MET_MANUT_OSPesqProd');
        $omatnecessario->addCampoBusca('pro_codigo', '', '');
        $omatnecessario->addCampoBusca('pro_descricao', '', '');
        $omatnecessario->setSIdTela($this->getTela()->getId());

        $oProCod->setClasseBusca('MET_MANUT_OSPesqProd');
        $oProCod->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oProCod->addCampoBusca('pro_descricao', $omatnecessario->getId(), $this->getTela()->getId());

        $sConsMaterial = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_MANUT_OSGeraSolCom","consultaMaterialSol");';
        $oProCod->addEvento(Campo::EVENTO_CHANGE, $sConsMaterial);

        $oQuant = new Campo('Quantidade Solicitação', 'quantMatSol', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oField1 = new FieldSet('Detalhes');

        $ousermatcod = new Campo('Cod. Usuário', 'usermatcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ousermatcod->setBCampoBloqueado(true);
        $ousermatdes = new Campo('Usuário', 'usermatdes', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $ousermatdes->setBCampoBloqueado(true);
        $oquantidade = new Campo('Quantidade', 'quantidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oquantidade->setBCampoBloqueado(true);
        $oobsmat = new Campo('Observação', 'obsmat', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oobsmat->setBCampoBloqueado(true);
        $odatamat = new Campo('Data', 'datamat', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $odatamat->setBCampoBloqueado(true);
        $oprocessoComp = new Campo('Processo Compra', 'processoCompra', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oprocessoComp->setBCampoBloqueado(true);

        $oField1->addCampos(array($ousermatcod, $ousermatdes, $oquantidade, $odatamat, $oprocessoComp), $oobsmat);
        $oField1->setOculto(true);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $this->addCampos(array($onumero, $ofil_codigo, $onr, $ocod, $oseq), $oLinha1, array($oProCod, $omatnecessario, $oQuant), $oLinha1, $oField1);
    }

}
