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

        $oSit = new CampoConsulta('CodSit', 'codsit');
        $oTip = new CampoConsulta('TipCod', 'tipcod');
        $oServ = new CampoConsulta('Serviço', 'servico');
        $oCiclo = new CampoConsulta('Ciclo', 'ciclo');
        $oResp = new CampoConsulta('Responsável', 'resp');
        $oUser = new CampoConsulta('Usuario', 'usercad');
        $oData = new CampoConsulta('Data', 'data');
        $oHora = new CampoConsulta('Hora', 'hora');

        
        $oDescricaoFiltro = new Filtro($oServ, Filtro::CAMPO_TEXTO,3);
        
        
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaoFiltro);
        
        $this->setBScrollInf(TRUE);
        $this->addCampos($oSit, $oTip, $oServ, $oCiclo,$oResp, $oUser, $oData, $oHora);
    }

    public function criaTela() {
        parent::criaTela();
        
        $oSit = new Campo('CodSit', 'codsit', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $oSer = new Campo('Serviço', 'servico', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSer->addValidacao(false, Validacao::TIPO_STRING);
        
        $oCiclo = new Campo('Ciclo', 'ciclo', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCiclo->addItemSelect('Teste', 'Teste');
        $oCiclo->addValidacao(false, Validacao::TIPO_INTEIRO);
        $oCiclo->setIMarginTop(1);
        
        $oResp = new Campo('Responsável', 'resp', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oResp->addValidacao(false, Validacao::TIPO_STRING);
        
        
        $oData = new Campo('Data','data', Campo::TIPO_TEXTO,1,1,12,12);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));
        
        $oHora = new Campo('Hora','hora', Campo::TIPO_TEXTO,2,2,12,12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setSValor(date('H:i'));
        
        $oUser = new Campo('Usuário','usercad', Campo::TIPO_TEXTO,2,2,12,12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);
        
        $oTip = new Campo('TipCod','tipcod',Campo::TIPO_BUSCADOBANCOPK,2,2,12,12);
        $oTip->setSValor('1');
        $oTip->addValidacao(false, Validacao::TIPO_STRING);
        
        //campo descrição do maquina o campo de busca
        $oMaq_des = new Campo('Maquina','tipdes',Campo::TIPO_BUSCADOBANCO, 4,4,12,12);
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
        
        
        $this->addCampos(array($oSit, $oSer, $oCiclo,$oResp, $oUser, $oData, $oHora), array($oTip, $oMaq_des));
    }

}
