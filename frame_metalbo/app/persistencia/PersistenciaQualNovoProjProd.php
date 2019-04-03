<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaQualNovoProjProd extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbqualNovoProjeto');

        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('dtimp', 'dtimp');
        $this->adicionaRelacionamento('resp_proj_nome', 'resp_proj_nome');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');
        $this->adicionaRelacionamento('desc_novo_prod', 'desc_novo_prod');
        $this->adicionaRelacionamento('obsaprovcli', 'obsaprovcli');
        $this->adicionaRelacionamento('sitgeralproj', 'sitgeralproj');
        $this->adicionaRelacionamento('sitcliente', 'sitcliente');

        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodsimilar', 'prodsimilar');
        $this->adicionaRelacionamento('procodsimilar', 'procodsimilar');

        $this->adicionaRelacionamento('chavemin', 'chavemin');
        $this->adicionaRelacionamento('chavemax', 'chavemax');
        $this->adicionaRelacionamento('altmin', 'altmin');
        $this->adicionaRelacionamento('altmax', 'altmax');
        $this->adicionaRelacionamento('diamfmin', 'diamfmin');
        $this->adicionaRelacionamento('diamfmax', 'diamfmax');
        $this->adicionaRelacionamento('compmin', 'compmin');
        $this->adicionaRelacionamento('compmax', 'compmax');

        $this->adicionaRelacionamento('diampmin', 'diampmin');
        $this->adicionaRelacionamento('diampmax', 'diampmax');

        $this->adicionaRelacionamento('diamexmin', 'diamexmin');
        $this->adicionaRelacionamento('diamexmax', 'diamexmax');

        $this->adicionaRelacionamento('comprmin', 'comprmin');
        $this->adicionaRelacionamento('comprmax', 'comprmax');

        $this->adicionaRelacionamento('comphmin', 'comphmin');
        $this->adicionaRelacionamento('comphmax', 'comphmax');

        $this->adicionaRelacionamento('diamhmin', 'diamhmin');
        $this->adicionaRelacionamento('diamhmax', 'diamhmax');

        $this->adicionaRelacionamento('anghelice', 'anghelice');

        $this->adicionaRelacionamento('acab', 'acab');
        $this->adicionaRelacionamento('material', 'material');
        $this->adicionaRelacionamento('classe', 'classe');

        $this->adicionaRelacionamento('profcanecomin', 'profcanecomin');
        $this->adicionaRelacionamento('profcanecomax', 'profcanecomax');

        $this->adicionaRelacionamento('tiprosca', 'tiprosca');
        $this->adicionaRelacionamento('normadimen', 'normadimen');
        $this->adicionaRelacionamento('normarosca', 'normarosca');
        $this->adicionaRelacionamento('normapropmec', 'normapropmec');

        $this->adicionaRelacionamento('ppap', 'ppap');
        $this->adicionaRelacionamento('vendaprev', 'vendaprev');
        $this->adicionaRelacionamento('reqcli', 'reqcli');
        $this->adicionaRelacionamento('codresproj', 'codresproj');
        $this->adicionaRelacionamento('respproj', 'respproj');
        $this->adicionaRelacionamento('dataprod', 'dataprod');

        $this->adicionaRelacionamento('dadosent', 'dadosent');
        $this->adicionaRelacionamento('dadosent_obs', 'dadosent_obs');
        $this->adicionaRelacionamento('reqlegal', 'reqlegal');
        $this->adicionaRelacionamento('reqlegal_obs', 'reqlegal_obs');

        $this->adicionaRelacionamento('reqadicional', 'reqadicional');
        $this->adicionaRelacionamento('reqadicional_obs', 'reqadicional_obs');
        $this->adicionaRelacionamento('reqadverif', 'reqadverif');
        $this->adicionaRelacionamento('reqadverif_obs', 'reqadverif_obs');

        $this->adicionaRelacionamento('reqadval', 'reqadval');
        $this->adicionaRelacionamento('reqadval_obs', 'reqadval_obs');

        $this->adicionaRelacionamento('reqproblem', 'reqproblem');
        $this->adicionaRelacionamento('reqproblem_obs', 'reqproblem_obs');

        $this->adicionaRelacionamento('comem', 'comem');

        $this->adicionaRelacionamento('grucod', 'grucod');
        $this->adicionaRelacionamento('subcod', 'subcod');
        $this->adicionaRelacionamento('famcod', 'famcod');
        $this->adicionaRelacionamento('famsub', 'famsub');

        $this->adicionaJoin('EmpRex');
        $this->adicionaOrderBy('nr', 1);
        $this->setSTop('50');

        //$this->adicionaFiltro('sitgeralproj', 'Lib.Cadastro');
    }

    /**
     * Libera código para o representante
     */
    public function liberaCodProj($aDados) {
        $sSql = "update tbqualNovoProjeto set sitgeralproj = 'Cadastrado',
                sitproj = 'Cód. enviado'
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function verifSitProj($aDados) {
        $sSql = "select sitvendas,sitcliente,sitgeralproj,sitproj,dataprod,valOdTer,valPedTer
                from tbqualNovoProjeto 
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRowBD = $result->fetch(PDO::FETCH_OBJ);
        $aRetorno = $oRowBD;

        return $aRetorno;
    }

    public function buscaObs($sCnpj, $sNr) {
        $sSql = "select sol_viavel_obs,fin_obs,obs_geral 
                from tbqualNovoProjeto 
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'   ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aObs['Operacional'] = $oRow->sol_viavel_obs;
        $aObs['Financeiro'] = $oRow->fin_obs;
        $aObs['ObsGeral'] = $oRow->obs_geral;

        return $aObs;
    }

    public function buscaDados($aDados) {
        $sSql = "select nr,tbqualNovoProjeto.empcod,empdes,convert(varchar,dtimp,103)as dtimp,horaimp,
                officedes,repnome,desc_novo_prod,quant_pc,replibobs,resp_venda_nome,acabamento,procod,sitproj
                from tbqualNovoProjeto left outer join 
                widl.EMP01 on tbqualNovoProjeto.empcod = widl.EMP01.empcod
                where  filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    //busca somente e-mail venda e projetos
    public function projEmailVendaProj($sCnpj, $sNr) {
        //busca códigos
        $sSql = "select resp_proj_cod,resp_venda_cod,repcod 
                from tbqualNovoProjeto 
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'   ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        foreach ($oRow as $key => $sCod) {
            $sSql = "select usuemail from tbusuario where usucodigo ='" . $sCod . "' ";
            $result = $this->getObjetoSql($sSql);
            $oCodigo = $result->fetch(PDO::FETCH_OBJ);
            $aEmail[] = $oCodigo->usuemail;
        }

        return $aEmail;
    }

    public function buscaSitCli($sDados) {
        $sSql = "select sitcliente from tbqualNovoProjeto where nr='" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow->sitcliente;
    }

    public function getCadDim($sDados) {
        $sSql = "select prodacab,promatcod,ProClasseG ,ProAngHel,"
                . " prodchamin,prodchamax,prodaltmin,prodaltmax,proddiamin,proddiamax,procommin,procommax,prodiapmin,prodiapmax,"
                . "prodiaemin,prodiaemax,procomrmin,procomrmax,comphastma,comphastmi,DiamHastMi,DiamHastMa ,pfcmin, pfcmax"
                . " from widl.prod01 where procod = '" . $sDados . "'";
        $oObj = $this->consultaSql($sSql);
        return $oObj;
    }

    public function insertCadDim() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        /*
         * Busca dados inseridos na tabela tbqualNovoProjeto para cadastro dimensional Sistema_Metalbo/Delsoft
         * * */
        $sSql = "select procod,desc_novo_prod,acab,material,classe,anghelice,"
                . "chavemin,chavemax,altmin,altmax,diamfmin,diamfmax,compmin,compmax,diampmin,diampmax,"
                . "diamexmin,diamexmax,comprmin,comprmax,comphmin,comphmax,diamhmin,diamhmax,profcanecomin,profcanecomax"
                . " from tbqualNovoProjeto"
                . " WHERE procod =" . $aCampos['procod'];

        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////   

        /*
         * Update valores na PROD01
         * * */
        $sSqlInsert = "update WIDL.PROD01 set "
                . "prodacab ='" . $oRow->acab . "',promatcod='" . $oRow->material . "',ProClasseG ='" . $oRow->classe . "',ProAngHel='" . $oRow->anghelice . "',"
                . "prodchamin='" . $oRow->chavemin . "',prodchamax='" . $oRow->chavemax . "',prodaltmin='" . $oRow->altmin . "',prodaltmax='" . $oRow->altmax . "',proddiamin='" . $oRow->diamfmin . "',"
                . "proddiamax='" . $oRow->diamfmax . "',procommin='" . $oRow->compmin . "',procommax='" . $oRow->compmax . "',prodiapmin='" . $oRow->diampmin . "',prodiapmax='" . $oRow->diampmax . "',"
                . "prodiaemin='" . $oRow->diamexmin . "',prodiaemax='" . $oRow->diamexmax . "',procomrmin='" . $oRow->comprmin . "',procomrmax='" . $oRow->comprmax . "',comphastma='" . $oRow->comphmax . "',comphastmi='" . $oRow->comphmin . "',"
                . "DiamHastMi='" . $oRow->diamhmin . "',DiamHastMa ='" . $oRow->diamhmax . "',pfcmin='" . $oRow->profcanecomin . "', pfcmax='" . $oRow->profcanecomax . "' "
                . "where procod = '" . $oRow->procod . "'";
        $aRetorno = $this->executaSql($sSqlInsert);

        return $aRetorno;
    }

}
