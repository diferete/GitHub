<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class ControllerSTEEL_PCP_ordensFabLista extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabLista');
    }
    
    /**
     * insere item na lista
     */
    public function insereLista($sDados){
        
        $this->carregaModel($aCamposTela);
        
        
        date_default_timezone_set('America/Sao_Paulo');
        $this->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iAgenda = $this->Persistencia->getCount();
        if ($iAgenda>0){
            $this->Persistencia->excluir(); 
            $oMensagemAt = new Mensagem('Atenção','Este registro foi atualizado!', Mensagem::TIPO_INFO);
            echo $oMensagemAt->getRender();
        }
        
        
        
        $this->Model->setData(date('Y-m-d'));
        $this->Model->setHora(date('H:i'));
        $this->Model->setUsucodigo($_SESSION["codUser"]);
        $this->Model->setUsunome($_SESSION["nome"]);
        $this->Model->setTempForno($this->ValorSql($this->Model->getTempForno()));
        //valida se forno = todos e situação igual a liberado
        if(($this->Model->getSituacao()=='Liberado') &&($this->Model->getFornocod()=='Todos') ){
            $oModal = new Modal('Atenção!','Para liberar essa OP é necessário informar um FORNO, escolha um FORNO para essa lista! ', Modal::TIPO_INFO);
            echo $oModal->getRender();
            exit;
        }
        
        
        
        //getTempForno()
        if($this->Model->getFornocod()=='Todos'){
            $this->Model->setFornocod('0');
            $this->Model->setFornodes('');
        }else{
           //busca descrição do forno
            $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
            $oForno->Persistencia->adicionaFiltro('fornocod',$this->Model->getFornocod());
            $oFornoDados = $oForno->Persistencia->consultarWhere();
            $this->Model->setFornodes($oFornoDados->getFornodes());
        }
        $aRetorno = $this->Persistencia->inserir();
        if($aRetorno[0]){
            //seta os cookies para recuperação
            setcookie("montalistaSit", $this->Model->getSituacao(), time()+3600*24*30*12*5); 
            setcookie("montalistaForno", $this->Model->getFornocod(), time()+3600*24*30*12*5);
            setcookie("montalistaPrio", $this->Model->getPrioridade(), time()+3600*24*30*12*5);
            setcookie("montalistaCarga", $this->Model->getNrCarga(), time()+3600*24*30*12*5);
            $oMensagem = new Mensagem('Sucesso!','Op inserida com sucesso na lista de prioridades!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo'$("#modalLista-btn").click();';
        }else{
            $oMensagem = new Mensagem('Atenção!',$aRetorno[''], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender(); 
        }
            
    }
    
    /**
     * atualizar lista
     */
    public function atualizarLista($sDados){
        
        $this->carregaModel($aCamposTela);
        date_default_timezone_set('America/Sao_Paulo');
        $this->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iAgenda = $this->Persistencia->getCount();
       
        
        $this->Model->setData(date('Y-m-d'));
        $this->Model->setHora(date('H:i'));
        $this->Model->setUsucodigo($_SESSION["codUser"]);
        $this->Model->setUsunome($_SESSION["nome"]);
        $this->Model->setTempForno($this->ValorSql($this->Model->getTempForno()));
        //valida se forno = todos e situação igual a liberado
        if(($this->Model->getSituacao()=='Liberado') &&($this->Model->getFornocod()=='Todos') ){
            $oModal = new Modal('Atenção!','Para liberar essa OP é necessário informar um FORNO, escolha um FORNO para essa lista! ', Modal::TIPO_INFO);
            echo $oModal->getRender();
            exit;
        }
        
        
        
        //getTempForno()
        if($this->Model->getFornocod()=='Todos'){
            $this->Model->setFornocod('0');
            $this->Model->setFornodes('');
        }else{
           //busca descrição do forno
            $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
            $oForno->Persistencia->adicionaFiltro('fornocod',$this->Model->getFornocod());
            $oFornoDados = $oForno->Persistencia->consultarWhere();
            $this->Model->setFornodes($oFornoDados->getFornodes());
        }
        $aRetorno = $this->Persistencia->apontaLista($this->Model);
        if($aRetorno[0]){
            $oMensagem = new Mensagem('Sucesso!','Lista apontada com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo'$("#modalLib-btn").click();';
        }else{
            $oMensagem = new Mensagem('Atenção!',$aRetorno[''], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender(); 
        }
            
    }
    
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
         $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
         $oFornoSel = $oForno->Persistencia->getArrayModel();
         $this->View->setAParametrosExtras($oFornoSel);
         
    }
    
     /**
     * Cria a tela Modal para a proposta
     * @param type $sDados
     */
    public function criaTelaModalLibForno($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('=', $aDados[2]);
        
        $this->carregaModelString($aDados[2]);
        $this->Model=$this->Persistencia->consultar();
    
          //busca os dados da ordem de produção
            $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOpDados=$oOp->buscaOp($this->Model->getOp());
            
            //busca fornos
            $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
            $oFornoSel = $oForno->Persistencia->getArrayModel();
            $this->View->setAParametrosExtras($oOpDados);
            $this->View->setAModelDados($oFornoSel);
            $this->View->criaModalLibForno($this->Model);
            //busca lista pela op
            $oLista= Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
            $oListaDate = $oLista->Persistencia->adicionaFiltro('op',$this->Model->getOp());
            $oListaDate = $oLista->Persistencia->consultarWhere();
            if($oListaDate->getSituacao()=='Processo'){
               $oMensagem = new Modal('Atenção','Esta lista da op nº '. $aChave[1] . ' já está em processo!', Modal::TIPO_AVISO,false,true);
              echo $oMensagem->getRender(); 
              echo'$("#modalLib-btn").click();';
            }else{
                if($oListaDate->getSituacao()=='Liberado'){
                    $oModalAlert = new Modal('Aviso!','Somente um lembrete, esta lista já está com situação Aberta e atrelada a um forno!', Modal::TIPO_INFO);
                    echo $oModalAlert->getRender();
                }
            $sLimpa = "$('#" . $aDados[0] . "-modal').empty();";
            echo $sLimpa;
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
            }
        
            
    }
    
     public function acaoMostraRelEspecifico($sDados) {
       parent::acaoMostraRelEspecifico($sDados);
       $aDados = explode(',', $sDados);
       
        $sChave =htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
            
        $sParam ='fornoCod='.$aDados[2].'';
        $sSistema ="app/relatorio";
        $sRelatorio = 'RelOpSteelPrioridadeForno.php?';
        $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oForno->Persistencia->adicionaFiltro('fornocod',$aDados[2]);
        $oDadosForno = $oForno->Persistencia->consultarWhere();
        $oDes = 'fornoDes='.$oDadosForno->getFornodes();
        
        $sCampos.= $sParam.'&'.$oDes.'&obs='.$aCamposChave['obs'].$this->getSget();
        
       $sCampos.='&output=tela';
       $oWindow = 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "'.$sCampos.'", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
       echo $oWindow; 
       
    }    
    
     public function gravaPrio($sDados){
        $aDados = explode(',', $sDados);
        $this->carregaModelString($aDados[3]);
        $aRetorno = $this->Persistencia->alteraPrio($aDados[2], $this->Model->getNr());
        if($aRetorno[0]){
            $oMensagem = new Mensagem('Sucesso!','Prioridade adicionada.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        }else{
            $oMensagem = new Mensagem('Atenção!','Prioridade não foi adicionada '.$aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
        
    }
    /**
     * baixa lista 
     */
    public function baixaLista($aDados,$sSit){
        $aRetorno = $this->Persistencia->baixaLista($aDados,$sSit);
        return $aRetorno;
        
    }
    
    /**
     * Vai excluir da lista
     * @param type $sDados
     */
    
    public function excluirLista($sDados){
        $aDados = explode(',',$sDados);
        
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $this->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $aRetorno = $this->Persistencia->excluir();
        if($aRetorno[0]){
           $oMensagem = new Mensagem('Sucesso!','O registro foi deletado! ', Mensagem::TIPO_SUCESSO);
           echo $oMensagem->getRender();
           echo"$('#".$aDados[1]."-pesq').click();";  
           
        }else{
            $oMensagem = new Mensagem('Atenção!','O registro não foi deletado, mensagem do banco: '.$aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
        }
        
    }
    
}