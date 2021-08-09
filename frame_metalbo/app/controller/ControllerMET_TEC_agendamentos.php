<?php

/*
 * Implementa a classe controller dos agendamentos
 */

class ControllerMET_TEC_agendamentos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_agendamentos');
    }

    public function getAgendamento($aDados) {

        $aModels = $this->Persistencia->getAgendamento();

        foreach ($aModels as $oAtual) {

            $aDados = array();

            $aDados['NR'] = $oAtual->getNr();
            $aDados['TITULO'] = $oAtual->getTitulo();
            $aDados['CLASSE'] = $oAtual->getClasse();
            $aDados['METODO'] = $oAtual->getMetodo();
            $aDados['DATA'] = $oAtual->getData();
            $aDados['HORA'] = substr($oAtual->getHora(), 0, -11);
            $aDados['PARAMETROS'] = $oAtual->getParametros();
            $aDados['OBS'] = $oAtual->getObs();
            $aDados['AGENDAMENTO'] = $oAtual->getAgendamento();
            $aDados['INTERVALOMINUTOS'] = $oAtual->getIntervalominuto();
            $aDados['ULTRESULTADO'] = $oAtual->getUltResultado();
            $aDados['DTULTRESULTADO'] = $oAtual->getDtultresultado();
            $aDados['HORAEXEC'] = $oAtual->getHoraExec();
            $aRetorno[] = $aDados;
        }

        return $aRetorno;
    }

    public function metodoEnvNotas($aDados) {

        foreach ($aDados as $key => $oValue) {
            $sIdAgenda = $oValue->agId;
        }

        /* $fp = fopen("bloco2.txt", "w");
          fwrite($fp, 'CHEGOU');
          fclose($fp); */

        $oMET_FIN_VisualizaNFE = Fabrica::FabricarController('MET_FIN_VisualizaNFE');
        $aRetEmail = $oMET_FIN_VisualizaNFE->enviaXmlAutomatizado();


        $aRetorno = $this->Persistencia->setExecutaAgenda($sIdAgenda);

        return $aRetorno['CHEGOU'] = 'agendaNr: ' . $sIdAgenda;
    }

    /*
      //Método para expirar projetos sem retorno do cliente/representante a mais de 60 dias
      public function metodoExpiraProj($aDados) {
      foreach ($aDados as $key => $oValue) {
      $sIdAgenda = $oValue->adId;
      }

      $aRetorno = $this->Persistencia->setExecutaAgenda($sIdAgenda);

      return $aRetorno['CHEGOU'] = 'agendaNr: ' . $sIdAgenda;
      }

      //Método para notificar o vencimento para tomada de ação para com ação da qualidade
      public function metodoNotificaAQ($aDados) {
      foreach ($aDados as $key => $oValue) {
      $sIdAgenda = $oValue->adId;
      }

      $aRetorno = $this->Persistencia->setExecutaAgenda($sIdAgenda);

      return $aRetorno['CHEGOU'] = 'agendaNr: ' . $sIdAgenda;
      }
     * 
     */
}
