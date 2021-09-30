<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_SUP_Solicitacao extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SUP_Solicitacao');
        $this->setControllerDetalhe('STEEL_SUP_SolicitacaoItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $this->Persistencia->adicionaFiltro('FIL_Codigo', $this->Model->getDELX_FIL_Empresa()->getFil_codigo());
        $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $this->Model->getSUP_SolicitacaoSeq());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFil_codigo();
        $aRetorno[1] = $this->Model->getSUP_SolicitacaoSeq();
        return $aRetorno;
    }

    /**
     * Imprime a solicitação de material
     */
    public function acaoMostraRelEspecifico($sDados) {
        parent::acaoMostraRelEspecifico($sDados);



        $aOrd = $_REQUEST['parametrosCampos'];
        sort($aOrd);
        $sVethor = '';
        foreach ($aOrd as $key => $value) {
            $aOrdAux = explode(';', $value);
            $aOrdAux2 = explode('&', $aOrdAux[0]);
            $sVethor .= $aOrdAux[1] . '&' . $aOrdAux2[0];
        }

        $sSistema = "app/relatorio";
        $sRelatorio = 'RelSolicitacao.php?' . $sVethor;

        $sCampos .= $this->getSget();

        $sCampos .= '&email=N';

        $sCampos .= '&output=tela';
        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sRel . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if (trim($this->Model->getSUP_SolicitacaoSituacao()) != 'A' && $this->Model->getSUP_SolicitacaoFaseApr() != 99) {
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
        $this->Model->setSUP_SolicitacaoFaseApr(1);
        $this->Model->setSUP_SolicitacaoMRP(0);
        $this->Model->setSUP_SolicitacaoSituacao('A');
        $this->Model->setSUP_SolicitacaoTipo('E');
        $this->Model->setSUP_SolicitacaoCCTCod(0);
        $this->Model->setSUP_SolicitacaoUsuCanc('');
    }

    public function afterInsert() {
        parent::afterInsert();

        $aCampos = $this->getArrayCampostela();
        $this->Persistencia->adicionaFiltro('FIL_Codigo', $aCampos['FIL_Codigo']);
        $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aCampos['SUP_SolicitacaoSeq']);
        $oObjDadosSol = $this->Persistencia->consultar();
        if (trim($oObjDadosSol->getSUP_SolicitacaoSituacao()) == 'A') {
            $this->Persistencia->updateSitMontagem($oObjDadosSol);
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $aCampos = $this->getArrayCampostela();
        $this->Persistencia->adicionaFiltro('FIL_Codigo', $aCampos['FIL_Codigo']);
        $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aCampos['SUP_SolicitacaoSeq']);
        $oObjDadosSol = $this->Persistencia->consultar();
        if (trim($oObjDadosSol->getSUP_SolicitacaoSituacao()) == 'A') {
            $this->Persistencia->updateSitMontagem($oObjDadosSol);
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /*     * ****************************APLICATIVO********************************** */

    public function getDadosBadgeSolCompras($oDados) {

        $oMET_TEC_MobileFat = Fabrica::FabricarPersistencia('MET_TEC_MobileFat');
        $aPainel = $oMET_TEC_MobileFat->getPainelApp();

        $aRetorno['PainelSolCompras'] = false;
        $aDados['steeltrater'] = 0;
        $aDados['matriz'] = 0;
        $aRetorno['CountBadgeSolCompras'] = $aDados;
        foreach ($aPainel as $key => $value) {
            if ($value == 'Solicitações') {
                $aRetornoDados = $this->Persistencia->buscaBadgeSolCompras($oDados);
                $aRetorno['PainelSolCompras'] = true;
                $aRetorno['CountBadgeSolCompras'] = $aRetornoDados;
            }
        }
        return $aRetorno;
    }

    public function getDadosSolicitacaoCompras($Dados) {

        $cnpj = $Dados->cnpj;

        $aRetorno = $this->Persistencia->getDadosSolicitacaoCompras($cnpj);

        return $aRetorno;
    }

    public function getQuantidades($Dados) {
        $nr = $Dados->nr;
        $cod = $Dados->codigo;
        $cnpj = $Dados->cnpj;
        $qnt = $Dados->qnt;

        $aRetorno = array();

        intval($sRetorno = $this->Persistencia->getQuantidades($nr, $cod, $cnpj));

        if ($qnt != $sRetorno) {
            $aRetorno['retorno'] = true;
            $aRetorno['qntteste'] = $sRetorno;
        } else {
            $aRetorno['retorno'] = false;
            $aRetorno['qntteste'] = $sRetorno;
        }

        return $aRetorno;
    }

    public function alteraQuantidades($Dados) {
        $nr = $Dados->nr;
        $cod = $Dados->codigo;
        $qnt = $Dados->qnt;
        $cnpj = $Dados->cnpj;

        $bRetorno = $this->Persistencia->alteraQuantidades($nr, $cod, $qnt, $cnpj);

        if ($bRetorno[0]) {
            $aRetorno['retorno'] = true;
        } else {
            $aRetorno['retorno'] = false;
        }

        return $aRetorno;
    }

    public function gerenSolicitacaoCompra($Dados) {
        $sit = $Dados->sit;
        $nr = $Dados->nr;
        $usucodigo = $Dados->usucodigo;
        $cnpj = $Dados->cnpj;

        switch ($sit) {
            case 'a':
                $aRetorno = $this->Persistencia->gerenSolicitacaoCompra($sit, $nr, $usucodigo, $cnpj);
                $aIonic = array();
                $aIonic['retorno'] = $aRetorno[0];
                if ($aRetorno[0]) {
                    $aIonic['mensagem'] = 'APROVADA com sucesso';
                } elseif ($aRetorno[1] == 'C') {
                    $aIonic['erro'] = 'Solicitação já foi aprovada por outro sistema.';
                    $aIonic['mensagem'] = 'APROVAR';
                    $aIonic['param'] = 'C';
                } else {
                    $aIonic['erro'] = $aRetorno[1];
                    $aIonic['mensagem'] = 'APROVAR';
                }
                break;

            case 'r':
                $aRetorno = $this->Persistencia->gerenSolicitacaoCompra($sit, $nr, $usucodigo, $cnpj);
                $aIonic = array();
                $aIonic['retorno'] = $aRetorno[0];
                if ($aRetorno[0]) {
                    $aIonic['mensagem'] = 'REPROVADA com sucesso';
                } elseif ($aRetorno[1] == 'C') {
                    $aIonic['erro'] = 'Solicitação já foi reprovada por outro sistema.';
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

    public function msgLiberarSol($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oRetorno = $this->Persistencia->getSituacoes($aCamposChave);

        if ($oRetorno->sup_solicitacaofaseapr != 99 && trim($oRetorno->sup_solicitacaosituacao) != 'M') {
            $oMsg = new Mensagem('Atenção!', 'A Solicitação ' . $aCamposChave['SUP_SolicitacaoSeq'] . ' não está em condições de ser Liberada para Compras!', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();
        } else {
            $oModal = new Modal('Atenção!', 'Deseja liberara a Solicitação Nr ' . $aCamposChave['SUP_SolicitacaoSeq'] . ' para o setor de compras?', Modal::TIPO_AVISO, true, true, true);
            $oModal->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaSolicitacao","' . $sDados . '");');

            echo $oModal->getRender();
        }
    }

    public function liberaSolicitacao($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->liberaSolicitacao($aCamposChave);
        if ($aRetorno[0]) {
            $oMsg = new Mensagem('Sucesso', 'Solicitação liberada para Compras', Mensagem::TIPO_SUCESSO);
            echo '$("#' . $aDados[1] . '-pesq").click();';
        } else {
            $oMsg = new Mensagem('ERRO.', 'Não foi possível liberar a Solicitação, entre em contato com o TI!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

}
