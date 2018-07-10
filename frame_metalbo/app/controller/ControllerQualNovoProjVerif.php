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

        $oRespValProj = $_SESSION['nome'];
        $oUsutipoVal = $_SESSION['usutipo'];

        if ($oRespValProj == 'Eloir Jordelino' || $oUsutipoVal == '1') {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $oMensagem = new Modal('Alteração inválida', 'Você não tem autorização para alterar ou inserir dados nessa tela... Contate um administrador ou o setor de TI', Modal::TIPO_ERRO, false, true, false);
            echo $oMensagem->getRender();
            //$this->getTela()->setBFecharTelaIncluir(true);
            return;
        }
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $oNr = $this->Model->getNr();

        $this->Persistencia->verifValProj($oNr);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
