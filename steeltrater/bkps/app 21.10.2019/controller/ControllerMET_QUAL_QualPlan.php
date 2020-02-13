<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerMET_QUAL_QualPlan extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_QualPlan');
    }
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        $this->View->setAParametrosExtras($aChave);
        
        }
        
     public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
        $this->Persistencia->adicionaFiltro('filcgc',$aparam[0]);
        $this->Persistencia->adicionaFiltro('nr',$aparam[1]);
        $this->Persistencia->setChaveIncremento(false);
        }  else {
        $this->Persistencia->adicionaFiltro('filcgc',$aparam1[0]);
        $this->Persistencia->adicionaFiltro('nr',$aparam1[1]);
        $this->Persistencia->setChaveIncremento(false); 
        }
        
    }
    
    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('seq',  $this->Model->getSeq());
    }
    
    public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sDados);
        $aParam = explode(',', $sDados);
        // "$('#".$sId."').each (function(){ this.reset();});";
        //verifica se está como 
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
          
            
       
        echo $sScript;
        
    }
    
    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
           $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
          
        }
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
    
    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
      
        //$("#'.$aCampos.'").fileinput('clear');
        //$sRetorno = "$('#".$aCampos[4][1]."').fileinput('clear');";
        echo $sRetorno;
        unset($aCampos[8]);
        return $aCampos;
        
        
    }
    
    public function afterInsert() {
        parent::afterInsert();
        
        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
       $sRetorno = "$('#".$aDados[4]."').fileinput('clear');";
       echo $sRetorno;
       
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function afterUpdate() {
        parent::afterUpdate();
         foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
       $sRetorno = "$('#".$aDados[4]."').fileinput('clear');";
       echo $sRetorno;
       
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }

    

    public function geraRelPdfAq($sDados){
         $aDados = explode(',', $sDados);
         $sSistema ="app/relatorio";
         $sRelatorio = $aDados[2].'.php?';
         $sCampos='nr='.$aDados[1].'&';
         $sCampos.='DELX_FIL_Empresa_fil_codigo='.$aDados[0];
         
        
         $sCampos.='&output=email';
         
          $oWindow = 'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "1366002941508","width=100,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 1000);';
         echo $oWindow;
    }
    
    public function geraPlanoEf($sDados){
         $aDados = explode(',', $sDados);
         $aCampos = array();
         parse_str($_REQUEST['campos'],$aCampos);
         
         if($aCampos['plano']=='' || $aCampos['plano']==null){
             $oMsg = new Modal('Aviso','Campo plano deve ser preenchido', Modal::TIPO_AVISO,false);
             echo $oMsg->getRender();
         }else if ($aCampos['seq']=='' || $aCampos['seq']==null){
             $oMsg2 = new Modal('Aviso','Clique na ação da eficácia no grid que deseja inserir um plano de ação', Modal::TIPO_AVISO,false);
             echo $oMsg2->getRender();
         }else{
        
                $aRetorno = $this->Persistencia->inserAq($aCampos);
                if($aRetorno[0]==true){
                    $sLimpa = '$("#'.$aDados[0].'").each (function(){ this.reset();});';
                    echo $sLimpa;
                    $oMsgSucesso = new Mensagem('Sucesso', 'Plano de ação inserido com sucesso!', Mensagem::TIPO_SUCESSO);
                    echo $oMsgSucesso->getRender();
                }else{

                }
         }
        
    }
    
    public function afterDelete() {
        parent::afterDelete();
        
       $this->Persistencia->deletaEficazPlan($this->Model->getFilcgc(),$this->Model->getNr(),$this->Model->getSeq());
        $aRetorno[0] = true;
        
        return $aRetorno;
    }
    
}
