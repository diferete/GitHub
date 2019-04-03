<?php
/**
 * Classe que implementa a estrutura Panel do ExtJs
 *
 * @author Fernando Salla
 * @since 10/12/2013
 */
class Panel {
    private $sId; //id
    private $sTitulo; //title
    private $bPermiteFechar; //closable
    private $bPermiteArrastar; //draggable
    private $bPermiteRedimensionar; //resizable
    private $bPermiteRecolher; //collapsible
    private $bAdicionaBorda; //border
    private $bReloadPreviousOnClose;
    private $bCentraliza;
    private $iAltura; //height
    private $iLargura; //width
    private $iLayout; //layout
    private $sHtml; //html
    private $aCampos; //items
    private $aLayout;
    private $aBotoes; //buttons
    private $aListener; //listeners
    private $aLarguraLabel;
    private $oCampoFoco;
    private $sRenderTo; //renderTo
    
    /**
     * Construtor da classe Panel 
     * 
     * O �nico par�metro obrigat�rio refere-se ao t�tulo da tela
     * 
     * @param string $sTitulo T�tulo da tela
     * @param integer $iAltura Altura da tela
     * @param integer $iLargura Largura da tela
     * @param bollean $bPermiteFechar Controla se a tela permitir� fechamento ou n�o
     * @param bollean $bPermiteArrastar Controla se a tela permitir� que seja arrastada ou n�o
     * @param bollean $bPermiteRedimensionar Controla se a tela permitir� redimensionamento ou n�o
     * @param bollean $bPermiteRecolher Controla se a tela permitir� recolhimento ou n�o
     * 
     */
    function __construct($sTitulo, 
                         $iAltura = '100%', 
                         $iLargura = '100%', 
                         $bPermiteFechar = true, 
                         $bPermiteArrastar = false, 
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
        $this->setAdicionaBorda(true);
        $this->setCentraliza();
        $this->setReloadPreviousOnClose();
        
        $this->setLayout(Base::LAYOUT_ANCHOR);
        
        $this->aCampos = array();
        $this->aLayout = array();
        $this->aBotoes = array();
        $this->aListener = array();
        $this->aLarguraLabel = array();
    }
    
    /**
     * Retorna o conte�do do atributo sId
     * 
     * @return string
     */
    public function getId() {
        return $this->sId;
    }
    
    /**
     * Retorna o conte�do do atributo sTitulo
     * 
     * @return string
     */
    public function getTitulo() {
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
     * Retorna o conte�do do atributo bPermiteFechar
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
     * Retorna o conte�do do atributo bPermiteArrastar
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
     * Retorna o conte�do do atributo bPermiteRedimensionar
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
     * Retorna o conte�do do atributo bPermiteRecolher
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
     * Retorna o conte�do do atributo bReloadPreviousOnClose
     * 
     * @return boolean
     */
    private function getReloadPreviousOnClose() {
        return $this->bReloadPreviousOnClose;
    }

    /**
     * Define o valor do atributo ReloadPreviousOnClose
     * Indica se ao fechar a tela o elemento anterior deve ser recarregado
     * caso seja um grid. 
     * O padr�o � true. 
     * Alterado apenas quando se deseja fazer outra opera��o ap�s o fechamento
     * da tela e a mesma j� realize o carregamento (evita duplo carregamento e
     * econimiza processamento)
     * 
     * @param boolean $bReloadPreviousOnClose 
     */
    public function setReloadPreviousOnClose($bReloadPreviousOnClose = true) {
        $this->bReloadPreviousOnClose = $bReloadPreviousOnClose;
    }
    
    /**
     * Retorna o conte�do do atributo bCentraliza
     * 
     * @return boolean
     */
    private function getCentraliza() {
        return $this->bCentraliza;
    }

    /**
     * Define o valor do atributo bCentraliza
     * 
     * @param boolean $bCentraliza
     */
    public function setCentraliza($bCentraliza = false) {
        $this->bCentraliza = $bCentraliza;
    }
    
    /**
     * Retorna o conte�do do atributo bAdicionaBorda
     * 
     * @return boolean
     */
    private function getAdicionaBorda() {
        return $this->bAdicionaBorda;
    }

    /**
     * Define o valor do atributo bAdicionaBorda
     * 
     * @param boolean $bAdicionaBorda 
     */
    public function setAdicionaBorda($bAdicionaBorda) {
        $this->bAdicionaBorda = $bAdicionaBorda;
    }
    
    /**
     * Retorna o conte�do do atributo iAltura
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
     * Retorna o conte�do do atributo iLargura
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
     * Retorna o conte�do do atributo iLayout
     * 
     * @return string
     */
    private function getLayout() {
        return Base::$LAYOUT[$this->iLayout];
    }

    /**
     * Define o valor do atributo iLayout
     * 
     * @param integer $iLayout 
     */    
    public function setLayout($iLayout) {
        $this->iLayout = $iLayout;
    }

    /**
     * Retorna o conte�do do atributo sHtml
     * 
     * @return string
     */   
    private function getHtml() {
        return $this->sHtml;
    }

    /**
     * Define o valor do atributo sHtml
     * 
     * @param string $sHtml 
     */ 
    public function setHtml($sHtml) {
        $this->sHtml = $sHtml;
    }
    
    /**
     * Retorna o conte�do do vetor de bot�es na estrutura que 
     * dever� ser renderizado
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
     * Adiciona um bot�o ao vetor de bot�es do objeto
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
     * Adiciona os valores passados ao array que conter� a largura do
     * label de cada coluna a ser montada na tela
     * 
     * @param integer Largura do label 
     */     
    public function addLarguraLabel($iLarguraLabel) {
       $this->aLarguraLabel[] = $iLarguraLabel;
    }  
    
    /**
     * Retorna o array de campos a ser utilizado pelas classes externas
     * Pode ser retornada apenas a posi��o desejada ou todo o vetor
     * 
     * @param integer $iPosicao Posi��o do vetor a ser retornada (opcional)
     * 
     * @return Array
     */
    public function getCampos($iPosicao = -1){
        return $iPosicao === -1 ? $this->aCampos : $this->aCampos[$iPosicao];
    }
    
    /**
     * Retorna um campo da lista de campos a partir do nome do mesmo
     * 
     * @param String $sNome Nome do campo a ser localizado
     * 
     * @return Object/null Retorna o objeto desejado ou nulo caso n�o encontrado
     */
    public function getCampoByName($sNone){
        foreach ($this->getCampos() as $oCampo) {
            if(strtolower($oCampo->getNome()) === strtolower($sNone)){
                return $oCampo;
            }
        }
        return null;
    }
    
    /**
     * Retorna um campo da lista de campos a partir do id do mesmo
     * 
     * @param String $sId Id do campo a ser localizado
     * 
     * @return Object/null Retorna o objeto desejado ou nulo caso n�o encontrado
     */
    public function getCampoById($sId){
        $oCampo = null;
        
        foreach ($this->getCampos() as $oCampo) {
            if(strtolower($oCampo->getId()) === strtolower($sId)){
                return $oCampo;
            }
        }
        return $oCampo;
    }
    
    /**
     * M�todo que adiciona os campos criados na tela
     */
    public function addCampos(){
        $aCampos = func_get_args();    
        
        foreach($aCampos as $campoAtual){
            if(is_array($campoAtual)){
                foreach ($campoAtual as $campo){
                    $this->addCampoTela($campo);
                }
            } else{
                $this->addCampoTela($campoAtual);    
            }
            $this->addItemsLayout($campoAtual);
        }
    }
    
    /**
     * Adiciona itens ao vetor de elementos do objeto
     */     
    private function addCampoTela($oCampo) {
        $this->aCampos[] = $oCampo;
    }
    
    /**
     * Retorna o vetor qua cont�m o layout do formul�rio
     * 
     * @return array
     */     
    public function getItemsLayout() {
        return $this->aLayout;
    }
    
    /**
     * Adiciona itens ao vetor que cont�m o layout do formul�rio
     */     
    private function addItemsLayout($aLinha) {
        $this->aLayout[] = $aLinha;
    }
    
    /**
     * Adiciona items ao vetor que cont�m o layout do formul�rio no fim da linha
     * desejada
     * 
     * @param array Array contendo os campos a serem adicionados
     * @param integer Posi��o que devem ser adicionados os campos
     */     
    public function addItemsLayoutPosicao($aCampos, $iPosicao) {
        if(!is_array($aCampos)){
            $aCampos = array($aCampos);
        }
        $aListaCampos = is_array($this->aLayout[$iPosicao]) ? $this->aLayout[$iPosicao] : array($this->aLayout[$iPosicao]);
        $this->aLayout[$iPosicao] = array_merge($aListaCampos,$aCampos);
    }
    
    /**
     * Retorna o conte�do do vetor de campos na estrutura (layout) que 
     * dever� ser renderizado
     * 
     * @return string
     */
    private function getStringItemsLayout(){ 
        $sCampos = "[";
        $sLinha = "{ xtype: 'container',"
                   ."layout: '".Base::$LAYOUT[Base::LAYOUT_HBOX]."',"
                   ."items: [";
        foreach ($this->aLayout as $key => $value) {
            if($key > 0){
                $sCampos .= ",";
            }
            if (is_a($value,'Grafico')){
                $sGrafico = $sLinha.$value->getRender()."]},";
                //$sGrafico = $sLinha."{html: 'teste'}"."]}";
                $sCampos .= $sGrafico;
            }
            else {
                $sCampoArquivo = Campo::getRenderArquivo($value);
                if($sCampoArquivo != ""){
                    $sCampos .= $sLinha.$sCampoArquivo."]},";
                }

                $sCampos .= $sLinha;

                $iColuna = 0; //controla a coluna para poder montar a sua largura

                if(is_array($value)){
                    foreach ($value as $iIndex => $oCampo){
                        if($iIndex > 0){
                            $sCampos .= ",";
                            $iColuna++; //incrementa a posi��o (coluna) atual
                        }
                        $sCampos .= $this->getStringCampo($oCampo, $iColuna);
                    }
                } else{
                    $sCampos .= $this->getStringCampo($value, $iColuna);
                }
                $sCampos .= "]}";
            }
        }
        $sCampos .= "]";
        
        return $sCampos;
    }
    
    /**
     * M�todo que monta a string dos campos a serem renderizados no formul�rio
     * 
     * @param Campo $oCampo Campo a ser renderizado
     * @param integer $iColuna Coluna na qual o campo deve ser adicionado
     * 
     * @return string
     */
    private function getStringCampo($oCampo, $iColuna){
        /*
         * verifica se existe largura definida para a coluna e 
         * define valor definido para a largura do label da coluna atual
         */
        if(isset($this->aLarguraLabel[$iColuna]) && method_exists($oCampo, 'setLarguraLabel')){
            $oCampo->setLarguraLabel($this->aLarguraLabel[$iColuna]);
        }
        
        /*
         * Verifica se o campo possui busca definida e adiciona a a��o
         * ao envento EXIT do mesmo. Tamb�m cria e retorna o bot�o de pesquisa
         * para ser adicionado ao lado do campo
         */
        $sCampoBusca = "";
        if(method_exists($oCampo, 'getBtnBusca') && $oCampo->getBtnBusca() != null && $oCampo->getValorTipo() != Campo::TIPO_SELECT){
            Campo::getAcaoExitBusca($oCampo);
            $sCampoBusca = Campo::getRenderBusca($oCampo);
        }
        
        return "{".($iColuna > 0 ? "labelStyle: 'margin-left: 15px;'," : "")
                  .$oCampo->getRender().
               "}"
               .$sCampoBusca; 
    }
    
    /**
     * Retorna o conte�do do atributo oCampoFoco, caso n�o seja definido pelo
     * programador o foco ocorrer� no primeiro campo habilitado do formul�rio
     * 
     * @return string
     */
    public function getCampoFoco() {
        if($this->oCampoFoco != null){
            return $this->oCampoFoco;
        } else{
            foreach ($this->getCampos() as $oCampo) {
                if(method_exists($oCampo, 'getSomenteLeitura') && !$oCampo->getSomenteLeitura()){
                    return $oCampo;
                }
            }
        }
        return null;
    }

    /**
     * Define o valor do atributo oCampoFoco referente ao campo que deve
     * receber o foco ao abrir o formul�rio
     * 
     * @param Object Item do formul�rio
     */
    public function setCampoFoco($oCampo) {
        $this->oCampoFoco = $oCampo;
    } 
    
    /**
     * Retorna o conte�do do atributo sRenderTo
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
     * @param string $sParam Par�metros a serem adicionados na fun��o (string separada por v�rgulas)
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
     * Adicionar o comportamento (listener) de remo��o da m�scara do objeto
     * pai ao fechar a tela
     * 
     * @param string Identificador do objeto que cont�m a m�scara
     */
    public function addRemoveMascara($renderTo) {
        $aRemoveMascara = Base::getAcaoRemoveMascara($renderTo);
        $this->addListener($aRemoveMascara[0],$aRemoveMascara[1]);
    }
    
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        //Adiciona a funcionalidade para definir o campo que deve receber o foco inicial
        if($this->getCampoFoco() != null){
            $sFuncao = View::campoFocus($this->getCampoFoco()->getId());
            $this->addListener(Base::EVENTO_APOS_MONTAR, $sFuncao);
        }
        
        //Adiciona a funcionalidade que centraliza o formul�rio na tela
        if($this->getCentraliza()){
            $sFuncao = Base::getFuncaoCentraliza();
            $this->addListener(Base::EVENTO_MONTAR, $sFuncao);
        }
        
        //Adiciona a funcionalidade que indica que ser� poss�vel arrastar o formul�rio
        if($this->getPermiteArrastar()){
            $sFuncao = Base::getFuncaoLimitaArrasto($this->getId(),$this->getRenderTo());
            $this->addListener(Base::EVENTO_MONTAR, $sFuncao);
        }
        
        $aRender = array(
            "animCollapse" => true,
            "autoScroll" => true,
            "waitMsgTarget" => true,
            "bodyPadding" => 10,
            "iconCls" => 'icon-form',
            "border" => $this->getAdicionaBorda(),
            //"glyph" => 36,
            "layout" => $this->getLayout(),
            "id" => $this->getId(),
            "title" => $this->getTitulo(),
            "closable" => $this->getPermiteFechar(),
            "resizable" => $this->getPermiteRedimensionar(),
            "draggable" => $this->getPermiteArrastar(),
            "collapsible" => $this->getPermiteRecolher(),
            "height" => $this->getAltura(),
            "width" => $this->getLargura(),
            "html" => $this->getHtml(),
            "items" => $this->getStringItemsLayout(),
            "buttons" => $this->getBotoes(),
            "listeners" => $this->getListeners(),
            "reloadPreviousOnClose" => $this->getReloadPreviousOnClose()
        );
        
        $oForm = "Ext.create('Ext.panel.Panel', {".Base::getRender($aRender)."})";
        
        return Base::addObj($oForm,$this->getRenderTo());
    }
}
?>