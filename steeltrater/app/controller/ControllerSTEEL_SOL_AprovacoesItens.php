<?php

/*
 * Implementa a classe controler STEEL_SOL_AprovacoesItens
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ControllerSTEEL_SOL_AprovacoesItens extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SOL_AprovacoesItens');
    }

    public function TelaVisualizaItens($sDados) {

        $this->View->setSRotina(View::ACAO_VISUALIZAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oSTEEL_SOL_Aprovacoes = Fabrica::FabricarController('STEEL_SOL_Aprovacoes');
        $oSTEEL_SOL_Aprovacoes->Persistencia->adicionaFiltro('FIL_Codigo', $aCamposChave['FIL_Codigo']);
        $oSTEEL_SOL_Aprovacoes->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aCamposChave['SUP_SolicitacaoSeq']);
        $oDados = $oSTEEL_SOL_Aprovacoes->Persistencia->consultarWhere();
        $sSituacao = trim($oDados->getSUP_SolicitacaoSituacao());

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

    public function gravaQnt($sDados) {
        $aDados = explode(',', $sDados);
        $this->carregaModelString($aDados[3]);
        //$aRetorno = $this->Persistencia->alteraOd($aDados[2], $this->Model->getPdv_PedidoFilial(), $this->Model->getPdv_pedidocodigo(), $this->Model->getPdv_pedidoitemseq());
        $aRetorno = $this->Persistencia->alteraQt($aDados[2], $this->Model->getFil_codigo(), $this->Model->getSup_solicitacaoseq(), $this->Model->getSup_solicitacaoitemseq());

        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso!', 'Valor alterado.', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Mensagem('Atenção!', 'Valor não foi alterado, é necessário informar um valor válido para alterar!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
        }
    }

}
