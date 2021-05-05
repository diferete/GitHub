<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ControllerDELX_EMP_PessoaContato extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_EMP_PessoaContato');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            if (isset($aCampos['SUP_PedidoFornecedor'])) {
                $this->Persistencia->adicionaFiltro('emp_codigo', $aCampos['SUP_PedidoFornecedor']);
            }
        }
    }

    public function antesValorBuscaPk() {
        parent::antesValorBuscaPk();

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('emp_codigo', $aCampos['SUP_PedidoFornecedor']);
        }
    }

}
