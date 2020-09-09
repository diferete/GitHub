<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_CAD_Placas extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(TRUE);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(true);
        $this->setUsaFiltro(true);


        $oFilcgc = new CampoConsulta('Empresa', 'filcgc', CampoConsulta::TIPO_TEXTO);

        $oPlaca = new CampoConsulta('Placa', 'placa', CampoConsulta::TIPO_TEXTO);

        $oEmpCod = new CampoConsulta('CNPJ', 'empcod', CampoConsulta::TIPO_TEXTO);

        $oEmpdes = new CampoConsulta('Emp.Des.', 'empdes', CampoConsulta::TIPO_TEXTO);

        $oColab = new CampoConsulta('Colaborador', 'nome', CampoConsulta::TIPO_TEXTO);

        $oFiltroEmpdes = new Filtro($oEmpdes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $oFiltroPlaca = new Filtro($oPlaca, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFiltroNome = new Filtro($oColab, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addFiltro($oFiltroEmpdes, $oFiltroPlaca, $oFiltroNome);
        $this->addCampos($oFilcgc, $oPlaca, $oEmpCod, $oEmpdes, $oColab);
    }

    public function criaTela() {
        parent::criaTela();


        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oDivisor1 = new Campo('Cadastro do veículo.', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '7', '7');
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPlaca->setBFocus(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_CAD_Placas","buscaPlaca","' . $oPlaca->getId() . '");';

        $oPlaca->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oEmpcod = new Campo('CNPJ', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING,'','12');

        $oEmpdes = new Campo('Emp/Transp', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getid());

        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());

        $oDivisor2 = new Campo('Crachá, caso seja colaborador.', 'divisor2', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oCracha = new Campo('Cracha', 'cracha', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oNome = new Campo('Nome', 'nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $sCallBackCracha = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_CAD_Placas","buscaPessoa","' . $oNome->getId() . '");';

        $oCracha->addEvento(Campo::EVENTO_SAIR, $sCallBackCracha);


        $this->addCampos($oDivisor1, array($oPlaca, $oEmpcod, $oEmpdes), $oDivisor2, array($oCracha, $oNome), array($oFilcgc));
    }

}
