<?php

/*
 * Implementa a classe controler STEEL_PCP_Produtos
 * 
 * @author Cleverton Hoffmann
 * @since 01/02/2019
 */

class ControllerSTEEL_PCP_Produtos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Produtos');
    }

    public function retornaPeso($sProduto) {
        $this->Persistencia->adicionaFiltro('pro_codigo', $sProduto);
        $oProduto = $this->Persistencia->consultarWhere();
        return $oProduto->getPro_pesoliquido();
    }

    public function afterInsert() {
        parent::afterInsert();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aValorCampo = array();

        if (isset($aCampos['matriz'])) {
            array_push($aValorCampo, '75483040000130');
        }
        if (isset($aCampos['fecial'])) {
            array_push($aValorCampo, '5572480000189');
        }
        if (isset($aCampos['fecula'])) {
            array_push($aValorCampo, '10540966000175');
        }
        if (isset($aCampos['hedler'])) {
            array_push($aValorCampo, '83781641000158');
        }
        if (isset($aCampos['steeltrater'])) {
            array_push($aValorCampo, '8993358000174');
        }

        $this->Persistencia->insereProdFilial($aCampos['pro_codigo'], $aValorCampo);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $this->Model->setPro_cadastrodatahora(date('d/m/Y h:m:s'));
        $this->preencheModelcomDados();
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
        
    }
    
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $this->Model->setPro_alteracaodatahora(date('d/m/Y h:m:s'));
        $this->Model->setPro_alteracaousuario($_SESSION['nomedelsoft']);
        $this->preencheModelcomDados();
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
        
    }  
    
    
    public function preencheModelcomDados(){
                
        $this->Model->setPro_mva(0);
        $this->Model->setPro_composto('N');
        $this->Model->setPro_diasvalidade(0);
        $this->Model->setPro_volume(0);
        $this->Model->setPro_comprimentoliquido(0);
        $this->Model->setPro_larguraliquido(0);
        $this->Model->setPro_espessuraliquido(0);
        $this->Model->setPro_comprimentobruto(0);
        $this->Model->setPro_largurabruto(0);
        $this->Model->setPro_espessurabruto(0);
        $this->Model->setPro_dimensoes('N');
        $this->Model->setPro_dimensoesconversor(0);
        $this->Model->setPro_receituario('N');
        $this->Model->setPro_lote('N');
        $this->Model->setPro_embalagemretornavel('N');
        $this->Model->setPro_dimensoesundconversor(0);
        $this->Model->setPro_generico('N');
        $this->Model->setPro_grade('N');
        $this->Model->setPro_sequencia(119.336);
        $this->Model->setPro_imagemfiletype(' ');
        $this->Model->setPro_imagemfilename(' ');
        $this->Model->setFis_generoitemcodigo('73');
        $this->Model->setPro_perigosoonu(' ');
        $this->Model->setPro_perigosonome(' ');
        $this->Model->setPro_perigosoclasse(' ');
        $this->Model->setPro_perigosoembalagem(' ');
        $this->Model->setPro_perigosopontofulgor(' ');
        $this->Model->setPro_compostovalor('N');
        $this->Model->setPro_inventariosequencia(0);
        $this->Model->setPro_produtotipoproducao('T');
        $this->Model->setPro_produtotipocalculo('T');
        $this->Model->setPro_transgenico(' ');
        $this->Model->setPro_tipocusto('M');
        $this->Model->setPro_produtotipovalidacodigobar('S');
        $this->Model->setFis_simpscancgrupocodigo(0);
        $this->Model->setFis_simpscancprodutocodigo(0);
        $this->Model->setPro_simpscancinpminicial(0);
        $this->Model->setPro_simpscanccalculoimposto('N');
        $this->Model->setPro_classeconsumo(2);
        $this->Model->setPro_tipoassinante(6);
        $this->Model->setPro_tipoutilizacao(6);
        $this->Model->setPro_classificacaoitem(' ');
        $this->Model->setPro_descricaoestrutura(' ');
        $this->Model->setPro_coproduto('N');
        $this->Model->setPro_dimensoesgradeformula(' ');
        $this->Model->setPro_tipovalidade('D');
        $this->Model->setPro_garantiatempo(0);
        $this->Model->setPro_garantiatempotipo('M');
        $this->Model->setPro_garantiatipo('S');
        $this->Model->setPro_produtocontrolado('N');
        $this->Model->setFis_agrupamentocodigo(0);
        $this->Model->setPro_tipoproduto(0);
        $this->Model->setPro_tipovolume(0);
        $this->Model->setPro_lotesequencial(0);
        $this->Model->setQld_produtofrequenciainspecao('N');
        $this->Model->setQld_produtoregimecodigo(0);
        $this->Model->setQld_produtonivelcodigo(0);
        $this->Model->setQld_produtoskiplotecodigo(0);
        $this->Model->setQld_produtoexamecodigo(0);
        $this->Model->setQld_produtonaoatualizaautoregi('N');
        $this->Model->setPro_produtoobsoleto('N');
        $this->Model->setPro_mascaralote(' ');
        $this->Model->setPro_importadoestrutura('N');
        $this->Model->setPro_tipocalculodecimal(' ');
        $this->Model->setPro_casasdecimais(0);
        $this->Model->setPro_produtobovinos('N');
        $this->Model->setPro_produtovacina('N');
        $this->Model->setPro_produtovacinacodigo(' ');
        $this->Model->setPro_volumem3(0);
        $this->Model->setGrs_agrotoxicoclassetoxicologi(' ');
        $this->Model->setGrs_agrotoxicoregistrominister(0);
        $this->Model->setGrs_agrotoxicograurisco(0);
        $this->Model->setGrs_classeriscocodigo(' ');
        $this->Model->setGrs_agrotoxicoprincipioativo(' ');
        $this->Model->setGrs_agrotoxicotriplicelavagem('N');
        $this->Model->setGrs_agrotoxicoindea(' ');
        $this->Model->setGrs_agrotoxicofabricante(' ');
        $this->Model->setGrs_agrotoxicoenderecofabrican(' ');
        $this->Model->setGrs_agrotoxicotelefoneemergenc(' ');
        $this->Model->setGrs_agrotoxiconumerososcotec(' ');
        $this->Model->setGrs_agrotoxicobulaarquivonome(' ');
        $this->Model->setGrs_agrotoxicobulaarquivotipo(' ');
        $this->Model->setPro_produtoprioridadecomposto(0);
        $this->Model->setPro_produtocontrolaserie('N');
        $this->Model->setPro_produtofastcommerce('N');
        $this->Model->setPro_produtomedidacomprimento('M');
        $this->Model->setGrs_agrotoxicocarencia(' ');
        $this->Model->setPro_fantasma('N');
        $this->Model->setPro_destacanfse('N');
        $this->Model->setCmb_produtoreducaost('N');
        $this->Model->setDii_produtobeneficio('N');
        $this->Model->setPro_produtodescnfe(' ');
        $this->Model->setPro_perigosonumerorisco(' ');
        $this->Model->setPro_mascaraqualidade(' ');
        $this->Model->setPro_tipocoluna(0);
        $this->Model->setPro_produtofcirevenda('N');
        $this->Model->setFis_produtocompra(' ');
        $this->Model->setPro_produtodrawback(' ');
        $this->Model->setTms_produtopredominante(' ');
    }
    
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        
        // $this->Persistencia->adicionaFiltro('pro_grupocodigo','100');
         $this->Persistencia->adicionaFiltro('pro_grupocodigo', '100', Persistencia::LIGACAO_AND, Persistencia::ENTRE,'101');
    }
}
