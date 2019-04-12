<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_CargaInsumoServ
 * 
 * @author Avanei Martendal
 * @since 10/01/2019
 */

class PersistenciaSTEEL_PCP_CargaInsumoServ extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_CargaInsumoServ');
        
        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial',true,true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo',true,true);
        $this->adicionaRelacionamento('pdv_pedidoitemseq', 'pdv_pedidoitemseq',true,true);
        $this->adicionaRelacionamento('pdv_insserv', 'pdv_insserv');
        $this->adicionaRelacionamento('op','op');
        $this->adicionaRelacionamento('alerta','alerta');
        $this->adicionaRelacionamento('pesoOp','pesoOp');
       
    }
    
     public function retornaOps($aCamposChave){
        $sSql = "select op from steel_pcp_cargainsumoserv 
                where pdv_pedidofilial = '8993358000174' 
                and pdv_pedidocodigo = '".$aCamposChave['pdv_pedidocodigo']."' 
                group by op
                "; 
        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
               $aRetorno[] = $oRowBD;
           }
         
        //limpa a classe obs adicionais
         $oPedidoObs = Fabrica::FabricarController('STEEL_PCP_PedidoObs');
         $oPedidoObs->Persistencia->adicionaFiltro('pdv_pedidofilial','8993358000174');
         $oPedidoObs->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aCamposChave['pdv_pedidocodigo']);
         $oPedidoObs->Persistencia->excluir();
          
           $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
           foreach ($aRetorno as $key => $oValue) {
               $oOp->Persistencia->limpaFiltro();
               $oOp->Persistencia->adicionaFiltro('op',$oValue->op);
               $oDados = $oOp->Persistencia->consultarWhere();
               $sData = Util::converteData($oDados->getData());
               $aDocumento[] = $oDados->getDocumento() .' de '.$sData; 
                
             }
           
             //remove documentos duplicados
             $aDocumentoUni =array_unique($aDocumento);
             foreach ($aDocumentoUni as $key => $infAdicional) {
                 $sInf .=$infAdicional.', ';
               }
                 $sInf = substr($sInf,0,-2);
                 
                 $sInf.='.';
             
              
           //analisa registro de rnc
           $sInfRnc ='';
           foreach ($aRetorno as $keyRnc => $oValueRnc) {
               $oOp->Persistencia->limpaFiltro();
               $oOp->Persistencia->adicionaFiltro('op',$oValueRnc->op);
               $oDadosRnc = $oOp->Persistencia->consultarWhere();
                if($oDadosRnc->getRetrabalho()=='Sim S/Cobrança'){
                    $aDocumentoRnc[] = $oDadosRnc->getRnc();
                }
           }
            //remove documentos duplicados
             $aDocumentoRncUni =array_unique($aDocumentoRnc);
             foreach ($aDocumentoRncUni as $key => $infAdicionalRnc) {
                 $sInfRnc .=$infAdicionalRnc.', ';
               }
               if($sInfRnc!==''){
                    $sInfRnc = substr($sInfRnc,0,-2);
                    $sInfRnc ='RETRABALHO SEM COBRANCA RNC '.$sInfRnc.'.';
               }
                
               
             
              
             //faz a inserção
               $sData = Util::converteData($oDados->getData());
               $oPedidoObs->Model->setPdv_pedidofilial('8993358000174');
               $oPedidoObs->Model->setPdv_pedidocodigo($aCamposChave['pdv_pedidocodigo']);
               $oPedidoObs->Model->setPdv_pedidoobscodigo('3');
               $oPedidoObs->Model->setPdv_pedidoobsdescricao($sInfRnc.' DEVOLUCAO SUA NF '.$sInf.'');
               $oPedidoObs->Persistencia->inserir();
       }
  
}