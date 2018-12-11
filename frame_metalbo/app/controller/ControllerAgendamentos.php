<?php

/*
 * Classe para gerenciar Agendamentos de rotinas no sistema
 * 
 * @author Alexandre W. de Souza
 * @since 05-02-2018
 */

class ControllerAgendamentos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('Agendamentos');
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
            //executa a funçao
            $aRet = $this->Persistencia->mudaSitEntProj($aRetorno);
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
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));


        $aUserPlano = $this->Persistencia->projEmailVendaProj($oValue);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº' . $oValue->nr . ''));
        $oEmail->setMensagem(utf8_decode('PROJETO Nº ' . $oValue->nr . ' FOI CANCELADO PELO SISTEMA<hr><br/>'
                        . '<p style="margin:20px;color:red;font-weight:900;font-size:25px;">PROJETO EXPIRADO: TEMPO LIMITE PARA APROVAÇÃO DO CLIENTE EXCEDIDO!</p>'
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

        $aRetorno = $oEmail->sendEmail();
        return $aRetorno;
    }

    public function notificaAQ() {
        $aRetorno = $this->Persistencia->buscaDataAq();

        if (count($aRetorno) > 0) {

            $iDias = 0;
            foreach ($aRetorno as $iKey => $oValue) {
                $iDias = $oValue->dias;

                if ($iDias >= -7) {
                    $this->envEmailAq($oValue);
                }
            }
        }
        return $aRetorno;
    }

    public function envEmailAq($oValue) {

        $oEmail = new Email();
        $oEmail->setMailer();
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));


        $aEmail = $this->Persistencia->buscaEmailPlanoAca($oValue);

        $oEmail->addDestinatario($aEmail[0]);

        //$oEmail->addDestinatario('alexandre@metalbo.com.br');


        $oEmail->setAssunto(utf8_decode('Plano de Ação Seq. ' . $oValue->seq . ' da Ação nº' . $oValue->nr . ''));
        $oEmail->setMensagem(utf8_decode('PLANO DE AÇÃO Nº ' . $oValue->seq . ' ESTÁ PRESTES A EXPIRAR <hr><br/>'
                        . '<p style="margin:20px;color:red;font-weight:900;font-size:25px;">Tempo para expirar o plano de ação está menor que 7 DIAS!</p>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Responsável pelo plano de ação:</b></td><td>' . $oValue->usunome. '</td></tr>'
                        . '<tr><td><b>Data prevista:</b></td><td> ' . $oValue->data . '</td></tr>'
                        . '<tr><td><b>Empesa:</b></td><td>' .$oValue->filcgc. '</td></tr>'
                        . '</table><br/><br/><hr>'
                        . '<br/><b style="margin:40px;color:blue">E-mail enviado automaticamente, favor não responder!</b>'
                        . '<br/><b style="margin:40px;color:red">Você continuará recebendo e-mails até o plano de ação ser finalizado!</b>'));

        $aRetorno = $oEmail->sendEmail();
        return;
    }

}
