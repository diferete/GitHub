<?php

/*
 * Classe que gerencia a busca de representantes por estado
 * @author: Alexandre
 * @since: 19/01/2018
 * 
 */

class PersistenciaBuscaRepSite extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbrepsite');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('codigo', 'codigo', true, true, true);
        $this->adicionaRelacionamento('estado', 'estado');
        $this->adicionaRelacionamento('pais', 'pais');
        $this->adicionaRelacionamento('ufrep','ufrep');
        $this->adicionaRelacionamento('logo', 'logo');
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('endereco', 'endereco');
        $this->adicionaRelacionamento('bairro', 'bairro');
        $this->adicionaRelacionamento('cidade', 'cidade');
        $this->adicionaRelacionamento('cep', 'cep');
        $this->adicionaRelacionamento('fone1', 'fone1');
        $this->adicionaRelacionamento('fone2', 'fone2');
        $this->adicionaRelacionamento('email1', 'email1');
        $this->adicionaRelacionamento('email2', 'email2');
        $this->adicionaRelacionamento('website', 'website');
    }

    public function getRep($aDados) {
        
        $uf = $_REQUEST['uf'];
        
        $sSql = "select coalesce(estado,'') as estado,coalesce(nome,'') as nome,coalesce(pais,'') as pais,coalesce(ufrep,'')as ufrep,coalesce(endereco,'') as endereco,
                coalesce(bairro,'') as bairro,coalesce(cidade,'') as cidade,coalesce(cep,'') as cep,
                coalesce(fone1,'') as fone1,coalesce(fone2,'') as fone2,coalesce(email1,'') as email1,
                coalesce(email2,'') as email2,coalesce(website,'') as website from tbrepsite where estado = '" . $uf . "'";
        $result = $this->getObjetoSql($sSql);

        $aRetorno = array();
        $aDadosRet = array();
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aDadosRet['estado'] = $oRowBD->estado;
            $aDadosRet['nome'] = $oRowBD->nome;
            $aDadosRet['pais'] = $oRowBD->pais;
            $aDadosRet['ufrep'] = $oRowBD->ufrep;
            $aDadosRet['endereco'] = $oRowBD->endereco;
            $aDadosRet['bairro'] = $oRowBD->bairro;
            $aDadosRet['cidade'] = $oRowBD->cidade;
            $aDadosRet['cep'] = $oRowBD->cep;
            $aDadosRet['fone1'] = $oRowBD->fone1;
            $aDadosRet['fone2'] = $oRowBD->fone2;
            $aDadosRet['email1'] = $oRowBD->email1;
            $aDadosRet['email2'] = $oRowBD->email2;
            $aDadosRet['website'] = $oRowBD->website;
            $aRetorno[] = $aDadosRet;
        }
        return $aRetorno;
    }

}
