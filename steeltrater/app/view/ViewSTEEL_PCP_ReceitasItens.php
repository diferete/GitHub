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
        $oTrat->setILargura(10);

        $oTratDes = new CampoConsulta('Desc', 'STEEL_PCP_Tratamentos.tratdes');
        $oTratDes->setILargura(300);

        $oTemperatura = new CampoConsulta('Temperatura', 'temperatura', CampoConsulta::TIPO_DECIMAL);
        $oTemperatura->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oTemperatura->setBComparacaoColuna(true);

        $oRecApont = new CampoConsulta('Apontamento Produção', 'recApont');

        $oCamadaEspessura = new CampoConsulta('Camada Espessura', 'CamadaEspessura', CampoConsulta::TIPO_DECIMAL);

        $oTempoZinc = new CampoConsulta('Tempo Zincagem', 'TempoZinc');
        $oTempoZinc->setILargura(10);

        $oPesoDoCesto = new CampoConsulta('Peso do Cesto', 'PesoDoCesto', CampoConsulta::TIPO_DECIMAL);
        $oPesoDoCesto->setILargura(10);

        $this->addCampos($oCod, $oSeq, $oTrat, $oTratDes, $oTemperatura, $oRecApont, $oCamadaEspessura, $oTempoZinc, $oPesoDoCesto);
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
        $oTrat->setILargura(10);

        $oTratDes = new CampoConsulta('Desc', 'STEEL_PCP_Tratamentos.tratdes');
        $oTratDes->setILargura(300);

        $oTemperatura = new CampoConsulta('Temperatura', 'temperatura', CampoConsulta::TIPO_DECIMAL);
        $oTemperatura->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, false, '');
        $oTemperatura->setBComparacaoColuna(true);

        $oRecApont = new CampoConsulta('Apontamento Produção', 'recApont');

        $oCamadaEspessura = new CampoConsulta('Camada Espessura', 'CamadaEspessura', CampoConsulta::TIPO_DECIMAL);

        $oTempoZinc = new CampoConsulta('Tempo Zincagem', 'TempoZinc');
        $oTempoZinc->setILargura(10);

        $oPesoDoCesto = new CampoConsulta('Peso do Cesto', 'PesoDoCesto', CampoConsulta::TIPO_DECIMAL);
        $oPesoDoCesto->setILargura(10);

        $this->addCamposDetalhe($oCod, $oSeq, $oTrat, $oTratDes, $oTemperatura, $oRecApont, $oCamadaEspessura, $oTempoZinc, $oPesoDoCesto);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();

        $this->criaGridDetalhe();
        $aValor = $this->getAParametrosExtras();

        $oCod = new Campo('Código', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCod->setSValor($aValor[0]);
        $oCod->setBCampoBloqueado(true);
        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oTrat = new Campo('Tratamento', 'STEEL_PCP_Tratamentos.tratcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oTrat->setSIdHideEtapa($this->getSIdHideEtapa());
        $oTrat->setBFocus(true);
        $oTrat->addValidacao(false, Validacao::TIPO_STRING, '', '1', '100');

        $oTratDes = new Campo('Desc', 'STEEL_PCP_Tratamentos.tratdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oTratDes->setSIdPk($oTrat->getId());
        $oTratDes->setClasseBusca('STEEL_PCP_Tratamentos');
        $oTratDes->addCampoBusca('tratcod', '', '');
        $oTratDes->addCampoBusca('tratdes', '', '');
        $oTratDes->setSIdTela($this->getTela()->getid());
        $oTratDes->addValidacao(false, Validacao::TIPO_STRING, '', '2', '100');

        $oTrat->setClasseBusca('STEEL_PCP_Tratamentos');
        $oTrat->setSCampoRetorno('tratcod', $this->getTela()->getId());
        $oTrat->addCampoBusca('tratdes', $oTratDes->getId(), $this->getTela()->getId());

        $oCamadaMin = new Campo('CamadaMín', 'camada_min', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oCamadaMax = new Campo('CamadaMáx', 'camada_max', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oTemperatura = new Campo('Temperatura', 'temperatura', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oTempo = new Campo('Tempo', 'tempo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oResf = new Campo('Resfriamento', 'resfriamento', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oRecApont = new Campo('Recebe Apontamento de Produção', 'recApont', Campo::CAMPO_SELECTSIMPLE, 3, 3, 12, 12);
        $oRecApont->addItemSelect('SIM', 'SIM');
        $oRecApont->addItemSelect('NÃO', 'NÃO');

        $oCamadaEspessura = new Campo('Camada Espessura', 'CamadaEspessura', Campo::TIPO_DECIMAL, 2, 2, 12, 12);

        $oTempoZinc = new Campo('Tempo Zincagem', 'TempoZinc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        //$oTempoZinc->setBTime(true);

        $oPesoDoCesto = new Campo('Peso do Cesto', 'PesoDoCesto', Campo::TIPO_DECIMAL_COMPOSTO, 1, 1, 12, 12);
        $oPesoDoCesto->setICasaDecimal(3);

        /* Botão para inserir no banco de dados */
        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten",'
                . '"' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oTrat->getId() . '","' . $oCod->getSValor() . ',");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oCod, $oSeq), array($oTrat, $oTratDes, $oCamadaEspessura, $oTempoZinc, $oPesoDoCesto), array($oTempo, $oResf, $oTemperatura, $oRecApont, $oBotConf));

        //adiciona objetos campos para servirem como filtros iniciais do grid
        $this->addCamposFiltroIni($oCod);
    }

}
