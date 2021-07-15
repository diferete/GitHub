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
        //Vamos fazer o insert dos itens na filial

        $this->insertProdutoFilial();



        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->verificaCampoGrupo();
        $this->verificaCampoSubGrupo();
        $this->verificaCampoFamilia();
        $this->verificaCampoSubFamilia();
        $this->Model->setPro_cadastrodatahora(date('d/m/Y H:i:s'));
        //seta código caso não foi setado pelo usuário
        if ($this->Model->getPro_codigo() == null || $this->Model->getPro_codigo() == '') {
            $oProdSeq = Fabrica::FabricarController('STEEL_PCP_Produtos');
            $sSeq = $oProdSeq->Persistencia->geraSequencia();
            $this->Model->setPro_codigo($sSeq);
        }
        //analisa se o código já tem 
        $this->Persistencia->adicionaFiltro('pro_codigo', $this->Model->getPro_codigo());
        $iCont = $this->Persistencia->getCount();
        if ($iCont > 0) {
            $this->Persistencia->rollback();
            $oModal = new Modal('Atenção', 'Código já cadastrado!', Modal::TIPO_AVISO, false, true, false);
            echo $oModal->getRender();
            exit();
        }


        if ($this->Model->getPro_referencia() !== '' && $this->Model->getPro_codigoantigo() !== '') {
            $oOprodutoRef = Fabrica::FabricarController('STEEL_PCP_Produtos');
            $oOprodutoRef->Persistencia->adicionaFiltro('pro_referencia', $this->Model->getPro_referencia());
            $oOprodutoRef->Persistencia->adicionaFiltro('pro_codigoantigo', $this->Model->getPro_codigoantigo());
            $iCountRef = $oOprodutoRef->Persistencia->getCount();
            if ($iCountRef > 0) {
                $oModal = new Modal('Atenção!', 'Já existe uma referência cadastrada para esse Cliente, necessário alterar a referência!', Modal::TIPO_AVISO, false, true, true);
                echo $oModal->getRender();
                exit();
            }
        }




        $this->preencheModelcomDados();
        $this->validacaoProdutos();


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setPro_alteracaodatahora(date('d/m/Y H:i:s'));
        $this->Model->setPro_alteracaousuario($_SESSION['nomedelsoft']);
        $this->preencheModelcomDados();
        $this->validacaoProdutos();
        $this->verificaCampoGrupo();
        $this->verificaCampoSubGrupo();
        $this->verificaCampoFamilia();
        $this->verificaCampoSubFamilia();

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function preencheModelcomDados() {

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
        //$this->Model->setPro_imagem(' ');
    }

    public function validacaoProdutos() {
        if ($this->Model->getPro_ncm() == null || $this->Model->getPro_ncm() == '') {
            $oModal = new Modal('Atencão', 'Obrigatório informar o NCM do produto.', Modal::TIPO_AVISO, false, true, false);
            echo $oModal->getRender();
            exit();
        }

        //verifica se não há mais de uma referencia
        if ($this->Model->getPro_referencia() !== '' && $this->Model->getPro_codigoantigo() !== '') {
            $oOprodutoRef = Fabrica::FabricarController('STEEL_PCP_Produtos');
            $oOprodutoRef->Persistencia->adicionaFiltro('pro_referencia', $this->Model->getPro_referencia());
            $oOprodutoRef->Persistencia->adicionaFiltro('pro_codigoantigo', $this->Model->getPro_codigoantigo());
            $iCountRef = $oOprodutoRef->Persistencia->getCount();
            if ($iCountRef > 1) {
                $oModal = new Modal('Atenção!', 'Já existe uma referência cadastrada para esse Cliente, necessário alterar a referência!', Modal::TIPO_AVISO, false, true, true);
                echo $oModal->getRender();
                exit();
            }
        }
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        // $this->Persistencia->adicionaFiltro('pro_grupocodigo','100');
        // $this->Persistencia->adicionaFiltro('pro_grupocodigo', '100', Persistencia::LIGACAO_AND, Persistencia::ENTRE,'102');
        $aFiltros[0] = 100;
        $aFiltros[1] = 101;
        $aFiltros[2] = 102;
        $aFiltros[3] = 103;
        $aFiltros[4] = 12;
        $aFiltros[5] = 13;
        $aFiltros[6] = 2;
        $aFiltros[7] = 104;
        $aFiltros[8] = 105;
        $aFiltros[9] = 106;
        $aFiltros[10] = 107;
        $aFiltros[11] = 108;
        $aFiltros[12] = 109;
        $aFiltros[13] = 110;
        $aFiltros[14] = 111;
        $aFiltros[15] = 112;
        $aFiltros[16] = 113;
        $this->Persistencia->adicionaFiltro('pro_grupocodigo', $aFiltros, Persistencia::LIGACAO_AND, Persistencia::GRUPO);
    }

    public function insertProdutoFilial() {
        $oProdutoFilial = Fabrica::FabricarController('STEEL_PCP_ProdutoFilial');

        $oProdutoFilial->Model->setFil_codigo('8993358000174');
        $oProdutoFilial->Model->setPro_codigo($this->Model->getPro_codigo());
        $oProdutoFilial->Model->setPro_filialprioridade('1');
        $oProdutoFilial->Model->setPro_filialdtbloqueado('1753-01-01 00:00:00.000');
        $oProdutoFilial->Model->setPro_filialestoque('S');
        $oProdutoFilial->Model->setPro_filialestminimo('0');
        $oProdutoFilial->Model->setPro_filialestminimodias('0');
        $oProdutoFilial->Model->setPro_filialestmaximo('0');
        $oProdutoFilial->Model->setPro_filialestmaximodias('0');
        $oProdutoFilial->Model->setPro_filialdtinventariorota('1753-01-01 00:00:00.000');
        $oProdutoFilial->Model->setPro_filialmrpplanejamento('S');
        $oProdutoFilial->Model->setPro_filialmrptipoordem('A');
        $oProdutoFilial->Model->setPro_filialmrpdiascompra('0');
        $oProdutoFilial->Model->setPro_filialmrpdiasproducao('0');
        $oProdutoFilial->Model->setPro_filialmrpdiasqualidade('0');
        $oProdutoFilial->Model->setPro_filialmrpdiasfornecedor('0');
        $oProdutoFilial->Model->setPro_filialestminimotipo('Q');
        $oProdutoFilial->Model->setPro_filialestminimoperiodo('0');
        $oProdutoFilial->Model->setPro_filialmrplotemultiploqtd('0');
        $oProdutoFilial->Model->setPro_filialmrploteminimoqtd('0');
        $oProdutoFilial->Model->setPro_filialmrpdiasagrupamento('0');
        $oProdutoFilial->Model->setPro_filialcomprador(' ');
        $oProdutoFilial->Model->setPro_filialloteproducaoqtd(0);
        $oProdutoFilial->Model->setPro_filialcomprapercdifvalor('0');
        $oProdutoFilial->Model->setPro_filialcomprapercdifqtd('0'); //1753-01-01 00:00:00.000
        $oProdutoFilial->Model->setPro_filialinvrotativodata('1753-01-01 00:00:00.000');
        $oProdutoFilial->Model->setPro_filialcodigofiname(' ');
        $oProdutoFilial->Model->setPro_filialdescricaofiname(' ');
        $oProdutoFilial->Model->setPro_filialreferenciaseriefilia('8993358000174');
        $oProdutoFilial->Model->setPro_filialreferenciaserie('0');
        $oProdutoFilial->Model->setPro_filialitemcomposto('N');
        $oProdutoFilial->Model->setPro_filialcontrolasaldo('Q');
        $oProdutoFilial->Model->setPro_filialreservaestoqueestrut('N');
        $oProdutoFilial->Model->setPro_filialmrpacao('C');
        $oProdutoFilial->Model->setPro_filialquantidademultpadrao('0');
        $oProdutoFilial->Model->setPro_filialespeciepadrao(' ');
        $oProdutoFilial->Model->setPro_filialespeciecapacidade('0');
        $oProdutoFilial->Model->setPro_filialqtdprodutividade('0');
        $oProdutoFilial->Model->setPro_filialpercustocoproduto('0');
        $oProdutoFilial->Model->setPro_filialveiculo('N');
        $oProdutoFilial->Model->setPro_filialconsqtdeprodcoprodut('N');
        $oProdutoFilial->Model->setPro_filialmotivobloqueio(' ');
        $oProdutoFilial->Model->setPro_filialestpontorep('0');
        $oProdutoFilial->Model->setPro_filialmrpfilial('0');
        $oProdutoFilial->Model->setPro_produtofilialgrupotipo(' ');

        $oProdutoFilial->Persistencia->inserir();
    }

    public function afterCriaTela() {
        parent::afterCriaTela();

        $this->View->setBOcultaFechar(true);
    }

    public function antesDeMostrarTela($sParametros = null) {
        parent::antesDeMostrarTela($sParametros);
        $aDados = explode(',', $sParametros);

        $oImpXml = Fabrica::FabricarController('STEEL_PCP_ImportaXml');
        $oImpXml->Persistencia->adicionaFiltro('seq', $aDados[1]);
        $oDados = $oImpXml->Persistencia->consultarWhere();

        $this->View->setAParametrosExtras($oDados);
    }

    public function buscaReferencia($sDados) {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['emp_codigo'] == '75483040000211') {
            echo "$('#" . $sDados . "').val('" . $aCampos['prod'] . "');";
        } else {
            $this->Persistencia->adicionaFiltro('pro_codigo', $aCampos['prod']);
            $oDados = $this->Persistencia->consultarWhere();

            echo "$('#" . $sDados . "').val('" . $oDados->getPro_referencia() . "');";
        }
    }

    /**
     * Busca produto pela referencia
     */
    public function buscaProdutoReferencia($sDados) {
        $aIds = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['emp_codigo'] == '75483040000211') {
            $oMensagem = new Mensagem('Op Metalbo!', 'Não é necessário buscar referencia!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $this->Persistencia->adicionaFiltro('pro_referencia', $aCampos['referencia']);
            $this->Persistencia->adicionaFiltro('pro_codigoantigo', $aCampos['emp_codigo']);
            $oDados = $this->Persistencia->consultarWhere();

            echo "$('#" . $aIds[0] . "').val('" . $oDados->getPro_codigo() . "');"
            . "$('#" . $aIds[1] . "').val('" . $oDados->getPro_descricao() . "');";
        }
    }

    public function validaNCM($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        if ($aCampos['pro_ncm'] != '____.__.__-___') {
            $iNCM = $this->Persistencia->buscaNCM($aCampos['pro_ncm']);

            if ($iNCM == 0) {
                $oMensagem = new Mensagem('ATENÇÃO', 'Esse número de NCM não está cadastrado', Mensagem::TIPO_ERROR);
                echo $oMensagem->getRender();
                echo "$('#" . $aDados[0] . "').val('');";
            } else {
                $genero = substr($aCampos['pro_ncm'], 0, 2);
                echo "$('#" . $aDados[1] . "').val('" . $genero . "').focus().blur();";
            }
        }
    }

    public function verificaCampoGrupo() {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oControllerGrupo = Fabrica::FabricarController('STEEL_PCP_GrupoProd');
        $oControllerGrupo->Persistencia->adicionaFiltro('PRO_GrupoCodigo', $aCamposChave['pro_grupocodigo']);
        $oDados = $oControllerGrupo->Persistencia->consultarWhere();
        if ($oDados->getPRO_GrupoCodigo() == null || $oDados->getPRO_GrupoDescricao() == null) {
            echo "$('#GrupoCod').val('');";
            echo "$('#GrupoDes').val('');";
            $oMenSuccess = new Mensagem("Atenção", "Grupo inexistente!", Mensagem::TIPO_ERROR);
            echo $oMenSuccess->getRender();
            exit();
        }
        
    }

    public function verificaCampoSubGrupo() {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $oControllerSubGrupo = Fabrica::FabricarController('STEEL_PCP_SubgrupoProd');
        $oControllerSubGrupo->Persistencia->adicionaFiltro('PRO_GrupoCodigo', $aCamposChave['pro_grupocodigo']);
        $oControllerSubGrupo->Persistencia->adicionaFiltro('PRO_SubGrupoCodigo', $aCamposChave['pro_subgrupocodigo']);
        $oDados = $oControllerSubGrupo->Persistencia->consultarWhere();
        if ($oDados->getPRO_SubGrupoCodigo() == null || $oDados->getPRO_SubGrupoDescricao() == null) {
            echo "$('#SubGrupoCod').val('');";
            echo "$('#SubGrupoDes').val('');";
            $oMenSuccess = new Mensagem("Atenção", "SubGrupo inexistente!", Mensagem::TIPO_ERROR);
            echo $oMenSuccess->getRender();
            exit();
        }
    }

    public function verificaCampoFamilia() {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $oControllerFamilia = Fabrica::FabricarController('STEEL_PCP_FamProd');
        $oControllerFamilia->Persistencia->adicionaFiltro('PRO_GrupoCodigo', $aCamposChave['pro_grupocodigo']);
        $oControllerFamilia->Persistencia->adicionaFiltro('PRO_SubGrupoCodigo', $aCamposChave['pro_subgrupocodigo']);
        $oControllerFamilia->Persistencia->adicionaFiltro('PRO_FamiliaCodigo', $aCamposChave['pro_familiacodigo']);
        $oDados = $oControllerFamilia->Persistencia->consultarWhere();
        if ($oDados->getPRO_FamiliaCodigo() == null || $oDados->getPRO_FamiliaDescricao() == null) {
            echo "$('#FamiliaCod').val('');";
            echo "$('#FamiliaDes').val('');";
            $oMenSuccess = new Mensagem("Atenção", "Familia inexistente!", Mensagem::TIPO_ERROR);
            echo $oMenSuccess->getRender();
            exit();
        }
    }

    public function verificaCampoSubFamilia() {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $oControllerSubFamilia = Fabrica::FabricarController('STEEL_PCP_SubFamProd');
        $oControllerSubFamilia->Persistencia->adicionaFiltro('PRO_GrupoCodigo', $aCamposChave['pro_grupocodigo']);
        $oControllerSubFamilia->Persistencia->adicionaFiltro('PRO_SubGrupoCodigo', $aCamposChave['pro_subgrupocodigo']);
        $oControllerSubFamilia->Persistencia->adicionaFiltro('PRO_FamiliaCodigo', $aCamposChave['pro_familiacodigo']);
        $oControllerSubFamilia->Persistencia->adicionaFiltro('PRO_SubFamiliaCodigo', $aCamposChave['pro_subfamiliacodigo']);
        $oDados = $oControllerSubFamilia->Persistencia->consultarWhere();
        if ($oDados->getPRO_SubFamiliaCodigo() == null || $oDados->getPRO_SubFamiliaDescricao() == null) {
            echo "$('#SubFamiliaCod').val('');";
            echo "$('#SubFamiliaDes').val('');";
            $oMenSuccess = new Mensagem("Atenção", "SubFamilia inexistente!", Mensagem::TIPO_ERROR);
            echo $oMenSuccess->getRender();
            exit();
        }
    }

}
