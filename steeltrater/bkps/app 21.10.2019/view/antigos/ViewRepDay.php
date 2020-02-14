<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewRepDay extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setBTela(true);
        
         $oFieldDay = new FieldSet('DIA DE TRABALHO');
         $oGridDayValor = new Campo('Meu Dia','myday', Campo::TIPO_GRIDVIEW,6,6,6,6);
         $oGridDayValor->addCabGridView('Resumo do dia 22/02/2017 em valores');
         $oGridDayValor->addCabGridView('');
         $oGridDayValor->addLinhasGridView(1,'Valor de solicitações liberadas para Metalbo');
         $oGridDayValor->addLinhasGridView(1, '0');
         $oGridDayValor->addLinhasGridView(2,'Valor de cotações emitidas');
         $oGridDayValor->addLinhasGridView(2, '0');
         $oGridDayValor->addLinhasGridView(3,'Valor de solicitações que viraram pedidos');
         $oGridDayValor->addLinhasGridView(3, '0');
         $oGridDayValor->addLinhasGridView(4,'Total de notas emitidas');
         $oGridDayValor->addLinhasGridView(4, '0');
         
         
         $oGridDay = new Campo('Meu Dia','myday', Campo::TIPO_GRIDVIEW,6,6,6,6);
         $oGridDay->addCabGridView('Resumo do dia 22/02/2017 em números');
         $oGridDay->addCabGridView('');
         $oGridDay->addLinhasGridView(1,'Número de solicitações');
         $oGridDay->addLinhasGridView(1, '0');
         $oGridDay->addLinhasGridView(2,'Número de cotações');
         $oGridDay->addLinhasGridView(2, '0');
         $oGridDay->addLinhasGridView(3,'Número de solicitação que viraram pedidos');
         $oGridDay->addLinhasGridView(3, '0');
         $oGridDay->addLinhasGridView(4,'Número de notas fiscais');
         $oGridDay->addLinhasGridView(4, '0');
         
         
         
        
         $oFieldDay->addCampos(array($oGridDayValor,$oGridDay));
         $sMes = date('m');
         $oFieldMes = new FieldSet('MÊS DE TRABALHO');
         $oGridDayVlrMes = new Campo('Meu Dia','myday', Campo::TIPO_GRIDVIEW,6,6,6,6);
         $oGridDayVlrMes->addCabGridView('Resumo do mês '.$sMes.' em valores');
         $oGridDayVlrMes->addCabGridView('');
         $oGridDayVlrMes->addLinhasGridView(1,'Valor de solicitações liberadas para Metalbo no mês');
         $oGridDayVlrMes->addLinhasGridView(1, '0');
         $oGridDayVlrMes->addLinhasGridView(2,'Valor de cotações emitidas');
         $oGridDayVlrMes->addLinhasGridView(2, '0');
         $oGridDayVlrMes->addLinhasGridView(3,'Valor de solicitações que viraram pedidos');
         $oGridDayVlrMes->addLinhasGridView(3, '0');
         $oGridDayVlrMes->addLinhasGridView(4,'Total de notas emitidas');
         $oGridDayVlrMes->addLinhasGridView(4, '0');
         
         
         $oGridCountMes = new Campo('Meu Dia','myday', Campo::TIPO_GRIDVIEW,6,6,6,6);
         $oGridCountMes->addCabGridView('Resumo do mês '.$sMes.' em números');
         $oGridCountMes->addCabGridView('');
         $oGridCountMes->addLinhasGridView(1,'Número de solicitações');
         $oGridCountMes->addLinhasGridView(1, '0');
         $oGridCountMes->addLinhasGridView(2,'Número de cotações');
         $oGridCountMes->addLinhasGridView(2, '0');
         $oGridCountMes->addLinhasGridView(3,'Número de solicitação que viraram pedidos');
         $oGridCountMes->addLinhasGridView(3, '0');
         $oGridCountMes->addLinhasGridView(4,'Número de notas fiscais');
         $oGridCountMes->addLinhasGridView(4, '0');
          
         $oFieldMes->addCampos(array($oGridDayVlrMes,$oGridCountMes));
         
         $this->addCampos($oFieldDay,$oFieldMes);
         
         $this->getTela()->setSAcaoShow('requestAjax("","RepDay","DadosRepDay","'.$oGridDay->getId().','.$oGridDayValor->getId().','.$oGridDayVlrMes->getId().','.$oGridCountMes->getId().'","");');
    }
}