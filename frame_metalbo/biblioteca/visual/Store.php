<?php
/**
 * Classe que implementa a estrutura Store do ExtJs
 *
 * @author Fernando Salla
 * @since 15/03/2013
 */

//inclusão da classe Proxy
Fabrica::requireBibliotecaVisual('Proxy');

class Store {
    private $sId; //storeId
    private $sIdContainer;
    private $aListener; //listeners
    private $oProxy;
    private $aCampos; //fields
    private $aDados; //data
    private $aAutoLoad; //autoLoad
    private $iLinhasPagina; //pageSize
    private $sAgrupamento; //groupField
    private $bIniciaFechada;
    
    /**
     * Contrutor da classe Store
     * 
     * @param string $sId Id a ser atribuída ao store
     */
    public function __construct($sId) {
        $this->setId($sId);
        
        $this->aCampos = array();
        $this->aDados = array();
        $this->aAutoLoad = array();
        $this->aListener = array();
        
        $this->oProxy = new Proxy();
    }
    
    /**
     * Retorna o conteúdo do atributo sId
     * 
     * @return string
     */
    public function getId() {
        return $this->sId;
    }
    
    /**
     * Retorna o conteúdo do atributo sIdContainer
     * Identificador do objeto que contêm a store
     * 
     * @return string
     */
    public function getIdContainer() {
        return $this->sIdContainer;
    }

    /**
     * Define o valor dos atributos sId e sIdContainer
     * 
     * @param string sId 
     */   
    public function setId($sId) {
        $this->sIdContainer = $sId;
        $this->sId = "store-".$sId;
    }
    
    /**
     * Retorna o conteúdo dos listeners (observadores) da tela
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
     * @param string $sAcao Nome da ação
     * @param string $sFuncao Função a ser executada 
     * @param string $sParams Parâmetros a serem adicionados na função (string separada por vírgulas)
     */     
    public function addListener($sAcao,$sFuncao,$sParams=null) {
        /*
         * Se a ação desejada já existe na lista apenas adiciona a operação,
         * senão cria uma nova ação
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
     * Retorna o conteúdo do atributo aProxy
     * 
     * @return array
     */
    public function getProxy() {
        return $this->oProxy;
    }
    
    /**
     * Retorna o conteúdo do atributo aCampos
     * 
     * @return array
     */
    public function getCampos() {
        return $this->aCampos;
    }
    
    /**
     * Retorna o conteúdo do atributo aCampos na forma que deve ser 
     * renderizado
     * 
     * @return string
     */
    public function getStringCampos(){
        $sFields = "";
        
        foreach ($this->getCampos() as $key => $value) {
            if($key > 0){
                $sFields .= ",";
            }
            $sFields .= "{".$value->getRenderFields()."}";
        }
        
        return $sFields != "" ? "[".$sFields."]" : null;
    }

    /**
     * Define o valor do atributo aCampos
     * 
     * @param array $aCampos 
     */
    public function setCampos($aCampos) {
        $this->aCampos = $aCampos;
    }
    
    /**
     * Retorna o conteúdo do atributo aDados
     * 
     * @return array
     */
    public function getDados() {
        return $this->aDados;
    }

    /**
     * Define o valor do atributo aDados
     * 
     * @param array $aDados
     */
    public function setDados($aDados) {
        $this->aDados = $aDados;
    }
    
    /**
     * Retorna o conteúdo do atributo aAutoLoad
     * 
     * @return array
     */
    public function getAutoLoad() {
        return $this->aAutoLoad;
    }
    
    /**
     * Retorna o conteúdo do atributo aAutoLoad na forma que deve ser 
     * renderizado
     * 
     * @return string
     */
    public function getStringAutoLoad() {
        $sAutoLoad = "";
        
        if(isset($this->aAutoLoad[0])){
            $sAutoLoad .= "start: ".$this->aAutoLoad[0];
        }
        
        if(isset($this->aAutoLoad[1])){
            $sAutoLoad .= ", limit: ".$this->aAutoLoad[1];
        }
        
        return ($sAutoLoad != "") ? "{".$sAutoLoad."}" : null;
    }
    
    /**
     * Define o valor do atributo aAutoLoad
     * 
     * @param integer $iInicio registro inicial a ser exibido
     * @param integer $iLimite quantidade de registros a serem exibidos
     */
    public function setAutoLoad($iInicio,$iLimite = null) {
        $this->aAutoLoad[0] = $iInicio;
        $this->aAutoLoad[1] = $iLimite;
    }
    
    /**
     * Retorna o conteúdo do atributo iLinhasPagina
     * 
     * @return integer
     */
    public function getLinhasPagina() {
        return $this->iLinhasPagina;
    }

    /**
     * Define o valor do atributo iLinhasPagina
     * 
     * @param integer $iLinhasPagina 
     */
    public function setLinhasPagina($iLinhasPagina) {
        $this->iLinhasPagina = $iLinhasPagina;
    }
   
    /**
     * Retorna o conteúdo do atributo sAgrupamento
     * 
     * @return string
     */
    public function getAgrupamento() {
        return $this->sAgrupamento;
    }

    /**
     * Define o valor do atributo sAgrupamento
     * 
     * @param string $sAgrupamento 
     */
    public function setAgrupamento($sAgrupamento) {
        $this->sAgrupamento = $sAgrupamento;
    }
    
    /**
     * Retorna o conteúdo do atributo bIniciaFechada
     * 
     * @return boolean
     */
    private function getIniciaFechada() {
        return $this->bIniciaFechada;
    }

    /**
     * Define o valor do atributo bIniciaFechada
     * Indica o comportamento inicial dos agrupamentos o padrão é fechado
     * 
     * @param boolean bIniciaFechada 
     */
    public function setIniciaFechada($bIniciaFechada) {
        $this->bIniciaFechada = $bIniciaFechada;
    }

    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        //verifica se existe agrupamento e define o estado inicial
        if($this->getAgrupamento() != "" && $this->getIniciaFechada()){
            $sAcao = "var grid = Ext.ComponentQuery.query('#".$this->getIdContainer()."')[0];"
                    ."var featureGroup = grid.getView().getFeature('".$this->getAgrupamento()."-group');"
                    ."featureGroup.collapseAll();";
             
            $this->addListener(Base::EVENTO_CARREGAR,$sAcao);
        }
        
        $aRender = array(
            "storeId" => $this->getId(),
            "remoteSort" => true,
            "proxy" => $this->getProxy()->getRender(),
            "pageSize" => $this->getLinhasPagina(),
            "fields" => $this->getStringCampos(),
            "groupField" => $this->getAgrupamento(),
            "listeners" => $this->getListeners()
        );
        
        //verifica se deve adiconar o controle de paginação do objeto
        if(sizeof($this->getAutoLoad()) > 0){
            $aRender["autoLoad"] = $this->getStringAutoLoad();
        }
        
        //verifica se deve adiconar os dados na construção do objeto
        if(sizeof($this->getDados()) > 0){
            $aRender["data"] = $this->getDados();
        }
        
        return "Ext.create('Ext.data.Store', {".Base::getRender($aRender)."})";
    }
}
?>