<?php
class ViewModUsuario extends View{
    function __construct() {
        parent::__construct();
    }
    
     function criaConsulta() {
          parent::criaConsulta();
          
          
          $oCodigo = new CampoConsulta('Usucodigo','User.usucodigo');
          $oUser = new CampoConsulta('Usunome','User.usunome');
          $oModCod = new CampoConsulta('Modulo','Modulo.modcod');
          $oModDes = new CampoConsulta('Modulo','Modulo.modescricao');
          $oModOrdem = new CampoConsulta('Ordem','modordem');
          $oFilUser = new Filtro($oUser, Filtro::CAMPO_TEXTO,3);
          $this->addFiltro($oFilUser);
          $this->addCampos($oCodigo,$oUser,$oModCod,$oModDes,$oModOrdem);
          
         
      }
      
      function criaTela() {
          parent::criaTela();
          
          $this->setTituloTela('Cadastro de módulos por usuário');
          
          $oUserCodigo = new Campo('Usuário','User.usucodigo',  Campo::TIPO_TEXTO,1);
          $oUserCodigo->setClasseBusca('User');
          $oUserCodigo->addCampoBusca('usunome',null,  $this->getTela()->getId());
       
          
          $oModCod = new Campo('Módulo','Modulo.modcod', Campo::TIPO_TEXTO,1);
          $oModCod->setClasseBusca('Modulo');
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

