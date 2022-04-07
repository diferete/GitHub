<?php

/*
 * Implementa a classe controler STEEL_PCP_Certificado
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class ControllerSTEEL_PCP_Certificado extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Certificado');
    }

    /**
     * Envia o e-mail
     */
    public function geraPdfCert($sDados) {
        $aDados = explode(',', $sDados);

        $aNr = $_REQUEST['parametrosCampos'];
        sort($aNr);
        $sVethor = '';
        foreach ($aNr as $key => $value) {
            $aNrEnv = explode('=', $value);
            $sVethor .= 'nrcert[]=' . $aNrEnv[1] . '&';
            $aCert[$key] = $aNrEnv[1];
        }

        $_REQUEST['nrcert'] = $aCert;
        $_REQUEST['email'] = 'S';
        $_REQUEST['userRel'] = $_SESSION['nome'];


        //busca se há notas diferentes
        $aNotaCert = array();
        foreach ($aCert as $iCert) {
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert', $iCert);
            $oCertificadoNota = $this->Persistencia->consultarWhere();
            $aNotaSteel[] = $oCertificadoNota->getNotasteel();
        }
        $aNotaSteelUni = array_unique($aNotaSteel);
        $_REQUEST['notaRetorno'] = $aNotaSteelUni[0];
        if (count($aNotaSteelUni) > 1) {
            $oModal = new Modal('Atenção!', 'Existem notas diferentes selecionadas, selecione itens da mesma nota de retorno!', Modal::TIPO_AVISO, false);
            echo $oModal->getRender();
            exit();
        }


        $aEmp = array();
        foreach ($aCert as $iCert) {
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert', $iCert);
            $oCertificado = $this->Persistencia->consultarWhere();
            $aEmp[] = $oCertificado->getEmpcod();
        }
        $aEmpRep = array_unique($aEmp);


        if (count($aEmpRep) == 1) {
            $_REQUEST['empresaCert'] = $aEmpRep[0];
            $aEmail = require 'app/relatorio/CertificadoOpSteel.php';
            if ($aEmail[0]) {
                $this->Persistencia->mudaSit($aCert);
                echo"$('#" . $aDados[1] . "-pesq').click();";
            }
            //grava histórico
            foreach ($aCert as $i => $cert) {
                $sDest = '';
                $oHist = Fabrica::FabricarController('STEEL_PCP_histEmailcert');
                $oHist->Model->setNrcert($cert);
                $oHist->Model->setUserEmail($_SESSION['nome']);
                $oHist->Model->setData(date('d/m/Y'));
                $oHist->Model->setHora(date('H:i'));
                if ($aEmail[0]) {
                    $oHist->Model->setSitenv('Sucesso');
                } else {
                    $oHist->Model->setSitenv($aEmail[1]);
                }
                foreach ($aEmail[2] as $iDest => $sDestinatario) {
                    $sDest .= $sDestinatario . ';';
                }
                $oHist->Model->setDestinatario($sDest);
                $oHist->Persistencia->setModel($oHist->Model);
                $oHist->Persistencia->inserir();
            }
        } else {
            $oModal = new Modal('Atenção!', 'Existem empresas diferentes nos certificados escolhidos, seleciona apenas certificados da mesma empresa!', Modal::TIPO_AVISO, false);
            echo $oModal->getRender();
        }
    }

    public function acaoMostraRelCertificado($sDados) {

        parent::acaoMostraRelEspecifico($sDados);

        $aNr = $_REQUEST['parametrosCampos'];
        sort($aNr);
        $sVethor = '';
        foreach ($aNr as $key => $value) {
            $aNrEnv = explode('=', $value);
            $sVethor .= 'nrcert[]=' . $aNrEnv[1] . '&';
        }

        //busca se há notas diferentes
        $aNotaCert = array();
        foreach ($aNr as $iCert) {
            $aCertEnv = explode('=', $iCert);
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('nrcert', $aCertEnv[1]);
            $oCertificadoNota = $this->Persistencia->consultarWhere();
            $aNotaSteel[] = $oCertificadoNota->getNotasteel();
        }
        $aNotaSteelUni = array_unique($aNotaSteel);
        $_REQUEST['notaRetorno'] = $aNotaSteelUni[0];
        if (count($aNotaSteelUni) > 1) {
            $oModal = new Modal('Atenção!', 'Existem notas diferentes selecionadas, selecione itens da mesma nota de retorno!', Modal::TIPO_AVISO, false);
            echo $oModal->getRender();
            exit();
        }

        // exemplo.php?vetor[]=valor1&vetor[]=valor2&vetor[]=valor3

        $sSistema = "app/relatorio";
        $sRelatorio = 'CertificadoOpSteel.php?' . $sVethor;

        $sCampos .= $this->getSget();
        $sCampos .= '&notaRetorno=' . $aNotaSteelUni[0];

        $sCampos .= '&output=tela';
        $oWindow = 'window.open("' . $sSistema . '/' . $sRelatorio . '' . $sCampos . '", "' . $sRel . $sCampos . '", "STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=30, WIDTH=1200, HEIGHT=700");';
        echo $oWindow;
    }

    public function consultaOpDados($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //verifica se tem uma op válida

        $oOpSteel = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oDados = $oOpSteel->consultaOp($aCampos['op']);

        if ($oDados->getSituacao()=='Aberta' || $oDados->getSituacao()=='Processo') {
            $oModal = new Modal('Atenção', 'Essa OP está em situação '.$oDados->getSituacao().', não pode gerar Certificado!', Modal::TIPO_ERRO, false);
            echo $oModal->getRender();
            exit();
        }

        if ($oDados->getOp() == null) {
            $oMensagem = new Mensagem('Atenção!', 'Ordem de produção não foi localizada!', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            echo '$("#' . $aId[0] . '").val("");'
            . '$("#' . $aId[1] . '").val("");'
            . '$("#' . $aId[2] . '").val("");'
            . '$("#' . $aId[3] . '").val("");'
            . '$("#' . $aId[4] . '").val("");'
            . '$("#' . $aId[5] . '").val("");'
            . '$("#' . $aId[6] . '").val("");'
            . '$("#' . $aId[7] . '").val("");';
        } else {

            $oDados->setProdes(str_replace("\n", " ", $oDados->getProdes()));
            $oDados->setProdes(str_replace("'", "\'", $oDados->getProdes()));
            $oDados->setProdes(str_replace("\r", "", $oDados->getProdes()));
            $oDados->setProdes(str_replace('"', '\"', $oDados->getProdes()));


            if ($aId[8] == 'leitor') {

                if ($oDados->getTipoOrdem() == 'P' || $oDados->getTipoOrdem() == 'TZ' || $oDados->getTipoOrdem() == 'Z') {
                    echo '$(".nav-tabs a[href=\"#' . $aId[20] . '\"]").tab("show");';
                }
                if ($oDados->getTipoOrdem() == 'F' || $oDados->getTipoOrdem() == 'A') {
                    echo '$(".nav-tabs a[href=\"#' . $aId[19] . '\"]").tab("show");';
                }

                $bAlterar = $this->verificaCertOp();
                if ($bAlterar) {

                    $oOpCert = Fabrica::FabricarController('STEEL_PCP_Certificado');
                    $oOpCert->Persistencia->adicionaFiltro('op', $aCampos['op']);
                    $oDadosCert = $oOpCert->Persistencia->consultarWhere();

                    //Habilita campos antes de desabilitar caso tenha digitado OP errada
                    $this->habilitaCampos();

                    echo '$("#' . $aId[0] . '").val("");'
                    . '$("#' . $aId[1] . '").val("");'
                    . '$("#' . $aId[2] . '").val("");'
                    . '$("#' . $aId[3] . '").val("");'
                    . '$("#' . $aId[4] . '").val("");'
                    . '$("#' . $aId[5] . '").val("");'
                    . '$("#' . $aId[6] . '").val("");'
                    . '$("#' . $aId[7] . '").val("");'
                    . '$("#' . $aId[8] . '").val("");'
                    . '$("#' . $aId[9] . '").val("");'
                    . '$("#' . $aId[10] . '").val("");'
                    . '$("#' . $aId[11] . '").val("");'
                    . '$("#' . $aId[12] . '").val("");'
                    . '$("#' . $aId[13] . '").val("");'
                    . '$("#' . $aId[14] . '").val("");'
                    . '$("#' . $aId[15] . '").val("");'
                    . '$("#' . $aId[16] . '").val("");'
                    . '$("#' . $aId[17] . '").val("");'
                    . '$("#' . $aId[18] . '").val("");'
                    . '$("#CertFioDurezaSol").val("");'
                    . '$("#CertFioEsferio").val("");'
                    . '$("#CertFioDescarbonetaTotal").val("");'
                    . '$("#CertFioDescarbonetaParcial").val("");'
                    . '$("#CertDiamFinalMin").val("");'
                    . '$("#CertDiamFinalMax").val("");'
                    . '$("#CertMicroGrafia").val("");'
                    . '$("#Certrnc").val("");'
                    . '$("#CertificadoData").val("");'
                    . '$("#CertificadoHora").val("");'
                    . '$("#CertificadoUsuario").val("");'
                    . '$("#' . $aId[0] . '").val("' . $oDadosCert->getEmpcod() . '");'
                    . '$("#' . $aId[1] . '").val("' . $oDadosCert->getEmpdes() . '");'
                    . '$("#' . $aId[2] . '").val("' . $oDadosCert->getProcod() . '");'
                    . '$("#' . $aId[3] . '").val("' . addslashes($oDadosCert->getProdes()) . '");'
                    . '$("#' . $aId[4] . '").val("' . $oDadosCert->getOpcliente() . '");'
                    . '$("#' . $aId[5] . '").val("' . number_format($oDadosCert->getPeso(), 2, ',', '.') . '");'
                    . '$("#' . $aId[6] . '").val("' . $oDadosCert->getNotacliente() . '");'
                    . '$("#' . $aId[7] . '").val("' . number_format($oDadosCert->getQuant(), 2, ',', '.') . '");'
                    . '$("#' . $aId[9] . '").val("' . number_format($oDadosCert->getDurezaSuperfMin(), 2, ',', '.') . '");'
                    . '$("#' . $aId[10] . '").val("' . number_format($oDadosCert->getDurezaSuperfMax(), 2, ',', '.') . '");'
                    . '$("#' . $aId[11] . '").val("' . $oDadosCert->getSuperEscala() . '");'
                    . '$("#' . $aId[12] . '").val("' . number_format($oDadosCert->getDurezaNucMin(), 2, ',', '.') . '");'
                    . '$("#' . $aId[13] . '").val("' . number_format($oDadosCert->getDurezaNucMax(), 2, ',', '.') . '");'
                    . '$("#' . $aId[14] . '").val("' . $oDadosCert->getNucEscala() . '");'
                    . '$("#' . $aId[15] . '").val("' . $oDadosCert->getExpCamadaMin() . '");'
                    . '$("#' . $aId[16] . '").val("' . $oDadosCert->getExpCamadaMax() . '");'
                    . '$("#' . $aId[17] . '").val("' . $oDadosCert->getInspeneg() . '");'
                    . '$("#' . $aId[18] . '").val("' . $oDadosCert->getConclusao() . '");'
                    . '$("#CertFioDurezaSol").val("' . $oDadosCert->getFioDurezaSol() . '");'
                    . '$("#CertFioEsferio").val("' . $oDadosCert->getFioEsferio() . '");'
                    . '$("#CertFioDescarbonetaTotal").val("' . $oDadosCert->getFioDescarbonetaTotal() . '");'
                    . '$("#CertFioDescarbonetaParcial").val("' . $oDadosCert->getFioDescarbonetaParcial() . '");'
                    . '$("#CertDiamFinalMin").val("' . $oDadosCert->getDiamFinalMin() . '");'
                    . '$("#CertDiamFinalMax").val("' . $oDadosCert->getDiamFinalMax() . '");'
                    . '$("#CertMicroGrafia").val("' . $oDadosCert->getMicrografia() . '");'
                    . '$("#Certrnc").val("' . $oDadosCert->getRnc() . '");'
                    . '$("#CertificadoData").val("' . date('d/m/Y') . '");'
                    . '$("#CertificadoHora").val("' . date('H:i') . '");'
                    . '$("#CertificadoUsuario").val("' . $_SESSION['nome'] . '");';

                    //Chama método para desabilitar e alterar foco
                    $this->desabilitaEalteraFoco($aId, $oDados);

                    $oMensagem = new Modal('Atenção!', 'Op já possui certificado atrelado, se deseja alterar tome cuidado ao preencher os valores encontrados!', Modal::TIPO_AVISO);
                    echo $oMensagem->getRender();
                } else {

                    //--------------Inicio Parte da Conclusão-------------------//
                    $oOpGera = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
                    $oOpGera->Persistencia->adicionaFiltro('op', $aCampos['op']);
                    $oDadosOpGera = $oOpGera->Persistencia->consultarWhere();

                    $oCert = Fabrica::FabricarController('STEEL_PCP_Certificado');
                    $oCert->Persistencia->adicionaFiltro('nrcert', $oDadosOpGera->getNrcert());
                    $oDadosCert2 = $oCert->Persistencia->consultarWhere();

                    $oProdMatReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
                    $oProdMatReceita->Persistencia->adicionaFiltro('seqmat', $oDadosOpGera->getSeqmat());
                    $oDadosProdMat = $oProdMatReceita->Persistencia->consultarWhere();

                    //conclusão
                    if ($oDadosCert2->getConclusao() !== null) {
                        $oConclusao = ('' . $oDadosProdMat->getObs() . '   ' . $oDadosOpGera->getObs() . '  ' . $oDadosCert2->getConclusao());
                    } else {
                        $oConclusao = ('' . $oDadosProdMat->getObs() . '  ' . $oDadosOpGera->getObs() . '  ' . $oDadosCert2->getConclusao() . ' Foram atingidas suas especificações conforme solicitado no documento de remessa.');
                    }
                    //--------------Fim Parte da Conclusão-------------------//

                    echo ('$("#' . $aId[0] . '").val("");'
                    . '$("#' . $aId[1] . '").val("");'
                    . '$("#' . $aId[2] . '").val("");'
                    . '$("#' . $aId[3] . '").val("");'
                    . '$("#' . $aId[4] . '").val("");'
                    . '$("#' . $aId[5] . '").val("");'
                    . '$("#' . $aId[6] . '").val("");'
                    . '$("#' . $aId[7] . '").val("");'
                    . '$("#' . $aId[9] . '").val("");'
                    . '$("#' . $aId[10] . '").val("");'
                    . '$("#' . $aId[12] . '").val("");'
                    . '$("#' . $aId[13] . '").val("");'
                    . '$("#' . $aId[15] . '").val("");'
                    . '$("#' . $aId[16] . '").val("");'
                    . '$("#CertFioDurezaSol").val("");'
                    . '$("#CertFioEsferio").val("");'
                    . '$("#CertFioDescarbonetaTotal").val("");'
                    . '$("#CertFioDescarbonetaParcial").val("");'
                    . '$("#CertDiamFinalMin").val("");'
                    . '$("#CertDiamFinalMax").val("");'
                    . '$("#Certrnc").val("");'
                    . '$("#CertificadoData").val("");'
                    . '$("#CertificadoHora").val("");'
                    . '$("#CertificadoUsuario").val("");'
                    . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_codigo() . '");'
                    . '$("#' . $aId[1] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                    . '$("#' . $aId[2] . '").val("' . $oDados->getProd() . '");'
                    . '$("#' . $aId[3] . '").val("' . addslashes($oDados->getProdes()) . '");'
                    . '$("#' . $aId[4] . '").val("' . $oDados->getOpcliente() . '");'
                    . '$("#' . $aId[5] . '").val("' . number_format($oDados->getPeso(), 2, ',', '.') . '");'
                    . '$("#' . $aId[6] . '").val("' . $oDados->getDocumento() . '");'
                    . '$("#' . $aId[7] . '").val("' . number_format($oDados->getQuant(), 2, ',', '.') . '");'
                    . '$("#' . $aId[18] . '").val("' . $oConclusao . '");'
                    . '$("#CertificadoData").val("' . date('d/m/Y') . '");'
                    . '$("#CertificadoHora").val("' . date('H:i') . '");'
                    . '$("#CertificadoUsuario").val("' . $_SESSION['nome'] . '");');

                    //Habilita campos antes de desabilitar caso tenha digitado OP errada
                    $this->habilitaCampos();
                    //Chama método para desabilitar e alterar foco
                    $this->desabilitaEalteraFoco($aId, $oDados);
                }
            } else {
                //coloca os dados na view  getProd()
                echo '$("#' . $aId[0] . '").val("");'
                . '$("#' . $aId[1] . '").val("");'
                . '$("#' . $aId[2] . '").val("");'
                . '$("#' . $aId[3] . '").val("");'
                . '$("#' . $aId[4] . '").val("");'
                . '$("#' . $aId[5] . '").val("");'
                . '$("#' . $aId[6] . '").val("");'
                . '$("#' . $aId[7] . '").val("");'
                . '$("#' . $aId[0] . '").val("' . $oDados->getEmp_codigo() . '");'
                . '$("#' . $aId[1] . '").val("' . $oDados->getEmp_razaosocial() . '");'
                . '$("#' . $aId[2] . '").val("' . $oDados->getProd() . '");'
                . '$("#' . $aId[3] . '").val("' . addslashes($oDados->getProdes()) . '");'
                . '$("#' . $aId[4] . '").val("' . $oDados->getOpcliente() . '");'
                . '$("#' . $aId[5] . '").val("' . number_format($oDados->getPeso(), 2, ',', '.') . '");'
                . '$("#' . $aId[6] . '").val("' . $oDados->getDocumento() . '");'
                . '$("#' . $aId[7] . '").val("' . number_format($oDados->getQuant(), 2, ',', '.') . '");';
            }
        }
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $aRender = explode(',', $sParametros);

        $sChave = htmlspecialchars_decode($aRender[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if (count($aCamposChave) > 0) {

            $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
            $oOp->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
            $oDadosOp = $oOp->Persistencia->consultarWhere();

            $this->View->setAParametrosExtras($oDadosOp);

            if ($oDadosOp->getNrcert()) {
                $oModal = new Modal('Atenção!', 'Esta ordem de produção já tem um certificado atrelado!', Modal::TIPO_AVISO);
                echo $oModal->getRender();
                echo ' $("#' . $aRender[1] . 'consulta").show(); ';
                exit();
            }
        }

        echo ' $("#' . $aRender[1] . 'consulta").hide(); ';
    }

    public function afterInsert() {
        parent::afterInsert();

        //instancia classe 
        $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
        $oOp->Persistencia->putCertOp($this->Model);


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterDelete() {
        parent::afterDelete();

        $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
        $oOp->Persistencia->limpaCert($this->Model);


        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iCon = $oOp->Persistencia->getCount();
        if ($iCon == 0) {
            $oModal = new Modal('Atenção', 'Essa op não existe, forneça uma ordem de produção existente!', Modal::TIPO_ERRO, false);
            echo $oModal->getRender();
        }
        //Parte de validações ? verificar se necessário gravar na observação
        $oDadosOp = $oOp->Persistencia->consultarWhere();
        $aInfo = $this->validaValoresCert($oDadosOp);
        
        //Parte para manter sempre como não aplicável campo inspeção
        $oProdMatReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $oProdMatReceita->Persistencia->adicionaFiltro('seqmat', $oDadosOp->getSeqmat());
        $oDadosProdMat = $oProdMatReceita->Persistencia->consultarWhere();
        $sTrat = $oDadosProdMat->getTratrevencomp();
        if ($sTrat == "À SECO") {
            $this->Model->setInspeneg("Não Aplicável");
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $this->Model->getOp());
        $iCon = $oOp->Persistencia->getCount();
        if ($iCon == 0) {
            $oModal = new Modal('Atenção', 'Essa op não existe, forneça uma ordem de produção existente!', Modal::TIPO_ERRO, false);
            echo $oModal->getRender();
        }
        //Parte de validações ? verificar se necessário gravar na observação
        $oDadosOp = $oOp->Persistencia->consultarWhere();
        $aInfo = $this->validaValoresCert($oDadosOp);
        
        //Parte para manter sempre como não aplicável campo inspeção
        $oProdMatReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $oProdMatReceita->Persistencia->adicionaFiltro('seqmat', $oDadosOp->getSeqmat());
        $oDadosProdMat = $oProdMatReceita->Persistencia->consultarWhere();
        $sTrat = $oDadosProdMat->getTratrevencomp();
        if ($sTrat == "À SECO") {
            $this->Model->setInspeneg("Não Aplicável");
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function validaValoresCert($oOp) {

        $aInfo = array();

        if ($this->Model->getDurezaNucMin() == null) {
            $this->Model->setDurezaNucMin(0);
        }
        if ($oOp->getDurezaNucMin() == null) {
            $oOp->setDurezaNucMin(0);
        }
        if ($this->Model->getDurezaNucMax() == null) {
            $this->Model->setDurezaNucMax(0);
        }
        if ($oOp->getDurezaNucMax() == null) {
            $oOp->setDurezaNucMax(0);
        }
        if ($this->Model->getDurezaSuperfMin() == null) {
            $this->Model->setDurezaSuperfMin(0);
        }
        if ($oOp->getDurezaSuperfMin() == null) {
            $oOp->setDurezaSuperfMin(0);
        }
        if ($this->Model->getDurezaSuperfMax() == null) {
            $this->Model->setDurezaSuperfMax(0);
        }
        if ($oOp->getDurezaSuperfMax() == null) {
            $oOp->setDurezaSuperfMax(0);
        }
        if ($this->Model->getExpCamadaMin() == null) {
            $this->Model->setExpCamadaMin(0);
        }
        if ($oOp->getExpCamadaMin() == null) {
            $oOp->setExpCamadaMin(0);
        }
        if ($this->Model->getExpCamadaMax() == null) {
            $this->Model->setExpCamadaMax(0);
        }
        if ($oOp->getExpCamadaMax() == null) {
            $oOp->setExpCamadaMax(0);
        }
        if ($this->Model->getRnc() == null) {
            if (($oOp->getDurezaNucMin()) > ($this->Model->getDurezaNucMin())) {
                $aInfo = "Certificado não gravado! Dureza mínima do núcleo encontrada está abaixo da Dureza mínima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaNucMax()) < ($this->Model->getDurezaNucMin()) && ($oOp->getDurezaNucMax() !== ".0000" && $oOp->getDurezaNucMax() !== 0)) {
                $aInfo = "Certificado não gravado! Dureza mínima do núcleo encontrada está acima da Dureza máxima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaNucMax()) < ($this->Model->getDurezaNucMax()) && ($oOp->getDurezaNucMax() !== ".0000" && $oOp->getDurezaNucMax() !== 0)) {
                $aInfo = "Certificado não gravado! Dureza máxima do núcleo encontrada está acima da Dureza máxima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaNucMin()) > ($this->Model->getDurezaNucMax())) {
                $aInfo = "Certificado não gravado! Dureza máxima do núcleo encontrada está abaixo da Dureza mínima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            //Validação valores max nunca pode ser menor do que mínimo
            if (($this->Model->getDurezaNucMax()) < ($this->Model->getDurezaNucMin())) {
                $aInfo = "Certificado não gravado! Dureza maxima do núcleo encontrada está abaixo da Dureza mínima encontrada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaSuperfMin()) > ($this->Model->getDurezaSuperfMin())) {
                $aInfo = "Certificado não gravado! Dureza minima da superfície encontrada está abaixo da Dureza mínima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaSuperfMax()) < ($this->Model->getDurezaSuperfMin()) && ($oOp->getDurezaSuperfMax() !== ".0000" && $oOp->getDurezaSuperfMax() !== 0)) {
                $aInfo = "Certificado não gravado! Dureza minima da superfície encontrada está acima da Dureza máxima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaSuperfMax()) < ($this->Model->getDurezaSuperfMax()) && ($oOp->getDurezaSuperfMax() !== ".0000" && $oOp->getDurezaSuperfMax() !== 0)) {
                $aInfo = "Certificado não gravado! Dureza máxima da superfície encontrada está acima da Dureza máxima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getDurezaSuperfMin()) > ($this->Model->getDurezaSuperfMax())) {
                $aInfo = "Certificado não gravado! Dureza máxima da superfície encontrada está abaixo da Dureza mínima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            //Validação valores max nunca pode ser menor do que mínimo
            if (($this->Model->getDurezaSuperfMax()) < ($this->Model->getDurezaSuperfMin())) {
                $aInfo = "Certificado não gravado! Dureza maxima do superfície encontrada está abaixo da Dureza mínima encontrada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getExpCamadaMin()) > ($this->Model->getExpCamadaMin())) {
                $aInfo = "Certificado não gravado! Camada minima encontrada está abaixo da Camada mínima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getExpCamadaMax()) < ($this->Model->getExpCamadaMin()) && ($oOp->getExpCamadaMax() !== ".0000" && $oOp->getExpCamadaMax() !== 0)) {
                $aInfo = "Certificado não gravado! Camada minima encontrada está acima da Camada máxima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getExpCamadaMax()) < ($this->Model->getExpCamadaMax()) && ($oOp->getExpCamadaMax() !== ".0000" && $oOp->getExpCamadaMax() !== 0)) {
                $aInfo = "Certificado não gravado! Camada máxima encontrada está acima da Camada máxima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            if (($oOp->getExpCamadaMin()) > ($this->Model->getExpCamadaMax())) {
                $aInfo = "Certificado não gravado! Camada máxima encontrada está abixo da Camada mínima solicitada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
            //Validação valores max nunca pode ser menor do que mínimo
            if (($this->Model->getExpCamadaMax()) < ($this->Model->getExpCamadaMin())) {
                $aInfo = "Certificado não gravado! Camada máxima encontrada está abaixo da Camada mínima encontrada!";
                $oModal = new Modal('Atenção!', $aInfo, Modal::TIPO_AVISO, false);
                echo $oModal->getRender();
                exit;
            }
        }
        return $aInfo;
    }

    /**
     * Modal apontamentos certificado
     */
    public function criaTelaModalAponta($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aFilcgc = explode('=', $aChave[0]);
        $aPedido = explode('=', $aChave[1]);
        $aSeq = explode('=', $aChave[2]);

        //busca a op
        $oCargaInsumoServ = Fabrica::FabricarController('STEEL_PCP_CargaInsumoServ');
        $oCargaInsumoServ->Persistencia->adicionaFiltro('pdv_pedidofilial', $aFilcgc[1]);
        $oCargaInsumoServ->Persistencia->adicionaFiltro('pdv_pedidocodigo', $aPedido[1]);
        $oCargaInsumoServ->Persistencia->adicionaFiltro('pdv_pedidoitemseq', $aSeq[1]);
        $oDadosCarga = $oCargaInsumoServ->Persistencia->consultarWhere();

        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $oDadosCarga->getOp());

        $oDados = $oOp->Persistencia->consultarWhere();


        $this->View->setAParametrosExtras($oDados);

        $this->View->criaTelaModal($aDados[3]);
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
    }

    public function geraCertCarga($sDados) {
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        //verifica se já existe o certificado para alterá-lo
        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpDados = $oOp->Persistencia->consultarWhere();
        //verifica se há o certificado
        $oCert = Fabrica::FabricarController('STEEL_PCP_Certificado');
        $oCert->Persistencia->adicionaFiltro('nrcert', $oOpDados->getNrcert());
        $iCert = $oCert->Persistencia->getCount();
        //se não há certificad na tabela gera o insert de um novo certificado
        if ($iCert > 0) {
            $this->alteraCertModal($sDados);
        } else {
            $this->insereCertificadoModal($sDados);
        }
    }

    public function insereCertificadoModal($sDados) {
        $aDados = explode(',', $sDados);
        $aId = explode(',', $sDados);
        //captura a op da tela
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        //inicia gravação
        $this->Persistencia->iniciaTransacao();
        $aRetorno[0] = true;
        //carrega o model
        $this->View->criaTela();
        $aCamposTela = $this->View->getTela()->getCampos();
        $this->carregaModel($aCamposTela);
        //carrega os dados que nao temos

        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpDados = $oOp->Persistencia->consultarWhere();

        $this->Model->setPeso($oOpDados->getPeso());
        $this->Model->setQuant($oOpDados->getQuant());
        $this->Model->setNotacliente($oOpDados->getDocumento());
        $this->Model->setOpcliente($oOpDados->getOpcliente());
        $this->Model->setEmpcod($oOpDados->getEmp_codigo());
        $this->Model->setEmpdes($oOpDados->getEmp_razaosocial());

        if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->inserir();
        }

        if ($aRetorno[0]) {
            $aRetorno = $this->afterInsert();
            $this->Persistencia->commit();
        }

        if ($aRetorno[0]) {
            //atualiza nr do certificado na ordem e produção
            $oGeraCert = Fabrica::FabricarPersistencia('STEEL_PCP_GeraCertificado');

            $oGeraCert->putCertOp($this->Model);
            $oMsg = new Mensagem('Sucesso!', 'Registro inserido com sucesso...', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo'$("#modalApontaItem-btn").click();';
            echo '$("#' . $aDados[2] . '").focus();';
        } else {
            $this->Persistencia->rollback();
            $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
    }

    public function alteraCertModal($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $this->View->criaTela();

        $aRetorno[0] = true;
        //traz lista campos
        $aCamposTela = $this->View->getTela()->getCampos();

//        if ($this->View->getBGravaHistorico() == true) {
//            $this->gravaHistorico('Alterar');
//        }

        $this->Persistencia->iniciaTransacao();

        $aChaveMestre = $this->Persistencia->getChaveArray();
        foreach ($aChaveMestre as $oCampoBanco) {
            if ($oCampoBanco->getPersiste()) {
                $this->setValorModel($this->Model, $oCampoBanco->getNomeModel(), $xValor, $aCamposTela);
            }
        }
        $this->Model = $this->Persistencia->consultar();

        $this->carregaModel($aCamposTela);

        //carrega os dados que nao temos

        $oOp = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oOp->Persistencia->adicionaFiltro('op', $aCampos['op']);
        $oOpDados = $oOp->Persistencia->consultarWhere();

        $this->Model->setPeso($oOpDados->getPeso());
        $this->Model->setQuant($oOpDados->getQuant());
        $this->Model->setNotacliente($oOpDados->getDocumento());
        $this->Model->setOpcliente($oOpDados->getOpcliente());
        $this->Model->setEmpcod($oOpDados->getEmp_codigo());
        $this->Model->setEmpdes($oOpDados->getEmp_razaosocial());

        if ($aRetorno[0]) {
            $aRetorno = $this->beforeUpdate();
        }

        if ($aRetorno[0]) {
            $aRetorno = $this->Persistencia->alterar();
        }

        if ($aRetorno[0]) {
            $this->Persistencia->commit();
            //MENSAGEM SUCESSO
            $oMsg = new Mensagem('Sucesso!', 'Seu registro foi alterado com sucesso...', Mensagem::TIPO_SUCESSO);
            echo $oMsg->getRender();
            echo'$("#modalApontaItem-btn").click();';
            echo '$("#' . $aDados[2] . '").focus();';
        } else {
            $this->Persistencia->rollback();
            $oMsg = new Mensagem('Erro!', 'Seu registro não foi alterado.', Mensagem::TIPO_ERROR);
            echo $oMsg->getRender();
        }
    }

    /**
     * Função para atualiza número de notas fiscais com seus certificados
     * @param type $sParametros
     */
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $oCertificado = Fabrica::FabricarController('STEEL_PCP_Certificado');
        $oCertificado->Persistencia->atualizaNotaCertificado();
    }

    //Método que altera e insere dados do certificado de acordo com a OP
    public function acaoInserirLeitor($sId) {

        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $bAlterar = false;
        $oOp = '';
        $oDadosOp = '';

        if (count($aCamposChave) > 0) {

            $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
            $oOp->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
            $oDadosOp = $oOp->Persistencia->consultarWhere();

            $this->View->setAParametrosExtras($oDadosOp);

            if ($oDadosOp->getNrcert()) {
                $bAlterar = true;
            }
        }
        
        /*
         * Parte responsável por alterar
         */
        if ($bAlterar) {

            $oOpCert = Fabrica::FabricarController('STEEL_PCP_Certificado');
            $oOpCert->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
            $oDadosOpCert = $oOpCert->Persistencia->consultarWhere();

            if ($oDadosOpCert->getNotasteel() != 0 && $oDadosOpCert->getNotasteel() != null) {
                $oModal = new Modal('Atenção!', 'Esta OP já tem um certificado atrelado e uma nota de retorno! Não pode ser alterada!', Modal::TIPO_AVISO);
                echo $oModal->getRender();
                exit();
            }

            $aDados = explode(',', $sId);
            $sForm = $aDados[0];
            $sCampoInc = $aDados[1];
            $sIdOP = $aDados[2];
            $aRetorno[0] = true;

            $this->antesDeCriarTela();
            //cria a tela
            $this->View->criaTela();

            //traz lista campos
            $aCamposTela = $this->View->getTela()->getCampos();

            if ($this->View->getBGravaHistoricoAlterar() == true) {
                $this->gravaHistorico('Alterar', null);
            }

            $this->Persistencia->iniciaTransacao();


            $aChaveMestre = $this->Persistencia->getChaveArray();
            foreach ($aChaveMestre as $oCampoBanco) {
                if ($oCampoBanco->getPersiste()) {
                    $this->setValorModel($this->Model, $oCampoBanco->getNomeModel(), $xValor, $aCamposTela);
                }
            }
            $this->Model = $this->Persistencia->consultar();
            $this->antesCarregarModel();
            $this->carregaModel($aCamposTela);
            $this->Model->setNrcert($oDadosOp->getNrcert());

            //alterar dependências
            $aRetorno = $this->acaoAlterarDependencias();

            if ($aRetorno[0]) {
                $aRetorno = $this->beforeUpdate();
            }

            if ($aRetorno[0]) {
                $aRetorno = $this->Persistencia->alterar();
            }

            if ($aRetorno[0]) {
                $aRetorno = $this->afterUpdate();
            }

            if ($aRetorno[0]) {

                $this->Persistencia->commit();

                $aRetorno = $this->afterCommitUpdate();
                if ($aRetorno[0]) {
                    $sAcoesExtras = $aRetorno[2];
                }
                //MENSAGEM SUCESSO
                $oMsg = new Mensagem('Sucesso!', 'Seu registro foi alterado com sucesso...', Mensagem::TIPO_SUCESSO);
                echo $oMsg->getRender();
//                $oLimpa = new Base();
//                $iAutoInc = $this->retornaValuInc();
//                $msg = "" . $oLimpa->limpaForm($sForm) . ""
//                        . "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
//                echo $msg;
//
//                //chama método após limpar os forms dos campos
//                $this->afterResetForm($aDados);
//                echo ("" . $oLimpa->focus($sIdOP) . "");
            } else {
                $this->Persistencia->rollback();
                $oMsg = new Mensagem('Erro!', 'Seu registro não foi alterado.', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
                exit;
            }
        }
        /*
         * Parte responsável por alterar
         */ else {

            $aDados = explode(',', $sId);
            $sForm = $aDados[0];
            $sCampoInc = $aDados[1];
            $sIdOP = $aDados[2];
            //adiciona filtros extras
            $this->adicionaFiltrosExtras();
            //necessidade de colocar novos filtros mas limpa os anteriores
            $this->adicionaFiltroDet2();


            $this->Persistencia->iniciaTransacao();

            //array de controle de erros
            $aRetorno[0] = true;

            //traz lista campos
            $this->View->criaTela();
            $aCamposTela = $this->View->getTela()->getCampos();

            $this->carregaModel($aCamposTela);

            $aRetorno = $this->beforeInsert();

            if ($aRetorno[0]) {
                $aRetorno = $this->Persistencia->inserir();
            }

            if ($aRetorno[0]) {
                $aRetorno = $this->afterInsert();
                $this->Persistencia->commit();
            }

            if ($aRetorno[0]) {
                $aRetorno = $this->afterInsertDetalhe();
            }

            //instancia a classe mensagem
            if ($aRetorno[0]) {
                $oMsg = new Mensagem('Sucesso!', 'Registro inserido com sucesso...', Mensagem::TIPO_SUCESSO);
                echo $oMsg->getRender();
//                //limpa uploads se necessário
//                $this->limpaUploads($aDados);
//                $oLimpa = new Base();
//                //retorna aut incremento
//                $iAutoInc = $this->retornaValuInc();
//
//                $msg = "" . $oLimpa->limpaForm($sForm) . ""
//                        . "" . $this->View->getAutoIncremento($sCampoInc, $iAutoInc) . "";
//                echo $msg;
//
//                //chama método após limpar os forms dos campos
//                $this->afterResetForm($aDados);
//                echo ("" . $oLimpa->focus($sIdOP) . "");
            } else {
                $oMsg = new Mensagem('ERRO AO INSERIR', 'Seu registro não foi inserido!', Mensagem::TIPO_ERROR);
                echo $oMsg->getRender();
                exit;
            }
        }

        $this->habilitaCampos();
        echo '$("#btn_imprimecertificado").click();';
    }

    public function verificaCertOp() {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $bAlterar = false;

        if (count($aCamposChave) > 0) {
            $oOp = Fabrica::FabricarController('STEEL_PCP_GeraCertificado');
            $oOp->Persistencia->adicionaFiltro('op', $aCamposChave['op']);
            $oDadosOp = $oOp->Persistencia->consultarWhere();

            $this->View->setAParametrosExtras($oDadosOp);

            if ($oDadosOp->getNrcert()) {
                $bAlterar = true;
            }
        }
        return $bAlterar;
    }

    /**
     * Habilita os campos após a inserção
     */
    public function habilitaCampos() {

        echo '$("#CertSupDurMin").prop("disabled", false);';
        echo '$("#CertSupDurMax").prop("disabled", false);';
        echo '$("#CertSupEscala").prop("disabled", false);';
        echo '$("#CertNucDurMin").prop("disabled", false);';
        echo '$("#CertNucDurMax").prop("disabled", false);';
        echo '$("#CertNucEscala").prop("disabled", false);';
        echo '$("#CertexpCamadaMin").prop("disabled", false);';
        echo '$("#CertexpCamadaMax").prop("disabled", false);';
        echo '$("#Certinspeneg").prop("disabled", false);';
        echo '$("#CertFioDurezaSol").prop("disabled", false);';
        echo '$("#CertFioEsferio").prop("disabled", false);';
        echo '$("#CertFioDescarbonetaTotal").prop("disabled", false);';
        echo '$("#CertFioDescarbonetaParcial").prop("disabled", false);';
        echo '$("#CertDiamFinalMin").prop("disabled", false);';
        echo '$("#CertDiamFinalMax").prop("disabled", false);';
    }

    /**
     * Método que desabilita campos e altera o foco de acordo com o cadastro na prodMatReceita (Dados vem da tabela Steel_pcp_ordensFab
     * @param type $aId
     * @param type $oDados
     */
    public function desabilitaEalteraFoco($aId, $oDados) {
        $bFoco = false;
        //Inicio dos Ifs para setar foco no campo que deseja e bloquear os demais que não possuem valores
        if (($oDados->getDurezaSuperfMin() != 0 && $oDados->getDurezaSuperfMin() != null) || ($oDados->getDurezaSuperfMax() != 0 && $oDados->getDurezaSuperfMax() != null)) {
            echo '$("#' . $aId[9] . '").focus();';
            $bFoco = true;
        } else {
            echo '$("#' . $aId[9] . '").prop("disabled", true);';
            echo '$("#' . $aId[10] . '").prop("disabled", true);';
            echo '$("#' . $aId[11] . '").prop("disabled", true);';
        }
        if (($oDados->getDurezaNucMin() != 0 && $oDados->getDurezaNucMin() != null) || ($oDados->getDurezaNucMax() != 0 && $oDados->getDurezaNucMax() != null)) {
            if (!$bFoco) {
                echo '$("#' . $aId[12] . '").focus();';
                $bFoco = true;
            }
        } else {
            echo '$("#' . $aId[12] . '").prop("disabled", true);';
            echo '$("#' . $aId[13] . '").prop("disabled", true);';
            echo '$("#' . $aId[14] . '").prop("disabled", true);';
        }
        if (($oDados->getExpCamadaMin() != 0 && $oDados->getExpCamadaMin() != null) || ($oDados->getExpCamadaMax() != 0 && $oDados->getExpCamadaMax() != null)) {
            if (!$bFoco) {
                echo '$("#' . $aId[15] . '").focus();';
                $bFoco = true;
            }
        } else {
            echo '$("#' . $aId[15] . '").prop("disabled", true);';
            echo '$("#' . $aId[16] . '").prop("disabled", true);';
        }
        if (($oDados->getExpCamadaMin() != 0 && $oDados->getExpCamadaMin() != null) || ($oDados->getExpCamadaMax() != 0 && $oDados->getExpCamadaMax() != null)) {
            if (!$bFoco) {
                echo '$("#' . $aId[15] . '").focus();';
                $bFoco = true;
            }
        } else {
            echo '$("#' . $aId[15] . '").prop("disabled", true);';
            echo '$("#' . $aId[16] . '").prop("disabled", true);';
        }

        //Quando for 
        $oProdMatReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
        $oProdMatReceita->Persistencia->adicionaFiltro('seqmat', $oDados->getSeqmat());
        $oDadosProdMat = $oProdMatReceita->Persistencia->consultarWhere();
        $sTrat = $oDadosProdMat->getTratrevencomp();
        if ($sTrat == "À SECO") {
            echo '$("#' . $aId[17] . '").val("Não Aplicável");';
            echo '$("#' . $aId[17] . '").trigger("change");';
            //echo '$("#' . $aId[17] . '").prop("disabled", true);';
        }
        if (($oDados->getFioDurezaSol() != 0 && $oDados->getFioDurezaSol() != null) || ($oDados->getFioEsferio() != 0 && $oDados->getFioEsferio() != null)) {
            if (!$bFoco) {
                echo '$("#CertFioDurezaSol").focus();';
                $bFoco = true;
            }
        } else {
            echo '$("#CertFioDurezaSol").prop("disabled", true);';
            echo '$("#CertFioEsferio").prop("disabled", true);';
        }
        if (($oDados->getFioDescarbonetaTotal() != 0 && $oDados->getFioDescarbonetaTotal() != null) || ($oDados->getFioDescarbonetaParcial() != 0 && $oDados->getFioDescarbonetaParcial() != null)) {
            if (!$bFoco) {
                echo '$("#CertFioDescarbonetaTotal").focus();';
                $bFoco = true;
            }
        } else {
            echo '$("#CertFioDescarbonetaTotal").prop("disabled", true);';
            echo '$("#CertFioDescarbonetaParcial").prop("disabled", true);';
        }
        if (($oDados->getDiamFinalMin() != 0 && $oDados->getDiamFinalMin() != null) || ($oDados->getDiamFinalMax() != 0 && $oDados->getDiamFinalMax() != null)) {
            if (!$bFoco) {
                echo '$("#CertDiamFinalMin").focus();';
                $bFoco = true;
            }
        } else {
            echo '$("#CertDiamFinalMin").prop("disabled", true);';
            echo '$("#CertDiamFinalMax").prop("disabled", true);';
        }
        //Fim dos Ifs para setar foco no campo que deseja e bloquear os demais que não possuem valores
    }

}
