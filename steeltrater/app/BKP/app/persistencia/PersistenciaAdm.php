<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaAdm extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('metfat_metalbo');
        
        $this->adicionaRelacionamento('data', 'data',true,true);
        
        $this->adicionaRelacionamento('vlrliquido', 'vlrliquido');
//        
//        $this->adicionaRelacionamento('vlrliquido', 'vlrliquido');
        $this->adicionaRelacionamento('vlripi', 'vlripi');
        $this->adicionaRelacionamento('exportacao', 'exportacao');
        $this->adicionaRelacionamento('sucata', 'sucata');
        $this->adicionaRelacionamento('devolucao', 'devolucao');
        $this->adicionaRelacionamento('pesodev', 'pesodev');
        $this->adicionaRelacionamento('pesoliquido', 'pesoliquido');
        $this->adicionaRelacionamento('mediaSipi', 'mediaSipi');
        $this->adicionaRelacionamento('mediaCipi', 'mediaCipi');
        
        $this->adicionaOrderBy('data', 1);
        $this->setBConsultaManual(true);
    }
    
    public function consultaManual() {
        parent::consultaManual();
        
        $sSql = "select  metfat_metalbo.data AS 'metfat_metalbo.data',
        (vlrLiquido - Exportacao - Sucata) as 'metfat_metalbo.vlrliquido',
        metfat_metalbo.vlripi as 'metfat_metalbo.vlripi',
        metfat_metalbo.exportacao as 'metfat_metalbo.exportacao',
        metfat_metalbo.sucata as 'metfat_metalbo.sucata',
        metfat_metalbo.devolucao as 'metfat_metalbo.devolucao',
        metfat_metalbo.pesodev as 'metfat_metalbo.pesodev',
        (Pesotudo - PesoSucata - pesodev) as 'metfat_metalbo.PesoLiquido',
        ((vlrliquido - sucata)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaSipi',
        ((vlrliquido - sucata + vlripi)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaCipi' 
        from metfat_metalbo ";
        return $sSql;
    }
    
    

        public function fatMobile($DataInicial, $DataFinal) {
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



            $sSql = "select  metfat_metalbo.data AS 'metfat_metalbo.data',
            (vlrLiquido - Exportacao - Sucata) as 'metfat_metalbo.vlrliquido',
            metfat_metalbo.vlripi as 'metfat_metalbo.vlripi',
            metfat_metalbo.exportacao as 'metfat_metalbo.exportacao',
            metfat_metalbo.sucata as 'metfat_metalbo.sucata',
            metfat_metalbo.devolucao as 'metfat_metalbo.devolucao',
            metfat_metalbo.pesodev as 'metfat_metalbo.pesodev',
            (Pesotudo - PesoSucata - pesodev) as 'metfat_metalbo.PesoLiquido',
            ((vlrliquido - sucata)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaSipi',
            ((vlrliquido - sucata + vlripi)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaCipi' 
            from metfat_metalbo where DATA between '".$sDataInicial."' and '".$sDataFinal."' 
            order by data desc ";

            $result = $this->getObjetoSql($sSql);

            while($oRowBD = $result->fetch(PDO::FETCH_OBJ)){
                $oModel = $this->getNewModel();

                $this->carregaModelBanco($oModel,$oRowBD);

                //adiciona o objeto atual ao array de retorno
                $aRetorno[] = $oModel;
            }
            return $aRetorno;
       
    }
    
    public function getTotalizadores(){
        $sSql =  "select  metfat_metalbo.data AS 'metfat_metalbo.data', "
            ."(vlrLiquido - Exportacao - Sucata) as 'metfat_metalbo.vlrliquido', "
            ."metfat_metalbo.vlripi as 'metfat_metalbo.vlripi', "
            ."metfat_metalbo.exportacao as 'metfat_metalbo.exportacao', "
            ."metfat_metalbo.sucata as 'metfat_metalbo.sucata', "
            ."metfat_metalbo.devolucao as 'metfat_metalbo.devolucao', " 
            ."metfat_metalbo.pesodev as 'metfat_metalbo.pesodev', "
            ."(Pesotudo - PesoSucata - pesodev) as 'metfat_metalbo.PesoLiquido', " 
            ."((vlrliquido - sucata)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaSipi', "
            ."((vlrliquido - sucata + vlripi)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaCipi' "
            ."from metfat_metalbo where DATA = '".Util::getDataAtual()."' order by data desc ";

        
//                "select  metfat_metalbo.data AS 'metfat_metalbo.data', "
//                ."metfat_metalbo.vlrLiquido as 'metfat_metalbo.vlr', "
//                ."metfat_metalbo.Pesotudo as 'metfat_metalbo.Pesotudo', "
//                ."(Pesotudo - PesoSucata - pesodev) as 'metfat_metalbo.PesoLiquido', "
//                ."((vlrliquido - sucata)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaSipi', "
//                ."((vlrliquido - sucata + vlripi)/(Pesotudo - PesoSucata - pesodev))as 'metfat_metalbo.mediaCipi' "
//                ."from metfat_metalbo where DATA = '".Util::getDataAtual()."' order by data desc ";
        
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