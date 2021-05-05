<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_SUP_PedidoCompra extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SUP_PedidoCompra');
        $this->setControllerDetalhe('STEEL_SUP_PedidoCompraItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $aCondPag = $this->Persistencia->buscaCondPag();

        $this->View->setOObjTela($aCondPag);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('FIL_Codigo', $this->Model->getDELX_FIL_Empresa()->getFil_codigo());
        $this->Persistencia->adicionaFiltro('SUP_PedidoSeq', $this->Model->getSUP_PedidoSeq());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFil_codigo();
        $aRetorno[1] = $this->Model->getSUP_SolicitacaoSeq();
        return $aRetorno;
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if (trim($this->Model->getSUP_PedidoSituacao()) != 'A') {
            $aOrdem = explode('=', $sChave);
            $oMensagem = new Mensagem('Atenção!', 'A solicitação não pode ser alterada somente visualizado!', Mensagem::TIPO_ERROR);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->carregaDefault();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->carregaDefault();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function carregaDefault() {
        $this->Model->setSUP_PedidoObservacao('');
        $this->Model->setSUP_PedidoMoedaData('1753-01-01 00:00:00.000');
        $this->Model->setSUP_PedidoMoedaValorNeg(0);
        $this->Model->setSUP_PedidoCCTCod(0);
        $this->Model->setSUP_PedidoFornecedorEnd(0);
        $this->Model->setSUP_PedidoFornecedorAssociado('N');
        $this->Model->setSUP_PedidoDataValidade('1753-01-01 00:00:00.000');
        $this->Model->setSUP_PedidoBxPrevisao('N');
    }

    public function getDadosBadgeCompras($oDados) {

        $oMET_TEC_MobileFat = Fabrica::FabricarPersistencia('MET_TEC_MobileFat');
        $aPainel = $oMET_TEC_MobileFat->getPainelApp();

        $aRetorno['PainelCompras'] = false;
        $aDados['steeltrater'] = 0;
        $aDados['filial'] = 0;
        $aDados['matriz'] = 0;
        $aRetorno['CountBadgeCompras'] = $aDados;
        foreach ($aPainel as $key => $value) {
            if ($value == 'Compras') {
                $aRetornoDados = $this->Persistencia->buscaBadgeCompras($oDados);
                $aRetorno['PainelCompras'] = true;
                $aRetorno['CountBadgeCompras'] = $aRetornoDados;
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
                    $aIonic['mensagem'] = 'aprovada com sucesso';
                } else {
                    $aIonic['erro'] = $aRetorno[1];
                    $aIonic['mensagem'] = 'aprovar';
                }

                break;

            case 'r':
                $aRetorno = $this->Persistencia->gerenPedidoCompra($sit, $nr, $cnpj, $usucodigo);
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
