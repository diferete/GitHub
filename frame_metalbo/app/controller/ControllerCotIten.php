<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerCotIten extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('CotIten');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $this->View->setAParametrosExtras($aChave);
    }

    /**
     * Busca informações relevantes no evento sair do campo codigo como 
     * preço, embalagem
     * array de dados
     * 0 - id preço bruto
     * 1 - id vlr unit
     * 2 - caixa master
     * 3 - caixa normal
     * 4 - código produto
     * 5 - campo peso
     *
     */
    public function acaoExitCodigo($sDados) {
        $oVenda = Fabrica::FabricarController('TabVenda');
        $oVenda->buscaPrecoRep($sDados);

        $oEan = Fabrica::FabricarController('Ean');
        $oEan->consultaCaixasRep($sDados);

        $oProduto = Fabrica::FabricarController('Produto');
        $oProduto->retPeso($sDados);

        //define as regras de bloqueio do preço unitário
        $this->regraPrcKg($sDados);
    }

    /**
     * Filtros extras
     */
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam = $this->getParametros();
        //$aparam = $this->View->getAParametrosExtras();
        $this->Persistencia->adicionaFiltro('nr', $aparam[2]);
        $this->Persistencia->setChaveIncremento(false);
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->limpaFiltro();
        $aparam = explode(',', $this->getParametros());
        $this->Persistencia->adicionaFiltro('nr', $aparam[0]);
        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
    }

    public function adicionaFiltroDet2() {
        parent::adicionaFiltroDet2();
        $this->Persistencia->limpaFiltro();
        $aparam = explode(',', $this->getParametros());
        $this->Persistencia->adicionaFiltro('nr', $aparam[0]);
    }

    public function afterCommitDelete() {
        parent::afterCommitDelete();
        $this->Persistencia->limpaFiltro();
        $aparam = $this->getParametros();
        $aparamP = explode('&', $aparam);
        $aparamF = explode('=', $aparamP[0]);
        $this->Persistencia->adicionaFiltro('nr', $aparamF[1]);
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);
        $aParam = explode(',', $sDados);
        // "$('#".$sId."').each (function(){ this.reset();});";
        //verifica se está como 
        $sScript = 'if( $("#' . $aParam[1] . '").is(":checked") ){'
                . '$("#' . $sForm . '").each (function(){ this.reset();});'
                . '$("#' . $aParam[1] . '").attr("checked", true);'
                . '$("#' . $aParam[2] . '").val("' . $this->Model->getObsprod() . '");'
                . '}else{'
                . '$("#' . $sForm . '").each (function(){ this.reset();});'
                . '$("#' . $aParam[1] . '").attr("checked", false);'
                . '}; $("#' . $aParam[3] . '").val("' . $this->Model->getDesconto() . '");';


        echo $sScript;
    }

    /**
     * Define as regra de bloqueio de preço
     */
    public function regraPrcKg($sDados) {
        $aDados = explode(',', $sDados);
        $oProduto = Fabrica::FabricarController('Produto');
        $oTabVenda = Fabrica::FabricarController('TabVenda');
        $oLibVenda = Fabrica::FabricarController('AutPrecoItem');
        $oLibSolCot = Fabrica::FabricarController('AutSolCot');
        $aRegra = array();
        //regra de desconto
        // 1- retorna regra por desconto
        $aRegra[] = 'Desconto';
        // 2- verifica se é sem tabela preço retorna "Sem tabela"
        $sSemTabela = $oTabVenda->getItemTab($aDados[4]);
        if (!empty($sSemTabela)) {
            $aRegra[] = $sSemTabela;
        }
        //3- verifica se é b7 retorna "EstojoB7"
        $sEstojoB7 = $oProduto->getB7($aDados[4]);
        if (!empty($sEstojoB7)) {
            $aRegra[] = $sEstojoB7;
        }
        //4- valida se é liberado por item pdfaut retorna "Item"
        $sLiberado = $oLibVenda->libePorItem($aDados);
        if (!empty($sLiberado)) {
            $aRegra[] = $sLiberado;
        }
        //5 - valida se a solicitação ou pedido estão liberados retorna "LiberadoSolCot" 
        $sSolCotLib = $oLibSolCot->libeSolCot($aDados);
        if (!empty($sSolCotLib)) {
            $aRegra[] = $sSolCotLib;
        }
        $sRegra = end($aRegra);

        echo '$("#' . $aDados[6] . '").val("' . $sRegra . '");';
    }

    /**
     * Efetua validaçoes necessárias
     */
    public function getVal($sDados) {
        parent::getVal($sDados);
        $aDados = explode(',', $sDados);
        $aparam = explode(',', $this->getParametros());
        //se acao for incluir executa essa validacao
        if ($aDados[4] == 0) {
            //$aparam = $this->View->getAParametrosExtras();
            $this->Persistencia->adicionaFiltro('nr', $aparam[0]);
            $this->Persistencia->adicionaFiltro('codigo', $this->Model->getCodigo());

            $iCont = $this->Persistencia->getCount();
            if ($iCont > 0) {
                $oMensagem = new Mensagem('Item repetido', 'Já existe ' . $iCont . ' produtos iguais nessa solicitação!', Mensagem::TIPO_INFO);
                echo $oMensagem->getRender();
            }
        }
    }

    public function acaoMsgDisp($sDados) {



        if (isset($_REQUEST['parametrosCampos'])) {
            $aParam = $_REQUEST['parametrosCampos'];
            $aChaves = array();
            foreach ($aParam as $key => $value) {
                $aChaves[] = $value;
            }
        }
        $sDados .= ',' . implode(',', $aChaves);


        $oMensagem = new Modal('Marcar como disponível', 'Você deseja marcar esses itens como disponível para entrega?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $this->getNomeClasse() . '","acaoDisp","' . $sDados . '");');
        echo $oMensagem->getRender();
    }

    public function acaoDisp($sDados) {

        $aDados = explode(',', $sDados);
        $idGrid = $aDados[0];
        array_shift($aDados);
        $aRetorno[0] = true;
        $sChave = htmlspecialchars_decode($aDados[0]);
        $this->carregaModelString($sChave);
        $this->Persistencia->adicionafiltro('nr', $this->Model->getNr());
        // $this->Persistencia->adicionafiltro('seq', $this->Model->getSeq());

        foreach ($aDados as $sChaveAtual) {
            $sChave = htmlspecialchars_decode($sChaveAtual);
            $this->carregaModelString($sChave);
            $aRetorno = $this->Persistencia->dispVenda($this->Model->getNr(), $this->Model->getSeq());

            if ($aRetorno[0] == true) {
                $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi apontado como disponível...', Mensagem::TIPO_SUCESSO);
                echo $oMensagemSucesso->getRender();
            } else {
                $oMensagemSucesso = new Mensagem('Erro!', 'Seu registro não foi marcado como disponível...', Mensagem::TIPO_ERROR);
                echo $oMensagemSucesso->getRender();
            }
        }
        $this->getDadosConsulta($idGrid, TRUE, null);
    }

    public function LimparDisp($sDados) {

        if (isset($_REQUEST['parametrosCampos'])) {
            $aParam = $_REQUEST['parametrosCampos'];
            $aChaves = array();
            foreach ($aParam as $key => $value) {
                $aChaves[] = $value;
            }
        }
        $sChave = htmlspecialchars_decode($aChaves[0]);
        $this->carregaModelString($sChave);
        $this->Persistencia->adicionafiltro('nr', $this->Model->getNr());
        //$this->Persistencia->adicionafiltro('seq', $this->Model->getSeq()); 


        foreach ($aChaves as $sChaveAtual) {
            $sChave = htmlspecialchars_decode($sChaveAtual);
            $this->carregaModelString($sChave);
            $aRetorno = $this->Persistencia->limpaDispVenda($this->Model->getNr(), $this->Model->getSeq());

            if ($aRetorno[0] == true) {
                $oMensagemSucesso = new Mensagem('Sucesso!', 'A disponibilidade foi apagada...', Mensagem::TIPO_SUCESSO);
                echo $oMensagemSucesso->getRender();
            } else {
                $oMensagemSucesso = new Mensagem('Erro!', 'Erro ao limpar disponibilidade...', Mensagem::TIPO_ERROR);
                echo $oMensagemSucesso->getRender();
            }
        }
        $this->getDadosConsulta($sDados, TRUE, null);
    }

    /**
         * Método responsável por realizar a soma do valor total
         * @param type $sParametros
         * @return type
         */
        public function calculoPersonalizado($sParametros = null) {
            parent::calculoPersonalizado($sParametros);
            $sNr='';
            if (isset($_REQUEST['metodo'])) {
                if ($_REQUEST['metodo'] == "acaoTelaDetalhe") {
                    if (isset($_REQUEST['parametrosCampos'])) {
                        $aParam = $_REQUEST['parametrosCampos'];
                        $sChave = htmlspecialchars_decode($aParam['parametrosCampos[']);
                        $sNr = explode(',', $sChave)[2];
                    }
                }
                if ($_REQUEST['metodo'] == "acaoDetalheIten") {
                    if (isset($_REQUEST['parametrosCampos'])) {
                        $aParam = $_REQUEST['parametrosCampos'];
                        $sChave = htmlspecialchars_decode($aParam['parametrosCampos[']);
                        $sNr = explode(',', $sChave)[0];
                    }
                }
                if(($_REQUEST['metodo'] == "acaoDisp")||($_REQUEST['metodo'] == "acaoExcluirRegDet")){
                    if (isset($_REQUEST['parametros'])){
                        $aParam = $_REQUEST['parametros'];
                        $sChave = htmlspecialchars_decode($aParam['parametros[']);
                        $aChave = explode(',', $sChave);
                        $sChave1 = explode('=', $aChave[1]);
                        $sNr = explode('&', $sChave1[1])[0];
                    }
                }
                if($_REQUEST['metodo'] == "LimparDisp"){
                    if (isset($_REQUEST['parametrosCampos'])){
                        $aParam = $_REQUEST['parametrosCampos'];
                        $sChave = htmlspecialchars_decode($aParam['parametrosCampos[0']);
                        $aChave = explode('=', $sChave);
                        $sNr = explode('&', $aChave[1])[0];   
                    }
                }
            }else{
                    $aCamposTela = $this->getArrayCampostela();
                    $sNr = $aCamposTela['nr'];
            }            
           
            $this->Persistencia->adicionafiltro('nr',$sNr);
            
            // $sTot .= '<b>' . $oCampoAtual->getSTituloOperacao() . ' ' . '</b>' . number_format($xValor, 2, ',', '.');
            
            $iTotal = number_format($this->Persistencia->getSoma($sParametros), 2, ',', '.');
          
          
            return "Valor Total: R$ ".$iTotal;
        }
}
