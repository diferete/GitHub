<?php

/* 
 * Classe que implementa a persistencia de STEEL_PCP_ProdutoFilial
 * 
 * @author Cleverton Hoffmann
 * @since 15/02/2019
 */

class PersistenciaSTEEL_PCP_ProdutoFilial extends Persistencia{
    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRODUTOFILIAL');

        $this->adicionaRelacionamento('pro_produtofilialgrupotipo','pro_produtofilialgrupotipo');
        
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo',true);  
        $this->adicionaRelacionamento('fil_codigo', 'DELX_FIL_Empresa.fil_codigo');  
              
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true);  
        $this->adicionaRelacionamento('pro_codigo', 'DELX_PRO_Produtos.pro_codigo');
                
        $this->adicionaRelacionamento('pro_filialdtbloqueado', 'pro_filialdtbloqueado');
        $this->adicionaRelacionamento('pro_filialmotivobloqueio', 'pro_filialmotivobloqueio');
        $this->adicionaRelacionamento('pro_filialestoque', 'pro_filialestoque');
        $this->adicionaRelacionamento('pro_filialnegativo', 'pro_filialnegativo');
        $this->adicionaRelacionamento('pro_filialestminimo', 'pro_filialestminimo');
        $this->adicionaRelacionamento('pro_filialestminimodias', 'pro_filialestminimodias');
        $this->adicionaRelacionamento('pro_filialestpontorep', 'pro_filialestpontorep');
        $this->adicionaRelacionamento('pro_filialestmaximo', 'pro_filialestmaximo');
        $this->adicionaRelacionamento('pro_filialestmaximodias', 'pro_filialestmaximodias');
        $this->adicionaRelacionamento('pro_filialdtinventariorota', 'pro_filialdtinventariorota');
        $this->adicionaRelacionamento('pro_filialitemcomposto', 'pro_filialitemcomposto');
        $this->adicionaRelacionamento('pro_filialcontrolasaldo', 'pro_filialcontrolasaldo');
        $this->adicionaRelacionamento('pro_filialreservaestoqueestrut', 'pro_filialreservaestoqueestrut');
        $this->adicionaRelacionamento('pro_filialquantidademultpadrao', 'pro_filialquantidademultpadrao');
        $this->adicionaRelacionamento('pro_filialqtdprodutividade', 'pro_filialqtdprodutividade');
        $this->adicionaRelacionamento('pro_filialveiculo', 'pro_filialveiculo');
        
        
        //Compras
        $this->adicionaRelacionamento('pro_filialprioridade', 'pro_filialprioridade');
        $this->adicionaRelacionamento('pro_filialcomprador', 'pro_filialcomprador');
        $this->adicionaRelacionamento('pro_filialcomprapercdifvalor', 'pro_filialcomprapercdifvalor');
        $this->adicionaRelacionamento('pro_filialcomprapercdifqtd', 'pro_filialcomprapercdifqtd');
    
        //MRP
        $this->adicionaRelacionamento('pro_filialmrpplanejamento', 'pro_filialmrpplanejamento');
        $this->adicionaRelacionamento('pro_filialmrptipoordem', 'pro_filialmrptipoordem');
        $this->adicionaRelacionamento('pro_filialmrpdiascompra', 'pro_filialmrpdiascompra');
        $this->adicionaRelacionamento('pro_filialmrpdiasproducao', 'pro_filialmrpdiasproducao');
        $this->adicionaRelacionamento('pro_filialmrpdiasqualidade', 'pro_filialmrpdiasqualidade');
        $this->adicionaRelacionamento('pro_filialmrpdiasfornecedor', 'pro_filialmrpdiasfornecedor');
        $this->adicionaRelacionamento('pro_filialestminimotipo', 'pro_filialestminimotipo');
        $this->adicionaRelacionamento('pro_filialestminimoperiodo', 'pro_filialestminimoperiodo');
        $this->adicionaRelacionamento('pro_filialmrploteminimoqtd', 'pro_filialmrploteminimoqtd');
        $this->adicionaRelacionamento('pro_filialmrplotemultiploqtd', 'pro_filialmrplotemultiploqtd');
        $this->adicionaRelacionamento('pro_filialmrpdiasagrupamento', 'pro_filialmrpdiasagrupamento');
        $this->adicionaRelacionamento('pro_filialloteproducaoqtd', 'pro_filialloteproducaoqtd');
        $this->adicionaRelacionamento('pro_filialmrpacao', 'pro_filialmrpacao');
        $this->adicionaRelacionamento('pro_filialmrpfilial', 'pro_filialmrpfilial');
            
        //FINAME
        $this->adicionaRelacionamento('pro_filialcodigofiname', 'pro_filialcodigofiname');
        $this->adicionaRelacionamento('pro_filialdescricaofiname', 'pro_filialdescricaofiname');
   
        //ContNserie
        $this->adicionaRelacionamento('pro_filialreferenciaseriefilia', 'pro_filialreferenciaseriefilia');
        
        $this->adicionaRelacionamento('pro_filialreferenciaserie', 'pro_filialreferenciaserie');
        
        //EspeciePadNotaFiscal
        $this->adicionaRelacionamento('pro_filialespeciepadrao', 'pro_filialespeciepadrao');
        $this->adicionaRelacionamento('pro_filialespeciecapacidade', 'pro_filialespeciecapacidade');
    
        //Fechamento de Estoque
        $this->adicionaRelacionamento('pro_filialpercustocoproduto', 'pro_filialpercustocoproduto');
        $this->adicionaRelacionamento('pro_filialconsqtdeprodcoprodut', 'pro_filialconsqtdeprodcoprodut');
        
        $this->adicionaRelacionamento('pro_filialinvrotativodata', 'pro_filialinvrotativodata');
        
        
        
        $this->setSTop('50');
        $this->adicionaOrderBy('fil_codigo', 1);
        
        $this->adicionaJoin('DELX_FIL_Empresa');
        $this->adicionaJoin('DELX_PRO_Produtos');
        
        }
        
        /**
         * SOMENTE STEEL ATENÇÃO
         * @param type $aCamposChave
         * @return type
         */
        public function bloqueioProd($aCamposChave){
            
            $sSql="update PRO_PRODUTOFILIAL set PRO_FilialDtBloqueado='".$aCamposChave['data']."', PRO_FilialMotivoBloqueio='".$aCamposChave['motivo']."' "
                    . "where PRO_Codigo = '".$aCamposChave['pro_codigo']."' and Fil_codigo = '".$aCamposChave['fil_codigo']."'";
            $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;

        }
        /**
         * SOMENTE STEEL ATENÇÃO
         * @param type $aCamposChave
         * @return type
         */
        public function desBloqueioProd($aCamposChave){
            
            $sSql="update PRO_PRODUTOFILIAL set PRO_FilialDtBloqueado='1753-01-01 00:00:00.000', PRO_FilialMotivoBloqueio='' "
                    . "where PRO_Codigo = '".$aCamposChave['pro_codigo']."' and Fil_codigo = '".$aCamposChave['fil_codigo']."'";
            $aRetorno = $this->executaSql($sSql);
        
        return $aRetorno;
            
        }
}
