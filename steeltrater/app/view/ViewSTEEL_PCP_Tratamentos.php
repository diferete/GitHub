<?php

/* 
 *Implementa a view da produção da metalbo
 * 
 * @Author Avanei Martendal
 * @since 31/05/2018
 */

class ViewSTEEL_PCP_Tratamentos extends View {
    public function criaConsulta() {
        parent::criaConsulta();
        
        
        $oTratCod = new CampoConsulta('Código','tratcod');
        $oTratCod->setILargura(50);
        $oTratDes = new CampoConsulta('Tratamento','tratdes');
        
        $oFiltro1 = new Filtro($oTratDes, Filtro::CAMPO_TEXTO_IGUAL,3);
        
        $this->addFiltro($oFiltro1);
        
        $this->setBScrollInf(true);
        $this->getTela()->setBUsaCarrGrid(true);
        
        $this->addCampos($oTratCod,$oTratDes);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oTratCod = new Campo('Código','tratcod', Campo::TIPO_TEXTO,1);
        $oTratCod->addValidacao(false, Validacao::TIPO_STRING, ''); 
        $oTratDes = new Campo('Tratamento','tratdes', Campo::TIPO_TEXTAREA,8);
        $oTratDes->addValidacao(false, Validacao::TIPO_STRING, ''); 
        $oL1 = new Campo('','linha1', Campo::TIPO_LINHA,12);
        $oL1->setApenasTela(true);
        
        $oRevenComposto = new Campo('Marca tratamento como revenir composto, (No cadastro de Prod/Mat/Receita onde marcamos o complemento)','tratrevencomp', Campo::TIPO_SELECT,8,8,8,8);
        $oRevenComposto->addItemSelect('Não', 'Não');
        $oRevenComposto->addItemSelect('Sim', 'Sim');
        
        
        $this->addCampos($oTratCod,$oTratDes,$oL1,$oRevenComposto);
    }
}
