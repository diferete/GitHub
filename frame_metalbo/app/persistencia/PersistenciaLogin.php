<?php

/**
 * Classe responsável pelas operações de persistência do objeto
 * Login
 * 
 * @author Avanei Martendal
 * @since 18/09/2015
 */
class PersistenciaLogin extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela("tblogin");
        $this->adicionaRelacionamento('logincodigo', 'logincodigo', true, true, true);
        $this->adicionaRelacionamento('login', 'login');
        $this->adicionaRelacionamento('loginsenha', 'loginsenha', false, true, false, CampoBanco::TIPO_SENHA);
        $this->adicionaRelacionamento('loginbloqueado', 'loginbloqueado');
        $this->adicionaRelacionamento('loginnome', 'loginnome');
    }

    public function logarSistema() {
        $sSql = "SELECT usucodigo, COUNT(*) as qtd,usubloqueado,usunome,usuimagem,usuemail,officecod,"
                . "codsetor,usutipo,filcgc,ususalvasenha,usubloqueado,senhaprovisoria,usunomedelsoft "
                . "FROM tbusuario "
                . "WHERE usulogin = '" . $this->Model->getLogin() . "' "
                . "AND ususenha='" . sha1($this->Model->getLoginsenha()) . "' "
                . "group by usunome,usucodigo,usubloqueado,usuimagem,usuemail,codsetor,officecod,"
                . "usutipo,filcgc,ususalvasenha,usubloqueado,senhaprovisoria,usunomedelsoft";

        $result = $this->getObjetoSql($sSql);

        $bReturn = false;
        $row = $result->fetch(PDO::FETCH_OBJ);
        if ($row->qtd > 0) {
            $this->Model->setLogincodigo($row->usucodigo);
            $this->Model->setLoginbloqueado($row->usubloqueado);

            $this->Model->setLoginnome($row->usunome);
            ($row->usuimagem == NULL) ? $this->Model->setUsuimagem('usuario.jpg') : $this->Model->setUsuimagem($row->usuimagem);
            //($row->usuimagemperfil==NULL)?$this->Model->setUsuimagemPerfil('usuario.jpg'):$this->Model->setUsuimagemPerfil($row->usuimagemperfil);
            $this->Model->setUsuemail($row->usuemail);
            $this->Model->setOfficecod($row->officecod);
            $this->Model->setUsutipo($row->usutipo);
            $this->Model->setFilcgc($row->filcgc);
            $this->Model->setUsusalvasenha($row->ususalvasenha);
            $this->Model->setUsubloqueado($row->usubloqueado);
            $this->Model->setSenhaProvisoria($row->senhaprovisoria);
            $this->Model->setUsunomeDelsoft($row->usunomedelsoft);
            $this->Model->setCodsetor($row->codsetor);
            //insere registro de login
            $this->registraLogin();
            //se campo salva senha está como ok vai criar um cookie com a senha 

            $aRetorno[0] = true;
            $aRetorno[1] = '';


            //busca diretório de relatórios e cotaçoes
            $sCodOffice = $this->Model->getOfficecod();
            if ($sCodOffice != null) {
                $sSql = 'select officedir,officecabsol,officecabsoliten,'
                        . 'officecabcot,officecabcotiten,officedes,officesolrel,officecotrel '
                        . 'from tbrepoffice where officecod =' . $this->Model->getOfficecod();
                $result = $this->getObjetoSql($sSql);
                $row = $result->fetch(PDO::FETCH_OBJ);

                $this->Model->setDirrel($row->officedir);
                $this->Model->setOfficecabsol($row->officecabsol);
                $this->Model->setOfficecabsoliten($row->officecabsoliten);
                $this->Model->setOfficecabcot($row->officecabcot);
                $this->Model->setOfficecabcotiten($row->officecabcotiten);
                $this->Model->setOfficedes($row->officedes);
                $this->Model->setOfficesolrel($row->officesolrel);
                $this->Model->setOfficecotrel($row->officecotrel);
            }

            //busca os representantes do usuário caso ele for do usutipo
            $sUsutipo = $this->Model->getUsutipo();
            if ($sUsutipo == '1' || $sUsutipo == '2') {
                $sSql = "select * from tbrepcodoffice where filcgc = '75483040000211' and officecod =" . $this->Model->getOfficecod();
                $result = $this->getObjetoSql($sSql);

                $sRep = "";
                while ($rowDb = $result->fetch(PDO::FETCH_OBJ)) {
                    $sRep .= "'" . $rowDb->repcod . "',";
                }

                $sRep = substr($sRep, 0, -1);
                $this->Model->setRepcods($sRep);
            }
            $_SESSION['repsoffice'] = $this->Model->getRepcods();
            $_SESSION['grupoprod'] = '12,13';
            $_SESSION['repofficedes'] = $this->Model->getOfficedes();

            //se o campo para salvar a senha está marcado como true cria um cookie com a senha para ser recuperado, se nao deleta o cookie
            if ($this->Model->getUsusalvasenha() == true) {
                setcookie('pass', '' . $this->Model->getLoginsenha() . '');
            } else {
                setcookie('pass');
            }


            //verifica se a senha é provisória
            $bProvPass = $this->Model->getSenhaProvisoria();
            if ($bProvPass === 'true') {
                $aRetorno[0] = TRUE;
                $aRetorno[1] = 'Provisória';
            }

            //verifica se o usuário é bloqueado
            $bBloq = $this->Model->getUsubloqueado();
            if ($bBloq == 'TRUE') {
                $aRetorno[0] = false;
                $aRetorno[1] = 'Seu usuário foi bloqueado! Contate o TI da Metalbo para o desbloqueio.';
            }
        } else {
            $bRetorno = $this->gerenciaBloqUser();
            if (!$bRetorno) {
                $aRetorno[0] = false;
                $aRetorno[1] = 'Usuário ou senha incorretos!';
            } else {
                $aRetorno[0] = false;
                $aRetorno[1] = 'Seu usuário foi bloqueado por tentativas de LOGIN incorretas! Contate o TI da Metalbo para o desbloqueio.';
            }
        }
        return $aRetorno;
    }

    public function validaLogin() {
        $sSql = "SELECT usucodigo,
                        COUNT(*) as qtd,
                        usubloqueado,
                        usunome, usuimagem
                FROM tbusuario
                WHERE usulogin = '" . $this->Model->getLogin() . "' 
                AND ususenha='" . sha1($this->Model->getLoginsenha()) . "' 
                group by usunome, usucodigo, usubloqueado, usuimagem";

        $result = $this->getObjetoSql($sSql);

        $Retorno = false;
        $row = $result->fetch(PDO::FETCH_OBJ);
        if ($row->qtd > 0) {
            $Retorno = true;
        }
    }

    /**
     * Método que validará login, e retornará dados essenciais para aplicação
     * 
     * @param type $login
     * @param type $senha
     * @return type
     */
    public function validaMobLogin($login, $senha) {

        $sSql = "SELECT COUNT(*) as qtd, usucodigo, tbusuario.codsetor, descsetor, usubloqueado, usunome, ususobrenome, usufone, usuimagem, usulogin "
                . "FROM tbusuario left outer join MetCad_Setores on  MetCad_Setores.codsetor = tbusuario.codsetor "
                . "WHERE usulogin = '" . $login . "' and ususenha = '" . sha1($senha) . "' and usubloqueado = 'FALSE' "
                . "group by usunome, ususobrenome, usufone, usucodigo, usubloqueado, usuimagem,  tbusuario.codsetor, descsetor, usulogin;";


        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);

        if ($row->qtd > 0) {
            $Retorno['LOGIN'] = true;
            $Retorno['DADOS'] = $row;
        } else {
            $Retorno['LOGIN'] = false; // Retorna se true ou false
            $Retorno['SUCESSO'] = true;
        }

        return $Retorno;
    }

    /**
     * Método responsável por verificar token do usuário
     * @param type $usuCodigo
     * @param type $usuToken
     * @return boolean
     */
    public function validaToken($usuCodigo, $usuToken) {
        $sql = "select count(*) as qtd, usutoken from tbusuario where usucodigo = " . $usuCodigo . " and usutoken = '" . $usuToken . "' group by usutoken";

        $result = $this->getObjetoSql($sql);
        $row = $result->fetch(PDO::FETCH_OBJ);

        if ($row->qtd > 0) {
            $Retorno['VALIDO'] = true;
        } else {
            $Retorno['VALIDO'] = false;
        }

        return $Retorno;
    }

    /**
     * Método responsável por atualizar token do usuário ao fazer login
     * 
     * @param int $codigo
     * @return boolean
     */
    public function atualizaToken($codigo) {
        $token = Base::geraToken(25);
        $sql = "update tbusuario set usutoken = '" . $token . "' where usucodigo = " . $codigo;
        $retorno = $this->executaSql($sql);

        if ($retorno[0]) {
            $aRetorno = array('SUCESSO' => TRUE,
                'TOKEN' => $token
            );
        } else {
            $aRetorno = array('SUCESSO' => FALSE,
                'TOKEN' => NULL
            );
        }

        return $aRetorno;
    }

    /**
     * Método para inserir os dados da conexão
     */
    public function registraLogin() {
        $sDelete = "delete tbsessao 
            where usucodigo = '" . $this->Model->getLogincodigo() . "'";
        $this->executaSql($sDelete);
        date_default_timezone_set('America/Sao_Paulo');
        $sSql = "insert into tbsessao(usucodigo,usunome,usuidsessao,usustatus,usudata,usuhora,usulastacesso,usutipo)
      values(" . $this->Model->getLogincodigo() . ",'" . $this->Model->getLoginnome() . "',"
                . "'" . session_id() . "',"
                . "'Ativo',"
                . "'" . date('d/m/Y') . "',"
                . "'" . date('Y-n-j H:i:s') . "',"
                . "'" . date('Y-n-j H:i:s') . "',"
                . "'" . $this->Model->getUsutipo() . "');";
        $aRetorno = $this->executaSql($sSql);
    }

    public function buscaDadosUser($sDados) {
        $sSql = 'select descsetor from MetCad_Setores where codsetor = ' . $sDados;

        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno;
    }

    /*

     * Verifica e altera campo tag_bloq 
     * Conforme quantidade de tentativas erradas de login, podendo bloquear o usuário caso ultrapasse 3 erros
     */
    public function gerenciaBloqUser() {
        $sSqlSelect = "select * from tbusuario "
                . "WHERE usulogin = '" . $this->Model->getLogin() . "'";
        $oObjUser = $this->consultaSql($sSqlSelect);
        if ($oObjUser->tag_bloq < 3) {
            $sSqlUpdt = "update tbusuario set tag_bloq = (select tag_bloq from tbusuario where usucodigo = " . $oObjUser->usucodigo . ") +1 where usucodigo = " . $oObjUser->usucodigo . "";
            $bBloq = false;
        } else {
            $sSqlUpdt = "update tbusuario set usubloqueado = 'TRUE' where usucodigo = " . $oObjUser->usucodigo . "";
            $bBloq = true;
        }
        $this->executaSql($sSqlUpdt);
        return $bBloq;
    }

    /*
     * Reseta o campo tag_block para o valor 0
     * Resetando a quantidade de possibilidades de senha errada para 3
     */
    public function limpaTag_Bloq() {
        $sSqlSelect = "select * from tbusuario "
                . "WHERE usulogin = '" . $this->Model->getLogin() . "'";
        $oObjUser = $this->consultaSql($sSqlSelect);
        $sSqlUpdt = "update tbusuario set tag_bloq = 0 where usucodigo = " . $oObjUser->usucodigo . "";
        $this->executaSql($sSqlUpdt);
    }

}
