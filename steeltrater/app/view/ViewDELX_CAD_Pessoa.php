<?php

/*
 * Classe que implementa as views 
 * 
 * @author Avanei Martendal e Cleverton Hoffmann
 * @since 11/06/2018 - Alteração 25/09/2018
 */

class ViewDELX_CAD_Pessoa extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCnpj = new CampoConsulta('CNPJ/CPF', 'emp_codigo');
        $oCnpjfiltro = new Filtro($oCnpj, Filtro::CAMPO_TEXTO_IGUAL, 3);
        $oRazao = new CampoConsulta('Razão Social', 'emp_razaosocial');
        $oRazaofiltro = new Filtro($oRazao, Filtro::CAMPO_TEXTO, 4);
        $oFantasia = new CampoConsulta('Fantasia', 'emp_fantasia');
        $oCadastrodata = new CampoConsulta('Cad.Data', 'emp_cadastrodata', CampoConsulta::TIPO_DATA);
        $oCadastrousuario = new CampoConsulta('Cad.Usuário', 'emp_cadastrousuario');

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCnpjfiltro,$oRazaofiltro);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oCnpj, $oRazao, $oFantasia, $oCadastrodata, $oCadastrousuario);
    }

    public function criaTela() {
        parent::criaTela();

        $oCnpj = new Campo('CNPJ/CPF', 'emp_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        $oRazao = new Campo('Razão', 'emp_razaosocial', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oRazao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oFantasia = new Campo('Fantasia', 'emp_fantasia', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpExt= new Campo('Empresa do Exterior','emp_exterior', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTipPes= new Campo('Tipo de Pessoa','emp_tipopessoa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oConFin= new Campo('Cosumidor Final','emp_consumidorfinal', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oOptSFe= new Campo('Optante Simples Federal','emp_optantesimplesfederal', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMicEmp= new Campo('MEI - Micro Emprendedor Individual','emp_microempreendedor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oIncCul= new Campo('Incentivador Cultural','emp_incentivadorcultural', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oForTri= new Campo('Forma Tributação','emp_formatributacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatFun= new Campo('Data Fundação','emp_datafundacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatNas= new Campo('Data Nascimento','emp_datanascimento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSituac= new Campo('Situação','emp_situacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodAnt= new Campo('Código Antigo','emp_codigoantigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oForPag= new Campo('Forma de Pagamento','emp_formapagamento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAlmPri= new Campo('Almoxarifado Principal','emp_almoxarifadocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oGruEco= new Campo('Grupo Econômico','emp_grupoeconomicocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPadGru= new Campo('Padrão do Grupo Econômico','emp_pessoapadraogrupoeconomico', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodPag= new Campo('Condição de Pagamento','emp_condpagtocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTipMov= new Campo('Tipo de Movimento Para Faturamento','emp_tipomovimentocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRepres= new Campo('Representante','emp_representante', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTabPre= new Campo('Tabela de Preço','emp_pessoatabelaprecocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTabFre= new Campo('Tabela de Frete por KM','emp_pessoatabelafretekm', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitEmp= new Campo('Site da Empresa','emp_siteempresa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDesAti= new Campo('Descrição Atividade','emp_descricaoatividade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpCob= new Campo('Empresa para Cobrança','emp_cobrancacodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTransp= new Campo('Transportadora','emp_transportadoracodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRedesp= new Campo('Redespacho','emp_redespachocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPorEsp= new Campo('% Desconto Especial Cliente','emp_clientedesconto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPorBol= new Campo('% Desconto no Boleto','emp_descontoboleto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPorJur= new Campo('% Juros','emp_percentualjuros', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPorMul= new Campo('% Multa','emp_percentualmulta', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDiaAtr= new Campo('Dias para considerar títulos em atraso','emp_diasatraso', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCapSoc= new Campo('Capital Social','emp_capitalsocial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oBloCre= new Campo('Bloqueio de Crédito','emp_creditobloqueio', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatCad= new Campo('Data do Cadastro','emp_cadastrodata', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuCad= new Campo('Usuário que Cadastrou','emp_cadastrousuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oGrupo= new Campo('Grupo','emp_grupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodCNAE= new Campo('Código CNAE','emp_cnae', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPaisOri= new Campo('País de Origem','emp_naturalidadepais', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEstOrig= new Campo('Estado de Origem','emp_cidadeestadocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCidOrig= new Campo('Cidade de Origem','emp_naturalidadecidade', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDanfe= new Campo('Imprime referência do produto no cliente no DANFE','emp_imprimereferenciaprodutoda', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPefin= new Campo('Não Enviar Títulos ao Serasa - PEFIN','emp_naoenviatitulosserasapefin', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        ////////////////////////////////////////////FALTA CAMPO DDD
        $oCreEmNfe= new Campo('Credenciado Para Emissão de NF-e','emp_credemissaonfe', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatFat= new Campo('Data de Desejo para Faturamento','emp_pessoadatadesejoparcela', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFluxCaix= new Campo('Desconsiderar Documento no Fluxo de Caixa','emp_pessoadesconsiderarfluxoca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        /////////////////////////////////////////////////////
        //Classificação
        ////////////////////////////////////////////////////
        $oClien= new Campo('Cliente','emp_cliente', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oForne= new Campo('Fornecedor','emp_fornecedor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRepr= new Campo('Representante','rep_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTran= new Campo('Transportador','emp_transportador', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAssis= new Campo('Assistência Técnica','emp_assistenciatecnica', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFunci= new Campo('Funcionário','emp_funcionario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oProsp= new Campo('Prospect','emp_prospect', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oProdu= new Campo('Produtor','emp_produtor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAssoc= new Campo('Associado/Cooperado','emp_associado', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMotor= new Campo('Motorista','emp_motorista', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNegoc= new Campo('Negociador','emp_negociador', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTradin= new Campo('Trading','emp_trading', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTecnic= new Campo('Técnico','emp_tecnico', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCenDis= new Campo('Centro de Distribuição','emp_centrodistribuicao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPodPub= new Campo('Poder Público','emp_poderpublico', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSuspec= new Campo('Suspect','emp_suspect', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFavorec= new Campo('Favorecido (CF-e)','cfe_cfefavorecidocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oOperad= new Campo('Operadora de Cartão','emp_operadoracartaocredito', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oBanFin= new Campo('Banco/Financeira','emp_financeira', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oClaCli= new Campo('Classificação do Cliente','crm_contaclassificacaocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAutôm= new Campo('Autônomo','emp_automato', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCnpj, $oRazao)
                ,$oFantasia, 
                array($oEmpExt, $oTipPes),
                array($oConFin, $oOptSFe,$oMicEmp),
                array($oIncCul, $oForTri),
                array($oDatFun, $oDatNas),
                array($oSituac, $oCodAnt),
                array($oForPag, $oAlmPri),
                array($oGruEco, $oPadGru, $oCodPag),
                $oTipMov,
                array($oRepres, $oTabPre),
                $oTabFre,
                $oSitEmp,
                $oDesAti,
                $oEmpCob,
                $oTransp,
                $oRedesp,
                array($oPorEsp,$oPorBol),
                array($oPorJur, $oPorMul),
                array($oDiaAtr, $oCapSoc),
                array($oBloCre, $oDatCad),
                array($oUsuCad, $oGrupo),
                array($oCodCNAE, $oPaisOri),
                array($oEstOrig, $oCidOrig),
                array($oDanfe, $oPefin),
                array($oCreEmNfe),
                array($oDatFat, $oFluxCaix),
                array($oClien,$oForne,$oRepr,$oTran,$oAssis,$oFunci),
                array($oProsp,$oProdu,$oAssoc,$oMotor,$oNegoc,$oTradin),
                array($oTecnic,$oCenDis,$oPodPub,$oSuspec,$oFavorec,$oOperad),
                array($oBanFin,$oClaCli,$oAutôm)
                );
    }
}
