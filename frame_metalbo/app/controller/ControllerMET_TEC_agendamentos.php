<?php

/*
 * Implementa a classe controller dos agendamentos
 */

class ControllerMET_TEC_agendamentos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_agendamentos');
    }

    public function getAgendamento($aDados) {

        $aModels = $this->Persistencia->getAgendamento();

        foreach ($aModels as $oAtual) {

            $aDados = array();

            $aDados['NR'] = $oAtual->getNr();
            $aDados['TITULO'] = $oAtual->getTitulo();
            $aDados['CLASSE'] = $oAtual->getClasse();
            $aDados['METODO'] = $oAtual->getMetodo();
            $aDados['DATA'] = $oAtual->getData();
            $aDados['HORA'] = substr($oAtual->getHora(), 0, -11);
            $aDados['PARAMETROS'] = $oAtual->getParametros();
            $aDados['OBS'] = $oAtual->getObs();
            $aDados['AGENDAMENTO'] = $oAtual->getAgendamento();
            $aDados['INTERVALOMINUTOS'] = $oAtual->getIntervalominuto();
            $aDados['ULTRESULTADO'] = $oAtual->getUltResultado();
            $aDados['DTULTRESULTADO'] = $oAtual->getDtultresultado();
            $aDados['HORAEXEC'] = $oAtual->getHoraExec();
            $aRetorno[] = $aDados;
        }

        return $aRetorno;
    }

    public function metodo1($aDados) {
        foreach ($aDados as $key => $oValue) {
            $sIdAgenda = $oValue->agId;
        }
        //envia o e-mail
        $oEnvMail = Fabrica::FabricarController('STEEL_PCP_GerenProd');
        $sLogEmail = $oEnvMail->enviaEmailProdAdm('EnvEmail', 'agenda');

        $aRetorno = $this->Persistencia->setExecutaAgenda($sIdAgenda);

        return $aRetorno['CHEGOU'] = $sLogEmail;
    }

    /**
     * Método que cria e adiciona os campos de relacionamento entre os objetos
     * model e de persistência
     * 
     * @param Busca dados via select na tabela de entrada de projetos e faz update caso expirado tempo de aprovação do cliente   */
    public function atualizaEntProj() {

        $aRetorno = $this->Persistencia->verificaSitEntProj();
        //verifica se array tem dados, dar um count
        if (count($aRetorno) > 0) {

            $iDias = 0;
            foreach ($aRetorno as $iKey => $oValue) {

                $iDias = $oValue->dias;
                $sFilcgc = $oValue->filcgc;
                $iNr = $oValue->nr;

                if ($iDias >= 60) {
                    $aRet = $this->Persistencia->mudaSitEntProj($oValue);
                    if ($aRet) {
                        $this->envEmail($oValue);
                    } else {
                        exit;
                    }
                }
            }
        }
    }

    /**
     *  Monta e envia o e-mail caso expirado o tempo de aprovação pelo cliente
     *
     */
    public function envEmail($oValue) {


        $sData = $oValue->dtimp;
        $sDateConvert = date("d/m/Y", strtotime($sData));

        $sData2 = $oValue->dtaprovendas;
        $sDateConvert2 = date("d/m/Y", strtotime($sData2));

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));


        $aUserPlano = $this->Persistencia->projEmailVendaProj($oValue);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

//        $oEmail->addDestinatario('alexandre@metalbo.com.br');

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº' . $oValue->nr . ''));
        $oEmail->setMensagem(utf8_decode('PROJETO Nº ' . $oValue->nr . ' FOI CANCELADO PELO SISTEMA<hr><br/>'
                        . '<p style="margin:20px;color:red;font-weight:900;font-size:25px;">PROJETO EXPIRADO: O TEMPO LIMITE DE 60 DIAS PARA APROVAÇÃO DO CLIENTE FOI EXCEDIDO!</p>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Descrição:</b></td><td> ' . $oValue->desc_novo_prod . '</td></tr>'
                        . '<tr><td><b>Implantação:</b></td><td> ' . $sDateConvert . '</td></tr>'
                        . '<tr><td><b>Dt. Aprovação Venda:</b></td><td>  ' . $sDateConvert2 . '</td></tr>'
                        . '<tr><td><b>Cnpj:</b></td><td>' . $oValue->empcod . '</td></tr>'
                        . '<tr><td><b>Escritório:</b></td><td>' . $oValue->officedes . '</td></tr>'
                        . '<tr><td><b>Representante:</b></td><td>' . $oValue->repnome . '</td></tr> '
                        . '<tr><td><b>Resp. Vendas:</b></td><td>' . $oValue->resp_venda_nome . '</td></tr> '
                        . '</table><br/><br/><hr>'
                        . '<br/><b style="margin:40px;color:blue">E-mail enviado automaticamente, favor não responder!</b>'));

        //$aRetorno = $oEmail->sendEmail();
        return;
    }

    public function notificaAQ() {
        $aRetorno = $this->Persistencia->buscaDataAq();

        if (count($aRetorno) > 0) {
            $iDias = 0;
            foreach ($aRetorno as $iKey => $oValue) {
                $iDias = $oValue->dias;
                if ($iDias >= -7) {
                    //$this->envEmailAq($oValue);
                }
            }
        }
        return $aRetorno;
    }

    public function envEmailAq($oValue) {

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $$oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));


        $aEmail = $this->Persistencia->buscaEmailPlanoAcao($oValue);

        $oEmail->addDestinatario($aEmail[0]);

        //$oEmail->addDestinatario('alexandre@metalbo.com.br');


        $oEmail->setAssunto(utf8_decode('Plano de Ação Seq. ' . $oValue->seq . ' da Ação nº' . $oValue->nr . ''));
        $oEmail->setMensagem(utf8_decode('PLANO DE AÇÃO Nº ' . $oValue->seq . ' ESTÁ PRESTES A EXPIRAR <hr><br/>'
                        . '<p style="margin:20px;color:red;font-weight:900;font-size:25px;">Tempo para expirar o plano de ação está menor que 7 DIAS!</p>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Responsável pelo plano de ação:</b></td><td>' . $oValue->usunome . '</td></tr>'
                        . '<tr><td><b>Data prevista:</b></td><td> ' . $oValue->data . '</td></tr>'
                        . '<tr><td><b>Empesa:</b></td><td>' . $oValue->filcgc . '</td></tr>'
                        . '</table><br/><br/><hr>'
                        . '<br/><b style="margin:40px;color:blue">E-mail enviado automaticamente, favor não responder!</b>'
                        . '<br/><b style="margin:40px;color:red">Você continuará recebendo e-mails até o plano de ação ser finalizado!</b>'));

        //$aRetorno = $oEmail->sendEmail();
        return;
    }

}
