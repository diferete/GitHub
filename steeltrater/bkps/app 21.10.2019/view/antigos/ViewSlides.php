<?php

/**
 * View da classe slides, que é responsável por controlar slides no MetalboApp e no Site
 * Atualmente é utilizada na classe
 * @author Carlos
 */
class ViewSlides extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oId = new CampoConsulta('ID', 'slidid');
        $oDesc = new CampoConsulta('Descrição', 'sliddesc');
        $oUsuario = new CampoConsulta('Usuario', 'slidusuario');
        $oData = new CampoConsulta('Data', 'sliddata');
        
        $this->addCampos($oId, $oDesc, $oUsuario, $oData);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oId = new Campo('ID', 'slidid', Campo::TIPO_TEXTO, 1,1,1,1);
        $oId->setBCampoBloqueado(true);
        
        $oDesc = new Campo('Descrição', 'sliddesc');
        $oImg = new Campo('Imagem', 'slidimg', Campo::TIPO_UPLOAD);
        
        
        $oUsuario = new Campo('Usuário', 'slidusuario', Campo::TIPO_TEXTO, 2);
        $oUsuario->setBCampoBloqueado(true);
        $oUsuario->setSValor($_SESSION['nome']);
        
        $oData = new Campo('Data', 'sliddata', Campo::TIPO_TEXTO, 1);
        $oData->setBCampoBloqueado(true);
        $oData->setSValor(date('d/m/Y'));
        
        $oAtiv = new Campo('Ativo', 'slidativo', Campo::TIPO_RADIO);
        $oAtiv->setSValor('true');
        $oAtiv->addItenRadio('true', 'Sim');
        $oAtiv->addItenRadio('false', 'Não');
        
        $this->addCampos($oId, array($oDesc), array($oUsuario, $oData), $oAtiv, $oImg);
    }
}
