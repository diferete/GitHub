<?php

//inclusão das bibliotecas visuais
Fabrica::requireBibliotecaVisual('Base');
Fabrica::requireBibliotecaVisual('Form');
Fabrica::requireBibliotecaVisual('Grid');
Fabrica::requireBibliotecaVisual('Cubo');
Fabrica::requireBibliotecaVisual('FormGrid');
Fabrica::requireBibliotecaVisual('TabPanel');
Fabrica::requireBibliotecaVisual('AbaTabPanel');
Fabrica::requireBibliotecaVisual('FieldSet');
Fabrica::requireBibliotecaVisual('Campo');
Fabrica::requireBibliotecaVisual('Grafico');
Fabrica::requireBibliotecaVisual('CampoConsulta');
Fabrica::requireBibliotecaVisual('Botao');
Fabrica::requireBibliotecaVisual('BotaoGrupo');
Fabrica::requireBibliotecaVisual('BotaoItem');
Fabrica::requireBibliotecaVisual('Mensagem');
Fabrica::requireBibliotecaVisual('Separador');
Fabrica::requireBibliotecaVisual('Relatorio');
Fabrica::requireBibliotecaVisual('Calendario');
Fabrica::requireBibliotecaVisual('Layout');
Fabrica::requireBibliotecaVisual('Modal');
Fabrica::requireBibliotecaVisual('Dropdown');
Fabrica::requireBibliotecaVisual('Filtro');
Fabrica::requireBibliotecaVisual('FormEtapa');
Fabrica::requireBibliotecaVisual('Validacao');
Fabrica::requireBibliotecaVisual('FieldSet');
Fabrica::requireBibliotecaVisual('MensagemMail');

abstract class View {

    //nomes dos métodos conforme ação da tela
    const ACAO_INCLUIR = 'acaoIncluir';
    const ACAO_ALTERAR = 'acaoAlterar';
    const ACAO_EXCLUIR = 'acaoExcluir';
    const ACAO_VISUALIZAR = 'acaoVisualizar';
    const ACAO_MOSTRA_TELA_INCLUIR = 'acaoMostraTelaIncluir';
    const ACAO_MOSTRA_TELA_ALTERAR = 'acaoMostraTelaAlterar';
    const ACAO_MOSTRA_TELA_VISUALIZA = 'acaoMostraTelaVisualiza';
    const ACAO_MOSTRA_RELATORIO = 'acaoMostraRelatorio';
    //constantes que indicam o tipo da rotina da tela
    const ROTINA_INCLUIR = 0;
    const ROTINA_ALTERAR = 1;
    //constantes que indicam a a��o dos valores no controle individual dos bot�es (habilita/desabilita) das consultas
    const VALORES_HABILITA_BOTAO = 1;
    const VALORES_DESABILITA_BOTAO = 2;

    private $sController;
    private $oTela;
    private $sTitulo;
    private $iRotinaTela;
    private $aAcoesExtraGravar;
    private $aBotoesExtra;
    private $aCondicional;
    private $aGroupBy;
    private $aOrderBy;
    private $sParametrosIncluir;
    private $acaoExtraLimpar;
    private $usaAcaoIncluir;
    private $usaAcaoAlterar;
    private $usaAcaoExcluir;
    private $usaAcaoVisualizar;
    private $codigoRotina;
    private $bAcaoIncluirTela;
    private $bAcaoLimparTela;
    private $bAcaoFecharTela;
    private $aParametrosExtras;
    private $aModelDados;
    private $sCabtela;
    private $oModelManual;
    private $sRenderPara;
    private $bAdicionaTotalizador;
    private $sRotina;
    private $usaDropdown;
    private $aDropdown;
    private $usaAtualizar;
    private $usaFiltro;
    private $aFiltro;
    private $bEtapa; //define se o sistema usa etapas ou n�o
    private $sControllerDetalhe;
    private $oGridDetalhe;
    private $bTela;
    private $sIdHideEtapa;
    private $bScrollInf;
    private $bDesativaAcaoConsulta;
    private $sIdUpload;
    private $sIdControleUpAlt;
    private $sIdAbaSelecionada;
    private $bUsaCarrGrid;
    private $oObjTela;
    private $bOcultaBotTela; //ocultar os botões quando não é necessário
    private $bGravaHistorico;
    private $sIdsTelas;
    private $bOcultaFechar;
    
    
    function getBOcultaFechar() {
        return $this->bOcultaFechar;
    }

    function setBOcultaFechar($bOcultaFechar) {
        $this->bOcultaFechar = $bOcultaFechar;
    }

    function getSIdsTelas() {
        return $this->sIdsTelas;
    }

    function setSIdsTelas($sIdsTelas) {
        $this->sIdsTelas = $sIdsTelas;
    }

    function setBGravaHistorico($bGravaHistorico) {
        $this->bGravaHistorico = $bGravaHistorico;
    }

    function getBGravaHistorico() {
        return $this->bGravaHistorico;
    }

    function getBUsaCarrGrid() {
        return $this->bUsaCarrGrid;
    }

    function setBUsaCarrGrid($bUsaCarrGrid) {
        $this->bUsaCarrGrid = $bUsaCarrGrid;
    }

    /**
     * Oculta o botão confirmar da tela
     * @param type $bOcultaBotTela
     */
    function getBOcultaBotTela() {
        return $this->bOcultaBotTela;
    }

    /**
     * Oculta o botão confirmar da tela
     * @param type $bOcultaBotTela
     */
    function setBOcultaBotTela($bOcultaBotTela) {
        $this->bOcultaBotTela = $bOcultaBotTela;
    }

    function getOObjTela() {
        return $this->oObjTela;
    }

    function setOObjTela($oObjTela) {
        $this->oObjTela = $oObjTela;
    }

    function getSIdAbaSelecionada() {
        return $this->sIdAbaSelecionada;
    }

    function setSIdAbaSelecionada($sIdAbaSelecionada) {
        $this->sIdAbaSelecionada = $sIdAbaSelecionada;
    }

    function getSIdControleUpAlt() {
        return $this->sIdControleUpAlt;
    }

    function setSIdControleUpAlt($sIdControleUpAlt) {
        $this->sIdControleUpAlt = $sIdControleUpAlt;
    }

    function getSIdUpload() {
        return $this->sIdUpload;
    }

    function setSIdUpload($sIdUpload) {
        $this->sIdUpload = $sIdUpload;
    }

    function getBScrollInf() {
        return $this->bScrollInf;
    }

    /**
     * 
     * @param type $bScrollInf
     * Seta como scroll infinito
     */
    function setBScrollInf($bScrollInf) {
        $this->bScrollInf = $bScrollInf;
        $this->getTela()->setBScrollInf($bScrollInf);
    }

    function getBDesativaAcaoConsulta() {
        return $this->bDesativaAcaoConsulta;
    }

    function setBDesativaAcaoConsulta($bDesativaAcaoConsulta) {
        $this->bDesativaAcaoConsulta = $bDesativaAcaoConsulta;
    }

    function getSIdHideEtapa() {
        return $this->sIdHideEtapa;
    }

    function setSIdHideEtapa($sIdHideEtapa) {
        $this->sIdHideEtapa = $sIdHideEtapa;
    }

    public function setAdicionaTotalizador($bAdicionaTotalizador) {
        $this->getTela()->setAdicionaTotalizador($bAdicionaTotalizador);
    }

    public function setTelaController($sController) {
        $this->getTela()->setController($sController);
    }

    public function getAdicionaTotalizador() {
        return $this->bAdicionaTotalizador;
    }

    public function getSRenderPara() {
        return $this->sRenderPara;
    }

    public function setSRenderPara($sRenderPara) {
        $this->sRenderPara = $sRenderPara;
    }

    /**
     * Construtor da classe View
     */
    public function __construct() {
        $this->aAcoesExtraGravar = array();
        $this->aCondicional = array();
        $this->aBotoesExtra = array();
        $this->aGroupBy = array();
        $this->aOrderBy = array();
        $this->aParametrosExtras = array();
        $this->aModelDados = array();

        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAtualizar(true);
        $this->setUsaFiltro(true);
        $this->setAcaoIncluirTela(true);
        $this->setAcaoLimparTela(true);
        $this->setAcaoFecharTela(true);
    }

    function getAModelDados() {
        return $this->aModelDados;
    }

    function setAModelDados($aModelDados) {
        $this->aModelDados = $aModelDados;
    }

    public function getOGridDetalhe() {
        return $this->oGridDetalhe;
    }

    public function setOGridDetalhe($oGridDetalhe) {
        $this->oGridDetalhe = $oGridDetalhe;
    }

    public function getAParametrosExtras() {
        return $this->aParametrosExtras;
    }

    public function setAParametrosExtras($aParametrosExtras) {
        $this->aParametrosExtras = $aParametrosExtras;
    }

    public function getCodigoRotina() {
        return $this->codigoRotina;
    }

    public function setCodigoRotina($codigoRotina) {
        $this->codigoRotina = $codigoRotina;
        return $this;
    }

    public function getUsaAcaoIncluir() {
        return $this->usaAcaoIncluir;
    }

    public function getUsaAcaoAlterar() {
        return $this->usaAcaoAlterar;
    }

    public function getUsaAcaoExcluir() {
        return $this->usaAcaoExcluir;
    }

    public function getUsaAcaoVisualizar() {
        return $this->usaAcaoVisualizar;
    }

    public function setUsaAcaoIncluir($usaAcaoIncluir) {
        $this->usaAcaoIncluir = $usaAcaoIncluir;
        return $this;
    }

    public function setUsaAcaoAlterar($usaAcaoAlterar) {
        $this->usaAcaoAlterar = $usaAcaoAlterar;
        return $this;
    }

    public function setUsaAcaoExcluir($usaAcaoExcluir) {
        $this->usaAcaoExcluir = $usaAcaoExcluir;
        return $this;
    }

    public function setUsaAcaoVisualizar($usaAcaoVisualizar) {
        $this->usaAcaoVisualizar = $usaAcaoVisualizar;
        return $this;
    }

    public function getAcaoIncluirTela() {
        return $this->bAcaoIncluirTela;
    }

    public function getAcaoLimparTela() {
        return $this->bAcaoLimparTela;
    }

    public function getAcaoFecharTela() {
        return $this->bAcaoFecharTela;
    }

    public function setAcaoIncluirTela($bAcaoIncluirTela) {
        $this->bAcaoIncluirTela = $bAcaoIncluirTela;
    }

    public function setAcaoLimparTela($bAcaoLimparTela) {
        $this->bAcaoLimparTela = $bAcaoLimparTela;
    }

    public function setAcaoFecharTela($bAcaoFecharTela) {
        $this->bAcaoFecharTela = $bAcaoFecharTela;
    }

    public function getAcaoExtraLimpar() {
        return $this->acaoExtraLimpar;
    }

    public function setAcaoExtraLimpar($acaoExtraLimpar) {
        $this->acaoExtraLimpar = $acaoExtraLimpar;
    }

    function getUsaDropdown() {
        return $this->usaDropdown;
    }

    function setUsaDropdown($usaDropdown) {
        $this->usaDropdown = $usaDropdown;
    }

    function getUsaAtualizar() {
        return $this->usaAtualizar;
    }

    function setUsaAtualizar($usaAtualizar) {
        $this->usaAtualizar = $usaAtualizar;
    }

    function getBEtapa() {
        return $this->bEtapa;
    }

    function setBEtapa($bEtapa) {
        $this->bEtapa = $bEtapa;
    }

    function getBTela() {
        return $this->bTela;
    }

    function setBTela($bTela) {
        $this->bTela = $bTela;
        $this->getTela()->setBTela(TRUE);
    }

    public function setParametrosAcaoIncluir($sParametros, $sCamposFiltrosExtra = null, $sValoresFiltrosExtra = null) {
        $this->sParametrosIncluir = $sParametros;

        if ($sCamposFiltrosExtra != null) {
            $aCampos = explode(',', $sCamposFiltrosExtra);
            $aValores = explode(',', $sValoresFiltrosExtra);
            foreach ($aCampos as $i => $sAtual) {
                if ($this->sParametrosIncluir != "") {
                    $this->sParametrosIncluir .= '&';
                }
                $this->sParametrosIncluir .= $sAtual . '=' . $aValores[$i];
            }
        }
    }

    public function getParametrosAcaoIncluir() {
        return $this->sParametrosIncluir;
    }

    /**
     * Retorna o objeto da tela
     * 
     * @return object
     */
    public function getTela() {
        return $this->oTela;
    }

    /**
     * Método responsável por chamar o Controller e retornar o objeto
     * View solicitado
     * 
     * @param String Nome da classe que ter� a tela retornada
     * @param string $sParametrosCriaTela String contendo os par�metros utilizados
     *                                    no m�todo criaTela dos objetos View
     *                                    devidamente separados por v�rgula
     * 
     * @return Objet Objeto View solicitado
     */
    public function getTelaExterna($sClasse, $sParametrosCriaTela = "") {
        $oController = Fabrica::FabricarController($this->getController());
        return $oController->getTelaExterna($sClasse, $sParametrosCriaTela);
    }

    /**
     * Retorna o conte�do do atributo sController
     * 
     * @return string
     */
    public function getController() {
        return $this->sController;
    }

    /**
     * Define o valor do atributo sController
     * 
     * @param string $sController 
     */
    public function setController($sController) {
        $this->sController = $sController;
    }

    /**
     * M�todo que cria uma mensagem de informa��o
     * 
     * @param string $sMsg
     * @param string $sFuncao
     * 
     * @return string String do objeto a ser renderizado pelo sistema 
     */
    public function mensagemInfo($sMsg, $sFuncao = null, $bFecha = true) {
        return $this->mensagem(Mensagem::$INFORMACAO, 'Informação', $sMsg, Mensagem::$OK, $sFuncao, $bFecha);
    }

    /**
     * M�todo que cria uma mensagem de alerta
     * 
     * @param string $sMsg
     * @param string $sFuncao
     * 
     * @return string String do objeto a ser renderizado pelo sistema 
     */
    public function mensagemAlerta($sMsg, $sFuncao = null) {
        return $this->mensagem(Mensagem::$ALERTA, 'Alerta', $sMsg, Mensagem::$OK, $sFuncao);
    }

    /**
     * M�todo que cria uma mensagem de erro
     * 
     * @param string $sMsg
     * @param string $sFuncao
     * 
     * @return string String do objeto a ser renderizado pelo sistema 
     */
    public function mensagemErro($sMsg, $sFuncao = null) {
        return $this->mensagem(Mensagem::$ERRO, 'Erro', $sMsg, Mensagem::$OK, $sFuncao);
    }

    /**
     * M�todo que cria uma mensagem do tipo pergunta
     * 
     * @param string $sMsg
     * @param string $sFuncao
     * 
     * @return string String do objeto a ser renderizado pelo sistema 
     */
    public function mensagemPergunta($sMsg, $sFuncao = null) {
        return $this->mensagem(Mensagem::$PERGUNTA, 'Pergunta', $sMsg, Mensagem::$SIM_NAO, $sFuncao);
    }

    /**
     * M�todo que cria uma mensagem personalizada
     * 
     * @param string $iTipo
     * @param string $sTitulo
     * @param string $sMsg
     * @param string $iBotoes
     * @param string $sFuncao
     * 
     * @return string String do objeto a ser renderizado pelo sistema 
     */
    public function mensagem($iTipo, $sTitulo, $sMsg, $iBotoes, $sFuncao, $bFecha = true) {
        $oMsg = new Mensagem($iTipo, $sTitulo, $sMsg, $iBotoes, $sFuncao);
        $oMsg->setFechar($bFecha);
        return $oMsg->getRender();
    }

    /**
     * M�todo que executa as fun��es necess�rias e comuns para permitir a 
     * cria��o das telas grid 
     * 
     * @param integer $iAltura Altura do componente grid na tela
     * @param integer $iLargura Largura do componente grid na tela
     */
    public function criaTelaGrid($iAltura = 150, $iLargura = '100%') {
        $this->oTela = new FormGrid($this->getTitulo(), $iAltura, $iLargura);
    }

    /**
     * Método que executa as funções necessárias e comuns para permitir a 
     * criação das telas de cadastro/alteração
     */
    public function criaTela() {
        $this->oTela = new Form("");
        //$this->setTituloTela('Cadastro de '.$this->getTitulo());
    }

    /**
     * Método que executa funções para renderizar telas modais 
     */
    public function criaModal() {
        $this->oTela = new Form("");
    }

    /**
     * Método que executa as funções necessárias e comuns para permitir a 
     * criação das consultas
     */
    public function criaConsulta() {
        $this->oTela = new Grid("");
    }

    /**
     * Método para cria grid de telas detalhe
     */
    public function criaGridDetalhe($sIdAba) {
        $this->oGridDetalhe = new Grid();
        $this->getOGridDetalhe()->setAbaSel($sIdAba);
    }

    /**
     * M�todo que executa as fun��es necess�rias e comuns para permitir a 
     * cria��o das consultas com o componente cubo
     */
    public function criaCubo() {
        $this->oTela = new Cubo("");
        $this->getTela()->setTitulo('Consulta Gerencial de ' . $this->getTitulo());
    }

    /**
     * M�todo que executa as fun��es necess�rias e comuns para permitir a 
     * cria��o das telas de cadastro/altera��o
     */
    public function criaTelaCalendario() {
        $this->oTela = new Calendario();
    }

    /**
     * M�todo que executa as fun��es necess�rias e comuns para permitir a 
     * cria��o das telas de relat�rios
     */
    public function criaTelaRelatorio() {
        $this->oTela = new Form("");
        $this->setTituloTela('Relatório de ' . $this->getTitulo());
    }

    /**
     * M�todo que permite definir o t�tulo da tela em situa��es que n�o
     * se trata de telas de cadastro, como no login, por exemplo
     * 
     * @param string String contendo o t�tulo da tela
     */
    public function setTituloTela($sTitulo) {
        $this->getTela()->setTitulo($sTitulo);
    }

    /**
     * M�todo que permite capturar o t�tulo da tela
     * 
     * return string String contendo o t�tulo da tela
     */
    public function getTituloTela() {
        return $this->getTela()->getTitulo();
    }

    /**
     * Define o valor do atributo sTitulo
     * 
     * @param string $sTitulo 
     */
    public function setTitulo($sTitulo) {
        $this->sTitulo = $sTitulo;
    }

    /**
     * Retorna o valor do atributo sTitulo
     * 
     */
    public function getTitulo() {
        return $this->sTitulo;
    }

    /**
     * Define o valor do atributo iRotina
     * 
     * @param string $iRotina 
     */
    public function setRotina($iRotina) {
        $this->iRotinaTela = $iRotina;
    }

    /**
     * Retorna o valor do atributo iRotina
     * 
     */
    public function getRotina() {
        return $this->iRotinaTela;
    }

    /**
     * Método que adiciona os campos criados na tela
     */
    public function addCampos() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getTela()->addCampos($campoAtual);
        }
    }

    /**
     * Método para adicionar modais nos grids
     */
    public function addModais() {
        $aModal = func_get_args();

        foreach ($aModal as $modalAtual) {
            $this->getTela()->addModal($modalAtual);
        }
    }

    public function addModaisDetalhe() {
        $aModal = func_get_args();

        foreach ($aModal as $modalAtual) {
            $this->getOGridDetalhe()->addModal($modalAtual);
        }
    }

    /**
     * Método que adiciona os campos criados na tela de grid detalhe
     */
    public function addCamposDetalhe() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getOGridDetalhe()->addCampos($campoAtual);
        }
    }

    /**
     * Método que adiciona filtros iniciais no grid
     */
    public function addCamposFiltroIni() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getOGridDetalhe()->addCamposIni($campoAtual);
        }
    }

    /**
     * Método que adiciona os campos abaixo dos grids
     */
    public function addCamposGrid() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getTela()->addCamposGrid($campoAtual);
        }
    }

    /**
     * Método que adiciona os campos abaixo dos grids
     */
    public function addCamposGridDetalhe() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getOGridDetalhe()->addCamposGrid($campoAtual);
        }
    }

    /**
     * Método que adiciona totalizadores nos objetos do tipo cubo
     */
    public function addAgregadorCubo() {
        $sClasse = strtolower(get_class($this->getTela()));

        if ($sClasse === 'cubo') {
            $aAgregador = func_get_args();

            foreach ($aAgregador as $campoAtual) {
                $this->getTela()->addAgregadores($campoAtual);
            }
        }
    }

    /**
     * Método que adiciona linhas nos objetos do tipo cubo
     */
    public function addLinhasCubo() {
        $sClasse = strtolower(get_class($this->getTela()));

        if ($sClasse === 'cubo') {
            $aLinhas = func_get_args();

            foreach ($aLinhas as $campoAtual) {
                $this->getTela()->addLinhas($campoAtual);
            }
        }
    }

    /**
     * Método que adiciona colunas nos objetos do tipo cubo
     */
    public function addColunasCubo() {
        $sClasse = strtolower(get_class($this->getTela()));

        if ($sClasse === 'cubo') {
            $aColunas = func_get_args();

            foreach ($aColunas as $campoAtual) {
                $this->getTela()->addColunas($campoAtual);
            }
        }
    }

    /**
     * M�todo que adiciona os campos "chave" em um FormGrid
     * A combina��o dos valores dos campos adicionados na
     * "chave" do grid n�o poder�o ser repetidos
     */
    public function addChave() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->getTela()->addChave($campoAtual);
        }
    }

    /**
     * M�todo que permite adicionar larguras diferentes para os labels de cada
     * coluna gerada na tela
     */
    public function addLarguraLabel() {
        $aLista = func_get_args();
        foreach ($aLista as $iLarguraAtual) {
            $this->getTela()->addLarguraLabel($iLarguraAtual);
        }
    }

    /**
     * M�todo que permite definir o campo da tela que receber� o foco inicial
     */
    public function setCampoFoco($oCampo) {
        $this->getTela()->setCampoFoco($oCampo);
    }

    /**
     * Método que adiciona botões na lista de botões tela (docked)
     * 
     * @param string $sTexto Texto que ser� exibido no bot�o
     * @param string $sAcao A��o que ser� executada no evento onClick do bot�o
     * @param string $sIcone Nome da classe CSS que cont�m o �cone a ser demonstrado no bot�o
     * @param boolean $bHabilitaFrmValido Indica se o bot�o deve ser habilitado apenas quando o formul�rio estiver totalmente validado ou n�o
     */
    private function addBotao($sTexto, $sAcao, $sIcone = null, $bHabilitaFrmValido = false) {
        $oBtn = new Botao($sTexto, $sAcao);
        $oBtn->setHabilitaFrmValidado($bHabilitaFrmValido);

        if ($sIcone <> null) {
            $oBtn->setIcone($sIcone);
        }

        $this->getTela()->addBotoes($oBtn);
        return $oBtn;
    }

    /**
     * M�todo que cria bot�es e retorna o objeto
     * 
     * @param string $sTexto Texto que ser� exibido no bot�o
     * @param string $sAcao A��o que ser� executada no evento onClick do bot�o
     * @param string $sIcone Nome da classe CSS que cont�m o �cone a ser demonstrado no bot�o
     * 
     * @return Object Objeto da classe bot�o
     */
    public function criaBotao($sTexto) {
        $oBtn = new Botao($sTexto);
        return $oBtn;
    }

    /**
     * M�todo que adiciona os bot�es que exigem comportamento diferentes passando a a��o da view
     * devem ser usado nos casos em que os bot�es padr�o n�o se aplicam
     * 
     * @param string $sTexto Texto que ser� utilizado no bot�o
     * @param string $sController Nome da classe a ser instanciada
     * @param string $sMetodo M�todo a ser executado
     * @param string $sIcone Classe CSS do �cone a ser utilizado no bot�o
     */
    public function addBotaoAcaoFree($sTexto, $sController, $sMetodo, $sCampos, $sIcone) {

        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '","' . $sController . '","' . $sMetodo . '",[' . $sCampos . ']);';


        $oBtn = $this->addBotao($sTexto, $sAcao, $sIcone);
        $oBtn->setTamanho('medium');
        $oBtn->setLargura(250);
        return $oBtn;
    }

    /**
     * M�todo que adiciona os botões que exigem comportamento diferentes
     * devem ser usado nos casos em que os bot�es padr�o n�o se aplicam
     * 
     * @param string $sTexto Texto que serão utilizado no botão
     * @param string $sController Nome da classe a ser instanciada
     * @param string $sMetodo Método a ser executado
     * @param string $sIcone Classe CSS do �cone a ser utilizado no bot�o
     */
    public function addBotaoAcao($sTexto, $sController, $sMetodo, $sParametros = null, $sIcone = null, $bHabilitaFrmValido = false) {
        $aParametros = explode(",", $sParametros);
        $sParametros = "";
        foreach ($aParametros as $key => $value) {
            if ($key > 0) {
                $sParametros .= ",";
            }
            if (is_numeric($value) || substr($value, 0, 4) == 'Ext.') {
                $sParametros .= $value;
            } else {
                $sParametros .= "'" . $value . "'";
            }
        }
        if (isset($aValores[0])) {
            $teste = "var valor = Ext.ComponentQuery.query('#" . $this->getTela()->getId() . "')[0];";
        } else {
            $sAcao = 'requestAjax("' . $this->getTela()->getId() . '","' . $sController . '","' . $sMetodo . '",[' . $sParametros . ']);';
        }

        $oBtn = $this->addBotao($sTexto, $sAcao, $sIcone, $bHabilitaFrmValido);
        return $oBtn;
    }

    /**
     * M�todo que adiciona os bot�es padr�o na tela
     * 
     * @param string $aAutoIncremento Array contendo o id dos campos que devem
     *                                ter seu valor incrementado 
     */
    public function addBotoesPadrao($aAutoIncremento) {
        if ($this->getAcaoIncluirTela()) {
            $sMetodo = $this->getRotina() === self::ROTINA_INCLUIR ? self::ACAO_INCLUIR : self::ACAO_ALTERAR;

            /*
             * carregamento das a��es extras a serem executadas ap�s a grava��o
             * as a��es s� ser�o executadas em caso de sucesso na grava��o
             */
            $sAcoesExtra = "";
            foreach ($this->getAcoesExtraGravar() as $sAcaoExtra) {
                $sAcoesExtra .= $sAcaoExtra;
            }

            $sIdCampoFoco = $this->getTela()->getCampoFoco() != null ? $this->getTela()->getCampoFoco()->getId() : "";
            $sAcao = 'requestAjax("' . $this->getTela()->getId() . '","' . $this->getController() . '","' . $sMetodo . '",["' . $this->getTela()->getId() . '","' . $sIdCampoFoco . '","' . implode(',', $aAutoIncremento) . '","' . $sAcoesExtra . '"]);';
            $this->addBotao(Base::BUTTON_WRITE, $sAcao, Base::ICON_SAVE, true);
        }

        if ($this->getAcaoLimparTela()) {
            $this->addBotaoCancela();
        }

        if ($this->getAcaoFecharTela()) {
            $this->addBotaoFechar();
        }
    }

    /**
     * M�todo que adiciona o bot�o para limpar o formul�rio na tela
     */
    public function addBotaoCancela() {
        $sAcaoLimpar = Base::getAcaoLimpa($this->getTela()->getId());
        $sAcaoExtra = $this->getAcaoExtraLimpar();
        if (isset($sAcaoExtra)) {
            $sAcaoLimpar .= $sAcaoExtra;
        }
        $this->addBotao(Base::BUTTON_CANCEL, $sAcaoLimpar, Base::ICON_CANCEL);
    }

    /**
     * M�todo que adiciona o bot�o para fechar a tela
     */
    public function addBotaoFechar() {
        $this->addBotao(Base::BUTTON_CLOSE, Base::getAcaoFechar($this->getTela()->getRenderTo(), $this->getTela()->getId()), Base::ICON_CLOSE);
    }

    /**
     * M�todo que retorna o conte�do do atributo aBotoesExtra
     * 
     * @return array contendo os objetos de bot�o extra a serem adicionados
     */
    public function getBotoesExtra() {
        return $this->aBotoesExtra;
    }

    /**
     * M�todo que define em qual objeto existente a nova tela dever� ser
     * renderizada
     * 
     * @param string $sRenderTo Id do objeto
     */
    public function setRetorno($sRenderTo) {
        $this->getTela()->setSRenderTo($sRenderTo);
    }

    /**
     * M�todo que permite definir a altura da tela
     * 
     * @param integer $iAltura 
     */
    public function setAltura($iAltura) {
        $this->getTela()->setAltura($iAltura);
    }

    /**
     * M�todo que permite definir a largura da tela
     * 
     * @param integer $iLargura 
     */
    public function setLargura($iLargura) {
        $this->getTela()->setLargura($iLargura);
    }

    /**
     * Método que permite definir se a tela poder� ser fechada
     * 
     * @param boolean $bPermiteFechar 
     */
    public function setPermiteFechar($bPermiteFechar) {
        $this->getTela()->setPermiteFechar($bPermiteFechar);
    }

    /**
     * Método que permite definir se a tela poder� ser arrastada
     * 
     * @param boolean $bPermiteArrastar 
     */
    public function setPermiteArrastar($bPermiteArrastar) {
        $this->getTela()->setPermiteArrastar($bPermiteArrastar);
    }

    /**
     * Método que permite definir se a tela poder� ser recolhida
     * 
     * @param boolean $bPermiteRecolher
     */
    public function setPermiteRecolher($bPermiteRecolher) {
        $this->getTela()->setPermiteRecolher($bPermiteRecolher);
    }

    /**
     * M�todo que permite definir se a tela poder� ser redimensionada
     * 
     * @param boolean $bPermiteRedimensionar 
     */
    public function setPermiteRedimensionar($bPermiteRedimensionar) {
        $this->getTela()->setPermiteRedimensionar($bPermiteRedimensionar);
    }

    /**
     * M�todo que permite definir se o grid deve exibir ou n�o os totalizadores
     * 
     * @param boolean $bExibeTotalizador
     */
    public function setExibeTotalizador($bExibeTotalizador) {
        $this->getTela()->setExibeTotalizador($bExibeTotalizador);
    }

    /**
     * Método que permite definir se a tela dever� ser centralizada na tela
     * 
     * @param boolean $bCentraliza
     */
    public function setCentraliza($bCentraliza) {
        $this->getTela()->setCentraliza($bCentraliza);
    }

    function getUsaFiltro() {
        return $this->usaFiltro;
    }

    function setUsaFiltro($usaFiltro) {
        $this->usaFiltro = $usaFiltro;
    }

    /**
     * Método que adiciona os botões padrão na tela de consulta
     */
    public function addBotoesConsulta($sRenderTo) {
        //retorna a classe
        $sClasse = $this->getController();
        $sMetodoInc = View::ACAO_MOSTRA_TELA_INCLUIR;
        $sMetodoAlt = View::ACAO_MOSTRA_TELA_ALTERAR;
        $sMetodoExc = View::ACAO_EXCLUIR;
        $sMetodoViz = View::ACAO_MOSTRA_TELA_VISUALIZA;
        $sTab = $sRenderTo . 'control';
        $sIdGrid = $this->getTela()->getSId() . 'consulta';
        //adição dos botões no grid
        if ($this->getUsaAcaoIncluir()) {
            $sAcao = ' $("#' . $this->getTela()->getSId() . 'consulta").hide();requestAjax("","' . $sClasse . '","' . $sMetodoInc . '","' . $sTab . ',' . $this->getTela()->getSId() . ',' . $sRenderTo . '");';
            $oBtnAdd = new Botao('', Botao::TIPO_ADICIONAR, $sAcao);
            $this->getTela()->addBotoes($oBtnAdd);
        }
        if ($this->getUsaAcaoAlterar()) {
            $sAcao = ' $("#' . $this->getTela()->getSId() . 'consulta tbody .selected").each(function(){'
                    . 'var chave = $(this).find(".chave").html();'
                    . ' $("#' . $this->getTela()->getSId() . 'consulta").hide();requestAjax("","' . $sClasse . '","' . $sMetodoAlt . '",chave +",' . $sTab . ',' . $this->getTela()->getSId() . ',' . $sRenderTo . '");'
                    . '});';
            $oBtnEdit = new Botao('', Botao::TIPO_ALTERAR, $sAcao);
            $oBtnEdit->setBDesativado(true);
            $this->getTela()->addBotoes($oBtnEdit);
        }
        if ($this->getUsaAcaoExcluir()) {
            $sAcao = ' $("#' . $this->getTela()->getSId() . 'consulta tbody .selected").each(function(){'
                    . 'var chave = $(this).find(".chave").html();'
                    . 'requestAjax("","' . $sClasse . '","' . $sMetodoExc . '",chave +",' . $this->getTela()->getSId() . ',' . $sIdGrid . ',' . $sRenderTo . '");'
                    . '});';
            $oBtnDelete = new Botao('', Botao::TIPO_REMOVER, $sAcao);
            $oBtnDelete->setBDesativado(true);
            $this->getTela()->addBotoes($oBtnDelete);
        }
        if ($this->getUsaAcaoVisualizar()) {
            //carrega tela de vizualização
            $sAcao = ' $("#' . $this->getTela()->getSId() . 'consulta tbody .selected").each(function(){'
                    . 'var chave = $(this).find(".chave").html();'
                    . ' $("#' . $this->getTela()->getSId() . 'consulta").hide();requestAjax("","' . $sClasse . '","' . $sMetodoViz . '",chave +",' . $sTab . ',' . $this->getTela()->getSId() . '");'
                    . '});';
            $oBtnViz = new Botao('', Botao::TIPO_VIZUALIZAR, $sAcao);
            $oBtnViz->setBDesativado(true);
            $this->getTela()->addBotoes($oBtnViz);
        }


        if ($this->getUsaDropdown()) {
            $sTelaId = $this->getTela()->getSId();
            $this->getTela()->addDropdownConsulta($this->aDropdown);
        }
        //tirado atualizar 
        /* if($this->getUsaAtualizar()){
          $sAcao = 'requestAjax("","'.$sClasse.'","getdadosConsulta","'.$this->getTela()->getSId().'");';
          $oAtualizar = new Botao('',  Botao::TIPO_ATUALIZAR,$sAcao);
          $this->getTela()->addBotoes($oAtualizar);
          } */
    }

    /**
     * Método responsavel por adicionar Filtros na renderiza
     */
    public function addFiltroConsulta($sRenderTo) {
        $sTab = $sRenderTo . 'control';
        if ($this->getUsaFiltro()) {
            $sAcao = '$("#' . $this->getTela()->getSId() . '-filtros").toggle();';
            $oBtnFiltro = new Botao('', Botao::TIPO_FILTRO, $sAcao);
            $this->getTela()->addBotoes($oBtnFiltro);
            $this->getTela()->addFiltroConsulta($this->aFiltro);
        }
    }

    public function getAcaoAlterarDuploClique() {
        $sClasse = $this->getController();
        $iCodigoRotina = $this->getCodigoRotina();
        $sMetodoAlterar = View::ACAO_MOSTRA_TELA;
        if (isset($iCodigoRotina)) {
            $sClasse = $iCodigoRotina;
            $sMetodoAlterar = PersistenciaAcao::ACAO_PADRAO_ALTERAR;
        }
        return "requestAjax('','" . $sClasse . "','" . $sMetodoAlterar . "',['" . $this->getTela()->getRenderTo() . "',record.getData(true).chave]);";
    }

    /**
     * M�todo para adicionar evento clique
     */
    public function getAcaoClique($sClasse, $metodo) {
        return "requestAjax('','" . $sClasse . "','" . $metodo . "',['" . $this->getTela()->getRenderTo() . "',record.getData(true).chave]);";
    }

    /**
     * M�todo para adicionar evento clique
     */
    public function getAcaoCliqueail($sGrid = null) {

        return "var grids = Ext.ComponentQuery.query('#" . $this->getTela()->getId() . "')[0];"
                . "var linha = grids.getSelectionModel().getSelection();"
                . "linhaP = linha[0].getData(true).chave;"
                . "console.log(linhaP);"
                . "var gridReload = Ext.ComponentQuery.query('panel[title=" . $sGrid . "]');"
                . "console.log(gridReload);"
                . "Ext.Array.each(gridReload, function(grid) {grid.getStore().reload({params:{param:linhaP}});});";
    }

    /**
     * M�todo que adiciona o bot�o de sele��o na tela de consulta, a a��o de 
     * sele��o tamb�m � adicionada ao duplo clique sobre a linha da consulta
     * 
     * @param string $sCampoRetornoValor Indica o campo que deve retornar seu valor em uma consulta de busca
     * @param string $sCampoForm Indica o campo do formul�rio que receber� o valor retornado
     */
    public function addBotaoSelect($sCampoRetornoValor, $sCampoForm) {
        $sFuncaoSelect = "var telaConsulta = Ext.ComponentQuery.query('#" . $this->getTela()->getId() . "')[0];"
                . "var valorRetorno = telaConsulta.getSelectionModel().getSelection()[0].getData()." . str_replace('.', '_', $sCampoRetornoValor) . ";"
                . "Ext.ComponentQuery.query('#" . $sCampoForm . "')[0].setValue(valorRetorno);"
                . $this->executaEvento($sCampoForm, Base::EVENTO_EXIT)
                . "telaConsulta.close();";

        $sAcaoSelect = $this->verificaSelecaoGrid($this->getTela()->getId(), $sFuncaoSelect);

        //adiciona o bot�o na consulta
        $oBtnSelect = $this->criaBotao(Base::BUTTON_SELECT, $sAcaoSelect, Base::ICON_SELECT);
        $this->getTela()->addBotoes($oBtnSelect);

        //adiciona a a��o de sele��o nas linhas da grid
        $this->getTela()->addListener(Base::EVENTO_ITEM_DUPLO_CLIQUE, $sFuncaoSelect);
    }

    /**
     * M�todo que adiciona os bot�es que exigem comportamento diferentes
     * devem ser usado nos casos em que os bot�es padr�o n�o se aplicam
     * 
     * @param string $sTexto Texto que ser� utilizado no bot�o
     * @param string $sClasse Nome da classe a ser instanciada
     * @param string $sAcao M�todo a ser executado
     * @param string $sIcone Classe CSS do �cone a ser utilizado no bot�o
     * @param boolean $bConfirmacao Indica se deve adicionar confirma��o de opera��o ao pressionar o bot�o
     * @param string $sMsgConfirmacao Mensagem a ser apresentada na tela de confirma��o
     * 
     * @return botao Retorna o objeto de bot�o criado
     */
    public function addBotaoConsulta($sTexto, $sClasse, $sMetodo, $sIcone = null, $bConfirmacao = false, $sConfirmacao = null, $bMostraTela = false, $aParamExtras = null, $bVerificaSel = true, $bReload = false, $bAtualiza = false, $bVoltar = false, $sRotProp = null) {
        $sParametros = "[row[0].getData(true).chave]";
        $sMetodoNumerico = '';
        if (is_numeric($sMetodo)) {
            $oModelAcao = Fabrica::FabricarModel('Acao');
            $oPersAcao = Fabrica::FabricarPersistencia('Acao');
            $oPersAcao->setModel($oModelAcao);

            $oModelAcao->setCodigo($sMetodo);
            $oModelAcao = $oPersAcao->consultar();

            $sMetodoNumerico = $oModelAcao->getMetodo();
        }

        if ($sMetodoNumerico === self::ACAO_MOSTRA_TELA or
                $sMetodo === self::ACAO_MOSTRA_TELA or
                $bMostraTela) {
            $sTabAtiva = "var tabAtiva = " . $this->getTabAtiva() . ";";
            if (isset($aParamExtras)) {
                $sCampos = "";
                $sValores = "";
                foreach ($aParamExtras as $i => $sParam) {
                    if ($i > 0) {
                        $sCampos .= ",";
                        $sValores .= ",";
                    }
                    $sCampos .= $sParam;
                    $sValores .= "row[0].getData(true)." . $sParam;
                }
                $sParametros = "[" . $sParametros . ",['" . $sCampos . "'],[" . $sValores . "]]";
            }
            $sParametros = "[tabAtiva, null, " . $sParametros . "]";
        }

        $sAcao = $sTabAtiva
                . "var telaConsulta = Ext.ComponentQuery.query('#" . $this->getTela()->getId() . "')[0];"
                . "var row = telaConsulta.getSelectionModel().getSelection();"
                . "requestAjax('','" . $sClasse . "','" . $sMetodo . "'," . $sParametros . ");";

        //Verifica se deve adicionar confirma��o ao clicar no bot�o
        if ($bConfirmacao) {
            if ($sConfirmacao === null) {
                $sConfirmacao = "Deseja realmente executar a opera��o?";
            }
            $sAcao = $this->mensagemPergunta($sConfirmacao, $sAcao);
        }
        //verifica se necessita dar um reload
        //verifica se somente da um reload na store
        if ($bReload) {
            $sAcao .= "layout.getActiveItem().getStore().reload();";
        }
        if (isset($sRotProp)) {
            $sAcao .= $sRotProp;
        }
        //Se bVerificaSel = false n�o verifica a sele��o no grid
        if ($bVerificaSel) {
            $sAcao = $this->verificaSelecaoGrid($this->getTela()->getId(), $sAcao);
        }
        if ($bVoltar) {
            $sAcao = "var oRender = Ext.ComponentQuery.query('#" . $this->getSRenderPara() . "')[0];"
                    . "if(oRender){var layout = oRender.getLayout();"
                    . "if(layout.type === 'card' && layout.getLayoutItems().length > 1){"
                    . "var bReloadPrevious = true;"
                    . " if(layout.getActiveItem() instanceof Ext.form.Panel){bReloadPrevious = layout.getActiveItem().reloadPreviousOnClose;}"
                    . "layout.setActiveItem(oRender.getLayout().getPrev());"
                    . "oRender.remove(layout.getNext());"
                    . "if(layout.getActiveItem() instanceof Ext.grid.Panel && bReloadPrevious){layout.getActiveItem().getStore().reload();}"
                    . "} else{oRender.close();}"
                    . "} else{alert('Erro ao carregar objeto: Base->getAcaoFechar()');}";
        }

        //verifica se a funções somente para atualizar
        if ($bAtualiza) {
            $sAcao = "";
            $sAcao = $this->recarregaConsulta($this->oTela->getId());
        }
        //cria e adiciona o bot�o na consulta
        $oBtn = $this->criaBotao($sTexto, $sAcao, $sIcone);
        $this->addBotoesExtra($oBtn);

        return $oBtn;
    }

    public function addBotaoConsultaGrupo($oBotaoGrupo) {
        $aFilhos = $oBotaoGrupo->getItens();
        $oBotaoPadrao = $aFilhos[0];
        $sTabAtiva = '';
        $sMetodo = $oBotaoPadrao->getMetodo();
        $sMetodoNumerico = '';
        if (is_numeric($sMetodo)) {
            $oModelAcao = Fabrica::FabricarModel('Acao');
            $oPersAcao = Fabrica::FabricarPersistencia('Acao');
            $oPersAcao->setModel($oModelAcao);

            $oModelAcao->setCodigo($sMetodo);
            $oModelAcao = $oPersAcao->consultar();

            $sMetodoNumerico = $oModelAcao->getMetodo();
        }

        if ($sMetodoNumerico === self::ACAO_MOSTRA_TELA or
                $oBotaoPadrao->getMetodo() === self::ACAO_MOSTRA_TELA or
                $oBotaoPadrao->getMostraTela()) {
            $sTabAtiva = "var tabAtiva = " . $this->getTabAtiva() . ";";
            $sParametros = "[tabAtiva, null, [row[0].getData(true).chave]]";
        } else {
            $sParametros = "[row[0].getData(true).chave]";
        }

        //cria e adiciona o bot�o na consulta
        $oBtn = $this->criaBotaoSplit($oBotaoGrupo, $sTabAtiva, $sParametros);
        $this->addBotoesExtra($oBtn);

        return $oBtn;
    }

    private function retornaAcao($sTabAtiva, $sParametros, $oBotao) {
        $sAcao = $sTabAtiva
                . "var telaConsulta = Ext.ComponentQuery.query('#" . $this->getTela()->getId() . "')[0];"
                . "var row = telaConsulta.getSelectionModel().getSelection();"
                . "requestAjax('','" . $oBotao->getClasse() . "','" . $oBotao->getMetodo() . "'," . $sParametros . ");";

        //Verifica se deve adicionar confirma��o ao clicar no bot�o
        if ($oBotao->getConfirmacao()) {
            if ($oBotao->getTextoConfirmacao() === null) {
                "Deseja realmente executar a opera��o?";
            }
            $sAcao = $this->mensagemPergunta($oBotao->getTextoConfirmacao(), $sAcao);
        }

        $sAcao = $this->verificaSelecaoGrid($this->getTela()->getId(), $sAcao);
        return $sAcao;
    }

    public function criaBotaoSplit($oBotaoGrupo, $sTabAtiva, $sParametros) {
        $aFilhos = $oBotaoGrupo->getItens();
        $oBotaoPadrao = $aFilhos[0];
        $sAcao = $this->retornaAcao($sTabAtiva, $sParametros, $oBotaoPadrao);

        $oBtn = new Botao($oBotaoGrupo->getTexto(), $sAcao);
        $oBtn->setSplit(true);
        foreach ($aFilhos as $oBotaoItem) {
            $sAcao = $this->retornaAcao($sTabAtiva, $sParametros, $oBotaoItem);
            $oBtn->addItem($oBotaoItem->getTexto(), $sAcao, $oBotaoItem->getIcone());
        }
        $oBtn->setStyle("margin-left: 3px;");

        if ($oBotaoGrupo->getIcone() <> null) {
            $oBtn->setIcone($oBotaoGrupo->getIcone());
        }

        return $oBtn;
    }

    /**
     * M�todo que retorna a a��o para envio dos dados selecionados de uma
     * consulta para a rotina e acao passadas por par�metro
     * 
     * @param string $sRotina Nome (c�digo ou nome) da classe a ser instanciada
     * @param string $sAcao M�todo (c�digo ou nome) a ser executado
     * @param string $sTituloAba T�tulo da aba, caso informado abre o conte�do em uma nova aba
     * 
     * @return string String da a��o a ser executada
     */
    function getAcaoBotaoEnviaConsulta($sRotina, $sAcao, $sTituloAba = null) {
        $sAba = "";
        if ($sTituloAba != null) {
            $sAba = "var aba = tabPanel.items.findBy(function(rec){ return rec.title === '" . $sTituloAba . "';});"
                    . "if(!aba){"
                    . "aba = tabPanel.add({"
                    . "iconCls: '" . Base::ICON_TABS . "',"
                    . "title: '" . $sTituloAba . "',"
                    . "layout: '" . Base::$LAYOUT[Base::LAYOUT_CARD] . "',"
                    . "closable: true,"
                    . "id: idTab"
                    . "});"
                    . "}"
                    . "tabPanel.setActiveTab(aba.id);";
        }

        $sAcao = "var tabPanel = Ext.ComponentQuery.query('#" . Config::TABPANEL . "')[0];"
                . "var grid = this.up('grid');"
                . "var rows = grid.getSelectionModel().getSelection();"
                . "var chave = new Array();"
                . "Ext.Array.each(rows, function(row) {"
                . "chave.push(row.getData(true).chave);"
                . "});"
                . "var idTab = " . ($sAba == "" ? "tabPanel.getActiveTab().id" : "Ext.id()") . ";"
                . $sAba
                . "requestAjax('','" . $sRotina . "','" . $sAcao . "',[idTab,null,chave,grid.id]);";
        return $sAcao;
    }

    /**
     * M�todo que permite incluir bot�es extras na barra de a��es dos
     * grids e formul�rios
     */
    public function addBotoesExtra() {
        $aBotoes = func_get_args();

        foreach ($aBotoes as $oBtn) {
            $this->aBotoesExtra[] = $oBtn;
        }
    }

    /**
     * M�todo que permite adicionar controles espec�ficos a bot�es adicionados
     * na consulta para habilit�-los e desabilit�-los conforme o(s) item(ns)
     * selecionados
     * 
     * Se o valor do campo for igual a algum existente no array o bot�o ser�
     * desabilitado
     * 
     * @param Botao Botao a ser controlado pela condi��o
     * @param CampoConsulta Coluna da consulta a ter o valor comparado
     * @param array Valores que far�o o bot�o ser desabilitado
     */
    public function addControleBotaoSelecao($oBtn, $oCampo, $aValoresDesabilita) {
        $this->getTela()->addControleBotaoSelecao($oBtn, $oCampo, $aValoresDesabilita);
    }

    /**
     * M�todo que adiciona os dados nas consultas
     * 
     * @param String $sDados String no formato json contendo os dados a serem adicionados na consulta
     */
    public function addDadosConsulta($sDados) {
        $this->getTela()->addDados($sDados);
    }

    /**
     * M�todo que permite definir o agrupamento da consulta
     * 
     * @param Object $oCampo Campo pelo qual a consulta ser� agrupada
     */
    public function setAgrupamento($oCampo) {
        $this->getTela()->setAgrupamento($oCampo->getNome());
    }

    /**
     * M�todo que permite definir a situa��o inicial dos agrupamentos 
     * da consulta Aberto ou Fechado 
     * 
     * @param boolean bIniciaFechada 
     */
    public function setIniciaFechada($bIniciaFechada) {
        $this->getTela()->setIniciaFechada($bIniciaFechada);
    }

    /**
     * M�todo que permite definir formata��es condicionais para as linhas
     * das consultas conforme os valores de uma ou mais colunas do grid
     * 
     * @param string $sFormatacao Formata��o a ser aplicada caso o resultado da compara��o seja verdadeiro
     * @param Object $xValorComparacaoA Objeto do tipo campo de consulta ou valor a ser utilizado � esquerda da compara��o condicional
     * @param Object $xValorComparacaoB Objeto do tipo campo de consulta ou valor a ser utilizado � direita da compara��o condicional
     * @param Object $xComparacao Tipo de compara��o a ser realizado
     */
    public function addFormatacaoCondicional($sFormatacao, $xValorComparacaoA, $xValorComparacaoB, $xComparacao = Base::IGUAL) {
        $this->getTela()->addFormatacaoCondicional($sFormatacao, $xValorComparacaoA, $xValorComparacaoB, $xComparacao);
    }

    /**
     * M�todo que permite adicionar a��es extras a serem executadas ap�s a
     * opera��o de inclus�o em caso de sucesso
     */
    public function addAcoesExtraGravar() {
        $aAcoes = func_get_args();

        foreach ($aAcoes as $sAcao) {
            $this->aAcoesExtraGravar[] = $sAcao;
        }
    }

    /**
     * M�todo que retorna a lista de a��es extras a serem executadas ap�s a
     * opera��o de inclus�o em caso de sucesso
     */
    public function getAcoesExtraGravar() {
        return $this->aAcoesExtraGravar;
    }

    /**
     * M�todo que retorna a data atual no formato dia/m�s/ano
     * 
     * @param integer $iDias N�mero de dias a ser acrescido na data de retorno
     * 
     * @return string String contendo a data desejada no formato indicado acima
     */
    public function getData($iDias = 0) {
        return date('d/m/Y', strtotime("+" . $iDias . " days"));
    }

    /**
     * Cria a fun��o que ser� respons�vel por verificar se alguma linha do grid
     * foi selecionada, usada nas a��es de exclus�o e altera��o
     * 
     * @param string $sIdGrid Id do grid que ter� a linha removida
     * @param string $sFuncao Fun��o a ser executada caso exista uma linha selecionada
     * 
     * @return string String contendo a a��o de verifica��o de sele��o de linhas do grid
     */
    public function verificaSelecaoGrid($sIdGrid, $sFuncao) {
        $sAcao = "var telaConsulta = Ext.ComponentQuery.query('#" . $sIdGrid . "')[0];"
                . "if(telaConsulta.getSelectionModel().hasSelection()){"
                . $sFuncao
                . "} else{"
                . $this->mensagemAlerta('Selecione um ou mais registros para executar a a��o')
                . "}";

        return $sAcao;
    }

    /**
     * Func�o que remove a m�scara do objeto desejado a partir do ID
     * passado como par�metro
     * 
     * @param string $sId Id do objeto que ter� a m�scara removida
     * 
     * @return string String contendo a a��o de remo��o da m�scara do objeto desejado
     */
    public function removeMascara($sId) {
        return "Ext.ComponentQuery.query('#" . $sId . "')[0].el.unmask();";
    }

    /**
     * Func�o que adiciona a m�scara no objeto desejado a partir do ID
     * passado como par�metro
     * 
     * @param string $sId Id do objeto que ter� a m�scara adicionada
     * @param string $sTexto texto a ser demonstrado durante a exibi��o da m�scara
     * 
     * @return string String contendo a a��o de adi��o da m�scara do objeto desejado
     */
    public function adicionaMascara($sId, $sTexto = "") {
        return "Ext.ComponentQuery.query('#" . $sId . "')[0].el.mask('" . $sTexto . "');";
    }

    /**
     * M�todo que realiza o recarregamento dos dados das consultas
     * Caso o identificador do objeto da consulta n�o seja indicado o sistema
     * ir� recarregar todos os objetos Grid presentes na aba ativa
     * 
     * @param string $sId Id do objeto a ter os dados recarregados
     * 
     * @return string String contendo a a��o de reload da consulta desejada
     */
    public function recarregaConsulta($sId = "") {
        $sAtualizaTodos = "var tabAtiva = " . $this->getTabAtiva() . ";"
                . "var grids = Ext.ComponentQuery.query('#'+tabAtiva+' > gridpanel');";

        $sAtualizaById = "var grids = Ext.ComponentQuery.query('#" . $sId . "');";

        $sAcaoReload = ($sId == "" ? $sAtualizaTodos : $sAtualizaById)
                . "Ext.Array.each(grids, function(grid) {"
                . "grid.getStore().reload();"
                . "});";

        return $sAcaoReload;
    }

    /**
     * Func�o que executa a a��o de fechamento do bjeto desejado, cuja ID
     * � passado por par�metro
     * 
     * @param string $sId Id do objeto que ser� fechado
     * 
     * @return string String contendo a a��o de fechamento do objeto desejado
     */
    public function fechaTela($sId) {
        $sAcaoClose = "Ext.ComponentQuery.query('#" . $sId . "')[0].close();";

        return $sAcaoClose;
    }

    /**
     * Retorna a string da fun��o que realiza a troca de campos na tela,
     * desabilitando e habilitando conforme necess�rio.
     * 
     * @param $aItems Array contendo no �ndice o valor, na primeira posi��o um array com os campos 
     * a serem habilitados e na segunda posi��o os campos a serem desabilitados
     * 
     * @return string
     * 
     */
    public function trocaCampos($aItems) {
        $sFuncao = "switch(this.value) {";
        foreach ($aItems as $key => $aValores) {
            $sFuncao .= "case " . $key . ":";

            //percorre os campos que ser�o visualizados
            foreach ($aValores[0] as $oCampoVisualiza) {
                $sFuncao .= "Ext.ComponentQuery.query('#" . $oCampoVisualiza->getId() . "')[0].setVisible(true);";
            }

            //percorre os campos que ser�o ocultados
            foreach ($aValores[1] as $oCampoOculta) {
                $sFuncao .= "Ext.ComponentQuery.query('#" . $oCampoOculta->getId() . "')[0].setVisible(false);";
            }

            $sFuncao .= "break;";
        }
        $sFuncao .= "}";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza a troca do label dos
     * campos na tela em tempo de execu��o conforme o valor de um determinado
     * campo. Normalmente usado nos eventos onchange
     * 
     * @param $aItems Array contendo no �ndice o valor, na primeira posi��o um array com os campos e na
     * segunda posi��o um array com os labels correspondentes 
     * 
     * @return string
     * 
     */
    public function trocaLabelCampos($aItems) {
        $sFuncao = "switch(this.value) {";
        foreach ($aItems as $key => $aValores) {
            $sFuncao .= "case " . $key . ":";

            foreach ($aValores[0] as $i => $oCampoVisualiza) {
                $sFuncao .= "Ext.ComponentQuery.query('#" . $oCampoVisualiza->getId() . "')[0].setFieldLabel('" . $aValores[1][$i] . "');";
            }

            $sFuncao .= "break;";
        }
        $sFuncao .= "}";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza a troca do tipo da valida��o
     * de um campo na tela
     * 
     * @param $oCampoAcao Objeto do tipo campo em que ser� executada a a��o
     * @param $aItems Array de items do campo select/radio
     * 
     * @return string
     * 
     */
    public function trocaValidacaoCampo($oCampoAcao, $aItems) {
        $sFuncao = "switch(this.getValue()) {";
        foreach ($aItems as $key => $aValores) {
            $sFuncao .= "case " . $key . ":"
                    . "var campo = Ext.ComponentQuery.query('#" . $oCampoAcao->getId() . "')[0];"
                    . "campo.vtype = '" . $aValores[1][0] . "';"
                    . "campo.setMask('" . $aValores[1][1] . "');"
                    . "if(!campo.validate()){"
                    . "campo.setValue();"
                    . "}"
                    . "break;";
        }
        $sFuncao .= "}";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza a c�pia do valor do campo atual
     * para o campo desejado
     * 
     * @param $oCampo Campo que receber� o valor
     * 
     * @return string
     * 
     */
    public function copiaValorParaCampo($oCampo) {
        $sFuncao = "var field = Ext.ComponentQuery.query('#" . $oCampo->getId() . "')[0];"
                . "if(field){"
                . "if(this.xtype == 'combo'){"
                . "var record = this.getStore().findRecord(this.valueField, this.getValue());"
                . "if(record != null){"
                . "field.setValue(record.get('" . Campo::SELECT_CONTEUDO . "'));"
                . "}"
                . "} else{"
                . "field.setValue(this.getValue());"
                . "}"
                . "}";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza o preenchimento de um campo com 
     * o valor desejado
     * 
     * @param $sIdCampo Id do campo que receber� o valor
     * @param $sValor Valor a ser carregado
     * 
     * @return string
     * 
     */
    public function setValorCampo($sIdCampo, $sValor = "") {
        $sFuncao = "var field = Ext.ComponentQuery.query('#" . $sIdCampo . "')[0];"
                . "if(field){"
                . "if(field.xtype == 'combo' && !field.hideTrigger){"
                . "var record = field.getStore().findRecord(field.valueField,'" . $sValor . "');"
                . "if(record != null){"
                . "field.setValue(record.get('" . Campo::SELECT_VALOR . "'));"
                . "}"
                . "} else{"
                . "field.setValue('" . $sValor . "');"
                . "}"
                . "}";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza a altera��o do valor original 
     * de um campo
     * 
     * @param $sIdCampo Id do campo que ter� o valor origonal alterado
     * @param $sValor Valor a ser carregado
     * 
     * @return string
     * 
     */
    public function setValorOriginalCampo($sIdCampo, $sValor = "") {
        $sFuncao = "var field = Ext.ComponentQuery.query('#" . $sIdCampo . "')[0];"
                . "if(field){"
                . "field.originalValue = '" . $sValor . "';"
                . "}";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza a captura do valor do campo
     * passado por par�metro no lado do cliente (ExtJS)
     * Utilizado quando for necess�rio passar o valor de um campo por par�metro
     * na chamada dos m�todos
     * 
     * @param $oCampo Object Objeto do tipo campo a ter o valor capturado
     * 
     * @return string Contendo a fun��o a ser executada
     * 
     */
    public function getValorCampo($oCampo) {
        $sFuncao = "Ext.ComponentQuery.query('#" . $oCampo->getId() . "')[0].getValue()";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza a sele��o (focus) de um campo
     * 
     * @param $sIdCampo Id do campo que receber� o foco
     * 
     * @return string
     * 
     */
    static public function campoFocus($sIdCampo) {
        $sFuncao = $sIdCampo != "" ? "Ext.ComponentQuery.query('#" . $sIdCampo . "')[0].focus(true,true);" : "";

        return $sFuncao;
    }

    /**
     * Retorna a string da fun��o que realiza o incremento do valor dos campos
     * passados na string
     * 
     * @param $sAutoIncremento String contendo o id dos campos a terem o valor
     *                         devidamente separados por v�rgula
     * 
     * @return string Contendo a fun��o a ser executada
     * 
     */
    public function getAutoIncremento($sAutoIncremento, $iAutoInc) {
        $sAuto = "$('#" . $sAutoIncremento . "').val('" . $iAutoInc . "');";
        return $sAuto;
    }

    /**
     * M�todo que monta a string para a chamada de eventos manualmente
     * 
     * @param string $sId Id do objeto a ter o evento executado
     * @param string $sEvento Tipo do evento a ser executado (exit, blur...)
     */
    public function executaEvento($sId, $sEvento) {
        $sFuncao = "var field = Ext.ComponentQuery.query('#" . $sId . "')[0];"
                . "if(field){"
                . "field.fireEvent('" . $sEvento . "');"
                . "}";
        return $sFuncao;
    }

    /**
     * M�todo que monta a string de recarregamento dos valores de um campo
     * combobox a partir do valor informado em outro campo
     * 
     * @param Object $oComboBox Objeto do tipo campo (ComoboBox)
     * @param Object $oCampoFiltro Objeto do tipo campo
     * 
     * @return string String da fun��o a ser renderizada 
     */
    public function recarregaComboBox($oComboBox, $oCampoFiltro) {
        $sFuncao = "var combobox = Ext.ComponentQuery.query('#" . $oComboBox->getId() . "')[0];"
                . "var store = combobox.getStore();"
                . "combobox.setValue();"
                . "store.removeAll();"
                . "if(Ext.ComponentQuery.query('#" . $oCampoFiltro->getId() . "')[0].getValue() != null && "
                . "Ext.ComponentQuery.query('#" . $oCampoFiltro->getId() . "')[0].getValue() != ''){"
                . "store.load({"
                . "params: {"
                . "campoFiltro: '" . $oCampoFiltro->getNome() . "',"
                . "valorFiltro: Ext.ComponentQuery.query('#" . $oCampoFiltro->getId() . "')[0].getValue()"
                . "}"
                . "});"
                . "}";

        return $sFuncao;
    }

    /**
     * M�todo que cria bot�es e retorna o objeto
     * 
     * @param object $oGrid Objeto grid a ter os registros adicionados
     * @param object $oValorTotal Objeto que cont�m o valor total da opera��o
     * @param object $oNumeroParcelas Objeto que cont�m a quantidade de parcelas
     * @param object $oPrimeiraParcela Objeto que cont�m a data de vencimento da primeira parcela
     * @param object $oDiasEntreParcelas Objeto que cont�m o n�mero de dias entre o vencimento das parcelas
     * @param string $sTexto Texto que ser� exibido no bot�o
     * @param string $sIcone Nome da classe CSS que cont�m o �cone a ser demonstrado no bot�o
     * 
     * @return Object Objeto da classe bot�o
     */
    public function getBotaoParcelas($oGrid, $oValorTotal, $oNumeroParcelas, $oPrimeiraParcela, $oDiasEntreParcelas, $oVenc, $sTexto = 'Gerar Parcelas', $sIcone = Base::ICON_GERAR) {
        $sAcao = $this->getAcaoParcelasGrid($oGrid, $oValorTotal, $oNumeroParcelas, $oPrimeiraParcela, $oDiasEntreParcelas, $oVenc);

        $oBtn = new Botao($sTexto, $sAcao);
        $oBtn->setStyle("margin-left: 3px;");
        $oBtn->setIcone($sIcone);

        //adiciona o listener para permitir o controle do bot�o
        $sEventoBtn = "var bCtr = false;"
                . "if(Ext.ComponentQuery.query('#" . $oValorTotal->getId() . "')[0].getValue() > 0 && "
                . "Ext.ComponentQuery.query('#" . $oNumeroParcelas->getId() . "')[0].getValue() > 0 && "
                . "Ext.ComponentQuery.query('#" . $oDiasEntreParcelas->getId() . "')[0].getValue() >= 0 && "
                . "(Ext.ComponentQuery.query('#" . $oPrimeiraParcela->getId() . "')[0].getValue() != '' && "
                . "Ext.ComponentQuery.query('#" . $oPrimeiraParcela->getId() . "')[0].isValid() "
                . ")"
                . "){"
                . "Ext.ComponentQuery.query('#" . $oPrimeiraParcela->getId() . "')[0].clearInvalid();"
                . "bCtr = true;"
                . "}"
                . "bCtr ? this.enable() : this.disable();";
        $oBtn->addListener(Base::EVENTO_MONTAR, $sEventoBtn);

        //adiciona o listener nos campos que controlam o bot�o
        $sEventoCampos = "Ext.ComponentQuery.query('#" . $oBtn->getId() . "')[0].fireEvent('" . Base::EVENTO_MONTAR . "');";
        $oValorTotal->addListener(Base::EVENTO_CHANGE, $sEventoCampos);
        $oNumeroParcelas->addListener(Base::EVENTO_CHANGE, $sEventoCampos);
        $oPrimeiraParcela->addListener(Base::EVENTO_CHANGE, $sEventoCampos);
        $oDiasEntreParcelas->addListener(Base::EVENTO_CHANGE, $sEventoCampos);

        return $oBtn;
    }

    /**
     * M�todo que monta a string da a��o que permite a inclus�o de registros
     * de parcelamentos de maneira autom�tica em um grid
     * 
     * @param object $oGrid Objeto grid a ter os registros adicionados
     * @param object $oValorTotal Objeto que cont�m o valor total da opera��o
     * @param object $oNumeroParcelas Objeto que cont�m a quantidade de parcelas
     * @param object $oPrimeiraParcela Objeto que cont�m a data de vencimento da primeira parcela
     * @param object $oDias Objeto que cont�m o n�mero de dias entre o vencimento das parcelas ou o dia fixo do vencimento
     * @param object $oVenc Objeto que cont�m o tipo do vencimento, se ser� intervalo ou dia fixo
     * 
     * @return string String contendo a a��o a ser executada
     */
    private function getAcaoParcelasGrid($oGrid, $oValorTotal, $oNumeroParcelas, $oPrimeiraParcela, $oDias, $oVenc) {
        $sAcao = "var oValorTotal = Ext.ComponentQuery.query('#" . $oValorTotal->getId() . "')[0];"
                . "var valorTotal  = oValorTotal.getValue();"
                . "var numParcelas = Ext.ComponentQuery.query('#" . $oNumeroParcelas->getId() . "')[0].getValue();"
                . "var dataParcela = Ext.ComponentQuery.query('#" . $oPrimeiraParcela->getId() . "')[0].getValue();"
                . "var dataInicial = dataParcela;"
                . "var tipoVenc = Ext.ComponentQuery.query('#" . $oVenc->getId() . "')[0].getValue();"
                . "var dias = Ext.ComponentQuery.query('#" . $oDias->getId() . "')[0].getValue();"
                . "var store = Ext.ComponentQuery.query('#" . $oGrid->getId() . "')[0].getStore();"
                . "if(store){"
                . "store.removeAll();"
                . "var valorParcela = (valorTotal/numParcelas).toFixed(oValorTotal.decimalPrecision);"
                . "var somaParcelas = 0;"
                . "for(var i=1; i<=numParcelas; i++){"
                . "if(i > 1){"
                . "if(tipoVenc == 1){"
                . "dataParcela = new Date(dataInicial);"
                . "dataParcela.setMonth(dataParcela.getMonth() + (i-1));"
                . "} else {"
                . "dataParcela = Ext.Date.add(new Date(dataParcela), Ext.Date.DAY, dias);"
                . "}"
                . "}"
                . "if(i == numParcelas){"
                . "valorParcela = valorTotal - somaParcelas;"
                . "}"
                . "store.add([[dataParcela,valorParcela]]);"
                . "somaParcelas += parseFloat(valorParcela);"
                . "}"
                . "store.sync();"
                . "}";

        return $sAcao;
    }

    /**
     * M�todo que realiza a chamada ao m�todo respons�vel por buscar valores
     * no banco de dados e preencher determinados campos na tela
     * 
     * @param string $sClasse Nome da classe a ser efetivada a busca
     * @param string $sCamposFiltro Campos que ser�o utilizados no filtro (WHERE)
     * @param string $sValoresFiltro Valores que ser�o utilizados no filtro (WHERE)
     * @param string $sCamposCarrega Campos que ser�o carregados (rela��o campo banco x campo tela)
     * @param object $oCampoValida Se passado ir� executar a a��o apenas se o valor do campo n�o for nulo
     * 
     * @return string
     */
    public function buscaValorCampo($sClasse, $sCamposFiltro, $sValoresFiltro, $sCamposCarrega, $oCampoValida = null) {
        $sAcao = "requestAjax('','" . $sClasse . "','getValorBusca',[['" . implode("','", explode(',', $sCamposFiltro)) . "'],[" . $sValoresFiltro . "],['" . $sCamposCarrega . "']])";

        if ($oCampoValida != null) {
            $sAcao = "if(Ext.ComponentQuery.query('#" . $oCampoValida->getId() . "')[0].getValue() != null && "
                    . "Ext.ComponentQuery.query('#" . $oCampoValida->getId() . "')[0].getValue() != ''){"
                    . $sAcao .
                    "}";
        }
        return $sAcao;
    }

    /**
     * M�todo que permite adicionar chamadas a qualquer m�todo do controller
     * a partir da tela
     * 
     * @param string $sClasse Nome da classe
     * @param string $sMetodo Nome do método
     * @param array $aParametros Par�metros do m�todo no formato de array
     * 
     * @return string Contendo a a��o a ser requisitada pelo ExtJs
     */
    public function addAcao($sClasse, $sMetodo, $aParametros = array()) {
        $sParametros = "";
        foreach ($aParametros as $key => $value) {
            if ($key > 0) {
                $sParametros .= ",";
            }
            if (is_numeric($value) || substr($value, 0, 4) == 'Ext.') {
                $sParametros .= $value;
            } else {
                $sParametros .= "'" . $value . "'";
            }
        }

        $sAcao = "requestAjax('','" . $sClasse . "','" . $sMetodo . "',[" . $sParametros . "]);";
        return $sAcao;
    }

    /**
     * M�todo que permite adicionar testes condicionais para anteceder a 
     * execu��o de tarefas
     * Os testes ser�o feitos a partir dos valores dos campos passados por
     * par�metro
     * 
     * @param Object Objeto do tipo campo ou valor a ser utilizado � esquerda da compara��o condicional
     * @param Object Objeto do tipo campo ou valor a ser utilizado � direita da compara��o condicional
     * @param string Tipo de compara��o a ser realizado
     */
    public function addCondicinal($xCondicionalA, $xCondicionalB, $sCondicional = Base::IGUAL) {
        $this->aCondicional[] = array($xCondicionalA, $xCondicionalB, $sCondicional);
    }

    /**
     * Retorna o array contendo os condicionais a serem considerados na fun��o
     */
    public function getCondicional() {
        return $this->aCondicional;
    }

    /**
     * Retorna a string contendo o c�digo com a ser executado considerando as
     * restri��es existentes no atributo aCondicional
     * 
     * @param string C�digo a ser inclu�do dentro da condicional
     * 
     * @return string C�digo contendo a a��o juntamente com a inclus�o da condicional
     */
    public function getStringCondicional($sAcao) {
        $sCondicional = "";
        foreach ($this->getCondicional() as $key => $aAtual) {
            $sCondicional .= $key === 0 ? "if(" : " && ";

            //valor da esquerda
            $sCondicional .= method_exists($aAtual[0], 'getValor') ? " Ext.ComponentQuery.query('#" . $aAtual[0]->getId() . "')[0].getValue() " : $aAtual[0];

            //tipo de compara��o condicional
            $sCondicional .= $aAtual[2];

            //valor da direita
            $sCondicional .= method_exists($aAtual[1], 'getValor') ? " Ext.ComponentQuery.query('#" . $aAtual[1]->getId() . "')[0].getValue() " : $aAtual[1];
        }
        return $sCondicional . "){" . $sAcao . "}";
    }

    /**
     * M�todo que retorna o id da tab ativa no sistema
     * @return type
     */
    public function getTabAtiva() {
        return "Ext.ComponentQuery.query('#" . Config::TABPANEL . "')[0].getActiveTab().id";
    }

    /**
     * Retorna o conte�do do atributo aGroupBy
     * 
     * @return array
     */
    public function getGroupBy() {
        return $this->aGroupBy;
    }

    /**
     * M�todo que realiza a adi��o dos par�metros respons�veis pelo 
     * agrupamento das telas de consulta
     */
    public function addGroupBy() {
        $aCampos = func_get_args();

        foreach ($aCampos as $sCampo) {
            $this->aGroupBy[] = $sCampo;
        }
    }

    /**
     * Retorna o conte�do do atributo aOrderBy
     * 
     * @return array
     */
    public function getOrderBy() {
        return $this->aOrderBy;
    }

    /**
     * M�todo que realiza a adi��o dos par�metros respons�veis pela 
     * ordena��o das telas de consulta
     * 
     * @param string $oCampo Campo do tipo consulta que ser� utilizado na ordena��o
     * @param integer $iTipo Tipo da ordena��o
     *                0 ==> Crescente (ASC)
     *                1 ==> Decrescente (DESC)
     */
    public function addOrderBy($oCampo, $iTipo = 0) {
        $this->aOrderBy[] = array($oCampo, $iTipo);
    }

    /**
     * Método que cria e retorna o objeto de separadores
     * 
     * @param integer $iTipo Tipo do separador
     * 
     * @return object Objeto do tipo separador
     */
    public function getSeparador($iTipo = Separador::TIPO_BARRA) {
        return new Separador($iTipo);
    }

    /**
     * M�todo que cria retorna o objeto da tela 
     * para que possa ser renderizado pelo sistema
     */
    public function getRender() {
        return $this->getTela()->getRender();
    }

    /**
     * 
     * Retorna a rotina
     */
    function getSRotina() {
        return $this->sRotina;
    }

    /**
     * 
     * seta a rotina
     */
    function setSRotina($sRotina) {
        $this->sRotina = $sRotina;
    }

    /**
     * M�todo usado para montar um cabeçalho para os forms
     */
    public function getSCabtela() {
        return $this->sCabtela;
    }

    public function setSCabtela($sCabtela) {
        $this->sCabtela = $sCabtela;
    }

    public function getOModelManual() {
        return $this->oModelManual;
    }

    public function setOModelManual($oModelManual) {
        $this->oModelManual = $oModelManual;
    }

    public function gridDetalhe() {
        //método para ser substituido
    }

    /**
     * Adiciona botões padrão nas telas de cadastro
     */
    public function addBotaoPadraoTela($sCampoIncremento) {
        //busca campo autoincremento para atualizar registro

        $sClasse = $this->getController();
        //adição dos botões no form
        if ($this->getBEtapa()) {
            $sMetodo = 'acaoDetalhe'; //$this->getSRotina();
            $sIdEtapas = $this->idEtapa();
            $sIdBody = $this->getTela()->getId() . '-body';
            //define o controle da etapa inicial
            $sEtapaInicial = '1';
            $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $sClasse . '","' . $sMetodo . '","' . $this->getTela()->getId() . '-form,' . $this->getTela()->getSRenderHide() . ',' . $sIdEtapas . ',' . $sEtapaInicial . ',' . $sIdBody . ',' . $this->getTela()->getId() . ',' . $this->getSIdControleUpAlt() . ',' . $this->getTela()->getAbaSel() . '");';
            $oBtnAdd = new Botao('Próximo', Botao::TIPO_PROXIMO, '');
            $this->getTela()->setAcaoConfirmar($sAcao);
            $this->getTela()->setIdBtnConfirmar($oBtnAdd->getId());
            $this->getTela()->addBotoes($oBtnAdd);
        } else {
            if (!($this->getBOcultaBotTela())) {
                $sCampoIncremento .= $this->getSIdUpload();
                $sMetodo = $this->getSRotina();
                $oBtnAdd = new Botao('', Botao::TIPO_CONFIRMAR, '');
                $oBtnAdd->setRequestAjax('requestAjax("' . $this->getTela()->getId() . '-form","' . $sClasse . '","' . $sMetodo . '","' . $this->getTela()->getId() . ',' . $this->getTela()->getSRenderHide() . ',' . $sCampoIncremento . ',' . $this->getTela()->getAbaSel() . '");'); //"'.$this->getSIdUpload().'"
                $this->getTela()->addBotoes($oBtnAdd);
            }

            $sAcao = '$("#' . $this->getTela()->getId() . '-form").each (function(){ this.reset();});';
            $oBtnLimpar = new Botao('', Botao::TIPO_LIMPAR, $sAcao);
            $this->getTela()->addBotoes($oBtnLimpar);
        }
        //desativa botao fechar
        if (!($this->getBOcultaFechar())) {
            $sAcaoClose = '';
            $sAcaoClose = $this->getTela()->getSAcaoClose();
            $sAcao = '' . $sAcaoClose . '$("#' . $this->getTela()->getId() . '").remove();$("#' . $this->getTela()->getSRenderHide() . 'consulta").toggle();';
            $oBtnFechar = new Botao('', Botao::TIPO_FECHAR, $sAcao);
            $this->getTela()->addBotoes($oBtnFechar);
        }
    }

    public function addBotaoApont() {
        $sAcao = '$("#' . $this->getTela()->getId() . '-form").each (function(){ this.reset();});';
        $oBtnLimpar = new Botao('', Botao::TIPO_LIMPAR, $sAcao);
        $this->getTela()->addBotoes($oBtnLimpar);

        $sAcao = '$("#' . $this->getTela()->getId() . '").remove();$("#' . $this->getTela()->getSRenderHide() . 'consulta").toggle();';
        $oBtnFechar = new Botao('', Botao::TIPO_FECHAR, $sAcao);
        $this->getTela()->addBotoes($oBtnFechar);
    }

    /**
     * Adiciona botões padrão para tela de detalhe
     */
    public function adicionaBotoesDet($sFormInicial = NULL, $sEtapa = NULL, $sFechar = NULL, $sHide = NULL, $sCount = NULL) {
        $sAcao = '$("#' . $this->getTela()->getId() . '-form").remove();$("#' . $sFormInicial . '").toggle();$( "#' . $sEtapa . ' > #' . $sCount . '" ).removeClass( "current" );';
        $oBotaoVoltar = new Botao('Voltar', Botao::TIPO_VOLTAR, $sAcao);

        $sAcaoFechar = $this->addeventoConc() . ' $("#' . $sFechar . '").remove();$("#' . $sHide . 'consulta").toggle();$("#' . $sHide . '-pesq").click();';

        $oBotaoConcluir = new Botao('Concluir', Botao::TIPO_CONCLUIRDET, $sAcaoFechar);
        $this->getTela()->addBotoes($oBotaoConcluir, $oBotaoVoltar);
    }

    /**
     * Adiciona botão detalhe com mais de duas etapas
     */
    public function adicionaBotoesEtapas($sEtapa = NULL, $iCount = NULL, $sForm = NULL, $sBody = NULL, $sBody2 = NULL, $sFormConsulta = NULL, $sControllerDetalhe = NULL, $sMetodoDetalhe = 'acaoTelaDetalhe', $sRotina = NULL) {

        $sAcao = '$("#' . $this->getTela()->getId() . '-form").remove();$("#' . $sForm . '").toggle();$( "#' . $sEtapa . ' > #' . $iCount . '" ).removeClass( "current" );';
        $oBotaoVoltar = new Botao('Voltar', Botao::TIPO_VOLTAR, $sAcao);

        $sTelaAtual = $this->getTela()->getId() . '-form';

        $sValores = implode(',', $this->getAParametrosExtras());

        $iCount++;
        $sAcao = '$( "#' . $sEtapa . ' > #' . $iCount . '" ).addClass( "current" );$("#' . $sTelaAtual . '").toggle(); requestAjax("' . $this->getTela()->getId() . '-form","' . $sControllerDetalhe . '","' . $sMetodoDetalhe . '","' . $sEtapa . ',' . $iCount . ',' . $sTelaAtual . ',' . $sBody . ',' . $sBody2 . ',' . $sFormConsulta . ',' . $sRotina . '","' . $sValores . '");';
        $oBtnAdd = new Botao('Próximo', Botao::TIPO_PROXIMO, $sAcao);


        $this->getTela()->addBotoes($oBtnAdd, $oBotaoVoltar);
    }

    /**
     * Método que set o layout da tela
     * @param string $sLayout define o layout
     * 
     * Aba=tela gerenciada com abas
     */
    public function addLayoutPadrao($sLayout = NULL) {
        $this->getTela()->getLayout()->setSTipoLayout($sLayout);
    }

    /**
     * seta o t�tulo quando a tela � uma consulta
     */
    public function setaTiluloConsulta($sTitulo) {
        $this->getTela()->setSTituloConsulta($sTitulo);
    }

    /**
     * M�todo respons�vel pela renderiza��o de dropdowns
     * instanciados na cria consulta da classe atual
     */
    public function addDropdown() {
        $aDados = func_get_args();

        foreach ($aDados as $DropAtual) {
            $this->aDropdown[] = $DropAtual;
        }
    }

    /**
     * M�todo responsavel por gerar string de �cones
     * para utilizar basta acessar a Base e utilizar as constates
     * j� definidas, exemplo: Base::ICON_CONFIG
     * @param string $sClasse Icones disponiveis na Base, exemplo: Base::ICON_
     * @return string Retorna a string a ser concatenada
     */
    public function addIcone($sClasse) {
        $sIcon = '<i class="' . $sClasse . '" aria-hidden="true"></i>';

        return $sIcon;
    }

    /**
     * Método responsável pela inclusção de Filtros a serem renderizados
     */
    public function addFiltro() {
        $aDados = func_get_args();

        foreach ($aDados as $FiltroAtual) {
            $this->aFiltro[] = $FiltroAtual;
        }
    }

    /**
     * Método 
     */
    public function addEtapa() {
        $aEtapa = func_get_args();
        $this->setBEtapa(true);
        foreach ($aEtapa as $campoAtual) {
            $this->getTela()->addEtapa($campoAtual);
        }
    }

    function getSControllerDetalhe() {
        return $this->sControllerDetalhe;
    }

    function setSControllerDetalhe($sControllerDetalhe) {
        $this->sControllerDetalhe = $sControllerDetalhe;
    }

    /**
     * Retorna o id da etapa do grid
     */
    function idEtapa() {
        $sIdEtapa = '';
        foreach ($this->getTela()->getAEtapas() as $key => $oEtapa) {
            //id da etapa
            $sIdEtapa = $oEtapa->getSId();
        }
        return $sIdEtapa;
    }

    /**
     * Adiciona grids
     */

    /**
     * Método que adiciona os campos criados na tela
     */
    public function addGriTela() {
        $aGrid = func_get_args();

        foreach ($aGrid as $gridAtual) {
            $this->getTela()->addGrid($gridAtual);
        }
    }

    /**
     * Método para sobescrever para adicionar eventos nos botões concluir em datails
     */
    public function addeventoConc() {
        return '';
    }

}

?>