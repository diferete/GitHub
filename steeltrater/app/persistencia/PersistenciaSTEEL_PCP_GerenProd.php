<?php

/* 
 * Classe que gerencia produção steeltrater
 * @author Avanei Martendal
 * @since 27/08/2019
 */

Class PersistenciaSTEEL_PCP_GerenProd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_ordensFabApont');
    }
    
    
    public function geraGerenProd($aDados){
        $sSqlDados =' select ';
        //campos listados
        if($aDados['busca'] =='ProdTotal'){
            $sSqlDados .= " sum(STEEL_PCP_ordensFab.peso) as pesoTotal ";
        }
        //se busca por producao de forno
        if($aDados['busca'] =='ProdForno'){
            $sSqlDados .= " fornodes,sum(STEEL_PCP_ordensFab.peso) as pesoTotal ";
        }
        //busca nas tabelas
            $sSqlDados .= " from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
               on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op ";
            
        //condições
            $sSqlDados .= "where dataent_forno between '".$aDados['dataini']."' and '".$aDados['datafin']."' 
					and STEEL_PCP_ordensFabApont.situacao='Finalizado'  
					and retrabalho<>'Retorno não Ind.'";
            if(isset($aDados['tipoOp'])){
             $sSqlDados .=" and STEEL_PCP_ordensFab.tipoOrdem IN ('".$aDados['tipoOp']."') ";   
            }
        //agrupamentos necessário
             if($aDados['busca'] =='ProdForno'){
             $sSqlDados .= " 	group by fornodes,fornocod order by fornocod  ";
            }
            
            $result = $this->getObjetoSql($sSqlDados);
            
            while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            if($aDados['busca']=='ProdTotal'){
                 $aRetorno['pesoTotal'] = $oRowBD->pesototal;
               }
            if($aDados['busca'] =='ProdForno'){
                $aRetorno[$oRowBD->fornodes] = $oRowBD->pesototal;
            }
        }
        
        //faz o retorno dos dados
        return $aRetorno;
        
        
        
        
        
        
    }
}
