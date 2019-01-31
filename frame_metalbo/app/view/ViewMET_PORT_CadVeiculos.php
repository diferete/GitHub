<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_PORT_CadVeiculos extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(TRUE);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(true);
        $this->setUsaFiltro(true);

        $oFilcgc = new CampoConsulta('CNPJ', 'filcgc', CampoConsulta::TIPO_TEXTO);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);

        $oPlaca = new CampoConsulta('Placa', 'placa', CampoConsulta::TIPO_TEXTO);

        $oDatacad = new CampoConsulta('Data Cad', 'datacad', CampoConsulta::TIPO_DATA);

        $oEmpdes = new CampoConsulta('Empresa', 'emptransdes', CampoConsulta::TIPO_TEXTO);

        $oSetor = new CampoConsulta('Setor', 'descsetor', CampoConsulta::TIPO_TEXTO);

        $oFiltroNr = new Filtro($oNr, Filtro::CAMPO_INTEIRO, 2, 2, 12, 12);
        $oFiltroEmpdes = new Filtro($oEmpdes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12);
        $oFiltroPlaca = new Filtro($oPlaca, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);

        $this->addFiltro($oFiltroNr, $oFiltroEmpdes, $oFiltroPlaca);
        $this->addCampos($oFilcgc, $oNr, $oPlaca, $oDatacad, $oEmpdes, $oSetor);
    }

    public function criaTela() {
        parent::criaTela();

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oUsuCod = new Campo('', 'usucod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCod->setSValor($_SESSION['codUser']);
        $oUsuCod->setBCampoBloqueado(true);
        $oUsuCod->setBOculto(true);

        $oUsuNome = new Campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsuNome->setSValor($_SESSION['nome']);
        $oUsuNome->setBCampoBloqueado(true);


        $oDatacad = new Campo('Data cad.', 'datacad', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDatacad->setSValor(date('d/m/Y'));
        $oDatacad->setBCampoBloqueado(true);

        $oDivisor1 = new Campo('Cadastro do veículo.', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oPlaca = new Campo('Placa', 'placa', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPlaca->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '7', '7');
        $oPlaca->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPlaca->setBFocus(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PORT_CadVeiculos","buscaPlaca","' . $oPlaca->getId() . '");';

        $oPlaca->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oContato = new Campo('Contato *número c/ DDD', 'contato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oContato->setBFone(true);

        $oModelo = new Campo('Fabricante/Modelo', 'modelo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oModelo->addItemSelect('Selecionar', 'Selecionar');
        $oModelo->addItemSelect('Audi', 'Audi');
        $oModelo->addItemSelect('BMW', 'BMW');
        $oModelo->addItemSelect('Cherry', 'Cherry');
        $oModelo->addItemSelect('Chevrolet', 'Chevrolet');
        $oModelo->addItemSelect('Fiat', 'Fiat');
        $oModelo->addItemSelect('Ford', 'Ford');
        $oModelo->addItemSelect('Honda', 'Honda');
        $oModelo->addItemSelect('Hyundai', 'Hyundai');
        $oModelo->addItemSelect('Iveco', 'Iveco');
        $oModelo->addItemSelect('Jac', 'Jac');
        $oModelo->addItemSelect('Jeep', 'Jeep');
        $oModelo->addItemSelect('Mercedes-Benz', 'Mercedes-Benz');
        $oModelo->addItemSelect('Nissan', 'Nissan');
        $oModelo->addItemSelect('Scania', 'Scania');
        $oModelo->addItemSelect('Toyota', 'Toyota');
        $oModelo->addItemSelect('Volvo', 'Volvo');
        $oModelo->addItemSelect('Volkswagen', 'Volkswagen');
        $oModelo->addItemSelect('Yamaha', 'Yamaha');
        $oModelo->addItemSelect('Outra', 'Outra');

        $oCor = new Campo('Cor', 'cor', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCor->addItemSelect('Selecionar', 'Selecionar');
        $oCor->addItemSelect('BRANCA', 'BRANCA');
        $oCor->addItemSelect('PRETA', 'PRETA');
        $oCor->addItemSelect('PRATA', 'PRATA');
        $oCor->addItemSelect('CINZA', 'CINZA');
        $oCor->addItemSelect('VERDE', 'VERDE');
        $oCor->addItemSelect('AZUL', 'AZUL');
        $oCor->addItemSelect('VERMELHA', 'VERMELHA');
        $oCor->addItemSelect('AMARELO', 'AMARELO');
        $oCor->addItemSelect('BEGE', 'BEGE');
        $oCor->addItemSelect('DOURADA', 'DOURADA');
        $oCor->addItemSelect('LARANJA', 'LARANJA');
        $oCor->addItemSelect('MARROM', 'MARROM');
        $oCor->addItemSelect('ROSA', 'ROSA');
        $oCor->addItemSelect('ROXA', 'ROXA');
        $oCor->addItemSelect('GRENÁ', 'GRENÁ');
        $oCor->addItemSelect('FANTASIA', 'FANTASIA');

        $oEmpcod = new Campo('CNPJ', 'emptranscod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oEmpcod->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório!', '1');

        $oEmpdes = new Campo('Emp/Transp', 'emptransdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getid());

        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());

        $oDivisor2 = new Campo('Setor, caso seja colaborador.', 'divisor2', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oSetorCod = new Campo('Cód', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oSetorDes = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSetorDes->setSIdPk($oSetorCod->getId());
        $oSetorDes->setClasseBusca('Setor');
        $oSetorDes->addCampoBusca('codsetor', '', '');
        $oSetorDes->addCampoBusca('descsetor', '', '');
        $oSetorDes->setSIdTela($this->getTela()->getid());


        $oSetorCod->setClasseBusca('Setor');
        $oSetorCod->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oSetorCod->addCampoBusca('descsetor', $oSetorDes->getId(), $this->getTela()->getId());

        $this->addCampos(array($oFilcgc, $oNr, $oUsuNome, $oDatacad), $oDivisor1, array($oPlaca, $oModelo, $oCor), array($oEmpcod, $oEmpdes, $oContato), $oDivisor2, array($oSetorCod, $oSetorDes, $oUsuCod)
        );
    }

}
