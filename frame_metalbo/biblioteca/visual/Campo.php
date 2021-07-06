<?php

/**
 * Classe que implementa a estrutura Field do ExtJs
 *
 * @author Avanei Martendal
 * @since 13/11/2015
 */
//inclusão da classe Store


class Campo {

    private $sId; //id
    private $sNome; //name
    private $sLabel; //fieldLabel
    private $iTipo; //tipo do campo
    private $sPlaceHolder; //mensagem no interior do campo
    private $sValor; //define o valor do campo
    private $sTelaGrande; //Define o valor para tela grandes como note e pc
    private $sTelaMedia; //Define o valor para telas de tablets e notes pequenos
    private $sTelaPequena; //Define o valor para telas pequenas como tablets pequenos e celulares
    private $sTelaMuitoPequena; //Define o valor para telas muito pequenas como celulares pequenos
    private $bCNPJ; //Se true, define mascara do tipo CNPJ
    private $bNCM; //Se true, define mascara do tipo NCM
    private $bCPF; //Se true, define mascara do tipo CPF
    private $bCEP; //Se true, define mascara do tipo CEP
    private $bFone; //Se true, define mascara do tipo Fone
    private $aItemsSelect; //Array que contém as opções do select
    private $aItensRadio; //Array que contém opções do Radio
    private $bValorCheck; //Define se o check vai esta clicado ou não
    private $bCampoBloqueado; // define se o campo tem a propriedade disabled
    private $bDisabled;
    private $bFocus; //define se o campo terá p foco
    private $sClasseBusca;
    private $aCampoBusca;
    private $bApenasTela; //usado para definir que o campo é apenas usado na tela
    private $sValorCampoBusca; //armazena o valor inicial do campo de busca
    private $sRetornoBusca; //envia o campo de retorno nas pesquisas
    private $sValorBusca; //armazena o campo que retorna o codigo da busca no suggest
    private $sIdTela; //atributo para informar o id da tela quando necessário
    private $aValidacao; // Array onde é atribuida a avalidação do Campo
    private $iTamanho; // Variavel para constantes dos campos
    private $bOculto;
    private $sAcaoBtn;
    private $oBotao;
    private $bSeq; //seta o campo como sequenciável mas não bloqueado
    private $sTamanhoMaxKB; //define o tamanho máximo (em kbytes) dos arquivos a ser feito upload
    private $sExtensaoPermitidas; //Define as extensões permitidas para upload
    private $bDropZone;
    private $bDeleteBtn;
    private $sCampoRetorno; //define o campo que deve ser retornado de uma pesquisa
    private $aEventos; // Array contendo eventos do campo
    private $sIdPk; //chave primária onde ao selecionar o registro em um campo busca ele joga a chave primária
    private $iAltura; //Altura do campo 
    private $sIdHideEtapa;
    private $sTipoMoeda;
    private $sEstiloBadge;
    private $bTime;
    private $sCorFundo;
    private $oGrid;
    private $sController;
    private $iAlturaGrid;
    private $aParametros; //array que contém 
    private $iCaracter;
    private $aCabGridView;
    private $aLinhasGridView;
    private $aValorGridView;
    private $sTipoBotao;
    private $sCorCabGridView;
    private $sParamBuscaPk;
    private $listaDow;
    private $iMarginTop;
    private $bDesativado; //se true o botão estará bloqueado para o click
    private $sFont;
    private $sClasseUp; //define a classe do campo upload
    private $sMetodoUp; //define o método para upload
    private $sTituloModal;
    private $sNomeModal;
    private $iTamanhoLabel; //define de 1 ate o 7 qual o tamanho do label
    private $iTamFonteBadge;
    private $iTamMarginTopBadge = 25;
    private $sTituloGridPainel;
    private $sCorTituloGridPainel;
    private $iCasaDecimal;
    private $bNomeArquivo;
    private $sDiretorio;
    private $bUpperCase;
    private $sTabelaUpload;
    private $sParamSeq;
    private $iLarguraGrid;

    /**/

    const TIPO_DATA = 0;
    const TIPO_TEXTO = 1;
    const TIPO_MONEY = 2;
    const TIPO_SELECT = 3;
    const TIPO_RADIO = 4;
    const TIPO_UPLOAD = 5;
    const TIPO_CHECK = 6;
    const TIPO_TEXTAREA = 7;
    const TIPO_BUSCA = 8; //CAMPO SELECT CUSTOMIZADO PARA BUSCAR DIRETAMENTE DO BANCO DE DADOS AS PESQUISAS
    const TIPO_SENHA = 9;
    const TIPO_BOTAOSMALL = 10;
    const TIPO_CONFIRMA_SENHA = 11;
    const TIPO_BUSCADOBANCO = 12; //FAZ A BUSCA DIRETAMENTE DO BANCO E O CAMPO TAMBÉM ENTRA NO REQUEST
    const TIPO_BUSCADOBANCOPK = 13; //FAZ A BUSCA QUANDO DO CAMPO QUANDO É CHAVE PRIMARIA
    const TIPO_EDITOR = 15; //DEFINE CAMPO DO TIPO EDITOR
    const TIPO_BADGE = 16; //DEFINE SE O CAMPO SERÁ TIPO BADGE
    const TIPO_BOTAOSMALL_SUB = 17; //DEFINE SE SERÁ UM BOTÃO TIPO SUBMIT
    const TIPO_GRID = 18; //DEFINE SE O CAMPO SERÁ UM GRID
    const TIPO_GRIDVIEW = 19; //DEFINE UM GRID SOMENTE PARA CONSULTA TENDO UMA RENDERIZACAO INICIAL MAS SE ATUALIZA NO PHP
    const TIPO_DOWN = 20; //insere uma lista de downloads
    const TIPO_LINHABRANCO = 21;
    const TIPO_REMOVER_TELAGRID = 22;
    const TIPO_LABEL = 23;
    const TIPO_LINHA = 24;
    const TIPO_CONTROLE = 25;
    const TIPO_SELECTMULTI = 26;
    const CAMPO_SELECT = 27;
    const CAMPO_SELECTSIMPLE = 28;
    const TIPO_DECIMAL = 29;
    const TIPO_HISTORICO = 30;
    /**/
    const DIVISOR_SUCCESS = 31;
    const DIVISOR_VERMELHO = 32;
    const DIVISOR_INFO = 33;
    const DIVISOR_WARNING = 34;
    const DIVISOR_DARK = 35;
    /**/
    const TIPO_TAGS = 36;
    const TIPO_SELECTTAGS = 37;
    const TIPO_BOTAOSIMPLES = 38;
    const TIPO_DECIMAL_COMPOSTO = 39;
    const TIPO_BOTAO_MOSTRACONSULTA = 41;
    const TIPO_GRIDSIMPLE = 42;
    const TIPO_UPLOADMULTI = 43;
    const TIPO_TEXTO_GRANDE = 44;
    const TIPO_TESTE = 99;
    /**/
    const TAMANHO_NORMAL = 0;
    const TAMANHO_GRANDE = 2;
    const TAMANHO_PEQUENO = 1;
    /**/
    const EVENTO_SAIR = 'blur';
    const EVENTO_CHANGE = 'change';
    const EVENTO_FOCUS = 'focus';
    const EVENTO_KEYUP = 'keyup';
    const EVENTO_ENTER = 'enter';
    const EVENTO_CLICK = 'click';
    /**/
    const BADGE_SUCCESS = 'label-success';
    const BADGE_WARNING = 'label-warning';
    const BADGE_DANGER = 'label-danger';
    const BADGE_PRIMARY = 'label-primary';
    /**/
    const FUNDO_AMARELO = 'fundo_amarelo';
    const FUNDO_AZUL = 'fundo_azul';
    const FUNDO_VERDE = 'fundo_verde';
    const FUNDO_MONEY = 'fundo_money';
    const FUNDO_VERMELHO = 'fundo_vermelho';
    /**/
    const BUTTON_WARNING = 'btn-warning';
    const BUTTON_SUCCESS = 'btn-success';
    const BUTTON_PRIMARY = 'btn-primary';
    /**/
    const GRIDVIEW_CORACTIVE = 'active';
    const GRIDVIEW_CORSUCCESS = 'success';
    const GRIDVIEW_CORINFO = 'info';
    /**/
    const FONT_BOLD = 'bold';
    /**/
    const TITULO_SUCCESS = 'success';
    const TITULO_DARK = 'dark';
    const TITULO_DANGER = 'danger';
    const TITULO_WARNING = 'warning';

    /**
     * Construtor da classe Campo 
     * @param string $sLabel Label do campo
     * @param string $sNome Nome campo
     * @param integer $iTipo Define o tipo do campo
     * @param string $sTelaGrande Define o valor para telas de notebook e pc valores 1 ao 12
     *  @param string $sTelaMedia Define o valor para telas de tablets  1 ao 12
     *  @param string $sTelaPequena Define o valor para telas de celulares
     *  @param string $sTelaMuitoPequena Define o valor para telas de celulares pequenos
     *  @param integer $iAlturaGrid Define a altura se o campo for grid
     */
    public function __construct($sLabel, $sNome, $iTipo = self::TIPO_TEXTO, $sTelaGrande = '3', $sTelaMedia = '6', $sTelaPequena = '12', $sTelaMuitoPequena = '12', $iAltGrid = 400, $iLarguraGrid = 1800) {
        $this->sId = Base::getId();
        $this->setLabel($sLabel);
        $this->setNome($sNome);
        $this->setITipo($iTipo);
        $this->setSTelaGrande($sTelaGrande);
        $this->setSTelaMedia($sTelaMedia);
        $this->setSTelaPequena($sTelaPequena);
        $this->setSTelaMuitoPequena($sTelaMuitoPequena);
        $this->setBCNPJ(false);
        $this->setBCPF(false);
        $this->setBCEP(false);
        $this->setBFone(false);
        $this->setBCampoBloqueado(false);
        $this->setBDisabled(false);
        $this->setApenasTela(false);
        $this->setBFocus(false);
        $this->setBNCM(false);
        $this->setSTamanhoMaxKB('0'); //Define o tamanho máximo como ilitmitado
        $this->setBDeleteBtn('true');
        $this->setBDropZone('false');
        $this->setIAltura('100');
        $this->setITamanho(Campo::TAMANHO_PEQUENO);
        $this->setIAlturaGrid($iAltGrid);
        $this->setILarguraGrid($iLarguraGrid);
        $this->setSTipoBotao(Campo::BUTTON_PRIMARY);
        $this->setSCorCabGridView(Campo::GRIDVIEW_CORACTIVE);
        $this->setIMarginTop(0);
        $this->setSClasseUp('Upload');
        $this->setSMetodoUp('Upload');
        $this->setSCorTituloGridPainel(Campo::TITULO_DARK);
        $this->setICasaDecimal(2);
        $this->setBNomeArquivo(false);
        $this->setICaracter('10000');
        $this->setBUpperCase(false);
        $this->setITamMarginTopBadge(25);


        $this->sController = $_REQUEST['classe'];
        $this->aItemsSelect = array();
        $this->aItensRadio = array();
        $this->aCampoBusca = array();
        $this->aValidacao = array();
        $this->aEventos = array();
        $this->sEstiloBadge = Campo::BADGE_WARNING;
        $this->aParametros = array();
        $this->aCabGridView = array(); //define cabeçalhos do grid vies
        $this->aLinhasGridView = array(); //define as linhas dos grids
        $this->aValorGridView = array();
        $this->sTamanhoLabel = 5;


        switch ($this->iTipo) {
            case self::TIPO_BOTAOSMALL:
                $this->oBotao = new Botao($this->getLabel(), Botao::TIPO_SMALL, '', $sTelaGrande, $sTelaMedia, $sTelaPequena, $sTelaMuitoPequena);
                $this->sId = $this->getOBotao()->getId();
                break;
            case self::TIPO_BOTAOSMALL_SUB:
                $this->oBotao = new Botao($this->getLabel(), Botao::TIPO_SMALL_SUB, '', $sTelaGrande, $sTelaMedia, $sTelaPequena, $sTelaMuitoPequena);
                $this->sId = $this->getOBotao()->getId();
                break;
            case self::TIPO_BOTAOSIMPLES:
                $this->oBotao = new Botao($this->getLabel(), Botao::TIPO_BOTAOSIMPLES, '', $sTelaGrande, $sTelaMedia, $sTelaPequena, $sTelaMuitoPequena);
                $this->sId = $this->getOBotao()->getId();
                break;
            case self::TIPO_GRID:
                $this->oGrid = new Grid($sTelaGrande, $sTelaMedia, $sTelaPequena, $sTelaMuitoPequena, $iAltGrid);
                $this->oGrid->setSTituloConsulta($sLabel);
                $this->oGrid->setBDetalhte(true);
                $this->oGrid->setBGridCampo(true);
                $this->sId = $this->getOGrid()->getSId();
                break;
            case self::TIPO_LABEL:
                $this->setApenasTela(true);
                break;
        }
    }

    function getILarguraGrid() {
        return $this->iLarguraGrid;
    }

    function setILarguraGrid($iLarguraGrid) {
        $this->iLarguraGrid = $iLarguraGrid;
    }

    function getSParamSeq() {
        return $this->sParamSeq;
    }

    function setSParamSeq($sParamSeq) {
        $this->sParamSeq = $sParamSeq;
    }

    function getSTabelaUpload() {
        return $this->sTabelaUpload;
    }

    function setSTabelaUpload($sTabelaUpload) {
        $this->sTabelaUpload = $sTabelaUpload;
    }

    function getBUpperCase() {
        return $this->bUpperCase;
    }

    function setBUpperCase($bUpperCase) {
        $this->bUpperCase = $bUpperCase;
    }

    function getBDisabled() {
        return $this->bDisabled;
    }

    function setBDisabled($bDisabled) {
        $this->bDisabled = $bDisabled;
    }

    function getBNomeArquivo() {
        return $this->bNomeArquivo;
    }

    function getSDiretorio() {
        return $this->sDiretorio;
    }

    function setBNomeArquivo($bNomeArquivo) {
        $this->bNomeArquivo = $bNomeArquivo;
    }

    function setSDiretorio($sDiretorio) {
        $this->sDiretorio = $sDiretorio;
    }

    function getICasaDecimal() {
        return $this->iCasaDecimal;
    }

    function setICasaDecimal($iCasaDecimal) {
        $this->iCasaDecimal = $iCasaDecimal;
    }

    function getSCorTituloGridPainel() {
        return $this->sCorTituloGridPainel;
    }

    function setSCorTituloGridPainel($sCorTituloGridPainel) {
        $this->sCorTituloGridPainel = $sCorTituloGridPainel;
    }

    function getSTituloGridPainel() {
        return $this->sTituloGridPainel;
    }

    function setSTituloGridPainel($sTituloGridPainel) {
        $this->sTituloGridPainel = $sTituloGridPainel;
    }

    function getITamFonteBadge() {
        return $this->iTamFonteBadge;
    }

    function getITamMarginTopBadge() {
        return $this->iTamMarginTopBadge;
    }

    /**
     * Define o tamanho do fonte nos inteiros de 5 - 30
     * @param type $iTamFonteBadge
     */
    function setITamFonteBadge($iTamFonteBadge) {
        $this->iTamFonteBadge = $iTamFonteBadge;
    }

    /**
     * Define o tamanho da margim top nos inteiros de 5 - 30
     * @param type $iTamMarginTopBadge
     */
    function setITamMarginTopBadge($iTamMarginTopBadge) {
        $this->iTamMarginTopBadge = $iTamMarginTopBadge;
    }

    function getITamanhoLabel() {
        return $this->iTamanhoLabel;
    }

    /**
     * Define o tamanho do label nos inteiros de 1 - 7
     * @param type $iTamanhoLabel
     */
    function setITamanhoLabel($iTamanhoLabel) {
        $this->iTamanhoLabel = $iTamanhoLabel;
    }

    function getSNomeModal() {
        return $this->sNomeModal;
    }

    function setSNomeModal($sNomeModal) {
        $this->sNomeModal = $sNomeModal;
    }

    function getSTituloModal() {
        return $this->sTituloModal;
    }

    function setSTituloModal($sTituloModal) {
        $this->sTituloModal = $sTituloModal;
    }

    function getBNCM() {
        return $this->bNCM;
    }

    function setBNCM($bNCM) {
        $this->bNCM = $bNCM;
    }

    function getSClasseUp() {
        return $this->sClasseUp;
    }

    function getSMetodoUp() {
        return $this->sMetodoUp;
    }

    function setSClasseUp($sClasseUp) {
        $this->sClasseUp = $sClasseUp;
    }

    function setSMetodoUp($sMetodoUp) {
        $this->sMetodoUp = $sMetodoUp;
    }

    function getSFont() {
        return $this->sFont;
    }

    function setSFont($sFont) {
        $this->sFont = $sFont;
    }

    function getBDesativado() {
        return $this->bDesativado;
    }

    function setBDesativado($bDesativado) {
        $this->bDesativado = $bDesativado;
        $this->oBotao->setBDesativado($this->getBDesativado());
    }

    function getIMarginTop() {
        return $this->iMarginTop;
    }

    function setIMarginTop($iMarginTop) {
        $this->iMarginTop = $iMarginTop;
    }

    function getListaDow() {
        return $this->listaDow;
    }

    function setListaDow($listaDow) {
        $this->listaDow = $listaDow;
    }

    function getSParamBuscaPk() {
        return $this->sParamBuscaPk;
    }

    function setSParamBuscaPk($sParamBuscaPk) {
        $this->sParamBuscaPk = $sParamBuscaPk;
    }

    function getSCorCabGridView() {
        return $this->sCorCabGridView;
    }

    function setSCorCabGridView($sCorCabGridView) {
        $this->sCorCabGridView = $sCorCabGridView;
    }

    /**
     * adiciona acao em botoes
     */
    function addAcaoBotao($sAcao) {
        $this->getOBotao()->addAcao($sAcao);
    }

    //adiciona cabeçlhos 
    function addCabGridView($sTitulo) {
        $this->aCabGridView[] = $sTitulo;
    }

    /**
     * 
     * @param type $iLinha adiciona a linha
     * @param type $sValor adiciona o valor
     */
    function addLinhasGridView($iLinha, $sValor) {
        $this->aLinhasGridView[] = $iLinha;
        $this->aValorGridView [] = $iLinha . '=' . $sValor;
    }

    function getSTipoBotao() {
        return $this->sTipoBotao;
    }

    function setSTipoBotao($sTipoBotao) {
        $this->sTipoBotao = $sTipoBotao;
    }

    function getICaracter() {
        return $this->iCaracter;
    }

    function setICaracter($iCaracter) {
        $this->iCaracter = $iCaracter;
    }

    public function addParam($sCampo = null, $sValor = null) {
        $this->aParametros[] = $sCampo . ',' . $sValor;
        $this->getOGrid()->setAParametros($this->getAParametros());
    }

    function getAParametros() {
        return $this->aParametros;
    }

    function setAParametros($aParametros) {
        $this->aParametros = $aParametros;
    }

    function getSController() {
        return $this->sController;
    }

    function setSController($sController) {
        $this->sController = $sController;
        $this->getOGrid()->setController($sController);
    }

    function getOGrid() {
        return $this->oGrid;
    }

    function setOGrid($oGrid) {
        $this->oGrid = $oGrid;
    }

    function getBTime() {
        return $this->bTime;
    }

    function setBTime($bTime) {
        $this->bTime = $bTime;
    }

    function getSEstiloBadge() {
        return $this->sEstiloBadge;
    }

    function setSEstiloBadge($sEstiloBadge) {
        $this->sEstiloBadge = $sEstiloBadge;
    }

    function getSTipoMoeda() {
        return $this->sTipoMoeda;
    }

    function setSTipoMoeda($sTipoMoeda) {
        $sMoeda = '<span class="input-group-addon"><strong>' . $sTipoMoeda . '</strong></span>';
        $this->sTipoMoeda = $sMoeda;
    }

    function getSIdPk() {

        return $this->sIdPk;
    }

    function setSIdPk($sIdPk) {
        $this->sIdPk = $sIdPk;
    }

    function getSCampoRetorno() {
        return $this->sCampoRetorno;
    }

    function setSCampoRetorno($sCampoRetorno, $sIdTela = null) {
        $this->setSIdTela($sIdTela);
        $this->sCampoRetorno = $sCampoRetorno;
    }

    function getOBotao() {
        return $this->oBotao;
    }

    function setOBotao($oBotao) {
        $this->oBotao = $oBotao;
    }

    function getBSeq() {
        return $this->bSeq;
    }

    function setBSeq($bSeq) {
        $this->bSeq = $bSeq;
    }

    /**
     * Retorna o conteúdo do atributo sId
     * 
     * @return string
     */
    public function getId() {
        return $this->sId;
    }

    public function setId($id) {
        $this->sId = $id;
    }

    /**
     * Retorna o conteúdo do atributo sNome
     * 
     * @return string
     */
    public function getNome() {
        return $this->sNome;
    }

    /**
     * Define o valor do atributo sNome
     * 
     * @param string sNome 
     */
    public function setNome($sNome) {
        $this->sNome = $sNome;
    }

    /**
     * Retorna o conteúdo do atributo sLabel
     * 
     * @return string
     */
    public function getLabel() {
        return $this->sLabel;
    }

    /**
     * Define o valor do atributo sLabel
     * 
     * @param string sLabel 
     */
    public function setLabel($sLabel) {
        $this->sLabel = $sLabel;
    }

    /**
     * 
     * @return inteiro do tipo do campo
     */
    function getITipo() {
        return $this->iTipo;
    }

    /**
     * 
     * seta o tipo do campo
     */
    function setITipo($iTipo) {
        $this->iTipo = $iTipo;
    }

    /**
     * 
     * Retorna o placeHolder do componentes
     */
    function getSPlaceHolder() {
        return $this->sPlaceHolder;
    }

    /**
     * 
     * Seta o placeholder dos componentes
     */
    function setSPlaceHolder($sPlaceHolder) {
        $this->sPlaceHolder = $sPlaceHolder;
    }

    /**
     * 
     * Retorna o valor do atributo valor
     */
    function getSValor() {
        return $this->sValor;
    }

    /**
     * 
     * seta o atributo valor
     * 
     */
    function setSValor($sValor) {
        $this->sValor = $sValor;
    }

    /**
     * 
     * Recupera o valor da telas grande
     */
    function getSTelaGrande() {
        return $this->sTelaGrande;
    }

    /**
     * 
     * Seta o valor das telas grandes
     */
    function setSTelaGrande($sTelaGrande) {
        $this->sTelaGrande = $sTelaGrande;
    }

    /**
     * 
     * Retorna o valor para telas médias como notebook e tablets
     */
    function getSTelaMedia() {
        return $this->sTelaMedia;
    }

    /**
     * 
     * Define o valor para telas como nobook e tablets
     */
    function setSTelaMedia($sTelaMedia) {
        $this->sTelaMedia = $sTelaMedia;
    }

    /**
     * 
     * retorna o valor para telas pequenas
     */
    function getSTelaPequena() {
        return $this->sTelaPequena;
    }

    /**
     * 
     * seta o valor para telas pequenas
     */
    function setSTelaPequena($sTelaPequena) {
        $this->sTelaPequena = $sTelaPequena;
    }

    /**
     * 
     * Retorna o valor para telas muito pequenas
     */
    function getSTelaMuitoPequena() {
        return $this->sTelaMuitoPequena;
    }

    /**
     * 
     * Seta o valor para telas muito pequenas
     */
    function setSTelaMuitoPequena($sTelaMuitoPequena) {
        $this->sTelaMuitoPequena = $sTelaMuitoPequena;
    }

    /**
     * Retorna mascara CNPJ, quando true
     */
    function getBCNPJ() {
        return $this->bCNPJ;
    }

    /**

     * Seta mascara CNPJ     
     */
    function setBCNPJ($bCNPJ) {
        $this->bCNPJ = $bCNPJ;
    }

    /**
     * Retorna mascara CPF, quando true
     */
    function getBCPF() {
        return $this->bCPF;
    }

    /**
     * Seta mascara CPF, quando true
     */
    function setBCPF($bCPF) {
        $this->bCPF = $bCPF;
    }

    /**
     * Retorna mascara de CEP, quando true
     */
    function getBCEP() {
        return $this->bCEP;
    }

    /**
     * Seta mascara de CEP, quando true
     */
    function setBCEP($bCEP) {
        $this->bCEP = $bCEP;
    }

    /**
     * Retorna mascara de telefone, quando true
     */
    function getBFone() {
        return $this->bFone;
    }

    /**
     * Seta mascara de telefone, quando true
     */
    function setBFone($bFone) {
        $this->bFone = $bFone;
    }

    /**
     * 
     * retorna o array dos items do select
     */
    function getAItemsSelect() {
        return $this->aItemsSelect;
    }

    /**
     * 
     * seta os items do select
     */
    function setAItemsSelect($aItemsSelect) {
        $this->aItemsSelect = $aItemsSelect;
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

    /**
     * 
     * Método para retornar valores de campos Radio 
     */
    function getAItensRadio() {
        return $this->aItensRadio;
    }

    /**
     * 
     * Método para setar valores de campos Radio 
     */
    function setAItensRadio($aItensRadio) {
        $this->aItensRadio = $aItensRadio;
    }

    /**
     * 
     * Método para adicionar valores nos campos radio
     * 
     * @param string $sValue Value dos itens de campos radio
     * @param string $sDescricao Descrição dos itens de campos radio
     */
    function addItenRadio($sValue, $sDescricao) {
        $this->aItensRadio[$sValue] = $sDescricao;
    }

    /**
     * 
     * Retorna o valor de checked
     */
    function getBValorCheck() {
        return $this->bValorCheck;
    }

    /**
     * 
     * seta o valor de checked
     */
    function setBValorCheck($bValorCheck) {
        $this->bValorCheck = $bValorCheck;
    }

    /**
     * 
     * seta as linhas do textarea
     */
    function getILinhasTextArea() {
        return $this->iLinhasTextArea;
    }

    /**
     * 
     * recupera as linhas do text area
     */
    function setILinhasTextArea($iLinhasTextArea) {
        $this->iLinhasTextArea = $iLinhasTextArea;
    }

    /**
     * 
     * seta se o campo tem a digitação bloqueada
     */
    function getBCampoBloqueado() {
        return $this->bCampoBloqueado;
    }

    /**
     * 
     * recupera se o campo tem a digitação bloqueada
     */
    function setBCampoBloqueado($bCampoBloqueado) {
        $this->bCampoBloqueado = $bCampoBloqueado;
    }

    public function verificaCampoBloqueado($arg) {
        if ($arg or $this->getBSeq()) {
            return 'readonly="true"';
        }
    }

    public function verificaBtnDisabled($arg) {
        if ($arg or $this->getBSeq()) {
            return 'disabled';
        }
    }

    /**
     * 
     * @return type Retorna o atributo Focus
     */
    function getBFocus() {
        return $this->bFocus;
    }

    /**
     * 
     * @return type seta o atributo focus
     */
    function setBFocus($bFocus) {
        $this->bFocus = $bFocus;
    }

    /**
     * retorna o evento focus
     */
    function getRenderFocus() {
        return '$("#' . $this->getId() . '" ).focus();';
    }

    /**
     * 
     * retorna o valor campo busca
     */
    function getSValorCampoBusca() {
        return $this->sValorCampoBusca;
    }

    /**
     * 
     * seta o valor do campo busca
     */
    function setSValorCampoBusca($sValorCampoBusca) {
        $this->sValorCampoBusca = $sValorCampoBusca;
    }

    /**
     * Retorna o conteúdo do atributo sClasseBusca
     * 
     * @return string
     */
    public function getClasseBusca() {
        return $this->sClasseBusca;
    }

    /**
     * Retorna o conteúdo do atributo bApenasTela
     * 
     * @return boolean
     */
    public function getApenasTela() {
        return $this->bApenasTela;
    }

    /**
     * Define o valor do atributo bApenasTela
     * 
     * Este atributo controla se o campo deve ser utilizado apenas para
     * algum tipo de controle na tela ou se terá valor atribuído na classe
     * de persitência
     * 
     * @param boolean bApenasTela 
     */
    public function setApenasTela($bApenasTela) {
        $this->bApenasTela = $bApenasTela;
    }

    /**
     * 
     * Retorna o campo retorno da busca
     */
    function getSRetornoBusca() {
        return $this->sRetornoBusca;
    }

    /**
     * 
     * seta o campo retorno da busca
     */
    function setSRetornoBusca($sRetornoBusca) {
        $this->sRetornoBusca = $sRetornoBusca;
    }

    /**
     * 
     * Retorna o campo codigo do suggest
     */
    function getSValorBusca() {
        return $this->sValorBusca;
    }

    /**
     * 
     * seta o campo código do suggest
     */
    function setSValorBusca($sValorBusca) {
        $this->sValorBusca = $sValorBusca;
    }

    /**
     * 
     * Método que informa o id da tela a qual o campo pertence
     */
    function getSIdTela() {
        return $this->sIdTela;
    }

    /**
     * 
     * retorna o id da tela a qual o campo pertence
     */
    function setSIdTela($sIdTela) {
        $this->sIdTela = $sIdTela;
    }

    function getAValidacao() {
        return $this->aValidacao;
    }

    function getITamanho() {
        return $this->iTamanho;
    }

    function setITamanho($iTamanho) {
        $this->iTamanho = $iTamanho;
    }

    function getBOculto() {
        return $this->bOculto;
    }

    function setBOculto($bOculto) {
        $this->bOculto = $bOculto;
    }

    function getSAcaoBtn() {
        return $this->sAcaoBtn;
    }

    function setSAcaoBtn($sAcaoBtn) {
        $this->sAcaoBtn = $sAcaoBtn;
    }

    function getSTamanhoMaxKB() {
        return $this->sTamanhoMaxKB;
    }

    /**
     * Define o tamanho máximo dos arquivos a serem feito upload
     * @param STRING $sTamanhoMaxKB Tamanho em KB
     */
    function setSTamanhoMaxKB($sTamanhoMaxKB) {
        $this->sTamanhoMaxKB = $sTamanhoMaxKB;
    }

    function getSExtensaoPermitidas() {
        return $this->sExtensaoPermitidas;
    }

    function getBDropZone() {
        return $this->bDropZone;
    }

    function getBDeleteBtn() {
        return $this->bDeleteBtn;
    }

    function setBDropZone($bDropZone) {
        $this->bDropZone = $bDropZone;
    }

    function setBDeleteBtn($bDeleteBtn) {
        $this->bDeleteBtn = $bDeleteBtn;
    }

    function getAEventos() {
        return $this->aEventos;
    }

    function setAEventos($aEventos) {
        $this->aEventos = $aEventos;
    }

    function getIAltura() {
        return $this->iAltura;
    }

    function setIAltura($iAltura) {
        $this->iAltura = $iAltura;
    }

    function getSCorFundo() {
        return $this->sCorFundo;
    }

    function setSCorFundo($sCorFundo) {
        $this->sCorFundo = $sCorFundo;
    }

    /**
     * Retorna a saida do campo quando campo é persistido também na classe
     */
    public function getAcaoExitCampoBanco() {

        $sClasseBusca = $this->getClasseBusca();
        $aCampoBusca = $this->getCampoBusca(0);
        $buscaComposto = $sClasseBusca . '.' . $aCampoBusca[0];
        $sCampoFiltro = $sClasseBusca . '.' . $this->getSCampoRetorno();
        $sMetodo = 'getValorBuscaPk';
        $sAcao = '$("#' . $this->getId() . '").blur(function() {'
                . '            if ($(this).val()== ""){ '
                . '           $("#' . $aCampoBusca[1] . '").val(""); '
                . '       } '
                . 'var value = $(this).val();'
                . 'if(value !==""){'
                . 'requestAjax("' . $this->getSIdTela() . '-form","' . $sClasseBusca . '","' . $sMetodo . '",""+value+",' . $this->getId() . ',' . $buscaComposto . ',' . $sCampoFiltro . ',' . $aCampoBusca[1] . '",false,true);'
                . '}'
                . '});';

        return $sAcao;
    }

    /**
     * Retorna a acao da saida do campo
     */
    public function getAcaoExitCampo() {
        //'requestAjax("'.$this->getTela()->getId().'-form","'.$sClasse.'","'.$sMetodo.'","'.$this->getTela()->getId().','.$this->getTela()->getSRenderHide().','.$sCampoIncremento.'");';
        $sClasseBusca = $this->getClasseBusca();
        $aCampoBusca = $this->getCampoBusca(0);
        $buscaComposto = $sClasseBusca . '.' . $aCampoBusca[0];
        $sMetodo = 'getValorBusca';
        $sAcao = '<script>'
                . 'var cars = new Array("Saab", "Volvo", "BMW");'
                . '$("#' . $this->getId() . '").blur(function() {'
                . 'var value = $(this).val();'
                //.'requestAjax("","'.$sClasseBusca.'","'.$sMetodo.'",cars);'
                . 'requestAjax("' . $this->getSIdTela() . '-form","' . $sClasseBusca . '","' . $sMetodo . '",""+value+",' . $this->getId() . ',' . $buscaComposto . ',' . $this->getNome() . ',' . $this->getSRetornoBusca() . '",cars);'
                . '});'
                . '</script>';
        //.'requestAjax("","'.$sClasseBusca.'","'.$sMetodo.'","8,'.$this->getId().','.$buscaComposto.'");'
        return $sAcao;
    }

    /**
     * Método que retorna a string do botão para pesquisa diretamento nos campos de procura pk
     */
    public function getBtnBuscaPk() {

        //captura a classe do campo de busca na posição 0 (suggest)
        $sCampoBusca = $this->getSCampoRetorno();
        $sClasseBusca = $this->getClasseBusca(); //substr($aCampoBusca[0],0,strpos($aCampoBusca[0],".")); 

        /* if (isset($this->getSIdHideEtapa())){
          $sTela = $this->getSIdHideEtapa();
          }else
          {
          $sTela = $this->getSIdTela();
          } */
        $sTela = '';
        if (!empty($this->getSIdHideEtapa())) {
            $sTela = $this->getSIdHideEtapa();
        } else {
            $sTela = $this->getSIdTela();
        }

        if ($this->getSParamBuscaPk()) {
            $sParam = ',$("#' . $this->getSParamBuscaPk() . '").val()';
        }
        $sAcao = '$("#tabmenusuperior > li").each(function(){'
                . '  if($(this).hasClass("active")){ '
                . '        abaSelecionada = $(this).attr("id"); '
                . '       } '
                . '     }); ';
        $sAcao .= ' $("#' . $sTela . '").hide();requestAjax("' . $sTela . '-form","' . $sClasseBusca . '","' . mostraConsulta . '",""+abaSelecionada+",' . $sTela . ',' . $sCampoBusca . ',' . $this->getId() . '"' . $sParam . ');';

        return $sAcao;
    }

    function getSIdHideEtapa() {
        return $this->sIdHideEtapa;
    }

    function setSIdHideEtapa($sIdHideEtapa) {
        $this->sIdHideEtapa = $sIdHideEtapa;
    }

    function getIAlturaGrid() {
        return $this->iAlturaGrid;
    }

    function setIAlturaGrid($iAlturaGrid) {
        $this->iAlturaGrid = $iAlturaGrid;
    }

    /**
     * Método que retorna a string do objeto do botão de busca para ser 
     * renderizado e permite incluir buscas nos formulários para que o valor
     * possa ser adquirido a partir de uma consulta externa
     * 
     * @param string $sIdForm Id do formulário
     *
     * @return string
     */
    public function getBtnBusca() {
        $oReturn = null;
        //captura a classe do campo de busca na posição 0 (suggest)
        $aCampoBusca = $this->getCampoBusca(0);
        $sClasseBusca = $this->getClasseBusca(); //substr($aCampoBusca[0],0,strpos($aCampoBusca[0],".")); 

        /*
         * se a classe do campo de filtro for igual a classe de busca faz o envio 
         * apenas do nome do campo no model para capturar o nome do campo
         * no banco, ou seja, envia sem a classe
         */
        if (strtolower($sClasseBusca) === strtolower($this->getClasseBusca())) {
            $sCampoConsulta = substr($this->getNome(), strpos($this->getNome(), ".") + 1);
        } else {
            $sCampoConsulta = str_replace('.', '_', $this->getNome());
        }

        $sAcao = ' $("#' . $this->getSIdTela() . '").hide();requestAjax("","' . $sClasseBusca . '","' . mostraConsulta . '",""+abaSelecionada+",' . $this->getSIdTela() . ',' . $sCampoConsulta . ',' . $this->getId() . '")';
        //requestAjax("","'.$sClasseBusca.'","'.$sMetodoInc.'","'.$sTab.','.$sIdGrid.'");

        $oBtn = new Botao('', Botao::TIPO_PESQUISAR, $sAcao);
        return $oBtn->getRender();
    }

    /**
     * Método que renderiza o campo da busca
     */
    public function getCampoClasseBusca() {
        //captura a classe do campo de busca na posição 0 (suggest)
        $aCampoBusca = $this->getCampoBusca(0);
        $sClasseBusca = $this->getClasseBusca(); //substr($aCampoBusca[0],0,strpos($aCampoBusca[0],".")); 

        /*
         * se a classe do campo de filtro for igual a classe de busca faz o envio 
         * apenas do nome do campo no model para capturar o nome do campo
         * no banco, ou seja, envia sem a classe
         */
        if (strtolower($sClasseBusca) === strtolower($this->getClasseBusca())) {
            $sCampoConsulta = substr($this->getNome(), strpos($this->getNome(), ".") + 1);
        } else {
            $sCampoConsulta = str_replace('.', '_', $this->getNome());
        }
        //faz a busca inicial do campo pesquisa
        $oPersClasseBusca = Fabrica::FabricarPersistencia($sClasseBusca);
        $oModelClasseBusca = Fabrica::FabricarModel($sClasseBusca);
        $oPersClasseBusca->setModel($oModelClasseBusca);
        $oControllerClasseBusca = Fabrica::FabricarController($sClasseBusca);
        $aModelClasseBusca = $oPersClasseBusca->getArrayModel();

        $oCampoFormBusca = new Campo('Busca', 'select', Campo::TIPO_BUSCA, 4);
        $oCampoFormBusca->setSRetornoBusca($this->getId());
        $oCampoFormBusca->setClasseBusca($sClasseBusca);
        $oCampoFormBusca->setSValorBusca($this->getNome());


        $oCampoFormBusca->addCampoBusca($aCampoBusca[0], null, null);
        $this->setSRetornoBusca($oCampoFormBusca->getId());
        //verifica se há valor inicial que deve ser carregado
        if ($this->getSValorCampoBusca() != null) {
            $oCampoFormBusca->addItemSelect($this->getSValor(), $this->getSValorCampoBusca());
        }
        //insere o primeiro registro sem valor
        $oCampoFormBusca->addItemSelect('', '');
        foreach ($aModelClasseBusca as $key => $oCampoBusca) {
            //retorna a chave
            $aDados = array();
            $aDados[0] = $oControllerClasseBusca->getValorModel($oCampoBusca, $sCampoConsulta);
            $aDados[1] = $oControllerClasseBusca->getValorModel($oCampoBusca, $aCampoBusca[0]);
            $oCampoFormBusca->addItemSelect($aDados[0], $aDados[1]);
        }
        return $oCampoFormBusca->getRender();
    }

    /**
     * Define o valor do atributo sClasseBusca
     * 
     * @param string sClasseBusca Nome da classe de busca
     */
    public function setClasseBusca($sClasseBusca) {
        $this->sClasseBusca = $sClasseBusca;
    }

    /**
     * Define o valor do atributo aCampoBusca, usado nas ocasiões onde
     * se pretende preencher campos existentes no formulário com valores
     * retornados da consulta 
     * 
     * Usado também para diversos tipos de preenchimento de campos na tela 
     * sem necessariamente estar ligado a um campo de busca
     * 
     * @param string sCampoRetorno Nome do campo da busca que terá o valor retornado
     * @param string oCampoForm Campo do formulário que receberá o valor
     * @param string sIdTela campo que informa o id do formulário para ações

     */
    public function addCampoBusca($sCampoRetorno, $sIdCampoRetorno, $sIdTela = null) {
        $this->aCampoBusca[] = array($sCampoRetorno, $sIdCampoRetorno);
        $this->setSIdTela($sIdTela);
    }

    /**
     * Retorna o conteúdo do atributo aCampoBusca
     * 
     * @param integer $iPosicao Posição do vetor a ser retornada (opcional)
     * 
     * @return array
     */
    public function getCampoBusca($iPosicao = -1) {
        return $iPosicao === -1 ? $this->aCampoBusca : $this->aCampoBusca[$iPosicao];
    }

    /**
     * 
     * Método responsável por adicionar parâmetros para gerar validação, na renderização do form
     * 
     * @param boolean $bCampoVazio Permite que o campo esteja vazio
     * @param string/constante $Tipo Tipo da validação (Ex: inteiro, decimal, string, data, email...)
     * @param string $Mensagem Mensagem que deverá aparecer, caso o campo esteja inválido
     * @param string $StrLengMin Tamanho mímimo da String no Campo
     * @param string $StrLengMax Tamanho máximo da String no Campo
     * @param string $sCampoIgual Campo a ser comparado, quando a validação é do TIPO_IGUAL
     * @param string $sRegex Expressão Regular, caso o tipo seja da mesma. (Ex: Validacao::TIPO_CEP ou '/\d{2}\.\d{3}\-\d{3}/' )
     * @param string $sCallback Executa callback em JS/jQuery
     * @param string $sTrigger Define o trigger que irá fazer a validação
     */
    function addValidacao($bCampoVazio, $Tipo, $Mensagem = 'Valor Inválido', $StrLengMin = '0', $StrLengMax = '250', $sCampoIgual = '', $sRegex = '', $sCallback = '', $sTrigger = Validacao::TRIGGER_TODOS) {
        $aItem['id'] = $this->getId();
        $aItem['nome'] = $this->getNome();
        $aItem['descricao'] = $this->getLabel();
        $aItem['campovazio'] = $bCampoVazio;
        $aItem['tipo'] = $Tipo;
        $aItem['mensagem'] = $Mensagem;
        $aItem['strMin'] = $StrLengMin;
        $aItem['strMax'] = $StrLengMax;
        $aItem['regex'] = $sRegex;
        $aItem['xs'] = $this->getSTelaMuitoPequena();
        $aItem['campoigual'] = $sCampoIgual;
        $aItem['callback'] = $sCallback;
        $aItem['trigger'] = $sTrigger;
        $this->aValidacao = $aItem;

        // $aDados['nome'], $aDados['descricao'], $aDados['campovazio'], $aDados['tipo'], $aDados['regex']
    }

    function getTamanho($iTamanho) {
        if ($iTamanho == Campo::TAMANHO_PEQUENO) {
            return 'input-sm';
        } else if ($iTamanho == Campo::TAMANHO_GRANDE) {
            return 'input-lg';
        }
    }

    /**
     * Método que  que carrega visualização inicial, quando há registro no banco de dados
     * @param type $ArquivoDir
     * @return string
     */
    function getInitialPreview2($Arquivo) {
        if (!empty($Arquivo)) {

            $sRetorno = 'in';
        }

        echo 'carregaCamposReq("' . $this->getNome() . '","' . $this->getSValor() . '");';

        return $sRetorno;
    }

    function getInitialPreview($ArquivoDir) {
        if (!empty($ArquivoDir)) {

            $aArquivo = explode('.', $ArquivoDir); //Explode arquivo, após o ponto obrigatoriamente será a extensao
            $nomeArquivo = $aArquivo[0];
            $Extensao = $aArquivo[1];


            $sRetorno = ' initialPreview: ['; //Incio InitialPreview

            if (($Extensao == 'PNG') || ($Extensao == 'png') || ($Extensao == 'gif') || ($Extensao == 'GIF') || ($Extensao == 'jpg') || ($Extensao == 'JPG') || ($Extensao == 'jpeg') || ($Extensao == 'JPEG')) {
                $sRetorno .= '"<img src=\\\'uploads/' . $ArquivoDir . '\\\' class=\\\'file-preview-image\\\' alt=\\\'Alt\\\' title=\\\'' . $nomeArquivo . '\\\'>"';
            }

            if (($Extensao == 'pdf') || ($Extensao == 'PDF')) {
                $sRetorno .= '"<a href=\\\'uploads/' . $ArquivoDir . '\\\' target=\\\'_blank\\\'> <img class=\\\'icone-upload\\\' src=\\\'biblioteca/assets/images/icones/pdf.png\\\' class=\\\'file-preview-image\\\' alt=\\\'Alt\\\' title=\\\'' . $nomeArquivo . '\\\'> </a>"';
            }

            if (($Extensao == 'xls') || ($Extensao == 'xlsx') || ($Extensao == 'XLS') || ($Extensao == 'XLSX')) {
                $sRetorno .= '"<a href=\\\'uploads/' . $ArquivoDir . '\\\' target=\\\'_blank\\\'> <img class=\\\'icone-upload\\\' src=\\\'biblioteca/assets/images/icones/excel.png\\\' class=\\\'file-preview-image\\\' alt=\\\'Alt\\\' title=\\\'' . $nomeArquivo . '\\\'> </a>"';
            }

            if (($Extensao == 'doc') || ($Extensao == 'DOC') || ($Extensao == 'docx') || ($Extensao == 'DOCX')) {
                $sRetorno .= '"<a href=\\\'uploads/' . $ArquivoDir . '\\\' target=\\\'_blank\\\'> <img class=\\\'icone-upload\\\' src=\\\'biblioteca/assets/images/icones/word.png\\\' class=\\\'file-preview-image\\\' alt=\\\'Alt\\\' title=\\\'' . $nomeArquivo . '\\\'> </a>"';
            }

            if (($Extensao == 'ppt') || ($Extensao == 'pptx') || ($Extensao == 'PPT') || ($Extensao == 'PPTX')) {
                $sRetorno .= '"<a href=\\\'uploads/' . $ArquivoDir . '\\\' target=\\\'_blank\\\'> <img class=\\\'icone-upload\\\' src=\\\'biblioteca/assets/images/icones/powerpoint.png\\\' class=\\\'file-preview-image\\\' alt=\\\'' . $nomeArquivo . '\\\' title=\\\'' . $nomeArquivo . '\\\'> </a>"';
            }

            $sRetorno .= '],'; //Fim InitialPreview


            echo 'carregaCamposReq("' . $this->getNome() . '","' . $this->getSValor() . '");';
            return $sRetorno;
        }
    }

    public function setExtensoesPermitidas() {
        $aExtensoes = func_get_args();
        $iCount = 0;
        $this->sExtensaoPermitidas = '';
        foreach ($aExtensoes as $Extensao) {
            if ($iCount > 0) {
                $this->sExtensaoPermitidas .= ',"' . $Extensao . '"';
            } else {
                $this->sExtensaoPermitidas .= '"' . $Extensao . '"';
            }
            $iCount ++;
        }
    }

    /**
     * 
     * @param type $sExtensoes
     * @return string
     * @author Carlos
     */
    function getExtensoes($sExtensoes) {
        if (!empty($sExtensoes)) {
            $sRetorno = ' allowedFileExtensions : [' . $sExtensoes . '],';

            return $sRetorno;
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

    public function addCampos() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getOGrid()->addCampos($campoAtual);
        }
    }

    public function getRender() {
        switch ($this->iTipo) {
            case self::TIPO_DATA:
                $sCampo = '<div style="margin-top:' . $this->getIMarginTop() . 'px;" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<label class="control-label" for="input-date">' . $this->getLabel() . '</label>'
                        . '<div class="input-group date" id="' . $this->getId() . '-group" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . ' >'
                        . '<span class="input-group-addon"' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '><i class="icon wb-calendar"></i></span>'
                        . '<input style="font-size:12px;" type="text" id="' . $this->getId() . '"  name="' . $this->getNome() . '" class="form-control" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '-group").datepicker({'
                        . 'format: "dd/mm/yyyy",'
                        . 'todayBtn: "linked",'
                        . 'language: "pt-BR",'
                        . 'autoclose: true,'
                        . 'todayHighlight: true,';
                if ($this->getBCampoBloqueado()) {
                    $sCampo .= 'enableOnReadonly : false';
                }
                $sCampo .= '});'
                        . '</script>'
                        . $this->getRenderEventos();
                $sCampo .= '<script>'
                        . '$("#' . $this->getId() . '  ").mask("99/99/9999");'
                        . '</script>';
                break;
            case self::TIPO_TEXTO:
                $sCampo = //'<div class="form-group">'
                        '<div id="' . $this->getId() . '-campo"  style="margin-top:' . $this->getIMarginTop() . 'px !important" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<input type="text" style="font-weight:' . $this->getSFont() . '" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . ' " ' // IMPORTANTE!!!! REVER ID
                        . 'id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . htmlspecialchars($this->getSValor()) . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        //.'</div>'
                        . '</div>'
                        . $this->getRenderEventos()
                        . '<script>';
                if ($this->getBUpperCase() == true) {
                    $sCampo .= '$( "#' . $this->getId() . '").blur(function(){'
                            . '$( "#' . $this->getId() . '").val($( "#' . $this->getId() . '").val().toUpperCase());'
                            . '}); ';
                }
                $sCampo .= '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>';
                //verifica se existe campo de busca e monta renderização
                if ($this->getClasseBusca() != null) {
                    $sCampo .= $this->getBtnBusca();
                    $sCampo .= $this->getCampoClasseBusca();
                    $sCampo .= $this->getAcaoExitCampo();
                }
                if ($this->getBCNPJ()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '").mask("99.999.999/9999-99");'
                            . '</script>';
                }
                if ($this->getBCPF()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("999.999.999-99");'
                            . '</script>';
                }
                if ($this->getBCEP()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '  ").mask("99.999-999");'
                            . '</script>';
                }
                if ($this->getBFone()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '  ").mask("(99) 9999-9999");'
                            . '</script>';
                }
                if ($this->getBOculto()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '-campo").hide();'
                            . '</script>';
                }
                if ($this->getBTime()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("99:99");'
                            . '</script>';
                }
                if ($this->getBNCM()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("9999.99.99-999");'
                            . '</script>';
                }  //7318.24.00-000
                break;
            case self::TIPO_TEXTO_GRANDE:
                $sCampo = //'<div class="form-group">'
                        '<div id="' . $this->getId() . '-campo"  style="margin-top:' . $this->getIMarginTop() . 'px !important" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label style="font-size: 20px;" class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<input type="text" style="font-weight:' . $this->getSFont() . ';height: 50px;font-size: 40px;" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . ' " ' // IMPORTANTE!!!! REVER ID
                        . 'id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . htmlspecialchars($this->getSValor()) . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        //.'</div>'
                        . '</div>'
                        . $this->getRenderEventos()
                        . '<script>';
                if ($this->getBUpperCase() == true) {
                    $sCampo .= '$( "#' . $this->getId() . '").blur(function(){'
                            . '$( "#' . $this->getId() . '").val($( "#' . $this->getId() . '").val().toUpperCase());'
                            . '}); ';
                }
                $sCampo .= '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>';
                //verifica se existe campo de busca e monta renderização
                if ($this->getClasseBusca() != null) {
                    $sCampo .= $this->getBtnBusca();
                    $sCampo .= $this->getCampoClasseBusca();
                    $sCampo .= $this->getAcaoExitCampo();
                }
                if ($this->getBCNPJ()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '").mask("99.999.999/9999-99");'
                            . '</script>';
                }
                if ($this->getBCPF()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("999.999.999-99");'
                            . '</script>';
                }
                if ($this->getBCEP()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '  ").mask("99.999-999");'
                            . '</script>';
                }
                if ($this->getBFone()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '  ").mask("(99) 9999-9999");'
                            . '</script>';
                }
                if ($this->getBOculto()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '-campo").hide();'
                            . '</script>';
                }
                if ($this->getBTime()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("99:99");'
                            . '</script>';
                }
                if ($this->getBNCM()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("9999.99.99-999");'
                            . '</script>';
                }  //7318.24.00-000
                break;
            case self::TIPO_MONEY:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        //  .'<label for="input-money ">'.$this->getLabel().'</label>'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '' . $this->getSTipoMoeda() . '</span><input type="text" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . '" id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '").maskMoney({showSymbol:false, decimal:",", thousands:"."});'
                        . '</script>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_TESTE:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        //  .'<label for="input-money ">'.$this->getLabel().'</label>'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '</span><input type="text" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . '" id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '").number(true,3);'
                        //. '$("#' . $this->getId() . '").focus(function(){$("#' . $this->getId() . '").number(false,2);$("#' . $this->getId() . '").val("");});'
                        //. '$("#' . $this->getId() . '").number(true,2);'
                        // . '$("#' . $this->getId() . '").focus(function(){$("#' . $this->getId() . '").number(false,2);$("#' . $this->getId() . '").val("");});'
                        //. '$("#' . $this->getId() . '").blur(function(){$("#' . $this->getId() . '").number(true,2);});'
                        . '</script>'
                        . $this->getRenderEventos();
                break;

            case self::TIPO_DECIMAL:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        //  .'<label for="input-money ">'.$this->getLabel().'</label>'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '</span><input type="text" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . '" id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '").blur(function(){maskDecimal("' . $this->getId() . '")});'
                        . '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_DECIMAL_COMPOSTO:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        //  .'<label for="input-money ">'.$this->getLabel().'</label>'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '</span><input type="text" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . '" id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '").blur(function(){maskDecimal("' . $this->getId() . '","' . $this->getICasaDecimal() . '")});'
                        . '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_SELECT:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . ':</label>'
                        . '<select name="' . $this->getNome() . '" class="form-control" id="' . $this->getId() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>';
                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                //verifica se há valor para renderizar o default do select
                if ($this->getSValor() != NULL) {
                    $sTrigger = '$("#' . $this->getId() . '").val("' . $this->getSValor() . '").trigger("change");';
                }
                $sCampo .= '</div>'
                        . '</select>'
                        . '</div>  '
                        . '<script>'
                        . '$("#' . $this->getId() . '").select2({'
                        . '  placeholder: "' . $this->getSPlaceHolder() . '",'
                        . '  allowClear: true'
                        . '});'
                        . $sTrigger
                        . '</script> '
                        . $this->getRenderEventos()
                        . '</div>';
                break;
            case self::TIPO_SELECTTAGS:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . ':</label>'
                        . '<select name="' . $this->getNome() . '" class="form-control select2-hidden-accessible" multiple="" id="' . $this->getId() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>';
                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                //verifica se há valor para renderizar o default do select
                if ($this->getSValor() != NULL) {
                    $sTrigger = '$("#' . $this->getId() . '").val("' . $this->getSValor() . '").trigger("change");';
                }
                $sCampo .= '</div>'
                        . '</select>'
                        . '</div>  '
                        . '<script>'
                        . '$("#' . $this->getId() . '").select2({'
                        . '  placeholder: "' . $this->getSPlaceHolder() . '",'
                        . '  allowClear: false'
                        . '});'
                        . $sTrigger
                        . '</script> '
                        . $this->getRenderEventos()
                        . '</div>';
                break;
            case self::TIPO_RADIO:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="radio-group">'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<div id="' . $this->getId() . '" >';
                foreach ($this->getAItensRadio() as $key => $value) {
                    //verifica o item que deve checar em um update
                    $sChecked = "";
                    if ($this->getSValor() == $key) {
                        $sChecked = 'checked="true";';
                    }
                    $sCampo .= '<label class="radio-inline">'//class="radio-custom radio-success"
                            . '<input type="radio" name="' . $this->getNome() . '"  '
                            . 'value="' . $key . '"' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . ' ' . $sChecked . '>' . $value
                            . '</label>';
                }
                $sCampo .= '</div>'
                        . '</div>'
                        . '</div>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_UPLOAD:
                /*
                 * Documentação: http://plugins.krajee.com/file-input
                 */
                if ($this->getSValor() == '' || $this->getSValor() == null) {
                    $sCampo = '$("#' . $this->getId() . '").fileinput("clear"); ';
                }
                $sCampo = '<div id="' . $this->getId() . '-group" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<label>' . $this->getLabel() . '</label>'
                        . '<input type="file"  id="' . $this->getId() . '" name="' . $this->getNome() . '"  >'
                        . '</div>'
                        . '<script>'
                        . ' $("#' . $this->getId() . '").fileinput({'
                        . $this->getInitialPreview($this->getSValor())
                        . $this->getExtensoes($this->getSExtensaoPermitidas())
                        . 'maxFileSize: ' . $this->getSTamanhoMaxKB() . ', '  //tamanho máximo do arquivo (em kb) //
                        . 'language: "pt-BR", '                                          // idioma para ser definida (obrigatório)
                        . 'uploadUrl: "index.php?classe=' . $this->getSClasseUp() . '&metodo=' . $this->getSMetodoUp() . '&nome=' . $this->getNome() . '&parametros=' . $this->getSDiretorio() . ',' . $this->getBNomeArquivo() . '", ' // url do arquivo php, que fara a cópia para o server
                        . 'overwriteInitial: true, '
                        . 'initialCaption: "Selecione um arquivo...", '
                        . 'uploadAsync: true, '
                        . 'dropZoneEnabled : ' . $this->getBDropZone() . ', '                                    //desativa drag & drop
                        . 'showUpload: false, '                                                              // hide upload button
                        . 'showRemove: true, '                  //'.$this->getBDeleteBtn().'                        // hide remove button
                        . 'showClose: true'                                     // mostrar botão fechar do plugin //. $this->getInitialPreview($this->getSValor());
                        . '}).on("fileuploaded", function(event, data) {'
                        . 'carregaCamposReq(data.response.campo, data.response.nome);'
                        . '})'
                        . '.on("fileclear", function(evt) {'
                        . 'deletaCampoReq(evt.currentTarget.name);'
                        . '}); '
                        . $sCampo
                        . '</script>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_CHECK:
                if ($this->getBValorCheck()) {
                    $this->setSValor('TRUE');
                }
                if ($this->getSValor() == 'TRUE' || $this->getSValor() == 'true') {
                    $sCheck = 'checked';
                }
                $sCampo = '<div style="margin-top:20px" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div  style="margin-top:' . $this->getIMarginTop() . 'px;" id="' . $this->getId() . '-group" class="checkbox-custom checkbox-success">'//class="checkbox-custom checkbox-success"
                        . '<input  id="' . $this->getId() . '"  name="' . $this->getNome() . '" type="checkbox" value="true" ' . $sCheck . ' ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '</div>'
                        . '</div>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_TEXTAREA:
                $xValor = $this->getSValor();
                $xValor = str_replace("<br>", "&#10", $xValor);
                $xValor = str_replace("\r", "", $xValor);
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<label style="margin-top:' . $this->getIMarginTop() . 'px;" for=' . $this->getId() . '>' . $this->getLabel() . ':</label>'
                        . '<textarea style="font-size:12px;" maxlength="' . $this->getICaracter() . '" class="form-control" id="' . $this->getId() . '" name="' . $this->getNome() . '" rows="' . $this->getILinhasTextArea() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . $xValor
                        . '</textarea>'
                        . '</div>'
                        . $this->getRenderEventos()
                        . '<script>'
                        . '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>';
                break;
            case self::TIPO_HISTORICO:
                $xValor = $this->getSValor();
                $xValor = str_replace("<br>", "&#10", $xValor);
                $xValor = str_replace("\r", "", $xValor);
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<label style="margin-top:' . $this->getIMarginTop() . 'px;" for=' . $this->getId() . '>' . $this->getLabel() . ':</label>'
                        . '<textarea style="font-size:12px;" maxlength="' . $this->getICaracter() . '" class="form-control" id="' . $this->getId() . '" name="' . $this->getNome() . '" rows="' . $this->getILinhasTextArea() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . $xValor
                        . '</textarea>'
                        . '</div>'
                        . $this->getRenderEventos()
                        . '<script>'
                        . '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>';
                break;
            case self::TIPO_EDITOR:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<label for=' . $this->getId() . '>' . $this->getLabel() . ':</label>'
                        . '<textarea class="form-control summernote" id="' . $this->getId() . '" name="' . $this->getNome() . '"  ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . $this->getSValor()
                        . '</textarea>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '").summernote({'
                        . 'lang: "pt-BR",'
                        . 'height: "' . $this->getIAltura() . '",'
                        . 'onImageUpload: function(files, editor, welEditable) {'
                        . 'alert("bosta");'
                        . 'sendFile(files[0], "index.php?classe=Upload&metodo=Upload&nome=' . $this->getNome() . '", editor, welEditable);'
                        . '}'
                        . '});'
                        . '</script>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_BUSCA:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'//style="margin-left: 0px; padding-left:0px"
                        . '<div class="input-group" id="' . $this->getId() . '-group" >'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . ':</label>'
                        . '<select name="' . $this->getNome() . '" class="form-control" id="' . $this->getId() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . ' ' . $this->verificaBtnDisabled($this->getBDisabled()) . '>';
                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                $sCampoPesquisa = $this->getCampoBusca(0);
                $sCampo .= '</select>'
                        . '</div>'
                        . '</div>  '
                        . '<script>'
                        . '$("#' . $this->getId() . '").select2({'
                        . '  allowClear: true'
                        . '});'
                        . '$("#' . $this->getId() . '").on("change", function() {'
                        . 'var value = $(this).val();'
                        . '$("#' . $this->getSRetornoBusca() . '" ).val( value );'
                        . '});'
                        . '$("#select2-' . $this->getId() . '-container ~ span").click(function(){'
                        . ' classeBusca = "' . $this->getClasseBusca() . '";'
                        . ' metodoBusca = "getDadosBusca";'
                        . ' idbusca = "' . $this->getId() . '";'
                        . ' campoBusca = "' . $this->getClasseBusca() . '.' . $sCampoPesquisa[0] . '";'
                        . ' campoValor = "' . $this->getSValorBusca() . '"; '
                        . '});'
                        . '$("#select2-' . $this->getId() . '-container").click(function(){'
                        . ' classeBusca ="' . $this->getClasseBusca() . '";'
                        . ' metodoBusca = "getDadosBusca";'
                        . ' idbusca = "' . $this->getId() . '";'
                        . ' campoBusca ="' . $this->getClasseBusca() . '.' . $sCampoPesquisa[0] . '";'
                        . ' campoValor = "' . $this->getSValorBusca() . '"; '
                        . ' campoRetId = "' . $this->getSRetornoBusca() . '";'
                        . '});'
                        . '</script> '
                        . $this->getRenderEventos();
                //getSRetornoBusca()
                break;
            case self::TIPO_SENHA:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . ':</label>'
                        . '<input type="password" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . '" ' // IMPORTANTE!!!! REVER ID
                        . 'id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '"  ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_BOTAOSMALL:
                $sCampo = $this->getOBotao()->getRender();
                break;
            case self::TIPO_BOTAOSMALL_SUB:
                $sCampo = $this->getOBotao()->getRender();
                break;
            case self::TIPO_BOTAOSIMPLES:
                $sCampo = $this->getOBotao()->getRender();
                break;
            case self::TIPO_GRID:
                $sCampo = $this->getOGrid()->getRender();
                break;
            case self::TIPO_CONFIRMA_SENHA:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '">'
                        . '<label for="input-texto">' . $this->getLabel() . ':</label>'
                        . '<input type="password" name="' . $this->getNome() . '" class="form-control" '
                        . 'id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '">'
                        . '<label for="input-texto">Confirma ' . $this->getLabel() . ':</label>'
                        . '<input type="password" name="' . $this->getNome() . '" class="form-control" '
                        . 'id="' . $this->getId() . '-confirma" placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>'
                        . $this->getRenderEventos();
                break;
            case self::TIPO_BUSCADOBANCO:
                $aCampoBuscaDesc = $this->getCampoBusca(0);
                $sCampoBuscaDesc = $this->getClasseBusca() . '.' . $aCampoBuscaDesc[0];
                $aCampoBuscaPk = $this->getCampoBusca(1);
                $sCampoBuscaPk = $this->getClasseBusca() . '.' . $aCampoBuscaPk[0];
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<input class="form-control ' . $this->getTamanho($this->getITamanho()) . '" type="text" autocomplete="off" name="' . $this->getNome() . '" ' . $this->getTamanho($this->getITamanho()) . '" placeholder = "Pesquisar.." ' // IMPORTANTE!!!! REVER ID
                        . 'id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . htmlspecialchars($this->getSValor()) . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '<span class="block" > '
                        . '<div class="form-group"> '
                        . '  <select class="form-control" multiple="" id="' . $this->getId() . 'select"> '
                        . '  </select> '
                        //  .'<h6 style="margin-top:1px"><a href="#"> Pesquisar...</a></h6>'
                        //------------------------------------------------------------------------
                        . '<div id="' . $this->getId() . '-refreshPainel" class="panel " style="margin-bottom: 0px !important;margin-top: 1px !important;">'
                        . '<div class="panel-heading" style="height:22px;">'
                        . '<div class="panel-title"><div style="float: right"><a href="#" id="' . $this->getId() . '-refresh" style="margin-right:5px;">Atualizar</a><a class="panel-action icon wb-refresh" data-toggle="panel-refresh" data-load-type="round-circle" data-load-callback="customRefreshCallback" aria-hidden="true"></a></div></div>'
                        . '<script>'
                        . '$( "#' . $this->getId() . '-refreshPainel").hide();'
                        . '$( "#' . $this->getId() . '-refresh").click(function(){'
                        . ' requestAjax("","' . $this->getClasseBusca() . '","getDadosBuscaCampo",$("#' . $this->getId() . '").val()+",' . $sCampoBuscaDesc . ',' . $sCampoBuscaPk . ',' . $this->getId() . 'select",false,true);'
                        . '});'
                        . '</script>'
                        . '</div>'
                        . '</div>'


                        //-----------------------------------------------------------------------
                        . '</div> '
                        //----------------------------------------------------
                        . '</span> '
                        . '<script>'
                        . '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '
                        . '</script>'
                        . '<script>'
                        . '  $("#' . $this->getId() . 'select").hide();'
                        . '  $("#' . $this->getId() . '").keyup(function(){'
                        . '  $("#' . $this->getId() . 'select").show();'
                        . '   $( "#' . $this->getId() . '-refreshPainel").show();'
                        . 'var val=0;'
                        . 'val =$(this).val(); '
                        . 'if(val.length > 3){     '
                        . ' requestAjax("","' . $this->getClasseBusca() . '","getDadosBuscaCampo",$(this).val()+",' . $sCampoBuscaDesc . ',' . $sCampoBuscaPk . ',' . $this->getId() . 'select",false,true);'
                        //idForm,classe,metodo,sparametros,aIdCampos 
                        . '     } '
                        . '     if(val.length <= 1){ '
                        . '    } '
                        . '});'
                        . '$("#' . $this->getId() . 'select").click(function(){'
                        . 'var valor = $(this).val();'
                        . 'var texto = $("#' . $this->getId() . 'select option:selected").text();'
                        . '/*campo do filtro*/'
                        . '$("#' . $this->getSIdPk() . '").val(valor);'
                        . '$("#' . $this->getId() . '").val(texto);'
                        . '});'
                        . '$("#' . $this->getId() . 'select").change(function(){'
                        . 'var valor = $(this).val();'
                        . 'var texto = $("#' . $this->getId() . 'select option:selected").text();'
                        . '$("#' . $this->getSIdPk() . '").val(valor);'
                        . '$("#' . $this->getId() . '").val(texto); '
                        . '});'
                        . '$("#' . $this->getId() . 'select").blur(function(){'
                        . '$( "#' . $this->getId() . '-refreshPainel").hide();'
                        . '$(this).hide(); '
                        . 'var revalida = $("#' . $this->getSIdPk() . '").attr("name");'
                        //.'alert("nome revalida é "+revalida);'
                        . '$("#' . $this->getSIdTela() . '-form").formValidation("revalidateField", revalida);'
                        . '});'
                        . '$("#' . $this->getId() . 'select").blur(function(){'
                        . '$("#' . $this->getId() . '").blur();'
                        . '});'
                        . '</script>'
                        . '</div>'
                        . $this->getRenderEventos();
                //.'$("#'.$this->getSIdPk().'").focus();'
                break;
            case self::TIPO_BUSCADOBANCOPK:
                $sBtnSmall = ($this->getITamanho() == Campo::TAMANHO_PEQUENO) ? 'btn-sm' : '';
                $sCampo = '<div id="' . $this->getId() . '-campo" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '   <label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<input type="text" autocomplete="off" name="' . $this->getNome() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . ' " ' // IMPORTANTE!!!! REVER ID
                        . 'id="' . $this->getId() . '"  placeholder="' . $this->getSPlaceHolder() . '" value="' . $this->getSValor() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '   <span class="input-group-btn">';
                $this->verificaCampoBloqueado($this->getBCampoBloqueado()) == true ? $sCampo .= '     <button title="Pesquisar" disabled type="button" class="btn ' . $this->getSTipoBotao() . ' ' . $sBtnSmall . '" id="' . $this->getId() . '-btn" style="margin-top: 22px; margin-rigth:0px;padding:6px 10px 6px 10px !important;" ><i class="icon wb-search" aria-hidden="true"></i></button>' : $sCampo .= '     <button title="Pesquisar" ' . $this->verificaBtnDisabled($this->getBDisabled()) . ' type="button" class="btn ' . $this->getSTipoBotao() . ' ' . $sBtnSmall . '" id="' . $this->getId() . '-btn" style="margin-top: 22px; margin-rigth:0px;padding:6px 10px 6px 10px !important;" ><i class="icon wb-search" aria-hidden="true"></i></button>';
                $sCampo .= '   </span>'
                        . ' </div>'
                        . ' </div>'
                        . '<script>'
                        . '$( "#' . $this->getId() . '").addClass( "' . $this->getSCorFundo() . '" ); '//btn-block btn-default  btn btn-primary
                        . '</script>';
                if ($this->getBUpperCase() == true) {
                    $sCampo .= '<script>'
                            . '$( "#' . $this->getId() . '").blur(function(){'
                            . '$( "#' . $this->getId() . '").val($( "#' . $this->getId() . '").val().toUpperCase());'
                            . '});'
                            . '</script>';
                }
                $sCampo .= '<script>$("#' . $this->getId() . '-btn").click(function(){'
                        . $this->getBtnBuscaPk()
                        . '});'
                        . $this->getAcaoExitCampoBanco()
                        . '</script>'
                        . $this->getRenderEventos();
                if ($this->getBCNPJ()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '").mask("99.999.999/9999-99");'
                            . '</script>';
                }
                if ($this->getBCPF()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("999.999.999-99");'
                            . '</script>';
                }
                if ($this->getBCEP()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '  ").mask("99.999-999");'
                            . '</script>';
                }
                if ($this->getBFone()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '  ").mask("(99) 9999-9999");'
                            . '</script>';
                }
                if ($this->getBOculto()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . '-campo").hide();'
                            . '</script>';
                }
                if ($this->getBTime()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("99:99");'
                            . '</script>';
                }
                if ($this->getBNCM()) {
                    $sCampo .= '<script>'
                            . '$("#' . $this->getId() . ' ").mask("9999.99.99-999");'
                            . '</script>';
                }  //7318.24.00-000
                break;
            case self::TIPO_BADGE:
                $sCampo = '<div style="margin-top:' . $this->getITamMarginTopBadge() . 'px; font-size:' . $this->getITamFonteBadge() . 'px;" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<span id="' . $this->getId() . '" name="' . $this->getNome() . '" class="label label-round ' . $this->getSEstiloBadge() . '">' . $this->getLabel() . '</span> '
                        . '</div>';
                break;
            case self::TIPO_GRIDVIEW:
                $aLinhasGrid = array_unique($this->aLinhasGridView);
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="label-' . $this->getSCorTituloGridPainel() . '" id="' . $this->getId() . '-spantitulo"><span class="label label-' . $this->getSCorTituloGridPainel() . '" id="' . $this->getId() . '-spanvalor">' . $this->getSTituloGridPainel() . '</span></div>'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '    <table class="table table-condensed"  style="color:#101010; margin-top:' . $this->getIMarginTop() . 'px;" id="' . $this->getId() . '"> '
                        . '<thead>   '
                        . '  <tr class="' . $this->getSCorCabGridView() . '">    ';
                foreach ($this->aCabGridView as $key => $value) {
                    $sCampo .= '<th>' . $value . '</th> ';
                }
                $sCampo .= '  </tr>                 '
                        . '</thead>                '
                        . '<tbody>                 ';
                //foreach linhas
                foreach ($aLinhasGrid as $key => $valueLine) {
                    $sCampo .= '  <tr style="white-space:nowrap">                  ';
                    foreach ($this->aValorGridView as $keyvlr => $vlr) {
                        $aTd = explode('=', $vlr);
                        if ($aTd[0] == $valueLine) {
                            $sCampo .= '<td>' . $aTd[1] . '</td>';
                        }
                    }
                    $sCampo .= '  </tr> ';
                }
                $sCampo .= '</tbody>    '
                        . '</table>     '
                        . '</div>'
                        //.'</div>'
                        . '</div>';
                break;
            case self::TIPO_GRIDSIMPLE:
                $aLinhasGrid = array_unique($this->aLinhasGridView);
                $sCampo = '<div style="overflow-y: auto; height:400px;" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="label-' . $this->getSCorTituloGridPainel() . '"><span class="label label-' . $this->getSCorTituloGridPainel() . '">' . $this->getSTituloGridPainel() . '</span></div>'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '    <table  class="table-striped table-hover table table-condensed table-bordered"  style="color:#101010; margin-top:' . $this->getIMarginTop() . 'px;" id="' . $this->getId() . '"> '
                        . '<thead style="display: fixed">   '
                        . '  <tr style="white-space:nowrap" class="' . $this->getSCorCabGridView() . '">    ';
                foreach ($this->aCabGridView as $key => $value) {
                    $sCampo .= '<th>' . $value . '</th> ';
                }
                $sCampo .= '  </tr>                 '
                        . '</thead>                '
                        . '<tbody>                 ';
                //foreach linhas
                foreach ($aLinhasGrid as $key => $valueLine) {
                    $sCampo .= '  <tr style="white-space:nowrap">                  ';
                    foreach ($this->aValorGridView as $keyvlr => $vlr) {
                        $aTd = explode('=', $vlr);
                        if ($aTd[0] == $valueLine) {
                            $sCampo .= '<td>' . $aTd[1] . '</td>';
                        }
                    }
                    $sCampo .= '  </tr> ';
                }
                $sCampo .= '</tbody>    '
                        . '</table>     '
                        . '</div>'
                        . '</div>';
                break;
            case self:: TIPO_DOWN:
                $sCampo = '<ul class="list-group list-group-full list-group-dividered">'
                        . '<li class="list-group-item">'
                        . '<h4>' . $this->getLabel() . '</h4>'
                        . '<a class="search-result-link" href="' . $this->getListaDow() . '">Baixar lista</a>'
                        . '</li>'
                        . '</ul>';
                break;
            case self::TIPO_LINHABRANCO:
                $sCampo = '<div style="margin-top:10px" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        // .'<span id="'.$this->getId().'" class="label label-round '.$this->getSEstiloBadge().'">'.$this->getLabel().'</span> '
                        . '</div>';
                break;
            case self::TIPO_LABEL:
                $sCampo = '<div style="margin-top:' . $this->getIMarginTop() . 'px;" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<h' . $this->getITamanhoLabel() . ' id="' . $this->getId() . '" style="margin-top: 30px;"><b>' . $this->getLabel() . '</b></h' . $this->getITamanhoLabel() . '>'
                        . '</div>';
                break;
            case self::TIPO_LINHA:
                $sCampo = '<div><hr style="margin:7px; "><div>';
                break;
            case self::DIVISOR_SUCCESS:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="panel panel-bordered panel-success" style="margin-bottom: 0px !important;margin-top: 10px !important;">'
                        . '<div class="panel-heading" style="height:22px;">'
                        . '<h3 class="panel-title">' . $this->getLabel() . '</h3>'
                        . '</div>'
                        . '</div>'
                        . '</div>';
                break;
            case self::DIVISOR_VERMELHO:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="panel panel-bordered panel-danger" style="margin-bottom: 0px !important;margin-top: 10px !important;">'
                        . '<div class="panel-heading" style="height:22px;">'
                        . '<h3 class="panel-title">' . $this->getLabel() . '</h3>'
                        . '</div>'
                        . '</div>'
                        . '</div>';
                break;
            case self::DIVISOR_INFO:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="panel panel-bordered panel-info" style="margin-bottom: 0px !important;margin-top: 10px !important;">'
                        . '<div class="panel-heading" style="height:22px;">'
                        . '<h3 class="panel-title">' . $this->getLabel() . '</h3>'
                        . '</div>'
                        . '</div>'
                        . '</div>';
                break;
            case self::DIVISOR_WARNING:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="panel panel-bordered panel-warning" style="margin-bottom: 0px !important;margin-top: 10px !important;">'
                        . '<div class="panel-heading" style="height:22px;">'
                        . '<h3 class="panel-title">' . $this->getLabel() . '</h3>'
                        . '</div>'
                        . '</div>'
                        . '</div>';
                break;
            case self::DIVISOR_DARK:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="panel panel-bordered panel-dark" style="margin-bottom: 0px !important;margin-top: 10px !important;">'
                        . '<div class="panel-heading" style="height:22px;">'
                        . '<h3 class="panel-title">' . $this->getLabel() . '</h3>'
                        . '</div>'
                        . '</div>'
                        . '</div>';
                break;
            case self::TIPO_CONTROLE:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<input type="hidden" style="margin-top:' . $this->getIMarginTop() . 'px;" name="' . $this->getNome() . '" class="controle form-control ' . $this->getTamanho($this->getITamanho()) . ' " ' // IMPORTANTE!!!! REVER ID
                        . 'id="' . $this->getId() . '" placeholder="' . $this->getSPlaceHolder() . '" value="' . htmlspecialchars($this->getSValor()) . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '</div>';
                break;
            case self::CAMPO_SELECT:
                $sCampo = '<div style="margin-top:' . $this->getIMarginTop() . 'px;" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . ':</label>'
                        . '<select name="' . $this->getNome() . '" class="form-control" id="' . $this->getId() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>';

                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                //verifica se há valor para renderizar o default do select
                if ($this->getSValor() != NULL) {
                    $sTrigger = '$("#' . $this->getId() . '").val("' . $this->getSValor() . '").trigger("change");';
                }
                $sCampo .= '</div>'
                        . '</select>'
                        . '</div>  '
                        . '<script>'
                        /* .'$("#'.$this->getId().'").select2({'
                          .'  placeholder: "'.$this->getSPlaceHolder().'",'
                          .'  allowClear: true'
                          .'});' */
                        . $sTrigger
                        . '</script> '
                        . $this->getRenderEventos()
                        . '</div>';
                break;
            case self::TIPO_SELECTMULTI:
                $sCampo = '<div style="margin-top:' . $this->getIMarginTop() . 'px;" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<select name="' . $this->getNome() . '" style="height:108px; font-size:12px;" class="form-control" multiple=""  id="' . $this->getId() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>';

                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                //verifica se há valor para renderizar o default do select
                if ($this->getSValor() != NULL) {
                    $sTrigger = '$("#' . $this->getId() . '").val("' . $this->getSValor() . '").trigger("change");';
                }
                $sCampo .= '</div>'
                        . '</select>'
                        . '</div>'
                        . '<script>'
                        . $sTrigger
                        . '</script> '
                        . '</div>  ';
                break;
            case self::CAMPO_SELECTSIMPLE://margin-top:8px;
                $sCampo = '<div style="" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<div class="input-group" id="' . $this->getId() . '-group">'
                        . '<label for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<select name="' . $this->getNome() . '" class="form-control input-sm" id="' . $this->getId() . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>';

                foreach ($this->getAItemsSelect() as $key => $svalue) {
                    $sCampo .= '<option value="' . $key . '">' . $svalue . '</option>';
                }
                //verifica se há valor para renderizar o default do select
                if ($this->getSValor() != NULL) {
                    $sTrigger = '$("#' . $this->getId() . '").val("' . $this->getSValor() . '").trigger("change");';
                }
                $sCampo .= '</div>'
                        . '</select>'
                        . '</div>'
                        . '<script>'
                        . $sTrigger
                        . '</script> '
                        . $this->getRenderEventos()
                        . '</div>  ';
                break;
            case self::TIPO_TAGS:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<input style="font-weight:' . $this->getSFont() . '" name="' . $this->getNome() . '"  id="' . $this->getId() . '" class="form-control ' . $this->getTamanho($this->getITamanho()) . ' " ' // IMPORTANTE!!!! REVER ID
                        . 'placeholder="' . $this->getSPlaceHolder() . '" value="' . htmlspecialchars($this->getSValor()) . '" ' . $this->verificaCampoBloqueado($this->getBCampoBloqueado()) . '>'
                        . '</div>'
                        . '<script>'
                        . '$("#' . $this->getId() . '").tagsInput();'
                        . '</script>';
                break;
            case self::TIPO_BOTAO_MOSTRACONSULTA:
                $sCampo = '<div class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '  btn-acao-grid" style="margin-top:' . $this->getIMarginTop() . 'px;">'
                        . '<button type="button" class="btn btn btn-block btn-success " id="' . $this->getId() . '-btn" data-target="#' . $this->getSNomeModal() . '" data-toggle="modal">'
                        . '<span><i aria-hidden="true"></i>' . $this->getLabel() . '</span>'
                        . '</button>'
                        . '</div>'
                        . '<script>'
                        . ' $("#' . $this->getId() . '-btn").click(function(){'
                        . '$("#tabmenusuperior > li").each(function(){'
                        . 'if($(this).hasClass("active")){'
                        . 'abaSelecionada = $(this).attr("id");'
                        . '}'
                        . '}); '
                        . ' $("#' . $this->getSIdTela() . '").hide();requestAjax("' . $this->getSIdTela() . '-form","' . $this->getClasseBusca() . '","mostraConsulta",""+abaSelecionada+",' . $this->getSIdTela() . ',' . $this->getSCampoRetorno() . ',' . $this->getId() . ',false");'
                        . '}); '
                        . '</script>';
                break;
            case self::TIPO_UPLOADMULTI:
                /*
                 * Documentação: http://plugins.krajee.com/file-input
                 */
                if ($this->getSValor() == '' || $this->getSValor() == null) {
                    $sCampo = '$("#' . $this->getId() . '").fileinput("clear"); ';
                }
                $sCampo = '<div id="' . $this->getId() . '-group" class="campo-form col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '">'
                        . '<label class="control-label" for="' . $this->getId() . '">' . $this->getLabel() . '</label>'
                        . '<div class="input-group dropzone" id="' . $this->getId() . '">'
                        . '<input style="display:none" name="file" type="file" multiple />'
                        . '</div>'
                        . '<script>'
                        . 'var sParam = "' . $this->getSParamSeq() . '";'
                        . 'var aParam = [];'
                        . 'aParam = sParam.split(",");'
                        . 'var seq = $("#" + aParam[0] + "").val();'
                        . 'var cnpj = aParam[1];'
                        . '$("div#' . $this->getId() . '").dropzone({'
                        . 'url: "index.php?classe=UploadMulti&metodo=Upload&parametros=' . $this->getSDiretorio() . ',uploads' . $this->getSTabelaUpload() . '" + "," + seq + "," + cnpj,' // url do arquivo php, que fara a cópia para o server
                        . 'thumbnailWidth: "70",'
                        . 'thumbnailHeight: "70",'
                        . 'thumbnailMethod: "contain",'
                        . 'addRemoveLinks: true,'
                        . 'dictDefaultMessage: "Clique aqui ou arraste os arquivos",'
                        . 'dictRemoveFile: "Remover",'
                        . 'dictCancelUpload: "Cancelar"'
                        . '});'
                        . '</script>'
                        . '</div>';
                break;
        }
        return $sCampo;
    }

}

?>