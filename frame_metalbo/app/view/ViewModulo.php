<?php

class ViewModulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(true);

        $oDrop2 = new Dropdown('Verifica movimentação', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Verifica movimentação', $this->getController(), 'verificaMovProduto', '', false, '', false, '', false, '', false, true);

        $oDrop3 = new Dropdown('Popula tabela', Dropdown::TIPO_AVISO, Dropdown::ICON_EMAIL);
        $oDrop3->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Popula tabela', $this->getController(), 'testePrecoProd', '', false, '', false, '', false, '', false, true);


        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oCodigo->setILargura(500);

        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModulo->setILargura(500);



        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $this->addFiltro($oModuloF);
        $this->addDropdown($oDrop2, $oDrop3);
        $this->addCampos($oCodigo, $oModulo);
    }

    function criaTela() {
        parent::criaTela();

        $oTeste = new Campo('Cad. User', 'teste', Campo::TIPO_BOTAO_MOSTRACONSULTA, 1, 1, 12, 12);
        $oTeste->setApenasTela(true);
        $oTeste->setClasseBusca('User');
        $oTeste->setSCampoRetorno('usucodigo', $this->getTela()->getId());

        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModDescricao->addValidacao(false, Validacao::TIPO_STRING, '', '2', '15');
        $oModDescricao->setBUpperCase(true);

        $this->addCampos(array($oModCod, $oModDescricao), $oTeste);
    }

}
