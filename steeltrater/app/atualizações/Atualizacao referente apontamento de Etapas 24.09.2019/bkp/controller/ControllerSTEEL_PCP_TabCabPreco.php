<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 04/02/2018
 */


class ControllerSTEEL_PCP_TabCabPreco extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_TabCabPreco');
        $this->setControllerDetalhe('STEEL_PCP_TabItemPreco');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
    public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       $this->Persistencia->adicionaFiltro('nr',$this->Model->getNr());
       }
    
    public function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getNr();
       return $aRetorno;
   }
   
   public function beforeInsert() {
       parent::beforeInsert();
       $this->validaEmpresaInsert();
       
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
   }
   
   public function beforeUpdate() {
       parent::beforeUpdate();
      
       $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
   }

   public function validaEmpresaInsert($sDados){
     $this->Persistencia->adicionaFiltro('emp_codigo',$this->Model->getEmp_codigo());
       $iCont = $this->Persistencia->getCount();
       if($iCont > 0){
           $oModal = new Modal('Atenção','Já temos no cadastro uma tabela para este cliente.', Modal::TIPO_AVISO, false,true, false);
           echo $oModal->getRender();
           exit();
       }
   }
   
}


