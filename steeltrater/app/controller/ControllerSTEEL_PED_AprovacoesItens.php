<?php

/*
 * Implementa a classe controler STEEL_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class ControllerSTEEL_PED_AprovacoesItens extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PED_AprovacoesItens');
    }

    public function TelaVisualizaItens($sDados) {

        $this->View->setSRotina(View::ACAO_VISUALIZAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oSTEEL_PED_Aprovacoes = Fabrica::FabricarController('STEEL_PED_Aprovacoes');
        $oSTEEL_PED_Aprovacoes->Persistencia->adicionaFiltro('FIL_Codigo', $aCamposChave['FIL_Codigo']);
        $oSTEEL_PED_Aprovacoes->Persistencia->adicionaFiltro('SUP_PedidoSeq', $aCamposChave['SUP_PedidoSeq']);
        $oDados = $oSTEEL_PED_Aprovacoes->Persistencia->consultarWhere();
        $sSituacao = trim($oDados->getSUP_PedidoSituacao());

        $aCamposChave['sit'] = $sSituacao;
        $aCamposChave['idtela'] = $aDados[1];

        $this->View->setAParametrosExtras($aCamposChave);

        //cria a tela
        $this->View->criaTela();

        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
        //adiciona botoes padrão
        if (!$this->getBDesativaBotaoPadrao()) {
            $this->View->addBotaoPadraoTela('');
        }
        //renderiza a tela


        $this->View->getTela()->getRender();
    }

}
