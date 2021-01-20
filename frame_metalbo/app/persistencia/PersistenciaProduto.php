<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaProduto extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.prod01');

        $this->adicionaRelacionamento('procod', 'procod', true);
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('probloqpro', 'probloqpro');
        $this->adicionaRelacionamento('grucod', 'GrupoProd.grucod');
        $this->adicionaRelacionamento('subcod', 'SubGrupoProd.subcod');
        $this->adicionaRelacionamento('famcod', 'FamProd.famcod');
        $this->adicionaRelacionamento('famsub', 'FamSub.famsub');
        $this->adicionaRelacionamento('pround', 'pround');
        $this->adicionaRelacionamento('propesprat', 'propesprat'); //peso
        $this->adicionaRelacionamento('proclasfis', 'proclasfis');
        $this->adicionaRelacionamento('procest', 'procest');

        $this->adicionaOrderBy('procod');
        $this->setSTop('35');
        $this->adicionaJoin('GrupoProd');
        $this->adicionaJoin('SubGrupoProd', null, 1, 'subcod', 'subcod');
        $sEndFam = 'and widl.prod01.grucod = FamProd.grucod
        and widl.prod01.subcod = FamProd.subcod
        and widl.prod01.famcod = FamProd.famcod';
        $this->adicionaJoin('FamProd', null, 1, 'famcod', 'famcod', $sEndFam);
        $sEndSub = 'and widl.prod01.grucod = FamSub.grucod
        and widl.prod01.subcod = FamSub.subcod
        and widl.prod01.famcod = FamSub.famcod and widl.prod01.famsub = FamSub.famsub';
        $this->adicionaJoin('FamSub', null, 1, 'famsub', 'famsub', $sEndSub);

        $this->adicionaFiltro('probloqpro', 'S', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);

        if (isset($_SESSION['grupoprod'])) {
            $aGrupo = explode(',', $_SESSION['grupoprod']);

            $this->adicionaFiltro('grucod', $aGrupo[0], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aGrupo[1]);
        }
        
        $this->setBNoLock(true);
    }

    /**
     * Método que retorna o peso do banco de dados
     */
    public function consultaPeso($sProcod) {
        $sSql = "select propesprat from widl.prod01 where procod =" . $sProcod;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        //number_format($row->normalct,0,',','.');
        return number_format($row->propesprat, 3, ',', '.');
    }

    /**
     * Retorna se o item é b7
     */
    public function getB7($sProcod) {

        $sSql = 'select COUNT(*) as b7 from widl.prod01 where procod =' . $sProcod . ' and subcod = 710';
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        if ($row->b7 > 0) {
            $sB7 = 'EstojoB7';
            return $sB7;
        } else {
            $sB7 = '';
            //não faz retorno
        }
    }

    /**
     * Verifica se existe produto acabado representante
     * 
     */
    public function getProdRep($sProcod) {
        $sSql = 'select count(*)as total from widl.prod01(nolock) where procod = ' . $sProcod . ' and grucod between 12 and 13 ';
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $iRetorno = $row->total;
        if ($iRetorno == 0) {
            $aErro[0] = false;
            $aErro[1] = 'Não permitido acesso a este produto';
        } else {
            //verifica se está bloqueado
            $sSql = "select procod,probloqpro from widl.prod01 where procod =" . $sProcod;
            $result = $this->getObjetoSql($sSql);
            $row = $result->fetch(PDO::FETCH_OBJ);
            if ($row->probloqpro == 'S') {
                $aErro[0] = false;
                $aErro[1] = 'Produto bloqueado!';
            } else {
                $aErro[0] = true;
            }
        }

        return $aErro;
    }

}
