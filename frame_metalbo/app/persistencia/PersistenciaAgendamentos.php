<?php

/*
 * Classe para gerenciar Agendamentos de rotinas no sistema
 * 
 * @author Alexandre W. de Souza
 * @since 05-02-2018
 */

class PersistenciaAgendamentos extends Persistencia {

    public function __construct() {
    }

    /**
     * Busca dados via select na tabela de entrada de projetos
     * 
     **/
    public function verificaSitEntProj() {
        $sSql = "select sitgeralproj,sitproj,sitcliente,sitvendas,filcgc,nr,desc_novo_prod,dtimp,
                empcod,officedes,repnome,resp_venda_nome,dtaprovendas,
                resp_proj_cod,resp_venda_cod,repcod,emailCli,
                DATEDIFF(day,dtaprovendas,GETDATE())as dias 
                from tbqualNovoProjeto where sitvendas='Aprovado' 
                and  sitgeralproj='Em execução' and sitcliente <> 'Aprovado'";
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
    public function mudaSitEntProj($aDados) {
        $iDias = 0;
        foreach ($aDados as $iKey => $oValue) {

            $iDias = $oValue->dias;
            $sFilcgc = $oValue->filcgc;
            $iNr = $oValue->nr;

            if ($iDias >= 60) {
                date_default_timezone_set('America/Sao_Paulo');
                $sSql = "update tbqualNovoProjeto 
                set sitgeralproj = 'Expirado',
                sitcliente = 'Expirado',
                userreprovcli = 'Expirado pelo Sistema'  
                where filcgc = '" . $sFilcgc . "' and nr = '" . $iNr . "'";
                $aRetorno = $this->executaSql($sSql);

                //chamar funcao do envio email
                if ($aRetorno[0]) {
                    $oAgenda = Fabrica::FabricarController('Agendamentos');
                    $aRetEmail = $oAgenda->envEmail($oValue);
                }
            }
        }
        return $aRetorno;
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

      $aEmail['cli']=$oValue->emailcli;

      return $aEmail;
      }
    
}
