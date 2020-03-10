<?php

/*
 * Classe para cadastrar os agendamentos 
 * 
 * @data 16/07/2019
 * @Usuário Avanei Martendal 
 */

class PersistenciaMET_TEC_agendamentos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_agendamentos');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('titulo', 'titulo');
        $this->adicionaRelacionamento('classe', 'classe');
        $this->adicionaRelacionamento('metodo', 'metodo');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('parametros', 'parametros');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('agendamento', 'agendamento');
        $this->adicionaRelacionamento('intervalominuto', 'intervalominuto');

        $this->adicionaRelacionamento('ultresultado', 'ultresultado');
        $this->adicionaRelacionamento('dtultresultado', 'dtultresultado');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop('200');
    }

    public function getAgendamento() {
        $sSql = "select nr,
                titulo ,
                classe,
                metodo,
                data,
                hora,
                parametros,
                obs,
                agendamento,
                intervalominuto,
                ultresultado,
                dtultresultado,
                horaexec
                from MET_TEC_agendamentos order by nr desc ";

        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $this->getNewModel();

            $oModel->setNr($oRowBD->nr);
            $oModel->setTitulo($oRowBD->titulo);
            $oModel->setClasse($oRowBD->classe);
            $oModel->setMetodo($oRowBD->metodo);
            $oModel->setData($oRowBD->data);
            $oModel->setHora($oRowBD->hora);
            $oModel->setParametros($oRowBD->parametros);
            $oModel->setObs($oRowBD->obs);
            $oModel->setAgendamento($oRowBD->agendamento);
            $oModel->setIntervalominuto($oRowBD->intervalominuto);
            $oModel->setUltresultado($oRowBD->ultresultado);
            $oModel->setDtultresultado($oRowBD->dtultresultado);
            $oModel->setHoraExec($oRowBD->horaexec);


            $aRetorno[] = $oModel;
        }


        return $aRetorno;
    }

    public function setExecutaAgenda($sIdAgenda) {
        //date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');

        $sSql = "update MET_TEC_agendamentos 
                    set ultResultado ='Sucesso!',
                    dtultResultado ='" . $sData . "', 
                    horaExec ='" . $sHora . "'
                    where nr =" . $sIdAgenda . "";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

}
