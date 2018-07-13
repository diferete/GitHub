<?php

/*
 * Implementa a persistencia da classe QualNovoProj
 * @autor Avanei Martenda
 * @since 01/06/2017
 */

class PersistenciaQualNovoProj extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbqualNovoProjeto');

        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('empcod', 'Pessoa.empcod');
        $this->adicionaRelacionamento('resp_proj_cod', 'resp_proj_cod');
        $this->adicionaRelacionamento('resp_proj_nome', 'resp_proj_nome');
        $this->adicionaRelacionamento('dtimp', 'dtimp');
        $this->adicionaRelacionamento('horaimp', 'horaimp');
        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');
        $this->adicionaRelacionamento('emailCli', 'emailCli');
        $this->adicionaRelacionamento('desc_novo_prod', 'desc_novo_prod');
        $this->adicionaRelacionamento('quant_pc', 'quant_pc');

        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('anexo3', 'anexo3');

        $this->adicionaRelacionamento('equip_corresp', 'equip_corresp');
        $this->adicionaRelacionamento('equip_corresp_evid', 'equip_corresp_evid');
        $this->adicionaRelacionamento('mat_prima', 'mat_prima');
        $this->adicionaRelacionamento('mat_prima_evid', 'mat_prima_evid');
        $this->adicionaRelacionamento('estudo_proc', 'estudo_proc');
        $this->adicionaRelacionamento('estudo_proc_evid', 'estudo_proc_evid');
        $this->adicionaRelacionamento('prod_sim', 'prod_sim');
        $this->adicionaRelacionamento('prod_sim_evid', 'prod_sim_evid');
        $this->adicionaRelacionamento('desen_ferram', 'desen_ferram');
        $this->adicionaRelacionamento('desen_ferram_evid', 'desen_ferram_evid');
        $this->adicionaRelacionamento('sol_viavel', 'sol_viavel');
        $this->adicionaRelacionamento('sol_viavel_obs', 'sol_viavel_obs');
        $this->adicionaRelacionamento('vlrDesenProj', 'vlrDesenProj');
        $this->adicionaRelacionamento('vlrFerramen', 'vlrFerramen');
        $this->adicionaRelacionamento('vlrMatPrima', 'vlrMatPrima');
        $this->adicionaRelacionamento('vlrAcabSuper', 'vlrAcabSuper');
        $this->adicionaRelacionamento('vlrTratTer', 'vlrTratTer');
        $this->adicionaRelacionamento('vlrCustProd', 'vlrCustProd');
        $this->adicionaRelacionamento('sol_viavel_fin', 'sol_viavel_fin');
        $this->adicionaRelacionamento('fin_obs', 'fin_obs');
        $this->adicionaRelacionamento('lotemin', 'lotemin');
        $this->adicionaRelacionamento('pesoct', 'pesoct');

        $this->adicionaRelacionamento('sitproj', 'sitproj');
        $this->adicionaRelacionamento('sitvendas', 'sitvendas');

        $this->adicionaRelacionamento('sitcliente', 'sitcliente');

        $this->adicionaRelacionamento('obs_geral', 'obs_geral');
        $this->adicionaRelacionamento('sitgeralproj', 'sitgeralproj');

        $this->adicionaRelacionamento('precofinal', 'precofinal');
        $this->adicionaRelacionamento('prazoentrega', 'prazoentrega');
        $this->adicionaRelacionamento('prazoentregautil', 'prazoentregautil');
        $this->adicionaRelacionamento('obsvenda', 'obsvenda');

        $this->adicionaRelacionamento('dtenvprop', 'dtenvprop');
        $this->adicionaRelacionamento('horaenvprop', 'horaenvprop');
        $this->adicionaRelacionamento('userenvprop', 'userenvprop');

        $this->adicionaRelacionamento('dtaprovaproj', 'dtaprovaproj');
        $this->adicionaRelacionamento('horaaprovproj', 'horaaprovproj');
        $this->adicionaRelacionamento('useraprovproj', 'useraprovproj');

        $this->adicionaRelacionamento('dtareprovcli', 'dtareprovcli');
        $this->adicionaRelacionamento('horareprovcli', 'horareprovcli');
        $this->adicionaRelacionamento('userreprovcli', 'userreprovcli');
        $this->adicionaRelacionamento('obsreprovcli', 'obsreprovcli');

        $this->adicionaRelacionamento('dtaprovcli', 'dtaprovcli');
        $this->adicionaRelacionamento('horaprovcli', 'horaprovcli');
        $this->adicionaRelacionamento('useraprovcli', 'useraprovcli');
        $this->adicionaRelacionamento('obsaprovcli', 'obsaprovcli');
        $this->adicionaRelacionamento('officedes', 'officedes');

        $this->adicionaRelacionamento('repnome', 'repnome');
        $this->adicionaRelacionamento('repcod', 'repcod');
        $this->adicionaRelacionamento('replibobs', 'replibobs');
        $this->adicionaRelacionamento('acabamento', 'acabamento');


        //$this->adicionaFiltro('sitgeralproj', 'Representante',0, Persistencia::DIFERENTE);


        $this->adicionaJoin('Pessoa');
        $this->adicionaJoin('EmpRex');
        $this->adicionaOrderBy('nr', 1);

        $this->setSTop('500');
    }

    /**
     * vai validar se um projeto já está aprovado para não haver reaprovação
     * @param type $aDados
     */
    public function validaProjAprov($aDados) {
        $sSql = "select sitproj from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sSitProj = $oRow->sitproj;

        if ($sSitProj == 'Aprovado') {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Valida se ao aprovar o projeto foram apontados obs,peso,lote
     * @param type $aDados
     */
    public function validaObsPesoCt($aDados) {
        $sSql = "select obs_geral,lotemin,pesoct from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $obs = $oRow->obs_geral;
        $lote = $oRow->lotemin;
        $peso = $oRow->pesoct;

        $aResultado = array();
        $aResultado[0] = true;
        $aResultado[1] = '';
        if ($obs == '' || $obs == null) {
            $aResultado[0] = false;
            $aResultado[1] .= 'Campo observação final do projeto não foi apontado. ';
        }

        if ($lote == '.000' || $lote == null) {
            $aResultado[0] = false;
            $aResultado[1] .= 'Campo lote não foi apontado. ';
        }

        if ($peso == '.000' || $peso == null) {
            $aResultado[0] = false;
            $aResultado[1] .= 'Campo peso não foi apontado. ';
        }

        return $aResultado;
    }

    /**
     * Valida se ao reprovar foi apontado a observação
     * @param type $aDados
     */
    public function validaObsRep($aDados) {
        $sSql = "select obs_geral,lotemin,pesoct from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $obs = $oRow->obs_geral;
        $lote = $oRow->lotemin;
        $peso = $oRow->pesoct;

        $aResultado = array();
        $aResultado[0] = true;
        $aResultado[1] = '';
        if ($obs == '' || $obs == null) {
            $aResultado[0] = false;
            $aResultado[1] .= 'Campo observação final do projeto não foi apontado. ';
        }

        return $aResultado;
    }

    public function liberaProj($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');
        $sSql = "update tbqualNovoProjeto set sitproj = 'Aprovado',
                sitgeralproj='Em execução',sitvendas = 'Aguardando',
                dtaprovaproj ='" . $sData . "',horaaprovproj ='" . $sHora . "',
                useraprovproj='" . $_SESSION['nome'] . "' 
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function reprovaProj($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');
        $sSql = "update tbqualNovoProjeto set sitproj = 'Reprovado',sitgeralproj='Reprovado',
        dtareprovproj ='" . $sData . "',horareprovproj ='" . $sHora . "',
        userreprovproj='" . $_SESSION['nome'] . "',dtafimProj='" . $sData . "', horafimProj='" . $sHora . "', "
                . "userfimProj='" . $_SESSION['nome'] . "'  "
                . " where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr ='" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function projEmail($sCnpj, $sNr) {
        //busca códigos
        $sSql = "select resp_proj_cod,resp_venda_cod,repcod 
                from tbqualNovoProjeto 
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'   ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codProj = $oRow->resp_proj_cod;
        $codVenda = $oRow->resp_venda_cod;
        $repcod = $oRow->repcod;

        //busca email projetos

        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codProj . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['proj'] = $oRow->usuemail;

        //busca email venda
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;

        //busca email representante
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $repcod . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['rep'] = $oRow->usuemail;

        return $aEmail;
    }

    //busca somente e-mail venda e projetos
    public function projEmailVendaProj($sCnpj, $sNr) {
        //busca códigos
        $sSql = "select resp_proj_cod,resp_venda_cod,repcod 
                from tbqualNovoProjeto 
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'   ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codProj = $oRow->resp_proj_cod;
        $codVenda = $oRow->resp_venda_cod;
        $repcod = $oRow->repcod;

        //busca email projetos

        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codProj . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['proj'] = $oRow->usuemail;

        //busca email venda
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;


        return $aEmail;
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
                officedes,repnome,desc_novo_prod,quant_pc,replibobs,resp_venda_nome,acabamento
                from tbqualNovoProjeto left outer join 
                widl.EMP01 on tbqualNovoProjeto.empcod = widl.EMP01.empcod
                where  filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    public function buscaCusto($sCnpj, $sNr) {
        $sSql = "select desc_novo_prod,quant_pc,vlrDesenProj,
                vlrFerramen,vlrMatPrima,vlrAcabSuper,
                vlrTratTer,vlrCustProd,obs_geral,lotemin,pesoct
                from tbqualNovoProjeto 
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'  ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmailAprov["VlrProj"] = $oRow->vlrdesenproj;
        $aEmailAprov["VlrFerramen"] = $oRow->vlrferramen;
        $aEmailAprov["VlrMatPrima"] = $oRow->vlrmatprima;
        $aEmailAprov["VlrAcab"] = $oRow->vlracabsuper;
        $aEmailAprov["VlrTrat"] = $oRow->vlrtratter;
        $aEmailAprov["VlrCustoProd"] = $oRow->vlrcustprod;

        $aEmailAprov["TotalCusto"] = ($aEmailAprov["VlrProj"] + $aEmailAprov["VlrFerramen"] + $aEmailAprov["VlrMatPrima"] +
                $aEmailAprov["VlrAcab"] + $aEmailAprov["VlrTrat"] + $aEmailAprov["VlrCustoProd"]);


        //traz para moeda
        $aEmailAprov["VlrProj"] = number_format($aEmailAprov["VlrProj"], 2, ',', '.');
        $aEmailAprov["VlrFerramen"] = number_format($aEmailAprov["VlrFerramen"], 2, ',', '.');
        $aEmailAprov["VlrMatPrima"] = number_format($aEmailAprov["VlrMatPrima"], 2, ',', '.');
        $aEmailAprov["VlrAcab"] = number_format($aEmailAprov["VlrAcab"], 2, ',', '.');
        $aEmailAprov["VlrTrat"] = number_format($aEmailAprov["VlrTrat"], 2, ',', '.');
        $aEmailAprov["VlrCustoProd"] = number_format($aEmailAprov["VlrCustoProd"], 2, ',', '.');

        $aEmailAprov["TotalCusto"] = number_format($aEmailAprov["TotalCusto"], 2, ',', '.');

        $aEmailAprov["descnovo"] = $oRow->desc_novo_prod;
        $aEmailAprov["quant_pc"] = number_format($oRow->quant_pc, 2, ',', '.');
        $aEmailAprov["lote"] = number_format($oRow->lotemin, 2, ',', '.');
        $aEmailAprov["peso"] = number_format($oRow->pesoct, 2, ',', '.');

        return $aEmailAprov;
    }

    /**
     * verifica se o projeto está no setor de projetos
     */
    public function verifProjProj($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitproj in('Lib.Projetos','Aprovado') ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna para o representante
     */
    public function retReprov($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = "update tbqualNovoProjeto 
                set sitgeralproj = 'Representante',
                dtlibrep = null,
                horalibrep = null,
                userlibrep = null,
                dtaprovaproj = null,
                horaaprovproj = null,
                useraprovproj = null,
                sitvendas = null,
                sitproj = null
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaProposta($aDados) {
        $sSql = " select filcgc,nr,tbqualNovoProjeto.empcod,empdes,desc_novo_prod,quant_pc,lotemin,
                 pesoct,precofinal,convert (varchar,prazoentrega,103)as prazoentrega,prazoentregautil,fin_obs,obsreprovcli,acabamento,convert (varchar,dtaprovcli,103)as dtaprovcli,horaprovcli,
                 obs_geral as obs_proj
                 from tbqualNovoProjeto left outer join widl.EMP01
                 on widl.EMP01.empcod = tbqualNovoProjeto.empcod
                 where filcgc ='" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'  ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
    }

}
