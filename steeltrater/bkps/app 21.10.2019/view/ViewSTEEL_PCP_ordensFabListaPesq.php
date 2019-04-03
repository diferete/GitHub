<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class ViewSTEEL_PCP_ordensFabListaPesq extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        
        
        
       

        $oNr = new CampoConsulta('Nr', 'nr');
        $oPrioridade = new CampoConsulta('Prior.','prioridade');
       
        
        
        $oOp = new CampoConsulta('Op', 'op');
        $oSit = new CampoConsulta ('Sit.', 'situacao');
        $oSit->addComparacao('Espera', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL,CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Liberado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE,CampoConsulta::MODO_COLUNA);
        $oSit->addComparacao('Processo', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO,CampoConsulta::MODO_COLUNA);
        
        $oTempFor = new CampoConsulta('TempForno','tempforno', CampoConsulta::TIPO_DECIMAL);
        $oTempFor->setBOrderBy(true);
        $oProduto = new CampoConsulta('Produto','STEEL_PCP_ordensFab.prod');
        $oProdes = new CampoConsulta('Descrição','STEEL_PCP_ordensFab.prodes');
        
        $oForDes = new CampoConsulta('Forno', 'fornodes');
        $oCliente = new CampoConsulta('Cliente','STEEL_PCP_ordensFab.emp_razaosocial');
      
       
        
       
        
       
        
       
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        
        
        

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setSTituloConsulta($this->addIcone("icon wb-search"). 'PESQUISA PRIORIDADE DE OPS');
        
       // $aInicial[0]='situacao,Liberado';
       // $this->getTela()->setAParametros($aInicial);
        $this->getTela()->setiAltura(1000);
        
        $this->addCampos($oPrioridade,$oOp,$oProduto,$oProdes,$oForDes,$oCliente,$oTempFor,$oSit,$oNr);
    }

  
}