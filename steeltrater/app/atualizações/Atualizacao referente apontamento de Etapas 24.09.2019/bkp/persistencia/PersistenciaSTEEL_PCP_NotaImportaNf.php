<?php

/* 
 * Implementa classe para gerar ordes de fabricação a partir de uma nf saída metalbo
 * 
 * @author Avanei Martendal
 * 
 * @since 02/07/2018
 */

class PersistenciaSTEEL_PCP_NotaImportaNf extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_importaNf');
        
        $this->adicionaRelacionamento('nfsnfnro', 'nfsnfnro',true,true);
        $this->adicionaRelacionamento('nfsnfser', 'nfsnfser',true,true);
        $this->adicionaRelacionamento('nfsitseq', 'nfsitseq',true,true);
        $this->adicionaRelacionamento('nfsitcod', 'nfsitcod');
        $this->adicionaRelacionamento('nfsitdes', 'nfsitdes');
        $this->adicionaRelacionamento('nfsitun', 'nfsitun');
        $this->adicionaRelacionamento('nfsitqtd', 'nfsitqtd');
        $this->adicionaRelacionamento('nfsclicgc', 'nfsclicgc');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('nfsdtemiss', 'nfsdtemiss');
        
        $this->adicionaRelacionamento('RoeNro', 'RoeNro');
        $this->adicionaRelacionamento('metof', 'metof');
        $this->adicionaRelacionamento('metpesocarg', 'metpesocarg');
        $this->adicionaRelacionamento('metmat', 'metmat');
        $this->adicionaRelacionamento('RoeObs', 'RoeObs');
        $this->adicionaRelacionamento('opSteel', 'opSteel');
        
        
        
        
        
        $this->adicionaOrderBy('nfsnfnro');
        $this->adicionaOrderBy('nfsitcod');
        
        $this->setSTop('300');
       
        
       
    }
    
    public function atualiaOPnf($aCampos){
        
        $sSql = "update STEEL_PCP_importaNf  "
                . "set opSteel = '".$aCampos['op']."' "
                . "where nfsnfnro =".$aCampos['nfsnfnro']." and nfsitseq =".$aCampos['nfsitseq']."";
        
        $aRetorno = $this->executaSql($sSql);
        
    }
    //funcao para importar notas para emitir ordem de produção
    public function importaNfRomaneio($aCampos){
        $sqlCount = "select COUNT(*)as nr "
                    ."from rex_maquinas.widl.NEC0401 left outer join rex_maquinas.widl.NEC040 "
                    ."on rex_maquinas.widl.NEC0401.filcgc =rex_maquinas.widl.NEC040.filcgc "
                    ."and rex_maquinas.widl.NEC0401.RoeNro = rex_maquinas.widl.NEC040.RoeNro "
                    ."where rex_maquinas.widl.NEC040.RoeNroNf ='".$aCampos[1]."'";
        
        $result = $this->getObjetoSql($sqlCount);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $iCont = $row->nr;
        
        if($iCont>0){
         $sSql = "insert into STEEL_PCP_importaNf "
         ."select rex_maquinas.widl.NEC040.RoeNroNf,"
         ."  '2' as serie,"
         ."rex_maquinas.widl.NEC0401.RoeSeq,"
         ."rex_maquinas.widl.NEC0401.procod,"
         ."rex_maquinas.widl.prod01.prodes,rex_maquinas.widl.prod01.pround,"
         ."rex_maquinas.widl.NEC0401.RoeQtdReal,"
         ."rex_maquinas.widl.NEC0401.filcgc, "
         ."'METALBO INDUSTRIA DE FIXADORES METALICOS LTDA' as empdes,"
         ."rex_maquinas.widl.NEC040.RoeData,"
         ."rex_maquinas.widl.NEC0401.RoeNro,"
         ."rex_maquinas.widl.NEC0401.metof, "
         ."rex_maquinas.widl.NEC0401.metpesocarg,rex_maquinas.widl.NEC0401.metmat,"
         ."rex_maquinas.widl.NEC040.RoeObs,'' as opSteel "
         ."from rex_maquinas.widl.NEC0401 left outer join rex_maquinas.widl.NEC040 "
         ."on rex_maquinas.widl.NEC0401.filcgc =rex_maquinas.widl.NEC040.filcgc  "
         ."and rex_maquinas.widl.NEC0401.RoeNro = rex_maquinas.widl.NEC040.RoeNro "
         ."left outer join rex_maquinas.widl.prod01 "
         ."on rex_maquinas.widl.NEC0401.procod = rex_maquinas.widl.prod01.procod "
         ."where rex_maquinas.widl.NEC040.RoeNroNf ='".$aCampos[1]."' "
         ."order by rex_maquinas.widl.NEC0401.procod ";
         $aRetorno = $this->executaSql($sSql);
         return $aRetorno;
        }else
        {
            $aRetorno[0]=false;
            return $aRetorno;
        }
        
    }
     /*    $sqlCount = "select COUNT(*)as nr "
                    ."from metalbo.widl.NEC0401 left outer join metalbo.widl.NEC040 "
                    ."on metalbo.widl.NEC0401.filcgc =metalbo.widl.NEC040.filcgc "
                    ."and metalbo.widl.NEC0401.RoeNro = metalbo.widl.NEC040.RoeNro "
                    ."where metalbo.widl.NEC040.RoeNroNf ='".$aCampos[1]."'";
        
        $result = $this->getObjetoSql($sqlCount);
        $row = $result->fetch(PDO::FETCH_OBJ);
        
        $iCont = $row->nr;
        
        if($iCont>0){
         $sSql = "insert into STEEL_PCP_importaNf "
         ."select metalbo.widl.NEC040.RoeNroNf,"
         ."  '2' as serie,"
         ."metalbo.widl.NEC0401.RoeSeq,"
         ."metalbo.widl.NEC0401.procod,"
         ."metalbo.widl.prod01.prodes,metalbo.widl.prod01.pround,"
         ."metalbo.widl.NEC0401.RoeQtdReal,"
         ."metalbo.widl.NEC0401.filcgc, "
         ."'METALBO INDUSTRIA DE FIXADORES METALICOS LTDA' as empdes,"
         ."metalbo.widl.NEC040.RoeData,"
         ."metalbo.widl.NEC0401.RoeNro,"
         ."metalbo.widl.NEC0401.metof, "
         ."metalbo.widl.NEC0401.metpesocarg,metalbo.widl.NEC0401.metmat,"
         ."metalbo.widl.NEC040.RoeObs,'' as opSteel "
         ."from metalbo.widl.NEC0401 left outer join metalbo.widl.NEC040 "
         ."on metalbo.widl.NEC0401.filcgc =metalbo.widl.NEC040.filcgc  "
         ."and metalbo.widl.NEC0401.RoeNro = metalbo.widl.NEC040.RoeNro "
         ."left outer join metalbo.widl.prod01 "
         ."on metalbo.widl.NEC0401.procod = metalbo.widl.prod01.procod "
         ."where metalbo.widl.NEC040.RoeNroNf ='".$aCampos[1]."' "
         ."order by metalbo.widl.NEC0401.procod ";
         $aRetorno = $this->executaSql($sSql);
         return $aRetorno;
        }else
        {
            $aRetorno[0]=false;
            return $aRetorno;
        }
        
    }*/
    
}

