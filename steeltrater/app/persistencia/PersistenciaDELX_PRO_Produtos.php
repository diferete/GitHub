<?php

/*
 * Classe que implementa a persistencia de pessoas
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class PersistenciaDELX_PRO_Produtos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRODUTO');

        $this->adicionaRelacionamento('pro_cadastrousuario', 'pro_cadastrousuario');
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo', true, true);
        $this->adicionaRelacionamento('pro_descricao', 'pro_descricao');
        $this->adicionaRelacionamento('pro_pesoliquido', 'pro_pesoliquido');
        $this->adicionaRelacionamento('pro_tipocontrole', 'pro_tipocontrole');
        $this->adicionaRelacionamento('pro_tipocusto', 'pro_tipocusto');
        $this->adicionaRelacionamento('pro_pesobruto', 'pro_pesobruto');
        $this->adicionaRelacionamento('pro_volume', 'pro_volume');

        $this->adicionaRelacionamento('pro_grupocodigo', 'pro_grupocodigo');
        $this->adicionaRelacionamento('pro_grupocodigo', 'DELX_PRO_Grupo.pro_grupocodigo', false, false);

        $this->adicionaRelacionamento('pro_subgrupocodigo', 'pro_subgrupocodigo');
        $this->adicionaRelacionamento('pro_subgrupocodigo', 'DELX_PRO_Subgrupo.pro_subgrupocodigo', false, false);

        $this->adicionaRelacionamento('pro_familiacodigo', 'pro_familiacodigo');
        $this->adicionaRelacionamento('pro_familiacodigo', 'DELX_PRO_Familia.pro_familiacodigo', false, false);

        $this->adicionaRelacionamento('pro_subfamiliacodigo', 'pro_subfamiliacodigo');
        $this->adicionaRelacionamento('pro_subfamiliacodigo', 'DELX_PRO_Subfamilia.pro_subfamiliacodigo', false, false);

        $this->adicionaRelacionamento('pro_unidademedida', 'pro_unidademedida');
        $this->adicionaRelacionamento('pro_unidademedida', 'DELX_PRO_UnidadeMedida.pro_unidademedida', false, false);

        $this->adicionaRelacionamento('pro_volumepc', 'pro_volumepc');
        $this->adicionaRelacionamento('pro_codigoantigo', 'pro_codigoantigo');
        $this->adicionaRelacionamento('pro_descricaotecnica', 'pro_descricaotecnica');
        $this->adicionaRelacionamento('pro_referencia', 'pro_referencia');
        $this->adicionaRelacionamento('pro_diasvalidade', 'pro_diasvalidade');
        $this->adicionaRelacionamento('pro_tipovalidade', 'pro_tipovalidade');
        $this->adicionaRelacionamento('pro_produtotipoproducao', 'pro_produtotipoproducao');
        $this->adicionaRelacionamento('pro_produtotipocalculo', 'pro_produtotipocalculo');
        $this->adicionaRelacionamento('pro_produtotipovalidacodigobar', 'pro_produtotipovalidacodigobar');
        $this->adicionaRelacionamento('pro_generico', 'pro_generico');
        $this->adicionaRelacionamento('pro_lote', 'pro_lote');
        $this->adicionaRelacionamento('pro_compostovalor', 'pro_compostovalor');
        $this->adicionaRelacionamento('pro_embalagemretornavel', 'pro_embalagemretornavel');
        $this->adicionaRelacionamento('pro_grade', 'pro_grade');
        $this->adicionaRelacionamento('pro_coproduto', 'pro_coproduto');
        $this->adicionaRelacionamento('pro_produtocontrolado', 'pro_produtocontrolado');
        $this->adicionaRelacionamento('pro_fantasma', 'pro_fantasma');
        $this->adicionaRelacionamento('pro_produtoobsoleto', 'pro_produtoobsoleto');
        $this->adicionaRelacionamento('pro_produtofcirevenda', 'pro_produtofcirevenda');
        $this->adicionaRelacionamento('pro_letra', 'pro_letra');
        $this->adicionaRelacionamento('pro_importadoestrutura', 'pro_importadoestrutura');
        $this->adicionaRelacionamento('pro_produtocontrolaserie', 'pro_produtocontrolaserie');
        $this->adicionaRelacionamento('pro_produtofastcommerce', 'pro_produtofastcommerce');
        $this->adicionaRelacionamento('pro_receituario', 'pro_receituario');
        $this->adicionaRelacionamento('pro_produtodrawback', 'pro_produtodrawback');
        $this->adicionaRelacionamento('pro_dimensoes', 'pro_dimensoes');
        $this->adicionaRelacionamento('pro_dimensoesconversor', 'pro_dimensoesconversor');
        $this->adicionaRelacionamento('pro_dimensoesundconversor', 'pro_dimensoesundconversor');
        $this->adicionaRelacionamento('pro_comprimentobruto', 'pro_comprimentobruto');
        $this->adicionaRelacionamento('pro_largurabruto', 'pro_largurabruto');
        $this->adicionaRelacionamento('pro_espessurabruto', 'pro_espessurabruto');
        $this->adicionaRelacionamento('pro_comprimentoliquido', 'pro_comprimentoliquido');
        $this->adicionaRelacionamento('pro_larguraliquido', 'pro_larguraliquido');
        $this->adicionaRelacionamento('pro_espessuraliquido', 'pro_espessuraliquido');
        $this->adicionaRelacionamento('pro_produtomedidacomprimento', 'pro_produtomedidacomprimento');
        $this->adicionaRelacionamento('pro_volumem3', 'pro_volumem3');
        $this->adicionaRelacionamento('pro_dimensoesgradeformula', 'pro_dimensoesgradeformula');
        $this->adicionaRelacionamento('pro_produtopativo', 'pro_produtopativo');
        $this->adicionaRelacionamento('pro_produtovinculadocodigo', 'pro_produtovinculadocodigo');
        $this->adicionaRelacionamento('pro_dimensoesunidade', 'pro_dimensoesunidade');
        $this->adicionaRelacionamento('pro_origem', 'pro_origem');
        $this->adicionaRelacionamento('pro_ncm', 'pro_ncm');
        $this->adicionaRelacionamento('fis_cnaecodigo', 'fis_cnaecodigo');
        $this->adicionaRelacionamento('fis_lc11603principalcodigo', 'fis_lc11603principalcodigo');
        $this->adicionaRelacionamento('fis_lc11603secundariocodigo', 'fis_lc11603secundariocodigo');
        $this->adicionaRelacionamento('fis_generoitemcodigo', 'fis_generoitemcodigo');
        $this->adicionaRelacionamento('pro_tipoligacao', 'pro_tipoligacao');
        $this->adicionaRelacionamento('pro_grupotensao', 'pro_grupotensao');
        $this->adicionaRelacionamento('pro_unidadecodigo', 'pro_unidadecodigo');
        $this->adicionaRelacionamento('pro_destacanfse', 'pro_destacanfse');
        $this->adicionaRelacionamento('pro_produtocest', 'pro_produtocest');
        $this->adicionaRelacionamento('pro_perigosoonu', 'pro_perigosoonu');
        $this->adicionaRelacionamento('pro_perigosonome', 'pro_perigosonome');
        $this->adicionaRelacionamento('pro_perigosoclasse', 'pro_perigosoclasse');
        $this->adicionaRelacionamento('pro_perigosoembalagem', 'pro_perigosoembalagem');
        $this->adicionaRelacionamento('pro_perigosopontofulgor', 'pro_perigosopontofulgor');
        $this->adicionaRelacionamento('pro_descricaoestrutura', 'pro_descricaoestrutura');
        $this->adicionaRelacionamento('pro_perigosonumerorisco', 'pro_perigosonumerorisco');
        $this->adicionaRelacionamento('pro_produtoperigosoqtdminima', 'pro_produtoperigosoqtdminima');
        $this->adicionaRelacionamento('matriz', 'matriz', false, false);
        $this->adicionaRelacionamento('steeltrater', 'steeltrater', false, false);
        $this->adicionaRelacionamento('fecula', 'fecula', false, false);
        $this->adicionaRelacionamento('fecial', 'fecial', false, false);
        $this->adicionaRelacionamento('hedler', 'hedler', false, false);

        $this->setSTop('30');
        $this->adicionaOrderBy('pro_codigo', 1);

        $this->adicionaJoin('DELX_PRO_UnidadeMedida');

        $this->adicionaJoin('DELX_PRO_Grupo');
        $sAndSub = ' and "DELX_PRO_Grupo".pro_grupocodigo = "DELX_PRO_Subgrupo".PRO_GrupoCodigo ';

        $this->adicionaJoin('DELX_PRO_Subgrupo', null, 1, 'pro_subgrupocodigo', 'pro_subgrupocodigo', $sAndSub);
        //////////////////////////////////////////////////////////////////////////////////////////
        $sAndFam = ' and PRO_PRODUTO.PRO_GrupoCodigo = "DELX_PRO_Familia".PRO_GrupoCodigo '
                . ' and PRO_PRODUTO.PRO_SubGrupoCodigo = "DELX_PRO_Familia".PRO_SubGrupoCodigo ';

        $this->adicionaJoin('DELX_PRO_Familia', null, 1, 'pro_familiacodigo', 'pro_familiacodigo', $sAndFam);
        /////////////////////////////////////////////////////////////////////////////////////////////////
        /* $sAndSubFam =' and PRO_PRODUTO.PRO_GrupoCodigo = "DELX_PRO_Subfamilia".PRO_GrupoCodigo '
          .' and PRO_PRODUTO.PRO_SubGrupoCodigo = "DELX_PRO_Subfamilia".PRO_SubGrupoCodigo '
          . 'and PRO_PRODUTO.PRO_Familiacodigo = "DELX_PRO_Subfamilia".PRO_FamiliaCodigo';
         * 
         * 
         */
        $sAndSubFam = ' and PRO_PRODUTO.PRO_SubGrupoCodigo = "DELX_PRO_Subfamilia".PRO_SubGrupoCodigo '
                . 'and PRO_PRODUTO.PRO_FamiliaCodigo = "DELX_PRO_Subfamilia".PRO_FamiliaCodigo '
                . 'and PRO_PRODUTO.PRO_SubFamiliaCodigo = "DELX_PRO_Subfamilia".PRO_SubFamiliaCodigo';
        $this->adicionaJoin('DELX_PRO_Subfamilia', null, 1, 'pro_grupocodigo', 'pro_grupocodigo', $sAndSubFam);
    }

    public function insereProdFilial($sProCod,$aCNPJ) {
        
    }

}
