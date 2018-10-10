<?php

/**
 * Classe que implementa a estrutura do layout dos objetos nos componentes 
 * de tela
 *
 * @author Avanei Martendal
 * @since 17/11/2015
 */
class Layout {

    private $aItems;
    private $aLarguraLabel;
    private $sTipoLayout;

    /**
     * Construtor da classe Layout
     */
    function __construct() {
        $this->aItems = array();
        $this->aLarguraLabel = array();
    }

    /**
     * Retorna o objeto de layout
     */
    public function getLayout() {
        return $this->oLayout;
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
     * Adiciona itens ao vetor que define os elementos do layout
     */
    public function addItems($aItems) {
        $this->aItems[] = $aItems;
    }

    /**
     * 
     * Retorna o layout
     *
     */
    function getSTipoLayout() {
        return $this->sTipoLayout;
    }

    /**
     * 
     * seta o layou
     *
     */
    function setSTipoLayout($sTipoLayout) {
        $this->sTipoLayout = $sTipoLayout;
    }

    /**
     * Função para recuperar a renderização
     */
    public function getRender() {
        //verifica se Ã© tab ou nÃ£o 
        if ($this->getSTipoLayout() == 'Aba') {
            foreach ($this->aItems as $key => $oTab) {
                //verifica se Ã© array
                if (is_array($oTab)) {
                    $sTab .= $this->getRenderCampos($oTab);
                } else {

                    //verifica se nÃ£o Ã© campo
                    if (get_class($oTab) === 'Campo') {
                        $sTab .= $this->getRenderCampos($oTab);
                    } else {
                        //abre a novo conjunto de abas
                        $sTab .= $oTab->getRender();
                        //renderizar as abas
                        $sAbas .= '<ul class="nav nav-tabs nav-tabs-line" data-plugin="nav-tabs" role="tablist">';
                        foreach ($oTab->getItems() as $key => $oAba) {
                            $sAbas .= $oAba->getRenderAba();
                        }
                        //fecha ul das abas
                        $sAbas .= '</ul>';
                        //inicia a renderizaÃ§Ã£o do conteÃºdo
                        $sContAbas .= ' <div class="tab-content padding-top-20">';
                        foreach ($oTab->getItems() as $key => $oContAba) {
                            //inicializa o conteÃºdo
                            $sContAbas .= $oContAba->getRenderContAba();
                            //renderiza os campos
                            foreach ($oContAba->getACampos() as $key => $aCampo) {
                                if (is_array($aCampo)) {
                                    $sContAbas .= '<div div class="row">';
                                    foreach ($aCampo as $key => $oCampo) {
                                        $sContAbas .= $oCampo->getRender();
                                    }
                                    $sContAbas .= '</div>';
                                } else {
                                    $sContAbas .= '<div class="row">';
                                    $sContAbas .= $aCampo->getRender();
                                    $sContAbas .= '</div>';
                                }
                            }
                            $sContAbas .= '</div>';
                        }
                        $sContAbas .= '</div>';
                        //finaliza o layout da aba
                        $sTab .= $sAbas . $sContAbas . '</div>';
                    }
                }
            }
            return $sTab;
        } else {
            foreach ($this->aItems as $key => $aCampo) {
                $sTela .= $this->getRenderCampos($aCampo);
            }
            return $sTela;
        }
    }

    public function getRenderCampos($aCampo) {

        if (is_array($aCampo)) {
            $sTela .= '<div class="form-group">';
            $sTela .= '<div class="row">';
            foreach ($aCampo as $key => $oCampo) {
                $sTela .= $oCampo->getRender();
            }
            $sTela .= '</div>'
                    . '</div>';
        } else if (is_a($aCampo, 'FieldSet')) {
            $sTela .= '<div class="form-group">';
            $sTela .= $aCampo->getRender();
            $sTela .= '</div>';
        } else {
            $sTela .= '<div class="form-group">';
            $sTela .= $aCampo->getRender();
            $sTela .= '</div>';
        }


        return $sTela;
    }

}

?>