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

    public function getDadosBadgeCompras() {

        $oMET_TEC_MobileFat = Fabrica::FabricarPersistencia('MET_TEC_MobileFat');
        $aPainel = $oMET_TEC_MobileFat->getPainelApp();

        foreach ($aPainel as $key => $value) {
            if ($value == 'Compras') {
                $aRetornoDados = $this->Persistencia->buscaBadgeCompras();

                $aRetorno['PainelCompras'] = true;
                $aRetorno['CountBadgeCompras'] = $aRetornoDados;
                return $aRetorno;
            }
        }
    }

    public function getDadosPedidoCompras($Dados) {

        $dia = date('d', strtotime($Dados->mes));
        $mes = date('m', strtotime($Dados->mes));
        $ano = date('Y', strtotime($Dados->mes));

        $cnpj = $Dados->cnpj;


        //primeiro dia
        $dataInicial = "01/$mes/$ano";

        $dataFinal = date("t", mktime(0, 0, 0, $mes, '01', $ano)) . '/' . $mes . '/' . $ano; // Mágica, plim!  

        $aRetorno = $this->Persistencia->getPedidosCompra($dataInicial, $dataFinal, $cnpj);

        return $aRetorno;
    }

    public function gerenPedidoCompra($Dados) {
        $sit = $Dados->sit;
        $seq = $Dados->seq;
        $cnpj = $Dados->cnpj;
        $usucodigo = $Dados->usucodigo;

        switch ($sit) {
            case 'a':
                $aRetorno = $this->Persistencia->gerenPedidoCompra($sit, $seq, $cnpj, $usucodigo);
                $aIonic = array();
                $aIonic['retorno'] = $aRetorno[0];
                if ($aRetorno[0]) {
                    $aIonic['mensagem'] = 'aprovada com sucesso';
                } else {
                    $aIonic['erro'] = $aRetorno[1];
                    $aIonic['mensagem'] = 'aprovar';
                }

                break;

            case 'r':
                $aRetorno = $this->Persistencia->gerenPedidoCompra($sit, $seq, $cnpj, $usucodigo);
                $aIonic = array();
                $aIonic['retorno'] = $aRetorno[0];
                if ($aRetorno[0]) {
                    $aIonic['mensagem'] = 'reprovada com sucesso';
                } else {
                    $aIonic['erro'] = $aRetorno[1];
                    $aIonic['mensagem'] = 'reprovar';
                }
                break;
        }

        return $aIonic;
    }

}
