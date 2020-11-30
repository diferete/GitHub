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

        if (trim($this->Model->getSUP_SolicitacaoSituacao()) != 'A') {
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

}
