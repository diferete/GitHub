<?php
/**
 * Classe que implementa os campos do grid
 *
 * @author Avanei Martendal
 * @since 21/10/2015
 */
class CampoConsulta{
    private $sLabel;//nome do campo que vai no cabeçalho do grid
    private $sNome;//nome do model do campo
    private $aComparacao; //array para comparação para renderizar grid com cores
    private $bComparacaoColuna; //Se true formata as cores de acordo com comparação somente na coluna do campo
    private $Tipo;  //Define o tipo de dado do campo
    private $iLargura;
    private $sOperacao;
    private $sTituloOperacao;
  
    
    const TIPO_TEXTO = 0;
    const TIPO_DATA = 1;
    const TIPO_MONEY = 2;
    const TIPO_DECIMAL = 3;


    //Constantes para operadores lógicos
    const MODO_LINHA = 0;
    const MODO_COLUNA = 1;
    
    //Constantes para operadores lógicos
    const COMPARACAO_IGUAL = 0;
    const COMPARACAO_MAIOR = 1;
    const COMPARACAO_MENOR = 2;
    const COMPARACAO_DIFERENTE = 3;
    
    //constantes responsáveis pelas cores
    const COR_VERMELHO = 'tr-vermelha';
    const COR_AZUL = 'tr-azul';
    const COR_AMARELO = 'tr-amarelo';
    const COR_VERDE = 'tr-verde';

    /**
     *  Método construtor que passa o label e o nome do campo no model
     *  @param Label do campo
     *  @param Nome do model
     *  @param Tipo o tipo de dado
     *  @param Largura define a largura do campo
     */
    function __construct($sLabel,$sNome, $Tipo = self::TIPO_TEXTO) {
        $this->sLabel = $sLabel;
        $this->sNome = $sNome;
        $this->aComparacao = array();
        $this->bComparacaoColuna = false;
        $this->Tipo = $Tipo;
       
        
    }
    
    function getSTituloOperacao() {
        return $this->sTituloOperacao;
    }

    function setSTituloOperacao($sTituloOperacao) {
        $this->sTituloOperacao = $sTituloOperacao;
    }

        
    
   /*
    * Define a operação soma,media
    */
    function getSOperacao() {
        return $this->sOperacao;
    }

    function setSOperacao($sOperacao) {
        $this->sOperacao = $sOperacao;
    }

           
    function getILargura() {
        return $this->iLargura;
    }

    function setILargura($iLargura) {
        $this->iLargura = $iLargura;
    }

    
            
    
    /*
     * Retorna o valor do label
     */
    function getSLabel() {
        return $this->sLabel;
    }
     /*
    * Seta o valor do label
    */
    function setSLabel($sLabel) {
        $this->sLabel = $sLabel;
    }

    /*
     * Retorna o valor do nome
     */
    function getSNome() {
        return $this->sNome;
    }
  
   /*
    * Seta o valor do nome
    */
    function setSNome($sNome) {
        $this->sNome = $sNome;
    }
    /**
     * Recupera Array de comparações
     * @return string
     */
    function getAComparacao() {
        return $this->aComparacao;
    }
    function getBComparacaoColuna() {
        return $this->bComparacaoColuna;
    }

    function setBComparacaoColuna($bComparacaoColuna) {
        $this->bComparacaoColuna = $bComparacaoColuna;
    }
    function getTipo() {
        return $this->Tipo;
    }

    function setTipo($Tipo) {
        $this->Tipo = $Tipo;
    }

    

    /**
     * Método responsavel por realizar a coloração de linhas/colunas do grid de acordo com
     * o modo de comparação escolhida
     * 
     * @param type $sValor Valor a ser comparado com o tipo de comparacao e o valor do CampoConsulta
     * @param type $iTipoComp Constante do tipo de comparação (Igual(0),Maior(1), Menor(2) ou diferente(3))
     * @param type $sCor CampoConsulta::CorPadrãoCor a ser atribuída a classe de acordo com o valor comparativo
     * @param type $iModo Define se o modo a ser colorido é linha ou coluna
     */
    public function addComparacao($sValor, $iTipoComp = self::COMPARACAO_IGUAL, $sCor = self::COR_VERMELHO, $iModo = self::MODO_LI3NHA){
        $aComp['valor'] = $sValor;
        $aComp['tipo'] = $iTipoComp;
        $aComp['cor'] = $sCor;
        $aComp['modo'] = $iModo;
        
        $this->aComparacao[] = $aComp;
    } 
    
    /**
     * Retorna o render do campo consulta
     */
    public function getRender($sClasse,$xValor){
        switch ($this->Tipo) {
            case self::TIPO_TEXTO:
                $sCampo ='<td class="'.$sClasse.'" >'.$xValor.'</td>';
                
             break;
            case self::TIPO_MONEY:
                $sCampo ='<td class="'.$sClasse.'" >R$ '.number_format($xValor, 2, ',', '.').'</td>'; //
            case self::TIPO_DECIMAL:
                $sCampo ='<td class="'.$sClasse.'" >'.number_format($xValor, 2, ',', '.').'</td>'; 
        }
        
         return $sCampo;
    }
}
?>