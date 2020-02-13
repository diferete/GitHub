<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class ViewMET_ServicoMaquina extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $aDados = $this->getAParametrosExtras();
        $aDado1 = $aDados[0];
        $aDado2 = $aDados[1];
        $aCodSetor = $aDado2[0];
        $aDesSetor = $aDado2[1];

        $oSit = new CampoConsulta('CodSit', 'codsit');
        $oTip = new CampoConsulta('TipCod', 'tipcod');
        $oTipDes = new CampoConsulta('DesTip', 'MET_CadastroMaquinas.tipdes');
        $oCodSetor = new CampoConsulta('Cod.', 'Setor.codsetor');
        $oDSetor = new CampoConsulta('Setor', 'Setor.descsetor');
        $oServ = new CampoConsulta('Serviço', 'servico');
        $oCiclo = new CampoConsulta('Ciclo', 'ciclo');
        $oResp = new CampoConsulta('Responsável', 'resp');
        $oUser = new CampoConsulta('Usuario', 'usercad');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oHora = new CampoConsulta('Hora', 'hora');

        $oTipFiltro = new Filtro($oSit, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);
        $oDesTipFiltro = new Filtro($oTipDes, Filtro::CAMPO_SELECT, 4, 4, 12, 12, false);
        $oDesTipFiltro->addItemSelect('', 'TODAS CATEGORIAS');
        foreach ($aDado1 as $key) {
            $oDesTipFiltro->addItemSelect($key['tipdes'], $key['tipdes']);
        }
        $oDesTipFiltro->setSLabel('');

        $oDescricaoFiltro = new Filtro($oServ, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oResponsavelFiltro = new Filtro($oResp, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oResponsavelFiltro->addItemSelect('', 'TODOS OS RESPONSÁVEIS');
      //  $oResponsavelFiltro->addItemSelect('ENCARREGADO DA PRODUCAO', 'ENCARREGADO DA PRODUCAO');
        $oResponsavelFiltro->addItemSelect('ELETRICA', 'ELETRICA');
        $oResponsavelFiltro->addItemSelect('OPERADOR', 'OPERADOR');
      //  $oResponsavelFiltro->addItemSelect('MANUTENCAO - PARAFUSOS', 'MANUTENCAO - PARAFUSOS');
     //   $oResponsavelFiltro->addItemSelect('MANUTENCAO - EMBALAGEM', 'MANUTENCAO - EMBALAGEM');
        $oResponsavelFiltro->addItemSelect('MECANICA', 'MECANICA');
        $oResponsavelFiltro->addItemSelect('LIDER', 'LIDER');
       // $oResponsavelFiltro->addItemSelect('SOLDADOR', 'SOLDADOR');
        $oResponsavelFiltro->setSLabel('');

        //Filtro de Setor
        $oFiltroSetor = new Filtro($oCodSetor, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFiltroSetor->addItemSelect('', 'Todos Setores');
        $iCont = 0;
        foreach ($aCodSetor as $key1) {
            $oFiltroSetor->addItemSelect($key1, $key1 . ' - ' . $aDesSetor[$iCont]);
            $iCont++;
        }
        $oFiltroSetor->setSLabel('');

        $this->setUsaAcaoExcluir(false);
        if($_SESSION['codUser']=='81'||$_SESSION['codSetor']=='2'){
            $this->setUsaAcaoAlterar(true);
            $this->setUsaAcaoIncluir(true);
        }else{
            $this->setUsaAcaoAlterar(false);
            $this->setUsaAcaoIncluir(false);
        }
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oTipFiltro, $oDesTipFiltro, $oDescricaoFiltro, $oResponsavelFiltro, $oFiltroSetor);

        $this->getTela()->setBMostraFiltro(true);

        $this->addCampos($oSit, $oTipDes, $oServ, $oCiclo, $oResp, $oCodSetor, $oDSetor);
    }

    public function criaTela() {
        parent::criaTela();

        $oSit = new Campo('CodSit', 'codsit', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSit->setBCampoBloqueado(true);
        $oSer = new Campo('Serviço', 'servico', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSer->addValidacao(false, Validacao::TIPO_STRING);

        $oCiclo = new Campo('Ciclo', 'ciclo', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCiclo->addItemSelect('', '');
        $oCiclo->addItemSelect('1', '1 dias');
        $oCiclo->addItemSelect('7', '7 dias');
        $oCiclo->addItemSelect('15', '15 dias');
        $oCiclo->addItemSelect('30', '30 dias');
        $oCiclo->addItemSelect('60', '60 dias');
        $oCiclo->addItemSelect('90', '90 dias');
        $oCiclo->addItemSelect('120', '120 dias');
        $oCiclo->addItemSelect('166', '166 dias');
        $oCiclo->addItemSelect('180', '180 dias');
        $oCiclo->addItemSelect('365', '365 dias');
        $oCiclo->addItemSelect('730', '730 dias');
        $oCiclo->addItemSelect('1095', '1095 dias');

        $oResp = new Campo('Responsável', 'resp', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oResp->addItemSelect('', '');
        $oResp->addItemSelect('ENCARREGADO DA PRODUCAO', 'ENCARREGADO DA PRODUCAO');
        $oResp->addItemSelect('ELETRICA', 'ELETRICA');
        $oResp->addItemSelect('OPERADOR', 'OPERADOR');
        $oResp->addItemSelect('MANUTENCAO - PARAFUSOS', 'MANUTENCAO - PARAFUSOS');
        $oResp->addItemSelect('MANUTENCAO - EMBALAGEM', 'MANUTENCAO - EMBALAGEM');
        $oResp->addItemSelect('MECANICA', 'MECANICA');
        $oResp->addItemSelect('LIDER', 'LIDER');
        $oResp->addItemSelect('SOLDADOR', 'SOLDADOR');

        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));

        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setSValor(date('H:i'));

        $oUser = new Campo('Usuário', 'usercad', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);

        $oTip = new Campo('TipCod', 'tipcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oTip->setSValor('1');
        $oTip->addValidacao(false, Validacao::TIPO_STRING);
        $oTip->setBFocus(true);

        //campo descrição do maquina o campo de busca
        $oMaq_des = new Campo('Tipo Maquina', 'tipdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oMaq_des->setSIdPk($oTip->getId());
        $oMaq_des->setClasseBusca('MET_CadastroMaquinas');
        $oMaq_des->addCampoBusca('tipcod', '', '');
        $oMaq_des->addCampoBusca('tipdes', '', '');
        $oMaq_des->setSIdTela($this->getTela()->getId());
        $oMaq_des->setSValor('CONFORMACAO A FRIO PORCAS');
        $oMaq_des->addValidacao(false, Validacao::TIPO_STRING);
        $oMaq_des->setApenasTela(true);
        $oMaq_des->setBCampoBloqueado(true);

        //declarar o campo descrição maquina
        $oTip->setClasseBusca('MET_CadastroMaquinas');
        $oTip->setSCampoRetorno('tipcod', $this->getTela()->getId());
        $oTip->addCampoBusca('tipdes', $oMaq_des->getId(), $this->getTela()->getId());
        
        $oSetor = new campo('Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSetor->setBFocus(true);
        
        $oSetorDes = new Campo('Descrição', 'descsetor', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oSetorDes->setSIdPk($oSetor->getId());
        $oSetorDes->setClasseBusca('Setor');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getid());
        $oSetorDes->addValidacao(false, Validacao::TIPO_STRING);
        $oSetorDes->setApenasTela(true);
        $oSetorDes->setBCampoBloqueado(true);

        $oSetor->setClasseBusca('Setor');
        $oSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oSetor->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());
        
        $oSitua = new Campo('Situação', 'sit', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oSitua->addItemSelect('ABERTO', 'ABERTO');
        $oSitua->addItemSelect('BLOQUEADO', 'BLOQUEADO');

        $oSer->setBFocus(true);
        
        $this->addCampos(array($oSit, $oUser, $oData, $oHora), array($oTip, $oMaq_des),array($oSetor, $oSetorDes), array($oSer), array($oCiclo, $oResp, $oSitua));
    }

}
