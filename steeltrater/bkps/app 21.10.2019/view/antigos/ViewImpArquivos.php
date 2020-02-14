<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewImpArquivos extends View{
    public function criaTela() {
        parent::criaTela();
        
        $this->setBTela(true);
        
        $oArquivo = new campo('Escolha arquivo','arq1', Campo::TIPO_UPLOAD,2);
        
        $sAcao = 'requestAjax("","ImpArquivos","impXlsPreco","'.$this->getTela()->getid().',xls");';
        $oBtnInserir = new Campo('Atualizar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $oBtnInserir->addAcaoBotao($sAcao);
        
        $sAcao2 = 'requestAjax("","ImpArquivos","insertPreco","'.$this->getTela()->getid().',xls");';
        $oBtnInserir2 = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $oBtnInserir2->addAcaoBotao($sAcao2);
        
        $this->addCampos($oArquivo,$oBtnInserir,$oBtnInserir2);
    }
}