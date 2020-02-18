<?php

/* 
 * Classe que gerencia a persistencia do faturamento gerencial
 * @author Avanei Martendal
 * @since 05/08/2019
  */

class PersistenciaSTEEL_PCP_GerenFat extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('');
    }
    
    public function geraGerenFat($aDados){
        $sSqlDados ='';
        //busca os dados conforme dados selecionados
        if($aDados['busca']=='FatPeso'){
                $sSqlDados = "select SUM(pesoOp) as pesoop,
                      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as valortotalvenda ";
         }
        
        //query padrão das tabelas
        $sSqlTab =" from NFS_NOTAFISCAL(nolock) left outer join NFS_NOTAFISCALITEM(nolock)
                      on NFS_NOTAFISCAL.NFS_NotaFiscalFilial = NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial
                      and NFS_NOTAFISCAL.NFS_NotaFiscalSeq = NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join STEEL_PCP_CargaInsumoServ(nolock)
                      on NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                      and NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                      and NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq ";
        if(isset($aDados['tipoRet'])){
            $sTipoRet =$aDados['tipoRet'];
        }else{
            $sTipoRet='RETORNO';
        }
        $sSqlTab .="  and pdv_insserv ='".$sTipoRet."' left outer join STEEL_PCP_ordensFab 
                      on STEEL_PCP_CargaInsumoServ.op = STEEL_PCP_ordensFab.op left outer join PRO_PRODUTO 
                      on NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = PRO_PRODUTO.PRO_Codigo ";
       
        
        //busca conforme filtros selecionados 
        $sSqlWhere = " where NFS_NotaFiscalDataEmissao between '".$aDados['dataini']."' and '".$aDados['datafin']."'
                and NFS_NotaFiscalTipo ='S'
                and NFS_NotaFiscalSituacao ='C'
                and NFS_NotaFiscalCancelada ='N' 
                and NFS_NotaFiscalItemMovVenda='".$aDados['finan']."'
				and PRO_GrupoCodigo between '".$aDados['grupoini']."' and '".$aDados['grupofin']."' 
				and PRO_SubGrupoCodigo between '0' and '99999' 
				and PRO_FamiliaCodigo between '0' and '99999' 
				and PRO_SubFamiliaCodigo between '0' and '99999'  
				and NFS_NotaFiscalTipoMovimento in (302) ";
         if(isset($aDados['tipoOrdem'])){
          $sSqlWhere .=" and tipoOrdem ='".$aDados['tipoOrdem']."' ";   
        }
        
        //faz a junção para retornar array de objetos
        $sSqlGera = $sSqlDados;
        $sSqlGera .=$sSqlTab; 
        $sSqlGera .=$sSqlWhere;
        $result = $this->getObjetoSql($sSqlGera);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            if($aDados['busca']=='FatPeso'){
               $aRetorno['PesoOp'] = $oRowBD->pesoop;
               $aRetorno['ValorTotalVenda'] = $oRowBD->valortotalvenda;
            }
        }
        
        //faz o retorno dos dados
        return $aRetorno;
        
    }
}


