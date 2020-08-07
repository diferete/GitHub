<?php

/* 
 * Implementa classe faturamento diário
 * @author Avanei Martendal
 * @since 20/02/2020
 */

class ViewSTEEL_PCP_GerenFatDiario extends View{
    
    public function criaTela() {
        parent::criaTela();
        //desativa botoes
        $this->setBTela(true);
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);
   //---------------cabeçalho da tela----------------------
         $oField2 = new FieldSet('Período de abrangência dos dados');
        $oDataIni = new Campo('Data inicial','dataini', Campo::TIPO_DATA, 3,3,6,6);
        $oDataIni->setSValor(Util::getPrimeiroDiaMes());
        $oDataIni->setIMarginTop(10);
        $oDataFim = new Campo('Data final','datafin', Campo::TIPO_DATA,3,3,6,6);
        $oDataFim->setIMarginTop(10);
        $dia = date("d");
        if($dia==1){
           $oDataFim->setSValor(Util::getPrimeiroDiaMes()); 
        }else{
           $oDataFim->setSValor(Util::getDataAtual());
        }
        
        
        $oBtnPesqOp = new Campo('Atualizar','btnPesq', Campo::TIPO_BOTAOSMALL,2,2,2,2);
        $oBtnPesqOp->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $oBtnPesqOp->getOBotao()->setIMarginTop(10);
        
        //campos totalizadores
        $oTotGeral = new Campo('Total Geral *Serviço e Insumo', 'totalGeral', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oTotGeral->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTotGeral->setBCampoBloqueado(true);
       
        $oTotServ = new Campo('Total Serviços', 'totalGeralServ', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oTotServ->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTotServ->setBCampoBloqueado(true);
        
        $oTotInsumo = new Campo('Total Insumo', 'totalGeralInsumo', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oTotInsumo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oTotInsumo->setBCampoBloqueado(true);
        
        
        $oField2->addCampos(array($oDataIni,$oDataFim,$oBtnPesqOp));
        
        $oLinha = new campo('','linha', Campo::TIPO_LINHA,12,12,12,12);
        
        //--------------------grid da tabela---------------------------------
         $oGridFatDiario = new Campo('Fat. Diário','fatDir', Campo::TIPO_GRIDSIMPLE,12,12,12,12);
         $oGridFatDiario->setSTituloGridPainel('Faturamento diário');
         $oGridFatDiario->setSCorTituloGridPainel(Campo::TITULO_SUCCESS);
         $oGridFatDiario->addCabGridView('Data');
         $oGridFatDiario->addCabGridView('Valor total *Serv.Ins');
         $oGridFatDiario->addCabGridView('Fat.Serviço');
         $oGridFatDiario->addCabGridView('Fat.Insumo');
         $oGridFatDiario->addCabGridView('Fat.Serv. PO/PF etc');
         $oGridFatDiario->addCabGridView('Fat.Ins. PO/PF etc');
         $oGridFatDiario->addCabGridView('Fat.Serv. Fio Máq');
         $oGridFatDiario->addCabGridView('Fat.Insumo Fio Máq');
         $oGridFatDiario->addCabGridView('Peso total');
         $oGridFatDiario->addCabGridView('Peso PO/PF etc');
         $oGridFatDiario->addCabGridView('Peso Fio Máq');
         
       /*  $oGridFatDiario->addLinhasGridView(1,'20/02/2020');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 19.887,86');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 16.108,17');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 3.779,69');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 14.779,69');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 3.779,69');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 2.779,69');
         $oGridFatDiario->addLinhasGridView(1, 'R$ 231,78');
         $oGridFatDiario->addLinhasGridView(1, '36.505,00');
         $oGridFatDiario->addLinhasGridView(1, '13.372,00');
         $oGridFatDiario->addLinhasGridView(1, '23.133,00');
         
         $oGridFatDiario->addLinhasGridView(2,'20/02/2020');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 19.887,86');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 16.108,17');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 3.779,69');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 14.779,69');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 3.779,69');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 2.779,69');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 231,78');
         $oGridFatDiario->addLinhasGridView(2, '36.505,00');
         $oGridFatDiario->addLinhasGridView(2, '13.372,00');
         $oGridFatDiario->addLinhasGridView(2, '23.133,00');*/
         
//---------------------------------------------------------------------------------------------
          //adiciona evento no botao
         $sEventoOp ='requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_GerenFatDiario",'
                 . '"carregaDadosGerenFatDiario","' . $oGridFatDiario->getId() . ','.$oTotGeral->getId().','.$oTotServ->getId().','.$oTotInsumo->getId().'");';
         $oBtnPesqOp->getOBotao()->addAcao($sEventoOp);
         
          $this->getTela()->setSAcaoShow('requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_GerenFatDiario",'
                 . '"carregaDadosGerenFatDiario","' . $oGridFatDiario->getId() . ','.$oTotGeral->getId().','.$oTotServ->getId().','.$oTotInsumo->getId().'");');
        
         $this->addCampos($oField2,$oLinha,array($oTotGeral,$oTotServ,$oTotInsumo),$oLinha,$oGridFatDiario);
        
    }
    
    
}

