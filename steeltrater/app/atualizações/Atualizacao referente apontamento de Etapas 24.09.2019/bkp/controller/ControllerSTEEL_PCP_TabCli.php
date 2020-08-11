<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */


class ControllerSTEEL_PCP_TabCli extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_TabCli');
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        $cond = $this->verificaEmpresa();
        if($cond){
            $aRetorno[0] = true;
        return $aRetorno;
        }
        else{
            $aRetorno[0] = false;
            return $aRetorno;
        }
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        $cond = $this->verificaEmpresa();
        if($cond){
            $aRetorno[0] = true;
        return $aRetorno;
        }
        else{
            $aRetorno[0] = false;
            return $aRetorno;
        }
    }
    
    public function verificaEmpresa(){
        
        $this->Persistencia->adicionaFiltro('emp_codigo', $this->Model->getEmp_codigo());
        
        $iCont =$this->Persistencia->getCount();
        if($iCont>0){
            $oModal = new Modal('Atenção!','Já existe um vínculo com o cliente! Selecione outro cliente!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            exit();
        }
        $this->Persistencia->limpaFiltro();
        return true;
    }
    
    
}

