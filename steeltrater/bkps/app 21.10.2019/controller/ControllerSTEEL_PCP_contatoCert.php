<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_contatoCert extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_contatoCert');
    }
    
    public function beforeInsert() {
        parent::beforeInsert();

        $this->Persistencia->adicionaFiltro('emp_codigo', $this->Model->getEmp_codigo());
        $this->Persistencia->adicionaFiltro('empcertemail', $this->Model->getEmpcertemail());//
        $iCont = $this->Persistencia->getCount();
        
        if($iCont > 0){
            $oModal = new Modal('Atenção', 'Já existe um contato com esse cliente e e-mail!', Modal::TIPO_INFO, false, true);
            echo $oModal->getRender();
        }
                 
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
}