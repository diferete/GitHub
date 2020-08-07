<?php

/* 
 *Implementa a view dos filcgc
 */

class ViewEmpRex extends View{
    function __construct() {
        parent::__construct();
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de empresas do grupo');
        
        $oFilcgc = new Campo('Cnpj','filcgc', Campo::TIPO_TEXTO,2);
        $oFilcgc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oFildes = new Campo('Empresa','fildes', Campo::TIPO_TEXTO,6);
        $oFildes->setITamanho(Campo::TAMANHO_PEQUENO);
        
        $this->addCampos($oFilcgc,$oFildes);
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->setaTiluloConsulta('Consulta empresas Rex Máquinas');
        
        
        $oFilcgc = new CampoConsulta('Cnpj','filcgc', CampoConsulta::TIPO_LARGURA,15);
        $oFildes = new CampoConsulta('Empresa', 'fildes', CampoConsulta::TIPO_LARGURA,15);
        
        $this->addCampos($oFilcgc,$oFildes);
        $this->setUsaAcaoAlterar(FALSE);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
    }
    
    
}