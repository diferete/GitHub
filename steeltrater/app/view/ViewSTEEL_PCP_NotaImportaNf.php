<?php

/* 
 * Classe que implementa a view da importação de notas para produção steel
 * 
 * @author Avanei Martendal 
 * 
 * @since 02/07/2018
 */

class ViewSTEEL_PCP_NotaImportaNf extends View{
    public function criaConsulta() {
        parent::criaConsulta();
        
        //botao para emissão da ordem de fabricacao
        
        $oBotaoConsulta = new CampoConsulta('OF','emitOf', CampoConsulta::TIPO_ACAO);
        $oBotaoConsulta->setSTitleAcao('Emitir Ordem Fabricação!');
        $oBotaoConsulta->addAcao('STEEL_PCP_OrdensFab','acaoMostraTelaIncluir');
        $oBotaoConsulta->setBHideTelaAcao(true);
        
        
        $oNf = new CampoConsulta('Nota Fiscal','nfsnfnro');
        $oOpSteel = new CampoConsulta('OpSteel','opSteel');
        $oSer = new CampoConsulta('Série','nfsnfser');
        $oSeq = new CampoConsulta('Seq.','nfsitseq');
        $oProd = new CampoConsulta('Código','nfsitcod');
        $oDes = new CampoConsulta('Descrição','nfsitdes');
        $oQt = new CampoConsulta('Quant.','nfsitqtd', CampoConsulta::TIPO_DECIMAL);
        $oData = new CampoConsulta('Data','nfsdtemiss', CampoConsulta::TIPO_DATA);
        $oRoeNro = new CampoConsulta('Romaneio','RoeNro');
        $oMetOf = new CampoConsulta('OP Metalbo','metof');
        $oMetMat = new CampoConsulta('Material','metmat');
        $oMetMat->addComparacao('', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_AZUL, CampoConsulta::MODO_COLUNA);
        $oMetMat->setBComparacaoColuna(true);
        
        
        $oOpSteel->addComparacao('0', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA);
        $oOpSteel->setBComparacaoColuna(true);
        
        $this->addCampos($oBotaoConsulta,$oNf,$oOpSteel,$oProd,$oDes,$oQt,$oData,$oMetOf,$oMetMat,$oRoeNro,$oSeq);
        
        $oFiltroNf = new Filtro($oNf, Filtro::CAMPO_TEXTO_IGUAL,2);
        $this->addFiltro($oFiltroNf);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->getTela()->setBUsaKeypress(false);
       // $this->getTela()->setBScrollInf(true);
    }
}