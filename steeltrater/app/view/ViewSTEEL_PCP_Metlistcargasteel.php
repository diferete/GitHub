<?php

/*
 * * Implementa classe view
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class ViewSTEEL_PCP_Metlistcargasteel extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);
        $this->getTela()->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $dataCarga = new CampoConsulta('Data Carga', 'dataCarga', CampoConsulta::TIPO_DATA);
        $nrCarga = new CampoConsulta('Nr Carga', 'nrCarga');
        $sit = new CampoConsulta('Sit', 'sit');
        $usuario = new CampoConsulta('Usuario', 'usuario');
        $data = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        $hora = new CampoConsulta('Hora', 'hora');

        $filtroDatacarga = new Filtro($dataCarga, Filtro::CAMPO_TEXTO, 3);
        $this->addFiltro($filtroDatacarga);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);

        $this->addCampos($dataCarga, $nrCarga, $sit, $usuario, $data, $hora);

        $this->setUsaDropdown(true);
        $oDrop = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_PCP_OrdensFab', 'acaoMostraRelEspecifico', '', false, 'OpSteel1', false, '', false, '', true, false);
        $this->addDropdown($oDrop);
    }

    public function criaTela() {
        parent::criaTela();

        $dataCarga = new Campo('Data Carga', 'dataCarga', Campo::TIPO_DATA, 1, 1);
        $nrCarga = new Campo('Nr Carga', 'nrCarga');
        $sit = new Campo('Sit', 'sit');
        $usuario = new Campo('Usuario', 'usuario');
        $data = new Campo('Data', 'data', Campo::TIPO_DATA);
        $hora = new Campo('Hora', 'hora');

        $this->addCampos(array($dataCarga, $nrCarga), $sit, $usuario, $data, $hora);
    }

}
