<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_Documentos extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);

        $oNr = new CampoConsulta('NR', 'nr');
        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oNomeDoc = new CampoConsulta('Documento', 'documento');

        $oTotDig = new CampoConsulta('Cópias Digitais', 'total_Dig');
        $oTotFis = new CampoConsulta('Cópias Físicas', 'total_Fis');

        $oRevisao = new CampoConsulta('Revisão Atual', 'revisao');

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12,false);

        $this->addFiltro($oFilNr);

        $this->addCampos($oNr, $oFilcgc, $oNomeDoc, $oRevisao, $oTotDig, $oTotFis);
    }

    public function criaTela() {
        parent::criaTela();


        $oTab = new TabPanel();
        $oTabDigital = new AbaTabPanel('Cópias digitais');
        $oTabDigital->setBActive(true);
        $oTabFisica = new AbaTabPanel('Cópias físicas');
        $this->addLayoutPadrao('Aba');

        $oDados = $this->getAParametrosExtras();
        $sAcaoRotina = $this->getSRotina();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);

        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setSValor($_SESSION['nome']);

        $oDoc = new Campo('Documento', 'documento', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oDoc->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 5);

        $oRevisao = new Campo('', 'revisao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRevisao->setBOculto(true);

///////////////////////////////////////////////////////////// CÓPIAS DIGITAIS //////////////////////////////////////////////////////////////////////////////////////////////////////

        $oCopiasDigitais = new Campo('Selecionar setores com as cópias <b style="font-weight:600">DIGITAIS</b> disponíveis e preencher a quantidade', 'digitais', Campo::TIPO_BADGE, 6, 6, 12, 12);
        $oCopiasDigitais->setSEstiloBadge(Campo::BADGE_PRIMARY);
        $oCopiasDigitais->setApenasTela(true);
        $oCopiasDigitais->setITamFonteBadge(20);

        $oDig_Direcao_Quant = new Campo('Quantidade', 'dig_direcao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Direcao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_direcao_quant == null) {
            $oDig_Direcao_Quant->setBOculto(true);
        }
        $oDig_Direcao = new Campo('Direção', 'dig_direcao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Direcao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Direcao_Quant->getId() . ',' . $oDados->dig_direcao_quant . '");');

        $oDig_Gestao_Qualidade_Quant = new Campo('Quantidade', 'dig_gestao_qualidade_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Gestao_Qualidade_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_gestao_qualidade_quant == null) {
            $oDig_Gestao_Qualidade_Quant->setBOculto(true);
        }
        $oDig_Gestao_Qualidade = new Campo('Gestão da Qualidade', 'dig_gestao_qualidade', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Gestao_Qualidade->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Gestao_Qualidade_Quant->getId() . ',' . $oDados->dig_gestao_qualidade_quant . '");');


        $oDig_Vendas_Quant = new Campo('Quantidade', 'dig_vendas_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Vendas_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_vendas_quant == null) {
            $oDig_Vendas_Quant->setBOculto(true);
        }
        $oDig_Vendas = new Campo('Vendas', 'dig_vendas', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Vendas->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Vendas_Quant->getId() . ',' . $oDados->dig_vendas_quant . '");');

        $oDig_Projetos_Quant = new Campo('Quantidade', 'dig_projetos_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Projetos_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_projetos_quant == null) {
            $oDig_Projetos_Quant->setBOculto(true);
        }
        $oDig_Projetos = new Campo('Projetos', 'dig_projetos', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Projetos->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Projetos_Quant->getId() . ',' . $oDados->dig_projetos_quant . '");');

        $oDig_Plan_Producao_Quant = new Campo('Quantidade', 'dig_plan_producao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Plan_Producao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_plan_producao_quant == null) {
            $oDig_Plan_Producao_Quant->setBOculto(true);
        }
        $oDig_Plan_Producao = new Campo('Plan. Produção', 'dig_plan_producao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Plan_Producao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Plan_Producao_Quant->getId() . ',' . $oDados->dig_plan_producao_quant . '");');

        $oDig_Compras_Quant = new Campo('Quantidade', 'dig_compras_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Compras_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_compras_quant == null) {
            $oDig_Compras_Quant->setBOculto(true);
        }
        $oDig_Compras = new Campo('Compras', 'dig_compras', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Compras->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Compras_Quant->getId() . ',' . $oDados->dig_compras_quant . '");');

        $oDig_Almoxarifado_Quant = new Campo('Quantidade', 'dig_almoxarifado_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Almoxarifado_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_almoxarifado_quant == null) {
            $oDig_Almoxarifado_Quant->setBOculto(true);
        }
        $oDig_Almoxarifado = new Campo('Almoxarifado', 'dig_almoxarifado', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Almoxarifado->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Almoxarifado_Quant->getId() . ',' . $oDados->dig_almoxarifado_quant . '");');

        $oDig_Rh_Quant = new Campo('Quantidade', 'dig_rh_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Rh_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_rh_quant == null) {
            $oDig_Rh_Quant->setBOculto(true);
        }
        $oDig_Rh = new Campo('RH', 'dig_rh', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Rh->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Rh_Quant->getId() . ',' . $oDados->dig_rh_quant . '");');

        $oDig_Ti_Quant = new Campo('Quantidade', 'dig_ti_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Ti_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_ti_quant == null) {
            $oDig_Ti_Quant->setBOculto(true);
        }
        $oDig_Ti = new Campo('TI', 'dig_ti', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Ti->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Ti_Quant->getId() . ',' . $oDados->dig_ti_quant . '");');

        $oDig_Expedicao_Quant = new Campo('Quantidade', 'dig_expedicao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Expedicao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_expedicao_quant == null) {
            $oDig_Expedicao_Quant->setBOculto(true);
        }
        $oDig_Expedicao = new Campo('Expedição', 'dig_expedicao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Expedicao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Expedicao_Quant->getId() . ',' . $oDados->dig_expedicao_quant . '");');

        $oDig_Embalagem_Quant = new Campo('Quantidade', 'dig_embalagem_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Embalagem_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_embalagem_quant == null) {
            $oDig_Embalagem_Quant->setBOculto(true);
        }
        $oDig_Embalagem = new Campo('Embalagem', 'dig_embalagem', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Embalagem->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Embalagem_Quant->getId() . ',' . $oDados->dig_embalagem_quant . '");');

        $oDig_Seguranca_Quant = new Campo('Quantidade', 'dig_seguranca_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Seguranca_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_seguranca_quant == null) {
            $oDig_Seguranca_Quant->setBOculto(true);
        }
        $oDig_Seguranca = new Campo('Segurança', 'dig_seguranca', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Seguranca->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Seguranca_Quant->getId() . ',' . $oDados->dig_seguranca_quant . '");');

        $oDig_Garantia_Qualidade_Quant = new Campo('Quantidade', 'dig_garantia_qualidade_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Garantia_Qualidade_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_garantia_qualidade_quant == null) {
            $oDig_Garantia_Qualidade_Quant->setBOculto(true);
        }
        $oDig_Garantia_Qualidade = new Campo('Gar. Qualidade', 'dig_garantia_qualidade', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Garantia_Qualidade->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Garantia_Qualidade_Quant->getId() . ',' . $oDados->dig_garantia_qualidade_quant . '");');

        $oDig_PCP_Quant = new Campo('Quantidade', 'dig_pcp_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_PCP_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_pcp_quant == null) {
            $oDig_PCP_Quant->setBOculto(true);
        }
        $oDig_PCP = new Campo('PCP', 'dig_pcp', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_PCP->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_PCP_Quant->getId() . ',' . $oDados->dig_pcp_quant . '");');

        $oDig_Fosfatizacao_Quant = new Campo('Quantidade', 'dig_fosfatizacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Fosfatizacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_fosfatizacao_quant == null) {
            $oDig_Fosfatizacao_Quant->setBOculto(true);
        }
        $oDig_Fosfatizacao = new Campo('Fosfatização', 'dig_fosfatizacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Fosfatizacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Fosfatizacao_Quant->getId() . ',' . $oDados->dig_fosfatizacao_quant . '");');


        $oDig_Trefilacao_Quant = new Campo('Quantidade', 'dig_trefilacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Trefilacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_trefilacao_quant == null) {
            $oDig_Trefilacao_Quant->setBOculto(true);
        }
        $oDig_Trefilacao = new Campo('Trefila', 'dig_trefilacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Trefilacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Trefilacao_Quant->getId() . ',' . $oDados->dig_trefilacao_quant . '");');

        $oDig_Conf_Frio_PO_Quant = new Campo('Quantidade', 'dig_conf_frio_PO_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Conf_Frio_PO_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_conf_frio_PO_quant == null) {
            $oDig_Conf_Frio_PO_Quant->setBOculto(true);
        }
        $oDig_Conf_Frio_PO = new Campo('Conf. Frio PO', 'dig_conf_frio_PO', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Conf_Frio_PO->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Conf_Frio_PO_Quant->getId() . ',' . $oDados->dig_conf_frio_PO_quant . '");');

        $oDig_Conf_Frio_PA_Quant = new Campo('Quantidade', 'dig_conf_frio_PA_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Conf_Frio_PA_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_conf_frio_PA_quant == null) {
            $oDig_Conf_Frio_PA_Quant->setBOculto(true);
        }
        $oDig_Conf_Frio_PA = new Campo('Conf. Frio PA', 'dig_conf_frio_PA', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Conf_Frio_PA->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Conf_Frio_PA_Quant->getId() . ',' . $oDados->dig_conf_frio_PA_quant . '");');

        $oDig_Machos_Quant = new Campo('Quantidade', 'dig_machos_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Machos_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_machos_quant == null) {
            $oDig_Machos_Quant->setBOculto(true);
        }
        $oDig_Machos = new Campo('Machos', 'dig_machos', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Machos->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Machos_Quant->getId() . ',' . $oDados->dig_machos_quant . '");');

        $oDig_Conf_Quente_Quant = new Campo('Quantidade', 'dig_conf_quente_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Conf_Quente_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_conf_quente_quant == null) {
            $oDig_Conf_Quente_Quant->setBOculto(true);
        }
        $oDig_Conf_Quente = new Campo('Conf. Quente', 'dig_conf_quente', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Conf_Quente->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Conf_Quente_Quant->getId() . ',' . $oDados->dig_conf_quente_quant . '");');

        $oDig_Forno_Rev_Cont_Quant = new Campo('Quantidade', 'dig_forno_rev_cont_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Forno_Rev_Cont_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_forno_rev_cont_quant == null) {
            $oDig_Forno_Rev_Cont_Quant->setBOculto(true);
        }
        $oDig_Forno_Rev_Cont = new Campo('Forno Rev.', 'dig_forno_rev_cont', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Forno_Rev_Cont->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Forno_Rev_Cont_Quant->getId() . ',' . $oDados->dig_forno_rev_cont_quant . '");');

        $oDig_Galvanizacao_Quant = new Campo('Quantidade', 'dig_galvanizacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Galvanizacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_galvanizacao_quant == null) {
            $oDig_Galvanizacao_Quant->setBOculto(true);
        }
        $oDig_Galvanizacao = new Campo('Galvanização', 'dig_galvanizacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Galvanizacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Galvanizacao_Quant->getId() . ',' . $oDados->dig_galvanizacao_quant . '");');

        $oDig_Lab_Galvanizacao_Quant = new Campo('Quantidade', 'dig_lab_galvanizacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Lab_Galvanizacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_lab_galvanizacao_quant == null) {
            $oDig_Lab_Galvanizacao_Quant->setBOculto(true);
        }
        $oDig_Lab_Galvanizacao = new Campo('Lab. Galvanização', 'dig_lab_galvanizacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Lab_Galvanizacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Lab_Galvanizacao_Quant->getId() . ',' . $oDados->dig_lab_galvanizacao_quant . '");');

        $oDig_Usinagem_Quant = new Campo('Quantidade', 'dig_usinagem_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Usinagem_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_usinagem_quant == null) {
            $oDig_Usinagem_Quant->setBOculto(true);
        }
        $oDig_Usinagem = new Campo('Usinagem', 'dig_usinagem', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Usinagem->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Usinagem_Quant->getId() . ',' . $oDados->dig_usinagem_quant . '");');

        $oDig_Expedicao_Expo_Quant = new Campo('Quantidade', 'dig_expedicao_expo_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Expedicao_Expo_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_expedicao_expo_quant == null) {
            $oDig_Expedicao_Expo_Quant->setBOculto(true);
        }
        $oDig_Expedicao_Expo = new Campo('Exp. Exportação', 'dig_expedicao_expo', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Expedicao_Expo->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Expedicao_Expo_Quant->getId() . ',' . $oDados->dig_expedicao_expo_quant . '");');

        $oDig_Ferramentaria_Quant = new Campo('Quantidade', 'dig_ferramentaria_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Ferramentaria_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_ferramentaria_quant == null) {
            $oDig_Ferramentaria_Quant->setBOculto(true);
        }
        $oDig_Ferramentaria = new Campo('Ferramentaria', 'dig_ferramentaria', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Ferramentaria->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Ferramentaria_Quant->getId() . ',' . $oDados->dig_ferramentaria_quant . '");');

        $oDig_Manutencao_Quant = new Campo('Quantidade', 'dig_manutencao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Manutencao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_manutencao_quant == null) {
            $oDig_Manutencao_Quant->setBOculto(true);
        }
        $oDig_Manutencao = new Campo('Manutenção', 'dig_manutencao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Manutencao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Manutencao_Quant->getId() . ',' . $oDados->dig_manutencao_quant . '");');


        $oDig_Nylon_Quant = new Campo('Quantidade', 'dig_nylon_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Nylon_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_nylon_quant == null) {
            $oDig_Nylon_Quant->setBOculto(true);
        }
        $oDig_Nylon = new Campo('Nylon', 'dig_nylon', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Nylon->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Nylon_Quant->getId() . ',' . $oDados->dig_nylon_quant . '");');

        $oDig_Ete_Quant = new Campo('Quantidade', 'dig_ete_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Ete_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_ete_quant == null) {
            $oDig_Ete_Quant->setBOculto(true);
        }
        $oDig_Ete = new Campo('ETE', 'dig_ete', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Ete->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Ete_Quant->getId() . ',' . $oDados->dig_ete_quant . '");');

        $oDig_Steeltrater_Quant = new Campo('Quantidade', 'dig_steeltrater_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Steeltrater_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_steeltrater_quant == null) {
            $oDig_Steeltrater_Quant->setBOculto(true);
        }
        $oDig_Steeltrater = new Campo('Steeltrater', 'dig_steeltrater', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Steeltrater->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Steeltrater_Quant->getId() . ',' . $oDados->dig_steeltrater_quant . '");');

        $oDig_Salt_Spray_Quant = new Campo('Quantidade', 'dig_salt_spray_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Salt_Spray_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_salt_spray_quant == null) {
            $oDig_Salt_Spray_Quant->setBOculto(true);
        }
        $oDig_Salt_Spray = new Campo('Salt Spray', 'dig_salt_spray', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Salt_Spray->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Salt_Spray_Quant->getId() . ',' . $oDados->dig_salt_spray_quant . '");');

        $oDig_JL_Galvano_Quant = new Campo('Quantidade', 'dig_jl_galvano_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_JL_Galvano_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_jl_galvano_quant == null) {
            $oDig_JL_Galvano_Quant->setBOculto(true);
        }
        $oDig_JL_Galvano = new Campo('JL Galvano', 'dig_jl_galvano', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_JL_Galvano->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_JL_Galvano_Quant->getId() . ',' . $oDados->dig_jl_galvano_quant . '");');

        $oDig_Prada_Galvano_Quant = new Campo('Quantidade', 'dig_prada_galvano_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oDig_Prada_Galvano_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->dig_prada_galvano_quant == null) {
            $oDig_Prada_Galvano_Quant->setBOculto(true);
        }
        $oDig_Prada_Galvano = new Campo('Prada Galvano', 'dig_prada_galvano', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oDig_Prada_Galvano->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oDig_Prada_Galvano_Quant->getId() . ',' . $oDados->dig_prada_galvano_quant . '");');

        //////////////////////////////////////////////////////////// CÓPIAS FÍSICAS ///////////////////////////////////////////////////////////////////////////////////////////////////

        $oCopiasFisicas = new Campo('Selecionar setores com as cópias <b style="font-weight:600">FÍSICAS</b> disponíveis e preencher a quantidade', 'fisicas', Campo::TIPO_BADGE, 6, 6, 12, 12);
        $oCopiasFisicas->setApenasTela(true);
        $oCopiasFisicas->setITamFonteBadge(20);


        $oFis_Direcao_Quant = new Campo('Quantidade', 'fis_direcao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Direcao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_direcao_quant == null) {
            $oFis_Direcao_Quant->setBOculto(true);
        }
        $oFis_Direcao = new Campo('Direção', 'fis_direcao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Direcao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Direcao_Quant->getId() . ',' . $oDados->fis_direcao_quant . '");');

        $oFis_Gestao_Qualidade_Quant = new Campo('Quantidade', 'fis_gestao_qualidade_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Gestao_Qualidade_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_gestao_qualidade_quant == null) {
            $oFis_Gestao_Qualidade_Quant->setBOculto(true);
        }
        $oFis_Gestao_Qualidade = new Campo('Gestão da Qualidade', 'fis_gestao_qualidade', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Gestao_Qualidade->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Gestao_Qualidade_Quant->getId() . ',' . $oDados->fis_gestao_qualidade_quant . '");');


        $oFis_Vendas_Quant = new Campo('Quantidade', 'fis_vendas_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Vendas_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_vendas_quant == null) {
            $oFis_Vendas_Quant->setBOculto(true);
        }
        $oFis_Vendas = new Campo('Vendas', 'fis_vendas', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Vendas->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Vendas_Quant->getId() . ',' . $oDados->fis_vendas_quant . '");');

        $oFis_Projetos_Quant = new Campo('Quantidade', 'fis_projetos_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Projetos_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_projetos_quant == null) {
            $oFis_Projetos_Quant->setBOculto(true);
        }
        $oFis_Projetos = new Campo('Projetos', 'fis_projetos', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Projetos->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Projetos_Quant->getId() . ',' . $oDados->fis_projetos_quant . '");');

        $oFis_Plan_Producao_Quant = new Campo('Quantidade', 'fis_plan_producao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Plan_Producao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_plan_producao_quant == null) {
            $oFis_Plan_Producao_Quant->setBOculto(true);
        }
        $oFis_Plan_Producao = new Campo('Plan. Produção', 'fis_plan_producao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Plan_Producao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Plan_Producao_Quant->getId() . ',' . $oDados->fis_plan_producao_quant . '");');

        $oFis_Compras_Quant = new Campo('Quantidade', 'fis_compras_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Compras_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_compras_quant == null) {
            $oFis_Compras_Quant->setBOculto(true);
        }
        $oFis_Compras = new Campo('Compras', 'fis_compras', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Compras->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Compras_Quant->getId() . ',' . $oDados->fis_compras_quant . '");');

        $oFis_Almoxarifado_Quant = new Campo('Quantidade', 'fis_almoxarifado_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Almoxarifado_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_almoxarifado_quant == null) {
            $oFis_Almoxarifado_Quant->setBOculto(true);
        }
        $oFis_Almoxarifado = new Campo('Almoxarifado', 'fis_almoxarifado', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Almoxarifado->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Almoxarifado_Quant->getId() . ',' . $oDados->fis_almoxarifado_quant . '");');

        $oFis_Rh_Quant = new Campo('Quantidade', 'fis_rh_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Rh_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_rh_quant == null) {
            $oFis_Rh_Quant->setBOculto(true);
        }
        $oFis_Rh = new Campo('RH', 'fis_rh', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Rh->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Rh_Quant->getId() . ',' . $oDados->fis_rh_quant . '");');

        $oFis_Ti_Quant = new Campo('Quantidade', 'fis_ti_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Ti_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_ti_quant == null) {
            $oFis_Ti_Quant->setBOculto(true);
        }
        $oFis_Ti = new Campo('TI', 'fis_ti', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Ti->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Ti_Quant->getId() . ',' . $oDados->fis_ti_quant . '");');

        $oFis_Expedicao_Quant = new Campo('Quantidade', 'fis_expedicao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Expedicao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_expedicao_quant == null) {
            $oFis_Expedicao_Quant->setBOculto(true);
        }
        $oFis_Expedicao = new Campo('Expedição', 'fis_expedicao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Expedicao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Expedicao_Quant->getId() . ',' . $oDados->fis_expedicao_quant . '");');

        $oFis_Embalagem_Quant = new Campo('Quantidade', 'fis_embalagem_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Embalagem_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_embalagem_quant == null) {
            $oFis_Embalagem_Quant->setBOculto(true);
        }
        $oFis_Embalagem = new Campo('Embalagem', 'fis_embalagem', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Embalagem->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Embalagem_Quant->getId() . ',' . $oDados->fis_embalagem_quant . '");');

        $oFis_Seguranca_Quant = new Campo('Quantidade', 'fis_seguranca_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Seguranca_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_seguranca_quant == null) {
            $oFis_Seguranca_Quant->setBOculto(true);
        }
        $oFis_Seguranca = new Campo('Segurança', 'fis_seguranca', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Seguranca->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Seguranca_Quant->getId() . ',' . $oDados->fis_seguranca_quant . '");');

        $oFis_Garantia_Qualidade_Quant = new Campo('Quantidade', 'fis_garantia_qualidade_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Garantia_Qualidade_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_garantia_qualidade_quant == null) {
            $oFis_Garantia_Qualidade_Quant->setBOculto(true);
        }
        $oFis_Garantia_Qualidade = new Campo('Gar. Qualidade', 'fis_garantia_qualidade', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Garantia_Qualidade->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Garantia_Qualidade_Quant->getId() . ',' . $oDados->fis_garantia_qualidade_quant . '");');

        $oFis_PCP_Quant = new Campo('Quantidade', 'fis_pcp_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_PCP_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_pcp_quant == null) {
            $oFis_PCP_Quant->setBOculto(true);
        }
        $oFis_PCP = new Campo('PCP', 'fis_pcp', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_PCP->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_PCP_Quant->getId() . ',' . $oDados->fis_pcp_quant . '");');

        $oFis_Fosfatizacao_Quant = new Campo('Quantidade', 'fis_fosfatizacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Fosfatizacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_fosfatizacao_quant == null) {
            $oFis_Fosfatizacao_Quant->setBOculto(true);
        }
        $oFis_Fosfatizacao = new Campo('Fosfatização', 'fis_fosfatizacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Fosfatizacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Fosfatizacao_Quant->getId() . ',' . $oDados->fis_fosfatizacao_quant . '");');


        $oFis_Trefilacao_Quant = new Campo('Quantidade', 'fis_trefilacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Trefilacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_trefilacao_quant == null) {
            $oFis_Trefilacao_Quant->setBOculto(true);
        }
        $oFis_Trefilacao = new Campo('Trefila', 'fis_trefilacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Trefilacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Trefilacao_Quant->getId() . ',' . $oDados->fis_trefilacao_quant . '");');

        $oFis_Conf_Frio_PO_Quant = new Campo('Quantidade', 'fis_conf_frio_PO_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Conf_Frio_PO_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_conf_frio_PO_quant == null) {
            $oFis_Conf_Frio_PO_Quant->setBOculto(true);
        }
        $oFis_Conf_Frio_PO = new Campo('Conf. Frio PO', 'fis_conf_frio_PO', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Conf_Frio_PO->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Conf_Frio_PO_Quant->getId() . ',' . $oDados->fis_conf_frio_PO_quant . '");');

        $oFis_Conf_Frio_PA_Quant = new Campo('Quantidade', 'fis_conf_frio_PA_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Conf_Frio_PA_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_conf_frio_PA_quant == null) {
            $oFis_Conf_Frio_PA_Quant->setBOculto(true);
        }
        $oFis_Conf_Frio_PA = new Campo('Conf. Frio PA', 'fis_conf_frio_PA', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Conf_Frio_PA->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Conf_Frio_PA_Quant->getId() . ',' . $oDados->fis_conf_frio_PA_quant . '");');

        $oFis_Machos_Quant = new Campo('Quantidade', 'fis_machos_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Machos_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_machos_quant == null) {
            $oFis_Machos_Quant->setBOculto(true);
        }
        $oFis_Machos = new Campo('Machos', 'fis_machos', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Machos->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Machos_Quant->getId() . ',' . $oDados->fis_machos_quant . '");');

        $oFis_Conf_Quente_Quant = new Campo('Quantidade', 'fis_conf_quente_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Conf_Quente_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_conf_quente_quant == null) {
            $oFis_Conf_Quente_Quant->setBOculto(true);
        }
        $oFis_Conf_Quente = new Campo('Conf. Quente', 'fis_conf_quente', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Conf_Quente->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Conf_Quente_Quant->getId() . ',' . $oDados->fis_conf_quente_quant . '");');

        $oFis_Forno_Rev_Cont_Quant = new Campo('Quantidade', 'fis_forno_rev_cont_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Forno_Rev_Cont_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_forno_rev_cont_quant == null) {
            $oFis_Forno_Rev_Cont_Quant->setBOculto(true);
        }
        $oFis_Forno_Rev_Cont = new Campo('Forno Rev.', 'fis_forno_rev_cont', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Forno_Rev_Cont->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Forno_Rev_Cont_Quant->getId() . ',' . $oDados->fis_forno_rev_cont_quant . '");');

        $oFis_Galvanizacao_Quant = new Campo('Quantidade', 'fis_galvanizacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Galvanizacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_galvanizacao_quant == null) {
            $oFis_Galvanizacao_Quant->setBOculto(true);
        }
        $oFis_Galvanizacao = new Campo('Galvanização', 'fis_galvanizacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Galvanizacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Galvanizacao_Quant->getId() . ',' . $oDados->fis_galvanizacao_quant . '");');

        $oFis_Lab_Galvanizacao_Quant = new Campo('Quantidade', 'fis_lab_galvanizacao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Lab_Galvanizacao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_lab_galvanizacao_quant == null) {
            $oFis_Lab_Galvanizacao_Quant->setBOculto(true);
        }
        $oFis_Lab_Galvanizacao = new Campo('Lab. Galvanização', 'fis_lab_galvanizacao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Lab_Galvanizacao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Lab_Galvanizacao_Quant->getId() . ',' . $oDados->fis_lab_galvanizacao_quant . '");');

        $oFis_Usinagem_Quant = new Campo('Quantidade', 'fis_usinagem_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Usinagem_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_usinagem_quant == null) {
            $oFis_Usinagem_Quant->setBOculto(true);
        }
        $oFis_Usinagem = new Campo('Usinagem', 'fis_usinagem', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Usinagem->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Usinagem_Quant->getId() . ',' . $oDados->fis_usinagem_quant . '");');

        $oFis_Expedicao_Expo_Quant = new Campo('Quantidade', 'fis_expedicao_expo_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Expedicao_Expo_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_expedicao_expo_quant == null) {
            $oFis_Expedicao_Expo_Quant->setBOculto(true);
        }
        $oFis_Expedicao_Expo = new Campo('Exp. Exportação', 'fis_expedicao_expo', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Expedicao_Expo->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Expedicao_Expo_Quant->getId() . ',' . $oDados->fis_expedicao_expo_quant . '");');

        $oFis_Ferramentaria_Quant = new Campo('Quantidade', 'fis_ferramentaria_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Ferramentaria_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_ferramentaria_quant == null) {
            $oFis_Ferramentaria_Quant->setBOculto(true);
        }
        $oFis_Ferramentaria = new Campo('Ferramentaria', 'fis_ferramentaria', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Ferramentaria->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Ferramentaria_Quant->getId() . ',' . $oDados->fis_ferramentaria_quant . '");');

        $oFis_Manutencao_Quant = new Campo('Quantidade', 'fis_manutencao_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Manutencao_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_manutencao_quant == null) {
            $oFis_Manutencao_Quant->setBOculto(true);
        }
        $oFis_Manutencao = new Campo('Manutenção', 'fis_manutencao', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Manutencao->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Manutencao_Quant->getId() . ',' . $oDados->fis_manutencao_quant . '");');


        $oFis_Nylon_Quant = new Campo('Quantidade', 'fis_nylon_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Nylon_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_nylon_quant == null) {
            $oFis_Nylon_Quant->setBOculto(true);
        }
        $oFis_Nylon = new Campo('Nylon', 'fis_nylon', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Nylon->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Nylon_Quant->getId() . ',' . $oDados->fis_nylon_quant . '");');

        $oFis_Ete_Quant = new Campo('Quantidade', 'fis_ete_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Ete_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_ete_quant == null) {
            $oFis_Ete_Quant->setBOculto(true);
        }
        $oFis_Ete = new Campo('ETE', 'fis_ete', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Ete->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Ete_Quant->getId() . ',' . $oDados->fis_ete_quant . '");');

        $oFis_Steeltrater_Quant = new Campo('Quantidade', 'fis_steeltrater_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Steeltrater_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_steeltrater_quant == null) {
            $oFis_Steeltrater_Quant->setBOculto(true);
        }
        $oFis_Steeltrater = new Campo('Steeltrater', 'fis_steeltrater', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Steeltrater->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Steeltrater_Quant->getId() . ',' . $oDados->fis_steeltrater_quant . '");');

        $oFis_Salt_Spray_Quant = new Campo('Quantidade', 'fis_salt_spray_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Salt_Spray_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_salt_spray_quant == null) {
            $oFis_Salt_Spray_Quant->setBOculto(true);
        }
        $oFis_Salt_Spray = new Campo('Salt Spray', 'fis_salt_spray', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Salt_Spray->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Salt_Spray_Quant->getId() . ',' . $oDados->fis_salt_spray_quant . '");');

        $oFis_JL_Galvano_Quant = new Campo('Quantidade', 'fis_jl_galvano_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_JL_Galvano_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_jl_galvano_quant == null) {
            $oFis_JL_Galvano_Quant->setBOculto(true);
        }
        $oFis_JL_Galvano = new Campo('JL Galvano', 'fis_jl_galvano', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_JL_Galvano->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_JL_Galvano_Quant->getId() . ',' . $oDados->fis_jl_galvano_quant . '");');

        $oFis_Prada_Galvano_Quant = new Campo('Quantidade', 'fis_prada_galvano_quant', Campo::TIPO_TEXTO, 1, 1, 6, 6);
        $oFis_Prada_Galvano_Quant->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo obrigatório', 1);
        if ($oDados->fis_prada_galvano_quant == null) {
            $oFis_Prada_Galvano_Quant->setBOculto(true);
        }
        $oFis_Prada_Galvano = new Campo('Prada Galvano', 'fis_prada_galvano', Campo::TIPO_CHECK, 1, 1, 6, 6);
        $oFis_Prada_Galvano->addEvento(Campo::EVENTO_CLICK, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Documentos","toggle","' . $oFis_Prada_Galvano_Quant->getId() . ',' . $oDados->fis_prada_galvano_quant . '");');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cadastro de Documento', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Revisões do Documento', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);


        $oTabDigital->addCampos($oCopiasDigitais, array($oDig_Direcao, $oDig_Direcao_Quant, $oDig_Gestao_Qualidade, $oDig_Gestao_Qualidade_Quant, $oDig_Vendas, $oDig_Vendas_Quant, $oDig_Projetos, $oDig_Projetos_Quant), array($oDig_Plan_Producao, $oDig_Plan_Producao_Quant, $oDig_Compras, $oDig_Compras_Quant, $oDig_Almoxarifado, $oDig_Almoxarifado_Quant, $oDig_Rh, $oDig_Rh_Quant), array($oDig_Ti, $oDig_Ti_Quant, $oDig_Expedicao, $oDig_Expedicao_Quant, $oDig_Embalagem, $oDig_Embalagem_Quant, $oDig_Seguranca, $oDig_Seguranca_Quant), array($oDig_Garantia_Qualidade, $oDig_Garantia_Qualidade_Quant, $oDig_PCP, $oDig_PCP_Quant, $oDig_Fosfatizacao, $oDig_Fosfatizacao_Quant, $oDig_Trefilacao, $oDig_Trefilacao_Quant), array($oDig_Conf_Frio_PO, $oDig_Conf_Frio_PO_Quant, $oDig_Conf_Frio_PA, $oDig_Conf_Frio_PA_Quant, $oDig_Machos, $oDig_Machos_Quant, $oDig_Conf_Quente, $oDig_Conf_Quente_Quant), array($oDig_Forno_Rev_Cont, $oDig_Forno_Rev_Cont_Quant, $oDig_Galvanizacao, $oDig_Galvanizacao_Quant, $oDig_Lab_Galvanizacao, $oDig_Lab_Galvanizacao_Quant, $oDig_Usinagem, $oDig_Usinagem_Quant), array($oDig_Expedicao_Expo, $oDig_Expedicao_Expo_Quant, $oDig_Ferramentaria, $oDig_Ferramentaria_Quant, $oDig_Manutencao, $oDig_Manutencao_Quant, $oDig_Nylon, $oDig_Nylon_Quant), array($oDig_Ete, $oDig_Ete_Quant, $oDig_Steeltrater, $oDig_Steeltrater_Quant, $oDig_Salt_Spray, $oDig_Salt_Spray_Quant, $oDig_JL_Galvano, $oDig_JL_Galvano_Quant), array($oDig_Prada_Galvano, $oDig_Prada_Galvano_Quant));
        $oTabFisica->addCampos($oCopiasFisicas, array($oFis_Direcao, $oFis_Direcao_Quant, $oFis_Gestao_Qualidade, $oFis_Gestao_Qualidade_Quant, $oFis_Vendas, $oFis_Vendas_Quant, $oFis_Projetos, $oFis_Projetos_Quant), array($oFis_Plan_Producao, $oFis_Plan_Producao_Quant, $oFis_Compras, $oFis_Compras_Quant, $oFis_Almoxarifado, $oFis_Almoxarifado_Quant, $oFis_Rh, $oFis_Rh_Quant), array($oFis_Ti, $oFis_Ti_Quant, $oFis_Expedicao, $oFis_Expedicao_Quant, $oFis_Embalagem, $oFis_Embalagem_Quant, $oFis_Seguranca, $oFis_Seguranca_Quant), array($oFis_Garantia_Qualidade, $oFis_Garantia_Qualidade_Quant, $oFis_PCP, $oFis_PCP_Quant, $oFis_Fosfatizacao, $oFis_Fosfatizacao_Quant, $oFis_Trefilacao, $oFis_Trefilacao_Quant), array($oFis_Conf_Frio_PO, $oFis_Conf_Frio_PO_Quant, $oFis_Conf_Frio_PA, $oFis_Conf_Frio_PA_Quant, $oFis_Machos, $oFis_Machos_Quant, $oFis_Conf_Quente, $oFis_Conf_Quente_Quant), array($oFis_Forno_Rev_Cont, $oFis_Forno_Rev_Cont_Quant, $oFis_Galvanizacao, $oFis_Galvanizacao_Quant, $oFis_Lab_Galvanizacao, $oFis_Lab_Galvanizacao_Quant, $oFis_Usinagem, $oFis_Usinagem_Quant), array($oFis_Expedicao_Expo, $oFis_Expedicao_Expo_Quant, $oFis_Ferramentaria, $oFis_Ferramentaria_Quant, $oFis_Manutencao, $oFis_Manutencao_Quant, $oFis_Nylon, $oFis_Nylon_Quant), array($oFis_Ete, $oFis_Ete_Quant, $oFis_Steeltrater, $oFis_Steeltrater_Quant, $oFis_Salt_Spray, $oFis_Salt_Spray_Quant, $oFis_JL_Galvano, $oFis_JL_Galvano_Quant), array($oFis_Prada_Galvano, $oFis_Prada_Galvano_Quant));
        $oTab->addItems($oTabDigital, $oTabFisica);



        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {
            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }
            $this->setSIdControleUpAlt($oAcao->getId());

            $this->addCampos(array($oNr, $oFilcgc, $oUser, $oRevisao), array($oDoc), $oTab, $oAcao);
        } else {
            $this->addCampos(array($oNr, $oFilcgc, $oUser, $oRevisao), array($oDoc), $oTab);
        }
    }

}
