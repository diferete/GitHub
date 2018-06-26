<?php

/* 
 * controla as ações dos escritótios de representações
 */

class ControllerRepOffice extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('RepOffice');
      
    }
    
    public function afterInsert() {
        parent::afterInsert();
        
        $sDir = $this->Model->getOfficedir();
        
        if($sDir!=''){
           mkdir("app/relatorio/representantes/".$sDir."", 0777, true) or die($s="erro ao criar diretório");
        }
       
       $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        
    }
    public function afterUpdate() {
        parent::afterUpdate();
        $novodir = $this->Model->getOfficedir();
        $antigo = $this->getParamaux();
        
        $sDir = "app/relatorio/representantes/".$antigo; 
        if($novodir == ''){
            rmdir("app/relatorio/representantes/".$antigo);
        } else {
        if($antigo==null){
          mkdir("app/relatorio/representantes/".$novodir."", 0777, true) or die($s="erro ao criar diretório");  
          }else{
          rename("app/relatorio/representantes/".$antigo, "app/relatorio/representantes/".$novodir);
        }
        } 
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function antesCarregarModel() {
        parent::antesCarregarModel();
        
        $sDirAntigo = $this->Model->getOfficedir();
        $this->setParamaux($sDirAntigo);
    }
    public function afterDelete() {
        parent::afterDelete();
        
        $sDir = $this->Model->getOfficedir();
        rmdir("app/relatorio/representantes/".$sDir);
        
         
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    
   
}
