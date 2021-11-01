<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerConsultaEstoque extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('ConsultaEstoque');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('grucod', $aCampos['grupo'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['grupo1']);
            $this->Persistencia->adicionaFiltro('subcod', $aCampos['subgrupo'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['subgrupo1']);
            $this->Persistencia->adicionaFiltro('famcod', $aCampos['familia'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['familia1']);
            $this->Persistencia->adicionaFiltro('famsub', $aCampos['subfamilia'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['subfamilia1']);
            if ($aCampos['procod'] !== '') {
                $this->Persistencia->adicionaFiltro('procod', $aCampos['procod']);
            }
            if ($aCampos['filadd'] !== '') {
                $aRepItens = explode(',', $aCampos['filadd']);
                //adiciona where manual 
                $this->Persistencia->setSwhereManual(" and procod in (select codigo from " . $aRepItens[1] . " where " . $aRepItens[0] . ") ");
            }
        } else {

            $aCamposParam = $_REQUEST['parametrosCampos'];
            foreach ($aCamposParam as $key => $value) {
                $aDados = explode('|', $value);
                $aCampos[$aDados[0]] = $aDados[1];
            }
            $this->Persistencia->limpaFiltro();
            $this->Persistencia->adicionaFiltro('grucod', $aCampos['grupo'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['grupo1']);
            $this->Persistencia->adicionaFiltro('subcod', $aCampos['subgrupo'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['subgrupo1']);
            $this->Persistencia->adicionaFiltro('famcod', $aCampos['familia'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['familia1']);
            $this->Persistencia->adicionaFiltro('famsub', $aCampos['subfamilia'], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aCampos['subfamilia1']);
            //filtro scroll infinito

            if ($_REQUEST['parametrosCampos']) {
                foreach ($_REQUEST['parametrosCampos'] as $sAtual) {
                    $aFiltros[] = explode(',', $sAtual);
                }
                $sProcod = $aFiltros[13][0];
                $aProcod = explode('=', $sProcod);
                $this->Persistencia->adicionaFiltro('procod', $aProcod[1], Persistencia::LIGACAO_AND, $this->tipoFiltro('scroll'));
            }
        }
    }

    /**
     * grid
     * código produto
     * id pedidos
     * id saldo
     * id of
     */
    public function geraEstoque($sDados) {

        $aDados = explode(',', $sDados);
        $aProcod = explode('=', $aDados[1]);
        if (isset($aProcod[1])) {
            $sProcod = $aProcod[1];
        } else {
            $sProcod = $aProcod[0];
        }
        //verifica se o código existe
        $oProduto = Fabrica::FabricarPersistencia('Produto');
        $aErros = $oProduto->getProdRep($sProcod);

        //se o código estiver na lista carrega o estoque
        if ($aErros[0]) {

            //gera o estoque

            $aEstoque = $this->Persistencia->carregaEstoque($sProcod);

            foreach ($aEstoque as $key => $value) {
                $sActive = "";
                $sH1 = "";
                $sH2 = "";
                if ($key == 'Total') {
                    $sActive = 'class="active"';
                    $sH1 = "<h4>";
                    $sH2 = "</h4>";
                };
                $sTable .= '<tr ' . $sActive . '><td>' . $sH1 . $key . $sH2 . '</td><td>' . $sH1 . number_format($value, 2, ',', '.') . $sH2 . '</td></tr>';
            }
            //carrega soma dos pedidos

            $iTotal = $this->Persistencia->carregaSomaPedidos($sProcod);
            echo '$("#' . $aDados[2] . '").val("' . number_format($iTotal, 2, ',', '.') . '");';

            //gera o saldo de pedidos somente com o estoque 57

            $iEstoqueAcabado = 0;
            if (isset($aEstoque['57-ESTOQUE ACABADO'])) {
                $iEstoqueAcabado = $aEstoque['57-ESTOQUE ACABADO'];
            }
            $sTotalEmpenho = $iEstoqueAcabado - $iTotal;
            echo '$("#' . $aDados[3] . '").val("' . number_format($sTotalEmpenho, 2, ',', '.') . '");';

            //carrega ordens de fabricação

            $iOf = $this->Persistencia->carregaOf($sProcod);
            if ($iOf == null) {
                $iOf = 0;
            }
            echo '$("#' . $aDados[4] . '").val("' . number_format($iOf, 2, ',', '.') . '");';



            //carrega estoques

            $sRender = '$("#' . $aDados[0] . ' > tbody > tr").empty();';
            echo $sRender;
            echo '$("#' . $aDados[0] . ' > tbody").append(\'' . $sTable . '\');';

            //carrega as embalagens
            $oEmbalagens = Fabrica::FabricarPersistencia('Ean');
            $aEmbalagem = $oEmbalagens->consultaEan($sProcod);
            foreach ($aEmbalagem as $key => $value) {
                $sTabEmb = '<tr>';
                foreach ($value as $key => $td) {
                    $sTabEmb .= '<td>' . $td . '</td>';
                }
                $sTabEmb .= '</tr>';
                $sEmb .= $sTabEmb;
            }
            echo '$("#' . $aDados[5] . ' > tbody > tr").empty();';
            echo '$("#' . $aDados[5] . ' > tbody").append(\'' . $sEmb . '\');';
        } else {
            //$oMensagem = new Mensagem('Atenção', ''.$aErros[1].'!', Mensagem::TIPO_WARNING);
            //echo $oMensagem->getRender();
            //zera os estoques
            foreach ($aEstoque as $key => $value) {
                $sActive = "";
                $sH1 = "";
                $sH2 = "";
                if ($key == 'Total') {
                    $sActive = 'class="active"';
                    $sH1 = "<h4>";
                    $sH2 = "</h4>";
                };
                $sTable .= '<tr ' . $sActive . '><td>' . $sH1 . $key . $sH2 . '</td><td>' . $sH1 . number_format($value, 2, ',', '.') . $sH2 . '</td></tr>';
            }
            //limpa estoques

            $sRender = '$("#' . $aDados[0] . ' > tbody > tr").empty();';
            echo $sRender;
            echo '$("#' . $aDados[0] . ' > tbody").append(\'' . $sTable . '\');'; // > tbody > tr
            echo '$("#' . $aDados[2] . '").val("0");';
            echo '$("#' . $aDados[3] . '").val("0");';
            echo '$("#' . $aDados[4] . '").val("0");';
            //limpa embalagem
            echo '$("#' . $aDados[5] . ' > tbody > tr").empty();';
        }
    }

}
