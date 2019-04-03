<?php
/**
 * Classe que implementa a estrutura Proxy do ExtJs
 *
 * @author Fernando Salla
 * @since 15/03/2013
 */
class Proxy {
    private $sTipo; //type
    private $aReader; //reader
    private $aWriter; //writes
    private $aApi; //api
    private $aExtraParams; //extraParams
    private $aListener; //listeners
    
    //Tipos de proxy local
    const LOCAL_STORAGE_PROXY   = 'localstorage'; //salva os dados no navegador (se tiver suporte)
    const SESSION_STORAGE_PROXY = 'sessionstorage'; //salva os dados na sess�o (se tiver suporte)
    const MEMORY_PROXY          = 'memory'; //mant�m os dados apenas na mem�ria, s�o perdidos ao recarregar
    
    //Tipo de proxy no servidor
    const AJAX   = 'ajax'; //dados em servidor do mesmo dom�nio
    const JSONP  = 'jsonp'; //dados em servidor de dom�nio diferente
    const REST   = 'rest'; //utiliza os m�todos HTTP (GET,PUT,POST,DELETE) para se comunicar com o servidor
    const DIRECT = 'direct'; //usa a classe Ext.direct.Manager para enviar pedidos
    
    //Tipos de Reader
    const TIPO_JSON = 'json';
    const TIPO_XML  = 'xml';
    
    //Propriedades padr�o
    const SUCESSO = 'success';
    const TOTAL   = 'total';
    
    /**
     * Construtor da classe Proxy
     */
    public function __construct() {
        $this->aReader = array();
        $this->aWriter = array();
        $this->aApi = array();
        $this->aExtraParams = array();
        $this->aListener = array();
        
        //adiciona um listener para exibir as mensagens em caso de erro
        $sMensagem = "Erro ao processar requisi��o <br>"
                    ."A��o: '+operation.action.toUpperCase()+'";
        $oMsg = new Mensagem(Mensagem::$ERRO, 'Erro - Proxy', $sMensagem, Mensagem::$OK,null); 
        $this->addListener(Base::EVENTO_EXCECAO, $oMsg->getRender(),"el, request, operation, eOpts");
    }
    
    /**
     * Retorna o conte�do do atributo sTipo
     * 
     * @return string
     */
    public function getTipo() {
        return $this->sTipo;
    }

    /**
     * Define o valor do atributo sTipo
     * 
     * @param string sTipo 
     */
    public function setTipo($sTipo) {
        $this->sTipo = $sTipo;
    }
    
    /**
     * Retorna o conte�do do atributo aReader
     * 
     * @param integer Posi��o a ser retornada
     * 
     * @return elemento/array
     */
    public function getReader($iPosicao = -1) {
        return $iPosicao === -1 ? $this->aReader : $this->aReader[$iPosicao];
    }
    
    /**
     * Retorna o conte�do do atributo aReader na forma que deve ser 
     * renderizado
     * 
     * @return string
     */
    public function getStringReader(){
        $sReader = "";
        
        if($this->getReader() != null){
            $sReader = "type: '".$this->getReader(0)."',"
                      ."root: '".$this->getReader(1)."',"
                      ."successProperty: '".$this->getReader(2)."',"
                      ."totalPropety:  '".$this->getReader(3)."'";
        } else{
            $sReader = "type: '".self::TIPO_JSON."',"
                      ."root: '".Base::ROOT_STORE."',"
                      ."successProperty: '".self::SUCESSO."',"
                      ."totalPropety:  '".self::TOTAL."'";
        }
        
        return "{".$sReader."}";
    }

    /**
     * Define o valor do atributo aReader
     * 
     * @param string $sTipo
     * @param string $sRoot Indica a ra�z do elemento de retorno (json)
     * @param string $sTagSucesso Nome da tag que cont�m a indica��o de erro ou sucesso na opera��o 
     * @param string $sTagTotal Nome da tag que cont�m a quantidade de registros
     */
    public function setReader($sTipo, $sRoot = Base::ROOT_STORE, $sTagSucesso = self::SUCESSO, $sTagTotal = self::TOTAL) {
        $this->aReader[0] = $sTipo;
        $this->aReader[1] = $sRoot;
        $this->aReader[2] = $sTagSucesso;
        $this->aReader[3] = $sTagTotal;
    }
    
    /**
     * Retorna o conte�do do atributo aWriter
     * 
     * @param integer Posi��o a ser retornada
     * 
     * @return elemento/array
     */
    public function getWriter($iPosicao = -1) {
        return $iPosicao === -1 ? $this->aWriter : $this->aWriter[$iPosicao];
    }
    
    /**
     * Retorna o conte�do do atributo aWriter na forma que deve ser 
     * renderizado
     * 
     * @return string
     */
    public function getStringWriter(){
        $sWriter = null;
        
        if($this->getWriter() != null){
            $sWriter = "{ type: '".$this->getWriter(0)."',"
                        ."root: '".$this->getWriter(1)."',"
                        ."writeAllFields: ".($this->getWriter(2) ? "true" : "false").","
                        ."nameProperty:  '".$this->getWriter(3)."',"
                        ."encode: true"
                      ."}";
        }
        return $sWriter;
    }
    
    /**
     * Define o valor do atributo aWriter
     * 
     * @param string $sTipo
     * @param string $sRoot Indica a ra�z do elemento que ser� enviado (json)
     * @param boolean $bEnviaTodosCampos Indica se deve enviar todos os campos ou apenas os alterados
     * @param string $sPropriedadeName Nome da propriedade de mapeamento entre o model e a view (ExtJS) 
     */
    public function setWriter($sTipo, $sRoot = Base::ROOT_STORE, $bEnviaTodosCampos = true, $sPropriedadeName = 'name') {
        $this->aWriter[0] = $sTipo;
        $this->aWriter[1] = $sRoot;
        $this->aWriter[2] = $bEnviaTodosCampos;
        $this->aWriter[3] = $sPropriedadeName;
    }
   
    /**
     * Retorna o conte�do do atributo aApi
     * 
     * Linhas:
     * 0 - Leitura
     * 1 - Grava��o
     * 2 - Altera��o
     * 3 - Exclus�o
     * 
     * @param integer iLinha Linha da matriz
     * @param integer iColuna Coluna na linha indicada
     * 
     * @return array
     */
    public function getApi($iLinha = -1, $iColuna = -1) {
        return $iLinha === -1 ? $this->aApi : $this->aApi[$iLinha][$iColuna];
    }
    
    /**
     * Retorna o conte�do da url naforma que deve ser 
     * renderizado no atributo API
     * 
     * @return string
     */
    private function getStringUrl($aValue){
        $sUrl = "index.php?classe=".$aValue[0]."&metodo=".$aValue[1];
        
        if($aValue[2] != null){
            $sUrl .= "&".$aValue[2];
        }
        return "'".$sUrl."'";
    }
    
    /**
     * Retorna o conte�do do atributo aApi na forma que deve ser 
     * renderizado
     * 
     * @return string
     */
    public function getStringApi(){
        if(sizeof($this->getApi())){
            $sApi = "";
            $aTipoApi = array('read','create','update','destroy');

            foreach ($this->getApi() as $key => $value) {
                if($sApi != ""){
                    $sApi .= ",";
                }
                $sApi .= $aTipoApi[$key].":".$this->getStringUrl($value);
            }
            return "{".$sApi."}";
        } else{
            return null;
        }
    }
    
    /**
     * Define o valor do atributo aApi para o evento de leitura dos
     * dados
     * 
     * @param string sClasse Classe que cont�m o m�todo a ser executado
     * @param string sClasse M�todo a ser executado 
     * @param string $sParametros Par�metros do m�todo
     */
    public function setUrlRead($sClasse, $sMetodo, $sParametros=null) {
        $this->aApi[0][0] = $sClasse;
        $this->aApi[0][1] = $sMetodo;
        $this->aApi[0][2] = $sParametros;
    }
    
    /**
     * Define o valor do atributo aApi para o evento de grava��o dos
     * dados
     * 
     * @param string sClasse Classe que cont�m o m�todo a ser executado
     * @param string sClasse M�todo a ser executado 
     * @param string $sParametros Par�metros do m�todo
     */
    public function setUrlWrite($sClasse, $sMetodo, $sParametros=null) {
        $this->aApi[1][0] = $sClasse;
        $this->aApi[1][1] = $sMetodo;
        $this->aApi[1][2] = $sParametros;
    }
    
    /**
     * Define o valor do atributo aApi para o evento de atualiza��o dos
     * dados
     * 
     * @param string sClasse Classe que cont�m o m�todo a ser executado
     * @param string sClasse M�todo a ser executado 
     * @param string $sParametros Par�metros do m�todo
     */
    public function setUrlUpdate($sClasse, $sMetodo, $sParametros=null) {
        $this->aApi[2][0] = $sClasse;
        $this->aApi[2][1] = $sMetodo;
        $this->aApi[2][2] = $sParametros;
    }
    
    /**
     * Define o valor do atributo aApi para o evento de exclus�o dos
     * dados
     * 
     * @param string sClasse Classe que cont�m o m�todo a ser executado
     * @param string sClasse M�todo a ser executado 
     * @param string $sParametros Par�metros do m�todo
     */
    public function setUrlDelete($sClasse, $sMetodo, $sParametros=null) {
        $this->aApi[3][0] = $sClasse;
        $this->aApi[3][1] = $sMetodo;
        $this->aApi[3][2] = $sParametros;
    }
    
    /**
     * Retorna o conte�do do atributo aExtraParams
     * 
     * @return array
     */
    public function getExtraParams($iPosicao = -1) {
        return $iPosicao === -1 ? $this->aExtraParams : $this->aExtraParams[$iPosicao];
    }
    
    /**
     * Retorna o conte�do do atributo aExtraParams na forma que deve ser 
     * renderizado
     * 
     * @return string
     */
    public function getStringExtraParams(){
        $sExtraParams = "";
        
        foreach ($this->getExtraParams() as $key => $value) {
            $sExtraParams = Base::addComma($sExtraParams);
            $sExtraParams .= $key.":".((substr($value,0,4) != 'Ext.') ? '"'.$value.'"' : $value);
        }
        return $sExtraParams != "" ? "{".$sExtraParams."}" : null;
    }
    
    /**
     * Adiciona um par�metro extra ao envio da requisi��o ao servidor
     * 
     * @param string sChave Chave do array associativo
     * @param string sValor Valor a ser enviado
     */
    public function addExtraParam($sChave, $sValor) {
        $this->aExtraParams[$sChave] = $sValor;
    }

    /**
     * Retorna o conte�do dos listeners (observadores) da tela
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
     * @param string $sAcao Nome da a��o
     * @param string $sFuncao Fun��o a ser executada 
     * @param string $sParams Par�metros a serem adicionados na fun��o (string separada por v�rgulas)
     */     
    public function addListener($sAcao,$sFuncao,$sParams=null) {
        /*
         * Se a a��o desejada j� existe na lista apenas adiciona a opera��o,
         * sen�o cria uma nova a��o
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
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        $aRender = array(
            "type" => $this->getTipo(),
            "autoLoad" => 'true',
            "api" => $this->getStringApi(),
            "reader" => $this->getStringReader(),
            "writer" => $this->getStringWriter(),
            "listeners" => $this->getListeners()
        );
        
        //verifica se envia informa��es extras
        if(sizeof($this->getExtraParams()) > 0){
            $aRender["extraParams"] = $this->getStringExtraParams();
        }
        return "{".Base::getRender($aRender)."}";
    }
}
?>