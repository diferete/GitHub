<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class PersistenciaSTEEL_PCP_Certificado extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_CERTIFICADO');

        $this->adicionaRelacionamento('nrcert', 'nrcert', true, true, true);
        $this->adicionaRelacionamento('op', 'op');
        $this->adicionaRelacionamento('notasteel', 'notasteel');
        $this->adicionaRelacionamento('notacliente', 'notacliente');
        $this->adicionaRelacionamento('opcliente', 'opcliente');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('dataensaio', 'dataensaio');
        $this->adicionaRelacionamento('dataemissao', 'dataemissao');
        $this->adicionaRelacionamento('peso', 'peso');
        $this->adicionaRelacionamento('quant', 'quant');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('hora', 'hora');
        
        $this->adicionaRelacionamento('durezaSuperfMin', 'durezaSuperfMin');
        $this->adicionaRelacionamento('durezaSuperfMax', 'durezaSuperfMax');
        $this->adicionaRelacionamento('SuperEscala', 'SuperEscala');
        
        $this->adicionaRelacionamento('durezaNucMin', 'durezaNucMin');
        $this->adicionaRelacionamento('durezaNucMax', 'durezaNucMax');
        $this->adicionaRelacionamento('NucEscala', 'NucEscala');
        
        $this->adicionaRelacionamento('expCamadaMin', 'expCamadaMin');
        $this->adicionaRelacionamento('expCamadaMax', 'expCamadaMax');
        
        $this->adicionaRelacionamento('inspeneg','inspeneg');
        
        $this->adicionaRelacionamento('sitEmail', 'sitEmail');
        
        $this->adicionaRelacionamento('conclusao', 'conclusao');
        
        $this->adicionaRelacionamento('fioDurezaSol', 'fioDurezaSol');
        $this->adicionaRelacionamento('fioEsferio', 'fioEsferio');
        $this->adicionaRelacionamento('fioDescarbonetaTotal', 'fioDescarbonetaTotal');
        $this->adicionaRelacionamento('fioDescarbonetaParcial', 'fioDescarbonetaParcial');
        $this->adicionaRelacionamento('DiamFinalMin', 'DiamFinalMin');
        $this->adicionaRelacionamento('DiamFinalMax', 'DiamFinalMax');
        
        
        $this->setSTop('300');
        $this->adicionaOrderBy('nrcert', 1);
    }
    
    /**
     * Muda a situação do envio do e-mail
     */
    
    public function mudaSit($aCert){
        foreach ($aCert as $key => $iCert) {
            $sSql="update steel_pcp_certificado set sitEmail='Env' where nrcert='".$iCert."'   ";
            $this->executaSql($sSql);
        }
    }

}
