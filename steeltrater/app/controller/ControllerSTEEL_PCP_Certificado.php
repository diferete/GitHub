<?php

/* 
 * Implementa a classe controler STEEL_PCP_Certificado
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */


class ControllerSTEEL_PCP_Certificado extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Certificado');
    }
    
    public function acaoMostraRelCertificado($sDados) {
       
       parent::acaoMostraRelEspecifico($sDados);
       
       $aNr = $_REQUEST['parametrosCampos'];
       sort($aNr);
       $sVethor='';
       foreach ($aNr as $key => $value) {
           $aNrEnv = explode('=', $value);
           $sVethor.= 'nrcert[]='.$aNrEnv[1].'&';
       }
       
      // exemplo.php?vetor[]=valor1&vetor[]=valor2&vetor[]=valor3
       
        $sSistema ="app/relatorio";
        $sRelatorio = 'CertificadoOpSteel.php?'.$sVethor;
        
        $sCampos.= $this->getSget();
        
       $sCampos.='&output=tela';
       $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sRel.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
       echo $oWindow; 

    }
    
    public function consultaOpDados($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //verifica se tem uma op válida

        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oDados = $oOpSteel->consultaOp($aCampos['op']);

        
            if ($oDados->getOp() == null) {
                $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não foi localizada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                echo '$("#' . $aId[0] . '").val("");'
                  . '$("#' . $aId[1] . '").val("");'
                 . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");'
               . '$("#' . $aId[4] . '").val("");'
              . '$("#' . $aId[5] . '").val("");'
             . '$("#' . $aId[6] . '").val("");'
            . '$("#' . $aId[7] . '").val("");';
            } else {
                
                $oDados->setProdes(str_replace("\n", " ",$oDados->getProdes()));
                $oDados->setProdes(str_replace("'","\'",$oDados->getProdes()));   
                $oDados->setProdes(str_replace("\r", "",$oDados->getProdes()));
                $oDados->setProdes(str_replace('"', '\"',$oDados->getProdes()));
                
                
                //coloca os dados na view  getProd()
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");'
                . '$("#' . $aId[4] . '").val("");'
                . '$("#' . $aId[5] . '").val("");'
                . '$("#' . $aId[6] . '").val("");'
                . '$("#' . $aId[7] . '").val("");'
                . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_codigo() . '");'
                . '$("#' . $aId[1] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                . '$("#' . $aId[2] . '").val("' . $oDados->getProd() . '");'
                . '$("#' . $aId[3] . '").val("' . $oDados->getProdes() . '");'
                . '$("#' . $aId[4] . '").val("' . $oDados->getOpcliente() . '");'
                . '$("#' . $aId[5] . '").val("' . number_format($oDados->getPeso(), 2, ',', '.') . '");'
                . '$("#' . $aId[6] . '").val("' . $oDados->getDocumento() . '");'
                . '$("#' . $aId[7] . '").val("' . number_format($oDados->getQuant(), 2, ',', '.') . '");';
            }                       
    } 
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        $aRender = explode(',',$sParametros);
        
        $sChave =htmlspecialchars_decode($aRender[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        if(count($aCamposChave)>0){
            
            $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
            $oOp->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
            $oDadosOp = $oOp->Persistencia->consultarWhere();
            
            $this->View->setAParametrosExtras($oDadosOp);
            
            if($oDadosOp->getNrcert()){
            $oModal = new Modal('Atenção!','Esta ordem de produção já tem um certificado atrelado!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            echo ' $("#'.$aRender[1].'consulta").show(); '; 
            exit();
            }
           
        
        }
        
       echo ' $("#'.$aRender[1].'consulta").hide(); '; 
    }
    
   
    
    public function afterInsert() {
        parent::afterInsert();
        
        //instancia classe 
        $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
        $oOp->Persistencia->putCertOp($this->Model);
        
        
        
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        
    }
    
}