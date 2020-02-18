<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018 
 */

class ViewDELX_PRO_Produtocodbarra extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoVisualizar(true);

        $oCodigo = new CampoConsulta('Código', 'pro_codigo', CampoConsulta::TIPO_TEXTO);

        $oCodBarra = new CampoConsulta('Cód.Barra', 'pro_codigobarra', CampoConsulta::TIPO_TEXTO);

        $oCodBarraDes = new CampoConsulta('Descrição', 'pro_codigobarradescricao', CampoConsulta::TIPO_TEXTO);

        $oCodBarraUn = new CampoConsulta('Un.Medida', 'pro_codigobarraunidade', CampoConsulta::TIPO_TEXTO);

        $oCodBarraQt = new CampoConsulta('Qnt.', 'pro_codigobarraquantidade', CampoConsulta::TIPO_TEXTO);

        $oCodBarraGrade = new CampoConsulta('Grade', 'pro_codigobarragrade', CampoConsulta::TIPO_TEXTO);

        $oCodBarraNUsa = new CampoConsulta('Usa Cod.Barra', 'pro_codigobarranaousa', CampoConsulta::TIPO_TEXTO);

        $oCodBarraTipo = new CampoConsulta('Tipo', 'pro_codigobarratipo', CampoConsulta::TIPO_TEXTO);
        
        $oFilCodigo = new Filtro($oCodigo, Filtro::CAMPO_TEXTO);
        $oFilCodBarra = new Filtro($oCodBarra, Filtro::CAMPO_TEXTO);
        
        $this->addFiltro($oFilCodigo,$oFilCodBarra);
        $this->addCampos($oCodigo, $oCodBarra, $oCodBarraDes, $oCodBarraUn, $oCodBarraGrade, $oCodBarraNUsa, $oCodBarraQt, $oCodBarraTipo);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new Campo('Código', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oCodBarra = new Campo('Cód.Barra', 'pro_codigobarra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodBarra->addValidacao(false, Validacao::TIPO_STRING, '', '5', '30');

        $oCodBarraDes = new Campo('Descrição', 'pro_codigobarradescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oCodBarraUn = new Campo('Un.Medida', 'pro_codigobarraunidade', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodBarraUn->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oCodBarraUn->setSCampoRetorno('pro_unidademedida', $this->getTela()->getid());
        $oCodBarraUn->addValidacao(FALSE, Validacao::TIPO_STRING, '', '2', '2');

        $oCodBarraQt = new Campo('Qnt', 'pro_codigobarraquantidade', Campo::TIPO_DECIMAL
                , 1, 1, 12, 12);

        $oCodBarraGrade = new Campo('Grade', 'pro_codigobarragrade', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCodBarraGrade->addItemSelect('N', 'Não');
        $oCodBarraGrade->addItemSelect('S', 'Sim');

        $oCodBarraNUsa = new Campo('Usa Cod.Barra', 'pro_codigobarranaousa', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCodBarraNUsa->addItemSelect('N', 'Não');
        $oCodBarraNUsa->addItemSelect('S', 'Sim');

        $oCodBarraTipo = new Campo('Tipo', 'pro_codigobarratipo', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oCodBarraTipo->addItemSelect('E', 'EAN');
        $oCodBarraTipo->addItemSelect('D', 'DUN-14');
        $oCodBarraTipo->addItemSelect('O', 'Outros');

        $this->addCampos(array($oCodigo, $oCodBarra, $oCodBarraDes), $oCodBarraUn, $oCodBarraQt, array($oCodBarraGrade, $oCodBarraNUsa, $oCodBarraTipo));
    }

}
