<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualNovoProj extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualNovoProj');
    }


    public function acaoExitEmp($sDados) {
        $aDados = explode(',', $sDados);
        $oPersPes = Fabrica::FabricarPersistencia('Pessoa');
        $oModelPes = Fabrica::FabricarModel('Pessoa');
        $oPersPes->adicionaFiltro('empcod', $aDados[0]);
        $oPersPes->setModel($oModelPes);

        $oPessoa = $oPersPes->consultarWhere();

        $sEmail = $oPessoa->getEmpinterne();
    }

    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);

        $sDataDb = $this->Model->getPrazoentregautil();
        $sValorBanco = $this->Model->getQuant_pc();
        $sValorDec = number_format($sValorBanco, 2, ',', '.');
        $this->Model->setQuant_pc($sValorDec);
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setVlrFerramen($this->ValorSql($this->Model->getVlrFerramen()));
        $this->Model->setVlrDesenProj($this->ValorSql($this->Model->getVlrDesenProj()));

        $this->Model->setVlrMatPrima($this->ValorSql($this->Model->getVlrMatPrima()));
        $this->Model->setVlrAcabSuper($this->ValorSql($this->Model->getVlrAcabSuper()));
        $this->Model->setVlrTratTer($this->ValorSql($this->Model->getVlrTratTer()));
        $this->Model->setVlrCustProd($this->ValorSql($this->Model->getVlrCustProd()));
        $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));
        $this->Model->setLotemin($this->ValorSql($this->Model->getLotemin()));
        $this->Model->setPesoct($this->ValorSql($this->Model->getPesoct()));
        $this->Model->setPrecofinal($this->ValorSql($this->Model->getPrecofinal()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setVlrFerramen($this->ValorSql($this->Model->getVlrFerramen()));
        $this->Model->setVlrDesenProj($this->ValorSql($this->Model->getVlrDesenProj()));

        $this->Model->setVlrMatPrima($this->ValorSql($this->Model->getVlrMatPrima()));
        $this->Model->setVlrAcabSuper($this->ValorSql($this->Model->getVlrAcabSuper()));
        $this->Model->setVlrTratTer($this->ValorSql($this->Model->getVlrTratTer()));
        $this->Model->setVlrCustProd($this->ValorSql($this->Model->getVlrCustProd()));
        $this->Model->setQuant_pc($this->ValorSql($this->Model->getQuant_pc()));
        $this->Model->setLotemin($this->ValorSql($this->Model->getLotemin()));
        $this->Model->setPesoct($this->ValorSql($this->Model->getPesoct()));
        $this->Model->setPrecofinal($this->ValorSql($this->Model->getPrecofinal()));


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    //retorna para para aberto
    public function msgReprovaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        //valida se foi apontado a observação
        $aRet = $this->Persistencia->validaObsRep($aCamposChave);
        if ($aRet[0] == true) {
            $oMensagem = new Modal('Reprovar projeto', 'Deseja reprovar o projeto nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","ReprovaProj","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Reprovar projeto', 'Atenção informe o campo observação final do projeto antes de reprovar! Projeto não reprovado!', Modal::TIPO_ERRO, false, true, true);
        }


        echo $oMensagem->getRender();
    }

    public function ReprovaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->reprovaProj($aCamposChave);
        if ($aRetorno[0] == true) {
            $oMensagem = new Mensagem('Reprovação', 'Reprovado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();

            echo"$('#" . $aDados[1] . "-pesq').click();";
            echo'requestAjax("","' . $sClasse . '","msgEnvReprov","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº' . $aCamposChave['nr'] . ' foi reprovado', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function msgEnvReprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Enviar reprovação', 'Deseja enviar reprovação do projeto nº' . $aCamposChave['nr'] . ' para vendas?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EnvReprov","' . $sDados . '");');


        echo $oMensagem->getRender();
    }

    public function EnvReprov($sDados) {
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

        $aObs = $this->Persistencia->buscaObs($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);
        $oCampos = $this->Persistencia->buscaDados($aCamposChave);

        $oEmail->setAssunto(utf8_decode('Entrada de projeto nº' . $aCamposChave['nr'] . ''));
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#FF0000"><b>REPROVADO</b></span> PELO SETOR DE PROJETOS.<hr><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%">'
                        . '<tr><td><b>Descrição:</b></td><td>' . $oCampos->desc_novo_prod . '</td></tr>'
                        . '<tr><td><b>Acabamento:</b></td><td>' . $oCampos->acabamento . '</td></tr>'
                        . '<tr><td><b>Quantidade:</b></td><td>' . number_format($oCampos->quant_pc, 2, ',', '.') . '</td></tr>'
                        . '<tr><td><b>Empresa:</b></td><td>' . $oCampos->empdes . '</td></tr>'
                        . '<tr><td><b>Observação Projetos/Motivo reprovação:</b></td><td>' . $aObs['ObsGeral'] . '</td></tr> </table>'
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));



        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        $aUserPlano = $this->Persistencia->projEmail($aCamposChave['EmpRex_filcgc'], $aCamposChave['nr']);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }


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

    public function msAprovaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        //verifica se campos obs, lote, peso foram informados
        $aRetorno = $this->Persistencia->validaObsPesoCt($aCamposChave);

        if ($aRetorno[0] == true) {
            $bRetorno2 = $this->Persistencia->validaProjAprov($aCamposChave);
            if ($bRetorno2) {
                $oMensagem = new Modal('Aprovar projeto', 'Deseja aprovar o projeto nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
                $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","aprovaproj","' . $sDados . '");');
            } else {
                $oMensagem = new Modal('Aprovar projeto', 'O projeto nº' . $aCamposChave['nr'] . ' já está aprovado!', Modal::TIPO_ERRO, FALSE, true, true);
            }
        } else {
            $oMensagem = new Modal('Aprovar projeto', 'O projeto nº' . $aCamposChave['nr'] . ' tem as seguintes pendências: ' . $aRetorno[1] . '', Modal::TIPO_ERRO, FALSE, true, true);
        }

        echo $oMensagem->getRender();
    }

    public function aprovaProj($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRetorno = $this->Persistencia->liberaProj($aCamposChave);
        if ($aRetorno[0] == true) {
            $oMensagem = new Mensagem('Atenção', 'O projeto nº' . $aRetorno[1] . ' foi aprovado com sucesso', Modal::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
            echo'requestAjax("","' . $sClasse . '","msgEnvAprov","' . $sDados . '");';
        } else {
            $oMensagem = new Modal('Atenção', 'O projeto nº' . $aCamposChave['nr'] . ' não foi aprovado', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function msgEnvAprov($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Enviar aprovação', 'Deseja enviar aprovação do projeto nº' . $aCamposChave['nr'] . ' para vendas?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EnvAprov","' . $sDados . '");');


        echo $oMensagem->getRender();
    }

    public function EnvAprov($sDados) {
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
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#006400"><b>APROVADO</b></span> PELO SETOR DE PROJETOS.<hr><br/>'
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
                        . '<tr><td><b>Observação:</b></td><td>' . $oDadosProj->replibobs . '</td></tr> '
                        . '<tr><td><b>Observação Projetos/Motivo reprovação:</b></td><td>' . $aObs['ObsGeral'] . '</td></tr> '
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

    /**
     * 
     * Mensagem de retorno para representante
     */
    public function msgRetRep($sDados) {

        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        //pesquisa se está liberado em projeto
        $bExecuta = $this->Persistencia->verifProjProj($aCamposChave);
        if ($bExecuta) {
            $oMensagem = new Modal('Retornar para representante', 'Deseja retornar o projeto nº' . $aCamposChave['nr'] . ' para o representante? --ATENÇÃO SERÁ RETORNADO TODAS AS SITUAÇÕES! ', Modal::TIPO_AVISO, true, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","retRepresentante","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Atenção', 'Verifique se o projeto nº' . $aCamposChave['nr'] . ' já não está liberado para o representante?', Modal::TIPO_ERRO, false, true, true);
        }

        echo $oMensagem->getRender();
    }

    /**
     * retorna representante
     */
    public function retRepresentante($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();


        $aRet = $this->Persistencia->retReprov($aCamposChave);



        if ($aRet[0]) {
            $oMensagem = new Mensagem('Retorno', 'Projeto retornado com sucesso!', Mensagem::TIPO_SUCESSO);
            $oMsgEmail = new Modal('Enviar aprovação', 'Deseja enviar e-mail do retorno do projeto nº' . $aCamposChave['nr'] . ' para o representante?', Modal::TIPO_AVISO, true, true, true);
            $oMsgEmail->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","EmailRetornaProj","' . $sDados . '");');
        } else {
            $oMensagem = new Modal('Atenção', 'Verifique a situação do projeto nº' . $aCamposChave['nr'] . ' já não está liberado para o representante', Modal::TIPO_ERRO, false, true, true);
        }

        echo $oMensagem->getRender();
        echo $oMsgEmail->getRender();
        echo"$('#" . $aDados[1] . "-pesq').click();";
    }

    public function EmailRetornaProj($sDados) {
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
        $oEmail->setMensagem(utf8_decode('ENTRADA DE PROJETO Nº ' . $aCamposChave['nr'] . ' FOI <span style="color:#006400"><b>RETORNADA</b></span> PELO SETOR DE PROJETOS.<hr><br/>'
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
                        . '<tr><td><b>Observação Projetos/Motivo retorno:</b></td><td>' . $aObs['ObsGeral'] . '</td></tr> '
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

    public function criaTelaModalProposta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $aCamposChave['id'] = $aDados[1];

        $oProposta = $this->Persistencia->buscaProposta($aCamposChave);
        $this->View->setAParametrosExtras($oProposta);

        $this->View->criaModalProposta();

        //adiciona onde será renderizado
        $sLimpa = "$('#" . $aDados[1] . "-modal').empty();";
        echo $sLimpa;
        $this->View->getTela()->setSRender($aDados[1] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }

}
