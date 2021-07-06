<?php

/*
 * Implementa a classe controler STEEL_PCP_GeraCertificado
 * 
 * @author Cleverton Hoffmann
 * @since 08/10/2018
 */

class ControllerSTEEL_PCP_GeraCertificado extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_GeraCertificado');
    }

    public function acaoRelGerencialSaldo($sDados) {

        parent::acaoMostraRelEspecifico($sDados);



        $sSistema = "app/relatorio";
        $sRelatorio = 'RelOpSteel3.php?';

        $sCampos .= $this->getSget();

        $sCampos .= '&output=tela';
        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sRel . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function acaoMostraRelCargaEtiquetas($sDados) {
        parent::acaoMostraRelEspecifico($sDados);

        $aInfo = array();
        $aInfo = $_REQUEST['parametrosCampos'];
        sort($aInfo);

        if ($aInfo == null) {
            $aInfo[0] = explode('&', $_REQUEST['campos'])[1];
        }

        $sVethor = '';
        foreach ($aInfo as $key => $value) {
            $aValor1 = explode('=', $value);
            $aValor2 = explode('&', $aValor1[1]);
            $sVethor .= 'nOp[]=' . $aValor1[1] . '&pesoBal=true&' . '&';
        }

        $sSistema = "app/relatorio";
        $sRelatorio = 'RelOpSteelCargaEtiqueta.php?' . $sVethor;

        $sCampos .= $this->getSget();

        $sCampos .= '&output=tela';
        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sRel . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function acaoMostraRelCargaEtiquetasLeitor($sDados) {
        parent::acaoMostraRelEspecifico($sDados);

        $aInfo = array();
        $aInfo = $_REQUEST['parametrosCampos'];
        sort($aInfo);

        if ($aInfo == null) {
            $aInfo[0] = explode('&', $_REQUEST['campos'])[1];
        }

        $sVethor = '';
        foreach ($aInfo as $key => $value) {
            $aValor1 = explode('=', $value);
            $aValor2 = explode('&', $aValor1[1]);
            $sVethor .= 'nOp[]=' . $aValor1[1] . '&pesoBal=true&parD=true' . '&';
        }

        $sSistema = "app/relatorio";
        $sRelatorio = 'RelOpSteelCargaEtiqueta.php?' . $sVethor;
        $sCampos .= $this->getSget();
        $sCampos .= '&output=tela';
        $oWindow = 'var janela = window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sRel . $sCampos . '", '
                . '"STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, '
                . 'SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=500, HEIGHT=200",);'
                . 'window.setTimeout(function(){janela.close();},2000);';

        echo $oWindow;

        $aDados = explode(',', $sDados);
        $sForm = $aDados[0];
        $sCampoInc = $aDados[1];
        $sIdOP = $aDados[2];

        $oLimpa = new Base();
        $iAutoInc = $this->retornaValuInc();
        $msg = "" . $oLimpa->limpaForm($sForm) . ""
                . "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
        echo $msg;

        echo ("" . $oLimpa->focus($sIdOP) . "");
    }

}
