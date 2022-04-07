<?php

/*
 * * Implementa classe persistencia
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class ViewMET_MP_ManutHistorico extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);
        $this->getTela()->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        
        $id = new CampoConsulta('ID', 'id');
        $usersistcod = new CampoConsulta('Cod usuário', 'usersistcod');
        $usersistdes = new CampoConsulta('Usuário', 'usersistdes');
        $codmaquina = new CampoConsulta('Cod', 'codmaquina');
        $descmaquina = new CampoConsulta('Maquina', 'MET_MP_Maquinas.maquina');
        $horasmaq = new CampoConsulta('Horas', 'horasmaq');
       // $horasmaqant = new CampoConsulta('Quant horas', 'horasmaqant');
       // $obs = new CampoConsulta('OBS', 'obs');
        $data = new CampoConsulta('Data', 'datahora', CampoConsulta::TIPO_DATA);

       // $filtroDatacarga = new Filtro($dataCarga, Filtro::CAMPO_TEXTO, 3);
       // $this->addFiltro($filtroDatacarga);
        
        $oFilCodMaq = new Filtro($codmaquina, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12, false);
        $oFilCodMaq->setSClasseBusca('MET_MP_Maquinas');
        $oFilCodMaq->setSCampoRetorno('cod', $this->getTela()->getSId());
        $oFilCodMaq->setSIdTela($this->getTela()->getSId());
        //$filtrodescmaquina = new Filtro($descmaquina, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $filtrousersistdes = new Filtro($usersistdes, Filtro::CAMPO_TEXTO, 3);
        
        $this->addFiltro($oFilCodMaq, $filtrousersistdes);
        
        $this->addCampos($data, $codmaquina,$descmaquina, $horasmaq, $usersistcod, $usersistdes);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Cod', 'tipcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDes = new Campo('Tipo Maquina', 'tipdes', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $this->addCampos(array($oCod, $oDes));
    }

}
