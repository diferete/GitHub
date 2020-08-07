<?php

/*
 * Classe que implementa a View da pesquisa de satisfação
 * 
 * @author Avanei Martendal
 * @since 15/01/2018
 */

class ViewSatisClientePesq extends View {

    function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(300);


        $oNr = new CampoConsulta('Nr', 'nr');

        $oSeq = new CampoConsulta('Seq', 'seq');
        $oEmpcod = new CampoConsulta('Cnpj', 'empcod');
        $oEmpcod->setILargura(200);
        $oEmpdes = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);
        $oEmpdes->setILargura(500);

        $oEmail = new CampoConsulta('Mail', 'email');
        $oEmail->setILargura(100);

        $oComercial = new CampoConsulta('Comercial', 'comercial');

        $oProdReq = new CampoConsulta('Prod.Requisito', 'prodrequisito');

        $oEmb = new CampoConsulta('Embalagem', 'prodembalagem');

        $oPrazo = new CampoConsulta('Prazo', 'prodprazo');

        $oGeralExp = new CampoConsulta('Expectativa', 'geralexpectativa');

        $oIndica = new CampoConsulta('Indicação', 'geralindica');

        $oEmailEnv = new CampoConsulta('Enviado', 'emailenv');
        $oEmailEnv->addComparacao('Sim', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oEmailEnv->addComparacao('Não', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, null);


        $this->addCamposDetalhe($oNr, $oSeq, $oEmpcod, $oEmpdes, $oEmail, $oComercial, $oProdReq, $oEmb, $oPrazo, $oGeralExp, $oIndica, $oEmailEnv);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oNr = new CampoConsulta('Nr', 'nr');
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oEmpcod = new CampoConsulta('Cnpj', 'empcod');
        $oEmpcod->setILargura(200);
        $oEmpdes = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);
        $oEmpdes->setILargura(500);
        $oEmail = new CampoConsulta('Mail', 'email');
        $oEmail->setILargura(100);

        $oComercial = new CampoConsulta('Comercial', 'comercial', CampoConsulta::TIPO_DESTAQUE1);
        $oProdReq = new CampoConsulta('Prod.Requisito', 'prodrequisito', CampoConsulta::TIPO_DESTAQUE1);
        $oEmb = new CampoConsulta('Embalagem', 'prodembalagem', CampoConsulta::TIPO_DESTAQUE1);
        $oPrazo = new CampoConsulta('Prazo', 'prodprazo', CampoConsulta::TIPO_DESTAQUE1);

        $oGeralExp = new CampoConsulta('Expectativa', 'geralexpectativa', CampoConsulta::TIPO_DESTAQUE1);

        $oIndica = new CampoConsulta('Indicação', 'geralindica', CampoConsulta::TIPO_DESTAQUE1);

        $oEmailEnv = new CampoConsulta('Enviado', 'emailenv');
        $oEmailEnv->addComparacao('Sim', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, null);
        $oEmailEnv->addComparacao('Não', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, null);

        $this->addCampos($oNr, $oSeq, $oEmpcod, $oEmpdes, $oEmail, $oComercial, $oProdReq, $oEmb, $oPrazo, $oGeralExp, $oIndica, $oEmailEnv);
    }

    public function criaTela() {
        parent::criaTela();

        //cria o grid de itens
        $this->criaGridDetalhe();

        $aValor = $this->getAParametrosExtras();
        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 1, 1);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);


        $oEmpcod = new Campo('...', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oEmpcod->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpcod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oEmpcod->addValidacao(false, Validacao::TIPO_STRING, '', '1');


        $oSeqRel = new Campo('Ordem', 'seqrel', Campo::TIPO_TEXTO, 1, 1, 12, 12);


        $oEmpdes = new Campo('Cliente', 'empdes', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oEmpdes->setSIdPk($oEmpcod->getId());
        $oEmpdes->setClasseBusca('Pessoa');
        $oEmpdes->addCampoBusca('empcod', '', '');
        $oEmpdes->addCampoBusca('empdes', '', '');
        $oEmpdes->setSIdTela($this->getTela()->getid());
        $oEmpdes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oEmpdes->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        //campos da pesquisa de satisfação de cliente
        $oComercial = new Campo('As pessoas demonstram educação? Os contatos atendem as suas necessidades?', 'comercial', Campo::CAMPO_SELECT, 6, 6, 6, 6);
        $oComercial->addItemSelect('0', 'Nota 0');
        $oComercial->addItemSelect('1', 'Nota 1');
        $oComercial->addItemSelect('2', 'Nota 2');
        $oComercial->addItemSelect('3', 'Nota 3');
        $oComercial->addItemSelect('4', 'Nota 4');
        $oComercial->addItemSelect('5', 'Nota 5');
        $oComercial->setIMarginTop(0);
        $oComercial->addValidacao(false, Validacao::TIPO_STRING, '', '1');



        $oProdrequisito = new Campo('Os produtos atendem aos requisitos especificados?', 'prodrequisito', Campo::CAMPO_SELECT, 6, 6, 6, 6);
        $oProdrequisito->addItemSelect('0', 'Nota 0');
        $oProdrequisito->addItemSelect('1', 'Nota 1');
        $oProdrequisito->addItemSelect('2', 'Nota 2');
        $oProdrequisito->addItemSelect('3', 'Nota 3');
        $oProdrequisito->addItemSelect('4', 'Nota 4');
        $oProdrequisito->addItemSelect('5', 'Nota 5');
        $oProdrequisito->setIMarginTop(0);
        $oProdrequisito->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oProdembalagem = new Campo('A embalagem garante a proteção e movimentação?', 'prodembalagem', Campo::CAMPO_SELECT, 6, 6, 6, 6);
        $oProdembalagem->addItemSelect('0', 'Nota 0');
        $oProdembalagem->addItemSelect('1', 'Nota 1');
        $oProdembalagem->addItemSelect('2', 'Nota 2');
        $oProdembalagem->addItemSelect('3', 'Nota 3');
        $oProdembalagem->addItemSelect('4', 'Nota 4');
        $oProdembalagem->addItemSelect('5', 'Nota 5');
        $oProdembalagem->setIMarginTop(0);
        $oProdembalagem->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oProdprazo = new Campo('O prazo de entrega, conforme pré-estabelecido, está dentro das expectativas?', 'prodprazo', Campo::CAMPO_SELECT, 6, 6, 6, 6);
        $oProdprazo->addItemSelect('0', 'Nota 0');
        $oProdprazo->addItemSelect('1', 'Nota 1');
        $oProdprazo->addItemSelect('2', 'Nota 2');
        $oProdprazo->addItemSelect('3', 'Nota 3');
        $oProdprazo->addItemSelect('4', 'Nota 4');
        $oProdprazo->addItemSelect('5', 'Nota 5');
        $oProdprazo->setIMarginTop(0);
        $oProdprazo->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oGeralExp = new Campo('A sua empresa considera que neste último ano a Metalbo atendeu as expectativas?', 'geralexpectativa', Campo::CAMPO_SELECT, 6, 6, 6, 6);
        $oGeralExp->addItemSelect('0', 'Nota 0');
        $oGeralExp->addItemSelect('1', 'Nota 1');
        $oGeralExp->addItemSelect('2', 'Nota 2');
        $oGeralExp->addItemSelect('3', 'Nota 3');
        $oGeralExp->addItemSelect('4', 'Nota 4');
        $oGeralExp->addItemSelect('5', 'Nota 5');
        $oGeralExp->setIMarginTop(0);
        $oGeralExp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oGeralindica = new Campo('Você indicaria os produtos da Metalbo?', 'geralindica', Campo::CAMPO_SELECT, 6, 6, 6, 6);
        $oGeralindica->addItemSelect('0', 'Nota 0');
        $oGeralindica->addItemSelect('1', 'Nota 1');
        $oGeralindica->addItemSelect('2', 'Nota 2');
        $oGeralindica->addItemSelect('3', 'Nota 3');
        $oGeralindica->addItemSelect('4', 'Nota 4');
        $oGeralindica->addItemSelect('5', 'Nota 5');
        $oGeralindica->setIMarginTop(0);
        $oGeralindica->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oObs = new campo('Observações', 'obs', Campo::TIPO_TEXTAREA, 10);
        $oObs->setILinhasTextArea(3);

        $oContato = new Campo('Contato', 'contato', Campo::TIPO_TEXTO, 3, 3, 3);
        $oEmail = new Campo('E-mail', 'email', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oEmail->addValidacao(false, Validacao::TIPO_EMAIL, 'Email inválido', '4');

        $oEmailEnv = new Campo('', 'emailenv', Campo::TIPO_TEXTO, 1);
        $oEmailEnv->setSValor('Não');
        $oEmailEnv->setBOculto(true);


        //fieldset
        $oEmpcod->setClasseBusca('Pessoa');
        $oEmpcod->setSCampoRetorno('empcod', $this->getTela()->getid());
        $oEmpcod->addCampoBusca('empdes', $oEmpdes->getId(), $this->getTela()->getId());

        $oFieldComercial = new FieldSet('Comercial');
        $oFieldComercial->addCampos($oComercial);
        $oFieldComercial->setOculto(true);

        $oFieldProduto = new FieldSet('Produtos');
        $oFieldProduto->addCampos($oProdrequisito, $oProdembalagem, $oProdprazo);
        $oFieldProduto->setOculto(true);

        $oFieldEmpresa = new FieldSet('Empresa');
        $oFieldEmpresa->addCampos($oGeralExp, $oGeralindica);
        $oFieldEmpresa->setOculto(true);


        //botão confirmar
        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus, 

        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' .
                $oSeq->getId() . ',' . $sGrid . ',' . $oEmpcod->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");'
                . 'expandeField("' . $oFieldComercial->getSId() . '");expandeField("' . $oFieldEmpresa->getSId() . '");expandeField("' . $oFieldProduto->getSId() . '");';

        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        //$sAcao = $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oSeq->getId().','.$sGrid.','.$oCausa->getId().','.$oCausa->getId().'","'.$oFilcgc->getSValor().','.$oNr->getSValor().'");';





        $this->addCampos(array($oSeq, $oSeqRel, $oEmpcod, $oEmpdes), array($oFilcgc, $oNr), $oFieldComercial, $oFieldProduto, $oFieldEmpresa, $oObs, array($oContato, $oEmail, $oEmailEnv, $oBotConf));

        $this->addCamposFiltroIni($oFilcgc);
        $this->addCamposFiltroIni($oNr);

        $sAcaoDisp = 'var contdel = 0; '
                . 'var chavedel = []; '
                . '$("#' . $this->getOGridDetalhe()->getSId() . 'div tbody .selected").each(function(){'
                . 'chavedel[contdel] = $(this).find(".chave").html();'
                . 'contdel++;'
                . '});'
                . 'requestAjax("","' . $this->getController() . '","msgEmail","' . $this->getOGridDetalhe()->getSId() . '",chavedel);';

        $oBotaoEmail = new Botao('E-mail agradecimento', Botao::TIPO_DETALHE, $sAcaoDisp);
        $oBotaoEmail->setSStyleBotao(Botao::TIPO_WARNING);

        $this->getTela()->addBotDet($oBotaoEmail);
    }

}
