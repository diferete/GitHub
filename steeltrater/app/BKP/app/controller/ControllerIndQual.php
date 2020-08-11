<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerIndQual extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('IndQual');
    }
    
    
    public function indicadorExp($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'indicadorRelExp');
    }
    
     /**
   * Retorna dados para get de relatórios
   */
  public function getSget() {
      parent::getSget();
      
      
      
      $sCampos ='&usu='.$_SESSION["nome"];
    
      
      return $sCampos;
  }
  
  
  /**
   * Gera xls do relatorio de producao expedicao
   */
  
  public function indicadorExpedicaoXls(){
        //Explode string parametros
        $sDados = $_REQUEST['campos'];
        
        $sCampos = htmlspecialchars_decode($sDados);
        
        
        
        $sCampos.= $this->getSget();
        
        $aRel = explode(',', $sRel);
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'indicadorRelExpXls.php?';
        
        $sCampos.='&output=email';
        $oMensagem = new Mensagem("Aguarde","Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();
       
        $oWindow =// 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");'; 
                'var win = window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'","MsgWindow","width=500,height=100,left=375,top=330");'
                    .'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;
         
        
        
        $oMenSuccess = new Mensagem("Sucesso","Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
        
    }
}