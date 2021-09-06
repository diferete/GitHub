<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_SUP_PedidoCompra extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SUP_PedidoCompra');
    }

    /*     * *********************APLICATIVO************************* */

    public function getDadosBadgePedCompras($oDados) {

        $oMET_TEC_MobileFat = Fabrica::FabricarPersistencia('MET_TEC_MobileFat');
        $aPainel = $oMET_TEC_MobileFat->getPainelApp();

        $aRetorno['PainelPedidoCompras'] = false;
        $aDados['steeltrater'] = 0;
        $aDados['filial'] = 0;
        $aDados['matriz'] = 0;
        $aRetorno['CountBadgePedCompras'] = $aDados;
        foreach ($aPainel as $key => $value) {
            if ($value == 'Compras') {
                $aRetornoDados = $this->Persistencia->buscaBadgePedCompras($oDados);
                $aRetorno['PainelPedidoCompras'] = true;
                $aRetorno['CountBadgePedCompras'] = $aRetornoDados;
            }
        }
        return $aRetorno;
    }

    public function getDadosPedidoCompras($Dados) {

        $cnpj = $Dados->cnpj;
        $usucodigo = $Dados->usucodigo;


        $aRetorno = $this->Persistencia->getPedidosCompra($cnpj, $usucodigo);

        return $aRetorno;
    }

    public function gerenPedidoCompra($Dados) {
        $sit = $Dados->sit;
        $nr = $Dados->seq;
        $cnpj = $Dados->cnpj;
        $usucodigo = $Dados->usucodigo;

        switch ($sit) {
            case 'a':
                $aRetorno = $this->Persistencia->gerenPedidoCompra($sit, $nr, $cnpj, $usucodigo);
                $aIonic = array();
                $aIonic['retorno'] = $aRetorno[0];
                if ($aRetorno[0]) {
                    $aIonic['mensagem'] = 'APROVADO com sucesso';
                } elseif ($aRetorno[1] == 'C') {
                    $aIonic['erro'] = 'Pedido já foi aprovado por outro sistema.';
                    $aIonic['mensagem'] = 'APROVAR';
                    $aIonic['param'] = 'C';
                } else {
                    $aIonic['erro'] = $aRetorno[1];
                    $aIonic['mensagem'] = 'APROVAR';
                }

                break;

            case 'r':
                $aRetorno = $this->Persistencia->gerenPedidoCompra($sit, $nr, $cnpj, $usucodigo);
                $aIonic = array();
                $aIonic['retorno'] = $aRetorno[0];
                if ($aRetorno[0]) {
                    $aIonic['mensagem'] = 'REPROVADO com sucesso';
                } elseif ($aRetorno[1] == 'C') {
                    $aIonic['erro'] = 'Pedido já foi reprovado por outro sistema.';
                    $aIonic['mensagem'] = 'REPROVAR';
                    $aIonic['param'] = 'C';
                } else {
                    $aIonic['erro'] = $aRetorno[1];
                    $aIonic['mensagem'] = 'REPROVAR';
                }
                break;
        }

        return $aIonic;
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
