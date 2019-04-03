<?php
/**
 * Classe que implementa a estrutura Tabpanel do ExtJs
 *
 * @author Avanei Martendal
 * @since 23/11/2015
 */
class TabPanel {
    private $sId; //id
    private $aItems; //items
  
    /**
     * Construtor da classe TabPanel 
     * 
     * @param string $sId Id do objeto tab
     */
    function __construct($sId = null) {
        $this->sId = Base::getId();
        
        $this->aItems = array();
        
        
        
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
     * Método que adiciona itens ao vetor de elementos do objeto
     */     
    public function addItems() {
        $aItems = func_get_args();
        
        foreach ($aItems as $oItem) {
            $this->aItems[] = $oItem;
        }
    }
    /**
     * Retorna o vetor qua contêm os elementos do layout 
     * 
     * @return array
     */     
    public function getItems() {
        return $this->aItems;
    }
    
   
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        return '<div class="nav-tabs-horizontal">';
    }
}
?>