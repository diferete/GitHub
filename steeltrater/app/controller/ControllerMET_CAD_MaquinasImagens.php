<?php

/*
 * Implementa a classe controler MET_CAD_MaquinasImagens
 * @author Cleverton Hoffmann
 * @since 03/08/2021
 */

class ControllerMET_CAD_MaquinasImagens extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_CAD_MaquinasImagens');
    }

    public function TelaCadastraFotos($sDados) {

        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $oMaq = Fabrica::FabricarController('MET_CAD_Maquinas');
        $oMaq->Persistencia->adicionaFiltro('cod', $aCamposChave['cod']);
        $oMaq->Persistencia->adicionaFiltro('fil_codigo', $aCamposChave['fil_codigo']);
        $oDadosMaq = $oMaq->Persistencia->consultarWhere();
        if (method_exists($oDadosMaq, 'getCodigoMaq')) {
            $iDadosMaqImag = $this->Persistencia->getIncrementoFinal($aCamposChave['fil_codigo'], $oDadosMaq->getCodigoMaq());
        }
        $aArrayDados[0] = $oDadosMaq;

        if ($iDadosMaqImag !== null) {
            $aArrayDados[1] = $iDadosMaqImag;
        } else {
            $aArrayDados[1] = 1;
        }

        $this->View->setAParametrosExtras($aArrayDados);

        $this->View->setSRotina(View::ACAO_INCLUIR);
        //método antes de criar a tela
        $this->antesDeCriarTela();
        //cria a tela
        $this->View->criaTela();

        //alimenta campos busca
        $this->antesIncluir();
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        $this->View->getTela()->setAbaSel($aDados[2]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        //busca campo autoincremento para passar como parametro
        $sCampoIncremento = $this->retornaAutoInc();
        //adiciona botoes padrão 

        $this->View->addBotaoPadraoTela($sCampoIncremento);

        //função autoincremento
        $this->funcoesAutoIncremento();
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    /**
     * Método para inserir dados na tela
     * @param type $sDados
     * @param type $sCampos
     */
    public function acaoInserirImagem($sDados, $sCampos) {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        //Conta na persistencia para ver se o método é alterar ou inserir
        $oImg = Fabrica::FabricarController('MET_CAD_MaquinasImagens');
        $oImg->Persistencia->adicionaFiltro('cod', $aCamposChave['cod']);
        $oImg->Persistencia->adicionaFiltro('fil_codigo', $aCamposChave['fil_codigo']);
        $oImg->Persistencia->adicionaFiltro('seq', $aCamposChave['seq']);

        $iDadosImg = $oImg->Persistencia->getCount();
        //adiciona filtro da chave primária
        $this->parametros = $sCampos;

        //se cont = 0 segue ação incluir
        if ($iDadosImg == 0) {
            $this->acaoIncluirDet($sDados, $sCampos);
        } else {
            $this->acaoAlterarDet($sDados, $sCampos);
        }
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);
        $aParam = explode(',', $sDados);

        $this->adicionaFiltroDeMaqEmp($aParam[0], $aParam[1]);
        unset($aCampos[2]);

        //verifica se está como 
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
        echo $sScript;
    }

    /**
     * Adiciona o filtro para trazer no grid apenas os valores correspondentes á maquina e empresa
     * @param type $iFilcodigo
     * @param type $iCodMaq
     */
    public function adicionaFiltroDeMaqEmp($iFilcodigo, $iCodMaq) {
        $this->Persistencia->adicionaFiltro('fil_codigo', $iFilcodigo);
        $this->Persistencia->adicionaFiltro('cod', $iCodMaq);
    }

    public function sendDadosCamposImagem($sDados) {
        $aDados = explode(',', $sDados);

        $sChave = htmlspecialchars_decode($aDados[1]);
        $aChaveAq = array();
        parse_str($sChave, $aChaveAq);
        $this->Persistencia->adicionaFiltro('seq', $aChaveAq['seq']);
        $this->Persistencia->adicionaFiltro('cod', $aChaveAq['cod']);
        $this->Persistencia->adicionaFiltro('fil_codigo', $aChaveAq['fil_codigo']);
        $this->Model = $this->Persistencia->consultarWhere();

        if (count($aChaveAq) > 0) {
            
            echo "$('#" . $aDados[2] . "').val('" . $this->Model->getMatcod() . "');";
            echo "$('#" . $aDados[3] . "').val('" . $this->Model->getSTEEL_PCP_material()->getMatdes() . "');";
            echo "$('#" . $aDados[4] . "').val('" . $this->Model->getCod() . "');";
            echo "$('#" . $aDados[5] . "').val('" . $this->Model->getSTEEL_PCP_receitas()->getPeca() . "');";
            echo "$('#" . $aDados[6] . "').val('" . $this->Model->getSeqmat() . "');";
            echo "$('#" . $aDados[7] . "').val('" . number_format($this->Model->getSTEEL_PCP_receitas()->getTemprev(), 3, ',', '.') . "');";
        
        } else {
            
            echo "$('#" . $aDados[2] . "').val('');";
            echo "$('#" . $aDados[3] . "').val('');";
            echo "$('#" . $aDados[4] . "').val('');";
            echo "$('#" . $aDados[5] . "').val('');";
            echo "$('#" . $aDados[6] . "').val('');";
            echo "$('#" . $aDados[7] . "').val('0');";
            
        }
    }

}
