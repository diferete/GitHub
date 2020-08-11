<?php

/* 
 * @author Avanei Martendal
 * @Since 06/09/2019
 */

class ControllerSTEEL_PCP_ordensFabApontEtapas extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabApontEtapas');
    }
    
    public function atualizaApontEnt($sDados){
        $aDados = explode(',', $sDados);
        
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        //verifica se foi informado uma op válida
        if($aCamposChave['op']==''){
            $oMensagem = new Mensagem('Op não informada!', 'Informe uma ordem de produção.', Mensagem::TIPO_WARNING, 5000);
            echo $oMensagem->getRender();
            echo '$("#'.$aDados[0].' > tbody >").remove();'; 
            exit();
        }
       //busca o apontamento da ordem de producao
        $oDadosEnt = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        $oDadosEnt->Persistencia->adicionaFiltro('op',$aCamposChave['op']);
        $oDadosOp = $oDadosEnt->Persistencia->consultarWhere();
        
         //verifica se há op apontada
        if($oDadosOp->getOp()==null){
             $oMensagem = new Mensagem('Ordem de produção não encontrada!', 'Informe uma nova ordem de produção.', Mensagem::TIPO_ERROR, 5000);
            echo $oMensagem->getRender();
            echo '$("#'.$aDados[0].' > tbody >").remove();'; 
            exit();
        }
        
        //carrega os dados no grid
         echo '$("#'.$aDados[0].' > tbody >").remove();'; 
         //verifica a cor verde para finalizado e azul para processo
         $sCorFundo ='';
         if($oDadosOp->getSituacao()=='Processo'){
             $sCorFundo = 'azul';
         }else{
             $sCorFundo = 'verde';
         }
        //html visualizacao
        $sRenderOp ='<tr class="tr-'.$sCorFundo.'" >'
                .'<td><button type="button" id="'.$aDados[0].'-btn" title="Excluir apontamento!" class="btn btn-outline btn-danger btn-xs"><i class="icon wb-trash" aria-hidden="true"></i></button></td>'
                . '<td>'.$oDadosOp->getOp().'</td>'
                . '<td>'.$oDadosOp->getProdes().'</td>'
                . '<td>'.$oDadosOp->getFornodes().'</td>'
                . '<td>'.$oDadosOp->getTurnoSteel().'</td>'
                . '<td>'.date('d/m/Y',strtotime($oDadosOp->getDataent_forno())).'</td>'
                . '<td>'.substr($oDadosOp->getHoraent_forno(), 0, -8).'</td>'
                . '<td class="tr-bk-'.$sCorFundo.'">'.$oDadosOp->getSituacao().'</td>'
                . '<td>'.$oDadosOp->getUsernome().'</td>'
                . '</tr> <script>$("#' . $aDados[0]. '-btn").click(function(){ '
                . 'requestAjax("","STEEL_PCP_ordensFabApontEtapas","msgExcluirApontamento","' .$aDados[0]. ','.$aCamposChave['op'].','.$aDados[1].'","consultaApontGrid");'
                . ' }); </script>';  
                    
        echo '$("#'.$aDados[0].' > tbody").append(\''.$sRenderOp.'\');';
        
        
        
        
    }

    
    
    public function antesDeMostrarTela($sParametros = null) {
        parent::antesDeMostrarTela($sParametros);

        $oFornoUser = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        $oDados = $oFornoUser->pesqFornoUser();

        //busca forno
        $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoAtual = $oForno->buscaForno($oDados->getFornocod());

        $aForno[]=$oFornoAtual;
        
        
        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoSel = $oFornos->Persistencia->getArrayModel();
        
        $aForno[]=$oFornoSel;

        $this->View->setAParametrosExtras($aForno);
    }
    
    /**
     * Mensagem para excluir o apontamento
     */
    
      /*
     * Mensagem de exclusão da OP selecionada no Apontamento
     */
    public function msgExcluirApontamento($sDados) {
        $aDados = explode(',', $sDados);
        
        if($aDados[1]=='' || $aDados[1]==null){
            $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não informada', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit();
        }
        //verifica se há linhas com algum apontamento
        $iTotalApont = $this->Persistencia->verificaApontamento($aDados[1]);
        if($iTotalApont > 0){
            $oMensagem = new Modal('Atenção!', 'Existem apontamentos de etapas nesta ordem de produção, retorne estes apontamentos para continuar!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }
       
        //monta a classe de ordem de produção 
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $aDados[1]);
        $oOpAtual = $oOp->Persistencia->consultarWhere();

        if ($oOpAtual->getSituacao() !== 'Processo') {
            $oMensagem = new Mensagem('Atenção!', 'Atenção OP não está em uma situação que permita ser excluído seu apontamento, somente apontamentos em Processo podem ser excluídos!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit();
           /* $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP nº' . $aDados[1] . ' não está em uma situação que pode ser excluída, somente apontamentos em "Processo" podem ser excluídos!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit();*/
        } 
              
            
            $oMensagem = new Modal('Atenção', 'Deseja excluir o apontamento da Ordem de Produção nº' . $aCamposChave['op'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","STEEL_PCP_ordensFabApontEtapas","excluirOpEtapa","' . $sDados . '");');

            echo $oMensagem->getRender();
        
    }
    
    /*
     * Função que exclui a OP selecionada no Apontamento
     */
    public function excluirOpEtapa($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
       
        $aCamposChave['op']=$aDados[1];
        $aCamposChave['seq']=1;
        //instancia a classe de apontamentos
       
        $aRetorno = $this->Persistencia->deletarOp($aCamposChave);
        //baixa lista
        $oLista = Fabrica::FabricarController('STEEL_PCP_ordensFabLista');
        $aRetornoLista=$oLista->baixaLista($aCamposChave,'Liberado');
        if($aRetornoLista[0]){
            $oMensagemLista = new Mensagem('Lista de prioridades!','Essa ordem de produção retornou a situação da lista de prioridades!', Mensagem::TIPO_SUCESSO);
            echo $oMensagemLista->getRender();
        }else{
            $oMensagemLista = new Mensagem('Lista de prioridades!','Ocorreu um erro ao retornar a lista de prioridades! '.$aRetornoLista[1], Mensagem::TIPO_SUCESSO);
            echo $oMensagemLista->getRender();
        }
        if ($aRetorno[0]) {
            //muda a situação da op para em aberto
            $oOrdensFab = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oOrdensFab->retornaOpAberto($aCamposChave);
            
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposChave['op'] . ' foi excluída com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
             //carrega os dados no grid
            //echo '$("#'.$aDados[0].' > tbody >").remove();'; 
            echo '$("#' . $aDados[2] . '" ).click();';
            
        } else {
            $oMensagem = new Mensagem('Erro!', 'A OP ' . $aCamposChave['op'] . ' não foi excluída com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
        }
       
    }

    /**
    * Modal apontamentos
    */
     public function criaTelaModalApontaIniciar($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aOp= explode('=', $aChave[0]);
        $aOpEtapa = explode('=', $aChave[1]);
        
        $oApontOp = Fabrica::FabricarController('STEEL_PCP_ordensFabItens');
        $oApontOp->Persistencia->adicionaFiltro('op',$aOp[1]);
        $oApontOp->Persistencia->adicionaFiltro('opseq',$aOpEtapa[1]);
        
        $oDados = $oApontOp->Persistencia->consultarWhere();
        //verifica a situacao, caso seja finalizado ou processo avisa e fecha a tela
        if($oDados->getSituacao()=='Processo' || $oDados->getSituacao()=='Finalizado'){
           $oModal = new Modal('Atenção!','OP com situação '.$oDados->getSituacao().', não é possível iniciar o apontamento!', Modal::TIPO_AVISO, false, true, true);
           echo $oModal->getRender();
           echo'$("#modalApontaIniciar-btn").click();';
           exit();
        }
        
        //verifica se a op anterior não está finalizada
        $iEtapa = $aOpEtapa[1];
        if($iEtapa >1){
            //busca a etapa anterior
            $iEtapa = $iEtapa-1;
            $iCountEtapaAnt = $this->Persistencia->etapaAntFinalizada($aOp[1],$iEtapa);
            if($iCountEtapaAnt == 0){
                $oModal = new Modal('Atenção!','Etapa anterior não foi FINALIZADA, por favor finalize a etapa anterior!', Modal::TIPO_AVISO, false, true, true);
                echo $oModal->getRender();
                echo'$("#modalApontaIniciar-btn").click();';
                exit(); 
            }
            
            
        }
        
        //verifica se há alguma etapa com situacao igual a processo
        $oDadosProc = Fabrica::FabricarController('STEEL_PCP_ordensFabItens');
        $oDadosProc->Persistencia->adicionaFiltro('op',$aOp[1]);
        $oDadosProc->Persistencia->adicionaFiltro('situacao','Processo');
        $iCountProc = $oDadosProc->Persistencia->getCount();
        if($iCountProc > 0){
           $oModal = new Modal('Atenção!','OP tem etapas com situação em Processo, finalize a etapa antes de iniciar uma nova!', Modal::TIPO_AVISO, false, true, true);
           echo $oModal->getRender();
           echo'$("#modalApontaIniciar-btn").click();';
           exit(); 
        }
        
        //busca os fornos para listar
        $oFornoUser = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        $oDadosForno = $oFornoUser->pesqFornoUser();

        //---busca forno----------------------------------------------------
        $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoAtual = $oForno->buscaForno($oDadosForno->getFornocod());

        $aForno[]=$oFornoAtual;
        
        
        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoSel = $oFornos->Persistencia->getArrayModel();
        
        $aForno[]=$oFornoSel;

        //-------------------------------------------------------------------
        
        $this->View->setAParametrosExtras($oDados);

        $this->View->criaModalApontaIniciar($aForno,$aDados[1]);
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }
    
    /**
     * Método para inserir apontamento
     */
    
    public function ApontEtapa($sDados){
         $aDados = explode(',', $sDados);
         $sChave = htmlspecialchars_decode($_REQUEST['campos']);
         $aCamposChave = array();
         parse_str($sChave, $aCamposChave);
         
         
         $oEtapaApont = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
         $aRetorno = $oEtapaApont->Persistencia->apontaIniciarEtapa($aCamposChave);
         
         echo'$("#modalApontaIniciar-btn").click();';
        // $oEtapaApont->getDadosConsulta($aDados[1], true, null);
         $oEtapaApont->getDadosGrid($aDados[1], 'gridApontaEtapa');
      }
    
   /**
    * Retorna apontamento
    */
   public function retornaApontamento($sDados){
         $aDados = explode(',', $sDados);
         $aChave = explode('&', $aDados[2]);
         $aOp= explode('=', $aChave[0]);
         $aOpEtapa = explode('=', $aChave[1]);
         
         //verifica se na tabela STEEL_PCP_OrdensFabApont a situação não está como finalizado
         $oOrdensFabApont = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
         $oOrdensFabApont->Persistencia->adicionaFiltro('op',$aOp[1]);
         $oOrdensFabApontDados = $oOrdensFabApont->Persistencia->consultarWhere();
         
         if($oOrdensFabApontDados->getSituacao()=='Finalizado'){
                $oModal = new Modal('Atenção!','Esta OP encontra-se como FINALIZADO, para alterar os lançamentos das etapas é necessário retornar para em PROCESSO!', Modal::TIPO_AVISO, false, true, true);
                echo $oModal->getRender();
                exit(); 
         }
         
       
         $oApontOp = Fabrica::FabricarController('STEEL_PCP_ordensFabItens');
         $oApontOp->Persistencia->adicionaFiltro('op',$aOp[1]);
         $oApontOp->Persistencia->adicionaFiltro('opseq',$aOpEtapa[1]);
        
         $oDados = $oApontOp->Persistencia->consultarWhere();
         //verifica caso nao tenha situacao nao retorna
         if($oDados->getSituacao()==null){
           $oModal = new Modal('Atenção!','Não há situação definida para retornar!', Modal::TIPO_AVISO, false, true, true);
           echo $oModal->getRender();
           exit(); 
         }
        //verifica a situacao, caso seja finalizado ou processo avisa e fecha a tela
        if($oDados->getSituacao()=='Processo'){
            $aRetorno = $this->Persistencia->limpaApontProcesso($aOp[1],$aOpEtapa[1]);
            if($aRetorno[0]){
                $oModal = new Modal('Sucesso!','Etapa retornado com sucesso!', Modal::TIPO_SUCESSO, false, true, true);
                echo $oModal->getRender();
                $oEtapaApont = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
                $_REQUEST['campos'] ='op='.$aOp[1];
                $oEtapaApont->getDadosGrid($aDados[1], 'gridApontaEtapa');
                exit(); 
            }
        }
        if($oDados->getSituacao()=='Finalizado'){
            $aRetorno = $this->Persistencia->retornaApontFinalizar($aOp[1],$aOpEtapa[1]);
            if($aRetorno[0]){
                $oModal = new Modal('Sucesso!','Etapa retornado com sucesso!', Modal::TIPO_SUCESSO, false, true, true);
                echo $oModal->getRender();
                $oEtapaApont = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
                $_REQUEST['campos'] ='op='.$aOp[1];
                $oEtapaApont->getDadosGrid($aDados[1], 'gridApontaEtapa');
                exit(); 
            }
        }
     }
     
      /**
     * Método para inserir apontamento
     */
    
    public function FinalizaEtapa($sDados){
         $aDados = explode(',', $sDados);
         $sChave = htmlspecialchars_decode($_REQUEST['campos']);
         $aCamposChave = array();
         parse_str($sChave, $aCamposChave);
         
         
         $oEtapaApont = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
         $aRetorno = $oEtapaApont->Persistencia->apontaFinalizaEtapa($aCamposChave);
         
         echo'$("#modalApontaFinalizar-btn").click();';
        // $oEtapaApont->getDadosConsulta($aDados[1], true, null);
         $oEtapaApont->getDadosGrid($aDados[1], 'gridApontaEtapa');
         
         //verifica se é o último apontamento
         $iEtapaFim = $this->Persistencia->verificaEtapaFinalizada($aCamposChave['op']);
         //se $iEtapaFim == 0 é necessário finalizar toda a op
         if($iEtapaFim==0){
             //finaliza a op
               echo'$("#btn_finalizargeralApontaEtapa").click();';
           
         }
      }
   
   /**
    * Modal apontamentos
    */
     public function criaTelaModalApontaFinalizar($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aOp= explode('=', $aChave[0]);
        $aOpEtapa = explode('=', $aChave[1]);
        
        $oApontOp = Fabrica::FabricarController('STEEL_PCP_ordensFabItens');
        $oApontOp->Persistencia->adicionaFiltro('op',$aOp[1]);
        $oApontOp->Persistencia->adicionaFiltro('opseq',$aOpEtapa[1]);
        
        $oDados = $oApontOp->Persistencia->consultarWhere();
        //verifica a situacao, caso seja finalizado ou processo avisa e fecha a tela
        if($oDados->getSituacao()=='Processo'){
            $oDadosProc = Fabrica::FabricarController('STEEL_PCP_ordensFabItens');
            $oDadosProc->Persistencia->adicionaFiltro('op',$aOp[1]);
            $oDadosProc->Persistencia->adicionaFiltro('situacao','Processo');
            $iCountProc = $oDadosProc->Persistencia->getCount();
            if($iCountProc > 1){
                $oModal = new Modal('Atenção!','OP tem etapas com situação em Processo!', Modal::TIPO_AVISO, false, true, true);
                echo $oModal->getRender();
                echo'$("#modalApontaFinalizar-btn").click();';
                exit(); 
            }
        }else{
           $oModal = new Modal('Atenção!','OP com situação '.$oDados->getSituacao().', não é possível finalizar o apontamento!', Modal::TIPO_AVISO, false, true, true);
           echo $oModal->getRender();
           echo'$("#modalApontaFinalizar-btn").click();';
           exit(); 
        } 
       
        
        //busca os fornos para listar
        $oFornoUser = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        $oDadosForno = $oFornoUser->pesqFornoUser();

        //---busca forno----------------------------------------------------
        $oForno = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoAtual = $oForno->buscaForno($oDadosForno->getFornocod());

        $aForno[]=$oFornoAtual;
        
        
        $oFornos = Fabrica::FabricarController('STEEL_PCP_Forno');
        $oFornoSel = $oFornos->Persistencia->getArrayModel();
        
        $aForno[]=$oFornoSel;

        //-------------------------------------------------------------------
        
        $this->View->setAParametrosExtras($oDados);

        $this->View->criaTelaModalApontaFinalizar($aForno,$aDados[1]);
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }
    
    /**
     * Mensagem para finalizar apontamento geral
     */
    
    /*
     * Mensagem de finalização da OP em processo
     */
     public function msgFinalizaOPgeral($sDados) {
         $aDados = explode(',', $sDados);
         $aCamposChave = $this->getArrayCampostela();
         
         $iEtapasNaoApont = $this->Persistencia->verificaEtapaFinalizada($aCamposChave['op']);
         
         if($iEtapasNaoApont >0){
             $oMensagem = new Modal('Atenção!', 'Atenção existem etapas não finalizadas nesta ordem de produção!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
            exit();
         }
         //valida se a ordem de produção geral não está diferente de processo
         $oApontSaida = Fabrica::FabricarController('STEEL_PCP_ordensFabApontSaida');
         $oApontSaida->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
         $oOpAtualSaida = $oApontSaida->Persistencia->consultarWhere();
         if ($oOpAtualSaida->getSituacao() !== 'Processo') {
            $oMensagem = new Modal('Atenção!', 'O apontamento da OP nº' . $aCamposChave['op'] . ' não pode ser finalizada, somente é possível finalizar OPs com situação em PROCESSO!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        } 
        
            $oMensagem = new Modal('Atenção!', 'Deseja finalizar o apontamento da OP nº' . $aCamposChave['op'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[0].'-form","STEEL_PCP_ordensFabApontEtapas","finalizaOpGeral","' . $sDados . '");');

            echo $oMensagem->getRender();
        
     }
     
     public function finalizaOpGeral($sDados){
         $aDados = explode(',', $sDados);
         $aCamposChave = $this->getArrayCampostela();
          //se passa pelas validaçoes gera a finalizacao
         $oApontSaida = Fabrica::FabricarController('STEEL_PCP_ordensFabApontSaida');
         $aRetorno = $oApontSaida->Persistencia->finalizarOP($aCamposChave);
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposChave['op'] . ' foi finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aDados[7]."').click();"; 
        } else {
            $oMensagem = new Mensagem('Erro!', 'O apontamento da OP ' . $aCamposChave['op'] . ' não foi finalizado com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            
        }
     }
    
    /*
     * Mengagem que chama posteriormente o método
     * para retornar o apontamento para Processo
     */
    public function msgRetornaApontSaida($sDados) {
        $aDados = explode(',', $sDados);
        $aCamposChave = $this->getArrayCampostela();
        
        $oOpApontSaida = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        $oOpApontSaida->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
        $oOpAtual = $oOpApontSaida->Persistencia->consultarWhere();
        
        $sClasse = $this->getNomeClasse();
        
        

        if ($oOpAtual->getSituacao() !== 'Finalizado') {
            $oMensagem = new Modal('Atenção!', 'O apontamento da OP nº' . $aCamposChave['op'] . ' não pode ser retornado, somente é possível retornar para Processo apontamentos finalizados!', Modal::TIPO_AVISO, false, true, true);
        } else {
              
            $oMensagem = new Modal('Atenção!', 'Deseja retornar o apontamento da OP nº' . $aCamposChave['op'] . ' para Processo?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[0].'-form","' . $sClasse . '","retornaOpGeral","' . $sDados . '");');            
        }
        echo $oMensagem->getRender();
    }
    
    public function retornaOpGeral($sDados){
        $aDados = explode(',', $sDados);
        $aCamposChave = $this->getArrayCampostela(); 
        
        $oOpSaida = Fabrica::FabricarController('STEEL_PCP_ordensFabApontSaida');
        $aRetorno = $oOpSaida->Persistencia->retornarOp($aCamposChave);
        if ($aRetorno[0]) {
          
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposChave['op'] . ' foi retornado para Processo!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aDados[7]."').click();"; 
        } else {
            $oMensagem = new Mensagem('Erro!', 'O apontamento da OP ' . $aCamposChave['op'] . ' não foi retornado para Processo! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            
        }
        
    }
}

