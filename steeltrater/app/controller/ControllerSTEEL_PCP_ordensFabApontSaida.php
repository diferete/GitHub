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
    
}    
