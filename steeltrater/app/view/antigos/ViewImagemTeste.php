<?php

class ViewImagemTeste extends View {
    
    public function criaTela() {
        parent::criaTela();
        
        $oCampoId = new Campo('ID', 'id');
        $oCampoId->setBCampoBloqueado(true);
       
        $oCampoImagem = new Campo('Imagem', 'caminho', Campo::TIPO_UPLOAD);
        $oCampoImagem->setExtensoesPermitidas('png','jpg');
        
        $oCampoData = new Campo('Data', 'data', Campo::TIPO_DATA);
        $oCampoData->setSValor(date('d/m/Y'));
        
        $oCampoHora = new Campo('Hora', 'hora');
        $oCampoHora->setSValor(date('H:i'));
        $oCampoHora->setBCampoBloqueado(true);
        
        $this->addCampos($oCampoId,$oCampoImagem, $oCampoData, $oCampoHora);
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oCampoId = new CampoConsulta('ID', 'id');
        
        $oCampoData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);
        
        $this->addCampos($oCampoId,$oCampoData);
    }
}
