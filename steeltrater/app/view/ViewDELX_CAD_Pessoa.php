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

        $oEmpcod = new CampoConsulta('Código', 'emp_codigo');
        $oCnpj = new CampoConsulta('Cnpj', 'emp_cnpj');
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
        $this->addFiltro($oCnpjfiltro, $oRazaofiltro);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oEmpcod, $oCnpj, $oRazao, $oFantasia, $oCadastrodata, $oCadastrousuario);
    }

    public function criaTela() {
        parent::criaTela();

        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('Geral');
        $oAbaGeral->setBActive(true);

        $this->addLayoutPadrao('Aba');

        $oCnpj = new Campo('CNPJ/CPF', 'emp_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCnpj->addValidacao(false, Validacao::TIPO_INTEIRO);

        $oRazao = new Campo('Razão', 'emp_razaosocial', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oRazao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oRazao->addValidacao(false, Validacao::TIPO_STRING);

        //Informações Gerais
        $oFantasia = new Campo('Fantasia', 'emp_fantasia', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFantasia->addValidacao(false, Validacao::TIPO_STRING);
        $oEmpExt = new Campo('Empresa do Exterior', 'emp_exterior', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEmpExt->addItemSelect('N', 'Não');
        $oEmpExt->addItemSelect('S', 'Sim');
        $oTipPes = new Campo('Tipo de Pessoa', 'emp_tipopessoa', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipPes->addItemSelect('F', 'Física');
        $oTipPes->addItemSelect('J', 'Jurídica');
        $oTipPes->addItemSelect('C', 'Física com C.E.I.');
        $oConFin = new Campo('Cosumidor Final', 'emp_consumidorfinal', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oConFin->addItemSelect('N', 'Não');
        $oConFin->addItemSelect('S', 'Sim');
        $oOptSFe = new Campo('Optante Simples Federal', 'emp_optantesimplesfederal', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOptSFe->addItemSelect('N', 'Não');
        $oOptSFe->addItemSelect('S', 'Sim');
        $oMicEmp = new Campo('MEI - Micro Emprendedor Individual', 'emp_microempreendedor', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oMicEmp->addItemSelect('N', 'Não');
        $oMicEmp->addItemSelect('S', 'Sim');
        $oIncCul = new Campo('Incentivador Cultural', 'emp_incentivadorcultural', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oIncCul->addItemSelect('N', 'Não');
        $oIncCul->addItemSelect('S', 'Sim');
        $oForTri = new Campo('Forma Tributação', 'emp_formatributacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oForTri->addItemSelect(' ', 'Nenhum');
        $oForTri->addItemSelect('R', 'Lucro Real');
        $oForTri->addItemSelect('P', 'Lucro Presumido');
        $oForTri->addItemSelect('A', 'Lucro Arbitrário');
        $oDatFun = new Campo('Data Fundação', 'emp_datafundacao', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatNas = new Campo('Data Nascimento', 'emp_datanascimento', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oSituac = new Campo('Situação', 'emp_situacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituac->addItemSelect('N', 'Inativo');
        $oSituac->addItemSelect('A', 'Ativo');
        $oSituac->addItemSelect('B', 'Bloqueado');
        $oSituac->addItemSelect('I', 'Incompleto');
        $oCodAnt = new Campo('Código Antigo', 'emp_codigoantigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        /////////////////////////////////////////////////////////////////
        $oForPag = new Campo('Forma de Pagamento', 'emp_formapagamento', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oForPag->addItemSelect(' ', 'Nenhum');
        $oForPag->addItemSelect('V', 'A Vista');
        $oForPag->addItemSelect('A', 'Antecipado');
        $oForPag->addItemSelect('B', 'Boleto');
        $oForPag->addItemSelect('R', 'Cartão de Crédito');
        $oForPag->addItemSelect('S', 'Conta Salário');
        $oForPag->addItemSelect('C', 'Cheque');
        $oForPag->addItemSelect('2', 'Cheque OP(Ordem de Pagamento)');
        $oForPag->addItemSelect('1', 'Crédito em Conta Corrente');
        $oForPag->addItemSelect('P', 'Depósito em Conta');
        $oForPag->addItemSelect('M', 'Dinheiro');
        $oForPag->addItemSelect('3', 'DOC');
        $oForPag->addItemSelect('D', 'Duplicata');
        $oForPag->addItemSelect('F', 'Faturado');
        $oForPag->addItemSelect('N', 'Não Fatura');
        $oForPag->addItemSelect('4', 'TED');
        $oForPag->addItemSelect('T', 'Cartão de Débito');
        ///////////////////////////////////////////////////////
        $oAlmPri = new Campo('Almoxarifado Principal', 'emp_almoxarifadocodigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oAlmPri->setClasseBusca('DELX_EST_Almoxarifado');
        $oAlmPri->setSCampoRetorno('est_almoxarifadocodigo', $this->getTela()->getId());


        $oGruEco = new Campo('Grupo Econômico', 'emp_grupoeconomicocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPadGru = new Campo('Padrão do Grupo Econômico', 'emp_pessoapadraogrupoeconomico', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oPadGru->addItemSelect('N', 'Não');
        $oPadGru->addItemSelect('S', 'Sim');

        $oCodPag = new Campo('Condição de Pagamento', 'emp_condpagtocodigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oCodPag->setClasseBusca('DELX_CPG_CondicaoPagamento');
        $oCodPag->setSCampoRetorno('cpg_codigo', $this->getTela()->getId());

        $oTipMov = new Campo('Tipo de Movimento Para Faturamento', 'emp_tipomovimentocodigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oTipMov->setClasseBusca('DELX_NFS_TipoMovimento');
        $oTipMov->setSCampoRetorno('nfs_tipomovimentocodigo', $this->getTela()->getId());

        $oRepres = new Campo('Representante', 'rep_codigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12); //////////////////////////////////////VER
        $oRepres->setClasseBusca('DELX_COM_Repcod');
        $oRepres->setSCampoRetorno('rep_codigo', $this->getTela()->getId());
        //VERIFICAR  
        $oTabPre = new Campo('Tabela de Preço', 'emp_pessoatabelaprecocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTabPre->setSValor('Nenhum');
        $oTabFre = new Campo('Tabela de Frete por KM', 'emp_pessoatabelafretekm', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTabFre->setSValor('Nenhum');
        $oSitEmp = new Campo('Site da Empresa', 'emp_siteempresa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDesAti = new Campo('Descrição Atividade', 'emp_descricaoatividade', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        //Informações Gerais Adicionais
        //VERIFICAR
        $oEmpCob = new Campo('Empresa para Cobrança', 'emp_cobrancacodigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oEmpCob->setClasseBusca('DELX_CAD_Pessoa');
        $oEmpCob->setSCampoRetorno('emp_codigo', $this->getTela()->getId());

        //VERIFICAR
        $oTransp = new Campo('Transportadora', 'emp_transportadoracodigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oTransp->setClasseBusca('DELX_CAD_Pessoa');
        $oTransp->setSCampoRetorno('emp_codigo', $this->getTela()->getId());

        //VERIFICAR
        $oRedesp = new Campo('Redespacho', 'emp_redespachocodigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oRedesp->setClasseBusca('DELX_CAD_Pessoa');
        $oRedesp->setSCampoRetorno('emp_codigo', $this->getTela()->getId());

        $oPorEsp = new Campo('% Desconto Especial Cliente', 'emp_clientedesconto', Campo::TIPO_DECIMAL, 3, 3, 12, 12);
        $oPorBol = new Campo('% Desconto no Boleto', 'emp_descontoboleto', Campo::TIPO_DECIMAL, 3, 3, 12, 12);
        $oPorJur = new Campo('% Juros', 'emp_percentualjuros', Campo::TIPO_DECIMAL, 3, 3, 12, 12);
        $oPorMul = new Campo('% Multa', 'emp_percentualmulta', Campo::TIPO_DECIMAL, 3, 3, 12, 12);
        $oDiaAtr = new Campo('Dias para considerar títulos em atraso', 'emp_diasatraso', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCapSoc = new Campo('Capital Social', 'emp_capitalsocial', Campo::TIPO_MONEY, 3, 3, 12, 12);
        $oBloCre = new Campo('Bloqueio de Crédito', 'emp_creditobloqueio', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oBloCre->setSValor('Nenhum');
        $oBloCre->setBCampoBloqueado(true);
        $oDatCad = new Campo('Data do Cadastro', 'emp_cadastrodata', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatCad->setSValor(date('d/m/Y'));
        $oDatCad->setBCampoBloqueado(true);
        $oUsuCad = new Campo('Usuário que Cadastrou', 'emp_cadastrousuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuCad->setSValor($_SESSION['nome']);
        $oUsuCad->setBCampoBloqueado(true);
        $oGrupo = new Campo('Grupo', 'emp_grupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCodCNAE = new Campo('Código CNAE', 'emp_cnae', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodCNAE->setClasseBusca('DELX_FIS_Cnae');
        $oCodCNAE->setSCampoRetorno('FIS_CNAECodigo', $this->getTela()->getId());

        $oPaisOri = new Campo('País de Origem', 'emp_naturalidadepais', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oPaisOri->setClasseBusca('DELX_CID_Pais');
        $oPaisOri->setSCampoRetorno('cid_paiscodigo', $this->getTela()->getId());

        $oEstOrig = new Campo('Estado de Origem', 'emp_cidadeestadocodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oEstOrig->setClasseBusca('DELX_CID_Estado');
        $oEstOrig->setSCampoRetorno('cid_estadocodigo', $this->getTela()->getId());

        $oCidOrig = new Campo('Cidade de Origem', 'emp_naturalidadecidade', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCidOrig->setClasseBusca('DELX_CID_Cidade');
        $oCidOrig->setSCampoRetorno('cid_codigo', $this->getTela()->getId());

        $oDanfe = new Campo('Imprime referência do produto no cliente no DANFE', 'emp_imprimereferenciaprodutoda', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oDanfe->addItemSelect('N', 'Não');
        $oDanfe->addItemSelect('S', 'Sim');
        $oPefin = new Campo('Não Enviar Títulos ao Serasa - PEFIN', 'emp_naoenviatitulosserasapefin', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oPefin->addItemSelect('N', 'Não');
        $oPefin->addItemSelect('S', 'Sim');

        $oCreEmNfe = new Campo('Credenciado Para Emissão de NF-e', 'emp_credemissaonfe', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oCreEmNfe->addItemSelect('0', 'Não credenciado para a emissão da NF-e');
        $oCreEmNfe->addItemSelect('1', 'Credenciado');
        $oCreEmNfe->addItemSelect('2', 'Credenciado com obrigatoriedade para todas operações');
        $oCreEmNfe->addItemSelect('3', 'Credenciado com obrigatoriedade parcial');
        $oCreEmNfe->addItemSelect('4', 'A SEFAZ não fornece informação');
        $oDatFat = new Campo('Data de Desejo para Faturamento', 'emp_pessoadatadesejoparcela', Campo::TIPO_DATA, 3, 3, 12, 12);
        $oFluxCaix = new Campo('Desconsiderar Documento no Fluxo de Caixa', 'emp_pessoadesconsiderarfluxoca', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oFluxCaix->addItemSelect('N', 'Não');
        $oFluxCaix->addItemSelect('S', 'Sim');

        /////////////////////////////////////////////////////
        //Classificação
        ////////////////////////////////////////////////////
        $oClien = new Campo('Cliente', 'emp_cliente', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oClien->addItemSelect('N', 'Não');
        $oClien->addItemSelect('S', 'Sim');
        $oForne = new Campo('Fornecedor', 'emp_fornecedor', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oForne->addItemSelect('N', 'Não');
        $oForne->addItemSelect('S', 'Sim');
        $oRepr = new Campo('Representante', 'emp_representante', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oRepr->addItemSelect('N', 'Não');
        $oRepr->addItemSelect('S', 'Sim');
        $oTran = new Campo('Transportador', 'emp_transportador', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTran->addItemSelect('N', 'Não');
        $oTran->addItemSelect('S', 'Sim');
        $oAssis = new Campo('Assistência Técnica', 'emp_assistenciatecnica', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oAssis->addItemSelect('N', 'Não');
        $oAssis->addItemSelect('S', 'Sim');
        $oFunci = new Campo('Funcionário', 'emp_funcionario', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oFunci->addItemSelect('N', 'Não');
        $oFunci->addItemSelect('S', 'Sim');
        $oProsp = new Campo('Prospect', 'emp_prospect', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProsp->addItemSelect('N', 'Não');
        $oProsp->addItemSelect('S', 'Sim');
        $oProdu = new Campo('Produtor', 'emp_produtor', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProdu->addItemSelect('N', 'Não');
        $oProdu->addItemSelect('S', 'Sim');
        $oAssoc = new Campo('Associado/Cooperado', 'emp_associado', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oAssoc->addItemSelect('N', 'Não');
        $oAssoc->addItemSelect('S', 'Sim');
        $oMotor = new Campo('Motorista', 'emp_motorista', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMotor->addItemSelect('N', 'Não');
        $oMotor->addItemSelect('S', 'Sim');
        $oNegoc = new Campo('Negociador', 'emp_negociador', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oNegoc->addItemSelect('N', 'Não');
        $oNegoc->addItemSelect('S', 'Sim');
        $oTradin = new Campo('Trading', 'emp_trading', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTradin->addItemSelect('N', 'Não');
        $oTradin->addItemSelect('S', 'Sim');
        $oTecnic = new Campo('Técnico', 'emp_tecnico', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTecnic->addItemSelect('N', 'Não');
        $oTecnic->addItemSelect('S', 'Sim');
        $oCenDis = new Campo('Centro de Distribuição', 'emp_centrodistribuicao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oCenDis->addItemSelect('N', 'Não');
        $oCenDis->addItemSelect('S', 'Sim');
        $oPodPub = new Campo('Poder Público', 'emp_poderpublico', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPodPub->addItemSelect('N', 'Não');
        $oPodPub->addItemSelect('S', 'Sim');
        $oSuspec = new Campo('Suspect', 'emp_suspect', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSuspec->addItemSelect('N', 'Não');
        $oSuspec->addItemSelect('S', 'Sim');
        $oFavorec = new Campo('Favorecido (CF-e)', 'emp_favorecido', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oFavorec->addItemSelect('N', 'Não');
        $oFavorec->addItemSelect('S', 'Sim');
        $oOperad = new Campo('Operadora de Cartão', 'emp_operadoracartaocredito', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOperad->addItemSelect('N', 'Não');
        $oOperad->addItemSelect('S', 'Sim');
        $oBanFin = new Campo('Banco/Financeira', 'emp_financeira', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oBanFin->addItemSelect('N', 'Não');
        $oBanFin->addItemSelect('S', 'Sim');
        $oClaCli = new Campo('Classificação do Cliente', 'crm_contaclassificacaocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAutôm = new Campo('Autônomo', 'emp_autonomo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oAutôm->addItemSelect('N', 'Não');
        $oAutôm->addItemSelect('S', 'Sim');
        //Operador
        $oOpeCar = new Campo('Operador de Carregadeira', 'emp_operadorcarregadeira', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOpeCar->addItemSelect('N', 'Não');
        $oOpeCar->addItemSelect('S', 'Sim');
        $oOpeCol = new Campo('Operador de Colhedeira', 'emp_operadorcolhedeira', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOpeCol->addItemSelect('N', 'Não');
        $oOpeCol->addItemSelect('S', 'Sim');
        $oOpeTra = new Campo('Operador de Transbordo', 'emp_operadortransbordo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOpeTra->addItemSelect('N', 'Não');
        $oOpeTra->addItemSelect('S', 'Sim');
        $oOpeReb = new Campo('Operador de Reboque', 'emp_operadorreboque', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oOpeReb->addItemSelect('N', 'Não');
        $oOpeReb->addItemSelect('S', 'Sim');

        //Observações
        $oObsGer = new Campo('Observações Gerais', 'emp_observacoesgerais', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oObsCom = new Campo('Observações Comerciais', 'emp_observacoescomerciais', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDesAte = new Campo('Desbloqueio até', 'emp_pessoabloqueiodata', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oJusblo = new Campo('Justificativa do Bloqueio', 'emp_creditobloqueiojust', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oObsFin = new Campo('Observações Financeiras', 'emp_observacoesfinanceiras', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oObsTra = new Campo('Observações de Transporte', 'emp_observacoestms', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        //Informações de Fornecedor
        $oAvaFor = new Campo('Avaliação Fornecedor', 'emp_fornecedoravaliacao', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oAvaFor->addItemSelect('FAP', 'Aprovado');
        $oAvaFor->addItemSelect('FQU', 'Qualificado');
        $oAvaFor->addItemSelect('NA', 'Não se Aplica');
        $oAvaFor->addItemSelect('ND', 'Não Definida');
        $oAvaFor->addItemSelect('R', 'Reprovado');
        $oDatHom = new Campo('Data Homologação', 'emp_fornecedorhomologacao', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oForCon = new Campo('Fornecedor Contábil', 'emp_fornecedorcontabil', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oForCon->addItemSelect('N', 'Não');
        $oForCon->addItemSelect('S', 'Sim');
        $oPerFor = new Campo('% Fornecedor', 'emp_fornecedorpercentual', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oNotAdQ = new Campo('Nota Administração Qualidade', 'emp_fornecedornotaqualidade', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oFrete = new Campo('Frete', 'emp_tipofretecodigo', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oFrete->addItemSelect(' ', 'Nenhum');
        $oFrete->addItemSelect('1', 'CIF (POR CONTA DO EMITENTE)');
        $oFrete->addItemSelect('2', 'FOB(POR CONTA DO DESTINATÁRIO/REMETENTE');
        $oFrete->addItemSelect('3', 'POR CONTA DE TERCEIRO');
        $oFrete->addItemSelect('4', 'SEM COBRANÇA DO FRETE');

        $oPerExcQn = new Campo('Percentual Excedente de Quantidade', 'emp_comprapercdifqtd', Campo::TIPO_DECIMAL, 3, 3, 12, 12);
        $oPerExcUn = new Campo('Percentual Excedente de Valor Unitário', 'emp_comprapercdifvalor', Campo::TIPO_DECIMAL, 3, 3, 12, 12);
        $oExiTabPr = new Campo('Exige Tabela de Preço', 'emp_fornecedorexigetabela', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oExiTabPr->addItemSelect('N', 'Não');
        $oExiTabPr->addItemSelect('S', 'Sim');
        $oPadAnf = new Campo('Padrão Anfavea', 'emp_pessoapadraoanfavea', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oPadAnf->addItemSelect(' ', 'Nenhum');
        $oPadAnf->addItemSelect('C', 'Com Tag CDATA)');
        $oPadAnf->addItemSelect('S', 'Com Tag IAP0100');
        $oPadAnf->addItemSelect('X', 'Sem Tag');
        $oPadAnf->addItemSelect('F', 'Padrão CNH (Fiat)');
        $oPadAnf->addItemSelect('M', 'Referência/OrdemCompra');
        $oPadAnf->addItemSelect('I', 'Com Tag IAP01');

        $oCodAce = new Campo('Código de Acesso para a Cotação Online', 'emp_pessoacodigoacessocotonlin', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        //Informações do transportador
        $oRntrc = new Campo('RNTRC', 'emp_transportadorrntrc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCateg = new Campo('Categoria de RNTRC', 'emp_transportadorrntrccategori', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oSitRnt = new Campo('Situação do RNTRC', 'emp_transportadorrntrcsituacao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUtiTab = new Campo('Utiliza Tabela de Frete', 'emp_transportadortabelafrete', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oUtiTab->addItemSelect('N', 'Não');
        $oUtiTab->addItemSelect('S', 'Sim');
        $oCarDDR = new Campo('Carta DDR', 'emp_pessoacartaddr', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oCarDDR->addItemSelect('N', 'Não');
        $oCarDDR->addItemSelect('S', 'Sim');
        $oEnvXML = new Campo('Envia E-mail com XML Original do CT-e', 'emp_pessaenviaxmlcteoriginal', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oEnvXML->addItemSelect('N', 'Não');
        $oEnvXML->addItemSelect('S', 'Sim');
        //Data Ultima Alteração

        $oDatAlt = new Campo('Data de Alteração do Cadastro', 'emp_pessoadataalteracao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatAlt->setSValor(date('d/m/Y H:m'));

        $oField = new FieldSet('Informações Gerais');
        $oField->setOculto(true);

        $oFieldAdd = new FieldSet('Informações Gerais Adicionais');
        $oFieldAdd->setOculto(true);

        $oFieldClas = new FieldSet('Classificação');
        $oFieldClas->setOculto(true);

        $oFieldOper = new FieldSet('Operador');
        $oFieldOper->setOculto(true);

        $oFieldObser = new FieldSet('Obsevações');
        $oFieldObser->setOculto(true);

        $oFieldInf = new FieldSet('Informações de Fornecedor');
        $oFieldInf->setOculto(true);

        $oFieldTra = new FieldSet('Informações do Transportador');
        $oFieldTra->setOculto(true);

        $oFieldData = new FieldSet('Data Ultima Alteração');
        $oFieldData->setOculto(true);

        $oField->addCampos($oFantasia, array($oEmpExt, $oTipPes), array($oConFin, $oOptSFe, $oMicEmp), array($oIncCul, $oForTri), array($oDatFun, $oDatNas), array($oSituac, $oCodAnt), array($oForPag, $oAlmPri), array($oGruEco, $oPadGru, $oCodPag), $oTipMov, array($oRepres, $oTabPre), $oTabFre, $oSitEmp, $oDesAti
        );

        $oFieldAdd->addCampos(array($oEmpCob, $oTransp), $oRedesp, array($oPorEsp, $oPorBol), array($oPorJur, $oPorMul), array($oDiaAtr, $oCapSoc), array($oBloCre, $oDatCad), array($oUsuCad, $oGrupo), array($oCodCNAE, $oPaisOri), array($oEstOrig, $oCidOrig), array($oDanfe, $oPefin), array($oCreEmNfe), array($oDatFat, $oFluxCaix));

        $oFieldClas->addCampos(array($oClien, $oForne, $oRepr, $oTran, $oAssis, $oFunci), array($oProsp, $oProdu, $oAssoc, $oMotor, $oNegoc, $oTradin), array($oTecnic, $oCenDis, $oPodPub, $oSuspec, $oFavorec, $oOperad), array($oBanFin, $oClaCli, $oAutôm)
        );

        $oFieldOper->addCampos($oOpeCar, $oOpeCol, $oOpeTra, $oOpeReb);

        $oFieldObser->addCampos($oObsGer, $oObsCom, $oDesAte, $oJusblo, $oObsFin, $oObsTra);

        $oFieldInf->addCampos(array($oAvaFor, $oDatHom), array($oForCon, $oPerFor), array($oNotAdQ, $oFrete), array($oPerExcQn, $oPerExcUn), array($oExiTabPr, $oPadAnf), $oCodAce);


        $oFieldTra->addCampos(array($oRntrc, $oCateg, $oSitRnt, $oUtiTab), array($oCarDDR, $oEnvXML));

        $oFieldData->addCampos($oDatAlt);

        $oAbaGeral->addCampos($oField, $oFieldAdd, $oFieldClas, $oFieldOper, $oFieldObser, $oFieldInf, $oFieldTra, $oFieldData
        );


        $oTab->addItems($oAbaGeral);
        $this->addCampos(array($oCnpj, $oRazao), $oTab);
    }

}
