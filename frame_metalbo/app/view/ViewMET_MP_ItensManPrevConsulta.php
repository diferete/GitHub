<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 18/02/2019
 */

class ViewMET_MP_ItensManPrevConsulta extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setBGridResponsivo(false);

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0];
        $aDado2 = $aDados[1];
        $aCodSetor = $aDado2[0];
        $aDesSetor = $aDado2[1];
        //$aDado3 = $aDados[2];
        $aDado4 = $aDados[3];

        $oSeq = new CampoConsulta('Seq.', 'seq');

        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');

        $oCodSit = new CampoConsulta('Cod.Sit.', 'MET_MP_ServicoMaquina.codsit');

        $oServ = new CampoConsulta('Serviço.', 'MET_MP_ServicoMaquina.servico');

        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA, false, null);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA, false, null);

        $oDias = new CampoConsulta('Dias Restantes', 'dias');

        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);

        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');

        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);

        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');

        $oSeq1 = new CampoConsulta('Célula', 'MET_MP_Maquinas.seq');

        $oTipManut = new CampoConsulta('Tipo Manutenção', 'MET_MP_Maquinas.tipmanut');

        $oSetor = new CampoConsulta('Setor', 'MET_MP_Maquinas.codsetor');

        $oCategoria = new CampoConsulta('Categoria', 'MET_MP_Maquinas.maqtip');

        //Filtro de células
        $oFiltroSeq1 = new Filtro($oSeq1, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroSeq1->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key) {
            $val = (int) $key['seq'];
            $oFiltroSeq1->addItemSelect($val, $key['seq'] . ' - Célula');
        }
        $oFiltroSeq1->setSLabel('');

        //Filtro tipo Categoria
        $oCategoriaFiltro = new Filtro($oCategoria, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oCategoriaFiltro->addItemSelect('', 'Todas Categorias');
        foreach ($aDado4 as $key3) {
            $oCategoriaFiltro->addItemSelect($key3['maqtip'], $key3['maqtip']);
        }
        $oCategoriaFiltro->setSLabel('');

        //Filtro de Setor
        $oFiltroSetor = new Filtro($oSetor, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1) {
            $oFiltroSetor->addItemSelect($key1, $key1 . ' - ' . $aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFiltroCodMaq = new Filtro($oCodmaq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFiltroServico = new Filtro($oServ, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFiltroSituacao = new Filtro($oSitmp, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFiltroSituacao->addItemSelect('', 'TODAS SITUAÇÕES');
        $oFiltroSituacao->addItemSelect('ABERTO', 'ABERTO');
        $oFiltroSituacao->addItemSelect('FINALIZADO', 'FINALIZADO');
        $oFiltroSituacao->setSLabel('');

        $oResp = new CampoConsulta('Resp', 'MET_MP_ServicoMaquina.resp');
        $oResp->setBColOculta(true);

        $oFiltroResp = new Filtro($oResp, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroResp->addItemSelect('', 'TODOS RESPONSÁVEIS');
        $oFiltroResp->addItemSelect('MECANICA', 'MECÂNICA');
        $oFiltroResp->addItemSelect('ELETRICA', 'ELÉTRICA');
        $oFiltroResp->addItemSelect('OPERADOR', 'OPERADOR');
        $oFiltroResp->setSLabel('');

        $this->addFiltro($oFiltroSeq, $oFiltroCodMaq, $oFiltroServico, $oFiltroResp, $oFiltroSituacao, $oFiltroSeq1/* , $oTipManutFiltro */, $oCategoriaFiltro, $oFiltroSetor);

        $this->getTela()->setBMostraFiltro(true);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addCampos($oSeq, $oCodmaq, $oCodSit, $oServ, $oSitmp, $oDias, $oDatabert, $oUserinic, $oDatafech, $oUserfinal);
    }

}
