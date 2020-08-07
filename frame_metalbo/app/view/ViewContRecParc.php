<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewContRecParc extends View {

    function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);


        $oEmpCnpj = new CampoConsulta('', 'empcnpj');
        $oPescnpj = new CampoConsulta('Cnpj', 'pescnpj');
        $oRecDoct = new CampoConsulta('Documento', 'recdocto');
        $oRecparc = new CampoConsulta('Parcela', 'recparc');
        $oRecVlr = new CampoConsulta('Valor', 'recparcvlr');
        $oRecVenc = new CampoConsulta('Vencimento', 'recparcvenc');

        $this->addCamposDetalhe($oPescnpj, $oRecDoct, $oRecparc, $oRecVlr, $oRecVenc);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oEmpCnpj = new CampoConsulta('', 'empcnpj');
        $oPescnpj = new CampoConsulta('Código Pessoa', 'Pessoa.pescnpj');
        $oPerazao_nome = new CampoConsulta('Nome', 'Pessoa.pesnome_razao');
        $oRecDoct = new CampoConsulta('Documento', 'recdocto');
        $oRecparc = new CampoConsulta('Parcela', 'recparc');
        $oRecVlr = new CampoConsulta('Valor', 'recparcvlr');
        $oRecVenc = new CampoConsulta('Vencimento', 'recparcvenc');
        $oRecSit = new CampoConsulta('Situação', 'recsit');
        $oRecSit->addComparacao('Em aberto', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA, false, null);
        $oRecSit->setBComparacaoColuna(true);

        $this->addCampos($oPescnpj, $oPerazao_nome, $oRecDoct, $oRecparc, $oRecVlr, $oRecVenc, $oRecSit);
    }

    public function criaTela() {


        parent::criaTela();
        $this->criaGridDetalhe();

        $aValor = $this->getAParametrosExtras();

        $oEmpCnpj = new Campo('', 'empcnpj', Campo::TIPO_TEXTO, 2);
        $oEmpCnpj->setSValor($aValor[0]);
        $oEmpCnpj->setBOculto(true);

        $oDoctVlr = new Campo('Valor Título', 'vlrtit', Campo::TIPO_MONEY, 2);
        $oDoctVlr->setBCampoBloqueado(true);
        $oDoctVlr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oDoctVlr->setApenasTela(true);
        $oDoctVlr->setSValor($aValor[3]);

        $oPescnpj = new Campo('Código Pessoa', 'Pessoa.pescnpj', Campo::TIPO_TEXTO, 2);
        $oPescnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oPescnpj->setSValor($aValor[1]);

        $oRecDoct = new Campo('Documento', 'recdocto', Campo::TIPO_TEXTO, 1);
        $oRecDoct->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecDoct->setSValor($aValor[2]);

        $oRecparc = new Campo('Parcela', 'recparc', Campo::TIPO_TEXTO, 1);
        $oRecparc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecVlr = new Campo('Valor Parc.', 'recparcvlr', Campo::TIPO_TEXTO, 1);
        $oRecVlr->setITamanho(Campo::TAMANHO_PEQUENO);

        $oRecSit = new Campo('Situação', 'recsit', Campo::TIPO_TEXTO, 2);
        $oRecSit->setSValor('Em aberto');
        $oRecSit->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRecSit->setBCampoBloqueado(true);

        $oRecObs = new Campo('Observações', 'recobs', Campo::TIPO_TEXTAREA, 6);

        $oRecVlr->addEvento(Campo::EVENTO_SAIR, 'var unit = $("#' . $oRecVlr->getId() . '").val();'
                . '$("#' . $oRecVlr->getId() . '").val(moedaParaNumero(unit));');


        $oRecVenc = new Campo('Vencimento', 'recparcvenc', Campo::TIPO_DATA, 2);
        $oRecVenc->setITamanho(Campo::TAMANHO_PEQUENO);

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL);
        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oRecparc->getId() . ',' . $sGrid . ',' . $oRecVlr->getId() . '","' . $oEmpCnpj->getSValor() . ',' . $oPescnpj->getSValor() . ',' . $oRecDoct->getSValor() . '");';
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oRecDoct, $oPescnpj, $oDoctVlr, $oRecSit, $oEmpCnpj), array($oRecparc, $oRecVlr), array($oRecVenc, $oRecObs, $oBotConf));

        $this->addCamposFiltroIni($oEmpCnpj, $oPescnpj, $oRecDoct);
    }

    /*
     * Adiciona evento no botão concluir
     */
    /*  public function addeventoConc() {
      parent::addeventoConc();

      $aValor = $this->getAParametrosExtras();

      $sRequest = 'requestAjax("","Solfat","mudaSitFinan","'.$aValor[0].','.$aValor[1].','.$aValor[2].','.$aValor[3].'");';

      return $sRequest;
      } */
}
