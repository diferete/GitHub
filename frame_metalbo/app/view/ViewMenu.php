<?php

/**
 * Classe que implementa as operações de tela referentes ao 
 * objeto Menu
 * 
 * @author Fernando Salla
 * @since 28/06/2012
 * 
 */
class ViewMenu extends View {

    function __construct() {
        parent::__construct();

        $this->setController('Menu');
        $this->setTitulo('Menu');
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);

        $oModulo = new CampoConsulta('Módulo', 'Modulo.modcod');

        $oModDes = new CampoConsulta('Módulo', 'Modulo.modescricao');
        $oFModDes = new Filtro($oModDes, Filtro::CAMPO_TEXTO);

        $oMenuCod = new CampoConsulta('Cód. Menu', 'mencodigo');

        $oMenDes = new CampoConsulta('Descrição', 'mendes');
        $oFMenDes = new Filtro($oMenDes, Filtro::CAMPO_TEXTO);

        $oMenOrdem = new CampoConsulta('Ordem', 'menordem');

        $this->addFiltro($oFMenDes, $oFModDes);


        $this->addCampos($oMenuCod, $oMenDes, $oModulo, $oModDes, $oMenOrdem);
    }

    /**
     * Método que realiza a criação dos campos da tela de manutenção (inclusão/alteração) 
     */
    function criaTela() {
        parent::criaTela();


        $sAcaoRotina = $this->getSRotina();

        $oModCodigo = new Campo('Cód Mod', 'Modulo.modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCodigo->setClasseBusca('Modulo');
        $oModCodigo->addCampoBusca('modescricao', null, $this->getTela()->getId(), Campo::TIPO_BUSCA, 4, 5, 12, 12);
        $oModCodigo->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco');

        $oMenCodigo = new Campo('Cód Menu', 'mencodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMenCodigo->setBCampoBloqueado(true);

        $oMenu = new Campo('Menu', 'mendes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oMenu->addValidacao(false, Validacao::TIPO_STRING, 'Conteúdo Inválido!');

        $oMenuOrdem = new Campo('Ordem', 'menordem', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cadastro Menu', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Cadastro Item Menu', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {
            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }
            $this->setSIdControleUpAlt($oAcao->getId());

            $this->addCampos($oModCodigo, array($oMenCodigo, $oMenu), $oMenuOrdem, $oAcao);
        } else {
            $this->addCampos($oModCodigo, array($oMenCodigo, $oMenu), $oMenuOrdem);
        }
    }

    /**
     * Método que realiza a criação dos campos da tela de consulta
     */
}

?>