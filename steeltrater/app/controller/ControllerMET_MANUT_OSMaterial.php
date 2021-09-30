<?php

/*
 * Implementa a classe controler MET_MANUT_OSMaterial
 * @author Cleverton Hoffmann
 * @since 24/08/2021
 */

class ControllerMET_MANUT_OSMaterial extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_MANUT_OSMaterial');
    }

    public function acaoInserirMaterial() {

        $aCampos = $this->getArrayCampostela();
        $this->verificacaoAntesDeInserirMaterial($aCampos);
        //Adiciona filtros da classe pai antes de inserir verificando e para trazer autoincremento
        $oOS = Fabrica::FabricarController('MET_MANUT_OS'); 
        $oOS->Persistencia->adicionaFiltro('fil_codigo', $aCampos['fil_codigo']);
        $oOS->Persistencia->adicionaFiltro('nr', $aCampos['nr']);
        $oOS->Persistencia->adicionaFiltro('cod', $aCampos['cod']);
        $Model = $oOS->Persistencia->consultarWhere();
        $iInc = $this->Persistencia->getIncrementoMat($Model);
        $aCampos['seq']= (int)$iInc;

        $this->acaoIncluirDetMat($aCampos);

    }

    public function acaoIncluirDetMat($aCamposChave) {

        $aRetorno = $this->Persistencia->inserirMat($aCamposChave);

        if ($aRetorno[0]) {
            $oMsg = new Mensagem('INSERIDO COM SUCESSO', 'Seu registro foi inserido!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            $this->recarregarGrid();
        } else {
            $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
    }

    public function msgExcluirMaterial($sDados) {

        $aCampos = $this->getArrayCampostela();

        $oMensagem = new Modal('Atenção', 'Deseja excluir o material seq ' . $aCampos['seq'] . ' da manutenção!', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_MANUT_OSMaterial","excluirMaterial","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function excluirMaterial($sChave) {
        $aDados = explode(',', $sChave);
        $aCamposChave = array();
        parse_str($aDados[2], $aCamposChave);
        $aRetorno = $this->Persistencia->excluirMat($aCamposChave);

        if ($aRetorno[0]) {
            $oMsg = new Mensagem('EXCLUÍDO COM SUCESSO', 'Seu registro foi excluído!', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            $this->recarregarGrid();
        } else {
            $oMsg = new Mensagem('ERRO AO EXCLUIR', 'Seu registro não foi excluído!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
    }

    /**
     * Método responsável por dar um click após o alterar ou excluir no botão atualizar do grid
     * E após inserir dar um reset no form
     * @param type $aCamposChaveAux
     * @return string
     */
    public function recarregarGrid() {

        if ($_REQUEST['metodo'] == 'excluirMaterial') {
            echo "$('#btn_atualizarGridManut').click();";
        } else {
            $sScript = '$("#formMET_MANUT_OS-form").each (function(){ this.reset();});';
            echo $sScript;
            echo "$('#btn_atualizarGridManut').click(); ";
        }
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    /**
     * Método que busca os dados pelo getArrayCamposTela e adiciona filtro antes da consulta do grid
     */
    public function afterGetdadoGrid() {
        parent::afterGetdadoGrid();
        
        $this->Persistencia->limpaFiltro();
        $aCampos = $this->getArrayCampostela();
        
        $this->Persistencia->adicionaFiltro('fil_codigo',$aCampos['fil_codigo']);
        $this->Persistencia->adicionaFiltro('nr',$aCampos['nr']);
        
    }
    
    public function verificacaoAntesDeInserirMaterial($aCampos){
        if ($aCampos['MET_MANUT_OSPesqProd_pro_codigo'] == null || $aCampos['MET_MANUT_OSPesqProd_pro_codigo'] == '') {
            $oMensagem = new Mensagem('Atenção!', 'Material inexistente, digite um código válido!', Mensagem::TIPO_ERROR, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#CodmaterialManOs").val("");'
                    . '$("#materialManOs").val("");'
                    . '$("#CodmaterialManOs").val("").focus();';
            echo $sScript;
            exit;
        }        
        if ($aCampos['matnecessario'] == null || $aCampos['matnecessario'] == '') {
            $oMensagem = new Mensagem('Atenção!', 'Material inexistente, digite uma descrição válida!', Mensagem::TIPO_ERROR, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#materialManOs").val("").focus();';
            echo $sScript;
            exit;
        }
        if ($aCampos['quantidade'] == null || $aCampos['quantidade'] == '' || $aCampos['quantidade'] == 0) {
            $oMensagem = new Mensagem('Atenção!', 'Necessário informar quantidade, digite um valor válido!', Mensagem::TIPO_ERROR, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#QuantMaterialManOs").val("").focus();';
            echo $sScript;
            exit;
        }
        if ($aCampos['MET_MANUT_OSPesqProd_pro_codigo'] == 0 && ($aCampos['obsmat'] == '' || $aCampos['obsmat'] == null)) {
            $oMensagem = new Mensagem('Atenção!', 'Digite um material na Observação Material!', Mensagem::TIPO_ERROR, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#ObsmanOs").val("").focus();';
            echo $sScript;
            exit;
        }
    }

}
