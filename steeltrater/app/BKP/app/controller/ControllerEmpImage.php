<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerEmpImage extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('EmpImage');
    }
    
    public function retornaLogo($sCodUser){
        
        return $this->Persistencia->retornaLogo($sCodUser) ;
        
    }
    
    public function afterCommitUpdate() {
        parent::afterCommitUpdate();
        $sImagem = $this->Model->getFillogo();
        $sCodMode = $this->Model->getFilcgc();
        
        if($_SESSION['filcgc']==$sCodMode){
        
        echo "$('#img-perfil1').attr('src','Uploads/".$sImagem."');";
        echo "$('#logo').attr('src','Uploads/".$sImagem."');";
        //$(this).attr('src', caminho+index+'.jpg');
        }
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
}