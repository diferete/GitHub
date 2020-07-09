<?php

class ControllerQualNovoProjVerif extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualNovoProjVerif');
    }

    public function TelaCadVerif($sDados) {

        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        //procedimentos antes de criar a tela
        $this->antesAlterar($aDados);
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

    public function beforeUpdate() {
        parent::beforeUpdate();
        if (($this->Model->getEnsReq() != null ||
                $this->Model->getEnsReqDef() != null ||
                $this->Model->getEnsReqLegal() != null) && $this->Model->getRespEns() == '') {
            $this->Model->setRespEns($_SESSION['nome']);
            $this->Model->setDtanaliseens(date('d/m/Y'));
        }


        if (($this->Model->getEtapProj() != null ||
                $this->Model->getResult() != null ||
                $this->Model->getCliprov() != null ||
                $this->Model->getValproj() != null ) && $this->Model->getRespvalproj() == '') {
            $this->Model->setRespvalproj($_SESSION['nome']);
            $this->Model->setDtanalisevalproj(date('d/m/Y'));
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $oNr = $this->Model->getNr();
        $oFilcgc = $this->Model->getEmpRex()->getFilcgc();

        $this->Persistencia->verifValProj($oFilcgc, $oNr);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
