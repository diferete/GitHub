<?php

/*
 * Implementa a persistencia da classe QualNovoProjVenda
 * @author Avanei Martendal
 * @since 09/08/2017
 */

class PersistenciaQualNovoProjVenda extends Persistencia {

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

        $this->adicionaFiltro('sitproj', 'Aprovado', Persistencia::LIGACAO_AND, Persistencia::ENTRE, 'Cód. enviado');


        $this->adicionaJoin('Pessoa');
        $this->adicionaJoin('EmpRex');
        $this->adicionaOrderBy('nr', 1);

        $this->setSTop('50');
    }

    public function verifProjProjVenda($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitvendas='Aprovado' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function verifProjRep($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitcliente ='Aprovado' ";
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
     * Método que verifica se um projeto está com as informações comerciais
     * 
     * @param type $sCnpj informa o cnpj do cliente
     * @param type $sNr informa o nr do projeto
     * @return boolean returna um booleano
     */
    public function verifInfCom($sCnpj, $sNr) {
        $sSql = "select prazoentregautil,precofinal from tbqualNovoProjeto where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sData = $oRow->prazoentregautil;
        $sPreco = $oRow->precofinal;

        if ($sData == null || $sPreco == null || $sPreco == '0,00') {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Verifica situação de vendas
     * @param type $sCnpj
     * @param type $sNr
     * @return boolean
     */
    public function verifSituacao($sCnpj, $sNr) {
        $sSql = "select sitvendas from tbqualNovoProjeto where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sSitVendas = $oRow->sitvendas;
        
        if ($sSitVendas == 'Aprovado') {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Verifica situação de cliente
     * @param type $sCnpj
     * @param type $sNr
     * @return boolean
     */
    public function verifSituacao2($sCnpj, $sNr) {
        $sSql = "select sitcliente from tbqualNovoProjeto where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sSitCliente = $oRow->sitcliente;
        
        if ($sSitCliente == 'Aguardando') {
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * Aprova o projeto em vendas
     * @param type $aDados monta a chave primária
     * @return type valor booleano do estatus do update
     */
    public function aprovaVendaProj($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');
        $sSql = "update tbqualNovoProjeto set sitvendas = 'Aprovado', 
                sitcliente = 'Aguardando',
                dtaprovendas = '" . $sData . "',
                horaaprovendas = '" . $sHora . "',
                useraprovendas = '" . $_SESSION['nome'] . "' 
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /**
     * busca os dados para montar um e-mail para o representante com os va
     * @param type $sCnpj
     * @param type $sNr
     * @return type um objeto com os dados 
     */
    public function buscaDadosEmailRep($sCnpj, $sNr) {
        $sSql = " select tbqualNovoProjeto.empcod,empdes,convert(varchar,dtimp,103)as dtimp,
                resp_proj_nome,resp_venda_cod,
                desc_novo_prod,quant_pc,lotemin,acabamento,
                pesoct,precofinal,prazoentregautil
                from tbqualNovoProjeto left outer join widl.EMP01
                on widl.EMP01.empcod = tbqualNovoProjeto.empcod
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'  ";



        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    /**
     * busca e-mails representante
     * @param type $sCnpj
     * @param type $sNr
     * @return type
     */
    public function emailRep($sCnpj, $sNr) {
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

    /**
     * retorna para projetos
     */

    /**
     * Retorna para o representante
     */
    public function retProjetos($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = "update tbqualNovoProjeto 
                set sitgeralproj = 'Lib.Projetos',
                dtaprovaproj = null,
                horaaprovproj = null,
                useraprovproj = null,
                sitvendas = null,
                sitproj = 'Lib.Projetos'
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /**
     * Reprova um projeto
     */
    public function reprovaProj($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');
        $sSql = "update tbqualNovoProjeto set sitgeralproj='Reprovado',sitvendas ='Reprovado',
        dtreprovendas ='" . $sData . "',horareprovendas ='" . $sHora . "',
        userreprovendas='" . $_SESSION['nome'] . "',dtafimProj='" . $sData . "', horafimProj='" . $sHora . "', "
                . "userfimProj='" . $_SESSION['nome'] . "'  "
                . " where filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr ='" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /**
     * busca e-mails 
     */
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

    public function buscaObs($sCnpj, $sNr) {
        $sSql = "select sol_viavel_obs,fin_obs,obs_geral,obsvenda
                from tbqualNovoProjeto 
                where filcgc ='" . $sCnpj . "' and nr ='" . $sNr . "'   ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aObs['Operacional'] = $oRow->sol_viavel_obs;
        $aObs['Financeiro'] = $oRow->fin_obs;
        $aObs['ObsGeral'] = $oRow->obs_geral;
        $aObs['ObsVenda'] = $oRow->obsvenda;

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

}
