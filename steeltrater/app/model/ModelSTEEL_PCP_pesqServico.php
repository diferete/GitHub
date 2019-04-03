<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSTEEL_PCP_pesqServico {
     private $STEEL_PCP_ProdutoFilial;
    private $DELX_PRO_Grupo;
    private $pro_codigo;
    private $pro_descricao;
    private $pro_cadastrousuario;
    private $pro_grupocodigo;
    private $pro_subgrupocodigo;
    private $DELX_PRO_Subgrupo;
    private $pro_familiacodigo;
    private $DELX_PRO_Familia;
    private $pro_subfamiliacodigo;
    private $DELX_PRO_Subfamilia;
    private $pro_unidademedida;
    private $DELX_PRO_UnidadeMedida;
    private $pro_tipocontrole;
    private $pro_tipocusto;
    private $pro_pesoliquido;
    private $pro_pesobruto;
    private $pro_volume;
    private $pro_volumepc;
    private $pro_codigoantigo;
    private $pro_descricaotecnica;
    private $pro_referencia;
    private $pro_diasvalidade;
    private $pro_tipovalidade;
    private $pro_produtotipoproducao;
    private $pro_generico;
    private $pro_produtotipovalidacodigobar;
    private $pro_produtotipocalculo;
    private $pro_lote;
    private $pro_compostovalor;
    private $pro_embalagemretornavel;
    private $pro_grade;
    private $pro_coproduto;
    private $pro_produtocontrolado;
    private $pro_fantasma;
    private $pro_produtoobsoleto;
    private $pro_produtofcirevenda;
    private $pro_letra;
    private $pro_importadoestrutura;
    private $pro_produtocontrolaserie;
    private $pro_produtofastcommerce;
    private $pro_receituario;
    private $pro_produtodrawback;
    private $pro_dimensoes;
    private $pro_dimensoesconversor;
    private $pro_dimensoesundconversor;
    private $pro_comprimentobruto;
    private $pro_largurabruto;
    private $pro_espessurabruto;
    private $pro_comprimentoliquido;
    private $pro_larguraliquido;
    private $pro_espessuraliquido;
    private $pro_produtomedidacomprimento;
    private $pro_volumem3;
    private $pro_dimensoesgradeformula;
    private $pro_produtopativo;
    private $pro_produtovinculadocodigo;
    private $pro_dimensoesunidade;
    private $pro_origem;
    private $pro_ncm;
    private $fis_cnaecodigo;
    private $fis_lc11603principalcodigo;
    private $fis_lc11603secundariocodigo;
    private $fis_generoitemcodigo;
    private $pro_tipoligacao;
    private $pro_grupotensao;
    private $pro_unidadecodigo;
    private $pro_destacanfse;
    private $pro_produtocest;
    private $pro_perigosoonu;
    private $pro_perigosonome;
    private $pro_perigosoclasse;
    private $pro_perigosoembalagem;
    private $pro_perigosopontofulgor;
    private $pro_descricaoestrutura;
    private $pro_perigosonumerorisco;
    private $pro_produtoperigosoqtdminima;
    private $matriz;
    private $steeltrater;
    private $fecula;
    private $fecial;
    private $hedler;
    ////////////////////////////////////////////////////////////////////////////////
    private $pro_mva;
    private $pro_composto;
    private $pro_cadastrodatahora;
    private $pro_alteracaousuario;
    private $pro_alteracaodatahora;
    private $pro_imagem;
    private $pro_sequencia;
    private $pro_imagemfiletype;
    private $pro_imagemfilename;
    private $pro_inventariosequencia;
    private $pro_transgenico;
    private $fis_simpscancgrupocodigo;
    private $fis_simpscancprodutocodigo;
    private $pro_simpscancinpminicial;
    private $pro_simpscanccalculoimposto;
    private $pro_classeconsumo;
    private $pro_tipoassinante;
    private $pro_tipoutilizacao;
    private $pro_classificacaoitem;
    private $pro_garantiatempo;
    private $pro_garantiatempotipo;
    private $pro_garantiatipo;
    private $fis_agrupamentocodigo;
    private $pro_tipoproduto;
    private $pro_tipovolume;
    private $pro_lotesequencial;
    private $qld_produtofrequenciainspecao;
    private $qld_produtoregimecodigo;
    private $qld_produtonivelcodigo;
    private $qld_produtoskiplotecodigo;
    private $qld_produtoexamecodigo;
    private $qld_produtonaoatualizaautoregi;
    private $pro_mascaralote;
    private $pro_tipocalculodecimal;
    private $pro_casasdecimais;
    private $pro_produtobovinos;
    private $pro_produtovacina;
    private $pro_produtovacinacodigo;
    private $grs_agrotoxicoclassetoxicologi;
    private $grs_agrotoxicoregistrominister;
    private $grs_agrotoxicograurisco;
    private $grs_classeriscocodigo;
    private $grs_agrotoxicoprincipioativo;
    private $grs_agrotoxicotriplicelavagem;
    private $grs_agrotoxicoindea;
    private $grs_agrotoxicofabricante;
    private $grs_agrotoxicoenderecofabrican;
    private $grs_agrotoxicotelefoneemergenc;
    private $grs_agrotoxiconumerososcotec;
    private $grs_agrotoxicobulaarquivo;
    private $grs_agrotoxicobulaarquivonome;
    private $grs_agrotoxicobulaarquivotipo;
    private $pro_produtoprioridadecomposto;
    private $grs_agrotoxicocarencia;
    private $cmb_produtoreducaost;
    private $dii_produtobeneficio;
    private $pro_produtodescnfe;
    private $pro_mascaraqualidade;
    private $pro_produtofilialfaturamento;
    private $pro_tipocoluna;
    private $fis_produtocompra;
    private $tms_produtopredominante;
    
    function getSTEEL_PCP_ProdutoFilial() {
        if(!isset($this->STEEL_PCP_ProdutoFilial)){
            $this->STEEL_PCP_ProdutoFilial = Fabrica::FabricarModel('STEEL_PCP_ProdutoFilial');
        }
        return $this->STEEL_PCP_ProdutoFilial;
    }

    function setSTEEL_PCP_ProdutoFilial($STEEL_PCP_ProdutoFilial) {
        $this->STEEL_PCP_ProdutoFilial = $STEEL_PCP_ProdutoFilial;
    }

    
    function getPro_mva() {
        return $this->pro_mva;
    }

    function getPro_composto() {
        return $this->pro_composto;
    }

    function getPro_cadastrodatahora() {
        return $this->pro_cadastrodatahora;
    }

    function getPro_alteracaousuario() {
        return $this->pro_alteracaousuario;
    }

    function getPro_alteracaodatahora() {
        return $this->pro_alteracaodatahora;
    }

    function getPro_imagem() {
        return $this->pro_imagem;
    }

    function getPro_sequencia() {
        return $this->pro_sequencia;
    }

    function getPro_imagemfiletype() {
        return $this->pro_imagemfiletype;
    }

    function getPro_imagemfilename() {
        return $this->pro_imagemfilename;
    }

    function getPro_inventariosequencia() {
        return $this->pro_inventariosequencia;
    }

    function getPro_transgenico() {
        return $this->pro_transgenico;
    }

    function getFis_simpscancgrupocodigo() {
        return $this->fis_simpscancgrupocodigo;
    }

    function getFis_simpscancprodutocodigo() {
        return $this->fis_simpscancprodutocodigo;
    }

    function getPro_simpscancinpminicial() {
        return $this->pro_simpscancinpminicial;
    }

    function getPro_simpscanccalculoimposto() {
        return $this->pro_simpscanccalculoimposto;
    }

    function getPro_classeconsumo() {
        return $this->pro_classeconsumo;
    }

    function getPro_tipoassinante() {
        return $this->pro_tipoassinante;
    }

    function getPro_tipoutilizacao() {
        return $this->pro_tipoutilizacao;
    }

    function getPro_classificacaoitem() {
        return $this->pro_classificacaoitem;
    }

    function getPro_garantiatempo() {
        return $this->pro_garantiatempo;
    }

    function getPro_garantiatempotipo() {
        return $this->pro_garantiatempotipo;
    }

    function getPro_garantiatipo() {
        return $this->pro_garantiatipo;
    }

    function getFis_agrupamentocodigo() {
        return $this->fis_agrupamentocodigo;
    }

    function getPro_tipoproduto() {
        return $this->pro_tipoproduto;
    }

    function getPro_tipovolume() {
        return $this->pro_tipovolume;
    }

    function getPro_lotesequencial() {
        return $this->pro_lotesequencial;
    }

    function getQld_produtofrequenciainspecao() {
        return $this->qld_produtofrequenciainspecao;
    }

    function getQld_produtoregimecodigo() {
        return $this->qld_produtoregimecodigo;
    }

    function getQld_produtonivelcodigo() {
        return $this->qld_produtonivelcodigo;
    }

    function getQld_produtoskiplotecodigo() {
        return $this->qld_produtoskiplotecodigo;
    }

    function getQld_produtoexamecodigo() {
        return $this->qld_produtoexamecodigo;
    }

    function getQld_produtonaoatualizaautoregi() {
        return $this->qld_produtonaoatualizaautoregi;
    }

    function getPro_mascaralote() {
        return $this->pro_mascaralote;
    }

    function getPro_tipocalculodecimal() {
        return $this->pro_tipocalculodecimal;
    }

    function getPro_casasdecimais() {
        return $this->pro_casasdecimais;
    }

    function getPro_produtobovinos() {
        return $this->pro_produtobovinos;
    }

    function getPro_produtovacina() {
        return $this->pro_produtovacina;
    }

    function getPro_produtovacinacodigo() {
        return $this->pro_produtovacinacodigo;
    }

    function getGrs_agrotoxicoclassetoxicologi() {
        return $this->grs_agrotoxicoclassetoxicologi;
    }

    function getGrs_agrotoxicoregistrominister() {
        return $this->grs_agrotoxicoregistrominister;
    }

    function getGrs_agrotoxicograurisco() {
        return $this->grs_agrotoxicograurisco;
    }

    function getGrs_classeriscocodigo() {
        return $this->grs_classeriscocodigo;
    }

    function getGrs_agrotoxicoprincipioativo() {
        return $this->grs_agrotoxicoprincipioativo;
    }

    function getGrs_agrotoxicotriplicelavagem() {
        return $this->grs_agrotoxicotriplicelavagem;
    }

    function getGrs_agrotoxicoindea() {
        return $this->grs_agrotoxicoindea;
    }

    function getGrs_agrotoxicofabricante() {
        return $this->grs_agrotoxicofabricante;
    }

    function getGrs_agrotoxicoenderecofabrican() {
        return $this->grs_agrotoxicoenderecofabrican;
    }

    function getGrs_agrotoxicotelefoneemergenc() {
        return $this->grs_agrotoxicotelefoneemergenc;
    }

    function getGrs_agrotoxiconumerososcotec() {
        return $this->grs_agrotoxiconumerososcotec;
    }

    function getGrs_agrotoxicobulaarquivo() {
        return $this->grs_agrotoxicobulaarquivo;
    }

    function getGrs_agrotoxicobulaarquivonome() {
        return $this->grs_agrotoxicobulaarquivonome;
    }

    function getGrs_agrotoxicobulaarquivotipo() {
        return $this->grs_agrotoxicobulaarquivotipo;
    }

    function getPro_produtoprioridadecomposto() {
        return $this->pro_produtoprioridadecomposto;
    }

    function getGrs_agrotoxicocarencia() {
        return $this->grs_agrotoxicocarencia;
    }

    function getCmb_produtoreducaost() {
        return $this->cmb_produtoreducaost;
    }

    function getDii_produtobeneficio() {
        return $this->dii_produtobeneficio;
    }

    function getPro_produtodescnfe() {
        return $this->pro_produtodescnfe;
    }

    function getPro_mascaraqualidade() {
        return $this->pro_mascaraqualidade;
    }

    function getPro_produtofilialfaturamento() {
        return $this->pro_produtofilialfaturamento;
    }

    function getPro_tipocoluna() {
        return $this->pro_tipocoluna;
    }

    function getFis_produtocompra() {
        return $this->fis_produtocompra;
    }

    function getTms_produtopredominante() {
        return $this->tms_produtopredominante;
    }

    function setPro_mva($pro_mva) {
        $this->pro_mva = $pro_mva;
    }

    function setPro_composto($pro_composto) {
        $this->pro_composto = $pro_composto;
    }

    function setPro_cadastrodatahora($pro_cadastrodatahora) {
        $this->pro_cadastrodatahora = $pro_cadastrodatahora;
    }

    function setPro_alteracaousuario($pro_alteracaousuario) {
        $this->pro_alteracaousuario = $pro_alteracaousuario;
    }

    function setPro_alteracaodatahora($pro_alteracaodatahora) {
        $this->pro_alteracaodatahora = $pro_alteracaodatahora;
    }

    function setPro_imagem($pro_imagem) {
        $this->pro_imagem = $pro_imagem;
    }

    function setPro_sequencia($pro_sequencia) {
        $this->pro_sequencia = $pro_sequencia;
    }

    function setPro_imagemfiletype($pro_imagemfiletype) {
        $this->pro_imagemfiletype = $pro_imagemfiletype;
    }

    function setPro_imagemfilename($pro_imagemfilename) {
        $this->pro_imagemfilename = $pro_imagemfilename;
    }

    function setPro_inventariosequencia($pro_inventariosequencia) {
        $this->pro_inventariosequencia = $pro_inventariosequencia;
    }

    function setPro_transgenico($pro_transgenico) {
        $this->pro_transgenico = $pro_transgenico;
    }

    function setFis_simpscancgrupocodigo($fis_simpscancgrupocodigo) {
        $this->fis_simpscancgrupocodigo = $fis_simpscancgrupocodigo;
    }

    function setFis_simpscancprodutocodigo($fis_simpscancprodutocodigo) {
        $this->fis_simpscancprodutocodigo = $fis_simpscancprodutocodigo;
    }

    function setPro_simpscancinpminicial($pro_simpscancinpminicial) {
        $this->pro_simpscancinpminicial = $pro_simpscancinpminicial;
    }

    function setPro_simpscanccalculoimposto($pro_simpscanccalculoimposto) {
        $this->pro_simpscanccalculoimposto = $pro_simpscanccalculoimposto;
    }

    function setPro_classeconsumo($pro_classeconsumo) {
        $this->pro_classeconsumo = $pro_classeconsumo;
    }

    function setPro_tipoassinante($pro_tipoassinante) {
        $this->pro_tipoassinante = $pro_tipoassinante;
    }

    function setPro_tipoutilizacao($pro_tipoutilizacao) {
        $this->pro_tipoutilizacao = $pro_tipoutilizacao;
    }

    function setPro_classificacaoitem($pro_classificacaoitem) {
        $this->pro_classificacaoitem = $pro_classificacaoitem;
    }

    function setPro_garantiatempo($pro_garantiatempo) {
        $this->pro_garantiatempo = $pro_garantiatempo;
    }

    function setPro_garantiatempotipo($pro_garantiatempotipo) {
        $this->pro_garantiatempotipo = $pro_garantiatempotipo;
    }

    function setPro_garantiatipo($pro_garantiatipo) {
        $this->pro_garantiatipo = $pro_garantiatipo;
    }

    function setFis_agrupamentocodigo($fis_agrupamentocodigo) {
        $this->fis_agrupamentocodigo = $fis_agrupamentocodigo;
    }

    function setPro_tipoproduto($pro_tipoproduto) {
        $this->pro_tipoproduto = $pro_tipoproduto;
    }

    function setPro_tipovolume($pro_tipovolume) {
        $this->pro_tipovolume = $pro_tipovolume;
    }

    function setPro_lotesequencial($pro_lotesequencial) {
        $this->pro_lotesequencial = $pro_lotesequencial;
    }

    function setQld_produtofrequenciainspecao($qld_produtofrequenciainspecao) {
        $this->qld_produtofrequenciainspecao = $qld_produtofrequenciainspecao;
    }

    function setQld_produtoregimecodigo($qld_produtoregimecodigo) {
        $this->qld_produtoregimecodigo = $qld_produtoregimecodigo;
    }

    function setQld_produtonivelcodigo($qld_produtonivelcodigo) {
        $this->qld_produtonivelcodigo = $qld_produtonivelcodigo;
    }

    function setQld_produtoskiplotecodigo($qld_produtoskiplotecodigo) {
        $this->qld_produtoskiplotecodigo = $qld_produtoskiplotecodigo;
    }

    function setQld_produtoexamecodigo($qld_produtoexamecodigo) {
        $this->qld_produtoexamecodigo = $qld_produtoexamecodigo;
    }

    function setQld_produtonaoatualizaautoregi($qld_produtonaoatualizaautoregi) {
        $this->qld_produtonaoatualizaautoregi = $qld_produtonaoatualizaautoregi;
    }

    function setPro_mascaralote($pro_mascaralote) {
        $this->pro_mascaralote = $pro_mascaralote;
    }

    function setPro_tipocalculodecimal($pro_tipocalculodecimal) {
        $this->pro_tipocalculodecimal = $pro_tipocalculodecimal;
    }

    function setPro_casasdecimais($pro_casasdecimais) {
        $this->pro_casasdecimais = $pro_casasdecimais;
    }

    function setPro_produtobovinos($pro_produtobovinos) {
        $this->pro_produtobovinos = $pro_produtobovinos;
    }

    function setPro_produtovacina($pro_produtovacina) {
        $this->pro_produtovacina = $pro_produtovacina;
    }

    function setPro_produtovacinacodigo($pro_produtovacinacodigo) {
        $this->pro_produtovacinacodigo = $pro_produtovacinacodigo;
    }

    function setGrs_agrotoxicoclassetoxicologi($grs_agrotoxicoclassetoxicologi) {
        $this->grs_agrotoxicoclassetoxicologi = $grs_agrotoxicoclassetoxicologi;
    }

    function setGrs_agrotoxicoregistrominister($grs_agrotoxicoregistrominister) {
        $this->grs_agrotoxicoregistrominister = $grs_agrotoxicoregistrominister;
    }

    function setGrs_agrotoxicograurisco($grs_agrotoxicograurisco) {
        $this->grs_agrotoxicograurisco = $grs_agrotoxicograurisco;
    }

    function setGrs_classeriscocodigo($grs_classeriscocodigo) {
        $this->grs_classeriscocodigo = $grs_classeriscocodigo;
    }

    function setGrs_agrotoxicoprincipioativo($grs_agrotoxicoprincipioativo) {
        $this->grs_agrotoxicoprincipioativo = $grs_agrotoxicoprincipioativo;
    }

    function setGrs_agrotoxicotriplicelavagem($grs_agrotoxicotriplicelavagem) {
        $this->grs_agrotoxicotriplicelavagem = $grs_agrotoxicotriplicelavagem;
    }

    function setGrs_agrotoxicoindea($grs_agrotoxicoindea) {
        $this->grs_agrotoxicoindea = $grs_agrotoxicoindea;
    }

    function setGrs_agrotoxicofabricante($grs_agrotoxicofabricante) {
        $this->grs_agrotoxicofabricante = $grs_agrotoxicofabricante;
    }

    function setGrs_agrotoxicoenderecofabrican($grs_agrotoxicoenderecofabrican) {
        $this->grs_agrotoxicoenderecofabrican = $grs_agrotoxicoenderecofabrican;
    }

    function setGrs_agrotoxicotelefoneemergenc($grs_agrotoxicotelefoneemergenc) {
        $this->grs_agrotoxicotelefoneemergenc = $grs_agrotoxicotelefoneemergenc;
    }

    function setGrs_agrotoxiconumerososcotec($grs_agrotoxiconumerososcotec) {
        $this->grs_agrotoxiconumerososcotec = $grs_agrotoxiconumerososcotec;
    }

    function setGrs_agrotoxicobulaarquivo($grs_agrotoxicobulaarquivo) {
        $this->grs_agrotoxicobulaarquivo = $grs_agrotoxicobulaarquivo;
    }

    function setGrs_agrotoxicobulaarquivonome($grs_agrotoxicobulaarquivonome) {
        $this->grs_agrotoxicobulaarquivonome = $grs_agrotoxicobulaarquivonome;
    }

    function setGrs_agrotoxicobulaarquivotipo($grs_agrotoxicobulaarquivotipo) {
        $this->grs_agrotoxicobulaarquivotipo = $grs_agrotoxicobulaarquivotipo;
    }

    function setPro_produtoprioridadecomposto($pro_produtoprioridadecomposto) {
        $this->pro_produtoprioridadecomposto = $pro_produtoprioridadecomposto;
    }

    function setGrs_agrotoxicocarencia($grs_agrotoxicocarencia) {
        $this->grs_agrotoxicocarencia = $grs_agrotoxicocarencia;
    }

    function setCmb_produtoreducaost($cmb_produtoreducaost) {
        $this->cmb_produtoreducaost = $cmb_produtoreducaost;
    }

    function setDii_produtobeneficio($dii_produtobeneficio) {
        $this->dii_produtobeneficio = $dii_produtobeneficio;
    }

    function setPro_produtodescnfe($pro_produtodescnfe) {
        $this->pro_produtodescnfe = $pro_produtodescnfe;
    }

    function setPro_mascaraqualidade($pro_mascaraqualidade) {
        $this->pro_mascaraqualidade = $pro_mascaraqualidade;
    }

    function setPro_produtofilialfaturamento($pro_produtofilialfaturamento) {
        $this->pro_produtofilialfaturamento = $pro_produtofilialfaturamento;
    }

    function setPro_tipocoluna($pro_tipocoluna) {
        $this->pro_tipocoluna = $pro_tipocoluna;
    }

    function setFis_produtocompra($fis_produtocompra) {
        $this->fis_produtocompra = $fis_produtocompra;
    }

    function setTms_produtopredominante($tms_produtopredominante) {
        $this->tms_produtopredominante = $tms_produtopredominante;
    }
/////////////////////////////////////////////////////////////////////////////////////////    
    
    function getMatriz() {
        return $this->matriz;
    }

    function getSteeltrater() {
        return $this->steeltrater;
    }

    function getFecula() {
        return $this->fecula;
    }

    function getFecial() {
        return $this->fecial;
    }

    function getHedler() {
        return $this->hedler;
    }

    function setMatriz($matriz) {
        $this->matriz = $matriz;
    }

    function setSteeltrater($steeltrater) {
        $this->steeltrater = $steeltrater;
    }

    function setFecula($fecula) {
        $this->fecula = $fecula;
    }

    function setFecial($fecial) {
        $this->fecial = $fecial;
    }

    function setHedler($hedler) {
        $this->hedler = $hedler;
    }

    function getPro_produtoperigosoqtdminima() {
        return $this->pro_produtoperigosoqtdminima;
    }

    function setPro_produtoperigosoqtdminima($pro_produtoperigosoqtdminima) {
        $this->pro_produtoperigosoqtdminima = $pro_produtoperigosoqtdminima;
    }

    function getPro_perigosonumerorisco() {
        return $this->pro_perigosonumerorisco;
    }

    function setPro_perigosonumerorisco($pro_perigosonumerorisco) {
        $this->pro_perigosonumerorisco = $pro_perigosonumerorisco;
    }

    function getPro_descricaoestrutura() {
        return $this->pro_descricaoestrutura;
    }

    function setPro_descricaoestrutura($pro_descricaoestrutura) {
        $this->pro_descricaoestrutura = $pro_descricaoestrutura;
    }

    function getPro_perigosopontofulgor() {
        return $this->pro_perigosopontofulgor;
    }

    function setPro_perigosopontofulgor($pro_perigosopontofulgor) {
        $this->pro_perigosopontofulgor = $pro_perigosopontofulgor;
    }

    function getPro_perigosoembalagem() {
        return $this->pro_perigosoembalagem;
    }

    function setPro_perigosoembalagem($pro_perigosoembalagem) {
        $this->pro_perigosoembalagem = $pro_perigosoembalagem;
    }

    function getPro_perigosoclasse() {
        return $this->pro_perigosoclasse;
    }

    function setPro_perigosoclasse($pro_perigosoclasse) {
        $this->pro_perigosoclasse = $pro_perigosoclasse;
    }

    function getPro_perigosonome() {
        return $this->pro_perigosonome;
    }

    function setPro_perigosonome($pro_perigosonome) {
        $this->pro_perigosonome = $pro_perigosonome;
    }

    function getPro_perigosoonu() {
        return $this->pro_perigosoonu;
    }

    function setPro_perigosoonu($pro_perigosoonu) {
        $this->pro_perigosoonu = $pro_perigosoonu;
    }

    function getPro_unidadecodigo() {
        return $this->pro_unidadecodigo;
    }

    function getPro_destacanfse() {
        return $this->pro_destacanfse;
    }

    function getPro_produtocest() {
        return $this->pro_produtocest;
    }

    function setPro_unidadecodigo($pro_unidadecodigo) {
        $this->pro_unidadecodigo = $pro_unidadecodigo;
    }

    function setPro_destacanfse($pro_destacanfse) {
        $this->pro_destacanfse = $pro_destacanfse;
    }

    function setPro_produtocest($pro_produtocest) {
        $this->pro_produtocest = $pro_produtocest;
    }

    function getPro_tipoligacao() {
        return $this->pro_tipoligacao;
    }

    function getPro_grupotensao() {
        return $this->pro_grupotensao;
    }

    function setPro_tipoligacao($pro_tipoligacao) {
        $this->pro_tipoligacao = $pro_tipoligacao;
    }

    function setPro_grupotensao($pro_grupotensao) {
        $this->pro_grupotensao = $pro_grupotensao;
    }

    function getFis_generoitemcodigo() {
        return $this->fis_generoitemcodigo;
    }

    function setFis_generoitemcodigo($fis_generoitemcodigo) {
        $this->fis_generoitemcodigo = $fis_generoitemcodigo;
    }

    function getFis_cnaecodigo() {
        return $this->fis_cnaecodigo;
    }

    function getFis_lc11603principalcodigo() {
        return $this->fis_lc11603principalcodigo;
    }

    function getFis_lc11603secundariocodigo() {
        return $this->fis_lc11603secundariocodigo;
    }

    function setFis_cnaecodigo($fis_cnaecodigo) {
        $this->fis_cnaecodigo = $fis_cnaecodigo;
    }

    function setFis_lc11603principalcodigo($fis_lc11603principalcodigo) {
        $this->fis_lc11603principalcodigo = $fis_lc11603principalcodigo;
    }

    function setFis_lc11603secundariocodigo($fis_lc11603secundariocodigo) {
        $this->fis_lc11603secundariocodigo = $fis_lc11603secundariocodigo;
    }

    function getPro_ncm() {
        return $this->pro_ncm;
    }

    function setPro_ncm($pro_ncm) {
        $this->pro_ncm = $pro_ncm;
    }

    function getPro_origem() {
        return $this->pro_origem;
    }

    function setPro_origem($pro_origem) {
        $this->pro_origem = $pro_origem;
    }

    function getPro_dimensoesunidade() {
        return $this->pro_dimensoesunidade;
    }

    function setPro_dimensoesunidade($pro_dimensoesunidade) {
        $this->pro_dimensoesunidade = $pro_dimensoesunidade;
    }

    function getPro_produtovinculadocodigo() {
        return $this->pro_produtovinculadocodigo;
    }

    function setPro_produtovinculadocodigo($pro_produtovinculadocodigo) {
        $this->pro_produtovinculadocodigo = $pro_produtovinculadocodigo;
    }

    function getPro_produtopativo() {
        return $this->pro_produtopativo;
    }

    function setPro_produtopativo($pro_produtopativo) {
        $this->pro_produtopativo = $pro_produtopativo;
    }

    function getPro_produtocontrolaserie() {
        return $this->pro_produtocontrolaserie;
    }

    function getPro_produtofastcommerce() {
        return $this->pro_produtofastcommerce;
    }

    function getPro_receituario() {
        return $this->pro_receituario;
    }

    function getPro_produtodrawback() {
        return $this->pro_produtodrawback;
    }

    function getPro_dimensoes() {
        return $this->pro_dimensoes;
    }

    function getPro_dimensoesconversor() {
        return $this->pro_dimensoesconversor;
    }

    function getPro_dimensoesundconversor() {
        return $this->pro_dimensoesundconversor;
    }

    function getPro_comprimentobruto() {
        return $this->pro_comprimentobruto;
    }

    function getPro_largurabruto() {
        return $this->pro_largurabruto;
    }

    function getPro_espessurabruto() {
        return $this->pro_espessurabruto;
    }

    function getPro_comprimentoliquido() {
        return $this->pro_comprimentoliquido;
    }

    function getPro_larguraliquido() {
        return $this->pro_larguraliquido;
    }

    function getPro_espessuraliquido() {
        return $this->pro_espessuraliquido;
    }

    function getPro_produtomedidacomprimento() {
        return $this->pro_produtomedidacomprimento;
    }

    function getPro_volumem3() {
        return $this->pro_volumem3;
    }

    function getPro_dimensoesgradeformula() {
        return $this->pro_dimensoesgradeformula;
    }

    function getPro_cadastrousuario() {
        return $this->pro_cadastrousuario;
    }

    function setPro_produtocontrolaserie($pro_produtocontrolaserie) {
        $this->pro_produtocontrolaserie = $pro_produtocontrolaserie;
    }

    function setPro_produtofastcommerce($pro_produtofastcommerce) {
        $this->pro_produtofastcommerce = $pro_produtofastcommerce;
    }

    function setPro_receituario($pro_receituario) {
        $this->pro_receituario = $pro_receituario;
    }

    function setPro_produtodrawback($pro_produtodrawback) {
        $this->pro_produtodrawback = $pro_produtodrawback;
    }

    function setPro_dimensoes($pro_dimensoes) {
        $this->pro_dimensoes = $pro_dimensoes;
    }

    function setPro_dimensoesconversor($pro_dimensoesconversor) {
        $this->pro_dimensoesconversor = $pro_dimensoesconversor;
    }

    function setPro_dimensoesundconversor($pro_dimensoesundconversor) {
        $this->pro_dimensoesundconversor = $pro_dimensoesundconversor;
    }

    function setPro_comprimentobruto($pro_comprimentobruto) {
        $this->pro_comprimentobruto = $pro_comprimentobruto;
    }

    function setPro_largurabruto($pro_largurabruto) {
        $this->pro_largurabruto = $pro_largurabruto;
    }

    function setPro_espessurabruto($pro_espessurabruto) {
        $this->pro_espessurabruto = $pro_espessurabruto;
    }

    function setPro_comprimentoliquido($pro_comprimentoliquido) {
        $this->pro_comprimentoliquido = $pro_comprimentoliquido;
    }

    function setPro_larguraliquido($pro_larguraliquido) {
        $this->pro_larguraliquido = $pro_larguraliquido;
    }

    function setPro_espessuraliquido($pro_espessuraliquido) {
        $this->pro_espessuraliquido = $pro_espessuraliquido;
    }

    function setPro_produtomedidacomprimento($pro_produtomedidacomprimento) {
        $this->pro_produtomedidacomprimento = $pro_produtomedidacomprimento;
    }

    function setPro_volumem3($pro_volumem3) {
        $this->pro_volumem3 = $pro_volumem3;
    }

    function setPro_dimensoesgradeformula($pro_dimensoesgradeformula) {
        $this->pro_dimensoesgradeformula = $pro_dimensoesgradeformula;
    }

    function setPro_cadastrousuario($pro_cadastrousuario) {
        $this->pro_cadastrousuario = $pro_cadastrousuario;
    }

    function getPro_produtofcirevenda() {
        return $this->pro_produtofcirevenda;
    }

    function setPro_produtofcirevenda($pro_produtofcirevenda) {
        $this->pro_produtofcirevenda = $pro_produtofcirevenda;
    }

    function getPro_letra() {
        return $this->pro_letra;
    }

    function setPro_letra($pro_letra) {
        $this->pro_letra = $pro_letra;
    }

    function getPro_importadoestrutura() {
        return $this->pro_importadoestrutura;
    }

    function setPro_importadoestrutura($pro_importadoestrutura) {
        $this->pro_importadoestrutura = $pro_importadoestrutura;
    }

    function getPro_produtoobsoleto() {
        return $this->pro_produtoobsoleto;
    }

    function setPro_produtoobsoleto($pro_produtoobsoleto) {
        $this->pro_produtoobsoleto = $pro_produtoobsoleto;
    }

    function getPro_lote() {
        return $this->pro_lote;
    }

    function getPro_compostovalor() {
        return $this->pro_compostovalor;
    }

    function getPro_embalagemretornavel() {
        return $this->pro_embalagemretornavel;
    }

    function getPro_grade() {
        return $this->pro_grade;
    }

    function getPro_coproduto() {
        return $this->pro_coproduto;
    }

    function getPro_produtocontrolado() {
        return $this->pro_produtocontrolado;
    }

    function getPro_fantasma() {
        return $this->pro_fantasma;
    }

    function setPro_lote($pro_lote) {
        $this->pro_lote = $pro_lote;
    }

    function setPro_compostovalor($pro_compostovalor) {
        $this->pro_compostovalor = $pro_compostovalor;
    }

    function setPro_embalagemretornavel($pro_embalagemretornavel) {
        $this->pro_embalagemretornavel = $pro_embalagemretornavel;
    }

    function setPro_grade($pro_grade) {
        $this->pro_grade = $pro_grade;
    }

    function setPro_coproduto($pro_coproduto) {
        $this->pro_coproduto = $pro_coproduto;
    }

    function setPro_produtocontrolado($pro_produtocontrolado) {
        $this->pro_produtocontrolado = $pro_produtocontrolado;
    }

    function setPro_fantasma($pro_fantasma) {
        $this->pro_fantasma = $pro_fantasma;
    }

    function getPro_generico() {
        return $this->pro_generico;
    }

    function getPro_produtotipovalidacodigobar() {
        return $this->pro_produtotipovalidacodigobar;
    }

    function getPro_produtotipocalculo() {
        return $this->pro_produtotipocalculo;
    }

    function setPro_generico($pro_generico) {
        $this->pro_generico = $pro_generico;
    }

    function setPro_produtotipovalidacodigobar($pro_produtotipovalidacodigobar) {
        $this->pro_produtotipovalidacodigobar = $pro_produtotipovalidacodigobar;
    }

    function setPro_produtotipocalculo($pro_produtotipocalculo) {
        $this->pro_produtotipocalculo = $pro_produtotipocalculo;
    }

    function getPro_volumepc() {
        return $this->pro_volumepc;
    }

    function getPro_codigoantigo() {
        return $this->pro_codigoantigo;
    }

    function getPro_descricaotecnica() {
        return $this->pro_descricaotecnica;
    }

    function getPro_referencia() {
        return $this->pro_referencia;
    }

    function getPro_diasvalidade() {
        return $this->pro_diasvalidade;
    }

    function getPro_tipovalidade() {
        return $this->pro_tipovalidade;
    }

    function getPro_produtotipoproducao() {
        return $this->pro_produtotipoproducao;
    }

    function setPro_volumepc($pro_volumepc) {
        $this->pro_volumepc = $pro_volumepc;
    }

    function setPro_codigoantigo($pro_codigoantigo) {
        $this->pro_codigoantigo = $pro_codigoantigo;
    }

    function setPro_descricaotecnica($pro_descricaotecnica) {
        $this->pro_descricaotecnica = $pro_descricaotecnica;
    }

    function setPro_referencia($pro_referencia) {
        $this->pro_referencia = $pro_referencia;
    }

    function setPro_diasvalidade($pro_diasvalidade) {
        $this->pro_diasvalidade = $pro_diasvalidade;
    }

    function setPro_tipovalidade($pro_tipovalidade) {
        $this->pro_tipovalidade = $pro_tipovalidade;
    }

    function setPro_produtotipoproducao($pro_produtotipoproducao) {
        $this->pro_produtotipoproducao = $pro_produtotipoproducao;
    }

    function getPro_tipocontrole() {
        return $this->pro_tipocontrole;
    }

    function getPro_tipocusto() {
        return $this->pro_tipocusto;
    }

    function getPro_pesobruto() {
        return $this->pro_pesobruto;
    }

    function getPro_volume() {
        return $this->pro_volume;
    }

    function setPro_tipocontrole($pro_tipocontrole) {
        $this->pro_tipocontrole = $pro_tipocontrole;
    }

    function setPro_tipocusto($pro_tipocusto) {
        $this->pro_tipocusto = $pro_tipocusto;
    }

    function setPro_pesobruto($pro_pesobruto) {
        $this->pro_pesobruto = $pro_pesobruto;
    }

    function setPro_volume($pro_volume) {
        $this->pro_volume = $pro_volume;
    }

    function getDELX_PRO_UnidadeMedida() {
        if (!isset($this->DELX_PRO_UnidadeMedida)) {
            $this->DELX_PRO_UnidadeMedida = Fabrica::FabricarModel('DELX_PRO_UnidadeMedida');
        }
        return $this->DELX_PRO_UnidadeMedida;
    }

    function setDELX_PRO_UnidadeMedida($DELX_PRO_UnidadeMedida) {
        $this->DELX_PRO_UnidadeMedida = $DELX_PRO_UnidadeMedida;
    }

    function getDELX_PRO_Subfamilia() {
        if (!isset($this->DELX_PRO_Subfamilia)) {
            $this->DELX_PRO_Subfamilia = Fabrica::FabricarModel('DELX_PRO_Subfamilia');
        }
        return $this->DELX_PRO_Subfamilia;
    }

    function setDELX_PRO_Subfamilia($DELX_PRO_Subfamilia) {
        $this->DELX_PRO_Subfamilia = $DELX_PRO_Subfamilia;
    }

    function getPro_subfamiliacodigo() {
        return $this->pro_subfamiliacodigo;
    }

    function setPro_subfamiliacodigo($pro_subfamiliacodigo) {
        $this->pro_subfamiliacodigo = $pro_subfamiliacodigo;
    }

    function getDELX_PRO_Familia() {
        if (!isset($this->DELX_PRO_Familia)) {
            $this->DELX_PRO_Familia = Fabrica::FabricarModel('DELX_PRO_Familia');
        }
        return $this->DELX_PRO_Familia;
    }

    function setDELX_PRO_Familia($DELX_PRO_Familia) {
        $this->DELX_PRO_Familia = $DELX_PRO_Familia;
    }

    function getPro_familiacodigo() {
        return $this->pro_familiacodigo;
    }

    function setPro_familiacodigo($pro_familiacodigo) {
        $this->pro_familiacodigo = $pro_familiacodigo;
    }

    function getDELX_PRO_Subgrupo() {
        if (!isset($this->DELX_PRO_Subgrupo)) {
            $this->DELX_PRO_Subgrupo = Fabrica::FabricarModel('DELX_PRO_Subgrupo');
        }
        return $this->DELX_PRO_Subgrupo;
    }

    function setDELX_PRO_Subgrupo($DELX_PRO_Subgrupo) {
        $this->DELX_PRO_Subgrupo = $DELX_PRO_Subgrupo;
    }

    function getPro_subgrupocodigo() {
        return $this->pro_subgrupocodigo;
    }

    function setPro_subgrupocodigo($pro_subgrupocodigo) {
        $this->pro_subgrupocodigo = $pro_subgrupocodigo;
    }

    function getPro_grupocodigo() {
        return $this->pro_grupocodigo;
    }

    function setPro_grupocodigo($pro_grupocodigo) {
        $this->pro_grupocodigo = $pro_grupocodigo;
    }

    function getDELX_PRO_Grupo() {
        if (!isset($this->DELX_PRO_Grupo)) {
            $this->DELX_PRO_Grupo = Fabrica::FabricarModel('DELX_PRO_Grupo');
        }
        return $this->DELX_PRO_Grupo;
    }

    function setDELX_PRO_Grupo($DELX_PRO_Grupo) {
        $this->DELX_PRO_Grupo = $DELX_PRO_Grupo;
    }

    function getPro_pesoliquido() {
        return $this->pro_pesoliquido;
    }

    function setPro_pesoliquido($pro_pesoliquido) {
        $this->pro_pesoliquido = $pro_pesoliquido;
    }

    function getPro_unidademedida() {
        return $this->pro_unidademedida;
    }

    function setPro_unidademedida($pro_unidademedida) {
        $this->pro_unidademedida = $pro_unidademedida;
    }

    function getPro_descricao() {
        return $this->pro_descricao;
    }

    function setPro_descricao($pro_descricao) {
        $this->pro_descricao = $pro_descricao;
    }

    function getPro_codigo() {
        return $this->pro_codigo;
    }

    function setPro_codigo($pro_codigo) {
        $this->pro_codigo = $pro_codigo;
    }

}