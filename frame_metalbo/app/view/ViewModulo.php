<?php

class ViewModulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();
        $this->setUsaDropdown(true);

        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oCodigo->setILargura(500);

        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModulo->setILargura(500);

        $oDropDown = new Dropdown('Testar Email', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Testar Email', 'Modulo', 'testarEmail', '', false, '', false, '', false, '', false, false);

        $this->addDropdown($oDropDown);
        $this->addCampos($oCodigo, $oModulo);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

    function criaTela() {
        parent::criaTela();






        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModDescricao->addValidacao(false, Validacao::TIPO_STRING, '', '2', '15');


        /*

          $oBotaoGrupo = new Campo('Add Grupo', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
          $sAcaoGrupo = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","insereGrupo");';
          $oBotaoGrupo->getOBotao()->addAcao($sAcaoGrupo);

          $oBotaoXML = new Campo('XML', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
          $sAcaoXML = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","converteXML");';
          $oBotaoXML->getOBotao()->addAcao($sAcaoXML);

          $oBotaoPlaca = new Campo('PLACA', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
          $sAcaoPlaca = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","inserePlaca");';
          $oBotaoPlaca->getOBotao()->addAcao($sAcaoPlaca);

          $oBotaoGrupo2 = new Campo('Add Grupo 2', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
          $sAcaoGrupo2 = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","insereGrupo2");';
          $oBotaoGrupo2->getOBotao()->addAcao($sAcaoGrupo2);

          $oBotaoExpira = new Campo('Expira', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
          $sAcaoExpira = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","expiraProd");';
          $oBotaoExpira->getOBotao()->addAcao($sAcaoExpira);
         * 
         */

        $oEmpcod = new campo('Cnpj *(Somente N°)', 'empcod', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '11', '14');

        $oEmpDes = new campo('Razão social', 'empdes', Campo::TIPO_TEXTO, 7, 7, 12, 12);
        $oEmpDes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpDes->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5', '45');

        $oEmpFant = new campo('Nome Fantasia', 'empfant', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oEmpFant->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5', '35');

        $oEmpFone = new campo('Telefone *(Somente N°)', 'empfone', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpFone->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '5', '15');

        $oEmailComum = new campo('E-mail *(E-mail geral da empresa)', 'empinterne', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmailComum->addValidacao(false, Validacao::TIPO_EMAIL, 'E-mail inválido', '4');

        $oCidCep = new campo('Cep *(Somente N°)', 'cidcep', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCidCep->setSCorFundo(Campo::FUNDO_MONEY);
        $oCidCep->addValidacao(FALSE, Validacao::TIPO_INTEIRO, 'Cep inválido!', '8', '8');

        $oEmpEnd = new campo('Endereço', 'empend', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oEmpEnd->setSCorFundo(Campo::FUNDO_MONEY);
        $oEmpEnd->addValidacao(FALSE, Validacao::TIPO_STRING, 'Endereço inválido', '8', '45');

        $oEmpnr = new campo('Número', 'empnr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEmpnr->addValidacao(FALSE, Validacao::TIPO_INTEIRO, 'Campo obrigatório', '0', '100');
        $oEmpnr->setSCorFundo(Campo::FUNDO_MONEY);

        $oComplemento = new Campo('Complemento', 'empcomplemento', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oComplemento->setSCorFundo(Campo::FUNDO_MONEY);
        $oComplemento->addValidacao(true, Validacao::TIPO_STRING, 'Insira menos caractéres', '0', '45');

        $oMunicipio = new campo('Munícipio', 'empmunicipio', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oMunicipio->setSCorFundo(Campo::FUNDO_MONEY);
        $oMunicipio->addValidacao(FALSE, Validacao::TIPO_STRING, 'Município inválido', '3', '80');

        $oUf = new campo('UF', 'uf', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUf->setSCorFundo(Campo::FUNDO_MONEY);
        $oUf->addValidacao(false, Validacao::TIPO_STRING, 'UF inválida', '2', '80');

        $oBairro = new campo('Bairro', 'empendbair', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oBairro->addValidacao(false, Validacao::TIPO_STRING, 'Bairro inválido', '2', '25');
        $oBairro->setSCorFundo(Campo::FUNDO_MONEY);

        $oEmpcod->setBFocus(true);
        $sAcaoExit = 'cnpjBusca($("#' . $oEmpcod->getId() . '").val(),'
                . '"' . $oEmpDes->getId() . '",'
                . '"' . $oEmpFant->getId() . '",'
                . '"' . $oEmpFone->getId() . '",'
                . '"' . $oEmailComum->getId() . '",'
                . '"' . $oCidCep->getId() . '",'
                . '"' . $oMunicipio->getId() . '",'
                . '"' . $oEmpEnd->getId() . '",'
                . '"' . $oUf->getId() . '",'
                . '"' . $oBairro->getId() . '",'
                . '"' . $oComplemento->getId() . '",'
                . '"' . $oEmpnr->getId() . '",'
                . '"' . $this->getController() . '")';

        $oEmpcod->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);




        $this->addCampos(array($oModCod, $oModDescricao), array($oEmpcod, $oEmpDes), $oEmpFant, array($oEmpFone, $oEmailComum), array($oCidCep, $oUf, $oMunicipio), array($oBairro, $oEmpEnd), array($oComplemento, $oEmpnr));
    }

}
