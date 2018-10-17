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
    
    /**
    * Envia o e-mail
    */
   public function geraPdfCert($sDados) {
       $aDados = explode(',', $sDados);
       
       $aNr = $_REQUEST['parametrosCampos'];
       sort($aNr);
       $sVethor='';
       foreach ($aNr as $key => $value) {
           $aNrEnv = explode('=', $value);
           $sVethor.= 'nrcert[]='.$aNrEnv[1].'&';
           $aCert[$key]=$aNrEnv[1];
       }
       
        $_REQUEST['nrcert'] = $aCert;
        $_REQUEST['email'] ='S';
        $_REQUEST['userRel'] = $_SESSION['nome'];
       
        $aEmp= array();
        foreach ($aCert as $iCert) {
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert',$iCert);
            $oCertificado = $this->Persistencia->consultarWhere();
            $aEmp[]=$oCertificado->getEmpcod();
        }
        $aEmpRep = array_unique($aEmp);
        
        
       if(count($aEmpRep)==1){
       $_REQUEST['empresaCert'] = $aEmpRep[0];
       $aEmail = require 'app/relatorio/CertificadoOpSteel.php';
       if($aEmail[0]){
           $this->Persistencia->mudaSit($aCert);
           echo"$('#".$aDados[1]."-pesq').click();"; 
       }
       //grava histórico
       foreach ($aCert as $i => $cert) {
           $sDest='';
          $oHist = Fabrica::FabricarController('STEEL_PCP_histEmailcert');
          $oHist->Model->setNrcert($cert); 
          $oHist->Model->setUserEmail($_SESSION['nome']);
          $oHist->Model->setData(date('d/m/Y'));
          $oHist->Model->setHora(date('H:i'));
          if($aEmail[0]){
             $oHist->Model->setSitenv('Sucesso'); 
          }else{
             $oHist->Model->setSitenv($aEmail[1]);  
          }
          foreach ($aEmail[2] as $iDest => $sDestinatario) {
              $sDest .= $sDestinatario.';';
             }
          $oHist->Model->setDestinatario($sDest); 
          $oHist->Persistencia->setModel($oHist->Model);
          $oHist->Persistencia->inserir();
       }
       }else{
           $oModal= new Modal('Atenção!', 'Existem empresas diferentes nos certificados escolhidos, seleciona apenas certificados da mesma empresa!', Modal::TIPO_AVISO, false);
           echo $oModal->getRender();
       }
       
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
    
    public function afterDelete() {
        parent::afterDelete();
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
        $oOp->Persistencia->limpaCert($this->Model);
        
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iCon = $oOp->Persistencia->getCount();
        if($iCon ==0){
            $oModal = new Modal('Atenção','Essa op não existe, forneça uma ordem de produção existente!', Modal::TIPO_ERRO,false);
            echo $oModal->getRender();
        }
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iCon = $oOp->Persistencia->getCount();
        if($iCon ==0){
            $oModal = new Modal('Atenção','Essa op não existe, forneça uma ordem de produção existente!', Modal::TIPO_ERRO,false);
            echo $oModal->getRender();
        }
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
        
    }
    
    
    
}