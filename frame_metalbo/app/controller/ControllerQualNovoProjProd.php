<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualNovoProjProd extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualNovoProjProd');
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     *      */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);

        $sResulta = '<div id="titulolinhatempo">'
                . '<h3 class="panel-title">Linha do Tempo dos Projetos</h3></br>'
                . '</div>'
                . '<div class="pearls row" id="qualnovoprojprodtempo">'
                . '</div>';

        return $sResulta;
    }

    /**
     * Gerencia estilo de cores do wizard conforme status do projeto
     *      */
    public function renderTempo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRetorno = $this->Persistencia->verifSitProj($aCamposChave);

        /* $scurrentGeral = '';
          if ($oRetorno->sitgeralproj == 'Aprovado') {
          $scurrentGeral = 'current';
          $sEstiloGeral = 'border-color:#2eb82e;color:#2eb82e;';
          }
          if ($oRetorno->sitgeralproj == 'Representante') {
          $scurrentGeral = 'current';
          $sEstiloGeral = 'border-color:#8B2252;color:#8B2252;';
          }
          if ($oRetorno->sitgeralproj == 'Finalizado') {
          $scurrentGeral = 'current';
          }
          if ($oRetorno->sitgeralproj == 'Lib.Projetos') {
          $scurrentGeral = 'current';
          }
         * 
         */

        if ($oRetorno->sitproj == 'Aprovado') {
            $scurrentProj = 'current';
            $sEstiloProj = 'border-color:#2eb82e;color:#2eb82e';
        }
        if ($oRetorno->sitproj == 'Reprovado') {
            $scurrentProj = 'current';
            $sEstiloProj = 'border-color:#F00;color:#F00;';
        }
        if ($oRetorno->sitproj == 'Lib.Projetos') {
            $scurrentProj = 'current';
            $sEstiloProj = 'border-color:#62a8ea;color:#62a8ea';
        }
        if ($oRetorno->sitvendas == 'Aprovado') {
            $scurrentVenda = 'current';
            $sEstiloVenda = 'border-color:#2eb82e;color:#2eb82e;';
        }
        if ($oRetorno->sitvendas == 'Reprovado') {
            $scurrentVenda = 'current';
            $sEstiloVenda = 'border-color:#f00;color:#f00;';
        }
        if ($oRetorno->sitvendas == 'Aguardando') {
            $scurrentVenda = 'current';
            $sEstiloVenda = 'border-color:#8B2252;color:#8B2252;';
        }
        if ($oRetorno->sitcliente == 'Aprovado') {
            $scurrentCli = 'current';
            $sEstiloCli = 'border-color:#2eb82e;color:#2eb82e;';
        }
        if ($oRetorno->sitcliente == 'Expirado') {
            $scurrentCli = 'current';
            $sEstiloCli = 'border-color:#E19D12;color:#E19D12;';
        }
        if ($oRetorno->sitcliente == 'Reprovado') {
            $scurrentCli = 'current';
            $sEstiloCli = 'border-color:#f00;color:#f00;';
        }
        if ($oRetorno->dataprod == true) {
            $scurrentCad = 'current';
            $sEstiloProd = 'border-color:#2eb82e;color:#2eb82e;';
            $ssitCad = 'Cadastrado';
        }
        if ($oRetorno->valodter == true) {
            $scurrentResp = 'current';
            $sEstiloFim = 'border-color:#2eb82e;color:#2eb82e;';
            $ssitProjProd = 'Produzido';
        }



        $sLinha = /* '<div id="0" class="pearl ' . $scurrentGeral . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                  . '<div class="pearl-icon" style="' . $sEstiloGeral . '">'
                  . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                  . '</div>'
                  . '<span class="pearl-title" style="font-size:12px">Geral: ' . $oRetorno->sitgeralproj . '</span>'
                  . '</div>' */
                '<div id="0" class="pearl ' . $scurrentProj . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloProj . '">'
                . '<i class="icon wb-calendar" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Projetos: ' . $oRetorno->sitproj . '</span>'
                . '</div>'
                . '<div id="1" class="pearl ' . $scurrentVenda . '  col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloVenda . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Vendas: ' . $oRetorno->sitvendas . '</span>'
                . '</div>'
                . '<div id="2" class="pearl ' . $scurrentCli . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloCli . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Cliente: ' . $oRetorno->sitcliente . '</span>'
                . '</div>'
                . '<div id="3" class="pearl ' . $scurrentCad . '  col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloProd . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Produto: ' . $ssitCad . '</span>'
                . '</div>'
                . '<div id="4" class="pearl ' . $scurrentResp . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                . '<div class="pearl-icon" style="' . $sEstiloFim . '">'
                . '<i class="icon wb-check" aria-hidden="true"></i>'
                . '</div>'
                . '<span class="pearl-title" style="font-size:12px">Produção: ' . $ssitProjProd . '</span>'
                . '</div>';

        $sRender = '$("#qualnovoprojprodtempo").empty();';
        $sRender .= '$("#qualnovoprojprodtempo").append(\'' . $sLinha . '\');';
        echo $sRender;
        //coloca o titulo
        echo '$("#titulolinhatempo").empty();';
        $sTitulo = '<h3 class="panel-title">Linha do Tempo Projeto Nº ' . $aCamposChave['nr'] . '</h3></br>';
        echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';
    }

    public function TelaCadProd($sDados) {

        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        //procedimentos antes de criar a tela
        $this->antesAlterar($aDados);
        //cria a tela
        $this->View->criaTelaProd();

        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
        //adiciona botoes padrão
        if (!$this->getBDesativaBotaoPadrao()) {
            $this->View->addBotaoPadraoTela('');
        };
        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setChavemin($this->ValorSql($this->Model->getChavemin()));
        $this->Model->setChavemax($this->ValorSql($this->Model->getChavemax()));
        $this->Model->setAltmin($this->ValorSql($this->Model->getAltmin())); //Altmax()
        $this->Model->setAltmax($this->ValorSql($this->Model->getAltmax()));
        $this->Model->setDiamfmin($this->ValorSql($this->Model->getDiamfmin()));
        $this->Model->setDiamfmax($this->ValorSql($this->Model->getDiamfmax()));

        $this->Model->setCompmin($this->ValorSql($this->Model->getCompmin())); //Compmax
        $this->Model->setCompmax($this->ValorSql($this->Model->getCompmax()));

        $this->Model->setDiampmin($this->ValorSql($this->Model->getDiampmin()));
        $this->Model->setDiampmax($this->ValorSql($this->Model->getDiampmax()));

        $this->Model->setDiamexmin($this->ValorSql($this->Model->getDiamexmin()));
        $this->Model->setDiamexmax($this->ValorSql($this->Model->getDiamexmax()));

        $this->Model->setComprmin($this->ValorSql($this->Model->getComprmin()));
        $this->Model->setComprmax($this->ValorSql($this->Model->getComprmax()));

        $this->Model->setComphmin($this->ValorSql($this->Model->getComphmin()));
        $this->Model->setComphmax($this->ValorSql($this->Model->getComphmax()));

        $this->Model->setDiamhmin($this->ValorSql($this->Model->getDiamhmin()));
        $this->Model->setDiamhmax($this->ValorSql($this->Model->getDiamhmax())); //Anghelice

        $this->Model->setAnghelice($this->ValorSql($this->Model->getAnghelice()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setChavemin($this->ValorSql($this->Model->getChavemin()));
        $this->Model->setChavemax($this->ValorSql($this->Model->getChavemax()));
        $this->Model->setAltmin($this->ValorSql($this->Model->getAltmin())); //Altmax()
        $this->Model->setAltmax($this->ValorSql($this->Model->getAltmax()));
        $this->Model->setDiamfmin($this->ValorSql($this->Model->getDiamfmin()));
        $this->Model->setDiamfmax($this->ValorSql($this->Model->getDiamfmax()));

        $this->Model->setCompmin($this->ValorSql($this->Model->getCompmin())); //Compmax
        $this->Model->setCompmax($this->ValorSql($this->Model->getCompmax()));

        $this->Model->setDiampmin($this->ValorSql($this->Model->getDiampmin()));
        $this->Model->setDiampmax($this->ValorSql($this->Model->getDiampmax()));

        $this->Model->setDiamexmin($this->ValorSql($this->Model->getDiamexmin()));
        $this->Model->setDiamexmax($this->ValorSql($this->Model->getDiamexmax()));

        $this->Model->setComprmin($this->ValorSql($this->Model->getComprmin()));
        $this->Model->setComprmax($this->ValorSql($this->Model->getComprmax()));

        $this->Model->setComphmin($this->ValorSql($this->Model->getComphmin()));
        $this->Model->setComphmax($this->ValorSql($this->Model->getComphmax()));

        $this->Model->setDiamhmin($this->ValorSql($this->Model->getDiamhmin()));
        $this->Model->setDiamhmax($this->ValorSql($this->Model->getDiamhmax())); //Anghelice

        $this->Model->setAnghelice($this->ValorSql($this->Model->getAnghelice()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    /**
     * Mensagem para finalizar projeto
     */
    public function msgFinalizar($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetSit = $this->Persistencia->verifSitProj($aCamposChave);
        $sVar = $aRetSit->sitgeralproj;

        if ($sVar == 'Finalizado') {
            $oMensagem = new Modal('Finalizar projeto', 'Projeto nº' . $aCamposChave['nr'] . ' já foi finalizado!', Modal::TIPO_ERRO, false, true, false);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('Finalizar projeto', 'Deseja finalizar o projeto nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","finalizaProj","' . $sDados . '");');
        }

        echo $oMensagem->getRender();
    }

    /**
     * Finaliza projeto
     */
    public function finalizaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->finaProjeto($aCamposChave);

        if ($aRetorno[0] == true) {
            $oMensagem = new Mensagem('Atenção', 'O projeto nº' . $aRetorno[1] . ' foi finalizado com sucesso!', Modal::TIPO_SUCESSO);
            $oMsgEmail = new Modal('Finalizar Projeto', 'Deseja enviar e-mail de Finalização do Projeto nº' . $aCamposChave['nr'] . ' para o representante?', Modal::TIPO_AVISO, true, true, true);
            $oMsgEmail->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EmailFinalProj","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº' . $aCamposChave['nr'] . ' não foi finalizado!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
        echo $oMensagem->getRender();
        echo $oMsgEmail->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function EmailFinalProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oDadosProj = $this->Persistencia->buscaDados($aCamposChave);
        $aObs = $this->Persistencia->buscaObs($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº' . $aCamposChave['nr'] . ''));
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#006400"><b>FINALIZADA</b></span> PELO SETOR DE PROJETOS.<hr><br/>'
                        . '<b>Projeto Finalizado com Sucesso e está pronto para pedido:</b><br/>'
                        . '<b>Código do Novo Produto:</b> ' . $oDadosProj->procod . '<br/>'
                        . '<b>Descrição:</b> ' . $oDadosProj->desc_novo_prod . '<br/>'
                        . '<b>Acabamento:</b> ' . $oDadosProj->acabamento . '<br/>'
                        . '<b>Quantidade:</b> ' . number_format($oDadosProj->quant_pc, 2, ',', '.') . '<br />' //.number_format($oAprov->quant_pc, 2, ',', '.').
                        . '<b>Data Implantação:  ' . $oDadosProj->dtimp . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Cnpj:</b></td><td>' . $oDadosProj->empcod . '</td></tr>'
                        . '<tr><td><b>Cliente:</b></td><td>' . $oDadosProj->empdes . '</td></tr>'
                        . '<tr><td><b>Escritório:</b></td><td>' . $oDadosProj->officedes . '</td></tr>'
                        . '<tr><td><b>Representante:</b></td><td>' . $oDadosProj->repnome . '</td></tr> '
                        . '<tr><td><b>Resp. Vendas:</b></td><td>' . $oDadosProj->resp_venda_nome . '</td></tr> '
                        . '<tr><td><b>Observação do Representante:</b></td><td>' . $oDadosProj->replibobs . '</td></tr> '
                        . '<tr><td><b>Observação Projetos</b></td><td>' . $aObs['ObsGeral'] . '</td></tr> '
                        . '</table><br/><br/> '
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();


        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //nao enviar e-mail para vendas no momento
        $aUserPlano = $this->Persistencia->projEmailVendaProj($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }

        //e-mail avanei somente para teste
        // $oEmail->addAnexo('app/relatorio/qualidade/Aq'.$aDados[1].'_empresa_'.$aDados[0].'.pdf', utf8_decode('Aq nº'.$aDados[1].'_empresa_'.$aDados[0]));
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}