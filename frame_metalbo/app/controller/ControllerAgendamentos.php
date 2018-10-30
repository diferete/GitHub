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
                        . '<table style="border-collapse:collapse;position:relative;margin: 20px"> '
                        . '<tr><td style="margin:0px"><b>Descrição:</b></td><td style="padding-left:10px;width:100%;"> ' . $oValue->desc_novo_prod . '</td></tr>'
                        . '<tr><td style="margin:0px"><b>Implantação:</b></td><td style="padding-left:10px;width:100%;"> ' . $sDateConvert . '</td></tr>'
                        . '<tr><td style="margin:0px"><b>Dt. Aprovação Venda:</b></td><td style="padding-left:10px;width:50%;">  ' . $sDateConvert2 . '</td></tr>'
                        . '<tr><td style="margin:0px"><b>Cnpj:</b></td><td style="padding-left:10px;width:100%;">' . $oValue->empcod . '</td></tr>'
                        . '<tr><td style="margin:0px"><b>Escritório:</b></td><td style="padding-left:10px;width:100%;">' . $oValue->officedes . '</td></tr>'
                        . '<tr><td style="margin:0px"><b>Representante:</b></td><td style="padding-left:10px;width:100%;">' . $oValue->repnome . '</td></tr> '
                        . '<tr><td style="margin:0px"><b>Resp. Vendas:</b></td><td style="padding-left:10px;width:100%;">' . $oValue->resp_venda_nome . '</td></tr> '
                        . '</table><br/>'
                        . '<br/><b style="margin:40px;color:blue">E-mail enviado automaticamente, favor não responder!</b>'));

        $aRetorno = $oEmail->sendEmail();
        return $aRetorno;
        
    }
}
