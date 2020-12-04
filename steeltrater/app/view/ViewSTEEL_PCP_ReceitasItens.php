<?php

/*
 * @author Avanei Martendal
 * @since 15/06/2018
 */

class ViewSTEEL_PCP_ReceitasItens extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código', 'cod');

        $oSeq = new CampoConsulta('Seq.', 'seq');

        $oTrat = new CampoConsulta('Tratamento', 'STEEL_PCP_Tratamentos.tratcod');

        $oTratDes = new CampoConsulta('Desc', 'STEEL_PCP_Tratamentos.tratdes');

        $oCamadaMin = new CampoConsulta('CamadaMín', 'camada_min', CampoConsulta::TIPO_DECIMAL);

        $oCamadaMax = new CampoConsulta('CamadaMáx', 'camada_max', CampoConsulta::TIPO_DECIMAL);

        $oTemperatura = new CampoConsulta('Temperatura', 'temperatura', CampoConsulta::TIPO_DECIMAL);
        $oTemperatura->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oTemperatura->setBComparacaoColuna(true);
        
        $oRecApont = new CampoConsulta('Apontamento Produção', 'recApont');

        $this->addCampos($oCod, $oSeq, $oTrat, $oTratDes, $oTemperatura, $oRecApont);
    }

    public function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);

        $oCod = new CampoConsulta('Código', 'cod');

        $oSeq = new CampoConsulta('Seq.', 'seq');

        $oTrat = new CampoConsulta('Tratamento', 'STEEL_PCP_Tratamentos.tratcod');

        $oTratDes = new CampoConsulta('Desc', 'STEEL_PCP_Tratamentos.tratdes');

        $oCamadaMin = new CampoConsulta('CamadaMín', 'camada_min', CampoConsulta::TIPO_DECIMAL);

        $oCamadaMax = new CampoConsulta('CamadaMáx', 'camada_max', CampoConsulta::TIPO_DECIMAL);

        $oTemperatura = new CampoConsulta('Temperatura', 'temperatura', CampoConsulta::TIPO_DECIMAL);
        $oTemperatura->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oTemperatura->setBComparacaoColuna(true);
        $oRecApont = new CampoConsulta('Apontamento Produção', 'recApont');

        $this->addCamposDetalhe($oCod, $oSeq, $oTrat, $oTratDes, $oTemperatura, $oRecApont);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();

        $this->criaGridDetalhe();
        $aValor = $this->getAParametrosExtras();

        $oCod = new Campo('Código', 'cod', Campo::TIPO_TEXTO, 1);
        $oCod->setSValor($aValor[0]);
        $oCod->setBCampoBloqueado(true);
        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1);
        $oSeq->setBCampoBloqueado(true);

        $oTrat = new Campo('Tratamento', 'STEEL_PCP_Tratamentos.tratcod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oTrat->setSIdHideEtapa($this->getSIdHideEtapa());
        $oTrat->setBFocus(true);
        $oTrat->addValidacao(false, Validacao::TIPO_STRING, '', '1', '100');

        $oTratDes = new Campo('Desc', 'STEEL_PCP_Tratamentos.tratdes', Campo::TIPO_BUSCADOBANCO, 4);
        $oTratDes->setSIdPk($oTrat->getId());
        $oTratDes->setClasseBusca('STEEL_PCP_Tratamentos');
        $oTratDes->addCampoBusca('tratcod', '', '');
        $oTratDes->addCampoBusca('tratdes', '', '');
        $oTratDes->setSIdTela($this->getTela()->getid());
        $oTratDes->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');


        $oTrat->setClasseBusca('STEEL_PCP_Tratamentos');
        $oTrat->setSCampoRetorno('tratcod', $this->getTela()->getId());
        $oTrat->addCampoBusca('tratdes', $oTratDes->getId(), $this->getTela()->getId());

        $oCamadaMin = new Campo('CamadaMín', 'camada_min', Campo::TIPO_TEXTO, 1);
        $oCamadaMax = new Campo('CamadaMáx', 'camada_max', Campo::TIPO_TEXTO, 1);
        $oTemperatura = new Campo('Temperatura', 'temperatura', Campo::TIPO_TEXTO, 1);
        $oTempo = new Campo('Tempo', 'tempo', Campo::TIPO_TEXTO, 1);
        $oResf = new Campo('Resfriamento', 'resfriamento', Campo::TIPO_TEXTO, 4);

        $oRecApont = new Campo('Recebe Apontamento de Produção', 'recApont', Campo::CAMPO_SELECTSIMPLE, 3);
        $oRecApont->addItemSelect('SIM', 'SIM');
        $oRecApont->addItemSelect('NÃO', 'NÃO');

        /* Botão para inserir no banco de dados */
        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten",'
                . '"' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oTrat->getId() . '","' . $oCod->getSValor() . ',");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oCod, $oSeq), array($oTrat, $oTratDes), array($oTempo, $oResf, $oTemperatura, $oRecApont, $oBotConf));

        //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oCod);
    }

}
