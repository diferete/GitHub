<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_FavMenu extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oUsuCodigo = new CampoConsulta('Usuário','usucodigo');
        $oFavseq = new CampoConsulta('Seq','favseq');
        $oFavDesc = new CampoConsulta('Descrição','favdescricao');
        $oFavClasse = new CampoConsulta('Classe','favclasse');
        $oFavMetodo = new CampoConsulta('Método','favmetodo');
        $oFavOrdem = new CampoConsulta('Ordem','favordem');
        
        $oFDesc = new Filtro($oFavDesc, Filtro::CAMPO_TEXTO,3);
        $this->addFiltro($oFDesc);
        
        $this->addCampos($oUsuCodigo,$oFavseq,$oFavDesc,$oFavClasse,$oFavMetodo,$oFavOrdem);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de menus favoritos por usuários');
        $oUsucodigo = new Campo('Usuário','usucodigo', Campo::TIPO_TEXTO,1);
        $oUsucodigo->setSValor($_SESSION['codUser']);
        $oUsucodigo->setBCampoBloqueado(true);
        $oFavseq = new Campo('Seq','favseq', Campo::TIPO_TEXTO,1);
        $oFavseq->setBCampoBloqueado(true);
        $oFavDesc = new Campo('Descrição','favdescricao',Campo::TIPO_TEXTO,3);
        $oFavDesc->setBFocus(true);
        $oFavClasse = new Campo('Classe','favclasse',Campo::TIPO_TEXTO,2);
        $oFavMetodo = new Campo('Método','favmetodo',Campo::TIPO_TEXTO,2);
        $oFavOrdem = new Campo('Ordem','favordem',Campo::TIPO_TEXTO,1);
        
         $this->addCampos($oUsucodigo,$oFavseq,$oFavDesc,$oFavClasse,$oFavMetodo,$oFavOrdem);
    }
}