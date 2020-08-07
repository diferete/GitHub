<?php
/**
 * Classe que implementa a estrutura dos separadores
 *
 * @author Fernando Salla
 * @since 17/05/2013
 */

class Separador {
    private $iTipo;
    
    const TIPO_BARRA  = 0;
    const TIPO_ESPACO = 1;
    
    //array contendo as strings referentes aos tipos possíveis do separador
    public static $TIPOS = array('tbseparator','tbspacer');
    
    /**
     * Construtor da classe separador 
     * 
     * @param integer $iTipo Tipo do separador
     */    
    public function __construct($iTipo = self::TIPO_BARRA) {
        $this->setTipo($iTipo);
    } 
   
    /**
     * Retorna o valor do atributo iTipo
     * 
     * @return integer
     */
    public function getTipo(){
        return $this->iTipo;
    }
    
    /**
     * Retorna a string referente ao valor do atributo iTipo
     * 
     * @return integer
     */
    public function getStringTipo(){
        return self::$TIPOS[$this->iTipo];
    }
    
    /**
     * Define o valor do atributo iTipo
     * 
     * @param interger iTipo 
     */  
    public function setTipo($iTipo) {
        $this->iTipo = $iTipo;
    }
    
    /** 
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRender(){
        $aRender = array(
            "xtype" => $this->getStringTipo()
        );

        $sRender = Base::getRender($aRender);

        return $sRender;
    }
}
?>