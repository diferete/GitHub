<?php

/**
 * Classe que implementa a estrutura dos filtros na consulta
 *
 * @author Carlos Eduardo Scheffer
 * @since 29/01/2015
 */
class Filtro {

    private $Id;
    private $sLabel;
    private $sNome; //nome do model
    private $iTipoCampo;
    private $bQuebraLinha;
    private $sPlaceHolder; //mensagem no interior do campo
    private $sValor; //define o valor do campo
    private $bFocus; //define se o campo terá o  foco
    private $sTelaGrande; //Define o valor para tela grandes como note e pc
    private $sTelaMedia; //Define o valor para telas de tablets e notes pequenos
    private $sTelaPequena; //Define o valor para telas pequenas como tablets pequenos e celulares
    private $sTelaMuitoPequena; //Define o valor para telas muito pequenas como celulares pequenos
    private $bDesativado; // Defini se dropdown e/ou itens do dropdowns estão desativados
    private $aFiltroValor;
    private $sCampoRetorno;
    private $sClasseBusca;
    private $sIdTela; //atributo para informar o id da tela quando necessário\
    private $sParamBuscaPk;
    private $bBuscaTela;
    private $aItemsSelect;
    private $bCampoBloqueado;
    private $bSeq;
    private $aEventos; // Array contendo eventos do campo
    private $bInline;

    //Estilo do filtro    
    const CAMPO_DATA = 0;
    const CAMPO_TEXTO = 1;
    const CAMPO_MONEY = 2;
    const CAMPO_SELECT = 3;
    const CAMPO_PESQUISA = 4;
    const CAMPO_INTEIRO = 5;
    const CAMPO_DATA_ENTRE = 6;
    const CAMPO_TEXTO_IGUAL = 7;
    const CAMPO_BUSCADOBANCOPK = 8;

    /**
     * 
     * @param type $oCampoConsulta CampoConsulta que deseja ativar o filtro na Grid
     * @param type $iTipoCampo Tipo de filtro que deseja aplicar
     * @param type $sTelaGrande gerencia tamanho do campo Valor de 1-12 
     * @param type $sTelaMedia gerencia tamanho do campo Valor de 1-12 
     * @param type $sTelaPequena gerencia tamanho do campo Valor de 1-12 - MANTER SEMPRE 12
     * @param type $sTelaMuitoPequena gerencia tamanho do campo Valor de 1-12 - MANTER SEMPRE 12
     * @param type $bQuebraLinha Se TRUE, aplica quebra de linha
     */
    public function __construct($oCampoConsulta, $iTipoCampo, $sTelaGrande = '2', $sTelaMedia = '2', $sTelaPequena = '12', $sTelaMuitoPequena = '12', $bQuebraLinha) {
        $this->Id = Base::getId();
        $this->sLabel = $oCampoConsulta->getSLabel();
        $this->sNome = $oCampoConsulta->getSNome();

        $this->iTipoCampo = $iTipoCampo;


        //propriedades de tamanho de acordo com tamanho da tela
        $this->sTelaGrande = $sTelaGrande;
        $this->sTelaMedia = $sTelaMedia;
        $this->sTelaPequena = $sTelaPequena;
        $this->sTelaMuitoPequena = $sTelaMuitoPequena;
        $this->bQuebraLinha = $bQuebraLinha;
        $this->aFiltroValor = array();
        $this->aItemsSelect = array();
        $this->aEventos = array();
    }

    function getBQuebraLinha() {
        return $this->bQuebraLinha;
    }

    function setBQuebraLinha($bQuebraLinha) {
        $this->bQuebraLinha = $bQuebraLinha;
    }

    function getBInline() {
        return $this->bInline;
    }

    function setBInline($bInline) {
        $this->bInline = $bInline;
    }

    function getAEventos() {
        return $this->aEventos;
    }

    function setAEventos($aEventos) {
        $this->aEventos = $aEventos;
    }

    function getBSeq() {
        return $this->bSeq;
    }

    function setBSeq($bSeq) {
        $this->bSeq = $bSeq;
    }

    function getBCampoBloqueado() {
        return $this->bCampoBloqueado;
    }

    function setBCampoBloqueado($bCampoBloqueado) {
        $this->bCampoBloqueado = $bCampoBloqueado;
    }

    function getAItemsSelect() {
        return $this->aItemsSelect;
    }

    function setAItemsSelect($aItemsSelect) {
        $this->aItemsSelect = $aItemsSelect;
    }

    function getBBuscaTela() {
        return $this->bBuscaTela;
    }

    function setBBuscaTela($bBuscaTela) {
        $this->bBuscaTela = $bBuscaTela;
    }

    function getSCampoRetorno() {
        return $this->sCampoRetorno;
    }

    function setSCampoRetorno($sCampoRetorno) {
        $this->sCampoRetorno = $sCampoRetorno;
    }

    function getSParamBuscaPk() {
        return $this->sParamBuscaPk;
    }

    function setSParamBuscaPk($sParamBuscaPk) {
        $this->sParamBuscaPk = $sParamBuscaPk;
    }

    function getSClasseBusca() {
        return $this->sClasseBusca;
    }

    function setSClasseBusca($sClasseBusca) {
        $this->sClasseBusca = $sClasseBusca;
    }

    function getSIdTela() {
        return $this->sIdTela;
    }

    function setSIdTela($sIdTela) {
        $this->sIdTela = $sIdTela;
    }

    function getId() {
        return $this->Id;
    }

    function getSLabel() {
        return $this->sLabel;
    }

    function getSTelaGrande() {
        return $this->sTelaGrande;
    }

    function getSTelaMedia() {
        return $this->sTelaMedia;
    }

    function getSTelaPequena() {
        return $this->sTelaPequena;
    }

    function getSTelaMuitoPequena() {
        return $this->sTelaMuitoPequena;
    }

    function getBDesativado() {
        return $this->bDesativado;
    }

    function setId($Id) {
        $this->Id = $Id;
    }

    function setSLabel($sLabel) {
        $this->sLabel = $sLabel;
    }

    function setSTelaGrande($sTelaGrande) {
        $this->sTelaGrande = $sTelaGrande;
    }

    function setSTelaMedia($sTelaMedia) {
        $this->sTelaMedia = $sTelaMedia;
    }

    function setSTelaPequena($sTelaPequena) {
        $this->sTelaPequena = $sTelaPequena;
    }

    function setSTelaMuitoPequena($sTelaMuitoPequena) {
        $this->sTelaMuitoPequena = $sTelaMuitoPequena;
    }

    function setBDesativado($bDesativado) {
        $this->bDesativado = $bDesativado;
    }

    function getSPlaceHolder() {
        return $this->sPlaceHolder;
    }

    function getSValor() {
        return $this->sValor;
    }

    function getBFocus() {
        return $this->bFocus;
    }

    function setSPlaceHolder($sPlaceHolder) {
        $this->sPlaceHolder = $sPlaceHolder;
    }

    function setSValor($sValor) {
        $this->sValor = $sValor;
    }

    function setBFocus($bFocus) {
        $this->bFocus = $bFocus;
    }

    function getSNome() {
        return $this->sNome;
    }

    function setSNome($sNome) {
        $this->sNome = $sNome;
    }

    function getITipoCampo() {
        return $this->iTipoCampo;
    }

    function setITipoCampo($iTipoCampo) {
        $this->iTipoCampo = $iTipoCampo;
    }

    /**
     * Método responsável pela inclusção de Filtros a serem renderizados
     */
    public function addFiltroValor($sValor) {
        $this->aFiltroValor[] = $sValor;
    }

    /**
     * Método que retorna a string do botão para pesquisa diretamento nos campos de procura pk
     */
    public function getBtnBuscaPk() {

        //captura a classe do campo de busca na posição 0 (suggest)
        $sCampoBusca = $this->getSCampoRetorno();
        $sClasseBusca = $this->getSClasseBusca(); //substr($aCampoBusca[0],0,strpos($aCampoBusca[0],".")); 

        $bTela = $this->getBBuscaTela();



        if ($bTela) {
            $sTela = $this->getSIdTela() . 'resize';
        } else {
            $sTela = $this->getSIdTela() . 'consulta';
        }



        if ($this->getSParamBuscaPk()) {
            $sParam = ',$("#' . $this->getSParamBuscaPk() . '").val()';
        }
        $sAcao = ' $("#' . $sTela . '").hide();requestAjax("' . $sTela . '-form","' . $sClasseBusca . '","' . mostraConsulta . '",""+abaSelecionada+",' . $sTela . ',' . $sCampoBusca . ',' . $this->getId() . '"' . $sParam . ');';

        return $sAcao;
    }

    /**
     * 
     * Método para adicionar valores nos campos select
     * 
     * @param string $sValue Value dos itens de campos select
     * @param string $sDescricao Descrição dos itens de campos select
     */
    function addItemSelect($sValue, $sDescricao) {
        $this->aItemsSelect[$sValue] = $sDescricao;
    }

    public function verficaCampoBloqueado($arg) {
        if ($arg or $this->getBSeq()) {
            return 'readonly="true"';
        }
    }

    /**
     * 
     * @param string $Evento Tipo do evento; Ex: Campo:EVENTO_
     * @param string $Funcao Funcão a ser executada após o gatilho do evento ser disparado
     * @author Carlos
     */
    function addEvento($Evento, $Funcao) {
        $aEvento['evento'] = $Evento;
        $aEvento['funcao'] = $Funcao;

        $this->aEventos[] = $aEvento;
    }

    /**
     * Retornará eventos
     * @return string
     * @author Carlos
     */
    function getRenderEventos() {
        if (!empty($this->aEventos)) {
            foreach ($this->aEventos as $Evento) {
                if ($Evento["evento"] == 'enter') {
                    $sRetorno = '<script>'
                            . '$(document).on("keydown", function(event) { '
                            . ' if(event.keyCode === 13) {'
                            . 'hasFocus = $("#' . $this->getId() . '").is(":focus"); '
                            . 'if(hasFocus){'
                            . $Evento["funcao"]
                            . '}'
                            . '} '
                            . '});'
                            . '</script>';
                } else {
                    $sRetorno = '<script>'
                            . '$("#' . $this->getId() . '").on("' . $Evento["evento"] . '", function(){'
                            . $Evento["funcao"]
                            . '});'
                            . '</script>';
                }
            }
            return $sRetorno;
        }
    }

    public function getRender() {
        switch ($this->iTipoCampo) {
            case self::CAMPO_TEXTO:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="form-group form-group-filter" id="' . $this->getId() . '">'
                        . '<div class="input-group"> '
                        . '<input class="form-control input-sm" name="' . $this->getSNome() . '" id="' . $this->getId() . '" type="text" placeholder="' . $this->getSLabel() . '" value="' . $this->aFiltroValor[0] . '"> '
                        . '<div class="input-group-btn"> '
                        . '<button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false" tabindex="-1"> '
                        . '<span class="caret"></span> '
                        . '</button> '
                        . '<ul class="dropdown-menu" id="' . $this->getId() . '-tipoFiltro">'
                        . '<li><a href="javascript:void(0)" class="small" data-value="contem" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="contem" type="radio" checked/>&nbsp;Contém</a></li>'
                        . '<li><a href="javascript:void(0)" class="small" data-value="comeca" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="comeca" type="radio" />&nbsp;Começa</a></li>'
                        . '<li><a href="javascript:void(0)" class="small" data-value="igual" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="igual" type="radio"/>&nbsp;Igual</a></li>'
                        . '</ul>'
                        . '</div> '
                        . '</div> '
                        . '</div> '
                        . '</div> ';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }
                break;
            case self::CAMPO_INTEIRO:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group form-group  form-group-filter" id="' . $this->getId() . '">'
                        . '<div class="input-group"> '
                        . '<input type="text" name="' . $this->getSNome() . '" class="form-control input-sm" id="' . $this->getId() . '" placeholder="' . $this->getSLabel() . '" value="' . $this->aFiltroValor[0] . '">'
                        . '<div class="input-group-btn">'
                        . '<button type="button" class="btn btn-default btn-outline dropdown-toggle" data-toggle="dropdown" aria-expanded="false" tabindex="-1">'
                        . '<span class="caret"></span>'
                        . '</button>'
                        . '<ul class="dropdown-menu" id="' . $this->getId() . '-tipoFiltro">'
                        . '<li><a href="javascript:void(0)" class="small" data-value="igual" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="igual" type="radio" checked/>&nbsp;Igual</a></li>'
                        . '<li><a href="javascript:void(0)" class="small" data-value="maior" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="maior" type="radio"/>&nbsp;Maior</a></li>'
                        . '<li><a href="javascript:void(0)" class="small" data-value="menor" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="menor" type="radio"/>&nbsp;Menor</a></li>'
                        . '<li><a href="javascript:void(0)" class="small" data-value="diferente" tabIndex="-1"><input name="' . $this->getSNome() . '-tipo" value="diferente" type="radio"/>&nbsp;Diferente</a></li>'
                        . '</ul>'
                        . '</div>'
                        . '</div> '
                        . '</div>'
                        . '</div>';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }
                break;


            case self::CAMPO_SELECT:
                if ($this->getBInline()) {
                    $sCampo = '<div class="form-inline">'
                            . '<div  class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                            . '<div class="form-group form-group-filter" id="' . $this->getId() . '-group">'
                            . '<label class="control-label" for="' . $this->getId() . '">' . $this->getSLabel() . '  </label>'
                            . '<select name="' . $this->getSNome() . '" class="form-control selectfiltro input-sm" id="' . $this->getId() . '" ' . $this->verficaCampoBloqueado($this->getBCampoBloqueado()) . '>';
                } else {
                    $sCampo = '<div  class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                            . '<div class="form-group form-group-filter">'
                            . '<div class="input-group" id="' . $this->getId() . '-group">'
                            . '<label for="' . $this->getId() . '">' . $this->getSLabel() . '  </label>'
                            . '<select name="' . $this->getSNome() . '" class="form-control selectfiltro input-sm" id="' . $this->getId() . '" ' . $this->verficaCampoBloqueado($this->getBCampoBloqueado()) . '>';
                }


                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                //verifica se há valor para renderizar o default do select
                if ($this->getSValor() != NULL) {
                    $sTrigger = '$("#' . $this->getId() . '").val("' . $this->getSValor() . '").trigger("change");';
                }


                $sCampo .= '</select>'
                        . '</div>  '
                        . '<script>'
                        . $sTrigger
                        . '</script> '
                        . $this->getRenderEventos()
                        . '</div></div>';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }
                break;
            case self::CAMPO_MONEY:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="input-group form-group  form-group-filter" id="' . $this->getId() . '">'
                        . '<span class="input-group-addon"><strong>R$</strong></span><input type="text" name="' . $this->getSNome() . '" class="form-control" id="input-money" placeholder="' . $this->getSLabel() . '" value="' . $this->aFiltroValor[0] . '">'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . ' >").maskMoney({showSymbol:false, decimal:",", thousands:"."});'
                        . '</script>';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }
                break;
            case self::CAMPO_DATA:

                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group date form-group form-group-filter" id="' . $this->getId() . '-ini">'
                        . '<input type="text" name="' . $this->getSNome() . '" class="form-control input-sm" placeholder="' . $this->getSLabel() . '" value="' . $this->aFiltroValor[0] . '">'
                        . '<span class="input-group-addon"><i class="icon wb-calendar"></i></span>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '-ini").datepicker({'
                        . 'format: "dd/mm/yyyy",'
                        . 'todayBtn: "linked",'
                        . 'language: "pt-BR",'
                        . 'autoclose: true,'
                        . 'todayHighlight: true,'
                        . '});'
                        . '</script>';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }

                break;
            case self::CAMPO_DATA_ENTRE:

                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group date form-group form-group-filter" id="' . $this->getId() . '-ini">'
                        . '<input type="text" name="' . $this->getSNome() . '" class="form-control data1 input-sm" placeholder="' . $this->getSLabel() . ' Inicial" value="' . $this->aFiltroValor[0] . '">'
                        . '<span class="input-group-addon"><i class="icon wb-calendar"></i></span>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '-ini").datepicker({'
                        . 'format: "dd/mm/yyyy",'
                        . 'todayBtn: "linked",'
                        . 'language: "pt-BR",'
                        . 'autoclose: true,'
                        . 'todayHighlight: true,'
                        . '});'
                        . '</script>'
                        . '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group date form-group form-group-filter" id="' . $this->getId() . '-fim">'
                        . '<input type="text" name="' . $this->getSNome() . '" class="form-control data2 input-sm" placeholder="' . $this->getSLabel() . ' Final" value="' . $this->aFiltroValor[1] . '">'
                        . '<span class="input-group-addon"><i class="icon wb-calendar"></i></span>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '-fim").datepicker({'
                        . 'format: "dd/mm/yyyy",'
                        . 'todayBtn: "linked",'
                        . 'language: "pt-BR",'
                        . 'autoclose: true,'
                        . 'todayHighlight: true,'
                        . '});'
                        . '</script>';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }

                break;

            case self::CAMPO_TEXTO_IGUAL:
                $sCampo = '<div class="col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '   <div class="form-group form-group  form-group-filter" id="' . $this->getId() . '"> '
                        . '       <input class="form-control input-sm" type="text" name="' . $this->getSNome() . '" placeholder="' . $this->getSLabel() . '"> '
                        . '   </div> '
                        . '</div> ';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }

                break;

            case self::CAMPO_BUSCADOBANCOPK;
                $sCampo = '<div class="col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" > '
                        . '<div class="input-group form-group  form-group-filter"  id="' . $this->getId() . '-group">   '
                        . '<input type="text" autocomplete="off" name="' . $this->getSNome() . '" class="form-control input-sm " id="' . $this->getId() . '" value=""  placeholder="' . $this->getSLabel() . '" >  '
                        . '<span class="input-group-btn">     '
                        . '<button title="Pesquisar" type="button" class="btn btn-primary btn-search btn-sm" id="' . $this->getId() . '-btn" style="margin-top: 0px; margin-rigth:0px;" ><i class="icon wb-search" aria-hidden="true"></i> '
                        . '</button>   </span> </div> '
                        . '</div> '
                        . '<script>$("#' . $this->getId() . '-btn").click(function(){'
                        . $this->getBtnBuscaPk()
                        . '});'
                        . '</script>';
                if ($this->getBQuebraLinha() == true) {
                    $sCampo .= '<br /><br />';
                }

                break;
        }
        return $sCampo;
    }

}
