<?php

/**
 * Classe que implementa a estrutura das abas de um TabPanel 
 *
 * @author Fernando Salla
 * @since 31/03/2014
 */
class AbaTabPanel {

    private $sId; //id
    private $sTitulo; //title
    private $aCampos; //items
    private $bActive;
    private $oLayout; //objeto do tipo layout que define o posicionamento dos elementos

    /**
     * Construtor da classe AbaTabPanel 
     * 
     * O único parâmetro obrigatório refere-se ao título da tab
     * 
     * @param string $sTitulo Título da aba
     * @param bollean $bPermiteFechar Controla se a tela permitirá fechamento ou não
     */

    function __construct($sTitulo) {
        $this->sId = Base::getId();
        $this->setTitulo($sTitulo);
        $this->setBActive(FALSE);

        $this->aCampos = array();
        $this->oLayout = new Layout();
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
     * Método que adiciona os campos criados na tela
     */
    public function addCampos() {
        /*  $aCampos = func_get_args();    

          foreach($aCampos as $campoAtual){
          if(is_array($campoAtual)){
          foreach ($campoAtual as $campo){
          $this->addCampoTela($campo);
          }
          } else{
          $this->addCampoTela($campoAtual);
          }

          } */
        $aCampos = func_get_args();

        foreach ($aCampos as $campoAtual) {
            $this->addCampoTela($campoAtual);
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
    public function getLayout() {
        return $this->oLayout;
    }

    /*
     * Recupera o atributo que define a tab ativa
     */

    function getBActive() {
        return $this->bActive;
    }

    /*
     * Define o atributo active
     */

    function setBActive($bActive) {
        $this->bActive = $bActive;
    }

    /**
     * 
     * Retorna os campos da aba
     */
    function getACampos() {
        return $this->aCampos;
    }

    function setACampos($aCampos) {
        $this->aCampos = $aCampos;
    }

    /**
     * Gera a string do objeto para que possa ser renderizado
     * pelo JSON
     * 
     * @return string String do objeto a ser renderizado 
     */
    public function getRenderAba() {
        //verifica a tab ativa
        $this->getBActive() ? $active = 'active' : $active = '';
        $sAbas = '<li class="' . $active . '" role="presentation"><a data-toggle="tab" href="#' . $this->getId() . '" aria-controls="' . $this->getId() . '"'
                . 'role="tab">' . $this->getTitulo() . '</a></li>';

        return $sAbas;
    }

    public function getRenderContAba() {
        //verifica a tab ativa
        $this->getBActive() ? $active = 'active' : $active = '';
        $sAbas = '<div class="tab-pane ' . $active . '" id="' . $this->getId() . '" role="tabpanel">';
        //lembrar tratar active 

        return $sAbas;
    }

}

?>