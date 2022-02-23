<?php

/*
 * Implementa a classe controler MET_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ControllerMET_PED_Aprovacoes extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PED_Aprovacoes');
    }

    public function criaTelaModalMetGerenciaPedido($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sSituacao = $this->Persistencia->getSituaca($aCamposChave);

        if ($sSituacao == 'N') {

            $this->View->setAParametrosExtras($aCamposChave);

            $this->View->criaModalMetGerenciaPedido();


            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'O Pedido não está em situação de ser Aprovado/Reprovado', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalMetGerenciaPedido-btn').click();";
            echo $oMsg->getRender();
            exit;
        }
    }

    public function gerenMetPedidoCompra($sDados) {

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
                $aRetorno = $this->Persistencia->gerenPedidoCompra($aDados[0], $aCampos);
                if ($aRetorno[0]) {
                    $oMsg = new Mensagem('PEDIDO ' . $aCampos['nrsol'], 'Foi APROVADO com sucesso!', Mensagem::TIPO_SUCESSO);
                } else {
                    $oMsg = new Mensagem('PEDIDO ' . $aCampos['nrsol'], 'Houve um erro ao tentar APROVAR o pedido!', Mensagem::TIPO_ERROR);
                }
                break;

            case 'R':
                $aRetorno = $this->Persistencia->gerenPedidoCompra($aDados[0], $aCampos);
                if ($aRetorno[0]) {
                    $oMsg = new Mensagem('PEDIDO ' . $aCampos['nrsol'], 'Foi REPROVADO com sucesso!', Mensagem::TIPO_SUCESSO);
                } else {
                    $oMsg = new Mensagem('PEDIDO ' . $aCampos['nrsol'], 'Houve um erro ao tentar REPROVAR o pedido!', Mensagem::TIPO_ERROR);
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

                echo '$("#criaModalMetGerenciaPedido-btn").click();';
                break;
        }
    }

    public function acaoMostraRelConsulta($sParametros, $sRel) {
        parent::acaoMostraRelConsulta($sParametros, $sRel);

        $Retorno = $this->beforeMostraRelConsulta($sParametros);

        //Explode string parametros
        $aDados = explode(',', $sParametros);

        $sCampos = htmlspecialchars_decode($aDados[2]);

        $sCampos .= '&dir=' . $_SESSION['diroffice'];

        $aRel = explode(',', $sRel);

        $sSistema = "app/relatorio";
        $sRelatorio = $aRel[0] . '.php?' . $aRel[1] . '&';

        $sCampos .= $this->getSget();

        $sCampos .= $this->beforeRel($sParametros);

        if ($aRel[1] != 'email') {
            //verifica se é sem logo
            if ($aRel[1] == 'slogo') {
                $sCampos .= '&logo=semlogo';
            }
            $sCampos .= '&output=tela';
            $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sRel . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
            echo $oWindow;
        } else {
            if ($aRel[4] == 'slogo') {
                $sCampos .= '&logo=semlogo';
            }
            $sCampos .= '&output=email';
            $oWindow = 'var win = window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "1366002941508","width=100,height=100,left=375,top=330");'
                    . 'setTimeout(function () { win.close();}, 1000);';
            echo $oWindow;

            $oMensagem = new Mensagem("Aguarde", "Seu e-mail está sendo processado", Mensagem::TIPO_INFO);
            echo $oMensagem->getRender();
            echo 'requestAjax("","' . $aRel[2] . '","' . $aRel[3] . '","' . $sParametros . '");';
        }
    }

}
