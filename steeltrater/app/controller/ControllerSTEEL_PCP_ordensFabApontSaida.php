<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 25/07/2018
 */

class ControllerSTEEL_PCP_ordensFabApontSaida extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabApontSaida');
    }
    
    /**
     * antes de criar a consulta coloca como filtro o forno padrao do usuário
     * @param type $sParametros
     */
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
     /*   $oUserForno = Fabrica::FabricarController('STEEL_PCP_fornoUser');
        
        $oFornoUser = $oUserForno->pesqFornoUser();
        
        if(isset($_COOKIE['cookfornocod'])){
            $sForno = $_COOKIE['cookfornocod'];
        }else{
        if (method_exists($oFornoUser,'getFornocod')){
            $sForno=$oFornoUser->getFornocod();
        }}
        
        //caso o campo esteja selecionado um forno ele deve limpar e filtrar por esse forno
        
        
        
        $this->Persistencia->adicionaFiltro('fornocod',$sForno);*/
    }
    /*
     * Mensagem de finalização da OP em processo
     */
     public function msgFinalizaOP($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();
        
       
        if ($oOpAtual->getSituacao() !== 'Processo') {
            $oMensagem = new Modal('Atenção!', 'O apontamento da OP nº' . $aCamposChave['op'] . ' não pode ser finalizada, somente é possível finalizar apontamentos em processo!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
        } else {
              
            $oMensagem = new Modal('Atenção!', 'Deseja finalizar o apontamento da OP nº' . $aCamposChave['op'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[3].'-form","' . $sClasse . '","finalizaOP","' . $sDados . '");');

            echo $oMensagem->getRender();
        }
    }
    /*      
     * Finaliza a OP
     */
    public function finalizaOP($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //chama o método na persistencia
        $aRetorno = $this->Persistencia->finalizarOp($aCamposChave);

        if ($aRetorno[0]) {
          
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposChave['op'] . ' foi finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aDados[1]."-pesq').click();"; 
        } else {
            $oMensagem = new Mensagem('Erro!', 'O apontamento da OP ' . $aCamposChave['op'] . ' não foi finalizado com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            
        }
       
    }
    
    /*      
     * Finaliza a OP
     */
    public function finalizaOPTurnoSaida($sDados) {
        
        $aId = explode(',', $sDados);
        
        $aCamposTela = $this->getArrayCampostela();
        
         $oOuser = Fabrica::FabricarController('MET_TEC_Usuario');
        $oOuser->Persistencia->adicionaFiltro('usucodigo',$_SESSION['codUser']);
        $oOuserDados = $oOuser->Persistencia->consultarWhere();
        if($oOuserDados->getTurnoSteel()==null||$oOuserDados->getTurnoSteel()=='Nenhum'||$oOuserDados->getTurnoSteel()==''){
           $oMensagem = new Modal('Atenção!', 'O usuário não tem cadastro de turno, cadastre um turno para o usuário!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }
        
        $this->Persistencia->adicionaFiltro('op', $aCamposTela['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();
        
        if ($oOpAtual->getSituacao() !== 'Processo') {
            $oMensagem = new Modal('Atenção!', 'O apontamento da OP nº' . $aCamposTela['op'] . ' não pode ser finalizada, somente é possível finalizar apontamentos em processo!', Modal::TIPO_AVISO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }
        
        
        //chama o método na persistencia
        $aRetorno = $this->Persistencia->finalizarOPTurno($aCamposTela);

        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposTela['op'] . ' foi finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aId[0]."-pesq').click();"; 
            echo "$('#modalApontaFinalizarSemEtapa-btn').click();"; 
        } else {
            $oMensagem = new Mensagem('Erro!', 'O apontamento da OP ' . $aCamposTela['op'] . ' não foi finalizado com sucesso! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            
        }
       
    }
    
    /*
     * Mengagem que chama posteriormente o método
     * para retornar o apontamento para Processo
     */
    public function msgRetornaApontSaida($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
        $oOpAtual = $this->Persistencia->consultarWhere();

        if ($oOpAtual->getSituacao() !== 'Finalizado') {
            $oMensagem = new Modal('Atenção!', 'O apontamento da OP nº' . $aCamposChave['op'] . ' não pode ser retornado, somente é possível retornar para Processo apontamentos finalizados!', Modal::TIPO_AVISO, false, true, true);
        } else {
              
            $oMensagem = new Modal('Atenção!', 'Deseja retornar o apontamento da OP nº' . $aCamposChave['op'] . ' para Processo?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("'.$aDados[3].'-form","' . $sClasse . '","retornaOP","' . $sDados . '");');            
        }
        echo $oMensagem->getRender();
    }
    /*  
     * Retorna OP para Processo
     */
    public function retornaOP($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //chama o método na persistencia
        $aRetorno = $this->Persistencia->retornarOp($aCamposChave);

        if ($aRetorno[0]) {
          
            $oMensagem = new Mensagem('Atenção!', 'O apontamento da OP ' . $aCamposChave['op'] . ' foi retornado para Processo!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#".$aDados[1]."-pesq').click();"; 
        } else {
            $oMensagem = new Mensagem('Erro!', 'O apontamento da OP ' . $aCamposChave['op'] . ' não foi retornado para Processo! >>>>' . $aRetorno[1], Mensagem::TIPO_ERROR);
            echo $oMensagem->getRender();
            
        }
       
    }
    
    public function beforFiltroConsulta($sParametros = null) {
        parent::beforFiltroConsulta($sParametros);
        //array_pop($cesta);
        if ($_REQUEST['parametrosCampos']) {
                foreach ($_REQUEST['parametrosCampos'] as $sAtual) {
                    $aFiltros[] = explode('|', $sAtual);
                }
            }
            //caso de não se informar o forno
            if($aFiltros['2']['1']=='--'){
               array_pop($_REQUEST['parametrosCampos']); 
               
               $oUserForno = Fabrica::FabricarController('STEEL_PCP_fornoUser');
               $oFornoUser = $oUserForno->pesqFornoUser();

                if(isset($_COOKIE['cookfornocod'])){
                    $sForno = $_COOKIE['cookfornocod'];
                }else{
                if (method_exists($oFornoUser,'getFornocod')){
                    $sForno=$oFornoUser->getFornocod();
                }}
                $this->Persistencia->adicionaFiltro('fornocod',$sForno);
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
        
        $oOpApont = Fabrica::FabricarController('STEEL_PCP_ordensFabApontEnt');
        $oOpApont->Persistencia->adicionaFiltro('op',$aOp[1]);
        $oDadosApont = $oOpApont->Persistencia->consultarWhere();
        
        echo '$("#modalApontaFinalizarSemEtapa-modal >").remove();';
        
        $this->View->criaTelaModalApontaFinalizar($oDadosApont);
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }
}    
