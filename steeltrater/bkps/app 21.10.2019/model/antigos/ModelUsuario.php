<?php
/**
 * Classe que implementa o Model do objeto Usuário 
 */
class ModelUsuario {
    private $iCodigo; 
    private $sLogin;
    private $sSenha;
    private $bBloqueado;
    private $tipo;
    private $UsuarioEmpresa;
    private $nome;
    private $usunomeDelsoft;
    
    function getUsunomeDelsoft() {
        return $this->usunomeDelsoft;
    }

    function setUsunomeDelsoft($usunomeDelsoft) {
        $this->usunomeDelsoft = $usunomeDelsoft;
    }

        
    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

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
     * Retorna o conteúdo do atributo sLogin
     * 
     * @return string
     */    
    public function getLogin() {
        return $this->sLogin;
    }

    /**
     * Define o valor do atributo sLogin
     * 
     * @param string sLogin 
     */
    public function setLogin($sLogin) {
        $this->sLogin = $sLogin;
    }

    /**
     * Retorna o conteúdo do atributo sSenha
     * 
     * @return string
     */    
    public function getSenha() {
        return $this->sSenha;
    }

    /**
     * Define o valor do atributo sSenha
     * 
     * @param integer sSenha 
     */
    public function setSenha($sSenha) {
        $this->sSenha = $sSenha;
    }

    /**
     * Retorna o conteúdo do atributo bBloqueado
     * 
     * @return boolean
     */    
    public function getBloqueado() {
        return $this->bBloqueado;
    }

    /**
     * Define o valor do atributo bBloqueado
     * 
     * @param integer bBloqueado 
     */
    public function setBloqueado($bBloqueado) {
        $this->bBloqueado = $bBloqueado;
    }
    
    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    /**
     * Retorna o conteúdo do atributo UsuarioEmpresa
     * 
     * @return Object
     */
    public function getUsuarioEmpresa() {
        if (!isset($this->UsuarioEmpresa)){
            $this->UsuarioEmpresa = Fabrica::FabricarModel('UsuarioEmpresa');
        }       
        return $this->UsuarioEmpresa;
    }

    /**
     * Define o valor do atributo UsuarioEmpresa
     * 
     * @param Object oProdutoGrade
     */
    public function setUsuarioEmpresa($oUsuarioEmpresa) {
        $this->UsuarioEmpresa = $oUsuarioEmpresa;
    }
    
}
?>