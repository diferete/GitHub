<?php

/*
 * Classe que implementa a View da pesquisa de satisfação
 * 
 * @author Avanei Martendal
 * @since 15/01/2018
 */

class ViewSatisClientePesqShow extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Nr', 'nr');

        $oSeq = new CampoConsulta('Seq', 'seq');

        $oEmpdes = new CampoConsulta('Cliente', 'empdes', CampoConsulta::TIPO_LARGURA);

        $oEmail = new CampoConsulta('Mail', 'email');

        $oComercial = new CampoConsulta('Comercial', 'comercial', CampoConsulta::TIPO_DESTAQUE1);

        $oProdReq = new CampoConsulta('Prod.Requisito', 'prodrequisito', CampoConsulta::TIPO_DESTAQUE1);

        $oEmb = new CampoConsulta('Embalagem', 'prodembalagem', CampoConsulta::TIPO_DESTAQUE1);
        $oEmb->setILargura(50);

        $oPrazo = new CampoConsulta('Prazo', 'prodprazo', CampoConsulta::TIPO_DESTAQUE1);

        $oGeralExp = new CampoConsulta('Expectativa', 'geralexpectativa', CampoConsulta::TIPO_DESTAQUE1);

        $oIndica = new CampoConsulta('Indicação', 'geralindica', CampoConsulta::TIPO_DESTAQUE1);

        $oEmailEnv = new CampoConsulta('Enviado', 'emailenv');
        $oEmailEnv->addComparacao('Sim', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        $oEmailEnv->addComparacao('Não', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA);

        $this->addCampos($oNr, $oSeq, $oEmpdes, $oEmail, $oComercial, $oProdReq, $oEmb, $oPrazo, $oGeralExp, $oIndica, $oEmailEnv);
    }

}
