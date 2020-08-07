<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 15/02/2019
 */

class ControllerSTEEL_PCP_ProdutoFilial extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ProdutoFilial');
    }
    
    public function criaTelaModalFilialProd($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aProCodigo = explode ('=', $aChave[0]);
        $sProCodigo = $aProCodigo[1];
        
        $this->Persistencia->adicionaFiltro('pro_codigo',$sProCodigo);
        $this->Persistencia->adicionaFiltro('fil_codigo','8993358000174');
        $oDados = $this->Persistencia->consultarWhere();
        $this->View->setAParametrosExtras($oDados);

        $this->View->criaModalFilial($sProCodigo);

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }
    /**
     * SOMENTE PARA A STEELTRATER ATENÇÃO
     * @return boolean
     */
    public function bloquearProd(){
      
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
       
        $this->Persistencia->adicionaFiltro('pro_codigo',$aCamposChave['pro_codigo']);
        //$oProCod = $this->Persistencia->consultarWhere();
        $aCamposChave['fil_codigo']='8993358000174';   //$oProCod->getFil_codigo();        
        if($aCamposChave['motivo']==""){
            $oMensagem = new Modal('Bloqueio não Realizado!','Motivo de Bloqueio Obrigatório!', Modal::TIPO_ERRO);
            echo $oMensagem->getRender();
            return false;
        } 
        if($aCamposChave['data']==""){
            $oMensagem = new Modal('Bloqueio não Realizado!','Data de Bloqueio Obrigatória!', Modal::TIPO_ERRO);
            echo $oMensagem->getRender();
            return false;
        } 
        $aRetorno = $this->Persistencia->bloqueioProd($aCamposChave);
        if ($aRetorno[0]) {
            $oMensagem = new Modal('Bloqueio Realizado!','O produto foi bloqueado com sucesso!', Modal::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        }else{
            $oMensagem = new Modal('Bloqueio não Realizado!','O produto não foi bloqueado!', Modal::TIPO_ERRO);
            echo $oMensagem->getRender();
        }
        return true;
    }
    /**
     * SOMENTE PARA A STEELTRATER ATENÇÃO
     * @return boolean
     */
    public function desBloquearProd(){

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $this->Persistencia->adicionaFiltro('pro_codigo',$aCamposChave['pro_codigo']);
       // $oProCod = $this->Persistencia->consultarWhere();
        $aCamposChave['fil_codigo']='8993358000174';//$oProCod->getFil_codigo();
        $aRetorno = $this->Persistencia->desBloqueioProd($aCamposChave);
        if ($aRetorno[0]) {
            $oMensagem = new Modal('Desbloqueio Realizado!','O produto foi desbloqueado com sucesso!', Modal::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        }else{
            $oMensagem = new Modal('Desbloqueio não realizado!','O produto não foi desbloqueado!', Modal::TIPO_ERRO);
            echo $oMensagem->getRender();
        }
        return true;
    }
    
    
}