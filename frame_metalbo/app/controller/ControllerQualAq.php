<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualAq extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualAq');
        // $this->setControllerDetalhe('QualAqPlan');
        $this->setControllerDetalhe('QualCausa');
        $this->setSMetodoDetalhe('criaPainelCausa');
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('filcgc', $this->Model->getEmpRex()->getFilcgc());
        $this->Persistencia->adicionaFiltro('nr', $this->Model->getNr());
    }

    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getEmpRex()->getFilcgc();
        $aRetorno[1] = $this->Model->getNr();
        return $aRetorno;
    }

    public function msgFechaAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $bEf = $this->Persistencia->verifEfi($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        if ($bEf) {
            $oMensagem = new Modal('Fechamento de ação', 'Fechar a ação da qualidade nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","fechaAq","' . $sDados . '");');
            echo $oMensagem->getRender();
        } else {
            $oMsgEf = new Modal('Atenção', 'Esta ação da qualidade não tem nenhuma avaliação da eficácia apontada, '
                    . 'insira uma avaliação da eficácia antes de finalizar', Modal::TIPO_ERRO, false, true, true);
            echo $oMsgEf->getRender();
        }
    }

    public function fechaAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->fechaAq($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem = new Modal('Sucesso', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' finalizada com sucesso', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' não foi finalizada', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function msgAbreAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();



        $oMensagem = new Modal('Reabertura da ação', 'Deseja reabrir a ação nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","reabreAq","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    public function reabreAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->reabreAq($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem = new Modal('Sucesso', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' foi reaberta com sucesso', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' não foi reaberta', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function startAq($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->startAq($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem = new Modal('Sucesso', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' foi iniciada', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagem = new Modal('Atenção', 'A ação da qualidade nº' . $aCamposChave['nr'] . ' não foi iniciada', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function envMailQual($sDados, $sRel) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aNr = explode('=', $aDados[2]);


        // sleep(5);

        $oEmail = new Email();
        $oEmail->setMailer();
        /* testes */
        $oEmail->setEnvioSMTP();
        //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oEmail->setAssunto(utf8_decode('Ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0]));
        $oEmail->setMensagem(utf8_decode('Anexo ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0] . ' da qual você está envolvido. '
                        . ' Verifique a ação em anexo para ficar por dentro dos detalhes!'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        // Cópia
        //  $aCopia = array();
        //  $aCopia[] = 'avaneim@gmail.com';
        //  $aCopia[] = 'avanei@rexmaquinas.com.br';

        foreach ($aCopia as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        $oEmail->addAnexo('app/relatorio/qualidade/Aq' . $aDados[1] . '_empresa_' . $aDados[0] . '.pdf', utf8_decode('Aq nº' . $aDados[1] . '_empresa_' . $aDados[0]));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function envMailGrid($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        echo 'requestAjax("","QualAqPlan","geraRelPdfAq","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . ',AqImp");';
        echo'requestAjax("","QualAq","envMailAll","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . '");';
    }

    public function envMailGrid2($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        echo 'requestAjax("","QualAqPlan","geraRelPdfAq","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . ',AqImp");';
        echo'requestAjax("","QualAq","envMailQual","' . $aCamposChave['EmpRex_filcgc'] . ',' . $aCamposChave['nr'] . '");';
    }

    public function envMailAll($sDados, $sRel) {
        $aDados = explode(',', $sDados);

        //emails planos da acao 
        $aUserPlano = $this->Persistencia->emailPlan($aDados);


        $oEmail = new Email();
        $oEmail->setMailer();
        /* testes */
        $oEmail->setEnvioSMTP();
        //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oEmail->setAssunto(utf8_decode('Ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0]));
        $oEmail->setMensagem(utf8_decode('Anexo ação da qualidade nº' . $aDados[1] . ' da empresa ' . $aDados[0] . ' da qual você está envolvido. '
                        . ' Verifique a ação em anexo para ficar por dentro dos detalhes!'));
        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        $oEmail->addAnexo('app/relatorio/qualidade/Aq' . $aDados[1] . '_empresa_' . $aDados[0] . '.pdf', utf8_decode('Aq nº' . $aDados[1] . '_empresa_' . $aDados[0]));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function envMailMsg($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aNr = explode('=', $aDados[2]);

        $oMensagem = new Modal('Email', 'Deseja enviar e-mail para todos os envolvidos nessa ação da qualidade?', Modal::TIPO_INFO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","QualAq","envMailAll","' . $sDados . '");');

        echo $oMensagem->getRender();
    }

    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);
        $aTotal = $this->Persistencia->somaSit();

        $sResulta = '<div class="cor_verde">Total de ações abertas:' . $aTotal['Aberta'] . '</div>'
                . '<div class="cor_azul">Total de ações iniciadas:' . $aTotal['Iniciada'] . '</div>'
                . 'Total de ações finalizadas:' . $aTotal['Finalizada'] . '';
        return $sResulta;
    }

}
