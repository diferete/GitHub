<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ViewMET_Maquinas extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0];
        $aDado2 = $aDados[1];
        $aCodSetor = $aDado2[0];
        $aDesSetor = $aDado2[1];
        // $aDado3 = $aDados[2];
        $aDado4 = $aDados[3];

        $oCodmaq = new CampoConsulta('Cod', 'cod');
        $oNr = new CampoConsulta('Maquina', 'maquina');
        $oMaqtip = new CampoConsulta('Tip.', 'maqtip');
        $oNomeclatura = new CampoConsulta('Nomeclatura', 'nomeclatura');
        $oSeq = new CampoConsulta('Célula', 'seq');
        //   $oTipManut = new CampoConsulta ('Tipo Manutenção','tipmanut');
        $oSetor = new CampoConsulta('Setor', 'codsetor');

        $oMaquinaFiltro = new Filtro($oNr, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        //Filtro de células
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFiltroSeq->addItemSelect('', 'Todas Células');
        foreach ($aDado1 as $key) {
            $val = (int) $key['seq'];
            $oFiltroSeq->addItemSelect($val, $key['seq'] . ' - Célula');
        }
        $oFiltroSeq->setSLabel('');

        //Filtro de Setor
        $oFiltroSetor = new Filtro($oSetor, Filtro::CAMPO_SELECT, 3, 3, 12, 12, false);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1) {
            $oFiltroSetor->addItemSelect($key1, $key1 . ' - ' . $aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');
        /*
          //Filtro tipo Manutenção
          $oTipManutFiltro= new Filtro($oTipManut, Filtro::CAMPO_SELECT, 2,2,12,12, false);
          $oTipManutFiltro->addItemSelect('', 'Todos Tipos de Manutenção');
          foreach ($aDado3 as $key2){
          $oTipManutFiltro->addItemSelect($key2['tipmanut'], $key2['tipmanut']);
          }
          $oTipManutFiltro->setSLabel('');
         */
        //Filtro tipo Categoria
        $oCategoriaFiltro = new Filtro($oMaqtip, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oCategoriaFiltro->addItemSelect('', 'Todas Categorias');
        foreach ($aDado4 as $key3) {
            $oCategoriaFiltro->addItemSelect($key3['maqtip'], $key3['maqtip']);
        }
        $oCategoriaFiltro->setSLabel('');

        $oFiltroCodMaq = new Filtro($oCodmaq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oFiltroCodMaq, $oMaquinaFiltro, $oFiltroSeq/* ,$oTipManutFiltro */, $oCategoriaFiltro, $oFiltroSetor);

        $this->getTela()->setBMostraFiltro(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oCodmaq, $oNr, $oMaqtip, $oNomeclatura, $oSeq, /* $oTipManut, */ $oSetor);
    }

    public function criaTela() {
        parent::criaTela();
        /*
          $oFilcgc = new Campo('filcgc', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
          $oNr = new Campo('nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
          $oCodmaq = new Campo('codmaq', 'codmaq', Campo::TIPO_TEXTO, 1, 1, 12, 12);

          /*
          $oTip = new Campo('TipCod','tipcod',Campo::TIPO_BUSCADOBANCOPK,2,2,12,12);
          $oTip->setSValor('1');
          $oTip->addValidacao(false, Validacao::TIPO_STRING);

          //campo descrição do maquina o campo de busca
          $oMaq_des = new Campo('Tipo Maquina','tipdes',Campo::TIPO_BUSCADOBANCO, 4,4,12,12);
          $oMaq_des->setSIdPk($oTip->getId());
          $oMaq_des->setClasseBusca('MET_CadastroMaquinas');
          $oMaq_des->addCampoBusca('tipcod', '','');
          $oMaq_des->addCampoBusca('tipdes', '','');
          $oMaq_des->setSIdTela($this->getTela()->getId());
          $oMaq_des->setSValor('CONFORMACAO A FRIO PORCAS');
          $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
          $oMaq_des->setApenasTela(true);

          //declarar o campo descrição maquina
          $oTip->setClasseBusca('MET_CadastroMaquinas');
          $oTip->setSCampoRetorno('tipcod',$this->getTela()->getId());
          $oTip->addCampoBusca('tipdes',$oMaq_des->getId(),  $this->getTela()->getId());






          $oCodsetor = new Campo('codsetor', 'codsetor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
          $oSitmp = new Campo('sitmp', 'sitmp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
          $oDatabert = new Campo('databert', 'databert', Campo::TIPO_TEXTO, 1, 1, 12, 12);
          $oUserabert = new Campo('userabert', 'userabert', Campo::TIPO_TEXTO, 2, 2, 12, 12);
          $oUserfecho = new Campo('userfecho', 'userfecho', Campo::TIPO_TEXTO, 2, 2, 12, 12);
          $oDatafech = new Campo('datafech', 'datafech', Campo::TIPO_TEXTO, 1, 1, 12, 12);

          $this->addCampos(array($oFilcgc,$oNr,$oCodmaq,$oCodsetor,$oSitmp,$oDatabert,$oUserabert,$oUserfecho,$oDatafech));
         */
    }

}
