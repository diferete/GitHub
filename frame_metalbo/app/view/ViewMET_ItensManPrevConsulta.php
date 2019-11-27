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
        $oCodSit = new CampoConsulta('Cod.Sit.', 'MET_ServicoMaquina.codsit');
        $oServ = new CampoConsulta('Serviço.', 'MET_ServicoMaquina.servico');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');

        $oSeq1 = new CampoConsulta('Célula', 'MET_Maquinas.seq');
        $oTipManut = new CampoConsulta('Tipo Manutenção', 'MET_Maquinas.tipmanut');
        $oSetor = new CampoConsulta('Setor', 'MET_Maquinas.codsetor');
        $oCategoria = new CampoConsulta('Categoria', 'MET_Maquinas.maqtip');

        //Filtro de células
        $oFiltroSeq1 = new Filtro($oSeq1, Filtro::CAMPO_SELECT, 2, 2, 2, 2);
        $oFiltroSeq1->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key) {
            $val = (int) $key['seq'];
            $oFiltroSeq1->addItemSelect($val, $key['seq'] . ' - Célula');
        }
        $oFiltroSeq1->setSLabel('');

        /*
          //Filtro tipo Manutenção
          $oTipManutFiltro= new Filtro($oTipManut, Filtro::CAMPO_SELECT, 3,3,3,3,true);
          $oTipManutFiltro->addItemSelect('', 'Todos Tipos de Manutenção');
          foreach ($aDado3 as $key2){
          $oTipManutFiltro->addItemSelect($key2['tipmanut'], $key2['tipmanut']);
          }
          $oTipManutFiltro->setSLabel('');
         */

        //Filtro tipo Categoria
        $oCategoriaFiltro = new Filtro($oCategoria, Filtro::CAMPO_SELECT, 2, 2, 2, 2);
        $oCategoriaFiltro->addItemSelect('', 'Todas Categorias');
        foreach ($aDado4 as $key3) {
            $oCategoriaFiltro->addItemSelect($key3['maqtip'], $key3['maqtip']);
        }
        $oCategoriaFiltro->setSLabel('');

        //Filtro de Setor
        $oFiltroSetor = new Filtro($oSetor, Filtro::CAMPO_SELECT, 3, 3, 3, 3);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1) {
            $oFiltroSetor->addItemSelect($key1, $key1 . ' - ' . $aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 1);
        $oFiltroCodMaq = new Filtro($oCodmaq, Filtro::CAMPO_TEXTO, 1);
        $oFiltroServico = new Filtro($oServ, Filtro::CAMPO_TEXTO, 1);
        $oFiltroSituacao = new Filtro($oSitmp, Filtro::CAMPO_SELECT, 1);
        $oFiltroSituacao->addItemSelect('', 'TODAS SITUAÇÕES');
        $oFiltroSituacao->addItemSelect('ABERTO', 'ABERTO');
        $oFiltroSituacao->addItemSelect('FINALIZADO', 'FINALIZADO');
        $oFiltroSituacao->setSLabel('');

        $this->addFiltro($oFiltroSeq, $oFiltroCodMaq, $oFiltroServico, $oFiltroSituacao, $oFiltroSeq1/* , $oTipManutFiltro */, $oCategoriaFiltro, $oFiltroSetor);

        $this->getTela()->setBMostraFiltro(true);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addCampos($oSeq, $oCodmaq, $oCodSit, $oServ, $oSitmp, $oDias, $oDatabert, $oUserinic, $oDatafech, $oUserfinal);
    }

}
