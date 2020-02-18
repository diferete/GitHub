<?php

/**
 * Classe que implementa as operações de tela referentes ao 
 * objeto ItemMenu
 * 
 * @author Fernando Salla
 * @since 29/06/2012
 * 
 */
class ViewMET_TEC_ItemMenu extends View {

    function __construct() {
        parent::__construct();

        $this->setController('MET_TEC_ItemMenu');
        $this->setTitulo('Itens Menu');
    }

    function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);
        //  $oModCodG = new CampoConsulta('Módulo','Modulo.modcod');
        //  $oModDesG = new CampoConsulta('Módulo','Modulo.modescricao');
        $oMenuG = new CampoConsulta('Menu', 'MET_TEC_Menu.mencodigo');
        $oMenuDesG = new CampoConsulta('Menu Desc.', 'MET_TEC_Menu.mendes');
        $oIteCodigoG = new CampoConsulta('Sub.Menu', 'itecodigo');
        $oItenDes = new CampoConsulta('Sub.Menu Desc.', 'itedescricao');
        $oIteclasseG = new CampoConsulta('Classe', 'iteclasse');
        $oIteMetodoG = new CampoConsulta('Metodo', 'itemetodo');
        $oIteOrdemG = new CampoConsulta('Ordem', 'iteordem');
        $this->addCamposDetalhe(/* $oModCodG,$oModDesG, */$oMenuG, $oMenuDesG, $oIteCodigoG, $oItenDes, $oIteclasseG, $oIteMetodoG, $oIteOrdemG);
        $this->addGriTela($this->getOGridDetalhe());
    }

    /**
     * Método que realiza a criação dos campos da tela de manutenção (inclusão/alteração) 
     */
    function criaTela() {
        parent::criaTela();

        $this->criaGridDetalhe();
        /* Dados pk menu */
        $aValor = $this->getAParametrosExtras();
        $oModCod = new Campo('Módulo', 'MET_TEC_Modulo.modcod', Campo::TIPO_TEXTO, 1);
        $oModCod->setITamanho(Campo::TAMANHO_PEQUENO);
        $oModCod->setBCampoBloqueado(true);

        $oModCod->setSValor($aValor[0]);

        $oModdes = new Campo('Descrição', '', Campo::TIPO_TEXTO, 3);
        $oModdes->setApenasTela(true);
        $oModdes->setBCampoBloqueado(true);
        $oModdes->setITamanho(Campo::TAMANHO_PEQUENO);

        $oModdes->setSValor($aValor[1]);


        $oMenCodigo = new Campo('Menu', 'MET_TEC_Menu.mencodigo', Campo::TIPO_TEXTO, 1);
        $oMenCodigo->setBCampoBloqueado(true);
        $oMenCodigo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oMenCodigo->setSValor($aValor[2]);

        $oMenDes = new Campo('Descrição', 'MET_TEC_Menu.mendes', Campo::TIPO_TEXTO, 3);
        $oMenDes->setApenasTela(true);
        $oMenDes->setBCampoBloqueado(true);
        $oMenDes->setITamanho(Campo::TAMANHO_PEQUENO);
        //$oMenDes->setBOculto(true);
        $oMenDes->setSValor($aValor[3]);

        $oIteCodigo = new Campo('Codigo', 'itecodigo', Campo::TIPO_TEXTO, 1);
        $oIteCodigo->setITamanho(Campo::TAMANHO_PEQUENO);
        $oIteCodigo->setBFocus(true);
        $oIteCodigo->setBSeq(true);

        $oIteDesc = new Campo('Submenu', 'itedescricao', Campo::TIPO_TEXTO, 4);
        $oIteDesc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oIteDesc->setBFocus(true);
        //$oIteDesc->addValidacao(true, Validacao::TIPO_EMAIL, 'Valor inválido!');

        $oIteOrdem = new Campo('Ordem', 'iteordem', Campo::TIPO_TEXTO, 1);
        $oIteOrdem->setITamanho(Campo::TAMANHO_PEQUENO);
        $oIteclasse = new Campo('Classe', 'iteclasse', Campo::TIPO_TEXTO, 2);
        $oIteclasse->setITamanho(Campo::TAMANHO_PEQUENO);
        $oIteMetodo = new Campo('Método', 'itemetodo', Campo::TIPO_TEXTO, 2);
        $oIteMetodo->setITamanho(Campo::TAMANHO_PEQUENO);

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oIteCodigo->getId() . ',' . $sGrid . ',' . $oIteDesc->getId() . '","' . $oMenCodigo->getSValor() . ',' . $oModCod->getSValor() . '");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        $this->addCampos(array($oModCod, $oModdes, $oMenCodigo, $oMenDes), array($oIteCodigo, $oIteDesc, $oIteOrdem), array($oIteclasse, $oIteMetodo, $oBotConf));

        //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oModCod, $oMenCodigo);
    }

    /**
     * Método que realiza a criação dos campos da tela de consulta
     */
    function criaConsulta() {
        parent::criaConsulta();

        //   $oModCod = new CampoConsulta('Módulo','Modulo.modcod');
        //   $oModDes = new CampoConsulta('Módulo','Modulo.modescricao');
        $oMenu = new CampoConsulta('Menu', 'MET_TEC_Menu.mencodigo');
        $oMenuDes = new CampoConsulta('Menu Desc.', 'MET_TEC_Menu.mendes');
        $oIteCodigo = new CampoConsulta('Sub.Menu', 'itecodigo');
        $oItenDes = new CampoConsulta('Sub.Menu Desc.', 'itedescricao');
        $oIteclasse = new CampoConsulta('Classe', 'iteclasse');
        $oIteMetodo = new CampoConsulta('Metodo', 'itemetodo');
        $oIteOrdem = new CampoConsulta('Ordem', 'iteordem');


        $this->addCampos(/* $oModCod,$oModDes, */$oMenu, $oMenuDes, $oIteCodigo, $oItenDes, $oIteclasse, $oIteMetodo, $oIteOrdem);
    }

    /**
     * Método que realiza a montagem da estrutura dos itens de um menu do sistema 
     * a partir do array passado por parâmetro
     * 
     * @param array Array contendo as informações dos itens do menu
     * @return string String contendo as informações dos itens do menu que serão renderizadas
     */
    function getItensMenu($aItens) {
        //monta a string dos itens do menu
        $sItens = "";
        foreach ($aItens as $aAtual) {
            if ($sItens != "") {
                $sItens .= ",";
            }
            $sItens .= "{ text: '" . $aAtual['descricao'] . "',"
                    . "leaf: true,"
                    . "iconCls: '" . Config::ARQ_FOLDER . Config::ARQ_FOLDER_IMG . "/" . $aAtual['icone'] . "',"
                    . "classe: '" . $aAtual['classe'] . "',"
                    . "metodo: '" . $aAtual['metodo'] . "',"
                    . "parametros: '" . $aAtual['parametros'] . "'"
                    . "}";
        }
        return $sItens;
    }

}

?>