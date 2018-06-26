<?php
/**
 * Classe que implementa a estrutura PivotGrid do ExtJs
 *
 * @author Fernando Salla
 * @since 19/11/2014
 */

//inclusуo da classe Store
Fabrica::requireBibliotecaVisual('Store');

class Cubo {
    private $sId; //id
    private $sTitulo; //title
    private $bPermiteFechar; //closable
    private $bPermiteArrastar; //draggable
    private $bPermiteRedimensionar; //resizable
    private $bPermiteRecolher; //collapsible
    private $iAltura; //height
    private $iLargura; //width
    private $aFields; //store
    private $aAgregadores;
    private $aLinhas;
    private $aColunas;
    private $sRenderTo; //renderTo
    private $aBotoes; //buttons
    private $aListener; //listeners
    private $aOrigemDados;
    private $sStyle; //style
    private $oStore;
    private $bPermiteConfigurar;
    private $bPermiteExportarExcel;
    
    
    //ver
    private $bAdicionaFiltrosColunas;
    private $bAdicionaFiltros;
    
    /**
     * Construtor da classe Grid 
     * 
     * O њnico parтmetro obrigatѓrio refere-se ao tэtulo da consulta
     * 
     * @param string $sTitulo Tэtulo da tela
     * @param integer $iAltura Altura da tela
     * @param integer $iLargura Largura da tela
     * @param bollean $bPermiteFechar Controla se a tela permitirс fechamento ou nуo
     * @param bollean $bPermiteArrastar Controla se a tela permitirс que seja arrastada ou nуo
     * @param bollean $bPermiteRedimensionar Controla se a tela permitirс redimensionamento ou nуo
     */
    function __construct($sTitulo, 
                         $iAltura = 100, 
                         $iLargura = 100, 
                         $bPermiteFechar = true, 
                         $bPermiteArrastar = true, 
                         $bPermiteRedimensionar = false, 
                         $bPermiteRecolher = false) {
        $this->sId = Base::getId();
        $this->setTitulo($sTitulo);
        $this->setAltura($iAltura);
        $this->setLargura($iLargura);
        $this->setPermiteFechar($bPermiteFechar);
        $this->setPermiteArrastar($bPermiteArrastar);
        $this->setPermiteRedimensionar($bPermiteRedimensionar);
        $this->setPermiteRecolher($bPermiteRecolher);
        $this->setPermiteConfigurar(true);
        $this->setPermiteExportarExcel(true);
        
        $this->setAdicionaFiltrosColunas(true);
        $this->setAdicionaFiltros(true);
        
        $this->aAgregadores = array();
        $this->aFields = array();
        $this->aLinhas = array();
        $this->aColunas = array();
        $this->aBotoes = array();
        $this->aListener = array();
        
        $this->oStore = new Store($this->getId());
    }
    
    /**
     * Retorna o conteњdo do atributo sId
     * 
     * @return string
     */
    public function getId() {
        return $this->sId;
    }
    
    /**
     * Retorna o conteњdo do atributo sTitulo
     * 
     * @return string
     */
    private function getTitulo() {
        return $this->sTitulo;
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
     * Retorna o conteњdo do atributo bPermiteFechar
     * 
     * @return boolean
     */
    private function getPermiteFechar() {
        return $this->bPermiteFechar;
    }

    /**
     * Define o valor do atributo bPermiteFechar
     * 
     * @param boolean $bPermiteFechar 
     */
    public function setPermiteFechar($bPermiteFechar) {
        $this->bPermiteFechar = $bPermiteFechar;
    }

    /**
     * Retorna o conteњdo do atributo bPermiteArrastar
     * 
     * @return boolean
     */
    private function getPermiteArrastar() {
        return $this->bPermiteArrastar;
    }

    /**
     * Define o valor do atributo bPermiteArrastar
     * 
     * @param boolean $bPermiteArrastar 
     */
    public function setPermiteArrastar($bPermiteArrastar) {
        $this->bPermiteArrastar = $bPermiteArrastar;
    }

    /**
     * Retorna o conteњdo do atributo bPermiteRedimensionar
     * 
     * @return boolean
     */
    private function getPermiteRedimensionar() {
        return $this->bPermiteRedimensionar;
    }

    /**
     * Define o valor do atributo bPermiteRedimensionar
     * 
     * @param boolean $bPermiteRedimensionar 
     */
    public function setPermiteRedimensionar($bPermiteRedimensionar) {
        $this->bPermiteRedimensionar = $bPermiteRedimensionar;
    }
    
    /**
     * Retorna o conteњdo do atributo bPermiteRecolher
     * 
     * @return boolean
     */
    private function getPermiteRecolher() {
        return $this->bPermiteRecolher;
    }

    /**
     * Define o valor do atributo bPermiteRecolher
     * 
     * @param boolean $bPermiteRecolher
     */
    public function setPermiteRecolher($bPermiteRecolher) {
        $this->bPermiteRecolher = $bPermiteRecolher;
    }
    
    /**
     * Retorna o conteњdo do atributo bPermiteConfigurar
     * 
     * @return boolean
     */
    private function getPermiteConfigurar() {
        return $this->bPermiteConfigurar;
    }

    /**
     * Define o valor do atributo bPermiteConfigurar
     * 
     * @param boolean $bPermiteConfigurar
     */
    public function setPermiteConfigurar($bPermiteConfigurar) {
        $this->bPermiteConfigurar = $bPermiteConfigurar;
    }
    
    /**
     * Retorna o conteњdo do atributo bPermiteExportarExcel
     * 
     * @return boolean
     */
    private function getPermiteExportarExcel() {
        return $this->bPermiteExportarExcel;
    }

    /**
     * Define o valor do atributo bPermiteExportarExcel
     * 
     * @param boolean $bPermiteExportarExcel
     */
    public function setPermiteExportarExcel($bPermiteExportarExcel) {
        $this->bPermiteExportarExcel = $bPermiteExportarExcel;
    }
    
    /**
     * Retorna o conteњdo do atributo iAltura
     * 
     * @return integer
     */
    private function getAltura() {
        return $this->iAltura;
    }

    /**
     * Define o valor do atributo iAltura
     * 
     * @param integer $iAltura 
     */
    public function setAltura($iAltura) {
        $this->iAltura = $iAltura;
    }
    
    /**
     * Retorna o conteњdo do atributo iLargura
     * 
     * @return integer
     */
    private function getLargura() {
        return $this->iLargura;
    }

    /**
     * Define o valor do atributo iLargura
     * 
     * @param integer $iLargura 
     */
    public function setLargura($iLargura) {
        $this->iLargura = $iLargura;
    }

    /**
     * Retorna o conteњdo do vetor de botѕes na estrutura que 
     * deverс ser renderizado
     * 
     * @return string
     */     
    private function getBotoes() {
        $sBotoes = '[';
        foreach ($this->aBotoes as $key => $value) {
            if($key > 0){
                $sBotoes .= ', ';
            }
            $sBotoes .= '{'.$value->getRender().'}';
        }
        $sBotoes .= ']';
        
        return $sBotoes;
    }

    /**
     * Adiciona um botуo ao vetor de botѕes do objeto
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
     * Retorna o conteњdo do atributo bAdicionaFiltrosColunas
     * 
     * @return boolean
     */
    private function getAdicionaFiltrosColunas() {
        return $this->bAdicionaFiltrosColunas;
    }

    /**
     * Define o valor do atributo bAdicionaFiltrosColunas
     * Em caso de valor falso os filtros nas colunas da consulta nуo serуo 
     * adicionados
     * 
     * @param boolean $bAdicionaFiltrosColunas
     */
    public function setAdicionaFiltrosColunas($bAdicionaFiltrosColunas) {
        $this->bAdicionaFiltrosColunas = $bAdicionaFiltrosColunas;
    }
    
    /**
     * Retorna o conteњdo do atributo bAdicionaFiltros
     * 
     * @return boolean
     */
    private function getAdicionaFiltros() {
        return $this->bAdicionaFiltros;
    }

    /**
     * Define o valor do atributo bAdicionaFiltros
     * Em caso de valor falso os filtros no topo da consulta nуo serуo 
     * adicionados
     * 
     * @param boolean $bAdicionaFiltros
     */
    public function setAdicionaFiltros($bAdicionaFiltros) {
        $this->bAdicionaFiltros = $bAdicionaFiltros;
    }
    
    /**
     * Retorna o conteњdo dos listeners (observadores) da tela
     * 
     * @return string
     */
    private function getListeners() {
        $sListeners = '';
        
        foreach($this->aListener as $key => $aAtual) {
            if($key > 0){
                $sListeners .= ', ';
            }
            $sListeners .= $aAtual[0].": function(".$aAtual[2]."){".$aAtual[1]."}";
        }
        
        return count($this->aListener) > 0 ? '{'.$sListeners.'}' : null;
    }    

    /**
     * Adiciona itens ao vetor de listener
     * 
     * @param string $sAcao Nome da aчуo
     * @param string $sFuncao Funчуo a ser executada 
     * @param string $sParams Parтmetros a serem adicionados na funчуo (string separada por vэrgulas)
     */     
    public function addListener($sAcao,$sFuncao,$sParams=null) {
        /*
         * Se a aчуo desejada jс existe na lista apenas adiciona a operaчуo,
         * senуo cria uma nova aчуo
         */
        $bExiste = false;
        foreach($this->aListener as $key => $aAtual) {
            if($aAtual[0] === $sAcao){
                $this->aListener[$key][1] .= $sFuncao; 
                $this->aListener[$key][2] .= $sParams; 
                $bExiste = true;
                break;
            }
        }
        
        if(!$bExiste){
            $this->aListener[] = array($sAcao,$sFuncao,$sParams);
        }
    }    
    
    /**
     * Retorna o conteњdo das сreas dos componentes adicionais que devem ser
     * renderizados
     * 
     * @return string
     */     
    private function getDockedItems() {
        $sDocked = "[";
        
        //verifica se deve adicionar os botѕes de filtros
        //if($this->getAdicionaFiltros()){
            //$sDocked .= $this->getFiltros();
        //}
        
        //verifica se deve adicionar os botѕes de aчѕes
        $sDocked .= $this->getAcoes();
        
        $sDocked .= "]";
        
        return $sDocked;
    } 
    
    /**
     * Retorna o conteњdo da сrea dos botѕes que deverс ser renderizado
     * 
     * @return string
     */     
    private function getAcoes() {
        $sAcoes = "{"
                ."xtype: 'toolbar',"
                ."dock: 'top',"
                ."items: ".$this->getBotoes()
            ."}";
        return $sAcoes;
    }
    
    /**
     * Retorna o conteњdo da сrea dos filtros superiores que deverс ser renderizado
     * 
     * @return string
     */     
    private function getFiltros() {
        $sFields = "";
        
        foreach($this->getArrayCampos() as $key => $value) {
            if(!$value->getOculta() && $value->getPermiteOcultar() != false){
                if($key > 0){
                    $sFields .= ",";
                }

                $sFields .= $value->getFiltro();
            }
        }
        
        //cria e adiciona o botуo com a aчao de limpar o filtro
        $sAcaoClear = $this->getAcaoBtnClearFiltroFixo();
        
        $oBtnClear = new Botao("Limpar Filtros",$sAcaoClear); 
        $oBtnClear->setIcone(Base::ICON_FILTER_CLEAR);
        
        //cria e adiciona o botуo com a aчao de filtrar
        $sAcaoFiltro = $this->getAcaoBtnFiltroFixo();
                   
        $oBtnFiltro = new Botao("Filtrar",$sAcaoFiltro); 
        $oBtnFiltro->setIcone(Base::ICON_FILTER);
        
        $sCampos = $this->getFiltroFixo($sFields);
        
        $sFiltros = "{"
            ."xtype: 'toolbar',"
            ."dock: 'top',"
            ."items: [{"
                .$sCampos
            ."},{"
                .$oBtnFiltro->getRender()
            ."},{"
                ."xtype: 'filterbutton',"
                ."store: 'store-".$this->getId()."',"
                ."fields: [".$sFields."]"
            ."},{"
                .$oBtnClear->getRender()
            ."}]"
        ."}";
        
        return $sFiltros;
    }
    
    /**
     * Mщtodo que monta e retorna a aчуo responsсvel por limpar os filtos
     * fixos presentes no topo da consulta
     * 
     * @return string
     */
    private function getAcaoBtnClearFiltroFixo(){
        $sAcao = "var store = Ext.StoreManager.lookup('store-".$this->getId()."');"
                ."store.getProxy().extraParams = {};"
                ."store.load();";
        
        return $sAcao;
    }
    
    /**
     * Mщtodo que monta e retorna a aчуo responsсvel por executar os filtos
     * fixos presentes no topo da consulta
     * 
     * @return string
     */
    private function getAcaoBtnFiltroFixo(){
        $sAcao = "var store = Ext.StoreManager.lookup('store-".$this->getId()."');"
                ."var cpoCampo = Ext.ComponentQuery.query('#field-filter-".$this->getId()."')[0];"
                ."var rec = cpoCampo.getStore().findRecord(cpoCampo.valueField,cpoCampo.getValue());"
                ."if(rec){"
                   ."var args = [];"
                   ."var tipo = rec.get('type');"
                   ."switch(tipo){"
                      ."case 'string':"
                      ."case 'numeric':"
                         ."var valor = Ext.ComponentQuery.query('#value-ini-filter-".$this->getId()."')[0].getValue();"
                         ."if(valor != null && valor != ''){"
                            ."args.push({"
                                ."type: tipo,"
                                ."field: rec.get('value'),"
                                ."comparison: Ext.ComponentQuery.query('#comparison-filter-".$this->getId()."')[0].getValue(),"
                                ."value: valor"
                            ."});"
                         ."}"
                      ."break;"
                      ."case 'date': console.log(Ext.ComponentQuery.query('#value-ini-filter-".$this->getId()."')[0]);"
                         ."var valor = Ext.ComponentQuery.query('#value-ini-filter-".$this->getId()."')[0].getValue();"
                         ."if(valor != null){"
                            ."args.push({"
                                ."type: tipo,"
                                ."field: rec.get('value'),"
                                ."comparison: 'ge',"
                                ."value: valor"
                            ."});"
                         ."}"
                         ."valor = Ext.ComponentQuery.query('#value-fim-filter-".$this->getId()."')[0].getValue();"
                         ."if(valor != null){"
                            ."args.push({"
                                ."type: tipo,"
                                ."field: rec.get('value'),"
                                ."comparison: 'le',"
                                ."value: valor"
                            ."});"
                         ."}"
                      ."break;"
                      ."case 'list':"
                         ."var valor = Ext.ComponentQuery.query('#value-ini-filter-".$this->getId()."')[0].getValue();"
                         ."if(valor != null && valor != ''){"
                            ."args.push({"
                                ."type: tipo,"
                                ."field: rec.get('value'),"
                                ."comparison: 'in',"
                                ."value: valor"
                            ."});"
                         ."}"
                      ."break;"
                   ."}"
                   ."store.getProxy().extraParams = {};"
                   ."store.getProxy().extraParams.filterbar = Ext.encode(args);"
                   ."store.load();"
                ."}";
        return $sAcao;
    }
    
    /**
     * Retorna o conteњdo da сrea do filtro fixo na coluna
     * 
     * @param string $sCampos String com os campos possэveis de serem filtrados
     * 
     * @return string
     */
    private function getFiltroFixo($sCampos){
        $sLinhaFiltro = 
            "fieldLabel: 'Campo',"
           ."xtype: 'combobox',"
           ."itemId: 'field-filter-".$this->getId()."',"
           ."labelWidth: 45,"
           ."inputWidth: 120,"
           ."queryMode: 'local',"
           ."store: Ext.create('Ext.data.Store', {"
              ."fields: ['name', 'type', 'value', 'options'],"
              ."data: [".$sCampos."]"
           ."}),"
           ."valueField: 'value',"
           ."displayField: 'name',"
           ."allowBlank: false,"
           ."editable: false,"
           ."forceSelection: true,"
           ."listeners:{"
              ."select: function (c,r,index){"
                 //carrega o tipo do campo selecionado
                 ."var tipo = r[0].data.type != '' ? r[0].data.type : 'string';"

                 //caputura o objeto da toolbar
                 ."var toolbar = this.up('toolbar');"
               
                 //remove os campos de comparaчуo, valor inicial e final caso existam anteriormente
                 ."var comparisonField = Ext.ComponentQuery.query('#comparison-filter-".$this->getId()."')[0];"
                 ."if(comparisonField){"
                    ."toolbar.remove(comparisonField);"
                 ."}"
                 ."var valueFieldIni = Ext.ComponentQuery.query('#value-ini-filter-".$this->getId()."')[0];"
                 ."if(valueFieldIni){"
                    ."toolbar.remove(valueFieldIni);"
                 ."}"
                 ."var valueFieldFim = Ext.ComponentQuery.query('#value-fim-filter-".$this->getId()."')[0];"
                 ."if(valueFieldFim){"
                    ."toolbar.remove(valueFieldFim);"
                 ."}"
                
                 //adiciona os novos campos para o filtro conforme tipo do campo selecionado 
                 ."switch (tipo){"
                    ."case 'list':"
                        ."var store = Ext.create('Ext.data.Store', {"
                            ."fields: ['conteudo','valor'],"
                            ."data: r[0].data.options"
                        ."});"
                                
                        ."toolbar.insert(1,{"
                            ."xtype: 'boxselect',"
                            ."itemId: 'value-ini-filter-".$this->getId()."',"
                            ."fieldLabel: 'Valor',"
                            ."displayField: 'conteudo',"
                            ."valueField: 'valor',"
                            ."inputWidth: 350,"
                            ."labelWidth: 35,"
                            ."emptyText: 'Selecione os valores desejados',"
                            ."pinList: false,"
                            ."filterPickList: true,"
                            ."triggerOnClick: false,"
                            ."store: store"
                        ."});"
                    ."break;"    
                    ."case 'date':"
                        ."toolbar.insert(1,{"
                            ."itemId: 'value-ini-filter-".$this->getId()."',"
                            ."xtype: 'datefield'," 
                            ."labelWidth: 35,"
                            ."inputWidth: 110,"
                            ."fieldLabel: 'Inэcio',"
                            ."format: 'd/m/Y',"
                            ."altFormats: 'dmY|d/m/Y|Y-m-d',"
                            ."submitFormat: 'Y-m-d'"
                        ."});"

                        ."toolbar.insert(2,{"
                            ."itemId: 'value-fim-filter-".$this->getId()."',"
                            ."xtype: 'datefield'," 
                            ."labelWidth: 25,"
                            ."inputWidth: 110,"
                            ."fieldLabel: 'Fim',"
                            ."format: 'd/m/Y',"
                            ."altFormats: 'dmY|d/m/Y|Y-m-d',"
                            ."submitFormat: 'Y-m-d'"
                        ."});"
                    ."break;"
                    ."case 'numeric':"
                        ."var data = ["
                            ."{valor: 'eq', conteudo: 'Igual'},"
                            ."{valor: 'lt', conteudo: 'Menor'},"
                            ."{valor: 'le', conteudo: 'Menor ou Igual'},"
                            ."{valor: 'gt', conteudo: 'Maior'},"
                            ."{valor: 'ge', conteudo: 'Maior ou Igual'}"
                        ."];"
                    ."break;"
                    ."case 'string':"
                        ."var data = ["
                            ."{valor: 'eq', conteudo: 'Igual'},"
                            ."{valor: 'cn', conteudo: 'Contъm'},"
                            ."{valor: 'sw', conteudo: 'Inicia com'},"
                            ."{valor: 'ew', conteudo: 'Termina com'}"
                        ."];"
                    ."break;"
                 ."}"
                 ."if(tipo == 'string' || tipo == 'numeric'){"
                    //campo de comparaчуo
                    ."var comparison = {"
                        ."xtype: 'combo',"
                        ."itemId: 'comparison-filter-".$this->getId()."',"
                        ."hidden: tipo == 'string' || tipo == 'numeric' ? false : true,"
                        ."mode: 'local',"
                        ."triggerAction: 'all',"
                        ."store: Ext.create('Ext.data.Store', {"
                            ."fields: ['valor', 'conteudo'],"
                            ."data: data"
                        ."}),"
                        ."valueField: 'valor',"
                        ."displayField: 'conteudo',"
                        ."hideLabel: true,"
                        ."editable: false,"
                        ."forceSelection: true,"
                        ."inputWidth: 125,"
                        ."listeners:{"
                            ."render: function(el){"
                                ."if(el.getStore().getAt(0)){"
                                    ."el.setValue(el.getStore().getAt(0).get('valor'));"
                                ."}"
                            ."}"
                        ."}"
                    ."};"
                    ."toolbar.insert(1,comparison);"
                    
                    //cria o campo do valor
                    ."var field = { };"
                    ."Ext.apply(field, {"
                        ."itemId: 'value-ini-filter-".$this->getId()."',"
                        ."xtype: tipo == 'numeric' ? 'numberfield' : 'textfield',"
                        ."fieldLabel: 'Valor',"
                        ."inputWidth: 220,"
                        ."allowBlank: false,"
                        ."labelWidth: 35"
                    ."});"
                    ."toolbar.insert(2,field);"
                 ."}"
              ."}"
           ."}";
        
        return $sLinhaFiltro;
    }

    /**
     * Retorna o conteњdo para que seja possэvel realizar filtros nas colunas
     * 
     * @return string
     */     
    private function getFiltrosColunas() {
        $sNome = 'filters';
        
        $sFiltros = "{ id: '".$sNome."',"
                     ."ftype: '".$sNome."',"
                     ."encode: true"
                   ."}";
        
        return $sFiltros;
    } 
    
    /**
     * Retorna o conteњdo das сreas dos componentes adicionais que devem ser
     * renderizados
     * 
     * @return string
     */     
    private function getFeatures(){
        $sFeatures = "";
        
        //verifica se deve adicionar os filtros do topo da consulta
        if($this->getAdicionaFiltrosColunas()){
            $sFeatures .= $this->getFiltrosColunas();
        }
        
        //verifica se existe agrupamento definido na consulta
        if($this->getAgrupamento() != null){
            $sFeatures = Base::addComma($sFeatures);
            $sFeatures .= $this->getStringAgrupamento();
        }
        
        return $sFeatures != "" ? "[".$sFeatures."]" : null;
    }

    /**
     * Define a origem de dados da consulta
     * Mѓdulo, classe e mщtodo
     * 
     * @param string $sClasse
     * @param string $sMetodo
     */
    public function setOrigemDados($sClasse,$sMetodo,$sParametros=null) {
        $this->aOrigemDados[0] = $sClasse;
        $this->aOrigemDados[1] = $sMetodo;
        $this->aOrigemDados[2] = $sParametros;
    }    
    
    /**
     * Retorna o objeto store
     * 
     * @return object
     */
    public function getStore(){
        return $this->oStore;
    }
    
    /**
     * Retorna o conteњdo a ser renderizado do objeto responsсvel pelo
     * carregamento dos dados
     * 
     * @return string
     */     
    private function getRenderStore() {
        $oProxy = $this->getStore()->getProxy();
        
        $oProxy->setTipo(Proxy::AJAX);
        $oProxy->setUrlRead($this->aOrigemDados[0],$this->aOrigemDados[1],$this->aOrigemDados[2]);

        $this->getStore()->setCampos($this->getCampos());
        $this->getStore()->setAutoLoad(0);
        
        return $this->getStore()->getRender();
    }

    /**
     * Adiciona itens ao vetor de fields do objeto
     * 
     * @param object $oItem 
     */     
    public function addCampos() {
        $aFields = func_get_args();
        
        foreach ($aFields as $oField) {
            $this->aFields[] = $oField;
        }
    }
    
    /**
     * Retorna o array de campos 
     * 
     * @return Array
     */
    public function getCampos(){
        return $this->aFields;
    }  
    
    /**
     * Adiciona itens ao vetor de agregadores do objeto para definir os
     * totalizadores que serуo exibidos inicialmente no cubo
     * 
     * @param object $oItem 
     */   
    public function addAgregadores() {
        $aFields = func_get_args();
        
        foreach ($aFields as $oField) {
            $this->aAgregadores[] = $oField;
        }
    }
    
    /**
     * Retorna o array contendo os agregadores iniciais do cubo
     * 
     * @return Array
     */
    public function getAgregadores(){
        return $this->aAgregadores;
    }   
    
    /**
     * Adiciona itens ao vetor de linhas do objeto para definir as linhas
     * que serуo exibidas inicialmente no cubo
     * 
     * @param object $oItem 
     */     
    public function addLinhas() {
        $aFields = func_get_args();
        
        foreach ($aFields as $oField) {
            $this->aLinhas[] = $oField;
        }
    }
    
    /**
     * Retorna o array contendo as linhas iniciais do cubo
     * 
     * @return Array
     */
    public function getLinhas(){
        return $this->aLinhas;
    }   
    
    /**
     * Adiciona itens ao vetor de colunas do objeto para definir as colunas
     * que serуo exibidas inicialmente no cubo
     * 
     * @param object $oItem 
     */     
    public function addColunas() {
        $aFields = func_get_args();
        
        foreach ($aFields as $oField) {
            $this->aColunas[] = $oField;
        }
    }
    
    /**
     * Retorna o array contendo as colunas iniciais do cubo
     * 
     * @return Array
     */
    public function getColunas(){
        return $this->aColunas;
    }  
    
    /**
     * Retorna o conteњdo do atributo sRenderTo
     * 
     * @return string
     */
    public function getRenderTo() {
        return $this->sRenderTo;
    }

    /**
     * Define o valor do atributo sRenderTo, referente ao ID do
     * objeto onde a tela deve ser renderizada
     * 
     * @param string $sRenderTo 
     */
    public function setRenderTo($sRenderTo) {
        $this->sRenderTo = $sRenderTo;
    }   
    
    /**
     * Retorna o conteњdo do atributo sStyle
     * 
     * @return string
     */
    private function getStyle() {
        return $this->sStyle;
    }

    /**
     * Define o valor do atributo sSyle
     * 
     * @param string $sStyle 
     */
    public function setStyle($sStyle) {
        $this->sStyle = $sStyle;
    }
    
    /**
     * Mщtodo que permite configurar alguns elementos visuais do grid
     */
    public function getViewConfig(){
        $sRetorno  = "{";
        
        //padrуo em todas as consultas (podem ser criadas configuraчѕes futuramente
        $sRetorno .= "loadingText: 'Carregando consulta...',"
                    ."enableTextSelection: true,"
                    ."trackOver: true,"
                    ."stripeRows: false";
        
        return $sRetorno .= "}";
    }
    
    /**
     * Retorna o conteњdo a ser renderizado do objeto responsсvel pelos
     * agregadores dos dados do cubo
     * 
     * @return string
     */     
    public function getRenderAgregadores(){
        $sAgregadores = null;
        
        foreach ($this->getAgregadores() as $key => $value) {
            if($key > 0){
                $sAgregadores .= ",";
            }
            $sAgregadores .= "{".$value->getRenderAgregador()."}";
        }
        return $sAgregadores != "" ? "[".$sAgregadores."]" : $sAgregadores;
    }
    
    /**
     * Retorna o conteњdo a ser renderizado do objeto responsсvel pelas linhas
     * iniciais apresentadas no cubo
     * 
     * @return string
     */     
    public function getRenderLinhas(){
        $sLinhas = null;
        
        foreach($this->getLinhas() as $key => $value) {
            if($key > 0){
                $sLinhas .= ",";
            }
            $sLinhas .= "{".$value->getRenderAgregador()."}";
        }
        return $sLinhas != "" ? "[".$sLinhas."]" : $sLinhas;
    }
    
    /**
     * Retorna o conteњdo a ser renderizado do objeto responsсvel pelas colunas
     * iniciais apresentadas no cubo
     * 
     * @return string
     */     
    public function getRenderColunas(){
        $sColunas = null;
        
        foreach ($this->getColunas() as $key => $value) {
            if($key > 0){
                $sColunas .= ",";
            }
            $sColunas .= "{".$value->getRenderAgregador()."}";
        }
        return $sColunas != "" ? "[".$sColunas."]" : $sColunas;
    }
    
    /**
     * Mщtodo que verifica a adiчуo de plugins adicionais e retorna a string
     * correspondente
     * 
     * @return string
     */
    public function getPlugins(){
        $sPlugins = "";
        
        if($this->getPermiteConfigurar()){
            $sPlugins .= "{ptype: 'mzconfigurator'}";
        }
        
        if($this->getPermiteExportarExcel()){
            $sPlugins = Base::addComma($sPlugins);
            $sPlugins .= "excelExport";
        }
        
        return $sPlugins != "" ? "[".$sPlugins."]" : $sPlugins;
    }
    
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        //Adiciona a funcionalidade que indica que serс possэvel arrastar o grid
        if($this->getPermiteArrastar()){
            $sFuncao = Base::getFuncaoLimitaArrasto($this->getId(),$this->getRenderTo());
            $this->addListener(Base::EVENTO_MONTAR, $sFuncao);
        }
        
        $sPluginExcel = "";
        //verifica se deve adicionar os botѕes de aчѕes
        if($this->getPermiteExportarExcel()){
            $sAcao = "var file = excelExport.getExcelData(true);"
                    ."var a = document.createElement('a');"
                    ."a.setAttribute('download', '".$this->getTitulo()."-".date('Y-m-d H:i:s').".xls');"
                    ."a.href = 'data:application/vnd.ms-excel;base64,'+Base64.encode(file);"
                    ."a.style.display = 'none';"
                    ."document.body.appendChild(a);"
                    ."a.click();"
                    ."a.remove();";
                    
            $oBtnExcel = new Botao("Exportar para Excel",$sAcao);        
            $oBtnExcel->setIcone(Base::ICON_EXCEL);
            
            $this->addBotoes($oBtnExcel);
            
            $sPluginExcel = "var excelExport = Ext.create('Mz.pivot.plugin.ExcelExport', {"
                        ."title: '".$this->getTitulo()."'"
                     ."});";
        }
        
        $aRender = array(
            "frame" => false,
            "iconCls" => 'icon-grid',
            "loadMask" => true,
            "id" => $this->getId(),
            "title" => $this->getTitulo(),
            "closable" => $this->getPermiteFechar(),
            "resizable" => $this->getPermiteRedimensionar(),
            "draggable" => $this->getPermiteArrastar(),
            "collapsible" => $this->getPermiteRecolher(),
            "style" => $this->getStyle(),
            "height" => $this->getAltura(),
            "width" => $this->getLargura(),
            "store" => $this->getRenderStore(),
            "viewConfig" => $this->getViewConfig(),
            "aggregate" => $this->getRenderAgregadores(),
            "leftAxis" => $this->getRenderLinhas(),
            "topAxis" => $this->getRenderColunas(),
            "plugins" => $this->getPlugins(),
            "listeners" => $this->getListeners(),
            "dockedItems" => $this->getDockedItems()
            //"features" => $this->getFeatures()
        );
        
        $oCubo = "Ext.create('Mz.pivot.Grid', {".Base::getRender($aRender)."})";
        
        return $sPluginExcel.Base::addObj($oCubo,$this->getRenderTo());
    }
}
        
?>