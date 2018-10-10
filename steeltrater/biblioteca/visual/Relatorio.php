<?php
/**
 * Classe que implementa a estrutura para geraчуo de relatѓrios
 *
 * @author Fernando Salla
 * @since 03/04/2013
 */

Fabrica::requireBibliotecaReport("tcpdf/tcpdf");
Fabrica::requireBibliotecaReport("PHPJasperXML.inc");

class Relatorio {
    private $sXmlModelo;
    private $aParametros;
    private $bDebugSql;
    private $sSaida;
    
    const IMPRESSAO_NA_TELA  = 'I';
    const DOWNLOAD_RELATORIO = 'D';
    const ENCODING_BASE64    = 'E';
    const STREAM_RELATORIO   = 'S';

    /**
     * Construtor da classe 
     * 
     * @param string $sXmlModelo Nome do arquivo XML que deve ser carregado
     */
    function __construct($sXmlModelo){
        $this->setXmlModelo($sXmlModelo);
        
        $this->setSaida(self::IMPRESSAO_NA_TELA);
        $this->getDebugSql(false);
        
        $this->aParametros = array();
    }
    
    /**
     * Retorna o conteњdo do atributo sXmlModelo
     * 
     * @return string
     */
    public function getXmlModelo() {
        return $this->sXmlModelo;
    }

    /**
     * Define o valor do atributo sXmlModelo
     * Refere-se ao nome do modelo que serс utilizado para a emissуo
     * do relatѓrio
     * 
     * @param string $sXmlModelo 
     */
    public function setXmlModelo($sXmlModelo) {
        $this->sXmlModelo = $sXmlModelo;
    }

    /**
     * Retorna o conteњdo do atributo aParametros
     * 
     * @return array associativo
     */
    public function getParametros() {
        return $this->aParametros;
    }
    
    /**
     * Mщtodo que permite incluir os parтmetros que serуo utilizados 
     * na executaчуo do comando sql e na montagem do relatѓrio
     * 
     * @param string $sNome Nome do parтmetro
     * @param x $xValor Valor do parтmetro
     */
    public function addParametro($sNome, $xValor){
        $this->aParametros[$sNome] = $xValor;
    }
    
    /**
     * Retorna o conteњdo do atributo bDebugSql
     * 
     * @return boolean
     */
    public function getDebugSql() {
        return $this->bDebugSql;
    }

    /**
     * Define o valor do atributo bDebugSql
     * Caso seja verdadeiro irс imprimir o sql definido na origem de dados
     * ao invщs do relatѓrio 
     * 
     * @param boolean $bDebugSql 
     */
    public function setDebugSql($bDebugSql) {
        $this->bDebugSql = $bDebugSql;
    }

    /**
     * Retorna o conteњdo do atributo sSaida
     * 
     * @return string
     */
    public function getSaida() {
        return $this->sSaida;
    }

    /**
     * Define o valor do atributo sSaida
     * 
     * Indica o formato de saэda do relatѓrio
     * Utilizar as constantes da classe
     *  -> IMPRESSAO_NA_TELA
     *  -> DOWNLOAD_RELATORIO 
     *  -> ENCODING_BASE64
     *  -> STREAM_RELATORIO
     * 
     * @param boolean $sSaida 
     */
    public function setSaida($sSaida) {
        $this->sSaida = $sSaida;
    }

    /** 
     * Mщtodo responsсvel por criar e definir os dados do objeto PHPJasperXML 
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRelatorio(){
        $sDiretorio = str_replace('\\','/',dirname(__FILE__)).'/../../'.Config::APP_FOLDER.Config::REPORT_FOLDER.'/';
        $retorno = null;
        if(file_exists($sDiretorio.$this->getXmlModelo().'.jrxml')){
            $oXml = new SimpleXMLElement(file_get_contents($sDiretorio.$this->getXmlModelo().'.jrxml'));
            
            $oPHPJasperXML = new PHPJasperXML();
            $oPHPJasperXML->debugsql = $this->getDebugSql();
            $oPHPJasperXML->arrayParameter = $this->getParametros();
            $oPHPJasperXML->xml_dismantle($oXml);
            $oPHPJasperXML->transferDBtoArray(Config::HOST_BD, Config::USER_BD, Config::PASS_BD, Config::NOME_BD);
            $retorno = $oPHPJasperXML->outpage($this->getSaida());
        }
        if($this->getSaida()==self::STREAM_RELATORIO){
            return $retorno;
        }
    }
}
?>