<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 29/11/2018
 */

class ViewSTEEL_PCP_PedidoObs extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPedFil = new CampoConsulta('Pedido Filial', 'pdv_pedidofilial');
        $oCodPed = new CampoConsulta('Codigo Ped.', 'pdv_pedidocodigo');
        $oCodObs = new CampoConsulta('Cod.Obs.', 'pdv_pedidoobscodigo');
        $oObserv = new CampoConsulta('Observação', 'pdv_pedidoobsdescricao');
        $oDescricaofiltro = new Filtro($oObserv, Filtro::CAMPO_TEXTO, 5);
        $oCodigofiltro = new Filtro($oCodPed,Filtro::CAMPO_TEXTO_IGUAL,2);
        $oPedidofiltro = new Filtro($oPedFil, Filtro::CAMPO_TEXTO_IGUAL, 2);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodigofiltro,$oPedidofiltro,$oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oPedFil,$oCodPed,$oCodObs,$oObserv);
    }

    public function criaTela() {
        parent::criaTela();
  
        $oPedFil = new Campo('Pedido Filial', 'pdv_pedidofilial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodPed = new Campo('Codigo Ped.', 'pdv_pedidocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodObs = new Campo('Cod.Obs.', 'pdv_pedidoobscodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodObs->setBCampoBloqueado(true);
        $oObserv = new Campo('Observação', 'pdv_pedidoobsdescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oPedFil,$oCodPed,$oCodObs,$oObserv));
    }

}
