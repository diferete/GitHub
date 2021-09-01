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

    public function acaoInserirMaterial($sDados, $sCampos) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        //Conta na persistencia para ver se o método é alterar ou inserir
        $oMat = Fabrica::FabricarController('MET_MANUT_OSMaterial');
        $oMat->Persistencia->adicionaFiltro('fil_codigo', $aCamposChave['fil_codigo']);
        $oMat->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oMat->Persistencia->adicionaFiltro('cod', $aCamposChave['cod']);
        $oMat->Persistencia->adicionaFiltro('codmat', $aCamposChave['DELX_PRO_Produtos_pro_codigo']);
        $oMatDados = $oMat->Persistencia->getCount();

        //adiciona filtro da chave primária
        $oMat->parametros = $sCampos;

        //se cont = 0 segue ação incluir
        if ($oMatDados == 0) {
            $oMat->acaoIncluirDetMat($sDados, $aCamposChave);
        }
    }

    public function acaoIncluirDetMat($sId, $aCamposChave) {

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

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $sChave = ($_REQUEST['parametros']);
        $aCamposChave = explode(',', $sChave['parametros[']);
        $sChave1 = htmlspecialchars_decode($aCamposChave[0]);
        $aCamposChave1 = array();
        parse_str($sChave1, $aCamposChave1);

        $this->Persistencia->adicionaFiltro('fil_codigo', $aCamposChave1['fil_codigo']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave1['nr']);
    }

    public function msgExcluirMaterial($sDados) {
        $sChave = htmlspecialchars_decode($sDados);
        $aChaveDados = explode(',', $sChave);
        $iCodProd = explode('=', $aChaveDados[2])[1];
        $sChave2 = htmlspecialchars_decode($_REQUEST['campos']);
        $sChave2 = $sChave2.'&pro_codigo='.$iCodProd;
        
        $oMensagem = new Modal('Atenção', 'Deseja excluir o material '.$iCodProd.' da manutenção!', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","MET_MANUT_OSMaterial","excluirMaterial","' . $sChave2 . '");');

        echo $oMensagem->getRender();
    }

    public function excluirMaterial($sChave){
        
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
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
    
    public function recarregarGrid() {

        if($_REQUEST['metodo']=='excluirMaterial'){
            $sChave = htmlspecialchars_decode($_REQUEST['parametros']['parametros[']);
            $aChaveDados = explode(',', $sChave);
        }else{
            $sChave = ($_REQUEST['parametros']);
            $aCamposChave = explode(',', $sChave['parametros[']);
            $sForm = $aCamposChave[0];
        }
//        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
//        echo $sScript;
//        $sScript1 = '$("#' . $aCamposChave[1] . '").each (function(){ this.reset();});';
//        echo $sScript1;
//        $sScript2 = '$("#' . $aCamposChave[2] . '").each (function(){ this.reset();});';
//        echo $sScript2;
//        $sScript3 = '$("#' . $aCamposChave[3] . '").each (function(){ this.reset();});';
//        echo $sScript3;
        
//        $sScript1 = '$("#' . $aCamposChave[3] . '").each (function(){ this.reset();});';
//        echo $sScript1;
//        $this->getDadosConsulta($aCamposChave[2], true, null, $aColuna = null, true, $bScroll = false);
//        $oBase = new Base();
//        echo $oBase->formhide($sForm);// ->focus($aCamposChave[3]);

//        echo"$('#" . $aCamposChave[3] . "-pesq').click();";

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
