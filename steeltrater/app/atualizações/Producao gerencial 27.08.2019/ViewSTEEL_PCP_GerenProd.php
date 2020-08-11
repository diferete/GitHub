<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_PCP_GerenProd extends View{
    public function criaConsulta() {
        parent::criaConsulta();
    }
    
    public function criaTela() {
        parent::criaTela();
        
         //desativa botoes
        $this->setBTela(true);
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);
        
        //periodo de abrangencia
          $oField2 = new FieldSet('Período de abrangência dos dados');
        $oDataIni = new Campo('Data inicial','dataini', Campo::TIPO_DATA, 4,4,6,6);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->setIMarginTop(10);
        $oDataFim = new Campo('Data final','datafin', Campo::TIPO_DATA,4,4,6,6);
        $oDataFim->setIMarginTop(10);
        $oDataFim->setSValor(Util::getUltimoDiaMes());
        
        $oBtnPesqOp = new Campo('Atualizar dados','btnPesq', Campo::TIPO_BOTAOSMALL);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $oBtnPesqOp->getOBotao()->setIMarginTop(10);
        
        
        $oField2->addCampos(array($oDataIni,$oDataFim,$oBtnPesqOp));
        
        $oLinha = new campo('','linha', Campo::TIPO_LINHA,12,12,12,12);
        
        //-------------------PRODUÇÃO DIÁRIO----------------------------------------
         $oGridProdDiario = new Campo('Produção diária','prodDir', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridProdDiario->setSTituloGridPainel('Produção diário');
         $oGridProdDiario->setSCorTituloGridPainel(Campo::TITULO_SUCCESS);
         $oGridProdDiario->addCabGridView('Movimento');
         $oGridProdDiario->addCabGridView('Valor');
         $oGridProdDiario->addLinhasGridView(1,'Produção total');
         $oGridProdDiario->addLinhasGridView(1, '0 Kg');
         $oGridProdDiario->addLinhasGridView(2,'Padrão tempera');
         $oGridProdDiario->addLinhasGridView(2, '0 Kg');
         $oGridProdDiario->addLinhasGridView(3,'Fio Máquina Industrialização');
         $oGridProdDiario->addLinhasGridView(3, '0 Kg');
         
        //------------------PRODUÇÃO MENSAL-------------------------------------------
          
         $oGridProdMensal = new Campo('Produção mensal','prodMensal', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridProdMensal->setSTituloGridPainel('Produção mensal');
         $oGridProdMensal->setSCorTituloGridPainel(Campo::TITULO_DANGER);
         $oGridProdMensal->addCabGridView('Movimento');
         $oGridProdMensal->addCabGridView('Valor');
         $oGridProdMensal->addLinhasGridView(1,'Produção total');
         $oGridProdMensal->addLinhasGridView(1, '0 Kg');
         $oGridProdMensal->addLinhasGridView(2,'Padrão tempera');
         $oGridProdMensal->addLinhasGridView(2, '0 Kg');
         $oGridProdMensal->addLinhasGridView(3,'Fio Máquina Industrialização');
         $oGridProdMensal->addLinhasGridView(3, '0 Kg');
         
         
         //----------------PRODUÇÃO POR FORNO DIÁRIO----------------------------------
         
         $oGridProdFornoDiario = new Campo('Produção por forno diário','prodFornoDiário', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridProdFornoDiario->setSTituloGridPainel('Produção por forno diário');
         $oGridProdFornoDiario->addCabGridView('Fornos');
         $oGridProdFornoDiario->addCabGridView('Valor');
         $oGridProdFornoDiario->addLinhasGridView(1,'Forno 1');
         $oGridProdFornoDiario->addLinhasGridView(1, '0 Kg');
         $oGridProdFornoDiario->addLinhasGridView(2,'Forno 2');
         $oGridProdFornoDiario->addLinhasGridView(2, 'R$ 0');
         
         //---------------PRODUÇÃO POR FORNO MENSAL--------------------------------------
         
         
         $oGridProdFornoMensal = new Campo('Produção por forno mensal','prodFornoMensal', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridProdFornoMensal->setSTituloGridPainel('Produção por forno mensal');
         $oGridProdFornoMensal->addCabGridView('Fornos');
         $oGridProdFornoMensal->addCabGridView('Valor');
         $oGridProdFornoMensal->addLinhasGridView(1,'Forno 1');
         $oGridProdFornoMensal->addLinhasGridView(1, '0 Kg');
         $oGridProdFornoMensal->addLinhasGridView(2,'Forno 2');
         $oGridProdFornoMensal->addLinhasGridView(2, 'R$ 0');
         
         
         
         //eventos iniciais
          $this->getTela()->setSAcaoShow('requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_GerenProd",'
                 . '"carregaDadosGerenProd","' . $oGridProdDiario->getId() . ','
                  . ''.$oGridProdMensal->getId().','.$oGridProdFornoDiario->getId().','.$oGridProdFornoMensal->getId().'");');
         
         //adiciona evento no botao
         $sEventoOp ='requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_GerenProd",'
                 . '"carregaDadosGerenProd","' . $oGridProdDiario->getId() . ','.$oGridProdMensal->getId().','
                 . ''.$oGridProdFornoDiario->getId().','.$oGridProdFornoMensal->getId().'");';
         $oBtnPesqOp->getOBotao()->addAcao($sEventoOp);
         
        
        $this->addCampos($oField2,$oLinha,array($oGridProdDiario,$oGridProdMensal),
                array($oGridProdFornoDiario,$oGridProdFornoMensal));
    }
}