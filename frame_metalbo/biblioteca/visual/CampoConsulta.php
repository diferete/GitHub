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
    private $iLarguraFixa;
    private $bCampoIcone;
    private $sTitleAcao;
    private $aAcao;

    const TIPO_TEXTO = 0;
    const TIPO_DATA = 1;
    const TIPO_MONEY = 2;
    const TIPO_DECIMAL = 3;
    const TIPO_DOWNLOAD = 4;
    const TIPO_DESTAQUE1=5;
    const TIPO_LARGURA = 6;
    const TIPO_TIME = 7;
    const TIPO_DESTAQUE2=8;
    const TIPO_ACAO = 9;

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
    const COR_ROXO = 'tr-roxo';
    const COR_ROSA ='tr-rosa';
    const COR_LARANJA ='tr-laranja';
    
    //constantes responsáveis pelos background cores
    const COL_VERMELHO = 'tr-bk-vermelha';
    const COL_AZUL = 'tr-bk-azul';
    const COL_AMARELO = 'tr-bk-amarelo';
    const COL_VERDE = 'tr-bk-verde';
    const COL_ROXO = 'tr-bk-roxo';
    const COL_ROSA ='tr-bk-rosa';
    const COL_LARANJA ='tr-bk-laranja';
    
    

    /**
     *  Método construtor que passa o label e o nome do campo no model
     *  @param string $sLabel Label do campo
     *  @param string $sNome Nome campo
     *  @param string $Tipo Define o tipo do campo
     *  @param integer $iLargura Define a largura do campo
     *  
     */
    
    
    function __construct($sLabel,$sNome, $Tipo = self::TIPO_TEXTO) {
        $this->sLabel = $sLabel;
        $this->sNome = $sNome;
        $this->aComparacao = array();
        $this->bComparacaoColuna = false;
        $this->Tipo = $Tipo;
        $this->setBCampoIcone(false);
        
        if($this->Tipo==9){
            $this->setBCampoIcone(true);
        }
        
        
    }
    
    /**
     * Adiciona a classe e o método para a ação do botão
     * 
     * @param type $sClasse Classe para para instanciar
     * @param type $sMetodo Método para chamar
     */
    
    function addAcao($sClasse,$sMetodo){
        $this->aAcao['classe']=$sClasse;
        $this->aAcao['metodo']=$sMetodo;
    }
   
            
    

        
    function getSTitleAcao() {
        return $this->sTitleAcao;
    }

    function setSTitleAcao($sTitleAcao) {
        $this->sTitleAcao = $sTitleAcao;
    }

        
    function getBCampoIcone() {
        return $this->bCampoIcone;
    }

    function setBCampoIcone($bCampoIcone) {
        $this->bCampoIcone = $bCampoIcone;
    }

        
    function getILarguraFixa() {
        return $this->iLarguraFixa;
    }

    function setILarguraFixa($iLarguraFixa) {
        $this->iLarguraFixa = $iLarguraFixa;
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
               $xValor = str_replace("\n", " ",$xValor);
               $xValor = str_replace("'","\'",$xValor);   
               $xValor = str_replace("\r", "",$xValor);
               $sCampo ='<td class="'.$sClasse.' tr-font" >'.$xValor.'</td>';
                
             break;
            case self::TIPO_MONEY:
                $sCampo ='<td class="'.$sClasse.'" >R$ '.number_format($xValor, 2, ',', '.').'</td>'; 
             break;
            case self::TIPO_DECIMAL:
                $sCampo ='<td class="'.$sClasse.'" >'.number_format($xValor, 2, ',', '.').'</td>'; 
            break;
            case self::TIPO_DATA:
               if($xValor=='01/01/1970'){$xValor='';};
               
               $sCampo ='<td class="'.$sClasse.'" >'.$xValor.'</td>'; 
            break;
            case self::TIPO_DOWNLOAD:
               $sCampo ='<td class="'.$sClasse.'" ><a href=\\\'uploads/'.$xValor.'\\\' target=\\\'_blank\\\'>'.$xValor.'</a></td>';
             
            break;
            case self::TIPO_DESTAQUE1:
                $sCampo ='<td class="'.$sClasse.'" ><span class="badge badge-dark">'.$xValor.'</span></td>'; 
            break;
           case self::TIPO_DESTAQUE2:
                $sCampo ='<td class="'.$sClasse.'" ><span class="badge badge-default">'.$xValor.'</span></td>'; 
            break;
            case self::TIPO_LARGURA:
               $xValor = str_replace("\n", " ",$xValor);
               $xValor = str_replace("'","\'",$xValor);   
               $xValor = str_replace("\r", "",$xValor);
               $sCampo ='<td class="'.$sClasse.' tr-font" style="width:'.$this->getILarguraFixa().'px !important; white-space: nowrap;" >'.$xValor.'</td>';
               
               break;
            case self::TIPO_TIME:
               $sTime = substr($xValor,0,-8);
               $sCampo ='<td class="'.$sClasse.' tr-font" >'.$sTime.'</td>';
               break; 
            case self:: TIPO_ACAO:
               $xValor = str_replace("\n", " ",$xValor);
               $xValor = str_replace("'","\'",$xValor);   
               $xValor = str_replace("\r", "",$xValor);
               $sAcao = '';
               $sIdBtn = Base::getId();
               $sCampo ='<td class="'.$sClasse.' tr-font" ><button id="'.$sIdBtn.'" title="'.$this->getSTitleAcao().'" class="btn btn-outline btn-warning btn-xs">+</button></td>'; 
               $sCampo.='<script>$("#'.$sIdBtn.'").click(function(){'
                      // .'alert(abaSelecionada);'
                       .'var idGrid = $("#"+abaSelecionada+"paramGrid").text();'
                       //.'alert(idGrid);'
                       .'$("#"+idGrid+"consulta").hide();'
                       .'requestAjax("","'.$this->aAcao['classe'].'","'.$this->aAcao['metodo'].'",abaSelecionada +"control,"+idGrid+",'.$xValor.'");' //abaSelecionada +"control,'.$sIdTela.',"+chave,"'.$aItem['paramadicional'].'"
                       . '});</script>';
               
               break;
                
        
        }
        
         return $sCampo;
    }
}
?>