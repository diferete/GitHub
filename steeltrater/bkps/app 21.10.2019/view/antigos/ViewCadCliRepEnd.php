<?php

/**
 * Class que implementa a view CadCliRepEnd para inserçao de cobrancás 
 * @author Avanei Martendal
 * @since 27/09/2017
 */
class ViewCadCliRepEnd extends View {

    public function criaTela() {
        parent::criaTela();

        $oDados = $this->getAParametrosExtras();
        $oNr = new campo('Nr', 'nr', Campo::TIPO_TEXTO, 1);
        if (method_exists($oDados, 'getNr')) {
            $oNr->setSValor($oDados->getNr());
        }
        $oNr->setBCampoBloqueado(true);
        $oNr->setIMarginTop(8);

        $oEmpcod = new Campo('Cnpj', 'empcod', Campo::TIPO_TEXTO, 2);
        if (method_exists($oDados, 'getEmpcod')) {
            $oEmpcod->setSValor($oDados->getEmpcod());
        }
        $oEmpcod->setBCampoBloqueado(true);
        $oEmpcod->setIMarginTop(8);

        $oTipo = new Campo('Tipo', 'tipo', Campo::TIPO_SELECT, 2);
        $oTipo->addItemSelect('De cobranca', 'De cobrança');
        $oTipo->addItemSelect('De entrega', 'De entrega');



        /* endereço */
        $oFieldEnd = new FieldSet('Endereço');

        $oCidCep = new campo('Cep *(Somente N°)', 'endcep', Campo::TIPO_TEXTO, 3, 3, 2, 12);
        $oCidCep->setSCorFundo(Campo::FUNDO_MONEY);
        $oCidCep->addValidacao(FALSE, Validacao::TIPO_INTEIRO, 'Cep inválido!', '8', '8');


        $oEmpEnd = new campo('Endereço', 'ender', Campo::TIPO_TEXTO, 4, 4, 4, 12);
        $oEmpEnd->setSCorFundo(Campo::FUNDO_MONEY);
        $oEmpEnd->addValidacao(FALSE, Validacao::TIPO_STRING, 'Endereço inválido', '8', '45');

        $oEmpnr = new campo('Número', 'endnr', Campo::TIPO_TEXTO, 1);
        $oEmpnr->addValidacao(FALSE, Validacao::TIPO_STRING, 'Campo obrigatório', '0', '100');
        $oEmpnr->setSCorFundo(Campo::FUNDO_MONEY);

        $oMunicipio = new campo('Munícipio', 'endcid', Campo::TIPO_TEXTO, 3, 3, 3, 12);
        $oMunicipio->setSCorFundo(Campo::FUNDO_MONEY);
        $oMunicipio->addValidacao(FALSE, Validacao::TIPO_STRING, 'Município inválido', '3', '80');

        $oUf = new campo('UF', 'enduf', Campo::TIPO_TEXTO, 1, 1, 2, 2);
        $oUf->setSCorFundo(Campo::FUNDO_MONEY);
        $oUf->addValidacao(false, Validacao::TIPO_STRING, 'UF inválida', '2', '80');

        $oBairro = new campo('Bairro', 'endbairr', Campo::TIPO_TEXTO, 3, 3, 3, 10);
        $oBairro->setSCorFundo(Campo::FUNDO_MONEY);
        $oBairro->addValidacao(false, Validacao::TIPO_STRING, 'Bairro inválido', '2', '40');

        $sCallBack = 'cepBusca($("#' . $oCidCep->getId() . '").val(),'
                . '"' . $oMunicipio->getId() . '","' . $oEmpEnd->getId() . '","' . $oUf->getId() . '","' . $oBairro->getId() . '")';


        $oCidCep->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oFieldEnd->addCampos(array($oCidCep, $oUf, $oBairro), array($oEmpEnd, $oEmpnr, $oMunicipio));

        /* dados cnpj */
        $oEmpCnpjEnd = new Campo('Cnpj', 'endcnpj', Campo::TIPO_TEXTO, 3);
        $oEmpCnpjEnd->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpCnpjEnd->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","CadCliRepEnd","verificaTipoEnd");');
        $oEmpCnpjEnd->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '12', '14');
        $oEmpCnpjEnd->setSValor($aDados['empcod']);

        $oEmpIns = new Campo('Inscrição estadual', 'endInsc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpIns->addValidacao(false, Validacao::TIPO_STRING, 'Inscrição inválida', '5', '18');

        $oEmpFone = new campo('Telefone *(Somente N°)', 'empendfone', Campo::TIPO_TEXTO, 3, 3, 3, 12);

        $oEmail = new campo('E-mail *(E-mail geral da empresa)', 'empendemail', Campo::TIPO_TEXTO, 3, 3, 3, 12);
        $oEmail->addValidacao(false, Validacao::TIPO_EMAIL, 'E-mail inválido', '4');

        $oEmpObs = new campo('Observação', 'empendobs', Campo::TIPO_TEXTAREA, 6);
        $oEmpObs->addValidacao(true, Validacao::TIPO_STRING, '...', '0', '120');




        /* grid da tela */
        $oGridEnd = new campo('Endereços', 'enderecos', Campo::TIPO_GRID, 12, 12, 12, 12, 150);


        $oEmpCodGrid = new CampoConsulta('Cnpj', 'empcod');
        $oNrGrid = new CampoConsulta('Nr', 'nr');
        $oEnderecoGrid = new CampoConsulta('Endereço', 'ender');

        $oTipoCons = new CampoConsulta('Tipo', 'tipo', CampoConsulta::TIPO_DESTAQUE1);

        $oMunicipioCons = new CampoConsulta('Munícipio', 'endcid', CampoConsulta::TIPO_DESTAQUE1);

        $oGridEnd->addCampos($oEmpCodGrid, $oTipoCons, $oNrGrid, $oEnderecoGrid, $oMunicipioCons);
        $oGridEnd->setSController('CadCliRep');
        $oGridEnd->addParam('nr', '0');



        /**
         * evento do grid
         */
        $sAcaoAlt = 'var chave=""; $("#' . $oGridEnd->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","CadCliRepEnd","sendaDadosCampos","' . $oGridEnd->getId() . '"+","+chave+","+"' . $oNr->getId() . '"+",'
                . '"+"' . $oEmpcod->getId() . '"+","+"' . $oTipo->getId() . '"+",'
                . '"+"' . $oCidCep->getId() . '"+","+"' . $oUf->getId() . '"+","+"' . $oBairro->getId() . '"+",'
                . '"+"' . $oEmpEnd->getId() . '"+","+"' . $oEmpnr->getId() . '"+","+"' . $oMunicipio->getId() . '"+","+"' . $oEmpCnpjEnd->getId() . '"+",'
                . '"+"' . $oEmpIns->getId() . '"+","+"' . $oEmpFone->getId() . '"+","+"' . $oEmail->getId() . '"+","+"' . $oEmpObs->getId() . '"); ';

        $oBtnAlterar = new Campo('Alterar', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $oBtnAlterar->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $oBtnAlterar->getOBotao()->addAcao($sAcaoAlt);

        /* botao de confirmar */

        //botão inserir os dados
        $oBtnInserir = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        //id do grid
        $sGridEnd = $oGridEnd->getId();
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontEnd","' . $this->getTela()->getId() . '-form,' . $sGridEnd . ',' . $oNr->getId() . '","");';

        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $sAcao = 'var chave=""; $("#' . $oGridEnd->getId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("' . $this->getTela()->getId() . '-form","CadCliRepEnd","excluirEf","' . $this->getTela()->getId() . '-form,' . $oGridEnd->getId() . '"+","+chave+""); '; // excluirEf
        $oBtnDelete = new Campo('Deletar', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $oBtnDelete->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
        $oBtnDelete->getOBotao()->addAcao($sAcao);

        $sAcaoBusca = 'requestAjax("' . $this->getTela()->getId() . '-form","CadCliRepEnd","getDadosGrid","' . $oGridEnd->getId() . '","consultaEnd");';
        $this->getTela()->setSAcaoShow($sAcaoBusca);

        $this->addCampos(array($oNr, $oEmpcod, $oTipo), $oFieldEnd, array($oEmpCnpjEnd, $oEmpIns), array($oEmpFone, $oEmail), array($oEmpObs, $oBtnInserir), array($oBtnAlterar, $oBtnDelete), $oGridEnd);
    }

    public function consultaEnd() {



        $oGridEnd = new Grid("");


        $oEmpCodGrid = new CampoConsulta('Cnpj', 'empcod');
        $oNrGrid = new CampoConsulta('Nr', 'nr');
        $oEnderecoGrid = new CampoConsulta('Endereço', 'ender');
        $oTipoCons = new CampoConsulta('Tipo', 'tipo', CampoConsulta::TIPO_DESTAQUE1);
        $oMunicipioCons = new CampoConsulta('Munícipio', 'endcid', CampoConsulta::TIPO_DESTAQUE1);

        $oGridEnd->addCampos($oEmpCodGrid, $oTipoCons, $oNrGrid, $oEnderecoGrid, $oMunicipioCons);


        $aCampos = $oGridEnd->getArrayCampos();
        return $aCampos;
    }

}
