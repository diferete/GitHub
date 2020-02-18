<?php

class ViewMET_TEC_Modulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oCodigo->setILargura(500);

        // $oCodigo->addComparacao('5','0','2');
        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModulo->setILargura(500);
        //  $oUnidade->addComparacao('4', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_AMARELO);
        // $oUnidade->addComparacao('', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERMELHO);
        // $oUnidade->addComparacao('4', CampoConsulta::COMPARACAO_MENOR, CampoConsulta::COR_VERDE);
        // $oUnidade->setBComparacaoColuna(true);
        //  $this->setUsaDropdown(true);
        //  $oDrop1 = new Dropdown('Drop1 ', Dropdown::TIPO_PADRAO);
        //  $oDrop1->addItemDropdown($this->addIcone(Base::ICON_DESBLOQUEADO).'Logout','usuario', 'acaoLogout', '');
        //  $oDrop1->addItemDropdown($this->addIcone(Base::ICON_BLOQUEADO).'item 2 drop 1','Teste 2', 'Teste metodo 2', '2');
        /* $oDrop2 = new Dropdown('Teste');
          $oDrop2->addItemDropdown('Item 1 drop 2','Drop2', 'Drop2 Metodo', 'Drop2'); */
        // $FiltroCodigo = new Filtro($oCodigo, Filtro::CAMPO_INTEIRO,2);
        // $TesteFiltro = new Filtro($oUnidade, Filtro::CAMPO_TEXTO,3);


        $this->addCampos($oCodigo, $oModulo);

        // $this->addDropdown($oDrop1);
        //  $this->addFiltro($FiltroCodigo,$TesteFiltro);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

    function criaTela() {
        parent::criaTela();

        $this->setTituloTela("Cadastro de Módulos");
        /* $oData1 = new Campo('Data', 'Data', Campo::TIPO_DATA);
          $oData1->setSValor('17/11/2015');
          $oData2 = new Campo('Data2', 'Data', Campo::TIPO_DATA);
          $oData3 = new Campo('data3', 'Data', Campo::TIPO_DATA);
          $oData4 = new Campo('data4', 'Data', Campo::TIPO_DATA);
          $oCEP = new Campo('CEP','cep', Campo::TIPO_TEXTO,'9');
          $oCEP->setBCEP(true);

          $oMoney = new Campo('Money', 'money', Campo::TIPO_MONEY);


          $oFone = new Campo('Fone','fone',  Campo::TIPO_TEXTO);
          $oFone->setBFone(true);

          $oCPF = new Campo('CPF','CPF',  Campo::TIPO_TEXTO);
          $oCPF->setBCPF(true);
          $oCNPJ = new Campo('CNPJ','CNPJ',  Campo::TIPO_TEXTO);
          $oCNPJ->setBCNPJ(true);

          $oSelect = new Campo('Campo Select','select',  Campo::TIPO_SELECT);
          $oSelect->addItemSelect('ac', 'Acre');
          $oSelect->addItemSelect('sc', 'Santa Catarina');
          // $this->addCampos(array($oData1, $oCEP),array($oMoney,$oFone,$oCPF,$oCNPJ));
          $oRadio = new Campo('Estados','radio', Campo::TIPO_RADIO);
          $oRadio->addItenRadio('sc', 'Santa Catarina');
          $oRadio->addItenRadio('pr', 'Paraná');
          $oTextArea = new Campo('Descrição','texto', Campo::TIPO_TEXTAREA,6);
          $oTextArea->setILinhasTextArea(5);

          $oCheck = new Campo('teste', 'teste', Campo::TIPO_CHECK);
          $oCheck->setBValorCheck(true);
          $oUpload = new Campo('Avanei', 'mestre', Campo::TIPO_UPLOAD); */

        /*   $oTab = new TabPanel();
          $oAbaGeral = new AbaTabPanel('Aba Geral');
          $oAbaGeral->setBActive(true);
          $oAbaCarlos = new AbaTabPanel('Pit Bull');
          $this->addLayoutPadrao('Aba');


          $oModCod = new Campo('Código','modcod', Campo::TIPO_TEXTO,1);
          $oModDescricao = new Campo('Descrição','modescricao',  Campo::TIPO_TEXTO,3);

          $oObs = new Campo('Obs','obs', Campo::TIPO_TEXTO,3);
          $oTeste = new Campo('Teste','obs', Campo::TIPO_TEXTO,3);

          $oAbaGeral->addCampos(array($oModCod,$oModDescricao,$oTeste));
          $oAbaCarlos->addCampos($oObs);
          $oTab->addItems($oAbaGeral,$oAbaCarlos);


          $this->addCampos($oTab); */
        //teste da gravação no banco
        $oMod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 3);
        $oMod->setBCampoBloqueado(true); //quando campo for pk
        $oMod->setBFocus(true);
        $oModdes = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3);
        $oModdes->addValidacao(true, Validacao::TIPO_STRING, 'Conteúdo Inválido!');
        // $oModdes->addValidacao(true, Validacao::TIPO_EMAIL, 'Email inválido');
        $oModdes->setBFocus(true);
        //  $oModdes->addValidacao('false', Validacao::TIPO_INTEIRO,'Dados informados são inválidos');
        //$oModdes->addValidacao(FALSE, Validacao::TIPO_STRING,'Dados informados são inválidos','1','20');





        $oSelect = new Campo('Campo Select', 'select', Campo::TIPO_SELECT);
        $oSelect->addItemSelect('ac', 'Acre');
        $oSelect->addItemSelect('sc', 'Santa Catarina');


        /* $oModdes1 = new Campo('teste','ATIVO', Campo::TIPO_CHECK,3);
          $oModdes1->setBValorCheck(true); */

//          $oSelect = new Campo('Campo Select','select',  Campo::TIPO_SELECT);
//          $oSelect->addItemSelect('ac', 'Acre');
//          $oSelect->addItemSelect('sc', 'Santa Catarina');
//          $oTexto = new Campo('texto','teste', Campo::TIPO_TEXTAREA,12);
//          $oTexto->setILinhasTextArea(5);
//          $oTexto->setBCampoBloqueado(true);
//          

        $oFieldSet = new FieldSet('Módulos');
        $oFieldSet->addCampos($oMod, $oModdes);

        $this->addCampos($oFieldSet);
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

