<?php

/**
 * Class que implementa a controller CadCliRepEnd para inserçao de cobrancás 
 * @author Avanei Martendal
 * @since 27/09/2017
 */

class ControllerCadCliRepEnd extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('CadCliRepEnd');
    }
    
        
    public function apontEnd($sDados){
         $aDados = explode(',', $sDados);
         $aCampos = array();
         parse_str($_REQUEST['campos'],$aCampos);
         
         //conta para verificar se vai alterar
         $this->Persistencia->adicionafiltro('empcod',$aCampos['empcod']);
         $this->Persistencia->adicionafiltro('nr',$aCampos['nr']);
         $this->Persistencia->adicionafiltro('tipo',$aCampos['tipo']);
         $iCont = $this->Persistencia->getCount();
         
        if($iCont==0){
         
         $this->carregaModel();
         
         $aRetorno = $this->Persistencia->inserir();
        
         if($aRetorno[0]){
             $oMensagem = new Mensagem('Sucesso', 'Inserido com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#'.$aDados[0].'").each (function(){ this.reset();});';
            echo $sLimpa;
           // echo '$("#'.$aDados[2].'").val("'.$iCont.'");';
            echo 'requestAjax("'.$aDados[0].'","CadCliRepEnd","getDadosGrid","'.$aDados[1].'","consultaEnd");';
         }else{
            $oMensagem = new Modal('Problema', 'Problemas ao retorna plano de ação'.$aRetorno[1], Modal::TIPO_ERRO,false,true,true);
            echo $oMensagem->getRender();   
         }
        }else{
           $this->carregaModel();
         
           $aRetorno = $this->Persistencia->alterar(); 
            
            
            
            
          if($aRetorno[0]){
             $oMensagem = new Mensagem('Sucesso', 'Alterado com sucesso!', Mensagem::TIPO_INFO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#'.$aDados[0].'").each (function(){ this.reset();});';
            echo $sLimpa;
           // echo '$("#'.$aDados[2].'").val("'.$iCont.'");';
            echo 'requestAjax("'.$aDados[0].'","CadCliRepEnd","getDadosGrid","'.$aDados[1].'","consultaEnd");';
         }else{
            $oMensagem = new Modal('Problema', 'Problemas ao retorna plano de ação'.$aRetorno[1], Modal::TIPO_ERRO,false,true,true);
            echo $oMensagem->getRender();   
         }
        }
         
    }
    
    public function excluirEf($sDados){
      
        $aDados = explode(',', $sDados);
        $aRetorno[0] = true;
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aChave = explode(',', $sChave);
        
        $this->Persistencia->iniciaTransacao();
        $this->carregaModelString($aChave[0]);
        $this->Model = $this->Persistencia->consultar();
        
        $aRetorno = $this->Persistencia->excluir(true);
        if($aRetorno[0]){
            $this->Persistencia->commit();
            $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
            echo $oMensagemSucesso->getRender();
            echo 'requestAjax("'.$aDados[0].'","CadCliRepEnd","getDadosGrid","'.$aDados[1].'","consultaEnd");';
        
        }else{
            $oMensagemErro = new Mensagem('Falha', 'O registro não foi excluído!', Mensagem::TIPO_ERROR);
            echo $oMensagemErro->getRender();
          
        }
    }
    
     public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        $aCampos = array();
        parse_str($_REQUEST['campos'],$aCampos);
        if(count($aCampos)>0){
        $this->Persistencia->adicionaFiltro('nr',$aCampos['nr']);
        $this->Persistencia->adicionaFiltro('empcod',$aCampos['empcod']);
        
        }
       
    }
    
    public function sendaDadosCampos($sDados){
      $aDados = explode(',',$sDados);
        
      $sChave = htmlspecialchars_decode($aDados[1]);
      $aChaveAq = array();
      parse_str($sChave,$aChaveAq);
      
      if(count($aChaveAq)>0){
          $this->Persistencia->adicionaFiltro('nr',$aChaveAq['nr']);
          $this->Persistencia->adicionaFiltro('empcod',$aChaveAq['empcod']); 
          $this->Persistencia->adicionaFiltro('tipo',$aChaveAq['tipo']);
          $this->Model = $this->Persistencia->consultarWhere();
                  
                 $sValor = $this->Model->getEmpendobs();
                  
                /*  $this->Model->setEmpendobs(str_replace("\n", " ",$this->Model->getEmpendobs()));
                  $this->Model->getEmpendobs(str_replace("'","\'",$this->Model->getEmpendobs()));   
                  $this->Model->getEmpendobs(str_replace("\r", "",$this->Model->getEmpendobs()));*/
                  
                    $sValor = str_replace("\n", " ",$sValor);
                    $sValor = str_replace("'","\'",$sValor);   
                    $sValor = str_replace("\r", "",$sValor);


           
            echo '$("#'.$aDados[2].'").val("'.$this->Model->getNr().'");';
            echo '$("#'.$aDados[3].'").val("'.$this->Model->getEmpcod().'");';
            echo '$("#'.$aDados[4].'").val("'.$this->Model->getTipo().'");';
            echo '$("#'.$aDados[5].'").val("'.$this->Model->getEndcep().'");';
            echo '$("#'.$aDados[6].'").val("'.$this->Model->getEnduf().'");';
            echo '$("#'.$aDados[7].'").val("'.$this->Model->getEndbairr().'");';
            echo '$("#'.$aDados[8].'").val("'.$this->Model->getEnder().'");';
            echo '$("#'.$aDados[9].'").val("'.$this->Model->getEndnr().'");';
            echo '$("#'.$aDados[10].'").val("'.$this->Model->getEndcid().'");';
            echo '$("#'.$aDados[11].'").val("'.$this->Model->getEndcnpj().'");';
            echo '$("#'.$aDados[12].'").val("'.$this->Model->getEndInsc().'");';
            echo '$("#'.$aDados[13].'").val("'.$this->Model->getEmpendfone().'");';
            echo '$("#'.$aDados[14].'").val("'.$this->Model->getEmpendemail().'");';
            echo '$("#'.$aDados[15].'").val("'.$sValor.'");';
        }
        
      
    }
    
    /**
     * verifica se já existe cadastro com esse tipo
     */
    public function verificaTipoEnd($sDados){
      $sChave = htmlspecialchars_decode($_REQUEST['campos']);
      $aChaveAq = array();
      parse_str($sChave,$aChaveAq);
      
          $this->Persistencia->adicionaFiltro('nr',$aChaveAq['nr']);
          $this->Persistencia->adicionaFiltro('empcod',$aChaveAq['empcod']); 
          $this->Persistencia->adicionaFiltro('tipo',$aChaveAq['tipo']);
          
          $iCount = $this->Persistencia->getCount();
          
          if($iCount>0){
              $oModal = new Modal('Atenção','Só deve existir um endereço de cobrança e um endereço de entrega!', Modal::TIPO_INFO, FALSE, true,false);
              echo $oModal->getRender();
          }
        
    }
    
     /**
     * Método responsável para abrir a tela de alteração no entanto ao selecionar item com 
       dropdow
     */
        public function acaoMostraTelaEndereço($sDados){
       
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $oCliente = Fabrica::FabricarController('CadCliRep');
        
        $oCliente->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
        $oDados = $oCliente->Persistencia->consultarWhere();
        
        
        $this->View->setAParametrosExtras($oDados);
        //cria a tela
        $this->View->criaTela();
        
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        
        //adiciona botoes padrão
        $this->View->addBotaoApont();
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
}

