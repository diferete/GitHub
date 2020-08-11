<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewMovFornoSteel extends View{
    public function criaTela() {
        parent::criaTela();
        
        $this->setBTela(true); 
    }
    
     public function telaGet(){
        parent::criaTelaRelatorio();
        
        $this->setTituloTela('Pega dados SteelTrater');
        $this->setBTela(true); 
        
        //botão que aplica a quantidade sugerida pelo sistema
        $oBtnNormal = new Campo('Chamar dados','btnNormal', Campo::TIPO_BOTAOSMALL,1);
        $sAcaoSugQt='requestAjax("","'.$this->getController().'","getDadosSteel","");';
        $oBtnNormal->getOBotao()->addAcao($sAcaoSugQt);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        
        $this->addCampos($oBtnNormal);
     }
     
  
     public function relSteel(){
        parent::criaTelaRelatorio();
        
        $this->setTituloTela('Relatório Steel');
        $this->setBTela(true); 
        
        $oFornos = new Campo('Forno','forno', Campo::TIPO_SELECT,2,2,12,12);
        $oFornos->addItemSelect('Todos', 'Todos');
        $oFornos->addItemSelect('Forno 1', 'Forno 1');
        $oFornos->addItemSelect('Forno 2', 'Forno 2');
        $oFornos->addItemSelect('Forno 3', 'Forno 3');
        $oFornos->addItemSelect('Forno 4', 'Forno 4');
        
        $oSit = new Campo('Situação','sit', Campo::TIPO_SELECT,2,2,12,12);
        $oSit->addItemSelect('Todos', 'Todos');
        $oSit->addItemSelect('Processo', 'Processo');
        $oSit->addItemSelect('Finalizado', 'Finalizado');
        
         $oDataIni = new Campo('Data Inicial','dataini', Campo::TIPO_DATA,2);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
       // $oDataIni->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim = new Campo('Data Final','datafim', Campo::TIPO_DATA,2);
       // $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oDataFim->setSValor(date('d/m/Y'));

        
        $this->addCampos($oFornos,$oSit,array($oDataIni,$oDataFim));
        
        
        
        
    }

          public function criaConsulta() {
         parent::criaConsulta();
         
         $oNr = new CampoConsulta('Reg.', 'nr', CampoConsulta::TIPO_TEXTO);
         
         $oNr->setSOperacao('personalizado');
         
         
         $oOfSteel = new CampoConsulta('OP.Steel','ofsteel');
      
         
         $oProcodCod = new CampoConsulta('Código','procodCod');
         
         
         $oProdes = new CampoConsulta('Produto','prodes', CampoConsulta::TIPO_LARGURA);
        
         
         $oEmpCod = new CampoConsulta('Cnpj','empcod');
         
         $oEmpDes = new CampoConsulta('Empresa','empdes', CampoConsulta::TIPO_LARGURA);
         
         
         $oOfCli = new CampoConsulta('OP.Cliente','ofcliente');
         
         $oForno = new CampoConsulta('Forno','forno', CampoConsulta::TIPO_DESTAQUE1);
         
         $oSit = new CampoConsulta('Situação','sit');
         $oSit->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);
         
         $oDtEnt = new CampoConsulta('Data.Ent','dtent', CampoConsulta::TIPO_DATA);
         $oHoraEnt = new CampoConsulta('Hora.Ent','horaent', CampoConsulta::TIPO_TIME);
         
         $oDtSaida = new CampoConsulta('Data.Saída','dtsaida', CampoConsulta::TIPO_DATA);
         $oHoraSaida = new CampoConsulta('Hora.Saída','horasaida', CampoConsulta::TIPO_TIME);
         
         //filtros
        
        $oFiltroForno = new Filtro($oForno, Filtro::CAMPO_SELECT,2,2,12,12);
        $oFiltroForno->addItemSelect('Todos', 'Todos');
        $oFiltroForno->addItemSelect('Forno 1', 'Forno 1');
        $oFiltroForno->addItemSelect('Forno 2', 'Forno 2');
        $oFiltroForno->addItemSelect('Forno 3', 'Forno 3');
        $oFiltroForno->addItemSelect('Forno 4', 'Forno 4');
        
        $oFiltroSit = new Filtro($oSit, Filtro::CAMPO_SELECT,2,2,12,12);
        $oFiltroSit->addItemSelect('Todos', 'Todos');
        $oFiltroSit->addItemSelect('Processo', 'Processo');
        $oFiltroSit->addItemSelect('Finalizado', 'Finalizado');
        
        
        $this->addFiltro($oFiltroForno,$oFiltroSit);
        //desativa botoes
         $this->setUsaAcaoAlterar(false);
         $this->setUsaAcaoExcluir(false);
         $this->setUsaAcaoIncluir(false);
         $this->setBScrollInf(true);
        
         $this->addCampos($oNr,$oOfSteel,$oProcodCod,$oProdes,$oEmpDes,$oOfCli,$oForno,$oSit,$oDtEnt,$oDtSaida);
         
     }
}
