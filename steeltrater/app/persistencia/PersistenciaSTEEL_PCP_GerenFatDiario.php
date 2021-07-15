<?php

/**
 * Classe que implementa a persistenca para gerar faturamento diário
 * 
 * @author Avanei Martendal
 * @since 20/02/2020
 */

class PersistenciaSTEEL_PCP_GerenFatDiario extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('');
    }
    
    public function getFatDiario($sDataini,$sDataFim,$sDisp){
        $PDOnew = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
        
        $sSql = 'BEGIN TRY '
                .'    drop table #SteelTraterFatRel ' 
                .' END TRY '
                .' BEGIN CATCH '
                .' END CATCH ';
        $aRetorno = $PDOnew->exec($sSql);
        
        $sSql = 'create table #SteelTraterFatRel ( '
		.'data date, '
		.'PesoInd money, /*Peso total de retorno de industrializacao NFS_NotaFiscalItemMovVenda=N*/ ' 
		.'ValorFat money,/*Valor total de faturamento NFS_NotaFiscalItemMovVenda=S*/ ' 
		.'ValorServico money, /*Valor total de serviço NFS_NotaFiscalItemMovVenda=S*/ '
		.'ValorInsumo money,  /*Valor total de insumo NFS_NotaFiscalItemMovVenda=S*/ '
		.' '
		.'PesoIndFio money, '  
		.'ValorServicoFio money, '
		.'ValorInsumoFio money, '
		.' '
		.'PesoIndAcab money, '
		.'ValorServicoAcab money,'
		.'ValorInsumoAcab money, '
		.')';
        $aRetorno = $PDOnew->exec($sSql);
        
        //INFORMA O PESO TOTAL PesoInd ***********************************************************
        $sSql = "insert into #SteelTraterFatRel(data,PesoInd) "
                ."select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
		."      SUM(pesoOp) as PesoInd "
                ."      from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq "
                ."      and pdv_insserv ='RETORNO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab(nolock) " 
                ."      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo " 
                ."      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ."   and NFS_NotaFiscalTipo ='S' "
                ."   and NFS_NotaFiscalSituacao ='C' "
                ."     and NFS_NotaFiscalCancelada ='N' "
                ." and NFS_NotaFiscalItemMovVenda='N' "
		." and PRO_GrupoCodigo between '0' and '9999' "
		." and PRO_SubGrupoCodigo between '0' and '99999' "
	        ." and PRO_FamiliaCodigo between '0' and '99999' "
		." and PRO_SubFamiliaCodigo between '0' and '99999' " 
		." and NFS_NotaFiscalTipoMovimento in (302) "
		." group by NFS_NotaFiscalDataEmissao "
		." order by NFS_NotaFiscalDataEmissao ";
        $aRetorno = $PDOnew->exec($sSql);
        
        //INFORMA PESO TOTAL ValorFat ********************************************************************
        $sSql = "insert into #SteelTraterFatRel(data,ValorFat) "
                ."select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
                ."      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorFat  "
                ."      from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq "  
                ."      and pdv_insserv ='RETORNO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
                ."      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo " 
                ."      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ." and NFS_NotaFiscalTipo ='S' "
                ." and NFS_NotaFiscalSituacao ='C' "
                ." and NFS_NotaFiscalCancelada ='N' "
                ." and NFS_NotaFiscalItemMovVenda='S' "
		." and PRO_GrupoCodigo between '0' and '9999' "
	        ." and PRO_SubGrupoCodigo between '0' and '99999' "
		." and PRO_FamiliaCodigo between '0' and '99999' "
		." and PRO_SubFamiliaCodigo between '0' and '99999' " 
		." and NFS_NotaFiscalTipoMovimento in (302) "  
		." group by NFS_NotaFiscalDataEmissao "
		." order by NFS_NotaFiscalDataEmissao ";
        $aRetorno = $PDOnew->exec($sSql);
        
     /*INFORMA PESO TOTAL ValorServico***********************************************************/

        $sSql = "insert into #SteelTraterFatRel(data,ValorServico) "
                ."              select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
                ."              (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorServico " 
                ."              from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."              on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."              and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."              on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."              and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."              and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq "  
                ."              and pdv_insserv ='RETORNO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
                ."              on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."              on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo " 
                ."              where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ."        and NFS_NotaFiscalTipo ='S' "
                ."        and NFS_NotaFiscalSituacao ='C' "
                ."        and NFS_NotaFiscalCancelada ='N' "
                ."        and NFS_NotaFiscalItemMovVenda='S' "
                ."			and PRO_GrupoCodigo between '100' and '100' "
                ."			and PRO_SubGrupoCodigo between '0' and '99999' "
                ."			and PRO_FamiliaCodigo between '0' and '99999' "
                ."			and PRO_SubFamiliaCodigo between '0' and '99999' " 
                ."			and NFS_NotaFiscalTipoMovimento in (302) " 
                ."			group by NFS_NotaFiscalDataEmissao"
                ."			order by NFS_NotaFiscalDataEmissao  "; 

                $aRetorno = $PDOnew->exec($sSql);
                
/*INFORMA PESO TOTAL ValorInsumo *********************************************************************/

        $sSql ="insert into #SteelTraterFatRel(data,ValorInsumo) "
        ."select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
        ."                      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorInsumo  "
        ."                      from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
        ."                      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
        ."                      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
        ."                      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
        ."                      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
        ."                      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq "  
        ."                      and pdv_insserv ='RETORNO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
        ."                      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
        ."                      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo "  
        ."                      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
        ."                and NFS_NotaFiscalTipo ='S' "
        ."                and NFS_NotaFiscalSituacao ='C' "
        ."                and NFS_NotaFiscalCancelada ='N' "
        ."                and NFS_NotaFiscalItemMovVenda='S' "
        ."                                and PRO_GrupoCodigo between '101' and '101' "
        ."                                and PRO_SubGrupoCodigo between '0' and '99999' "
        ."                                and PRO_FamiliaCodigo between '0' and '99999' "
        ."                                and PRO_SubFamiliaCodigo between '0' and '99999' " 
        ."                                and NFS_NotaFiscalTipoMovimento in (302) "  
        ."                                group by NFS_NotaFiscalDataEmissao "
        ."                                order by NFS_NotaFiscalDataEmissao ";      

        $aRetorno = $PDOnew->exec($sSql);
        
        /*INFORMA PESO TOTAL FIO MÁQUINA PesoIndFio**********************************************************/
        $sSql = "insert into #SteelTraterFatRel(data,PesoIndFio) "
        ."select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
        ."					  SUM(pesoOp) as PesoIndFio "
        ."					  from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
        ."                      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
        ."                      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
        ."                      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
        ."                      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
        ."                      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq  " 
        ."                      and pdv_insserv ='RETORNO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
        ."                      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO " 
        ."                      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo " 
        ."                      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
        ."                and NFS_NotaFiscalTipo ='S' "
        ."                and NFS_NotaFiscalSituacao ='C' "
        ."               and NFS_NotaFiscalCancelada ='N' "
        ."                and NFS_NotaFiscalItemMovVenda='N' "
        ."				and PRO_GrupoCodigo between '0' and '9999' "
        ."				and PRO_SubGrupoCodigo between '0' and '99999' "
        ."				and PRO_FamiliaCodigo between '0' and '99999' "
        ."				and PRO_SubFamiliaCodigo between '0' and '99999'  "
        ."				and NFS_NotaFiscalTipoMovimento in (302)  and tipoOrdem ='F' "
        ."				group by NFS_NotaFiscalDataEmissao "
        ."				order by NFS_NotaFiscalDataEmissao ";

         $aRetorno = $PDOnew->exec($sSql);
        
        /*INFORMA PESO TOTAL ValorServicoFio********************************************************/
        $sSql = "insert into #SteelTraterFatRel(data,ValorServicoFio) "
                ."select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
                ."      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorServicoFio  "
                ."       from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq  " 
                ."      and pdv_insserv ='SERVIÇO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab  "
                ."      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo  "
                ."     where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ."and NFS_NotaFiscalTipo ='S' "
                ."and NFS_NotaFiscalSituacao ='C' "
                ."and NFS_NotaFiscalCancelada ='N' "
                ."and NFS_NotaFiscalItemMovVenda='S' "
		."		and PRO_GrupoCodigo between '0' and '9999' "
		."		and PRO_SubGrupoCodigo between '0' and '99999' "
		."		and PRO_FamiliaCodigo between '0' and '99999' "
		."		and PRO_SubFamiliaCodigo between '0' and '99999'  "
		."		and NFS_NotaFiscalTipoMovimento in (302)  and tipoOrdem ='F' "
		."		group by NFS_NotaFiscalDataEmissao "
		."		order by NFS_NotaFiscalDataEmissao ";
         $aRetorno = $PDOnew->exec($sSql);
         
/*INFORMA PESO TOTAL ValorInsumoFio*************************************************/
        $sSql = "insert into #SteelTraterFatRel(data,ValorInsumoFio) "
                ."select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
                ."      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorServicoFio  "
                ."       from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq "  
                ."      and pdv_insserv ='INSUMO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
                ."      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo  "
                ."      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ." and NFS_NotaFiscalTipo ='S' "
                ." and NFS_NotaFiscalSituacao ='C' "
                ." and NFS_NotaFiscalCancelada ='N' "
                ." and NFS_NotaFiscalItemMovVenda='S' "
		."		and PRO_GrupoCodigo between '0' and '9999' "
		."		and PRO_SubGrupoCodigo between '0' and '99999' "
		."		and PRO_FamiliaCodigo between '0' and '99999' "
		."		and PRO_SubFamiliaCodigo between '0' and '99999' " 
		."		and NFS_NotaFiscalTipoMovimento in (302)  and tipoOrdem ='F' "
		."		group by NFS_NotaFiscalDataEmissao "
		."		order by NFS_NotaFiscalDataEmissao ";
        $aRetorno = $PDOnew->exec($sSql);
        
        /*INFORMA PESO TOTAL PesoIndAcab***********************************************************/
     $sSql ="insert into #SteelTraterFatRel(data,PesoIndAcab) "
	    ."       select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
            ."          /*(SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as PesoIndAcab */ "
            ."          SUM(pesoOp) as PesoInd   "
            ."          from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
            ."          on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
            ."          and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
            ."          on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
            ."          and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
            ."          and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq  " 
            ."          and pdv_insserv ='RETORNO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab  "
            ."          on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO  "
            ."          on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo " 
            ."          where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
            ."    and NFS_NotaFiscalTipo ='S' "
            ."    and NFS_NotaFiscalSituacao ='C' "
            ."    and NFS_NotaFiscalCancelada ='N' "
            ."    and NFS_NotaFiscalItemMovVenda='N' "
	    ."			and PRO_GrupoCodigo between '0' and '9999' "
	    ."			and PRO_SubGrupoCodigo between '0' and '99999' "
	    ."			and PRO_FamiliaCodigo between '0' and '99999' "
	    ."			and PRO_SubFamiliaCodigo between '0' and '99999' " 
	    ."			and NFS_NotaFiscalTipoMovimento in (302)  and tipoOrdem ='P'  "
	    ."		        group by NFS_NotaFiscalDataEmissao "
	    ."		        order by NFS_NotaFiscalDataEmissao ";
        
        $aRetorno = $PDOnew->exec($sSql);
        
        /*INFORMA PESO TOTAL ValorServicoAcab***************************************************/ 
        $sSql = "insert into #SteelTraterFatRel(data,ValorServicoAcab) "
		."		select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
                ."      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorServicoAcab  "  
                ."      from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq "  
                ."      and pdv_insserv ='SERVIÇO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
                ."      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo " 
                ."      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ." and NFS_NotaFiscalTipo ='S' "
                ." and NFS_NotaFiscalSituacao ='C' "
                ." and NFS_NotaFiscalCancelada ='N' "
                ." and NFS_NotaFiscalItemMovVenda='S' "
		."		and PRO_GrupoCodigo between '0' and '9999' "
		."		and PRO_SubGrupoCodigo between '0' and '99999' "
		."		and PRO_FamiliaCodigo between '0' and '99999' "
		."		and PRO_SubFamiliaCodigo between '0' and '99999'  "
		."		and NFS_NotaFiscalTipoMovimento in (302)  and tipoOrdem ='P'"
		."		group by NFS_NotaFiscalDataEmissao "
		."		order by NFS_NotaFiscalDataEmissao ";
        
        $aRetorno = $PDOnew->exec($sSql);
        
        /*INFORMA PESO TOTAL ValorInsumoAcab****************************************************/ 
        $sSql = "insert into #SteelTraterFatRel(data,ValorInsumoAcab) "
		."		select convert(varchar,NFS_NotaFiscalDataEmissao,103) as data, "
                ."      (SUM(NFS_NotaFiscalItemValorTotal)-SUM(NFS_NotaFiscalItemDesconto)) as ValorInsumoAcab  "    
                ."      from metalbobase.dbo.NFS_NOTAFISCAL(nolock) left outer join metalbobase.dbo.NFS_NOTAFISCALITEM(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalFilial = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCAL.NFS_NotaFiscalSeq = metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalSeq left outer join metalbobase.dbo.STEEL_PCP_CargaInsumoServ(nolock) "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalFilial = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidofilial "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoCodigo = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo "
                ."      and metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemPedidoItemSe = metalbobase.dbo.STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq  "  
                ."      and pdv_insserv ='INSUMO' left outer join metalbobase.dbo.STEEL_PCP_ordensFab "
                ."      on metalbobase.dbo.STEEL_PCP_CargaInsumoServ.op = metalbobase.dbo.STEEL_PCP_ordensFab.op left outer join metalbobase.dbo.PRO_PRODUTO "
                ."      on metalbobase.dbo.NFS_NOTAFISCALITEM.NFS_NotaFiscalItemProduto = metalbobase.dbo.PRO_PRODUTO.PRO_Codigo  "
                ."      where NFS_NotaFiscalDataEmissao between '".$sDataini."' and '".$sDataFim."' "
                ." and NFS_NotaFiscalTipo ='S' "
                ." and NFS_NotaFiscalSituacao ='C' "
                ." and NFS_NotaFiscalCancelada ='N' "
                ." and NFS_NotaFiscalItemMovVenda='S' "
		."		and PRO_GrupoCodigo between '0' and '9999' "
		."		and PRO_SubGrupoCodigo between '0' and '99999' "
		."		and PRO_FamiliaCodigo between '0' and '99999' "
		."		and PRO_SubFamiliaCodigo between '0' and '99999'  "
		."		and NFS_NotaFiscalTipoMovimento in (302)  and tipoOrdem ='P' "
		."		group by NFS_NotaFiscalDataEmissao "
		."		order by NFS_NotaFiscalDataEmissao ";
        
        $aRetorno = $PDOnew->exec($sSql);
        
        //gera o array de dados
        
        //gera array do total
        $sSql = "select CONVERT(varchar,data,103)as dataChar,data, "
                ."      SUM(coalesce(PesoInd,0))as PesoInd, "
                ."      SUM(coalesce(ValorFat,0))as ValorFat,  "
                ."      SUM(coalesce(ValorServico,0))as ValorServico, "
                ."      SUM(coalesce(ValorInsumo,0))as ValorInsumo, "
                ."      SUM(coalesce(PesoIndFio,0))as PesoIndFio, "
                ."     /* SUM(coalesce(ValorFatFio,0))as ValorFatFio, */ "
                ."      SUM(coalesce(ValorServicoFio,0))as ValorServicoFio, "
                ."      SUM(coalesce(ValorInsumoFio,0))as ValorInsumoFio, "
                ."      SUM(coalesce(PesoIndAcab,0))as PesoIndAcab, "
                ."     /* SUM(coalesce(ValorFatAcab,0))as ValorFatAcab, */"
                ."      SUM(coalesce(ValorServicoAcab,0))as ValorServicoAcab, "
                ."      SUM(coalesce(ValorInsumoAcab,0))as ValorInsumoAcab "
                ."      from #SteelTraterFatRel "
                ."      group by data "
                ."      order by data desc";
        $result = $PDOnew->query($sSql);
        $aDados = array();
        $aDadosGrid = array();
        //se dispositivo celular já formata os valores
        if($sDisp=='celular'){
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $aDados['dataChar'] = $row['dataChar'];
                $aDados['PesoInd'] = number_format($row['PesoInd'],2,',','.');//$row['PesoInd'];
                $aDados['ValorFat'] = number_format($row['ValorFat'],2,',','.');
                $aDados['ValorServico'] = number_format($row['ValorServico'],2,',','.');
                $aDados['ValorInsumo'] = number_format($row['ValorInsumo'],2,',','.');
                $aDados['PesoIndFio'] = number_format($row['PesoIndFio'],2,',','.');
                $aDados['ValorServicoFio'] = number_format($row['ValorServicoFio'],2,',','.');
                $aDados['ValorInsumoFio'] = number_format($row['ValorInsumoFio'],2,',','.');
                $aDados['PesoIndAcab'] = number_format($row['PesoIndAcab'],2,',','.');
                $aDados['ValorServicoAcab'] = number_format($row['ValorServicoAcab'],2,',','.');
                $aDados['ValorInsumoAcab'] = number_format($row['ValorInsumoAcab'],2,',','.');
                $aDadosGrid['grid'][] = $aDados;
            }
        }else{
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $aDados['dataChar'] = $row['dataChar'];
                $aDados['PesoInd'] = $row['PesoInd'];//number_format($row['PesoInd'],2,',','.');//$row['PesoInd'];
                $aDados['ValorFat'] = $row['ValorFat'];
                $aDados['ValorServico'] = $row['ValorServico'];
                $aDados['ValorInsumo'] = $row['ValorInsumo'];
                $aDados['PesoIndFio'] = $row['PesoIndFio'];
                $aDados['ValorServicoFio'] = $row['ValorServicoFio'];
                $aDados['ValorInsumoFio'] = $row['ValorInsumoFio'];
                $aDados['PesoIndAcab'] = $row['PesoIndAcab'];
                $aDados['ValorServicoAcab'] = $row['ValorServicoAcab'];
                $aDados['ValorInsumoAcab'] = $row['ValorInsumoAcab'];
                $aDadosGrid['grid'][] = $aDados;
            }
        }
        //retorna o somatório
        $sSqlSoma = "select SUM(coalesce(ValorFat,0))as ValorFat, "
                   ." SUM(coalesce(ValorServico,0))as ValorServico, "
                   ." SUM(coalesce(ValorInsumo,0))as ValorInsumo, "
                    ." SUM(coalesce(PesoInd,0))as PesoInd, "
                   ." SUM(coalesce(PesoIndAcab,0)) as PesoIndAcab, "
                   ." SUM(coalesce(PesoIndFio,0))as PesoIndFio "
                   ."  from #SteelTraterFatRel ";
        $resultSoma = $PDOnew->query($sSqlSoma);
        while ($row = $resultSoma->fetch(PDO::FETCH_ASSOC)){
           $aDadosGrid['Total']['ValorFat'] = $row['ValorFat'];
           $aDadosGrid['Total']['ValorServico'] = $row['ValorServico'];
           $aDadosGrid['Total']['ValorInsumo'] = $row['ValorInsumo'];
           
           $aDadosGrid['Total']['PesoInd'] = $row['PesoInd'];
           $aDadosGrid['Total']['PesoIndAcab'] = $row['PesoIndAcab'];
           $aDadosGrid['Total']['PesoIndFio'] = $row['PesoIndFio'];
        }
        
        return $aDadosGrid;
        
    }
}
