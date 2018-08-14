<?php

/*
 * Classe que implementa a estrutura de grid
 * no sistema
 * 20/10/2015
 */

class Grid {

    private $sId; //id do grid
    private $sRenderTo; //renderTo
    private $abaSel;
    private $aColunas; //colunas do grid, entra os camposconsulta da view, os objetos
    private $sController; //controle para pegar os dados
    private $aBotoes;
    private $bConsulta;
    private $sTituloConsulta; //monta o nome da pesquisa quando é mostrado o grid como consulta
    private $sRenderHide;
    private $aDropdown; //array onde estarão dropdowns disponiveis para renderização
    private $sCampoConsulta;
    private $sCampoRetorno;
    private $aFiltro;
    private $bDetalhte;
    private $iAltura;
    private $aFiltrosIni;
    private $bGridCampo;
    private $sTelaGrande; //Define o valor para tela grandes como note e pc
    private $sTelaMedia; //Define o valor para telas de tablets e notes pequenos
    private $sTelaPequena; //Define o valor para telas pequenas como tablets pequenos e celulares
    private $sTelaMuitoPequena; //Define o valor para telas muito pequenas como celulares pequenos
    private $aParametros; //Array que define os parametros de grids como campos
    private $bScrollInf;
    private $sEventoClick;
    private $sScrollInfCampo;
    private $sOrdemScrollInf;
    private $oLayout;
    private $aCampos; //campos da tela
    private $bScrollInfTelaGrid;
    private $sIdTelaGrid;
    private $bNaoUsaScroll;
    private $bUsaCarrGrid;
    private $iLarguraGrid;
    private $bGridResponsivo;
    private $bUsaKeypress;
    private $bMostraFiltro;
    private $aModal;
    
    /**
     * Construtor da classe Grid 
     * @param string $sTelaGrande Define o valor para telas de notebook e pc valores 1 ao 12
     *  @param string $sTelaMedia Define o valor para telas de tablets  1 ao 12
     *  @param string $sTelaPequena Define o valor para telas de celulares
     *  @param string $sTelaMuitoPequena Define o valor para telas de celulares pequenos
     *
     */
    function __construct($sTelaGrande = '12', $sTelaMedia = '12', $sTelaPequena = '12', $sTelaMuitoPequena = '12', $iAltura = 400, $iLarguraGrid = 1800) {
        $this->sId = Base::getId();
        $this->aColunas = array();
        $this->aBotoes = array();
        $this->aModal = array();
        $this->setIAltura($iAltura);
        $this->aFiltrosIni = array();
        $this->setBGridCampo(false);
        $this->setSTelaGrande($sTelaGrande);
        $this->setSTelaMedia($sTelaMedia);
        $this->setSTelaPequena($sTelaPequena);
        $this->setSTelaMuitoPequena($sTelaMuitoPequena);
        $this->aParametros = array();
        $this->setSEventoClick(null);
        $this->oLayout = new Layout();
        $this->aCampos = array();
        $this->setBUsaCarrGrid(false);
        $this->setILarguraGrid($iLarguraGrid);
        $this->setBGridResponsivo(TRUE);
        $this->setBUsaKeypress(true);
        $this->setBMostraFiltro(false);
    }
    
     /**
     * Adiciona um botão ao vetor de botões do objeto
     * 
     * @param object $oBotao 
     */
    public function addModal() {
        $aModal = func_get_args();
        foreach ($aModal as $oModal) {
            $this->aModal[] = $oModal;
        }
    }
    
    function getBMostraFiltro() {
        if($this->bMostraFiltro){
           return ''; 
        }else{
            
            return 'display: none;';
        }
        
    }
    
    
    function setBMostraFiltro($bMostraFiltro) {
        $this->bMostraFiltro = $bMostraFiltro;
    }

        
    function getBUsaKeypress() {
        return $this->bUsaKeypress;
    }

    function setBUsaKeypress($bUsaKeypress) {
        $this->bUsaKeypress = $bUsaKeypress;
    }

        
    function getAbaSel() {
        return $this->abaSel;
    }

    function setAbaSel($abaSel) {
        $this->abaSel = $abaSel;
    }

    
    function getBGridResponsivo() {
        return $this->bGridResponsivo;
    }

    function setBGridResponsivo($bGridResponsivo) {
        $this->bGridResponsivo = $bGridResponsivo;
    }

    function getBUsaCarrGrid() {
        return $this->bUsaCarrGrid;
    }

    function setBUsaCarrGrid($bUsaCarrGrid) {
        $this->bUsaCarrGrid = $bUsaCarrGrid;
    }

    function getBNaoUsaScroll() {
        return $this->bNaoUsaScroll;
    }

    function setBNaoUsaScroll($bNaoUsaScroll) {
        $this->bNaoUsaScroll = $bNaoUsaScroll;
    }

    function getBScrollInfTelaGrid() {
        return $this->bScrollInfTelaGrid;
    }

    function getSIdTelaGrid() {
        return $this->sIdTelaGrid;
    }

    function setBScrollInfTelaGrid($bScrollInfTelaGrid) {
        $this->bScrollInfTelaGrid = $bScrollInfTelaGrid;
    }

    function setSIdTelaGrid($sIdTelaGrid) {
        $this->sIdTelaGrid = $sIdTelaGrid;
    }

    /**
     * Adiciona itens ao vetor de elementos do objeto
     */
    private function addCampoTela($oCampo) {
        $this->aCampos[] = $oCampo;
    }

    /**
     * Retorna o objeto de layout
     */
    public function getLayout() {
        return $this->oLayout;
    }

    function getSScrollInfCampo() {
        return $this->sScrollInfCampo;
    }

    function getSOrdemScrollInf() {
        return $this->sOrdemScrollInf;
    }

    function setSScrollInfCampo($sScrollInfCampo) {
        $this->sScrollInfCampo = $sScrollInfCampo;
    }

    function setSOrdemScrollInf($sOrdemScrollInf) {
        $this->sOrdemScrollInf = $sOrdemScrollInf;
    }

    function getSEventoClick() {
        return $this->sEventoClick;
    }

    function setSEventoClick($sEventoClick) {
        $this->sEventoClick = $sEventoClick;
    }

    function getBScrollInf() {
        return $this->bScrollInf;
    }

    function setBScrollInf($bScrollInf) {
        $this->bScrollInf = $bScrollInf;
    }

    function getAParametros() {
        return $this->aParametros;
    }

    function setAParametros($aParametros) {
        $this->aParametros = $aParametros;
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

    function getBGridCampo() {
        return $this->bGridCampo;
    }

    function setBGridCampo($bGridCampo) {
        $this->bGridCampo = $bGridCampo;
    }

    function getIAltura() {
        return $this->iAltura;
    }

    function setIAltura($iAltura) {
        $this->iAltura = $iAltura;
    }

    function getILarguraGrid() {
        return $this->iLarguraGrid;
    }

    function setILarguraGrid($iLarguraGrid) {
        $this->iLarguraGrid = $iLarguraGrid;
    }

    function getBDetalhte() {
        return $this->bDetalhte;
    }

    function setBDetalhte($bDetalhte) {
        $this->bDetalhte = $bDetalhte;
    }

    function getController() {
        return $this->sController;
    }

    function setController($sController) {
        $this->sController = $sController;
    }

    /* Retorna o conteúdo do atributo getSid
     */

    function getSId() {
        return $this->sId;
    }

    /*
     * Seta o conteúdo do atributo setSId
     */

    function setSId($sId) {
        $this->sId = $sId;
    }

    /*
     * Retorna o conteúdo do atributo getSRenderTo
     */

    function getSRenderTo() {
        return $this->sRenderTo;
    }

    /*
     * Seta o conteúdo do atributo getSRenderTo
     */

    function setSRenderTo($sRenderTo) {
        $this->sRenderTo = $sRenderTo;
    }

    function getBConsulta() {
        return $this->bConsulta;
    }

    function setBConsulta($bConsulta) {
        $this->bConsulta = $bConsulta;
    }

    /**
     * 
     * @return Seta o Título da consulta
     */
    function getSTituloConsulta() {
        return $this->sTituloConsulta;
    }

    /**
     * 
     * @param type $sTituloConsulta seta o título da consulta
     */
    function setSTituloConsulta($sTituloConsulta) {
        $this->sTituloConsulta = $sTituloConsulta;
    }

    /**
     * 
     * @return type o id da tela que deu um hide ao abrir o grid
     */
    function getSRenderHide() {
        return $this->sRenderHide;
    }

    /**
     * 
     * @param type $sRenderHide seta o id da tela que houve um hide
     */
    function setSRenderHide($sRenderHide) {
        $this->sRenderHide = $sRenderHide;
    }

    /**
     * 
     * @return type retorna o campo consulta
     */
    function getSCampoConsulta() {
        return $this->sCampoConsulta;
    }

    /**
     * 
     * @param type $sCampoConsulta seta o campo consulta
     */
    function setSCampoConsulta($sCampoConsulta) {
        $this->sCampoConsulta = $sCampoConsulta;
    }

    /**
     * 
     * @return type o campo de retorno de consulta
     */
    function getSCampoRetorno() {
        return $this->sCampoRetorno;
    }

    /**
     * 
     * @param type $sCampoRetorno o campo de retorno das consultas
     */
    function setSCampoRetorno($sCampoRetorno) {
        $this->sCampoRetorno = $sCampoRetorno;
    }

    /**
     * Adiciona itens ao vetor de colunas do objeto
     * 
     * @param object $oItem 
     */
    public function addCampos() {
        $aColunas = func_get_args();

        foreach ($aColunas as $oColuna) {
            $this->aColunas[] = $oColuna;
        }
    }

    /**
     * Adiciona itens ao vetor de colunas do objeto
     * 
     * @param object $oItem 
     */
    public function addCamposGrid() {
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            if (is_array($campoAtual)) {
                foreach ($campoAtual as $campo) {
                    $this->addCampoTela($campo);
                }
            } else {
                $this->addCampoTela($campoAtual);
            }
            $this->oLayout->addItems($campoAtual); //Verificar o oLayout
        }
    }

    /**
     * Adiciona itens ao vetor de filtros iniciais do grid
     * 
     * @param object $oItem 
     */
    public function addCamposIni() {
        $aFiltrosIni = func_get_args();

        foreach ($aFiltrosIni as $oFiltro) {
            $this->aFiltrosIni[] = $oFiltro;
        }
    }

    /**
     * Retorna o array de campos a ser utilizado pelas classes externas
     * Pode ser retornada apenas a posição desejada ou todo o vetor
     * 
     * @param integer $iPosicao Posição do vetor a ser retornada (opcional)
     * 
     * @return Array
     */
    public function getArrayCampos($iPosicao = -1) {
        return $iPosicao === -1 ? $this->aColunas : $this->aColunas[$iPosicao];
    }

    /**
     * Adiciona um botão ao vetor de botões do objeto
     * 
     * @param object $oBotao 
     */
    public function addBotoes() {
        $aBotoes = func_get_args();
        foreach ($aBotoes as $oBotao) {
            $this->aBotoes[] = $oBotao;
        }
    }

    /**
     * Retorna um campo da lista de campos a partir do nome do mesmo
     * 
     * @param String $sNome Nome do campo a ser localizado
     * 
     * @return Object/null Retorna o objeto desejado ou nulo caso não encontrado
     */
    public function getCampoByName($sNome) {
        foreach ($this->getArrayCampos() as $oCampo) {
            if (strtolower($oCampo->getsNome()) === strtolower($sNome)) {
                return $oCampo;
            }
        }
        return null;
    }

    /**
     * Método responsavel por adicionar dropdowns de ações
     */
    public function addDropdownConsulta($aDropdowns) {
        //$aDropdowns = func_get_args(); 
        foreach ($aDropdowns as $oDropdown) {
            $this->aDropdown[] = $oDropdown;
        }
    }

    /**
     * Método responsável por adicionar filtros na consulta

     */
    public function addFiltroConsulta($aFiltro) {
        foreach ($aFiltro as $oFiltro) {
            $this->aFiltro[] = $oFiltro;
        }
    }

    /**
     * Método que retorna renderizaçao de telas modais
     */
    public function getRenderModal($sTitulo, $sNome, $sId, $sIdTela) {
        //teste para renderizaçao de janelas modais
        $sModal1 = '<div class="modal fade" id="' . $sNome . '" aria-hidden="true" aria-labelledby="examplePositionCenter" '
                . 'role="dialog" tabindex="-1"> '
                . '         <div class="modal-dialog modal-center"> '
                . '           <div class="modal-content">   '
                . '             <div class="modal-header"> '
                . '               <h5 class="modal-title">' . $sTitulo . '</h5>'
                . '             </div> '
                . '             <div style="margin-top:-30px;"class="modal-body" id="' . $sId . '-modal"> '
                . '                                      '
                . '              </div> '
                . '             <div class="modal-footer"> '
                . '                <button type="button" id="' . $sId . '-btn" class="btn btn-danger" data-dismiss="modal">Fechar</button> '
                //  .'               <button type="button" class="btn btn-primary">Save changes</button> '
                . '             </div> '
                . '           </div> '
                . '         </div> '
                . '        </div> '
                . '<script>$("#' . $sId . '-btn").click(function(){$("#' . $sId . '-modal >").remove();$("#' . $sIdTela . '-pesq").click();});</script>';

        return $sModal1;
    }

    /**
     * Gera o html e o java script da tela que irá ser renderizada
     */
    public function getRender() {
        $sGrid = "";
        $sGrid .= '<div id="' . $this->getSId() . 'resize" class="col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >';
        //verifica se o grid está setado para montar o cabeçalho
        if ($this->getBConsulta()) {
            $sGrid .= '<div class="panel panel-bordered" id="' . $this->getSId() . 'form">'
                    . '<div class="panel-heading">'
                    . '<h3 class="panel-title">' . $this->getSTituloConsulta() . '</h3>'
                    . '<div class="panel-actions">'
                    . '<a class="panel-action icon wb-close" data-toggle="panel-close" id="' . $this->getSId() . 'formclose" aria-hidden="true"></a>'
                    . '</div>'
                    . '</div>'
                    . '<div class="panel-body">';
        }
        //foreach a botao e vai montar o html dos botões
        if (!empty($this->aBotoes)) {
            $sBotao = '<div id="' . $this->getSId() . 'consulta"><div class="row botoes-consulta">';
            foreach ($this->aBotoes as $key => $oBotao) {
                $sBotao .= $oBotao->getRender();
            }
            if (!empty($this->aDropdown)) {
                $sModal = '';
                foreach ($this->aDropdown as $oDropdown) {
                    $sBotao .= $oDropdown->getRender($this->getSId());
                    $aDrop = $oDropdown->getAItensDropdown();

                    foreach ($aDrop as $aItem) {
                        if ($aItem['bModal']) {
                            //carrega a classe model
                            $sModal .= $this->getRenderModal($aItem['titulo'], $aItem['nomeModal'], $aItem['id'], $this->getSId());
                        }
                    }
                }
            }
            $sBotao .= $sModal . '</div>';
        }
        if (!empty($this->aFiltro)) {
            $sFiltro = ' <div class="row" id="' . $this->getSId() . '-filtros" style="'.$this->getBMostraFiltro().' background-color: whitesmoke">'
                    . '<form class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="' . $this->getSId() . '-pesquisa" style=" position: relative; padding: 15px 15px 15px 50px;  background-color: #f3f7fa;  border: 1px solid #eee">'
                    . '<div class="ribbon ribbon-clip ribbon-reverse ribbon-dark">'//ribbon ribbon-clip ribbon-reverse ribbon-primary
                    . '<a href="javascript:void(0)" id ="' . $this->getSId() . '-pesq">'
                    . '<span class="ribbon-inner" >'
                    . 'Buscar'
                    . '</span>'
                    . '</a>'
                    . '</div>';
            //rendereizar filtros
            foreach ($this->aFiltro as $oFiltro) {
                $iTipo = $oFiltro->getITipoCampo();

                $sFiltro .= $oFiltro->getRender();
            }
            $sFiltro .= '</form>'
                    . '<script>';
                if($this->getBUsaKeypress()){
                    $sFiltro .= '$("#' . $this->getSId() . '-pesquisa :input").keyup(function(){'
                    . 'var val = $(this).val();'
                    . '$("#' . $this->getSId() . '-pesquisa").each(function(){'
                    . 'if(val.length > 2){'
                    . 'sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '");'
                    . '}'
                    . 'if(val.length <= 1){'
                    . 'sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '");'
                    . '}'
                    . '});'
                    . '});';
                    }
            $sFiltro .= '$("#' . $this->getSId() . '-pesq").click(function(){'
                    . '    sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '");'
                    . ' });'
                    . '</script>'
                    . '</div>';
        }



        $sGrid .= $sBotao;
        $sGrid .= $sFiltro;


        $sGrid .= '<div id="' . $this->getSId() . 'resize" class="col-lg-' . $this->getSTelaGrande() . ' col-md-' . $this->getSTelaMedia() . ' col-sm-' . $this->getSTelaPequena() . ' col-xs-' . $this->getSTelaMuitoPequena() . '" >';
        $sGrid .= '<div class="label-dark" style="margin-top:10px;"><span class="label label-dark">' . $this->getSTituloConsulta() . '</span></div>';

        $sGrid .= '<div class="containerTable">';
        $this->getBGridResponsivo() == true ? $sGrid .= '<div class="classe-vazia">' : $sGrid .= '<div class="classe-vazia" style="width:' . $this->getILarguraGrid() . 'px;margin:0 auto;">';
        //$sGrid .= '<div class="classe-vazia" style="width:' . $this->getILarguraGrid() . 'px;margin:0 auto;">';
        $sGrid .= '<table id="' . $this->getSId() . '" class="display compact cell-border" cellspacing="0" width="100%" style="background-color:#E8E8E8" >'//display compact
                . '<thead><tr role ="row"><th></th>';
        //monta o cabeçalho baseado nos campos do cria consulta
        foreach ($this->aColunas as $key => $oCampoAtual) {
            $sLargura = '';
            if (!is_null($oCampoAtual->getILargura())) {
                $sLargura = 'style="width: ' . $oCampoAtual->getILargura() . 'px;"';
            }
            $sGrid .= '<th ' . $sLargura . '>' . $oCampoAtual->getSLabel() . '</th>';
        }
        //monta th da chave primaria
        $sGrid .= '<th class="hidden"></th>';
        //carrega os campos da consulta
        $oDados = Fabrica::FabricarController($this->getController());
        $oDados->filtroInicial();
        //verifica se há filtros 
        foreach ($this->aFiltrosIni as $key => $oFiltro) {
            $oNomePers = $oDados->Persistencia->getCampoByNameModel($oFiltro->getNome());
            $oDados->Persistencia->adicionaFiltro($oNomePers->getNomeBanco(), $oFiltro->getSValor());
        }
        //verifica se há filtros vindo de campos grid dos forms
        foreach ($this->aParametros as $value) {
            $aFiltro = explode(',', $value);
            $oDados->Persistencia->adicionaFiltro($aFiltro[0], $aFiltro[1]);
        }
        $sDados = $oDados->getDadosConsulta(NULL, $bConsultaPorSql = false, $this->getSCampoConsulta(), $this->getArrayCampos(), $this->getBGridCampo());

        $sGrid .= '</tr></thead>';


        //carrega botao carregar
        $sEventoCarr = '';
        if ($this->getBScrollInf()) {
            $sEventoCarr = 'var lastregCarr = $("#' . $this->getSId() . ' tr:last" ).find(".chave").html();  '
                    . 'sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '",true,lastregCarr,"");';
        }

        if ($this->getSScrollInfCampo() !== null) {
            $sEventoCarr = 'var lastregCarr = $("#' . $this->getSId() . ' tr:last" ).find(".chave").html(); '
                    . 'sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '",true,lastregCarr,"' . $this->getSScrollInfCampo() . '");';
        }
        if ($this->getBScrollInfTelaGrid()) {
            $sEventoCarr = '';
            $sEventoCarr = 'var lastregCarr = $("#' . $this->getSId() . ' tr:last" ).find(".chave").html();'
                    . 'sendFiltros("#' . $this->getSIdTelaGrid() . '","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '",true,lastregCarr,"' . $this->getSScrollInfCampo() . '");';
        }

        $sBotCarregar = '';
        if ($this->getBUsaCarrGrid()) {
            $sBotCarregar = '<button type="button" id="' . $this->getSId() . '-botcarr" class="btn btn-primary btn-xs '
                    . 'ladda-button" data-style="expand-left" data-plugin="ladda" >'
                    . '<span class="ladda-label">Carregar...</span>'
                    . '<span class="ladda-spinner"></span></button> '
                    . '<script>'
                    . '$("#' . $this->getSId() . '-botcarr").click(function(){' . $sEventoCarr . '});'
                    . '</script>';
        }

        $this->getBGridResponsivo() == true ? $sGrid .= '<tbody id="' . $this->getSId() . 'body">' . $sDados . '</tbody></table></div>' . $sBotCarregar . '<div class="panel"><table id="' . $this->getSId() . '-summary" class="table table-hover"><tbody><tr class="tr-destaque">' : $sGrid .= '<tbody id="' . $this->getSId() . 'body">' . $sDados . '</tbody></table></div>' . $sBotCarregar . '<div style="width:' . $this->getILarguraGrid() . 'px;margin:0 auto;" class="panel"><table id="' . $this->getSId() . '-summary" class="table table-hover" style=" width:' . $this->getILarguraGrid() . 'px"><tbody><tr class="tr-destaque">';
        $sGrid .= $oDados->getDadosFoot($this->getArrayCampos(), $this->getBGridCampo(), $this->getAParametros());
        $sGrid .= '<span name="paramGrid" id="'.$this->getAbaSel().'paramGrid" style="display:none;">'.$this->getSId().'</span></tr></tbody></table></div></div>';
       


        $sGrid .= '</div>';


        //renderiza campos abaixo do grid
        //renderiza os campos
        $sConteudo = $this->oLayout->getRender();
        $sGrid .= $sConteudo;


        $sGrid .= '</div>';

        //verifica se tem botao do tipo modal no grid
        foreach ($this->aModal as $key => $oModal) {
            $aAcao = $oModal->getAAcao();
            $sGrid .= $this->getRenderModal($oModal->getSTitleAcao(),$aAcao['modalNome'], $aAcao['modalNome'], $this->getSId());
        }    

        //eventos do grid
        //variável para identificar onde ficará o grid
        $table = str_replace('-', '', $this->getSRenderTo());
        //renderiza os eventos
        $sEventos = '';

        foreach ($this->aBotoes as $key => $oBotao) {
            $sEventos .= $oBotao->getAAcao();
            //verifica se é alterar e joga id na variável

            ($oBotao->getITipo() == 3) ? $sAlterarId = $oBotao->getId() : $sAlterarId;
            //capatura a ação do alterar
            ($oBotao->getITipo() == 3) ? $sacaoAlterar = $oBotao->getAAcao() : '';
            ($oBotao->getITipo() == 2) ? $sRemoverId = $oBotao->getId() : $sRemoverId;
            ($oBotao->getITipo() == 16) ? $sVizualizar = $oBotao->getId() : $sVizualizar;
        }

        //fecha a pesquisa se necessário
        if ($this->getBConsulta()) {
            $sGrid .= ' </div>';
            //monta evento do retorno
            $sEventoRetorno = ' $("#' . $this->getSId() . ' tbody").on("dblclick", "tr", function () {'
                    . ' var campoRet = $(this).find(".consultaCampo").html();'
                    . '$("#' . $this->getSId() . 'form").remove();'
                    . '$("#' . $this->getSCampoRetorno() . '").val(campoRet);'
                    . '$("#' . $this->getSRenderHide() . '").toggle();'
                    . '$("#' . $this->getSCampoRetorno() . '").focus();'
                    . '$("#' . $this->getSCampoRetorno() . '").blur();'
                    . '} );';
            
            $sEnter ='$("#' . $this->getSId() . ' tbody tr").keypress(function(e) { '  //$( "#style327115ae71976bad30 tbody tr" ).keydown(function(e) {
                     .'                if(e.which == 13) { '
                     .' $("#' . $this->getSId() . ' tbody .selected").each(function(){ '
                     .'  var chaveRet = $(this).find(".consultaCampo").html(); '
                     . '$("#' . $this->getSId() . 'form").remove();'
                    . '$("#' . $this->getSCampoRetorno() . '").val(chaveRet);'
                    . '$("#' . $this->getSRenderHide() . '").toggle();'
                    . '$("#' . $this->getSCampoRetorno() . '").focus();'
                    . '$("#' . $this->getSCampoRetorno() . '").blur();'
                     .'                  }); '
                     .'               } '
                     .'             });';
            $sEventoRetorno.=$sEnter;
        }
        //monta string duplo clique
        $dbClick = '';
        if (!$this->getBConsulta()) {
            $dbClick = ' $("#' . $this->getSId() . ' tbody").on("dblclick", "tr", function () {'
                    . '$("#' . $sAlterarId . '").prop("disabled", false);'
                    . '$(this).removeClass("selected");'
                    . '$(this).addClass("selected");'
                    . '$("#' . $sAlterarId . '").click();'
                    . '} );';
        }
        //monta evento click
        $Click = "";
        if ($this->getSEventoClick() !== NULL) {
            $Click = ' $("#' . $this->getSId() . ' tbody").on("click", "tr", function () {'
                    . $this->getSEventoClick()
                    . '} );';
            }
            
        //monta evento setas no teclado
        $sSetas =  '$("#' . $this->getSId() . ' tbody tr" ).keydown(function(e) { '
                                  .'if(e.which == 40) {   '
                                  .'     $(this).removeClass("selected"); '
                                  .'     $(this).next().focus(); '
                                  .'     $(this).next().addClass("selected");'
                                  .'  } else if(e.which == 38) {  '
                                  .'      $(this).removeClass("selected"); '                                       
                                  .'      $(this).prev().focus(); '                                      
                                  .'      $(this).prev().addClass("selected"); ' 
                                  .'  } '
                                  .'});';
                 
        //evento de scroll
        //se marcado para nao usar scroll nao entra
        if ($this->getBNaoUsaScroll() !== true) {
            $scroll = '';
            if ($this->getBScrollInf()) {
                $scroll = '$("#' . $this->getSId() . 'resize .dataTables_scrollBody").on("scroll", function() {'
                        . ' if($(this).scrollTop() + $(this).innerHeight() >=$(this)[0].scrollHeight) { '
                        . 'var lastreg = $("#' . $this->getSId() . ' tr:last" ).find(".chave").html(); '
                        . 'sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '",true,lastreg,"");'
                        . ' } '
                        . ' });';
            }

            if ($this->getSScrollInfCampo() !== null) {
                $scroll = '$("#' . $this->getSId() . 'resize .dataTables_scrollBody").on("scroll", function() {'
                        . ' if($(this).scrollTop() + $(this).innerHeight() >=$(this)[0].scrollHeight) { '
                        . 'var lastreg = $("#' . $this->getSId() . ' tr:last" ).find(".chave").html(); '
                        . 'sendFiltros("#' . $this->getSId() . '-filtros","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '",true,lastreg,"' . $this->getSScrollInfCampo() . '");'
                        . ' } '
                        . ' });';
            }
            if ($this->getBScrollInfTelaGrid()) {
                $scroll = '';
                $scroll = '$("#' . $this->getSId() . 'resize .dataTables_scrollBody").on("scroll", function() {'
                        . ' if($(this).scrollTop() + $(this).innerHeight() >=$(this)[0].scrollHeight) { '
                        . 'var lastreg = $("#' . $this->getSId() . ' tr:last" ).find(".chave").html(); '
                        . 'sendFiltros("#' . $this->getSIdTelaGrid() . '","' . $this->getController() . '","' . $this->getSId() . '","' . $this->getSCampoConsulta() . '",true,lastreg,"' . $this->getSScrollInfCampo() . '");'
                        . ' } '
                        . ' });';
            }
        }

        //renderiza campos abaixo do grid
        //renderiza os campos
        //$sConteudo = $this->oLayout->getRender();
        //$sGrid.=$sConteudo;
        $sGrid .= '<script>$("#' . $this->getSId() . '").DataTable( {'
                . '"scrollY": ' . $this->getIAltura() . ','
                . '"scrollX": true,'
                . '"searching": false,'
                . '"select": true,'
                . '"paging":         false,'
                . '"order":false,'
                . '"info": false,'
                . ' fixedColumns:   {'
                . '      leftColumns: 2'
                . '  },'
                . 'columnDefs: [ {'
                . 'orderable: false,'
                . 'className: "select-checkbox",'
                . 'targets:   0'
                . '} ],'
                . 'select: {'
                . 'style:    "os",'
                . 'selector: "td:first-child"'
                . '}'
                . '} );'
                . 'var pressedCtrl = false;'
                . '$(document).keydown(function (e) {'
                . 'if(e.which == 17) {'
                . 'pressedCtrl = true;'
                . '}'
                . '});'
                . '$("#' . $this->getSId() . ' tbody").on( "click", "tr", function () {'
                . 'var tr = $("#' . $this->getSId() . ' tr");'
                . 'if(pressedCtrl !=true){'
                . 'var self = this;'
                . '     tr.each(function(){'
                . '        if(this == self) $(this).toggleClass("selected");'
                . '        else $(this).removeClass("selected");'
                . '     });'
                . ' }else'
                . ' {'
                . '     $(this).toggleClass("selected");'
                . ' }'
                . '} );'
                . '$(document).keyup(function(e){'
                . 'pressedCtrl = false;'
                . '});'
                . $sEventos
                . $dbClick
                . $Click
                . $sSetas

                //desabilita botão alterar e remover
                . '$("#' . $this->getSId() . ' tbody").click(function(){'
                . 'var count = 0;'
                . '$("#' . $sAlterarId . '").prop("disabled", true);'
                . '$("#' . $sRemoverId . '").prop("disabled", true);'
                . '$("#' . $sVizualizar . '").prop("disabled", true);'
                . '$("#' . $this->getSId() . ' tbody .selected").each(function(){'
                . 'count ++;'
                . 'if(count > 1){'
                . '$("#' . $sAlterarId . '").prop("disabled", true);'
                . '$("#' . $sRemoverId . '").prop("disabled", true);'
                . '$("#' . $sVizualizar . '").prop("disabled", true);'
                . '} else {'
                . '$("#' . $sAlterarId . '").prop("disabled", false);'
                . '$("#' . $sRemoverId . '").prop("disabled", false);'
                . '$("#' . $sVizualizar . '").prop("disabled", false);'
                . '}'
                . '});'
                . '});';
        if ($this->getBConsulta()) {
            $sGrid .= '$("#' . $this->getSId() . 'formclose").click(function(){$("#' . $this->getSId() . 'form").remove();'
                    . '$("#' . $this->getSRenderHide() . '").toggle();});';
            $sGrid .= $sEventoRetorno;
        }
        $sGrid .= $scroll;
        $sGrid .= '</script>';


        if ($this->getBDetalhte()) {
            return $sGrid;
        } else {
            $sRetorno = "$('#" . $this->getSRenderTo() . "control').append('" . $sGrid . "');";

            echo $sRetorno;

            $fp = fopen("bloco1.txt", "w");
            fwrite($fp, $sRetorno);
            fclose($fp);
        }
        //gera resize
        echo "$( '#" . $this->getSId() . "resize' ).removeClass('col-lg-12').addClass('col-lg-5');";
        echo "$( '#" . $this->getSId() . "resize' ).removeClass('col-lg-5').addClass('col-lg-12');";
    }

}
