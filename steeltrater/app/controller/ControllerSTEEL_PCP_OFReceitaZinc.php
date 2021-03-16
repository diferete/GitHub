<?php

/*
 * Controller da classe alteração da receita zincagem na ordens fabricação
 * @author Cleverton Hoffmann
 * @since 25/02/2021
 */

class ControllerSTEEL_PCP_OFReceitaZinc extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_OFReceitaZinc');
    }

    public function TelaAlteraZincagem($sDados) {

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

        $this->verificaTipoZincagem();
        $this->apontaReceitaZincagem();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        //atualiza itens da orden de fabricação
        $oFabintens = Fabrica::FabricarController('STEEL_PCP_OrdensFabItens');
        $oFabintens->itensOrdemZincagem($this->Model);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Método responsável por inserir apontamento caso seja zincagem ou têmpera/zincagem
     */
    public function apontaReceitaZincagem() {

        if ($this->Model->getSituacao() == 'Finalizado') {
            $oModal = new Modal('Atenção!', 'Essa op já está finalizada e não pode ser alterada!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            exit();
        }

        if ($this->Model->getReceita_zinc() !== '' && $this->Model->getReceita_zinc() !== null) {
            $this->Model->setProcessozinc('S');
        }
    }

    public function verificaTipoZincagem() {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oControllerReceitaZinc = Fabrica::FabricarController('STEEL_PCP_receitas');
        $oControllerReceitaZinc->Persistencia->adicionaFiltro('cod', $aCamposChave['receita_zinc']);
        $oSteelDados = $oControllerReceitaZinc->Persistencia->consultarWhere();

        if ($oSteelDados->getTipoReceita() != 'Zincagem') {
            echo "$('#Zincar').val('');";
            echo "$('#ZincarDes').val('');";
            $oMenSuccess = new Mensagem("Atenção", "Receita Zincagem Incorreta!", Mensagem::TIPO_ERROR);
            echo $oMenSuccess->getRender();
            exit();
        }
    }

}
