<?php
/**
 * Classe que implementa a estrutura de dropdowns
 *
 * @author Carlos Eduardo Scheffer
 * @since 06/01/2015
 */

class Dropdown{
    private $sId;
    private $sLabel;
    private $aItensDropdown;
    
    private $iTipo; //?
    private $sTelaGrande; //Define o valor para tela grandes como note e pc
    private $sTelaMedia; //Define o valor para telas de tablets e notes pequenos
    private $sTelaPequena; //Define o valor para telas pequenas como tablets pequenos e celulares
    private $sTelaMuitoPequena; //Define o valor para telas muito pequenas como celulares pequenos
    private $bDesativado; // Defini se dropdown e/ou itens do dropdowns est�o desativados
   

    const TIPO_PADRAO = 0;
    const TIPO_SUCESSO = 1;
    const TIPO_ERRO = 2;
    const TIPO_DARK = 3;
    const TIPO_INFO = 4;
    const TIPO_AVISO = 5;
    const TIPO_PRIMARY = 6;


    public function __construct($sLabel, $iTipo = self::TIPO_PADRAO,$sTelaGrande = '2',$sTelaMedia = '2',$sTelaPequena = '2',$sTelaMuitoPequena='12') {
        $this->sId = Base::getId();
        $this->setSLabel($sLabel);
        $this->setITipo($iTipo);
        
        // Respons�vel pelo tamanho do Dropdown em diferentes tamanhos de tela
        $this->setSTelaGrande($sTelaGrande);
        $this->setSTelaMedia($sTelaMedia);
        $this->setSTelaPequena($sTelaPequena);
        $this->setSTelaMuitoPequena($sTelaMuitoPequena);
        
        $this->bDesativado = false;
    }
   
   
        
        function getSId() {
        return $this->sId;
    }

    function getSLabel() {
        return $this->sLabel;
    }

    function setSId($sId) {
        $this->sId = $sId;
    }

    function setSLabel($sLabel) {
        $this->sLabel = $sLabel;
    }
    function getITipo() {
        return $this->iTipo;
    }

    function setITipo($iTipo) {
        $this->iTipo = $iTipo;
    }
      /**
    * 
    * Recupera o valor da telas grande
    */
    function getSTelaGrande() {
        return $this->sTelaGrande;
    }
    /**
     * 
     * Seta o valor das telas grandes
     */
    function setSTelaGrande($sTelaGrande) {
        $this->sTelaGrande = $sTelaGrande;
    }
    /**
     * 
     * Retorna o valor para telas m�dias como notebook e tablets
     */        
    function getSTelaMedia() {
        return $this->sTelaMedia;
    }
    /**
     * 
     * Define o valor para telas como nobook e tablets
     */
    function setSTelaMedia($sTelaMedia) {
        $this->sTelaMedia = $sTelaMedia;
    }
     /**
      * 
      * retorna o valor para telas pequenas
      */       
    function getSTelaPequena() {
        return $this->sTelaPequena;
    }
     /**
      * 
      * seta o valor para telas pequenas
      */       
    function setSTelaPequena($sTelaPequena) {
        $this->sTelaPequena = $sTelaPequena;
    }

    /**
     * 
     * Retorna o valor para telas muito pequenas
     */
    function getSTelaMuitoPequena() {
        return $this->sTelaMuitoPequena;
    }
    /**
     * 
     * Seta o valor para telas muito pequenas
     */        
    function setSTelaMuitoPequena($sTelaMuitoPequena) {
        $this->sTelaMuitoPequena = $sTelaMuitoPequena;
    }
    
    function getAItensDropdown() {
        return $this->aItensDropdown;
    }

    function setAItensDropdown($aItensDropdown) {
        $this->aItensDropdown = $aItensDropdown;
    }
    function getBDesativado() {
        return $this->bDesativado;
    }

    function setBDesativado($bDesativado) {
        $this->bDesativado = $bDesativado;
    }

    
    
    
     /**
     * Método necess�rio para renderizar
     * @return string
     */  
    function getAAcao() {
        $sAcao = "";
        
        return $sAcao;
    }
    /**
     * Método responsavel por adicionar itens aos Dropdowns
     * @param string $sLabelAcao String que representa a ação no dropdown
     * @param string $sClasse Classe a ser assumida
     * @param string $sMetodo Método da classe assumida para ser executado
     * @param string $sParametro Parametros adicionais se necessários
     */
    public function addItemDropdown($sLabelAcao, $sClasse, $sMetodo, $sParametro,$bHiden,$sParamAdicional,$bNewAba,$sNomeModal,$bModal,$sTitulo,$bMultiSelect){
        $aItem['label'] = $sLabelAcao;
        $aItem['classe'] = $sClasse;
        $aItem['metodo'] = $sMetodo;
        $aItem['parametro'] = $sParametro;
        $aItem['id'] = Base::getId();
        $aItem['hiden'] = $bHiden;
        $aItem['paramadicional']=$sParamAdicional;
        $aItem['newaba'] = $bNewAba;
        $aItem['nomeModal'] = $sNomeModal;
        if($bModal){
            $sModal = 'data-target="#'.$aItem['nomeModal'].'" data-toggle="modal"';//'.$aItem['id'].'
            $aItem['bModal'] = true;
        }
        $aItem['modal'] = $sModal;
        $aItem['titulo'] = $sTitulo;
        $aItem['bMultiSelect'] = $bMultiSelect;
        $this->aItensDropdown[] = $aItem;
    }
    
    public function getDesativado($bDesativo){
        if($bDesativo){
            return 'disabled';
        }
    }
   
    

    

    public function getRender($sIdTela){
        switch ($this->getITipo()){
            
            case self::TIPO_PADRAO:
              $sTipo = "default";  
            break;
            case self::TIPO_SUCESSO:
              $sTipo = "success";  
            break;
            case self::TIPO_ERRO:
              $sTipo = "danger";  
            break;
            case self::TIPO_DARK:
              $sTipo = "dark";  
            break;
            case self::TIPO_ERRO:
              $sTipo = "danger";  
            break;
            case self::TIPO_INFO:
              $sTipo = "info";  
            break;
            case self::TIPO_AVISO:
              $sTipo = "warning";  
            break;
            case self::TIPO_PRIMARY:
              $sTipo = "primary";  
            break;
        }
        $sDropdown = '<div class="col-lg-'.$this->getSTelaGrande().' col-md-'.$this->getSTelaMedia().' col-sm-'.$this->getSTelaPequena().' col-xs-'.$this->getSTelaMuitoPequena().' btn-acao-grid">'
                    .'<div class="dropdown">'
                    .'<button type="button" class="btn btn-outline btn-'.$sTipo.'  btn-sm margin-btn dropdown-toggle" id="'.$this->getSId().'" data-toggle="dropdown" aria-expanded="false"'.$this->getDesativado($this->getBDesativado()).'>' 
                    .'<i class="icon wb-settings" aria-hidden="true"></i>'.$this->getSLabel()
                    .'<span class="caret"></span>'
                    .'</button>'
                    .'<ul class="dropdown-menu" aria-labelledby="'.$this->getSId().'" role="menu">';
                    $aDrop = $this->aItensDropdown;
                    if(!is_null($aDrop)){
                        foreach ($this->aItensDropdown as $aItem){
                          //verifica se deve dar hiden na consulta
                          if($aItem['hiden']){$sHiden =' $("#'.$sIdTela.'consulta").hide();';}else{$sHiden='';};
                          $sDropdown .= '<li id="'.$aItem['id'].'" role="presentation" ><a href="#" role="menuitem" '.$aItem['modal'].'> '.$aItem['label'].'</a></li>';  //data-target="#examplePositionCenter" data-toggle="modal"
                          
                           $sAcao .= '$("#'.$aItem['id'].'").click(function(){ '
                                    .'var nrEach = $("#'.$sIdTela.'consulta tbody .selected").length;'
                                    .'if(nrEach==0){requestAjax("","'.$aItem['classe'].'","msgReg",abaSelecionada +"control,'.$sIdTela.','.$aItem['paramadicional'].'");}else{'
                                    .'var contP = 0;'
                                    .'var contChave=[];'
                                    .'var chave="";'
                                    .'$("#'.$sIdTela.'consulta tbody .selected").each(function(){'
                                    .'chave = $(this).find(".chave").html();';
                                   
                                  
                              
                                    
                                    $sAcao .='});';
                                    
                                    //monta a chave com as linhas selecionadas
                                    $sAcao .='$("#'.$sIdTela.'consulta tbody .selected").each(function(){'
                                    .'contChave[contP]=$(this).find(".chave").html();'
                                    .'contP++;'
                                    . '});';

                                  
                                   //$sAcao .='alert(chave);';
                                    if($aItem['bModal']){
                                      $sAcao .='requestAjax("","'.$aItem['classe'].'","'.$aItem['metodo'].'","'.$sIdTela.','.$aItem['id'].',"+chave,"'.$aItem['paramadicional'].'");';
                                    }
                                    if ($aItem['newaba']){
                                       $sAcao .='verificaTab("menu-2-est","1-est","'.$aItem['classe'].'","'.$aItem['metodo'].'","tabmenu-2-est","'.$aItem['titulo'].'",chave+","+"'.$aItem['paramadicional'].'");';   
                                    }
                                    if($aItem['bMultiSelect']){
                                      $sAcao .='requestAjax("","'.$aItem['classe'].'","'.$aItem['metodo'].'",abaSelecionada +"control,'.$sIdTela.',"+chave,contChave);';
                                    }
                                    if($aItem['newaba']==null && $aItem['bModal']==null && $aItem['bMultiSelect']==null){
                                       $sAcao .='requestAjax("","'.$aItem['classe'].'","'.$aItem['metodo'].'",abaSelecionada +"control,'.$sIdTela.',"+chave,"'.$aItem['paramadicional'].'");';
                                    }
                                    
                                   
                                    
                                    $sAcao .=$sHiden;
                                    $sAcao .='}});';
                       }
                    }
        $sDropdown .='</ul>'
                    .'</div>'
                    .'</div>'
                    .'<script type="text/javascript">'
                    .'$(document).ready(function() {'
                    .$sAcao
                    .'});'
                    .'</script>';
        
       
                 
    
        return $sDropdown;
    }

}