<?php

/* 
 * Classe que implementa os models da DELX_CAD_Pessoa
 * 
 * @author Avanei Martendal e Cleverton Hoffmann
 * @since 11/06/2018 - Alteração 25/09/2018
 */

class ModelDELX_CAD_Pessoa{
    
    
   /* 
    
    private $emp_ativa;        
    
    private $emp_situacaocadastral;
            
    
    private $emp_diretoriodocumentos;
    
    private $emp_funcionariomatricula;
    private $emp_funcionariomatriculadv;
   
    
    private $emp_necessitacertificado;
    private $emp_mvazerado;
    private $emp_pisporunidade;
    private $emp_cofinsporunidade;        
    private $emp_datanascimento;
    private $emp_icmsfretepresumido;
    
    private $emp_cfopcodigo;
    private $emp_graosunidadecodigo;
    private $emp_graosunidadenucleo;
    private $emp_carteiraidentidade;
    private $emp_associadostatus;
    private $emp_associadodataadmisao;
    private $emp_associadodatademisao;
    private $emp_associadoaposentado;
    private $emp_associadoacaoinss;
    private $emp_associadoquebratecnica;
    private $emp_associadodebitoautomatico;
    private $emp_associadodescontasindicato;
    private $emp_associadogeraadtoleite;
    private $emp_associadoparticipacao;
    private $emp_associadosexo;
    private $emp_numerodap;
    private $emp_vencimentodap;
    private $emp_aprovacaopedidovenda;
    private $emp_faturamentomedio;
    private $emp_valorcompras;
    private $grs_areabonificacao;
    private $grs_areaparceiro;
    private $grs_areadistancia;
    private $grs_areaheproprio;
    private $grs_areahepecuaria;
    private $grs_areahrarrendado;
    
    
    private $emp_cnpjraiz;
    
    
    
    private $emp_comprapercdifvalor;
    private $emp_comprapercdifqtd;
    
   
    private $emp_carteirahabilitacaodataven;
    private $emp_carteirahabilitacaonumero;
    private $emp_carteirahabilitacaoregistr;
    private $emp_categoriahabilitacao;
    private $emp_contratante;
    private $emp_transportadorrntrc;
    private $emp_transportadorrntrccategori;
    private $emp_transportadortabelafrete;
    
    private $emp_transportadorcargaperigosa;
    private $emp_retencaoconversao;
        
    private $emp_localtrabalho;
    private $emp_rendimento;
    
    private $crm_contatipoempresa;
    private $crm_contaresponsavelcodigo;
    
    private $crm_contaprospectconvertido;
    private $crm_contadataconversao;
    private $crm_contausuarioconversao;
    private $crm_contamaladireta;
    private $crm_contanumerofuncionarios;
    private $crm_contanumerounidades;
    private $crm_contareceitaanual;
    private ;
    private $crm_contaatuacaocodigo;
    private $crm_contarepresregiaobloqueado;
    private $fis_simpscancagenteanp;
    private $fis_simpscancinstalacaoanp;
    private $fis_simpscancatividadecodigo;
    private $fis_simpscancmodalcodigo;
    private $fis_simpscancbandeiracodigo;
    private $fis_simpscanccategoriacodigo;
    private $fis_simpscancnrodias;
    private $crm_cnpj;
    private $rhm_pessoaatividade;
    private $rhm_pessoapais;
    private $rhm_pessoaestado;
    private $rhm_pessoacrf;
    private $rhm_pessoacrm;
    private $rhm_pessoanit;
    private $rhm_pessoassmt;
    private $rhm_pessoaqualificacao;
    private $rhm_pessoamedicotitular;
    private $rhm_pessoanacionalidade;
    private $rhm_pessoafoneclinica;
    private $rhm_pessoasocio;
    private $emp_favorecido;
    private $emp_transportadorrntrcsituacao;
    private $cfe_cfefavorecidointegracaosit;
    private $crm_prospectestagiocodigo;
    private $crm_contadatainativacao;
    
    
    private $emp_pessoadircopiaxml;
    private $emp_pessoadiravisoembarque;
    private $emp_pessoacodigointerno;
    private $qld_affornecedorcriteriocodigo;
    private $emp_filial;
    private $emp_taxacredito;
    private $emp_taxadebito;
    private $emp_numerodias;
    private $emp_pessoafoto;
    private $emp_pessoafotofilename;
    private $emp_pessoafotofiletype;
    private $nfs_nfseconstrucaocivilart;
    private $nfs_nfseconstrucaocivilobra;
    
    
    private $emp_pessoaexpressao;
    private $emp_taxaprazocredito;
    private $emp_taxaprazodebito;
    private $emp_taxaprazocreditoadm;
    private $emp_taxaprazodebitoadm;
    private $rhm_pessoaorgaoclasse;
    private $rhm_pessoaorgaoclasseuf;
    private $rhm_pessoanis;
    private $emp_socio;
    private $qld_affornecedoravalia;
    private $tms_motoristavlrcomissao;
    private $emp_pessoatipocusto;
    private $emp_pessoalayoutanfavea;
    
    
    
    
    
    private $tms_motoristadataprimcnh;
    private $emp_pessoalayoutasn;
    
    
    private $emp_associadotempocontribuicao;
    private $emp_associadoidaderesgate;
    private $emp_pessoatda;
    private $emp_pessoatdaraiz;
    private $emp_pessoatde;
    private $emp_pessoatderaiz;
    private $emp_pessoapesocubadopadrao;
    
    private $emp_pessoacartaddr;
    private $emp_pessoamictextocampotranspo;
    private $emp_pessoamictextocampoproprie;
    private $emp_pessaenviaxmlcteoriginal;
    private $emp_pessoaemitenf;
    private $emp_pessoanotaseparada;
    private $emp_pessoadataalteracao;
    private $emp_pessoadiasflout;
    
    private $emp_numerodiascredito;
    private $emp_pessoacrttexto;
    private $emp_pessoamotcomissionado;
    private $emp_pessoamotperfrete;
    private $emp_pessoamotprodutofrete;
    private $emp_pessoanumeropis;
    private $tms_motoristagerriscoid;
    private $emp_nomesocial;
    private $emp_pessoagernomecct;
    private $emp_pessoagernomeproduto;
    private $emp_pessoagermonitoramentologi;
    
    private $emp_senhaautoatendimento;
    private $rhf_pessoacartaosptrans;
    private $emp_cnpj;
    private $emp_cidadedescricao;
    
    private $emp_pessoarateiavaloresagenda;
    private $tms_motoristaprimeiradataadmis;
    private $rhf_pessoacartaointertrans;
    private $cmb_pessoaexigekm;
    private $cmb_pessoaexigefrota;
    private $cmb_pessoaexigerequisicao;
    private $cmb_pessoaexigirsenha;
    private $cmb_pessoaexigirplaca;
    private $cmb_pessoaexigirmotorista;
    private $cmb_pessoavalidaplaca;
    private $cmb_pessoavalidamotorista;
    private $cmb_pessoasenha;
    private $emp_pessoafilialpadrao;
    private $emp_pessoausuariopadrao;
    private $emp_pessoapermitepagprazo;
    private $emp_pessoapermitepagcheque;
    
    
    private $rhf_pessoavaletransporte;
    private $emp_pessoaterceiroautorizado;
    private $emp_pessoaterceirocpf;
    private $emp_pessoaterceiropessoanome;
    
    private $emp_pessoaemailanexocte;
    private $emp_pessoanroregestadual;
    private $emp_pessoataf;
    */
    private $emp_codigo;
    private $emp_razaosocial;
    
    //Informações Gerais
    private $emp_fantasia; 
    private $emp_exterior;
    private $emp_tipopessoa;
    private $emp_consumidorfinal;
    private $emp_optantesimplesfederal;
    private $emp_microempreendedor;
    private $emp_incentivadorcultural;
    private $emp_formatributacao;
    private $emp_datafundacao;
    private $emp_datanascimento;
    private $emp_situacao;
    private $emp_codigoantigo;
    private $emp_formapagamento;
    private $emp_almoxarifadocodigo;
    private $emp_grupoeconomicocodigo;
    private $emp_pessoapadraogrupoeconomico;
    private $emp_condpagtocodigo;
    private $emp_tipomovimentocodigo;
    private $emp_representante;
    private $emp_pessoatabelaprecocodigo;
    private $emp_pessoatabelafretekm;
    private $emp_siteempresa;   
    private $emp_descricaoatividade;
    private $emp_cobrancacodigo;
    private $emp_transportadoracodigo;
    private $emp_redespachocodigo;
    private $emp_clientedesconto;
    private $emp_descontoboleto;
    private $emp_percentualjuros;
    private $emp_percentualmulta;
    private $emp_diasatraso;
    private $emp_capitalsocial;
    private $emp_creditobloqueio;
    private $emp_cadastrodata; 
    private $emp_cadastrousuario;
    private $emp_grupocodigo;
    private $emp_cnae;
    private $emp_naturalidadepais;
    private $emp_cidadeestadocodigo; ///DUVIDAS
    private $emp_naturalidadecidade;
    private $emp_imprimereferenciaprodutoda;
    private $emp_naoenviatitulosserasapefin;
    ////////////////////////////////////////////FALTA CAMPO
    private $emp_credemissaonfe;
    private $emp_pessoadatadesejoparcela; ///Duvida
    private $emp_pessoadesconsiderarfluxoca;
    
    //Classificação
    private $emp_cliente;
    private $emp_fornecedor;
    private $rep_codigo;    /////Duvidas
    private $emp_transportador;
    private $emp_assistenciatecnica;
    private $emp_funcionario;
    private $emp_prospect;
    private $emp_produtor;
    private $emp_associado;
    private $emp_motorista;
    private $emp_negociador;
    private $emp_trading;
    private $emp_tecnico;
    private $emp_centrodistribuicao;
    private $emp_poderpublico;
    private $emp_suspect;
    private $cfe_cfefavorecidocodigo; //Dúvidas
    private $emp_operadoracartaocredito;
    private $emp_financeira;
    private $crm_contaclassificacaocodigo;
    private $emp_automato;///////////////////////////////
    
    //Operador
    private $emp_operadorcarregadeira;
    private $emp_operadorcolhedeira;
    private $emp_operadortrasnbordo;
    private $emp_operadorreboque;
    
    //Observações
    private $emp_observacoesgerais;
    private $emp_observacoescomerciais;
    private $emp_pessoabloqueiodata;
    private $emp_creditobloqueiojust;
    private $emp_observacoesfinanceiras;
    private $emp_observacoestms;
    
    //Informações de Fornecedor
    private $emp_fornecedoravaliacao;
    private $emp_fornecedorhomologacao;
    private $emp_fornecedorcontabil;
    private $emp_fornecedorpercentual;
    private $emp_fornecedornotaqualidade;
    private $emp_tipofretecodigo;   //////////Duvidas
    //FALTOU DOIS CAMPOS=Percentual Excedente de Quantidade/Percentual Excedente de Valor Unitário
    private $emp_fornecedorexigetabela;
    private $emp_pessoapadraoanfavea;
    private $emp_pessoacodigoacessocotonlin;
    
    function getEmp_codigo() {
        return $this->emp_codigo;
    }

    function getEmp_razaosocial() {
        return $this->emp_razaosocial;
    }

    function getEmp_fantasia() {
        return $this->emp_fantasia;
    }

    function getEmp_exterior() {
        return $this->emp_exterior;
    }

    function getEmp_tipopessoa() {
        return $this->emp_tipopessoa;
    }

    function getEmp_consumidorfinal() {
        return $this->emp_consumidorfinal;
    }

    function getEmp_optantesimplesfederal() {
        return $this->emp_optantesimplesfederal;
    }

    function getEmp_microempreendedor() {
        return $this->emp_microempreendedor;
    }

    function getEmp_incentivadorcultural() {
        return $this->emp_incentivadorcultural;
    }

    function getEmp_formatributacao() {
        return $this->emp_formatributacao;
    }

    function getEmp_datafundacao() {
        return $this->emp_datafundacao;
    }

    function getEmp_datanascimento() {
        return $this->emp_datanascimento;
    }

    function getEmp_situacao() {
        return $this->emp_situacao;
    }

    function getEmp_codigoantigo() {
        return $this->emp_codigoantigo;
    }

    function getEmp_formapagamento() {
        return $this->emp_formapagamento;
    }

    function getEmp_almoxarifadocodigo() {
        return $this->emp_almoxarifadocodigo;
    }

    function getEmp_grupoeconomicocodigo() {
        return $this->emp_grupoeconomicocodigo;
    }

    function getEmp_pessoapadraogrupoeconomico() {
        return $this->emp_pessoapadraogrupoeconomico;
    }

    function getEmp_condpagtocodigo() {
        return $this->emp_condpagtocodigo;
    }

    function getEmp_tipomovimentocodigo() {
        return $this->emp_tipomovimentocodigo;
    }

    function getEmp_representante() {
        return $this->emp_representante;
    }

    function getEmp_pessoatabelaprecocodigo() {
        return $this->emp_pessoatabelaprecocodigo;
    }

    function getEmp_pessoatabelafretekm() {
        return $this->emp_pessoatabelafretekm;
    }

    function getEmp_siteempresa() {
        return $this->emp_siteempresa;
    }

    function getEmp_descricaoatividade() {
        return $this->emp_descricaoatividade;
    }

    function getEmp_cobrancacodigo() {
        return $this->emp_cobrancacodigo;
    }

    function getEmp_transportadoracodigo() {
        return $this->emp_transportadoracodigo;
    }

    function getEmp_redespachocodigo() {
        return $this->emp_redespachocodigo;
    }

    function getEmp_clientedesconto() {
        return $this->emp_clientedesconto;
    }

    function getEmp_descontoboleto() {
        return $this->emp_descontoboleto;
    }

    function getEmp_percentualjuros() {
        return $this->emp_percentualjuros;
    }

    function getEmp_percentualmulta() {
        return $this->emp_percentualmulta;
    }

    function getEmp_diasatraso() {
        return $this->emp_diasatraso;
    }

    function getEmp_capitalsocial() {
        return $this->emp_capitalsocial;
    }

    function getEmp_creditobloqueio() {
        return $this->emp_creditobloqueio;
    }

    function getEmp_cadastrodata() {
        return $this->emp_cadastrodata;
    }

    function getEmp_cadastrousuario() {
        return $this->emp_cadastrousuario;
    }

    function getEmp_grupocodigo() {
        return $this->emp_grupocodigo;
    }

    function getEmp_cnae() {
        return $this->emp_cnae;
    }

    function getEmp_naturalidadepais() {
        return $this->emp_naturalidadepais;
    }

    function getEmp_cidadeestadocodigo() {
        return $this->emp_cidadeestadocodigo;
    }

    function getEmp_naturalidadecidade() {
        return $this->emp_naturalidadecidade;
    }

    function getEmp_imprimereferenciaprodutoda() {
        return $this->emp_imprimereferenciaprodutoda;
    }

    function getEmp_naoenviatitulosserasapefin() {
        return $this->emp_naoenviatitulosserasapefin;
    }

    function getEmp_credemissaonfe() {
        return $this->emp_credemissaonfe;
    }

    function getEmp_pessoadatadesejoparcela() {
        return $this->emp_pessoadatadesejoparcela;
    }

    function getEmp_pessoadesconsiderarfluxoca() {
        return $this->emp_pessoadesconsiderarfluxoca;
    }

    function setEmp_codigo($emp_codigo) {
        $this->emp_codigo = $emp_codigo;
    }

    function setEmp_razaosocial($emp_razaosocial) {
        $this->emp_razaosocial = $emp_razaosocial;
    }

    function setEmp_fantasia($emp_fantasia) {
        $this->emp_fantasia = $emp_fantasia;
    }

    function setEmp_exterior($emp_exterior) {
        $this->emp_exterior = $emp_exterior;
    }

    function setEmp_tipopessoa($emp_tipopessoa) {
        $this->emp_tipopessoa = $emp_tipopessoa;
    }

    function setEmp_consumidorfinal($emp_consumidorfinal) {
        $this->emp_consumidorfinal = $emp_consumidorfinal;
    }

    function setEmp_optantesimplesfederal($emp_optantesimplesfederal) {
        $this->emp_optantesimplesfederal = $emp_optantesimplesfederal;
    }

    function setEmp_microempreendedor($emp_microempreendedor) {
        $this->emp_microempreendedor = $emp_microempreendedor;
    }

    function setEmp_incentivadorcultural($emp_incentivadorcultural) {
        $this->emp_incentivadorcultural = $emp_incentivadorcultural;
    }

    function setEmp_formatributacao($emp_formatributacao) {
        $this->emp_formatributacao = $emp_formatributacao;
    }

    function setEmp_datafundacao($emp_datafundacao) {
        $this->emp_datafundacao = $emp_datafundacao;
    }

    function setEmp_datanascimento($emp_datanascimento) {
        $this->emp_datanascimento = $emp_datanascimento;
    }

    function setEmp_situacao($emp_situacao) {
        $this->emp_situacao = $emp_situacao;
    }

    function setEmp_codigoantigo($emp_codigoantigo) {
        $this->emp_codigoantigo = $emp_codigoantigo;
    }

    function setEmp_formapagamento($emp_formapagamento) {
        $this->emp_formapagamento = $emp_formapagamento;
    }

    function setEmp_almoxarifadocodigo($emp_almoxarifadocodigo) {
        $this->emp_almoxarifadocodigo = $emp_almoxarifadocodigo;
    }

    function setEmp_grupoeconomicocodigo($emp_grupoeconomicocodigo) {
        $this->emp_grupoeconomicocodigo = $emp_grupoeconomicocodigo;
    }

    function setEmp_pessoapadraogrupoeconomico($emp_pessoapadraogrupoeconomico) {
        $this->emp_pessoapadraogrupoeconomico = $emp_pessoapadraogrupoeconomico;
    }

    function setEmp_condpagtocodigo($emp_condpagtocodigo) {
        $this->emp_condpagtocodigo = $emp_condpagtocodigo;
    }

    function setEmp_tipomovimentocodigo($emp_tipomovimentocodigo) {
        $this->emp_tipomovimentocodigo = $emp_tipomovimentocodigo;
    }

    function setEmp_representante($emp_representante) {
        $this->emp_representante = $emp_representante;
    }

    function setEmp_pessoatabelaprecocodigo($emp_pessoatabelaprecocodigo) {
        $this->emp_pessoatabelaprecocodigo = $emp_pessoatabelaprecocodigo;
    }

    function setEmp_pessoatabelafretekm($emp_pessoatabelafretekm) {
        $this->emp_pessoatabelafretekm = $emp_pessoatabelafretekm;
    }

    function setEmp_siteempresa($emp_siteempresa) {
        $this->emp_siteempresa = $emp_siteempresa;
    }

    function setEmp_descricaoatividade($emp_descricaoatividade) {
        $this->emp_descricaoatividade = $emp_descricaoatividade;
    }

    function setEmp_cobrancacodigo($emp_cobrancacodigo) {
        $this->emp_cobrancacodigo = $emp_cobrancacodigo;
    }

    function setEmp_transportadoracodigo($emp_transportadoracodigo) {
        $this->emp_transportadoracodigo = $emp_transportadoracodigo;
    }

    function setEmp_redespachocodigo($emp_redespachocodigo) {
        $this->emp_redespachocodigo = $emp_redespachocodigo;
    }

    function setEmp_clientedesconto($emp_clientedesconto) {
        $this->emp_clientedesconto = $emp_clientedesconto;
    }

    function setEmp_descontoboleto($emp_descontoboleto) {
        $this->emp_descontoboleto = $emp_descontoboleto;
    }

    function setEmp_percentualjuros($emp_percentualjuros) {
        $this->emp_percentualjuros = $emp_percentualjuros;
    }

    function setEmp_percentualmulta($emp_percentualmulta) {
        $this->emp_percentualmulta = $emp_percentualmulta;
    }

    function setEmp_diasatraso($emp_diasatraso) {
        $this->emp_diasatraso = $emp_diasatraso;
    }

    function setEmp_capitalsocial($emp_capitalsocial) {
        $this->emp_capitalsocial = $emp_capitalsocial;
    }

    function setEmp_creditobloqueio($emp_creditobloqueio) {
        $this->emp_creditobloqueio = $emp_creditobloqueio;
    }

    function setEmp_cadastrodata($emp_cadastrodata) {
        $this->emp_cadastrodata = $emp_cadastrodata;
    }

    function setEmp_cadastrousuario($emp_cadastrousuario) {
        $this->emp_cadastrousuario = $emp_cadastrousuario;
    }

    function setEmp_grupocodigo($emp_grupocodigo) {
        $this->emp_grupocodigo = $emp_grupocodigo;
    }

    function setEmp_cnae($emp_cnae) {
        $this->emp_cnae = $emp_cnae;
    }

    function setEmp_naturalidadepais($emp_naturalidadepais) {
        $this->emp_naturalidadepais = $emp_naturalidadepais;
    }

    function setEmp_cidadeestadocodigo($emp_cidadeestadocodigo) {
        $this->emp_cidadeestadocodigo = $emp_cidadeestadocodigo;
    }

    function setEmp_naturalidadecidade($emp_naturalidadecidade) {
        $this->emp_naturalidadecidade = $emp_naturalidadecidade;
    }

    function setEmp_imprimereferenciaprodutoda($emp_imprimereferenciaprodutoda) {
        $this->emp_imprimereferenciaprodutoda = $emp_imprimereferenciaprodutoda;
    }

    function setEmp_naoenviatitulosserasapefin($emp_naoenviatitulosserasapefin) {
        $this->emp_naoenviatitulosserasapefin = $emp_naoenviatitulosserasapefin;
    }

    function setEmp_credemissaonfe($emp_credemissaonfe) {
        $this->emp_credemissaonfe = $emp_credemissaonfe;
    }

    function setEmp_pessoadatadesejoparcela($emp_pessoadatadesejoparcela) {
        $this->emp_pessoadatadesejoparcela = $emp_pessoadatadesejoparcela;
    }

    function setEmp_pessoadesconsiderarfluxoca($emp_pessoadesconsiderarfluxoca) {
        $this->emp_pessoadesconsiderarfluxoca = $emp_pessoadesconsiderarfluxoca;
    }

    function getEmp_cliente() {
        return $this->emp_cliente;
    }

    function getEmp_fornecedor() {
        return $this->emp_fornecedor;
    }

    function getRep_codigo() {
        return $this->rep_codigo;
    }

    function getEmp_transportador() {
        return $this->emp_transportador;
    }

    function getEmp_assistenciatecnica() {
        return $this->emp_assistenciatecnica;
    }

    function getEmp_funcionario() {
        return $this->emp_funcionario;
    }

    function getEmp_prospect() {
        return $this->emp_prospect;
    }

    function getEmp_produtor() {
        return $this->emp_produtor;
    }

    function getEmp_associado() {
        return $this->emp_associado;
    }

    function getEmp_motorista() {
        return $this->emp_motorista;
    }

    function getEmp_negociador() {
        return $this->emp_negociador;
    }

    function getEmp_trading() {
        return $this->emp_trading;
    }

    function getEmp_tecnico() {
        return $this->emp_tecnico;
    }

    function getEmp_centrodistribuicao() {
        return $this->emp_centrodistribuicao;
    }

    function getEmp_poderpublico() {
        return $this->emp_poderpublico;
    }

    function getEmp_suspect() {
        return $this->emp_suspect;
    }

    function getCfe_cfefavorecidocodigo() {
        return $this->cfe_cfefavorecidocodigo;
    }

    function getEmp_operadoracartaocredito() {
        return $this->emp_operadoracartaocredito;
    }

    function getEmp_financeira() {
        return $this->emp_financeira;
    }

    function getCrm_contaclassificacaocodigo() {
        return $this->crm_contaclassificacaocodigo;
    }

    function getEmp_automato() {
        return $this->emp_automato;
    }

    function setEmp_cliente($emp_cliente) {
        $this->emp_cliente = $emp_cliente;
    }

    function setEmp_fornecedor($emp_fornecedor) {
        $this->emp_fornecedor = $emp_fornecedor;
    }

    function setRep_codigo($rep_codigo) {
        $this->rep_codigo = $rep_codigo;
    }

    function setEmp_transportador($emp_transportador) {
        $this->emp_transportador = $emp_transportador;
    }

    function setEmp_assistenciatecnica($emp_assistenciatecnica) {
        $this->emp_assistenciatecnica = $emp_assistenciatecnica;
    }

    function setEmp_funcionario($emp_funcionario) {
        $this->emp_funcionario = $emp_funcionario;
    }

    function setEmp_prospect($emp_prospect) {
        $this->emp_prospect = $emp_prospect;
    }

    function setEmp_produtor($emp_produtor) {
        $this->emp_produtor = $emp_produtor;
    }

    function setEmp_associado($emp_associado) {
        $this->emp_associado = $emp_associado;
    }

    function setEmp_motorista($emp_motorista) {
        $this->emp_motorista = $emp_motorista;
    }

    function setEmp_negociador($emp_negociador) {
        $this->emp_negociador = $emp_negociador;
    }

    function setEmp_trading($emp_trading) {
        $this->emp_trading = $emp_trading;
    }

    function setEmp_tecnico($emp_tecnico) {
        $this->emp_tecnico = $emp_tecnico;
    }

    function setEmp_centrodistribuicao($emp_centrodistribuicao) {
        $this->emp_centrodistribuicao = $emp_centrodistribuicao;
    }

    function setEmp_poderpublico($emp_poderpublico) {
        $this->emp_poderpublico = $emp_poderpublico;
    }

    function setEmp_suspect($emp_suspect) {
        $this->emp_suspect = $emp_suspect;
    }

    function setCfe_cfefavorecidocodigo($cfe_cfefavorecidocodigo) {
        $this->cfe_cfefavorecidocodigo = $cfe_cfefavorecidocodigo;
    }

    function setEmp_operadoracartaocredito($emp_operadoracartaocredito) {
        $this->emp_operadoracartaocredito = $emp_operadoracartaocredito;
    }

    function setEmp_financeira($emp_financeira) {
        $this->emp_financeira = $emp_financeira;
    }

    function setCrm_contaclassificacaocodigo($crm_contaclassificacaocodigo) {
        $this->crm_contaclassificacaocodigo = $crm_contaclassificacaocodigo;
    }

    function setEmp_automato($emp_automato) {
        $this->emp_automato = $emp_automato;
    }
    
    function getEmp_operadorcarregadeira() {
        return $this->emp_operadorcarregadeira;
    }

    function getEmp_operadorcolhedeira() {
        return $this->emp_operadorcolhedeira;
    }

    function getEmp_operadortrasnbordo() {
        return $this->emp_operadortrasnbordo;
    }

    function getEmp_operadorreboque() {
        return $this->emp_operadorreboque;
    }

    function setEmp_operadorcarregadeira($emp_operadorcarregadeira) {
        $this->emp_operadorcarregadeira = $emp_operadorcarregadeira;
    }

    function setEmp_operadorcolhedeira($emp_operadorcolhedeira) {
        $this->emp_operadorcolhedeira = $emp_operadorcolhedeira;
    }

    function setEmp_operadortrasnbordo($emp_operadortrasnbordo) {
        $this->emp_operadortrasnbordo = $emp_operadortrasnbordo;
    }

    function setEmp_operadorreboque($emp_operadorreboque) {
        $this->emp_operadorreboque = $emp_operadorreboque;
    }
    
    function getEmp_observacoesgerais() {
        return $this->emp_observacoesgerais;
    }

    function getEmp_observacoescomerciais() {
        return $this->emp_observacoescomerciais;
    }

    function getEmp_pessoabloqueiodata() {
        return $this->emp_pessoabloqueiodata;
    }

    function getEmp_creditobloqueiojust() {
        return $this->emp_creditobloqueiojust;
    }

    function getEmp_observacoesfinanceiras() {
        return $this->emp_observacoesfinanceiras;
    }

    function getEmp_observacoestms() {
        return $this->emp_observacoestms;
    }

    function setEmp_observacoesgerais($emp_observacoesgerais) {
        $this->emp_observacoesgerais = $emp_observacoesgerais;
    }

    function setEmp_observacoescomerciais($emp_observacoescomerciais) {
        $this->emp_observacoescomerciais = $emp_observacoescomerciais;
    }

    function setEmp_pessoabloqueiodata($emp_pessoabloqueiodata) {
        $this->emp_pessoabloqueiodata = $emp_pessoabloqueiodata;
    }

    function setEmp_creditobloqueiojust($emp_creditobloqueiojust) {
        $this->emp_creditobloqueiojust = $emp_creditobloqueiojust;
    }

    function setEmp_observacoesfinanceiras($emp_observacoesfinanceiras) {
        $this->emp_observacoesfinanceiras = $emp_observacoesfinanceiras;
    }

    function setEmp_observacoestms($emp_observacoestms) {
        $this->emp_observacoestms = $emp_observacoestms;
    }
    
    function getEmp_fornecedoravaliacao() {
        return $this->emp_fornecedoravaliacao;
    }

    function getEmp_fornecedorhomologacao() {
        return $this->emp_fornecedorhomologacao;
    }

    function getEmp_fornecedorcontabil() {
        return $this->emp_fornecedorcontabil;
    }

    function getEmp_fornecedorpercentual() {
        return $this->emp_fornecedorpercentual;
    }

    function getEmp_fornecedornotaqualidade() {
        return $this->emp_fornecedornotaqualidade;
    }

    function getEmp_tipofretecodigo() {
        return $this->emp_tipofretecodigo;
    }

    function getEmp_fornecedorexigetabela() {
        return $this->emp_fornecedorexigetabela;
    }

    function getEmp_pessoapadraoanfavea() {
        return $this->emp_pessoapadraoanfavea;
    }

    function getEmp_pessoacodigoacessocotonlin() {
        return $this->emp_pessoacodigoacessocotonlin;
    }

    function setEmp_fornecedoravaliacao($emp_fornecedoravaliacao) {
        $this->emp_fornecedoravaliacao = $emp_fornecedoravaliacao;
    }

    function setEmp_fornecedorhomologacao($emp_fornecedorhomologacao) {
        $this->emp_fornecedorhomologacao = $emp_fornecedorhomologacao;
    }

    function setEmp_fornecedorcontabil($emp_fornecedorcontabil) {
        $this->emp_fornecedorcontabil = $emp_fornecedorcontabil;
    }

    function setEmp_fornecedorpercentual($emp_fornecedorpercentual) {
        $this->emp_fornecedorpercentual = $emp_fornecedorpercentual;
    }

    function setEmp_fornecedornotaqualidade($emp_fornecedornotaqualidade) {
        $this->emp_fornecedornotaqualidade = $emp_fornecedornotaqualidade;
    }

    function setEmp_tipofretecodigo($emp_tipofretecodigo) {
        $this->emp_tipofretecodigo = $emp_tipofretecodigo;
    }

    function setEmp_fornecedorexigetabela($emp_fornecedorexigetabela) {
        $this->emp_fornecedorexigetabela = $emp_fornecedorexigetabela;
    }

    function setEmp_pessoapadraoanfavea($emp_pessoapadraoanfavea) {
        $this->emp_pessoapadraoanfavea = $emp_pessoapadraoanfavea;
    }

    function setEmp_pessoacodigoacessocotonlin($emp_pessoacodigoacessocotonlin) {
        $this->emp_pessoacodigoacessocotonlin = $emp_pessoacodigoacessocotonlin;
    }
    
}
