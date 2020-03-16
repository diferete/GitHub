<?php

class PersistenciaQualGerenProj extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbqualNovoProjeto');

        $this->adicionaRelacionamento('filcgc', 'EmpRex.filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('resp_proj_nome', 'resp_proj_nome');
        $this->adicionaRelacionamento('resp_venda_nome', 'resp_venda_nome');
        $this->adicionaRelacionamento('desc_novo_prod', 'desc_novo_prod');
        $this->adicionaRelacionamento('repnome', 'repnome');

        $this->adicionaRelacionamento('repcod', 'repcod');
        $this->adicionaRelacionamento('replibobs', 'replibobs');
        $this->adicionaRelacionamento('quant_pc', 'quant_pc');
        $this->adicionaRelacionamento('empcod', 'Pessoa.empcod');
        $this->adicionaRelacionamento('resp_proj_cod', 'resp_proj_cod');
        $this->adicionaRelacionamento('dtimp', 'dtimp');
        $this->adicionaRelacionamento('horaimp', 'horaimp');
        $this->adicionaRelacionamento('resp_venda_cod', 'resp_venda_cod');
        $this->adicionaRelacionamento('emailCli', 'emailCli');

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
        $this->adicionaRelacionamento('acabamento', 'acabamento');

        //$this->adicionaFiltro('sitgeralproj', 'Representante',0, Persistencia::DIFERENTE);

        $this->adicionaJoin('Pessoa');
        $this->adicionaJoin('EmpRex');
        $this->adicionaOrderBy('nr', 1);

        $this->setSTop('50');
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

}
