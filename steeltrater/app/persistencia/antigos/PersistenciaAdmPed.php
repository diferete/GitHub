<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaAdmPed extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('metpedonlineShow');
        
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('nr', 'nr');
        $this->adicionaRelacionamento('peso', 'peso');
        $this->adicionaRelacionamento('contpeso', 'contpeso');
        $this->adicionaRelacionamento('vlr', 'vlr');
        $this->adicionaRelacionamento('ipi', 'ipi');
        $this->adicionaRelacionamento('vlrcomipi', 'vlrcomipi');
        $this->adicionaRelacionamento('contvlr', 'contvlr');
        $this->adicionaRelacionamento('mediaSipi', 'mediaSipi');
        $this->adicionaRelacionamento('mediaCipi', 'mediaCipi');//datahora
        $this->adicionaRelacionamento('datahora', 'datahora');
        $this->setBConsultaManual(true);
        $this->adicionaOrderBy('data',1);
    }
    
     public function consultaManual() {
        parent::consultaManual();
        
        $sSql = "select metpedonlineShow.data as 'metpedonlineShow.data', 
                metpedonlineShow.nr as 'metpedonlineShow.nr',
                metpedonlineShow.peso as 'metpedonlineShow.peso', 
                (select SUM(peso)from metpedonlineShow ped2 where metpedonlineShow.seq >= ped2.seq)as 'metpedonlineShow.contpeso', 
                metpedonlineShow.vlr as 'metpedonlineShow.vlr',
                metpedonlineShow.ipi as 'metpedonlineShow.ipi',
                metpedonlineShow.vlrcompipi as 'metpedonlineShow.vlrcomipi', 
                (select SUM(vlrcompipi)from metpedonlineShow ped2 
                where metpedonlineShow.seq >= ped2.seq)as 'metpedonlineShow.contvlr',
                (vlr / peso) as 'metpedonlineShow.mediaSipi',
                (vlrcompipi / peso) as 'metpedonlineShow.mediaCipi',
                metpedonlineShow.datahora as 'metpedonlineShow.datahora'
                from metpedonlineShow ";
        return $sSql;
    }
    
     public function fatPed($DataInicial,$DataFinal) {
        parent::consultaManual();
        
        if(empty($DataInicial)){
            $sDataInicial = Util::getPrimeiroDiaMes();
        }else{
            $sDataInicial = $DataInicial;
        }
        
        if(empty($DataFinal)){
            $sDataFinal = Util::getUltimoDiaMes();
        
        }else{
            $sDataFinal = $DataFinal;
        }
        
        $sSql = "select metpedonlineShow.data as 'metpedonlineShow.data', 
                metpedonlineShow.nr as 'metpedonlineShow.nr',
                metpedonlineShow.peso as 'metpedonlineShow.peso', 
                (select SUM(peso)from metpedonlineShow ped2 where metpedonlineShow.seq >= ped2.seq and DATA between '".$sDataInicial."' and '".$sDataFinal."' )as 'metpedonlineShow.contpeso', 
                metpedonlineShow.vlr as 'metpedonlineShow.vlr',
                metpedonlineShow.ipi as 'metpedonlineShow.ipi',
                metpedonlineShow.vlrcompipi as 'metpedonlineShow.vlrcomipi', 
                (select SUM(vlrcompipi)from metpedonlineShow ped2 
                where metpedonlineShow.seq >= ped2.seq and DATA between '".$sDataInicial."' and '".$sDataFinal."' )as 'metpedonlineShow.contvlr',
                (vlr / peso) as 'metpedonlineShow.mediaSipi',
                (vlrcompipi / peso) as 'metpedonlineShow.mediaCipi',
                metpedonlineShow.datahora as 'metpedonlineShow.datahora'
                from metpedonlineShow where DATA between '".$sDataInicial."' and '".$sDataFinal."' order by data desc";
        
        $result = $this->getObjetoSql($sSql);
        
        while($oRowBD = $result->fetch(PDO::FETCH_OBJ)){
            $oModel = $this->getNewModel();
            
            $this->carregaModelBanco($oModel,$oRowBD);

            //adiciona o objeto atual ao array de retorno
            $aRetorno[] = $oModel;
        }
        return $aRetorno;
       
    }
    
}
