<?php

/*
 * Classe que implementa a persistencia da classe QualNovoProjRep
 * 
 * @autor Avanei Martendal
 * @since 26/07/2017
 */

class PersistenciaQualNovoProjRep extends Persistencia {

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
        $this->adicionaRelacionamento('sitproj', 'sitproj');
        $this->adicionaRelacionamento('sitgeralproj', 'sitgeralproj');
        $this->adicionaRelacionamento('officecod', 'officecod');
        $this->adicionaRelacionamento('officedes', 'officedes');
        $this->adicionaRelacionamento('repnome', 'repnome');
        $this->adicionaRelacionamento('emailCli', 'emailCli');
        $this->adicionaRelacionamento('contato', 'contato');
        $this->adicionaRelacionamento('desc_novo_prod', 'desc_novo_prod');
        $this->adicionaRelacionamento('quant_pc', 'quant_pc');

        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('anexo3', 'anexo3');

        $this->adicionaRelacionamento('replibobs', 'replibobs');
        $this->adicionaRelacionamento('sitvendas', 'sitvendas');

        $this->adicionaRelacionamento('repcod', 'repcod');

        $this->adicionaRelacionamento('sitcliente', 'sitcliente');
        $this->adicionaRelacionamento('acabamento', 'acabamento');
        $this->adicionaRelacionamento('grucod', 'grucod');

        $this->adicionaJoin('Pessoa');

        if (isset($_SESSION['repoffice'])) {

            $this->adicionaFiltro('officecod', $_SESSION['repoffice']);
        }

        $this->adicionaOrderBy('nr', 1);

        $this->setSTop(50);
    }

    public function verifSit($aDados) {
        $sSql = "select sitproj,sitvendas,sitcliente,sitgeralproj from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' ";
        $oRow = $this->consultaSql($sSql);
        return $oRow;
    }

    /**
     * Verifica se o projeto foi aprovado tanto por vendas qto por projetos
     * @param type $aDados
     */
    public function verifAprovRep($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitproj = 'Aprovado' and sitvendas = 'Aprovado' ";
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
     * Verifica se o projeto foi aprovado tanto por vendas qto por projetos
     * @param type $aDados
     */
    public function verifReprov($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitcliente in('Reprovado','Aprovado')";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Verifica se o projeto foi aprovado pelo cliente, somente vai reenviar então
     */
    public function verifAprovCliSit($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitcliente = 'Aprovado' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return FALSE;
        } else {
            return true;
        }
    }

    /**
     * Verifica se o projeto foi aprovado tanto por vendas qto por projetos
     * @param type $aDados
     */
    public function verifAprovCli($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitcliente = 'Aprovado' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Verifica se o projeto foi liberado pelo projeto
     * @param type $aDados
     */
    public function verifLibRepProj($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitgeralproj <>'Representante' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return true;
        } else {
            return false;
        }
    }

    //verifica se a entrada já foi aprovada ou reprovada pelo setor de vendas
    public function verifLibProj($aDados) {

        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitproj in ('Lib.Projetos','Reprovado','Aprovado')";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return false;
        } else {
            return true;
        }
    }

    //verifica se a entrada está aprovada
    public function verifLibProjEmail($aDados) {

        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitproj in ('Reprovado','Aprovado')";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return false;
        } else {
            return true;
        }
    }

    //Verifica se o projeto está expirado
    public function verifExpirado($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitgeralproj = 'Expirado'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iSit = $oRow->total;
        if ($iSit == '1') {
            return false;
        } else {
            return true;
        }
    }

    //executa a liberação para projetos
    public function liberaProj($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = "update tbqualNovoProjeto set sitvendas ='',
                sitgeralproj ='Lib.Projetos', sitproj ='Lib.Projetos',
                dtlibrep ='" . $sData . "',
                horalibrep ='" . $sHora . "',
                userlibrep = '" . $_SESSION['nome'] . "'
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    //busca os dados para o envio do projeto para o representante em vendas
    public function buscaDadosEmail($aDados) {
        $sSql = "select nr,tbqualNovoProjeto.empcod,empdes,convert(varchar,dtimp,103)as dtimp,horaimp,
                officedes,repnome,desc_novo_prod,quant_pc,replibobs,resp_venda_nome,acabamento
                from tbqualNovoProjeto left outer join 
                widl.EMP01 on tbqualNovoProjeto.empcod = widl.EMP01.empcod
                where  filcgc = '" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    //busca e-mail de vendas
    public function buscaEmailVenda($aDados) {
        $sSql = "select resp_proj_cod,resp_venda_cod 
                from tbqualNovoProjeto 
                where filcgc ='" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codProj = $oRow->resp_proj_cod;
        $codVenda = $oRow->resp_venda_cod;

        //busca email venda
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codVenda . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['venda'] = $oRow->usuemail;

        return $aEmail;
    }

//busca e-mail projetos
    //busca e-mail de vendas
    public function buscaEmailProjeto($aDados) {
        $sSql = "select resp_proj_cod,resp_venda_cod 
                from tbqualNovoProjeto 
                where filcgc ='" . $aDados['0'] . "' and nr = '" . $aDados['1'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codProj = $oRow->resp_proj_cod;
        $codVenda = $oRow->resp_venda_cod;

        //busca email venda
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codProj . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['projeto'] = $oRow->usuemail;

        return $aEmail;
    }

    //busca e-mail projetos
    //busca e-mail de vendas
    public function buscaEmailProjeto2($aDados) {
        $sSql = "select resp_proj_cod,resp_venda_cod 
                from tbqualNovoProjeto 
                where filcgc ='" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $codProj = $oRow->resp_proj_cod;
        $codVenda = $oRow->resp_venda_cod;

        //busca email venda
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $codProj . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail['projeto'] = $oRow->usuemail;

        return $aEmail;
    }

    /**
     * busca dados para a proposta
     * @param type $aDados
     * @return type
     */
    public function buscaProposta($aDados) {
        $sSql = " select filcgc,nr,tbqualNovoProjeto.empcod,empdes,desc_novo_prod,quant_pc,lotemin,
                 pesoct,precofinal,prazoentregautil,fin_obs,obsreprovcli,acabamento,dtaprovcli,horaprovcli,
                 obs_geral as obs_proj
                 from tbqualNovoProjeto left outer join widl.EMP01
                 on widl.EMP01.empcod = tbqualNovoProjeto.empcod
                 where filcgc ='" . $aDados['EmpRex_filcgc'] . "' and nr = '" . $aDados['nr'] . "'  ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        return $oRow;
    }

    /**
     * grava data e usuário do envio da proposta
     * @param type $aDados
     * @return type
     */
    public function sitenvProposta($aDados) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $bExecuta = $this->verifAprovCliSit($aDados);

        if ($bExecuta) {
            $sSql = "update tbqualNovoProjeto set sitcliente ='Enviado',
                dtenvprop ='" . $sData . "',
                horaenvprop ='" . $sHora . "',
                userenvprop = '" . $_SESSION['nome'] . "'
                where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";
            $aRetorno = $this->executaSql($sSql);
            return $aRetorno;
        } else {
            $aRetorno[0] = TRUE;
        }
    }

    /**
     * Aponta aprovação do cliente
     */
    public function aprovCli($sCnpj, $sNr, $sObs) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = " update tbqualNovoProjeto set  dtaprovcli = '" . $sData . "',
                horaprovcli ='" . $sHora . "', 
                useraprovcli = '" . $_SESSION['nome'] . "',
                obsaprovcli='" . $sObs . "',
                sitcliente ='Aprovado',
                sitgeralproj ='Lib.Cadastro'
                where filcgc = '" . $sCnpj . "' and nr ='" . $sNr . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /**
     * 
     * @param type $sCnpj
     * @param type $sNr
     * @param type $sObs
     * @return type
     */
    public function reprovCli($sCnpj, $sNr, $sObs) {
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');

        $sSql = " update tbqualNovoProjeto set  dtareprovcli = '" . $sData . "',
                horareprovcli ='" . $sHora . "', 
                userreprovcli = '" . $_SESSION['nome'] . "',
                obsreprovcli='" . $sObs . "',
                sitcliente ='Reprovado',
                sitgeralproj ='Reprovado',
                dtafimProj = '" . $sData . "',
                horafimProj = '" . $sHora . "',
                userfimProj = '" . $_SESSION['nome'] . "'
                where filcgc = '" . $sCnpj . "' and nr ='" . $sNr . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    /*
     * [dtafimProj] [date] NULL,
      [horafimProj] [time](7) NULL,
      [userfimProj] [varchar](80) NULL,
     */

    public function verifLibCad($sCnpj, $sNr, $sObs) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitgeralproj ='Lib.Projetos'";

        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iTotal = $oRow->total;

        if ($iTotal == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifica se já está liberado o cadastro
     */
    public function verifLibCadastro($aDados) {
        $sSql = "select count(*)as total from tbqualNovoProjeto where filcgc = '" . $aDados['EmpRex_filcgc'] . "' "
                . "and nr = '" . $aDados['nr'] . "' and sitgeralproj ='Lib.Cadastro'";

        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $iTotal = $oRow->total;

        if ($iTotal == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifica situaçao para liberar retorno para o cliente
     */
    public function verifAprovVendaProj($aDados) {

        $sSql = "select sitproj,sitvendas 
	from tbqualNovoProjeto
	 where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";
        $resul = $this->getObjetoSql($sSql);
        $oRow = $resul->fetch(PDO::FETCH_OBJ);
        $sVendas = $oRow->sitvendas;
        $sProj = $oRow->sitproj;

        $aRetorno = array();
        if ($sVendas == 'Aprovado') {
            $aRetorno[0] = true;
        } else {
            $aRetorno[0] = false;
        }
        if ($aRetorno[0] == true) {
            if ($sProj == 'Aprovado') {
                $aRetorno[0] = true;
            } else {
                $aRetorno[0] = false;
            }

            return $aRetorno;
        } else {
            return $aRetorno;
        }
    }

    /**
     * Verifica se a solicitacao está aprovada pelo cliente, se está nao pode retornar
     */
    public function veriAprovCli($aDados) {
        $sSql = "select sitcliente
	from tbqualNovoProjeto
	 where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";
        $resul = $this->getObjetoSql($sSql);
        $oRow = $resul->fetch(PDO::FETCH_OBJ);
        $sCli = $oRow->sitcliente;

        if ($sCli == 'Aprovado') {
            return false;
        } else {
            return true;
        }

        /**
         * retorna a situação
         */
    }

    public function retornaAprovCli($aDados) {
        $sSql = "update tbqualNovoProjeto set 
	    dtareprovcli = null,
	    horareprovcli = null,
            userreprovcli = null,
	    obsreprovcli = null,
            dtaprovcli = null,
            horaprovcli = null,
            useraprovcli = null,
            obsaprovcli = null,
            sitcliente = 'Aguardando',
            dtafimProj = null,
            horafimProj = null,
            userfimProj = null,
            sitgeralproj = 'Em execução' 
            where filcgc = '" . $aDados['EmpRex_filcgc'] . "'
                and nr = '" . $aDados['nr'] . "'";

        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaRespEscritório($sDados) {
        $sSql = "select officeresp from tbrepoffice where officecod =" . $_SESSION['repoffice'];
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sCodResp = $oRow->officeresp;


        $sSql = "select usucodigo,usunome from tbusuario where usucodigo =" . $sCodResp;
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->usucodigo;
        $aRetorno[1] = $oRow->usunome;

        return $aRetorno;
    }

    public function buscaRespVenda($sDados) {
        $sSql = "select resp_venda_cod,resp_venda_nome"
                . " from tbrepcodoffice"
                . " where repcod = '" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        $aRetorno[0] = $oRow->resp_venda_cod;
        $aRetorno[1] = $oRow->resp_venda_nome;

        return $aRetorno;
    }

}
