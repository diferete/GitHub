<?php 
 /*
 * Implementa a classe view MET_MANUT_OSServico
 * @author Cleverton Hoffmann
 * @since 06/10/2021
 */
 
class ViewMET_MANUT_OSServico extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
    public function criaConsulta() { 
        parent::criaConsulta();
 
        $this->setUsaAcaoVisualizar(true);
        
        $ofil_codigo = new CampoConsulta('Empresa', 'fil_codigo');
        $oCodServ = new CampoConsulta('Cod. Serv.', 'codserv');
        $oServ = new CampoConsulta('Serviço', 'servico');
        $oTip = new CampoConsulta('TipCod', 'tipcod');
        $oCodSetor = new CampoConsulta('Cod. Setor', 'MET_CAD_Setores.codsetor');
        $oDSetor = new CampoConsulta('Setor', 'MET_CAD_Setores.descsetor');
        $oCiclo = new CampoConsulta('Ciclo', 'ciclo');
        $oResp = new CampoConsulta('Responsável', 'resp');
        $oSit = new CampoConsulta('Situação', 'sit');

        $oCodFiltro = new Filtro($oCodServ, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);
                
        $oDesTipFiltro = new Filtro($oTip, Filtro::CAMPO_SELECT, 4, 4, 12, 12, false);
        $oDesTipFiltro->addItemSelect('', 'TODAS CATEGORIAS');
        $oDesTipFiltro->addItemSelect('PO', 'PO');
        $oDesTipFiltro->addItemSelect('PF', 'PF');
        $oDesTipFiltro->addItemSelect('CNC', 'CNC');
        $oDesTipFiltro->addItemSelect('MQ', 'MQ');
        $oDesTipFiltro->addItemSelect('ROSQ', 'ROSQ');
        $oDesTipFiltro->addItemSelect('DIVER', 'DIVER');
        $oDesTipFiltro->setSLabel('');
//
        $oDescricaoFiltro = new Filtro($oServ, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $oResponsavelFiltro = new Filtro($oResp, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oResponsavelFiltro->addItemSelect('', 'TODOS OS RESPONSÁVEIS');
        $oResponsavelFiltro->addItemSelect('ELETRICA', 'ELETRICA');
        $oResponsavelFiltro->addItemSelect('OPERADOR', 'OPERADOR');
        $oResponsavelFiltro->addItemSelect('MECANICA', 'MECANICA');
        $oResponsavelFiltro->setSLabel('');
        
        $this->addFiltro($oCodFiltro, $oDescricaoFiltro, $oDesTipFiltro, $oResponsavelFiltro);

        $this->getTela()->setBMostraFiltro(true);

        $this->addCampos($ofil_codigo, $oCodServ, $oServ, $oTip, $oCiclo, $oResp, $oCodSetor, $oDSetor, $oSit);

    }
 
    public function criaTela() { 
        parent::criaTela();
 
        $ofil_codigo = new campo('Cód. Empresa', 'fil_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $ofil_codigo->setSValor('8993358000174'); 
        $ofil_codigo->setBCampoBloqueado(true);
                
        $oSit = new Campo('Cod. Serv.', 'codserv', Campo::TIPO_TEXTO, 1, 1, 12, 12);
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
        $oResp->addItemSelect('ELETRICA', 'ELETRICA');
        $oResp->addItemSelect('OPERADOR', 'OPERADOR');
        $oResp->addItemSelect('MECANICA', 'MECANICA');

        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));

        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setBCampoBloqueado(true);
        $oHora->setSValor(date('H:i'));

        $oUser = new Campo('Usuário', 'usercad', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setBCampoBloqueado(true);
        $oUser->setSValor($_SESSION['nome']);

        $oTip = new Campo('Tipo', 'tipcod', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oTip->addItemSelect('PO', 'PO');
        $oTip->addItemSelect('PF', 'PF');
        $oTip->addItemSelect('CNC', 'CNC');
        $oTip->addItemSelect('MQ', 'MQ');
        $oTip->addItemSelect('ROSQ', 'ROSQ');
        $oTip->addItemSelect('DIVER', 'DIVER');

        $oSetor = new campo('Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSetor->setBFocus(true);

        $oSetorDes = new Campo('Descrição', 'descsetor', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oSetorDes->setSIdPk($oSetor->getId());
        $oSetorDes->setClasseBusca('MET_CAD_Setores');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getid());
        $oSetorDes->addValidacao(false, Validacao::TIPO_STRING);
        $oSetorDes->setApenasTela(true);
        $oSetorDes->setBCampoBloqueado(true);

        $oSetor->setClasseBusca('MET_CAD_Setores');
        $oSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oSetor->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());

        $oSitua = new Campo('Situação', 'sit', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oSitua->addItemSelect('ABERTO', 'ABERTO');
        $oSitua->addItemSelect('BLOQUEADO', 'BLOQUEADO');

        $oSer->setBFocus(true);

        $this->addCampos(array($ofil_codigo, $oSit, $oUser, $oData, $oHora), array($oSetor, $oSetorDes), array($oSer, $oTip), array($oCiclo, $oResp, $oSitua));
        
    } 
}