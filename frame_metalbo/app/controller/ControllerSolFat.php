<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSolFat extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('SolFat');
        $this->setControllerDetalhe('SolFatItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }

    /**
     * adiciona filtros extras
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->Persistencia->adicionaFiltro('empcnpj', $this->Model->getEmpcnpj());
        $this->Persistencia->adicionaFiltro('pescnpj', $this->Model->getPessoa()->getPescnpj()); //getEmpcnpj()
        $this->Persistencia->adicionaFiltro('fatsol', $this->Model->getFatsol());
    }

    /**
     * monta os campos para a próxima etapa
     */
    function montaProxEtapa() {
        parent::montaProxEtapa();
        $aRetorno[0] = $this->Model->getEmpcnpj();
        $aRetorno[1] = $this->Model->getFatsol();
        $aRetorno[2] = $this->Model->getPessoa()->getPescnpj();

        return $aRetorno;
    }

    public function mudaSitFinan($sChave) {
        $oPers = Fabrica::FabricarPersistencia('SolFat');
        $aRetorno = $oPers->mudaSitFinan($sChave);
    }

    /*
     * Retorna solicitação
     */

    public function retornaSolicitação($sChave) {
        $aDados = explode(',', $sChave);
        $sDados = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sDados, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aErros = array();
        //verifica se tem financeiro 
        $oModelSolFat = Fabrica::FabricarModel('SolFat');
        $oPersSolFat = Fabrica::FabricarPersistencia('SolFat');
        $oPersSolFat->setModel($oModelSolFat);
        $oPersSolFat->adicionaFiltro('empcnpj', $aCamposChave['empcnpj']);
        $oPersSolFat->adicionaFiltro('fatsol', $aCamposChave['fatsol']);
        $oPersSolFat->adicionaFiltro('pescnpj', $aCamposChave['Pessoa_pescnpj']);
        $oPersSolFat->adicionaFiltro('fatfinan', 'Com financeiro');
        $iTotalFinan = $oPersSolFat->getCount();

        $aErros[0] = true;
        if ($iTotalFinan > 0) {
            $aErros[0] = false;
            $aErros[1] = '1-Solicitação está com financeiro atrelado. ';
        }

        //verificar se tem fatura
        $oPersSolFat->limpaFiltro();
        $oPersSolFat->adicionaFiltro('empcnpj', $aCamposChave['empcnpj']);
        $oPersSolFat->adicionaFiltro('fatsol', $aCamposChave['fatsol']);
        $oPersSolFat->adicionaFiltro('pescnpj', $aCamposChave['Pessoa_pescnpj']);
        $oPersSolFat->adicionaFiltro('fatsit', 'Faturada');
        $iTotalFat = $oPersSolFat->getCount();

        if ($iTotalFat > 0) {
            $aErros[0] = false;
            $aErros[1] .= '2-Solicitação está com nota fiscal atrelada. ';
        }
        //excluit ítems da tabela se não há erros
        if ($aErros[0]) {

            //muda a situação da ordem de serviço ou cotação
            $oPersSolFat->limpaFiltro();
            $oPersSolFat->adicionaFiltro('empcnpj', $aCamposChave['empcnpj']);
            $oPersSolFat->adicionaFiltro('fatsol', $aCamposChave['fatsol']);
            $oPersSolFat->adicionaFiltro('pescnpj', $aCamposChave['Pessoa_pescnpj']);
            $oDados = $oPersSolFat->consultarWhere();




            $oModelSoFatIten = Fabrica::FabricarModel('SolFatItem');
            $oPersSolFatIten = Fabrica::FabricarPersistencia('SolFatItem');
            $oPersSolFatIten->setModel($oModelSoFatIten);
            $oPersSolFatIten->adicionaFiltro('empcnpj', $aCamposChave['empcnpj']);
            $oPersSolFatIten->adicionaFiltro('fatsol', $aCamposChave['fatsol']);
            $oPersSolFat->adicionaFiltro('pescnpj', $aCamposChave['Pessoa_pescnpj']);

            $oPersSolFatIten->excluir();

            //excliu o cabeçalho

            $oPersSolFat->limpafiltro();
            $oPersSolFat->adicionaFiltro('empcnpj', $aCamposChave['empcnpj']);
            $oPersSolFat->adicionaFiltro('fatsol', $aCamposChave['fatsol']);
            $oPersSolFat->adicionaFiltro('pescnpj', $aCamposChave['Pessoa_pescnpj']);
            $oPersSolFat->excluir();

            //altera situação od
            $oPersOd = Fabrica::FabricarPersistencia('Od');
            $oPersOd->retsit($oDados->getFatod(), $aCamposChave['empcnpj']);

            //Atualiza o Grid
            //$this->getDadosConsulta($aDados[1],false,null);
            $oMensagemErro = new Modal('Sucesso', 'Solicitação ' . $aCamposChave['fatsol'] . ' retornada com sucesso!', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagemErro->getRender();
            echo"$('#" . $aDados[1] . "-pesq').click();";
        } else {
            $oMensagemErro = new Modal('Antenção', $aErros[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagemErro->getRender();
        }






        /*
          $oMensagem = new Modal('Deletar', 'Você tem certeza que deseja deletar este item?', Modal::TIPO_ERRO, true, true, true);
          $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","acaoExcluirRegistro","'.$sDados.'");');
          //$oMensagem->setSBtnCancelarFunction('alert("Cancelouuu")');
          echo $oMensagem->getRender(); */
        /**
         * 
         */
    }

    public function beforeInsert() {
        parent::beforeInsert();
        $this->Persistencia->setChaveIncremento(false);
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
