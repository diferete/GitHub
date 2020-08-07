<?php

/* 
 * Classe que implementa a persistencia de pessoas
 * 
 * @author Avanei Martendal e Cleverton Hoffmann
 * @since 11/06/2018 - Alteração 25/09/2018
 */

class PersistenciaDELX_CAD_Pessoa extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('EMP_PESSOA');
        
        $this->adicionaRelacionamento('emp_codigo','emp_codigo',true,true);
        $this->adicionaRelacionamento('emp_razaosocial','emp_razaosocial');
        
        $this->adicionaRelacionamento('emp_cnpj','emp_cnpj');
        
        //Informações Gerais
        $this->adicionaRelacionamento('emp_fantasia', 'emp_fantasia');        
        $this->adicionaRelacionamento('emp_exterior','emp_exterior');
        $this->adicionaRelacionamento('emp_tipopessoa','emp_tipopessoa');
        $this->adicionaRelacionamento('emp_consumidorfinal','emp_consumidorfinal');
        $this->adicionaRelacionamento('emp_optantesimplesfederal','emp_optantesimplesfederal');
        $this->adicionaRelacionamento('emp_microempreendedor','emp_microempreendedor');
        $this->adicionaRelacionamento('emp_incentivadorcultural','emp_incentivadorcultural');
        $this->adicionaRelacionamento('emp_formatributacao','emp_formatributacao');
        $this->adicionaRelacionamento('emp_datafundacao','emp_datafundacao');
        $this->adicionaRelacionamento('emp_datanascimento','emp_datanascimento');
        $this->adicionaRelacionamento('emp_situacao','emp_situacao');
        $this->adicionaRelacionamento('emp_codigoantigo','emp_codigoantigo');
        $this->adicionaRelacionamento('emp_formapagamento','emp_formapagamento');
        $this->adicionaRelacionamento('emp_almoxarifadocodigo','emp_almoxarifadocodigo');
        $this->adicionaRelacionamento('emp_grupoeconomicocodigo','emp_grupoeconomicocodigo');
        $this->adicionaRelacionamento('emp_pessoapadraogrupoeconomico','emp_pessoapadraogrupoeconomico');
        $this->adicionaRelacionamento('emp_condpagtocodigo','emp_condpagtocodigo');
        $this->adicionaRelacionamento('emp_tipomovimentocodigo','emp_tipomovimentocodigo');
        $this->adicionaRelacionamento('rep_codigo','rep_codigo');
        $this->adicionaRelacionamento('emp_pessoatabelaprecocodigo','emp_pessoatabelaprecocodigo');
        $this->adicionaRelacionamento('emp_pessoatabelafretekm','emp_pessoatabelafretekm');
        $this->adicionaRelacionamento('emp_siteempresa','emp_siteempresa');   
        $this->adicionaRelacionamento('emp_descricaoatividade','emp_descricaoatividade');
        $this->adicionaRelacionamento('emp_cobrancacodigo','emp_cobrancacodigo');
        $this->adicionaRelacionamento('emp_transportadoracodigo','emp_transportadoracodigo');
        $this->adicionaRelacionamento('emp_redespachocodigo','emp_redespachocodigo');
        $this->adicionaRelacionamento('emp_clientedesconto','emp_clientedesconto');
        $this->adicionaRelacionamento('emp_descontoboleto','emp_descontoboleto');
        $this->adicionaRelacionamento('emp_percentualjuros','emp_percentualjuros');
        $this->adicionaRelacionamento('emp_percentualmulta','emp_percentualmulta');///
        $this->adicionaRelacionamento('emp_diasatraso','emp_diasatraso');
        $this->adicionaRelacionamento('emp_capitalsocial','emp_capitalsocial');
        $this->adicionaRelacionamento('emp_creditobloqueio','emp_creditobloqueio');
        $this->adicionaRelacionamento('emp_cadastrodata','emp_cadastrodata'); 
        $this->adicionaRelacionamento('emp_cadastrousuario','emp_cadastrousuario');
        $this->adicionaRelacionamento('emp_grupocodigo','emp_grupocodigo');
        $this->adicionaRelacionamento('emp_cnae','emp_cnae');
        $this->adicionaRelacionamento('emp_naturalidadepais','emp_naturalidadepais');
        $this->adicionaRelacionamento('emp_cidadeestadocodigo','emp_cidadeestadocodigo'); ///DUVIDAS
        $this->adicionaRelacionamento('emp_naturalidadecidade','emp_naturalidadecidade');
        $this->adicionaRelacionamento('emp_imprimereferenciaprodutoda','emp_imprimereferenciaprodutoda');
        $this->adicionaRelacionamento('emp_naoenviatitulosserasapefin','emp_naoenviatitulosserasapefin');
        ////////////////////////////////////////////FALTA CAMPO
        $this->adicionaRelacionamento('emp_credemissaonfe','emp_credemissaonfe');
        $this->adicionaRelacionamento('emp_pessoadatadesejoparcela','emp_pessoadatadesejoparcela'); ///Duvida
        $this->adicionaRelacionamento('emp_pessoadesconsiderarfluxoca','emp_pessoadesconsiderarfluxoca');
        
        //Classificação
        $this->adicionaRelacionamento('emp_cliente','emp_cliente');
        $this->adicionaRelacionamento('emp_fornecedor','emp_fornecedor');
        $this->adicionaRelacionamento('emp_representante','emp_representante');
        $this->adicionaRelacionamento('emp_transportador','emp_transportador');
        $this->adicionaRelacionamento('emp_assistenciatecnica','emp_assistenciatecnica');
        $this->adicionaRelacionamento('emp_funcionario','emp_funcionario');
        $this->adicionaRelacionamento('emp_prospect','emp_prospect');
        $this->adicionaRelacionamento('emp_produtor','emp_produtor');
        $this->adicionaRelacionamento('emp_associado','emp_associado');
        $this->adicionaRelacionamento('emp_motorista','emp_motorista');
        $this->adicionaRelacionamento('emp_negociador','emp_negociador');
        $this->adicionaRelacionamento('emp_trading','emp_trading');
        $this->adicionaRelacionamento('emp_tecnico','emp_tecnico');
        $this->adicionaRelacionamento('emp_centrodistribuicao','emp_centrodistribuicao');
        $this->adicionaRelacionamento('emp_poderpublico','emp_poderpublico');
        $this->adicionaRelacionamento('emp_suspect','emp_suspect');
        $this->adicionaRelacionamento('emp_favorecido','emp_favorecido');
        $this->adicionaRelacionamento('emp_operadoracartaocredito','emp_operadoracartaocredito');
        $this->adicionaRelacionamento('emp_financeira','emp_financeira');
        $this->adicionaRelacionamento('crm_contaclassificacaocodigo','crm_contaclassificacaocodigo');
        $this->adicionaRelacionamento('emp_autonomo','emp_autonomo'); ///ARUMAR
           
        //Operador
        $this->adicionaRelacionamento('emp_operadorcarregadeira','emp_operadorcarregadeira');
        $this->adicionaRelacionamento('emp_operadorcolhedeira','emp_operadorcolhedeira');
        $this->adicionaRelacionamento('emp_operadortransbordo','emp_operadortransbordo'); 
        $this->adicionaRelacionamento('emp_operadorreboque','emp_operadorreboque');
       
        //Observações
        $this->adicionaRelacionamento('emp_observacoesgerais','emp_observacoesgerais');
        $this->adicionaRelacionamento('emp_observacoescomerciais','emp_observacoescomerciais');
        $this->adicionaRelacionamento('emp_pessoabloqueiodata','emp_pessoabloqueiodata');
        $this->adicionaRelacionamento('emp_creditobloqueiojust','emp_creditobloqueiojust');
        $this->adicionaRelacionamento('emp_observacoesfinanceiras','emp_observacoesfinanceiras');
        $this->adicionaRelacionamento('emp_observacoestms','emp_observacoestms');
        
        //Informações de Fornecedor
        $this->adicionaRelacionamento('emp_fornecedoravaliacao','emp_fornecedoravaliacao');
        $this->adicionaRelacionamento('emp_fornecedorhomologacao','emp_fornecedorhomologacao');
        $this->adicionaRelacionamento('emp_fornecedorcontabil','emp_fornecedorcontabil');
        $this->adicionaRelacionamento('emp_fornecedorpercentual','emp_fornecedorpercentual');
        $this->adicionaRelacionamento('emp_fornecedornotaqualidade','emp_fornecedornotaqualidade');
        $this->adicionaRelacionamento('emp_tipofretecodigo','emp_tipofretecodigo');
        $this->adicionaRelacionamento('emp_comprapercdifqtd','emp_comprapercdifqtd');
        $this->adicionaRelacionamento('emp_comprapercdifvalor','emp_comprapercdifvalor');
        $this->adicionaRelacionamento('emp_fornecedorexigetabela','emp_fornecedorexigetabela');
        $this->adicionaRelacionamento('emp_pessoapadraoanfavea','emp_pessoapadraoanfavea');
        $this->adicionaRelacionamento('emp_pessoacodigoacessocotonlin','emp_pessoacodigoacessocotonlin');
       
        
        $this->setSTop('100');
        $this->adicionaOrderBy('emp_codigo', 1);
        
    }
}

