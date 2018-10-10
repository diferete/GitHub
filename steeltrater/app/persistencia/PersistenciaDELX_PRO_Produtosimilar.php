<?php

/*
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class PersistenciaDELX_PRO_Produtosimilar extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRODUTOSIMILAR');

        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo', true, true);
        $this->adicionaRelacionamento('pro_similarcodigo', 'pro_similarcodigo', true, true);
        $this->adicionaRelacionamento('pro_similarobservacao', 'pro_similarobservacao');
        
        $this->setSTop(50);
    }

    public function consultaDados($sDados) {
        $sSql = "select pro_unidademedida,pro_descricao"
                . " from PRO_PRODUTO"
                . " where pro_codigo ='" . $sDados . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

}
