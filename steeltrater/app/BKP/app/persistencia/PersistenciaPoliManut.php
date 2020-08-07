<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaPoliManut extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbpolimanut');
        
        $this->adicionaRelacionamento('nr', 'nr', true,true,true);
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('codmaq', 'PoliCadMaq.codmaq');
        $this->adicionaRelacionamento('problema', 'problema');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('solucao', 'solucao');
        $this->adicionaRelacionamento('mecanico', 'mecanico');
        $this->adicionaRelacionamento('consumo', 'consumo');
        $this->adicionaRelacionamento('previsao', 'previsao');
        
        $this->adicionaJoin('PoliCadMaq');
        $this->adicionaOrderBy('nr',1);
        $this->setSTop('50');
    }
    public function apontaInicio($aDados){
        
        $sSql = "update tbpolimanut set situaca = 'Iniciada' where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
     public function apontaAberta($aDados){
        
        $sSql = "update tbpolimanut set situaca = 'Aberta' where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
     public function cancela($aDados){
        
        $sSql = "update tbpolimanut set situaca = 'Cancelada' where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
    
    public function enc($aDados){
        $nome = $_SESSION['nome'];
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update tbpolimanut set situaca = 'Encerrada', "
                ."userenc ='".$nome."', "
                ."dataenc ='".Util::getDataAtual()."', "
                ."horaenc ='".date('H:i')."'  where nr =".$aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
        
    }
}
