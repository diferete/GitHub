<?php
class ViewMET_TEC_ModUsuario extends View{
    function __construct() {
        parent::__construct();
    }
    
     function criaConsulta() {
          parent::criaConsulta();
          
          $this->getTela()->setILarguraGrid(1200);
          
          $oCodigo = new CampoConsulta('Usucodigo','MET_TEC_Usuario.usucodigo');
          $oUser = new CampoConsulta('Usunome','MET_TEC_Usuario.usunome');
          $oModCod = new CampoConsulta('Modulo','MET_TEC_Modulo.modcod');
          $oModDes = new CampoConsulta('Modulo','MET_TEC_Modulo.modescricao');
          $oModOrdem = new CampoConsulta('Ordem','modordem');
          $oFilUser = new Filtro($oUser, Filtro::CAMPO_TEXTO,3);
          $this->addFiltro($oFilUser);
          $this->addCampos($oCodigo,$oUser,$oModCod,$oModDes,$oModOrdem);
          $this->setUsaAcaoAlterar(false);
          
         
      }
      
      function criaTela() {
          parent::criaTela();
          
          $this->setTituloTela('Cadastro de módulos por usuário');
          
          $oUserCodigo = new Campo('Usuário','MET_TEC_Usuario.usucodigo',  Campo::TIPO_TEXTO,1);
          $oUserCodigo->setClasseBusca('MET_TEC_Usuario');
          $oUserCodigo->addCampoBusca('usunome',null,  $this->getTela()->getId());
       
          
          $oModCod = new Campo('Módulo','MET_TEC_Modulo.modcod', Campo::TIPO_TEXTO,1);
          $oModCod->setClasseBusca('MET_TEC_Modulo');
          $oModCod->addCampoBusca('modescricao',null,  $this->getTela()->getId());//sempre setar o nome do modulo referente a pesquisa
       
          $oModOrdem = new Campo('Ordem','modordem', Campo::TIPO_TEXTO,1);
          $this->addCampos($oUserCodigo,$oModCod,$oModOrdem);
          
          
      }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

