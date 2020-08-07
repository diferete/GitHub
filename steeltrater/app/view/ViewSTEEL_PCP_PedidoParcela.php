<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 30/01/2019
 */

class ViewSTEEL_PCP_PedidoParcela extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPedFil = new CampoConsulta('pdv_pedidofilial', 'pdv_pedidofilial');


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);


        $this->setBScrollInf(false);
        $this->addCampos($oPedFil);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
