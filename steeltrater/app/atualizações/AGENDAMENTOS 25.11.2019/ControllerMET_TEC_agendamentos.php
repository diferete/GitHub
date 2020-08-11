<?php

/* 
 * Implementa a classe controller dos agendamentos
 */

class ControllerMET_TEC_agendamentos extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_agendamentos');
    }
    
    public function getAgendamento($aDados){
       
        $aModels = $this->Persistencia->getAgendamento('');
        
         foreach($aModels as $oAtual){
            
             $aDados = array();
			 
             $aDados['NR'] = $oAtual->getNr();  
             $aDados['TITULO'] = $oAtual->getTitulo();
             $aDados['CLASSE'] = $oAtual->getClasse();
             $aDados['METODO'] = $oAtual->getMetodo();
             $aDados['DATA'] = $oAtual->getData();
             $aDados['HORA'] = substr($oAtual->getHora(),0,-11);
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
    
    public function metodo1($aDados){
        foreach ($aDados as $key => $oValue) {
            $sIdAgenda = $oValue->agId;
        }
        //envia o e-mail
        $oEnvMail = Fabrica::FabricarController('STEEL_PCP_GerenProd');
        $sLogEmail = $oEnvMail->enviaEmailProdAdm('EnvEmail','agenda');
        
                
        
        $aRetorno = $this->Persistencia->setExecutaAgenda($sIdAgenda);
        
        
        
        return $aRetorno['CHEGOU'] =$sLogEmail;
       
       
        
    }
}
