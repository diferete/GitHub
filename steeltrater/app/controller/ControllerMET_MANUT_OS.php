<?php

/*
 * Implementa a classe controler MET_MANUT_OS
 * @author Cleverton Hoffmann
 * @since 21/07/2021
 */

class ControllerMET_MANUT_OS extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_MANUT_OS');
    }

    /**
     * Mensagem para liberar início da manutenção
     */
    public function msgLibManut($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituacao() <> 'Aberta') {
            $aOrdem = $aCamposChave['nr'];
            $oMensagem = new Modal('Ordem não está em estado para apontar!', 'Ordem nº' . $aOrdem . ' está ' . $this->Model->getSituacao() . ' não é permitido fazer alterações!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }

        $oMensagem = new Modal('Apontar início da manutenção', 'Deseja apontar o início da manutenção da ordem nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaManut","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function liberaManut($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = array();
        $aRetorno = $this->Persistencia->apontaInicio($aCamposChave);

        $oMensagem = new Modal('Atenção', 'A ordem nº' . $aCamposChave['nr'] . ' foi iniciada a manutenção com sucesso', Modal::TIPO_SUCESSO, false, true, true);
        echo $oMensagem->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    /**
     * Mensagem para retornar a manutenção para situação aberta
     */
    public function msgRetAberta($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituacao() <> 'Iniciada') {
            $aOrdem = $aCamposChave['nr'];
            $oMensagem = new Modal('Ordem não está em estado para retornar para Aberta!', 'Ordem nº' . $aOrdem . ' está ' . $this->Model->getSituacao() . ' não é permitido retornar!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }

        $oMensagem = new Modal('Retornar para situação em aberta', 'Deseja retornar para aberta a ordem nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","retornaAberta","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function retornaAberta($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = array();
        $aRetorno = $this->Persistencia->apontaAberta($aCamposChave);

        $oMensagem = new Modal('Atenção', 'A ordem nº' . $aCamposChave['nr'] . ' foi retornada para aberta', Modal::TIPO_SUCESSO, false, true, true);
        echo $oMensagem->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function msgCancela($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituacao() == 'Encerrada') {
            $aOrdem = $aCamposChave['nr'];
            $oMensagem = new Modal('Ordem não pode ser cancelada!', 'Ordem nº' . $aOrdem . ' está ' . $this->Model->getSituacao() . ' não é permitido cancelar!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }

        $oMensagem = new Modal('Cancelamento', 'Deseja cancelar a ordem nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","cancela","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function cancela($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = array();
        $aRetorno = $this->Persistencia->cancela($aCamposChave);

        $oMensagem = new Modal('Atenção', 'A ordem nº' . $aCamposChave['nr'] . ' foi cancelada', Modal::TIPO_SUCESSO, false, true, true);
        echo $oMensagem->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function msgEnc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituacao() <> 'Iniciada') {
            $aOrdem = $aCamposChave['nr'];
            $oMensagem = new Modal('Ordem não está em estado para encerrar!', 'Ordem nº' . $aOrdem . ' está ' . $this->Model->getSituacao() . ' não é permitido encerrar!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }

        $oMensagem = new Modal('Encerramento', 'Deseja encerrar a ordem nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","enc","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function enc($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = array();
        $aRetorno = $this->Persistencia->enc($aCamposChave);

        $oMensagem = new Modal('Encerramento', 'A ordem nº' . $aCamposChave['nr'] . ' foi encerrada!!!', Modal::TIPO_SUCESSO, false, true, true);
        echo $oMensagem->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    /**
     * Método para verificar se pode alterar um registro
     */
    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sParametros[0] = str_replace("amp;", "", $sParametros[0]);
        $this->carregaModelString($sParametros[0]);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituacao() == 'Encerrada') {
            $aOrdem = explode('=', explode('&', $sParametros[0])[1]);
            $oMensagem = new Modal('Ordem já está encerrada', 'Ordem nº' . $aOrdem[1] . ' já está encerrada, não é permitido fazer alterações!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
        if ($this->Model->getSituacao() == 'Cancelada') {
            $aOrdem = explode('=', explode('&', $sParametros[0])[1]);
            $oMensagem = new Modal('Ordem já está Cancelada', 'Ordem nº' . $aOrdem[1] . ' já está cancelada, não é permitido fazer alterações!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * Antes de criar consulta atualiza a data de dias
     * @param type $sParametros
     */
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $this->Persistencia->atualizaDataAntesdaConsulta();
        //      $this->Persistencia->atualizaServicos();
    }

    /**
     * Mensagem para retornar a manutenção para situação iniciada
     */
    public function msgRetIniciada($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        if ($this->Model->getSituacao() <> 'Encerrada') {
            $aOrdem = $aCamposChave['nr'];
            $oMensagem = new Modal('Ordem não está em estado para retornar para Iniciada!', 'Ordem nº' . $aOrdem . ' está ' . $this->Model->getSituacao() . ' não é permitido retornar!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
            exit();
        }

        $oMensagem = new Modal('Retornar para situação iniciada', 'Deseja retornar para iniciada a ordem nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","retornaIniciada","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function retornaIniciada($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = array();
        $aRetorno = $this->Persistencia->apontaIniciada($aCamposChave);

        $oMensagem = new Modal('Atenção', 'A ordem nº' . $aCamposChave['nr'] . ' foi retornada para iniciada', Modal::TIPO_SUCESSO, false, true, true);
        echo $oMensagem->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function relOsSteel($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relOsSteel');
    }

    public function buscaDadosCrachaManut($sDados) {
        $aDados = $this->getArrayCampostela();
        $aIDs = explode(',', $sDados);

        $sCracha = ltrim($aDados['cracha'], '0');

        if ($aDados['cracha'] == '') {
            exit;
        } else {
            $dadosCracha = $this->Persistencia->buscaDadosCrachaMan($sCracha);
            if ($dadosCracha == false) {
                $oMensagem = new Mensagem('Atenção!', 'Colaborador não encontrado, verifique o número do crachá!', Mensagem::TIPO_WARNING, 7000);
                echo $oMensagem->getRender();
                $sScript = '$("#' . $aIDs[0] . '").val("");'
                        . '$("#' . $aIDs[1] . '").val("");'
                        . '$("#' . $aIDs[2] . '").val("").focus();';
                echo $sScript;
            } else {
                $sScript = '$("#' . $aIDs[0] . '").val(' . $dadosCracha->usucodigo . ');'
                        . '$("#' . $aIDs[1] . '").val("' . $dadosCracha->usunome . '");'
                        . '$("#' . $aIDs[2] . '").val("' . $sCracha . '").focus();';
                echo $sScript;
            }
        }
    }

    /**
     *  Gera xls das manutenções Steel
     */
    public function relatorioExcelManut() { //indicadorExpedicaoXls
        //Explode string parametros
        $sDados = $_REQUEST['campos'];

        $sCampos = htmlspecialchars_decode($sDados);

        $sCampos .= $this->getSget();

        $sSistema = "app/relatorio";
        $sRelatorio = 'relOsSteelExcel.php?';

        $sCampos .= '&output=email';
        $oMensagem = new Mensagem("Aguarde", "Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();

        $oWindow = 'var win = window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '","MsgWindow","width=500,height=100,left=375,top=330");'
                . 'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;

        $oMenSuccess = new Mensagem("Sucesso", "Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
    }

    public function afterInsert() {
        parent::afterInsert();

        echo '$("#manutCracha").val("").focus();';

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function consultaDesMaq() {

        $aCampos = $this->getArrayCampostela();

        $oMaq = Fabrica::FabricarController('MET_CAD_Maquinas');
        $oMaq->Persistencia->adicionaFiltro('fil_codigo', $aCampos['fil_codigo']);
        $oMaq->Persistencia->adicionaFiltro('codigoMaq', $aCampos['cod']);
        $iCont = $oMaq->Persistencia->getCount();

        if ($iCont == 0) {
            $oMensagem = new Mensagem('Atenção!', 'Código de máquina inexistente, digite um código válido!', Mensagem::TIPO_WARNING, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#codMaqManOS").val("");'
                    . '$("#desMaqManOS").val("");'
                    . '$("#codMaqManOS").val("").focus();';
            echo $sScript;
        }
    }

    public function consultaMaterial() {

        $aCampos = $this->getArrayCampostela();

        $oMaq = Fabrica::FabricarController('DELX_PRO_Produtos');
        $oMaq->Persistencia->adicionaFiltro('pro_codigo', $aCampos['MET_MANUT_OSPesqProd_pro_codigo']);
        $iCont = $oMaq->Persistencia->getCount();

        if ($iCont == 0) {
            $oMensagem = new Mensagem('Atenção!', 'Código de material inexistente, digite um código válido!', Mensagem::TIPO_WARNING, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#CodmaterialManOs").val("");'
                    . '$("#materialManOs").val("");'
                    . '$("#CodmaterialManOs").val("").focus();';
            echo $sScript;
        }
        $oDadosMaq = $oMaq->Persistencia->consultarWhere();

        $oContPar = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
        $oContPar->Persistencia->adicionaFiltro('parametro', "PARAMENTRO PARA O SISTEMA DE CONSULTA DE MATERIAL OS");
        $oModelDadosPar = $oContPar->Persistencia->consultarWhere();
        $sDados = $oModelDadosPar->getObs();
        $aGrupDados = explode(',', $sDados);

        if (!in_array($oDadosMaq->getPro_grupocodigo() , $aGrupDados )) {
            $oMensagem = new Mensagem('Atenção!', 'Código de material inexistente no grupo válido, digite um código válido!', Mensagem::TIPO_WARNING, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#CodmaterialManOs").val("");'
                    . '$("#materialManOs").val("");'
                    . '$("#CodmaterialManOs").val("").focus();';
            echo $sScript;
        } 
        
    }

}
