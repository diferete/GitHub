<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_HorasParadas extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_HorasParadas');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $sFornoDes = $this->Persistencia->buscaForno($aChave);
        $aChave[1] = $sFornoDes;

        $this->View->setAParametrosExtras($aChave);
        
        $oMotivos = Fabrica::FabricarController('STEEL_PCP_ParMotivo');
        $aMotivos = $oMotivos->Persistencia->getArrayModel();

        $aDados[] = $aMotivos;
        //Concatena parametros extras no array de motivos passado para a view
        $aDados[] = $this->View->getAParametrosExtras();

        $this->View->setAParametrosExtras($aDados);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aParam1 = explode(',', $this->getParametros());
        $aParam = $this->View->getAParametrosExtras();
        if (count($aParam) > 0) {
            $this->Persistencia->adicionaFiltro('fornocod', $aParam[0]);
        } else {
            $this->Persistencia->adicionaFiltro('fornocod', $aParam1[0]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
        
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);

        $sScript = '$("#' . $sForm . '").each(function(){this.reset();});';
        echo $sScript;
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[1]);
        foreach ($aCampos as $key => $value) {
            $aCampoAtual = explode('=', $value);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }
    }

    public function beforeInsert() {
        parent::beforeInsert();

        //-----Inicío do calculo e inserção de horas paradas----//
        $sModel = $this->Model;
        $iHorasTotal = 0;
        //Responsável por pegar valor inteiro da diferença de dias
        $date1 = date_create_from_format('d/m/Y', $sModel->getDataini());
        $date2 = date_create_from_format('d/m/Y', $sModel->getDatafim());
        $dataent = $date1->format('Y-m-d');
        $datasaid = $date2->format('Y-m-d');
        ;
        $dataent1 = date_create($dataent);
        $datasaid2 = date_create($datasaid);
        $diff = date_diff($dataent1, $datasaid2);
        $iDias = (int) $diff->format('%d');

        $iHorasDias = $iDias * 24;

        $hora1 = date_create_from_format('H:i', $sModel->getHoraini());
        $hora2 = date_create_from_format('H:i', $sModel->getHorafim());
        $horaent = $hora1->format('Y-m-d H:i:s');
        $horasaid = $hora2->format('Y-m-d H:i:s');
        ;
        $horaent1 = date_create($horaent);
        $horasaid2 = date_create($horasaid);
        $diff2 = date_diff($horaent1, $horasaid2);
        $iHoras = (int) $diff2->format('%h');
        $iMinutos = (int) $diff2->format('%i');
        $nHoras = $iHoras + $iMinutos / 60;

        //Verifica a necessidade de descontar das horas dos dias
        $horaAux1 = strtotime($sModel->getHoraini());
        $horaAux2 = strtotime($sModel->getHorafim());
        if ($horaAux2 < $horaAux1) {
            $iHorasTotal = $iHorasDias - $nHoras;
        } else {
            $iHorasTotal = $iHorasDias + $nHoras;
        }

        $this->Model->setHorasparadas($iHorasTotal);
        //-----Fim do calculo e inserção de horas paradas----//
        //---------Início Parte que monta a string horas paradas-----//
        $sTempoParada = '';
        $qDias = 0;
        $qHoras = 0;
        $qMin = 0;
        if ($iHorasTotal >= 24) {
            $qDias = (int) ($iHorasTotal / 24);
            $qHoras = (int) ($iHorasTotal % 24);
            $qMin = round(((($iHorasTotal - ($qDias * 24)) - $qHoras) * 60),0);
            $sTempoParada = $qDias . " dia(s), " . $qHoras . " horas e " . $qMin . " min.";
        } else {
            if ($iHorasTotal < 24 && $iHorasTotal >= 1) {
                $qHoras = (int) ($iHorasTotal);
                $qMin = round((($iHorasTotal - $qHoras) * 60),0);
                $sTempoParada = $qHoras . " hora(s) e " . $qMin . " minutos";
            } else {
                $qMin = (int) (($iHorasTotal) * 60);
                $sTempoParada = $qMin . " minutos";
            }
        }

        $this->Model->setTempoparada($sTempoParada);
        //---------Fim Parte que monta a string horas paradas-----//
        //Adiciona descrição do motivo na inserção
        $oMotivos = Fabrica::FabricarController('STEEL_PCP_ParMotivo');
        $oMotivos->Persistencia->adicionaFiltro('codmotivo', $sModel->getCodmotivo());
        $oMotivo = $oMotivos->Persistencia->consultarWhere();
        $this->Model->setMotivo($oMotivo->getDescricao());

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        //-----Inicío do calculo e inserção de horas paradas----//
        $sModel = $this->Model;
        $iHorasTotal = 0;
        //Responsável por pegar valor inteiro da diferença de dias
        $date1 = date_create_from_format('d/m/Y', $sModel->getDataini());
        $date2 = date_create_from_format('d/m/Y', $sModel->getDatafim());
        $dataent = $date1->format('Y-m-d');
        $datasaid = $date2->format('Y-m-d');
        ;
        $dataent1 = date_create($dataent);
        $datasaid2 = date_create($datasaid);
        $diff = date_diff($dataent1, $datasaid2);
        $iDias = (int) $diff->format('%d');

        $iHorasDias = $iDias * 24;

        $hora1 = date_create_from_format('H:i', $sModel->getHoraini());
        $hora2 = date_create_from_format('H:i', $sModel->getHorafim());
        $horaent = $hora1->format('Y-m-d H:i:s');
        $horasaid = $hora2->format('Y-m-d H:i:s');
        ;
        $horaent1 = date_create($horaent);
        $horasaid2 = date_create($horasaid);
        $diff2 = date_diff($horaent1, $horasaid2);
        $iHoras = (int) $diff2->format('%h');
        $iMinutos = (int) $diff2->format('%i');
        $nHoras = $iHoras + $iMinutos / 60;

        //Verifica a necessidade de descontar das horas dos dias
        $horaAux1 = strtotime($sModel->getHoraini());
        $horaAux2 = strtotime($sModel->getHorafim());
        if ($horaAux2 < $horaAux1) {
            $iHorasTotal = $iHorasDias - $nHoras;
        } else {
            $iHorasTotal = $iHorasDias + $nHoras;
        }

        $this->Model->setHorasparadas($iHorasTotal);
        //-----Fim do calculo e inserção de horas paradas----//
        //---------Início Parte que monta a string horas paradas-----//
        $sTempoParada = '';
        $qDias = 0;
        $qHoras = 0;
        $qMin = 0;
        if ($iHorasTotal >= 24) {
            $qDias = (int) ($iHorasTotal / 24);
            $qHoras = (int) ($iHorasTotal % 24);
            $qMin = round(((($iHorasTotal - ($qDias * 24)) - $qHoras) * 60),0);
            $sTempoParada = $qDias . " dia(s), " . $qHoras . " horas e " . $qMin . " min.";
        } else {
            if ($iHorasTotal < 24 && $iHorasTotal >= 1) {
                $qHoras = (int) ($iHorasTotal);
                $qMin = round((($iHorasTotal - $qHoras) * 60),0);
                $sTempoParada = $qHoras . " hora(s) e " . $qMin . " minutos";
            } else {
                $qMin = (int) (($iHorasTotal) * 60);
                $sTempoParada = $qMin . " minutos";
            }
        }

        $this->Model->setTempoparada($sTempoParada);
        //---------Fim Parte que monta a string horas paradas-----//
        //Adiciona descrição do motivo na inserção
        $oMotivos = Fabrica::FabricarController('STEEL_PCP_ParMotivo');
        $oMotivos->Persistencia->adicionaFiltro('codmotivo', $sModel->getCodmotivo());
        $oMotivo = $oMotivos->Persistencia->consultarWhere();
        $this->Model->setMotivo($oMotivo->getDescricao());

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
