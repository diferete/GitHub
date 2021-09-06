<?php

/*
 * Implementa a classe controler MET_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class ControllerMET_PED_AprovacoesItens extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PED_AprovacoesItens');
    }

    public function TelaVisualizaItens($sDados) {

        $this->View->setSRotina(View::ACAO_VISUALIZAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oMET_PED_Aprovacoes = Fabrica::FabricarPersistencia('MET_PED_Aprovacoes');
        $sSituacao = $oMET_PED_Aprovacoes->getSituaca($aCamposChave);

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
