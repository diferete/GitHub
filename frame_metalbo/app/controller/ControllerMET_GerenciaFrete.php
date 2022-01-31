<?php

/*
 * Classe que gerencia a Controller da MET_GerenciaFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class ControllerMET_GerenciaFrete extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_GerenciaFrete');
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function antesVisualizar($sParametros = null) {
        parent::antesVisualizar($sParametros);
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
    }

    public function buscaDados($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $oRow = $this->Persistencia->consultaDados($aCamposChave);

        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $sVal = $this->Persistencia->consultarWhere();

        if ($sVal->getNrnotaoc() == $aCamposChave['nrnotaoc']) {
            if ($oRow->nfsvlrtot != 0) {
                echo"$('#" . $aDados[0] . "').val('" . $oRow->nfsvlrtot . "');";
            }
            if ($oRow->pesonota != 0) {
                echo "$('#" . $aDados[1] . "').val('" . $oRow->pesonota . "');";
            }
            if ($oRow->fracaofrete != 0) {
                echo "$('#" . $aDados[2] . "').val('" . $oRow->fracaofrete . "');";
            }
        } else {
            echo"$('#" . $aDados[0] . "').val('" . $oRow->nfsvlrtot . "');";
            echo "$('#" . $aDados[1] . "').val('" . $oRow->pesonota . "');";
            echo "$('#" . $aDados[2] . "').val('" . $oRow->fracaofrete . "');";
        }
        echo "$('#" . $aDados[1] . "').focus();";
        echo "$('#" . $aDados[0] . "').focus();";
        echo '$("#gerenciafrete_valorserv").focus();';

        $this->verificaNotaConhecimento();
    }

    public function calculoFracaoFrete($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);

        $iFracaoFrete = ceil($aCamposChave['totakg'] / 100);

        echo"$('#" . $aDados[0] . "').val(" . $iFracaoFrete . ");";
    }

    public function calculoFreteTotalFormulas($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aDados = explode(',', $sDados);


        //Validações campos vazios
        if (($aCamposChave['fracaofrete']) == 0) {
            $oModal = new Modal('Atenção', 'Digite o valor do peso!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }

        $oRow = $this->Persistencia->consultaDadosFormulas($aCamposChave);

        $this->carregaDadosConsulta($aDados[0], $aCamposChave, $oRow, $aDados[1]);
    }

    /**
     * Método que renderiza dados para o grid.
     * @param type $sIdGrid
     * @param type $sCampoConsulta
     * @param type $oRow
     * @param type $iIdSeq
     */
    public function carregaDadosConsulta($sIdGrid, $aCamposChave, $oRow, $iIdSeq) {

        $htmlSelectG = "";

        forEach ($oRow as $aA) {

            $sIdtr = Base::getId();
            if ($aCamposChave['seqregra'] == '') {
                if ((number_format($aA['totalfrete'], 0) == number_format(str_replace(',', '.', $aCamposChave['valorserv']), 0)) ||
                        number_format($aA['freteminimo'], 0) == number_format(str_replace(',', '.', $aCamposChave['valorserv']), 0)) {
                    $htmlSelectG .= '<tr id="' . $sIdtr . '"  tabindex="0" class= "tr-azul dbclick selected" style="font-size:small;">'; //abre a linha azul
                    echo "$('#" . $iIdSeq . "').val(" . $aA['seq'] . ");";
                } else {
                    if ($aCamposChave['seqregra'] == $aA['seq']) {
                        $htmlSelectG .= '<tr id="' . $sIdtr . '" tabindex="0" role="row" class="odd dbclick selected" style="font-size:small;">'; //abre a linha
                    } else {
                        $htmlSelectG .= '<tr id="' . $sIdtr . '" tabindex="0" role="row" class="odd dbclick" style="font-size:small;">'; //abre a linha
                    }
                }
            } else {
                if ($aCamposChave['seqregra'] == $aA['seq']) {
                    $htmlSelectG .= '<tr id="' . $sIdtr . '"  tabindex="0" class= "tr-azul dbclick selected" style="font-size:small;">'; //abre a linha azul
                    echo "$('#" . $iIdSeq . "').val(" . $aA['seq'] . ");";
                } else {
                    $htmlSelectG .= '<tr id="' . $sIdtr . '" tabindex="0" role="row" class="odd dbclick" style="font-size:small;">'; //abre a linha
                }
            }

            $htmlSelectG .= '<script>'
                    . '$("#' . $sIdtr . '").keydown(function(e) { '
                    . 'if(e.which == 40) {   '
                    . '     $(this).removeClass("selected"); '
                    . '     $(this).next().focus(); '
                    . '     $(this).next().addClass("selected");'
                    . '  } else if(e.which == 38) {  '
                    . '      $(this).removeClass("selected"); '
                    . '      $(this).prev().focus(); '
                    . '      $(this).prev().addClass("selected"); '
                    . '  } '
                    . '});'
                    . '</script>';

            $htmlSelectG .= '<td class="select-checkbox sorting_1 select-checkbox" style="width: 30px;"></td>'; //td do check  
            $htmlSelectG .= '<td id="' . $sIdtr . '-seq" class=" tr-font" style="">' . $aA['seq'] . '</td>';
            $htmlSelectG .= '<td class=" tr-font" style="">' . $aA['ref'] . '</td>';
            $htmlSelectG .= '<td class=" tr-font" style="">' . number_format($aA['totalfrete'], 2) . '</td>';
            $htmlSelectG .= '<td class=" tr-font" style="">' . number_format($aA['freteminimo'], 2) . '</td>';
            $htmlSelectG .= '<td class="hidden chave">' . $aA['seq'] . '</td>'; ///colocar valor chave
            //Script que passa o valor da sequencia e o id do campo oculto
            $htmlSelectG .= '<script>'
                    . '$("#' . $sIdtr . '").click(function(){'
                    . 'requestAjax("", "MET_GerenciaFrete","isereDadosModel","' . $aA['seq'] . '&' . $iIdSeq . '&' . number_format($aA['totalfrete'], 2, '.', '') . '&' . number_format($aA['freteminimo'], 2, '.', '') . '");});'
                    . '</script>';
            $htmlSelectG .= '</tr>';
        }

        //pegar id da tr
        $sRender = 'var idTr="";$("#' . $sIdGrid . 'consulta tbody .selected").each(function(){'
                . ' idTr=$(this).attr("id");'
                . ' });';

        //scroll infinito
        $sRender .= '$("#' . $sIdGrid . ' > tbody > tr").remove();';

        //Coloca dados no grid
        $sRender .= '$("#' . $sIdGrid . '").append(\'' . $htmlSelectG . '\');';

        $sRender .= ' if (idTr!==""){$("#' . $sIdGrid . ' #"+idTr+"").focus();'
                . ' $("#' . $sIdGrid . ' #"+idTr+"").addClass("selected");}';

        echo $sRender;

        //mostra contator de registros 

        $sNrReg = 'var nrReg = $("#' . $sIdGrid . ' > tbody > tr").length ;'
                . ' $("#' . $sIdGrid . '-nrReg").text(nrReg+" registros listados do total de ' . count($oRow) . '. Clique para carregar!"); ';
        echo $sNrReg;

        echo '$("#gerenciafrete_obs").focus();';
    }

    /**
     * Função que insere dados no campo oculto da tela, sequencia da regra
     * @param type $sDados
     */
    public function isereDadosModel($sDados) {
        $aDados = explode('&', $sDados);
        echo "$('#" . $aDados[1] . "').val(" . $aDados[0] . ");";
        echo "$('#valorservfrete2').val(" . $aDados[2] . ");";
        echo "$('#valorservfrete3').val(" . $aDados[3] . ");";
    }

//valorservfrete2
    /**
     * Mostra tela relatório de Frete
     * @param type $renderTo
     * @param type $sMetodo
     */
    public function mostraTelaRelGerenciaFrete($renderTo, $sMetodo = '') {
        $oEmp = $this->Persistencia->buscaEmpresas();
        $this->View->setAParametrosExtras($oEmp);
        parent::mostraTelaRelatorio($renderTo, 'relGerenciaFrete');
    }

    /**
     * Método que inicializa função botão contas a pagar
     * @param type $sDados
     */
    public function msgLibPag($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oVal = $this->Persistencia->consultarWhere();

        if ($oVal->getSit() == "E") {
            $oModal = new Modal('Atenção', 'Apenas conhecimentos aprovados podem ser pagos!', Modal::TIPO_AVISO);
            echo $oModal->getRender();
            exit();
        } else {
            $oModalS = new Modal('Atenção', 'Deseja gerar o financeiro do conhecimento Nº' . $oVal->getNr() . ', com o valor de R$' . number_format($oVal->getValorserv(), 2), Modal::TIPO_INFO, true, true, true);
            $oModalS->setSBtnConfirmarFunction('requestAjax("","MET_GerenciaFrete","geraFinanceiro","' . $aCamposChave['nr'] . '");');
            echo $oModalS->getRender();
        }
    }

    /*
     * Método que retorna a parcela e gera o financeiro
     */

    public function geraFinanceiro($sDados) {
        $this->Persistencia->adicionaFiltro('nr', $sDados);
        $oVal = $this->Persistencia->consultarWhere();

        $sParcela = $this->Persistencia->getParcelaFrete($oVal);
    }

    //Método que preenche os campos do form depois de dar o resetform
    public function afterResetForm($sDados) {
        parent::afterResetForm($sDados);

        echo '$("#gerenciafrete_cnpj").val("' . $this->Model->getCnpj() . '").trigger("change");';
        echo '$("#gerenciafrete_codtip").val("' . $this->Model->getCodtipo() . '").trigger("change");';
        echo ' $("#gerenciafrete_nrfat").val("' . $this->Model->getNrfat() . '");';
        echo ' $("#gerenciafrete_dataem").val("' . $this->Model->getDataem() . '");';
        echo ' $("#gerenciafrete_datafn").val("' . $this->Model->getDatafn() . '");';
        echo '$("#gerenciafrete_grid > tbody > tr").remove();';
        echo '$("#gerenciafrete_nrconhe").focus();';
    }

    //Método antes de inserir verifica linha selecionada conforme a situação
    public function beforeInsert() {
        parent::beforeInsert();

        if ($this->Model->getSeqregra() == "" && $this->Model->getSit() != "E") {
            $oModal = new Modal('Atenção', 'Selecione uma linha de resultado de cálculo!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
        //Verifica se não existe conhecimento repetido
        $this->verificaConhecimento();

        //Verifica a vírgula nos valores
        if (stristr($this->Model->getTotalnf(), ',')) {
            $this->Model->setTotalnf(Util::ValorSql($this->Model->getTotalnf()));
        }
        if (stristr($this->Model->getTotakg(), ',')) {
            $this->Model->setTotakg(Util::ValorSql($this->Model->getTotakg()));
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    //Verifica se não existe conhecimento repetido
    public function verificaConhecimento() {
        $sDados = $_REQUEST['campos'];
        $sChave = htmlspecialchars_decode($sDados);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($this->Persistencia->verificaConhec($aCamposChave) > 0) {
            $oModal = new Mensagem('Atenção', 'Conhecimento digitado já foi inserido!', Mensagem::TIPO_ERROR);
            echo ' $("#gerenciafrete_nrconhe").val("");';
            echo $oModal->getRender();
            echo ' $("#gerenciafrete_nrconhe").focus();';
            exit();
        }
    }

    //Método antes de alterar verifica linha selecionada conforme a situação
    public function beforeUpdate() {
        parent::beforeUpdate();

        if ($this->Model->getSeqregra() == "" && $this->Model->getSit() != "E") {
            $oModal = new Modal('Atenção', 'Selecione uma linha de resultado de cálculo!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }

        //Verifica a vírgula nos valores
        if (stristr($this->Model->getTotalnf(), ',')) {
            $this->Model->setTotalnf(Util::ValorSql($this->Model->getTotalnf()));
        }
        if (stristr($this->Model->getTotakg(), ',')) {
            $this->Model->setTotakg(Util::ValorSql($this->Model->getTotakg()));
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     *  Gera xls do relatorio de frete
     */
    public function relatorioExcelFrete() {
        //Explode string parametros
        $sDados = $_REQUEST['campos'];

        $sCampos = htmlspecialchars_decode($sDados);

        $sCampos .= $this->getSget();

        $aRel = explode(',', $sRel);

        $sSistema = "app/relatorio";
        $sRelatorio = 'relGerenciaFreteExcel.php?';

        $sCampos .= '&output=email';
        $oMensagem = new Mensagem("Aguarde", "Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();

        $oWindow = 'var win = window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '","MsgWindow","width=500,height=100,left=375,top=330");'
                . 'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;


        $oMenSuccess = new Mensagem("Sucesso", "Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
    }

    //Verifica se não existe nota digitada com um conhecimento já existente
    public function verificaNotaConhecimento() {
        $sDados = $_REQUEST['campos'];
        $sChave = htmlspecialchars_decode($sDados);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($this->Persistencia->verificaNotaConhec($aCamposChave) > 0) {
            $oModal = new Mensagem('Atenção', 'Nota já possui Conhecimento inserido para a mesma!', Mensagem::TIPO_ERROR);
            echo $oModal->getRender();
        }
    }

}
