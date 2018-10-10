<?php
/**
 * Classe que implementa o Model do objeto Sistema 
 */
class ModelSistema{
    private $iCodigo; 
    private $sNome;
    private $sLogo;

    /**
     * Retorna o conteúdo do atributo iCodigo
     * 
     * @return integer
     */
    public function getCodigo() {
        return $this->iCodigo;
    }

    /**
     * Define o valor do atributo iCodigo
     * 
     * @param integer iCodigo 
     */
    public function setCodigo($iCodigo) {
        $this->iCodigo = $iCodigo;
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
     * Retorna o conteúdo do atributo sLogo
     * 
     * @return string
     */    
    public function getLogo() {
        return $this->sLogo;
    }

    /**
     * Define o valor do atributo sLogo
     * 
     * @param string sLogo 
     */
    public function setLogo($sLogo) {
        $this->sLogo = $sLogo;
    }
}
?>