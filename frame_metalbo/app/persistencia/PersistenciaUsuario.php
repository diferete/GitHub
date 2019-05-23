<?php

/**
 * Classe responsável pelas operações de persistência do objeto
 * Usuario
 * 
 * @author Fernando Salla
 * @since 04/06/2012 
 */
class PersistenciaUsuario extends Persistencia {

    const USUARIO_ADMINISTRADOR = 1;
    const USUARIO_NORMAL = 2;
    const USUARIO_VENDEDOR = 3;

    public function __construct() {
        parent::__construct();

        $this->setTabela("tbusuario");

        $this->adicionaRelacionamento('usucodigo', 'codigo', true, true, true);
        $this->adicionaRelacionamento('usunome', 'nome');
        $this->adicionaRelacionamento('usulogin', 'login');
        $this->adicionaRelacionamento('ususenha', 'senha', false, true, false, CampoBanco::TIPO_SENHA);
        $this->adicionaRelacionamento('usutipo', 'tipo');
        $this->adicionaRelacionamento('usubloqueado', 'bloqueado');
        $this->adicionaRelacionamento('filcodigo', 'filial');
    }

    /**
     * busca a id da sessao
     */
    public function getIdSessao($usucodigo, $usunome, $sessao) {
        $sSql = "select usuidsessao from tbsessao 
        where usucodigo = '" . $usucodigo . "' 
        and usunome = '" . $usunome . "' 
        and usuidsessao ='" . $sessao . "'";
        $result = $this->getObjetoSql($sSql);

        $row = $result->fetch(PDO::FETCH_OBJ);
        $sSessao = $row->usuidsessao;




        if (isset($sSessao)) {
            //atualiza ultimo acesso
            //date('Y-n-j H:i:s')
            date_default_timezone_set('America/Sao_Paulo');
            $sLast = "update tbsessao set usulastacesso = '" . date('Y-n-j H:i:s') . "' 
            where usucodigo ='" . $usucodigo . "' and usunome = '" . $usunome . "' and usuidsessao = '" . $sSessao . "'";
            $this->executaSql($sLast);
            return $sSessao;
        } else {
            $sDelete = "delete tbsessao 
            where usucodigo = '" . $usucodigo . "' 
            and usunome = '" . $usunome . "'";
            $this->executaSql($sDelete);
            return "No session";
        }
    }

    /**
     * public function deleta sessao no banco
     */
    public function deltaSessaoDb($usucodigo, $usunome, $sessao) {
        $sDelete = "delete tbsessao 
            where usucodigo = '" . $usucodigo . "' ";
        $this->executaSql($sDelete);
    }

    public function getIdSessaoAtual($usucodigo, $usunome) {
        $sSql = "select * from tbsessao 
        where usucodigo = '" . $usucodigo . "' 
        and usunome = '" . $usunome . "'";
        $oObj = $this->consultaSql($sSql);
        $sSessao = $oObj->usuidsessao;

        return $sSessao;
    }

}

?>