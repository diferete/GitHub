<?php

class ControllerQualGerenProj extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualGerenProj');
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     *      */
    public function calculoPersonalizado($sParametros = null) {
        parent::calculoPersonalizado($sParametros);


        $sResulta = '<div id="titulolinhatempo">'
                . '<h3 class="panel-title">Linha do Tempo dos Projetos</h3></br>'
                . '</div>'
                . '<div class="pearls row" id="qualgerenprojtempo">'
                . '</div>';

        return $sResulta;
    }

    /**
     * Gerencia estilo de cores do wizard conforme status do projeto
     * */
    public function renderTempo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aDados[0] == '') {
            echo '$("#qualgerenprojtempo").empty();';
            echo '$("#titulolinhatempo").empty();';
        } else {
            $oRetorno = $this->Persistencia->verifSitProj($aCamposChave);


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
            if ($oRetorno->sitproj == 'Cód. enviado') {
                $scurrentProj = 'current';
                $sEstiloProj = 'border-color:#2eb82e;color:#2eb82e';
                $ssitCad = 'Cód. enviado';
            }
            if ($oRetorno->valodter == true) {
                $scurrentResp = 'current';
                $sEstiloFim = 'border-color:#2eb82e;color:#2eb82e;';
                $ssitProjProd = 'Produzido';
            }
            if ($oRetorno->valpedter == true) {
                $scurrentResp = 'current';
                $sEstiloFim = 'border-color:#2eb82e;color:#2eb82e;';
                $ssitProjProd = 'Faturado';
            }



            $sLinha = '<div id="0" class="pearl ' . $scurrentProj . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
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
                    . '<span class="pearl-title" style="font-size:12px">Cadastro: ' . $ssitCad . '</span>'
                    . '</div>'
                    . '<div id="4" class="pearl ' . $scurrentResp . ' col-lg-2 col-md-2 col-sm-2  col-xs-2 ">'
                    . '<div class="pearl-icon" style="' . $sEstiloFim . '">'
                    . '<i class="icon wb-check" aria-hidden="true"></i>'
                    . '</div>'
                    . '<span class="pearl-title" style="font-size:12px">Produto: ' . $ssitProjProd . '</span>'
                    . '</div>';

            $sRender = '$("#qualgerenprojtempo").empty();';
            $sRender .= '$("#qualgerenprojtempo").append(\'' . $sLinha . '\');';
            echo $sRender;
            //coloca o titulo
            echo '$("#titulolinhatempo").empty();';
            $sTitulo = '<h3 class="panel-title">Linha do Tempo Projeto Nº ' . $aCamposChave['nr'] . '</h3></br>';
            echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';
        }
    }

    public function relNovoProjeto($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'relNovoProjeto');
    }

    public function relNovoProjetoRanking() {

        //Explode string parametros
        $sDados = $_REQUEST['campos'];

        $sCampos = htmlspecialchars_decode($sDados);

        $sCampos .= $this->getSget();

        $sSistema = "app/relatorio";
        $sRelatorio = 'relNovoProjetoRanking.php?';

        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function relNovoProjetosMes() {

        //Explode string parametros
        $sDados = $_REQUEST['campos'];

        $sCampos = htmlspecialchars_decode($sDados);

        $sCampos .= $this->getSget();

        $sSistema = "app/relatorio";
        $sRelatorio = 'relNovoProjetosMes.php?';

        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function relProjXls() {
        //Explode string parametros
        $sDados = $_REQUEST['campos'];

        $sCampos = htmlspecialchars_decode($sDados);

        $sCampos .= $this->getSget();

        $aRel = explode(',', $sRel);

        $sSistema = "app/relatorio";
        $sRelatorio = 'relNovoProjetoXls.php?';

        $sCampos .= '&output=email';
        $oMensagem = new Mensagem("Aguarde", "Seu excel está sendo processado", Mensagem::TIPO_INFO);
        echo $oMensagem->getRender();

        $oWindow = // 'window.open("'.$sSistema.'/'.$sRelatorio.''.$sCampos.'", "Relatório", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");'; 
                'var win = window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '","MsgWindow","width=500,height=100,left=375,top=330");'
                . 'setTimeout(function () { win.close();}, 30000);';
        echo $oWindow;



        $oMenSuccess = new Mensagem("Sucesso", "Seu excel foi gerado com sucesso, acesse sua pasta de downloads!", Mensagem::TIPO_SUCESSO);
        echo $oMenSuccess->getRender();
    }

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
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
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

        $aRetorno = $oEmail->sendEmail();
        return $aRetorno;
    }

}
