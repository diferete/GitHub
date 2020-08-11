<?php

/* 
 * classe carrega os itens para geração de ofs
 * @author Avanei Martendal
 * 
 * @since 22/06/2018
 */

class ControllerSTEEL_PCP_OFnfentItens extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_OFnfentItens');
    }
    
     public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        if(count($aCampos)>0){
        $this->Persistencia->adicionaFiltro('nfs_notafiscalfilial',$aCampos['nfs_notafiscalfilial']);
        $this->Persistencia->adicionaFiltro('nfs_notafiscalseq',$aCampos['nfs_notafiscalseq']);
        
        }
       
    }
}

