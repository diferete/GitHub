<?php

/*
 * Classe que implementa as views da classe CadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class ViewCadCliRep extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oNr = new CampoConsulta('Nr.Cadastro', 'nr');
        $oNr->setILargura(5);
        $oEmpcod = new CampoConsulta('Cnpj', 'empcod');
        $oEmpcod->setILargura(100);
        $oEmpDes = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);
        $oEmpDes->setILargura(500);
        $oDataCad = new CampoConsulta('Data Cadastro', 'empdtcad', CampoConsulta::TIPO_DATA);
        $oDataCad->setILargura(30);
        $oEmpusu = new CampoConsulta('Usuário', 'empusucad');

        $oSituaca = new CampoConsulta('Situação', 'situaca');
        $oSituaca->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oSituaca->addComparacao('Liberado', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, null);
        $oSituaca->addComparacao('Cadastrado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_LINHA, false, null);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Liberações', Dropdown::TIPO_PRIMARY);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIRMAR) . 'Liberar Metalbo', 'CadCliRep', 'msgLiberaCadastro', '', false, '', false, '', false, '', false, false);

        $oDrop2 = new Dropdown('Endereços', Dropdown::TIPO_AVISO);
        $oDrop2->addItemDropdown($this->addIcone(Base::ICON_EDITAR) . 'Inserir endereços', 'CadCliRepEnd', 'acaoMostraTelaEndereço', '', true, '', false, '', false, '', false, false);


        //filtros 
        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilEmpcod = new Filtro($oEmpcod, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $oFiltroEmpdes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $oFiltroUsuCad = new Filtro($oEmpusu, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);


        $this->addFiltro($oFilNr, $oFilEmpcod, $oFiltroEmpdes, $oFiltroUsuCad);

        $this->addDropdown($oDrop2, $oDrop1);

        $this->addCampos($oNr, $oEmpcod, $oEmpDes, $oDataCad, $oEmpusu, $oSituaca);
    }

    public function criaTela() {
        parent::criaTela();

        $oDadosRep = $this->getOObjTela();
        $sAcao = $this->getSRotina();

        $oFieldInf = new FieldSet('Informações');
        $oFieldInf->setOculto(true);

        $oNr = new Campo('Nr.Cad', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setBCampoBloqueado(true);

        $oEmpAtivo = new Campo('Sit.Cliente', 'empativo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEmpAtivo->setSValor('S');
        $oEmpAtivo->setBCampoBloqueado(true);

        $oEmpData = new Campo('Data Cadastro', 'empdtcad', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpData->setSValor(date('d/m/Y'));
        $oEmpData->setBCampoBloqueado(true);

        $oUsuCodigo = new campo('Código', 'usucodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCodigo->setSValor($_SESSION['codUser']);
        $oUsuCodigo->setBCampoBloqueado(true);

        $oUsuEmpCad = new campo('Usuário', 'empusucad', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuEmpCad->setSValor($_SESSION['nome']);
        $oUsuEmpCad->setBCampoBloqueado(true);

        $oOfficecod = new Campo('...', 'officecod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOfficecod->setSValor($_SESSION['repoffice']);
        $oOfficecod->setBCampoBloqueado(true);

        $oOfficedes = new Campo('Escritório', 'officedes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oOfficedes->setSValor($_SESSION['repofficedes']);
        $oOfficedes->setBCampoBloqueado(true);

        $oSit = new Campo('', 'situaca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSit->setBCampoBloqueado(true);
        $oSit->setSValor('');
        $oSit->setBOculto(true);

        $oDtLib = new Campo('', 'dtlib', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDtLib->setBOculto(true);

        $oHoraLib = new Campo('', 'horalib', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oHoraLib->setBOculto(true);

        $oFieldInf->addCampos(array($oNr, $oEmpAtivo, $oEmpData, $oUsuCodigo, $oUsuEmpCad), array($oOfficecod, $oOfficedes, $oSit, $oDtLib, $oHoraLib));

        //////////////////////////////////////////////////////////////////////////////////////////////////////
        $oEmpcod = new campo('Cnpj *(Somente N°)', 'empcod', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!', '11', '14');

        $oCNPJ = new Campo('cnpj', 'cnpj', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCNPJ->setBOculto(true);
        $oCNPJ->setBCampoBloqueado(true);

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
        $oEmpEnd->addValidacao(FALSE, Validacao::TIPO_STRING, 'Endereço inválido', '8', '35');

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

        $oCodIBGE = new Campo('...', 'codIBGE', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodIBGE->setBOculto(true);

        $sAcaoExit = 'cnpjBusca($("#' . $oEmpcod->getId() . '").val(),'
                . '"' . $oCNPJ->getId() . '",'
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
                . '"' . $oCodIBGE->getId() . '",'
                . '"' . $this->getController() . '",'
                . '$("#' . $oNr->getId() . '").val())';


        $oEmpcod->addEvento(Campo::EVENTO_SAIR, $sAcaoExit);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oTipoPessoa = new campo('Tipo de pessoa', 'empfj', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoPessoa->addItemSelect('J', 'Jurídica');
        $oTipoPessoa->addItemSelect('F', 'Física');
        $oTipoPessoa->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!');

        $oConsFinal = new Campo('Consumidor final', 'empconfina', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oConsFinal->addItemSelect('N', 'Cliente não é consumidor final');
        $oConsFinal->addItemSelect('S', 'Cliente é um consumidor final');
        $oConsFinal->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!');

        $oEmailNfe = new campo('E-mail NFE', 'emailNfe', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmailNfe->addValidacao(false, Validacao::TIPO_EMAIL, 'Email inválido', '4');

        $oBanco = new Campo('Branco', 'empcobbco', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oBanco->addItemSelect('0006', 'Bradesco 0006');
        $oBanco->addItemSelect('0005', 'Unibanco 0005');
        $oBanco->addValidacao(FALSE, Validacao::TIPO_STRING, 'Campo obrigatório');

        $oCarteira = new Campo('Carteira', 'empcobcar', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCarteira->addItemSelect('1', 'SIMPLES');
        $oCarteira->addValidacao(FALSE, Validacao::TIPO_STRING, 'Campo obrigatório');

        $oComer = new campo('Cliente', 'comer', Campo::TIPO_CHECK, 1);
        $oComer->setSValor(true);

        $oTransp = new campo('Transportadora', 'transp', Campo::TIPO_CHECK, 1);

        $oFieldEnd = new FieldSet('Endereço');


        $oFieldEnd->addCampos(array($oCidCep, $oUf, $oMunicipio), array($oBairro, $oEmpEnd), array($oComplemento, $oEmpnr), $oCodIBGE);

        $oEmpIns = new Campo('Inscrição estadual *(Somente Nº)', 'empins', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpIns->addValidacao(false, Validacao::TIPO_STRING, 'Inscrição inválida', '5', '18');

        $oRep = new Campo('Código do Representante', 'repcod', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oRep->addItemSelect('Cod. Representante', 'Cod. Representante');
        foreach ($oDadosRep as $key => $oRepCodObj) {
            $oRep->addItemSelect($oRepCodObj->getRepcod(), $oRepCodObj->getRepcod());
        }
        $oRep->addValidacao(false, Validacao::TIPO_STRING, 'Selecione código de representante', '2', '3');

        $oRespVenda = new campo('...', 'resp_venda_cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRespVenda->setBCampoBloqueado(true);
        $oRespVenda->addValidacao(false, Validacao::TIPO_STRING, 'Caso não apareça, notificar o setor de TI da Metalbo', '2', '3');

        $oRespVendaNome = new Campo('Resp. Vendas', 'resp_venda_nome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRespVendaNome->setBCampoBloqueado(true);

        $sAcaoRespVenda = 'buscaRespVenda($("#' . $oRep->getId() . '").val(),'
                . '"' . $oRespVenda->getId() . '",'
                . '"' . $oRespVendaNome->getId() . '",'
                . '"' . $this->getController() . '")';

        $oRep->addEvento(Campo::EVENTO_CHANGE, $sAcaoRespVenda);

        $oPagaSt = new campo('Paga ST ', 'pagast', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPagaSt->addItemSelect('Não', 'Não');
        $oPagaSt->addItemSelect('Sim', 'Sim');
        $oPagaSt->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!');

        $oSimplesNacional = new Campo('Simples Nacional ', 'simplesNacional', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSimplesNacional->addItemSelect('N', 'Não');
        $oSimplesNacional->addItemSelect('S', 'Sim');
        $oSimplesNacional->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório!');

        $oCert = new Campo('Necessita Certificado', 'certcli', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCert->addItemSelect('N', 'Não');
        $oCert->addItemSelect('S', 'Sim');
        $oCert->addValidacao(false, Validacao::TIPO_STRING, 'Campo Obrigatório!');

        $oEmpObs = new Campo('Observações', 'empobs', Campo::TIPO_TEXTAREA, 8, 8, 8, 12);
        $oEmpObs->setILinhasTextArea(5);
        $oEmpObs->addValidacao(true, Validacao::TIPO_STRING, '...', '0', '1000');

        $this->addCampos($oFieldInf, array($oEmpcod, $oCNPJ, $oEmpDes), array($oEmpFant, $oTipoPessoa, $oConsFinal), array($oEmpFone, $oEmailComum, $oEmailNfe), array($oBanco, $oCarteira, $oComer, $oTransp), $oFieldEnd, array($oEmpIns, $oRep), array($oPagaSt, $oSimplesNacional, $oCert), $oEmpObs, array($oRespVenda, $oRespVendaNome));
    }

}
