<?php

/*
 * Classe para cadastrar os agendamentos 
 * 
 * @data 16/07/2019
 * @Usuário Avanei Martendal 
 */

class PersistenciaMET_TEC_agendamentos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_agendamentos');

        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('titulo', 'titulo');
        $this->adicionaRelacionamento('classe', 'classe');
        $this->adicionaRelacionamento('metodo', 'metodo');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('parametros', 'parametros');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('agendamento', 'agendamento');
        $this->adicionaRelacionamento('intervalominuto', 'intervalominuto');

        $this->adicionaRelacionamento('ultresultado', 'ultresultado');
        $this->adicionaRelacionamento('dtultresultado', 'dtultresultado');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop('200');
    }

    public function getAgendamento() {
        $sSql = "select nr,
                titulo ,
                classe,
                metodo,
                data,
                hora,
                parametros,
                obs,
                agendamento,
                intervalominuto,
                ultresultado,
                dtultresultado,
                horaexec
                from MET_TEC_agendamentos order by nr desc ";

        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $this->getNewModel();

            $oModel->setNr($oRowBD->nr);
            $oModel->setTitulo($oRowBD->titulo);
            $oModel->setClasse($oRowBD->classe);
            $oModel->setMetodo($oRowBD->metodo);
            $oModel->setData($oRowBD->data);
            $oModel->setHora($oRowBD->hora);
            $oModel->setParametros($oRowBD->parametros);
            $oModel->setObs($oRowBD->obs);
            $oModel->setAgendamento($oRowBD->agendamento);
            $oModel->setIntervalominuto($oRowBD->intervalominuto);
            $oModel->setUltresultado($oRowBD->ultresultado);
            $oModel->setDtultresultado($oRowBD->dtultresultado);
            $oModel->setHoraExec($oRowBD->horaexec);


            $aRetorno[] = $oModel;
        }


        return $aRetorno;
    }

    public function setExecutaAgenda($sIdAgenda) {
        //date_default_timezone_set('America/Sao_Paulo');
        $sData = Util::getDataAtual();
        $sHora = date('H:i');

        $sSql = "update MET_TEC_agendamentos 
                    set ultResultado ='Sucesso!',
                    dtultResultado ='" . $sData . "', 
                    horaExec ='" . $sHora . "'
                    where nr =" . $sIdAgenda . "";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    /**
     * Busca dados via select na tabela de entrada de projetos
     * 
     * */
    public function verificaSitEntProj() {
        $sSql = "select sitgeralproj,sitproj,sitcliente,sitvendas,filcgc,nr,desc_novo_prod,dtimp,
                empcod,officedes,repnome,resp_venda_nome,dtaprovendas,
                resp_proj_cod,resp_venda_cod,repcod,emailCli,
                DATEDIFF(day,dtaprovendas,GETDATE())as dias 
                from tbqualNovoProjeto where sitvendas='Aprovado' 
                and  sitgeralproj='Em execução' and sitcliente = 'Aguardando'";
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $oRowBD;
            $aRetorno[] = $oModel;
        }
        return $aRetorno;
    }

    /**
     * Faz update de campos na tabela em caso de tempo projeto expirado sem aprovação do cliente 
     * 
     * */
    public function mudaSitEntProj($oDados) {

        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "update tbqualNovoProjeto 
                set sitgeralproj = 'Expirado',
                sitcliente = 'Expirado',
                userreprovcli = 'Expirado pelo Sistema'  
                where filcgc = '" . $oDados->filcgc . "' and nr = '" . $oDados->nr . "'";
        //$aRet = $this->executaSql($sSql);

        return $aRet;
    }

    /**
     * Busca e-mails na tabela de usuários pelo código 
     */
    public function projEmailVendaProj($oValue) {
        //busca códigos
        $codProj = $oValue->resp_proj_cod;
        $codVenda = $oValue->resp_venda_cod;
        $repcod = $oValue->repcod;

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

        $aEmail['cli'] = $oValue->emailcli;

        return $aEmail;
    }

    public function buscaDataAq() {

        $sSql = "select filcgc,nr,seq,usucodigo,usunome,DATEDIFF(day,dataprev,GETDATE())as dias,convert(varchar,dataprev,103)as data"
                . " from tbacaoqualplan where sitfim is null";
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $oModel = $oRowBD;
            $aRetorno[] = $oModel;
        }

        return $aRetorno;
    }

    public function buscaEmailPlanoAcao($oValue) {

        //busca email
        $sSql = "select usuemail from tbusuario where usucodigo ='" . $oValue->usucodigo . "' ";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $aEmail[] = $oRow->usuemail;

        return $aEmail;
    }

}
