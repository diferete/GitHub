<?php

/*
 * Classe que implementa as views STEEL_PCP_ParFornoMaster
 * 
 * @author Cleverton Hoffmann
 * @since 04/12/2020
 */

class ViewSTEEL_PCP_ParFornoMaster extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código', 'fornocod');
        $oDes = new CampoConsulta('Descrição', 'fornodes');  
        
        $oFilForno = new Filtro($oDes, Filtro::CAMPO_TEXTO, 3);
        $this->addFiltro($oFilForno);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(TRUE);
        $this->getTela()->setBUsaCarrGrid(true);
        
        $this->addCampos($oCod,$oDes);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Codigo', 'fornocod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCod->setBCampoBloqueado(true);
        $oDes = new Campo('Descrição', 'fornodes', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oDes->setBCampoBloqueado(true);
        $oSig = new Campo('Sigla', 'fornosigla', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSig->setBOculto(true);
        $oTipo = new Campo('Tipo OP','tipoOrdem', Campo::TIPO_TEXTO,3,3,3,3);
        $oTipo->setBOculto(true);
     
        $oEficiencia = new Campo('Eficiencia (Kg/H)','eficienciaHora', Campo::TIPO_TEXTO); 
        $oEficiencia->setBOculto(true);
        
        $this->addCampos(array($oCod,$oDes,$oSig), array($oTipo, $oEficiencia));
    }
    
    

}
