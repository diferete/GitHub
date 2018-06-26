<?php

/**
 * Classe que implementa ViewPessoa
 */
class ViewPessoa extends View{
    function __construct() {
        parent::__construct();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oEmpoCod = new CampoConsulta('Código','empcod', CampoConsulta::TIPO_LARGURA,20);
        $oEmpDes = new CampoConsulta('Empresa', 'empdes', CampoConsulta::TIPO_LARGURA,20);
        $oEmpSit = new CampoConsulta('Situação','empativo');
        $oEmpSit->addComparacao('B', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        
        $oEmpSitCred = new CampoConsulta('Situação Crédito','empblocred');
        $oEmpSitCred->addComparacao('B', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        
        $oCidade = new CampoConsulta('Cidade','Cidcep.cidnome', CampoConsulta::TIPO_LARGURA,15);
        
        
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $FiltroEmpcod = new Filtro($oEmpoCod, Filtro::CAMPO_TEXTO_IGUAL,2);
        $FiltroEmpdes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO,3);
        
         
         
        $this->addCampos($oEmpoCod,$oEmpDes,$oEmpSit,$oCidade,$oEmpSitCred);
        $this->addFiltro($FiltroEmpcod,$FiltroEmpdes);
        $this->setBScrollInf(TRUE);
    }
    
    public function criaTela() {
        parent::criaTela();
        $this->setTituloTela('Cadastro de Clientes e Fornecedores');
        $oEmpCod = new Campo('Código','empcod', Campo::TIPO_TEXTO,2);
        $oEmpdes = new Campo('Empresa','empdes', Campo::TIPO_TEXTO,4);
        $oEmpCnpj = new Campo('Cnpj/Cpf','empcnpj', Campo::TIPO_TEXTO,2);
        $oEmpCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpSit = new Campo('Situação','empativo', Campo::TIPO_SELECT,2);
        $oEmpSit->addItemSelect('S', 'Ativo');
        $oEmpSit->addItemSelect('N','Inativo');
        
        $oEmpSitCred = new Campo('Situação Crédito','empblocred', Campo::TIPO_SELECT,2);
        $oEmpSitCred->addItemSelect('B', 'Bloqueado');
        
        $oEmpfant = new Campo('Fantasia','empfant', Campo::TIPO_TEXTO,3);
     
        $oEmpFone = new Campo('Telefone','empfone', Campo::TIPO_TEXTO,2);
        $oEmpFone->setBFone(true);
        
        $oEmailGeral = new Campo('E-mail','empinterne', Campo::TIPO_TEXTO,2);
        
        $oEmpEnd = new Campo('Endereço','empend', Campo::TIPO_TEXTO,3);
        
        $oEmpBair = new Campo('Bairro','empendbair', Campo::TIPO_TEXTO,2);
        
        $oEmpEstCod = new Campo('Estado','Cidcep.estcod', Campo::TIPO_TEXTO,1);
        
        $oCep = new Campo('CEP','Cidcep.cidcep', Campo::TIPO_TEXTO,2);
        $oCep->setBCEP(true);
        
        $oEmpIns = new Campo('Inscrição Estadual','empins', Campo::TIPO_TEXTO,2);
        
        $oCidade = new Campo('Cidade','Cidcep.cidnome', Campo::TIPO_TEXTO,2);
        
        $oObs = new Campo('Observações','empobs', Campo::TIPO_TEXTAREA,6);
        $oObs->setILinhasTextArea(7);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oEmpUser = new Campo('Usuário de cadastro','empausucad', Campo::TIPO_TEXTO,2);
        $oDataca = new Campo('Data cadastro','empadtcad', Campo::TIPO_DATA,2);
        
        $oRepcod = new Campo('Representante','repcod', Campo::TIPO_TEXTO,1);
        
        $oTab = new TabPanel();
        $oTabGeral = new AbaTabPanel('Dados Gerais');
        $this->addLayoutPadrao('Aba');
        $oTabGeral->setBActive(true);
       
        $oTabGeral->addCampos(array($oEmpCod,$oEmpdes,$oEmpCnpj),array($oEmpfant,
                $oEmpFone),array(/*$oEmailGeral,*/$oEmpEnd, $oEmpBair,$oCidade,$oEmpEstCod),array($oCep,$oEmpIns),$oObs,
                array($oEmpUser,$oDataca),$oRepcod,$oEmpSitCred,$oEmpSit);
        $oTab->addItems($oTabGeral);
        
        $this->addCampos($oTab);
        /*$oTab = new TabPanel();
        $oTabUser = new AbaTabPanel('Cadastro Geral');
        $oTabPerfil = new AbaTabPanel('Perfil');
        $this->addLayoutPadrao('Aba');
        $oTabUser->setBActive(true);
       
        $oTabUser->addCampos($oUsucodigo, $oUserNome,$UsuLogin,$Ususenha,$UsuBloqueado,$oUsuEmail,$oFilcgc,$oOfficeCod);
        $oTabPerfil->addCampos($oUsuimagem);
        $oTab->addItems($oTabUser,$oTabPerfil);*/
        
    }


    /*  public function criaTela() {
        parent::criaTela();
        
        $oPesCod = new Campo('Código', 'pescod',  Campo::TIPO_TEXTO,'1');
        $oPesCod->setBCampoBloqueado(true);
        
        $oPesNome = new Campo('Nome', 'pesnome');
        
        $oPesDataNasc = new Campo('Data Nasc.', 'pesdatanasc', Campo::TIPO_DATA,'2');
        $oPesDataNasc->setSValor(date('d/m/Y'));
        
        $oPesEmail = new Campo('Email', 'pesemail', Campo::TIPO_TEXTO,'3','3','3','12');
        $oPesEmail->addValidacao(true, Validacao::TIPO_EMAIL, 'Email inválido');
        //$oPesEmail->setITamanho(Campo::TAMANHO_GRANDE);
        
        $oPesNomeCad = new Campo('Cadastrado por', 'pesnomecad');
       // $oPesNomeCad->setSValor($_SESSION['nome']);
        $oPesNomeCad->setBCampoBloqueado(true);
        
        $oPesDataCad = new Campo('Cadastrado em', 'pesdatacad',  Campo::TIPO_DATA,'2');
       // $oPesDataCad->setSValor(date('d/m/Y'));
        $oPesDataCad->setBCampoBloqueado(true);
        
        $oField1 = new FieldSet('Título');
        $oField1->addCampos($oPesNome, $oPesDataNasc, $oPesEmail);
        
        $oFild2 = new FieldSet('FieldSet 2');
        $oFild2->addCampos($oPesNomeCad,$oPesDataCad);
        
        
        $this->addCampos($oPesCod, $oField1, $oFild2);
    }*/
    
 /*   function RelatorioTeste(){
        parent::criaTelaRelatorio();
        $this->setTituloTela('Relatório de Pessoas');
        //Nome do Campo será o nome que deverá dar-se o request no arquivo do relatório
        $oCampoData1 = new Campo('Data Inicial', 'datainicial', Campo::TIPO_DATA);
        $oCampoData2 = new Campo('Data Final', 'datafin', Campo::TIPO_DATA);       
        
        $this->addCampos($oCampoData1, $oCampoData2);
    }*/
}
