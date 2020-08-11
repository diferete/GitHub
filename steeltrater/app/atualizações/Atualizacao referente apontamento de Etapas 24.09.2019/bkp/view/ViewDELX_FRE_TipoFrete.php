<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ViewDELX_FRE_TipoFrete extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.', 'fre_tipofretecodigo');
        $oDes = new CampoConsulta('Descrição', 'fre_tipofretedescricao');
        $oRes = new CampoConsulta('Responsável', 'fre_tipofreteresponsavel');
        $oPag = new CampoConsulta('Pagamento', 'fre_tipofretepagamento');

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oRes, $oDes, $oPag);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Cod.', 'fre_tipofretecodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDes = new Campo('Descrição', 'fre_tipofretedescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oRes = new Campo('Responsável', 'fre_tipofreteresponsavel', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPag = new Campo('Pagamento', 'fre_tipofretepagamento', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $this->addCampos(array($oCod, $oRes, $oDes, $oPag));
    }

}
