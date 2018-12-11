<?php

/* 
 * Classe que gerencia a busca de representantes por estado
 * @author: Alexandre
 * @since: 19/01/2018
 * 
 */

class ViewBuscaRepSite extends View {
    function __construct() {
        parent::__construct();
    }
    
    
    public function criaConsulta() {
        parent:: criaConsulta();
        
      
        
        $oFilcgc = new CampoConsulta('Empresa','filcgc');
        $oCodigo = new CampoConsulta('Código','codigo');
        $oEstado = new CampoConsulta('Estado','estado');
        $oNome = new CampoConsulta('Representante','nome');
        
        $oFiltroEstado = new Filtro($oEstado, Filtro::CAMPO_TEXTO_IGUAL,2,2,2,2);
        $oFiltroRep = new Filtro($oNome, Filtro::CAMPO_TEXTO,4,4,12,12);
        $this->addFiltro($oFiltroEstado,$oFiltroRep);
        
        $this->addCampos($oFilcgc,$oCodigo,$oEstado,$oNome);
    
    }
    
    public function criaTela() {
        parent::criaTela();
        
        
        $oFilcgc = new Campo('Empresa','filcgc', Campo::TIPO_TEXTO,2,2,12,12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oFilcgc->setBCampoBloqueado(true);
        $oCodigo = new Campo('Código','codigo',Campo::TIPO_TEXTO,1,1,12,12);
        $oCodigo->setBCampoBloqueado(true);
        
        $oUfRep = new Campo('UF Escritório', 'ufrep', Campo::CAMPO_SELECT,3,3,12,12);
        $oUfRep->addItemSelect('AC', 'ACRE');
        $oUfRep->addItemSelect('AL', 'ALAGOAS');
        $oUfRep->addItemSelect('AP', 'AMAPA');
        $oUfRep->addItemSelect('AM', 'AMAZONAS');
        $oUfRep->addItemSelect('BA', 'BAHIA');
        $oUfRep->addItemSelect('CE', 'CEARA');
        $oUfRep->addItemSelect('DF', 'DISTRITO FEDERAL');
        $oUfRep->addItemSelect('ES', 'ESPIRITO SANTO');
        $oUfRep->addItemSelect('GO', 'GOIAS');
        $oUfRep->addItemSelect('MA', 'MARANHAO');
        $oUfRep->addItemSelect('MT', 'MATO GROSSO');
        $oUfRep->addItemSelect('MS', 'MATO GROSSO DO SUL');
        $oUfRep->addItemSelect('MG', 'MINAS GERAIS');
        $oUfRep->addItemSelect('PA', 'PARA');
        $oUfRep->addItemSelect('PB', 'PARAIBA');
        $oUfRep->addItemSelect('PR', 'PARANA');
        $oUfRep->addItemSelect('PE', 'PERNAMBUCO');
        $oUfRep->addItemSelect('PI', 'PIAUI');
        $oUfRep->addItemSelect('RJ', 'RIO DE JANEIRO');
        $oUfRep->addItemSelect('RN', 'RIO GRANDE DO NORTE');
        $oUfRep->addItemSelect('RS', 'RIO GRANDE DO SUL');
        $oUfRep->addItemSelect('RO', 'RONDONIA');
        $oUfRep->addItemSelect('RR', 'RORAIMA');
        $oUfRep->addItemSelect('SC', 'SANTA CATARINA');
        $oUfRep->addItemSelect('SP', 'SAO PAULO');
        $oUfRep->addItemSelect('SE', 'SERGIPE');
        $oUfRep->addItemSelect('TO', 'TOCANTINS');
        
        $oEstado = new Campo('Estado','estado', Campo::CAMPO_SELECT,3,3,12,12);
        $oEstado->addItemSelect('AC', 'ACRE');
        $oEstado->addItemSelect('AL', 'ALAGOAS');
        $oEstado->addItemSelect('AP', 'AMAPA');
        $oEstado->addItemSelect('AM', 'AMAZONAS');
        $oEstado->addItemSelect('BA', 'BAHIA');
        $oEstado->addItemSelect('CE', 'CEARA');
        $oEstado->addItemSelect('DF', 'DISTRITO FEDERAL');
        $oEstado->addItemSelect('ES', 'ESPIRITO SANTO');
        $oEstado->addItemSelect('GO', 'GOIAS');
        $oEstado->addItemSelect('MA', 'MARANHAO');
        $oEstado->addItemSelect('MT', 'MATO GROSSO');
        $oEstado->addItemSelect('MS', 'MATO GROSSO DO SUL');
        $oEstado->addItemSelect('MG', 'MINAS GERAIS');
        $oEstado->addItemSelect('PA', 'PARA');
        $oEstado->addItemSelect('PB', 'PARAIBA');
        $oEstado->addItemSelect('PR', 'PARANA');
        $oEstado->addItemSelect('PE', 'PERNAMBUCO');
        $oEstado->addItemSelect('PI', 'PIAUI');
        $oEstado->addItemSelect('RJ', 'RIO DE JANEIRO');
        $oEstado->addItemSelect('RN', 'RIO GRANDE DO NORTE');
        $oEstado->addItemSelect('RS', 'RIO GRANDE DO SUL');
        $oEstado->addItemSelect('RO', 'RONDONIA');
        $oEstado->addItemSelect('RR', 'RORAIMA');
        $oEstado->addItemSelect('SC', 'SANTA CATARINA');
        $oEstado->addItemSelect('SP', 'SAO PAULO');
        $oEstado->addItemSelect('SE', 'SERGIPE');
        $oEstado->addItemSelect('TO', 'TOCANTINS');
        
        $oPais = new Campo('País','pais', Campo::CAMPO_SELECT,2,2,12,12);
        $oPais->addItemSelect('BR','BRASIL');
        $oPais->addItemSelect('AR','ARGENTINA');
        
        $oLogo = new Campo('Upload da Logo','logo', Campo::TIPO_UPLOAD,4,4,12,12);
        $oNome = new Campo('Nome do Escritório','nome', Campo::TIPO_TEXTO,6,6,12,12);
        
        $oEndereco = new Campo('Endereço','endereco', Campo::TIPO_TEXTO,4,4,12,12);
        $oCep = new Campo('CEP','cep', Campo::TIPO_TEXTO,2,2,12,12);
        $oBairro = new Campo('Bairro','bairro', Campo::TIPO_TEXTO,4,4,12,12);
        $oCidade = new Campo('Cidade','cidade', Campo::TIPO_TEXTO,3,3,12,12);
        
        $oFone1 = new Campo('Fone 1','fone1', Campo::TIPO_TEXTO,3,3,12,12);
        $oFone2 = new Campo('Fone 2','fone2', Campo::TIPO_TEXTO,3,3,12,12);
        
        $oEmail1 = new Campo('E-mail 1','email1', Campo::TIPO_TEXTO,4,4,12,12);
        $oEmail2 = new Campo('E-mail 2','email2', Campo::TIPO_TEXTO,4,4,12,12);
        $oWebsite = new Campo('Site', 'website', Campo::TIPO_TEXTO,4,4,12,12);
        

        
        
        $this->addCampos(array($oFilcgc,$oCodigo,$oNome),array($oEstado,$oPais,$oUfRep),array($oCep,$oCidade,$oBairro,$oEndereco,),array($oFone1,$oFone2),array($oEmail1,$oEmail2),$oWebsite,$oLogo);

    }
    
    
}
