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
        
        $oSit = new CampoConsulta('CodSit', 'codsit');
        $oTip = new CampoConsulta('TipCod', 'tipcod');
        $oTipDes = new CampoConsulta ('DesTip','MET_CadastroMaquinas.tipdes');
        $oServ = new CampoConsulta('Serviço', 'servico');
        $oCiclo = new CampoConsulta('Ciclo', 'ciclo');
        $oResp = new CampoConsulta('Responsável', 'resp');
        $oUser = new CampoConsulta('Usuario', 'usercad');
        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $oHora = new CampoConsulta('Hora', 'hora');
        
        $oTipFiltro = new Filtro($oSit, Filtro::CAMPO_TEXTO_IGUAL,1);
        $oDesTipFiltro = new Filtro($oTipDes, Filtro::CAMPO_SELECT, 4,4,12,12);
        $oDesTipFiltro->addItemSelect('', 'TODAS CATEGORIAS');
        foreach ($aDado1 as $key){
            $oDesTipFiltro->addItemSelect($key['tipdes'], $key['tipdes']);
        }
        $oDesTipFiltro->setSLabel('');
  
        $oDescricaoFiltro = new Filtro($oServ, Filtro::CAMPO_TEXTO,3);
        $oResponsavelFiltro = new Filtro($oResp, Filtro::CAMPO_SELECT,2);
        $oResponsavelFiltro->addItemSelect('', 'TODOS OS RESPONSÁVEIS');
        $oResponsavelFiltro->addItemSelect('ENCARREGADO DA PRODUCAO', 'ENCARREGADO DA PRODUCAO');
        $oResponsavelFiltro->addItemSelect('MANUTENCAO', 'MANUTENCAO');
        $oResponsavelFiltro->addItemSelect('OPERADOR', 'OPERADOR');
        $oResponsavelFiltro->addItemSelect('MANUTENCAO - PARAFUSOS', 'MANUTENCAO - PARAFUSOS');
        $oResponsavelFiltro->addItemSelect('MANUTENCAO - EMBALAGEM', 'MANUTENCAO - EMBALAGEM');
        $oResponsavelFiltro->addItemSelect('MECANICA', 'MECANICA');
        $oResponsavelFiltro->addItemSelect('LIDER', 'LIDER');
        $oResponsavelFiltro->addItemSelect('SOLDADOR', 'SOLDADOR');
        $oResponsavelFiltro->setSLabel('');
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oTipFiltro,$oDesTipFiltro,$oDescricaoFiltro,$oResponsavelFiltro);
        
        $this->getTela()->setBMostraFiltro(true);
        
        $this->addCampos($oSit,$oTipDes, $oServ, $oCiclo,$oResp);
    }

    public function criaTela() {
        parent::criaTela();
        
        $oSit = new Campo('CodSit', 'codsit', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSit->setBCampoBloqueado(true);
        $oSer = new Campo('Serviço', 'servico', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSer->addValidacao(false, Validacao::TIPO_STRING);
              
        $oCiclo = new Campo('Ciclo', 'ciclo', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCiclo->addItemSelect('','');
        $oCiclo->addItemSelect('1','1 dias');
        $oCiclo->addItemSelect('7','7 dias');
        $oCiclo->addItemSelect('15','15 dias');
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
        $oResp->addItemSelect('MANUTENCAO', 'MANUTENCAO');
        $oResp->addItemSelect('OPERADOR', 'OPERADOR');
        $oResp->addItemSelect('MANUTENCAO - PARAFUSOS', 'MANUTENCAO - PARAFUSOS');
        $oResp->addItemSelect('MANUTENCAO - EMBALAGEM', 'MANUTENCAO - EMBALAGEM');
        $oResp->addItemSelect('MECANICA', 'MECANICA');
        $oResp->addItemSelect('LIDER', 'LIDER');
        $oResp->addItemSelect('SOLDADOR', 'SOLDADOR');
        
        
        $oData = new Campo('Data','data', Campo::TIPO_TEXTO,1,1,12,12);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));
        
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,1,1,12,12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setSValor(date('H:i'));
        
        $oUser = new Campo('Usuário','usercad', Campo::TIPO_TEXTO,2,2,12,12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
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
        $oMaq_des->setBCampoBloqueado(true);
        
        //declarar o campo descrição maquina
        $oTip->setClasseBusca('MET_CadastroMaquinas');
        $oTip->setSCampoRetorno('tipcod',$this->getTela()->getId());
        $oTip->addCampoBusca('tipdes',$oMaq_des->getId(),  $this->getTela()->getId());
        
        $this->addCampos(array($oSit, $oUser, $oData, $oHora), array($oTip, $oMaq_des),array($oSer), array($oCiclo,$oResp));
    }

}
