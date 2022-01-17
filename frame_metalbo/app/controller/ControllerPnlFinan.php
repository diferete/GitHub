<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerPnlFinan extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('PnlFinan');
        $this->setControllerDetalhe('SolPedIten');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    /**
     * Método para cria a tela do painel financeiro
     */
    public function criaPainelFinanceiroSol($sDados, $sCampos) {
        $aDados = explode(',', $sDados);
        $aCampos = explode(',', $sCampos);
        $this->pkDetalhe($aCampos);
        $this->parametros = $sCampos;
        if ($aDados[7] != '') {
            $this->View->setSRotina($aDados[7]);
        }

        $this->View->setSIdHideEtapa($aDados[4]);
        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->adicionaBotoesEtapas($aDados[0], $aDados[1], $aDados[2], $aDados[3], $aDados[4], $aDados[5], $this->getControllerDetalhe(), $this->getSMetodoDetalhe(), $aDados[7]);
        $this->View->getTela()->getRender();
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);

        $oModelPessoa = Fabrica::FabricarModel('Pessoa');
        $oPersPessoa = Fabrica::FabricarPersistencia('Pessoa');
        $oPersPessoa->setModel($oModelPessoa);
        $oPersPessoa->adicionaFiltro('empcod', $aChave[0]);
        $oModelPessoa = $oPersPessoa->consultarWhere();

        $aCampos[] = $aChave[0];
        $aCampos[] = $oModelPessoa->getEmpdes();
        $aCampos[] = $aChave[2];

        $this->View->setAParametrosExtras($aCampos);
    }

    public function calculoPersonalizado($sParametros = null, $aParam = null) {
        parent::calculoPersonalizado($sParametros);

        foreach ($aParam as $key => $value) {
            $sEmpcod = $value[0];
            $sCnpj = $value[1];
        }
        $this->Persistencia->adicionaFiltro('empcod', $sCnpj);
        $iTotal = $this->Persistencia->somaTitulos($sCnpj);
        $iAtraso = $this->Persistencia->somaTitAtraso($sCnpj);
        $iMedia = $this->Persistencia->mediaFat($sCnpj);
        $iLimite = $this->Persistencia->limiteCred($sCnpj);

        if ($iLimite > 0) {
            if ($iLimite < $iTotal) {
                $oMensagem = new Modal('Atenção', 'Este cliente está sem limite de crédito!', Modal::TIPO_INFO, false);
                echo $oMensagem->getRender();
            }
        }

        $xResult = '<b>Em aberto:</b> R$ ' . number_format($iTotal, 2, ',', '.') . '    |  '
                . '<span class="cor_vermelho"><b>Atraso:</b> R$ ' . number_format($iAtraso, 2, ',', '.') . '</span>  | '
                . '<span class="cor_verde"><b>Média de Faturamento:</b> R$ ' . number_format($iMedia, 2, ',', '.') . '</span> | ';
        if ($iLimite > 0) {
            $xResult .= '<span><b>Limite de crédito:</b> R$ ' . number_format($iLimite, 2, ',', '.') . '</span>';
        } else {
            $xResult .= '<span><b>SEM LIMITE DE CRÉDITO CADASTRADO!</b></span>';
        }
        return $xResult;
    }

}
