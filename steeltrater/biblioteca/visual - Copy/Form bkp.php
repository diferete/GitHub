<?php
/**
 * Classe que implementa a tela do sistema
 *
 * @author Avanei Martendal
 * @since 11/11/2015
 */
class Form {
    private $sId; //id
    private $sTitulo; //title
    private $sRender;
    private $sRenderHide;
    private $sIdFecha;
    private $aBotoes; //buttons
    private $aCampos; //campos da tela
    private $oLayout; //define o layout da tela
    private $aEtapas; //define as etapas do processo
    private $AcaoConfirmar;
    private $IdBtnConfirmar;
    private $bSomanteForm; //define que deve retornar o render apenas do form
    private $aGrid;//adiciona grids na tela
    private $sController;//controle para pegar os dados
    private $bTela;
    private $CallbackSuccess;
    private $CallbackError;
    private $aValidacao;
    private $sCampoFocus;

  
    /**
     * Construtor da classe Form 
     * 
     * O único parâmetro obrigatório refere-se ao título da tela
     */
    function __construct($sTitulo) {
        $this->sId = Base::getId();
        $this->setTitulo($sTitulo);
        $this->aCampos = array();
        $this->aBotoes = array();
        $this->aCampos = array();
        $this->aEtapas = array();
        $this->sIdFecha = Base::getId();
        $this->setBSomanteForm(false);
        $this->oLayout = new Layout();
        $this->aGrid = array();
        $this->CallbackSuccess = '';
        
        $this->aValidacao = array();
       }
    
    function getBTela() {
           return $this->bTela;
       }

    function setBTela($bTela) {
           $this->bTela = $bTela;
       }

       
    function getAGrid() {
        return $this->aGrid;
    }

    function setAGrid($aGrid) {
        $this->aGrid = $aGrid;
    }

    public function addGrid(){
        $aGrids = func_get_args();    
        
        foreach ($aGrids as $oGrid) {
            $this->aGrid[] = $oGrid;
        } 
    }


       
       function getAEtapas() {
           return $this->aEtapas;
       }

       function setAEtapas($aEtapas) {
           $this->aEtapas = $aEtapas;
       }

              
       /**
        * 
        * Retorna o elemento id do fechamento da tela no x
        */
       function getSIdFecha() {
           return $this->sIdFecha;
       }
      
      /**
       * 
       * Define o id do fechamento da tela no x
       */
       function setSIdFecha($sIdFecha) {
           $this->sIdFecha = $sIdFecha;
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
     * Retorna o conteúdo do atributo sTitulo
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
     * 
     * Retorna o conteúdo de onde a tela deve ser renderizada
     */
    function getSRender() {
        return $this->sRender;
    }
    
     /**
     *
     *  Retorna o conteúdo que deve receber um show apos fechar a tela
     */
    function getSRenderHide() {
        return $this->sRenderHide;
    }
   /**
    * 
    * Define onde a tela deve ser renderizada
    */
    function setSRender($sRender) {
        $this->sRender = $sRender;
    }
    /**
     * 
     * Define onde será dado um show ao fechar a tela
     */
    function setSRenderHide($sRenderHide) {
        $this->sRenderHide = $sRenderHide;
    }
    function getAcaoConfirmar() {
        return $this->AcaoConfirmar;
    }

    function setAcaoConfirmar($AcaoConfirmar) {
        $this->AcaoConfirmar = $AcaoConfirmar;
    }
    function getIdBtnConfirmar() {
        return $this->IdBtnConfirmar;
    }

    function setIdBtnConfirmar($IdBtnConfirmar) {
        $this->IdBtnConfirmar = $IdBtnConfirmar;
    }

    function getBSomanteForm() {
        return $this->bSomanteForm;
    }

    function setBSomanteForm($bSomanteForm) {
        $this->bSomanteForm = $bSomanteForm;
    }

    function getController() {
        return $this->sController;
    }

    function setController($sController) {
        $this->sController = $sController;
    }
    function getCallbackSuccess() {
        return $this->CallbackSuccess;
    }

    function setCallbackSuccess($CallbackSuccess) {
        $this->CallbackSuccess = $CallbackSuccess;
    }
    function getCallbackError() {
        return $this->CallbackError;
    }

    function setCallbackError($CallbackError) {
        $this->CallbackError = $CallbackError;
    }

    function getAValidacao() {
        return $this->aValidacao;
    }

    function setAValidacao($aValidacao) {
        $this->aValidacao = $aValidacao;
    }
    function getSCampoFocus() {
        return $this->sCampoFocus;
    }

    function setSCampoFocus($sCampoFocus) {
        $this->sCampoFocus = $sCampoFocus;
    }

                                    
    
   /**
     * Retorna o conteúdo do vetor de botões na estrutura que 
     * deverá ser renderizado
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
     * Adiciona um botão ao vetor de botões do objeto
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
     * Retorna o array de campos a ser utilizado pelas classes externas
     * Pode ser retornada apenas a posição desejada ou todo o vetor
     * 
     * @param integer $iPosicao Posição do vetor a ser retornada (opcional)
     * 
     * @return Array
     */
    public function getCampos($iPosicao = -1){
        return $iPosicao === -1 ? $this->aCampos : $this->aCampos[$iPosicao];
    }
    
   /**
     * Método que adiciona os campos criados na tela
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
            $this->oLayout->addItems($campoAtual); //Verificar o oLayout
        }
    }
    
    /**
     * Adiciona itens ao vetor de elementos do objeto
     */     
    private function addCampoTela($oCampo) {
        $this->aCampos[] = $oCampo;
    }
    
    /**
     * Retorna o objeto de layout
     */
    public function getLayout(){
        return $this->oLayout;
    }
    /**
     * Retorna um campo da lista de campos a partir do nome do mesmo
     * 
     * @param String $sNome Nome do campo a ser localizado
     * 
     * @return Object/null Retorna o objeto desejado ou nulo caso não encontrado
     */
    public function getCampoByName($sNome){
        $oReturn = null;
        
        foreach ($this->getCampos() as $oCampo) {
            if(method_exists($oCampo, 'getCampos')){
                $oReturn = $oCampo->getCampoByName($sNome);
                if($oReturn != null){
                    break;
                }
            } else{
                if(method_exists($oCampo, 'getNome')){                
                    if(strtolower($oCampo->getNome()) === strtolower($sNome)){
                        $oReturn = $oCampo;
                        break;
                    }
                }
            }
        }
        return $oReturn;
    }
    /**
     * Define as etapas do form
     */
    function addEtapa(){
        $aEtapasIns = func_get_args();
        foreach ($aEtapasIns as $oEtapa) {
            $this->aEtapas[]=$oEtapa;
            }
    }
           
    /** 
     * Gera a string para renderizar a tela
     */
    public function getRender(){
        $sBotao = '';
        //renderiza os botões
        foreach ($this->aBotoes as $key => $oBotao){
            $sBotao.=$oBotao->getRender();  
        }
        //renderiza os campos
        $sConteudo = $this->oLayout->getRender();
        //renderizar os eventos
        $sEventos = '';
        foreach ($this->aBotoes as $key => $oBotao){
            $sEventos.=$oBotao->getAAcao(); 
            if($oBotao->getITipo() == Botao::TIPO_CONFIRMAR ){
                $this->setAcaoConfirmar($oBotao->getRequestAjax());
                $this->setIdBtnConfirmar($oBotao->getId());
            }
        }

           foreach ($this->oLayout->getItems() as $key => $oCampo) {
               $this->verificaTipoCampo($oCampo);
            }
        //Monta as etapas se necessário
        $sEtapa = '';
        $aEtapa = $this->getAEtapas();
        if(!empty($aEtapa)){
        foreach ($this->getAEtapas() as $keyEtapa => $oEtapa) {
           $sEtapa = $oEtapa->getRender(); 
        }
        }else{$sEtapa='<h3 class="panel-title">'.$this->getTitulo().'</h3>';}
        //monta somente o form
  $sForm = '<form class="form-horizontal" id="'.$this->getId().'-form" >'
               //renderiza os campos
              .$sConteudo;
              $aGrid = $this->getAGrid();
              if (empty($aGrid)){
             $sForm .='<div class="row btn-padroes-form">'
               //renderizar os botões
              . $sBotao
              .'</div>';
              }      
             $sForm .='<div id="'.$this->getId().'-msg">'
              .'</div>';
             $sForm.=$this->getRenderDet();
              $sForm.='</form>';
  // $sForm.=$this->getRenderDet();
       //se o form retorna toda a tela       
      if (!$this->getBSomanteForm()){
       $sTela = '<div class="panel panel-bordered" id="'.$this->getId().'">'
              .'<div class="panel-heading">'
              .$sEtapa
              .'<div class="panel-actions">';
              if(!$this->getBTela()){
                $sTela.= '<a class="panel-action icon wb-close" id="'.$this->getSIdFecha().'" aria-hidden="true"></a>'; 
              }
              $sTela.='</div>'
              .'</div>'
              .'<div id="'.$this->getId().'-body"class="panel-body">'//Base::getId()
              .$sForm 
              .$this->getRenderDet()
              .'</div>';
      }  else {
        $sTela.=$sForm;    
      }
        //eventos da tela
       $sListener.='<script>';
          if (!$this->getBSomanteForm()){    
              $sListener.='$("#'.$this->getSIdFecha().'").click(function(){$("#'.$this->getId().'").remove();'
               .'$("#'.$this->getSRenderHide().'consulta").toggle();});';
          }
       $sListener.= ''.$sEventos.'';
               
       

               //inicio validação
     $Validacao .= //'(function() {'
                'var form = $("#'.$this->getId().'-form").formValidation({'
                  .'framework: "bootstrap",'
                   .' button: {'
                    .'    selector: "#'.$this->getIdBtnConfirmar().'",'
                    .'    disabled: "disabled"'
                   .'   },'
             //inicio icone
                  .'icon: {'
             . 'valid: "icon wb-check",'
                 // .'invalid: "icon wb-close",'
                  .'validating: "icon wb-refresh"'
                . '},'
             .'        locale: "pt_BR",'
             //fim icone
                  .'fields: {';
     
          foreach ($this->getAValidacao() as $key => $oValidacao){
            if($key==0){ 
              $sValidation .= $oValidacao->getRender();
              }else
              {
                $sValidation .=','. $oValidacao->getRender();  
              }
          }
    $Validacao .= $sValidation 
                .'}'
                .'}).on("success.form.fv", function(e){'
                  //  .'console.log(e); '
                  //  .'var form = $(e.target); '
                    .$this->getAcaoConfirmar()
                    .$this->getCallbackSuccess()
                    .'if (form.fv.getSubmitButton()) { '
                        .'form.fv.disableSubmitButtons(false); '
                    .'} '
                .'}) ;';
//              .'})(); '
  
    $sListener .= $Validacao;
    $sListener .= '$("#'.$this->getIdBtnConfirmar().'").on("click", function(){'
                    .' form.formValidation("validate");'
                   .'});';
     //se for somente form renderiza o form
    
        $sTela.=$sListener.'</script></div>'; 
  
      
      $sRetorno = "$('#".$this->getSRender()."').append('".$sTela."');"
                   ."".$this->getSCampoFocus()."";
       
       //se for uma etapa renderiza somente o form
      
           $fp = fopen("bloco1.txt", "w");
            fwrite($fp, $sRetorno);
            fclose($fp);
       
      echo $sRetorno;
    }
    
    /**
     * Método que renderiza o grid detalhe 
     */
    public function getRenderDet(){
      //verifica se deve ser renderizado grid
      foreach ($this->getAGrid() as $key => $oGrid) {
          $oGrid->setController($this->getController());
          $oGrid->setBDetalhte(TRUE);
          $oGrid->setSRenderTo($oGrid->getSId().'div');
          $sGridDetalhe =$oGrid->getRender();
          //renderiza botões dos grid detalhe
           //ação do botão excluir
       $sAcao = ' $("#'.$oGrid->getSId().'div tbody .selected").each(function(){'
                     .'var chave = $(this).find(".chave").html();'
                     .'requestAjax("","'.$this->getController().'","'.View::ACAO_EXCLUIR.'",chave +",'.$oGrid->getSId().',true");'
                     .'});';
          $oBtnDelete = new Botao('Remover', Botao::TIPO_DELDETALHE, $sAcao);
      
      //busca campo do focus
      $sIdCampoFocus = $this->getIdCampoFocus();
       $sAcao='vCampos = new Array (); '
                            .'$("#'.$oGrid->getSId().' tbody .selected").each(function(){ '
                            .'var altchave = $(this).find(".chave").html(); '
                            .$this->camposAlt()
                            .'requestAjax("","'.$this->getController().'","carregaDetalhe",altchave,vCampos); '
                            .'$("#'.$sIdCampoFocus.'" ).focus();'
                            .'});';
          $oBtnAlterar = new Botao('', Botao::TIPO_ALTERARDET, $sAcao); 
          
          $sGrid .= ' <div class="row" id="'.$oGrid->getSId().'div">'
                 .'<div class="row">'
                 .$oBtnDelete->getRender()
                 .$oBtnAlterar->getRender()
                 .'</div>'
               . $sGridDetalhe;
             
         //carrega 
          $sGrid .='<div class="row btn-padroes-form">';
               //renderizar os botões
             foreach ($this->aBotoes as $key => $oBotao){
             $sBotao.=$oBotao->getRender();  
           }
          $sGrid .= $sBotao.'</div></div>';
      }
      return $sGrid;
    }
    /**
     * Método que retorna um array para alteração dos campos
     */
    public function camposAlt(){
      // if(is_a($oAtualTela, 'Campo')) {
        foreach ($this->getCampos() as $key => $oCampo) {
           if(is_a($oCampo,'Campo')){
            if(!$oCampo->getApenasTela()){
                if (($oCampo->getITipo()!=Campo::TIPO_BOTAOSMALL)){
                   $sAlt .='vCampos['.$key.'] = "'.$oCampo->getNome().','.$oCampo->getId().'"; ';   
                }
               }
           }
        }
       
        return $sAlt;
    }
    
    
    function getValidacao($aParam){
        if(!empty($aParam)){
            $this->aValidacao[] = new Validacao($aParam['id'], $aParam['xs'],$aParam['nome'], $aParam['descricao'], $aParam['campovazio'], $aParam['tipo'],$aParam['strMin'],$aParam['strMax'], $aParam['campoigual'], $aParam['regex'], $aParam['callback'], $aParam['trigger']);      
        }
        
    }
    
    /**
     * 
     * @param type $oCampo
     * @author Carlos
     */
    function getFocus($oCampo){
        if($oCampo->getBFocus()){
            $this->sCampoFocus .= $oCampo->getRenderFocus();
        }
    }
    /**
     * Método que itera objetos e arrays,
     * até chegar ao objeto tipo campo e aplicar os métodos atribuidos na form
     * 
     * Obs: Todo e qualquer método, da classe Form, que for necessário
     * aplicar/chamar em algum objeto da classe Campo,
     * deverão ser aplicados dentro deste método.
     * 
     * @param object $oCampo
     * @author Carlos
     */
   public function verificaTipoCampo($oCampo){
        switch ($oCampo){
             case  is_a($oCampo, 'Campo'):
                 //Métodos devem serem chamados aqui
                $this->getFocus($oCampo);
                $this->getValidacao($oCampo->getAValidacao());
            break;
            case is_array($oCampo):
                foreach ($oCampo as $oCampoArray){
                    $this->verificaTipoCampo($oCampoArray);
                }
            break;
            case  is_a($oCampo, 'FieldSet'):
                foreach($oCampo->getACampos() as $oFsCampo){
                    $this->verificaTipoCampo($oFsCampo);
                }
            break;
            case  is_a($oCampo, 'TabPanel'):
                foreach($oCampo->getItems() as $Aba){
                    foreach($Aba->getACampos() as $AbaCampo){
                        $this->verificaTipoCampo($AbaCampo);
                    }
                }
            break;
        }
    }
    
    /**
     * Método que retorna o id do campo focus
     */
    public function getIdCampoFocus(){
        foreach ($this->getCampos() as $key => $oCampo) {
             if($oCampo->getBFocus()){
               $sIdCampoFocus .= $oCampo->getId();
               break;
             }
        }
        return $sIdCampoFocus;
    }
}
?>

