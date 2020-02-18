<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 29/06/2018
 */

class ViewDELX_MNV_Atividade extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Codigo', 'mnv_atividadecodigo');
        $oDes = new CampoConsulta('Descrição', 'mnv_atividadedescricao');
        $oPro = new CampoConsulta('Pro.cod.', 'mnv_atividadeprodutocodigo');
        $oObs = new CampoConsulta('Obs.eng.', 'eng_atividadeobservacao');
        $oTer = new CampoConsulta('Terceiro', 'eng_atividadeterceiro');
        $oPar = new CampoConsulta('Parada', 'eng_atividadeparada');
        $oRec = new CampoConsulta('RecursoCod.', 'eng_atividaderecursocodigo');
        $oTem = new CampoConsulta('Tempo', 'mnt_atividadetempo');
        $oPri = new CampoConsulta('Prioridade', 'mnt_atividadeprioridade');
        $oObser = new CampoConsulta('Obs.mnt.', 'mnt_atividadeobservacao');
        $oMan = new CampoConsulta('Manutenção', 'mnt_atividadetipomanutencao');
        $oAre = new CampoConsulta('Área', 'mnt_atividadearea');
        $oIna = new CampoConsulta('Inativa', 'eng_atividadeinativa');

       // $this->getTela()->setBGridResponsivo(false);
       // $this->getTela()->setILarguraGrid(2000);

        // $oDescricaofiltro = new Filtro($oDescri, Filtro::CAMPO_TEXTO, 4,4,12,12,false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        //$this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(true);

        $this->addCampos($oCod,$oDes,$oPro, $oObs,$oTer,$oPar,$oRec,$oTem,$oPri,$oObser,$oMan,$oAre,$oIna);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Codigo', 'mnv_atividadecodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Descrição', 'mnv_atividadedescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oPro = new Campo('Pro.cod.', 'mnv_atividadeprodutocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oObs = new Campo('Obs.eng.', 'eng_atividadeobservacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTer = new Campo('Terceiro', 'eng_atividadeterceiro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPar = new Campo('Parada', 'eng_atividadeparada', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRec = new Campo('RecursoCod.', 'eng_atividaderecursocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTem = new Campo('Tempo', 'mnt_atividadetempo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPri = new Campo('Prioridade', 'mnt_atividadeprioridade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oObser = new Campo('Obs.mnt.', 'mnt_atividadeobservacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMan = new Campo('Manutenção', 'mnt_atividadetipomanutencao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAre = new Campo('Área', 'mnt_atividadearea', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oIna = new Campo('Inativa', 'eng_atividadeinativa', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCod,$oDes,$oPro, $oObs,$oTer), 
                array($oPar,$oRec,$oTem,$oPri), array($oObser,$oMan,$oAre,$oIna));
    }

}
