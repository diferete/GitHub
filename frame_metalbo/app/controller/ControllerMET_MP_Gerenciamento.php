<?php

/*
 * Implementa a classe controler
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ControllerMET_MP_Gerenciamento extends Controller {

    function __construct() {
        $this->carregaClassesMvc('MET_MP_Gerenciamento');
        $this->setControllerDetalhe('MET_MP_ItensManPrev');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    //NOVO ----------------------------------------------------------------------------------
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
        $this->Persistencia->adicionaFiltro('codmaq', $this->Model->getCodmaq());
        $this->buscaCelulas();
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        $aRetorno[2] = $this->Model->getCodmaq();
        return $aRetorno;
    }

    //-----------------------------------------------------------------------------------------

    function beforeInsert() {
        parent::beforeInsert();

        $iCodMaq = $this->Model->getCodmaq();

        $oCodSetor = $this->Persistencia->consultaCodSetor($iCodMaq);

        $this->Model->setCodsetor($oCodSetor->codsetor);

        $this->verificaNrPorMaquina($iCodMaq);
        $this->verificaCampoMaquina();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /*
     * Método que verifica se existe uma Nr cadastrada para a máquina. 
     */

    public function verificaNrPorMaquina($iCodMaq) {

        $iCountMq = $this->Persistencia->verificaQuantMaqAber($iCodMaq);

        if ($iCountMq != 0) {
            $oModal = new Modal('Atenção', 'Já existe uma Manutenção Preventiva aberta para a máquina! \n Altere a máquina selecionada! \n OU \nVolte a tela inicial de Gerenciamento selecione TODOS RESPONSÁVEIS e clique em Buscar', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
    }

    public function verificaCampoMaquina() {
        $sDados = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sDados, $aCamposChave);

        $bBol = $this->Persistencia->verificaCampoValido($aCamposChave['codmaq'], $aCamposChave['maqmp']);

        if (!$bBol) {
            $oModal = new Modal('Atenção', 'Máquina Incorreta! Selecione novamente uma máquina!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
    }

    function beforeUpdate() {
        parent::beforeUpdate();

        $iCodMaq = $this->Model->getCodmaq();

        $oCodSetor = $this->Persistencia->consultaCodSetor($iCodMaq);

        $this->Model->setCodsetor($oCodSetor->codsetor);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $oValoresAtuais = $this->Persistencia->consultarWhere();

        if ($oValoresAtuais->getSitmp() == 'FINALIZADO') {
            $oModal = new Modal('Atenção', 'Não é possivel alterar manutenção pois está finalizada!', Modal::TIPO_AVISO);
            $this->setBDesativaBotaoPadrao(true);
            echo $oModal->getRender();
        }
    }

    public function acaoMostraRelEspecifico($renderTo, $sMetodo = '') {
        parent::acaoMostraRelEspecifico($renderTo, $sMetodo);

        $sNrs = '';
        $aDados = $_REQUEST['parametrosCampos'];
        if ($aDados == null) {
            $this->mostraTelaRelItensGerenciamento($renderTo, $sMetodo);
        } else {
            foreach ($aDados as $key) {
                $sNrs = $sNrs . '&' . substr($key, 26);
            }
            $aSit = $_REQUEST['parametros'];
            foreach ($aSit as $key1) {
                $aSit1 = explode(',', $key1);
            }

            $sSistema = "app/relatorio";
            $sRelatorio = 'relServicoMaquinaMantPrev.php?' . $sNrs . '&Sit=' . $aSit1[2];

            $sCampos .= $this->getSget();

            $sCampos .= '&email=N';

            $sCampos .= '&output=tela';
            $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
            echo $oWindow;
        }
    }

    public function mostraTelaRelItensGerenciamento($renderTo, $sMetodo = '') {
        $this->buscaCelulas();
        parent::mostraTelaRelatorio($renderTo, 'relServicoMaquinaMantPrev');
    }

    public function buscaCelulas() {
        $oControllerMaquina = Fabrica::FabricarController('MET_MP_Maquinas');
        $aParame = $oControllerMaquina->buscaDados();
        $aParame[4] = $this->Persistencia->buscaNrServNeg();
        $this->View->setAParametrosExtras($aParame);
    }

    public function consultaDadosMaquina($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //Fabrica a controller MET_Maquinas e consulta os dados buscando no método com o filtro
        $oOpSteel = Fabrica::FabricarController('MET_MP_Maquinas');
        $oDados = $oOpSteel->consultaDadosMaquina($aCampos['codmaq']);

        if ($oDados->getCod() == null) {
            $oMensagem = new Mensagem('Atenção!', 'Código Inválido!', Mensagem::TIPO_INFO, '9000');
            echo $oMensagem->getRender();
        } else {
            //coloca os dados na view  
            echo '$("#' . $aId[0] . '").val("' . rtrim($oDados->getSeq()) . '");'
            . '$("#' . $aId[1] . '").val("' . rtrim($oDados->getMaqtip()) . '");'
            . '$("#' . $aId[2] . '").val("' . rtrim($oDados->getCodsetor()) . '");';
        }
    }

    /**
     * Calculo da quantidade de serviços em atraso por responsável
     * @param type $sParametros
     * @return string
     */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);

        $sChave = htmlspecialchars_decode($sParametros);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $aCamposChave['nr']);
        $sNr = $aDados[0];

        $aTotal = $this->Persistencia->totalAbertoVencidos($sNr);
        $this->Persistencia->adicionaFiltro('nr', $sNr);
        $this->Persistencia->consultarWhere();
        $iCodMaq = $this->Persistencia->Model->getCodmaq();
        if ($iCodMaq != null) {
            $iCodMaq = 'Maq = ' . $iCodMaq;
        }

        $sResulta = '<div id="titulolinhatempo">'
                . '<h1 class="panel-title" style="-webkit-text-stroke-width:thin; color:red; font-size:18px">Serviços em Atraso das Máquinas ' . $iCodMaq . '</h1>'
                . '<div class="cor_verde">Total de serviços Operador: 0' . $aTotal['OPERADOR'] . '</div>'
                . '<div class="cor_azul">Total de serviços Mecânica: 0' . $aTotal['MECANICA'] . '</div>'
                . 'Total de serviços Manutenção Elétrica: 0' . $aTotal['ELETRICA'] . ''
                . '</div>';

        echo '$("#titulolinhatempo").empty();';

        $sTitulo = '<div id="titulolinhatempo">'
                . '<h1 class="panel-title" style="-webkit-text-stroke-width:thin; color:red; font-size:18px">Serviços em Atraso das Máquinas ' . $iCodMaq . '</h1>'
                . '<div class="cor_verde">Total de serviços Operador: 0' . $aTotal['OPERADOR'] . '</div>'
                . '<div class="cor_azul">Total de serviços Mecânica: 0' . $aTotal['MECANICA'] . '</div>'
                . 'Total de serviços Manutenção Elétrica: 0' . $aTotal['ELETRICA'] . ''
                . '</div>';
        echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';

        return $sResulta;
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        $oItens = Fabrica::FabricarController('MET_MP_ItensManPrev');
        $oItens->Persistencia->atualizaDataAntesdaConsulta();
        $this->buscaCelulas();
        $oDados = $_REQUEST['parametrosCampos'];

        $sSit = explode('|', $oDados['parametrosCampos[5'])[1];
        $iSet = $_SESSION['codsetor'];
        
        if($_REQUEST['metodo']!='getDadosConsulta' && $_REQUEST['metodo']!='getDadosScroll' || $iSet==5){
            if($iSet!= 2 && $iSet!= 12 && $iSet!= 29){
                $this->Persistencia->adicionaFiltro('Setor.codsetor',$iSet);
                $this->Persistencia->setSqlWhere('nr in (' . $this->Persistencia->retornaTexMaqPorSetor($iSet) . ') ');
            }else if($iSet== 12){
                $this->Persistencia->setSqlWhere('nr in (' . $this->Persistencia->retornaTexMaqPorSetor(12) . ') ');
            }else if($iSet== 29){
                $this->Persistencia->setSqlWhere('nr in (' . $this->Persistencia->retornaTexMaqPorSetor(29) . ') ');
            }
        }
            if ($sSit == 'FINALIZADO') {
                $this->Persistencia->adicionaFiltro('sitmp', 'FINALIZADO');
            } else {
                $this->Persistencia->adicionaFiltro('sitmp', 'ABERTO');
            }
            //Parte participante da ordenação em ordem alfabética quando usuário realiza getDadosScroll
            if($_REQUEST['metodo']=='getDadosScroll'){
                $aWhere = $this->Persistencia->getListaWhere();
                $oDesMaq = $this->Persistencia->retornaMaquina($aWhere[1]['valor']);
                $aWhere[1]['campo'] = 'maqmp';
                $aWhere[1]['valor'] = $oDesMaq->maqmp; 
                $aWhere[1]['comparacao'] = 1;
                $this->Persistencia->setAListaWhere($aWhere);
            }
    }

}
