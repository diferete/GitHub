<?php

/*
 * Implementa a classe controler STEEL_SOL_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ControllerSTEEL_SOL_Aprovacoes extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SOL_Aprovacoes');
    }

    public function criaTelaModalSteelGerenciaSolicitacao($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('FIL_Codigo', $aCamposChave['FIL_Codigo']);
        $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aCamposChave['SUP_SolicitacaoSeq']);
        $oDados = $this->Persistencia->consultarWhere();
        $sSituacao = trim($oDados->getSUP_SolicitacaoSituacao());

        if ($sSituacao == 'A') {

            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalSteelGerenciaSolicitacao();


            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'A Solicitação não está em situação de ser Aprovada/Reprovada', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalSteelGerenciaSolicitacao-btn').click();";
            echo $oMsg->getRender();
            exit;
        }
    }

    public function gerenSteelSolicitacaoCompra($sDados) {

        /* $aDados:
         * 0 -> Parametro Aprova/Reprova
         * 1 -> Parametro Modal Sim/Não
         * 2 -> ID tela de Itens
         * 3 -> ID tela de Aprovações
         * */
        $aDados = explode(',', $sDados);
        $aCampos = $this->getArrayCampostela();

        switch ($aDados[0]) {
            case 'A':
                $aRetorno = $this->Persistencia->gerenSolicitacaoCompra($aDados[0], $aCampos);
                if ($aRetorno[0]) {
                    $oMsg = new Mensagem('SOLICITAÇÃO ' . $aCampos['nrsol'], 'Foi APROVADA com sucesso!', Mensagem::TIPO_SUCESSO);
                } else {
                    $oMsg = new Mensagem('SOLICITAÇÃO ' . $aCampos['nrsol'], 'Houve um erro ao tentar APROVAR a solicitação!', Mensagem::TIPO_ERROR);
                }
                break;

            case 'R':
                $aRetorno = $this->Persistencia->gerenSolicitacaoCompra($aDados[0], $aCampos);
                if ($aRetorno[0]) {
                    $oMsg = new Mensagem('SOLICITAÇÃO ' . $aCampos['nrsol'], 'Foi REPROVADA com sucesso!', Mensagem::TIPO_SUCESSO);
                } else {
                    $oMsg = new Mensagem('SOLICITAÇÃO ' . $aCampos['nrsol'], 'Houve um erro ao tentar REPROVAR a solicitação!', Mensagem::TIPO_ERROR);
                }
                break;
        }
        echo $oMsg->getRender();
        $this->isModal($aDados);
    }

    public function isModal($aDados) {

        switch ($aDados[1]) {
            case 'N':
                $sScript = '$("#' . $aDados[2] . '").remove();'
                        . '$("#' . $aDados[3] . 'consulta").removeAttr("style");'
                        . '$("#' . $aDados[3] . '-pesq").click();';

                echo $sScript;

                break;

            default:

                echo '$("#criaModalSteelGerenciaSolicitacao-btn").click();';
                break;
        }
    }

}
