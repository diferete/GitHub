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

    public function TelaCadProd($sDados) {

        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $sRetorno = $this->Persistencia->buscaSitCli($aCamposChave['nr']);

        if ($sRetorno != 'Aprovado') {
            $oMensagem = new Modal('Atenção!', 'O projeto ainda não foi Aprovado pelo cliente', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }

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
        }
        //renderiza a tela
        $this->View->getTela()->getRender();
    }

  
    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setChavemin($this->ValorSql($this->Model->getChavemin()));
        $this->Model->setChavemax($this->ValorSql($this->Model->getChavemax()));
        $this->Model->setAltmin($this->ValorSql($this->Model->getAltmin())); //Altmax()
        $this->Model->setAltmax($this->ValorSql($this->Model->getAltmax()));
        $this->Model->setDiamfmin($this->ValorSql($this->Model->getDiamfmin()));
        $this->Model->setDiamfmax($this->ValorSql($this->Model->getDiamfmax()));

        $this->Model->setCompmin($this->ValorSql($this->Model->getCompmin()));
        $this->Model->setCompmax($this->ValorSql($this->Model->getCompmax())); //Compmax

        $this->Model->setDiampmin($this->ValorSql($this->Model->getDiampmin()));
        $this->Model->setDiampmax($this->ValorSql($this->Model->getDiampmax()));

        $this->Model->setDiamexmin($this->ValorSql($this->Model->getDiamexmin()));
        $this->Model->setDiamexmax($this->ValorSql($this->Model->getDiamexmax()));

        $this->Model->setComprmin($this->ValorSql($this->Model->getComprmin()));
        $this->Model->setComprmax($this->ValorSql($this->Model->getComprmax()));

        $this->Model->setComphmin($this->ValorSql($this->Model->getComphmin()));
        $this->Model->setComphmax($this->ValorSql($this->Model->getComphmax()));

        $this->Model->setDiamhmin($this->ValorSql($this->Model->getDiamhmin()));
        $this->Model->setDiamhmax($this->ValorSql($this->Model->getDiamhmax()));

        $this->Model->setAnghelice($this->ValorSql($this->Model->getAnghelice())); //Anghelice

        $this->Model->setProfcanecomin($this->ValorSql($this->Model->getProfcanecomin()));
        $this->Model->setProfcanecomax($this->ValorSql($this->Model->getProfcanecomax()));

        $this->Model->setAcab($this->ValorSql($this->Model->getAcab()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterUpdate();

        $aRetornoInsert = $this->Persistencia->insertCadDim();

        if ($aRetornoInsert[0]) {
            $oMessage = new Mensagem('Cad. Dimensional', 'Cadastro dimensional inserido com sucesso no Sistema_Metalbo/Delsoft', Mensagem::TIPO_SUCESSO);
            echo $oMessage->getRender();
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $oMessage = new Mensagem('Cad. Dimensional', 'Erro ao inserir cadastro dimensional no Sistema_Metalbo/Delsoft', Mensagem::TIPO_WARNING);
            echo $oMessage->getRender();
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    /**
     * Mensagem para liberar código do projeto
     */
    public function msgLibCod($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->liberaCodProj($aCamposChave);

        $oMsgEmail = new Modal('Liberar código', 'Deseja enviar e-mail com o código do Produto/Projeto nº' . $aCamposChave['nr'] . ' para o vendas?', Modal::TIPO_AVISO, true, true, true);
        $oMsgEmail->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","emailLibCod","' . $sDados . '");');

        echo $oMsgEmail->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function reenviaCodigo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Mensagem('Aguarde', 'Seu e-mail está sendo gerado e enviado', Mensagem::TIPO_INFO);
        echo'requestAjax("","' . $sClasse . '","emailLibCod","' . $sDados . '");';

        echo $oMensagem->getRender();
    }

    public function emailLibCod($sDados) {
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
        $oEmail->setSenha('Metalbo@@50');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $oDadosProj = $this->Persistencia->buscaDados($aCamposChave);
        $aObs = $this->Persistencia->buscaObs($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº' . $aCamposChave['nr'] . ''));
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#006400"><b>CADASTRADA</b></span> PELO SETOR DE PROJETOS.<hr><br/>'
                        . '<b>Projeto Cadastrado com sucesso e está pronto para pedido:</b><br/>'
                        . '<b>CÓDIGO DO NOVO PRODUTO:</b> ' . $oDadosProj->procod . '<br/>'
                        . '<b>Descrição:</b> ' . $oDadosProj->desc_novo_prod . '<br/>'
                        . '<b>Acabamento:</b> ' . $oDadosProj->acabamento . '<br/>'
                        . '<b>Quantidade:</b> ' . number_format($oDadosProj->quant_pc, '.') . '<br />' //.number_format($oAprov->quant_pc, '.').
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


        //nao enviar e-mail para vendas no momento
        $aEmail = $this->Persistencia->projEmailVendaProj($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        $oEmail->addDestinatario($aEmail[1]);

        //$oEmail->addDestinatario('alexandre@metalbo.com.br');
        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, tente novamente no botão de E-mails, caso o problema persista, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    /**
     * Monta Wizard linha do tempo OnClick para Gerenciar Projetos
     * */
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
     * */
    public function renderTempo($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

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

        $sRender = '$("#qualnovoprojprodtempo").empty();';
        $sRender .= '$("#qualnovoprojprodtempo").append(\'' . $sLinha . '\');';
        echo $sRender;
        //coloca o titulo
        echo '$("#titulolinhatempo").empty();';
        $sTitulo = '<h3 class="panel-title">Linha do Tempo Projeto Nº ' . $aCamposChave['nr'] . '</h3></br>';
        echo '$("#titulolinhatempo").append(\'' . $sTitulo . '\');';
    }

    /**
     * Cria a tela Modal para aprovaçào da proposta
     * @param type $sDados
     */
    public function criaTelaModalSeqProc($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $oProposta = $this->Persistencia->buscaDados($aCamposChave);

        if ($oProposta->sitproj == 'Cód. enviado') {

            $this->View->setAParametrosExtras($oProposta);

            $this->View->criaTelaModalSeqProc($aDados[1]);

            //adiciona onde será renderizado
            $this->View->getTela()->setSRender($aDados[1] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMensagem = new Modal('Atenção', 'Produto não cadastrado', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function geraEtapaProcesso($renderTo, $sMetodo = '') {
        parent::acaoMostraRelatorio($renderTo, 'geraEtapaProcesso');
    }

    public function getDadosProdSimilar($sDados) {
        $aDados = explode(',', $sDados);

        $oObj = $this->Persistencia->getCadDim($aDados[0]);

        $sSetValorCampos = '$("#' . $aDados[1] . '").val("' . Util::formataSqlDecimal($oObj->prodchamin) . '");'
                . '$("#' . $aDados[2] . '").val("' . Util::formataSqlDecimal($oObj->prodchamax) . '");'
                . '$("#' . $aDados[3] . '").val("' . Util::formataSqlDecimal($oObj->prodaltmin) . '");'
                . '$("#' . $aDados[4] . '").val("' . Util::formataSqlDecimal($oObj->prodaltmax) . '");'
                . '$("#' . $aDados[5] . '").val("' . Util::formataSqlDecimal($oObj->proddiamin) . '");'
                . '$("#' . $aDados[6] . '").val("' . Util::formataSqlDecimal($oObj->proddiamax) . '");'
                . '$("#' . $aDados[7] . '").val("' . Util::formataSqlDecimal($oObj->procommin) . '");'
                . '$("#' . $aDados[8] . '").val("' . Util::formataSqlDecimal($oObj->procommax) . '");'
                . '$("#' . $aDados[9] . '").val("' . Util::formataSqlDecimal($oObj->prodiapmin) . '");'
                . '$("#' . $aDados[10] . '").val("' . Util::formataSqlDecimal($oObj->prodiapmax) . '");'
                . '$("#' . $aDados[11] . '").val("' . Util::formataSqlDecimal($oObj->prodiaemin) . '");'
                . '$("#' . $aDados[12] . '").val("' . Util::formataSqlDecimal($oObj->prodiaemax) . '");'
                . '$("#' . $aDados[13] . '").val("' . Util::formataSqlDecimal($oObj->procomrmin) . '");'
                . '$("#' . $aDados[14] . '").val("' . Util::formataSqlDecimal($oObj->procomrmax) . '");'
                . '$("#' . $aDados[15] . '").val("' . Util::formataSqlDecimal($oObj->comphastma) . '");'
                . '$("#' . $aDados[16] . '").val("' . Util::formataSqlDecimal($oObj->comphastmi) . '");'
                . '$("#' . $aDados[17] . '").val("' . Util::formataSqlDecimal($oObj->diamhastmi) . '");'
                . '$("#' . $aDados[18] . '").val("' . Util::formataSqlDecimal($oObj->diamhastma) . '");'
                . '$("#' . $aDados[19] . '").val("' . Util::formataSqlDecimal($oObj->pfcmin) . '");'
                . '$("#' . $aDados[20] . '").val("' . Util::formataSqlDecimal($oObj->pfcmax) . '");'
                . '$("#' . $aDados[22] . '").val("' . (int) $oObj->prodacab . '");'
                . '$("#' . $aDados[23] . '").val("' . $oObj->promatcod . '");'
                . '$("#' . $aDados[24] . '").val("' . $oObj->proclasseg . '");';
        $teste = strlen($oObj->proanghel);
        if ($teste > 0) {
            $sSetValorCampos .= '$("#' . $aDados[21] . '").val("' . $oObj->proanghel . '");';
        }
        echo $sSetValorCampos;
    }

}
