<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_Treinamentos extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oNr = new CampoConsulta('Nr.', 'nr');
        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oCracha = new CampoConsulta('Crachá', 'cracha');
        $oNome = new CampoConsulta('Colaborador', 'nome');
        $oSit = new CampoConsulta('Sit', 'situacao');
        $oSetor = new CampoConsulta('Setor', 'descsetor');
        $oFuncao = new CampoConsulta('Função', 'funcao');

        $this->addCampos($oNr, $oFilcgc, $oCracha, $oNome, $oSetor, $oFuncao, $oSit);
    }

    public function criaTela() {
        parent::criaTela();


        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);
        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setSValor($_SESSION['nome']);
        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oNome = new Campo('Colaborador', 'nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oSit = new Campo('Sit', 'situacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSetor = new Campo('Setor', 'descsetor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFuncao = new Campo('Função', 'funcao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCracha->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Treinamentos","buscaDadosFunc","' . $oNome->getId() . ',' . $oSit->getId() . ',' . $oSetor->getId() . ',' . $oFuncao->getId() . '");');


        $this->addCampos(array($oNr, $oFilcgc, $oUser), $oCracha, array($oNome, $oSetor, $oFuncao, $oSit));
    }

}
