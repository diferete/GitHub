<?php

/* 
 * Classe que implementa a controller da SatisClientePesq
 * 
 * @author Avanei Martendal
 * @since 15/01/2018
 */

class ControllerSatisClientePesqShow extends Controller{
    public function __construct() {
        
        $this->carregaClassesMvc('SatisClientePesqShow');
        
       
    }
    
     /**
     * gera dados de um segundo grid
     */
    public function getDadosGridDetalheShow($sDados,$sChave){
        
       $aDados = explode(',', $sChave);
       $sChaveNew = htmlspecialchars_decode($aDados[0]);
       $aCamposChave = array();
       parse_str($sChaveNew,$aCamposChave);
       
       $this->Persistencia->adicionaFiltro('filcgc',$aCamposChave['filcgc']);
       $this->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
       $this->getDadosConsulta($sDados,true,null,null, null);
        
       /* $aDados = explode(',',$sChave);
        $aParam = explode('=', $aDados[0]);
        $this->Persistencia->adicionaFiltro($aParam[0],$aParam[1]);
        $this->antesDetalhe($aParam[1]);
        $this->getDadosConsulta($sDados,true,null,null, null);*/
    }
}

