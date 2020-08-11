<?php

/* 
 * Implementa a classe controler STEEL_PCP_GeraCertificado
 * 
 * @author Cleverton Hoffmann
 * @since 08/10/2018
 */


class ControllerSTEEL_PCP_GeraCertificado extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GeraCertificado');
    }
    
     public function acaoRelGerencialSaldo($sDados) {
       
       parent::acaoMostraRelEspecifico($sDados);
       
       
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'RelOpSteel3.php?';
        
        $sCampos.= $this->getSget();
        
        $sCampos.='&output=tela';
        $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow; 
         
         
       
        }
    
}