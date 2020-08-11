<?php

/**
 * Implementa model da classe DELX_PRO_Principioativo
 * 
 * @author Alexandre W de Souza
 * @since 08/10/2018
 * ** */
class ModelDELX_PRO_Principioativo {

    private $pro_principioativoseq;
    private $pro_principioativodescricao;

    function getPro_principioativoseq() {
        return $this->pro_principioativoseq;
    }

    function getPro_principioativodescricao() {
        return $this->pro_principioativodescricao;
    }

    function setPro_principioativoseq($pro_principioativoseq) {
        $this->pro_principioativoseq = $pro_principioativoseq;
    }

    function setPro_principioativodescricao($pro_principioativodescricao) {
        $this->pro_principioativodescricao = $pro_principioativodescricao;
    }

}
