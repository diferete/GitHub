<?php

class ControllerNoticiaSite extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('NoticiaSite');
    }

    public function getFeed($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->liberaNoticia('');

        echo json_encode($aRetorno);
    }

    public function getNoticias($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->buscaNoticia('');

        echo json_encode($aRetorno);
    }

    public function carregaTexto($sDados) {
        $aDados = explode('&', $sDados);
        $aChaveNR = explode(',', $aDados[0]);
        $aChaveFilcgc = explode(',', $aDados[1]);
        $aChaveCNPJ = explode(';', $aChaveFilcgc[0]);
        $aCamposChaveNR = explode('=', $aChaveNR[1]);
        $aCamposChaveCNPJ = explode('=', $aChaveCNPJ[1]);

        $this->Persistencia->adicionaFiltro($aCamposChaveNR[0], $aCamposChaveNR[1]);
        $this->Persistencia->adicionaFiltro($aCamposChaveCNPJ[0], $aCamposChaveCNPJ[1]);
        $oDados = $this->Persistencia->consultarWhere();

        $oDados->setTexto(str_replace("\n", " ", $oDados->getTexto()));
        $oDados->setTexto(str_replace("'", "\'", $oDados->getTexto()));
        $oDados->setTexto(str_replace("\r", "", $oDados->getTexto()));
        $oDados->setTexto(str_replace('"', '\"', $oDados->getTexto()));

        $sTexto = $oDados->getTexto();
        echo '$("#' . $aChaveFilcgc[1] . '").val("' . $sTexto . '");';
    }

}
