<?php

/* 
 * Gerencia a view da classe para gerenciar o faturamento
 * 
 * @author Avanei Martendal
 * @since 05/08/2019
 */

class ViewSTEEL_PCP_GerenFat extends View{
    
    public function criaTela() {
        parent::criaTela();
        //desativa botoes
        $this->setBTela(true);
        $this->setBOcultaBotTela(true);
        $this->setBOcultaFechar(true);
        
        //carrega os dados iniciais
        
        
        
        //field do período abrangido
        
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
         
         $oGridFatDiario = new Campo('Fat. Diário','fatDir', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridFatDiario->setSTituloGridPainel('Faturamento diário');
         $oGridFatDiario->setSCorTituloGridPainel(Campo::TITULO_SUCCESS);
         $oGridFatDiario->addCabGridView('Movimento');
         $oGridFatDiario->addCabGridView('Valor');
         $oGridFatDiario->addLinhasGridView(1,'Peso total de retorno de industrialização');
         $oGridFatDiario->addLinhasGridView(1, '0 Kg');
         $oGridFatDiario->addLinhasGridView(2,'Valor total de faturamento');
         $oGridFatDiario->addLinhasGridView(2, 'R$ 0');
         $oGridFatDiario->addLinhasGridView(3,'Valor serviço');
         $oGridFatDiario->addLinhasGridView(3, 'R$ 0');
         $oGridFatDiario->addLinhasGridView(4,'Valor insumo');
         $oGridFatDiario->addLinhasGridView(4, 'R$ 0');
        
        
         $oGridFatPeso = new Campo('Fat. Peso','fatPeso', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridFatPeso->setSTituloGridPainel('Faturamento mensal');
         $oGridFatPeso->setSCorTituloGridPainel(Campo::TITULO_DANGER);
         $oGridFatPeso->addCabGridView('Movimento');
         $oGridFatPeso->addCabGridView('Valor');
         $oGridFatPeso->addLinhasGridView(1,'Peso total de retorno de industrialização');
         $oGridFatPeso->addLinhasGridView(1, '0 Kg');
         $oGridFatPeso->addLinhasGridView(2,'Valor total de faturamento');
         $oGridFatPeso->addLinhasGridView(2, 'R$ 0');
         $oGridFatPeso->addLinhasGridView(3,'Valor serviço');
         $oGridFatPeso->addLinhasGridView(3, 'R$ 0');
         $oGridFatPeso->addLinhasGridView(4,'Valor insumo');
         $oGridFatPeso->addLinhasGridView(4, 'R$ 0');
         
        
        
         $oGridFatPesoAcabado = new Campo('Fat. PesoAcabado','fatPesoAcab', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridFatPesoAcabado->setSTituloGridPainel('Produtos acabados mensal');
         $oGridFatPesoAcabado->addCabGridView('Movimento produtos acabados');
         $oGridFatPesoAcabado->addCabGridView('Valor');
         $oGridFatPesoAcabado->addLinhasGridView(1,'Peso total de retorno de industrialização');
         $oGridFatPesoAcabado->addLinhasGridView(1, '0 Kg');
         $oGridFatPesoAcabado->addLinhasGridView(2,'Valor total de faturamento');
         $oGridFatPesoAcabado->addLinhasGridView(2, 'R$ 0');
         $oGridFatPesoAcabado->addLinhasGridView(3,'Valor serviço');
         $oGridFatPesoAcabado->addLinhasGridView(3, 'R$ 0');
         $oGridFatPesoAcabado->addLinhasGridView(4,'Valor insumo');
         $oGridFatPesoAcabado->addLinhasGridView(4, 'R$ 0');
        
        
         $oGridFatPesoFio = new Campo('Fat. PesoFio','fatPesoFio', Campo::TIPO_GRIDVIEW,6,6,12,12);
         $oGridFatPesoFio->setSTituloGridPainel('Fio máquina mensal');
         $oGridFatPesoFio->addCabGridView('Movimento Fio Máquina');
         $oGridFatPesoFio->addCabGridView('Valor');
         $oGridFatPesoFio->addLinhasGridView(1,'Peso total de retorno de industrialização');
         $oGridFatPesoFio->addLinhasGridView(1, '0 Kg');
         $oGridFatPesoFio->addLinhasGridView(2,'Valor total de faturamento');
         $oGridFatPesoFio->addLinhasGridView(2, 'R$ 0');
         $oGridFatPesoFio->addLinhasGridView(3,'Valor serviço');
         $oGridFatPesoFio->addLinhasGridView(3, 'R$ 0');
         $oGridFatPesoFio->addLinhasGridView(4,'Valor insumo');
         $oGridFatPesoFio->addLinhasGridView(4, 'R$ 0');
         
         
         $this->getTela()->setSAcaoShow('requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_GerenFat",'
                 . '"carregaDadosGerenFat","' . $oGridFatDiario->getId() . ','.$oGridFatPeso->getId().','
                 . ''.$oGridFatPesoFio->getId().','.$oGridFatPesoAcabado->getId().'");');
         
         //adiciona evento no botao
         $sEventoOp ='requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_GerenFat",'
                 . '"carregaDadosGerenFat","' . $oGridFatDiario->getId() . ','.$oGridFatPeso->getId().','
                 . ''.$oGridFatPesoFio->getId().','.$oGridFatPesoAcabado->getId().'");';
         $oBtnPesqOp->getOBotao()->addAcao($sEventoOp);
        
        $this->addCampos($oField2,$oLinha,array($oGridFatDiario,$oGridFatPeso),
                array($oGridFatPesoFio,$oGridFatPesoAcabado));
        
        
        
    }
}
