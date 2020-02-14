<?php

/*
 * Gerencia as visões de cadastro dos escritórios de representações
 */

class viewMET_COM_Repoffice extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $this->setaTiluloConsulta('Consulta escritórios de representações');



        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oOfficecod = new CampoConsulta('Código escritório', 'officecod');
        $oOfficecod->setILargura(5);
        $oOfficeDes = new CampoConsulta('Nome Escritório', 'officedes', CampoConsulta::TIPO_LARGURA, 20);
        $oCabSol = new CampoConsulta('Cab. Sol', 'officecabsol');
        $oItenSol = new CampoConsulta('Iten. Sol', 'officecabsoliten');
        $oCabCot = new CampoConsulta('Cab. Cot', 'officecabcot');
        $oItenCot = new CampoConsulta('Iten. Cot', 'officecabcotiten');

        $this->setUsaAcaoVisualizar(true);

        $oFilOffice = new Filtro($oOfficeDes, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addFiltro($oFilOffice);

        $this->addCampos($oFilcgc, $oOfficecod, $oOfficeDes, $oCabSol, $oItenSol, $oCabCot, $oItenCot);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de escritórios de representações');

        $oFilcgc = new Campo('Emp. Grupo', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 2, 2);
        $oFilcgc->setClasseBusca('DELX_FIL_Empresa');
        $oFilcgc->setSCampoRetorno('fil_codigo', $this->getTela()->getId());
        $oFilcgc->setBFocus(true);


        $officeCod = new Campo('Código', 'officecod', Campo::TIPO_TEXTO, 1);
        $officeCod->setITamanho(Campo::TAMANHO_PEQUENO);
        $oFilDes = new Campo('Nome do Escritório', 'officedes', Campo::TIPO_TEXTO, 6);
        $oFilDes->setITamanho(Campo::TAMANHO_PEQUENO);

        $oRepOffice = new Campo('Diretório', 'officedir', Campo::TIPO_TEXTO, 5);

        $oTabOffice = new Campo('Cab. sol', 'officecabsol', Campo::TIPO_TEXTO, 3);

        $oItenSol = new Campo('Iten. Sol', 'officecabsoliten', Campo::TIPO_TEXTO, 3);

        $oCabCot = new Campo('Cab. Cot', 'officecabcot', Campo::TIPO_TEXTO, 3);

        $oItenCot = new Campo('Iten. Cot', 'officecabcotiten', Campo::TIPO_TEXTO, 3);

        $oImgRel = new Campo('Imagem padrão de relatórios', 'officeimgrel', Campo::TIPO_UPLOAD);

        $oSolrel = new campo('Relatório de solicitação de pedidos', 'officesolrel', Campo::TIPO_TEXTO, 4);

        $oCotrel = new campo('Relatório de cotação', 'officecotrel', Campo::TIPO_TEXTO, 4);

        $oRepAlm = new Campo('Almoxarifado liberados', 'officealm', Campo::TIPO_TEXTO, 4, 4, 4, 4);

        $oRespOffice = new campo('Responsável Venda', 'officeResp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 2, 2);
        $oRespOffice->setClasseBusca('MET_TEC_Usuario');
        $oRespOffice->setSCampoRetorno('usucodigo', $this->getTela()->getId());





        $this->addCampos($oFilcgc, array($officeCod, $oFilDes), $oRepOffice, $oTabOffice, $oItenSol, $oCabCot, $oItenCot, $oImgRel, $oSolrel, $oCotrel, $oRepAlm, $oRespOffice);
    }

}
