<?php

/*
 * Implementa a classe ModelQualNovoProjVenda
 * 
 * @author Avanei Martendal
 * @since 09/08/2017
 * 
 */

class ModelQualNovoProjVenda {

    private $EmpRex;
    private $nr;
    private $Pessoa;
    private $resp_proj_cod;
    private $resp_proj_nome;
    private $dtimp;
    private $horaimp;
    private $resp_venda_cod;
    private $resp_venda_nome;
    private $emailCli;
    private $desc_novo_prod;
    private $quant_pc;
    private $anexo1;
    private $anexo2;
    private $anexo3;
    private $equip_corresp;
    private $equip_corresp_evid;
    private $mat_prima;
    private $mat_prima_evid;
    private $estudo_proc;
    private $estudo_proc_evid;
    private $prod_sim;
    private $prod_sim_evid;
    private $desen_ferram;
    private $desen_ferram_evid;
    private $sol_viavel;
    private $sol_viavel_obs;
    private $vlrDesenProj;
    private $vlrFerramen;
    private $vlrMatPrima;
    private $vlrAcabSuper;
    private $vlrTratTer;
    private $vlrCustProd;
    private $sol_viavel_fin;
    private $fin_obs;
    private $lotemin;
    private $pesoct;
    private $sitproj;
    private $sitcliente;
    private $sitvendas;
    private $obs_geral;
    private $sitgeralproj;
    private $precofinal;
    private $prazoentrega;
    private $obsvenda;
    private $dtenvprop;
    private $horaenvprop;
    private $userenvprop;
    private $dtaprovaproj;
    private $horaaprovproj;
    private $useraprovproj;
    private $dtareprovcli;
    private $horareprovcli;
    private $userreprovcli;
    private $obsreprovcli;
    private $dtaprovcli;
    private $horaprovcli;
    private $useraprovcli;
    private $obsaprovcli;
    private $officedes;
    private $repnome;
    private $repcod;
    private $replibobs;
    private $acabamento;
    private $prazoentregautil;
    private $usuaprovaoperacional;
    private $dtaprovaoperacional;
    private $usuaprovafinanceiro;
    private $dtaprovafinanceiro;

    function getUsuaprovaoperacional() {
        return $this->usuaprovaoperacional;
    }

    function getDtaprovaoperacional() {
        return $this->dtaprovaoperacional;
    }

    function getUsuaprovafinanceiro() {
        return $this->usuaprovafinanceiro;
    }

    function getDtaprovafinanceiro() {
        return $this->dtaprovafinanceiro;
    }

    function setUsuaprovaoperacional($usuaprovaoperacional) {
        $this->usuaprovaoperacional = $usuaprovaoperacional;
    }

    function setDtaprovaoperacional($dtaprovaoperacional) {
        $this->dtaprovaoperacional = $dtaprovaoperacional;
    }

    function setUsuaprovafinanceiro($usuaprovafinanceiro) {
        $this->usuaprovafinanceiro = $usuaprovafinanceiro;
    }

    function setDtaprovafinanceiro($dtaprovafinanceiro) {
        $this->dtaprovafinanceiro = $dtaprovafinanceiro;
    }

    function getPrazoentregautil() {
        return $this->prazoentregautil;
    }

    function setPrazoentregautil($prazoentregautil) {
        $this->prazoentregautil = $prazoentregautil;
    }

    function getAcabamento() {
        return $this->acabamento;
    }

    function setAcabamento($acabamento) {
        $this->acabamento = $acabamento;
    }

    function getReplibobs() {
        return $this->replibobs;
    }

    function setReplibobs($replibobs) {
        $this->replibobs = $replibobs;
    }

    function getRepcod() {
        return $this->repcod;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

    function getRepnome() {
        return $this->repnome;
    }

    function setRepnome($repnome) {
        $this->repnome = $repnome;
    }

    function getOfficedes() {
        return $this->officedes;
    }

    function setOfficedes($officedes) {
        $this->officedes = $officedes;
    }

    function getSitvendas() {
        return $this->sitvendas;
    }

    function setSitvendas($sitvendas) {
        $this->sitvendas = $sitvendas;
    }

    function getAnexo1() {
        return $this->anexo1;
    }

    function getAnexo2() {
        return $this->anexo2;
    }

    function getAnexo3() {
        return $this->anexo3;
    }

    function setAnexo1($anexo1) {
        $this->anexo1 = $anexo1;
    }

    function setAnexo2($anexo2) {
        $this->anexo2 = $anexo2;
    }

    function setAnexo3($anexo3) {
        $this->anexo3 = $anexo3;
    }

    function getDtaprovcli() {
        return $this->dtaprovcli;
    }

    function getHoraprovcli() {
        return $this->horaprovcli;
    }

    function getUseraprovcli() {
        return $this->useraprovcli;
    }

    function getObsaprovcli() {
        return $this->obsaprovcli;
    }

    function setDtaprovcli($dtaprovcli) {
        $this->dtaprovcli = $dtaprovcli;
    }

    function setHoraprovcli($horaprovcli) {
        $this->horaprovcli = $horaprovcli;
    }

    function setUseraprovcli($useraprovcli) {
        $this->useraprovcli = $useraprovcli;
    }

    function setObsaprovcli($obsaprovcli) {
        $this->obsaprovcli = $obsaprovcli;
    }

    function getDtareprovcli() {
        return $this->dtareprovcli;
    }

    function getHorareprovcli() {
        return $this->horareprovcli;
    }

    function getUserreprovcli() {
        return $this->userreprovcli;
    }

    function getObsreprovcli() {
        return $this->obsreprovcli;
    }

    function setDtareprovcli($dtareprovcli) {
        $this->dtareprovcli = $dtareprovcli;
    }

    function setHorareprovcli($horareprovcli) {
        $this->horareprovcli = $horareprovcli;
    }

    function setUserreprovcli($userreprovcli) {
        $this->userreprovcli = $userreprovcli;
    }

    function setObsreprovcli($obsreprovcli) {
        $this->obsreprovcli = $obsreprovcli;
    }

    function getDtaprovaproj() {
        return $this->dtaprovaproj;
    }

    function getHoraaprovproj() {
        return $this->horaaprovproj;
    }

    function getUseraprovproj() {
        return $this->useraprovproj;
    }

    function setDtaprovaproj($dtaprovaproj) {
        $this->dtaprovaproj = $dtaprovaproj;
    }

    function setHoraaprovproj($horaaprovproj) {
        $this->horaaprovproj = $horaaprovproj;
    }

    function setUseraprovproj($useraprovproj) {
        $this->useraprovproj = $useraprovproj;
    }

    function getUserenvprop() {
        return $this->userenvprop;
    }

    function setUserenvprop($userenvprop) {
        $this->userenvprop = $userenvprop;
    }

    function getHoraenvprop() {
        return $this->horaenvprop;
    }

    function setHoraenvprop($horaenvprop) {
        $this->horaenvprop = $horaenvprop;
    }

    function getDtenvprop() {
        return $this->dtenvprop;
    }

    function setDtenvprop($dtenvprop) {
        $this->dtenvprop = $dtenvprop;
    }

    function getObsvenda() {
        return $this->obsvenda;
    }

    function setObsvenda($obsvenda) {
        $this->obsvenda = $obsvenda;
    }

    function getPrazoentrega() {
        return $this->prazoentrega;
    }

    function setPrazoentrega($prazoentrega) {
        $this->prazoentrega = $prazoentrega;
    }

    function getPrecofinal() {
        return $this->precofinal;
    }

    function setPrecofinal($precofinal) {
        $this->precofinal = $precofinal;
    }

    function getSitgeralproj() {
        return $this->sitgeralproj;
    }

    function setSitgeralproj($sitgeralproj) {
        $this->sitgeralproj = $sitgeralproj;
    }

    function getObs_geral() {
        return $this->obs_geral;
    }

    function setObs_geral($obs_geral) {
        $this->obs_geral = $obs_geral;
    }

    function getSitcliente() {
        return $this->sitcliente;
    }

    function setSitcliente($sitcliente) {
        $this->sitcliente = $sitcliente;
    }

    function getSitproj() {
        return $this->sitproj;
    }

    function setSitproj($sitproj) {
        $this->sitproj = $sitproj;
    }

    function getSol_viavel_fin() {
        return $this->sol_viavel_fin;
    }

    function getFin_obs() {
        return $this->fin_obs;
    }

    function getLotemin() {
        return $this->lotemin;
    }

    function getPesoct() {
        return $this->pesoct;
    }

    function setSol_viavel_fin($sol_viavel_fin) {
        $this->sol_viavel_fin = $sol_viavel_fin;
    }

    function setFin_obs($fin_obs) {
        $this->fin_obs = $fin_obs;
    }

    function setLotemin($lotemin) {
        $this->lotemin = $lotemin;
    }

    function setPesoct($pesoct) {
        $this->pesoct = $pesoct;
    }

    function getVlrCustProd() {
        return $this->vlrCustProd;
    }

    function setVlrCustProd($vlrCustProd) {
        $this->vlrCustProd = $vlrCustProd;
    }

    function getVlrTratTer() {
        return $this->vlrTratTer;
    }

    function setVlrTratTer($vlrTratTer) {
        $this->vlrTratTer = $vlrTratTer;
    }

    function getVlrAcabSuper() {
        return $this->vlrAcabSuper;
    }

    function setVlrAcabSuper($vlrAcabSuper) {
        $this->vlrAcabSuper = $vlrAcabSuper;
    }

    function getVlrMatPrima() {
        return $this->vlrMatPrima;
    }

    function setVlrMatPrima($vlrMatPrima) {
        $this->vlrMatPrima = $vlrMatPrima;
    }

    function getVlrFerramen() {
        return $this->vlrFerramen;
    }

    function setVlrFerramen($vlrFerramen) {
        $this->vlrFerramen = $vlrFerramen;
    }

    function getVlrDesenProj() {
        return $this->vlrDesenProj;
    }

    function setVlrDesenProj($vlrDesenProj) {
        $this->vlrDesenProj = $vlrDesenProj;
    }

    function getSol_viavel_obs() {
        return $this->sol_viavel_obs;
    }

    function setSol_viavel_obs($sol_viavel_obs) {
        $this->sol_viavel_obs = $sol_viavel_obs;
    }

    function getSol_viavel() {
        return $this->sol_viavel;
    }

    function setSol_viavel($sol_viavel) {
        $this->sol_viavel = $sol_viavel;
    }

    function getDesen_ferram_evid() {
        return $this->desen_ferram_evid;
    }

    function setDesen_ferram_evid($desen_ferram_evid) {
        $this->desen_ferram_evid = $desen_ferram_evid;
    }

    function getDesen_ferram() {
        return $this->desen_ferram;
    }

    function setDesen_ferram($desen_ferram) {
        $this->desen_ferram = $desen_ferram;
    }

    function getProd_sim_evid() {
        return $this->prod_sim_evid;
    }

    function setProd_sim_evid($prod_sim_evid) {
        $this->prod_sim_evid = $prod_sim_evid;
    }

    function getProd_sim() {
        return $this->prod_sim;
    }

    function setProd_sim($prod_sim) {
        $this->prod_sim = $prod_sim;
    }

    function getEstudo_proc_evid() {
        return $this->estudo_proc_evid;
    }

    function setEstudo_proc_evid($estudo_proc_evid) {
        $this->estudo_proc_evid = $estudo_proc_evid;
    }

    function getEstudo_proc() {
        return $this->estudo_proc;
    }

    function setEstudo_proc($estudo_proc) {
        $this->estudo_proc = $estudo_proc;
    }

    function getMat_prima_evid() {
        return $this->mat_prima_evid;
    }

    function setMat_prima_evid($mat_prima_evid) {
        $this->mat_prima_evid = $mat_prima_evid;
    }

    function getMat_prima() {
        return $this->mat_prima;
    }

    function setMat_prima($mat_prima) {
        $this->mat_prima = $mat_prima;
    }

    function getEquip_corresp_evid() {
        return $this->equip_corresp_evid;
    }

    function setEquip_corresp_evid($equip_corresp_evid) {
        $this->equip_corresp_evid = $equip_corresp_evid;
    }

    function getEquip_corresp() {
        return $this->equip_corresp;
    }

    function setEquip_corresp($equip_corresp) {
        $this->equip_corresp = $equip_corresp;
    }

    function getQuant_pc() {
        return $this->quant_pc;
    }

    function setQuant_pc($quant_pc) {
        $this->quant_pc = $quant_pc;
    }

    function getDesc_novo_prod() {
        return $this->desc_novo_prod;
    }

    function setDesc_novo_prod($desc_novo_prod) {
        $this->desc_novo_prod = $desc_novo_prod;
    }

    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    function getEmailCli() {
        return $this->emailCli;
    }

    function setEmailCli($emailCli) {
        $this->emailCli = $emailCli;
    }

    function getResp_venda_cod() {
        return $this->resp_venda_cod;
    }

    function getResp_venda_nome() {
        return $this->resp_venda_nome;
    }

    function setResp_venda_cod($resp_venda_cod) {
        $this->resp_venda_cod = $resp_venda_cod;
    }

    function setResp_venda_nome($resp_venda_nome) {
        $this->resp_venda_nome = $resp_venda_nome;
    }

    function getDtimp() {
        return $this->dtimp;
    }

    function setDtimp($dtimp) {
        $this->dtimp = $dtimp;
    }

    function getHoraimp() {
        return $this->horaimp;
    }

    function setHoraimp($horaimp) {
        $this->horaimp = $horaimp;
    }

    function getEmpRex() {
        if (!isset($this->EmpRex)) {
            $this->EmpRex = Fabrica::FabricarModel('EmpRex');
        }

        return $this->EmpRex;
    }

    function setEmpRex($EmpRex) {
        $this->EmpRex = $EmpRex;
    }

    function getNr() {
        return $this->nr;
    }

    function getResp_proj_cod() {
        return $this->resp_proj_cod;
    }

    function getResp_proj_nome() {
        return $this->resp_proj_nome;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setResp_proj_cod($resp_proj_cod) {
        $this->resp_proj_cod = $resp_proj_cod;
    }

    function setResp_proj_nome($resp_proj_nome) {
        $this->resp_proj_nome = $resp_proj_nome;
    }

}
