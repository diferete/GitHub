<?php

/*
 * Implementa a classe controler MET_MANUT_OSGeraSolCom
 * @author Cleverton Hoffmann
 * @since 20/09/2021
 */

class ControllerMET_MANUT_OSGeraSolCom extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_MANUT_OSGeraSolCom');
    }

    public function msgGeraSolOS($sDados) {

        $sClasse = $this->getNomeClasse();

        $aOs = $_REQUEST['parametrosCampos'];
        $sDadosOS = '';
        foreach ($aOs as $key => $value) {
            $sDadosOS = $value . '&&' . $sDadosOS;
        }

        $oMensagem = new Modal('Geração Solicitação', 'Deseja gerar a solicitação dos itens selecionados?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","GeraSolOS","' . $sDadosOS . '", "' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    /**
     * Prepara o Array com as chaves primárias para gerar as solicitações de compra
     * @param type $sDadosOS
     */
    public function GeraSolOS($sDadosOS, $sDados) {
        $aDadosinic = explode(',', $sDados);

        $aDados = explode('&&', $sDadosOS);
        $aDadosOS = array();
        $aOSs = array();
        $aCodMaqs = array();
        $iK = 0;
        foreach ($aDados as $key => $value) {
            if ($value != '') {
                $sChave = htmlspecialchars_decode($value);
                $aCamposChave = array();
                parse_str($sChave, $aCamposChave);
                $aDadosOS[$iK] = $aCamposChave;
                $aOSs[$iK] = $aCamposChave['nr'];
                $aCodMaqs[$iK] = $aCamposChave['cod'];
                $iK++;
            }
        }
        //Prepara os arrays com os números das OS e dos códigos de máquina selecionados agrupando eles, para as mensagens e gravação nos campos de observação
        $aOSs = array_unique($aOSs);
        $aCodMaqs = array_unique($aCodMaqs);
        $sOSs = '';
        $sCodMaqs = '';
        $iK = 0;
        foreach ($aOSs as $key => $value) {
            if ($iK == 0) {
                $sOSs = $value;
            } else {
                $sOSs = $sOSs . ',' . $value;
            }
            $iK++;
        }
        $iK = 0;
        foreach ($aCodMaqs as $key => $value) {
            $oContMaq = Fabrica::FabricarController('MET_CAD_Maquinas');
            $oContMaq->Persistencia->adicionaFiltro('codigoMaq', $value);
            $oModelMaq = $oContMaq->Persistencia->consultarWhere();
            if ($iK == 0) {
                $sCodMaqs = $value.'-'.$oModelMaq->getMaquina();
            } else {
                $sCodMaqs = $sCodMaqs . ', ' . $value.'- '.$oModelMaq->getMaquina();
            }
            $iK++;
        }
        //Método que gera a solicitação na persistência
        $aRetorno = $this->Persistencia->geraSolicOS($aDadosOS, $sOSs, $sCodMaqs);

        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso!', 'Solicitação gerada!', Mensagem::TIPO_SUCESSO, 7000);
            echo $oMensagem->getRender();
            echo"$('#" . $aDadosinic[1] . "-pesq').click();";
        }
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        //Parte participante da ordenação em ordem alfabética quando usuário realiza getDadosScroll
        if ($_REQUEST['metodo'] == 'getDadosScroll') {
            $iNr = 0;
            $aWhere = $this->Persistencia->getListaWhere();
            //Limpa posição do array
            unset($aWhere[2]);
            unset($aWhere[3]);
            unset($aWhere[4]);
            unset($aWhere[5]);
            $this->Persistencia->setAListaWhere($aWhere);
        }
    }

    public function consultaMaterialSol() {

        $aCampos = $this->getArrayCampostela();

        $oMaq = Fabrica::FabricarController('DELX_PRO_Produtos');
        $oMaq->Persistencia->adicionaFiltro('pro_codigo', $aCampos['codmat']);
        $iCont = $oMaq->Persistencia->getCount();

        if ($iCont == 0) {
            $oMensagem = new Mensagem('Atenção!', 'Código de material inexistente, digite um código válido!', Mensagem::TIPO_WARNING, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#CodmaterialManOsSol").val("");'
                    . '$("#materialManOsSol").val("");'
                    . '$("#CodmaterialManOsSol").val("").focus();';
            echo $sScript;
        }
        $oDadosMaq = $oMaq->Persistencia->consultarWhere();

        $oContPar = Fabrica::FabricarController('STEEL_PCP_ParametrosProd');
        $oContPar->Persistencia->adicionaFiltro('parametro', "PARAMENTRO PARA O SISTEMA DE CONSULTA DE MATERIAL OS");
        $oModelDadosPar = $oContPar->Persistencia->consultarWhere();
        $sDados = $oModelDadosPar->getObs();
        $aGrupDados = explode(',', $sDados);

        if (!in_array($oDadosMaq->getPro_grupocodigo(), $aGrupDados)) {
            $oMensagem = new Mensagem('Atenção!', 'Código de material inexistente no grupo válido, digite um código válido!', Mensagem::TIPO_WARNING, 7000);
            echo $oMensagem->getRender();
            $sScript = '$("#CodmaterialManOsSol").val("");'
                    . '$("#materialManOsSol").val("");'
                    . '$("#CodmaterialManOsSol").val("").focus();';
            echo $sScript;
        }
    }

}
