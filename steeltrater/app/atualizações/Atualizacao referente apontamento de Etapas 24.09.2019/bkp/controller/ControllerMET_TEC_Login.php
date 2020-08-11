<?php

/**
 * Classe responsável pelas operações de controle do objeto
 * Login
 * 
 * @author Avanei Martendal
 * @since 18/09/2015
 */
class ControllerMET_TEC_Login extends Controller {
    /*
     * Método construtor 
     */

    function __construct() {
        $this->View = Fabrica::FabricarView('MET_TEC_Login');
        $this->Model = Fabrica::FabricarModel('MET_TEC_Login');
        $this->Persistencia = Fabrica::FabricarPersistencia('MET_TEC_Login');
        $this->Persistencia->setModel($this->Model);
    }

    /*
     * Método mostra a tela de login
     */

    public function mostraTelaLogin() {
        echo $this->View->getTelaLogin();
    }

    /*
     * Método para chamar o procedimento de login do sistema
     */

    public function logaSistema() {
        $params = array();
        parse_str($_REQUEST['campos'], $params);
        $this->carregaModel();
        $aLogaSistema = $this->Persistencia->logarSistema();
        if ($aLogaSistema[0]) {
            //vai montar a estrutura inicial do sistema 
            $_SESSION["codUser"] = $this->Model->getLogincodigo();
            $_SESSION["loginUser"] = $this->Model->getLogin();
            $_SESSION["nome"] = $this->Model->getLoginnome();
            $_SESSION['sessao'] = session_id();
            $_SESSION['data'] = date('d/m/Y');
            $_SESSION['hora'] = $this->getHoraAtual();
            $_SESSION['usuimagem'] = $this->Model->getUsuimagem();
            $_SESSION['email'] = $this->Model->getUsuemail();
            $_SESSION['repoffice'] = $this->Model->getOfficecod();
            $_SESSION['diroffice'] = $this->Model->getDirrel();
            $_SESSION['nomeBanco'] = Config::NOME_BD;
            $_SESSION['servidor'] = Config::HOST_BD;
            $_SESSION['filcgc'] = $this->Model->getFilcgc();
            $_SESSION['codsetor'] = $this->Model->getCodsetor();

            $_SESSION['officecabsol'] = $this->Model->getOfficecabsol();
            $_SESSION['officecabsoliten'] = $this->Model->getOfficecabsoliten();
            $_SESSION['officecabcot'] = $this->Model->getOfficecabcot();
            $_SESSION['officecabcotiten'] = $this->Model->getOfficecabcotiten();
            $_SESSION['solvenda'] = $this->Model->getOfficesolrel();
            $_SESSION['cotvenda'] = $this->Model->getOfficecotrel();
            $_SESSION['nomedelsoft'] = $this->Model->getUsunomeDelsoft();


            setcookie("loginUser", $_SESSION['loginUser'], time() + 60 * 60 * 24 * 100, "/");
            $oControllerSistema = Fabrica::FabricarController('Sistema');
            $oControllerImagem = Fabrica::FabricarController('MET_TEC_Emplogo');
            $_SESSION['imgLogo'] = $oControllerImagem->retornaLogo($_SESSION["codUser"]);

            if ($aLogaSistema[1] == 'Provisória') {
                //gera tela para redefinir 
                echo $this->View->redfineSenha();
                // $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","ReprovaProj","'.$sDados.'");');
            } else {
                $oControllerSistema->getTelaSistema($_SESSION["codUser"]);
            }
        } else {
            //monta class para registrar login incorreto
            $oLoginErro = Fabrica::FabricarController('MET_TEC_ErroLogin');
            $oLoginErro->geraLoginErro();

            //monta mensagem de erro de login
            $oModalErro = new Modal('Login incorreto!', 'Seu usuário ou senha não estão corretos ou está bloqueado. Entre em contato pelo e-mail metalboti@metalbo.com.br.', Modal::TIPO_ERRO, false, true, true);
            echo $oModalErro->getRender();
            //echo $this->View->erroLogin($aLogaSistema[1]);
        }
    }

    /**
     * Método que captura e retorna o horário atual para que possa ser atrubuído
     * a variável de sessão correspondente
     * 
     */
    public function getHoraAtual() {
        $h = (float) (date('H') * 3600);
        $m = (float) (date('i') * 60);
        $s = (float) (date('s') * 1);
        $horaAtual = ($h + $m + $s);

        return $horaAtual;
    }

    /*     * ******************************** MOBILE *********************************** */

    public function validaMobLogin($usuario, $senha) {

        if (empty($usuario) || empty($senha)) {
            $aDados['LOGIN'] = FALSE;
        } else {
            $aDados = $this->Persistencia->validaMobLogin($usuario, $senha);
        }

        return $aDados;
    }

    public function validaToken($usuCodigo, $usuToken) {
        $oDados = $this->Persistencia->validaToken($usuCodigo, $usuToken);

        if ($oDados['VALIDO']) {
            $aRetorno['VALIDO'] = true;
        } else {
            $aRetorno['VALIDO'] = false;
        }

        return $aRetorno;
    }

    public function atualizaToken($usuCodigo) {
        $Token = $this->Persistencia->atualizaToken($usuCodigo);

        if ($Token['SUCESSO']) {
            $aRetorno['SUCESSO'] = true;
            $aRetorno['TOKEN'] = $Token['TOKEN'];
        } else {
            $aRetorno['SUCESSO'] = false;
        }

        return $aRetorno;
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

